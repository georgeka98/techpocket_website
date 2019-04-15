<div class="wrapper">
  <div class="user-info-wrap">
    <div class="user-key-info">
      <div class="profile-pic-wrapper">
        <img src="<?= BASE_DIR.MEDIA_STORAGE_URL."profile_pics/".$this->data["profile_icon"];?>" alt="" class="profile-pic"/>
      </div>
      <div class="key-info">
        <?php if ($this->data["date_joined"]): ?>
        <div class="join-date-wrap">
          <div class="icon-wrapper">
            <span class="join-date-indicator"></span>
          </div>
          <div>
            <p class="join-date"><?=$this->data["date_joined"];?></p>
          </div>
        </div>
        <?php endif;?>
        <?php if ($this->data["firstname"] && $this->data["lastname"]): ?>
        <div class="full-name-wrap">
          <div class="icon-wrapper">
            <span class="full-name-indicator"></span>
          </div>
          <div class="info-wrapper">
            <p class="full-name"><?=$this->data["firstname"]." ".$this->data["lastname"]?></p>
          </div>
        </div>
        <?php endif;?>
        <?php if ($this->data["about_me"]): ?>
        <div class="about-me-wrap">
          <div class="icon-wrapper">
            <span class="about-me-indicator"></span>
          </div>
          <div>
            <p class="about-me"><?= $this->data["about_me"];?></p>
          </div>
        </div>
        <?php endif;?>
        <?php if ($this->data["birthday"] && $this->data["birthday"] != "0000-00-00"): ?>
        <div class="dob-wrap">
          <div class="icon-wrapper">
            <span class="dob-indicator"></span>
          </div>
          <div class="info-wrapper">
            <p class="dob"><?= $this->data["birthday"];?></p>
          </div>
        </div>
        <?php endif;?>
        <?php if ($this->data["country"]): ?>
        <div class="location-wrap">
          <div class="icon-wrapper">
            <span class="location-indicator"></span>
          </div>
          <div class="info-wrapper">
            <p class="location"><?= $this->data["country"];?></p>
            <span class="flag">
              <img class="country-flag" src='<?php echo BASE_DIR.MEDIA_STORAGE_URL."country-flags/country-flag-".$this->data["country-flag"].".png"; ?>'
               alt='<?= $this->data["country"]; ?>'/>
             </span>
          </div>
        </div>
        <?php endif;?>
        <?php if ($this->data["interests"]): ?>
        <div class="occupation-wrap">
          <div class="icon-wrapper">
            <span class="occupation-indicator"></span>
          </div>
          <div class="info-wrapper">
            <p class="occupation"><?= $this->data["interests"];?></p>
          </div>
        </div>
        <?php endif;?>
        <?php if ($this->data["gender"]): ?>
        <div class="gender-wrap">
          <div class="icon-wrapper">
            <span class="gender-indicator"></span>
          </div>
          <div class="info-wrapper">
            <p class="gender"><?= $this->data["gender"];?></p>
          </div>
        </div>
        <?php endif;?>
        <?php if ($this->data["role"]): ?>
        <div class="role-wrap">
          <div class="icon-wrapper">
            <span class="role-indicator"></span>
          </div>
          <div class="info-wrapper">
            <p class="role"><?= $this->data["role"];?></p>
          </div>
        </div>
        <?php endif;?>
        <!-- <div class="email-wrap">
          <div class="icon-wrapper">
            <span class="email-indicator"></span>
          </div>
          <div class="info-wrapper">
            <p class="email"></p>
          </div>
        </div> -->
        <?php if ($this->data["main_website"]): ?>
        <div class="personal-website-wrap">
          <div class="icon-wrapper">
            <span class="personal-website-indicator"></span>
          </div>
          <div class="info-wrapper">
            <a href="http://<?= $this->data["main_website"];?>" class="personal-website"><?= $this->data["main_website"];?></a>
          </div>
        </div>
        <?php endif;?>
        <div class="social-media-wrap">
          <div class="icon-wrapper">
            <span class="social-media-indicator"></span>
          </div>
          <!-- <a href="<?= $this->data["facebook"];?>" class="personal-website"><?= $this->data["facebook"];?></a>
          <a href="<?= $this->data["twitter"];?>" class="personal-website"><?= $this->data["twitter"];?></a>
          <a href="<?= $this->data["google+"];?>" class="personal-website"><?= $this->data["google+"];?></a>
          <a href="<?= $this->data["youtube"];?>" class="personal-website"><?= $this->data["youtube"];?></a> -->
        </div>
      </div>
    </div>
  </div>
  <div class="user-actions-wrap">
    <div class="user-actions">
      <div class="articles">

      </div>
      <div class="all-comments" data-user-id="<?= $this->data["ID"];?>">
        <div class="comments-settings">
          <div class="order">
            <p class="order-par">Order:</p>
            <ul class="comments__options__dropdown order-dropdown">
              <li class="selected__item">
                <button class="button__toggle" data-order="recommended"><span class="option-title">recommended</span></button>
                <ul class="comments__options__dropdown__toggle">
                  <li class="popup__item">
                    <button class="popup__action" data-order="newest"><span class="option-title">newest</span></button>
                  </li>
                  <li class="popup__item">
                    <button class="popup__action" data-order="oldest"><span class="option-title">oldest</span></button>
                  </li>
                  <li class="popup__item">
                    <button class="popup__action" data-order="recommended"><span class="option-title">recommended</span></button>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
          <div class="display">
            <p class="display-par">Display:</p>
            <ul class="comments__options__dropdown display-dropdown">
              <li class="selected__item">
                <button class="button__toggle" data-display="20"><span class="option-title">20</span></button>
                <ul class="comments__options__dropdown__toggle">
                  <li class="popup__item">
                    <button class="popup__action" data-display="5"><span class="option-title">5</span></button>
                  </li>
                  <li class="popup__item">
                    <button class="popup__action" data-display="10"><span class="option-title">10</span></button>
                  </li>
                  <li class="popup__item">
                    <button class="popup__action" data-display="20"><span class="option-title">20</span></button>
                  </li>
                  <li class="popup__item">
                    <button class="popup__action" data-display="40"><span class="option-title">40</span></button>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
          <div class="comment-type">
            <p class="display-par">Type:</p>
            <ul class="comments__options__dropdown type-dropdown">
              <li class="selected__item">
                <button class="button__toggle" data-type="comments"><span class="option-title">Comments</span></button>
                <ul class="comments__options__dropdown__toggle">
                  <li class="popup__item">
                    <button class="popup__action" data-type="comments"><span class="option-title">Comments</span></button>
                  </li>
                  <li class="popup__item">
                    <button class="popup__action" data-type="replies"><span class="option-title">Replies</span></button>
                  </li>
                </ul>
              </li>
            </ul>
  				</div>
          <div class="pages">
            <ul class="comments_pages_list">
            </ul>
          </div>
        </div>
        <div class="comments" data-profile-user-id="<?= $this->data["ID"];?>"></div>
        <div class="comments-settings">
          <div class="pages">
            <ul class="comments_pages_list">
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
