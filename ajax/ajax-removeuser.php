<?php

require_once("../constants.php");
require_once('ajax-config.php');
session_start();

//	LOAD VARS
$userid = 	$_REQUEST['userid'];

//	CALL THE FUNCTION
remove($userid);

function remove($userid)
{
    //	TEST FOR EMAIL ACCOUNT
    try
    {
        //$dbh = new PDO('mysql:host=localhost;dbname=survey', 'root', 'demo');
        $dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
        $updateSQL = "DELETE FROM wtbmembers WHERE userid=".$userid;
        $updateSQL = $dbh->prepare($updateSQL);
        $updateDB = $updateSQL->execute();
        
        if($updateDB)
        {
        	echo "TRUE";
        }
        else
        {
        	echo "FALSE";
        }
    }
    catch (PDOException $e)
    {
        print "DB_ERROR";
        die();
    }
}

?>