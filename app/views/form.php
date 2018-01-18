<?php
error_reporting(E_ALL);
require_once("ajax/ajax-config.php");
if(isset($business))	//	WE HAVE A KNOWN BUSINESS URL BEING CALLED IT (BUT NEED TO TEST)
	{	
		//echo DBUN . " " . DBPW;
		$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
        //$dbh = new PDO('mysql:host=localhost; dbname=greatgr2_buzz', 'buzz', 'demo');
		$formQuery = "SELECT * from wtbmembers WHERE busURL='$business'";
		$subURL = $dbh->query($formQuery);
		
		$isThere = $subURL->rowCount();
		
		//	echo $formQuery;
		
		$recs = $subURL->fetch();	//versus fetchall
		//	var_dump($recs["logoPath"]);
		
		if($isThere>0)
		{
			//	SET SESSION VARIABLE FOR USER ID
				$_SESSION['BIZNAME']=$recs["busname"];
				
			//	SET BIZ ID AGAINST WHICH WE'LL STORE RESPONSES IN THE RESPONSES TABLE
				$_SESSION['COUPON']=(!empty($recs["couponPath"]))?$recs["couponPath"]:"NULL";
				$_SESSION['BIZID']= $recs["userid"];
				$_SESSION['bizOwnerFN'] = $recs["fname"];
				$_SESSION['bizOwnerLN'] = $recs["lname"];
				$_SESSION['bizOwnerEmail'] = $recs["email"];
				$_SESSION['URL'] = $recs["busURL"];	
				
			//	SET USER EMAIL
				$_SESSION['BIZEMAIL'] = $recs["email"];	
				
			//	SET LOGO PATH	
				if(is_null($recs["logoPath"]))
					{
						$_SESSION['LOGO']= "uploads/Buzz-Logo.png";	
					}else{	
						$_SESSION['LOGO']= $recs["logoPath"];
					}
				$_SESSION['FORMTYPE']="MEMBER";
				showPage();
		}
		else{
		//	redirect to 'cannot find it' page...	
			header("location:NoLuck");
		}
	}	//	END IF ELSE
function showPage()	// CALLED AFTER ONE OF THE CONDITIONS ABOVE IS MET
{
	
	//	HANDLE UPPER CASE PER WORD IF NEEDED
		$str				= strtolower($_SESSION['BIZNAME']);
		$strUpper 			= ucwords($str);
		$_SESSION['BIZ'] 	= $strUpper;
?>

<html>

<head>
<title>Give Us The Buzz for <?php echo $_SESSION['BIZNAME'];?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/landing.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/plan.css"/>
	<link rel="shortcut icon" href="<?php echo HOST;?>/favicon.ico">
	
	<!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    .buzzButton{background-color:#ffcc00;border:1px solid #545454;}
	.buzzButton:hover{background-color:#00a8cc;border:1px solid #545454}
	.form-control:focus {
  border-color: #545454;
  outline: 0;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(255, 204, 0, .6);
          box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(255, 204, 0, .6);
}
	.myform{width:90%;margin-left:auto;margin-right:auto;padding:6px;}
	.question{padding:4%;width:90%;margin-left:auto;margin-right:auto;}
	.ranker{width:18%;height:40px; max-height:40px;background-color:#66ff00;border:none;}
	.btn:focus { outline: none; }
	.btn:clicked{outline:none;}
	.instructions{width:100%;font-size:1.2em;color:#bbb;margin-left:auto;margin-right:auto;text-align:justify;padding-bottom:10px;padding-top:4px;border-bottom:1px solid #ccc;border-top:1px solid #ccc;padding-left:2%;padding-right:2%;}
	.legend{border:none;text-align:center;}
	.hidden{display:none;}
	.unhidden{display:block;}
    </style>
</head>
<body>
<div class='container'>
<div id='logo-frame' style='width:100%;text-align:center;'>
	<img class="img-responsive" style='margin-left:auto;margin-right:auto;padding-bottom:2%;' src="<?php echo HOST;?><?php echo $_SESSION['LOGO'];?>" alt="logo"/>
</div>
<div id="showThatForm" class="myform">
<form role="form" id="feedback-form" class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend class="legend">How Was Your Visit to <?php echo $_SESSION['BIZ'];?> ?</legend>
<div class="row instructions"><em>
	For each question, just tap to indicate level of satisfaction - red (far left) is the low score. Green (far right) is the high score.</em> 
</div>
<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="qualitySel">Overall Quality</label>
  <div class="col-md-6">
    <!--
    <select id="qualitySel" name="qualitySel" class="form-control">
      <option value="99">Please Select...</option>
	 <option value="5">5 - Great</option>
      <option value="4">4 - Pretty Good</option>
	 <option value="3">3 - So So</option>
	 <option value="2">2 - Not so good</option>
	 <option value="1">1 - Poor</option> 
    </select>
    -->
    	<div id="quest-1" class="question row">
		<button id="1" class="btn ranker">&nbsp;</button>
		<button id="2" class="btn ranker">&nbsp;</button>
		<button id="3" class="btn ranker">&nbsp;</button>
		<button id="4" class="btn ranker">&nbsp;</button>
		<button id="5" class="btn ranker">&nbsp;</button>
		<input id="quest-1-resp" type="hidden" value="5">
	</div>
  </div>
</div>

<div id="additional-comments1" class="form-group hidden">
  <label class="col-md-4 control-label" for="server"></label>
  <div class="col-md-6">
    <textarea class="form-control" name="comments" id="comments1" placeholder="What did we do wrong? (Optional)"></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="serviceSel">Overall Service</label>
  <div class="col-md-6">
    <!--
    <select id="serviceSel" name="serviceSel" class="form-control">
      <option value="99">Please Select...</option>
	 <option value="5">5 - Great</option>
      <option value="4">4 - Pretty Good</option>
	 <option value="3">3 - So So</option>
	 <option value="2">2 - Not so good</option>
	 <option value="1">1 - Poor</option> 
    </select>
    -->
    
    <div id="quest-2" class="question row">
		<button id="1" class="btn ranker">&nbsp;</button>
		<button id="2" class="btn ranker">&nbsp;</button>
		<button id="3" class="btn ranker">&nbsp;</button>
		<button id="4" class="btn ranker">&nbsp;</button>
		<button id="5" class="btn ranker">&nbsp;</button>
		<input id="quest-2-resp" type="hidden" value="5">
	</div>
    
  </div>
</div>

<div id="additional-comments2" class="form-group hidden">
  <label class="col-md-4 control-label" for="server"></label>
  <div class="col-md-6">
    <textarea class="form-control" name="comments" id="comments2" placeholder="What did we do wrong? (Optional)"></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="valueSel">Overall Value</label>
  <div class="col-md-6">
    <!--
    <select id="valueSel" name="valueSel" class="form-control">
     <option value="99">Please Select...</option>
	 <option value="5">5 - Great</option>
      <option value="4">4 - Pretty Good</option>
	 <option value="3">3 - So So</option>
	 <option value="2">2 - Not so good</option>
	 <option value="1">1 - Poor</option> 
    </select>
    -->
    <div id="quest-3" class="question row">
		<button id="1" class="btn ranker">&nbsp;</button>
		<button id="2" class="btn ranker">&nbsp;</button>
		<button id="3" class="btn ranker">&nbsp;</button>
		<button id="4" class="btn ranker">&nbsp;</button>
		<button id="5" class="btn ranker">&nbsp;</button>
		<input id="quest-3-resp" type="hidden" value="5">
	</div>
  </div>
</div>

<div id="additional-comments3" class="form-group hidden">
  <label class="col-md-4 control-label" for="server"></label>
  <div class="col-md-6">
    <textarea class="form-control" name="comments" id="comments3" placeholder="What did we do wrong? (Optional)"></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="cleanSel">Overall Cleanliness</label>
  <div class="col-md-6">
    <!--
    <select id="cleanSel" name="cleanSel" class="form-control">
      <option value="99">Please Select...</option>
	 <option value="5">5 - Great</option>
      <option value="4">4 - Pretty Good</option>
	 <option value="3">3 - So So</option>
	 <option value="2">2 - Not so good</option>
	 <option value="1">1 - Poor</option> 
    </select>
    -->
    <div id="quest-4" class="question row">
		<button id="1" class="btn ranker">&nbsp;</button>
		<button id="2" class="btn ranker">&nbsp;</button>
		<button id="3" class="btn ranker">&nbsp;</button>
		<button id="4" class="btn ranker">&nbsp;</button>
		<button id="5" class="btn ranker">&nbsp;</button>
		<input id="quest-4-resp" type="hidden" value="5">
	</div>
  </div>
</div>

<div id="additional-comments4" class="form-group hidden">
  <label class="col-md-4 control-label" for="server"></label>
  <div class="col-md-6">
    <textarea class="form-control" name="comments" id="comments4" placeholder="What did we do wrong? (Optional)"></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="nprSel">
  How Likely Are You To Recommend Us to a Friend?
  </label>
  <div class="col-md-6">
    <!--
    <select id="nprSel" name="nprSel" class="form-control">
      <option value="0">Please select...</option>
      <option value="10">Extremely Likely</option>
	 <option value="9">9</option>
      <option value="8">8</option>
	 <option value="7">7</option>
	 <option value="6">6</option>
	 <option value="5">Neutral</option>
	 <option value="4">4</option>
	 <option value="3">3</option>
	 <option value="2">2</option>
	 <option value="1">Not At All Likely</option>
    </select>
    -->
    <div id="quest-5" class="question row">
		<button id="1" class="btn ranker">&nbsp;</button>
		<button id="2" class="btn ranker">&nbsp;</button>
		<button id="3" class="btn ranker">&nbsp;</button>
		<button id="4" class="btn ranker">&nbsp;</button>
		<button id="5" class="btn ranker">&nbsp;</button>
		<input id="quest-5-resp" type="hidden" value="5">	
	</div>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="server">Who was your server?</label>
  <div class="col-md-6">
    <input type="text" class="form-control" name="server" id="server" placeholder="server name (optional)">
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="verbatim">What could we do better or keep doing?</label>
  <div class="col-md-6">                     
    <textarea class="form-control" id="verbatim" name="verbatim" placeholder="comments (optional)"></textarea>
  </div>
</div>
<!-- EMAIL -->
<div class="form-group">
  <label class="col-md-4 control-label" for="nprSel">Leave your email and we'll send a coupon!</label>
  <div class="col-md-6">
    <input type="email" class="form-control" name="email" id="email" placeholder="email (optional)">
  </div>
</div>
</fieldset>
</form>
<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submitFeedback"></label>
  <div class="col-md-4">
    <button style="width:100%" id="submitFeedback" name="submitFeedback" class="btn btn-primary buzzButton">Send it!</button>
  </div>
</div>
</div><!-- slide up -->

 
<!-- spinner -->
<div id="FormPending" style="display:none;text-align:center;padding-top:8%;">
<img src="<?php echo HOST;?>img/ajax-loader.gif" alt='loader'style="margin-left:auto;margin-right:auto"/>
</div>
<div id="ThankYou" style="display:none;text-align:center;padding-top:8%;font-size:1.4em;font-weight:bold;">Thank you for your submission!</div>
	<div id="ThankYou2" style="display:none;text-align:center;padding-top:4%;font-size:1.4em;font-weight:bold;">You will be receiving a coupon from us soon!</div>
<!-- spinner end -->


</div> <!-- container --> 

</body>
</html>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
// 	SCRIPT TO HANDLE THE RESPONSES
	

//	SCRIPT TO HANDLD SUBMISSION FUNCTION
	$(document).ready(function(){
		$("#submitFeedback").click(function(){
			$("#showThatForm").slideUp("slow",function(){
				$("#FormPending").fadeIn(500).delay(3000).after(function(){
						sendFeedback();	// LOG IT INTO DATABASE
					$("#FormPending").fadeOut(500,function(){
						$("#ThankYou").fadeIn(750);
						$("#ThankYou2").fadeIn(750);
					});
						
				});
			});	
		});
	});
	
//	SCRIPT TO HANDLE AJAX RECORD AND RESPONSE
	function sendFeedback()
	{
			$.ajax({
			type: 'POST',
			url: "/ajax/ajaxfeedback.php/",
			data: {	
			//	pull these in either way. for updates, we use.
				
			//	Add User ID
				'userID'		:	'<?php echo $_SESSION['BIZID'];?>',
			//	Add User Email
			//	'userEmail'	:	'',
			//	FORM HERE
				'qual'	:	$("#quest-1-resp").val(), // qual, service, value, clean, npr
				'qualcomment'	:	$("#comments1").val(), // comments about quality
				'serv'	:	$("#quest-2-resp").val(), //service, value, clean, npr
				'servcomment'	:	$("#comments2").val(), // comments about service
				'value'	:	$("#quest-3-resp").val(), //service, value, clean, npr
				'valuecomment'	:	$("#comments3").val(), // comments about value
				'clean'	:	$("#quest-4-resp").val(), //service, value, clean, npr
				'cleancomment'	:	$("#comments4").val(), // comments about cleanliness
				'npr'		:	$("#quest-5-resp").val(), //service, value, clean, npr
				'consumer'	:	$("#email").val(), //service, value, clean, npr
				'server'	:	$("#server").val(),	//	added server 10/16/2016
				'words'	:	$("#verbatim").val(), //service, value, clean, npr
				},
				beforeSend:function(){
					//	alert(data);	
				},
				success:function(data)
				{	
					// 	DO CLOSE OUT STUFF HERE
					//	alert(data);
						
						//var responseSet = data.split(":");
					//	alert(responseSet[0]);
//						$("#ThankYou").style = "display:block";//.html("<h3>"+responseSet[0]+"</h3>");
					//	SEND AN UPDATE TO THE DB TO RECORD SUCCESS / FAILURE OF EMAIL	
				
				},
				error:function(data)
				{
					//	alert(data);
				}
		});	//	END AJAX	
	}

</script>
<script>

$(document).ready(function(){
	
	$(".myform .question button").click(function(event){

	//	WHAT BUTTON ARE WE TOUCHING	
		var myButton = $(this).attr('id');
		
	//	WHOSE BUTTON ARE WE TOUCHING
		var myParent = $(this).parent().attr('id');
		
	//	REST BG COLORS
		$("#"+myParent + " .ranker").css('background-color','#aaa');
		$("#"+myParent + " .ranker").css('border-style','none');

	//  DO WE NEED ADDITIONAL COMMENTS
		var comments = false;
	
	//	WHO NEEDS COMMENTS
		var add_comments = "additional-comments";
		var which_comment = myParent.substr(6,7);
		add_comments += which_comment;
		var item = document.getElementById(add_comments);
		
	//	SET COLOR NASED ON SELECTION
		switch(myButton)
		{
			case "1":	//	RED
				myColor = "#ff0000";
				comments = true;
			break;
			case "2":	//	ORANGE
				myColor = "#ff9900";
				comments = true;
			break;
			case "3":	//	YELLOW
				myColor = "#ffcc00";
				comments = true;
			break;
			case "4":	//	LIME
				myColor = "#ccff00";
			break;
			case "5":	//	GREEN
				myColor = "#66ff00";	
			break;	
		}

		if (comments == true && which_comment < 5){
			item.className = 'form-group unhidden';}
		else if(comments == false && which_comment < 5){
			item.className = 'form-group hidden';}
	
	//	UPDATE COLOR CODING
		for(i=1;i<=myButton;i++)
		{
			//	VERBOSE TO ILLUSTRATE HOW TO BUILD STRING FOR ID
				parentName = "#"+myParent;
				buttonName = "#"+i;
				myTarget = parentName + " " + buttonName;
			//	SET BG COLOR OF BUTTONS 'UP TO' WHERE SCORE STOPS	
				$(myTarget).css('background-color',myColor);
				$(myTarget).css('border-color','#000000');
				$(myTarget).css('border-style','solid');
		}	
	$("#"+myParent+"-resp").val($(this).attr('id'));
	
	event.preventDefault();
	
	});
	
	$(".myform .question button").hover(function(){
		
	});

});	//	END DOC READY


</script>
<?php
}	//	END SHOW FORM FUNCTION
?>