<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {


	public function timeline() {

		$this->validaAutenticacao();
			
		//recuperação dos tweets
		$tweet = Container::getModel('Tweet');

		$tweet->__set('id_usuario', $_SESSION['id']);

		$tweets = $tweet->getAll();

		$this->view->tweets = $tweets;

    $usuario = Container::getModel("Usuario");

    $usuario->__set("id", $_SESSION["id"]);

    $this->view->infoUsuario = $usuario->getInfoUsuario();
    $this->view->totalTweets =  $usuario->getTotalTweets();
    $this->view->totalSeguindo =  $usuario->getTotalSeguindo();
    $this->view->totalSeguidores = $usuario->getTotalSeguidores();

		$this->render('timeline');
		
		
	}

	public function tweet() {

		$this->validaAutenticacao();

		$tweet = Container::getModel('Tweet');

		$tweet->__set('tweet', $_POST['tweet']);
		$tweet->__set('id_usuario', $_SESSION['id']);

		$tweet->salvar();

		header('Location: /timeline');
		
	}

	public function validaAutenticacao() {

		session_start();

		if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
			header('Location: /?login=error');
		}	

	}

	public function quemSeguir() {

		$this->validaAutenticacao();
    
    $pesquisarPor = isset($_GET["pesquisarPor"]) ? htmlspecialchars($_GET["pesquisarPor"], ENT_QUOTES) : "" ;

    //echo "Pesquisando Por ".$pesquisarPor;

    $usuarios = array();

    
    

    if($pesquisarPor != ""){

      $usuario = Container::getModel("Usuario");
      $usuario->__set("nome", $pesquisarPor);
      $usuario->__set("id", $_SESSION["id"]);
      $usuarios = $usuario->getAll();

    }

    $this->view->usuarios = $usuarios;

    $usuarioInfo = Container::getModel("Usuario");

    $usuarioInfo->__set("id", $_SESSION["id"]);

    $this->view->infoUsuario = $usuarioInfo->getInfoUsuario();
    $this->view->totalTweets =  $usuarioInfo->getTotalTweets();
    $this->view->totalSeguindo =  $usuarioInfo->getTotalSeguindo();
    $this->view->totalSeguidores = $usuarioInfo->getTotalSeguidores();
    

		$this->render("quemSeguir");
	}	

  public function acao(){

    $this->validaAutenticacao();

    $acao = isset($_GET["acao"]) ? $_GET["acao"] : "";
    $id_usuario_seguindo = isset($_GET["id_usuario"]) ? $_GET["id_usuario"] : "";

    $usuario = Container::getModel("Usuario");
    $usuario->__set("id", $_SESSION["id"]);

    if($acao == "seguir"){

      $usuario->seguirUsuario($id_usuario_seguindo);

    }else if($acao == "deixar_de_seguir"){

      $usuario->deixarSeguirUsuario($id_usuario_seguindo);

    }

    header("Location: /quemSeguir");

  }

  public function delete(){

    $this->validaAutenticacao();

    $tweet = Container::getModel("Tweet");

   
    $tweet->__set("id", $_POST["idTweet"]);
    $tweet->__set("id_usuario", $_SESSION["id"]);

    $tweet->delete();

    header("Location: /timeline");

    

  }

}

?>