<div class="cover">
  <div class="cover-overlay">
    <div class="cont container">
      <h1 class="article-headline headline-title">WELCOME BACK, <?=strtoupper(Session::user_data("firstname"));?>!</h1>
      <h1 class="article-headline headline-subtitle">Ready to edit submitted articles?</h1>
    </div>
  </div>
  <div class="cover-img" style="background-image: url('<?=BASE_DIR.MEDIA_STORAGE_URL.BLOG_STORAGE;?>new_post/welcome-bg.jpg')">
  </div>
</div>
<div class="articles">
  <div class="ver-article-list">
    <div class="widget__box news-articles-wrapper latest__articles__horizontal articles__teaser">
      <h2>Submitted articles</h2>
      <div class="ver-article-list">
        <?php if ($this->data["submitted_articles"] != "empty"): ?>
        <?php foreach ($this->data["submitted_articles"] as $article):?>
          <div class="column-item-cont">
            <div class="column-item row-item">
              <div class="item-img-cover">
                <img data-pin-nopin class="article-item-cover" src="<?=BASE_DIR.MEDIA_STORAGE_URL?>blog/article-<?=$article['ID'];?>/<?=$article["cover-photo"];?>"/>
              </div>
              <div class="item-body">
                <div class="article-item-title">
                  <p class="article-title">
                    <?=$article["title"];?>
                  </p>
                  <p class="article-text">
                      <?=$article["post"];?>
                    </p>
                  </div>
                  <span class="body-separator"></span>
                  <div class="article-item-author">
                    <div class="item-author-profile-pic">
                      <img data-pin-nopin data-pin-nopin class="author-prof" src="<?=BASE_DIR.MEDIA_STORAGE_URL?>profile_pics/<?=$article["profile_icon"];?>"/>
                    </div>
                    <div class="item-author-info">
                      <p class="full-name"><?=$article["firstname"]." ".$article["lastname"];?></p>
                      <p class="date-posted"><?=$article["date-posted"];?></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="article-preview-info">
                <form class="article-edit-form" action="edit_articles/submit_edit" method="post">
                  <input class="title-edited" type="hidden" name="title-edited" value='<?=$article["title"];?>'>
                  <input class="text-edited" type="hidden" name="text-edited" value='<?=$article["post"];?>'>
                  <input class="teaser-paragraph-edited" type="hidden" name="teaser-paragraph-edited" value='<?=$article["teaser-paragraph"];?>'>
                  <input class="article_id" type="hidden" name="article_id" value='<?=$article["ID"];?>'>
                  <div class="edit-title edit__info" dir="ltr" contenteditable="true">
                      <?=$article["title"];?>
                  </div>
                  <div class="edit-teaser-paragraph edit__info" dir="ltr" contenteditable="true">
                      <?=$article["teaser_paragraph"];?>
                  </div>
                  <div class="edit-text edit__info" dir="ltr" contenteditable="true">
                      <?=$article["post"];?>
                  </div>
                  <div class="keywords-tags">
                    <input class="keywords_list" type="hidden" name="keywords-edited" value='"<?=implode('","',explode(',',$article["keywords"]));?>"'>
                    <div class="blog-tags edit__info" role="list" aria-label="Tags added" dir="ltr" contenteditable="false" placeholder="Phone 9 rumors, Windows 10 optimization">
                      <?php $keywrods_arr = explode(",",$article["keywords"]); ?>
                      <?php foreach($keywrods_arr as $keyword):?>
                        <?php if(!empty($keyword)):?>
                          <span class="keyword">
                            <?=$keyword;?>
                            <span class="remove_tag">X</span>
                          </span>
                        <?php endif; ?>
                      <?php endforeach;?>
                      <input class="add-tag" type="text" class="keywords_list" value="">
                    </div>
                  </div>
                  <input type="submit" name="submit" class="submit-edits" value="Publish"/>
                </form>
              </div>
              <!-- <a class="article-item-link" href="<?=BASE_DIR?>blog/article/<?=$article["title_url"]?>"></a> -->
            </div>
          <?php endforeach;?>
        <?php else:?>
          <p style="text-align: center">There are no submitted articles right now. Check back later.<p>
        <?php endif;?>
      </div>
    </div>
  </div>
</div>
