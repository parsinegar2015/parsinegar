<?php
header('Content-Type: text/html; charset=utf-8');
function html_list($text){
$xh = explode("\n",$text);
echo '<pre>';
print_r($xh);
echo '</pre>';
$ptrn_fa = '([^\n]*)\s*[^\n]-';
$ptrn_en = '^\s*-[^\n]\s*(.*?)';
$list_fa = false;
$list_en = false;
$list = false;

$out = array();
foreach($xh as $line){
preg_match("/$ptrn_fa/siU",$line,$mfa);
preg_match("/$ptrn_en/siU",$line,$men);
if(!empty($mfa)){
if($list_en){
$list_en = false;
$out[] = '</ul>';
}
if(!$list_fa){
$list_fa = true;
$out[] = '<ul dir="rtl">';
}
$out[] = '<li>'.$mfa[1].'</li>';

}else if(!empty($men)){
if($list_fa){
$list_fa = false;
$out[] = '</ul>';
}
if(!$list_en){
$list_en = true;
$out[] = '<ul dir="ltr">';
}
$out[] = '<li>'.$men[1].'</li>';

}else{
if($list_fa || $list_en){
$list_fa = false;
$list_en = false;
$out[] = '</ul>';
}
//if(mb_detect_encoding($line, 'UTF-8', true)){
//$out[] = '<p style="text-align: right;">'.$line.'</p>';
//}else{
$out[] = $line;
//}
}
}
return implode("\n",$out);
}



if(isset($_POST['txt']) && !empty($_POST['txt'])){




$ptrn_fa = '#[^\n]*\n+#';
 
preg_match_all($ptrn_fa, $_POST['txt'], $matches_out);
$matches_out=$matches_out[0];
 
foreach($matches_out as $m_o){
 
if(substr(trim($m_o),-1)=="-")
     echo '<ul dir="rtl"><li>'.trim($m_o).'</li></ul>'.PHP_EOL;
elseif($m_o[0]=="-")
     echo '<ul><li>'.trim($m_o).'</li></ul>'.PHP_EOL;
else{
    if(mb_detect_encoding($m_o, 'UTF-8', true))
        echo '<p style="text-align: right;">'.$m_o.'</p>'.PHP_EOL;
    else
        echo '<p>'.$m_o.'</p>'.PHP_EOL;
} 
}
}

echo "\n<br/>------------------------<br/>\n";

echo html_list($_POST['txt']);
?>

<?php 
 
 /*
 
 select get_lock('register', -1)



select 1 from `accounts` where `email`=...



insert into `accounts` ...



select release_lock('register')

*/
 
?>


<form method="post">
<textarea name="txt" dir="rtl"></textarea>
<br/>
<input type="submit" value="send"/>
</form>