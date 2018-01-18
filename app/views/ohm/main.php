<?php
//	CHECK TO SEE IF WE KNOW THIS PERSON	
	if(!isset($_SESSION["OHM"]))
	{
		header("location:".HOST."ohm/login");		
	}
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title><?php echo TITLE;?></title>
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
	.input-group{width:100%;}
	.input-group *{margin:5px;width:100%;}
	.login-box{text-align:left;width:100%;}
	.login-box div{float:left;border:1px solid #ccc;};
	#error_msg{padding-top:2%;}
	.codeBox{	width:100%;padding:4px; 
			margin-bottom:15px; 
			border-top:2px solid #ddd;
			border-bottom:2px solid #ddd;
			padding-top:6px;
			padding-bottom:8px;
			}
	.codelabel{display:inline-block;font-size:1.8em;color:#00a8cc;padding-top:2px;padding-left:10px;padding-bottom:4px;}
	.codeform{display:inline-block;margin-left:5px;}
	.codeButton{display:inline-block;margin-left:5px;}
	.codeBox div{vertical-align:bottom;}
	#showSpinner{display:inline-block;width:30px;}
	#error-msg{display:inline-block;font-size:1.4em;color:#bbb;margin-left:5px;vertical-align:bottom;padding-bottom:4px;}
	.header{border:0px;}
	.buzzButton{background-color:#ffcc00;border:1px solid #545454;}
	.buzzButton:hover{background-color:#00a8cc;border:1px solid #545454}
	.form-control:focus {
  border-color: #545454;
  outline: 0;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(255, 204, 0, .6);
          box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(255, 204, 0, .6);
}
.jumbotron{
	background-color:#545454;
	color:#ffffff;
	background-image:url(img/honeycomb-jumbo.png);
	background-position:left bottom;
	background-repeat:no-repeat;
}
.buzzHdr{color:#00a8cc;}
	</style>

  </head>

  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <?php
			$page = "home";
			require("inc/ohm.php");
		?>
        </ul>
	   	<?php
	   		require("inc/logo.php");	
	   	?>
      </div>
	<?php
		//	GET LIST OF SITES
		//	$SITES = "GET * FROM USERS";
	?>
      <div class="row marketing">
		Site 1		
      </div>
	       <div class="row marketing">
		Site 2		
      </div>
	       <div class="row marketing">
		Site 3		
      </div>


      <div class="navbar navbar-fixed-bottom survey-footer" >
        <p><?php echo COPY;?></p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="<?php echo HOST;?>js/ohmnav.js"></script>
</body>
</html>
