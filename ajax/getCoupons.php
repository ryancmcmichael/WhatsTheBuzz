<?php
session_start();
require_once("../constants.php");
require_once('ajax-config.php');
$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
$user = $_SESSION['userid'];
$getSQL = "SELECT * from coupons WHERE `expired`='FALSE' AND userid=".$user." ORDER BY couponType ASC";

$results = $dbh->query($getSQL);

if($results!=false && $results->rowCount()>0) 
{
	//	SETUP LIST OF COUPONS
	//	REFERENCE HTML FOR STRUCTURE
		
		$couponString		.=	"<div id='bidList' class='coupon-list'>";
		$myCoupons = $results->fetchAll(PDO::FETCH_ASSOC);
		$centinal = "0";
		$couponString 	=	"<h2>My Coupons</h2>";
		foreach($myCoupons as $coupon)
		{
			if($coupon['couponType']!=$centinal)
			{
				//	WE ADD A NEW HEADER AND CONTINUE
					switch($coupon['couponType'])
					{
						case	 "1":
							$couponString .=	"<h4>Normal Coupons</h4>";
						break;
						case "2":
							$couponString .=	"<h4>Group Coupons</h4>";
						break;
						case "3":
							$couponString .=	"<h4>Bid Coupons</h4>";
						break;
					}	//	END SWITCH
				//	UPDATE CENTINEAL
					$centinal = $coupon['couponType'];
				
				//	CREATE MENU STRING FOR THIS RECORD AS WELL
					$couponString.= "<a href='javascript:showCouponDetail(";
					$couponString.= $coupon['couponID'].",".$coupon['couponType'].")'>";
					$couponString.= $coupon['title']."</a><br>";
			
			}else{
				//	WE JUST ADD A MENU STRING 
					$couponString.= "<a href='javascript:showCouponDetail(";
					$couponString.= $coupon['couponID'].",".$coupon['couponType'].")'>";
					$couponString.= $coupon['title']."</a><br>";
				}	//	END IF/ELSE
				
		}	//	END FOREACH
		echo $couponString;
}	
else
{
	echo "<h2>My Coupons</h2><br><em>No coupons yet</em>";
}

?>

