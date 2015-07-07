<?php
include('bootstrap.php');
$title   = '';
$content = '';
$keyword = '';
if(isset($_SESSION['login'])){
try{
$dsn = 'mysql:dbname='.DATABASE.';host='.HOST.';';
		   $pdo = new PDO($dsn,LOGIN,PASSWORD,array(PDO::ATTR_EMULATE_PREPARES => false, 
                                                                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		   $pdo->exec("set names utf8");
		 }catch(PDOException $e){
	       echo $e->getMessage();
	      }

	
	if(isset($_GET['type'],$_GET['print']) && in_array(trim(strtolower($_GET['type'])),array('article','thesis')) && intval($_GET['print']) && is_numeric($_GET['print'])){
	$table = strtolower($_GET['type']);
	$sql = "select * from $table where status=1 and id=".intval($_GET['print']);
	$stmt = $pdo->query($sql);
	if($stmt->rowCount()){
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$title   = $row['title'];
	$content = $row['content'];
	$keyword = $row['keyword'];
	if($table == 'article' && $row['lang'] == 'en'){
	#Article
	$title   = $row['title_en'];
	$content = $row['content_en'];
	$keyword = $row['keyword_en'];
	}
	$title   = '<div class="title">'.$title.'</div>';
	$content = '<div>'.$content.'<div>';
	$keyword = '<div class="keyword">'.$keyword.'<div>';
	}
	}
	}
	
?>


<html>
<head>
<style type="text/css">
div{ width: 100%; float: left; margin-top: 15px; font-size: 18px; }
.title{ height: 100px; font-weight: bold; font-size: 24px; }
.keyword{ height: 100px; font-weight: bold; }
</style>
<script>
window.print();
</script>
</head>
<body>
<?php
echo $title."\n";
echo $content."\n";
echo $keyword."\n";
?>
</body>
</html>

