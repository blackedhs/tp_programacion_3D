<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
// use App\Models\ORM\cdApi;
use App\Models\ORM\comanda;
use App\Models\ORM\encuesta;
use App\Models\ORM\log;
use App\Models\ORM\producto;
use App\Models\ORM\mesa;

include_once __DIR__ . '/../../src/app/modelORM/encuesta.php';
include_once __DIR__ . '/../../src/app/modelORM/log.php';
include_once __DIR__ . '/../../src/middleware.php';

return function (App $app) {
    $container = $app->getContainer();
    $app->group('/listados', function () {
        ///++++++++++++++++++++++log de ingresos++++++++++++++++++++++++++++++++++++++++++////
        $this->get('/ingresos', function ($req, $res, $args) {
            if ($req->getQueryParams()['id'] != null)
                $log = log::where('id_usuario', $req->getQueryParams()['id'])->get();
            else {
                if ($req->getQueryParams()['nombre'] != null)
                    $log = log::where('nombre_usuario', $req->getQueryParams()['nombre'])->get();
                else
                    $log = log::all();
            }
            $res->getBody()->write($log);
            return $res;
        });
        $this->get('/productomasvendido', function ($req, $res, $args) {
            $productos = producto::all();
            $producto = $productos[0];
            foreach ($productos as $prod) {
                if ($prod->cant_vendida > $producto->cant_vendida)
                    $producto = $prod;
            }
            $res->getBody()->write('el producto mas vendido es ' . $producto);
            return $res;
        });
        $this->get('/productomenosvendido', function ($req, $res, $args) {
            $productos = producto::all();
            $producto = $productos[0];
            foreach ($productos as $prod) {
                if ($prod->cant_vendida < $producto->cant_vendida)
                    $producto = $prod;
            }
            $res->getBody()->write('el producto menos vendido es ' . $producto);
            return $res;
        });
        $this->get('/pedidosanulados', function ($req, $res, $args) {
            $comanda = comanda::where('estado', 'anulada')->get();
            $res->getBody()->write('los pedidos anulados son ' . $comanda);
            return $res;
        });
        $this->get('/mesamenosusada', function ($req, $res, $args) {
            $mesas = mesa::all();
            $mesa = $mesas[0];
            foreach ($mesas as $prod) {
                if ($prod->usos < $mesa->usos)
                    $mesa = $prod;
            }
            $res->getBody()->write('la mesa menos usada es ' . $mesa);
            return $res;
        });
        $this->get('/mesamasusada', function ($req, $res, $args) {
            $mesas = mesa::all();
            $mesa = $mesas[0];
            foreach ($mesas as $prod) {
                if ($prod->usos > $mesa->usos)
                    $mesa = $prod;
            }
            $res->getBody()->write('la mesa mas usada es ' . $mesa);
            return $res;
        });
        $this->get('/mesamasfacturo', function ($req, $res, $args) {
            $comandas = comanda::all();
            $mesas = mesa::all();
            $mesa = $mesas[0];
            $valor = 0;
            $sumador = 0;
            foreach ($mesas as $m) {
                foreach ($comandas as $comanda) {
                    if ($m->id == $comanda->id_mesa && $comanda->estado == 'pagado')
                        $sumador += $comanda->importe;
                }
                if ($sumador > $valor) {
                    $valor = $sumador;
                    $mesa = $m;
                }
                $sumador = 0;
            }
            $res->getBody()->write('la mesa que mas vendio es ' . $mesa . ' por un importe de ' . $valor);
            return $res;
        });
        $this->get('/mesamenosfacturo', function ($req, $res, $args) {
            $comandas = comanda::all();
            $mesas = mesa::all();
            $mesa = $mesas[0];
            $valor = comanda::where('estado', 'pagado')->get();
            $valor = $valor[0]->importe;
            $sumador = 0;
            $ban=0;
            foreach ($mesas as $m) {
                foreach ($comandas as $comanda) {
                    if ($m->id == $comanda->id_mesa && $comanda->estado == 'pagado'){
                        $ban = 1;
                        $sumador += $comanda->importe;
                    }
                }
                if ($sumador < $valor && $ban) {
                    $valor = $sumador;
                    $mesa = $m;
                    $ban=0;
                }
                $sumador = 0;
            }
            $res->getBody()->write('la mesa que mas vendio es ' . $mesa . ' por un importe de ' . $valor);
            return $res;
        });
        $this->get('/mesamayorimporte', function ($req, $res, $args) {
            $comandas = comanda::all();
            $mesas = mesa::all();
            $mesa = $mesas[0];
            $valor = comanda::where('estado', 'pagado')->get();
            $valor = $valor[0]->importe;
            foreach ($mesas as $m) {
                foreach ($comandas as $comanda) {
                    if ($m->id == $comanda->id_mesa && $comanda->estado == 'pagado' && $valor < $comanda->importe) {
                        $valor = $comanda->importe;
                        $mesa = $m;
                    }
                }
            }
            $res->getBody()->write('la mesa con mayor importe es ' . $mesa . ' por un importe de ' . $valor);
            return $res;
        });
        $this->get('/mesamenorimporte', function ($req, $res, $args) {
            $comandas = comanda::all();
            $mesas = mesa::all();
            $mesa = $mesas[0];
            $valor = comanda::where('estado', 'pagado')->get();
            $valor = $valor[0]->importe;
            foreach ($mesas as $m) {
                foreach ($comandas as $comanda) {
                    if ($m->id == $comanda->id_mesa && $comanda->estado == 'pagado' && $valor > $comanda->importe) {
                        $valor = $comanda->importe;
                        $mesa = $m;
                    }
                }
            }
            $res->getBody()->write('la mesa con menor importe es ' . $mesa . ' por un importe de ' . $valor);
            return $res;
        });
    })
        ->add(middle::class . ':logGuardar')
        ->add(middle::class . ':autorizadoAdmin')
        ->add(middle::class . ':validarToken');
};
