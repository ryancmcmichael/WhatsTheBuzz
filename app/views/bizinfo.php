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
<link rel="shortcut icon" href="<?php echo HOST;?>assets/ico/favicon.ico">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
   <style>
   p.instruct{font-size:1.2em;color:#aaa;}
   div .row .bizURLFrame{
	   	background-color:#0F4F7F;padding:2%; text-align:center;
		border-radius:5px;
		margin-bottom:3%;
	   }
   span.bizURL{font-size:1.75em;color:#fff;}
   .bulabel{font-size:.75;}
   .callOut{color:#003DFF;}
   </style> 
  </head>

  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li><a class="pubnav" id='home'>Home</a></li>
          <li><a class="pubnav" id="overview">Overview</a></li>
			<li><a class="pubnav" id="faq">FAQ</a></li>
          <li><a class="pubnav" id="contact">Contact</a></li>
		<li><a class="pubnav" id="signin">Sign In</a></li>
        </ul>
        <h3 class="text-muted"><?php echo TITLE;?></h3>
      </div>
	
      <div class="row marketing">
	   <h3 style="text-align:center;">Now lets build your survey URL!</h3><br>
	   <p class='instruct'><span class="callOut">Here's what we're doing.</span> When you type in the name  of your business, we'll create a branded URL that your customers will see when they go to your survey. Before final submission, we will also check to make sure that your url is unique.</p>
	   
	   <p class='instruct'><span class="callOut">Multiple locations?</span>
	   No problem. Once you're signed up, we'll show you how to set up unique surveys for different stores!</p>
		<form role="form">
			<div class="row">
				<div class="form-group">
				<input type="text" name="busname" id="busname" class="form-control input-lg" placeholder="Business Name" tabindex="4">
				</div>
			</div><!-- /row -->
			<span class='bulabel'>your url:</span>
			<div class="row bizURLFrame">
			<span class='bizURL'>
				<?php echo HOST?><span id="bizID"></span>	
			</div>
		</form>


	  
	  <p style="text-align:center;"><a class="btn btn-lg btn-info" id="signup" role="button">Next: 2 of 3</a></p>
	   
      </div> <!-- // END ROW MARKETING-->

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
	function alphanumeric(inputtxt)  
	{  
		var letterNumber = /^[0-9a-zA-Z]+$/;  
		if((inputtxt.value.match(letterNumber))   
		{  
   			return true;  
  		}  
		else  
		{   
			return false;   
  		}  
  	}	  	
  	</script>

</body>
</html>