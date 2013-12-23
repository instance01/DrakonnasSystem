<?php
include "config.php";

$uid = $_GET['uid'];
$username = $_GET['username'];

if(empty($uid) || empty($username)){
	echo("Unknown ID or USERNAME. Contact InstanceLabs to complete your registration manually.");	
}else{
	$con = mysql_connect($localhost, $mysqlusername, $mysqlpassword);
	mysql_select_db("$db", $con);
	
	$query = mysql_query("UPDATE players SET registerkey='y' WHERE player='$username'")or die(mysql_error());
	header("location: index.php");
}

?>