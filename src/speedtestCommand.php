<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

require('vendor/autoload.php');

class speedtestCommand extends Command
{
    protected static $defaultName = 'app:speedtest';

    protected function configure()
    {
        $this->setDescription('Executes the speedtest command.');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
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
    }
}


//Okla command to create a Json file in the folder
$application = new Application();
$application->add(new speedtestCommand());
$application->run();