<?php

ob_start("ob_gzhandler");

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Drakonnas Realm minecraft game server">
    <meta name="author" content="InstanceLabs">

    <title>Drakonnas Realm</title>
    
	<link href='http://fonts.googleapis.com/css?family=Lobster+Two:700&v2' rel='stylesheet' type='text/css'>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="carousel.css" rel="stylesheet">

	<style>
	h3 { font-family: 'Lobster Two'; margin: 20px 0; line-height: 1em; }
	</style>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

  </head>
<!-- NAVBAR
================================================== -->
  <body>
  
  
  
    <div class="navbar-wrapper">
      <div class="container">

        <div class="navbar navbar-inverse navbar-static-top" role="navigation">
          <div class="container">
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="info/">Help/Info</a></li>
                <li><a href="players.php">Players</a></li>
                <li><a href="bans.php">Bans</a></li>
                <li><a href="votes.php">Voting</a></li>
                <li><a href="staff.php">Staff</a></li>
                <li><a href="store/">Shop</a></li>
                <li><a href="forum.php">Forum</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Account <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li class="customhandler"><a href="#myModal" data-target="#myModal" data-toggle="modal">Login</a></li>
                    <li class="customhandler"><a href="#myModal2" data-target="#myModal2" data-toggle="modal">Register</a></li>
                    <li class="customhandler2 hide"><a href="logout.php?referer=<?php echo(basename(__FILE__, '.php')); ?>">Logout</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>


    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel" data-ride="carousel">
      <div class="carousel-inner">
        <div class="item active">
          <img id="bgimage" src="dragon.jpeg" alt="Drakonnas Realm" style="width: 100%; height: auto;">
          <div class="container">
            <div class="carousel-caption">
              <p><img src='logo.png'></p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign in</a></p>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.carousel -->

    <div class="container marketing">
      <div class="row">
  		<div class="col-md-8">
        <h3>What's in the news?</h3>
        <?php
include "config.php";
$count = 10;

$con = mysql_connect($localhost, $mysqlusername, $mysqlpassword);
mysql_select_db("$db", $con);

$query = mysql_query("SELECT * FROM posts ORDER BY id DESC LIMIT $count")or die(mysql_error());



while($row2 = mysql_fetch_array($query))
{
	$id = $row2['id'];
	$content = $row2['content'];
	$user = $row2['user'];
	$date = date("d.m.Y", strtotime($row2['date']));
	$headline = $row2['headline'];
	

   echo("<div class='well'><font size='+3'>".$headline."</font><br><font size='-2' style='font-family:Arial'>Posted  by <font color='#FF0000'>".$user."</font> at <font color='#FF0000'>".$date."</font></font><br><hr>".$content."</div><br>");

}
?>
        </div>
  		<div class="col-md-4">
        
        <div class="well"> 
        <h3>Is the server up?</h3>
        <?php
		include "config.php";
		$count = 10;
		$con = mysql_connect($localhost, $mysqlusername, $mysqlpassword);
		mysql_select_db("$db", $con);
		
		$query = mysql_query("SELECT * FROM players WHERE online='1'")or die(mysql_error());
		
		$count = 0;
		
		while($row2 = mysql_fetch_array($query))
		{
			$count += 1;
		}

		
		function ping($host, $c, $port=25565, $timeout=1) { 
			$handle = fsockopen($host, $port, $errno, $errstr, $timeout);
			try {
				fwrite($handle, "\xFE");
				$d = fread($handle, 256);
				
				if ($d[0] != "\xFF") return array('motd' => "", 'players' => "?", 'max_players' => "?");
				$d = substr($d, 3);
				$d = mb_convert_encoding($d, 'auto', 'UCS-2');
				$d = explode("\xA7", $d);
				fclose($handle);
			} catch(Exception $e) {
				//echo 'Caught exception: ',  $e->getMessage(), "n";
				return;
			}
			
			echo("IP: mc.drakonnaspvp.com<br>");
			echo("STATUS: <font color='#00FF00'>ONLINE</font>!<br>");
			echo("PLAYERS: $c/50<br>");
			//echo("MOTD: $d[0]");
			//return array('motd' => $d[0], 'players' => (int)$d[1], 'max_players' => (int)$d[2]);
		}
		
		try {
			ping("127.0.0.1", $count);
		} catch(Exception $e) {
			echo("STATUS: <font color='#FF0000'>OFFLINE</font>1");
		}

		
		?>
        
        </div>
        
        <div class="well">
        <h3> Who's online? </h3>
<?php
include "config.php";
$count = 10;
$con = mysql_connect($localhost, $mysqlusername, $mysqlpassword);
mysql_select_db("$db", $con);

$query = mysql_query("SELECT * FROM players WHERE online='1'")or die(mysql_error());

$count = 0;

while($row2 = mysql_fetch_array($query))
{
	$count += 1;
   	echo(" <img src='face.php?u=" . $row2['player'] ."&s=32' class='ppoints' data-toggle='tooltip' title='".$row2['player']."' />");
}

if($count < 1){
	echo("No players currently online!");
}
?>
        </div>
        
		<div class="well">
        <h3> Who has the most points? </h3>
<?php
include "config.php";
$con = mysql_connect($localhost, $mysqlusername, $mysqlpassword);
mysql_select_db("$db", $con);

$query = mysql_query("SELECT * FROM players ORDER BY points DESC LIMIT 5")or die(mysql_error());

while($row2 = mysql_fetch_array($query))
{
   	echo(" <p><img id='" . $row2['player'] . "' src='face.php?u=".$row2['player']."&s=32' class='ppoints' data-toggle='tooltip' title='".$row2['player']."' /> ".$row2['points']." DR Points</p>");
}

?>
		</div>
		
		<div class="well">
			<h3> Who is online the most time? </h3>
<?php
include "config.php";
$con = mysql_connect($localhost, $mysqlusername, $mysqlpassword);
mysql_select_db("$db", $con);

$query = mysql_query("SELECT * FROM players ORDER BY timespent DESC LIMIT 10")or die(mysql_error());

while($row2 = mysql_fetch_array($query))
{
	$thingy = round($row2['timespent'] / 3600, 2); // convert seconds to hours
   	echo(" <p><img id='" . $row2['player'] . "' src='face.php?u=".$row2['player']."&s=32' class='ppoints' data-toggle='tooltip' title='".$row2['player']."' /> ".$thingy." h</p>");
}

?>
		</div>
        </div>
	  </div>



      <!-- FOOTER -->
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2013 DrakonnasRealm &middot; by <a href="http://www.github.com/instance01">InstanceLabs</a></p>
      </footer>

    </div><!-- /.container -->




    <!-- Modal -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3 id="myModalLabel">Sign in</h3>
      </div>
      <div class="modal-body">
      <form role="form" method="get" action="login.php">
          <div class="form-group">
            <label for="InputEmail1">Email address</label>
            <input type="email" name="email" class="form-control" id="InputEmail1" placeholder="E-Mail">
          </div>
          <div class="form-group">
            <label for="InputPassword1">Password</label>
            <input type="password" name="pw" class="form-control" id="InputPassword1" placeholder="Password">
          </div>
          <input type="hidden" name="referer" value="<?php echo(basename(__FILE__, '.php')); ?>">
          <button type="submit" class="btn btn-success btn-block">Submit</button>
        </form>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Cancel</button>
      </div>
    </div>
    </div>
      
    </div>
    </div>
    
    
    
    <!-- Modal -->
    <div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3 id="myModalLabel">Register</h3>
      </div>
      <div class="modal-body">
      <form role="form" method="get" action="register.php">
      	  <div class="form-group">
            <label for="InputUser2">Username</label>
            <input type="text" name="username" class="form-control" id="InputUser2" placeholder="Username">
          </div>
          <div class="form-group">
            <label for="InputEmail2">Email address</label>
            <input type="email" name="email" class="form-control" id="InputEmail2" placeholder="E-Mail">
          </div>
          <div class="form-group">
            <label for="InputPassword2">Password</label>
            <input type="password" name="pw" class="form-control" id="InputPassword2" placeholder="Password">
          </div>
          <button type="submit" class="btn btn-success btn-block">Submit</button>
        </form>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Cancel</button>
      </div>
    </div>
    </div>
      
    </div>
    </div>


    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
    <script>
     $(document).ready(function () {
     	$(".ppoints").tooltip();
		
		$("#InstanceLabs").mouseover(function(e) {
            $(this).effect("bounce");
        });
		
		if ((screen.width>=1800) && (screen.height>=890)) {
		 	$("#bgimage").css("top", "-300px");
			//alert("Working?");
		}

   	 });
	</script>
    
    <?php
	include "config.php";

	if(isset($_COOKIE['drakonnaspvp'])){
		$cookie = $_COOKIE['drakonnaspvp'];
		$content = base64_decode ($cookie);
		list($email, $hashed_password) = explode (':', $content);
		
		$con = mysql_connect($localhost, $mysqlusername, $mysqlpassword);
		mysql_select_db("$db", $con);
		
		$query = mysql_query("SELECT * FROM players WHERE email='$email'")or die(mysql_error());
		
		
		
		while($row2 = mysql_fetch_array($query))
		{
			$pw = $row2['password'];
			
			if(md5($pw) == $hashed_password){
				// user is logged in
				echo('<script>$(document).ready(function(e) {$(".customhandler").addClass("hide");$(".customhandler2").removeClass("hide");var f = $(".dropdown-toggle").html(); $(".dropdown-toggle").html(f + " ('.$email.')");});</script>');
			}else{
				// wrong password
			}
		}
	}
	else{
		// Cookie is not set
	}
	?>
  </body>
</html>
