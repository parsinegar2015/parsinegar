<?php
function _log($type_do,$msg,$xdata=''){
$time = date('H:i:s');
$file_name = date('Y-m-d');
$backtrace = debug_backtrace();
$logInfo = $backtrace[1];
/*Array
(
    [file] => C:\xampp\htdocs\article\index.php
    [line] => 50
    [function] => test
    [args] => Array
        (
        )

)*/
if(isset($_SESSION['username'])){
$user = $_SESSION['username'];
}else{
$user = '';
}

$header = "
_____________________________________________________________________________________________\n
\n
LOG FILE [$file_name]\n
_____________________________________________________________________________________________\n
\n\n\r
";

$tdarr = explode('_',$type_do);
$ip    = $_SERVER['REMOTE_ADDR'];
$flag  = strtoupper($tdarr[0]);
$do    = strtoupper($tdarr[1]);

switch($tdarr[1]){
case 'edit':
$do_msg = 'Update Record';
if($tdarr[0] != 'info'){
$do_msg = 'Prevent editing records';
}
break;
case 'delete':
$do_msg = 'Remove Record';
if($tdarr[0] != 'info'){
$do_msg = 'Avoid deleting records';
}
break;
case 'add':
$do_msg = 'Insert New Record';
if($tdarr[0] != 'info'){
$do_msg = 'Prevent the insertion of new records';
}
break;
case 'upload':
$do_msg = 'Uploaded New File';
if($tdarr[0] != 'info'){
$do_msg = 'Prevent the upload new file';
}
break;
}

$logInfo_file = 'undefined';
if(array_key_exists('file',$logInfo)){
$logInfo_file = $logInfo['file'];
}

$logInfo_line = 'undefined';
if(array_key_exists('line',$logInfo)){
$logInfo_file = $logInfo['line'];
}

$logInfo_function = 'undefined';
if(array_key_exists('function',$logInfo)){
$logInfo_file = $logInfo['function'];
}

$xmsg = $file_name.' '.$time.' ['.$ip.'] : '.$flag.' - ['.$do.'] '.$do_msg.', '.$msg."\n
\n =TraceInfo ========================
\n [file] => ".$logInfo_file."
\n [line] => ".$logInfo_line."
\n [function] => ".$logInfo_function."
\n [user] => ".$user."
\n [data] => ".$xdata."
\n ================================
";
$data = $xmsg." \n";
if(file_exists('log'.DS.$file_name.'.log')){
file_put_contents('log'.DS.$file_name.'.log', $data, FILE_APPEND | LOCK_EX);
}else{
$data = $header.$data;
file_put_contents('log'.DS.$file_name.'.log', $data);
}
}
?>