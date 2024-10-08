<?php

namespace App\Controllers;

use stdClass;

use MF\Controller\Action;
use MF\Model\Container;


class AuthController extends Action{

  public function autenticar(){

    $usuario = Container::getModel("usuario");

    $usuario->__set("email", filter_var($_POST["email"], FILTER_SANITIZE_EMAIL));
    $usuario->__set("senha", htmlspecialchars($_POST["password"], ENT_QUOTES));

    $retorno = $usuario->autenticar();

    if($usuario->__get("id") != "" && $usuario->__get("nome") != ""){

      session_start();

      $_SESSION["id"] = $usuario->__get("id");
      $_SESSION["nome"] = $usuario->__get("nome");

      header("Location: /timeline");

    }else{

       header("Location: /?login=error");

    }
  }

  public function sair(){

    session_start();

    session_destroy();

    header("Location: /");

  }


}