<?php

  Session::init();

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title><?=$this->title?></title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link href="<?= BASE_DIR?>views/css/main.sass" rel="stylesheet" type="text/css"/>
    <link href="<?= BASE_DIR?>views/css/normalize.css" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php foreach ($this->css as $shylesheet): ?>
      <?php if (!empty($shylesheet)): ?>
        <link href="<?=BASE_DIR?>views/css/<?=$shylesheet;?>.css" rel="stylesheet" type="text/css"/>
      <?php endif;?>
    <?php endforeach;?>
    <link rel="icon" type="image/png" href="<?=BASE_DIR.MEDIA_STORAGE_URL?>techpocket_favicon.png">

    <meta name="thumbnail" content="<?=BASE_DIR.MEDIA_STORAGE_URL?>images/article-<?=$this->data["ID"]?>/<?=$this->data["cover-photo"]?>">
    <meta name="description" content="<?php $description = isset($this->description) ? $this->description : ""; echo $description;?>">
    <meta name="keywords" content="<?php $keywords = isset($this->keywords) ? $this->keywords.",".WEBSITE_NAME : WEBSITE_NAME; echo $keywords;?>">
    <meta name="author" content="<?=$this->data["firstname"]." ".$this->data["lastname"];?>">
    <!-- <meta http-equiv="refresh" content="30"> -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'
      https://www.facebook.com https://www.youtube.com https://fonts.googleapis.com https://cdnjs.cloudflare.com http://assets.pinterest.com;
      script-src http://assets.pinterest.com https://connect.facebook.net 'self';
      connect-src 'self';
      img-src 'self';
      style-src 'self' 'unsafe-inline';
      object-src 'none';">
      <!-- MUST DO look up what the 'strict-dynamic' does to script-src -->
  </head>
  <body oncopy="return false" oncut="return false" onpaste="return false">
    <script>
  //if CSP is supported this will not run
  window.onload=function(){
      var jsNode = document.getElementById("jsNode");
      jsNode.innerHTML = "<h3> CSP Not Supported</h3> Your browser does not support CSP, the inline script executed and replaced this div content";
      jsNode.className = "alert alert-danger";
  };
</script>
<div id="jsNode"></div>
    <header>
      <section class="top">
        <div class="cont cont-top">
          <span class="social">
            <!-- <a href="https://www.facebook.com/techpocketofficial"><img src="<?=MEDIA_STORAGE_URL?>fb.png" alt="FB" class="facebook"></a>
            <a href="https://twitter.com/techpocket1"><img src="<?=MEDIA_STORAGE_URL?>twitter.png" alt="T" class="twitter"></a>
            <a href="https://plus.google.com/+techpocketvideo"><img src="<?=MEDIA_STORAGE_URL?>g+.png" alt="G" class="google_plus"></a> -->
            <a href="https://www.facebook.com/techpocketofficial" target="_blank"><img data-pin-nopin="true" src="<?=BASE_DIR.MEDIA_STORAGE_URL?>/soc_med_icons/facebook.png" alt="FB" class="fb-logo"></a>
            <a href="https://twitter.com/techpocket1" target="_blank"><img data-pin-nopin="true" src="<?=BASE_DIR.MEDIA_STORAGE_URL?>/soc_med_icons/twitter.png" alt="T" class="twitter-logo"></a>
            <a href="https://plus.google.com/+techpocketvideo" target="_blank"><img data-pin-nopin="true" src="<?=BASE_DIR.MEDIA_STORAGE_URL?>/soc_med_icons/google+.png" alt="Google+" class="google-logo"></a>
          </span>
          <span class="join">
            <?php if (Session::get("loggedin") == False): ?>
            <a href="<?= BASE_DIR?>login" class="login">Log in</a>
            <a href="<?= BASE_DIR?>signup" class="signup">Sign up</a>
            <?php else: ?>
            <a id="account"><?=Session::user_data("firstname")." ".Session::user_data("lastname")?></a>
            <div id="js-profile-popup">
  						<ul id="profile-popup-options">
  							<li class="view_profile bottom-border"><a href="<?= BASE_DIR?>user/id/<?=Session::user_data("ID")?>">View profile</a>
  							</li><li class="edit-profile bottom-border"><a href="<?= BASE_DIR?>account/edit/1">Edit profile</a>
                <?php if (Session::user_data("role") == "admin" || Session::user_data("role") == "editor" || Session::user_data("role") == "author"): ?>
                  </li><li class="new-post bottom-border"><a href="<?= BASE_DIR?>new_article">New Post</a>
                <?php endif; ?>
                <?php if (Session::user_data("role") == "admin" || Session::user_data("role") == "editor"): ?>
                  </li><li class="new-post bottom-border"><a href="<?= BASE_DIR?>edit_articles">Edit Posts</a>
                <?php endif; ?>
                <?php if (Session::user_data("role") == "admin"): ?>
                  </li><li class="new-post bottom-border"><a href="<?= BASE_DIR?>admin">Admin</a>
                <?php endif; ?>
  							</li><li class="logout"><a href="<?= BASE_DIR?>logout">Log out</a>
  						</ul>
  					</div>
            <a href="<?= BASE_DIR?>logout" class="logout">Log out</a>
            <?php endif; ?>
          </span>
        </div>
      </section>
