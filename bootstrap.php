<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
ini_set('session.cookie_lifetime', 86400);
ini_set('session.gc_maxlifetime', 86400);
session_start();
ini_set('default_charset',"UTF-8");
date_default_timezone_set("Asia/Tehran"); //UTC
define("DS",DIRECTORY_SEPARATOR);
function baseUrl($target,$lvl=1){
		
		$server_https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';  
        $server_port = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != 80;  
        $scheme = ($server_https || $server_port) ? 'https://' : 'http://';  	
        $host = $_SERVER['HTTP_HOST'];
        $path = trim(filter_var($_SERVER['PHP_SELF'],FILTER_SANITIZE_STRING)); //$_SERVER['PHP_SELF'];
        $pArr = explode('/',$path);
        $len = count($pArr);
        $len = $len - $lvl;
        $path = implode('/',array_slice($pArr,0,$len));
		
		$url = $scheme.$host.$path.$target;
		
		return $url;
}
$base_url = baseUrl('');
///////////////
define("BASE_PATH",$base_url);
////////////////////
$server_https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';  
$server_port = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != 80;  
$scheme = ($server_https || $server_port) ? 'https://' : 'http://'; 
$current_url = $scheme.filter_var($_SERVER['HTTP_HOST'],FILTER_SANITIZE_STRING).filter_var($_SERVER['REQUEST_URI'],FILTER_SANITIZE_STRING);
///////////////
define("CURRENT_URL",$current_url);
////////////////////
if(isset($_SERVER['HTTP_REFERER'])){
$back_address = filter_var($_SERVER['HTTP_REFERER'],FILTER_SANITIZE_STRING);
}else{
$back_address = BASE_PATH.'index.php';
}
///////////////
define("BACK_ADDRESS",$back_address);
////////////////////
define("DIR",$_SERVER['DOCUMENT_ROOT']);
////////////////////
$url = $current_url;
if(strstr($url,'PHPSESSID') || strstr($url,'phpsessid') || strstr($url,'sid') || strstr($url,'SID')){
	$url = str_replace('PHPSESSID','',$url);
	$url = str_replace('phpsessid','',$url);
	$url = str_replace('sid','',$url);
	$url = str_replace('SID','',$url);
	//header("HTTP/1.1 301 Moved Permanently"); 
    header("Location: $url"); 
    exit(); 
	}
////////////////////
function redirect($path='/',$lvl=2,$header=301){
switch($header){
	case 301:
	 $header = 'HTTP/1.1 301 Moved Permanently';
	break;
	case 403:
	 $header = 'HTTP/1.1 403 Forbidden';
	break;
	}
$url = $path;	
if(is_array($path)){
$dir = each($path);
$url = BASE_PATH.'/'.$dir['key'].'/'.$dir['value'];
}	

if($lvl >= 2){
$url = baseUrl($url,$lvl);
}
header($header);
header("Location: $url");
exit();
}
////////////////////
function validRequest(){
 if(isset($_SERVER['HTTP_REFERER'])){
	if(@strtolower(parse_url(filter_var($_SERVER['HTTP_REFERER'],FILTER_SANITIZE_STRING), PHP_URL_HOST)) == strtolower(filter_var($_SERVER['HTTP_HOST'],FILTER_SANITIZE_STRING))){   
	   return true;
	   }
	return false;
	}
	return true;
 }
////////////////////
////////
function ajax(){
	 if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) =='xmlhttprequest'){ return true; }
	return false;	
	}
///////
////////////////////
function escape($val,$trim=true){
		if($trim){
		 $val = trim($val);
		}
		return preg_replace("/\s*/",'',filter_var($val,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH));
		}
////////////////////
require_once("config".DS."config.php");
require_once 'lib'.DS.'functions.php';
require_once 'lib'.DS.'log.php';
require_once 'lib'.DS.'jdf.class.php';

$jd = new jalaliDate();
$day_number = $jd->jdate('j');
$month_number = $jd->jdate('n');
$year_number = $jd->jdate('y');
$day_name = $jd->jdate('l');
$today = $year_number.'/'.$month_number.'/'.$day_number;


function term(){
global $month_number,$year_number;
if($month_number <= 1 || $month_number <= 6){
return array('id'=>2,'title'=>$year_number.' نیمسال دوم - سال');	
}
return array('id'=>1,'title'=>$year_number.' نیمسال اول - سال');
}


function is_latin($text){
	
	$permitted_chars="/^([a-zA-Z0-9-\s\!\?\[\]\(\)])*$/u";

    if(preg_match($permitted_chars, $text)) return true;
	
	 return false;
	
	}


	
#|------====[paginate]====------|#
require_once 'lib'.DS.'pagination.class.php';
$item_pre_page = 10;
$btn_pre_page = 10;
$paginate = new pagination();
#|------====[paginate]====------|#


#IE BLOCKING#
/*$u_agent = $_SERVER['HTTP_USER_AGENT'];
if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'ie'; 
        $ub = "MSIE"; 
		redirect(BASE_PATH.'/block.html',1);
    }*/


preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
if(count($matches)<2){
  preg_match('/Trident\/\d{1,2}.\d{1,2}; rv:([0-9]*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
}

if (count($matches)>1){
  //Then we're using IE
  redirect(BASE_PATH.'/block.html',1);
}	
	
#SET SITE LANGUAGE#
/*$query = parse_url(CURRENT_URL, PHP_URL_QUERY);
if(!empty($query)){
$en = CURRENT_URL.'&lang=en';
$fa = CURRENT_URL.'&lang=fa';
}else{
$en = CURRENT_URL.'?lang=en';
$fa = CURRENT_URL.'?lang=fa';
}
define("FA_LANG_URL",$fa);
define("EN_LANG_URL",$en);*/
if(validRequest()){
//if(isset($_SERVER['HTTP_REFERER'])){
//$fragment = strtolower(parse_url(filter_var($_SERVER['HTTP_REFERER'],FILTER_SANITIZE_STRING), PHP_URL_FRAGMENT));
if(isset($_POST['langx']) && !empty($_POST['langx'])){
$fragment = strtolower($_POST['langx']);
if($fragment == 'en'){
//redirect('www.google.com',1);
setcookie("sys_config_language_interface","en",time()+3600*24*30,'/');
}else if($fragment == 'fa'){
setcookie("sys_config_language_interface","fa",time()+3600*24*30,'/');
}
}
//}
}
if(isset($_COOKIE['sys_config_language_interface']) && in_array($_COOKIE['sys_config_language_interface'],array('fa','en'))){
if(isset($_POST['langx']) && !empty($_POST['langx'])){
$fragment = strtolower($_POST['langx']);
if($fragment == 'en'){
define("DEFAULT_LANGUAGE",'en');
}else if($fragment == 'fa'){
define("DEFAULT_LANGUAGE",'fa');
}
}else{
define("DEFAULT_LANGUAGE",$_COOKIE['sys_config_language_interface']);
}
}else{
define("DEFAULT_LANGUAGE",'fa');
}
require_once 'config'.DS.'language.php';



require_once 'app'.DS.'app.php';

$app = new app();




?>