<?php

class Profile_setup_model extends Model{

  public function __construct(){
    parent::__construct();
    $this->id = Session::user_data("ID");
  }

  public function save_details($page){
    $this->save_updates($page);
  }

  public function update_progress($page){

    $user = $this->db->prepare("SELECT * FROM users WHERE ID = :id");
    $user->execute(array(':id' => $this->id));
    $info = $user->fetch(PDO::FETCH_ASSOC);

    if ($info["profilesetupstatus"] < $page){
      $user = $this->db->prepare("UPDATE users SET profilesetupstatus=:profilesetupstatus WHERE ID=:id");
      $user->execute(array(":profilesetupstatus" => $page, ':id' => $this->id));
      $info["profilesetupstatus"] = $page;
    }

    Session::update_all_data($info);
  }

  public function load($item){
    return $this->load_prof_img($item);
  }

  public function img_upload($item){
    return $this->prof_img_uploaded($item);
  }

  public function save_changes(){
    return $this->save_prof_img_changes();
  }

}


?>
