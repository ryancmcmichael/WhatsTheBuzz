<?php

if(!isset($_SESSION['userid']))
{
	header("location:../");
}
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title><?php echo TITLE;?>: Administration</title>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/landing.css"/>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Customer Insight, tagging, mobile, suveys, better business, relationship management">
<meta name="author" content="John Brenton Phillips">
<link rel="shortcut icon" href="<?php echo HOST;?>/favicon.ico">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    #hello-there{float:right;}
    </style>
  </head>

  <body>

    <div class="container">
     <div class="header">
        <ul class="nav nav-pills pull-right">

        </ul>
	   <h3 class="text-muted"><span id='mast-header'><?php echo TITLE;?></span>: admin
	   <span id='hello-there'><?php echo "Welcome ". $_SESSION['fname'];?></span>
	   </h3>
	</div>
	   <br>
	   	<?php
		include('admin_nav.php');
		?>

<?php
	//	THE $_SESSION variables URL, SurveyCode, and QRPath WILL BE SET FOR THIS PAGE THROUGH EITHER
	//	SIGNIN OR SIGNUP PROCESS.
	//	HANDLE THE URL / IMAGE BUILD HERE
		define('RELPATH',dirname($_SERVER['PHP_SELF']));
		if(!defined("SRVHOST"))
		{
			define('SRVHOST',$_SERVER['HTTP_HOST']);
		}
	//	DEFINE URL PATH FOR TESTING
		switch(SRVHOST)
		{
			case "whatsthebuzz":
				$myURLroot = "http://whatsthebuzz";
				$myHTTP = "http://";
			break;
			case "whatsthe.buzz":
				$myURLroot = "https://whatsthe.buzz";
				$myHTTP = "https://";
			break;
		}
		$urlBUILD = $myURLroot."/for/" . $_SESSION['URL'];

?>
    		<h3>Your URL: <input style="width:100%;" type="text" value="<?php echo $urlBUILD;?>"></h3>

		<h3>Your Survey Code: <input style="width:100%;" type="text" value="<?php echo $_SESSION['uniqueID'];?>"></h3>
		<h3>Your QR Code:<br>
			<img id='qrImage2' style="width:30%;height:30%" src='<?php echo $myHTTP.$_SESSION['QRPath'];?>'>&nbsp;
		</h3>

      <div class="navbar navbar-fixed-bottom survey-footer" >
        <p><?php echo COPY;?> | <a href="../logout">logout</a></p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="<?php echo HOST;?>/js/pubnav.js"></script>

</body>
</html>