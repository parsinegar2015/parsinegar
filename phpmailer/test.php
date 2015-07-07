<?php
require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();      
//$mail->SMTPDebug  = 4;                                // Set mailer to use SMTP
$mail->Host = 'ssl://smtp.gmail.com'; //smtp.gmail.com mail.google.com  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'parsinegar2015@gmail.com';                 // SMTP username
$mail->Password = '1236987458741';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465; //465 587 26;                                    // TCP port to connect to

$mail->From = 'parsinegar2015@gmail.com';
$mail->FromName = 'Parsinegar2015';
$mail->addAddress('parsnet4u@gmail.com', 'Ali Smith');     // Add a recipient
$mail->addBCC('parsinegar2015@gmail.com');
//$mail->addReplyTo('parsinegar2015@gmail.com', 'Information');

$mail->WordWrap = 50;
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Safe Login System';
$mail->Body    = 'Login Link: <a href="http://a">gsghjehethkgowkgwoghhjkheh;ed</a>'; //
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}


?>