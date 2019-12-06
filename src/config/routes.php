<?php

use App\Controller\FixtureController;
use App\Controller\OrderController;
use App\Controller\ProductsController;

$routes = [
    ['fixtures_load', '/api/fixtures/load', [FixtureController::class, 'load'], ['POST']],
    ['get_all_products', '/api/products', [ProductsController::class, 'all'], ['GET']],
    ['create_order', '/api/order', [OrderController::class, 'create'], ['POST']],
    ['pay_order', '/api/order/pay/{orderId}', [OrderController::class, 'pay'], ['POST']],
];

return $routes;
