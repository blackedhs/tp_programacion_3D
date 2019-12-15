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


class pedidoControler
{
  public function Beinvenida($request, $response, $args)
  {
    $response->getBody()->write("GET => Bienvenido!!! ,a UTN FRA SlimFramework");

    return $response;
  }

  public function TraerTodos($request, $response, $args)
  {
    $usuario = $request->getAttribute('usuario');
    if ($usuario->perfil == 'admin') {
      $todosLosPedidos = pedido::where('estado', 0)->get();
      if (count($todosLosPedidos) > 0)
        $newResponse = $response->withJson($todosLosPedidos, 200);
      else
        $newResponse = $response->withJson('no hay pedidos disponibles', 200);
    } else {
      if ($usuario->perfil == 'cocinero') {
        $usuario->perfil = 'cocina';
      }
      $todosLosPedidos = pedido::where('responsable', $usuario->perfil)
        ->where('estado', 0)
        ->get();
      if (count($todosLosPedidos) > 0)
        $newResponse = $response->withJson($todosLosPedidos, 200);
      else
        $newResponse = $response->withJson('no hay pedidos disponibles para este perfil', 200);
    }
    return $newResponse;
  }
  public function TraerUno($request, $response, $args)
  {
    $usuario = $request->getAttribute('usuario');
    if ($usuario->perfil == 'admin') {
      $todosLosPedidos = pedido::where('estado', 0)
        ->where('codigo', $request->getQueryParams()['codigo'])
        ->get();
      $newResponse = $response->withJson($todosLosPedidos, 200);
    } else {
      if ($usuario->perfil == 'cocinero') {
        $usuario->perfil = 'cocina';
      }
      $todosLosPedidos = pedido::where('responsable', $usuario->perfil)
        ->where('estado', 0)
        ->where('codigo', $request->getQueryParams()['codigo'])
        ->get();
      if (count($todosLosPedidos) > 0)
        $newResponse = $response->withJson($todosLosPedidos, 200);
      else
        $newResponse = $response->withJson('no hay pedidos disponibles para este perfil', 200);
    }
    return $newResponse;
  }

  public function PrepararUno($request, $response, $args)
  {
    $usuario = $request->getAttribute('usuario');
    if ($usuario->perfil == 'cocinero') {
      $usuario->perfil = 'cocina';
    }
    $pedido = pedido::where('id', $request->getParsedBody()['id'])
      ->where('responsable', $usuario->perfil)
      ->where('estado', 0)
      ->get();
    if (count($pedido) == 1) {
      $pedido[0]->estado = 1;
      $pedido[0]->save();
      $newResponse = $response->withJson("preparando pedido " . $pedido[0], 200);
    } else {
      $newResponse = $response->withJson("Pedido no existente para su sector", 200);
    }
    return $newResponse;
  }
  public function PrepararTodos($request, $response, $args)
  {
    $usuario = $request->getAttribute('usuario');
    if ($usuario->perfil == 'cocinero') {
      $usuario->perfil = 'cocina';
    }
    if ($request->getParsedBody()['codigo'] != null)
      $pedido = pedido::where('codigo', $request->getParsedBody()['codigo'])
        ->where('responsable', $usuario->perfil)
        ->where('estado', 0)
        ->get();
    else
      $pedido = pedido::where('responsable', $usuario->perfil)
        ->where('estado', 0)
        ->get();

    if (count($pedido) > 0) {
      foreach ($pedido as $p) {
        $p->estado = 1;
        $p->save();
      }
      $newResponse = $response->withJson("preparando pedidos " . $pedido, 200);
    } else {
      $newResponse = $response->withJson("Pedido no existente para su sector", 200);
    }
    return $newResponse;
  }
  public function TerminarUno($request, $response, $args)
  {
    $usuario = $request->getAttribute('usuario');
    if ($usuario->perfil == 'cocinero') {
      $usuario->perfil = 'cocina';
    }
    $pedido = pedido::where('id', $request->getParsedBody()['id'])
      ->where('responsable', $usuario->perfil)
      ->where('estado', 1)
      ->get();
    if (count($pedido) == 1) {
      $pedido[0]->estado = 2;
      $pedido[0]->save();
      $newResponse = $response->withJson("Pedido terminado " . $pedido[0], 200);
    } else {
      $newResponse = $response->withJson("Pedido no existente para su sector", 200);
    }
    return $newResponse;
  }
  public function TerminarTodos($request, $response, $args)
  {
    $usuario = $request->getAttribute('usuario');
    if ($usuario->perfil == 'cocinero') {
      $usuario->perfil = 'cocina';
    }
    if ($request->getParsedBody()['codigo'] != null)
      $pedido = pedido::where('codigo', $request->getParsedBody()['codigo'])
        ->where('responsable', $usuario->perfil)
        ->where('estado', 1)
        ->get();
    else
      $pedido = pedido::where('responsable', $usuario->perfil)
        ->where('estado', 1)
        ->get();

    if (count($pedido) > 0) {
      foreach ($pedido as $p) {
        $p->estado = 2;
        $p->save();
      }
      $newResponse = $response->withJson("Pedidos Terminados" . $pedido, 200);
    } else {
      $newResponse = $response->withJson("Pedido no existente para su sector", 200);
    }
    return $newResponse;
  }

  public function BorrarUno($request, $response, $args)
  {
    $comanda = comanda::where('codigo', $request->getParsedBody()['codigo'])->get();
    if (count($comanda) == 1) {
      $comanda[0]->estado = 'anulada';
      $mesa = mesa::where('id', $comanda->id_mesa)->get();
      $pedidos = pedido::where('codigo', $comanda->codigo)->get();
      foreach ($pedidos as $pedido) {
        $pedido->delete();
      }
      $mesa[0]->estado = 'lista';
      $mesa[0]->save();
      $comanda[0]->save();
      $newResponse = $response->withJson("baja exitosa", 200);
    } else {
      $newResponse = $response->withJson("Comanda inexistente", 200);
    }
    return $newResponse;
  }

  public function Servir($request, $response, $args)
  {
    $comanda = comanda::where('codigo', $request->getParsedBody()['codigo'])->get();
    if (count($comanda) == 1) {
      if ($comanda[0]->estado == 'listo para servir') {
        $comanda[0]->estado = 'servido';
        $mesa = mesa::where('id', $comanda[0]->id_mesa)->get();
        $pedidos = pedido::where('codigo', $comanda[0]->codigo)->get();
        foreach ($pedidos as $pedido) {
          $pedido->estado = 3;
          $pedido->save();
        }
        $mesa[0]->estado = 'con gente comiendo';
        $mesa[0]->save();
        $comanda[0]->save();
        $newResponse = $response->withJson("Pedido servido", 200);
      } else {
        return $response->withJson("Pedido no preparado para servir", 200);
      }
    } else {
      $newResponse = $response->withJson("Comanda inexistente", 200);
    }
    return   $newResponse;
  }
  public function Cobrar($request, $response, $args)
  {
    $comanda = comanda::where('codigo', $request->getParsedBody()['codigo'])->get();
    if (count($comanda) == 1) {
      if ($comanda[0]->estado == 'servido') {
        $comanda[0]->estado = 'pagado';
        $mesa = mesa::where('id', $comanda[0]->id_mesa)->get();
        $mesa[0]->estado = 'lista';
        $mesa[0]->usos++;
        $mesa[0]->save();
        $comanda[0]->save();
        $newResponse = $response->withJson("Pedido cobrado", 200);
      } else {
        return $response->withJson("Pedido no preparado para cobrar", 200);
      }
    } else {
      $newResponse = $response->withJson("Comanda inexistente", 200);
    }
    return   $newResponse;
  }
}
