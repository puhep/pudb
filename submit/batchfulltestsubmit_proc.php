<?php
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');


if(isset($_POST['submit']) && $_POST['user'] != "" &&  $_FILES['txt']['size'] > 0){

	$errcode = 4;

	$errcode = batchfulltest($_FILES['txt']['tmp_name'],$_FILES['txt']['name'],$_FILES['txt']['size'], $_POST['user']);

	$gets = "?code=".$errcode;

	header("Location: batchfulltestsubmit.php".$gets);
	
	exit();
}
else{

	$gets = "?code=2";

	header("Location: batchfulltestsubmit.php".$gets);
}
?>
