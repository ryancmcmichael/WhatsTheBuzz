<?php
session_start();

// 	GET THE CONFIG FILE
	include("ajax-config.php");


//	HANDLES MAIL ALERTS FOR ANON OR KNOWN FORM POSTS
//	define('RELPATH',dirname($_SERVER['PHP_SELF'])."/");
//	define('SRVHOST',$_SERVER['HTTP_HOST']);

	$refLink = "../mailer/PHPMailerAutoload.php";	
	
	include($refLink);

function emailCall($htmlMsg, $textMsg, $toEmail, $toName, $subject, $attachPath, $attachName)
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
	$mail->FromName = 'Mail from WhatsThe.Buzz';
	$mail->addAddress($toEmail, $toName);     
	//	$mail->addReplyTo('info@example.com', 'Information');
	//	$mail->addAddress(email string, name string);
	//	$mail->addCC('jbrentonphillips@gmail.com');
	$mail->addBCC('jbrentonphillips@gmail.com');
		
	//	$mail->addBCC('bcc@example.com');
		
	$mail->WordWrap = 50;                                 		// Set word wrap to 50 characters
	//	$mail->addAttachment('/var/tmp/file.tar.gz');        	// Add attachments
	
	if($attachPath!="NULL")
	{
		$mail->addAttachment($attachPath,$attachName);   			// Optional name
	}
		$mail->isHTML(true);                                  		// Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body    = $htmlMsg;
		$mail->AltBody = $txtMsg;
		
		if(!$mail->send()) {
		//    echo 'ERROR';
		//    echo 'Mailer Error: ' . $mail->ErrorInfo;
			return 'FALSE';
		
		} else {
		   return 'TRUE';
		}
}




/*
function twitterCall($which)
{
	require_once("TwitterAPIExchange.php");
	$settings = array(
    		'oauth_access_token' => "2814928212-gc4pxbAmvs1VZVLkkt01RkjrB601YOboepkm8zI",
    		'oauth_access_token_secret' => "RdkEWG0tlxsaeBgLdytHpHKNVW4mqPKYpsTc1si5H8Dyu",
    		'consumer_key' => "jV5PWWL0LxKVKZQoPrJPjzVPr",
    		'consumer_secret' => "Y3YsNVA3v8w8jUhqEde6fa8tvsrtVtE25AwckjqH0ozkhIFm53"
	);

$url = 'https://api.twitter.com/1.1/statuses/update.json';
$requestMethod = "POST";
/*
$postfields = array(
    		'screen_name' => 'usernameToBlock', 
    		'skip_status' => '1'
		);

		
//	RESET CITY STRING FOR CASES
$citystrlow	= strtolower($_SESSION['CITY']);
$cityUpper 	= ucwords($citystrlow);

$postfields = array(
    'status' => $_SESSION['BIZ']." was just reviewed.". $which, 
	);

$twitter = new TwitterAPIExchange($settings);
$result = $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest();  
}
*/

function killSession()
{
	
	$_SESSION = array();
	if (ini_get("session.use_cookies")) {
    		$params = session_get_cookie_params();
    		setcookie(session_name(), '', time() - 42000,
        		$params["path"], $params["domain"],
        		$params["secure"], $params["httponly"]
    		);
}
session_destroy();
return true;
}
?>
