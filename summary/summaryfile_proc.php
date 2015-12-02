<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include('../functions/editfunctions.php');
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');

	$gets = "?part=".$_POST['part']."&id=".$_POST['id'];

	header("Location: summaryfile.php".$gets);

if (isset($_POST['submit']) && $_FILES['file']['size']>0 && $_POST['user'] != ""){

	#addcomment($_POST['part'],$_POST['id'], $_FILES['file']['name']." added by ".$_POST['user'], $_POST[user']);
	addconfig($_FILES['file']['name'], $_FILES['file']['tmp_name'],$_POST['part'],$_POST['id']);
	exit();
	
}

?>
