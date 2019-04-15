<?php

  date_default_timezone_set('Europe/London');
  ini_set("allow_url_fopen", 1);

  include 'config/config.php';
  include 'app/view.php';
  include 'app/bootstrap.php';
  include 'app/model.php';

  //Library
  include 'app/database.php';
  include 'app/session.php';

  $app = new Bootstrap;
  // echo phpinfo();
?>
