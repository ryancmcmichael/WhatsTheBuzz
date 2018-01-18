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
			require("inc/nav.php");
		?>
        </ul>
	   	<?php
	   		require("inc/logo.php");	
	   	?>
      </div>
		
		
		<div class='codeBox'><!-- for box for code -->
			<div class='codelabel'>Have a survey code?</div>
			<div class='codeform'><input id="sitecode" type='text' class='form-control'/></div>
			<div class='codeButton'>
				<button class="btn btn-med btn-info buzzButton" id="sendCodeButton" role="button">Load Survey</button>
			</div>
			<div id="showSpinner">
				<img id='spinner' style='display:none;' src='<?php echo HOST;?>img/ajax-loader.gif'/>
			</div>
			<div id="error-msg">
				&nbsp;
			</div>
		</div>
	
      <div class="jumbotron">
        <h1>Better Insight. Better Business!</h1>
        <p class="lead">Our intuitive and simple mobile survey solution enables you to reach customers where they are, ensuring 'top of mind' responses about their experience with your business. <br>Reach, Learn and grow!</p>
        <p><a class="btn btn-lg btn-success buzzButton" id="signup" role="button">Get Started Now!</a></p>
      </div>

      <div class="row marketing">
        <div class="col-lg-6">
          <h4 class='buzzHdr'>Simple, Intuitive Surveys</h4>
          <p>Short, intuitive questions designed to quickly capture perception.</p>

          <h4 class='buzzHdr'>Any Device</h4>
          <p>A flexible web-based interface that scales to fit any screen!</p>

          <h4 class='buzzHdr'>Reach Customers 'Where They Are'</h4>
          <p>Capture insight when it matters. Put your survey in the palm of their hand. No url's to type in later.</p>
        </div>

        <div class="col-lg-6">
          <h4 class='buzzHdr'>Easy Reporting</h4>
          <p>Quickly see the results of your surveys through an administrative console.</p>

          <h4 class='buzzHdr'>Actionable Insight</h4>
          <p>Understand consumer opinion and loyalty to improve business processes.</p>

          <h4 class='buzzHdr'>Turnkey Solution</h4>
          <p>Leverage a complete platform to send, collect, and analyze consumer opinions.</p>
		
		<br><br>
        </div>
	   
	 
      </div>

      <!--<div class="navbar navbar-fixed-bottom survey-footer" >-->
	 <div class="navbar survey-footer" >
	 <?php 
	 	require("inc/footernav.php");
	 ?>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="<?php echo HOST;?>js/pubnav.js"></script>
	<script>
	
	$(document).ready(function(){
		$("#sendCodeButton").click(function(){
			//	alert('clicked');
				
			//	spinner here
			//	$("#signin-button").prop("disabled",true);
				$("#spinner").show();
				$("#error-msg").fadeOut(1000);
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
						$("#error-msg").html("Hmm. No luck!").fadeIn(500).delay(1000).fadeOut(500);
						
					break;
					case "DB_ERROR":
						$("#spinner").fadeOut(500);
						$("#error-msg").html("Error! We'll fix that.").fadeIn(500).delay(1000).fadeOut(500);				
						alert(data);
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