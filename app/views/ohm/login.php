<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo TITLE;?>: Sign In</title>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/landing.css"/>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Customer Insight, tagging, mobile, suveys, better business, relationship management">
<meta name="author" content="John Brenton Phillips">
<link rel="shortcut icon" href="<?php echo HOST;?>/favicon.ico">
	<style>
	.input-group{width:100%;}
	.input-group *{margin:5px;width:100%;}
	.login-box{text-align:center;}
	#error_msg{padding-top:2%;}
	</style>
  </head>

  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
         <?php
	    		$page = "signin";
			require("inc/nav.php");
	    ?>
        </ul>
	   <?php
        		require("inc/logo.php");
		?>
      </div>
      <div class="login-box">
        <h2 style="text-transform:uppercase;color:#545454">Ohm Access</h2>
	   	<div class="input-group input-group-lg">
  			<input id="email" type="text" class="form-control spacer" placeholder="email address">
			<input id="pw" type="password" class="form-control" placeholder="password">
		</div>
			<div style='display:inline-block;padding-top:8px;'><button class="btn btn-lg btn-info buzzButton" id="signin-button" style="margin-left:50px;" role="button">Login</button></div>		
				<div style='display:inline-block;width:40px;'>
					<img id='spinner' style='display:none;' src='<?php echo HOST;?>img/ajax-loader.gif'/>
				</div>
    </div>
	<div class="row" style="text-align:center;font-size:2em;">
		<p id="error_msg">
		</p>
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
	<script>
	$(document).ready(function(){
		$("#signin-button").click(function(){
				
			//	spinner here
			//	$("#signin-button").prop("disabled",true);
				$("#spinner").show();
				$("#error_msg").fadeOut(1000);
				var delayer = setTimeout("signin()",2000);
			})
		})
	function signin(){
	
	$.ajax({
		type: 'POST',
		url: "../ajax/ajax-ohm.php",
		data: {	
		//	pull these in either way. for updates, we use.
			'email'	:	$("#email").val(),
			'pw'		:	$("#pw").val()
			
			},
			beforeSend:function(){
				
			},
			success:function(data)
			{	
				//alert(data);
				
				switch(data)
				{
					case "TRUE":
						$("#spinner").fadeOut(500);
						window.location.href="./";
					break;
					case "FALSE":
						$("#spinner").fadeOut(500);
						$("#error_msg").html("Hmm. We couldn't find you. Please try again.").fadeIn(500);
					break;
					case "DB_ERROR":
						$("#spinner").fadeOut(500);
						$("#error_msg").html("Well...We have a DB error. We will look into it!").fadeIn(500);							
						alert(data);
					break;	
				}
			},
			error:function(data)
			{
				alert(data);
			}
	});	//	END AJAX	
	
	}
	</script>

</body>
</html>