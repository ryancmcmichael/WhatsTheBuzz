<?php
//session_start();

//	UPDATE DATABASE, NEED THE FOLLOWING PLUS SESSION['BIZID']
	$_SESSION['ID']			=	$_REQUEST['userID'];	
	$_SESSION['qual']		= 	$_REQUEST['qual'];
	$_SESSION['qualcomment']	=	$_REQUEST['qualcomment'];
	$_SESSION['serv'] 		= 	$_REQUEST['serv'];
	$_SESSION['servcomment']	=	$_REQUEST['servcomment'];
	$_SESSION['value'] 		= 	$_REQUEST['value'];
	$_SESSION['valuecomment']	=	$_REQUEST['valuecomment'];
	$_SESSION['clean'] 		= 	$_REQUEST['clean'];
	$_SESSION['cleancomment']	=	$_REQUEST['cleancomment'];
	$_SESSION['npr']		= 	$_REQUEST['npr'];
	$_SESSION['words'] 		= 	strip_tags($_REQUEST['words']);		// SUBMITTER COMMENTS
	$_SESSION['server']		=	strip_tags($_REQUEST['server']);		// WAITER - WAITRESS	
	$_SESSION['email']		=	strip_tags($_REQUEST['consumer']);		// SUBMITTER EMAIL
	
//	CALCULATE AVERAGE HERE FOR CORE QUESTIONS
	$_SESSION['AvgScore'] = 	
	(	
		$_SESSION['qual']+
		$_SESSION['serv']+
		$_SESSION['value']+
		$_SESSION['clean']
	)/4;	
	//echo $_SESSION['AvgScore'];
	//echo $_SESSION['npr'] . " NPR";
	//exit;
		

// 	DATABASE CONNECTIVITY
//	include("ajax-config.php");

//	GET OUR MAIL FUNCTIONS HERE
	include("ajax-coupon.php");
	include("ajax-mailer.php");
	
	try 
		{
			$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
			$insertSQL = "INSERT INTO Responses(accountID,respEmail,quality,";
			$insertSQL .= "qualitycomment,service,servicecomment,value,valuecomment,";
			$insertSQL .= "clean,cleancomment,recommend,server,verbatim,googleID,busname) ";
			$insertSQL .= "VALUES(". $_SESSION['ID'].",";
			$insertSQL .= "'".$_SESSION['email']."',";
			$insertSQL .= $_SESSION['qual'].",";
			$insertSQL .= "'".$_SESSION['qualcomment']."',";
			$insertSQL .= $_SESSION['serv'].",";
			$insertSQL .= "'".$_SESSION['servcomment']."',";
			$insertSQL .= $_SESSION['value'].",";
			$insertSQL .= "'".$_SESSION['valuecomment']."',";
			$insertSQL .= $_SESSION['clean'].",";
			$insertSQL .= "'".$_SESSION['cleancomment']."',";
			$insertSQL .= $_SESSION['npr'].",'";
			$insertSQL .= $_SESSION['server']."',";
			$insertSQL .= "'".$_SESSION['words']."',";
			$insertSQL .= "'','".$_SESSION['BIZNAME']."') ";
			
			$insertSQL = $dbh->prepare($insertSQL);
			$updateDB = $insertSQL->execute();
			
			$_SESSION['responseID'] = $dbh->lastInsertId();
			
			if($updateDB) 
					{
						sendManagerAlert();				
					}
					else
					{
						echo "DB_ERROR";
					}
		} //end try
	catch(PDOException $e)
	{
		print "DB_ERROR";
		die();
	}

//	END DB UPDATE 



	
//	HANDLE EMAIL BUILD AND SEND TO MANAGER
	function sendManagerAlert()
	{		
		
	//	NOTIFIES OWNER THAT A SURVEY HAS BEEN COMPLETED	
		$AdminEmail = emailCall
		(
			htmlMsgAdmin(),
			textMsgAdmin(),
			$_SESSION['bizOwnerEmail'],
			$_SESSION['bizOwnerFN'] . " " . $_SESSION['bizOwnerLN'],
			"Survey Alert",
			"NULL",
			"NULL"
		);
		$_SESSION['managerAlert'] = $AdminEmail;
		
	//	CHECK FOR CONSUMER EMAIL - IF EMAIL, WE SEND A THANK YOU			
		if(!empty($_SESSION['email']))
		{
			filterForThankYouEmail();	
		}else{
				//	NO EMAIL SO WE JUST THANK THEM FOR THEIR INPUT
					echo "<p>Survey submitted<br>Thank you!</p>:NULL";
			}
	}	//	END SEND MANAGER ALERT
	
	
	
//	NET PROMOTER NOTES
	/*
	QUESTION TO ASK:
	How likely is it that you would recommend our company/product/service to a friend or colleague? 
	
	Promoters (score 9-10) are loyal enthusiasts who will keep buying and refer others, fueling growth.
	Passives (score 7-8) are satisfied but unenthusiastic customers who are vulnerable to competitive offerings.
	Detractors (score 0-6) are unhappy customers who can damage your brand and impede growth through negative word-of-mouth.
	
	CALCULATE NET PROMOTER SCORE AS FOLLOWS:
	% PROMOTERS - % DETRACTORS = NET PROMOTER SCORE. RANGE CAN BE -100 to 100 (if all detractors or all promoters)
	
	*/		
	
	
	
//	LOGIC TO MANAGE CONSUMER RESPONSES IF WE HAVE AN EMAIL
	function filterForThankYouEmail()
	{
		
		//	CHECK THE COUPON STATUS
			$getCoupon = evaluateCoupon();
		
		//	SET SESSIONS TO LOCAL HERE TO MAKE MATHING EASIER
			$avgNum 	= $_SESSION['AvgScore'];
			$npr		= $_SESSION['npr'];
		
		//	LOGIC HERE TO DETERMINE WHAT MESSAGE THEY RECIEVE
			
		//	1) EXCEPTIONAL EXPERIENCE, PROMOTERS
			if($avgNum>=4 && $npr==5)
			{
				sendThankYouCoupon('promoter',$getCoupon);
			}else
			
		//	2) PRETTY GOOD EXPERIENCE
			if($avgNum>=4 && $npr==4)
			{
				sendThankYouCoupon('passivehigh',$getCoupon);	
			}
			
		//	SO SO EXPERIENCE
			else
			if($avgNum<4 && $npr>=4)
			{
				sendThankYouCoupon('passivelow',$getCoupon);
			}
			else
			
		//	NOT A GREAT EXPERIENCE AT ALL	
			{
				sendThankYouCoupon('detractor',$getCoupon);	
			}
		//		
		
	}
	//	ENDING SEND CONSUMER A MESSAGE
	
	
//	TAKE CARE OF COUPON
	function evaluateCoupon()
	{
		
		
	//	THIS SECTION BUILDS / SENDS THANK YOU TO CUSTOMER (IF EMAIL PROVIDED)	
		if($_SESSION['COUPON']!="NULL")
		{
			/*	CALL FUNCTION HERE TO BUILD COUPON WITH EXPIRY DATE AND UNIQUE CODED NUMBER
				THEN RESET COUPON IMAGE PATH TO NEW FILE BASED ON STUB
				SEND BASE COUPON TO THE FUNCTION
				VARIABLE HERE WILL BE NEW STRING TO FILE PATH
			*/
			
			//	function customizeCoupon($toWhom, $account, $whichCoupon, $expiry)
				$newPath = customizeCoupon($_SESSION['email'],$_SESSION['ID'],$_SESSION['COUPON'],90);
				
				if($newPath!="FALSE")
				{
					$_SESSION['COUPON'] = $newPath;	
				}else{
					$_SESSION['COUPON']="NULL";
					$thankYouID = "NULL";
				}
			//	NAME OF THE 'FILE' BEING SENT
				$thankYouID = $_SESSION['URL']."-Coupon";	
		}else{
			$thankYouID = "NULL";
		}	//	END TEST FOR COUPON
		
		return $thankYouID;
		
	}	// END EVALUATE COUPON
	
	
	
	
//	SEND THANK YOU EMAILS BASED ON ALL THE CRITERIA LISTED ABOVE
	function sendThankYouCoupon($experience, $couponStatus)
	{
		//	HERE WE BUILD THE APPROPRIATE MESSAGES, THEN SEND THE EMAIL	
		
			$htmlThankYou 	= "";
			$textThankYou 	= "";
			$htmlCoupon	= "";
			$textCoupon	= "";
		
		//	HANDLE COUPON STRING TO APPEND
			if($couponStatus!="NULL")	//	WE HAVE A COUPON
			{
				$htmlCoupon = "As a thank you for your time, we are attaching a coupon for you to use during your next visit.<br>";
				$textCoupon = "As a thank you for your time, we are attaching a coupon for you to use during your next visit.\n";	
			}
							
		//	OPENER HERE
			$htmlThankYou = "<body><p>Hello from the team at ".$_SESSION['BIZ'].". We want to sincerely thank you for taking the time to provide feedback to us.<br>We take quality and value very seriously and will use your feedback to help create the best possible dining experience for our customers.</p>".$htmlCoupon;
			
			$textThankYou = "Hello from the team at ".$_SESSION['BIZ'].". We want to sincerely thank you for taking the time to provide feedback to us.\nWe take quality and value very seriously and will use your feedback to help create the best possible dining experience for our customers.\n".$textCoupon;		;
	
	
		//	APPEND FINAL MESSAGE BASED ON THE ACTUAL SCORES
			switch($experience)
			{
				case "promoter":
					$htmlThankYou .= "<p>Based on your responses, it looks like we took great care of you during your visit. We're happy to hear it and we'll strive to always exceed your expectations every time you come in. Thanks again, and we hope to see you again soon!</p>";
					$textThankyou .= "\nBased on your responses, it looks like we took great care of you during your visit. We're happy to hear it and we'll strive to always exceed your expectations every time you come in. Thanks again, and we hope to see you again soon!\n";
 			
				$formCloser = "<p>Survey submitted<br>Thank you!</p>";
				break;
				
				case "passivehigh":
				
				$htmlThankYou .= "<p>Based on your responses, it looks like you had a pretty good time. We also see that we have some room for improvement before we can truly exceed your expectations. We continue to look for ways to improve our dining experience and hope to have another chance soon to win your business.</p>";
				$textThankyou .= "\nBased on your responses, it looks like you had a pretty good time. We also see that we have some room for improvement before we can truly exceed your expectations. We continue to look for ways to improve our dining experience and hope to have another chance soon to win your business.\n";
				
				$formCloser = "<p>Survey submitted<br>Thank you!</p>";
							
				break;
				
				case "passivelow":
				
				$htmlThankYou .= "<p>Based on your responses, it looks like your visit with us wasn't what it should have been and we are truly sorry. We continue to look for ways to improve our dining experience and would like to invite you back for another try. We will be in touch via separate email with details.</p>";
				$textThankyou .= "\nBased on your responses, it looks like your visit with us wasn't what it should have been and we are truly sorry. We continue to look for ways to improve our dining experience and would like to invite you back for another try. We will be in touch via separate email with details.\n";
				
				$formCloser = "<p>Survey submitted<br>Thank you!</p>";
				
				break;
				
				case "detractor":
					
				$htmlThankYou .= "<p>Based on your responses, it looks like your visit with us was significantly below your expectations and we are truly sorry. We continue to look for ways to improve our dining experience and would like to invite you back for another try. We will be in touch via separate email with details.</p>";
				$textThankyou .= "\nBased on your responses, it looks like your visit with us was significantly below your expectations and we are truly sorry. We continue to look for ways to improve our dining experience and would like to invite you back for another try. We will be in touch via separate email with details.\n";
				
				$formCloser = "<p>Survey submitted<br>Thank you!</p>";
				
				break;
					
			}
			
			$ThankYouEmail = emailCall
			(
					$htmlThankYou,
					$textThankYou,
					$_SESSION['email'],"Our Guest at " . $_SESSION['BIZ'],
					"Thank You",
					$_SESSION['COUPON'],
					$thankYouID
			);		
	
			// return $managerEmail.":".$ThankYouEmail.":".$formCloser;
			echo $formCloser.":".$ThankYouEmail.":".$_SESSION['managerAlert'].":".$_SESSION['responseID'];
	
	}	//	END SEND THANK YOU SERIES
	
	function htmlMsgAdmin()
	{
	
	$netpromote = translateVal($_SESSION['npr']);
	if(!empty($_SESSION['email']))
	{
		$emailMsg = "Oh, and they left an email address too. <br>Email address is: <a href='mailto:".$_SESSION['email']."'>".$_SESSION['email']."</a><br><br>";	
	}
	if(!empty($_SESSION['words']))
	{
		$thoughts = "...And some Feedback: <br>".$_SESSION['words'].".<br><br>";	
	}
	if(!empty($_SESSION['server']))
	{
		$serverWas = "Their server was: " . $_SESSION['server'];	
	}
	
	$bodyMsgHTML = "<!doctype html><html><head><meta charset='UTF-8'>";
	$bodyMsgHTML .= "<title>Survey Notice</title>";
	$bodyMsgHTML .= "<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet'>";
	$bodyMsgHTML .= "<style type='text/css'>";
	$bodyMsgHTML .= "body{margin:0;background-color:#fff;}";
	$bodyMsgHTML .= "#container{width:90%;;text-align:center;margin-left:0;margin-right:0;}";
	$bodyMsgHTML .= ".logo-style{width:70%;margin-left:auto;margin-right:auto}";
	$bodyMsgHTML .= "#message{width:90%;text-align:left;margin-left:auto;margin-right:auto;}";
	$bodyMsgHTML .= "#message p, table{font-family: 'Open Sans', sans-serif;font-size:1.2em;color:#444444;}";
	$bodyMsgHTML .= "#results{width:100%;padding:5px;border-color:#fff;}";
	$bodyMsgHTML .= ".got1{background-color:#FF0004;width:20px;}";
	$bodyMsgHTML .= ".got2{background-color:#FF9000;width:20px;}";
	$bodyMsgHTML .= ".got3{background-color:#FFDD00;width:20px;}";	
	$bodyMsgHTML .= ".got4{background-color:#C2FF00;width:20px;}";
	$bodyMsgHTML .= ".got5{background-color:#5AF300;width:20px;}";
	$bodyMsgHTML .= ".noResponse{background-color:#000000;}";
	$bodyMsgHTML .= "#results td.colr{width:10%;}";
	$bodyMsgHTML .= "#results td.disp{width:30%;}";
	$bodyMsgHTML .= "</style></head><body>";
	$bodyMsgHTML .= "<div id='container'>";
	$bodyMsgHTML .= "<img class='logo-style' src='https://whatsthe.buzz/uploads/Buzz-Logo.png' alt='WhatsThe.Buzz Logo'/>";
	$bodyMsgHTML .= "<div id='message'>";
	$bodyMsgHTML .= "<p>Hello ". $_SESSION["bizOwnerFN"] .", </p>";
	$bodyMsgHTML .= "<p>A survey was just submitted for ".$_SESSION['BIZ'].". Here are the results:</p>";
	$bodyMsgHTML .= "<table id='results'>";	// my table
	
	
	
	// AVERAGE
	$avgColor = getColor((int)$_SESSION['AvgScore']);
	$bodyMsgHTML .= "<tr class='row'>";
	$bodyMsgHTML .= "<td class='colr, ".$qavgColor."'><img src='https://whatsthe.buzz/img/".$avgColor.".png' alt='color icon'></td>";
	$bodyMsgHTML .= "<td class='disp'>Average Score:</td>";
	$bodyMsgHTML .= "<td>".$_SESSION['AvgScore']."</td>";
	$bodyMsgHTML .= "</tr>";
	
	// QUALITY
	$qualColor = getColor($_SESSION['qual']);
	$bodyMsgHTML .= "<tr class='row'>";
	$bodyMsgHTML .= "<td class='colr, ".$qualColor."'><img src='https://whatsthe.buzz/img/".$qualColor.".png' alt='color icon'></td>";
	$bodyMsgHTML .= "<td class='disp'>Overall Quality:</td>";
	$bodyMsgHTML .= "<td>".$_SESSION['qual']."</td>";
	$bodyMsgHTML .= "</tr>";
	
	// SERVICE
	$serviceColor = getColor($_SESSION['serv']);
	$bodyMsgHTML .= "<tr class='row'>";
	$bodyMsgHTML .= "<td class='colr, ".$serviceColor."'><img src='https://whatsthe.buzz/img/".$serviceColor.".png' alt='color icon'></td>";
	$bodyMsgHTML .= "<td class='disp'>Overall Service:</td><td>".$_SESSION['serv']."</td>";
	$bodyMsgHTML .=	"</tr>";
	
	// VALUE
	$valueColor = getColor($_SESSION['value']);
	$bodyMsgHTML .= "<tr class='row'>";
	$bodyMsgHTML .= "<td class='colr, ".$valueColor."'><img src='https://whatsthe.buzz/img/".$valueColor.".png' alt='color icon'></td>";
	$bodyMsgHTML .= "<td class='disp'>Overall Value:</td><td>".$_SESSION['value']."</td>";
	$bodyMsgHTML .= "</tr>";
	
	// CLEANLINESS
	$cleanColor = getColor($_SESSION['clean']);
	$bodyMsgHTML .= "<tr class='row'>";
	$bodyMsgHTML .= "<td class='colr, ".$cleanColor."'><img src='https://whatsthe.buzz/img/".$cleanColor.".png' alt='color icon'></td>";
	$bodyMsgHTML .= "<td class='disp'>Overall Cleanliness:</td><td>".$_SESSION['clean']."</td>";
	$bodyMsgHTML .= "</tr>";
	
	//	RATING
	$rateColor = getPromoteColor($_SESSION['npr']);
	$bodyMsgHTML .= "<tr class='row'>";
	$bodyMsgHTML .= "<td class='colr, ".$rateColor."'><img src='https://whatsthe.buzz/img/".$rateColor.".png' alt='color icon'></td>";
	$bodyMsgHTML .= "<td class='disp'>Willing to Recommend:</td><td>".$netpromote."</td>";
	
	$bodyMsgHTML .= "</tr>";
	$bodyMsgHTML .= "</table><p>". $emailMsg ."</p><p>" . $serverWas . "</p><p>" . $thoughts . "</p></div></div></body></html>";
	return $bodyMsgHTML;

}

	function textMsgAdmin()
	{
//	BUILD TREXT MESSAGE
	$netpromote = translateVal($_SESSION['npr']);
	$bodyMsgTXT = "Hello " . $_SESSION["bizOwnerFN"] . ":\n";
	$bodyMsgTXT .= $_SESSION['BIZ']." was recently reviewed by a customer and here were their results.\n\n";
	$bodyMsgTXT .= "The ratings were as follows:\n\n";
	$bodyMsgTXT .= "Score Average: " . $_SESSION['AvgScore'] . ".\n\n";
	$bodyMsgTXT .= "Overall Quality: " . $_SESSION['qual'] . ".\n";
	$bodyMsgTXT .= "Overall Service: " . $_SESSION['serv'] . ".\n";
	$bodyMsgTXT .= "Overall Value: " . $_SESSION['value'] . ".\n";
	$bodyMsgTXT .= "Overall Cleanliness: " . $_SESSION['clean'] . ".\n";
	$bodyMsgTXT .= "Likelihood to Recommend to a friend: " . $netpromote . " out of 10.\n";
	if(!empty($_SESSION['words'])){
		$bodyMsgTXT .= "Other Comments: " . $_SESSION['words'] . ".\n";
	}
	if(!empty($_SESSION['email']))
	{
		$bodyMsgTXT .= "Oh, they left an email address too. \nEmail address is: <a href='mailto:".$_SESSION['email']."'>".$_SESSION['email']."</a>\n\n";	
	}
	if(!empty($_SESSION['server']))
	{
		$bodyMsgTXT .= "...And their server was ".$_SESSION['server']."\n\n";	
	}
	return $bodyMsgTXT;
}
	

//	SOME FORMATTING BELOW FOR COLORIZING SCORES
//	PUT SCORES INTO ENGLISH
	function translateVal($what)
	{
		
		if($what<=3)
		{
			return $what.", A Detractor.";
		}else
		if($what==4)
		{
			return $what.", A Passive.";
		}else
		if($what==5)
		{
			return $what.", A Promoter.";	
		}
	}

	function getPromoteColor($num)
	{
	$score=(int)$num;
	$color="";
	if($score<=3)				//	Detractors
	{
		$color="got1";	
	}
	elseif($score==4)	//	Passives
	{
		$color="got3";
	}
	elseif($score==5)			//	PROMOTERS
	{
		$color="got5";
	}
	return $color;
}

	function getColor($num)
	{
	$color="";
		switch($num){
		case "1":
			$color="got1"; 	//	POOR
		break;
		case "2":
			$color="got2";
		break;
		case "3":
			$color="got3";	//	 SO-SO
		break;
		case "4":
			$color="got4";
		break;
		case "5":
			$color="got5";	//	GREAT
		break;
		case "99":
			$color="noResponse"; // DID NOT ANSWER THIS ONE
		break;
	}
	return $color;
}

?> 