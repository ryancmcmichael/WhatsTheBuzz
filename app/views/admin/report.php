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
    <title><?php echo TITLE;?>: Reports</title>
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
        #responseTable{margin-left:auto;margin-right:auto;width:100%;margin-top:20px;}
        .got1{background-color:#FF0004;}
        .got2{background-color:#FF9000;}
        .got3{background-color:#FFDD00;}
        .got4{background-color:#C2FF00;}
        .got5{background-color:#5AF300;}
        .noResponse{background-color:#000000;}
        .row{width:100%;padding:5px;position:relative;clear:both;font-size:.8em;border-bottom:1px solid #ddd;margin:0 auto;}
        .cell{display:inline-block;padding:1%;}
        .metric{width:5.3125%;text-align:center !important;border:1px solid #ddd;margin-left:1px;margin-right:1px;}
        .date{width:25%;text-align:left;white-space:nowrap;}
        .server{width:18.75%;text-align:left;}
        .email{width:*;}
        .row.header{font-style:italic;font-weight:bold;}
        .butt{font-style:italic;font-weight:bold;border:none;display:inline-block;padding:4px;min-width:95px;}
        .button{min-width:87px;min-height:21px;}
        .hiddenRow{display:none;}
        .shownRow{width:95%;padding:2px;position:relative;clear:both;font-size:.8em;margin:0 auto;display:block;}
        .commentTag{width:20%;position:relative;clear:both;font-size:1.2em;margin:0 auto;display:inline-block;padding:1px;}
        .comments{width:20%;text-align:left;display:inline-block;vertical-align:text-top;}
        .tagrow{width:100%;padding:1px;position:relative;clear:both;font-size:.8em;border-bottom:1px solid #ddd;margin:0 auto;}
        .hiddenline{display:none;}
        .shownline{width:100%;padding:1px;position:relative;clear:both;border-bottom:1px solid #ddd;display:block;}

    </style>
</head>

<body>

<div class="container">
    <div class="header">
        <ul class="nav nav-pills pull-right">

        </ul>
        <h3 class="text-muted"><span id='mast-header'><?php echo TITLE;?></span>: Summary
            <span id='hello-there'><?php echo "Welcome ". $_SESSION['fname'];?></span>
        </h3>
    </div>
    <br>
    <?php

    include("ajax/ajax-config.php");
    //	ATTRIBUTES FOR DB CONNECTION
    $attrs = array(PDO::ATTR_PERSISTENT => true);

    //	CONNECT TO DB
    $dbh = new PDO(DBHOSTAJX,DBUN,DBPW,$attrs);

    // 	the following tells PDO we want it to throw Exceptions for every error.
    // 	this is far more useful than the default mode of throwing php errors
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 	prepare the statement. the place holders allow PDO to handle substituting
    // 	the values, which also prevents SQL injection
    $stmt = $dbh->prepare("SELECT * FROM Responses WHERE accountID=:id ORDER BY dtCreated DESC");

    // 	bind the parameters
    $stmt->bindValue(":id", $_SESSION['userid']);
    //	$stmt->bindValue(":id", 9999);


    // 	initialise an array for the results
    $responses = array();
    $html = "";
    if ($stmt->execute()) {

        //	BUILD THE TABLE
        $html .= "<div id='responseTable'>";
        $html .= "<div class='row header'>";
        $html .= "<div class='cell date'>Date/Time</div>";
        $html .= "<div class='cell server'>Server</div>";
        $html .= "<div class='cell metric'>Q</div>";
        $html .= "<div class='cell metric'>S</div>";
        $html .= "<div class='cell metric'>V</div>";
        $html .= "<div class='cell metric'>C</div>";
        $html .= "<div class='cell metric'>R</div>";
        $html .= "</div>"; //END ROW
        //	CHECK OF RECORDS EXIST
        $rowCount = $stmt->rowCount();

        //	ADD ROWS
        if($rowCount>0)
        {
            //	USE rowCount TO TRACK WHICH ROW WE ARE ON

            $counter = 1;

            //	WE HAD RESULTS
            while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                $html .= "<div class='row'>";
                //	CELLS FOR OUR DATA
                $html .= "<div class='cell date'>".date("M d, Y g:iA",strtotime($row['dtCreated']))."</div>";
                $html .= "<div class='cell server'>".$row['server']."</div>";
                $html .= "<div class='cell metric ".getColor($row['quality'])."'>".$row['quality']."</div>";
                $html .= "<div class='cell metric ".getColor($row['service'])."'>".$row['service']."</div>";
                $html .= "<div class='cell metric ".getColor($row['value'])."'>".$row['value']."</div>";
                $html .= "<div class='cell metric ".getColor($row['clean'])."'>".$row['clean']."</div>";
                $html .= "<div class='cell metric ".getColor($row['recommend'])."'>".$row['recommend']."</div>";
                $html .= "<div class='butt pull-right'><button class='button' id = 'button".$counter."'>Show Details</button></div>";
                $html .= "</div>";

                $html .= "<div class = 'hiddenRow' id = 'row".$counter."'>";

                $html .= "<div class = 'tagrow'>";
                $html .= "<div class = 'commentTag'>Quality</div>";
                $html .= "<div class = 'commentTag'>Service</div>";
                $html .= "<div class = 'commentTag'>Value</div>";
                $html .= "<div class = 'commentTag'>Cleanliness</div>";
                $html .= "<div class = 'commentTag'>General</div>";
                $html .= "</div>";
                if(!empty($row['qualitycomment']))
                {
                    $html .= "<div class='comments'>".$row['qualitycomment']."</a></div>";
                }
                else
                {
                    $html .= "<div class='comments'>No comments provided.</div>";
                }
                if(!empty($row['servicecomment']))
                {
                    $html .= "<div class='comments'>".$row['servicecomment']."</a></div>";
                }
                else
                {
                    $html .= "<div class='comments'>No comments provided.</div>";
                }
                if(!empty($row['valuecomment']))
                {
                    $html .= "<div class='comments'>".$row['valuecomment']."</a></div>";
                }
                else
                {
                    $html .= "<div class='comments'>No comments provided.</div>";
                }
                if(!empty($row['cleancomment']))
                {
                    $html .= "<div class='comments'>".$row['cleancomment']."</a></div>";
                }
                else
                {
                    $html .= "<div class='comments'>No comments provided.</div>";
                }
                if(!empty($row['verbatim']))
                {
                    $html .= "<div class='comments'>".$row['verbatim']."</a></div>";
                }
                else
                {
                    $html .= "<div class='comments'>No comments provided.</div>";
                }
                $html .= "</div>";	//	END ROW

                $html .= "<div id = 'line".$counter."' class = 'hiddenline'></div>";

                $counter++;

            }	//	END WHILE LOOP

        }
        else
        {
            //	NO RESULTS
            $html .="<div class='noreports'>No responses to report yet!</div>";
            $html .= "</div>";	//	END ROW
        }

        //	END ROWS AND TABLE
        $html .= "</div>";	//	END TABLE
    } else
        //	NO DATA FOR THIS USER
    {

        echo "we had a DB error. We'll look into it!";

    }

    // 	set PDO to null in order to close the connection
    $pdo = null;
    include('admin_nav.php');
    echo $html;
    ?>


    <div class="navbar navbar-fixed-bottom survey-footer" >
        <p><?php echo COPY;?> | <a href="../../logout">logout</a></p>
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
//	FUNCTIONS GO HERE FOR COLOR CODING
function getPromoteColor($num)
{
    $score=(int)$num;
    $color="";
    if($score<=6)				//	Detractors
    {
        $color="got1";
    }
    elseif($score>6 && $score<9)	//	Passives
    {
        $color="got3";
    }
    elseif($score>=9)			//	PROMOTERS
    {
        $color="got5";
    }
    return $color;
}

function getColor($num)
{
    $color="";
    switch($num){
        case "1":
            $color="got1"; 	//	POOR
            break;
        case "2":
            $color="got2";
            break;
        case "3":
            $color="got3";	//	 SO-SO
            break;
        case "4":
            $color="got4";
            break;
        case "5":
            $color="got5";	//	GREAT
            break;
        case "99":
            $color="noResponse";
            break;
    }
    return $color;
}


?>
<script>

    $(document).ready(function(){

        $("button").click(function(event){

            //	WHAT BUTTON ARE WE TOUCHING
            var myButton = $(this).attr('id');

            //	WHOSE BUTTON ARE WE TOUCHING
            var myRow = document.getElementById("row" + myButton.substring(6));
            var myLine = document.getElementById("line" + myButton.substring(6));

            if(myRow.className == "hiddenRow")
            {
                myRow.className = "shownRow";
                myLine.className = "shownline";
                document.getElementById($(this).attr('id')).innerHTML = "Hide Details";
            }
            else if(myRow.className == "shownRow")
            {
                myRow.className = "hiddenRow";
                myLine.className = "hiddenline";
                document.getElementById($(this).attr('id')).innerHTML = "Show Details";
            }

        });

    });

</script>