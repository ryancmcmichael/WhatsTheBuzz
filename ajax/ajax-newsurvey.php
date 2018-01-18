<?php

require_once("../constants.php");
require_once('ajax-config.php');
session_start();

//	LOAD VARS
$Q1		=	$_REQUEST['Q1'];
$Q2		=	$_REQUEST['Q2'];
$Q3		=	$_REQUEST['Q3'];
$Q4		=	$_REQUEST['Q4'];
$T1		=	$_REQUEST['T1'];
$T2		=	$_REQUEST['T2'];
$T3		=	$_REQUEST['T3'];
$T4		=	$_REQUEST['T4'];
$surveyName = $_REQUEST['surveyName'];

//	CALL THE FUNCTION
newSurvey($Q1, $Q2, $Q3, $Q4, $T1, $T2, $T3, $T4, $surveyName);

function newSurvey($Q1, $Q2, $Q3, $Q4, $T1, $T2, $T3, $T4, $surveyName)
{

    //	TEST FOR EMAIL ACCOUNT
    try
    {
        //$dbh = new PDO('mysql:host=localhost;dbname=survey', 'root', 'demo');
        $dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
        $checkSurvey = $dbh->query("SELECT * FROM surveys WHERE busname='".$_SESSION['BIZNAME']."' AND surveyname='$surveyName'");
        $isThere = $checkSurvey->rowCount();
        if($isThere>0)
        {
        	$updateSQL = "UPDATE surveys SET Q1='$Q1',Q2='$Q2',Q3='$Q3',Q4='$Q4',T1='$T1',T2='$T2',T3='$T3',T4='$T4' WHERE busname='".$_SESSION['BIZNAME']."' AND surveyname='$surveyName'";
        	$updateDB = $dbh->query($updateSQL);
        }
        else
        {    //	OTHERWISE WE UPDATE THE DB WITH THE RECORD
            $updateSQL = "INSERT INTO surveys(busname,surveyname,Q1,Q2,Q3,Q4,T1,T2,T3,T4) ";
            $updateSQL .= "VALUES('".$_SESSION['BIZNAME']."','$surveyName','$Q1','$Q2','$Q3','$Q4','$T1','$T2','$T3','$T4')";
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
        $updateUser = $dbh->prepare("UPDATE wtbmembers SET activesurvey='".$surveyName."' WHERE busname='".$_SESSION['BIZNAME']."'");
        $updateUser = $updateUser->execute();
    }
    catch (PDOException $e)
    {
        print "DB_ERROR";
        die();
    }
}

?>