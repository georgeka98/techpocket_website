<?php

require "app/controller.php";

class Bootstrap{

  protected $controller;
  protected $method;
  protected $params;
  protected $ajax;

  public function __construct(){

    $this->controller = DEFAULT_CONTROLLER;
    $this->method = DEFAULT_ACTION;
    $this->params = [];
    $this->ajax = False;

    $url = isset($_GET['url']) ? explode('/', rtrim($_GET['url'], '/')) : null;
    // print_r($url); //debug

    $view = new View();
    //default values in case the requested page is not found
    $view->title = "404 not found";
    $view->css = array("error");

    if (isset($url[0]) && ($url[0] == "blog" || $url[0] == "universal")){
      if(!isset($url[1])){
        $view->render("error/error.php", true, false);
        return;
      }
      else{
        if ($url[1] == "article" && !isset($url[2])){
          $view->render("error/error.php", true, false);
          return;
        }
      }
    }

    if (isset($url[0]) && $url[0] != "home"){
      if (file_exists("controllers/" . $url[0] . '.php')){

        require_once "controllers/" . $url[0] . '.php';
        $this->controller = new $url[0];

        Session::init();

        //checking whether user is allowed to access this page
        if ($this->controller->accessible != "all"){
          if($this->controller->accessible == "loggedin" && !Session::get("loggedin")){
            $view->title = "You need to log in to access this page.";
            $view->render("error/error.php", true, false);
            return;
          }else if($this->controller->accessible == "not_loggedin" && Session::get("loggedin")){
            $view->title = "You need logout to access this page.";
            $view->render("error/error.php", true, false);
            return;
          }
          else if($this->controller->accessible == 'allbutmbmebers' && (!Session::get("loggedin") || Session::user_data("role") == "member" || Session::user_data("role") == "subscriber")){
            $view->render("error/error.php", true, false);
            return;
          }
          else if ($this->controller->accessible == 'admin'){
            if (Session::get("loggedin") && Session::user_data("role") != "admin" || !Session::get("loggedin")){
              $view->render("error/error.php", true, false);
              return;
            }
          }
        }

        $view->title = $this->controller->title;
        $view->css = $this->controller->css;
        $view->js = $this->controller->js;

        $view->data = $this->controller->loadModel($url[0]); //calling the model page of this controller

        if(isset($url[1])){

          if ($url[1] == "ajax"){
            unset($url[0]);
            $url = array_values($url);
            $this->ajax = True;
          }

          if (method_exists($this->controller, $url[1])){
            $this->method = $url[1];
            unset($url[0]);
            unset($url[1]);
            $url = array_values($url);

            $view->data = $this->controller->{$this->method}($url);
          }
          else{
            $this->error($view);
            return;
          }
        }

        $this->params = $url;

        if ($view->data == "notfound"){
          $this->error($view);
          return;
        }

        if ($this->ajax != True){
          if (is_array($view->data) && array_key_exists("access", $view->data) && $view->data["access"] == "denied"){
            $this->error($view);
            return;
          }
          else{
            if (is_array($view->data) && array_key_exists("title", $view->data)){ //if the page has a custom title
              $view->title = $view->data["title"];
            }
            if (is_array($view->data) && array_key_exists("teaser_paragraph", $view->data)){ //if the page has a custom description
              $view->description = $view->data["teaser_paragraph"];
            }
            if (is_array($view->data) && array_key_exists("keywords", $view->data)){ //if the page has akeywords
              $view->keywords = $view->data["keywords"];
            }
            $view->render($this->controller->view, $this->controller->include_footer, $this->controller->include_header);
          }
        }

      }
      else{
        $this->error($view);
        return;
      }
    }
    else{
      if ((isset($url[0]) && count($url) == 1) || !isset($url[0])){
        $url[0] = "home";
        //require_once "controllers/index.php";
        require_once "controllers/".$url[0].".php";

        //$index = new Index("home/".$url[0].".php");

        $this->controller = new $url[0];
        $view->data = $this->controller->loadModel($url[0]);
        $view->data = $this->controller->{$url[0]}();

        $view = new View($view->data,$this->controller->css,$this->controller->js,$this->controller->title);
        $view->render($this->controller->view, $this->controller->include_footer, $this->controller->include_header);
      }
      else{
        $this->error($view);
        return;
      }
    }
  }

  private function error($view){
    $view->title = "404 not found";
    $view->css = array("error");
    $view->render("error/error.php", true, false);
  }
}


?>
