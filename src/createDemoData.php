<?php

use Symfony\Component\Console\Command\Command;

require_once 'vendor/autoload.php';
require_once 'bootstrap.php';

class createDemoData extends Command
{
    protected static $defaultName = 'app:speedtest:demo';

    protected function configure()
    {
        $this->setDescription('Executes the speedtest command.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}
