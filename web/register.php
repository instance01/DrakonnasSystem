<?php
require 'phpmailer/PHPMailerAutoload.php';
include "config.php";

$email = $_GET['email'];
$password = $_GET['pw'];
$user = $_GET['username'];

$con = mysql_connect($localhost, $mysqlusername, $mysqlpassword);
mysql_select_db("$db", $con);

$query = mysql_query("SELECT * FROM players WHERE player='$user' AND registerkey <> 'y'")or die(mysql_error());
$query2 = mysql_query("SELECT * FROM players WHERE email='$email'")or die(mysql_error());

$uid = md5(uniqid());

if(mysql_num_rows($query) < 1){
	// player was not on the server yet -> can't register
	echo("You need to join the server first before registering!");
}else{
	
	if(mysql_num_rows($query2) > 0){
		// email already there -> can't register
		echo("E-Mail already in database!");
	}else{
		$query = mysql_query("UPDATE players SET email='$email',password='$password',registerkey='" . $uid . "' WHERE player='$user'")or die(mysql_error());
		$msg = "Please follow this link to complete the registration: http://mc.drakonnaspvp.com/complete.php?uid=".$uid."&username=".$user;
		//mail($email, 'DrakonnasPVP Registration', $msg, null, '-finstancelabs@drakonnaspvp.com');


		$mail = new PHPMailer;
		
		//$mail->isSMTP();                                      // Set mailer to use SMTP
		//$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup server
		//$mail->SMTPAuth = true;                               // Enable SMTP authentication
		//$mail->Username = 'jswan';                            // SMTP username
		//$mail->Password = 'secret';                           // SMTP password
		//$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
		
		$mail->From = 'instancelabs@drakonnaspvp.com';
		$mail->FromName = 'InstanceLabs';
		$mail->addAddress($email);  // Add a recipient
		$mail->addReplyTo('instancelabs@drakonnaspvp.com', 'Information');
		
		$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
		$mail->isHTML(true);                                  // Set email format to HTML
		
		$mail->Subject = 'DrakonnasPVP Registration';
		$mail->Body    = $msg;
		$mail->AltBody = $msg;
		
		if(!$mail->send()) {
		   echo('Message could not be sent.');
		   echo('Mailer Error: ' . $mail->ErrorInfo);
		   exit;
		}

		echo("Successfully registered. Now check the verification e-mail that was sent to you and click the link in it.");
	}
}




?>