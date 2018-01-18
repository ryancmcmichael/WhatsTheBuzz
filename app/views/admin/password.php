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
          
        </ul>
        <h3 class="text-muted"><span id='mast-header'><?php echo TITLE;?></span>: admin
	   <span id='hello-there'><?php echo "Welcome ". $_SESSION['fname'];?></span>
	   </h3></div>
	   <br>
	   	<?php
		include('admin_nav.php');
		?>
      	<div class="password-box">
        <h3>Let's update your password, shall we?</h3>
	   <p>We just need an alphanumeric phrase (numbers and letters only) please...</p>
	   	<div class="input-group input-group-lg">
  			<input id="pwA" type="password" class="form-control spacer" placeholder="password">
			<input id="pwB" type="password" class="form-control spacer" placeholder="confirm">
		</div>
			<div style='display:inline-block;padding-top:8px;'><button class="btn btn-lg btn-info" id="password-button" role="button">Update Your Password</button></div>		
				<div style='display:inline-block;width:40px;'>
					<img id='spinner' style='display:none;' src='<?php echo HOST;?>img/ajax-loader.gif'/>
				</div>
    </div>

	<div class="row" style="text-align:center;font-size:2em;">
		<p id="error_msg">
		</p>
	</div>


      <div class="navbar navbar-fixed-bottom survey-footer" >
        <p><?php echo COPY;?> | <a href="../logout">logout</a></p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="<?php echo HOST;?>js/pubnav.js"></script>
	<script>
	$(document).ready(function(){
		$("#password-button").click(function(){
				
			//	spinner here
				$("#password-button").prop("disabled",true);
				$("#spinner").show();
				$("#error_msg").hide();
				
			//	Validate Password (Alpha-Numeric Only)
				$pw1 = $("#pwA").val();
				$pw2 = $("#pwB").val();
				if($pw1!=$pw2)
				{
				
					var delayer = setTimeout(resetError,2000);	
				}
				else{
						changePassword();
				}	
				
				
			})
		})
	//	RESET FORM
		function resetForm()
		{
			$("#password-button").prop("disabled",false);
			$("#spinner").fadeOut(500);
			$("#error_msg").fadeOut(500);
		}
		function resetError()
		{
			$("#password-button").prop("disabled",false);
			$("#spinner").fadeOut(500);
			$("#error_msg").html("Hmmm. They don't seem to match. Try again.").fadeIn(500);
		}	
	// 	CHANGE PASSWORD FUNCTION
		function changePassword(){
	
		$.ajax({
				type: 'POST',
				url: "../ajax/ajax-password.php",
				data: {	
				//	pull these in either way. for updates, we use.
					'pwA'	:	$("#pwA").val(),
					'id' :	'<?php echo $_SESSION['userid'];?>'
					
					},
					beforeSend:function(data){
						//alert(data);
					},
					success:function(data)
					{	
						//alert(data);
						
						switch(data)
						{
							
							case "TRUE":
								$("#spinner").fadeOut(500);
								$("#error_msg").html("Success! Your password has been changed.").fadeIn(500);
								var timeToReset = setTimeout(resetForm,2000);							
							break;
							case "FALSE":
								$("#spinner").fadeOut(500);
								$("#error_msg").html("Hmm. We couldn't make the change. Hang tight, we'll look into it.").fadeIn(500);
								
							break;
							case "DB_ERROR":
								$("#spinner").fadeOut(500);
								$("#error_msg").html("Well...We have a DB error. We will look into it!").fadeIn(500);				alert(data);
							break;
								
						}
					},
					error:function(data)
					{
						$("#spinner").fadeOut(500);
						$("#error_msg").html("Well...We have a code error. We will look into it!");
					}
			});	//	END AJAX	
	
		}
	// END CHANGE PASSWORD FUNCTION
		</script>

</body>
</html>