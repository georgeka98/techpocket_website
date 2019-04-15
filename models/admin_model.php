<?php

class Admin_model extends Model{

  public function __construct(){
    parent::__construct();
    return $this->data();
  }

  public function data(){
    return $this->all_users_shorted(array("admin", "moderator", "editor", "author", "member", "users"), "users");
  }

}

 ?>
