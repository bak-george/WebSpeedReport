<?php

use Core\App;
use Core\Database;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

require_once 'vendor/autoload.php';
require_once 'bootstrap.php';

class speedtestCommand extends Command
{
    protected static $defaultName = 'app:speedtest';

    protected function configure()
    {
        $this->setDescription('Executes the speedtest command.');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $db = App::resolve(Database::class);

        $createTable = $db->query('CREATE DATABASE IF NOT EXISTS web_speed_reports;');
        var_dump($createTable);

        $sql = "CREATE TABLE IF NOT EXISTS results (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    type VARCHAR(50),
                    timestamp DATETIME,
                    ping_jitter FLOAT,
                    ping_latency FLOAT,
                    ping_low FLOAT,
                    ping_high FLOAT,
                    download_bandwidth INT,
                    download_bytes BIGINT,
                    download_elapsed INT,
                    download_latency_iqm FLOAT,
                    download_latency_low FLOAT,
                    download_latency_high FLOAT,
                    download_latency_jitter FLOAT,
                    upload_bandwidth INT,
                    upload_bytes BIGINT,
                    upload_elapsed INT,
                    upload_latency_iqm FLOAT,
                    upload_latency_low FLOAT,
                    upload_latency_high FLOAT,
                    upload_latency_jitter FLOAT,
                    packetLoss INT,
                    isp VARCHAR(255),
                    interface_internalIp VARCHAR(255),
                    interface_name VARCHAR(50),
                    interface_macAddr VARCHAR(50),
                    interface_isVpn BOOLEAN,
                    interface_externalIp VARCHAR(255),
                    server_id INT,
                    server_host VARCHAR(255),
                    server_port INT,
                    server_name VARCHAR(255),
                    server_location VARCHAR(255),
                    server_country VARCHAR(255),
                    server_ip VARCHAR(255),
                    result_id VARCHAR(255),
                    result_url VARCHAR(1000),
                    result_persisted BOOLEAN
                );";

        $db->query($sql);

        $resultDir = __DIR__ . '/speedTestResults';
        if (!is_dir($resultDir)) {
            mkdir($resultDir, 0777, true);
        }

        $date = date('Y-m-d_H-i-s');
        $filePath = $resultDir . "/result_{$date}.json";

        $jsonResult = shell_exec('speedtest -f json-pretty');

        if ($jsonResult) {
            file_put_contents($filePath, $jsonResult);
            $output->writeln("Result saved to: $filePath");
            return Command::SUCCESS;
        } else {
            $output->writeln("Failed to execute speedtest.");
            return Command::FAILURE;
        }

        $files = glob($resultDir . '/*.json');

        usort($files, 'sort_by_created_at');

        $latestFile = $files[0];

        if ($latestFile) {
            $jsonContent = file_get_contents($latestFile);
            $decodedData = json_decode($jsonContent, true);
        } else {
            $output->writeln("No results No JSON files found in the directory:" . $resultDir);
            return Command::FAILURE;
        }

        $query = "INSERT INTO results (type, timestamp, ping_jitter, ping_latency, ping_low, ping_high, 
              download_bandwidth, download_bytes, download_elapsed, download_latency_iqm, 
              download_latency_low, download_latency_high, download_latency_jitter, upload_bandwidth, 
              upload_bytes, upload_elapsed, upload_latency_iqm, upload_latency_low, upload_latency_high, 
              upload_latency_jitter, packetLoss, isp, interface_internalIp, interface_name, interface_macAddr, 
              interface_isVpn, interface_externalIp, server_id, server_host, server_port, server_name, 
              server_location, server_country, server_ip, result_id, result_url, result_persisted)
              VALUES (:type, :timestamp, :ping_jitter, :ping_latency, :ping_low, :ping_high, 
              :download_bandwidth, :download_bytes, :download_elapsed, :download_latency_iqm, 
              :download_latency_low, :download_latency_high, :download_latency_jitter, :upload_bandwidth, 
              :upload_bytes, :upload_elapsed, :upload_latency_iqm, :upload_latency_low, :upload_latency_high, 
              :upload_latency_jitter, :packetLoss, :isp, :interface_internalIp, :interface_name, :interface_macAddr, 
              :interface_isVpn, :interface_externalIp, :server_id, :server_host, :server_port, :server_name, 
              :server_location, :server_country, :server_ip, :result_id, :result_url, :result_persisted)";

        $db->query($query, [
            ':type' => $decodedData['type'],
            ':timestamp' => $decodedData['timestamp'],
            ':ping_jitter' => $decodedData['ping']['jitter'],
            ':ping_latency' => $decodedData['ping']['latency'],
            ':ping_low' => $decodedData['ping']['low'],
            ':ping_high' => $decodedData['ping']['high'],
            ':download_bandwidth' => $decodedData['download']['bandwidth'],
            ':download_bytes' => $decodedData['download']['bytes'],
            ':download_elapsed' => $decodedData['download']['elapsed'],
            ':download_latency_iqm' => $decodedData['download']['latency']['iqm'],
            ':download_latency_low' => $decodedData['download']['latency']['low'],
            ':download_latency_high' => $decodedData['download']['latency']['high'],
            ':download_latency_jitter' => $decodedData['download']['latency']['jitter'],
            ':upload_bandwidth' => $decodedData['upload']['bandwidth'],
            ':upload_bytes' => $decodedData['upload']['bytes'],
            ':upload_elapsed' => $decodedData['upload']['elapsed'],
            ':upload_latency_iqm' => $decodedData['upload']['latency']['iqm'],
            ':upload_latency_low' => $decodedData['upload']['latency']['low'],
            ':upload_latency_high' => $decodedData['upload']['latency']['high'],
            ':upload_latency_jitter' => $decodedData['upload']['latency']['jitter'],
            ':packetLoss' => $decodedData['packetLoss'],
            ':isp' => $decodedData['isp'],
            ':interface_internalIp' => $decodedData['interface']['internalIp'],
            ':interface_name' => $decodedData['interface']['name'],
            ':interface_macAddr' => $decodedData['interface']['macAddr'],
            ':interface_isVpn' => $decodedData['interface']['isVpn'],
            ':interface_externalIp' => $decodedData['interface']['externalIp'],
            ':server_id' => $decodedData['server']['id'],
            ':server_host' => $decodedData['server']['host'],
            ':server_port' => $decodedData['server']['port'],
            ':server_name' => $decodedData['server']['name'],
            ':server_location' => $decodedData['server']['location'],
            ':server_country' => $decodedData['server']['country'],
            ':server_ip' => $decodedData['server']['ip'],
            ':result_id' => $decodedData['result']['id'],
            ':result_url' => $decodedData['result']['url'],
            ':result_persisted' => $decodedData['result']['persisted']
        ]);
    }
}


//Okla command to create a Json file in the folder
$application = new Application();
$application->add(new speedtestCommand());
$application->run();