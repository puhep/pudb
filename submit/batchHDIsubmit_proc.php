<?php
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');

if(isset($_POST['submit']) && $_POST['user'] != "" && $_POST['arrival'] != "" && $_FILES['txt']['size'] > 0){

	batchHDI($_FILES['txt']['tmp_name'],$_FILES['txt']['name'],$_FILES['txt']['size'],$_POST['location'], $_POST['user'], $_POST['notes'], $_POST['arrival']);

	$gets = "?code=1";
	
	header("Location: batchHDIsubmit.php".$gets);
}
else{
	$gets = "?code=2";

	header("Location: batchHDIsubmit.php".$gets);
}
?>
