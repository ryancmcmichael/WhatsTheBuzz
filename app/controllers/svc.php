<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('RELPATH',dirname($_SERVER['PHP_SELF'])."/");
define('SRVHOST',$_SERVER['HTTP_HOST']);
switch(SRVHOST)
{	
	//	THIS IS THE LOCAL ONE
		case "whatsthebuzz":
			define('DBHOSTAJX','mysql:host=localhost;dbname=greatgr2_buzz');
			define('DBUN','buzz');
			define('DBPW','demo');
		break;
	
	//	THIS IS THE LIVE ONE
		case "whatsthe.buzz":
			define('DBHOSTAJX','mysql:host=localhost;dbname=greatgr2_buzz');
			define('DBUN','greatgr2_buzz');
			define('DBPW','Buzzy211!');
		break;
	
}   
class svc extends CI_Controller {

	/*	METHODS:
		putMember/$1";				//	make a member (by email) // returns ID
		getMember/$1";				//	check if member is there (by email)
		getAll/$1";					//	GET FULL LIST OF COUPONS $1=params json
		getThisCoupon/$1/$2";			//	USER ID, WHO / WHICH
		shareThisCoupon/$1/$2";		//	WHO/ JSON of emails
		bidOnThisCoupon/$1/$2/$3"	
	*/
	public function putMember($who)
	{
		echo $who . " " . SRVHOST;
	}
	public function getMember($who)
	{
		echo $who;	
	}
	
	//	HANDLE GETTING COUPONS HERE
		public function getAll($JSONparams = NULL)
		{
			getCoupons($JSONparams);
		}
		
		public function getThese($JSONparams = NULL)
		{
			getSavedCoupons($JSONparams);	
		}
		public function getThis($JSONparams = NULL)
		{
			getThisCoupon($JSONparams);
		}
		
	//	END CORE COUPONS CALLS
	
	public function getThisCoupon($user,$coupon)
	{
		echo "GetThisCoupon";	//	SAVING THIS COUPON	
	}
	public function shareThisCoupon($user,$params)
	{
		//	$params	= email list as JSON
			echo "Share";
	}
	public function bidOnThisCoupon($user,$coupon,$amount)
	{
		// 	who is bidding, how much, and on what
			echo "BID";	
	}
	public function putCurrBid($couponID,$who,$amount)
	{
		$bidSQL = "INSERT INTO bids(couponID,whoBid,currValue) VALUES($couponID,$who,$amount)";
		$putBid = new PDO(DBHOSTAJX,DBUN,DBPW);
		$myBid = $putBid->query($bidSQL);
		if($myBid)
		{echo "TRUE";}else{echo "FALSE";};
	
	}
	public function getCurrBid($coupon)
	{
		$bidSQL = "SELECT MAX(currValue) FROM bids WHERE couponID=".$coupon;
		$getBid = new PDO(DBHOSTAJX,DBUN,DBPW);
		$myBid = $getBid->query($bidSQL);
		$myMax = $myBid->fetch(PDO::FETCH_ASSOC);
		if($myMax!=null){
		echo $myMax['MAX(currValue)'];
		}else{
			echo false;
			}
	}	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

function getCoupons($params)
{
	
	//	LETS SEE WHATS IN PARAMS
		
		if($params!=null)
		{
			$paramArray=explode("-",$params);
			//	echo $paramArray[1];
		}		
	//	END TEST
			
	
	$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
	$getSQL = "SELECT * from coupons WHERE `expired`='FALSE' "; 
	if($params!=null)
	{
		//	WE HAVE TO ADD WHERE FILTERS
			$sz = count($paramArray);
			$myfilters="";
			$filters = "(";
			for($i=1;$i<$sz;$i++)
			{
				$filters.=$paramArray[$i].",";
			}
			$myfilters = rtrim($filters, ",");
			$myfilters.=")";
			$getSQL .= " AND couponCat in ".$myfilters." ";	
	}
	$getSQL .= "ORDER BY couponType ASC";
	//	echo $getSQL;
	$results = $dbh->query($getSQL);
	if($results->rowCount()>0) 
	{
	
		$isXML = false;		//	SET FALSE FOR A JSON FEED
		$myCoupons = $results->fetchAll(PDO::FETCH_ASSOC);
		
		if($isXML)
		{
			$couponString = "<coupons>";
			$couponString 	=	"";
			foreach($myCoupons as $coupon)
			{
					
				$couponString.="<coupon>";
				$couponString.="<couponID>".$coupon['couponID']."</couponID>";
				$couponString.="<couponType>".$coupon['couponType']."</couponType>";
				$couponString.="<couponCat>".$coupon['couponCat']."</couponCat>";
				$couponString.="<couponTitle>".$coupon['title']."</couponTitle>";
				$couponString.="<couponDesc>".$coupon['description']."</couponDesc>";
				$couponString.="<couponExpires>NA</couponExpires>";
				$couponString.="<couponImage>".$coupon['imgpath']."</couponImage>";
				$couponString.="</coupon>";
			
			}	//	END FOREACH
			$couponString.="</coupons>";
		}
		else	//	WE BUILD JSON
		{
			$couponString = "[";
			foreach($myCoupons as $coupon)
			{
				
				$couponString.="{";
				$couponString.="\"couponID\":".$coupon['couponID'].",";
				$couponString.="\"bizName\":\"".$coupon['bizName']."\",";
				$couponString.="\"couponType\":".$coupon['couponType'].",";
				
				// BREAK INTO INNER QUERY FOR COUPON TYPE DETAIL
				$getDetail = new PDO(DBHOSTAJX,DBUN,DBPW); 
				switch($coupon['couponType'])
				{
					case 1:
						$normalSQL = "SELECT * FROM normalCoupon WHERE couponID=".$coupon['couponID'];
						$normResults = $getDetail->query($normalSQL);
						if($normResults->rowCount()>0) 
						{
							$myNormal = $normResults->fetch(PDO::FETCH_ASSOC);
							$couponString.="\"discount\":".$myNormal['discount'].",";
							$couponString.="\"condreq\":\"".$myNormal['condreq']."\",";
							$couponString.="\"expires\":\"".$myNormal['expires']."\",";
						}
					break;
					case 2:
						$groupSQL = "SELECT * FROM groupCoupon WHERE couponID=".$coupon['couponID'];
						$groupResults = $getDetail->query($groupSQL);
						if($groupResults->rowCount()>0) 
						{
							$myGroup = $groupResults->fetch(PDO::FETCH_ASSOC);
							$couponString.="\"startDiscount\":".$myGroup['startDiscount'].",";
							$couponString.="\"maxDiscount\":".$myGroup['maxDiscount'].",";
							$couponString.="\"groupSize\":".$myGroup['groupSize'].",";
							$couponString.="\"condreq\":\"".$myGroup['condreq']."\",";
							$couponString.="\"expires\":\"".$myGroup['expires']."\",";
						}
					break;
					case 3:
						$bidSQL = "SELECT * FROM bidCoupons WHERE couponID=".$coupon['couponID'];
						$bidResults = $getDetail->query($bidSQL);
						if($bidResults->rowCount()>0) 
						{
							$myBid = $bidResults->fetch(PDO::FETCH_ASSOC);
							$couponString.="\"startingBid\":".$myBid['startingBid'].",";
							$couponString.="\"buyOut\":".$myBid['buyOut'].",";
							$couponString.="\"startDate\":\"".$myBid['startDate']."\",";
							$couponString.="\"endDate\":\"".$myBid['endDate']."\",";
						}
				
					break;
					
				}				
				$couponString.="\"couponCat\":".$coupon['couponCat'].",";
				$couponString.="\"couponTitle\":\"".$coupon['title']."\",";
				$couponString.="\"couponDesc\":\"".$coupon['description']."\",";
				$couponString.="\"couponImage\":\"".$coupon['imgpath']."\"";
				$couponString.="},";
			
			}	//	END FOREACH
			$tempString = rtrim($couponString,",");
			$couponString=$tempString."]";		
				
		}
		//xecho $couponString;
		
		echo $couponString;
}	
else
{
	echo "<coupon>No coupons yet</coupon>";
}
}

function getSavedCoupons($params)
{
	
	//	echo "called";
	//	LETS SEE WHATS IN PARAMS
		
		if($params!=null)
		{
			$paramArray=explode("-",$params);
		}		
		$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
		$getSQL = "SELECT * from coupons WHERE `expired`='FALSE' "; 
		
		if($params!=null)
		{
		//	WE HAVE TO ADD WHERE FILTERS
			$sz = count($paramArray);
			$myfilters="";
			$filters = "(";
			for($i=1;$i<$sz;$i++)
			{
				$filters.=$paramArray[$i].",";
			}
			$myfilters = rtrim($filters, ",");
			$myfilters.=")";
			$getSQL .= " AND couponID in ".$myfilters." ";	
	}
	$getSQL .= "ORDER BY couponType ASC";
	
	$results = $dbh->query($getSQL);
	if($results->rowCount()>0) 
	{
	
		$isXML = false;		//	SET FALSE FOR A JSON FEED
		$myCoupons = $results->fetchAll(PDO::FETCH_ASSOC);
		
		if($isXML)
		{
			$couponString = "<coupons>";
			$couponString 	=	"";
			
			foreach($myCoupons as $coupon)
			{
					
				$couponString.="<coupon>";
				$couponString.="<couponID>".$coupon['couponID']."</couponID>";
				$couponString.="<couponType>".$coupon['couponType']."</couponType>";
				$couponString.="<couponCat>".$coupon['couponCat']."</couponCat>";
				$couponString.="<couponTitle>".$coupon['title']."</couponTitle>";
				$couponString.="<couponDesc>".$coupon['description']."</couponDesc>";
				$couponString.="<couponExpires>NA</couponExpires>";
				$couponString.="<couponImage>".$coupon['imgpath']."</couponImage>";
				$couponString.="</coupon>";
			
			}	//	END FOREACH
			$couponString.="</coupons>";
		}
		else	//	WE BUILD JSON
		{
			$couponString = "[";
			foreach($myCoupons as $coupon)
			{
				
				$couponString.="{";
				$couponString.="\"couponID\":".$coupon['couponID'].",";
				$couponString.="\"bizName\":\"".$coupon['bizName']."\",";
				$couponString.="\"couponType\":".$coupon['couponType'].",";
				
				// BREAK INTO INNER QUERY FOR COUPON TYPE DETAIL
				$getDetail = new PDO(DBHOSTAJX,DBUN,DBPW); 
				switch($coupon['couponType'])
				{
					case 1:
						$normalSQL = "SELECT * FROM normalCoupon WHERE couponID=".$coupon['couponID'];
						$normResults = $getDetail->query($normalSQL);
						if($normResults->rowCount()>0) 
						{
							$myNormal = $normResults->fetch(PDO::FETCH_ASSOC);
							$couponString.="\"discount\":".$myNormal['discount'].",";
							$couponString.="\"condreq\":\"".$myNormal['condreq']."\",";
							$couponString.="\"expires\":\"".$myNormal['expires']."\",";
						}
					break;
					case 2:
						$groupSQL = "SELECT * FROM groupCoupon WHERE couponID=".$coupon['couponID'];
						$groupResults = $getDetail->query($groupSQL);
						if($groupResults->rowCount()>0) 
						{
							$myGroup = $groupResults->fetch(PDO::FETCH_ASSOC);
							$couponString.="\"startDiscount\":".$myGroup['startDiscount'].",";
							$couponString.="\"maxDiscount\":".$myGroup['maxDiscount'].",";
							$couponString.="\"groupSize\":".$myGroup['groupSize'].",";
							$couponString.="\"condreq\":\"".$myGroup['condreq']."\",";
							$couponString.="\"expires\":\"".$myGroup['expires']."\",";
						}
					break;
					case 3:
						$bidSQL = "SELECT * FROM bidCoupons WHERE couponID=".$coupon['couponID'];
						$bidResults = $getDetail->query($bidSQL);
						if($bidResults->rowCount()>0) 
						{
							$myBid = $bidResults->fetch(PDO::FETCH_ASSOC);
							$couponString.="\"startingBid\":".$myBid['startingBid'].",";
							$couponString.="\"buyOut\":".$myBid['buyOut'].",";
							$couponString.="\"startDate\":\"".$myBid['startDate']."\",";
							$couponString.="\"endDate\":\"".$myBid['endDate']."\",";
						}
				
					break;
					
				}
				//	FINISH OUTER QUERY LOOP
				
				$couponString.="\"couponCat\":".$coupon['couponCat'].",";
				$couponString.="\"couponTitle\":\"".$coupon['title']."\",";
				$couponString.="\"couponDesc\":\"".$coupon['description']."\",";
				$couponString.="\"couponImage\":\"".$coupon['imgpath']."\"";
				$couponString.="},";
			
			}	//	END FOREACH
			$tempString = rtrim($couponString,",");
			$couponString=$tempString."]";		
				
		}
		//xecho $couponString;
		
		echo $couponString;
}	
else
{
	echo "<coupon>No coupons yet</coupon>";
}
}