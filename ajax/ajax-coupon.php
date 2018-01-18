<?php

//	SET TIMEZONE
	date_default_timezone_set("America/New_York");
	
//	FOR DATABASE DEFINITION
//	include("ajax-config.php");

/*	THIS FUNCTION ACCEPTS A BASE COUPON 'STUB' THEN ADDS A TRACKING CODE
	AND EXPIRATION DATE. WHILE HERE WE UPDATE THE couponsIssued TABLE WITH
	THE DATE ISSUED, THE RECIPIENT EMAIL, THE ISSUER NAME, THE TRACKING CODE.
	THIS FUNCTION RETURNS A PATH TO THE NEW IMAGE IF SUCCESSFUL.
	IF NOT IT RETURNS 'FALSE'. THIS INDICATES TO THE CALLING FUNCTION NOT TO USE IT. 

*/

function customizeCoupon($toWhom, $account, $whichCoupon, $expiry)
{		
	
//	1) 	THIS SECTION UPDATES THE DATABASE	

//		TODAYS DATE
		$todayDateMT  = mktime(0, 0, 0, date("m") ,date("d"), date("Y"));
		
		$todayDate = date("Y-m-d",$todayDateMT);
		$dateToPrint = date("m/d/Y",$todayDateMT);
		// echo $todayDate;
			
		$SQL = "INSERT INTO `couponsIssued` ";
		$SQL.= "(`dateIssued`,`accountID`,`sentTo`)";
		$SQL.= "VALUES(";
		$SQL.= "'$todayDate',";
		$SQL.= "$account,";
		$SQL.= "'$toWhom'";
		$SQL.= ");";
		
		// echo $SQL;
		
		try 
			{
				$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
				$subURL = $dbh->query($SQL);
				if($subURL)
				{ 
					// 	SUCCESSFUL UPDATE
						$tmpCode 	= $dbh->lastInsertId();
						$tmpLen 	= strlen($tmpCode);
						$newLen	= 10 - $tmpLen;
						if($newLen>0) //	we need to pad it
						{
							$finCode = str_pad($tmpCode, $newLen, "0",STR_PAD_LEFT);
						}else{
							$finCode = $tmpCode;	
						}	
						//	echo $finCode;
					
				}else
				{ 
					return "FALSE";
				}
			
			} //end try
		catch(PDOException $e)
		{
			return "DB_ERROR";
			die();
		}

//	2) 	ALL THE FOLLOWING BUILDS THE NEW IMAGE	
	
	//	CREATE DESTINATION IMAGE FROM STUB
		$stubCoupon = "../".$whichCoupon;
		$destination_image 	= imagecreatefrompng($stubCoupon);
	
	//	CREATE SOURCE IMAGE	
		$source_image 		= imagecreate(400,40);
		$sourceBG 			= imagecolorallocate($source_image, 0 ,0 ,0);
		$sourceTXT		= imagecolorallocate($source_image, 255, 255, 255);	
	
	//	CREATE EXPIRY
		$addExpiry  = mktime(0, 0, 0, date("m") ,date("d")+(int)$expiry, date("Y"));
		$newDate = date("m/d/Y",$addExpiry);
		
	//	MESSAGE
		$message = strtoupper("ISSUED:".$dateToPrint." - EXPIRES:".$newDate);

	// 	Write the string at the top left
		imagestring($source_image, 5, 15, 10, $message, $sourceTXT);
		
	//	NOW WE COPY SOURCE TO APPLY TO DESTINATION
		imagecopymerge($destination_image, $source_image,50,460,0,0,400,40, 100);

	//	SET HEADER TYPE TO SHOW IN BROWSER	
	//	header("Content-Type:image/png");	
	//	imagepng($destination_image);		
		
	//	WRITES NEW FILE - NOTE BUILDING FULL PATH HERE
		$newCoupon = "../uploads/".$_SESSION['URL'].$finCode.".png";
		$newPath = imagepng($destination_image,$newCoupon,9);
	
	// TEST IF NEW PATH WORKED
		if($newPath)
		{
			imagedestroy($destination_image);
			imagedestroy($source_image);
			return $newCoupon;	
		
		}else{
		
			imagedestroy($destination_image);
			imagedestroy($source_image);	
			return "FALSE";
		}
}

//	TETSING FUNCTION

	/*
	$newPath = customizeCoupon
	(
		"jbrentonphillips@gmail.com",				//	towhom
		104,									//	account
		"../uploads/buffalos-coupon-stub.png",		//	coupon base
		90									//	days to expire
	);
	echo $newPath;
	*/

?>
