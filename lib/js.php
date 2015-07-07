<?php
namespace parsinegar;

require 'jsmin.php';

class js{

 #Properties....
 
 /**
  *@var string  $path
  */
  public $path = '';
 
 
 
 
 /**
  *@param string  $file
  *@param string  $data
  *@param boolean $append
  *return bool
  */
 public function file($file,$data='',$append=false){
  try{
  if($append === true){
   file_put_contents($this->path.$file.'.js',$data,FILE_APPEND);
  }else{
   if(!empty($data)){
   file_put_contents($this->path.$file.'.js',$data);
   }else if(!file_exists($this->path.$file.'.js')){
    return false;
   }
  }
  return true;
  }catch(\Exception $e){
  return false;
  }
 }
 
 
 
 /**
  *@param string  $file
  *@param array   $datamapper
  *return boolean
  */
 public function push($file,$datamapper){
  if(file_exists($this->path.$file.'.js') && is_array($datamapper) && !empty($datamapper)){
   $js = $this->get($file);
   foreach($datamapper as $k => $v){
    $js = str_replace('{'.$k.'}',$v,$js);
   }
   return $this->file($file,$js);
  }
 }
 
 
 
 /**
  *@param string  $file
  *@param string  $js
  *return boolean
  */
 public function comp($file,$js){
  if(file_exists($this->path.$file.'.js')){
   $js_file = $this->get($file);
    $f = strcmp($js_file,$js);
	if($f == 0) return true;
  }
  return false;
 }
 
 
 
 /**
  *@param string  $file
  *return string
  */
 public function get($file){
  if(file_exists($this->path.$file.'.js')){
   return file_get_contents($this->path.$file.'.js');
  }
 }
 
 
 
 /**
  *@param string  $js
  *return string
  */
 public static function min($js){
 
 return \JSMin::minify($js);
 }
 
}

