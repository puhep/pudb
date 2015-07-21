<?php
include('../functions/submitfunctions.php');

if(isset($_POST['submit']) &&  $_FILES['zipped']['size'] > 0 && isset($_POST['level'])){

	$errcode = 3;

	$errcode = batchmeasurement($_FILES['zipped']['tmp_name'],$_FILES['zipped']['name'],$_FILES['zipped']['size'], $_POST['level'],$_POST['notes']);

	$gets = "?code=".$errcode;

	header("Location: batchmeassubmit.php".$gets);
	
	exit();
}
else{

	$gets = "?code=2";

	header("Location: batchmeassubmit.php".$gets);

}
?>
