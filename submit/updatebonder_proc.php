<?php
include('../functions/submitfunctions.php');
include('../functions/curfunctions.php');
include('../functions/editfunctions.php');
include('../functions/popfunctions.php');

	$id = findid("module_p", $_POST['name']);
	$gets = "?name=".findname("module_p",$id);

	header("Location: updatebonder.php".$gets);


if(isset($_POST['submit']) && $_POST['newbonder']!="" && isset($_POST['user'])){

	changebonder($id, $_POST['newbonder'], $_POST['notes'], $_POST['user']);

	$newbondernote = "Module bonder set to ".$_POST['newbonder']." by ".$_POST['user'];
	echo $newbondernote;
	exit();
}
?>
