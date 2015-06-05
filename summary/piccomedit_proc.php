<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include('../functions/editfunctions.php');
include('../functions/curfunctions.php');

	$gets = "?file=".$_POST['file']."&part=".$_POST['part']."&id=".$_POST['id'];
	$txtfile = $_POST['file'];


	header("Location: piccomedit.php".$gets);


if (isset($_POST['submit']) && $_POST['notes'] != ""){

	$fp = fopen($txtfile, 'a');
	$date = date('Y-m-d H:i:s ');

	fwrite($fp, $date.$_POST['notes']."\n");
	fclose($fp);

	if($_POST['part'] == "module_p"){
		lastUpdate("module_p", $_POST['id'], "User", "Picture Comment", $_POST['notes']);
	}

	exit();
}

?>
