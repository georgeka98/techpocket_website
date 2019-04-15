<?php

class Account_model extends Model{

  public function __construct(){
    parent::__construct();
    $this->id = Session::user_data("ID");
  }

  public function save_details($page){
    return $this->save_updates($page);
  }

}


?>
