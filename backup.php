<?php

try{
$dsn = 'mysql:dbname='.DATABASE.';host='.HOST.';';
		   $pdo = new PDO($dsn,LOGIN,PASSWORD,array(PDO::ATTR_EMULATE_PREPARES => false, 
                                                                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		   $pdo->exec("set names utf8");
		 }catch(PDOException $e){
	       echo $e->getMessage();
	      }
		  

function is_connected()
{
    $connected = @fsockopen("www.dropbox.com", 80); 
                                        //website, port  (try 80 or 443)
    if ($connected){
        $is_conn = true; //action when connected
        fclose($connected);
    }else{
        $is_conn = false; //action in connection failure
    }
    return $is_conn;

}


$css = '
#backup_wrap{ width: 900px; float: left; margin-left: 50px; }
.file_row_head{ width: 400px; height: 30px; float: left; }
.sps_head{ width: 50px; height: 30px; float: left; }
.restore_head{ width: 200px; height: 30px; background: #f2f2f2; float: left; }
.file_bg{ background: #f7f7f7; }
.file_row{ width: 400px; height: 100px; float: left; background: #f7f7f7; margin-top: 10px; }
.sps_row{ width: 50px; height: 100px; background: #f7f7f7; float: left; margin-top: 10px; }
.restore_row{ width: 200px; height: 100px; background: #f2f2f2; float: left; margin-top: 10px; }
.mkb{ width: 150px; height: 35px; outline: none; border: 1px solid #ccc; border-radius: 5px; float: left; margin-top: 40px; margin-left: 15px; cursor: pointer; font-weight: bold; }
.mkb:hover{ border: 1px solid #f7f7f7; }
';



function backup_tables($host,$user,$pass,$name,$tables = '*')
{
	
	$link = mysql_connect($host,$user,$pass);
	mysql_query("set names 'utf8'");
	mysql_select_db($name,$link);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	$return = '';
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	
	#=============================================
	$head = '-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2015 at 02:38 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `'.$name.'`
--
CREATE DATABASE IF NOT EXISTS `'.$name.'` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `'.$name.'`;

-- --------------------------------------------------------
';
	$return = $head."\n\n".$return;
	#=============================================
	
	
	
	//Prepare Sql
	$ptrn1 = 'CREATE\s*TABLE\s*\`([a-zA-Z0-9-.\/-_]+)\`\s*\(\s*(.*)\s*\)\s*ENGINE(.*)';
    $ptrn2 = 'CONSTRAINT\s*(.*)\s*FOREIGN\s*KEY\s*\((.*)\)\s*REFERENCES\s*(.*)\s*\((.*)\)\s*ON\s*DELETE\s*CASCADE';
    $ptrn3 = 'KEY\s*(.*)\s*\((.*)\)\,';
    $constraints = array();
    preg_match_all("/$ptrn1/siU",$return,$match);

    foreach($match[0] as $m){
    $mi = $m;
    preg_match_all("/$ptrn2/siU",$m,$mm);
    if($len = count($mm[0])){
	   $table = preg_replace("/$ptrn1/s","$1",$m);
	   $constraints[$table] = array();
	   $i=0;
        while($i < $len){
		 $m = str_replace($mm[0][$i],'',$m);
		 $constraints[$table][] = $mm[0][$i];
		 $m = preg_replace("/$ptrn3/s","KEY $1 ($2)",$m);
		 $i++;
		}
  $return = str_replace($mi,$m,$return);
		
  }
 }
	if(!empty($constraints)){
	foreach($constraints as $tbl => $ctArr){
	 $return = $return."\n\nALTER TABLE `$tbl`\n";
	 foreach($ctArr as $ct){
	  $return = $return."ADD ".$ct.";\n";
	 }
	}
	}
	
	//save file
	$name = 'db-backup_'.date('y-m-d_h-i-s').'.sql';
	$path = 'dbbackup'.DS;
	$handle = fopen($path.$name,'w+');
	fwrite($handle,$return);
	fclose($handle);
	return $name;
}



function formatbytes($file, $type){
     switch($type){
      case "KB":
         $filesize = filesize($file) * .0009765625; // bytes to KB
      break;
      case "MB":
         $filesize = (filesize($file) * .0009765625) * .0009765625; // bytes to MB
      break;
      case "GB":
         $filesize = ((filesize($file) * .0009765625) * .0009765625) * .0009765625; // bytes to GB
      break;
   }
   if($filesize <= 0){
      return $filesize = 'unknown file size';}
   else{return round($filesize, 2).' '.$type;}
  }


  
function dropboxBackup($file,$name){

/**
 * Upload a file to the authenticated user's Dropbox
 * @link https://www.dropbox.com/developers/reference/api#files-POST
 * @link https://github.com/BenTheDesigner/Dropbox/blob/master/Dropbox/API.php#L80-110
 */

// Require the bootstrap
require_once('dropbox/examples/bootstrap.php');

// Create a temporary file and write some data to it
//$tmp = tempnam('/tmp', 'dropbox');
//$data = 'This file was uploaded using the Dropbox API!';
//file_put_contents($tmp, $data);

$data = fopen($file,"r");
$tmp = tempnam('/tmp', 'dropbox');
file_put_contents($tmp, $data);

try {
    // Upload the file with an alternative filename
    $put = $dropbox->putFile($tmp,$name); //api_upload_test
    
	// Unlink the temporary file
    unlink($tmp);
	
	return true;
} catch (\Dropbox\Exception\BadRequestException $e) {
  
   // Unlink the temporary file
   unlink($tmp);  

  // The file extension is ignored by Dropbox (e.g. thumbs.db or .ds_store)
    return false;
}

}  
  
  
  

function backup($pdo){
global $today;
$path = 'dbbackup'.DS;
$backup = backup_tables(HOST,LOGIN,PASSWORD,DATABASE);
$filesize = formatbytes($path.$backup,'KB');

$sql = "insert into backup.backup(`file`,`backupdate`,`size`) values(:b,:bd,:fs)";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':b',$backup,PDO::PARAM_STR);
$stmt->bindvalue(':bd',$today,PDO::PARAM_STR);
$stmt->bindvalue(':fs',$filesize,PDO::PARAM_STR);
$stmt->execute();
if(is_connected()){
dropboxBackup($path.$backup,$backup);
}

redirect(BASE_PATH.'/backup/?token='.$_SESSION['token'],1);

}


function dropboxDBfiles(){
// Require the bootstrap
include('dropbox/examples/bootstrap.php');
$ret = array();
$metaData = $dropbox->metaData('');

foreach($metaData['body']->contents as $file){
    $f = str_replace("/", "", $file->path);
    $ret[] = $f;
}
$dropbox = false;
return $ret;
}

function view($pdo){
$data = '';
$template = '<div class="file_row">{file}<br/><b>size:</b>&nbsp;{size}</div>
<div class="restore_row">{dropbox}</div>
<div class="sps_row"></div>
<div class="restore_row">{local}</div>
<div class="sps_row"></div>';

$sql = "select * from backup.backup";
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$html = array();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$internet = false;
if(is_connected()){
$internet = true;
}
foreach($rows as $row){
$tpl = $template;
$tpl = str_replace('{file}',$row['file'],$tpl);
$tpl = str_replace('{size}',$row['size'],$tpl);
if($internet){
$a_drop = '<a href="'.BASE_PATH.'/backup/?do=restore&type=cloud&file='.$row['file'].'&token='.$_SESSION['token'].'"><img src="'.BASE_PATH.'/assets/img/restore.png" align="absmiddle"/>&nbsp;Restore</a>';
}else{
$a_drop = '';
}
$tpl = str_replace('{dropbox}',$a_drop,$tpl);
$a_local = '<a href="'.BASE_PATH.'/backup/?do=restore&type=local&file='.$row['file'].'&token='.$_SESSION['token'].'"><img src="'.BASE_PATH.'/assets/img/restore.png" align="absmiddle"/>&nbsp;Restore</a>';
$tpl = str_replace('{local}',$a_local,$tpl);
$html[] = $tpl;

}

$data = implode("\n",$html);
}
$html = '<div class="file_row" style="background: none;">
<input type="button" value="+Make Backup" class="mkb" onClick=\'window.location="'.BASE_PATH.'/backup/?do=backup&token='.$_SESSION['token'].'"\'/>
</div>

<div id="backup_wrap">
<div class="file_row_head"></div>
<div class="restore_head"><img src="'.BASE_PATH.'/assets/img/dropbox.png" align="absmiddle"/>&nbsp;Dropbox Storage</div>
<div class="sps_head"></div>
<div class="restore_head"><img src="'.BASE_PATH.'/assets/img/localdata.png" align="absmiddle"/>&nbsp;Local Storage</div>
<div class="sps_head"></div>
<div class="file_row_head file_bg">File</div>
<div class="restore_head"></div>
<div class="sps_head file_bg"></div>
<div class="restore_head"></div>
<div class="sps_head file_bg"></div>
{data}
</div>
';

echo str_replace('{data}',$data,$html);

}


function dropboxRestore($file){
// Require the bootstrap
include('dropbox/examples/bootstrap.php');

// Set the file path
// You will need to modify $path or run putFile.php first
$path = $file;

// Set the output file
// If $outFile is set, the downloaded file will be written
// directly to disk rather than storing file data in memory
$outFile = false;

try {
    // Download the file
    $file = $dropbox->getFile($path, $outFile);
    file_put_contents('dbbackup'.DS.'dropbox'.DS.$path,$file['data']);
	return true;
} catch (\Dropbox\Exception\NotFoundException $e) {
    // The file wasn't found at the specified path/revision
    //echo 'The file was not found at the specified path/revision';
	
	return false;
}
}



function import_to_db($file){

/*
 * Restore MySQL dump using PHP
 * (c) 2006 Daniel15
 * Last Update: 9th December 2006
 * Version: 0.2
 * Edited: Cleaned up the code a bit. 
 *
 * Please feel free to use any part of this, but please give me some credit :-)
 */
 
// Name of the file
$filename = $file;
// MySQL host
$mysql_host = HOST;
// MySQL username
$mysql_username = LOGIN;
// MySQL password
$mysql_password = PASSWORD;
// Database name
$mysql_database = DATABASE;

//////////////////////////////////////////////////////////////////////////////////////////////

// Connect to MySQL server
mysql_connect($mysql_host, $mysql_username, $mysql_password); // or die('Error connecting to MySQL server: ' . mysql_error());
// Select database
mysql_select_db($mysql_database); // or die('Error selecting MySQL database: ' . mysql_error());

// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line)
{
	// Skip it if it's a comment
	if (substr($line, 0, 2) == '--' || $line == '')
		continue;

	// Add this line to the current segment
	$templine .= $line;
	// If it has a semicolon at the end, it's the end of the query
	if (substr(trim($line), -1, 1) == ';')
	{
		// Perform the query
		mysql_query($templine);  // or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
		// Reset temp variable to empty
		$templine = '';
	}
}

}




function restore($pdo){
if(isset($_GET['type'],$_GET['file']) && !empty($_GET['type']) && !empty($_GET['file'])){
$type = $_GET['type'];
$file = trim($_GET['file']);
$internet = false;
if($type == 'cloud'){
if(is_connected()){
$internet = true;
$drop_sql = dropboxDBfiles();
if(in_array($file,$drop_sql)){


if(dropboxRestore($file)){
import_to_db('dbbackup'.DS.'dropbox'.DS.$file);
}
}
}


}else if($type == 'local'){
if(file_exists('dbbackup'.DS.$file)){
import_to_db('dbbackup'.DS.$file);
}
}
}
redirect(BASE_PATH.'/backup/?token='.$_SESSION['token'],1);
}

		  
		  
$error = true;

if(validRequest()){
if(isset($_SESSION['login']) && $_SESSION['permission'] == 'admin'){
if(isset($_GET['token']) && $_GET['token'] == $_SESSION['token']){
$error = false;
$do = 'view';
if(isset($_GET['do']) && !empty($_GET['do'])){
$do = trim(strtolower($_GET['do']));
}
switch($do){
case 'view':
view($pdo);
break;
case 'backup':
backup($pdo);
break;
case 'restore':
restore($pdo);
break;
}
 }
}
}

if($error){
redirect(BASE_PATH.'/index.php',1);
}

		  
		  
?>