<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\cdApi;
use App\Models\ORM\encuesta;


include_once __DIR__ . '/../../src/app/modelORM/encuesta.php';
include_once __DIR__ . '/../../src/middleware.php';

return function (App $app) {
    $container = $app->getContainer();
    $app->group('/encuestas', function () {
        ///++++++++++++++++++++++Alta de encuesta++++++++++++++++++++++++++++++++++++++++++////
        $this->post('/alta', function ($req, $res, $args) {
            $encuesta = new encuesta;
            $encuesta->mesa = $req->getParsedBody()['mesa'];
            $encuesta->restaurante = $req->getParsedBody()['restaurante'];
            $encuesta->cocinero = $req->getParsedBody()['cocinero'];
            $encuesta->mozo = $req->getParsedBody()['mozo'];
            $encuesta->comentario = $req->getParsedBody()['comentario'];
            $encuesta->puntuacion_total = $req->getParsedBody()['mozo'] +
                $req->getParsedBody()['mesa'] + $req->getParsedBody()['restaurante'] +
                $req->getParsedBody()['cocinero'];
            $encuesta->save();
            $res->getBody()->write('Gracias por su tiempo
                . Datos de la encuesta : ' . $encuesta);
            return $res;
        });
    });
};
