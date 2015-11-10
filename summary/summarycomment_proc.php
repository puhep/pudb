<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include('../functions/editfunctions.php');
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');

	$gets = "?part=".$_POST['part']."&id=".$_POST['id'];

	header("Location: summarycomment.php".$gets);

if (isset($_POST['submit']) && $_POST['notes'] != "" && $_POST['user'] != ""){

	addcomment($_POST['part'],$_POST['id'], $_POST['notes']."&nbsp;&nbsp;&nbsp;&nbsp; --".$_POST['user'], $_POST['user']);
	exit();
}

?>
