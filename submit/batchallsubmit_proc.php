<?php
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');

if(isset($_POST['submit']) && $_POST['user'] != "" && $_FILES['zip']['size'] > 0){

	$errcode = 4;

	$errcode = bigbatch($_FILES['zip']['tmp_name'],$_FILES['zip']['name'],$_FILES['zip']['size'], $_POST['user']);

	$gets = "?code=".$errcode;

	header("Location: batchallsubmit.php".$gets);
	
	exit();
}
else{

	$gets = "?code=2";

	header("Location: batchallsubmit.php".$gets);

}
?>
