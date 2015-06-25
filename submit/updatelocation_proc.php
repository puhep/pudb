<?php
include('../functions/submitfunctions.php');
include('../functions/curfunctions.php');
include('../functions/editfunctions.php');
include('../functions/popfunctions.php');

	$id = findid("module_p", $_POST['name']);
	$gets = "?name=".findname("module_p",$id);

	header("Location: updatelocation.php".$gets);

if(isset($_POST['submit']) && $_POST['newloc']!="" && isset($_POST['user'])){
	
	changeloc($id, $_POST['newloc'], $_POST['notes'], $_POST['user']);

	$newlocnote = "Module moved to ".$_POST['newloc']." by ".$_POST['user'];
	echo $newlocnote;

	exit();

}
?>
