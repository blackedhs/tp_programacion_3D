<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\cdApi;
use App\Models\ORM\usuario;
use App\Models\AutentificadorJWT;


include_once __DIR__ . '/../../src/app/modelORM/usuario.php';
include_once __DIR__ . '/../../src/middleware.php';
include_once __DIR__ . '/../../src/app/modelAPI/AutentificadorJWT.php';

return function (App $app) {
    $container = $app->getContainer();
    $app->group('/login', function () {

        ///++++++++++++++++++++++Login de usuarios++++++++++++++++++++++++++++++++++++++++++////
        $this->post('/login', function ($req, $res, $args) {
            if ($req->getParsedBody()['usuario'] != null &&  $req->getParsedBody()['clave'] != null) {
                $usu = usuario::where('usuario', $req->getParsedBody()['usuario'])
                    ->where('contraseña', crypt($req->getParsedBody()['clave'], 'masflow2'))
                    ->get();
                if (count($usu) == 1) {
                    foreach($usu as $s){
                        $datos = array(
                            'id'=> $s->id,
                            'nombre' => $s->nombre,
                            'apellido' => $s->apellido,
                            'usuario' => $s->usuario,
                            'contraseña' => $s->contraseña,
                            'estado' => $s->estado,
                            'sector' => $s->sector,
                            'perfil' => $s->perfil,
                          );
                        $token = AutentificadorJWT::CrearToken($datos);
                    } 
                    $res->getBody()->write('Usuario logeado.Su token es ' . $token);
                } else
                    $res->getBody()->write('Usuario o contraseña incorrecta');
            } else
                $res->getBody()->write('Debe ingresar usuario y contraseña');
            return $res;
        });
    });
};
