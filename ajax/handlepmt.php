<?php
require_once('ajax-config.php');
session_start();
//	NEED THIS TO MANAGE PAYMENTS
	require_once('../braintree/braintree.php');
	Braintree_Configuration::environment('sandbox');
	Braintree_Configuration::merchantId('9kpp26tyfgcsgzny');
	Braintree_Configuration::publicKey('ss4w86479yp36ymh');
	Braintree_Configuration::privateKey('12a9b615116a760dd051d692a94624a4');

//	GRAB PLAN NAME FROM FORM POST
	$plan = "";
	$plan = $_POST['plan'];
	
	
	
	/*
	switch($plan)
	{	
		SET LABEL HERE FOR PLAN TO SHOW ON SUMMARY PAGE
	}
	*/

//	HARDCODED TEST
/*  CODE TO SET UP CUSTOMER SUBMISSION
	$result = Braintree_Customer::create(array(
    "firstName" => "JOHN",
    "lastName" => "PHILLIPS",
    "creditCard" => array(
       "number" => "4111111111111111",
       "expirationMonth" => "11",
		"cardholderName"=> "JOHN PHILLIPS",
       "expirationYear" => "2015",
       "cvv" => "111",
       "billingAddress" => array(
            "postalCode" => "30101"
        ),"options" => array(
        "verifyCard" => true
    	)
    )
	*/
//	CODE TO SET UP CUSTOMER SUBMISSION
	$result = Braintree_Customer::create(array(
    "firstName" => $_POST["first_name"],
    "lastName" => $_POST["last_name"],
    "creditCard" => array(
       "number" => $_POST["number"],
       "expirationMonth" => $_POST["month"],
		"cardholderName"=> $_POST["nameOnCard"],
       "expirationYear" => $_POST["year"],
       "cvv" => $_POST["cvv"],
       "billingAddress" => array(
            "postalCode" => $_POST["postal_code"]
        ),"options" => array(
        "verifyCard" => true
    	)
    )
    
));

if ($result->success) {
   	
	try 
		{
			//	WE'VE SET UP OUR CUSTOMER ACCOUNT, NOW WE NEED SUBSCRIPTION SETUP
				
			//	$subscribe = enrollSubscription($result->customer->id,$plan);
				
				
				
				switch("YES")	//	WAS SWITCH($subscribe), hardcoded to bypass payment GATEWAY
				{
					case "NOCUSTOMER":		//	WE SEND BACK ERROR MESSAGE	
					case "ERROR":			//	WE SEND BACK ERROR MESSAGE
					//	echo $subscribe;
					break;
					default:	
					//	WE GOT A POSITIVE ID BACK FOR THE SUBSCRIPTION SO WE PASS ID INTO QUERY BELOW
					//	$dbh = new PDO('mysql:host=localhost;dbname=survey', 'root', 'demo');
						
					//	ID FOR CONSUMERS TO ENTER ON LANDING PAGE TO GET TO THIS ID	
						$prefixVal = substr($_SESSION['URL'],0,3);
					//	TRUE increases entropy to ensure more randomness
						$uniqueID = strtoupper(uniqid($prefixVal,FALSE));
					
					//	HANDLE THE URL / IMAGE BUILD HERE
						define('RELPATH',dirname($_SERVER['PHP_SELF']));
						define('SRVHOST',$_SERVER['HTTP_HOST']);

					//	DEFINE URL PATH FOR TESTING
						switch(SRVHOST)
						{
							case "whatsthebuzz":
								$myURLroot = "http://whatsthebuzz";
								$myHTTP = "http://";
							break;
							case "whatsthe.buzz":
								$myURLroot = "https://whatsthe.buzz";
								$myHTTP = "https://";
							break;	
						}
					//	BUILD UNIQUE URL STRING FOR SURVEY
						$urlBUILD = $myURLroot."/for/" . $_SESSION['URL']; //	<-- that is unique
						$_SESSION['uniqueID'] = $uniqueID;
						
					//	INCLUDE QR ENGINE
						require_once("../qr/qrlib.php"); 
						$newQrImage = handleQR($_SESSION['URL'],$urlBUILD);
						$_SESSION['QRPath'] = $newQrImage;
						
					//	UPDATE THE SITES TABLE HERE
						$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
						$subQry = "UPDATE wtbmembers set ";
						$subQry.= "status='ACTIVE', ";
						$subQry.= "plan=$plan, ";
						$subQry.= "pmtcode='$subscribe', ";
						$subQry.= "SurveyCode='$uniqueID', ";
						$subQry.= "QRPath=\"$newQrImage\" ";
						$subQry.= "WHERE userid=". $_SESSION['TID'];
					
					//	ECHO THIS FOR A SEC
					//	echo $subQry;	
							
					//	LOAD THAT STATEMENT	
						$subURL = $dbh->query($subQry);
						if($subURL)
						{ 
							
							//	WE NOW MOVE FROM TEMP ID TO USER ID TO MOVE TO ADMIN
								$_SESSION['userid'] = $_SESSION['TID'];
							
							//	SEND BACK CONFIRMATION
								echo "TRUE"; 		
							
						}else{
							echo DBHOSTAJX . " " . $subQry;		// DB UPDATE ERROR
						}
					break;
				}
		} //end try
	catch(PDOException $e)
	{
		echo "DB_ERROR";
		die();
	}
	//	RETURNING BACK FROM AJAX CALL
		//	echo("Success! Customer ID: " . $result->customer->id);
   		//	


} else {
    echo $plan;
	
	/*
	foreach($result->errors->deepAll() AS $error) {
 		print_r($error->code . ": " . $error->message . "\n");
	}
	
	if(isset($result->transaction->processorResponseCode))
	{
		echo($result->transaction->processorResponseCode);	
	}
	if(isset($result->transaction->gatewayRejectionReason))
	{
		echo($result->transaction->gatewayRejectionReason);	
	}*/
	
	
}
function enrollSubscription($who,$plan)
{
	
	try {
    			
			$customer_id = $who;
    			$customer = Braintree_Customer::find($customer_id);
    			$payment_method_token = $customer->creditCards[0]->token;
    			
			$subresult = Braintree_Subscription::create(array(
        		'paymentMethodToken' => $payment_method_token,
        		'planId' => $plan,
			'options' => ['startImmediately' => true]	
    			));
			var_dump($subresult);
			exit;

    		if ($subresult->success) {
		//	echo("Success! Your subscription is " . $result->subscription->status);
		//	echo("Success! Subscription " . $result->subscription->id . " is " . $result->subscription->status);
		return $subresult->subscription->id;
    } else {
       return "ERROR"; 
		//	echo($result->transaction->status);
		//	echo("Woops! We had an error. Please try again later!");
        
			foreach (($result->errors->deepAll()) as $error)
			{
           		echo("- " . $error->message . "<br/>");
        		}
		
    }
	} catch (Braintree_Exception_NotFound $e) {
    		return("NOCUSTOMER");
	}
}


//	HANDLE IMAGE BUILD HERE
	function handleQR($imgpath, $urlpath){
	
	switch(SRVHOST)
	{
		case "whatsthebuzz":
		//	define('TEMPPATH','/Library/WebServer/wwwroot/greenolive/qrImage'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR);
define('TEMPPATH','/Library/WebServer/wwwroot/buzz/qrImages'.DIRECTORY_SEPARATOR);		
		break;
		case "whatsthe.buzz":
		//	NEED TO SEE WHAT THIS ENDS UP BEING - ycloser1 won't be the user name for this site
		define('TEMPPATH','/home/greatgr2/public_html/qrImages'.DIRECTORY_SEPARATOR);
		break;
	
	}   
    	//	set it to writable location, a place for temp generated PNG files
    		$PNG_TEMP_DIR = TEMPPATH;
    
    	// 	html PNG location prefix
    		$PNG_WEB_DIR = 'qrImages/';      
    
    	//	of course we need rights to create temp dir
    		if (!file_exists($PNG_TEMP_DIR))
        	mkdir($PNG_TEMP_DIR);
	//	echo $PNG_TEMP_DIR
    		$filename = "";
    		$filename = $myHTTP .SRVHOST."/qrImages/".$imgpath.'.png';
    
    	//	processing form input
    	//	remember to sanitize user input in real-life solution !!!
    		$errorCorrectionLevel = 'H';
    
    		/*if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        	$errorCorrectionLevel = $_REQUEST['level'];   */ 

    		$matrixPointSize = 7;
    
	    /*
	    if (isset($_REQUEST['size']))
		   $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);
		*/

    		if (isset($urlpath)) { 
    
        		//	it's very important!
        			if (trim($urlpath) == '')
           		echo "Error"; 
		  
		  	//	die('data cannot be empty! <a href="?">back</a>');
            
	// 	user data
	   	$buildpath = $PNG_TEMP_DIR;
		$addImage =  $imgpath."_".md5($urlpath.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        	$filename = $buildpath.$addImage;
	   	QRcode::png($urlpath, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    } 
        
    	//	display generated file
    	//	echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';
		return $myHTTP . SRVHOST ."/qrImages/$addImage";
	}

?>