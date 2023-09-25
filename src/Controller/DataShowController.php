<?php

namespace App\Controller;

use Core\Bytes;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class  DataShowController extends AbstractController
{
    private $bytes;

    public function __construct()
    {
        $this->bytes = new Bytes();
    }

    #[Route('/data', name: 'data_list')]
    public function view($id, Connection $connection): Response
    {
        $data = $connection->executeQuery("SELECT * FROM results WHERE id = :id", [
            'id' => $id
        ])->fetchAssociative();

        $data['download_bytes'] = round($this->bytes->toMB($data['download_bytes'], 2));
        $data['upload_bytes'] = round($this->bytes->toMB($data['upload_bytes'], 2));
        $this->bytes->setBandwidth($data['download_bandwidth']);
        $data['download_bandwidth'] = round($this->bytes->bandwidthToMBps(), 2);
        $this->bytes->setBandwidth($data['upload_bandwidth']);
        $data['upload_bandwidth'] = round($this->bytes->bandwidthToMBps(), 2);
        $data['ping_latency'] = round($data['ping_latency'], 2);
        ($data['interface_isVpn'] == 1) ? $data['interface_isVpn'] = 'Yes' : $data['interface_isVpn'] = 'No';

        $headers = [];
        foreach ($data as $key => $value) {
            if (!$this->getTableHeaders($key)) {
                $headers[$key] = $key;
            } else {
                $headers[$key] = $this->getTableHeaders($key);
            }
        }

        return $this->render('data/show.html.twig', [
            'heading' => 'Data',
            'data' => $data,
            'headers' => $headers
        ]);
    }

    public function getTableHeaders($kindOfDataKey)
    {
        switch ($kindOfDataKey) {
            case 'download_bytes':
                $header = 'Download Mbps';
                break;

            case 'upload_bytes':
                $header = 'Upload Mbps';
                break;

            case 'download_bandwidth':
                $header = 'Download Bandwidth Mbps';
                break;

            case 'upload_bandwidth':
                $header = 'Upload Bandwidth Mbps';
                break;

            case 'ping_latency':
                $header = 'Ping Latency ms';
                break;

            case 'packetLoss':
                $header = 'Packet Loss %';
                break;

            case 'server_name':
                $header = 'Server Name';
                break;

            case 'server_id':
                $header = 'Server ID';
                break;

            case 'server_location':
                $header = 'Server Location';
                break;

            case 'server_country':
                $header = 'Server Country';
                break;

            case 'server_host':
                $header = 'Server Host';
                break;

            case 'server_port':
                $header = 'Server Port';
                break;

            case 'server_ip':
                $header = 'Server IP';
                break;

            case 'server_sponsor':
                $header = 'Server Sponsor';
                break;

            case 'id':
                $header = 'Internet Speed Number';
                break;

            case 'timestamp':
                $header = 'Timestamp';
                break;

            case 'interface_name':
                $header = 'Interface Name';
                break;

            case 'interface_macAddr':
                $header = 'Interface MAC Address';
                break;

            case 'type':
                $header = 'Type';
                break;

            case 'ping_jitter':
                $header = 'Ping Jitter ms';
                break;

            case 'ping_low':
                $header = 'Ping Lowest ms';
                break;

            case 'ping_high':
                $header = 'Ping Highest ms';
                break;

            case 'download_elapsed':
                $header = 'Download Elapsed';
                break;

            case 'upload_elapsed':
                $header = 'Upload Elapsed';
                break;

            case 'download_latency_iqm':
                $header = 'Download Latency IQM';
                break;

            case 'upload_latency_iqm':
                $header = 'Upload Latency IQM';
                break;

            case 'download_latency_low':
                $header = 'Download Latency Lowest';
                break;

            case 'upload_latency_low':
                $header = 'Upload Latency Lowest';
                break;

            case 'download_latency_high':
                $header = 'Download Latency Highest';
                break;

            case 'upload_latency_high':
                $header = 'Upload Latency Highest';
                break;

            case 'upload_latency_jitter':
                $header = 'Upload Latency Jitter';
                break;

            case 'download_latency_jitter':
                $header = 'Download Latency Jitter';
                break;

            case 'result_url':
                $header = 'Result URL';
                break;

            case 'result_id':
                $header = 'Result ID';
                break;

            default:
                $header = false;
                break;
        }

        return $header;
    }
}