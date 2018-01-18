<?php
if(!isset($_SESSION['TID']))
{
	header("location:./");
	session_start();	
	
}
//	CHECK FOR ADMIN HERE
if(!isset($_SESSION['OHM']))
{
	header("location:".HOST."ohm");
}
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title><?php echo TITLE;?>: Your URL</title>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/landing.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/plan.css"/>
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
  </head>

  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
         <?php 
			$page = "yourlink";
			require("inc/nav.php");
		?>
        </ul>
        <h3 class="text-muted"><span id='mast-header'><?php echo TITLE;?></span></h3>
      </div>
	
      <div class="row marketing">
	   <h3 style="text-align:center;">Awesome! Now lets build your survey link! (Step 2 of 3)</h3><br>
	   <p class='instruct'><span class="callOut">Your survey will open using a web URL.</span> Use this form to create your branded link. Please note, only alphanumeric characters and hyphens can be used. As you type, your new URL will display below.</p>
	   <!-- we'll get to this eventually 
	   <p class='instruct'><span class="callOut">Multiple locations?</span>
	   No problem. In the next step, we'll let you configure the service for multiple sites!</p>-->
		<form role="form">
			<div class="row">
				<div class="form-group">
				<input type="text" name="busname" id="busname" class="form-control input-lg" placeholder="Business Name" tabindex="4" value="">
				</div>
			</div><!-- /row -->
			<span class='bulabel'>your url:</span>
			<div class="row bizURLFrame">
			<span class='bizURL'>
				<?php echo HOST;?>for/<span id="bizID"></span>	
				<input type="hidden" value="" id="bidHidden">
			</div>
		</form>


	  
	 <div class="row" style='text-align:center;'>
	  	<!--HOLDING PATTERN-->
		<div style='display:inline-block;width:40px;'>
			<img id='spinner' style='display:none;' src='<?php echo HOST;?>img/ajax-loader.gif'/>
		</div>
	  	<button  class="btn btn-lg btn-info" id="confirm" role="button">confirm?</button>
	  	<button style="margin-right:50px;" class="btn btn-lg btn-info" id="payment" role="button">Proceed</button>
		
	</div>
		
      </div> <!-- // END ROW MARKETING-->
		<div class="row" id="message" style='text-align:center;font-size:2em;'>
			<!-- copy here -->
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
		//	SET PROP
			$("#payment").prop("disabled",true);
		//	HANDLE SUBMISSION LINK
			$("#confirm").click(function(){
				
				var str = $("#busname").val(); 
				if(str.match(/^[a-z0-9]+$/i))
    				{	
    					$("#spinner").show();
					$("#message").fadeOut(100).html("");
					var delayer = setTimeout("checkURL()",2000);
    				}
    			 	else
				{
    					$("#message").empty();
					$("#message").append($("<p>Oops! Alphanumeric only please!</p>").fadeIn(500).delay(1000).fadeOut(500));
				}
			})
			$("#payment").click(function(){
				submitURL();
				
			});	
		
		//	HANDLE YOURURL URL BUILDER
			//$("#busname").keydown(function(e){alert(e.which)});
			$("#busname").forceNumeric();
			$("#busname").keyup(function(e)
			{
			//	mover the value to the span and to the hidden field
				$("#bidHidden").val($("#busname").val());
				$("#bizID").html($("#busname").val());
			});
	});
	
	
// JavaScript Document// NUMERIC ONLY INPUT RESTRICTION
	jQuery.fn.forceNumeric = function ()
		{
			return this.each(function()
			{
				$(this).keydown(function (e) 
				{
					var key = e.which || e.keyCode;
					if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
					// numbers   
						key >= 48 && key <= 57 ||
					// Numeric keypad
						key >= 96 && key <= 105 ||
					// comma, period and minus, . on keypad
						key == 190 || key == 188 || key == 109 || key == 110 ||
					// Backspace and Tab and Enter
						key == 8 || key == 9 || key == 13 ||
					// Home and End
						key == 35 || key == 36 ||
					// left and right arrows
						key == 37 || key == 39 ||
					// Del and Ins
						key == 46 || key == 45 ||
					// Hyphen and underscore
						key == 189  ||
					// Alpha Keys	
						key >= 65 && key <= 90 
					)
					return true;
					return false;
				});
			});
		};
		

function checkURL()
{
	//	alert($("#bidHidden").val());
	// 	AJAX CALL TO TEST URL
	$.ajax({
		type: 'POST',
		url: "ajax/ajax-signup.php",
		data: {	
		//	pull these in either way. for updates, we use.
			'type'	:	"CHECK",
			'URL'	:	$("#bidHidden").val(),		
			},
			beforeSend:function(){
				
			},
			success:function(data)
			{	
				//alert(data);
				switch(data)
				{
					case "TRUE":
					//	SHOW CONFIRM
						$("#payment").prop("disabled",false);
						$("#confirm").html('change');
						$("#spinner").hide();
						$("#message").show().html("<span style='color:green'>It looks like this url is available!</span>");
						
					break;
					case "FALSE":
					//	DENIED, URL ALREADY TAKEN
						$("#payment").prop("disabled",true);
						$("#spinner").hide();
						$("#message").show().html("<span style='color:red'>Hmmm. Looks like this URL is taken.</span>");
					break;	
				}	
			},
			error:function(data)
			{
			//	DENIED, URL ALREADY TAKEN
				$("#payment").prop("disabled",true);
				$("#message").show().html("<span style='color:red'>We're sorry! We've had an error. Please check back later.</span>")
			}
	});	//	END AJAX
}	//	END checkURL function

function submitURL()
{
	//	alert($("#bidHidden").val());
	// 	AJAX CALL TO TEST URL
	$.ajax({
		type: 'POST',
		url: "ajax/ajax-signup.php",
		data: {	
		//	pull these in either way. for updates, we use.
			'type'	:	"SUBMIT",
			'URL'	:	$("#bidHidden").val(),		
			},
			beforeSend:function(){
				
			},
			success:function(data)
			{	
				//alert(data);
				switch(data)
				{
					case "TRUE":
					//	SHOW CONFIRM
						$("#payment").prop("disabled",false);
						$("#spinner").hide();
						window.location.href="/pay";	
					break;
					case "FALSE":
					//	DENIED, URL ALREADY TAKEN
						$("#payment").prop("disabled",true);
						$("#spinner").hide();
						$("#message").html("<span style='color:red'>Oh no. We had an error. Please check back later.</span>");
					break;	
				}	
			},
			error:function(data)
			{
			//	DENIED, URL ALREADY TAKEN
				$("#payment").prop("disabled",true);
				$("#message").html("<span style='color:red'>We're sorry! We've had an error. Please check back later.</span>")
			}
	});	//	END AJAX
}	//	END checkURL function

</script>	
  	

</body>
</html>