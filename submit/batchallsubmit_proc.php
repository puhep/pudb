<?php
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');

	$gets = "?";

	header("Location: batchallsubmit.php".$gets);

if(isset($_POST['submit']) && $_POST['user'] != "" && $_FILES['zip']['size'] > 0){

	bigbatch($_FILES['zip']['tmp_name'],$_FILES['zip']['name'],$_FILES['zip']['size'], $_POST['user']);

	exit();

}
?>
