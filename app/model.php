<?php

class Model{

  function __construct(){
    try{
      $this->db = new Database();
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    }
    catch(PDOException $e){
      print "error in connection" . $e->getMessage();
    }
  }

  protected function visitor($blog_ID){
    $this->article_visit_DB(); //checking if the table has already be made. If so, it wont be recreated
    $this->unique_article_visits_DB();

    $add_visitor = $this->db->prepare("INSERT INTO article_visitors (blog_ID, visit_by_IP, visit_date)
                                            VALUES (:blog_ID, :visit_by_IP, :visit_date)");
    $add_visitor->execute(array(':blog_ID' => $blog_ID, ':visit_by_IP' => $this->getUserIP(),':visit_date' => date("Y-m-d H:i:s")));


    $check_unique_visit = $this->db->prepare("SELECT * FROM article_unique_visitors WHERE blog_ID = :blog_ID AND visit_by_IP = :visit_by_IP");
    $check_unique_visit->execute(array(':blog_ID' => $blog_ID, ':visit_by_IP' => $this->getUserIP()));
    $result = $check_unique_visit->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) < 1){
      $add_unique_visitor = $this->db->prepare("INSERT INTO article_unique_visitors (blog_ID, visit_by_IP)
                                              VALUES (:blog_ID, :visit_by_IP)");
      $add_unique_visitor->execute(array(':blog_ID' => $blog_ID, ':visit_by_IP' => $this->getUserIP()));
    }
  }

  public function latest_articles($article_visited, $limit = 6){
    $newest_posts = $this->db->prepare("SELECT * FROM blog WHERE status = 'published' ORDER BY ID DESC LIMIT ".$limit);
    $newest_posts->execute();
    $results = $newest_posts->fetchAll(PDO::FETCH_ASSOC);

    $new_results = array();

    foreach($results as $article){ //updates the results by adding the full name of the author
      if ($article_visited != $article["ID"]){
        $info = $this->author($article["authorID"]);

        array_push($new_results,$article + $info);
      }
    }

    if (count($new_results) == 0){
      return array("newest" => "Wow, you must be one of the first people to visit ".WEBSITE_NAME.". Congratulations! However, we do not have any articles yet. Please, come back or subscribe to get notified to be the frist to read our first article!");
    }

    return array("newest" => $new_results);
  }

  protected function users_DB(){
    $users = $this->db->prepare("CREATE TABLE IF NOT EXISTS `users` (
                                `ID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                `date_joined` date NOT NULL,
                                `title` varchar(4) DEFAULT NULL,
                                `firstname` varchar(32) NOT NULL,
                                `middlename` varchar(64) NOT NULL,
                                `lastname` varchar(64) NOT NULL,
                                `username` varchar(64) NOT NULL,
                                `email` varchar(128) NOT NULL,
                                `pwd` varchar(256) NOT NULL,
                                `role` varchar(16) DEFAULT 'member',
                                `gender` varchar(16) DEFAULT NULL,
                                `birthday` date DEFAULT NULL,
                                `location` varchar(32) DEFAULT NULL,
                                `about_me` varchar(256) DEFAULT NULL,
                                `interests` varchar(256) DEFAULT NULL,
                                `main_website` varchar(64) DEFAULT NULL,
                                `country_telephone_code` varchar(4) DEFAULT NULL,
                                `phone_number` varchar(16) DEFAULT NULL,
                                `address_1` varchar(32) DEFAULT NULL,
                                `address_2` varchar(32) DEFAULT NULL,
                                `town` varchar(32) DEFAULT NULL,
                                `state` varchar(32) DEFAULT NULL,
                                `postcode_or_zipcode` varchar(32) DEFAULT NULL,
                                `country` varchar(32) DEFAULT NULL,
                                `confirmCode` varchar(64) NOT NULL,
                                `confirmed` int(1) DEFAULT '1',
                                `profilesetupstatus` int(1) NOT NULL,
                                `profile_icon` varchar(32) DEFAULT NULL
                              )");
    $users->execute();
  }

  protected function blog_DB(){
    $this->users_DB();
    $blog = $this->db->prepare("CREATE TABLE IF NOT EXISTS `blog` (
                                `ID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                `title_url` varchar(128) NOT NULL,
                                `title` varchar(128) NOT NULL,
                                `date-posted` date NOT NULL,
                                `teaser_paragraph` varchar(256) NOT NULL,
                                `post` varchar(16384) CHARACTER SET utf8 NOT NULL,
                                `keywords` varchar(1024) NOT NULL,
                                `authorID` int(9) NOT NULL,
                                `cover-photo` varchar(32) NOT NULL,
                                `status` varchar(12) NOT NULL,
                                FOREIGN KEY (`authorID`) REFERENCES `users`(`ID`)
                              )");
    $blog->execute();
  }

  protected function article_visit_DB(){
    $this->blog_DB();
    $articles_visits = $this->db->prepare("CREATE TABLE IF NOT EXISTS article_visitors (
                                                ID int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                                                blog_ID int(11) NOT NULL,
                                                visit_by_IP int(11) DEFAULT 0,
                                                visit_date DateTime DEFAULT 0,
                                                FOREIGN KEY (blog_ID) REFERENCES blog(ID)
                                              )");
    $articles_visits->execute();
  }

  protected function unique_article_visits_DB(){
    $this->blog_DB();
    $articles_visits = $this->db->prepare("CREATE TABLE IF NOT EXISTS article_unique_visitors (
                                                ID int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                                                blog_ID int(11) NOT NULL,
                                                visit_by_IP int(11) DEFAULT 0,
                                                FOREIGN KEY (blog_ID) REFERENCES blog(ID)
                                              )");
    $articles_visits->execute();
  }

  public function most_popular($top_x_popular, $phrase = ""){
    $this->article_visit_DB(); //checking if the table has already be made. If so, it wont be recreated
    $this->unique_article_visits_DB();

    $articles_visits = array();

    $articles_q;
    if(!empty($phrase)){
      $articles_q = $this->db->prepare("SELECT * FROM blog WHERE status = 'published' AND (title LIKE :phrase1 OR keywords LIKE :phrase2)");
      $articles_q->execute(array(":phrase1" => "%{$phrase}%", ":phrase2" => "%{$phrase}%"));
    }
    else{
      $articles_q = $this->db->prepare("SELECT * FROM blog WHERE status = 'published'");
      $articles_q->execute();
    }
    $articles = $articles_q->fetchAll(PDO::FETCH_ASSOC);

    $results = array();

    foreach($articles as $article){

        $visitors_query = $this->db->prepare("SELECT * FROM article_visitors WHERE blog_ID = :blog_ID");
        $visitors_query->execute(array(":blog_ID" => $article["ID"]));
        $visitors = count($visitors_query->fetchAll(PDO::FETCH_ASSOC));

        array_push($results, array($visitors, $article));

    }

    $most_popular_articles = array();
    $visits = 0;

    foreach($results as $article_visits){
      if ($article_visits[0] >= $visits){
        array_push($most_popular_articles, $article_visits[1]);
        $visits = $article_visits[0];
      }
      if(count($most_popular_articles) > $top_x_popular){
        array_splice($most_popular_articles, count($most_popular_articles), $top_x_popular);
      }
    }

    if (count($results) == 0){
      return array("most_popular" => array());
    }

    return array("most_popular" => $results);

  }

  public function hot_articles($article_visited, $period = 0){

    $this->article_visit_DB(); //checking if the table has already be made. If so, it wont be recreated
    $this->unique_article_visits_DB();

    $articles_visits = array();

    $articles_q = $this->db->prepare("SELECT * FROM blog WHERE status = 'published'");
    $articles_q->execute();
    $articles = $articles_q->fetchAll(PDO::FETCH_ASSOC);

    $results = array();

    foreach($articles as $article){

      if ($article_visited != $article["ID"]){

        $visitors_query = $this->db->prepare("SELECT * FROM article_visitors WHERE visit_date  >= (DATE(NOW()) - INTERVAL :period DAY) AND blog_ID = :blog_ID");
        $visitors_query->execute(array(":period" => $period, ":blog_ID" => $article["ID"]));
        $visitors = count($visitors_query->fetchAll(PDO::FETCH_ASSOC));

      // $articles_visits[$visitors] = $article;
      // }

      // krsort($articles_visits); //shorting the array from posts of the most visitors to less
      // print_r($articles_visits);

      // $results = array();
      //
      // foreach($articles_visits as $article){

        $info = $this->author($article["authorID"]);

        //print_r($results);

        array_push($results,$article + $info);

      }
    }

    if (count($results) == 0){
      return array("hot" => "Wow, you must be one of the first people to visit ".WEBSITE_NAME.". Congratulations! However, we do not have any articles yet. Please, come back or subscribe to get notified to be the frist to read our first article!");
    }

    return array("hot" => $results);

  }

  public function recommended_articles($article_visited, $limit){

    $article = $this->db->prepare("SELECT * FROM blog WHERE ID <> :ID AND status = 'published' LIMIT ".$limit);
    $article->execute(array(':ID' => $article_visited["ID"]));
    $all_articles = $article->fetchAll(PDO::FETCH_ASSOC);

    if (count($all_articles) > 0){
      $article1 = explode(" ",strtolower(preg_replace('#\s+#',' ',trim(preg_replace('/[^A-Za-z0-9\- ]+/','', $article_visited["post"])))));
      $article1_words = array_unique($article1);

      $vector1 = array(); //holds word occurances of the visited article

      foreach($article1_words as $u_word){
        $count = 0; //counter of how many times does this word occurs in both textstext.
        foreach($article1 as $word){
          if ($word == $u_word){
            $count += 1;
          }
        }
        array_push($vector1, $count);
      }

      //calculating the length (module) of the vector1 vector

      $vectorA_length = 0; //length (module) of the words occurance (module of vector1)

      for($val = 0; $val < count($vector1); $val++){
        $vectorA_length += $vector1[$val]*$vector1[$val];
      }

      $recommended_articles = array(); //storing the recommended articles

      foreach ($all_articles as $article){ //comparing the visited article with all the others

        //parsing the article into an array of words

        $article2 = explode(" ",strtolower(preg_replace('#\s+#',' ',trim(preg_replace('/[^A-Za-z0-9\- ]+/i','', $article["post"])))));
        $article2_words = array_unique($article2);

        $all_words = $article1_words + $article2_words;
        $vector2 = array();

        //counting how many times every word occurs in the text

        foreach($all_words as $u_word){
          $count = 0; //counter of how many times does this word occurs in both textstext.
          foreach($article2 as $word){
            if ($word == $u_word){
              $count += 1;
            }
          }
          array_push($vector2, $count);
        }

        //calculating similatrity

        $vectors_product = 0; //getting the product of the twi vectors.

        //getting the product of the two vectors
        $larger_vector = count($vector2) > count($vector1) ? $vector2 : $vector1;
        $smaller_vector = count($vector2) <= count($vector1) ? $vector2 : $vector1;
        for($val = 0; $val < count($larger_vector); $val++){
          //since on this index, there may not exist a value for hte second vector, we have to check whether a value exists on the second vector at $val index.
          $other_value = isset($smaller_vector[$val]) ? $smaller_vector[$val] : 0;
          $vectors_product += $larger_vector[$val]*$other_value;
        }

        //echo $vectors_product."<br><br>";

        //calculating the length of the vector2 vector

        $vectorB_length = 0;

        for($val = 0; $val < count($vector2); $val++){
          $vectorB_length += $vector2[$val]*$vector2[$val];
        }

        $similarity = $vectors_product/(sqrt($vectorA_length)*sqrt($vectorB_length)); //calculating the similarity by using the cosine rule

        //echo $similarity."<br><br>";

        $recommended_articles[(string)$similarity] = $article;
      }

      //print_r($recommended_articles);

      krsort($recommended_articles);

      $recommended = array();
      foreach($recommended_articles as $article){
        if ($article_visited != $article["ID"]){
          $info = $this->author($article["authorID"]);

          array_push($recommended, $article + $info);
        }
      }

      //echo $article1."<br><br>".$article_visited["post"];
      //print_r($recommended);
      return array("recommended" => $recommended);
    }

    return array("recommended" => "Wow, you must be one of the first people to visit ".WEBSITE_NAME.". Congratulations! However, we do not have any articles yet. Please, come back or subscribe to get notified to be the frist to read our first article!");

  }

  protected function author($ID){
    $user = $this->db->prepare("SELECT firstname, lastname, profile_icon FROM users WHERE ID = :id");
    $user->execute(array(':id' => $ID));
    return $user->fetch(PDO::FETCH_ASSOC);
  }

  protected function getUserIP(){
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {

      $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
      $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];

    }

    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP)){
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP)){
        $ip = $forward;
    }
    else{
        $ip = $remote;
    }

    return $ip;

  }

  //prints the date in a friendly format (NOT USED)
  // protected function date_friendly_format($date){

  //   $minute = mb_substr($date,14,16, 'UTF-8');
  //   $hour = mb_substr($date,11,13, 'UTF-8');
  //   $day = mb_substr($date,8,10, 'UTF-8');
  //   $month = mb_substr($date,5,2, 'UTF-8');
  //   $year = mb_substr($date,0,4, 'UTF-8');

  //   $months = array("01" => "Jan", "02" => "Feb", "03" => "Mar", "04" => "Apr", "05" => "May", "06" => "Jun", "07" => "Jul", "08" => "Aug", "09" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dec");
  //   if (strlen($month) == 1){
  //     $month = "0".$month;
  //   }
  //   if($day[0] == "0" && isset($day[1])){
  //     $day = $day[1];
  //   }
  //   if($day[strlen($day)-1] == "1"){
  //     $day = $day.'<span class="day-prefix">st</span>';
  //   }
  //   else if($day[strlen($day)-1] == "1"){
  //     $day = $day.'<span class="day-prefix">nd</span>';
  //   }
  //   else if($day[strlen($day)-1] == "1"){
  //     $day = $day.'<span class="day-prefix">rd</span>';
  //   }
  //   else{
  //     $day = $day.'<span class="day-prefix">th</span>';
  //   }

  //   //time
  //   if ($hour[0] == "0" && strlen($hour) == 2){
  //     $hour = $hour[1];
  //   }
  //   return $months[$month]." ".$day.", ".$year." ".$hour.":".$minute."         date: ".$date." length: ".strlen($date);
  // }

  protected function all_users_shorted($page_roles,$output_label){
    $users_list = array(); //array holding all users

    foreach($page_roles as $role){

      $user_q = $this->db->prepare("SELECT * FROM users WHERE role = :role ORDER BY lastname");
      $user_q->execute(array(':role' => $role));
      $users = $user_q->fetchAll(PDO::FETCH_ASSOC);

      foreach($users as $user){
        $user["country-flag"] = $user['country']; //used to get the flag of the country which includes dashes "-"
        $user["country"] = str_replace("-", " ", $user['country']);

        if (empty($user["profile_icon"])){
          $user["profile_icon"] = "default-profile-picture.jpg";
        }
        array_push($users_list, $user);
      }
    }
    return array($output_label => $users_list);
  }

  protected function save_updates($page){
    if($page == 2){

      $first_name = htmlspecialchars($_POST['firstname'], ENT_QUOTES, 'UTF-8');
      $middle_name = htmlspecialchars($_POST['middlename'], ENT_QUOTES, 'UTF-8');
      $last_name = htmlspecialchars($_POST['lastname'], ENT_QUOTES, 'UTF-8');
      $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');

      $genders = array("Male","Female","Transgender","Other","uknown");
      $gender = Session::user_data("gender"); //default value
      for($i = 0; $i<count($genders); $i++){
        if($_POST['gender'] === $genders[$i]){
          $gender = $_POST['gender'];
        }
      }

      $gender = htmlspecialchars($gender, ENT_QUOTES, 'UTF-8');

      //validating birthday

      $days = array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
      $day = substr(Session::user_data("birthday"), 8, 2); //default value
      for($i = 0; $i<count($days); $i++){
        if($_POST['birthDate_day'] == $days[$i]){
          $day = $_POST['birthDate_day'];
        }
      }

      $months = array("1","2","3","4","5","6","7","8","9","10","11","12");
      $month = substr(Session::user_data("birthday"), 5, 2);
      for($i = 0; $i<count($months); $i++){
        if($month === $_POST['birthDate_month']){
          $month = $_POST['birthDate_month'];
        }
      }

      $years = array("2018","2017","2016","2015","2014","2013","2012","2011","2010","2009","2008","2007","2006","2005","2004","2003","2002","2001","2000","1999","1998","1997","1996","1995","1994","1993","1992",
      "1991","1990","1989","1988","1987","1986","1985","1984","1983","1982","1981","1980","1979","1978","1977","1976","1975","1974","1973","1972","1971","1970","1969","1968","1967","1966","1965","1964","1963",
      "1962","1961","1960","1959","1958","1957","1956","1955","1954","1953","1952","1951","1950","1949","1948","1947","1946","1945","1944","1943","1942","1941","1940","1939","1938","1937","1936","1935","1934",
      "1933","1932","1931","1930","1929","1928","1927","1926","1925","1924","1923","1922","1921","1920","1919","1918","1917","1916","1915","1914","1913","1912","1911","1910","1909","1908","1907","1906","1905",
      "1904","1903","1902","1901","1900","1899","1898","1897","1896","1895","1894","1893","1892","1891","1890","1889","1888","1887","1886","1885","1884","1883","1882","1881","1880","1879","1878","1877","1876",
      "1875","1874","1873","1872","1871","1870","1869","1868","1867","1866","1865","1864","1863","1862","1861","1860","1859","1858","1857","1856","1855","1854","1853","1852","1851");
      $year = substr(Session::user_data("birthday"), 0, 4); //default value
      //echo $year;$_POST['birthDate_year']
      for($i = 0; $i<count($years); $i++){
        if($_POST['birthDate_year'] === $years[$i]){
          $year = $_POST['birthDate_year'];
        }
      }

      $birthday = htmlspecialchars($year."-".$month."-".$day, ENT_QUOTES, 'UTF-8');

      //checking whether the country value inputted is listed below
      $countries = array("None","Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua, Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia-Herzegovina","Botswana","Brazil","British Indian Ocean Territory","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burma","Burundi","Cambodia","Cameroon","Canada","Canary Islands","Cape Verde","Cayman Islands","Central Africa","Chad","Chile","China","Christmas Island","Cocos Island","Colombia","Comoros","Congo","Cook Islands","Costa Rica","Croatia","Cuba","Cyprus","Czech Republic","Democratic Republic of Congo","Denmark","Djibouti","Dominica","Dominican Republic","East Timor","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","FYRO Macedonia","Falkland Islands","Faroe Islands","Fiji","Finland","France","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guinea","Guinea","-Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Ivory Coast","Jamaica","Japan","Jordan","Kazachstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Namibia","Nauru","Nepal","Netherlands","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","North Korea","Norway","Oman","Pakistan","Palau","Palestine National Authority","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn Islands","Poland","Polynesia","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Kitts and Nevis","Saint Lucia","Saint Vincent and the Grenadines","Samoa","San Marino","San Serriffe","Sao Tome","Saudi Arabia","Senegal","Serbia and Montenegro","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","Spain","Sri Lanka","St. Helena","South Sudan","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Tadjikistan","Taiwan","Tanzania","Thailand","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","USA","Uruguay","Uzbekistan","Vanuatu","Vatican City State","Venezuela","Vietnam","Virgin Islands, British","Virgin Islands, US","Western Sahara","Yemen","Yugoslavia","Zambia");
      $selectedCountry = Session::user_data("country");
      for($i = 0; $i<count($countries); $i++){
        if($_POST['country'] === $countries[$i]){
          $selectedCountry = $_POST['country'];
        }
      }

      $country = htmlspecialchars(str_replace(" ", "-", $selectedCountry), ENT_QUOTES, 'UTF-8');

      $about_me = htmlspecialchars($_POST['about_me'], ENT_QUOTES, 'UTF-8');
      $interests = htmlspecialchars($_POST['interests'], ENT_QUOTES, 'UTF-8');
      $main_website = htmlspecialchars($_POST['main_website'], ENT_QUOTES, 'UTF-8');

      echo $middle_name;

      // $user = $this->db->prepare("UPDATE users SET firstname=:firstname, middlename=:middlename, lastname=:lastname, username=:username,
      //                                               gender=:gender, birthday=:birthday, country=:country, about_me=:about_me, interests=:interests,
      //                                               main_website=:main_website WHERE ID=:id");
      //$user->execute(array(":firstname" => $first_name, ":middlename" => $middle_name, ":lastname" => $last_name, ":username" => $username, ":gender" => $gender, ":birthday" => $birthday, ":country" => $country, ":about_me" => $about_me, ":interests" => $interests, ":main_website" => $main_website, ':id' => $this->id));
      $user = $this->db->prepare("UPDATE users SET firstname=?, middlename=?, lastname=?, username=?,
                                                     gender=?, birthday=?, country=?, about_me=?, interests=?,
                                                     main_website=? WHERE ID=?");
      $user->execute(array($first_name, $middle_name, $last_name, $username, $gender, $birthday, $country, $about_me, $interests, $main_website, $this->id));

      $user = $this->db->prepare("SELECT * FROM users WHERE ID = :id");
      $user->execute(array(':id' => $this->id));
      $info = $user->fetch(PDO::FETCH_ASSOC);
      //print_r($info); //debug
      Session::update_all_data($info);
    }
    else if($page == 3){

      $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
      //$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
      $cur_password = $_POST['cur_password'];
      $new_password = $_POST['new_password'];
      $new_conf_password = $_POST['new_conf_password'];
      $country_telephone_code = htmlspecialchars($_POST['country_telephone_code'], ENT_QUOTES, 'UTF-8');
      $phone_number = htmlspecialchars($_POST['phone_number'], ENT_QUOTES, 'UTF-8');
      $address_1 = htmlspecialchars($_POST['address_1'], ENT_QUOTES, 'UTF-8');
      $address_2 = htmlspecialchars($_POST['address_2'], ENT_QUOTES, 'UTF-8');
      $town = htmlspecialchars($_POST['town'], ENT_QUOTES, 'UTF-8');
      $state = htmlspecialchars($_POST['state'], ENT_QUOTES, 'UTF-8');
      $postcode = htmlspecialchars($_POST['postcode'], ENT_QUOTES, 'UTF-8');

      //$user = $this->db->prepare("UPDATE users SET title=:title, email=:email, birthday=:birthday, address_1=:address_1, address_2=:address_2, town=:town, state=:state, postcode_or_zipcode=:postcode_or_zipcode, country=:country WHERE ID=:id");
      //$user->execute(array(":title" => $title, ":email" => $email, ":country_telephone_code" => $country_telephone_code, ":phone_number" => $phone_number, ":address_1" => $address_1, ":address_2" => $address_2, ":town" => $town, ":state" => $state, ":postcode_or_zipcode" => $postcode, ':id' => $this->id));

      $user = $this->db->prepare("UPDATE users SET title=?, country_telephone_code=?, phone_number=?address_1=?, address_2=?, town=?, state=?, postcode_or_zipcode=? WHERE ID=?");

      $user->execute(array($title, $country_telephone_code, $phone_number, $address_1, $address_2, $town, $state, $postcode, $this->id));

      $user = $this->db->prepare("SELECT * FROM users WHERE ID = :id");
      $user->execute(array(':id' => $this->id));
      $info = $user->fetch(PDO::FETCH_ASSOC);
      //print_r($info); //debug
      Session::update_all_data($info);

    }
  }

  protected function load_prof_img($item){

    header("Content-Type: text/xml");

    $XML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
            <response>';
    //echo isset($_GET['restore_image']);
    //if(isset($_GET['restore_image'])){ //loading the profile picture uploaded by the user
    if ($item == "profile"){
      $userID = Session::user_data("ID");

      $dir = MEDIA_STORAGE_URL.'profile_pics';

      $images = scandir($dir);
  		$targetImage = $userID."-prof-img";

  		//iteration which loops through each image file form the users-profile-pictures and checks each whether it matches with the logged user ID
  		for($i = 0; $i<count($images); $i++){

  			if(strpos($images[$i], $targetImage) !== false && strpos($images[$i], $targetImage) == 0){
  				$imageName = $images[$i];
  				$XML .= "<img>".$imageName."</img>";
  				break;
  			}
  			if($i == count($images) - 1){
  				$XML .= "<img>none</img>";
  			}
  		}
    }
    else if($item == "cover"){
      $userID = Session::user_data("ID");

      $dir = MEDIA_STORAGE_URL.'blog/article_cover_temp/article-photos-temp-'.$userID;

      //checking if this is a directory and exists
      if (!file_exists($dir) && !is_dir($dir)) {
        mkdir($dir, 0757, true);
        $XML .= "<img>none</img>";
      }
      else{

        $images = scandir($dir);
    		$targetImage = "cover";

    		//iteration which loops through each image file form the users-profile-pictures and checks each whether it matches with the logged user ID
    		for($i = 0; $i<count($images); $i++){

    			if(strpos($images[$i], $targetImage) !== false && strpos($images[$i], $targetImage) == 0){
    				$imageName = $images[$i];
    				$XML .= "<img>".$imageName."</img>";
    				break;
    			}
    			if($i == count($images) - 1){
    				$XML .= "<img>none</img>";
    			}
    		}
      }
    }
  	//}
    return $XML .= '</response>';
  }

  protected function prof_img_uploaded($img){
    header("Content-Type: text/xml");

    $XML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
            <response>';
    //$XML .= "<img>cover.".$_FILES['file-select']['error']."</img>";
    if(isset($_FILES['file-select'])){ //if the user clicked on the upload image button
      $fileName = $_FILES['file-select']['name'];
  		$fileTmpLoc = $_FILES['file-select']['tmp_name'];
  		$fileType = $_FILES['file-select']['type']; //getting the extention of the file (for example: png, jpeg etc)
  		$fileSize = $_FILES['file-select']['size'];
  		$fileErrorMsg = $_FILES['file-select']['error'];

      $userID = Session::user_data("ID");

      if ((exif_imagetype($fileTmpLoc) == IMAGETYPE_JPEG || exif_imagetype($fileTmpLoc) == IMAGETYPE_PNG) && getimagesize($fileTmpLoc) && filesize($fileTmpLoc) <= 2097152){
    		//getting the extention of the file (for example: png, jpeg etc)
    		$fileExtension = "";
    		for($i = strlen($fileName)-1; $i>0; $i--){
    			if($fileName[$i] == "."){
    				break;
    			}
    			else{
    				$fileExtension = $fileName[$i].$fileExtension;
    			}
    		}
        if ($img == "cover"){
      		$destinationPath = MEDIA_STORAGE_URL."blog/article_cover_temp/article-photos-temp-".$userID."/cover.".$fileExtension;

      		if(!$fileTmpLoc){
      			echo "Please select a file to upload";
      		}
      		else{
      			$dir = MEDIA_STORAGE_URL.'blog/article_cover_temp/article-photos-temp-'.$userID;
      			$images = scandir($dir);
      			$targetImage = "cover";
      			//funciton which checks whether the first character of the given string matches with one of the given series of characters
      			for($i = 0; $i<count($images); $i++){
      				if(strpos($images[$i], $targetImage) !== false && strpos($images[$i], $targetImage) == 0){
      					unlink(MEDIA_STORAGE_URL.'blog/article_cover_temp/article-photos-temp-'.$userID.'/'.$images[$i]);
      				}
      			}
      			if(move_uploaded_file($fileTmpLoc, $destinationPath)){

      				//$stmt = $this->db->prepare("UPDATE users SET profile_icon = :profile_icon WHERE ID = :userID"); //creating the prepared statement and runs it into the server database
      				//$stmt->execute(array(":profile_icon" => $userID."-prof-img.".$fileExtension, ':userID' => $userID)); //binding the user input (in this case is the email)
              $XML .= "<img>cover.".$fileExtension."</img>";
            }
      			else{
      				echo "An uknown error occured".$fileTmpLoc;
      			}
      		}
        }
        else if ($img == "profile"){
          $destinationPath = MEDIA_STORAGE_URL."profile_pics/".$userID."-prof-img.".$fileExtension;

          if(!$fileTmpLoc){
            echo "Please select a file to upload";
          }
          else{
            $dir = MEDIA_STORAGE_URL.'profile_pics';
            $images = scandir($dir);
            $targetImage = $userID."-prof-img";
            //funciton which checks whether the first character of the given string matches with one of the given series of characters
            for($i = 0; $i<count($images); $i++){
              if(strpos($images[$i], $targetImage) !== false && strpos($images[$i], $targetImage) == 0){
                unlink(MEDIA_STORAGE_URL."profile_pics/".$images[$i]);
              }
            }
            if(move_uploaded_file($fileTmpLoc, $destinationPath)){

              $stmt = $this->db->prepare("UPDATE users SET profile_icon = :profile_icon WHERE ID = :userID"); //creating the prepared statement and runs it into the server database
              $stmt->execute(array(":profile_icon" => $userID."-prof-img.".$fileExtension, ':userID' => $userID)); //binding the user input (in this case is the email)
              $XML .= "<img>".$userID."-prof-img.".$fileExtension."</img>";
            }
            else{
              echo "An uknown error occured".$fileTmpLoc;
            }
          }
        }
      }
    }

    return $XML .= '</response>';

  }

  protected function save_prof_img_changes(){
    if(isset($GLOBALS["HTTP_RAW_POST_DATA"])){ //if the user clicked on the save changes button on the setup profile picture step
      $dir = '../home/users-profile-pictures/';
      $images = scandir($dir);
      $targetImage = $userID."-prof-img";
      //funciton which checks whether the first character of the given string matches with one of the given series of characters
      for($i = 0; $i<count($images); $i++){
        if(strPosition($images[$i], $targetImage) >= 0 && pregMatch("/^[^\.].*$/", $images[$i]) !== true){
          fclose("users-profile-pictures/".$images[$i]);
          unlink("users-profile-pictures/".$images[$i]);
        }
      }
      $rawImage = $GLOBALS["HTTP_RAW_POST_DATA"];
      $removeHeaders = substr($rawImage, strpos($rawImage, ",")+1);
      $decode = base64_decode($removeHeaders);
      $fopen = fopen("users-profile-pictures/".$userID."-prof-img.png","wb"); //naming the image file. wb means writing
      fwrite($fopen, $decode);
      fclose($fopen);

      $stmt = $conn->prepare("UPDATE users SET profile_icon = ? WHERE ID = ?"); //creating the prepared statement and runs it into the server database
      $stmt->bind_param("ss", $imageName, $userID); //binding the user input (in this case is the email)
      $imageName = $userID."-prof-img.png";
      $stmt->execute(); //executing the prepared statement by taking the parameters to the prepared statement and executes it
      $stmt->get_result(); //takes the parameters (which are already declared in this PHP code) we inserted into the bind_param() function and puts them in our statement and executes it.
    }
  }

  protected function recurse_copy($src,$dst) {
    $dir = opendir($src);
    mkdir($dst, 0777, true);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                $this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
  }

  protected function delete_files($src) {
      $dir = opendir($src);
      foreach(scandir($src) as $file) {
          if ('.' === $file || '..' === $file) continue;
          if (is_dir("$src/$file")) rmdir_recursive("$src/$file");
          else unlink("$src/$file");
      }
      closedir($dir);
      rmdir($src);
  }


}


?>
