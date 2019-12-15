<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
// use App\Models\ORM\cdApi;
use App\Models\ORM\comanda;
use App\Models\ORM\mesa;

include_once __DIR__ . '/../../src/app/modelORM/mesa.php';
include_once __DIR__ . '/../../src/middleware.php';

return function (App $app) {
    $container = $app->getContainer();
    $app->group('/mesas', function () {
        ///++++++++++++++++++++++Alta de Mesas++++++++++++++++++++++++++++++++++++++++++////
        $this->post('/alta', function ($req, $res, $args) {
            $mesa = new mesa;
            $mesa->codigo = $req->getParsedBody()['codigo'];
            try {
                $mesa->estado = 'lista';
                $mesa->save();
                $res->getBody()->write('Alta Existosa. Datos de la mesa : ' . $mesa);
            } catch (Exception $e) {
                $res->getBody()->write('La mesa ya existe');
            }
            return $res;
        });

        ///++++++++++++++++++++++Moficar Mesas++++++++++++++++++++++++++++++++++++++++++////
        $this->post('/modificar', function ($req, $res, $args) {
            $mesa = mesa::where('id', $req->getParsedBody()['id'])->get();
            if (count($mesa) == 1) {
                // $mesa[0]->codigo = $req->getParsedBody()['codigo'];
                $mesa[0]->estado = $req->getParsedBody()['estado'];
                $mesa[0]->save();
                $res->getBody()->write('Modificacion Existosa. Datos del mesa : ' . $mesa);
            } else {
                $res->getBody()->write('La mesa no existe');
            }
            return $res;
        });

        ///++++++++++++++++++++++Mostar de Mesas++++++++++++++++++++++++++++++++++++++++++////
        $this->get('/mostrar', function ($req, $res, $args) {
            if ($req->getQueryParams()['id'] == null) {
                $mesa = mesa::all();
                if (count($mesa) > 0 )
                    $res->getBody()->write($mesa);
                else
                    $res->getBody()->write('No hay mesas cargadas');
            } else {
                $mesa = mesa::where('id', $req->getQueryParams()['id'])->get();
                if (count($mesa) == 1)
                    $res->getBody()->write($mesa);
                else
                    $res->getBody()->write('Id de mesa inexistente');
            }
            return $res;
        });

        ///++++++++++++++++++++++Baja de Mesas++++++++++++++++++++++++++++++++++++++++++////
        $this->post('/baja', function ($req, $res, $args) {
            $mesa = mesa::where('id', $req->getParsedBody()['id'])->get();
            if (count($mesa) == 1) {
                $mesa[0]->forceDelete();
                $res->getBody()->write('Baja Exitosa');
            } else
                $res->getBody()->write('Mesa no existente');
            return $res;
        });
    })
        ->add(middle::class . ':logGuardar')
        ->add(middle::class . ':autorizadoMesas')
        ->add(middle::class . ':validarToken');
};
