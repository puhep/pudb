<?php
include('../functions/submitfunctions.php');
include('../functions/curfunctions.php');

	$gets = "?submitted=".$_POST['wafer_id'];

	header("Location: wafersubmit.php".$gets);

if(isset($_POST['submit']) && $_POST['wafer_id']!="" && $_POST['receive']!=""){


	$iwafer = intval($_POST['wafer_id']);
	if(($iwafer < 0) || ($iwafer > 999)){
		echo "Wafer ID formatting incorrect, please retry";
	}
	else{ 
   		$name=str_pad($_POST['wafer_id'],3,"0", STR_PAD_LEFT);

 		wafersensorinfo($name,$_POST['receive'],$_POST['notes']);
	}
	exit();
}
?>
