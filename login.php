<?php // login.php
include_once 'header.php';
echo "<div class='main'><h3>Please enter your details to log in</h3>";
$error = $user = $pass =$fname= "";
if (isset($_POST['user']))
{
$user = sanitizeString($conn,$_POST['user']);
$pass = sanitizeString($conn,$_POST['pass']);
	if ($user == "" || $pass == "")
	{
	$error = "All fields are compulsory.<br />";
	}
	else
	{
	$query = "SELECT `user`,`pass`,`fname` FROM `members`
	WHERE `user`='$user' AND `pass`='$pass'";
	}

	if (queryMysql($conn,$query)->num_rows== 0)
	{
	$error = "<span class='error'>Username/Password invalid</span><br /><br />";
	}
	else
	{
	$row = mysqli_fetch_row(queryMysql($conn,$query));
	$_SESSION['user'] = $user;
	$_SESSION['pass'] = $pass;
	$_SESSION['fname']=$row[2];

	die("You are now logged in. Please <a href='members.php?view=$user'>" .
	"click here</a> to continue.<br /><br />");
	}
}
?>
<form method='post' action='login.php'> <?php echo $error; ?>
<span class='fieldname'>Username</span><input type='text' maxlength='16' name='user' value= "<?php echo $user; ?>" /><br />
<span class='fieldname'>Password</span><input type='password' maxlength='16' name='pass'  />

<br />
<span class='fieldname'>&nbsp;</span>
<input type='submit' value='Login' />
</form><br /></div></body></html>