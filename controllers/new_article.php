<?php

class New_article extends Controller{

  public $title; //title of the controller (page)
  public $view; //page
  public $include_footer; //boolean determining whether the footer of the page should be included;
  public $include_header; //boolean determining whether the header of the page should be included;
  public $css;
  public $js;
  public $accessible;

  public function __construct(){
    $this->title = "Create New Post";
    $this->view = "new_article/new_article.php";
    $this->include_header = False;
    $this->include_footer = False;
    $this->css = array("new_article");
    $this->js = array("article_keywords_system","photo_upload");
    $this->accessible = "allbutmembers";
  }

  public function submit(){
    if(isset($_POST["submit"]) && Session::get("loggedin") && (Session::user_data("role") == "author" || Session::user_data("role") == "editor" || Session::user_data("role") == "admin")){
      echo $this->model->submit_article();
    }
  }

  public function cover_upload(){
    echo $this->model->img_upload("cover");
  }

  public function cover_restore(){
    echo $this->model->load("cover");
  }
}

?>
