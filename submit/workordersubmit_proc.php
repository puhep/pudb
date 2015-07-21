<?php

include('../functions/submitfunctions.php');

if(isset($_POST['submit']) && $_POST['neworder']!="" ){

	if(!preg_match("/([0-9A-Za-z]{5})-([0-9A-Za-z]{4})/",$_POST['neworder'])){
		header("Location: workordersubmit.php?code=2");
	}
	else{
		workorderinfo(strtoupper($_POST['neworder']));
		header("Location: workordersubmit.php?code=1");
	}
	exit();
}
else{
	header("Location: workordersubmit.php?code=2");
}
?>
