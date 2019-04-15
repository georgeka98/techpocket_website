<?php

class Universal_model extends Model{

  public function __construct(){
    parent::__construct();
  }

  public function search_results($num_of_results,$phrase){
    header("Content-Type: text/xml");

    $XML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
            <response>';
    $results = $this->most_popular($num_of_results,$phrase);
    if (!empty($results["most_popular"])){
      foreach ($results["most_popular"] as $result) {
        //print_r($result[0][1]);
        $XML .= "<result>";
        $XML .= "<id>".$result[1]['ID']."</id>";
        $XML .= "<thumbnail>".$result[1]['cover-photo']."</thumbnail>";
        $XML .= "<title>".$result[1]['title']."</title>";
        $XML .= "<url>".$result[1]['title_url']."</url>";
        $XML .= "</result>";
      }
    }

    $XML .= '</response>';
    echo $XML;
  }
}

?>
