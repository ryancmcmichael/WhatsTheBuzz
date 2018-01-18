<?php

//	HANDLES MAIL ALERTS FOR ANON OR KNOWN FORM POSTS

define('RELPATH',dirname($_SERVER['PHP_SELF'])."/");
if(!defined('SRVHOST'))
{
	define('SRVHOST',$_SERVER['HTTP_HOST']);
}

switch(SRVHOST)
{
	case "whatsthebuzz":
		$refLink = "../mailer/PHPMailerAutoload.php";	
	break;
	case "whatsthe.buzz":
		$refLink = "../mailer/PHPMailerAutoload.php";	
	break;	
}   


	echo SRVHOST;
	echo "IN 1";
	include($refLink);
	
$testMail = sendMail('Hello');
$test2Mail = sendOtherMail('My Dixie Wrecked');

echo "Results :" . $testMail . " " . $test2Mail;
	
function sendMail($msg)
{	
	$mail = new PHPMailer;
	
	//$mail->SMTPDebug = 3;                               // Enable verbose debug output
	$mail->isSMTP();                                      	// Set mailer to use SMTP
	$mail->Host = 'whatsthe.buzz';  					// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               	// Enable SMTP authentication
	$mail->Username = 'admin@whatsthe.buzz';               	// SMTP username
	$mail->Password = 'Buzzy211!';                          // SMTP password
	$mail->SMTPSecure = 'ssl';                            	// Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;                                    	// TCP port to connect to
	
	$mail->From = 'admin@whatsthe.buzz';
	$mail->FromName = 'The Buzz Team';
	$mail->addAddress('jbrentonphillips@gmail.com', 'John Phillips');     // Add a recipient
	//$mail->addAddress('brown.joe.e@gmail.com');               // Name is optional
	//$mail->addReplyTo('info@example.com', 'Information');
	//$mail->addCC('cc@example.com');
	//$mail->addBCC('bcc@example.com');
	
	$mail->WordWrap = 50;                                 				// Set word wrap to 50 characters
	//$mail->addAttachment('/var/tmp/file.tar.gz');         			// Add attachments
	$mail->addAttachment('./JohnsMusic.jpg', 'Coupon.jpg');    	// Optional name
	$mail->isHTML(true);                                  			// Set email format to HTML
	
	$mail->Subject = $msg;
	$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	
	if(!$mail->send()) {
	    //echo 'ERROR';
	    $status = 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
	    $status = 'TRUE for 1';
	}
	return $status;
}

function sendOtherMail($msg)
{	
	$mail = new PHPMailer;
	
	//$mail->SMTPDebug = 3;                               // Enable verbose debug output
	$mail->isSMTP();                                      	// Set mailer to use SMTP
	$mail->Host = 'whatsthe.buzz';  					// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               	// Enable SMTP authentication
	$mail->Username = 'admin@whatsthe.buzz';               	// SMTP username
	$mail->Password = 'Buzzy211!';                          // SMTP password
	$mail->SMTPSecure = 'ssl';                            	// Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;                                    	// TCP port to connect to
	
	$mail->From = 'admin@whatsthe.buzz';
	$mail->FromName = 'The Buzz Team';
	$mail->addAddress('jbrentonphillips@gmail.com', 'John Phillips');     // Add a recipient
	//$mail->addAddress('brown.joe.e@gmail.com');               // Name is optional
	//$mail->addReplyTo('info@example.com', 'Information');
	//$mail->addCC('cc@example.com');
	//$mail->addBCC('bcc@example.com');
	
	$mail->WordWrap = 50;                                 				// Set word wrap to 50 characters
	//$mail->addAttachment('/var/tmp/file.tar.gz');         			// Add attachments
	$mail->addAttachment('./JohnsMusic.jpg', 'Coupon.jpg');    	// Optional name
	$mail->isHTML(true);                                  			// Set email format to HTML
	
	$mail->Subject = $msg;
	$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	
	if(!$mail->send()) {
	    //echo 'ERROR';
	    $status = 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
	    $status = 'TRUE for 2';
	}
	return $status;
}