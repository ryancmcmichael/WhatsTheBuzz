<!doctype html>
<html>
<head>
<title>CommentBox.es for <?php echo $business;?></title>
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
<div id="showThatForm">
<form role="form" id="feedback-form" class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Give us your feedback!</legend>

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
<!-- spinner end -->


</div><!-- container --> 

</body>
</html>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$("#submitFeedback").click(function(){
		//	alert('clicks');
		$("#showThatForm").slideUp("slow",function(){
			$("#FormPending").fadeIn(500).delay(1000).after(function(){
					sendPost(); 
			});
		});	
	});
})

//	HANDLE FORM DATA
function sendPost(){
	/*
			'qual'	:	$("#qualitySel").val(),
			'serv'	:	$("#serviceSel").val(),
			'valu'	:	$("#valueSel").val(),
			'clean'	:	$("#cleanSel").val(),
			'npr'	:	$("#nprSel").val(),
			'verb'	:	$("#verbatim").val()*/
			
			$.ajax({
		type: 'POST',
		url: "ajax/ajax-feedback.php",
		data: {	
		//	pull these in either way. for updates, we use.
			'type'	:	'SIGNUP',
			'email'	:	$("#email").val(),
			'fname'	:	$("#fname").val(),
			'lname'	:	$("#lname").val(),
			'pw1'	:	$("#pw1").val(),
			'pw2'	:	$("#pw2").val()
			
			},
			beforeSend:function(){
				
			},
			success:function(data)
			{	
				switch(data)
				{
					case "TRUE":
						alert('yay');	
					break;
					case "EMAIL_ERROR":
						alert('boo');
					break;
					case "DB_ERROR":
						alert('db');
					break;
						
				}
			},
			error:function(data)
			{
				alert('buggy');
			}
	});	//	END AJAX	
	
	
		
} //	END SEND POST

// AJAX TO HANDLE SUBMISSION
</script>