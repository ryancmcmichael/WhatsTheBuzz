<?php
if (!isset($_SESSION['userid'])) {
    header("location:../");
}
?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title><?php echo TITLE; ?>: Graphs</title>
    <link rel="stylesheet" type="text/css" href="<?php echo HOST; ?>bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo HOST; ?>bootstrap/css/landing.css"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
          content="Customer Insight, tagging, mobile, suveys, better business, relationship management">
    <meta name="author" content="John Brenton Phillips">
    <link rel="shortcut icon" href="<?php echo HOST; ?>/favicon.ico">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        #hello-there {
            float: right;
        }
        .shownRow{display:block;border-bottom:2px solid #bababa}
        .hiddenRow{display:none;}
    </style>
</head>

<body>

<div class="container">
    <div class="header">
        <ul class="nav nav-pills pull-right"></ul>

        <h3 class="text-muted"><span id='mast-header'><?php echo TITLE; ?></span>: admin
            <span id='hello-there'><?php echo "Welcome " . $_SESSION['fname']; ?></span>
        </h3>
    </div>


    <?php
    include('admin_nav.php');
    ?>

    <style>

        .container {
            width: 110%;
            margin: 21px auto;
        }

    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/pie.js"></script>

    <br>



	<div style="width:100%;padding:5px;position:relative;clear:both;font-size:1.2em;font-weight:bold;margin:0 auto;">Select the graph you would like to see: 
		<select name="whichGraph" id="barGraphs" style='margin-left:20px;'>
			<option value="graph1">1 Week Graph</option>
			<option value="graph2">1 Month Graph</option>
			<option value="graph3">6 Month Graph</option>
		</select>
		<div style='display:inline-block;'>
			<button class="btn btn-info" id="graphButton" style="margin-left:50px;vertical-align:middle;" role="button">Show Graph!</button>
		</div>
	</div>
	<div class="shownRow" id="barGraph1">
    	<canvas id="chartCanvas" width="1500" height="700"></canvas>
    </div>
    
	<div class="hiddenRow" id="barGraph2">
	    <canvas id="chartCanvas2" width="1500" height="700"></canvas>
    </div>
	<div class="hiddenRow" id="barGraph3">
	    <canvas id="chartCanvas3" width="1500" height="700"></canvas>
    </div>
    
    <br>
    <div class="linechart">
        <br>
        <canvas id="lineChartCanvas" style="padding-bottom:20px;" width="1500" height="700"></canvas>
    </div>

    <!-- DB Setup -->

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

   
    
    $date1wk = date('Y-m-d', strtotime('-7 days'));
    $qualityQuery1wk = $dbh->prepare("SELECT quality FROM responses WHERE dtCreated > '".$date1wk."'");
    $serviceQuery1wk = $dbh->prepare("SELECT service FROM responses WHERE dtCreated > '".$date1wk."'");
    $valueQuery1wk = $dbh->prepare("SELECT value FROM responses WHERE dtCreated > '".$date1wk."'");
    $cleanQuery1wk = $dbh->prepare("SELECT clean FROM responses WHERE dtCreated > '".$date1wk."'");
    $recoQuery1wk = $dbh->prepare("SELECT recommend FROM responses WHERE dtCreated > '".$date1wk."'");
    
    
    // 	bind the parameters
    $qualityQuery1wk->bindValue(":id", $_SESSION['userid']);
    $serviceQuery1wk->bindValue(":id", $_SESSION['userid']);
    $valueQuery1wk->bindValue(":id", $_SESSION['userid']);
    $cleanQuery1wk->bindValue(":id", $_SESSION['userid']);
    $recoQuery1wk->bindValue(":id", $_SESSION['userid']);
    
    if ($qualityQuery1wk->execute() && $serviceQuery1wk->execute() && $valueQuery1wk->execute() && $cleanQuery1wk->execute() && $recoQuery1wk->execute()) {
    
    	$quality1wk = array();
    	$service1wk = array();
    	$value1wk = array();
    	$clean1wk = array();
    	$reco1wk = array();
    
    	$quality1wk = $qualityQuery1wk->fetchAll(PDO::FETCH_ASSOC);
    	$service1wk = $serviceQuery1wk->fetchAll(PDO::FETCH_ASSOC);
    	$value1wk = $valueQuery1wk->fetchAll(PDO::FETCH_ASSOC);
    	$clean1wk = $cleanQuery1wk->fetchAll(PDO::FETCH_ASSOC);
    	$reco1wk = $recoQuery1wk->fetchAll(PDO:: FETCH_ASSOC);
    
    	$qualityArray1wk = json_encode($quality1wk, JSON_FORCE_OBJECT);
    	$serviceArray1wk = json_encode($service1wk, JSON_FORCE_OBJECT);
    	$valueArray1wk = json_encode($value1wk, JSON_FORCE_OBJECT);
    	$cleanArray1wk = json_encode($clean1wk, JSON_FORCE_OBJECT);
    	$recoArray1wk = json_encode($reco1wk, JSON_FORCE_OBJECT);
    
    
    	$qualityCount1wk = 0;
    	$qualitySum1wk = 0;
    
    	foreach ($quality1wk as $qualityObj) {
    
    		$quality_loc_array = (array)$qualityObj;
    		$qualityCount1wk += count($quality_loc_array);
    		$qualitySum1wk += array_sum($quality_loc_array);
    
    	}
    
    	$qualityAverage1wk = $qualitySum1wk / $qualityCount1wk;
    
    
    	$serviceCount1wk = 0;
    	$serviceSum1wk = 0;
    
    	foreach ($service1wk as $serviceObj) {
    
    		$service_loc_array = (array)$serviceObj;
    		$serviceCount1wk += count($service_loc_array);
    		$serviceSum1wk += array_sum($service_loc_array);
    
    
    	}
    
    	$serviceAverage1wk = $serviceSum1wk / $serviceCount1wk;
    
    
    	$cleanCount1wk = 0;
    	$cleanSum1wk = 0;
    
    	foreach ($clean1wk as $cleanObj) {
    
    		$clean_loc_array = (array)$cleanObj;
    		$cleanCount1wk += count($clean_loc_array);
    		$cleanSum1wk += array_sum($clean_loc_array);
    
    
    	}
    
    
    	$cleanAverage1wk = $cleanSum1wk / $cleanCount1wk;
    
    
    	$valueCount1wk = 0;
    	$valueSum1wk = 0;
    
    
    	foreach ($value1wk as $valueObj) {
    
    		$value_loc_array = (array)$valueObj;
    		$valueCount1wk += count($value_loc_array);
    		$valueSum1wk += array_sum($value_loc_array);
    
    	}
    
    
    	$valueAverage1wk = $valueSum1wk / $valueCount1wk;
    
    
    	$recoCount1wk = 0;
    	$recoSum1wk = 0;
    
    
    	foreach ($reco1wk as $recoObj) {
    
    
    		$reco_loc_array = (array)$recoObj;
    		$recoCount1wk += count($reco_loc_array);
    		$recoSum1wk += array_sum($reco_loc_array);
    	}
    
    	$recoAverage1wk = $recoSum1wk / $recoCount1wk;
    
    
    }
    
    $date1mth = date('Y-m-d', strtotime('-30 days'));
    $qualityQuery1mth = $dbh->prepare("SELECT quality FROM responses WHERE dtCreated > '".$date1mth."'");
    $serviceQuery1mth = $dbh->prepare("SELECT service FROM responses WHERE dtCreated > '".$date1mth."'");
    $valueQuery1mth = $dbh->prepare("SELECT value FROM responses WHERE dtCreated > '".$date1mth."'");
    $cleanQuery1mth = $dbh->prepare("SELECT clean FROM responses WHERE dtCreated > '".$date1mth."'");
    $recoQuery1mth = $dbh->prepare("SELECT recommend FROM responses WHERE dtCreated > '".$date1mth."'");
    
    
    // 	bind the parameters
    $qualityQuery1mth->bindValue(":id", $_SESSION['userid']);
    $serviceQuery1mth->bindValue(":id", $_SESSION['userid']);
    $valueQuery1mth->bindValue(":id", $_SESSION['userid']);
    $cleanQuery1mth->bindValue(":id", $_SESSION['userid']);
    $recoQuery1mth->bindValue(":id", $_SESSION['userid']);
    
    if ($qualityQuery1mth->execute() && $serviceQuery1mth->execute() && $valueQuery1mth->execute() && $cleanQuery1mth->execute() && $recoQuery1mth->execute()) {
    
    	$quality1mth = array();
    	$service1mth = array();
    	$value1mth = array();
    	$clean1mth = array();
    	$reco1mth = array();
    
    	$quality1mth = $qualityQuery1mth->fetchAll(PDO::FETCH_ASSOC);
    	$service1mth = $serviceQuery1mth->fetchAll(PDO::FETCH_ASSOC);
    	$value1mth = $valueQuery1mth->fetchAll(PDO::FETCH_ASSOC);
    	$clean1mth = $cleanQuery1mth->fetchAll(PDO::FETCH_ASSOC);
    	$reco1mth = $recoQuery1mth->fetchAll(PDO:: FETCH_ASSOC);
    
    	$qualityArray1mth = json_encode($quality1mth, JSON_FORCE_OBJECT);
    	$serviceArray1mth = json_encode($service1mth, JSON_FORCE_OBJECT);
    	$valueArray1mth = json_encode($value1mth, JSON_FORCE_OBJECT);
    	$cleanArray1mth = json_encode($clean1mth, JSON_FORCE_OBJECT);
    	$recoArray1mth = json_encode($reco1mth, JSON_FORCE_OBJECT);
    
    
    	$qualityCount1mth = 0;
    	$qualitySum1mth = 0;
    
    	foreach ($quality1mth as $qualityObj) {
    
    		$quality_loc_array = (array)$qualityObj;
    		$qualityCount1mth += count($quality_loc_array);
    		$qualitySum1mth += array_sum($quality_loc_array);
    
    	}
    
    	$qualityAverage1mth = $qualitySum1mth / $qualityCount1mth;
    
    
    	$serviceCount1mth = 0;
    	$serviceSum1mth = 0;
    
    	foreach ($service1mth as $serviceObj) {
    
    		$service_loc_array = (array)$serviceObj;
    		$serviceCount1mth += count($service_loc_array);
    		$serviceSum1mth += array_sum($service_loc_array);
    
    
    	}
    
    	$serviceAverage1mth = $serviceSum1mth / $serviceCount1mth;
    
    
    	$cleanCount1mth = 0;
    	$cleanSum1mth = 0;
    
    	foreach ($clean1mth as $cleanObj) {
    
    		$clean_loc_array = (array)$cleanObj;
    		$cleanCount1mth += count($clean_loc_array);
    		$cleanSum1mth += array_sum($clean_loc_array);
    
    
    	}
    
    
    	$cleanAverage1mth = $cleanSum1mth / $cleanCount1mth;
    
    
    	$valueCount1mth = 0;
    	$valueSum1mth = 0;
    
    
    	foreach ($value1mth as $valueObj) {
    
    		$value_loc_array = (array)$valueObj;
    		$valueCount1mth += count($value_loc_array);
    		$valueSum1mth += array_sum($value_loc_array);
    
    	}
    
    
    	$valueAverage1mth = $valueSum1mth / $valueCount1mth;
    
    
    	$recoCount1mth = 0;
    	$recoSum1mth = 0;
    
    
    	foreach ($reco1mth as $recoObj) {
    
    
    		$reco_loc_array = (array)$recoObj;
    		$recoCount1mth += count($reco_loc_array);
    		$recoSum1mth += array_sum($reco_loc_array);
    	}
    
    	$recoAverage1mth = $recoSum1mth / $recoCount1mth;
    
    
    }

    $date6mth = date('Y-m-d', strtotime('-180 days'));
    $qualityQuery6mth = $dbh->prepare("SELECT quality FROM responses WHERE dtCreated > '".$date6mth."'");
    $serviceQuery6mth = $dbh->prepare("SELECT service FROM responses WHERE dtCreated > '".$date6mth."'");
    $valueQuery6mth = $dbh->prepare("SELECT value FROM responses WHERE dtCreated > '".$date6mth."'");
    $cleanQuery6mth = $dbh->prepare("SELECT clean FROM responses WHERE dtCreated > '".$date6mth."'");
    $recoQuery6mth = $dbh->prepare("SELECT recommend FROM responses WHERE dtCreated > '".$date6mth."'");
    
    
    // 	bind the parameters
    $qualityQuery6mth->bindValue(":id", $_SESSION['userid']);
    $serviceQuery6mth->bindValue(":id", $_SESSION['userid']);
    $valueQuery6mth->bindValue(":id", $_SESSION['userid']);
    $cleanQuery6mth->bindValue(":id", $_SESSION['userid']);
    $recoQuery6mth->bindValue(":id", $_SESSION['userid']);
    
    if ($qualityQuery6mth->execute() && $serviceQuery6mth->execute() && $valueQuery6mth->execute() && $cleanQuery6mth->execute() && $recoQuery6mth->execute()) {
    
    	$quality6mth = array();
    	$service6mth = array();
    	$value6mth = array();
    	$clean6mth = array();
    	$reco6mth = array();
    
    	$quality6mth = $qualityQuery6mth->fetchAll(PDO::FETCH_ASSOC);
    	$service6mth = $serviceQuery6mth->fetchAll(PDO::FETCH_ASSOC);
    	$value6mth = $valueQuery6mth->fetchAll(PDO::FETCH_ASSOC);
    	$clean6mth = $cleanQuery6mth->fetchAll(PDO::FETCH_ASSOC);
    	$reco6mth = $recoQuery6mth->fetchAll(PDO:: FETCH_ASSOC);
    
    	$qualityArray6mth = json_encode($quality6mth, JSON_FORCE_OBJECT);
    	$serviceArray6mth = json_encode($service6mth, JSON_FORCE_OBJECT);
    	$valueArray6mth = json_encode($value6mth, JSON_FORCE_OBJECT);
    	$cleanArray6mth = json_encode($clean6mth, JSON_FORCE_OBJECT);
    	$recoArray6mth = json_encode($reco6mth, JSON_FORCE_OBJECT);
    
    
    	$qualityCount6mth = 0;
    	$qualitySum6mth = 0;
    
    	foreach ($quality6mth as $qualityObj) {
    
    		$quality_loc_array = (array)$qualityObj;
    		$qualityCount6mth += count($quality_loc_array);
    		$qualitySum6mth += array_sum($quality_loc_array);
    
    	}
    
    	$qualityAverage6mth = $qualitySum6mth / $qualityCount6mth;
    
    
    	$serviceCount6mth = 0;
    	$serviceSum6mth = 0;
    
    	foreach ($service6mth as $serviceObj) {
    
    		$service_loc_array = (array)$serviceObj;
    		$serviceCount6mth += count($service_loc_array);
    		$serviceSum6mth += array_sum($service_loc_array);
    
    
    	}
    
    	$serviceAverage6mth = $serviceSum6mth / $serviceCount6mth;
    
    
    	$cleanCount6mth = 0;
    	$cleanSum6mth = 0;
    
    	foreach ($clean6mth as $cleanObj) {
    
    		$clean_loc_array = (array)$cleanObj;
    		$cleanCount6mth += count($clean_loc_array);
    		$cleanSum6mth += array_sum($clean_loc_array);
    
    
    	}
    
    
    	$cleanAverage6mth = $cleanSum6mth / $cleanCount6mth;
    
    
    	$valueCount6mth = 0;
    	$valueSum6mth = 0;
    
    
    	foreach ($value6mth as $valueObj) {
    
    		$value_loc_array = (array)$valueObj;
    		$valueCount6mth += count($value_loc_array);
    		$valueSum6mth += array_sum($value_loc_array);
    
    	}
    
    
    	$valueAverage6mth = $valueSum6mth / $valueCount6mth;
   
    
    	$recoCount6mth = 0;
    	$recoSum6mth = 0;
    
    
    	foreach ($reco6mth as $recoObj) {
    
    
    		$reco_loc_array = (array)$recoObj;
    		$recoCount6mth += count($reco_loc_array);
    		$recoSum6mth += array_sum($reco_loc_array);
    	}
    
    	$recoAverage6mth = $recoSum6mth / $recoCount6mth;
    
    }
    
    $avg1 = ($recoAverage1wk + $qualityAverage1wk + $cleanAverage1wk + $serviceAverage1wk + $valueAverage1wk) / 5;
    $avg2 = ($recoAverage1mth + $qualityAverage1mth + $cleanAverage1mth + $serviceAverage1mth + $valueAverage1mth) / 5;
    $avg6 = ($recoAverage6mth + $qualityAverage6mth + $cleanAverage6mth + $serviceAverage6mth + $valueAverage6mth) / 5;
    $avg3 = ($avg1 + $avg2) / 2;
    $avg4 = ($avg1 + $avg2) / 2;
    $avg5 = ($avg4 + $avg6) / 2;
    
    ?>
    
      <div class="navbar navbar-fixed-bottom survey-footer" >
        <p><?php echo COPY;?> | <a href="../../logout">logout</a></p>
      </div>
    


    <script>

    $(document).ready(function(){

        $("#graphButton").click(function(event){

        	var graphName = document.getElementById("barGraphs");
        	var myGraph = graphName.options[graphName.selectedIndex].value

            switch(myGraph){
                case 'graph1':
                	$("#barGraph2").fadeOut(500);
                	$("#barGraph3").fadeOut(500);
                	$("#barGraph1").delay(400).fadeIn(500);
                    break;
                case 'graph2':
                	$("#barGraph1").fadeOut(500);
                	$("#barGraph3").fadeOut(500);
                	$("#barGraph2").delay(400).fadeIn(500);
                    break;
                case 'graph3':
                	$("#barGraph1").fadeOut(500);
                	$("#barGraph2").fadeOut(500);
                	$("#barGraph3").delay(400).fadeIn(500);
                    break;
            }

        });
    });


        function getColorArray(data) {
            var colors = [];
            for (var i = 0; i < data.length; i++) {

                if (data[i] >= 4) {
                    colors.push('#66ff00');

                }
                else if (data[i] >= 3) {
                    colors.push('#ccff00');

                }
                else if (data[i] >= 2) {
                    colors.push('#ffcc00');

                }
                else if (data[i] > 1) {
                    colors.push('#ff9900');

                }
                else if (data[i] == 1) {
                    colors.push('#ff0000');

                }


            }

            return colors;
        }

        var ctx = document.getElementById("chartCanvas");
        var data = [<?php echo($qualityAverage1wk)?>, <?php echo($serviceAverage1wk)?>, <?php echo($valueAverage1wk)?>, <?php echo($cleanAverage1wk)?>, <?php echo($recoAverage1wk)?>];
        var backgroundColors = getColorArray(data);

        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Quality", "Service", "Value", "Cleanliness", "Recommendation"],
                datasets: [{
                    data: data,
                    backgroundColor: backgroundColors
                }]
            },
            options: {
                legend: {
                    display: false
                 },
                 
                title: {

                    text: "7 Day Averages for Individual Metrics",
                    display: true,
                },

                scales: {
                    xAxes: [{
                        gridLines: {
                            display: true
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


    </script>
    <script>
    
            var ctx = document.getElementById("chartCanvas2");
        var data = [<?php echo($qualityAverage1mth)?>, <?php echo($serviceAverage1mth)?>, <?php echo($valueAverage1mth)?>, <?php echo($cleanAverage1mth)?>, <?php echo($recoAverage1mth)?>];
        var backgroundColors = getColorArray(data);

        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Quality", "Service", "Value", "Cleanliness", "Recommendation"],
                datasets: [{
                    data: data,
                    backgroundColor: backgroundColors
                }]
            },
            options: {
                legend: {
                    display: false
                 },
                 
                title: {

                    text: "30 Day Averages for Individual Metrics",
                    display: true,
                },

                scales: {
                    xAxes: [{
                        gridLines: {
                            display: true
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


    </script>
    <script>
    
        	var ctx = document.getElementById("chartCanvas3");
        var data = [<?php echo($qualityAverage6mth)?>, <?php echo($serviceAverage6mth)?>, <?php echo($valueAverage6mth)?>, <?php echo($cleanAverage6mth)?>, <?php echo($recoAverage6mth)?>];
        var backgroundColors = getColorArray(data);

        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Quality", "Service", "Value", "Cleanliness", "Recommendation"],
                datasets: [{
                    data: data,
                    backgroundColor: backgroundColors
                }]
            },
            options: {
                legend: {
                    display: false
                 },
                 
                title: {

                    text: "6 Month Averages for Individual Metrics",
                    display: true,
                },

                scales: {
                    xAxes: [{
                        gridLines: {
                            display: true
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


    </script>

    <script>


        var lineChartData = {
            labels: ["02/17", "03/03", "03/17", "03/31", "04/13", "04/27"],
            datasets: [{

                fill: true,
                lineTension: 0.1,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,

                data: [<?php echo($avg1)?>, <?php echo($avg2)?>, <?php echo($avg3)?>, <?php echo($avg4)?>, <?php echo($avg5)?>, <?php echo($avg6)?>]
            }]


        }

        var ctx2 = document.getElementById("lineChartCanvas").getContext("2d");
        var LineChartDemo = new Chart(ctx2, {


            type: 'line',
            data: lineChartData,
            options: {
                legend: {
                    display: false
                 },
                 
                 title: {

                    text: "Overall Satisfaction Trend",
                    display: true
                },

                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0

                        }

                    }]

                }
            },
            pointDotRadius: 10,
            bezierCurve: false,
            scaleShowVerticalLines: false,
            scaleGridLineColor: "black"


        });

    </script>

    
    