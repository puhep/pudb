<?php
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');

if(isset($_POST['submit']) && isset($_POST['user']) && $_FILES['txt']['size'] > 0){

	batchroc($_FILES['txt']['tmp_name'],$_FILES['txt']['name'],$_FILES['txt']['size'],$_POST['location'], $_POST['user'], $_POST['notes']);

	$gets = "?code=1";
	
	header("Location: batchrocsubmit.php".$gets);
}
else{
	$gets = "?code=2";

	header("Location: batchrocsubmit.php".$gets);
}
?>
