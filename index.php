<?php
require 'header.php';
echo "<br/> <span class='main'> Welcome to the LET'S CHAT,";
if ($loggedin) {
echo $user." You are logged in.";
}
else{
	echo "Please sign up and/or login to join.";
}
?>
</span><br/> <br/>
</body>
</html>