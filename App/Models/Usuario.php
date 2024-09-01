<?php

namespace App\models;

use MF\Model\Model;
use PDO;

class Usuario extends Model{

  private $id;
  private $nome;
  private $email;
  private $senha;

  public function __get($attr){

    return $this->$attr;

  }

  public function __set($attr,$value){

    $this->$attr = $value;

  }

  public function salvar(){

    $query = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":nome", $this->__get("nome"));
    $stmt->bindValue(":email", $this->__get("email"));
    $stmt->bindValue("senha", password_hash($this->__get("senha"), PASSWORD_DEFAULT));
    $stmt->execute();

    return $this;

  }    
  
  public function validarCadastro(){
    $valido = true;
    $nomeValido = true;
    $passValido = true;
    $emailValido = true;

    if(strlen($this->__get("nome")) < 3 ){
      $nomeValido = "nomeInvalido";
      return $nomeValido;
    }

    if(!filter_var($this->__get("email"), FILTER_VALIDATE_EMAIL)){
      $emailValido = "emailInvalido";
      return $emailValido;
    }


    $lowercase = preg_match('@[a-z]@', $this->__get("senha"));
    $number = preg_match('@[0-9]@', $this->__get("senha"));
    $specialChars = preg_match('@[^\w]@', $this->__get("senha"));

    if(!$lowercase || !$number || !$specialChars || strlen($this->__get("senha")) < 6) {
      $passValido = "passInvalido";
      return $passValido;
    }
    

  }


  public function getUsuarioPorEmail(){

    $query = "SELECT nome, email FROM usuarios WHERE email = :email";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":email", $this->__get("email"));
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);


  }

  public function autenticar(){

    $query = "SELECT id, nome, email, senha FROM usuarios WHERE email = :email";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":email", $this->__get("email"));
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if($usuario["id"] != "" && $usuario["nome"] != ""){


      if($this->__get("email") == $usuario["email"] && password_verify($this->__get("senha"), $usuario["senha"])){

        $this->__set("id", $usuario["id"]);
        $this->__set("nome", $usuario["nome"]);
  
      }                                                                                                     
                                                                                                                                                             
    }

    return $this;


  }

  public function getAll(){

    $query = "SELECT u.id, u.nome, u.email, (SELECT count(*) FROM usuarios_seguidores as us WHERE us.id_usuario = :id_usuario and us.id_usuario_seguindo = u.id) as seguindo_sn FROM usuarios as u WHERE nome LIKE :nome AND id != :id_usuario";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":nome", "%".$this->__get("nome")."%");
    $stmt->bindValue(":id_usuario", $this->__get("id"));
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

  }

  public function seguirUsuario($id_usuario_seguindo){

    $query = "INSERT INTO usuarios_seguidores (id_usuario, id_usuario_seguindo) VALUES (:id_usuario, :id_usuario_seguindo)";

    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id_usuario", $this->__get("id"));
    $stmt->bindValue(":id_usuario_seguindo", $id_usuario_seguindo);
    $stmt->execute();

    return true;

  }


  public function deixarSeguirUsuario($id_usuario_seguindo){

    $query = "DELETE FROM usuarios_seguidores WHERE id_usuario = :id_usuario AND id_usuario_seguindo = :id_usuario_seguindo";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id_usuario", $this->__get("id"));
    $stmt->bindValue(":id_usuario_seguindo", $id_usuario_seguindo);
    $stmt->execute();

    return true;
  }


  public function getInfoUsuario(){

    $query = "SELECT nome FROM usuarios WHERE id = :id_usuario";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id_usuario", $this->__get("id"));
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);

  }

  public function getTotalTweets(){

    $query = "SELECT count(*) as totalTweet FROM tweets WHERE id_usuario = :id_usuario";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id_usuario", $this->__get("id"));
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);

  }

  public function getTotalSeguindo(){

    $query = "SELECT count(*) as totalSeguindo FROM usuarios_seguidores WHERE id_usuario = :id_usuario";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id_usuario", $this->__get("id"));
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);

  }

  public function getTotalSeguidores(){

    $query = "SELECT count(*) as totalSeguidores FROM usuarios_seguidores WHERE id_usuario_seguindo = :id_usuario";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id_usuario", $this->__get("id"));
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);

  }

}               


?>