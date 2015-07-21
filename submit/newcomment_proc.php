<?php
include('../functions/editfunctions.php');
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');

	$gets = "?part=".$_POST['part']."&id=".$_POST['id'];

	header("Location: newcomment.php".$gets);
	

	if(isset($_POST['submit']) && isset($_POST['notes'])){
		addcomment($_POST['part'],$_POST['id'],$_POST['notes']);
	}
	exit();
?>
