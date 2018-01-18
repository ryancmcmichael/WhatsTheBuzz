<?php
//	START SESSION
	session_start();

//	INCLUDE CONFIG FILE FOR DATABASE FUNCTIONALITY LATER 
	include("ajax-config.php");

//	HANDLES MAIL ALERTS FOR ANON OR KNOWN FORM POSTS
	define('RELPATH',dirname($_SERVER['PHP_SELF'])."/");
	define('SRVHOST',$_SERVER['HTTP_HOST']);

	$refLink = "../mailer/PHPMailerAutoload.php";	
	
	include($refLink);


//	GET FIELDS FROM POST
	$FNAME		=	$_REQUEST['fname'];	
	$LNAME		= 	$_REQUEST['lname'];
	$EMAIL 		= 	$_REQUEST['email'];
	$SUBJECT 		= 	$_REQUEST['subject'];
	$MESSAGE 		= 	$_REQUEST['message'];

	
	
//	CODE HERE TO CLEAN UP STRINGS AND SUBMIT TO DATABASE

//	FORMAT MESSAGE
	$htmlMsg = "<pr>A message has been submitted by " . $FNAME . " " . $LNAME . ".</pr></br></br>";
	$htmlMsg .= "<pr>Email: <a href='mailto:".$EMAIL."'>".$EMAIL."</a>.</pr></br></br>";
	$htmlMsg .= "<pr>Subject: ".$SUBJECT.".</pr></br></br>";
	$htmlMsg .= "<pr>Message: ".$MESSAGE.".</pr>";
	
	
	$textMsg = "A message has been submitted by " . $FNAME . " " . $LNAME . ".\n\n";
	$textMsg .= "Email: <a href='mailto:".$EMAIL."'>".$EMAIL."</a>.\n\n";
	$textMsg .= "Subject: ".$SUBJECT.".\n\n";
	$textMsg .= "Message: ".$MESSAGE.".\n\n";
	
	$sendSubscribe = emailCall($htmlMsg,$textMsg);
	echo $sendSubscribe;
	
//	CODE HERE TO SEND ADMIN AN EMAIL
	function emailCall($htmlMsg, $textMsg)
{
	
	$mail = new PHPMailer;
//	$mail->SMTPDebug = 3;                               	// Enable verbose debug output
//	$mail->SMTPDebug = 3;                               	// Enable verbose debug output
	$mail->isSMTP();                                      	// Set mailer to use SMTP
	$mail->Host = 'whatsthe.buzz';  					// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               	// Enable SMTP authentication
	$mail->Username = 'admin@whatsthe.buzz';               	// SMTP username
	$mail->Password = 'Buzzy211!';                          // SMTP password
	$mail->SMTPSecure = 'ssl';                            	// Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;                                   	// TCP port to connect to
	$mail->From = 'admin@whatsthe.buzz';
	$mail->FromName = 'New Message';
	$mail->addAddress("subscribe@whatsthe.buzz","Brent Phillips");     
	$mail->WordWrap = 50;                                 		// Set word wrap to 50 characters
	$mail->isHTML(true);                                  		// Set email format to HTML
	$mail->Subject = "A Message!";
	$mail->Body    = $htmlMsg;
	$mail->AltBody = $txtMsg;
		
		if(!$mail->send())
		{
			return 'FALSE';
		
		} else {
			return 'TRUE';
		}
}
?>