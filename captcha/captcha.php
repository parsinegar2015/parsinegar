<?php
ob_start();
session_start();
$card;
$color = array();
$num1 = rand(1,9);
$num2 = rand(1,9);
$_SESSION['captcha'] = (int) $num1 + $num2;
$font = "times.ttf";
#--------------------

    function openCardVector(){
	    global $card,$color;
		$card = imagecreatefrompng('secbg.png');
		$color['Black'] = imagecolorallocate($card, 0, 0, 0);
		$color['blue'] = imagecolorallocate($card, 0, 0, 255);
		$color['red'] = imagecolorallocate($card, 255, 0, 0);
		}
	
	
	
	function param(){
		global $card,$color,$font,$num1,$num2;
		$opt = array('size'=>28,'angle'=>0,'left'=>30,'top'=>40,'color'=>$color['red'],'font'=>$font,'content'=>$num1.' + '.$num2);
					
				imagettftext($card, $opt['size'], $opt['angle'], $opt['left'], $opt['top'], $opt['color'], $opt['font'], $opt['content']);
		
		
		}



  function save(){
	  global $card;
	  
	  header('Content-Type: image/png');

      imagepng($card); //,'captcha.png'

      //imagedestroy($card);
	  
	  }


#===============================================

openCardVector();
param();
save();


?>