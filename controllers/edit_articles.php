<?php

class Edit_articles extends Controller{

  public $title; //title of the controller (page)
  public $view; //page
  public $include_footer; //boolean determining whether the footer of the page should be included;
  public $include_header; //boolean determining whether the header of the page should be included;
  public $css;
  public $js;
  public $accessible;

  public function __construct(){
    $this->title = "Edit Articles";
    $this->view = "edit_articles/edit_articles.php";
    $this->include_header = False;
    $this->include_footer = False;
    $this->css = array("articles","edit_articles");
    $this->js = array("edit_articles","article_keywords_system");
    $this->accessible = "editor";
  }

  public function edit_articles(){
    if(Session::get("loggedin") && (Session::user_data("role") == "editor" || Session::user_data("role") == "admin")){
      return $this->model->submitted();
    }
  }

  public function submit_edit(){
    if(isset($_POST["submit"]) && Session::get("loggedin") && (Session::user_data("role") == "editor" || Session::user_data("role") == "admin")){
      return $this->model->submit();
    }
  }
}
?>
