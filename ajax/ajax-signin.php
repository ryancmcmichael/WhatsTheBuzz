<?php

session_start();
//	FILES WITH COMMON CORE
	require_once("../constants.php");
	require_once('ajax-config.php');

 
//	GET VARS
	$pw = $_REQUEST['pw'];
	$uname = $_REQUEST['email'];
	//echo $pw . " and " . $uname;
	
	
// 	CHECK IF IN DB AND IN GOOD STANDING
	try 
		{
			$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
			$theQuery = "SELECT * from wtbmembers WHERE email='$uname' AND pword='$pw'";
			$subURL = $dbh->query($theQuery);
			$isThere = $subURL->rowCount();
			$recs = $subURL->fetch();	//versus fetchall
			if($isThere>0)
			{
				//	SWITCH 'STATUS'
				 
				//	SET SESSION VARIABLE FOR USER ID
					$_SESSION['userid']=$recs["userid"];
					$_SESSION['fname']= $recs["fname"];
					$_SESSION['lname']= $recs["lname"];
				//	WE'LL CALL THE FULL URL LIST FROM THE ADMIN PAGE
					$_SESSION['URL'] = $recs["busURL"];
					$_SESSION['uniqueID'] = $recs["SurveyCode"];
					$_SESSION['QRPath'] = $recs["QRPath"];
					$_SESSION['BIZNAME'] = $recs["busname"];
					$_SESSION['USERTYPE'] = $recs["usertype"];
					$_SESSION['SurveyName'] = $recs["activesurvey"];
					echo "TRUE";
			}
			else
			{	//	SQL WORKED BUT NO USER MET CRITERIA
					echo "FALSE";
				
			}
		} //end try
	catch(PDOException $e)
	{
		print $theQuery;
		//print "DB_ERROR";
		die();
	}
	
?>