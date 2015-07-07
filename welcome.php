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


if(isset($_SESSION['login']) && $_SESSION['login'] == true){
$sql = "select start from user where id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':id',intval($_SESSION['userId']),PDO::PARAM_INT);
$stmt->execute();
if($stmt->rowCount()){
$start = $stmt->fetchColumn();
if($start == 1){
redirect(BASE_PATH.'/me',1);
}else{
$sql = "update user set start=1 where id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':id',intval($_SESSION['userId']),PDO::PARAM_INT);
$stmt->execute();
echo '
<style type="text/css">
.perfect_btn {
	display: inline-block;
	color: #666;
	background-color: #eee;
	text-transform: uppercase;
	letter-spacing: 2px;
	font-size: 12px;
	padding: 10px 30px;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border: 1px solid rgba(0,0,0,0.3);
	border-bottom-width: 3px;
	margin-bottom: 30px;
}

	.perfect_btn:hover {
		background-color: #e3e3e3;
		border-color: rgba(0,0,0,0.5);
	}
	
	.perfect_btn:active {
		background-color: #CCC;
		border-color: rgba(0,0,0,0.9);
	}
</style>
<center>
<br/><br/><br/>
<br/><br/><br/>
<img src="'.BASE_PATH.'/assets/img/user.png" />
<br/><br/>
<b>'.$_LANGUAGE['welcome_passege'][DEFAULT_LANGUAGE].'</b>
<br/><br/>
<input type="button" name="" class="perfect_btn" value="'.$_LANGUAGE['control_panel'][DEFAULT_LANGUAGE].'" onClick=\'window.open("'.BASE_PATH.'/me","_self")\'/>
<br/><br/>
</center>
';
}
}else{
redirect(BASE_PATH,1);
}
}else{
redirect(BASE_PATH,1);
}
?>