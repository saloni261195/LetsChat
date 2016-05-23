<?php

session_start();
echo "<!DOCTYPE html>\n <html> <head> <script src='OSC.js'> </script>";
include 'functions.php';
$userstr="(Guest)";
if (isset($_SESSION['user'])) {
	$user=$_SESSION['user'];
	$fname=$_SESSION['fname'];
	$loggedin=true;
	$userstr=": $fname";
}
else
	$loggedin=false;

echo "<title>" .$appname.$userstr ."</title> <link rel='stylesheet' href='style.css' type='text/css'/>".
"</head> <body> <div class='appname'>".$appname. " ".$userstr."  <a href='members.php'> <span style='color:#00a9ec;' id='member'> <img src='icons/member.png' > Add Friends </span> </a></div>";

if ($loggedin) {
	echo "<br> <ul class='menu'>".
		"<li> <a href='members.php?view=$user'> <img src='icons/home.png'> </a></li>".
		"<li> <a href='profile.php'> <img src='icons/profile.png'></a></li>".
		"<li  style='float:right;'> <a href='friends.php'> <img src='icons/friends.png' </a></li>".
		"<li  style='float:right;'> <a href='messages.php?view=$user'> <img src='icons/messages.png' </a></li>".
		"<li  style='float:right;'> <a href='logout.php'><img src='icons/logout.png'> </a></li> </ul> <br/>";
}
else
{
	echo "<br> <ul class='menu'>".
		"<li> <a href='index.php'> <img src='icons/home.png'> </a></li>".
		"<li> <a href='signup.php'> Sign Up </a></li>".
		"<li> <a href='login.php'> Login </a></li> </ul> <br/>".
		"<span class='info'>You must be logged in to view this page. </span> <br/><br/>";
}
?>