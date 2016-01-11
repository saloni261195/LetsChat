<?php

session_start();
echo "<!DOCTYPE html>\n <html> <head> <script src='OSC.js'> </script>";
include 'functions.php';
$userstr="(Guest)";
if (isset($_SESSION['user'])) {
	$user=$_SESSION['user'];
	$loggedin=true;
	$userstr="($user)";
}
else
	$loggedin=false;

echo "<title>" .$appname.$userstr ."</title> <link rel='stylesheet' href='style.css' type='text/css'/>".
"</head> <body> <div class='appname'>".$appname. " ".$userstr."</div>";

if ($loggedin) {
	echo "<br> <ul class='menu'>".
		"<li> <a href='members.php?view=$user'> Home </a></li>".
		"<li> <a href='members.php'> Members </a></li>".
		"<li> <a href='friends.php'> Friends </a></li>".
		"<li> <a href='messages.php?view=$user'> Messages </a></li>".
		"<li> <a href='profile.php'> Edit Profile </a></li>".
		"<li> <a href='logout.php'> Logout </a></li> </ul> <br/>";
}
else
{
	echo "<br> <ul class='menu'>".
		"<li> <a href='index.php'> Home </a></li>".
		"<li> <a href='signup.php'> Sign Up </a></li>".
		"<li> <a href='login.php'> Login </a></li> </ul> <br/>".
		"<span class='info'> &#8658; You must be logged in to view this page. </span> <br/><br/>";
}
?>