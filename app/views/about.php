<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title><?php echo TITLE;?>: About</title>
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
   	.about{font-size:1.2em;color:#222; text-align:justify;} 
	.about b{color:#00a8cc};
	.about em{color:#000000};
	.about p{margin-bottom:24px;}
	.about li{margin-bottom:20px;}
	.about li b{color:#f02979;}
	.demolink{color:#00a8cc;text-decoration:underline;}
	.catch{font-size:1.6em; color:#545454;}
   </style>
  </head>

  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <?php 
			$page = "about";
			require("inc/nav.php");
		?>
        </ul>
        	<?php
			require("inc/logo.php");
		?>
      </div>

      <div class="row marketing about">
	 <p class='catch'>Designed to collect feedback and drive retention through a combined Survey and Coupon Delivery platform...</p></br>
		<p><b>Customer Feedback is a priceless asset for any company.</b> With it, owners shape the strategy of their business by having a better understanding of what customers want and need - as well as what they value about the products and services being offered. Customer insight guides a business into being more responsive, more competitive, and, ultimately, more profitable over time.</p> 
<p><b>Collecting and – more importantly – leveraging customer feedback can be a challenge.</b> Many businesses don’t have the tools, time, or resources to maintain a formal feedback loop with their clients. They often rely on the occassional complaint or return which usually involves a specific situation that doesn’t tell the bigger picture. For those who attempt to collect feedback more proactively, the process is often inconsistent, and the tools inadequate. Any information collected is useful, but it is often not quantifiable and therefore cannot be measured or trended over time.</p>
<p><b>WhatsThe.Buzz is designed to address these challenges</b> by streamlining the collection and analysis of customer feedback about your business.  Most importantly, it provides you as a business owner with a means of quantifying and trending your data over time to see how well your business is improving. The following describes its key benefits:</p>
<ul> 
<li><b>It is web-based.</b> As a web-based platform, the collection of feedback is centralized online and the survey can be accessed by your customers via any device (mobile, desktop, laptop, or tablet computer).</li>

<li>
<img src='https://whatsthe.buzz/img/wtb-QR-image.png' style='width:124px;height:124px;float:right;display:inline-block;margin:5px;padding-left:12px;'>
<b>It is Easy to Get Started.</b> Your survey will be published to a custom URL, such as <em class='demolink'> https://WhatsThe.Buzz/for/YourBusinessHere</em> which can be accessed directly over the web or directly through the whatsthe.buzz homepage via survey code. You also have the option of publishing QR codes like this one here that customers can tag with their mobile phone to reach the survey directly and in real-time.</li> 

<li><b>It is Easy to Take.</b> The survey takes about 2 minutes to complete and consists of 8 questions designed to measure your customer’s perception of service, quality, cleanliness, and value. It also asks a question to indicate level of loyalty which becomes extremely valuable as more surveys are submitted.</li> 

<li><b>It is Easy to Analyze.</b> Business owners are given a secure login to access reports. See summaries of responses, averages of responses, and overall loyalty across respondents.</li> 

<li><b>It is Responsive.</b> Email alerts are sent to business owners when a survey is submitted. Likewise, a thank you email is sent to the respondent (if an email address is provided) with tailored language based on an average of scores submitted (good, bad, ugly).</li>

<li><b>It Promotes Retention and Repeat Business.</b> When an email address is provided by the respondent, a survey is attached that can be used on their next visit. They survey is encoded with a unique tracking number and an expiration date set for 90 days after the survey is taken. The coupon design and expiration window is entirely up to you.</li>
</ul>
</div><!-- end about -->
      

      <div class="navbar survey-footer" >
	 <?php 
	 	require("inc/footernav.php");
	 ?>
      </div>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="<?php echo HOST;?>js/pubnav.js"></script>

</body>
</html>