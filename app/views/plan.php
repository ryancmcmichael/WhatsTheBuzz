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
<?php
session_start();
?>
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
          <li><a class='pubnav' id='home'>Home</a></li>
          <li><a class='pubnav' id="about">About</a></li>
          <li><a class="pubnav" id="contact">Contact</a></li>
		<li><a class="pubnav" id="signin">Sign In</a></li>
        </ul>
        <h3 class="text-muted"><?php echo TITLE;?></h3>
      </div>
	
      <div class="row marketing">
	   <h3 style="text-align:center;">Almost done! Select your payment option here. (Step 3 of 4)</h3><br>
	   <p class='instruct' style="padding-left:2%;">All plans come with unlimited survey responses, tag configuration, and reporting. Please review your information below and select one of our payment options to continue.
	<div class="row">
	 <div class='recap-block'>
		<div class="recap row">
			<div class='labeldiv'>USER NAME: </div>
			<div class='userIs'><?php echo $_SESSION['NAME'];?></div>
		</div>
		<div class="recap row">
			<div class='labeldiv'>YOUR URL: </div>
			<div class='userIs'><?php echo $_SESSION['URL'];?></div>
		</div>
		<div class="recap row">
			<div class='labeldiv'>YOUR EMAIL: </div>
			<div class='userIs'><?php echo $_SESSION['EMAIL'];?></div>
		</div>
		<div class="recap row">
			<div class='labeldiv'>DATE: </div>
			<div class='userIs'><?php echo date("F dS, Y",strtotime($_SESSION['JOINED']));?></div>
		</div>
	</div> <!-- end recap-block-->
	</div> <!-- end recap row -->
		<div id="subOptions" >
			<label class="inline">
  				<input type="radio" checked id="pmt1" name="payment" value="MTH"><span class="mnlbl" >$20 / Monthly</span><br><span class="subtxt">&nbsp;</span>
			</label>
			<label class="inline">
  				<input type="radio" id="pmt2" name="payment" value="QTR"><span class="mnlbl"> $50 / Quarterly
				</span><br><span class="subtxt">(save $40 per year)</span>
			</label>
			<label class="inline">
  				<input type="radio" id="pmt3"  name="payment" value="YR"><span class="mnlbl">$180 / Annually
				</span><br><span class="subtxt">(save $60 per year)</span>
			</label>
		</div><br>
		</p>
	   <div class="row" style='text-align:center;'>
	  	<!--HOLDING PATTERN-->
		<div style='display:inline-block;width:40px;'>
			<img id='spinner' style='display:none;' src='<?php echo HOST;?>img/ajax-loader.gif'/>
		</div>
	  	<button style="margin-right:50px;" class="btn btn-lg btn-info" id="pmtplan" role="button">On to Payment</button>
		
	</div>
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
		//	HANDLE PMT OPTION ON PLAN.PHP
		$('#pmtplan').click(function(){
			
			//	GET VALUE OF RADIO BUTTON
				
				$("#spinner").show();
				$("#message").fadeOut(100).html("");
				var delayer = setTimeout("pmtOption()",2000);
		});
		
		function pmtOption()
		{
			//alert('click');
			var paytype = $("input[name='payment']:checked").val();
			$("#spinner").hide();
			
			// 	AJAX CALL TO TEST URL
				$.ajax({
					type: 'POST',
					url: 'ajax/ajax-signup.php',
					data: {	
					//	pull these in either way. for updates, we use.
						'type'	:	'PMTOPTION',
						'OPT'	:	paytype,		
						},
						beforeSend:function(){
							
						},
						success:function(data)
						{	
							//	alert(data);
								window.location.href = "/pay";	
						},
						error:function(data)
						{
							alert(data);
						}
				});	//	END AJAX
			}	//	END pmtOption() function
	</script>
</body>
</html>