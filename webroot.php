<?php
include('bootstrap.php');
try{
$dsn = 'mysql:dbname='.DATABASE.';host='.HOST.';';
		   $pdo = new PDO($dsn,LOGIN,PASSWORD,array(PDO::ATTR_EMULATE_PREPARES => false, 
                                                                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		   $pdo->exec("set names utf8");
		 }catch(PDOException $e){
	       echo $e->getMessage();
	      }



function checkhashSSHA($salt,$password){

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
		
		//return sha1(sha1(base64_encode($salt)).sha1($password));
    }




function token($length,$key){
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
		$str = '';
    $size = strlen( $chars );
    for( $i = 0; $i < $length; $i++ ) {
        $str .= $chars[ rand( 0, $size - 1 ) ];
    }
	
	return hash('sha256',trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $str, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))))); 
		
		}
		  
		  

		  
#-output-------
$html = '';		  
		  
function base64_url_encode($input) {
 return strtr(base64_encode($input), '+/=', '-_,');
}

function base64_url_decode($input) {
 return base64_decode(strtr($input, '-_,', '+/='));
}		  

$inactive = 300;		  

if(validRequest()){
if(!isset($_SESSION['login'])){

include('lib/Crypt/RSA.php');

$rsa = new Crypt_RSA();

$publicKey = 'MIICXAIBAAKBgQCqGKukO1De7zhZj6+H0qtjTkVxwTCpvKe4eCZ0FPqri0cb2JZfXJ/DgYSF6vUp
wmJG8wVQZKjeGcjDOL5UlsuusFncCzWBQ7RKNUSesmQRMSGkVb1/3j+skZ6UtW+5u09lHNsj6tQ5
1s1SPrCBkedbNf0Tp0GbMJDyR4e9T04ZZwIDAQABAoGAFijko56+qGyN8M0RVyaRAXz++xTqHBLh
3tx4VgMtrQ+WEgCjhoTwo23KMBAuJGSYnRmoBZM3lMfTKevIkAidPExvYCdm5dYq3XToLkkLv5L2
pIIVOFMDG+KESnAFV7l2c+cnzRMW0+b6f8mR1CJzZuxVLL6Q02fvLi55/mbSYxECQQDeAw6fiIQX
GukBI4eMZZt4nscy2o12KyYner3VpoeE+Np2q+Z3pvAMd/aNzQ/W9WaI+NRfcxUJrmfPwIGm63il
AkEAxCL5HQb2bQr4ByorcMWm/hEP2MZzROV73yF41hPsRC9m66KrheO9HPTJuo3/9s5p+sqGxOlF
L0NDt4SkosjgGwJAFklyR1uZ/wPJjj611cdBcztlPdqoxssQGnh85BzCj/u3WqBpE2vjvyyvyI5k
X6zk7S0ljKtt2jny2+00VsBerQJBAJGC1Mg5Oydo5NwD6BiROrPxGo2bpTbu/fhrT8ebHkTz2epl
U9VQQSQzY1oZMVX8i1m5WUTLPz2yLJIBQVdXqhMCQBGoiuSoSjafUhV7i1cEGpb88h5NBYZzWXGZ
37sJ5QsW+sJyoNde3xH8vdXhzU7eT82D6X/scw9RZz+/6rCJ4p0=';

$privateKey = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCqGKukO1De7zhZj6+H0qtjTkVxwTCpvKe4eCZ0
FPqri0cb2JZfXJ/DgYSF6vUpwmJG8wVQZKjeGcjDOL5UlsuusFncCzWBQ7RKNUSesmQRMSGkVb1/
3j+skZ6UtW+5u09lHNsj6tQ51s1SPrCBkedbNf0Tp0GbMJDyR4e9T04ZZwIDAQAB';

if(!isset($_SESSION['SAFE_LOGIN'])){
if(isset($_POST['email'])){
if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) && isset($_SESSION['captcha'],$_POST['captcha']) && $_POST['captcha'] == $_SESSION['captcha']){
$email = trim(filter_var($_POST['email'],FILTER_SANITIZE_STRING));
$sql = "select username,concat_ws(' ',fname,lname) as 'fullname' from user where email=:em and type=1";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':em',$email,PDO::PARAM_STR);
$stmt->execute();
if($stmt->rowCount()){
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$username = $user['username'];
$fullname = $user['fullname'];
$_SESSION['timeout']=time();

$password = '';
$rsa->loadKey($privateKey);
$ciphertext = $rsa->encrypt($username);
$ciphertext_session = $ciphertext;
$ciphertext = base64_url_encode($ciphertext);



#==================================
require 'phpmailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->isSMTP();
//$mail->SMTPDebug = 1;
$mail->Host = 'ssl://smtp.gmail.com';                  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = '';        // SMTP username
$mail->Password = '';                  // SMTP password
$mail->SMTPSecure = 'ssl';                         // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465; //465 587 26;                  // TCP port to connect to

$mail->From = 'parsinegar2015@gmail.com';
$mail->FromName = 'Parsinegar2015';
$mail->addAddress($email, $fullname);     // Add a recipient
$mail->addBCC('parsinegar2015@gmail.com');

$mail->WordWrap = 50;
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Safe Login System';
$mail->Body    = 'Login Link: '.BASE_PATH.'/webroot.php?code='.$ciphertext; //
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.'; //.$mail->ErrorInfo;
    
} else {
    $_SESSION['SAFE_LOGIN'] = $ciphertext_session;
	if(isset($_SESSION['SAFE_LOGIN'])){
    echo 'Message has been sent';
	}
}
}else{
#NOT FOUND USER
$html = ' ';
}
}else{
#INVALID INPUT
$html = ' ';
}
}else{
$html = '
<!--WRAPPER-->
<div id="wrapper">

	<!--SLIDE-IN ICONS-->
    <div class="user-icon"></div>
    <div class="pass-icon"></div>
    <!--END SLIDE-IN ICONS-->

<!--LOGIN FORM-->
<form name="login-form" class="login-form" id="login_form" action="" method="post">

	<!--HEADER-->
    <div class="header">
    <!--TITLE--><h1>Login Form</h1><!--END TITLE-->
    <!--DESCRIPTION--><span>Fill out the form below to login to Administrator control panel.</span><!--END DESCRIPTION-->
    </div>
    <!--END HEADER-->
	
	<!--CONTENT-->
    <div class="content">
	<!--USERNAME--><input name="email" type="text" class="input username" autocomplete="off" value="" placeholder="Enter Email Address" /><!--END USERNAME-->
	<img src="captcha/captcha2.php" style="margin-top: 10px; margin-bottom: 10px;"/>
    <!--PASSWORD--><input name="captcha" type="text" class="input password" value="" placeholder="حاصل جمع؟" style="margin-top: 0px;" /><!--END PASSWORD-->
    </div>
    <!--END CONTENT-->
    
    <!--FOOTER-->
    <div class="footer">
    <!--LOGIN BUTTON--><input type="submit" name="btn" value="Verfication" id="login_btn" class="button" /><!--END LOGIN BUTTON-->
    </div>
    <!--END FOOTER-->

</form>
<!--END LOGIN FORM-->

</div>
<!--END WRAPPER-->
';
}



#==================================


}else if(isset($_SESSION['SAFE_LOGIN'])){
 $duration = time() - (int) $_SESSION['timeout'];
 if($duration >= $inactive) {
 unset($_SESSION['SAFE_LOGIN']);
 redirect(BASE_PATH.'/webroot.php',1);
 }
 if(isset($_POST['admin_x_login'],$_POST['admin_x_pass'])){
 //$rsa->loadKey($publicKey);
 //$rsa->decrypt(base64_url_decode($_GET['code']))
  if(isset($_GET['code']) && !empty($_GET['code']) && base64_url_decode($_GET['code']) == $_SESSION['SAFE_LOGIN']){
   #LOGIN
   $sql = "select * from user where username=:u and type=1";
   $stmt = $pdo->prepare($sql);
   $username = escape($_POST['admin_x_login']);
   $password = $_POST['admin_x_pass'];
   $stmt->bindValue(':u',$username,PDO::PARAM_STR);
   $stmt->execute();  
   if($stmt->rowCount()){
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
   //$_SESSION['f_id'] = $user->f_id;
   $_SESSION['permission'] = $user->permission;
   $_SESSION['token'] = token(20,TOKEN_KEY);
   redirect(BASE_PATH.'/me',1);
  }else{
   echo '<a href="'.CURRENT_URL.'">Try again</a>';
  }
  }else{
  redirect(BASE_PATH.'/index.php',1);
  }
 }else{ echo 'wrong info!'; }
}else{
  $html = '
<!--WRAPPER-->
<div id="wrapper">

	<!--SLIDE-IN ICONS-->
    <div class="user-icon"></div>
    <div class="pass-icon"></div>
    <!--END SLIDE-IN ICONS-->

<!--LOGIN FORM-->
<form name="login-form" class="login-form" action="" method="post" id="login_form">
<input type="hidden" name="admin_login" value="true"/>
	<!--HEADER-->
    <div class="header">
    <!--TITLE--><h1>Login Form</h1><!--END TITLE-->
    <!--DESCRIPTION--><span>Fill out the form below to login to Administrator control panel.</span><!--END DESCRIPTION-->
    </div>
    <!--END HEADER-->
	
	<!--CONTENT-->
    <div class="content">
	<!--USERNAME--><input name="admin_x_login" type="text" class="input username" autocomplete="off" value="" placeholder="username" /><!--END USERNAME-->
    <!--PASSWORD--><input name="admin_x_pass" type="password" class="input password" value="" placeholder="password" /><!--END PASSWORD-->
    </div>
    <!--END CONTENT-->
    
    <!--FOOTER-->
    <div class="footer">
    <!--LOGIN BUTTON--><input type="submit" name="submit" value="Login" class="button" id="login_btn" /><!--END LOGIN BUTTON-->
    </div>
    <!--END FOOTER-->

</form>
<!--END LOGIN FORM-->

</div>
<!--END WRAPPER-->
';
 }
}else{
redirect(BASE_PATH.'/index.php',1);
}
}else{
redirect(BASE_PATH.'/index.php',1);
}

		  
		  
if(!empty($html)){
echo '
<!doctype html>
<html lang="fa-IR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<title>Secure Login</title>
<style type="text/css">
body{ background: #ece7f1; outline: none; }
#wrapper {
	/* Center wrapper perfectly */
	width: 300px;
	height: 400px;
	position: absolute;
	left: 50%;
	top: 20%;
	margin-left: -150px;
	
}

/*******************
LOGIN FORM
*******************/

.login-form {
	width: 300px;
	margin: 0 auto;
	position: relative;
	z-index:5;
	
	background: #f3f3f3;
	border: 1px solid #fff;
	border-radius: 5px;
	
	box-shadow: 0 1px 3px rgba(0,0,0,0.5);
	-moz-box-shadow: 0 1px 3px rgba(0,0,0,0.5);
	-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.5);
}

/*******************
HEADER
*******************/

.login-form .header {
	padding: 40px 30px 30px 30px;
}

.login-form .header h1 {
	font-family: \'Bree Serif\', serif;
	font-weight: 300;
	font-size: 28px;
	line-height:34px;
	color: #414848;
	text-shadow: 1px 1px 0 rgba(256,256,256,1.0);
	margin-bottom: 10px;
}

.login-form .header span {
	font-size: 11px;
	line-height: 16px;
	color: #678889;
	text-shadow: 1px 1px 0 rgba(256,256,256,1.0);
}

/*******************
CONTENT
*******************/

.login-form .content {
	padding: 0 30px 25px 30px;
}

/* Input field */
.login-form .content .input {
	width: 188px;
	padding: 15px 25px;
	
	font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
	font-weight: 400;
	font-size: 14px;
	color: #9d9e9e;
	text-shadow: 1px 1px 0 rgba(256,256,256,1.0);
	
	background: #fff;
	border: 1px solid #fff;
	border-radius: 5px;
	
	box-shadow: inset 0 1px 3px rgba(0,0,0,0.50);
	-moz-box-shadow: inset 0 1px 3px rgba(0,0,0,0.50);
	-webkit-box-shadow: inset 0 1px 3px rgba(0,0,0,0.50);
}

/* Second input field */
.login-form .content .password, .login-form .content .pass-icon {
	margin-top: 25px;
}

.login-form .content .input:hover {
	background: #dfe9ec;
	color: #414848;
}

.login-form .content .input:focus {
	background: #dfe9ec;
	color: #414848;
	
	box-shadow: inset 0 1px 2px rgba(0,0,0,0.25);
	-moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.25);
	-webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.25);
}

.user-icon, .pass-icon {
	width: 46px;
	height: 47px;
	display: block;
	position: absolute;
	left: 0px;
	padding-right: 2px;
	z-index: 3;
	
	-moz-border-radius-topleft: 5px;
	-moz-border-radius-bottomleft: 5px;
	-webkit-border-top-left-radius: 5px;
	-webkit-border-bottom-left-radius: 5px;
}

.user-icon {
	top:167px; /* Positioning fix for slide-in, got lazy to think up of simpler method. */
	background: rgba(65,72,72,0.75) url(assets/img/user-icon.png) no-repeat center;	
}

.pass-icon {
	top:241px;
	background: rgba(65,72,72,0.75) url(assets/img/pass-icon.png) no-repeat center;
}

/* Animation */
.input, .user-icon, .pass-icon, .button, .register {
	transition: all 0.5s;
	-moz-transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-o-transition: all 0.5s;
	-ms-transition: all 0.5s;
}

/*******************
FOOTER
*******************/

.login-form .footer {
	padding: 25px 30px 40px 30px;
	overflow: auto;
	
	background: #d4dedf;
	border-top: 1px solid #fff;
	
	box-shadow: inset 0 1px 0 rgba(0,0,0,0.15);
	-moz-box-shadow: inset 0 1px 0 rgba(0,0,0,0.15);
	-webkit-box-shadow: inset 0 1px 0 rgba(0,0,0,0.15);
}

/* Login button */
.login-form .footer .button {
	float:right;
	padding: 11px 25px;
	
	font-family: \'Bree Serif\', serif;
	font-weight: 300;
	font-size: 18px;
	color: #fff;
	text-shadow: 0px 1px 0 rgba(0,0,0,0.25);
	
	background: #56c2e1;
	border: 1px solid #46b3d3;
	border-radius: 5px;
	cursor: pointer;
	
	box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
	-moz-box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
	-webkit-box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
}

.login-form .footer .button:hover {
	background: #3f9db8;
	border: 1px solid rgba(256,256,256,0.75);
	
	box-shadow: inset 0 1px 3px rgba(0,0,0,0.5);
	-moz-box-shadow: inset 0 1px 3px rgba(0,0,0,0.5);
	-webkit-box-shadow: inset 0 1px 3px rgba(0,0,0,0.5);
}

.login-form .footer .button:focus {
	position: relative;
	bottom: -1px;
	
	background: #56c2e1;
	
	box-shadow: inset 0 1px 6px rgba(256,256,256,0.75);
	-moz-box-shadow: inset 0 1px 6px rgba(256,256,256,0.75);
	-webkit-box-shadow: inset 0 1px 6px rgba(256,256,256,0.75);
}

</style>
<script src="'.BASE_PATH.'/assets/js/jquery.min.js"></script>
<script>
$(function(){

$(".username").focus(function() {
		$(".user-icon").css("left","-48px");
	});
	$(".username").blur(function() {
		$(".user-icon").css("left","0px");
	});
	
	$(".password").focus(function() {
		$(".pass-icon").css("left","-48px");
	});
	$(".password").blur(function() {
		$(".pass-icon").css("left","0px");
	});


$("#login_btn").click(function(event){
login_error = false;
$("#login_form input").each(function(){
self = $(this);
if(self.attr(\'type\') == \'text\' || self.attr(\'type\') == \'password\'){
if(self.val() == \'\'){
 self.css(\'border\',\'1px solid red\');
 login_error = true;
}
name = self.attr(\'name\');		
if(name == \'captcha\'){
if(!/^[\-\+]?\d+$/.test(self.val())){
self.css(\'border\',\'1px solid red\');
login_error = true;
  }
}
}
});
if(login_error){
event.preventDefault();
return false;
}
});


$("#login_form input[type=text]").live(\'blur\',function(){
	self = $(this);
	if(self.val() == \'\'){
		self.css(\'border\',\'1px solid red\');
		}else{
		  self.css(\'border\',\'1px solid #ccc\');	
			}
	  name = self.attr(\'name\');		
	  if(name == \'captcha\'){
		  if(!/^[\-\+]?\d+$/.test(self.val())){
			  self.css(\'border\',\'1px solid red\');
			  }
		  }		
	});
$("#login_form input[type=text]").live("keyup change click",function(){
	self = $(this);
	if(self.val() != \'\'){
		self.css(\'border\',\'1px solid #ccc\');
	}
	name = self.attr(\'name\');		
	  if(name == \'captcha\'){
		  if(!/^[\-\+]?\d+$/.test(self.val())){
			  self.css(\'border\',\'1px solid red\');
			  }
		  }	
	});
});	
</script>
</head>
<body>

'.$html.'

</body>
</html
';
}
}

?>