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
    $app->group('/productos', function () {
        ///++++++++++++++++++++++Alta de Productos++++++++++++++++++++++++++++++++++++++++++////
        $this->post('/alta', function ($req, $res, $args) {
            $producto = new producto;
            $producto->nombre = $req->getParsedBody()['nombre'];
            $producto->tiempo_preparacion = $req->getParsedBody()['tiempo_preparacion'];
            $producto->cant_vendida = 0;
            $producto->precio = $req->getParsedBody()['precio'];
            try {
                $producto->save();
                $res->getBody()->write('Alta Existosa. Datos del producto : ' . $producto);
            } catch (Exception $e) {
                $res->getBody()->write('El producto ya existe');
            }
            return $res;
        });

        ///++++++++++++++++++++++Moficar Productos++++++++++++++++++++++++++++++++++++++++++////
        $this->post('/modificar', function ($req, $res, $args) {
            $producto = producto::where('nombre', $req->getParsedBody()['nombre'])->get();
            if (count($producto) == 1) {
                $producto[0]->tiempo_preparacion = $req->getParsedBody()['tiempo_preparacion'];
                $producto[0]->precio = $req->getParsedBody()['precio'];
                $producto[0]->save();
                $res->getBody()->write('Modificacion Existosa. Datos del producto : ' . $producto);
            } else {
                $res->getBody()->write('El producto no existe');
            }
            return $res;
        });

        ///++++++++++++++++++++++Mostar de Productos++++++++++++++++++++++++++++++++++++++++++////
        $this->get('/mostrar', function ($req, $res, $args) {
            $producto = producto::all();
            return $res->withJson($producto);
        });

        ///++++++++++++++++++++++Baja de Productos++++++++++++++++++++++++++++++++++++++++++////
        $this->post('/baja', function ($req, $res, $args) {
            $producto = producto::where('nombre', $req->getParsedBody()['nombre'])->get();
            if (count($producto) == 1) {
                $producto[0]->forceDelete();
                // var_dump($producto);
                $res->getBody()->write('Baja Exitosa');
            } else
                $res->getBody()->write('Producto no existente');
            return $res;
        });
    })
        ->add(middle::class . ':logGuardar')
        ->add(middle::class . ':autorizadoAdmin')
        ->add(middle::class . ':validarToken');
};
