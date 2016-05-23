<?php 
include_once 'header.php';
if (!$loggedin) die();
echo "<div class='main'>";
if (isset($_GET['view']))
{
	$view = sanitizeString($conn,$_GET['view']);
	if ($view == $user) $name = "Your";
	else
	$name = "$view's";

echo "<h3>$name Profile</h3>";
showProfile($conn,$view);
echo "<br/><a  href='messages.php?view=$view'>" .
"<Button class='button'>View $name messages</Button></a><br /><br />";
die("</div></body></html>");
}
if (isset($_GET['add']))
{
$add = sanitizeString($conn,$_GET['add']);
if (!(queryMysql($conn,"SELECT * FROM `friends` WHERE `user`='$add' AND `friend`='$user'")->num_rows))
queryMysql($conn,"INSERT INTO `friends` VALUES (NULL,'$add', '$user')");
}
elseif (isset($_GET['remove']))
{
$remove = sanitizeString($_GET['remove']);
queryMysql($conn,"DELETE FROM `friends` WHERE `user`='$remove' AND `friend`='$user'");
}
$result = queryMysql($conn,"SELECT `user` FROM `members` ORDER BY `user`");
$num= $result->num_rows;
echo "<h3>Other Members</h3><ul>";
for ($j = 0 ; $j < $num ; ++$j)
{
	$row = mysqli_fetch_row($result);
	if ($row[0] == $user) continue;
	echo "<li><a href='members.php?view=$row[0]'>$row[0]</a>";
	$follow = "follow";
	$t1 = (queryMysql($conn,"SELECT * FROM `friends` WHERE `user`='$row[0]' AND `friend`='$user'"))->num_rows;
	$t2 = (queryMysql($conn,"SELECT * FROM `friends` WHERE `user`='$user' AND `friend`='$row[0]'"))->num_rows;
	if (($t1 + $t2) > 1) 
		echo " &harr; is a mutual friend";
	elseif ($t1)
		echo " &larr; you are following";
	elseif ($t2)
		{ echo " &rarr; is following you";
		$follow = "recip"; }
	if (!$t1) echo " [<a href='members.php?add=".$row[0]    ."'>$follow</a>]";
	else echo " [<a href='members.php?remove=".$row[0] . "'>drop</a>]";
}
?>
<br /></div></body></html>


