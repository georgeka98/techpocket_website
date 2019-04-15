<div class="global-wrap">
  <div class="top-articles">
    <div class="latest-post">
      <div class="latest-post-wrap teaser_widget" style="background-image: url('<?=BASE_DIR.MEDIA_STORAGE_URL.'/blog/article-'.$this->data['newest'][0]['ID'].'/'.$this->data['newest'][0]['cover-photo'];?>')">
        <div class="overlay"></div>
        <div class="bg-cover">
          <div class="post-info">
            <div class="post-info-cont">
              <p class="widget-article-title"><?=$this->data["newest"][0]["title"];?></p>
              <a href="<?=BASE_DIR?>blog/article/<?=$this->data["newest"][0]["title_url"]?>">READ MORE</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="more-top-articles">
      <div class="more-top-articles-wrap">
        <div class="top-hottest-article teaser_widget" style="background-image: url('<?=BASE_DIR.MEDIA_STORAGE_URL.'/blog/article-'.$this->data['hot'][0]['ID'].'/'.$this->data['hot'][0]['cover-photo'];?>')">
          <div class="overlay"></div>
          <div class="post-info">
            <span class="status-label">HOT</span>
            <p class="widget-article-title side-article-title"><?=$this->data["hot"][0]["title"];?></p>
            <a href="<?=BASE_DIR?>blog/article/<?=$this->data["hot"][0]["title_url"]?>">READ MORE</a>
          </div>
        </div>
        <div class="top-most-popular teaser_widget" style="background-image: url('<?=BASE_DIR.MEDIA_STORAGE_URL.'/blog/article-'.$this->data['most_popular'][0][1]['ID'].'/'.$this->data['most_popular'][0][1]['cover-photo'];?>')">
          <div class="overlay"></div>
          <div class="post-info">
            <span class="status-label">POPULAR</span>
            <p class="widget-article-title side-article-title"><?=$this->data["most_popular"][0][1]["title"];?></p>
            <a href="<?=BASE_DIR?>blog/article/<?=$this->data["most_popular"][0][1]["title_url"]?>">READ MORE</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="articles">
    <div class="posts-list">
      <div class="widget__box latest__articles__horizontal news-articles-wrapper articles__teaser">
        <h2>Latest</h2>
        <div class="ver-article-list">
          <?php foreach ($this->data["newest"] as $article):?>
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
              <a class="article-item-link" href="<?=BASE_DIR?>blog/article/<?=$article["title_url"]?>"></a>
            </div>
          <?php endforeach;?>
        </div>
      </div>
    </div>
    <div class="articles__teaser side__articles__teaser">
      <div class="widget__box teaser-articles hot-articles">
        <div class="hot-articles">
          <h2>Hot Now</h2>
          <div class="ver-article-list">
            <?php foreach ($this->data["newest"] as $article):?>
              <div class="article-link-wrap">
                <a class="article-link" href="<?=BASE_DIR?>blog/article/<?=$article["title_url"];?>">
                  <div class="hot-article-cover-wrap">
                    <img data-pin-nopin class="hot-article-cover" src="<?=BASE_DIR.MEDIA_STORAGE_URL?>blog/article-<?=$article['ID'];?>/<?=$article["cover-photo"];?>"/>
                  </div>
                  <div class="hot-title-wrap">
                    <p class="hot-title"><?=$article["title"];?></p>
                  </div>
                </a>
              </div>
            <?php endforeach;?>
          </div>
        </div>
      </div>
      <!-- <div class="teaser-articles newest-articles">
        <div class="newest-articles">
          <h2>Latest</h2>
          <div class="ver-article-list">
            <?php foreach ($this->data["hot"] as $article):?>
              <div class="article-link-wrap">
                <a class="article-link" href="<?=BASE_DIR?>blog/article/<?=$article["title_url"];?>">
                  <div class="hot-article-cover-wrap">
                    <img data-pin-nopin class="hot-article-cover" src="<?=BASE_DIR.MEDIA_STORAGE_URL?>blog/article-<?=$article['ID'];?>/<?=$article["cover-photo"];?>"/>
                  </div>
                  <div class="hot-title-wrap">
                    <p class="hot-title"><?=$article["title"];?></p>
                  </div>
                </a>
              </div>
            <?php endforeach;?>
          </div>
        </div>
      </div> -->
      <!-- <div class="teaser-articles youtube-videos">
        <div class="latest-videos">
          <h2>Latest videos</h2>
          <div class="ver-videos-list">
            <?php foreach ($this->data["videos"] as $video):?>
              <div class="article-link-wrap">
                <a class="article-link" href="<?=BASE_DIR?>blog/article/<?=$article["title_url"];?>">
                  <div class="hot-article-cover-wrap">
                    <img data-pin-nopin class="hot-article-cover" src="<?=BASE_DIR.MEDIA_STORAGE_URL?>blog/article-<?=$article['ID'];?>/<?=$article["cover-photo"];?>"/>
                  </div>
                  <div class="hot-title-wrap">
                    <p class="hot-title"><?=$article["title"];?></p>
                  </div>
                </a>
              </div>
            <?php endforeach;?>
          </div>
        </div>
      </div> -->
    </div>
  </div>
</div>
