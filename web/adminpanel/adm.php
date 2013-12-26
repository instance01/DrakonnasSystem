<?php

ob_start("ob_gzhandler");

require_once("../config.php");
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
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="../info/">Help/Info</a></li>
                <li><a href="../players.php">Players</a></li>
                <li><a href="../bans.php">Bans</a></li>
                <li><a href="../votes.php">Voting</a></li>
                <li><a href="../staff.php">Staff</a></li>
                <li><a href="../store/">Shop</a></li>
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
              <p><a class="btn btn-lg btn-primary" role="button" href="#myModal" data-target="#myModal" data-toggle="modal">Sign in</a></p>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.carousel -->

    <div class="container marketing">

<?php
$email = "";
if(isset($_COOKIE['drakonnaspvp'])){
		$cookie = $_COOKIE['drakonnaspvp'];
		$content = base64_decode ($cookie);
		list($email_, $hashed_password) = explode (':', $content);
		$email = $email_;
}else{
	
}

?>

		<div class="well">
        <h3>New Post</h3>
        <form role="form" method="get" action="action.php">
          <div class="form-group">
            <label for="titleinput">Title</label>
            <input type="text" name="title" class="form-control" id="titleinput" placeholder="Title">
          </div>
          <div class="form-group">
            <label for="contentarea">Content</label>
            <textarea name="content" class="form-control" id="contentarea" placeholder="Content"></textarea>
          </div>
          <input type="hidden" name="email" value="<?php echo($email); ?>">
          <input type="hidden" name="action" value="newpost">
          <button type="submit" class="btn btn-success btn-block">Submit</button>
        </form>
        </div>


		<div class="well">
        <h3>Edit Ranks Shop</h3>
        <div class="row">
        <?php
		
        $con = mysql_connect($dbhost, $dbuser, $dbpass);
        mysql_select_db("$dbname", $con);
        
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
        <form action="action.php" method="get" target="_self">
        <input type="hidden" name="id" value="'.$id.'">
		<input type="hidden" name="action" value="removeshopitem">
        <center><input type="submit" class="btn btn-block btn-danger" value="Remove" /></center>
        </form>
        </div>
        </div>
        </div>');
        
        }
        ?>
        </div>
        <div class="row">
        <h3>New Shop Item</h3>
        <form role="form" method="get" action="action.php">
          <div class="form-group">
            <label for="nameinput">Name</label>
            <input type="text" name="name" class="form-control" id="nameinput" placeholder="Name">
          </div>
          <div class="form-group">
            <label for="costinput">Cost</label>
            <input type="text" name="cost" class="form-control" id="costinput" placeholder="Cost">
          </div>
          <input type="hidden" name="email" value="<?php echo($email); ?>">
          <input type="hidden" name="action" value="newshopitem">
          <button type="submit" class="btn btn-success btn-block">Add</button>
        </form>
        </div>
        </div>
    
    
    	
      <!-- FOOTER -->
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2013 DrakonnasRealm &middot; by <a href="http://www.github.com/instance01">InstanceLabs</a></p>
      </footer>

    </div><!-- /.container -->


    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    
    <script>
     $(document).ready(function () {
     	$(".ppoints").tooltip();
		
		$("#InstanceLabs").mouseover(function(e) {
            $(this).effect("pulsate");
        });
		$("#InstanceLabs1").mouseover(function(e) {
            $(this).effect("pulsate");
        });
		
		if ((screen.width>=1800) && (screen.height>=890)) {
		 	$("#bgimage").css("top", "-300px");
			//alert("Working?");
		}

   	 });
	</script>
    
            <?php

	if(isset($_COOKIE['drakonnaspvp'])){
		$cookie = $_COOKIE['drakonnaspvp'];
		$content = base64_decode ($cookie);
		list($email, $hashed_password) = explode (':', $content);
		
		$con = mysql_connect($dbhost, $dbuser, $dbpass);
        mysql_select_db("$dbname", $con);
		
		$query = mysql_query("SELECT * FROM players WHERE email='$email'")or die(mysql_error());
		
		
		
		while($row2 = mysql_fetch_array($query))
		{
			$pw = $row2['password'];
			
			if($row2['rank'] != "owner" && $row2['rank'] != "head-dev"){
				echo('<script>alert("You need to be logged in to access the admin panel!"); location.href="../index.php";</script>');
			}else{
				if(md5($pw) == $hashed_password){
					// user is logged in
					echo('<script>$(document).ready(function(e) {$(".customhandler").addClass("hide");$(".customhandler2").removeClass("hide");var f = $(".dropdown-toggle").html(); $(".dropdown-toggle").html(f + " ('.$email.')");});</script>');
				}else{
					// wrong password
					echo('<script>alert("You need to be logged in to access the admin panel!"); location.href="../index.php";</script>');
				}
			}
		}
	}
	else{
		// Cookie is not set
		echo('<script>alert("You need to be logged in to access the admin panel!"); location.href="../index.php";</script>');
	}
	?>
  </body>
</html>
