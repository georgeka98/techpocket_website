<div class="cover">
  <div class="cover-overlay">
    <div class="cont container">
      <h1 class="article-headline headline-title">WELCOME BACK, <?=strtoupper(Session::user_data("firstname"));?>!</h1>
      <h1 class="article-headline headline-subtitle">Ready for your new post?</h1>
    </div>
  </div>
  <div class="cover-img" style="background-image: url('<?=BASE_DIR.MEDIA_STORAGE_URL.BLOG_STORAGE;?>new_post/welcome-bg.jpg')">
  </div>
</div>
<div class="users-list">
  <h2>Users</h2>
  <?php foreach($this->data["users"] as $user): ?>
    <div class="user-item">
      <div class="basic-info">
        <div class="prof-img">
          <img data-pin-nopin class="user-prof" src="<?=BASE_DIR.MEDIA_STORAGE_URL?>profile_pics/<?=$user["profile_icon"]?>"><br>
        </div>
        <div class="full-name-cont">
          <span class="name-location">
            <a href="<?=BASE_DIR?>user/id/<?=$user["ID"]?>"><?=$user["firstname"]?> <?=$user["middlename"]?> <?=$user["lastname"]?></a>
            <img data-pin-nopin class="region-flag" src="<?=BASE_DIR.MEDIA_STORAGE_URL?>country-flags/country-flag-<?=$user["country-flag"]?>.png">
          </span>
          <p class="username"><?=$user["username"]?></p>
          <p class="username"><?=$user["email"]?></p>
        </div>
      </div>
      <div class="role-wrap">
        <p class="role"><?=$user["role"]?></p>
      </div>
    </div>

    <!-- <img data-pin-nopin class="user-prof" src="'.BASE_DIR.MEDIA_STORAGE_URL.'profile_pics/'.$author_prof_icon.'"><br>
    <span class="region-flag-wrapper">
      <img data-pin-nopin class="region-flag" src='.BASE_DIR.MEDIA_STORAGE_URL."country-flags/country-flag-".$author_region_flag.".png".' -->

  <?php endforeach; ?>
</div>
