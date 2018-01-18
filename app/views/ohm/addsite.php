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
.profilelabel{color:#ccc;font-size:1.2em;text-transform:uppercase;padding-left:20px;font-weight:bolder;}
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
	<div class="marketing row"><!-- PRIMARY HORIZ CONTAINER -->
	
<!-- BUSINESS NAME  						-->
		<div class="row profilelabel">
			Business Name
		</div>
		<div class="row"><!-- CONTACT INFO -->
			<div class="col-xs-24 col-sm-12 col-md-12">
				<div class="form-group">
			    <input type="text" name="bizname" id="bizname" class="form-control" placeholder="Name of the Business" tabindex="3">
				</div>
			</div>
					
		</div><!-- END BUSINESS NAME -->	
		
<!-- BUSINESS ADDRESS LABEL AND FORM SECTION 	-->
		<div class="row profilelabel">
			Business Address
		</div>
		<div class="row"><!-- BIZ ADD 1 -->
			<div class="col-md-12">
				<div class="form-group">
					<input type="text" name="bizadd1" id="bizadd1" class="form-control" placeholder="Address 1" tabindex="2">
				</div>
			</div><!-- /FORM GROUP -->
		</div><!-- /ROW -->
		<div class="row"><!-- BIZZ ADD 2 -->
			<div class="col-md-12">
				<div class="form-group">
					<input type="text" name="bizadd2" id="bizadd2" class="form-control" placeholder="Address 2" tabindex="3">
				</div>
			</div><!-- /FORM-GROUP-->
		</div><!-- /ROW -->
		<div class='row'><!-- CITY STATE ZIP -->
			
				<div class="col-md-6">	
					<input type="text" name="city" id="city" class="form-control" placeholder="City" tabindex="3">
				</div>
				<div class="col-md-2">
					<input type="text" name="state" id="state" class="form-control" placeholder="ST" tabindex="3">
				</div>
				<div class="col-md-2">
					<input type="text" name="zip" id="zip" class="form-control" placeholder="Zip" tabindex="3">
				</div>
				<div class="col-md-2">
					<input type="text" name="zip4" id="zip4" class="form-control" placeholder="Plus 4" tabindex="3">
				</div>
			
		</div><!-- END ROW -->	
	</div><!-- END BUSINESS INFO -->	
	
	<!--	FIRST NAME AND LAST NAME LABEL AND FORM SECTION --> 
		<div class="row profilelabel">
			Primary Contact
		</div>
		<div class="row"><!-- FNAME & LNAME -->
			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="form-group">
			    <input type="text" name="fname" id="fname" class="form-control input" placeholder="First Name" tabindex="4">
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="form-group">
					<input type="text" name="lname" id="lname" class="form-control input" placeholder="Last Name" tabindex="5">
				</div>
			</div>
		</div>
		<div class="row profilelabel">
			Phone and Email
		</div>
		<div class="row"><!-- CONTACT INFO -->
		
			<div class="col-md-2">
				<div class="form-group">
			    <input type="text" name="phonepre" id="phonepre" class="form-control input" placeholder="pre" tabindex="6">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
			    <input type="text" name="phonepost" id="phonepost" class="form-control input" placeholder="local" tabindex="7">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
			    <input type="text" name="email" id="email" class="form-control input" placeholder="email" tabindex="3">
				</div>
			</div>
			
		</div><!-- END CONTACT INFO -->
	</div><!-- PRIMARY HORIZ CONTAINER -->
	
	
	<!-- <div class="navbar navbar-fixed-bottom survey-footer" >  // fixed bottom commented out -->
      <div class="navbar navbar-bottom survey-footer" >
        <p><?php echo COPY;?></p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="<?php echo HOST;?>js/ohmnav.js"></script>
	<script>
	
	//	AJAX TO LOAD THIS INFO HERE INTO DATABASE
	//	THIS SECTION SETS A SITE CODE
	//	SITE CODE USED TO SET UP SITES
	
	</script>
	
</body>
</html>
