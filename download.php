<?php
include('bootstrap.php');
if(isset($_SESSION['login'])){
if(isset($_GET['file']) && !empty($_GET['file'])){
if(strstr($_GET['file'],'_')){
$file = explode('_',$_GET['file']);
if(intval($file[0]) && intval($file[1])){
$fullPath = 'assets/d/'.$file[0].'/'.$file[1].'.pdf';
if(file_exists($fullPath) && is_readable($fullPath)){
try{
$dsn = 'mysql:dbname='.DATABASE.';host='.HOST.';';
		   $pdo = new PDO($dsn,LOGIN,PASSWORD,array(PDO::ATTR_EMULATE_PREPARES => false, 
                                                                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		   $pdo->exec("set names utf8");
		 }catch(PDOException $e){
	       echo $e->getMessage();
	      }

#=SET QTY=======================================================		  
$f = trim($_GET['file']);		  
$sql = "update files set quantity = quantity+1 where file=:f";	
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':f',$f,PDO::PARAM_STR);	  
$stmt->execute();
#==============================================================
		  

if($fullPath) {
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);
    switch ($ext) {
        case "pdf":
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a download
        header("Content-type: application/pdf"); // add here more headers for diff. extensions
        break;
        default;
        header("Content-type: application/octet-stream");
        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
    }
    if($fsize) {//checking if file size exist
      header("Content-length: $fsize");
    }
    readfile($fullPath);
    exit;
}
}
}
}
}
}
?>