<?php 

if(!isset($_SESSION['userid']))
{
	header("location:../");
}
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title><?php echo TITLE;?>: Contact</title>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/landing.css"/>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Customer Insight, tagging, mobile, suveys, better business, relationship management">
<meta name="author" content="John Brenton Phillips">
<link rel="shortcut icon" href="<?php echo HOST;?>assets/ico/favicon.ico">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    #hello-there{float:right;}
    .row{width:98%;margin-left:auto;margin-right:auto;padding-top:3px;padding-bottom:2px;}
    .row div{float:left;width:15%;margin-left:1%;}
    .lightgrey{background-color:#dddddd;}
    .hdr{font-weight:600;}
    .bigNum{font-size:2.2em;width:100%;}
    .label{color:#000;border-top:1px solid #000;border:1px solid orange;width:100%;}
    </style>
  </head>

  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          
        </ul>
        <h3 class="text-muted"><span id='mast-header'><?php echo TITLE;?></span>: reports
	   <span id='hello-there'><?php echo "Welcome ". $_SESSION['fname'];?></span>
	   </h3>
      </div><br>
	 <a href="./">admin home</a> | 
	   	<a href="reportsummary">report summary</a>
		<?php
		//	COVER CONNECTIVITY VARS	
			include('ajax/ajax-config.php');
		
		//	GET AVERAGES AND RESPONSES
			try 
		{
			//$dbh = new PDO('mysql:host=localhost;dbname=survey', 'root', 'demo');
			$dbh = new PDO(DBHOSTAJX,DBUN,DBPW);
			$checkResponses = $dbh->query("SELECT * FROM Responses WHERE accountid=".$_SESSION['userid']);
			
			$getAverages = $dbh->query("SELECT Avg(quality),Avg(service),Avg(value),Avg(clean),Avg(recommend) FROM Responses WHERE accountid=".$_SESSION['userid']);
			
			$isThere = $checkResponses->rowCount();
			if($isThere>0)
			{
				?>
				<div style="width:100%;margin-top:2%;margin-bottom:6%;">
				
				
				<div class='row lightgrey'>
					<div class='hdr'>&nbsp;</div>
					<div class='hdr'>Quality</div>
					<div class='hdr'>Service</div>
					<div class='hdr'>Value</div>
					<div class='hdr'>Cleanliness</div>
					<div class='hdr'>Recommend</div>
				</div>
				<?php
				$avgs = $getAverages->fetch();
				?>
				<div class='row lightgrey'>
					<div class='hdr'>Avg.</div>
					<div class='hdr'>
					<div class='bigNum'>
							<?php echo intval($avgs['Avg(quality)']);?>
						</div>
					</div>
					<div class='hdr'>
					<div class='bigNum'>
							<?php echo intval($avgs['Avg(service)']);?>
						</div>
					</div>
					<div class='hdr'>
					<div class='bigNum'>
							<?php echo intval($avgs['Avg(value)']);?>
						</div>
					</div>
					<div class='hdr'>
					<div class='bigNum'>
							<?php echo intval($avgs['Avg(clean)']);?>
						</div>
					</div>
					<div class='hdr'>
						<div class='bigNum'>
							<?php echo intval($avgs['Avg(recommend)']);?>
						</div>
					</div>
				</div>
				<div class='row lightgrey'>
					<div class='hdr'>Date</div>
					<div class='hdr'>Quality</div>
					<div class='hdr'>Service</div>
					<div class='hdr'>Value</div>
					<div class='hdr'>Cleanliness</div>
					<div class='hdr'>Recommend</div>
				</div>
				<?php
				$reportset = $checkResponses->fetchAll();
				foreach($reportset as $row)
				{
					
					echo "<div class='row'>";
					echo "<div><a href='report/".$row['responseID']."'>".$row['reportDate']."</a></div>";
					echo "<div>".$row['quality']."</div>";
					echo "<div>".$row['service']."</div>";
					echo "<div>".$row['value']."</div>";
					echo "<div>".$row['clean']."</div>";
					echo "<div>".$row['recommend']."</div>";
					echo "</div>";	
					
				}
				
				?>
				</div>
				<?php
				
			}
			else
			{
			
				echo "No reports yet for this user.";
					
			}
		}
		catch (PDOException $e)
		{
			print "DB_ERROR";
			die();
		}

		
		
		
		
		?>

     
      <div class="navbar navbar-fixed-bottom survey-footer" >
        <p><?php echo COPY;?> | <a href="../logout">logout</a></p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="<?php echo HOST;?>/js/pubnav.js"></script>

</body>
</html>

<?php
function handleQR($imgpath, $urlpath){
	
	  
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = "/home/ycloser1/public_html/qr".DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
	
    // 	html PNG location prefix
    		$PNG_WEB_DIR = 'temp/';

      
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
	   //echo $PNG_TEMP_DIR;
    		
    $filename = "";
    $filename = "http://commentbox.es/qr/temp/".$imgpath.'.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'H';
    
    /*if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];   */ 

    $matrixPointSize = 7;
    
    /*
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);
	*/

    if (isset($urlpath)) { 
    
        //it's very important!
        if (trim($urlpath) == '')
           echo "Error"; 
		  
		  //	die('data cannot be empty! <a href="?">back</a>');
            
        // user data
	   	$buildpath = $PNG_TEMP_DIR;
		$addImage =  $imgpath."_".md5($urlpath.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        	$filename = $buildpath.$addImage;
	   	QRcode::png($urlpath, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    } 
        
    	//	display generated file
    	//	echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';
		echo "<img src='http://commentbox.es/qr/temp/".$addImage."'/>";  
    
	
	
	}

?>