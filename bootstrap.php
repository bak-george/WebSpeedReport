<?php

use Core\App;
use Core\Container;
use Core\Database;

$container = new Container();

$container->bind('Core\Database', function () {
    $config = require BASE_PATH . 'config.php';

    $databaseConfig = new Database($config['database']);

    return $databaseConfig;
});

App::setContainer($container);