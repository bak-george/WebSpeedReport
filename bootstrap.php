<?php

use Core\Bytes;
use Core\Container;
use Core\Database;
use Core\App;

include('vendor/autoload.php');

$container = new Container();

$container->bind('Core\Database', function () {
    $config = require __DIR__ . '/config.php';

    return new Database($config['database'], $config['username'], $config['pass']);
});

$container->bind('Core\Bytes', function () {
    return new bytes();
});

App::setContainer($container);
