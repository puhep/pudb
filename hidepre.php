<?php
	session_start();
	if($_SESSION['hidepre']){$_SESSION['hidepre']=FALSE;}
	else{$_SESSION['hidepre'] = TRUE;}

	header("Location: index.php");
	exit();

?>
