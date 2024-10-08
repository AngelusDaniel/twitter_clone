<?php

namespace MF\Controller;

use stdClass;

abstract class Action {

  protected $view;

  public function __construct()
  {
    $this->view = new stdClass();
  }

  protected function render($view, $layout="layout"){
    $this->view->page = $view;

    if(file_exists("../App/Views/$layout.phtml")){

      require_once "../App/Views/$layout.phtml";

    }else{

      $this->content();

    }
    
    
  }

  protected function content(){

    $classAtual =  get_class($this);

    $classAtual = str_replace("App\\Controllers\\", "",  $classAtual);

    $classAtual = str_replace("Controller", "", $classAtual);

    $classAtual =  strtolower($classAtual);

    require "../App/Views/$classAtual/".$this->view->page.".phtml";

  }

}

?>