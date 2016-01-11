<?php // signup.php
include_once 'header.php';
echo <<<_END
<div class='main'><h3>Please enter your details to sign up</h3>
_END;
$error = $user = $pass = "";
if (isset($_SESSION['user'])) destroySession();
if (isset($_POST['user']))
{
$user = sanitizeString($_POST['user']);
$pass = sanitizeString($_POST['pass']);

if ($user == "" || $pass == "")
	$error = "All fields are compulsory.<br /><br />";
else
{
	if (mysql_num_rows(queryMysql("SELECT * FROM `members` WHERE `user`='$user'")))
	$error = "That username already exists<br /><br />";
	else
	{
	queryMysql("INSERT INTO `members` VALUES('$user', '$pass')");
	die("<h4>Account created</h4>Please Log in.<br /><br />");
	}
}
}
echo <<<_END
<form method='post' action='signup.php'>$error
<span class='fieldname'>Username</span>
<input type='text' maxlength='16' name='user' value='$user'
onBlur='checkUser(this)'/><span id='info'></span><br />
<span class='fieldname'>Password</span>
<input type='password' maxlength='16' name='pass'/><br />
_END;
?>
<span class='fieldname'>&nbsp;</span>
<input type='submit' value='Sign up' />
</form></div><br /></body></html>