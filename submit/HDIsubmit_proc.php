<?php
include('../functions/submitfunctions.php');


if(isset($_POST['submit']) && isset($_POST['panel']) && isset($_POST['pos']) && isset($_POST['arrival'])){
 

	$HDI_id = $_POST['batchdate']."-".$_POST['panel']."-".$_POST['pos'];
 
 	$gets = "?code=1&val=".$HDI_id;

 	hdiinfo($HDI_id,$_POST['notes'],$_POST['arrival'],$_POST['loc']);
	header("Location: HDIsubmit.php".$gets);
	exit();
}
elseif(isset($_POST['submit'])){
 	$gets = "?code=2";
 	#echo "Not all forms were filled, please retry.";
	header("Location: HDIsubmit.php".$gets);
	exit();
}
?>
