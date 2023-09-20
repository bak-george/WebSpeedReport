<?php

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

return [
    'database' => [
        'host' => $_ENV['DB_HOST'],
        'dbname' => $_ENV['DB_NAME'],
        'port' => $_ENV['DB_PORT'],
        'charset' => 'utf8mb4'
    ],
    'username' => $_ENV['DB_USER'],
    'pass' => $_ENV['DB_PASS']
];
