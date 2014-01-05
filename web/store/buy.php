<?php
	include "../config.php";

	if(isset($_COOKIE['drakonnaspvp'])){
		$cookie = $_COOKIE['drakonnaspvp'];
		$content = base64_decode ($cookie);
		list($email, $hashed_password) = explode (':', $content);
		
		$con = mysql_connect($dbhost, $dbuser, $dbpass);
		mysql_select_db("$db", $con);
		
		$query = mysql_query("SELECT * FROM players WHERE email='$email'")or die(mysql_error());
		
		
		
		while($row2 = mysql_fetch_array($query))
		{
			$pw = $row2['password'];
			
			if(md5($pw) == $hashed_password){
				// user is logged in
				$itemid = $_GET['id'];
				$player = $row2['player'];
				$currentpoints = $row2['points'];
				$query2 = mysql_query("SELECT * FROM shop WHERE id='$itemid'")or die(mysql_error());
				while($row3 = mysql_fetch_array($query2))
				{
					$name = $row3['name'];
					$command2 = str_replace('<player>', $player, $row3['command']);
					$command = str_replace('<group>', $name, $command2);
					$currentcost = $row3['cost'];
					if($currentpoints >= $currentcost){
						// user can afford it
						$newpoints = $currentpoints - $currentcost;
						// save new points
						// save into transactions and get them on player login too (bukkit plugin)
						mysql_query("UPDATE players SET points=$newpoints WHERE player='$player'")or die(mysql_error());
						mysql_query("INSERT INTO item_transactions VALUES ('0', '$itemid', '$player', '$command')")or die(mysql_error());
					}
				}
			}else{
				// wrong password
			}
		}
	}
	else{
		// Cookie is not set
	}
	
	header("location: index.php");
	
	

?>