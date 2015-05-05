<?php

	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$db = $_GET['db'];
	$name = $_GET['name'];

	$function = "SELECT $name FROM $db";

	$output = mysql_query($function, $connection);

	if($output){
		echo "taken";
	}
	else{
		echo "";
	}
?>
