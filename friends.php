<?php // friends.php
include_once 'header.php';
if (!$loggedin) die();
if (isset($_GET['view'])) $view = sanitizeString($conn,$_GET['view']);
else
$view = $user;
if ($view ==$user)
{
$name1 =$name2 = "Your";
$name3 ="You are";
}
else
{
$name1 ="<a href='members.php?view=$view'>$view</a>'s";
$name2 ="$view's";
$name3 ="$view is";
}
echo "<div class='main'>";

$followers = array();
$following = array();
$result = queryMysql($conn,"SELECT * FROM `friends` WHERE `user`='$view'");
$num= $result->num_rows;
for ($j = 0 ; $j < $num ; ++$j)
{
$row= mysqli_fetch_row($result);
$followers[$j] = $row[2];
}
$result = queryMysql($conn,"SELECT * FROM `friends` WHERE `friend`='$view'");
$num= $result->num_rows;
for ($j = 0 ; $j < $num ; ++$j)
{
$row= mysqli_fetch_row($result);
$following[$j] = $row[1];
}
$mutual=array_intersect($followers, $following);
$followers=array_diff($followers, $mutual);
$following=array_diff($following, $mutual);
$friends=FALSE;

if (sizeof($mutual))
{
echo "<span class='subhead'>$name2 friends</span><ul>";
foreach($mutual as $friend)
echo "<li><a href='members.php?view=$friend'>$friend</a>";
echo "</ul>";
$friends = TRUE;
}
if (sizeof($followers))
{
	echo "<span class='subhead'>$name2 followers</span><ul>";
	foreach($followers as $friend)
	echo "<li><a href='members.php?view=$friend'>$friend</a>";
	echo "</ul>";
	$friends = TRUE;
}
if (sizeof($following))
{
	echo "<span class='subhead'>$name3 following</span><ul>";
	foreach($following as $friend)
	echo "<li><a href='members.php?view=$friend'>$friend</a>";
	echo "</ul>";
	$friends = TRUE;
}
if (!$friends) echo "<br />You don't have any friends yet.<br /><br />";
	echo "<a  href='messages.php?view=$view'>" ."<Button class='button'> View $name2 messages </Button></a>";
?>
</div><br /></body></html>
