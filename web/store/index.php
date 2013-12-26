<?php

ob_start("ob_gzhandler");

require_once("./include/config.php");

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
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../carousel.css" rel="stylesheet">

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
                <li><a href="../index.php">Home</a></li>
                <li><a href="../info/">Help/Info</a></li>
                <li><a href="../players.php">Players</a></li>
                <li><a href="../bans.php">Bans</a></li>
                <li><a href="../votes.php">Voting</a></li>
                <li><a href="../staff.php">Staff</a></li>
                <li class="active"><a href="#">Shop</a></li>
                <li><a href="../forum.php">Forum</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Account <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li class="customhandler"><a href="#myModal" data-target="#myModal" data-toggle="modal">Login</a></li>
                    <li class="customhandler"><a href="#myModal2" data-target="#myModal2" data-toggle="modal">Register</a></li>
                    <li class="customhandler2 hide"><a href="../logout.php?referer=<?php echo(basename(__FILE__, '.php')); ?>">Logout</a></li>
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
          <img id="bgimage" src="../dragon.jpeg" alt="Drakonnas Realm" style="width: 100%; height: auto;">
          <div class="container">
            <div class="carousel-caption">
              <p><img src='../logo.png'></p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign in</a></p>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.carousel -->



    <div class="container marketing">
    <?php
	$points = 0;
	if(isset($_COOKIE['drakonnaspvp'])){
		$cookie = $_COOKIE['drakonnaspvp'];
		$content = base64_decode ($cookie);
		list($email, $hashed_password) = explode (':', $content);
	
		$con = mysql_connect($mysql_hostname, $mysql_user, $mysql_password);
		mysql_select_db("$mysql_database", $con);
		
		$query = mysql_query("SELECT * FROM players WHERE email='$email'")or die(mysql_error());
		
		while($row2 = mysql_fetch_array($query))
		{
			$points = $row2['points'];
		}
	}
	?>
    <h3>Your balance: <?php echo($points); ?></h3>
    <div class="well">
    
    <h3>Points Shop</h3>
    <div class="row">
    <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="../diamond.png" alt="DR Points">
      <div class="caption">
        <h3>300 DR Points - 1$</h3>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_self">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business" value="<?php echo $paypal; ?>"/>
<input type="hidden" name="item_name" value="Purchase 300 DR Points for account <?php echo $email; ?>"/>
<input type="hidden" name="item_number" value="<?php echo $email; ?>"/>
<input type="hidden" name="amount" value="1"/> <!-- 1$ -->
<input type="hidden" name="return" value="http://mc.drakonnaspvp.com/store/index.php">
<input type="hidden" name="cancel_return" value="http://mc.drakonnaspvp.com/store/index.php" />
<input type="hidden" name="notify_url" value="http://mc.drakonnaspvp.com/store/ipn.php">
<input type="hidden" name="custom" value="1"/>
<input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>"/>
<center><input type='submit' class="btn btn-block btn-success" value='Purchase 300 DR Points' /></center>
</form>       
      </div>
    </div>
    </div>

    <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="../diamond.png" alt="DR Points">
      <div class="caption">
        <h3>1500 DR Points - 5$</h3>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_self">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business" value="<?php echo $paypal; ?>"/>
<input type="hidden" name="item_name" value="Purchase 1500 DR Points for account <?php echo $email; ?>"/>
<input type="hidden" name="item_number" value="<?php echo $email; ?>"/>
<input type="hidden" name="amount" value="5"/> <!-- 5$ -->
<input type="hidden" name="return" value="http://mc.drakonnaspvp.com/store/index.php">
<input type="hidden" name="cancel_return" value="http://mc.drakonnaspvp.com/store/index.php" />
<input type="hidden" name="notify_url" value="http://mc.drakonnaspvp.com/store/ipn.php">
<input type="hidden" name="custom" value="2"/>
<input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>"/>
<center><input type='submit' class="btn btn-block btn-success" value='Purchase 1500 DR Points' /></center>
</form>        
      </div>
    </div>
    </div>
    
    <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="../diamond.png" alt="DR Points">
      <div class="caption">
        <h3>3000 DR Points - 10$</h3>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_self">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business" value="<?php echo $paypal; ?>"/>
<input type="hidden" name="item_name" value="Purchase 3000 DR Points for account <?php echo $email; ?>"/>
<input type="hidden" name="item_number" value="<?php echo $email; ?>"/>
<input type="hidden" name="amount" value="10"/> 
<input type="hidden" name="return" value="http://mc.drakonnaspvp.com/store/index.php">
<input type="hidden" name="cancel_return" value="http://mc.drakonnaspvp.com/store/index.php" />
<input type="hidden" name="notify_url" value="http://mc.drakonnaspvp.com/store/ipn.php">
<input type="hidden" name="custom" value="3"/>
<input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>"/>
<center><input type='submit' class="btn btn-block btn-success" value='Purchase 3000 DR Points' /></center>
</form>        
      </div>
    </div>
    </div>

    <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="../diamond.png" alt="DR Points">
      <div class="caption">
        <h3>6000 DR Points - 18$</h3>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_self">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business" value="<?php echo $paypal; ?>"/>
<input type="hidden" name="item_name" value="Purchase 6000 DR Points for account <?php echo $email; ?>"/>
<input type="hidden" name="item_number" value="<?php echo $email; ?>"/>
<input type="hidden" name="amount" value="18"/> 
<input type="hidden" name="return" value="http://mc.drakonnaspvp.com/store/index.php">
<input type="hidden" name="cancel_return" value="http://mc.drakonnaspvp.com/store/index.php" />
<input type="hidden" name="notify_url" value="http://mc.drakonnaspvp.com/store/ipn.php">
<input type="hidden" name="custom" value="4"/>
<input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>"/>
<center><input type='submit' class="btn btn-block btn-success" value='Purchase 6000 DR Points' /></center>
</form>        
      </div>
    </div>
    </div>
    
    
    <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="../diamond.png" alt="DR Points">
      <div class="caption">
        <h3>12000 DR Points - 35$</h3>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_self">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business" value="<?php echo $paypal; ?>"/>
<input type="hidden" name="item_name" value="Purchase 12000 DR Points for account <?php echo $email; ?>"/>
<input type="hidden" name="item_number" value="<?php echo $email; ?>"/>
<input type="hidden" name="amount" value="35"/> 
<input type="hidden" name="return" value="http://mc.drakonnaspvp.com/store/index.php">
<input type="hidden" name="cancel_return" value="http://mc.drakonnaspvp.com/store/index.php" />
<input type="hidden" name="notify_url" value="http://mc.drakonnaspvp.com/store/ipn.php">
<input type="hidden" name="custom" value="5"/>
<input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>"/>
<center><input type='submit' class="btn btn-block btn-success" value='Purchase 12000 DR Points' /></center>
</form>        
      </div>
    </div>
    </div>
    
    
    <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="../diamond.png" alt="DR Points">
      <div class="caption">
        <h3>24000 DR Points - 75$</h3>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_self">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business" value="<?php echo $paypal; ?>"/>
<input type="hidden" name="item_name" value="Purchase 24000 DR Points for account <?php echo $email; ?>"/>
<input type="hidden" name="item_number" value="<?php echo $email; ?>"/>
<input type="hidden" name="amount" value="75"/> 
<input type="hidden" name="return" value="http://mc.drakonnaspvp.com/store/index.php">
<input type="hidden" name="cancel_return" value="http://mc.drakonnaspvp.com/store/index.php" />
<input type="hidden" name="notify_url" value="http://mc.drakonnaspvp.com/store/ipn.php">
<input type="hidden" name="custom" value="6"/>
<input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>"/>
<center><input type='submit' class="btn btn-block btn-success" value='Purchase 24000 DR Points' /></center>
</form>        
      </div>
    </div>
    </div>
    </div>


	</div>
    
    <div class="well">
    
    <h3>Ranks Shop</h3>
    <div class="row">
    <?php
	$con = mysql_connect($mysql_hostname, $mysql_user, $mysql_password);
		mysql_select_db("$mysql_database", $con);
		
		$query = mysql_query("SELECT * FROM shop")or die(mysql_error());
		
		while($row2 = mysql_fetch_array($query))
		{
			$id = $row2['id'];
			$cost = $row2['cost'];
			$name = $row2['name'];
			echo('<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="../emerald.png" alt="wat lulz">
      <div class="caption">
        <h3>' . $name . ' - ' . $cost .' DR Points</h3>
<form action="buy.php" method="get" target="_self">
<input type="hidden" name="id" value="'.$id.'">
<center><input type="submit" class="btn btn-block btn-success" value="Purchase" /></center>
</form>
      </div>
    </div>
    </div>');

		}
	?>
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
    <script src="../js/bootstrap.min.js"></script>
    
    <script>
     $(document).ready(function () {
     	$(".ppoints").tooltip();
		
		if ((screen.width>=1800) && (screen.height>=890)) {
		 	$("#bgimage").css("top", "-300px");
			//alert("Working?");
		}
		
		$("#searchbtn").click(function(e){
			$(".ppoints").css("box-shadow", "0px 0px 0px #000000");
			var f = $("#searchbar").val().toLowerCase();
			$('.ppoints').each(function() {
				var id = this.id.toLowerCase();
				if(id.indexOf(f) != -1){
					$("#" + this.id).effect("pulsate");
					$("#" + this.id).css("box-shadow", "0 0 3px 3px #0044AA");
				}
			});
			
			return false;
		});
   	 });
	</script>
    
    
            <?php
	include "config.php";

	if(isset($_COOKIE['drakonnaspvp'])){
		$cookie = $_COOKIE['drakonnaspvp'];
		$content = base64_decode ($cookie);
		list($email, $hashed_password) = explode (':', $content);
		
		$con = mysql_connect($mysql_hostname, $mysql_user, $mysql_password);
		mysql_select_db("$mysql_database", $con);
		
		$query = mysql_query("SELECT * FROM players WHERE email='$email'")or die(mysql_error());
		
		
		
		while($row2 = mysql_fetch_array($query))
		{
			$pw = $row2['password'];
			
			if(md5($pw) == $hashed_password){
				// user is logged in
				echo('<script>$(document).ready(function(e) {$(".customhandler").addClass("hide");$(".customhandler2").removeClass("hide");var f = $(".dropdown-toggle").html(); $(".dropdown-toggle").html(f + " ('.$email.')");});</script>');
			}else{
				// wrong password
				echo('<script>alert("You need to be logged in to access the web shop!"); location.href="../index.php";</script>');
			}
		}
	}
	else{
		// Cookie is not set
		echo('<script>alert("You need to be logged in to access the web shop!"); location.href="../index.php";</script>');
	}
	?>
  </body>
</html>
