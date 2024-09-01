<?php

namespace App;

use PDO;
use PDOException;

class Connection{

  public static function getDb(){
    try{

      $conn = new PDO("mysql:host=localhost;dbname=*alterado*;charset=utf8", "*alterado*", "*alterado*");

      return $conn;

    }catch(PDOException $e){

      echo $e;

    }
  }

}


?>