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
    $app->group('/usuarios', function () {

        ///++++++++++++++++++++++Alta de usuarios++++++++++++++++++++++++++++++++++++++++++////
        $this->post('/alta', function ($req, $res, $args) {
            $usuario = new usuario;
            $usuario->nombre = $req->getParsedBody()['nombre'];
            $usuario->apellido = $req->getParsedBody()['apellido'];
            $usuario->usuario = $req->getParsedBody()['usuario'];
            $usuario->contraseña = $req->getParsedBody()['contraseña'];
            $usuario->estado = $req->getParsedBody()['estado'];
            $usuario->sector = $req->getParsedBody()['sector'];
            $usuario->perfil = $req->getParsedBody()['perfil'];
            try {
                $usuario->save();
                $res->getBody()->write('Alta Existosa. Datos del usuario : ' . $usuario);
            } catch (Exception $e) {
                $res->getBody()->write('El usuario ya existe');
            }
            return $res;
        });

        ///++++++++++++++++++++++Modificar usuarios++++++++++++++++++++++++++++++++++++++++++////
        $this->post('/modificar', function ($req, $res, $args) {
            $usuario = usuario::where('usuario', $req->getParsedBody()['usuario'])->get();
            if (count($usuario) == 1) {
                $usuario[0]->nombre = $req->getParsedBody()['nombre'];
                $usuario[0]->apellido = $req->getParsedBody()['apellido'];
                $usuario[0]->contraseña = $req->getParsedBody()['contraseña'];
                $usuario[0]->estado = $req->getParsedBody()['estado'];
                $usuario[0]->sector = $req->getParsedBody()['sector'];
                $usuario[0]->perfil = $req->getParsedBody()['perfil'];
                $usuario[0]->save();
                $res->getBody()->write('Modificacion Existosa. Datos del usuario : ' . $usuario);
            } else {
                $res->getBody()->write('Usuario no existente');
            }
            return $res;
        });

        ///++++++++++++++++++++++Mostar  usuarios++++++++++++++++++++++++++++++++++++++++++////
        $this->get('/mostrar', function ($req, $res, $args) {
            $usuarios = usuario::all();
            return $res->withJson($usuarios);
        });

        ///++++++++++++++++++++++Baja de usuarios++++++++++++++++++++++++++++++++++++++++++////
        $this->post('/baja', function ($req, $res, $args) {
            $usuario = usuario::where('usuario', $req->getParsedBody()['usuario'])->get()->toArray();
            if (count($usuario) == 1) {
                $usuario[0]->forceDelete();
                $res->getBody()->write('Baja Exitosa');
            } else
                $res->getBody()->write('Usuario no existente');
            return $res;
        });
    })
        ->add(middle::class . ':logGuardar')
        ->add(middle::class . ':autorizadoUsuarios')
        ->add(middle::class . ':validarToken');
};
