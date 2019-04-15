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
<div class="container cont">
  <form action="new_article/submit" class="article-info-settings" method="POST">
    <div class="form-wrap">
      <div class="post-cont-wrapper">
        <input type="file" accept="image/x-png,image/jpeg,image/jpg" id="cover-select" name="file-select">
        <input type="button" id="upload-cover-btn" value="Upload Image" name="submit">
        <canvas width="480" height="300" id="img-preview">
        </canvas>
        <h3 id="status"></h3>
        <p id="loaded_n_total"></p>
        <div class="settings">
          <button id="zoom-in">+</button>
          <button id="zoom-out">-</button>
        </div>
        <div class="headlines">
          <div class="title-wrapper">
            <label class="title-label" for="post-title">Title</label><span>?<br>
            <input class="post-title" name="title" type="text" placeholder="Title" name="title" autocomplete="off"/>
          </div>
          <div class="teaser-wrapper">
            <label class="teaser-label" for="post-teaser">Teaser paragraph</label>?<br>
            <input class="post-teaser" name="teaser-paragraph" type="text" placeholder="Teaser Paragraph" name="teaser" autocomplete="off"/>
          </div>
        </div>
        <div class="post-body">
          <div class="post-wrapper">
            <label class="content-label" for="post-content">Content</label>?<br>
            <textarea class="post-content" type="text" placeholder="Article goes here" name="article" autocomplete="off"></textarea>
          </div>
        </div>
      </div>
      <div class="settings-wrapper">
        <!-- <div class="categories">

        </div> -->
        <div class="keywords-tags">
          <label class="teaser-label" for="blog-tags">Keywords</label>?<br>
          <input class="keywords_list" type="hidden" name="keywords" value="">
          <div class="blog-tags" role="list" aria-label="Tags added" dir="ltr" contenteditable="false" placeholder="Phone 9 rumors, Windows 10 optimization">
            <input class="add-tag" type="text" placeholder="iPhone 9 rumors, Windows 10 optimization" value="">
          </div>
        </div>
      </div>
    </div>
    <input type="submit" class="submit" name="submit" value="Submit" />
    <input type="button" class="preview" name="preview" value="Preview" title="See how your article will look like" />
  </form>
</div>

<!-- <div class="video-settings-tag-chips-container yt-uix-form-input-textarea tb-tagautocomplete-element" role="list" aria-label="Tags added" dir="ltr">

    <span class="yt-uix-form-input-placeholder-container">

        <span class="yt-uix-form-input-placeholder">
            Tags (e.g., albert einstein, flying pig, mashup)
        </span>
    </span>
    <input class="yt-focusable-invisible-input" aria-hidden="true"/>
      <span class="yt-chip" title="techpocket" role="listitem" tabindex="-1">
        <img class="tb-upload-search-icon" src="chrome-extension://mhkhmbddkmdggbhaaaodilponhnccicb/images/icons/search.png" style="height: 12px; opacity: .5; margin-right: 3px; position: relative; top: 2px;">
        <span>techpocket</span>
        <span class="yt-delete-chip" role="button" aria-label="Remove Tag techpocket" tabindex="0"></span>
      </span>
      <span style="position: absolute; left: 430px; opacity: 0.7; display: none;" class="tb-emoji-toggle">
        <img src="https://www.tubebuddy.com/images/modules/emoji/face.png" style=" cursor:pointer; position:relative; top:5px;"></span>
        <span class="yt-chip" title="adf" role="listitem" tabindex="-1">
          <img class="tb-upload-search-icon" src="chrome-extension://mhkhmbddkmdggbhaaaodilponhnccicb/images/icons/search.png" style="height: 12px; opacity: .5; margin-right: 3px; position: relative; top: 2px;">
          <span>adf</span>
          <span class="yt-delete-chip" role="button" aria-label="Remove Tag adf" tabindex="0"></span>
        </span>
        <span style="position: absolute; left: 430px; opacity: 0.7; display: none;" class="tb-emoji-toggle">
          <img src="https://www.tubebuddy.com/images/modules/emoji/face.png" style=" cursor:pointer; position:relative; top:5px;"></span>
          <span class="yt-chip" title="dsa" role="listitem" tabindex="-1">
            <img class="tb-upload-search-icon" src="chrome-extension://mhkhmbddkmdggbhaaaodilponhnccicb/images/icons/search.png" style="height: 12px; opacity: .5; margin-right: 3px; position: relative; top: 2px;"><span>dsa</span><span class="yt-delete-chip" role="button" aria-label="Remove Tag dsa" tabindex="0"></span></span><span style="position: absolute; left: 430px; opacity: 0.7; display: none;" class="tb-emoji-toggle"><img src="https://www.tubebuddy.com/images/modules/emoji/face.png" style=" cursor:pointer; position:relative; top:5px;"></span><span style="position: absolute; left: 430px; opacity: 0.7; display: none;" class="tb-emoji-toggle"><img src="https://www.tubebuddy.com/images/modules/emoji/face.png" style=" cursor:pointer; position:relative; top:5px;"></span>
    <div class="tb-tagautocomplete-menu-container" style="background-color: white; position: absolute; z-index: 10000; left: 4px; top: 65px; display: none;" id="tb-tagautocomplete-menu">
        <div class="tb-tagautocomplete-header"> <img src="chrome-extension://mhkhmbddkmdggbhaaaodilponhnccicb/images/branding/icon_large.png" style="height: 16px; vertical-align: middle; margin-right: 2px;"> <span style="vertical-align: middle; font-size: 13px;margin-left:5px;">Related Search Terms</span>
            <div title="close" class="tb-tagautocomplete-header-right"><a class="tb-move-up2 tb-margin-right10" style="vertical-align: middle;text-decoration: none;" target="_blank" href="http://localhost:7265/tools?tool=instasuggest"><img src="chrome-extension://mhkhmbddkmdggbhaaaodilponhnccicb/images/icons/question.png" title="help" style="height: 18px; vertical-align: middle;"></a><img src="chrome-extension://mhkhmbddkmdggbhaaaodilponhnccicb/images/icons/close4.png" style="height: 16px; vertical-align: middle; margin-right: 2px;"></div>
        </div>
        <div class="tb-tagautocomplete-menu-items"><span title="add tag" class="tb-tagautocomplete-menu-item tb-tagautocomplete-tag" data-disabled="false" data-tag="asda"><img class="tb-tagautocomplete-menu-item-image" src="chrome-extension://mhkhmbddkmdggbhaaaodilponhnccicb/images/icons/add.png"> <span class="tb-tagautocomplete-menu-item-text">asda</span></span><br> <span title="add tag" class="tb-tagautocomplete-menu-item tb-tagautocomplete-tag" data-disabled="false" data-tag="asdasd"><img class="tb-tagautocomplete-menu-item-image" src="chrome-extension://mhkhmbddkmdggbhaaaodilponhnccicb/images/icons/add.png"> <span class="tb-tagautocomplete-menu-item-text">asdasd</span></span><br> <span title="add tag" class="tb-tagautocomplete-menu-item tb-tagautocomplete-tag" data-disabled="false" data-tag="asdsadsadsa"><img class="tb-tagautocomplete-menu-item-image" src="chrome-extension://mhkhmbddkmdggbhaaaodilponhnccicb/images/icons/add.png"> <span class="tb-tagautocomplete-menu-item-text"><span style="font-weight:normal !important">asdsa</span>dsadsa</span></span><br> </div>
        <div class="tb-tagautocomplete-menu-upgrade" style="display: block;">
            <div class="tb-tagautocomplete-menu-upgrade-text"><img src="chrome-extension://mhkhmbddkmdggbhaaaodilponhnccicb/images/icons/lock.png" style="position:relative; top:3px;"> Only <span class="tb-tagautocomplete-menu-upgrade-shown">3</span> of <span class="tb-tagautocomplete-menu-upgrade-total">10</span> total results are shown. <br> Upgrade your license to view them all. <br> <a style="cursor:pointer; font-weight:500; padding:2px 0 5px" class="tb-tagautocomplete-menu-upgrade-upgrade-link">UPGRADE NOW!</a></div> <img class="tb-tagautocomplete-menu-upgrade-img" src="chrome-extension://mhkhmbddkmdggbhaaaodilponhnccicb/images/screenshots/instasuggestblur.png">
        </div>
        <div class="tb-tagautocomplete-footer">
            <div class="tb-margin-right5 " style="text-align:left"> <span> <button class="tb-button tb-button-default tb-tagautocomplete-tag-explorer">EXPLORE</button> this tag in depth...</span> </div>
            <div style="text-align:left" class="tb-margin-right5 tb-margin-top5"> <span><button class="tb-button tb-button-default tb-tagautocomplete-suggested-tags">SUGGEST</button> more tags for this video...</span> </div>
        </div>
        <div style="background-color: #ddd;font-size: 11px;padding: 4px 4px;font-weight: 500;text-align: center;background-color: rgb(240, 240, 240);border-top: solid 1px #ddd;">* Make sure to only select Tags RELEVANT to this video *</div>
    </div><span class="yt-chip" title="fdsaf" role="listitem" tabindex="-1"><img class="tb-upload-search-icon" src="chrome-extension://mhkhmbddkmdggbhaaaodilponhnccicb/images/icons/search.png" style="height: 12px; opacity: .5; margin-right: 3px; position: relative; top: 2px;"><span>fdsaf</span><span class="yt-delete-chip" role="button" aria-label="Remove Tag fdsaf" tabindex="0"></span></span><span style="position: absolute; left: 430px; opacity: 0.7; display: none;" class="tb-emoji-toggle"><img src="https://www.tubebuddy.com/images/modules/emoji/face.png" style=" cursor:pointer; position:relative; top:5px;"></span><span style="position: absolute; left: 430px; opacity: 0.7; display: none;" class="tb-emoji-toggle"><img src="https://www.tubebuddy.com/images/modules/emoji/face.png" style=" cursor:pointer; position:relative; top:5px;"></span><span class="yt-chip" title="asdsa" role="listitem" tabindex="-1"><img class="tb-upload-search-icon" src="chrome-extension://mhkhmbddkmdggbhaaaodilponhnccicb/images/icons/search.png" style="height: 12px; opacity: .5; margin-right: 3px; position: relative; top: 2px;"><span>asdsa</span><span class="yt-delete-chip" role="button" aria-label="Remove Tag asdsa" tabindex="0"></span></span><span style="position:absolute; left:430px; opacity:.7" class="tb-emoji-toggle"><img src="https://www.tubebuddy.com/images/modules/emoji/face.png" style=" cursor:pointer; position:relative; top:5px;"></span><input class="video-settings-add-tag" spellcheck="false" autocomplete="false" aria-haspopup="true" placeholder="" data-ita-enable="true" aria-label="Tags help viewers find your videos and discover your channel. Want to add some tags?" style="width: 297px;">
</div> -->
