<?php

use Core\App;
use Core\Database;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

require_once 'vendor/autoload.php';
require_once 'bootstrap.php';

class speedtestCommand extends Command
{
    protected static $defaultName = 'app:speedtest';

    protected function configure()
    {
        $this->setName('app:speedtest')
             ->setDescription('Executes the speedtest command and saves the results into your database.')
             ->addArgument('frequency', InputArgument::OPTIONAL, '!Under Development! Frequency to run the script (daily/weekly)')
             ->addArgument('time', InputArgument::OPTIONAL, '!Under Development! Time to run the script (format: H:i)');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $frequency = $input->getArgument('frequency');
        $time = $input->getArgument('time');

        if ($frequency && $time) {
            //until the cron-code is set up
            $output->writeln("<error>Cron job functionality under development.</error>");
            return Command::FAILURE;

            $individualTimes = explode(',', $time);
            $minutes = [];
            $hours = [];

            foreach ($individualTimes as $t) {
                list($h, $m) = explode(':', $t);
                $hours[] = $h;
                $minutes[] = $m;
            }

            $cronLine = implode(',', $minutes) . " " . implode(',', $hours) . " ";

            if ($frequency === 'daily') {
                $cronLine .= "* * * ";
            } elseif ($frequency === 'weekly') {
                $cronLine .= "* * 1 ";
            } else {
                $output->writeln("<error>Invalid frequency. Please use 'daily' or 'weekly'.</error>");
                return Command::FAILURE;
            }

            $logPath    = dirname(__DIR__) . '/logs/webspeedreport.log';

            if (!file_exists($logPath)) {
                $logDir = dirname($logPath);
                if (!is_dir($logDir)) {
                    mkdir($logDir, 0777, true);
                }
                touch($logPath);
            }

            $cronLine .= "cd " . dirname(__DIR__) . " && ./webspeedreport app:speedtest" . " > " . $logPath . " 2>&1";

            $outputFile = "/tmp/cronfile";
            exec("crontab -l > $outputFile");
            file_put_contents($outputFile, $cronLine . PHP_EOL, FILE_APPEND);
            exec("crontab $outputFile");
            unlink($outputFile);

            $output->writeln("Cron job has been added.");
        }

        $progressBar = new ProgressBar($output, 6);
        $progressBar->start();

        $db = App::resolve(Database::class);

        $dataBaseName   = 'web_speed_reports';
        $dataTableName  = 'results';
        $createDatabase = $db->query('CREATE DATABASE IF NOT EXISTS ' . $dataBaseName . ';');

        if ($createDatabase) {
            echo PHP_EOL;
            $output->writeln("<info>Database 'web_speed_reports' created successfully.</info>");
            $progressBar->advance();
        } else {
            $output->writeln("<error>Failed to create database.</error>");
            return Command::FAILURE;
        }

        $useDatabase = $db->query('USE ' . $dataBaseName . ';');

        if ($useDatabase) {
            echo PHP_EOL;
            $output->writeln("Using database 'web_speed_reports'.");
            $progressBar->advance();
        } else {
            $output->writeln("<error>Failed to use database.</error>");
            return Command::FAILURE;
        }

        $sql = "CREATE TABLE IF NOT EXISTS " . $dataTableName . " (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    type VARCHAR(50),
                    timestamp TIMESTAMP,
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
                    interface_isVpn BOOLEAN DEFAULT FALSE,
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

        $createTable = $db->query($sql);

        if ($createTable) {
            echo PHP_EOL;
            $output->writeln("<info>Table 'results' created successfully.</info>");
            $progressBar->advance();
        } else {
            $output->writeln("<error>Failed to create table.</error>");
            return Command::FAILURE;
        }

        $resultDir = __DIR__ . '/speedTestResults';
        if (!is_dir($resultDir)) {
            mkdir($resultDir, 0777, true);
        }

        $date       = date('Y-m-d_H-i-s');
        $filePath   = $resultDir . "/result_{$date}.json";
        $jsonResult = shell_exec('speedtest -f json-pretty 2>&1');

        if ($jsonResult) {
            echo PHP_EOL;
            file_put_contents($filePath, $jsonResult);
            $output->writeln("<info>Saving results saved to: $filePath</info>");
            $progressBar->advance();
        } else {
            $output->writeln("<error>Failed to execute speedtest.</error>");
            return Command::FAILURE;
        }

        $files = glob($resultDir . '/*.json');

        usort($files, [self::class, 'sort_by_created_at']);

        $latestFile = $files[0];

        if ($latestFile) {
            $jsonContent = file_get_contents($latestFile);
            $decodedData = json_decode($jsonContent, true);
            echo PHP_EOL;
            $output->writeln("<info>Decoding Data...</info>");
            $progressBar->advance();
        } else {
            $output->writeln("<error>No results No JSON files found in the directory:</error>" . $resultDir);
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

        $formattedTimestamp = date('Y-m-d H:i:s', strtotime($decodedData['timestamp']));

        $insertSql = $db->query($query, [
                        ':type' => $decodedData['type'],
                        ':timestamp' => $formattedTimestamp,
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
                        ':interface_isVpn' => isset($decodedData['interface']['isVpn']) ? (int) $decodedData['interface']['isVpn'] : 0,
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

        if ($insertSql) {
            echo PHP_EOL;
            $output->writeln("<info>Result saved to database.</info>");
            $progressBar->finish();
            return Command::SUCCESS;
        } else {
            $output->writeln("<error>Failed to save result to database.</error>");
            return Command::FAILURE;
        }
    }

    public static function sort_by_created_at($a, $b)
    {
        if (filectime($a) === filectime($b)) {
            return 0;
        }

        return (filectime($a) > filectime($b)) ? -1 : 1;
    }

}
