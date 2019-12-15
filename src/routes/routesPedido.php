<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\pedidoControler;
use App\Models\ORM\cdApi;
use App\Models\ORM\comanda;
use App\Models\ORM\comandaControler;
use App\Models\ORM\producto;
use App\Models\ORM\pedido;

include_once __DIR__ . '/../../src/app/modelORM/comanda.php';
include_once __DIR__ . '/../../src/app/modelORM/pedido.php';
include_once __DIR__ . '/../../src/app/modelORM/producto.php';
include_once __DIR__ . '/../../src/app/modelORM/pedidoControler.php';
include_once __DIR__ . '/../../src/middleware.php';

return function (App $app) {
    $container = $app->getContainer();
    $app->group('/pedidos', function () {
        // ///++++++++++++++++++++++Alta de Productos++++++++++++++++++++++++++++++++++++++++++////
        // $this->post('/alta', function ($req, $res, $args) {
        //     return pedidoControler::CargarUno($req, $res, $args);
        // })
        //     ->add(middle::class . ':logGuardar')
        //     ->add(middle::class . ':autorizadoMesas')
        //     ->add(middle::class . ':validarToken');

        ///++++++++++++++++++++++preparar Pedidos++++++++++++++++++++++++++++++++++++++++++////
        $this->post('/preparar', function ($req, $res, $args) {
            if ($req->getParsedBody()['id'] != null) {
                $newRes = pedidoControler::PrepararUno($req, $res, $args);
                comandaControler::RevisarComandas();
            } else {
                $newRes = pedidoControler::PrepararTodos($req, $res, $args);
                comandaControler::RevisarComandas();
            }
            return $newRes;
        })
        ->add(middle::class . ':logGuardar')
        ->add(middle::class . ':autorizadoPreparar')
        ->add(middle::class . ':validarToken');
        
        ///++++++++++++++++++++++Terminar Pedidos++++++++++++++++++++++++++++++++++++++++++////
        $this->post('/terminar', function ($req, $res, $args) {
            if ($req->getParsedBody()['id'] != null) {
                $newRes = pedidoControler::TerminarUno($req, $res, $args);
                comandaControler::RevisarComandas();
            } else {
                $newRes = pedidoControler::TerminarTodos($req, $res, $args);
                comandaControler::RevisarComandas();
            }
            return $newRes;
        })
            ->add(middle::class . ':logGuardar')
            ->add(middle::class . ':autorizadoPreparar')
            ->add(middle::class . ':validarToken');

        ///++++++++++++++++++++++Mostar de Productos++++++++++++++++++++++++++++++++++++++++++////
        $this->get('/mostrar', function ($req, $res, $args) {
            if ($req->getQueryParams()['codigo'] != null) {
                $newresponse = pedidoControler::TraerUno($req, $res, $args);
            } else {
                $newresponse = pedidoControler::TraerTodos($req, $res, $args);
            }
            return $newresponse;
        })
            ->add(middle::class . ':logGuardar')
            // ->add(middle::class . ':autorizadoPedidos')
            ->add(middle::class . ':validarToken');


        ///++++++++++++++++++++++Baja de Productos++++++++++++++++++++++++++++++++++++++++++////
        $this->post('/baja', function ($req, $res, $args) {
            return pedidoControler::BorrarUno($req, $res, $args);
        })
            ->add(middle::class . ':logGuardar')
            ->add(middle::class . ':autorizadoMesas')
            ->add(middle::class . ':validarToken');

        $this->post('/servir', function ($req, $res, $args) {
            return pedidoControler::Servir($req, $res, $args);
        })
            ->add(middle::class . ':logGuardar')
            ->add(middle::class . ':autorizadoMozo')
            ->add(middle::class . ':validarToken');

        $this->post('/cobrar', function ($req, $res, $args) {
            return pedidoControler::Cobrar($req, $res, $args);
        })
            ->add(middle::class . ':logGuardar')
            ->add(middle::class . ':autorizadoAdmin')
            ->add(middle::class . ':validarToken');
    });
};
