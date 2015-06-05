<?php
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');

	$gets = "?";

	header("Location: batchfulltestsubmit.php".$gets);

if(isset($_POST['submit']) &&  $_FILES['txt']['size'] > 0){
	batchfulltest($_FILES['txt']['tmp_name'],$_FILES['txt']['name'],$_FILES['txt']['size']);

	exit();
}
?>
