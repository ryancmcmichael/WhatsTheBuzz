<?php 
require_once("ajax/ajax-config.php");

if(!isset($_SESSION['userid']))
{
	header("location:../");
}
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title><?php echo TITLE;?>: Export Email</title>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/landing.css"/>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Customer Insight, tagging, mobile, suveys, better business, relationship management">
<meta name="author" content="John Brenton Phillips">
<link rel="shortcut icon" href="<?php echo HOST;?>/favicon.ico">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    #hello-there{float:right;}
    </style>
  </head>

  <body>

    <div class="container">
     <div class="header">
        <ul class="nav nav-pills pull-right">
       	   
        </ul>
	   <h3 class="text-muted"><span id='mast-header'><?php echo TITLE;?></span>: admin
	   <span id='hello-there'><?php echo "Welcome ". $_SESSION['fname'];?></span>
	   </h3>
	</div>
	   <br>
	   	<?php
		include('admin_nav.php');
		?>
      
<?php 

	//	THE EXPORT CODE HERE  _ CLEAN IT UP LATER
		// 	output headers so that the file is downloaded rather than displayed
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=data.csv');
		
		// 	create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');
	
		// 	output the column headings
			fputcsv($output, array('email'));

		// 	fetch the data
			
    				$db = new PDO(DBHOSTAJX,DBUN,DBPW);
    				$query = "SELECT respEmail FROM Responses;";
    				$sql = $db->prepare($query);
    				$sql->execute();
    				$data = $sql->fetchAll();
				
				foreach($data as $row) {
				//$email = $row['respEmail'];
					fputcsv($output, $row);
				}
				
				//var_dump($data);
	//	END EXPORT CODE
		
?>
    		Sending you the file!

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
