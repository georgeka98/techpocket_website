<?php

class User_model extends Model{

  public function __construct(){
    parent::__construct();

    $this->data = array(); //stores all user's data
    $this->comments = ""; //stores all the HTML comment list codeßΩΩΩ

  }

  public function get_user_info($user_id){ //getting all user info

    $user = $this->db->prepare("SELECT * FROM users WHERE ID = :id");
    $user->execute(array(':id' => $user_id));
    $info = $user->fetch(PDO::FETCH_ASSOC);

    $info["country-flag"] = $info['country']; //used to get the flag of the country which includes dashes "-"
    $info["country"] = str_replace("-", " ", $info['country']);

    if (empty($info["profile_icon"])){
      $info["profile_icon"] = "default-profile-picture.jpg";
    }

    return $info;
  }

  private function reply_or_root($comm_id, $replied_to_user){ //checking whether comment is root

    if ($comm_id >= 0):
      return '<span class="reply-img"></span>
              <a href="'.BASE_DIR.'user/id/'.$comm_id.'" "="">'.$replied_to_user["username"].'</a>';
    endif;

    return '<span class="wrote-img"></span>';

  }

  private function rating_score($likes, $dislikes){
    $a = 1 + $likes;
    $b = 1 + $dislikes;
    $score = $a/($a+ $b) - 1.65*sqrt(($a*$b)/(($a+$b)*($a+$b)*($a+$b+1)));
    return $score;
  }

  private function bubble_sort_ratings($comments_list){
    $n = count($comments_list);
    while ($n > 0){
      $newn = 0;
      for ($i = 1; $i < $n; $i++){
        if ($this->rating_score($comments_list[$i-1]["likes"],$comments_list[$i-1]["dislikes"]) < $this->rating_score($comments_list[$i]["likes"],$comments_list[$i]["dislikes"])){
          $swap = $comments_list[$i];
          $comments_list[$i] = $comments_list[$i-1];
          $comments_list[$i-1] = $swap;
          $newn = $i;
        }
      }
      $n = $newn;
    }
    return $comments_list;
  }

  public function comments_pages($info){

    $user_id = isset($info[0]) ? $info[0] : "";
    $order = isset($info[1]) ? $info[1] : "";
    $display = isset($info[2]) ? $info[2] : "";
    $type = isset($info[3]) ? $info[3] : "";

    $comments;
    if ($type == "comments"){
      $comments = $this->db->prepare("SELECT * FROM comments WHERE userID = :id");
    }
    else if ($type == "replies"){
      $comments = $this->db->prepare("SELECT * FROM comments WHERE repliedToUserId = :id");
    }
    $comments->execute(array(':id' => $user_id));
    $comments_list = $comments->fetchAll(PDO::FETCH_ASSOC);

    $all_comments = count($comments_list);
    return ceil($all_comments/$info[2]);
  }

  public function get_user_comments($info){ //fetching all comments by user

    $user_id = isset($info[0]) ? $info[0] : "";
    $order = isset($info[1]) ? $info[1] : "";
    $display = isset($info[2]) ? $info[2] : "";
    $type = isset($info[3]) ? $info[3] : "";
    $index = isset($info[4]) ? $info[4] : 0;
    $comments_list = array(); //all comment info

    if ($type == "comments"){
      $comments;
      if ($order == "oldest"){
        $comments = $this->db->prepare("SELECT * FROM comments INNER JOIN blog ON comments.articleID = blog.ID WHERE userID = :id ORDER BY comments.ID ASC LIMIT :amount OFFSET :skip");
      }
      else if($order == "newest"){
        $comments = $this->db->prepare("SELECT * FROM comments INNER JOIN blog ON comments.articleID = blog.ID WHERE userID = :id ORDER BY comments.ID DESC LIMIT :amount OFFSET :skip");
      }
      else{
        $comments = $this->db->prepare("SELECT * FROM comments INNER JOIN blog ON comments.articleID = blog.ID WHERE userID = :id LIMIT :amount OFFSET :skip");
      }
      $comments->execute(array(':id' => $user_id, ':amount' => $display, ':skip' => (($index-1)*$display)));
      $comments_list = $comments->fetchAll(PDO::FETCH_ASSOC);
    }
    else if ($type == "replies"){
      $comments;
      if ($order == "oldest"){
        $comments = $this->db->prepare("SELECT * FROM comments INNER JOIN blog ON comments.articleID = blog.ID WHERE repliedToUserId = :id ORDER BY comments.ID ASC LIMIT :amount OFFSET :skip");
      }
      else if($order == "newest"){
        $comments = $this->db->prepare("SELECT * FROM comments INNER JOIN blog ON comments.articleID = blog.ID WHERE repliedToUserId = :id ORDER BY comments.ID DESC LIMIT :amount OFFSET :skip");
      }
      else{
        $comments = $this->db->prepare("SELECT * FROM comments INNER JOIN blog ON comments.articleID = blog.ID WHERE repliedToUserId = :id LIMIT :amount OFFSET :skip");
      }
      $comments->execute(array(':id' => $user_id, ':amount' => $display, ':skip' => (($index-1)*$display)));
      $comments_list = $comments->fetchAll(PDO::FETCH_ASSOC);
    }

    $user_info = $this->get_user_info($user_id);

    if ($order == "recommended"){
      $comments_list = $this->bubble_sort_ratings($comments_list);
    }

    foreach ($comments_list as $comment){
      // print_r($comment);

      $replied_to_user = array();
      if($comment["repliedToUserId"] > -1){
        $replied_to_user = $this->get_user_info($comment["repliedToUserId"]);
      }

      $reply_or_root = "";
      if ($type == "comments"){
        $reply_or_root = $this->reply_or_root($comment["repliedToUserId"], $replied_to_user);
      }
      else if ($type == "replies"){
        $user_info = $this->get_user_info($comment["userID"]);
        $user_id = $comment["userID"];
        $reply_or_root = $this->reply_or_root($comment["repliedToUserId"], $replied_to_user);
      }

      //print_r($replied_to_user); //debug
      $this->comments .= '<div class="post" id="comment-2" data-comment-id="2" data-comment-author-id="'.$user_id.'">
                  					<div class="comm-rapper">
                              <div class="article-title">
                                <a href="'.BASE_DIR.'blog/article/'.$comment["title_url"].'">'.$comment["title"].'</a>
                              </div>
                  						<div class="opt-wrapper">
                  							<div class="comment-post-head">
                  								<div class="comment-post-info">
                  									<div class="comment-user-info">
                                      <div class="comment-author">
                                        <a href="'.BASE_DIR.'user/id/'.$user_id.'" "="">'.$user_info["username"].'</a>
                                        '.$reply_or_root.':
                                      </div><!-- member type can be: admin, moderator, editor, or just member -->
                  										<div class="posted-date-img"></div>
                                      <span class="date">Jul 27th of 2017</span>
                  									</div>
                                  </div>
                  							</div>
            										<div class="comment comment-post-body">
            											<p id="comment-post-manage-2">'.$comment["comment"].'</p>
            										</div>
            										<div class="options comment-post-foot">
            											<div class="vote-report">
            												<span class="vote-up">
            													<img src="'.BASE_DIR.MEDIA_STORAGE_URL.'vote-up.png">
                                      <p class="total-up-votes">'.$comment["likes"].'</p>
            												</span>
            												<span class="vote-down">
            													<img src="'.BASE_DIR.MEDIA_STORAGE_URL.'vote-down.png">
                                      <p class="total-down-votes">'.$comment["dislikes"].'</p>
            												</span>
            											</div>
            										</div>
            									</div>
            								</div>
            							</div>';
    }

    return $this->comments;

  }

}

?>
