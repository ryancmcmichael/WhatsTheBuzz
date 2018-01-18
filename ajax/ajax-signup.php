<?php
//	SALT HERE
//	define("SALT","$2a$07$AllofOldNothingElseEverEverTriedEverFailed$");
//	processing signup stage 1.
	require_once("../constants.php");
	require_once('ajax-config.php');
	session_start();
	$getType = $_REQUEST['type'];
	
	switch($getType)
	{
		case "SIGNUP":
			//	LOAD VARS	
				$e 		= 	$_REQUEST['email'];
				$biz		=	$_REQUEST['biz'];
				$pw 		= 	crypt($_REQUEST['pw1'],SALT);
				$fn		=	$_REQUEST['fname'];
				$ln		=	$_REQUEST['lname'];
				$gpid	=	$_REQUEST['googleID'];
					
			//	CALL THE FUNCTION	
				handleSignUp($fn,$ln,$pw,$e,$biz,$gpid);
		break;
		case "CHECK":
			//	TEST URL FOR UNIQUENESS
				$url 	=	$_REQUEST['URL'];
				checkURL($url);	
		break;
		case "SUBMIT":
			//	INSERT URL
				$url 	=	$_REQUEST['URL'];
				submitURL($url);	

		break;	
		case "PMTOPTION":
				$pmt = $_REQUEST['OPT'];
				echo "TRUE";
				
		break;
		
	}
//	CHECK / LOAD URL FOR THIS USER	
	function submitURL($url)
	{
		try 
			{
				$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
				//	STILL USING TEMP ID HERE TID
				$subURL = $dbh->query("UPDATE wtbmembers set busURL='$url' WHERE userid=".$_SESSION['TID']);
				if($subURL)
				{ 
					$_SESSION['URL'] = $url;
					echo "TRUE"; 
				}else{ echo "FALSE";}
			} //end try
		catch(PDOException $e)
		{
			print "DB_ERROR";
			die();
		}
	}
//	CHECK URL FOR UNIQUENESS HERE
	function checkURL($url)
	{
		try 
			{
				$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
				$checkURL = $dbh->query("SELECT * FROM wtbmembers WHERE busURL='$url' ");
				$isThere = $checkURL->rowCount();
				if($isThere>0)
			{
					echo "FALSE";
					$_SESSION['bizID']=$url;
			}
			else
			{	
				echo "TRUE";		
			}
		} //end try
		catch(PDOException $e)
		{
			print "DB_ERROR";
			die();
		}
	}

//	PUT USER INTO SYSTEM HERE
	function handleSignUp($fn,$ln,$pw,$e,$b,$g)
	{
	//	TEST FOR EMAIL ACCOUNT			
		try 
		{
			//$dbh = new PDO('mysql:host=localhost;dbname=survey', 'root', 'demo');
			$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
			$checkEmail = $dbh->query("SELECT * FROM wtbmembers WHERE email='$e'");
			$isThere = $checkEmail->rowCount();
			if($isThere>0)
			{
				//	WE HAVE THAT EMAIL ALREADY SO SEND A MESSAGE BACK
					echo "EMAIL_ERROR";	
			}
			else
			{
				//	OTHERWISE WE UPDATE THE DB WITH THE RECORD
					$joined 	= date("Y-m-d h:i:s");
					$updateSQL = "INSERT INTO wtbmembers(joined,email,busname, pword,fname,lname,status,googleID) ";
					$updateSQL .= "VALUES('$joined','$e','$b','$pw','$fn','$ln','INPROGRESS','$g') ";
					$updateDB = $dbh->query($updateSQL);
					$NewUID = $dbh->lastInsertId();
					$_SESSION['TID'] = $NewUID;	//	TEMP UID WHILE WE FINISH SIGNUP
					$_SESSION['URL'] = $b;
					$_SESSION['fname'] = $fn;
					$_SESSION['lname'] = $ln; 
					$_SESSION['cool'] = $NewUID;
					$_SESSION['BIZNAME'] = $b;
					if($updateDB) 
					{
						$_SESSION['NAME'] = $fn . " " . $ln;
						$_SESSION['EMAIL'] = $e;
						$_SESSION['JOINED'] = $joined;
						echo "TRUE";	
					}
					else
					{
						echo "FALSE";
					}
					
			}
		}
		catch (PDOException $e)
		{
			print "DB_ERROR";
			die();
		}
}
?>