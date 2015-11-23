<?php
 ini_set('display_errors', 'On');
 error_reporting(E_ALL | E_STRICT);
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');
include('../functions/editfunctions.php');

	$gets = "?part=".$_POST['part']."&id=".$_POST['id'];

	header("Location: summarypic.php".$gets);

if(isset($_POST['submit']) && $_FILES['pic']['size'] > 0 && $_POST['user'] != ""){

	addcomment($_POST['part'],$_POST['id'], $_FILES['pic']['name']." added by ".$_POST['user'], $_POST['user']);
	addpic($_FILES['pic']['name'], $_FILES['pic']['tmp_name'], $_POST['part'], $_POST['id'], $_POST['notes']);
	exit();
}

?>
