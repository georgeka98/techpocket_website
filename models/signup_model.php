<?php

class Signup_model extends Model{

  public function __construct(){
    parent::__construct();
  }

  public function run(){

    $first       = htmlspecialchars($_POST['first-name'], ENT_QUOTES, 'UTF-8');
    $last        = htmlspecialchars($_POST['last-name'], ENT_QUOTES, 'UTF-8');
    $uid         = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $email       = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $pwd         = $_POST['pwd'];
    $pwd_ver     = $_POST['ver-pwd'];
    $remember_me = isset($_POST['remember_me']) ? htmlspecialchars($_POST['remember_me'], ENT_QUOTES, 'UTF-8') : "";

    $return = $this->error_check($first,$last,$uid,$email,$pwd,$pwd_ver);

    if ($return != "true"){
      header("Location: ../signup&error=".$return);
    }
    else {
      //tocken generation

      include_once "remember-me.php";

      remember_me($remember_me, $email,$pwd);

      $confirmToken = "";

      $NonSymbols = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","1","2","3","4","5","6","7","8","9","0");
      $arrLen = count($NonSymbols);
      for($i = 0; $i<64; $i++){
        $int = mt_rand(0, $arrLen-1); //generates a random integer using the Mersenne Twister algorithm. Its 4 times faster and produces a better random value than the rand() function
        $char = $NonSymbols[$int];
        $confirmToken = $confirmToken.$char; //creating the token
      }

      $message =
      "
      Please follow the instruction below to confirm your email:

      Click on this link: http://".BASE_DIR."email_confirmation/tk/".$confirmToken." to validate your email address. If you encounter any issues, please contact us by clicking on this link: http://".BASE_DIR."contact_us

      Please ignore this email if your received this by mistake.

      Enjoy.

      The TechPocket team
      ";

      mail($email,"TECHPOCKET: EMAIL CONFIRMATION",$message,"FROM: donotreply@techpocketnews.com");

      $hash_pwd = password_hash($pwd, PASSWORD_DEFAULT);
      $confirmed = "0";
	    $date_joined = date("Y-m-d");

      $user = $this->db->prepare("INSERT INTO users (date_joined, firstname, lastname, email, username, pwd, confirmCode, confirmed, profilesetupstatus)
                                            VALUES (:date_joined, :firstname, :lastname, :email, :username, :pwd, :confirmCode, :confirmed, :profilesetupstatus)");
      $user->execute(array(':date_joined' => $date_joined, ':firstname' => $first, ':lastname' => $last, ':email' => $email, ':username' => $uid, ':pwd' => $hash_pwd, ':confirmCode' => $confirmToken, ':confirmed' => $confirmed, ":profilesetupstatus" => "1"));

      //echo $user;

      //**** CREATING THE PREPARED STATEMENT ****
      $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username"); //creating the prepared statement and runs it into the server database
      $stmt->execute(array(':username' => $uid)); //binding the user input (in this case is the email)
      $user_info = $stmt->fetch(PDO::FETCH_ASSOC);
      //$userInfo = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE username = '".$uid."'"));

      //adding country flag name
      $user_info["country-flag"] = $user_info['country']; //used to get the flag of the country which includes dashes "-"
      $user_info["country"] = str_replace("-", " ", $user_info['country']);

      //checking if profile pcture exists
      if ($user_info["profile_icon"] == NULL){
        $user_info["profile_icon"] = "default-profile-picture.jpg";
      }

      Session::init();
      $_SESSION['loggedin'] = True;
      $_SESSION['auth'] = $user_info;
      header('Location: ../profile_setup/page/1');
      exit();
    }

  }

  public function error_check($first,$last,$uid,$email,$pwd,$pwd_ver){
    $acceptableChar = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","'","-");
    $alphabet = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
    $numbers = array("1","2","3","4","5","6","7","8","9","0");

    $return = $this->nameVal($acceptableChar, $first, "null");
    if($return != "true"){
      if ($return == "empty"){
        return "empty_first_name";
      }
			return $return;
		}
		$return = $this->nameVal($acceptableChar, $last, "null");
		if($return != "true"){
      if ($return == "empty"){
        return "empty_last_name";
      }
			return $return;
		}
		$return = $this->uidVal($uid, $pwd);
		if($return != "true"){
      if ($return == "empty"){
        return "empty_user_name";
      }
			return $return;
		}
		$return = $this->emailVal($email);
		if($return != "true"){
      if ($return == "empty"){
        return "empty_email";
      }
			return $return;
		}
		$return = $this->pwdVal($pwd, $first, $last, $uid);
		if($return != "true" && $return != "passAndVerTrue"){
      if ($return == "empty"){
        return "empty_password";
      }
			return $return;
		}
		$return = $this->pwdVer($pwd, $pwd_ver);
		if($this->pwdVer($pwd, $pwd_ver) != "true"){
      if ($return == "empty"){
        return "empty_password_confirm";
      }
			return $return;
		}
    return $return;
  }

  public function nameVal($characters, $val){
    if($val == ""){
      return "empty";
    }
    else if($val == ""){
      return "none"; //no border colour change or message to be printed is needed
    }
    for($i = 0; $i<strlen($val); $i++){
      for($char = 0; $char<count($characters); $char++){
        if(strtoupper($val[$i]) == $characters[$char]){
          break;
        }
        if($char == count($characters)-1){
          return "firstNoAlphabet";
        }
      }
    }
    return "true";
  }

  function uidVal($uid, $pwd){

    $user = $this->db->prepare("SELECT username FROM users WHERE username = :username");
    $user->execute(array(':username' => $uid));
    $rows = $user->rowCount();

    if($rows >= 1){
      return "uidExists";
    }
    else if($uid !== "" && strpos(strtoupper($pwd), strtoupper($uid)) !== false){
      return "containsUid";
    }
    else if($uid == ""){
      return "empty";
    }
    else{
      return "true";
    }
  }

  function emailVal($email){
		$hasAt = false; //Email contains at (@) symbol
		$DotAfterAt = false; //Email contains a domain name (contains a dot '.' after the host name).
		$hasMoreAt = false; //Email contains more than 1 @ symbols
		$UnallowedChar = true; //if character which is not allwed is found
		$UserName = ""; //username
		$hostName = ""; //host name
		$domain = ""; //domain name
		$acceptedChar = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","1","2","3","4","5","6","7","8","9","0","-","!","#","$","%","&","'","*","+","/","=","?","^","_","`","{","|","}","~",";"); //all the accepted characters in the email
		if($email == ""){
			return "emptyEmail";
		}
		for($i = 0; $i<strlen($email); $i++){
			for($c = 0; $c<count($acceptedChar); $c++){ //first child loop (loops through each character from the acceptedChar array in order to check whether the current charactrer form the email is allowed or not)
				if($c > 36 && $hasAt == true){ //if the host nane part is being validated
					if($UnallowedChar == true){ //if an unallowed character is found
						return "UnallowedChar";
					}
					break; //break the first child loop
				}
				if($acceptedChar[$c] == $email[$i]){ //if the current character of the email matches with the currect character from the acceptedChar array. Used to determine whether the current character of the email is allowed
					$UnallowedChar = false;
				}
				else if($email[$i] == "@" && $hasAt != true){ //if the @ symbol is found (the first @ symbol found)
					$hasAt = true;
					break;
				}
				else if($email[$i] == "@" && $hasAt == true){ //if more than 1 @ symbol is found
					$hasMoreAt = true;
					return "MoreThanOneAt";
				}
				else if($email[$i] == "." && $hasAt == true && $DotAfterAt == false){
					$DotAfterAt = true; //if a . character is found after the @ symbol
					break;
				}
				else if($email[$i] == "." && $hasAt == true && $DotAfterAt != false){
					return "WrongDot";
				}
				else if($hasAt == false){ //if @ symbol is not found yet (username part)
					$UserName = $UserName.$email[$i];
					break;
				}
				else if($hasAt == true && $DotAfterAt == false){ //if @ symbol is found but not a . character (host name part)
					$hostName = $hostName.$email[$i];
					break;
				}
				else if($hasAt == true && $DotAfterAt == true){ //if a . character is found (domnain name part)
					$domain = $domain.$email[$i];
					break;
				}
			}
			if($i == strlen($email) - 1){
				if($hasAt == false){
					return "NoAtSymbol";
				}
			}
		}
		if($UserName != "" && $hostName != "" && $domain != ""){

      $user = $this->db->prepare("SELECT email FROM users WHERE email = :email");
      $user->execute(array(':email' => $email));
      $rows = $user->rowCount();

			if($rows >= 1){
				return "emailExists";
			}
			else{
				return "true";
			}
		}
		else if($UserName == ""){
			return "noUserName";
		}
		else if($hostName == ""){
			return "noHostName";
		}
		else if($domain == ""){
			return "noDomain";
		}
	}

  function pwdVer($pwd, $pwd_ver){
    if($pwd == $pwd_ver && $pwd_ver != ""){
      return "true";
    }
    else if($pwd_ver == ""){
      return "empty";
    }
    else{
      return "pwdNotMatch";
    }
  }
}


?>
