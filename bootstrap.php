<?php

use Core\Container;
use Core\Database;
use Core\App;

include('vendor/autoload.php');

$container = new Container();

$container->bind('Core\Database', function () {
    $config = require __DIR__ . '/config.php';

    return new Database($config['database'], $config['username'], $config['pass']);
});

App::setContainer($container);