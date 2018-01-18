<?php
//	echo "bus name ". $business;
//	get business profile detail based on URL tag
// 	CHECKING FOR A BUSINESS ID HERE
//	COMING HERE WE'RE EXPECTING AN ANONYMOUS SURVEY FROM A CONSUMER MOBILE APP
//	LOOKING FOR JSON STRING

// 
	if(!isset($_REQUEST['JSON']))	// IE NO REQUEST STRING, JUST A RANDOM CONNECTION HERE
	{
		//	redirect to cannot find that business
			header("location:NoLuck");	
	}else{
		
		//	now check against parsed JSON string to see if business is already registered
		//	EITHER WAY WE'LL SHOW A FORM HERE
		
		//	OK - HANDLE THE QUERY HERE, THEN SET SESSIONS AND PASS TO FORM PAGE TO OFFICIATE THIS THING
		/*
		
			?JSON={
  				"BIZ": "BIZ NAME",
  				"CITY": "CITY NAME",
  				"STREET": "STREET NO AND NAME",
  				"STATE" : "STATE - 2 LETTERS",
  				"ID" : "LONG IF FROM GOOGLE"
			}
		*/	
			//	RESET SESSIONS HERE
				// Unset all of the session variables.

			
			// END RESET SESSIONS	
			$jLocal 	= urldecode($_REQUEST['JSON']);
			
			//echo $jLocal;
			
			$revisedLocal =  stripslashes($jLocal);
			
			$jLocDec 	= json_decode($revisedLocal,true);
			
			//var_dump($jLocDec); 	
			
			//	echo "<br><br>".$jLocDec["BIZ"];
			
			/*	TEST URL
				http://commentbox.es/vibe/?JSON={"BIZ":"STEEL CANYON GOLF CLUB","CITY":"SANDY SPRINGS","STREET":"460 MORGAN FALLS ROAD","STATE":"GA","PLACEID":"ChIJR74kJ2gM9YgRJwPVocVpNM4","SCOPE":"GOOGLE"}
			
			*/
			
			$_SESSION['BIZ']=$jLocDec["BIZ"];
			$_SESSION['CITY']=$jLocDec["CITY"];
			$_SESSION['STREET']=$jLocDec["STREET"];
			$_SESSION['STATE']=$jLocDec["STATE"];
			$_SESSION['PLACEID']=$jLocDec["PLACEID"];
			
			//var_dump($jLocDec);
			header("location:../for/anon");
	}
	

?>
