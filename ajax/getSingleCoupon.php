<?php
require_once("../constants.php");
require_once('ajax-config.php');
$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
$which = $_REQUEST['which'];
$type = $_REQUEST['type'];
//	DETERMINE WHICH QUERY TO EXECUTE
	switch($type)
	{
		case "1":		//	coupons JOIN WITH normalCoupon TABLE
			$getSQL 	= "select coupons.couponID,coupons.title,coupons.description,";
			$getSQL .= "coupons.postal,coupons.imgpath,coupons.created,";
			$getSQL .= "normalCoupon.discount,normalCoupon.condreq,normalCoupon.expires";
			$getSQL .= " from coupons,normalCoupon WHERE coupons.couponID=$which ";
			$getSQL .= "AND normalCoupon.couponID=$which AND coupons.expired=FALSE LIMIT 1;";
			
			//	EXECUTE, FORMAT, AND RETURN
				$results = $dbh->query($getSQL);
				if($results->rowCount()>0)
				{
					$myCoupon = $results->fetch();
					//	BUILD HTML
						echo "<h2>".$myCoupon['title']."</h2>";
						echo "<p>Coupon ID:\t\t".$myCoupon['couponID']."</p>";
						echo "<p>Coupon Type:\t\tNormal</p>";
						echo "<p>Coupon Postal:\t\t".$myCoupon['postal']."</p>";
						echo "<p>Coupon Created:\t\t".date("l, F jS, Y",strtotime($myCoupon['created']))."</p>";
						echo "<p>Coupon Expires:\t\t".date("l, F jS, Y",strtotime($myCoupon['expires']))."</p>";
						echo "<p><img src='http://".SRVHOST."/uploads/".$myCoupon['imgpath']."' style='width:75%'alt='img'></p>";
						echo "<p>Coupon Description: ".$myCoupon['description']."</p>";
						echo "<p>Coupon Discount: ".$myCoupon['discount']."</p>";
						echo "<p>Coupon Conditions: ".$myCoupon['condreq']."</p>";
						echo "<br><br><br>";
				}else
				{
					echo "Crumps! We had a problem!";
				} 
			
		break;
		case "2":		//	coupons JOIN with groupCoupon TABLE
			
			$getSQL 	= "select coupons.couponID,";
			$getSQL .= "coupons.title,";
			$getSQL .= "coupons.description,";
			$getSQL .= "coupons.postal,";
			$getSQL .= "coupons.imgpath,";
			$getSQL .= "coupons.created,";
			$getSQL .= "groupCoupon.startDiscount,";
			$getSQL .= "groupCoupon.maxDiscount,";
			$getSQL .= "groupCoupon.groupSize,";
			$getSQL .= "groupCoupon.condreq,";
			$getSQL .= "groupCoupon.expires ";
			$getSQL .= "from coupons,groupCoupon WHERE coupons.couponID=$which AND";
			$getSQL .= " groupCoupon.couponID=$which AND coupons.expired=FALSE LIMIT 1;";
			
			//	EXECUTE, FORMAT, AND RETURN
				$results = $dbh->query($getSQL);
				if($results->rowCount()>0)
				{
					$myCoupon = $results->fetch();
					//	BUILD HTML
						echo "<h2>".$myCoupon['title']."</h2>";
						echo "<p>Coupon ID:\t\t".$myCoupon['couponID']."</p>";
						echo "<p>Coupon Type:\t\tNormal</p>";
						echo "<p>Coupon Postal:\t\t".$myCoupon['postal']."</p>";
						echo "<p>Coupon Created:\t\t".date("l, F jS, Y",strtotime($myCoupon['created']))."</p>";
						echo "<p>Coupon Expires:\t\t".date("l, F jS, Y",strtotime($myCoupon['expires']))."</p>";
						echo "<p><img src='http://".SRVHOST."/uploads/".$myCoupon['imgpath']."' style='width:75%'alt='img'></p>";
						echo "<p>Coupon Description: ".$myCoupon['description']."</p>";
						echo "<p>Start Discount: ".$myCoupon['startDiscount']."</p>";
						echo "<p>Max Discount: ".$myCoupon['maxDiscount']."</p>";
						echo "<p>Members Needed: ".$myCoupon['groupSize']."</p>";
						echo "<p>Coupon Conditions: ".$myCoupon['condreq']."</p>";
						echo "<br><br><br>";
				}else
				{
					echo "Crumps! We had a problem!";
				} 
		break;
		case "3":		//	coupons JOIN with bidCoupon TABLE
			$getSQL 	= "select coupons.couponID,";
			$getSQL .= "coupons.title,";
			$getSQL .= "coupons.description,";
			$getSQL .= "coupons.postal,";
			$getSQL .= "coupons.imgpath,";
			$getSQL .= "coupons.created,";
			$getSQL .= "bidCoupons.startingBid,";
			$getSQL .= "bidCoupons.buyOut,";
			$getSQL .= "bidCoupons.startDate,";
			$getSQL .= "bidCoupons.endDate";
			$getSQL .= " from coupons,bidCoupons WHERE coupons.couponID=$which AND bidCoupons.couponID=$which ";
			$getSQL .= " AND coupons.expired=FALSE LIMIT 1;";
			
			//	EXECUTE, FORMAT, AND RETURN
				$results = $dbh->query($getSQL);
				if($results->rowCount()>0)
				{
					$myCoupon = $results->fetch();
					//	BUILD HTML
					echo "<h2>".$myCoupon['title']."</h2>";
					echo "<p>Coupon ID:\t\t".$myCoupon['couponID']."</p>";
					echo "<p>Coupon Type:\t\tNormal</p>";
					echo "<p>Coupon Postal:\t\t".$myCoupon['postal']."</p>";
					echo "<p>Coupon Created:\t\t".date("l, F jS, Y",strtotime($myCoupon['created']))."</p>";
					echo "<p>Coupon Expires:\t\t".date("l, F jS, Y",strtotime($myCoupon['expires']))."</p>";
					echo "<p><img src='http://".SRVHOST."/uploads/".$myCoupon['imgpath']."' style='width:75%'alt='img'></p>";
					echo "<p>Coupon Description: ".$myCoupon['description']."</p>";
					echo "<p>Starting Bid: ".$myCoupon['startingBid']."</p>";
					echo "<p>Buy out: ".$myCoupon['buyOut']."</p>";
					echo "<p>Start Date: ".date("l, F jS, Y",strtotime($myCoupon['startDate']))."</p>";
					echo "<p>End Date: ".date("l, F jS, Y",strtotime($myCoupon['endDate']))."</p>";
					echo "<br><br><br>";
					
				}else
				{
					echo "Crumps! We had a problem!";
				}
				
		break;
		
	}



?>

