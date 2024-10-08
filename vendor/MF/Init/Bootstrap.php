<?php

namespace MF\Init;


abstract class Bootstrap{

  private $routes;

  abstract protected function initRoutes();

  public function __construct()
  {
    $this->initRoutes();
    $this->run($this->getUrl());
  }

  public function setRoutes(array $routes){
    $this->routes = $routes;
  }

  public function getRoutes(){
    return $this->routes;
  }


  protected function run($url){
    foreach($this->getRoutes() as $key => $route){

      if($url == $route["route"]){
        //use ucfirst opcional ucfirst($route["controller"]);
        $class = "App\\Controllers\\".$route["controller"];
        $controller = new $class;

        $action = $route["action"];
        //não esquecer os ()
        $controller -> $action();
      }

    }
  }


  protected function getUrl(){

    return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

  }

}

?>