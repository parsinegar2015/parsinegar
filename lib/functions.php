<?php

function dropdown($data,$name,$keyname,$valuename,$selectedOption=''){
if(is_array($data) && !empty($name) && !empty($data) && !empty($keyname) && !empty($keyname) && count(array_diff(array($keyname,$valuename), array_keys($data[0]))) == 0){
$ret = array();
$ret[] = '<select name="'.$name.'">';
$ret[] = '<option selected disabled>Choose here</option>';
foreach($data as $opt){
$selected = "";
if($opt[$valuename] == $selectedOption){
$selected = ' selected="selected"';
}
$ret[] = '<option value="'.$opt[$valuename].'"'.$selected.'>'.$opt[$keyname].'</option>';
}
$ret[] = '</select>';
return implode("\n",$ret);
}
}

?>