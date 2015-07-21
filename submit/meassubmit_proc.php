<?php
include('../functions/submitfunctions.php');
include('../functions/curfunctions.php');
include('../functions/editfunctions.php');


if(isset($_POST['submit']) &&  $_FILES['xml']['size'] > 0 && isset($_POST['level']) && isset($_POST['scan']) ){
	
	$fp = fopen($_FILES['xml']['tmp_name'],'r');
	$content = fread($fp,filesize($_FILES['xml']['tmp_name']));
	$content = addslashes($content);
	fclose($fp);
 
	measurement($_POST['sensors'],$_POST['level'],$_POST['scan'],$_POST['notes'],$content,$_FILES['xml']['size'], $_FILES['xml']['name'], $_POST['breakdown'], $_POST['compliance']);

	if($_POST['level'] == "wafer"){
		isTestedWaferUpdate($_POST['wafers']);
	}

	$gets = "?code=1&wafers=".$_POST['wafers'];

	header("Location: meassubmit.php".$gets);

	exit();
}
else if(isset($_POST['submit']) &&  $_FILES['log']['size'] > 0 && isset($_POST['level']) && isset($_POST['scan']) && $_POST['user'] != ""){

	###We assume that using the log input implies that the sensor is on a module###
	$names = namedump("sensor_p", $_POST['sensors']);
	$dumped = dump("sensor_p",$_POST['sensors']);
	$modid = $dumped['assoc_module'];
	$loc = curloc("module_p", $modid);

	$content = log2xml($_FILES['log']['tmp_name'], $_POST['user'], $loc, $names['bbm']);

	measurement($_POST['sensors'],$_POST['level'],$_POST['scan'],$_POST['notes'],$content, strlen($content), $_FILES['log']['name'], $_POST['breakdown'], $_POST['compliance']);

	$gets = "?code=1&wafers=".$_POST['wafers'];

	header("Location: meassubmit.php".$gets);

	exit();
}
else{
	$gets = "?code=2&wafers=".$_POST['wafers'];

	header("Location: meassubmit.php".$gets);
}
?>
