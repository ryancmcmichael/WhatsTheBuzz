<?php
//	COMING IN FROM AN ANONYOUS USER
	require_once("ajax/ajax-config.php");

	if (isset($_SESSION['PLACEID']) && !isset($business)) 
	{
			$_SESSION['BIZID'] = 0;
			$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
			$subURL = $dbh->query("SELECT * from wtbmembers WHERE googleID='".$_SESSION['PLACEID']."';");
			$isThere = $subURL->rowCount();
			$recs = $subURL->fetch();	//versus fetchall
			
			if($isThere>0)
			{
				//	SET SESSION VARIABLE FOR USER ID
					$_SESSION['LOGO']=$recs["logo"];
					// BIZNAME ALREADY SET ON VIBE PAGE
			}
			else{
						$_SESSION['LOGO']="commentboxes-logo.png";
						// BIZ NAME ALREADY SET ON VIBE PAGE
				}
			showPage();
	}else{
			?>
			<h3>We had an error! We're offly sorry!</h3>
			<?php
	}
	function showPage()	// CALLED AFTER ONE OF THE CONDITIONS ABOVE IS MET
{
	
	//	HANDLE UPPER CASE PER WORD IF NEEDED
		$str				= strtolower($_SESSION['BIZ']);
		$strUpper 		= ucwords($str);
		$_SESSION['BIZ'] 	= $strUpper;
?>
<!doctype html>
<html>

<head>
<title>CommentBox.es for <?php echo $_SESSION['BIZ'];?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/landing.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/plan.css"/>
	
	<!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class='container'>
<div id='logo-frame' style='width:100%;text-align:center;'>
	<img class="img-responsive" style='margin-left:auto;margin-right:auto;padding-bottom:2%;' src="<?php echo HOST;?>/logos/<?php echo $_SESSION['LOGO'];?>" alt="logo"/>
</div>
<div id="showThatForm">
<form role="form" id="feedback-form" class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend style="text-align:center;">How Was Your Visit to <?php echo $_SESSION['BIZ'];?> ?</legend>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="qualitySel">Overall Quality</label>
  <div class="col-md-6">
    <select id="qualitySel" name="qualitySel" class="form-control">
      <option value="0">Please select...</option>
      <option value="1">1 - Extremely Poor</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5 - Average</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10 - Exceptional</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="serviceSel">Overall Service</label>
  <div class="col-md-6">
    <select id="serviceSel" name="serviceSel" class="form-control">
      <option value="1">Please select...</option>
      <option value="2">1 - Extremely Poor</option>
      <option value="3">2</option>
      <option value="4">3</option>
      <option value="5">4</option>
      <option value="6">5 - Average</option>
      <option value="7">6</option>
      <option value="8">7</option>
      <option value="9">8</option>
      <option value="10">9</option>
      <option value="">10 - Exceptional</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="valueSel">Overall Value</label>
  <div class="col-md-6">
    <select id="valueSel" name="valueSel" class="form-control">
      <option value="0">Please select...</option>
      <option value="1">1 - Extremely Poor</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5 - Average</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10 - Exceptional</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="cleanSel">Overall Cleanliness</label>
  <div class="col-md-6">
    <select id="cleanSel" name="cleanSel" class="form-control">
      <option value="0">Please select...</option>
      <option value="1">1 - Extremely Poor</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5 - Average</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10 - Exceptional</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="nprSel">Would You Recommend Us?</label>
  <div class="col-md-6">
    <select id="nprSel" name="nprSel" class="form-control">
      <option value="0">Please select...</option>
      <option value="1">1 - Absolutely Not</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5 - Probably</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10 - Definitely</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="nprSel">Would You Recommend Us?</label>
  <div class="col-md-6">
    <input type="text" class="input" name="email" id="email" placeholder="email (optional)">
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="verbatim">Any additional thoughts?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="verbatim" name="verbatim"></textarea>
  </div>
</div>
</fieldset>
</form>
<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submitFeedback"></label>
  <div class="col-md-4">
    <button id="submitFeedback" name="submitFeedback" class="btn btn-primary">Send it!</button>
  </div>
</div>
</div><!-- slide up -->

 
<!-- spinner -->
<div id="FormPending" style="display:none;text-align:center;padding-top:8%;">
<img src="<?php echo HOST;?>img/pre-loader.gif" alt='loader'style="margin-left:auto;margin-right:auto"/>
</div>
<div id="ThankYou" style="display:none;text-align:center;padding-top:8%;">
<h3>Thank you for your feedback!<br>go <a href="http://www.bing.com">search</a></h3>

</div>
<!-- spinner end -->


</div> <!-- container --> 

</body>
</html>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$("#submitFeedback").click(function(){
		$("#showThatForm").slideUp("slow",function(){
			$("#FormPending").fadeIn(500).delay(3000).after(function(){
					sendFeedback();	// LOG IT INTO DATABASE
				$("#FormPending").fadeOut(500,function(){
					$("#ThankYou").fadeIn(500);
				});
					
			});
		});	
	});
});
function sendFeedback()
{
		$.ajax({
		type: 'POST',
		url: "../ajax/ajaxfeedback.php",
		data: {	
		//	pull these in either way. for updates, we use.
			'qual'	:	$("#qualitySel").val(), // qual, servive, value, clean, npr
			'serv'	:	$("#serviceSel").val(), //servive, value, clean, npr
			'value'	:	$("#valueSel").val(), //servive, value, clean, npr
			'clean'	:	$("#cleanSel").val(), //servive, value, clean, npr
			'npr'	:	$("#nprSel").val(), //servive, value, clean, npr
			'email'	:	$("#email").val(), //servive, value, clean, npr
			'words'	:	$("#verbatim").val(), //servive, value, clean, npr
			},
			beforeSend:function(){
				
			},
			success:function(data)
			{	
				// DO CLOSE OUT STUFF HERE
				//alert(data);
			},
			error:function(data)
			{
				alert('error');
			}
	});	//	END AJAX	
}

</script>
<?php
}	//	END SHOW FORM FUNCTION
?>