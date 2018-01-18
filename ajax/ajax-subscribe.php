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
	$TELEPRE 		= 	$_REQUEST['telepre'];
	$TELEFULL 		= 	$_REQUEST['telefull'];
	$BIZNAME		= 	$_REQUEST['bizname'];
	$NUMLOC 		= 	$_REQUEST['numloc'];
	
	
//	CODE HERE TO CLEAN UP STRINGS AND SUBMIT TO DATABASE

//	FORMAT MESSAGE
	$htmlMsg = "<pr>A subscription request has been submitted by " . $FNAME . " " . $LNAME . ".</pr>";
	$htmlMsg .= "<pr>Email: <a href='mailto:".$EMAIL."'>".$EMAIL."</a>.</pr>";
	$htmlMsg .= "<pr>Business Name: ".$BIZNAME.".</pr>";
	$htmlMsg .= "<pr>Telephone: (".$TELEPRE.") ".$TELEFULL.".</pr>";
	$htmlMsg .= "<pr>Number of Locations: ".$NUMLOC.".</pr>";
	
	$textMsg = "A subscription request has been submitted by " . $FNAME . " " . $LNAME . ".\n\n";
	$textMsg .= "Email: <a href='mailto:".$EMAIL."'>".$EMAIL."</a>.\n\n";
	$textMsg .= "Business Name: ".$BIZNAME.".\n\n";
	$textMsg .= "Telephone: (".$TELEPRE.") ".$TELEFULL.".\n\n";
	$textMsg .= "Number of Locations: ".$NUMLOC.".\n\n";
	
	$sendSubscribe = emailCall($htmlMsg,$textMsg,$BIZNAME);
	echo $sendSubscribe;
	
//	CODE HERE TO SEND ADMIN AN EMAIL
	function emailCall($htmlMsg, $textMsg, $bizname)
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
	$mail->FromName = 'Subscription Request';
	$mail->addAddress("subscribe@whatsthe.buzz","Brent Phillips");     
	$mail->WordWrap = 50;                                 		// Set word wrap to 50 characters
	$mail->isHTML(true);                                  		// Set email format to HTML
	$mail->Subject = "Subscription Request for";
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