<?php

class Admin extends Controller{

  public $title; //title of the controller (page)
  public $view; //page
  public $include_footer; //boolean determining whether the footer of the page should be included;
  public $include_header; //boolean determining whether the header of the page should be included;
  public $css;
  public $js;
  public $accessible;

  public function __construct(){
    $this->title = "Admin";
    $this->view = "admin/admin.php";
    $this->include_header = False;
    $this->include_footer = False;
    $this->css = array("admin");
    $this->js = array("admin");
    $this->accessible = "admin";
  }

  public function admin(){
    if(isset($_POST["submit"]) && Session::get("loggedin") && Session::get("role") == "admin"){
      echo $this->model->admin_panel();
    }
  }
}
?>
