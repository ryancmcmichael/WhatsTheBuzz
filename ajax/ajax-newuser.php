<?php
//	SALT HERE

//	processing signup stage 1.
require_once("../constants.php");
require_once('ajax-config.php');
session_start();

//	LOAD VARS
$e 		= 	$_REQUEST['email'];
$pw		= 	$_REQUEST['pword'];
$fn		=	$_REQUEST['fname'];
$ln		=	$_REQUEST['lname'];

//	CALL THE FUNCTION
handleSignUp($fn,$ln,$pw,$e);

function handleSignUp($fn,$ln,$pw,$e)
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
            $updateSQL = "INSERT INTO wtbmembers(usertype,joined,email,busname, pword,fname,lname,status,googleID) ";
            $updateSQL .= "VALUES('sub','$joined','$e','".$_SESSION['BIZNAME']."','$pw','$fn','$ln','INPROGRESS','') ";
            $updateSQL = $dbh->prepare($updateSQL);
            $updateDB = $updateSQL->execute();
            
            $checkSurvey = $dbh->query("SELECT * FROM surveys WHERE busname='".$_SESSION['BIZNAME']."' AND surveyname='survey1'");
            $isThere = $checkSurvey->rowCount();
            if(!$isThere>0)
            {
	            $defaultSurvey = "INSERT INTO surveys(busname, surveyname, Q1, Q2, Q3, Q4, T1, T2, T3, T4) ";
	            $defaultSurvey .= "VALUES('".$_SESSION['BIZNAME']."', '".$_SESSION['SurveyName']."', 'Overall Quality', 'Overall Service', 'Overall Value', 'Overall Cleanliness',";
	            $defaultSurvey .= "'Quality', 'Service', 'Value', 'Cleanliness')";
	            $defaultSurvey = $dbh->prepare($defaultSurvey);
	            $createSurvey = $defaultSurvey->execute();
            }

            if($updateDB)
            {
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