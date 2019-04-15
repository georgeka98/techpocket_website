<div class="channel-info">
  <div class="header-wrapper"><h1 class="title-label"><?php if(isset($this->data["channel_name"])){echo $this->data["channel_name"];}else{echo "TechPocket";} ?> YouTube channel</h1></div>
  <div class="youtube-logo">
    <img style="display: none" src="<?php if(isset($this->data["profile_icon"])){echo $this->data["profile_icon"];}else{echo "#.";} ?>" 
         alt="<?php if(isset($this->data["channel_name"])){echo $this->data["channel_name"];}else{echo "TechPocket";} ?>" />
  </div>
  <div class="label-subtitle">
    <div class="YT_stat_values">
      <div class="YT_stat_ver_centre">
        <!-- <span class="videos-icon"></span> -->
        <p class="YT_stat_value video-count"><?php if(isset($this->data["videos"])){ echo $this->data["videos"];} else{echo "400+";} ?></p>
      </div>
      <div class="YT_stat_ver_centre">
        <!-- <span class="view-icon"></span> -->
        <p class="YT_stat_value view-count"><?php if(isset($this->data["view_count"])){ echo $this->data["view_count"];} else{echo "9000000+";} ?></p>
      </div>
      <div class="YT_stat_ver_centre">
        <!-- <span class="subscribers-icon"></span> -->
        <p class="YT_stat_value subscriber-count"><?php if(isset($this->data["subscribers"])){ echo $this->data["subscribers"];} else{echo "24000+";} ?></p>
      </div>
      <div class="YT_stat_ver_centre">
        <!--<span class="globe-icon"></span>-->
        <div class="region-wrapper"><span class="country-flag-wrapper"><img class="country-flag" src='<?php if(isset($this->data["region"])){ echo BASE_DIR.MEDIA_STORAGE_URL."country-flags/country-flag-".$this->data["region"].".png";} else{echo "UK";} ?>'
              alt='<?php if(isset($this->data["region"])){ echo $this->data["region"];} else {echo "UK";} ?>'/></span></div>
        </div>
    </div>
    <div class="YT_stat_labels">
      <h6 class="YT_stats_label">videos</h6>
      <h6 class="YT_stats_label">views</h6>
      <h6 class="YT_stats_label">subscribers</h6>
      <h6 class="YT_stats_label">region</h6>
    </div>
  </div>
  <div class="note-wrapper"><p class="note">Video fetching from the channel can be slow. If this is the case, check <a href="https://www.youtube.com/channel/UCjtakVAGquXU74GthNKdCYQ" target="_blank">TechPocket</a> here.</p></div>
</div>
<div class="videos-cont" id="videos-list">
  <?php if(isset($this->data["video_list"])){ echo $this->data["video_list"];} ?>
</div>
<div id="loader"></div>
<button id="load_more_videos" data-total-videos="12">Load More +</button>
