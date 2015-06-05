<?php
include('../functions/submitfunctions.php');

	$gets = "?";

	header("Location: batchmeassubmit.php".$gets);

if(isset($_POST['submit']) &&  $_FILES['zipped']['size'] > 0 && isset($_POST['level'])){
	batchmeasurement($_FILES['zipped']['tmp_name'],$_FILES['zipped']['name'],$_FILES['zipped']['size'], $_POST['level'],$_POST['notes']);

	exit();
}
?>
