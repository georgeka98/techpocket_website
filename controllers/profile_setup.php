<?php

class Profile_setup extends Controller{

  public $view; //page
  public $title; //title of the controller (page)
  public $include_footer; //boolean determining whether the footer of the page should be included;
  public $include_header; //boolean determining whether the header of the page should be included;
  public $css;
  public $js;
  public $accessible;

  public function __construct(){
    $this->title = "Profile Setup";
    $this->view = "profile_setup/profile_setup.php";
    $this->include_header = False;
    $this->include_footer = False;
    $this->css = array("profile_setup");
    $this->js = array("photo_upload");
    $this->accessible = "loggedin";
    if (Session::get("loggedin")){
      echo "404 page not found";
      return;
    }
  }

  public function page($param){
    //print_r($this->model->loadModel("user"));
    if (Session::user_data("profilesetupstatus") == "4"){
      header("location: http://192.168.64.2/mvclearn/user/id/".Session::user_data("ID"));
    }
    $progress = $param[0];
    $this->model->update_progress($progress);
    return array("progress" => $progress);
  }

  public function save_details($param){
    $progress = $param[0];
    header("location: http://192.168.64.2/mvclearn/account/edit/".$progress);
    return array("error_msg" => $this->model->save_details($progress), "progress" => $progress);
    exit();
  }

  public function restore_image(){
    echo $this->model->load("profile");
  }

  public function profile_upload(){
    echo $this->model->img_upload("profile");
  }

  public function load_profile(){
    echo $this->model->save_changes();
  }

}


?>
