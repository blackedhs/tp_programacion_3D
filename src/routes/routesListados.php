<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\cdApi;
use App\Models\ORM\encuesta;
use App\Models\ORM\log;


include_once __DIR__ . '/../../src/app/modelORM/encuesta.php';
include_once __DIR__ . '/../../src/app/modelORM/log.php';
include_once __DIR__ . '/../../src/middleware.php';

return function (App $app) {
    $container = $app->getContainer();
    $app->group('/listados', function () {
        ///++++++++++++++++++++++log de ingresos++++++++++++++++++++++++++++++++++++++++++////
        $this->get('/ingresos', function ($req, $res, $args) {
            $log = log::all();
            $res->getBody()->write($log);
            return $res;
        });
    })
        ->add(middle::class . ':logGuardar')
        ->add(middle::class . ':autorizadoAdmin')
        ->add(middle::class . ':validarToken');
};
