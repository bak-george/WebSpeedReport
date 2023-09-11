<?php

use Core\Container;
use Core\Database;
use Core\App;
const BASE_PATH = __DIR__.'/../';

var_dump(__DIR__);

include('vendor/autoload.php');

$container = new Container();

$container->bind('Core\Database', function () {
    $config = require __DIR__ . '/config.php';

    return new Database($config['database']);
});

App::setContainer($container);