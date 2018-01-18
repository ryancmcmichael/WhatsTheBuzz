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
.ohmnav{
	color:#00a8cc;
	text-decoration: none;
	padding-left:6px;
	padding-right:6px;
	cursor:pointer;
}
.nav > li > a:hover,
.nav > li > a:focus {
  text-decoration: none;
  background-color: #545454;
  color:#fff;
  cursor:pointer;
}
	
</style>

<li><a class='ohmnav' id='home'>Home</a></li>
<li><a class='ohmnav' id="addsite">Add Site</a></li>
<li><a class='ohmnav' id="logout">Logout</a></li>