<?php
include('../functions/submitfunctions.php');

	$gets = "?wafers=".$_POST['wafers'];

	header("Location: meassubmit.php".$gets);


if(isset($_POST['submit']) &&  $_FILES['xml']['size'] > 0 && isset($_POST['level']) && isset($_POST['scan'])){
	
	$fp = fopen($_FILES['xml']['tmp_name'],'r');
	$content = fread($fp,filesize($_FILES['xml']['tmp_name']));
	$content = addslashes($content);
	fclose($fp);
 
	measurement($_POST['sensors'],$_POST['level'],$_POST['scan'],$_POST['notes'],$content,$_FILES['xml']['size'], $_FILES['xml']['name'], $_POST['breakdown'], $_POST['compliance']);
}
	if($_POST['level'] == "wafer"){
		isTestedWaferUpdate($_POST['wafers']);
	}

	exit();
}

?>
