<?php

session_start();
//	FILES WITH COMMON CORE
	require_once("../constants.php");
	require_once('ajax-config.php');

//	GET VARS
	$pw = crypt($_REQUEST['pw'],SALT);
	$uname = $_REQUEST['email'];
	
// 	CHECK IF IN DB AND IN GOOD STANDING
	try 
		{
			$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
			$theQuery = "SELECT * from ohm WHERE login='$uname' AND password='$pw'";
			$subURL = $dbh->query($theQuery);
			$isThere = $subURL->rowCount();
			$recs = $subURL->fetch();	//versus fetchall
			if($isThere>0)
			{
				//	SWITCH 'STATUS'
				 
				//	SET SESSION VARIABLE FOR USER ID
					$_SESSION["OHM"]=$recs["ohmid"];
					echo "TRUE";
			}
			else
			{	//	SQL WORKED BUT NO USER MET CRITERIA
					echo "FALSE";
				
			}
		} //end try
	catch(PDOException $e)
	{
		echo $theQuery;
		//print "DB_ERROR";
		die();
	}
	
?>