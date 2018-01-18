<?php
if(!isset($_SESSION['OHM']))
{
	header("location:".HOST."ohm");
}
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title><?php echo TITLE;?>: Sign Up</title>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/landing.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/plan.css"/>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Customer Insight, tagging, mobile, suveys, better business, relationship management">
<meta name="author" content="John Brenton Phillips">
<link rel="shortcut icon" href="<?php echo HOST;?>/favicon.ico">
	<?php
		// echo $_SERVER['HTTP_HOST'];
	?>
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <?php
			$page = "signup";
			require("inc/nav.php");
		?>
        </ul>
        <h3 class="text-muted"><span class='myHeader' id='mast-header'><?php echo TITLE;?></span></h3>
      </div>
	 
	 
      <div class="row marketing">
	   <h3 style="text-align:center;">Ready to sign up?<br>Great! We just need a few details to get started.(Step 1 of 3)</h3><br>
	   
		<form role="form" id="signup-step-one">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
                        <input type="text" name="fname" id="fname" class="form-control input-lg" placeholder="First Name" tabindex="1">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="text" name="lname" id="lname" class="form-control input-lg" placeholder="Last Name" tabindex="2">
					</div>
				</div>
			</div>
			<div class="form-group">
				<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" tabindex="4">
			</div>
			<!-- business name -->
			<div class="form-group">
				<input type="busname" name="busname" id="busname" class="form-control input-lg" placeholder="Business Name" tabindex="4">
			</div>
			
			<!-- GOOGLE ID -->
			<!--
			<div class="form-group">
				<input type="busname" name="googleID" id="googleID" class="form-control input-lg" placeholder="Google ID" tabindex="4">
			</div>
			-->
			
			<!--PASSWORD ROW -->
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="password" name="pw1" id="pw1" class="form-control input-lg" placeholder="Password" tabindex="5">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="password" name="pw2" id="pw2" class="form-control input-lg" placeholder="Confirm Password" tabindex="6">
					</div>
				</div>
			</div></form><!-- END FORM-->
			<div class="row" style='text-align:center;'>
				<div style='display:inline-block;'><button class="btn btn-lg btn-info" id="yourURL" style="margin-left:50px;" role="button">Let's Go!</button></div>		
				<div style='display:inline-block;width:40px;'>
					<img id='spinner' style='display:none;' src='<?php echo HOST;?>img/ajax-loader.gif'/>
				</div>
			</div>
			<div class="row" style="text-align:center;font-size:2em;">
				<p id="error_msg">
				</p>
			</div>
		
      </div> <!-- // END ROW MARKETING-->

      <div class="navbar navbar-fixed-bottom survey-footer" >
        <p><?php echo COPY;?></p>
      </div>

    </div> <!-- /container -->
<!-- Modal -->
<div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
			</div>
			<div class="modal-body">
				T's and C's here
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">I Agree</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="<?php echo HOST;?>/js/pubnav.js"></script>
	<script>
	$(document).ready(function(){
	//	SET CLICK FUNCTION TO MOVE ON
		$("#yourURL").click(function(){
			
			//	CHECK FOR COMPLETENESS
		
		if(
			$("#email").val() == null		|| 
			$("#email").val() == "" 		||
			$("#busname").val() == null	||
			$("#busname").val() == ""		||
			$("#fname").val() == null		||
			$("#fname").val() == ""		||
			$("#lname").val() == null		||
			$("#lname").val() == ""		||
			$("#pw1").val() == null		||
			$("#pw1").val() == ""		||
			$("#pw2").val() == null		||
			$("#pw2").val() == ""		
		)
		{
			$("#spinner").hide();
			$("#yourURL").prop("disabled",false);
			$("#error_msg").text("Hi! Please complete the form before submitting. ");
			return false;
		}
	//	VALIDATE THE PW'S, QUICK CHECK
		if($("#pw1").val() != $("#pw2").val())
		{
			$("#spinner").hide();
			$("#yourURL").prop("disabled",false);
			$("#error_msg").text("Double check your passwords. They don't quite match :) ");
			return false;
		}
			
			//	0. Set spinner...put button to disabled
				$("#yourURL").prop("disabled",true);
				$("#spinner").show();
				var delayer = setTimeout("signup()",2000);		
		});	
	});
	
	function signup(){
	
	$.ajax({
		type: 'POST',
		url: "ajax/ajax-signup.php",
		data: {	
		//	pull these in either way. for updates, we use.
			'type'	:	'SIGNUP',
			'email'	:	$("#email").val(),
			'biz'		:	$("#busname").val(),
			'fname'	:	$("#fname").val(),
			'lname'	:	$("#lname").val(),
			'pw1'	:	$("#pw1").val(),
			'pw2'	:	$("#pw2").val(),
			//'googleID' :	$("#googleID").val()
			
			},
			beforeSend:function(data){
				//alert(data);
				
			},
			success:function(data)
			{	
				switch(data)
				{
					case "TRUE":
						$("#yourURL").fadeOut(500);
						$("#spinner").fadeOut(500);
						window.location.href="/yourlink";
					break;
					case "EMAIL_ERROR":
						$("#yourURL").prop("disabled",false);
						$("#spinner").fadeOut(500);
						
						$("#error_msg").html("<p>Looks like we have this email address already. Have you tried <a href='/signin'>signing in</a></a>?");
					break;
					case "DB_ERROR":
						alert('we have a database error');
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