<?php 

if(!isset($_SESSION['userid']))
{
	header("location:../");
}

?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title><?php echo TITLE;?>: Coupon</title>
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
    #couponFrame{width:100%;}
    #coupon-list{width:40%;float:left;padding:8px;}
    #coupon-builder{width:60%;background:#FFF;float:left;padding:8px;}
    #loading{display:none;}
    .buffed{margin-bottom:8px;}
    .coupon-list{margin-top:10px;text-decoration:none;color:#605F5F;}
    #confirm{display:none}
    #display-coupon{display:none;position:relative;}
    #display-builder{position:relative;}
    #image-preview{text-align:center;}
    
    </style>
  </head>

  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          
        </ul>
        <h3 class="text-muted"><span id='mast-header'><?php echo TITLE;?></span>: Coupons
	   <span id='hello-there'><?php echo "Welcome ". $_SESSION['fname'];?></span>
	   </h3>
      </div>
	 <br>
	 <div id="couponFrame">
	 	<div id='coupon-list'>
	 		<h2>My Coupons</h2>
			<span style="color:#006EFF"><em>loading...</em></span>
		</div><!-- END COUPON LIST -->
		<div id='coupon-builder'>
			
			<div id='display-builder'>
			<div class='form-group'>
				<label>Graphic (300x300px) </label>
				<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
					<div id="image_preview"><img id="previewing" src="../uploads/noimage.png" /></div>
						<hr id="line">
							<div id="selectImage">
								<label>Select Your Image</label><br/>
								<input type="file" name="file" id="file" required />
								<input type="submit" value="Upload" class="submit" />
					</div>
					<h4 id='loading' >loading..</h4>
					
				</form>
			</div>
			
			
			<!-- COUPON FORM -->
			<form id="buildCoupon" action="" method="post" enctype="multipart/form-data">
			<div class='control-group buffed'>
				<label>Image Path</label>
				<input type="text" id="imagePath" name="imagePath" class="form-control" value="">
			</div>
			<div class='control-group buffed'>
				<label>Title</label><input class="form-control" type="text" class="input-medium" name="coupon-title">
			</div>
			<div class='control-group'>
				<label>Description</label><textarea class="form-control" style="resize:none" name='coupon-description'></textarea>
			</div>
			<div class='control-group buffed'>
				<label>Postal Code</label><input class="form-control" type="text" class="input-medium" name="postalcode" >
			</div>
			<div class='control-group buffed'>
				<label>Category</label>
				<select name="category" id="category" class="form-control">
					<option selected value="1">Restaurants</option>
					<option value="2">Entertainment</option>
					<option value="3">Family</option>
					<option value="4">Concerts</option>
					<option value="5">Sports</option>
					<option value="6">Night Life</option>
				</select>
			</div>
			<div class='control-group buffed'>
				<label>Coupon Type</label>
				<select name="couponType" id="couponType" class="form-control">
					<option selected value="1">Normal</option>
					<option value="2">Group</option>
					<option value="3">Bid</option>
				</select>
			</div>
			<hr>
			<div id='coupon-detail'>
			<div class='control-group buffed'>
					<label>Discount</label>&nbsp;
					<div class='input-group' >
						<input type='number' class='form-control' name='discount' value='5'><div class="input-group-addon">%</div>
					</div>
				</div>
				<div class='control-group buffed'>
					<label>Condition</label>&nbsp;<input type='text' class='form-control' name='condreq' value=''>
				</div>
				<div class='control-group buffed'>
					<label>Expires(mm/dd/yy)</label>&nbsp;<input type='text' class='form-control' name='expires' value=''>
				</div>
			</div><!-- END COUPON DETAIL -->
			<div class='control-group buffed'>
			<input type="hidden" id="couponTypeCode" name="couponTypeCode" value="normal"/>
			<!--default and is used to determine database process on back end-->
			<input type="submit" id="createCoupon" value="Create it!" class="submit"/>
			<span id='confirm'>hello</spam>
			</form>
			<br><br><br><br><br>
			
		</div>
		</div><!-- END DISPLAY BUILDER -->
		
		<!-- SUB FORM TO SHOW COMPLETE COUPON -->
			<div id='display-coupon'>
				<!-- DISPLAY COUPON -->
				<div id='coupon-review'>
					
				</div>
				<button id="delete-coupon">Delete This</button>
				<button id="editor-return">Return To Editor</button>
			</div>
		<!-- END SUB FORM TO DISPLAY COUPON -->
		
	 </div>
	 <br style="clear:both"/><br><br><br><br><br>
	 
	 <!-- FOOTER BELOW -->
      <div class="navbar navbar-fixed-bottom survey-footer" >
        <p><?php echo COPY;?> | <a href="../../logout">logout</a></p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="<?php echo HOST;?>/js/pubnav.js"></script>
	<script>
	
		function displayNormal()
		{
			$("#coupon-detail").empty();
			$("#coupon-detail").append("<label>Discount</label>&nbsp;<div class='input-group'><input type='number' class='form-control' name='discount' value='5'><div class='input-group-addon'>%</div></div>");	
		$("#coupon-detail").append("<div class='control-group buffed'><label>Condition</label>&nbsp;<input type='text' class='form-control' name='condreq' value=''></div>");
		$("#coupon-detail").append("<div class='control-group buffed'><label>Expires(mm/dd/yy)</label>&nbsp;<input type='text' class='form-control' name='expires' value=''></div>");	
		}
		function displayGroup()
		{
			$("#coupon-detail").empty();
			$("#coupon-detail").append("<label>Initial Discount</label>&nbsp;<div class='input-group'><input type='number' class='form-control' name='init-discount' value='5'><div class='input-group-addon'>%</div></div>");
			$("#coupon-detail").append("<label>Max Discount</label>&nbsp;<div class='input-group'><input type='number' class='form-control' name='max-discount' value='10'><div class='input-group-addon'>%</div></div>");
			$("#coupon-detail").append("<div class='control-group buffed'><label>Members Needed for Max Discount</label>&nbsp;<input type='number' class='form-control' name='members-needed' value='5'></div>");		
		$("#coupon-detail").append("<div class='control-group buffed'><label>Condition</label>&nbsp;<input type='text' class='form-control' name='condreq' value=''></div>");
		$("#coupon-detail").append("<div class='control-group buffed'><label>Expires(mm/dd/yy)</label>&nbsp;<input type='text' class='form-control' name='expires' value=''></div>");	
			
		}
		function displayBid()
		{
			$("#coupon-detail").empty();
			$("#coupon-detail").append("<div class='control-group buffed'><label>Starting Bid</label><div class='input-group'><div class='input-group-addon'>$</div><input type='number' class='form-control' name='start-price' value='10'></div>");
			$("#coupon-detail").append("<div class='control-group buffed'><label>Buy Out Value</label><div class='input-group'><div class='input-group-addon'>$</div><input type='number' class='form-control' name='buy-out' value='100'></div>");
			$("#coupon-detail").append("<div class='control-group buffed'><label>Bidding Starts (mm/dd/yy)</label>&nbsp;<input type='text' class='form-control' name='bid-starts' value=''></div>");	
			$("#coupon-detail").append("<div class='control-group buffed'><label>Bidding Ends (mm/dd/yy)</label>&nbsp;<input type='text' class='form-control' name='bid-ends' value=''></div>");	
			
		}
		
		$(document).ready(function(){
			var couponTypeVal="";
			$("#couponType").on("change",function(){
					switch($("#couponType").val())
					{
						//	THIS SECTION DETERMINES WHAT TO SHOW AND WHAT CODE TO ADD TO THE FORM
						case "1":
							//	SET REMAINDER OF FORM FOR NORMAL COUPON
								couponTypeVal="normal";
								displayNormal();
						break;
						case "2":
							//	SET REMAINDER OF FORM FOR NORMAL COUPON
								couponTypeVal="group";
								displayGroup();
							
						break;
						case "3":
							//	SET REMAINDER OF FORM FOR NORMAL COUPON
								couponTypeVal="bid";
								displayBid(); 
						break;	
					}
					$("#couponTypeCode").val(couponTypeVal);
					//alert($("#couponTypeCode").val());
				});
			});
		//	AJAX IMAGE UPLOAD
		$(document).ready(function (e) {
			
			// HANDLE IMAGE UPLOAD
			$("#uploadimage").on('submit',(function(e) {
				e.preventDefault();
				$("#message").empty();
				$('#loading').show();
				$.ajax({
					url: "../ajax/loadImage.php", 
					type: "POST",             
					data: new FormData(this), 
					contentType: false,       
					cache: false,             
					processData:false,        
					success: function(data)   
				{
					$('#loading').hide();
					$("#imagePath").val(data);
				},
				error:function()
				{
					alert("error");	
				}
			});
		})); // END IMAGE UPLOAD AJAX

		// 	Function to preview image after validation
			$(function() {
				$("#file").change(function() {
					$("#message").empty(); // To remove the previous error message
					var file = this.files[0];
					var imagefile = file.type;
					var match= ["image/jpeg","image/png","image/jpg"];
					if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
					{
						$('#previewing').attr('src','noimage.png');
						$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
						return false;
					}
					else
					{
						var reader = new FileReader();
						reader.onload = imageIsLoaded;
						reader.readAsDataURL(this.files[0]);
					}
				});
			});
			function imageIsLoaded(e) {
				$("#file").css("color","green");
				$('#image_preview').css("display", "block");
				$('#previewing').attr('src', e.target.result);
				$('#previewing').attr('width', '250px');
				$('#previewing').attr('height', '230px');
			};
	});
	</script>
	<script>
	//	AJAX HANDLE FORM SUBMIT
		$(document).ready(function(e){		
			$("#buildCoupon").on("submit",(function(e){	
				e.preventDefault();
				$.ajax({
					url: "../ajax/buildCoupon.php", 
					type: "POST",             
					data: new FormData(this), 
					contentType: false,       
					cache: false,             
					processData:false,        
					success: function(data)   
					{
							//alert(data);
							switch(data)
							{
								case "FALSE":
									//alert(data);
									$("#confirm").html("<span style='color:red'>We had a problem!</span>");
									$("#confirm").fadeIn(500).delay(3000).fadeOut(500);
								break;
								case "TRUE":
								//	RETURNED VALUE TO SHOW COUPON IS SAVED
									$("#confirm").html("Confirmed!");
									$("#confirm").fadeIn(500).delay(3000).fadeOut(500);
									$("#previewing").attr("src","../uploads/noimage.png");
									$("#buildCoupon")[0].reset();
									//	reloads page from server
									//	location.reload(true);
										loadCoupons();
										/*
										loadBids();
										loadGroups();
										loadNormals();	
										*/										
								break;	
							}	
					},
					error:function()
					{
						alert("ajax error");	
					}
				});	
			}));
		});
	</script>
	<script>
		function loadCoupons()
		{
			$.ajax({
					url: "../ajax/getCoupons.php", 
					type: "POST",             
					//data: {'which':'all'}, 
					contentType: 'application/x-www-form-urlencoded; charset=UTF-8',       
					cache: false,             
					processData:true,        
					success: function(data)   
					{
					//	RETURNED VALUE TO SHOW COUPON IS SAVED
						$("#coupon-list").empty();
						$("#coupon-list").html(data);
					},
					error:function()
					{
						$("#bidList").html("unknown error");	
					}
				});
		} 
		function showCouponDetail(which,type)
		{
			$("#display-builder").slideUp().delay(500);
			$("#display-coupon").slideDown();
			
			//	NOW GO GET COUPON DETAIL
				$.ajax({
					url: "../ajax/getSingleCoupon.php", 
					type: "POST",             
					data: {'which':which,'type':type}, 
					contentType: 'application/x-www-form-urlencoded; charset=UTF-8',       
					cache: false,             
					processData:true,        
					success: function(data)   
					{
						$("#coupon-review").html(data);
					},
					error:function()
					{
						"Whoa. Something went wrong. We're working on it."
					}
				});
				
				
		}
		function setButtons()
		{
			$("#editor-return").click(function(){			
				$("#display-builder").slideDown().delay(500);
				$("#display-coupon").slideUp();
			});
		}
		
		$(document).ready(function(){
		//	CODE TO LOAD LIST OF COUPONS
			loadCoupons();
			setButtons();	
		});
		
				
	</script>

</body>
</html>

