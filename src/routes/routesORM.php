<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\comandaControler;
use App\Models\ORM\cdApi;
use App\Models\ORM\comanda;
use App\Models\ORM\usuario;

include_once __DIR__ . '/../../src/app/modelORM/comanda.php';
include_once __DIR__ . '/../../src/app/modelORM/usuario.php';
include_once __DIR__ . '/../../src/app/modelORM/comandaControler.php';
include_once __DIR__ . '/../../src/middleware.php';

return function (App $app) {
  $container = $app->getContainer();

  $app->group('/cdORM', function () {

    $this->get('/', function ($request, $response, $args) {
      //return cd::all()->toJson();
      $todosLosCds = comanda::all();
      $newResponse = $response->withJson($todosLosCds, 200);
      return $newResponse;
    });
  });
  

  $app->group('/cdORM2', function () {

    $this->get('/', cdApi::class . ':traerTodos');
  });
};
