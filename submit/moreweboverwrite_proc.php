<?php
include('../functions/submitfunctions.php');
include('../functions/curfunctions.php');

	$gets = "?name=".$_POST['name'];

	header("Location: ../summary/summaryFull.php".$gets);

if(isset($_POST['submit'])){

	$id = findid("module_p", $_POST['name']);

	moreweb2database($id, $_POST['link']);

	exit();
}
?>
