<?php 
//	ARE THEY LOGGED IN?
	if(!isset($_SESSION['userid']))
	{
		header("location:../");
	}

//	ARE THE TRYING TO UPLOAD AN IMAGE?
//	IF SOME UPOLOAD ACTIVITY IS DETECTED WE EXECUTE THIS CODE
	if(isset($_POST["submit"])){
		
		//echo "uploading file...";
		$uploadResult = uploadImage();
		$uploadArry = explode(":",$uploadResult);
		
	}
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title><?php echo TITLE;?>: Add a Logo</title>
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
    
    	.fileUpload {
    		position: relative;
    		overflow: hidden;
    		margin: 10px;
	}
	.fileUpload input.upload {
    		position: absolute;
    		top: 0;
    		right: 0;
    		margin: 0;
    		padding: 0;
    		font-size: 20px;
    		cursor: pointer;
    		opacity: 0;
    		filter: alpha(opacity=0);
	}
    </style>
  </head>

  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          
        </ul>
        <h3 class="text-muted"><span id='mast-header'><?php echo TITLE;?></span>: admin
	   <span id='hello-there'><?php echo "Welcome ". $_SESSION['fname'];?></span>
	   </h3></div>
	   <br>
	   	<a href="../">admin home</a>	|
		<a href="addLogo/"> add logo</a>	|
		<!--<a href="">add site</a> 	| -->
		<!--<a href="">add coupon</a>	| -->
	   	<a href="myreports/">report summary</a>

<?php
	//	THE $_SESSION variables URL, SurveyCode, and QRPath WILL BE SET FOR THIS PAGE THROUGH EITHER
	//	SIGNIN OR SIGNUP PROCESS.
	//	HANDLE THE URL / IMAGE BUILD HERE
		define('RELPATH',dirname($_SERVER['PHP_SELF']));
		if(!defined("SRVHOST"))
		{define('SRVHOST',$_SERVER['HTTP_HOST']);}

	//	DEFINE URL PATH FOR TESTING
		switch(SRVHOST)
		{
			case "whatsthebuzz":
				$myURLroot = "http://whatsthebuzz";
			break;
			case "whatsthe.buzz":
				$myURLroot = "https://whatsthe.buzz";
			break;	
		}
		$urlBUILD = $myURLroot."/for/" . $_SESSION['URL'];
		
?>
    		<h2>
		Add a Logo For Your Surveys
		</h2>
		<?php
			//	TEST FOR SUCCESS WITH UPLOAD
				if(isset($_POST['submit']))
				{
					
					// 	WE CHECK FOR MESSAGE - WE SHOW FORM EITHER WAY I THINK
						echo "url" . $uploadArry[1];				
						if($uploadArry[0]=='TRUE')
						{
							//	SHOW THE IMAGE
							echo "<img src='".$_SESSION['logoURL']."'/>";	
						}
				}	// 	END SUBMIT ISSET
		?>
		
		<form action="" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input  type="file" class="fileUpload btn btn-primary" name="fileToUpload" id="fileToUpload">
   
    <input type="submit" class="btn" value="Upload Image" name="submit">
</form>

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
function uploadImage()
{
	//	WE'LL USE THIS $VAR TO CONVEY INFO TO THE SUBMITTER
		$uploadMsg = "";
		
	//	BEGIN UPLOAD FUNCTION
		$target_dir = "./uploads/";
	//	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$imgType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);
		$newFileName = basename($_SESSION['URL'].".".$imgType);
		$target_file = $target_dir . $newFileName;
		$imageFileType = $imgType;
	//	echo "new image " . $target_file; = './uploads/newfilename.ext'
		$uploadOk = 1;
	//	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	//	CHECK FOR VALID IMAGE FILE
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    $uploadMsg =  "FALSE:Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}
		
	// 	Check if image file is a actual image or fake image
		if(isset($_POST["submit"]) && !empty($_FILES["fileToUpload"]["tmp_name"])) {
	//	    echo $_FILES["fileToUpload"]["tmp_name"];
		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    if($check !== false) {
			   //echo "File is an image - " . $check["mime"] . ".";
			   $uploadOk = 1;
		    } else {
			   $uploadMsg = "FALSE:The file does not appear to be an image. Can you double check and try again?";
			   $uploadOk = 0;
		    }
		}
		// Check if file already exists
		if (file_exists($target_file)) {
		    $uploadMsg = "FALSE:Sorry, file already exists.";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
		    $uploadMsg = "FALSE:Sorry, your file is too large. We're limiting the size to 5MB.";
		    $uploadOk = 0;
		}
		
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    $uploadMsg .= "<br>your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			   $uploadMsg = "TRUE: Your file was uploaded successfully!";
			   
			   
			   //		CODE HERE TO ADD IMG PATH TO THE DATABASE
			   $_SESSION['logoURL'] = "http://".$_SERVER['HTTP_HOST']."/uploads/" . $newFileName;
			   echo $_SESSION['logoURL'];
		    } else {
			   $uploadMsg = "FALSE:Sorry, there was an error uploading your file.";
		    }
		}	
	//	END UPLOAD FUNCTION
		return $uploadMsg;
	
	
	
}
?>