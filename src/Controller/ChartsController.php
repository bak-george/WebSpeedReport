<?php

namespace App\Controller;

use Core\Bytes;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChartsController extends AbstractController
{
    private $bytes;

    public function __construct()
    {
        $this->bytes = new Bytes();
    }

    #[Route('/charts', name: 'charts_index')]
    public function index(Connection $connection): Response
    {
        $sql = "SELECT timestamp,download_bytes,upload_bytes,
                        download_bandwidth,upload_bandwidth,
                        ping_latency, ping_low, ping_high
                FROM results";
        $chartData = $connection->executeQuery($sql)->fetchAllAssociative();

        foreach ($chartData as $key => $value) {
            $chartData[$key]['download_bytes'] = round($this->bytes->toMB($value['download_bytes'], 2));
            $chartData[$key]['upload_bytes'] = round($this->bytes->toMB($value['upload_bytes'], 2));

            $this->bytes->setBandwidth($value['download_bandwidth']);
            $chartData[$key]['download_bandwidth'] = round($this->bytes->bandwidthToMBps(), 2);

            $this->bytes->setBandwidth($value['upload_bandwidth']);
            $chartData[$key]['upload_bandwidth'] = round($this->bytes->bandwidthToMBps(), 2);
        }

        $sql = "SELECT server_country, COUNT(*) AS number_of_countries
                FROM results
                GROUP BY server_country";
        $countryData = $connection->executeQuery($sql)->fetchAllAssociative();

        $sql = "SELECT isp, COUNT(*) AS number_of_isps
                FROM results
                GROUP BY isp";

        $ispData = $connection->executeQuery($sql)->fetchAllAssociative();

        $sql = "SELECT server_name, COUNT(*) AS number_of_server_names
                FROM results
                GROUP BY server_name";

        $serverNameData = $connection->executeQuery($sql)->fetchAllAssociative();

        return $this->render('charts/body.html.twig', [
            'chartData' => $chartData,
            'countryData' => $countryData,
            'ispData' => $ispData,
            'serverNameData' => $serverNameData
        ]);
    }
}