<?php
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');

	$gets = "?";

	header("Location: batchrocsubmit.php".$gets);

if(isset($_POST['submit']) && isset($_POST['user']) && $_FILES['txt']['size'] > 0){

	batchroc($_FILES['txt']['tmp_name'],$_FILES['txt']['name'],$_FILES['txt']['size'],$_POST['location'], $_POST['user'], $_POST['notes']);

}
?>
