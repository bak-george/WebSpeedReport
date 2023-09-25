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
        $sql = "SELECT timestamp,download_bytes FROM results";
        $downLoadData = $connection->executeQuery($sql)->fetchAllAssociative();

        return $this->render('charts/body.html.twig', [
            'downLoadData' => $downLoadData,
        ]);
    }
}