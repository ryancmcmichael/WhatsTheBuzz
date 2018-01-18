<?php
//	CHECK TO SEE IF WE HAVE A TEMP ID
	if(!isset($_SESSION['TID']))
	{	
		header("location:./");
		session_start();		
	}
?>
<!DOCTYPE html><head>
<meta charset="utf-8">
<title><?php echo TITLE;?>: About</title>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/landing.css"/>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Customer Insight, tagging, mobile, suveys, better business, relationship management">
<meta name="author" content="John Brenton Phillips">
<link rel="shortcut icon" href="<?php echo HOST;?>assets/ico/favicon.ico">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<style>
div.pmtsummary{text-align:center}
</style>
  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
         <?php 
			$page = "overview";
			require("inc/nav.php");
		?>
        </ul>
        <h3 class="text-muted"><span class='myHeader' id='mast-header'><?php echo TITLE;?></span></h3>
      </div>

       <div class="row pmtsummary">
	  <!-- SUMMARY AND GUIDANCE THAT AN EMAIL IS BEING SENT TO CONFIRM THE ACCOUNT -->
	  	<h1>Thank you!</h1>
		<h3>Click <a href="signin">here</a> to sign in</h3>
	  </div>

      <div class="navbar navbar-fixed-bottom survey-footer" >
        <p><?php echo COPY;?></p>
      </div>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="<?php echo HOST;?>/js/pubnav.js"></script>

</body>

</html>
<?php
//	KILL SESSIONS AFTER WE DISPLAY THE PAGE
	$_SESSION = array();
	session_destroy();

?>