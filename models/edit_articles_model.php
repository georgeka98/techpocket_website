<?php

class Edit_articles_model extends Model{

  public function __construct(){
    parent::__construct();
    return $this->data();
  }

  public function data(){
    return $this->submitted_articles();
  }

  private function submitted_articles(){

    $submitted_articles = $this->db->prepare("SELECT * FROM blog WHERE status = 'submitted'");
    $submitted_articles->execute();
    $results = $submitted_articles->fetchAll(PDO::FETCH_ASSOC);

    $new_results = array();

    foreach($results as $article){ //updates the results by adding the full name of the author
      $user = $this->db->prepare("SELECT firstname, lastname, profile_icon FROM users WHERE ID = :id");
      $user->execute(array(':id' => $article["authorID"]));
      $info = $user->fetch(PDO::FETCH_ASSOC);
      $article["keywords"] = trim($article["keywords"]);

      array_push($new_results, $article + $info);
    }

    if (empty($new_results)){
      return array("submitted_articles" => "empty");
    }

    return array("submitted_articles" => $new_results);
  }

  public function submit(){
    $title_url = str_replace(' ','-',strtolower(trim(preg_replace('/[^A-Za-z0-9 ]+/','', $_POST["title-edited"]))));
    $keywords = preg_replace('/"+/','', $_POST["keywords-edited"]);
    $post_date = date("Y-m-d H:i:s");
    $blog_ID = $_POST["article_id"];

    $submitted_articles = $this->db->prepare("UPDATE `blog`
                                              SET `title_url` = :title_url, `title` = :title, `date-posted` = :date_posted, `teaser_paragraph` = :teaser_paragraph, `post` = :post, `keywords` = :keywords, `status` = :status
                                              WHERE `ID` = :ID");
    $submitted_articles->execute(array(':title_url' => $title_url, ':title' => $_POST["title-edited"], ':date_posted' => $post_date, ':teaser_paragraph' => trim($_POST["teaser-paragraph-edited"]), ':post' => trim($_POST["text-edited"]), ':keywords' => $keywords, ':status' => 'published', ':ID' => $blog_ID));

    header("Location: ".BASE_DIR."edit_articles");
  }

}


?>
