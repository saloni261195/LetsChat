<?php
$dbhost='localhost';
$user='root';
$appname='Lets Chat';
$pass='';
$database='login';

$conn=mysqli_connect($dbhost,$user,$pass) or die(mysqli_error());
mysqli_select_db($conn,$database) or die(mysqli_error());

function createTable($conn,$name,$query){
	queryMySql($conn,"CREATE TABLE IF NOT EXISTS $name($query)");
	echo "Table ".$name. " created or already exists.<br/>";
}
function queryMySql($conn,$query){
	$result=mysqli_query($conn,$query) or die(mysqli_error($conn));
	return $result;
}
function destroySession(){
	$_SESSION=array();
	if (session_id()!=""||isset($_COOKIE[session_name()])){
		setcookie(session_name(),'',time()-2592000,'/');
	session_destroy();
	}
}

function sanitizeString($conn,$var){
	$var=strip_tags($var);
	$var=htmlentities($var);
	$var=stripslashes($var);
	return mysqli_real_escape_string($conn,$var);
}

function showProfile($conn,$user){
	if (file_exists($user.".jpg")) {
		echo "<img src= $user.jpg id='profile'/> <br/>";
	}
	$result=queryMySql($conn,"SELECT * FROM `profiles` WHERE `user`='$user'");
	if ($result->num_rows) {
		$row=mysqli_fetch_row($result);
		echo "<span id='blue' > ".$user."</span> <br/>";
		echo "<span id='pink'>".stripslashes($row[2])."</span><br/>";
	}
	
}
?>
