<?php

namespace App\Models\ORM;

use App\Models\ORM\comanda;
use App\Models\ORM\producto;
use App\Models\ORM\pedido;
use App\Models\IApiControler;

include_once __DIR__ . '/comanda.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';
include_once __DIR__ . '/pedido.php';
include_once __DIR__ . '/producto.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class comandaControler implements IApiControler
{
  public function Beinvenida($request, $response, $args)
  {
    $response->getBody()->write("GET => Bienvenido!!! ,a UTN FRA SlimFramework");

    return $response;
  }

  public function TraerTodos($request, $response, $args)
  {
    $todosLoscomandas = comanda::all();
    $newResponse = $response->withJson($todosLoscomandas, 200);
    return $newResponse;
  }
  public function RevisarComandas()
  {
    $comandas = comanda::where('estado', 'activa')
      ->orwhere('estado', 'preparando')
      ->get();
    if (count($comandas) > 0) {
      foreach ($comandas as $comanda) {
        $pedidos = pedido::where('codigo', $comanda->codigo)->get();
        if (count($pedidos) > 0) {
          $todosPreparando = 0;
          $todosListos = 0;
          foreach ($pedidos as $pedido) {
            if ($pedido->estado == 1)
              $todosPreparando++;
            else if ($pedido->estado == 2)
              $todosListos++;
            }
          if ($todosListos == count($pedidos) ) {
            $comanda->estado = 'listo para servir';
            $comanda->save();
          } else if ($todosPreparando == count($pedidos) ) {
            $comanda->estado = 'preparando';
            $comanda->save();
          }
        }
      }
    }
    return;
  }
  public function TraerUno($request, $response, $args)
  {
    $comanda = comanda::where('codigo', $request->getQueryParams()['codigo'])
      ->where('estado', '<>', 'anulada')
      ->where('estado', '<>', 'cobrada')->get();
    if (count($comanda) == 1) {
      $newResponse = $response->withJson($comanda[0], 200);
    } else {
      $newResponse = $response->withJson("La comanda no existe o fue cobrada o fue anulada", 200);
    }
    return $newResponse;
  }

  public function CargarUno($request, $response, $args)
  {
    $comanda = new comanda();
    $comanda->estado = 'activa';
    $idmesa = $request->getParsedBody()['id_mesa'];
    $existeMesa = mesa::where('id', $idmesa)->get();
    if (count($existeMesa) == 1 && $existeMesa[0]->estado == 'lista') {
      $existeMesa[0]->estado = 'con gente comiendo';
      $comanda->id_mesa = $idmesa;
      $comanda->nombre_cliente = $request->getParsedBody()['nombreCli'];
      ///id	id_mesa	nombre_cliente	pedido	estado	codigo	tiempo_preparacion	importe
      $comanda->pedido = $request->getParsedBody()['pedido'];
      $pedidos = explode(',', $comanda->pedido);
      $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
      $codigo = substr(str_shuffle($permitted_chars), 0, 5);
      $comanda->codigo = $codigo;
      $tiempo = 0;
      $importe = 0;
      foreach ($pedidos as $producto) {
        //id_mesa	codigo	producto	responsable	hora_pedido	estado
        $newPedido = new pedido();
        $newPedido->id_mesa = $idmesa;
        $newPedido->codigo = $comanda->codigo;
        $newProducto = producto::where('id', $producto)->get();
        if ($newProducto[0] == null) {
          return $response->withJson("producto no existente" . $newProducto[0], 200);
        }
        $newProducto[0]->cant_vendida += +1;
        $tiempo += $newProducto[0]->tiempo_preparacion;
        $importe += $newProducto[0]->precio;
        $newPedido->producto = $newProducto[0]->nombre;
        $newPedido->responsable = $newProducto[0]->responsable;
        $newPedido->estado = 0;
        $newPedido->hora_pedido = date('h:i:s', time());
        $newProducto[0]->save();
        $newPedido->save();
      }
      $comanda->tiempo_preparacion = $tiempo;
      $comanda->importe = $importe;
      $comanda->save();
      $existeMesa[0]->save();
      $newResponse = $response->withJson("Carga exitosa " . $comanda, 200);
    } else {
      $newResponse = $response->withJson("Mesa inexiste o ocupada ", 200);
    }
    return $newResponse;
  }
  public function BorrarUno($request, $response, $args)
  {
    $comanda = comanda::where('codigo', $request->getParsedBody()['codigo'])
      ->where('estado', '<>', 'anulada')
      ->get();
    if (count($comanda) == 1) {
      $comanda[0]->estado = 'anulada';
      $mesa = mesa::where('id', $comanda[0]->id_mesa)->get();
      $mesa[0]->estado = 'lista';
      $pedidos = pedido::where('codigo', $comanda[0]->codigo)->get();
      foreach ($pedidos as $pedido) {
        $pedido->delete();
      }
      $mesa[0]->save();
      $comanda[0]->save();
      $newResponse = $response->withJson("baja exitosa", 200);
    } else {
      $newResponse = $response->withJson("Comanda inexistente o ya fue dada de baja", 200);
    }
    return $newResponse;
  }

  public function ModificarUno($request, $response, $args)
  {
    $comanda = comanda::where('codigo', $request->getParsedBody()['codigo'])->get();
    if (count($comanda)) {
      $pedidos = explode(',', $comanda[0]->pedido);
      foreach ($pedidos as $producto) {
        $Modproducto = producto::where('id', $producto)->get();
        $Modproducto[0]->cant_vendida -= 1;
      }
      $pedidos = pedido::where('codigo', $comanda[0]->codigo)->get();
      foreach ($pedidos as $pedido) {
        $pedido->delete();
      }
      $comanda[0]->pedido = $request->getParsedBody()['pedido'];
      $pedidos = explode(',', $comanda[0]->pedido);
      $tiempo = 0;
      $importe = 0;
      foreach ($pedidos as $producto) {
        //id_mesa	codigo	producto	responsable	hora_pedido	estado
        $newPedido = new pedido();
        $newPedido->id_mesa = $comanda[0]->id_mesa;
        $newPedido->codigo = $comanda[0]->codigo;
        $newProducto = producto::where('id', $producto)->get();
        $newProducto[0]->cant_vendida += +1;
        $tiempo += $newProducto[0]->tiempo_preparacion;
        $importe += $newProducto[0]->precio;
        $newPedido->producto = $newProducto[0]->nombre;
        $newPedido->responsable = $newProducto[0]->responsable;
        $newPedido->estado = 0;
        $newPedido->hora_pedido = date('h:i:s', time());
        $newProducto[0]->save();
        $newPedido->save();
      }
      $comanda[0]->tiempo_preparacion = $tiempo;
      $comanda[0]->importe = $importe;
      $comanda[0]->save();
      $newResponse = $response->withJson("Modificacion exitosa " . $comanda[0], 200);
    } else {
      $newResponse = $response->withJson("Comanda no existente ", 200);
    }
    return   $newResponse;
  }
}
