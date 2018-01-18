<?php
//	SALT HERE
//	define("SALT","$2a$07$AllofOldNothingElseEverEverTriedEverFailed$");
//	processing signup stage 1.
	require_once("../constants.php");
	require_once('ajax-config.php');
	session_start();
	
//	GET VALUES AND ENCRYPT OUR PASSWORD
	
	$forWhom	=	$_REQUEST['id'];
	$pw 		= 	crypt($_REQUEST['pwA'],SALT);	
		
	$update	=	submitChange($forWhom,$pw);
	
	echo $update;
		
//	UPDATE THE DATABASE	
	function submitChange($forWhom,$pw)
	{
		try 
			{
				$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
				//	STILL USING TEMP ID HERE TID
				$subChg = $dbh->query("UPDATE wtbmembers set pword='$pw' WHERE userid=$forWhom;");
				if($subChg)
				{ 
					return "TRUE"; 
				}else{
					 return "FALSE";}
			} //end try
		catch(PDOException $e)
		{
			print "DB_ERROR";
			die();
		}
	}
?>