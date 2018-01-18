<?php
if(isset($_SESSION['userid']))
{
	header("location:/admin/");
}
?>
<link href="https://fonts.googleapis.com/css?family=Hammersmith+One" rel="stylesheet">
<style>
.myHeader{
	font-family: 'Hammersmith One', sans-serif;
	}
.pubnav{
	color:#00a8cc;
	text-decoration: none;
	padding-left:6px;
	padding-right:6px;
}
.nav > li > a:hover,
.nav > li > a:focus {
  text-decoration: none;
  background-color: #545454;
  color:#fff;
}
	
</style>

<li><a class='pubnav' id='home'>Home</a></li>
<li><a class='pubnav' id="about">About</a></li>
<li><a class='pubnav' id="subscribe">Subscribe</a></li>
<li><a class="pubnav" id="contact">Contact</a></li>
<li><a class="pubnav" id="signin">Sign In</a></li>