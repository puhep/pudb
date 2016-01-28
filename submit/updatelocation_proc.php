<?php
include('../functions/submitfunctions.php');
include('../functions/curfunctions.php');
include('../functions/editfunctions.php');
include('../functions/popfunctions.php');

ini_set('display_error', 'On');
error_reporting(E_ALL | E_STRICT);

	$id = findid("module_p", $_POST['name']);

if(isset($_POST['submit']) && $_POST['newloc']!="" && isset($_POST['user'])){
	if(isset($_POST['box'])){
		changeloc($id, "In transit to ".$_POST['newloc'], $_POST['notes'], $_POST['user']);
		$newlocnote = "Module in transit to ".$_POST['newloc']." by ".$_POST['user'];
	}
	else{	
		changeloc($id, $_POST['newloc'], $_POST['notes'], $_POST['user']);
		$newlocnote = "Module moved to ".$_POST['newloc']." by ".$_POST['user'];
	}
	$gets = "?code=1&name=".findname("module_p",$id);
	header("Location: updatelocation.php".$gets);
	exit();

}
else{
	$gets = "?code=2&name=".findname("module_p",$id);
	header("Location: updatelocation.php".$gets);
	exit();
}
?>
