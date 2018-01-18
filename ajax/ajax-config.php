<?php
define('RELPATH',dirname($_SERVER['PHP_SELF'])."/");
if(!defined('SRVHOST'))
{	define('SRVHOST',$_SERVER['HTTP_HOST']); }


switch(SRVHOST)
{	
	//	THIS IS THE LOCAL ONE
		case "whatsthebuzz":
			//define('DBHOSTAJX','mysql:host=localhost;dbname=greatgr2_buzz');
            define('DBHOSTAJX','mysql:host=localhost;dbname=greatgr2_buzz');
			define('DBUN','root');
			define('DBPW','');
		break;
	
	//	THIS IS THE LIVE ONE
		case "whatsthe.buzz":
			define('DBHOSTAJX','mysql:host=localhost;dbname=greatgr2_buzz');
			define('DBUN','greatgr2_buzz');
			define('DBPW','Buzzy211!');
		break;
	
}   
?>