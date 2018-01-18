<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title><?php echo TITLE;?>: Feedback</title>
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
        <h3 class="text-muted"><span id='mast-header'><?php echo TITLE;?></span></h3>
      </div>
            	<div class="row marketing" style="text-align:center;"><!--DISPLAY FEEDBACK RESULTS HERE -->
			<?php 
			include("ajax/ajax-config.php");
			try 
			{
			$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
			$subURL = $dbh->query("SELECT * from Responses WHERE responseID=".$survey );
			$isThere = $subURL->rowCount();
			$recs = $subURL->fetch();	//versus fetchall
			if($isThere>0)
			{
				//	SWITCH 'STATUS'
				//	quality, service, value, clean, recommend, verbatim
				//	SET SESSION VARIABLE FOR USER ID
					$bn = $recs["busname"];
					$q = $recs["quality"];
					$s = $recs["service"];
					$v = $recs["value"];
					$c = $recs["clean"];
					$r = $recs["recommend"];
					$txt = $recs["verbatim"];
					?>
					<h1><?php echo $bn;?></h1>
					<hr>
					<div style="width:100%;text-align:left;">
					<h3>Quality: <?php echo $q;?> out of 10.</h3>
					<h3>Service: <?php echo $s;?> out of 10.</h3>
					<h3>Value: <?php echo $v;?> out of 10.</h3>
					<h3>Cleanliness: <?php echo $c;?> out of 10.</h3>
					<h3>How Likely would this user be to recommend <?php echo $bn;?> to a friend or colleague?&nbsp;&nbsp;<?php echo $r;?> out of 10.</h3>
					<h3>Comments: <?php echo $txt;?>.</h3>
					</div>
					<?php
					
				
			}
			else
			{	//	SQL WORKED BUT NO USER MET CRITERIA
					echo "<h1>We couldn't find this report<br/>for some reason!</h1>";
				
			}
		} //end try
	catch(PDOException $e)
	{
		print "DB_ERROR";
		die();
	}
			?>
    
     	 	</div>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="<?php echo HOST;?>/js/pubnav.js"></script>

</body>
</html>