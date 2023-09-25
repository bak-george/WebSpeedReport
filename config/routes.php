<?php

use App\Controller\ChartsController;
use App\Controller\DataShowController;
use App\Controller\HomeController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('home_index', '/')
            ->controller([HomeController::class, 'index']);

    $routes->add('data_list', '/data/{id}')
            ->controller([DataShowController::class, 'view']);

    $routes->add('charts_index', '/charts')
           ->controller([ChartsController::class, 'index']);
};
