<?php // profile.php
include_once 'header.php';
if (!$loggedin) die();
echo "<div class='main'><h3>Your Profile</h3>";
if (isset($_POST['text']))
{
	$text = sanitizeString($conn,$_POST['text']);
	$text = preg_replace('/\s\s+/', ' ', $text);
	if ((queryMysql($conn,"SELECT * FROM `profiles` WHERE `user`='$user'"))->num_rows)
		queryMysql($conn,"UPDATE `profiles` SET `text`='$text' where `user`='$user'");
	else 
		queryMysql($conn,"INSERT INTO `profiles` VALUES(NULL,'$user', '$text')");
}
else
{
	$result = queryMysql($conn,"SELECT * FROM `profiles` WHERE `user`='$user'");

	if ($result->num_rows)
	{
	$row = mysqli_fetch_row($result);
	$text = stripslashes($row[1]);
	}
	else $text = "";
}
$text = stripslashes(preg_replace('/\s\s+/', ' ', $text));

if (isset($_FILES['image']['name'])){
	$saveto = "$user.jpg";
	move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
	$typeok = TRUE;
	switch($_FILES['image']['type'])
	{
	case "image/gif": $src = imagecreatefromgif($saveto); break;
	case "image/jpeg": // Allow both regular and progressive jpegs
	case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
	case "image/png": $src = imagecreatefrompng($saveto); break;
	default: $typeok = FALSE; break;
	}

	if ($typeok)
	{
	list($w, $h) = getimagesize($saveto);
	$max = 100;
	$tw = $w;
	$th = $h;
		if ($w > $h && $max < $w)
		{
		$th = $max / $w * $h;
		$tw = $max;
		}
		elseif ($h > $w && $max < $h)
		{
		$tw = $max / $h * $w;
		$th = $max;
		}
		elseif ($max < $w)
		{
		$tw = $th = $max;
		}
		$tmp = imagecreatetruecolor($tw, $th);
		imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
		imageconvolution($tmp, array(array('−1', '−1', '−1'),array('−1', '16', '−1'), array('−1', '−1', '−1')), '8', '0');
		imagejpeg($tmp, $saveto);
		imagedestroy($tmp);
		imagedestroy($src);
	}
}

showProfile($conn,$user,$fname);
echo <<<_END
</div>
<div class='right_panel'>
<form method='post' action='profile.php' enctype='multipart/form-data'>
<h3>Enter or edit your details and/or upload an image</h3>
<textarea name='text' cols='50' rows='3'>$text</textarea><br />
_END;
?>
Image: <input type='file' name='image' size='14' maxlength='32' />
<input type='submit' value='Save Profile' />
</form></div><br /></body></html>