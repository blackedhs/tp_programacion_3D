<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\cd;
use App\Models\cdApi;



return function (App $app) {
    $container = $app->getContainer();

    // Rutas PDO
    $routes = require __DIR__ . '/../src/routes/routesPDO.php';
    $routes($app);

    // Rutas ORM
    $routes = require __DIR__ . '/../src/routes/routesORM.php';
    $routes($app);

    // Rutas JWT
    $routes = require __DIR__ . '/../src/routes/routesJWT.php';
    $routes($app);

    // Rutas Usuarios
    $routes = require __DIR__ . '/../src/routes/routesUsuarios.php';
    $routes($app);

    // Productos
    $routes = require __DIR__ . '/../src/routes/routesProductos.php';
    $routes($app);

    // Mesas
    $routes = require __DIR__ . '/../src/routes/routesMesas.php';
    $routes($app);

    // Encuestas
    $routes = require __DIR__ . '/../src/routes/routesEncuestas.php';
    $routes($app);

    // Login
    $routes = require __DIR__ . '/../src/routes/routesLogin.php';
    $routes($app);

    // Listados
    $routes = require __DIR__ . '/../src/routes/routesListados.php';
    $routes($app);

    // Comanda
    $routes = require __DIR__ . '/../src/routes/routesComanda.php';
    $routes($app);

    // Pedido
    $routes = require __DIR__ . '/../src/routes/routesPedido.php';
    $routes($app);

    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");
        // $container->get('logger')->addCritical('Hey, a critical log entry!');
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });
};
