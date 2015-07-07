<?php
class app{
 
 public static $errorHandler = '';
 
 public static $ROUTE_GET  = 'rout::get';
 public static $ROUTE_POST = 'rout::post';
 
 private static $default_app = '';
 private static $lambda = array();
 private static $_get = array();
 private static $_post = array();
 
 /*public function set($do,$method){
  self::$lambda[$do] = $method;
 }*/
 
 public function defaultRoute($app){
  self::$default_app = $app;
 return $this;
 }
 
 private function _run($prop){
 $error = false;
 if(is_callable($prop['closure'])){
	  if(is_array($prop['filter'])){
	  $error = true;
	  foreach($prop['filter'] as $k => $v){
	  $isset_k = false;
	   if(preg_match('/^auth_(.*)/i',$k,$m)){
	   if(isset($_SESSION[$m[1]])){
	    $error = false;
		$k = $_SESSION[$m[1]];
		$isset_k = true;
	   }
	   }else if(preg_match('/^get_(.*)/i',$k,$m)){
	   if(isset($_GET[$m[1]])){
	    $error = false;
		$k = $_GET[$m[1]];
		$isset_k = true;
	   }
	   }
	   #==============================================
	   if(preg_match('/^auth_(.*)/i',$v,$m)){
	   if(isset($_SESSION[$m[1]]) && $_SESSION[$m[1]] == $k){
	    $error = false;
	   }else{
	    $error = true;
		break;
	   }
	   }else if(preg_match('/^get_(.*)/i',$v,$m)){
	   if(isset($_GET[$m[1]]) && $_GET[$m[1]] == $k){
	    $error = false;
	   }else{
	    $error = true;
		break;
	   }
	   }else if(is_numeric($k)){
	   if(preg_match('/^(\!*)auth_(.*)/i',$v,$m)){
	   if(($m[1]=='!')? !isset($_SESSION[$m[2]]) : isset($_SESSION[$m[2]])){
	    $error = false;
	   }else{
	    $error = true;
		break;
	   }
	   }else if(preg_match('/^(\!*)get_(.*)/i',$v,$m)){
	   if(($m[1]=='!')? !isset($_GET[$m[2]]) : isset($_GET[$m[2]])){
	    $error = false;
	   }else{
	    $error = true;
		break;
	   }
	   }else{
	   if($v){
	   $error = false;
	   }else{
	   $error = true;
	   break;
	   }
	   }
	   }else{
	   if($isset_k){
	   if($k == $v){
	    $error = false;
	   }else{
	    $error = true;
		break;
	   }
	   }else{
	   $error = true;
	   }
	   }
	  }
	  }
	  if(!$error){
	   return call_user_func_array($prop['closure'], $prop['arguments']);
	  }else if(is_callable(self::$errorHandler)){
	  var_dump(self::$errorHandler);
	   return call_user_func(self::$errorHandler, []);
	  }
	 }
 }
 
 public static function run($rout=null,$action=null,$arguments=array(),$app=''){
 $error = false;
 if(!is_null($rout) && is_array($action)){
 if($rout == 'rout::get'){
  $arr_get = self::$_get;
  $closure = $arr_get[array_keys($action)[0]][array_values($action)[0]]['closure'];
  return call_user_func_array($closure, $arguments);
 }
 }else{
  $arr_get = self::$_get;
  if(!empty($arr_get)){ //(isset($_GET) && !empty($_GET) && !empty($arr_get)) || (is_array($app) && !empty($arr_get))
  
  foreach($arr_get as $rg => $v){
   if(isset($_GET[$rg])){
    $key = strtolower($_GET[$rg]);
	foreach($arr_get[$rg] as $action => $prop){
	 if($action == $key){
	  return self::_run($prop);
	 }
	}
   }
  }
  if(!empty(self::$default_app)){
   //self::run(null,null,array(),self::$default_app);
   #default app
   $key    = array_keys(self::$default_app)[0];
   $action = array_values(self::$default_app)[0];
   if(isset($arr_get[$key]) && isset($arr_get[$key][$action])){
   $app = $arr_get[$key][$action];
   return self::_run($app);
  }
  }
  
  }
  
  }

 }
 
 public function __call($method,$args){
 
 if(preg_match('/^get(.*)/i',$method,$match)){
  if(!isset(self::$_get[strtolower($match[1])])){
   self::$_get[strtolower($match[1])] = array();
  }
  if(count($args) && !is_callable($args[0])){
   $filter    = '';
   $closure   = '';
   $arguments = array();
   $s=3;
   if(count($args) == 2){
   if(is_array($args[1])){ $filter = $args[1]; }
   if(is_callable($args[1])){ $closure = $args[1]; }
   }else if(count($args) >= 3){
   if(is_array($args[1])){ $filter = $args[1]; }
   if(is_callable($args[1])){ $closure = $args[1]; }
   if(empty($closure)){
   if(is_callable($args[2])){ $closure = $args[2]; }
   }else{
    $s = 2;
   }
   $arguments = array_slice($args,$s);
   }
   self::$_get[strtolower($match[1])][strtolower($args[0])] = array(
    'filter'   => $filter,
	'closure'  => $closure,
	'arguments' => $arguments
   );
   }
   
 }
 
 }
 
}
?>