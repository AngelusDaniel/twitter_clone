<?php

namespace App\Controllers;

use stdClass;

use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action{


  

  public function index(){

  
    $this->view->login = isset($_GET["login"]) ? $_GET["login"] : "";
    $this->render("index", "layout");
      
  }



  public function inscreverse(){

    $this->view->usuario = array(
      "nome" => "",
      "email" => "",


    );

    $this->view->erroCadastro = false;

    $this->render("inscreverse");

  }


  public function registrar(){

    $usuario = Container::getModel("Usuario");

    $usuario->__set("nome",  htmlspecialchars($_POST["name"]), ENT_QUOTES);
    $usuario->__set("email", filter_var($_POST["email"], FILTER_SANITIZE_EMAIL));
    $usuario->__set("senha", htmlspecialchars($_POST["password"], ENT_QUOTES));

    $valido = $usuario->validarCadastro();

    if(!count($usuario->getUsuarioPorEmail()) == 0){

      $emailValido = false;

    }

    if(!$valido == "nomeInvalido" && !$valido=="emailInvalido" && !$valido == "passInvalido" && count($usuario->getUsuarioPorEmail()) == 0 ){

      
      $usuario->salvar();
      $this->render("cadastro");

      
    }else{


      $this->view->usuario = array(
        "nome" => $_POST["name"],
        "email" => $_POST["email"],


      );

      $this->view->erroCadastro = true;

      $this->render("inscreverse");
      
    }
    

  }
     
    

  
  

}


?>