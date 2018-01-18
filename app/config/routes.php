<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "welcome";
$route['home'] = "welcome";
$route['yourlink'] = "yourlink";
$route['for/NoLuck']="forWhom/NoChoice";
$route['for/anon']="forWhom/anon";
$route['for/(:any)'] = "forWhom/which/$1";
$route['for'] = "forWhom/NoChoice";
$route['vibe/NoLuck']="forWhom/NoChoice";
$route['vibe/']="forWhom/NoChoice";
$route['feedback/NoLuck'] = "feedback/NoChoice";
$route['feedback'] = "feedback/NoChoice";
$route['feedback/(:any)'] = "feedback/which/$1";

//	HANDLE REST REQUESTS

//	GET AND PUT MEMBERS BY EMAIL
$route['svc/putMember/(:any)']				= 	"svc/putMember/$1";		//	make a member (by email) // returns ID
$route['svc/getMember/(:any)']				=	"svc/getMember/$1";		//	check if member is there (by email)
$route['svc/getAllCoupons/(:any)'] 			= 	"svc/getAll/$1";			//	GET FULL LIST OF COUPONS $1=params json
$route['svc/getCurrBid/(:num)']				=	"svc/getCurrBid/$1";
$route['svc/putCurrBid/(:num)/(:num)/(:num)']		=	"svc/putCurrBid/$1/$2/$3";
$route['svc/getTheseCoupons/(:any)'] 			= 	"svc/getThese/$1";
$route['svc/getThisCoupons/(:any)'] 			= 	"svc/getThis/$1";
$route['svc/getThisCoupon/(:num)/(:num)']		=	"svc/getThisCoupon/$1/$2";	//USER ID, WHO / WHICH
$route['svc/shareThisCoupon/(:num)/(:any)']		=	"svc/shareThisCoupon/$1/$2";	//	WHO/ JSON of emails
$route['svc/bidOnThisCoupon/(:num)/(:num)/(:num)']	= "svc/bidOnThisCoupon/$1/$2/$3";	//coupon id, who id, amount


//	THIS IS CLIENT ADMIN
$route['admin'] = "admin";
$route['admin/addlogo'] 			= "admin/addlogo";
$route['admin/exportemail'] 		= "admin/exportemail";
$route['admin/myreports'] 		= "admin/report/0";
$route['admin/myreports/(:num)'] 	= "admin/report/$1";
$route['admin/changepassword'] 	= "admin/password";

$route['admin/graphs'] 			= "admin/graphs";
$route['admin/settings']		= "admin/settings";

//	THIS IS OHM (MY) ADMIN
$route['ohm'] = "ohm";
//$route['ohm/(:any)']="ohm/";					//	MAIN SITE, CHECK LOGIN
$route['ohm/(:any)']="ohm/opt/$1";					//	$1 ARE FUNCTIONS TO BE PARSED BY CONTROLLER
//	$route['ohm/(:any)/(:any)']="ohm/opt/$1/$2";

//	404 ERROR
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */