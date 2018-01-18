<?php
session_start();
	require_once("../constants.php");
	require_once('ajax-config.php');
//	TEST FOR EMAIL ACCOUNT			

	//$dbh = new PDO('mysql:host=localhost;dbname=survey', 'root', 'demo');
	$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);

	
	//	GET OTHER VARS
		$merchID		= $_SESSION['userid'];
		
		$imgpath 		= $_REQUEST['imagePath'];
		$title 		= $_REQUEST['coupon-title'];
		$desc 		= $_REQUEST['coupon-description'];
		$postal		= $_REQUEST['postalcode'];
		$category	= $_REQUEST['category'];
		$type		= $_REQUEST['couponType'];
		$bizName		=  $_SESSION['BIZNAME'];	
		$created 	= date("Y-m-d");
		$expired		= 'FALSE';
		
	//	GETS MAIN COUPON TABLE UPDATED
	$updateSQL = "INSERT INTO coupons(userID,bizName,title,description,couponType,couponCat,postal,imgpath,created,expired) ";
	$updateSQL .= "VALUES($merchID,'$bizName','$title','$desc',$type,$category,$postal,'$imgpath','$created','$expired') ";
	$updateDB = $dbh->query($updateSQL);
	if($updateDB) 
	{
		$success = "TRUE";
		$couponID = $dbh->lastInsertId();
	}
	else
	{
		$success = "FALSE";
	}
	//	FIRST STEP IS COMPLETE
	//	UPDATE A DETAILED COUPON TABLE NOW
		switch($success)
		{
		
			case "FALSE":
				echo "FALSE FIRST ROUND"; //	WE CANNOT CONTINUE
			break;
			case "TRUE":			
			//	WE ASSUME TRU
			//	EXECUTE DETAIL SQL HERE
			//	BUILD DETAIL STRING HERE
				$detSQL="";
				switch($type)
				{
					case "1": 	//	NORMAL
						$discount = $_REQUEST['discount'];
						$condition = $_REQUEST['condreq'];
						$expires = date("Y-m-d",strtotime($_REQUEST['expires']));
						$detSQL	=	"INSERT INTO"; 
						$detSQL	.=	" normalCoupon(couponID,discount,condreq,expires) ";
						$detSQL 	.= 	"VALUES($couponID,$discount,'$condition','$expires') ";
						
					break;
					case "2":		//	GROUP
						$initDiscount = $_REQUEST['init-discount'];
						$maxDiscount = $_REQUEST['max-discount'];
						$membersNeeded = $_REQUEST['members-needed'];
						$condition = $_REQUEST['condreq'];
						$expires = date("Y-m-d",strtotime($_REQUEST['expires']));
						$detSQL	=	"INSERT INTO"; 
						$detSQL	.=	" groupCoupon(couponID,startDiscount,maxDiscount,groupSize,condreq,expires) ";
						$detSQL 	.= 	"VALUES($couponID,$initDiscount,";
						$detSQL 	.= 	"$maxDiscount,$membersNeeded,'$condition','$expires') ";
					break;
					case "3":		//	BID
						$startPrice 	= 		$_REQUEST['start-price'];
						$buyOut 		= 		$_REQUEST['buy-out'];
						$startDate 	= 		date("Y-m-d",strtotime($_REQUEST['bid-starts']));
						$endDate		= 		date("Y-m-d",strtotime($_REQUEST['bid-ends']));	
						$detSQL		=		"INSERT INTO"; 
						$detSQL		.=		" bidCoupons(couponID,startingBid,buyOut,startDate,endDate) ";
						$detSQL 		.= 		"VALUES($couponID,$startPrice,$buyOut,'$startDate','$endDate') ";
					break;
				}
				//	DETAIL SQL UPDATE SCRIPT HERE
					$detailSQL = $dbh->query($detSQL);
					if($detailSQL)
					{
						$finalSuccess="TRUE";
					}
					else
					{
						$finalSuccess="FALSE";
					}
					echo $finalSuccess;
			break;
		}
	

?>