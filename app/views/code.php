<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title><?php echo TITLE;?>: Contact</title>
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
			$page = "contact";
			require("inc/nav.php");
		?>
        </ul>
        <h3 class="text-muted"><span class='myHeader' id='mast-header'><?php echo TITLE;?></span></h3>
      </div>

    	<div class="login-box">
        <h1>Have a code? Enter it here!</h1>
	   	<div class="input-group input-group-lg">
  			<input id="sitecode" type="text" class="form-control spacer" placeholder="site code">
		</div>
			<div style='display:inline-block;padding-top:8px;'><button class="btn btn-lg btn-info" id="sendCodeButton" style="margin-left:50px;" role="button">Load Survey</button></div>		
				<div style='display:inline-block;width:40px;'>
					<img id='spinner' style='display:none;' src='<?php echo HOST;?>img/ajax-loader.gif'/>
				</div>
    </div>


	<div class="row" style="text-align:center;font-size:2em;">
		<p id="error_msg">
		&nbsp;
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
		$("#sendCodeButton").click(function(){
			//	alert('clicked');
				
			//	spinner here
			//	$("#signin-button").prop("disabled",true);
				$("#spinner").show();
				$("#error_msg").fadeOut(1000);
				var code = setTimeout("testCode()",2000);
			})
		})
	function testCode(){
		
		$.ajax({
		type: 'POST',
		url: "ajax/ajax-testcode.php",
		data: {	
		//	pull these in either way. for updates, we use.
			'sitecode'	:	$("#sitecode").val(),
			
			},
			beforeSend:function(){
				//	alert(data);
				
			},
			success:function(data)
			{	
				//alert(data);
				
				switch(data)
				{
					
					
					case "FALSE":
						$("#spinner").fadeOut(500);
						$("#error_msg").html("Hmm. We couldn't find that site. Please try again.").fadeIn(500);
						
					break;
					case "DB_ERROR":
						$("#spinner").fadeOut(500);
						$("#error_msg").html("Well...We have a DB error. We will look into it!").fadeIn(500);				alert(data);
					break;
					default:
					
						$("#spinner").fadeOut(500);
						//alert("");
						window.location.href="../for/"+data;
					
					
					break;
						
				}
			},
			error:function(data)
			{
				alert('buggy');
			}
	});	//	END AJAX	
		
	}
	</script>

</body>
</html>