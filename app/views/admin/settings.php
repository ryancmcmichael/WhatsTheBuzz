<?php

if(!isset($_SESSION['userid']))
{
    header("location:../");
}
date_default_timezone_set('America/New_York');
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title><?php echo TITLE;?>: Settings</title>
    <link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo HOST;?>bootstrap/css/landing.css"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Customer Insight, tagging, mobile, suveys, better business, relationship management">
    <meta name="author" content="Ryan McMichael">
    <link rel="shortcut icon" href="<?php echo HOST;?>/favicon.ico">

    <style>
        #hello-there{float:right;}
        .emailRow{width:94%;}
        .row{width:100%;padding:5px;position:relative;clear:both;font-size:.8em;margin:0 auto;}
        .butt{font-style:italic;border:none;display:inline-block;padding:4px;min-width:95px;vertical-align:top;}
        .button{min-width:97px;min-height:21px;font-size:.7em;font-weight:normal;color:#000000;vertical-align:top;}
        .hiddenRow{display:none;}
        .shownRow{width:95%;padding:2px;position:relative;clear:both;font-size:.8em;margin:0 auto;display:block;}
        .hiddenline{display:none;}
        .shownline{width:100%;padding:1px;position:relative;clear:both;border-bottom:1px solid #ddd;display:block;}
        .rowTag{width:100%;padding-top:10px;padding-bottom:5px;position:relative;clear:both;border-bottom:2px solid #bababa;display:block;text-align:left;font-size:1.4em;font-weight:bold;color:#8c8c8c;}

    </style>
</head>

<body>

<div class="container">
    <div class="header">
        <ul class="nav nav-pills pull-right">

        </ul>
        <h3 class="text-muted"><span id='mast-header'><?php echo TITLE;?></span>: Settings
            <span id='hello-there'><?php echo "Welcome ". $_SESSION['fname'];?></span>
        </h3>
    </div>
    <br>

    <?php include('admin_nav.php');?>

    <div class='rowTag'>User Management<div class='butt pull-right'><button class='button' id = 'userButton'>Hide Details</button></div>
        <div class='shownRow' id='userManagement'>
            <form role="form" id="signup-step-one">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="fname" id="fname" class="form-control input-lg" placeholder="First Name" tabindex="1">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="lname" id="lname" class="form-control input-lg" placeholder="Last Name" tabindex="2">
                        </div>
                    </div>
                </div>
                <center><div class="form-group">
                        <input type="email" name="email" id="email" class="form-control input-lg emailRow" placeholder="Email Address" tabindex="3">
                    </div></center>

                <!--PASSWORD ROW -->
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="password" name="pw1" id="pw1" class="form-control input-lg" placeholder="Password" tabindex="4">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="password" name="pw2" id="pw2" class="form-control input-lg" placeholder="Confirm Password" tabindex="5">
                        </div>
                    </div>
                </div></form><!-- END FORM-->
            <div class="row" style='text-align:center;'>
                <div style='display:inline-block;'><button class="btn btn-lg btn-info" id="submitButton" style="margin-left:50px;" role="button">Add New User!</button></div>
                <div style='display:inline-block;width:40px;'>
                    <img id='userSpinner' style='display:none;' src='<?php echo HOST;?>img/ajax-loader.gif'/>
                </div>
            </div>
            <div class="row" style="text-align:center;font-size:2em;">
                <p id="error_msg">
                </p>
            </div>
            
            <center>
            	<div class="shownRow" style='border-top:1px solid #ddd;padding-top:10px;display:inline-block;font-size:1.4em;font-weight:normal;'>Select User to Delete:
            	              	  
					<?php
					    include("ajax/ajax-config.php");
					    //	ATTRIBUTES FOR DB CONNECTION
					    $attrs = array(PDO::ATTR_PERSISTENT => true);
					
					    //	CONNECT TO DB
					    $dbh = new PDO(DBHOSTAJX, DBUN, DBPW, $attrs);
					
					    // 	the following tells PDO we want it to throw Exceptions for every error.
					    // 	this is far more useful than the default mode of throwing php errors
					    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					    // 	prepare the statement. the place holders allow PDO to handle substituting
					    // 	the values, which also prevents SQL injection
					    //  $stmt = $dbh->prepare("SELECT dtCreated, server, quality, service, value, clean, respEmail, verbatim FROM responses");
					
					    $userQuery = $dbh->prepare("SELECT * FROM wtbmembers WHERE busname='".$_SESSION['BIZNAME']."' AND usertype='sub' ");
					
					    // 	bind the parameters
					    $userQuery->bindValue(":id", $_SESSION['userid']);
					
					    if ($userQuery->execute()) {
								
					        $employees = array();
					
					        $employees = $userQuery->fetchAll(PDO::FETCH_ASSOC);
					    }
						?>
		            	              	  
						<select name="Employees" id="userid" style='margin-left:30px;'>
							<option selected="selected">Choose one</option>
		  					<?php foreach($employees as $employee) { ?>
								<option value="<?php echo $employee['userid'] ?>"><?php echo $employee['fname'] ?></option>
		  					<?php } ?>
						</select>
            
            	</div>
            
            </center>
            
            <div class="row" style='text-align:center;'>
                <div style='display:inline-block;'><button class="btn btn-lg btn-info" id="deleteButton" style="margin-left:50px;" role="button">Delete User</button></div>
                <div style='display:inline-block;width:40px;'>
                    <img id='deleteSpinner' style='display:none;' src='<?php echo HOST;?>img/ajax-loader.gif'/>
                </div>
            </div>

        </div> <!-- // END ROW MARKETING-->

    </div>



<div class='rowTag' style='border-bottom:none;'>Survey Management<div class='butt pull-right'><button class='button' id = 'surveyButton'>Hide Details</button></div>
    <div class='shownRow' id='surveyManagement'>

		<div class="row">Select the survey you would like to update: 
			<select name="whichSurvey" id="surveys" style='margin-left:20px;'>
				<option selected="selected" value="survey1">Custom Survey 1</option>
				<option value="survey1">Custom Survey 2</option>
				<option value="survey2">Custom Survey 3</option>
				<option value="survey3">Custom Survey 4</option>
				<option value="survey4">Custom Survey 5</option>
			</select>
		</div>

		<div class="row">
			<div class="col-xs-16 col-sm-8 col-md-8" style='color:#000000;'>Question 1:
				<div class="form-group">
					<input type="text" name="Q1" id="Q1" class="form-control input" placeholder="Question/Metric to be rated" tabindex="6">
				</div>
			</div>
			<div class="col-xs-8 col-sm-4 col-md-4" style='color:#000000;'>Tag:
				<div class="form-group">
					<input type="text" name="T1" id="T1" class="form-control input" placeholder="1-Word Label" tabindex="7">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-16 col-sm-8 col-md-8" style='color:#000000;'>Question 2:
				<div class="form-group">
					<input type="text" name="Q2" id="Q2" class="form-control input" placeholder="Question/Metric to be rated" tabindex="8">
				</div>
			</div>
			<div class="col-xs-8 col-sm-4 col-md-4" style='color:#000000;'>Tag:
				<div class="form-group">
					<input type="text" name="T2" id="T2" class="form-control input" placeholder="1-Word Label" tabindex="9">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-16 col-sm-8 col-md-8" style='color:#000000;'>Question 3:
				<div class="form-group">
					<input type="text" name="Q3" id="Q3" class="form-control input" placeholder="Question/Metric to be rated" tabindex="10">
				</div>
			</div>
			<div class="col-xs-8 col-sm-4 col-md-4" style='color:#000000;'>Tag:
				<div class="form-group">
					<input type="text" name="T3" id="T3" class="form-control input" placeholder="1-Word Label" tabindex="11">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-16 col-sm-8 col-md-8" style='color:#000000;'>Question 4:
				<div class="form-group">
					<input type="text" name="Q4" id="Q4" class="form-control input" placeholder="Question/Metric to be rated" tabindex="12">
				</div>
			</div>
			<div class="col-xs-8 col-sm-4 col-md-4" style='color:#000000;'>Tag:
				<div class="form-group">
					<input type="text" name="T4" id="T4" class="form-control input" placeholder="1-Word Label" tabindex="13">
				</div>
			</div>
		</div>
		<div class="row" style='text-align:center;'>
			<div style='display:inline-block;'><button class="btn btn-lg btn-info" id="changeButton" style="margin-left:50px;margin-bottom:35px;" role="button">Submit Changes!</button></div>
			<div style='display:inline-block;width:40px;'>
				<img id='changeSpinner' style='display:none;' src='<?php echo HOST;?>img/ajax-loader.gif'/>
			</div>
		</div>
	</div>
</div>

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

    $(document).ready(function(){

        $("button").click(function(event){

            //	WHAT BUTTON ARE WE TOUCHING
            var myButton = $(this).attr('id');

            //	WHOSE BUTTON ARE WE TOUCHING
            var myRow = document.getElementById("row" + myButton.substring(6));
            var myLine = document.getElementById("line" + myButton.substring(6));

            switch(myButton){
                case 'userButton':
                    if(document.getElementById("userManagement").className == 'shownRow')
                    {
                        document.getElementById("userManagement").className = "hiddenRow";
                        document.getElementById($(this).attr('id')).innerHTML = "Show Details";
                    }else
                    {
                        document.getElementById("userManagement").className = "shownRow";
                        document.getElementById($(this).attr('id')).innerHTML = "Hide Details";
                    }
                    break;
                case 'surveyButton':
                    if(document.getElementById("surveyManagement").className == 'shownRow')
                    {
                        document.getElementById("surveyManagement").className = "hiddenRow";
                        document.getElementById($(this).attr('id')).innerHTML = "Show Details";
                    }else
                    {
                        document.getElementById("surveyManagement").className = "shownRow";
                        document.getElementById($(this).attr('id')).innerHTML = "Hide Details";
                    }
                    break;
            }

        });

    $("#submitButton").click(function(){

        //	CHECK FOR COMPLETENESS
        if(
            $("#fname").val() == null		||
            $("#fname").val() == ""		||

            $("#lname").val() == null		||
            $("#lname").val() == ""		||

            $("#email").val() == null		||
            $("#email").val() == "" 		||

            $("#pw1").val() == null	||
            $("#pw1").val() == ""		||

            $("#pw2").val() == null	||
            $("#pw2").val() == ""		||

            $("#pw1").val() != $("#pw2").val()

        )	//	END IF - SOMETHING IS NOT COMPLETE
        {
            $("#userSpinner").hide();
            $("#submitButton").prop("disabled",false);
            return false;
        }
        //	SET SPINNER IN MOTION
        $("#submitButton").prop("disabled",true);
        $("#userSpinner").show();
        var delayer = setTimeout("submit()",2000);
    });
});
    
    function submit(){

        $.ajax({
            url: "/ajax/ajax-newuser.php/",
            data: {
                //	pull these in either way. for updates, we use.
                'fname'	:	$("#fname").val(),
                'lname'	:	$("#lname").val(),
                'email'	:	$("#email").val(),
                'pword'	:	$("#pw1").val()
            },
            success:function(data)
            {
                switch(data)
                {
                    case "TRUE":
                        $("#userSpinner").fadeOut(500);
						alert("Thanks! New user created.");
						location.reload(true);
                        break;
                    case "FALSE":
                        alert("Something went wrong. Please try again later.");
                        $("#userSpinner").fadeOut(500);
						location.reload(true);
                }
            },
            error:function(data)
            {
                //alert(data);
            }
        });	//	END AJAX

    }
    
    $("#changeButton").click(function(){

        //	CHECK FOR COMPLETENESS

        if(
            $("#Q1").val() == null		||
            $("#Q1").val() == ""		||

            $("#Q2").val() == null		||
            $("#Q2").val() == ""		||

            $("#Q3").val() == null		||
            $("#Q3").val() == "" 		||

            $("#Q4").val() == null		||
            $("#Q4").val() == ""		||

            $("#T1").val() == null		||
            $("#T1").val() == ""		||

            $("#T2").val() == null		||
            $("#T2").val() == ""		||

            $("#T3").val() == null		||
            $("#T3").val() == "" 		||

            $("#T4").val() == null		||
            $("#T4").val() == ""

        )	//	END IF - SOMETHING IS NOT COMPLETE
        {
            $("#changeSpinner").hide();
            $("#changeButton").prop("disabled",false);
            return false;
        }
        //	SET SPINNER IN MOTION
        $("#changeButton").prop("disabled",true);
        $("#changeSpinner").show();
        var delayer = setTimeout("change()",2000);
    });

    function change(){

    	var sName = document.getElementById("surveys");
    	var surveyName = sName.options[sName.selectedIndex].value

        $.ajax({
            url: "/ajax/ajax-newsurvey.php/",
            data: {
                //	pull these in either way. for updates, we use.
                'Q1'	:	$("#Q1").val(),
                'Q2'	:	$("#Q2").val(),
                'Q3'	:	$("#Q3").val(),
                'Q4'	:	$("#Q4").val(),
                'T1'	:	$("#T1").val(),
                'T2'	:	$("#T2").val(),
                'T3'	:	$("#T3").val(),
                'T4'	:	$("#T4").val(),
                surveyName
            },
            success:function(data)
            {
                switch(data)
                {
                    case "TRUE":
                        $("#changeSpinner").fadeOut(500);
						alert("Thanks! Your survey has been updated.");
						location.reload(true);
                        break;
                    case "FALSE":
                        alert("Something went wrong. Please try again later.");
                        $("#changeSpinner").fadeOut(500);
						location.reload(true);
                }
            },
            error:function(data)
            {
                //alert(data);
            }
        });	//	END AJAX

    }
    
    $("#deleteButton").click(function(){

        //	SET SPINNER IN MOTION
    	$("#deleteButton").prop("disabled",true);
    	$("#deleteSpinner").show();
    	var delayer = setTimeout("remove()",2000);
	});

	function remove(){
	
        $.ajax({
            url: "/ajax/ajax-removeuser.php/",
            data: {
                //	pull these in either way. for updates, we use.
                'userid':	$("#userid").val(),
            },
            success:function(data)
            {
                switch(data)
                {
                    case "TRUE":
                        $("#deleteSpinner").fadeOut(500);
						alert("User has succesfully been removed.");
						location.reload(true);
                        break;
                    case "FALSE":
                        alert("Something went wrong. Please try again later.");
                        $("#deleteSpinner").fadeOut(500);
						location.reload(true);
                }
            },
            error:function(data)
            {
                //alert(data);
            }
        });	//	END AJAX

    }

</script>

</body>
</html>