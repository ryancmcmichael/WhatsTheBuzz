<!doctype html>
<html>

<head>
<title>CommentBox.es for <?php echo $business;?></title>
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
<h2>We're sorry! We couldn't find that business.</h2>
</div> <!-- container --> 

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