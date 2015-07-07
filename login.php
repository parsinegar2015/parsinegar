<?php

function token($length,$key){
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
    $size = strlen( $chars );
    for( $i = 0; $i < $length; $i++ ) {
        $str .= $chars[ rand( 0, $size - 1 ) ];
    }
	
	return hash('sha256',trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $str, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))))); 
		
		}

function hashSSHA($password){

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
	
function checkhashSSHA($salt,$password){

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
		
		//return sha1(sha1(base64_encode($salt)).sha1($password));
    }

function check_email_address($email) {
        // First, we check that there's one @ symbol, and that the lengths are right
        if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
            // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
            return false;
        }
        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for ($i = 0; $i < sizeof($local_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
                return false;
            }
        }
        if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2) {
                return false; // Not enough parts to domain
            }
            for ($i = 0; $i < sizeof($domain_array); $i++) {
                if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                    return false;
                }
            }
        }

        return true;
    }

	
/*function login(){

$_SESSION['token'] = token(20,TOKEN_KEY);

}*/

function url($target){
		
		$server_https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';  
        $server_port = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != 80;  
        $scheme = ($server_https || $server_port) ? 'https://' : 'http://';  	
        $host = $_SERVER['HTTP_HOST'];
        $path = trim(filter_var($_SERVER['PHP_SELF'],FILTER_SANITIZE_STRING)); //$_SERVER['PHP_SELF'];
        $pArr = explode('/',$path);
        $len = count($pArr);
        $len = $len - 1;
        $path = implode('/',array_slice($pArr,0,$len));
		
		$url = $scheme.$host.$path.$target;
		
		return $url;
}


function back_to_index($target=''){
$url = url('/'.$target);
$header = 'HTTP/1.1 401 Unauthorized';
header($header);
header("Location: $url");
exit();
}

//===============================================
if(!isset($_SESSION['login']) && empty($_POST) && isset($_GET['route'])){
$layout = false;
if(isset($_SERVER['HTTP_REFERER']) && strtolower(parse_url(filter_var($_SERVER['HTTP_REFERER'],FILTER_SANITIZE_STRING), PHP_URL_HOST)) == strtolower(filter_var($_SERVER['HTTP_HOST'],FILTER_SANITIZE_STRING))){
?>
<center>
<br/><br/>
<b>
برای دسترسی به بخش های اصلی سامانه نیاز است که از طریق کد کاربری و کلمه عبور وارد بخش کاربری شوید
</b>
<?php
if(isset($_GET['msg'])){
echo '<br/>'.$_GET['msg'].'<br/>';
}
?>
<br/>
<form class="login" method="post" id="login_form" action="<?php echo BASE_PATH; ?>/login.php">
<input type="text" name="username" autocomplete="off" value="" placeholder="نام کاربری" tabindex="1"/><br/>
<input type="password" name="password" value="" placeholder="کلمه عبور" tabindex="2"/><br/>
<br/>
<img src="<?php echo BASE_PATH; ?>/captcha/captcha.php"/>
<br/>
<input type="text" name="captcha" value="" placeholder="حاصل جمع؟" tabindex="3"/><br/>
<input type="submit" name="btn" value="ورود" id="login_btn" tabindex="4"/>
</form>
</center>
<?php
}else{
//redirect
$url = url('/index.php');
$header = 'HTTP/1.1 403 Forbidden';
header($header);
header("Location: $url");
exit();
}
}else if(!isset($_SESSION['login'])){
if(isset($_POST) && !empty($_POST)){
include('bootstrap.php');
try{
$dsn = 'mysql:dbname='.DATABASE.';host='.HOST.';';
		   $pdo = new PDO($dsn,LOGIN,PASSWORD,array(PDO::ATTR_EMULATE_PREPARES => false, 
                                                                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		   $pdo->exec("set names utf8");
		 }catch(PDOException $e){
	       echo $e->getMessage();
	      }	

if(isset($_POST['username'],$_POST['password'],$_POST['captcha']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['captcha'])){
if(isset($_SESSION['captcha']) && $_POST['captcha'] == $_SESSION['captcha']){
$username = escape($_POST['username']);
$password = $_POST['password'];
$sql = "select * from user where username=:user and permission!='admin'";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user',$username,PDO::PARAM_STR);
$stmt->execute();
if($stmt->rowCount() == 1){
$user = $stmt->fetch(PDO::FETCH_OBJ);
$salt = $user->salt;
$encPassword = $user->password;
if(checkhashSSHA($salt,$password) == $encPassword){
session_regenerate_id(true);
$_SESSION['login'] = true;
$_SESSION['name'] = $user->lname.' '.$user->fname;
$_SESSION['fname'] = $user->fname;
$_SESSION['lname'] = $user->lname;
$_SESSION['username'] = $user->username;
$_SESSION['userId'] = $user->id;
$_SESSION['f_id'] = $user->f_id;
$_SESSION['permission'] = $user->permission;
$_SESSION['token'] = token(20,TOKEN_KEY);

/*************************************/

$url = url('/welcome.php');
$header = 'HTTP/1.1 200 OK';
header($header);
header("Location: $url");
exit();

/*************************************/

 }
}
}
}
back_to_index('login/?&msg=please insert correct data');		  
}else{
back_to_index('login/?msg=please complete login form');
}
}else{
back_to_index();
}//session

?>