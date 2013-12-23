<?php
$referer = $_GET['referer'];


if(isset($_COOKIE['drakonnaspvp'])) {
  unset($_COOKIE['drakonnaspvp']);
  setcookie('drakonnaspvp', '', time() - 3600);
}

if (empty($_GET['referer'])){
	$referer = "index";	
}
header("location: $referer".".php");


?>


Logout failed. Please contact <a href="http://github.com/instance01">InstanceLabs</a> <img src='face.php?u=InstanceLabs&s=32'> 
<hr><a href="index.php">Return to homepage </a>

