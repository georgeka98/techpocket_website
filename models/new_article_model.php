<?php

class New_article_model extends Model{

  public function __construct(){
    parent::__construct();
  }

  public function submit_article(){
    $src = MEDIA_STORAGE_URL.'blog/article_cover_temp/article-photos-temp-'.Session::user_data("ID");
    if (!empty($_POST['title']) && !empty($_POST['teaser-paragraph']) && !empty($_POST['article']) && !empty($_POST['keywords']) && file_exists($src) && is_dir($src)){
      $title = htmlspecialchars($_POST['title'], ENT_QUOTES, "UTF-8");
      $teaser_paragraph = htmlspecialchars($_POST['teaser-paragraph'], ENT_QUOTES, "UTF-8");
      $article = htmlspecialchars($_POST['article'], ENT_QUOTES, "UTF-8");
      $keywords = htmlspecialchars(str_replace('"', "",$_POST['keywords']), ENT_QUOTES, "UTF-8");

      $submit = $this->db->prepare("INSERT INTO `blog`(`title_url`, `title`, `date-posted`, `teaser_paragraph`, `post`, `authorID`, `cover-photo`, `status`, `keywords`)
                                             VALUES (:title_url, :title, :date_posted, :teaser_paragraph, :post, :authorID, :cover_photo, :status, :keywords)");
      $submit->execute(array(':title_url' => str_replace(' ','-',strtolower(preg_replace('/[^A-Za-z0-9 ]+/','', $title))), ':title' => $title, ':date_posted' => date("Y-m-d H:i:s"), ':teaser_paragraph' => $teaser_paragraph, ':post' => $article, ':authorID' => Session::user_data("ID"), ':cover_photo' => 'cover.jpg', ':status' => 'submitted', ':keywords' => $keywords));
      $user_info = $this->db->lastInsertId();

      //copying the photos from the tmp folder to the article folder

      $ID = $user_info;
      $dst = MEDIA_STORAGE_URL.'blog/article-'.$ID;

      $this->recurse_copy($src,$dst); //copying this article's temp folder to the new article folder
      $this->delete_files($src); //removing the temp folder

      header("Location: ".BASE_DIR."new_article");
    }
  }

  public function img_upload($item){
    return $this->prof_img_uploaded($item);
  }

  public function load($item){
    return $this->load_prof_img($item);
  }

}

?>
