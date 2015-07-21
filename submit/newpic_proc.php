<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include('../functions/editfunctions.php');
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');
	
	$gets = "?part=".$_POST['part']."&id=".$_POST['id'];

	header("Location: newpic.php".$gets);

	
	if (isset($_POST['submit']) && isset($_FILES['pic']['size'])){
		addpic($_FILES['pic']['name'], $_FILES['pic']['tmp_name'], $_POST['part'], $_POST['id'], $_POST['notes']);
	}
?>
