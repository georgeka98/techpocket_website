<div class="cover">
  <div class="cover-overlay">
    <div class="cont container">
      <h1 class="article-headline headline-title">Here, yes here! Meet us!</h1>
      <h1 class="article-headline headline-subtitle">Meet what is going on behind <?=WEBSITE_NAME?>!</h1>
    </div>
  </div>
  <div class="cover-img" style="background-image: url('<?=BASE_DIR.MEDIA_STORAGE_URL.BLOG_STORAGE;?>about/about-us-bg.jpg')">
  </div>
</div>
<div class="quote">
  <p class="quote-paragraph">“A customer won't care about your hard work, but the quality of service you'll provide”</p>
</div>
<div class="who-are-we">
  <p class="who-are-we-par">Our mission is to make your life simpler and avoid seing technology as impossible to understand as well
    as make businesses more successfull by helping them promote their products. We love what we do and helping people out and always
    will. If you appreciate our work and effort and waht to help us too, why not <a href="<?=BASE_DIR?>support">support</a> us? </p>
</div>
<div class="team">
  <h1>Meet The Passionative Team</h1>
  <div class="items-list">
    <?php foreach($this->data["team"] as $member): ?>
      <div class="member-item">
        <div class="profile-item">
          <a href="http://192.168.64.2/mvclearn/about/<?=str_replace(" ", "-",preg_replace("/[^a-zA-Z ]/", "", $member["firstname"]." ".$member["lastname"]))?>" class="profile-item-images">
            <img class="profile-item-img" src="<?=BASE_DIR.MEDIA_STORAGE_URL?>/profile_pics/<?=$member["profile_icon"]?>" alt="<?=$member["firstname"]." ".$member["lastname"]?>">
          </a>
        </div>
        <div class="profile-item-text">
          <div class="full-name-region-wrap">
            <div class="full-name-region">
              <a class="full-name" href="http://192.168.64.2/mvclearn/about/<?=str_replace(" ", "-",preg_replace("/[^a-zA-Z ]/", "", $member["firstname"]." ".$member["lastname"]))?>">
               <?=$member["firstname"]." ".$member["lastname"]?></a>
              <span class="region-flag-wrapper">
            <img data-pin-nopin class="region-flag" src="http://192.168.64.2/mvclearn/storage/images/country-flags/country-flag-<?=$member["country-flag"]?>.png" title="<?=$member["country"]?>" alt="<?=$member["country"]?>"></span>
            </div>
          </div>
          <p class="about_me"><?=$member["about_me"]?></p>
          <ul class="profile-item-social social">
            <li class="facebook">
               <!-- <a href="http://twitter.com/madebyshape" title="" target="_blank" class="js-focus-link colour-background-twitter colour-fill-light">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="15 15 35 35">
                     <path fill="#010002" d="M41.507 26.916c-.66.293-1.373.493-2.12.582.762-.458 1.347-1.182 1.623-2.043-.714.423-1.505.73-2.348.897-.675-.72-1.635-1.167-2.698-1.167-2.04 0-3.694 1.654-3.694 3.694 0 .29.03.57.095.84-3.07-.156-5.794-1.627-7.617-3.86-.318.542-.5 1.18-.5 1.854 0 1.282.654 2.414 1.644 3.075-.604-.02-1.174-.188-1.674-.464v.047c0 1.79 1.274 3.283 2.964 3.623-.31.082-.635.13-.972.13-.238 0-.47-.024-.697-.07.47 1.47 1.835 2.538 3.45 2.566-1.263.992-2.858 1.58-4.59 1.58-.296 0-.59-.018-.88-.05 1.636 1.05 3.58 1.66 5.666 1.66 6.795 0 10.51-5.63 10.51-10.513l-.013-.478c.724-.516 1.353-1.166 1.846-1.907z"></path>
                  </svg>
               </a> -->
               <a href="https://www.facebook.com/techpocketofficial" target="_blank"><img src="<?=BASE_DIR.MEDIA_STORAGE_URL?>/soc_med_icons/facebook.png" alt="FB" class="fb-logo"></a>
            </li>
            <li class="twitter">
              <!-- <a href="http://twitter.com/madebyshape" title="" target="_blank" class="js-focus-link colour-background-twitter colour-fill-light">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="15 15 35 35">
                    <path fill="#010002" d="M41.507 26.916c-.66.293-1.373.493-2.12.582.762-.458 1.347-1.182 1.623-2.043-.714.423-1.505.73-2.348.897-.675-.72-1.635-1.167-2.698-1.167-2.04 0-3.694 1.654-3.694 3.694 0 .29.03.57.095.84-3.07-.156-5.794-1.627-7.617-3.86-.318.542-.5 1.18-.5 1.854 0 1.282.654 2.414 1.644 3.075-.604-.02-1.174-.188-1.674-.464v.047c0 1.79 1.274 3.283 2.964 3.623-.31.082-.635.13-.972.13-.238 0-.47-.024-.697-.07.47 1.47 1.835 2.538 3.45 2.566-1.263.992-2.858 1.58-4.59 1.58-.296 0-.59-.018-.88-.05 1.636 1.05 3.58 1.66 5.666 1.66 6.795 0 10.51-5.63 10.51-10.513l-.013-.478c.724-.516 1.353-1.166 1.846-1.907z"></path>
                 </svg>
              </a> -->
              <a href="https://twitter.com/techpocket1" target="_blank"><img src="<?=BASE_DIR.MEDIA_STORAGE_URL?>/soc_med_icons/twitter.png" alt="T" class="twitter-logo"></a>
           </li>
            <li class="instagram">
              <!-- <a href="http://instagram.com/madebyshape" title="" target="_blank" class="js-focus-link colour-background-instagram colour-fill-light">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="6.75 6.75 57 57">
                    <path d="M23.523 19.473h23.454c2.23 0 4.05 1.65 4.05 4.05v23.455c0 2.4-1.82 4.05-4.048 4.05H23.52c-2.228 0-4.05-1.65-4.05-4.05V23.52c0-2.398 1.822-4.047 4.05-4.047zm18.936 3.505c-.78 0-1.42.64-1.42 1.42v3.4c0 .782.64 1.42 1.42 1.42h3.56c.78 0 1.42-.64 1.42-1.42v-3.4c0-.782-.64-1.42-1.42-1.42h-3.56zm5 9.838h-2.78c.26.86.403 1.768.403 2.708 0 5.248-4.393 9.503-9.81 9.503-5.416 0-9.807-4.253-9.807-9.5 0-.943.142-1.85.405-2.71h-2.9V46.15c0 .688.564 1.254 1.254 1.254H46.2c.69 0 1.253-.565 1.253-1.255V32.81zM35.28 29.04c-3.5 0-6.337 2.75-6.337 6.14 0 3.394 2.836 6.142 6.338 6.142 3.5 0 6.34-2.747 6.34-6.14s-2.84-6.142-6.34-6.142z"></path>
                 </svg>
              </a> -->
              <a href="https://plus.google.com/+techpocketvideo" target="_blank"><img src="<?=BASE_DIR.MEDIA_STORAGE_URL?>/soc_med_icons/insta.png" alt="Google+" class="google-logo"></a>
           </li>
            <li class="linkedin">
              <!-- <a href="https://www.linkedin.com/in/andygolpys" title="" target="_blank" class="js-focus-link colour-background-linkedin colour-fill-light">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="20.5 20.5 61 61">
                    <path d="M70.332 55.18v14.293h-8.287V56.137c0-3.352-1.197-5.638-4.2-5.638-2.288 0-3.65 1.54-4.25 3.03-.218.533-.274 1.273-.274 2.02v13.924h-8.29s.115-22.59 0-24.93h8.29v3.533c-.015.025-.036.054-.052.08h.055v-.08c1.103-1.698 3.067-4.12 7.472-4.12 5.452-.002 9.54 3.56 9.54 11.22zM36.358 32.526c-2.835 0-4.69 1.86-4.69 4.306 0 2.393 1.8 4.31 4.58 4.31h.056c2.89 0 4.688-1.916 4.688-4.31-.055-2.446-1.798-4.306-4.634-4.306zM32.16 69.473h8.287v-24.93H32.16v24.93z"></path>
                 </svg>
              </a> -->
              <a href="https://plus.google.com/+techpocketvideo" target="_blank"><img src="<?=BASE_DIR.MEDIA_STORAGE_URL?>/soc_med_icons/linkedin.png" alt="Google+" class="google-logo"></a>
           </li>
          </ul>
        </div>
      </div>
    <?php endforeach;?>
  </div>
</div>

<!-- <div class="profile-item-statistics">
  <a href="" class="profile-item-statistic-refresh js-statistics-refresh">
     <div class="icon size-24 colour-fill-quaternary">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="17.5 17.5 62 62">
           <path fill="#C6C6C5" d="M55.886 58.828a12.709 12.709 0 0 1-7.265 2.274l-.17-.004c-.35-.002-.69-.02-1.04-.05l-.42-.053c-.27-.034-.54-.073-.8-.122-.11-.02-.23-.05-.34-.076l-.14-.03c-.25-.062-.51-.122-.76-.197l-.36-.12c-.28-.097-.57-.196-.86-.31l-.08.184-.11-.268c-.32-.146-.65-.298-1.01-.487-1.06-.59-2.03-1.31-2.93-2.2-.26-.27-.51-.54-.75-.83l-.15.13.01-.32a12.478 12.478 0 0 1-2.72-6.8c2.14-.06 4.03-.21 4.21-.57.07-.13.22-.43-1.46-3.14-.78-1.26-4.14-6.35-5.023-6.35-.96.03-5 6.48-5.95 8.4-.45.92-.41 1.11-.32 1.23.21.28 2.19.39 4.07.43.2 3.08 1.215 6.04 2.984 8.58l.2-.06-.13.19c.15.21.31.41.47.6l.4.5c.31.37.646.73.985 1.08l.1.1c1.14 1.13 2.44 2.1 3.854 2.87l.12.07c.41.21.82.41 1.25.6l.31.14c.365.15.736.27 1.19.43l.456.15c.33.1.66.17 1 .26l.156.03c.17.04.344.08.62.134.06.014.12.03.176.04.25.043.51.072.77.1l.53.07c.574.056 1.15.09 1.716.09 3.514 0 6.91-1.066 9.82-3.096a2.22 2.22 0 0 0 .55-3.1c-.683-.97-2.14-1.23-3.12-.546zm13.734-10.61c-.173-.34-1.882-.495-3.88-.56a16.864 16.864 0 0 0-2.987-8.818l-.168.112.092-.25c-.23-.33-.48-.635-.754-.965l-.086-.114a16.944 16.944 0 0 0-6.414-4.79l-.208-.09c-.397-.16-.803-.305-1.21-.44l-.154-.052c-.09-.03-.18-.06-.28-.09-.35-.1-.71-.19-1.08-.27l-.16-.04c-.14-.03-.29-.07-.44-.1l-.29-.06a4.35 4.35 0 0 0-.52-.06l-.85-.1c-.46-.04-.91-.06-1.47-.07h-.18a17.2 17.2 0 0 0-9.81 3.08c-.49.34-.81.85-.92 1.44-.1.59.03 1.18.37 1.67.69.97 2.15 1.23 3.13.55 2.14-1.49 4.65-2.272 7.38-2.272h.008c.373.003.75.02 1.11.056l.336.04c.306.04.6.08.9.14l.39.09c.29.06.58.13.86.21l.267.09c.325.11.64.22 1.05.39 1.846.79 3.503 2.02 4.81 3.6 1.68 2.03 2.64 4.49 2.82 7.125-1.96.03-4.15.133-4.38.44-.09.12-.13.305.32 1.223.954 1.93 4.99 8.384 5.95 8.41h.01c.885 0 4.17-4.98 5-6.31 1.704-2.74 1.55-3.04 1.48-3.177z"></path>
        </svg>
     </div>
  </a>
  <!-- <ul>
     <li class=" is-active " data-index="1">
        Favourite Artist: Eric Cantona
     </li>
     <li class="" data-index="2">
        Favourite Typeface: Playfair Display
     </li>
     <li class="" data-index="3">
        Favourite Shape: Circle
     </li>
     <li class="" data-index="4">
        Dislikes: Uneven Margins
     </li>
     <li class="" data-index="5">
        Lectures at Salford University
     </li>
     <li class="" data-index="6">
        Can't eat cheese
     </li>
  </ul>
</div> -->
