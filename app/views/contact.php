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
<link rel="shortcut icon" href="<?php echo HOST;?>/favicon.ico">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
   	.about{font-size:1.2em;color:#222; text-align:justify;} 
	.about b{color:#00a8cc};
	.about em{color:#000000};
	.about p{margin-bottom:24px;}
	.about li{margin-bottom:20px;}
	.about li b{color:#f02979;}
	.demolink{color:#00a8cc;text-decoration:underline;}
	.subReq{font-size:3em;color:#545454;text-align:center;}
	.form-control:focus {
  border-color: #545454;
  outline: 0;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(255, 204, 0, .6);
          box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(255, 204, 0, .6);
}
	.subLabel{
		color:#00a8cc;
		font-size:1.2em;
		padding-left:6px;
		text-transform:uppercase;
		}
	.buzzButton{background-color:#ffcc00;border:1px solid #545454;}
	.buzzButton:hover{background-color:#00a8cc;border:1px solid #545454}
	.subReqShell{width:100%;height:18px;}
	#subReqHdr{width:100%; font-size:1em; color:#f02979;text-align:center;}
	.message{width:100%;font-size:2em;text-align:center;}
	.message.thanks{color:#00a8cc};
	.message.error{color:#f02979};
   </style>
  </head>

  <body>
    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <?php 
			$page = "about";
			require("inc/nav.php");
		?>
        </ul>
        	<?php
			require("inc/logo.php");
		?>
      </div>
	<h2 class='subReq'>Hi! How can we help?</h2>
	<div class='subReqShell'>
		<div id="subReqHdr" style="display:none">Woops! Looks like you missed a field.</div>
	</div>
	<div id="Thanks" class="message thanks" style="display:none;"><h3>Thank you for your interest! We'll be in touch soon.</h3></div>
	<div id="Error" class="message error" style="display:none;"><h3>Woops! Something went wrong. We'll check it out. In the meantime, please email <a href='mailto:subscribe@whatsthe.buzz'>subscribe@whatsthe.buzz</a></h3></div>
     
	 <div id="curtain" class="row marketing"><!-- start about form -->
	 <form role="form" id="profile">
			
			<!-- FIRST NAME, LAST NAME -->
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
			</div><!-- end row -->
			
			<div class="row"><!-- row -->
			<div class="col-sm-12">
					<div class="form-group">
						<input type="text" name="subject" id="subject" class="form-control input-lg" placeholder="subject" tabindex="3">
					</div>
			</div><!-- end section -->
			</div><!-- end row-->
			
			
			<div class="row"><!-- row -->
			<div class="col-sm-12">
					<div class="form-group">
						<input type="text" name="email" id="email" class="form-control input-lg" placeholder="email" tabindex="4">
					</div>
			</div><!-- end section -->
			</div><!-- end row-->
			
			
			<div class="row"><!-- row -->
			<div class="col-sm-12">
					<div class="form-group">
						<textarea id="message" class="form-control" tabindex="5" style="height:200px;max-height:200px;min-height:200px">
						</textarea>
					</div>
				</div><!-- end section -->
			
			</div>	
			</form><!-- END FORM-->
			
			<div class="row" style='text-align:center;'>
				<div style='display:inline-block;'><button class="btn btn-lg btn-info buzzButton" id="subscribeHere" style="margin-left:50px;" role="button">Send It!</button></div>		
				<div style='display:inline-block;width:40px;'>
					<img id='spinner' style='display:none;' src='<?php echo HOST;?>img/ajax-loader.gif'/>
				</div>
			</div>		
		</div><!-- END ABOUT SECTION -->
	 

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
	<!-- for script -->
	<script>
	
	$(document).ready(function(){
	//	SET CLICK FUNCTION TO MOVE ON
		$("#subscribeHere").click(function(){
			
		//	CHECK FOR COMPLETENESS
		
			if(
				$("#fname").val() == null		||
				$("#fname").val() == ""		||
				
				$("#lname").val() == null		||
				$("#lname").val() == ""		||
				
				$("#email").val() == null		|| 
				$("#email").val() == "" 		||

				$("#subject").val() == null	|| 
				$("#subject").val() == "" 	||
				
				$("#message").val() == null	|| 
				$("#message").val() == "" 	
				
					
			)	//	END IF - SOMETHING IS NOT COMPLETE
		{
			$("#spinner").hide();
			$("#subscribeHere").prop("disabled",false);
			$("#subReqHdr").fadeIn("slow").delay(3000).fadeOut("slow");
			return false;
		}
			//	SET SPINNER IN MOTION
				$("#subscribeHere").prop("disabled",true);
				$("#spinner").show();
				var delayer = setTimeout("subscribe()",2000);		
		});	
	});
	
	function subscribe(){
	
	$.ajax({
		type: 'POST',
		url: "ajax/ajax-contact.php",
		data: {	
		//	pull these in either way. for updates, we use.
			'fname'	:	$("#fname").val(),
			'lname'	:	$("#lname").val(),
			'email'	:	$("#email").val(),
			'subject'	:	$("#subject").val(),
			'message'	:	$("#message").val(),
			},
			beforeSend:function(data){
				//alert(data);
			},
			success:function(data)
			{	
				switch(data)
				{
					case "TRUE":
						$("#subscribeHere").fadeOut(500);
						$("#spinner").fadeOut(500);
						$("#curtain").fadeOut(500,function(){
							
							var pause = setTimeout(
							sayThanks
							,300);
							});
						
					break;
					case "FALSE":
						$("#subscribeHere").prop("disabled",false);
						$("#spinner").fadeOut(500);
						$("#curtain").fadeOut(500,function(){
							
							var pause = setTimeout(
							sayError
							,300);
						});
				}
			},
			error:function(data)
			{
				alert(data);
			}
	});	//	END AJAX	
	
	}
	function sayThanks()
	{
		$("#Thanks").fadeIn(300);	
		var timer = setTimeout(goHome,3000);
	}
	function sayError()
	{
		$("#Error").fadeIn(300);		
	}
	function goHome()
	{
		//alert('worked');
		window.location="../";	
	}
	</script>
	<!-- end form script -->

</body>
</html>