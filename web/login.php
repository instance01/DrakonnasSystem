<?php
include "config.php";

$email = $_GET['email'];
$password = $_GET['pw'];
$referer = $_GET['referer'];

if(empty($_GET['email'])){
	header("location: $referer".".php");
	exit();	
}

$con = mysql_connect($localhost, $mysqlusername, $mysqlpassword);
mysql_select_db("$db", $con);

$query = mysql_query("SELECT * FROM players WHERE email='$email' AND registerkey='y'")or die(mysql_error());



while($row2 = mysql_fetch_array($query))
{
	$pw = $row2['password'];
	
	if($pw == $password){
		$cookie = base64_encode ("$email:" . md5 ($pw));
		setcookie ('drakonnaspvp', $cookie);
		
		if (empty($_GET['referer'])){
			$referer = "index";	
		}
		header("location: $referer".".php");
	}
}

if (empty($_GET['referer'])){
	$referer = "index";	
}

header("location: $referer".".php");

?>


Login failed. Please contact <a href="http://github.com/instance01">InstanceLabs</a> <img src='face.php?u=InstanceLabs&s=32'> and drop him the following message: <?php echo($referer." ".md5($password)); ?>
<hr><a href="index.php">Return to homepage </a>

