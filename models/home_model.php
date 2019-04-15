<?php

class Home_model extends Model{

  public function __construct(){
    parent::__construct();
  }

  public function home_widgets($num_of_posts){
    return $this->hot_articles(0,6) + $this->latest_articles(0,10) + $this->most_popular(5);
  }
}

?>
