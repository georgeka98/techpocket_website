<?php

class View{

  public $title;
  public $description;
  public $keywords;
  public $data;
  public $css;
  public $js;

  function __construct($data = array(), $css = "", $js = "", $title = "", $description = "", $keywords = ""){
    $this->title = $title;
    $this->description = $description;
    $this->keywords = $keywords;
    $this->data = $data;
    $this->css = $css;
    $this->js = $js;
  }

  public function render($path, $render_footer, $render_header){
    include "views/includes/top.php";
    if($render_header == True){
      include "views/includes/header.php";
    }
    else{
      echo '</header>
            <div class="cont container">';
    }
    include "views/".$path;
    if($render_footer == False){
      echo '</div>';
    }
    else if($render_footer == True){
      include "views/includes/footer.php";
    }
    include "views/includes/copyright.php";
  }
}


?>
