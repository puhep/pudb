<?php

include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');
include('../functions/editfunctions.php');

	$id = findid("module_p", $_POST['name']);
	$gets = "?name=".$_POST['name'];
	$assembly = findmodassembly($id);

	header("Location: fullSubmit.php".$gets);

if($_POST['user'] != ""){
if(isset($_POST['submit'])){
	$newval = 1;
	if(!empty($_POST['PA'])){
		foreach($_POST['PA'] as $check){
			$newval *= $check;
		}
	}
	include('../../../Submission_p_secure_pages/connect.php');
	$func = "UPDATE module_p SET assembly_post=".$newval." WHERE id=".$id;
	mysql_query('USE cmsfpix_u', $connection);
	mysql_query($func, $connection);
	
}
if (isset($_POST['submit']) && $_FILES['pic']['size'] > 0){

	addpic($_FILES['pic']['name'], $_FILES['pic']['tmp_name'], "sidet_p", $id, $_POST['notes']);
}
else if(isset($_POST['submit']) && $_FILES['zip']['size'] > 0){

	batchpic($_FILES['zip']['tmp_name'], $_FILES['zip']['name'], "sidet_p", $id);
}
else if(isset($_POST['submit']) && $_FILES['tests']['size'] > 0){

	batchfulltest($_FILES['tests']['tmp_name'], $_FILES['tests']['name'], $_FILES['tests']['size']);
}
if(isset($_POST['submit']) && isset($_POST['newgrade'])){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "UPDATE module_p SET grade=\"".$_POST['newgrade']."\" WHERE id=".$id;
	mysql_query($func, $connection);
}
if(isset($_POST['submit']) && ($_POST['grade'] != "")){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "UPDATE module_p SET grade=\"".$_POST['grade']."\" WHERE id=".$id;
	mysql_query($func, $connection);
}
if(isset($_POST['submit']) && ($_POST['status'] != "" &&  $_POST['status'] != "Ready for Mounting")){
	include('../../../Submission_p_secure_pages/connect.php');
	$func = "UPDATE module_p SET tested_status=\"".$_POST['status']."\" WHERE id=".$id;
	mysql_query('USE cmsfpix_u', $connection);
	mysql_query($func, $connection);
	addcomment_fnal($id, "Next Testing Step set to ".$_POST['status']." by ".$_POST['user']);
}
elseif(isset($_POST['submit']) && ($_POST['status'] == "Ready for Mounting" && ($assembly == 12 || $assembly == 13) || $assembly == 14)){
	include('../../../Submission_p_secure_pages/connect.php');
	$func = "UPDATE module_p SET tested_status=\"".$_POST['status']."\" WHERE id=".$id;
	mysql_query('USE cmsfpix_u', $connection);
	mysql_query($func, $connection);    
	$funcassembly = "UPDATE module_p SET assembly=13 WHERE id=".$id;
	mysql_query($funcassembly, $connection);
	addcomment("module_p", $id, $_POST['status']." by ".$_POST['user']);
	addcomment_fnal($id, "Set to ".$_POST['status']." by ".$_POST['user']);
	
}

if(isset($_POST['submit']) && ($_POST['notes'] != "")){

	addcomment_fnal($id, $_POST['notes']."&nbsp;&nbsp;&nbsp;&nbsp; --".$_POST['user']);
}
}
exit();
?>
