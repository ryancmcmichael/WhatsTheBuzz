<?php
include("ajax/ajax-config.php");
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
<title><?php echo TITLE;?>: Sign Up</title>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/landing.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/plan.css"/>
<!--<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/qr.css"/>-->
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
			$page = "pay";
			require("inc/nav.php");
		?>
        </ul>
        <h3 class="text-muted"><span class='myHeader' id='mast-header'><?php echo TITLE;?></span></h3>
      </div>
	   <div class="row">
	   <?php
	   	$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
		$planQry = "SELECT * FROM RatePlans WHERE planStatus='ACTIVE';";	
		$subURL = $dbh->query($planQry);
		
	   ?>
		
		<div class="row">
		<div class="form-group col-xs-12" >
		<form role="form" id="braintree-payment-form" action="../ajax/handlepmt.php" method="POST">
			<select name="plan" id="plan" class="form-control input-lg plan">
				<option value="000">Please choose a plan...</option>
				<?php
				foreach($subURL as $row)
				{
						echo "<option value='".$row['planID']."'>\$";
						echo $row['rate'] . " ". $row['planDescription'];
						if($row['ratequal']=='')
						{
							echo " ";	
						}else
						{
							echo  " ( " . $row['ratequal'] . " )";	
						}
						echo "</option>"; 
				}
				?>
			</select>
			</div><!--end extended select -->
			</div><!-- row -->
		
		<?php
			if(isset($_SESSION['fname']))
			{
				$fn = $_SESSION['fname'];
				$ln = $_SESSION['lname'];
					
			}else{
					$fn = 'first name';
					$ln = 'last name';
				}
		?>
		<div class="row">
       		<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="form-group">
					<input name="first_name" id="first_name" class="form-control input-lg sname" type="text" autocomplete="off"  placeholder="<?php echo $fn;?>" />		
				</div><!--/form group-->
			</div><!-- END COL SPEC -->
			<div class="col-xs-12 col-sm-6 col-md-6">	
				<div class="form-group">
					<input name="last_name" id="last_name" type="text" class="form-control input-lg sname" autocomplete="off" placeholder="<?php echo $ln;?>" />
      			</div><!-- /form-group-->
			</div><!-- END COL DIV-->
		</div><!--END ROW-->
		<div class="row">
       		<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="form-group">
					<input type="text" class=' form-control input-lg sname' autocomplete="off"  name="number" placeholder="Card Number"  data-encrypted-name="number"/>
				</div><!--/form group-->
				</div><!--END COL SPEC -->
				<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="form-group">
					<input type="text" class='form-control input-lg sname' autocomplete="off"  name="nameOnCard" placeholder="Name on Card" data-encrypted-name="nameOnCard"/>
      			</div><!-- /form-group-->
			</div><!-- END COL DIV-->
		</div><!--END ROW-->
		<div class="row">
			<div class="col-sm-3">
				<div class="form-group">
					<input type="text" name="postal_code" id="postal_code"  class="form-control input-lg zip" autocomplete="off"  placeholder="postal code" data-encrypted-name="postal_code"/>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<input type="text" class="form-control input-lg cvv" autocomplete="off" name="cvv" placeholder="cvv" data-encrypted-name="cvv"/>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<input type="text" autocomplete="off"  class="form-control input-lg state" name="month" placeholder="MM"/ data-encrypted-name="MM">
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<input type="text" autocomplete="off"  class="form-control input-lg anno" name="year" placeholder="YYYY" data-encrypted-name="YYYY"/>
				</div>
			</div>
		</div><!-- END ROW -->
		
		<!-- BEGIN BUTTON ROW -->
		<div class="row" style='text-align:center;'>
		
			<div style='display:inline-block;width:40px;'>
				<img id='spinner' style='display:none' src='<?php echo HOST;?>img/ajax-loader.gif'/>
			</div>
			<button style="margin-right:50px;" type="submit" id="submit" class="btn btn-primary btn-lg">Click to Finish!</button></form>
		</div>
		<!--END BUTTON ROW-->
		
		<!-- BEGIN MESSAGE ROW -->
		<div class="row" style='text-align:center;padding-top:3%;'>
			<div class="row" id="message" style='text-align:center;font-size:2em;'>
				<!-- copy here -->
			</div>
		</div>
		<!--END MESSAGE ROW-->
		
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
	
	<!--		BRAINTREE INCLUDE SCRIPT	-->
	<script src="https://js.braintreegateway.com/v1/braintree.js"></script>
  
  <script>
   var ajax_submit = function (e) {
     form = $('#braintree-payment-form');
     e.preventDefault();
	// quick check for plan selection
	if($("#plan").val()=="000")
	{
		$("#message").html("Hi. Make sure to choose a plan first!").fadeIn(100);
		return false;
	}else
	{
	
		$("#submit").attr("disabled","disabled");
		$("#spinner").show();
		$("#message").html("<span>&nbsp;</span>");
     
      	$.post(form.attr('action'), form.serialize(), function (data) {
	  		
		//	TEST THE RETURN DATA BELOW	
		//	WATCHING FOR ERRORS IN DATABASE OR COLUMN FIELDS MISALIGNING WITH DATA
		
		//	alert(data);
			
			switch(data)
			{
				
				case "TRUE":
				
				//	NEED TO PUSH TO A TEMP PAGE TO 
				//	1) WRITE FORM URL TO DATABASE
				//	2) SAVE QR CODE TO DATABASE
				//	3) SAVE QR IMAGE TO FILE STRUCTURE
				
					$("#spinner").hide();
					// 	REDIRECT TO ADMIN PAGE
					//	window.location.href='/admin/';
					//	SET UP LINK SAYING PAYMENT ACCEPTS CLICK TO GO TO ADMIN PAGE<br>
					$("#spinner").hide();
					$("#message").html("Payment confirmed! </br>Please <a href='/admin/'>click here</a> to access your admin page.").fadeIn(100);
				break;
				default:
					$("#submit").prop("disabled", false);
					//alert(data);
					$("#message").html("Hi. We had a problem with your card. Try again?").fadeIn(100);
				break;
			}
			
      	});
		}	//	END 'ELSE' CHECK FOR PLAN SELECTION HERE
    }
	$("#plan").change(function(){
		$("#message").fadeOut(100);
		})
      var braintree = Braintree.create("MIIBCgKCAQEA3+ZImnKpVck/IvVC50tiuQ/swDLAxFRFqx5YqohCygv0VUI7KhESmbWaHuwKWMOBQQ45g2U9H7qMzMJ5aDlMU7BFSfJlvqt/GG6bZLXAdfxrnkn/xJT9mzZajFXCWuHaEG5edueTUph/1EteMWil7HElmCtEMW288LTG1sOvWF9s/JrPBqcM5HwwuJY4xMynPOttxnnEtvUNJeOihjOkIWoEWHZH5QoZprti701/ObvhDcaoe1MHxKhP5fnL3ayW0XIw3Roa7yf8L9xSxSHHFRd8ngfPQn+iST93G65oIFYDlV3sJX8GULg/iYw0tBIf43FS5hiyuO0xPWJ9Pokp6wIDAQAB");
      braintree.onSubmitEncryptForm('braintree-payment-form', ajax_submit);
    </script>    

</body>
</html>


    
   