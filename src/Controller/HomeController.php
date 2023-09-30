<?php

namespace App\Controller;

use Core\Bytes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;

class HomeController extends AbstractController
{
    private $bytes;

    public function __construct()
    {
        $this->bytes = new Bytes();
    }

    #[Route('/', name: 'home_index')]
    public function index(Connection $connection): Response
    {
        $serverName = $connection->executeQuery("SELECT server_name FROM results GROUP BY server_name ORDER BY COUNT(*) DESC LIMIT 4")->fetchAllAssociative();

        $avgDownload = $connection->executeQuery("SELECT AVG(download_bytes) AS 'avg_download_bytes' FROM results")->fetchAssociative();
        $avgUpload = $connection->executeQuery("SELECT AVG(upload_bytes) AS 'avg_upload_bytes' FROM results")->fetchAssociative();
        $avgPingLatency = $connection->executeQuery("SELECT AVG(ping_latency) AS 'avg_ping_latency' FROM results")->fetchAssociative();
        $avgPacketLoss = $connection->executeQuery("SELECT AVG(packetLoss) AS 'avg_packet_loss' FROM results")->fetchAssociative();

        $averages = [
            round($this->bytes->toMB($avgDownload['avg_download_bytes']), 2),
            round($this->bytes->toMB($avgUpload['avg_upload_bytes']), 2),
            round($avgPingLatency['avg_ping_latency'], 2),
            round($avgPacketLoss['avg_packet_loss'], 2)
        ];

        $maxDownload = $connection->executeQuery("SELECT MAX(download_bytes) AS 'max_download_bytes' FROM results")->fetchAssociative();
        $maxUpload = $connection->executeQuery("SELECT MAX(upload_bytes) AS 'max_upload_bytes' FROM results")->fetchAssociative();
        $maxPingLatency = $connection->executeQuery("SELECT MAX(ping_latency) AS 'max_ping_latency' FROM results")->fetchAssociative();
        $maxPacketLoss = $connection->executeQuery("SELECT MAX(packetLoss) AS 'max_packet_loss' FROM results")->fetchAssociative();

        $maxValues = [
            round($this->bytes->toMB($maxDownload['max_download_bytes']), 2),
            round($this->bytes->toMB($maxUpload['max_upload_bytes']), 2),
            round($maxPingLatency['max_ping_latency'], 2),
            $maxPacketLoss['max_packet_loss']
        ];

        $minDownload = $connection->executeQuery("SELECT MIN(download_bytes) AS 'min_download_bytes' FROM results")->fetchAssociative();
        $minUpload = $connection->executeQuery("SELECT MIN(upload_bytes) AS 'min_upload_bytes' FROM results")->fetchAssociative();
        $minPingLatency = $connection->executeQuery("SELECT MIN(ping_latency) AS 'min_ping_latency' FROM results")->fetchAssociative();
        $minPacketLoss = $connection->executeQuery("SELECT MIN(packetLoss) AS 'min_packet_loss' FROM results")->fetchAssociative();

        $minValues = [
            round($this->bytes->toMB($minDownload['min_download_bytes']), 2),
            round($this->bytes->toMB($minUpload['min_upload_bytes']), 2),
            round($minPingLatency['min_ping_latency'], 2),
            $minPacketLoss['min_packet_loss']
        ];

        $data = $connection->executeQuery("SELECT * FROM results ORDER BY timestamp DESC")->fetchAllAssociative();

        foreach ($data as &$value) {
            $value['download_bytes'] = round($this->bytes->toMB($value['download_bytes']), 2);
            $value['upload_bytes'] = round($this->bytes->toMB($value['upload_bytes']), 2);


            $this->bytes->setBandwidth($value['download_bandwidth']);
            $value['download_bandwidth'] = round($this->bytes->bandwidthToMBps(), 2);

            $this->bytes->setBandwidth($value['upload_bandwidth']);
            $value['upload_bandwidth'] = round($this->bytes->bandwidthToMBps(), 2);
        }

        return $this->render('home/body.html.twig', [
            'data' => $data,
            'averages' => $averages,
            'maxValues' => $maxValues,
            'minValues' => $minValues,
            'serverName' => $serverName
        ]);
    }
}
