<?php // messages.php
include_once 'header.php';
if (!$loggedin) die();
if (isset($_GET['view'])){ $view = sanitizeString($conn,$_GET['view']);}
else
$view = $user;
if (isset($_POST['text']))
{
$text = sanitizeString($conn,$_POST['text']);

if ($text != "")
{
$pm= substr(sanitizeString($conn,$_POST['pm']),0,1);
$time = time();
queryMysql($conn,"INSERT INTO `messages` VALUES(NULL, '$user',
'$view', '$pm', $time, '$text')");
}
}
if ($view != "")
{
	if ($view == $user) $name1 = $name2 = "Your";
	else
	{
	$name1 = "<a href='members.php?view=$view'>$view</a>'s";
	$name2 = $view;
	}
	echo "<div class='main'><h3> $name1 Messages</h3>";
	showProfile($conn,$view,$fname);
	
	echo "</div>".
	"<div class='right_panel' ><form method='post' action='messages.php?view=$view'>
	Type here to leave a message:<br />
	<textarea name='text' cols='40' rows='3'></textarea><br />
	Public<input type='radio' name='pm' value='0' checked='checked' />";
	if($view!=$user)
	echo "Private<input type='radio' name='pm' value='1' />";
	echo "<input type='submit' class='button' value='Post Message' /></form><br />";
	
	if (isset($_GET['erase']))
	{
		$erase = sanitizeString($conn,$_GET['erase']);
		queryMysql($conn,"DELETE FROM `messages` WHERE `id`=$erase AND `recip`='$user'");
	}
	$query = "SELECT * FROM `messages` WHERE recip='$view' OR auth='$view' ORDER BY `time` DESC";
	$result = queryMysql($conn,$query);
	$num= $result->num_rows;
	for ($j = 0 ; $j < $num ; ++$j)
	{
		$row = mysqli_fetch_row($result);
		if ($user==$view)
		{
		echo date('M jS \'y g:ia:', $row[4]);
		echo " <a href='messages.php?view=$row[1]'>$row[1]</a> ";
		if($row[3]==0)
			echo "wrote: &quot;$row[5]&quot; ";
		else
			echo "whispered: <span class='whisper'> &quot;$row[5]&quot;</span> ";
		if($row[2]!=$user)
			echo "to:$row[2]";
		echo "[<a href='messages.php?view=$view"."&erase=$row[0]'>erase</a>]";
		echo "<br/>";
		}
		else {
			if($row[3]==0){
				echo date('M jS \'y g:ia:', $row[4]);
				echo " <a href='messages.php?view=$row[1]'>$row[1]</a> ";
				echo "wrote: &quot;$row[5]&quot; ";
				if($row[2]!=$user)
					echo "to:$row[2]";
				if($row[1]==$user)
					echo "[<a href='messages.php?view=$view&erase=$row[0]'>erase</a>]";
				echo "<br/>";
			}
			else{
				if($row[1]==$user){
					echo date('M jS \'y g:ia:', $row[4]);
					echo " <a href='messages.php?view=$row[1]'>$row[1]</a> ";
					if($row[3]==0)
						echo "wrote: &quot;$row[5]&quot; ";
					else
						echo "whispered: <span class='whisper'> &quot;$row[5]&quot;</span> ";
					echo "to:$row[2]";
					echo "[<a href='messages.php?view=$view" .
					"&erase=$row[0]'>erase</a>]";
					echo "<br/>";
				}
			}
		}
	}
}
echo "<br />";
if (!$num) echo "<br /><span class='info'>No messages yet</span><br /><br />";
echo "<br /><a  href='messages.php?view=$view'> <Button class='button'>Refresh messages  </Button></a>".
"<a href='friends.php?view=$view'><Button class='button' >View $name2 friends </Button></a>";
?>
</div><br /></body></html>