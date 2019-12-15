<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\comandaControler;
use App\Models\ORM\cdApi;
use App\Models\ORM\comanda;
use App\Models\ORM\producto;

include_once __DIR__ . '/../../src/app/modelORM/comanda.php';
include_once __DIR__ . '/../../src/app/modelORM/producto.php';
include_once __DIR__ . '/../../src/app/modelORM/comandaControler.php';
include_once __DIR__ . '/../../src/middleware.php';

return function (App $app) {
    $container = $app->getContainer();
    $app->group('/comandas', function () {
        ///++++++++++++++++++++++Alta de Productos++++++++++++++++++++++++++++++++++++++++++////
        $this->post('/alta', function ($req, $res, $args) {
            return comandaControler::CargarUno($req, $res, $args);
        })
            ->add(middle::class . ':logGuardar')
            ->add(middle::class . ':autorizadoMesas')
            ->add(middle::class . ':validarToken');

        ///++++++++++++++++++++++Moficar Productos++++++++++++++++++++++++++++++++++++++++++////
        $this->post('/modificar', function ($req, $res, $args) {
            return comandaControler::ModificarUno($req, $res, $args);
        })
            ->add(middle::class . ':logGuardar')
            ->add(middle::class . ':autorizadoMesas')
            ->add(middle::class . ':validarToken');

        ///++++++++++++++++++++++Mostar de Productos++++++++++++++++++++++++++++++++++++++++++////
        $this->get('/mostrar', function ($req, $res, $args) {
            if ($req->getQueryParams()['codigo'] != null) {
                $newresponse = comandaControler::TraerUno($req, $res, $args);
            } else {
                $newresponse = comandaControler::TraerTodos($req, $res, $args);
            }
            return $newresponse;
        })
            ->add(middle::class . ':logGuardar')
            ->add(middle::class . ':autorizadoMesas')
            ->add(middle::class . ':validarToken');


        ///++++++++++++++++++++++Baja de Productos++++++++++++++++++++++++++++++++++++++++++////
        $this->post('/baja', function ($req, $res, $args) {
            return comandaControler::BorrarUno($req, $res, $args);
        })
            ->add(middle::class . ':logGuardar')
            ->add(middle::class . ':autorizadoMesas')
            ->add(middle::class . ':validarToken');
    });
};
