<?php

ini_set('display_error', 'On');
error_reporting(E_ALL | E_STRICT);

include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');
include('../functions/editfunctions.php');

	$id = findid("module_p", $_POST['name']);
	$gets = "?name=".$_POST['name'];
	$assembly = findmodassembly($id);

	header("Location: fullSubmit.php".$gets);

### Only execute anything if the submit button is pressed and the user field is filled
if($_POST['user'] != "" && isset($_POST['submit'])){
if(isset($_POST['submit'])){
	$newval = 1;
	if(!empty($_POST['PA'])){
		foreach($_POST['PA'] as $check){
			$newval *= $check;
		}
	}
	$dumped = dump("module_p", $id);
	if($dumped['assembly_post'] != $newval){
		include('../../../Submission_p_secure_pages/connect.php');
		$func = "UPDATE module_p SET assembly_post=".$newval." WHERE id=".$id;
		mysql_query('USE cmsfpix_u', $connection);
		mysql_query($func, $connection);
		$newcomment = "Completed post-assembly tests: ";
		if($newval == 1){ $newcomment .= "None, ";}
		else{
			if($newval%2 == 0){ 
				$newcomment .= "Full test at 17C, ";
				#$timesfunc = "UPDATE times_module_p SET post_tested_17c = NOW() WHERE assoc_module=".$id;
				$timesfunc = "UPDATE times_module_p SET post_tested_17c= CASE WHEN (post_tested_17c IS NULL OR UNIX_TIMESTAMP(post_tested_17c)=0) AND assoc_module=$id THEN NOW() ELSE post_tested_17c END";
				mysql_query($timesfunc,$connection);
			}
			if($newval%3 == 0){ 
				$newcomment .= "Full test at -20C, ";
				#$timesfunc = "UPDATE times_module_p SET post_tested_n20c = NOW() WHERE assoc_module=".$id;
				$timesfunc = "UPDATE times_module_p SET post_tested_n20c= CASE WHEN (post_tested_n20c IS NULL OR UNIX_TIMESTAMP(post_tested_n20c)=0) AND assoc_module=$id THEN NOW() ELSE post_tested_n20c END";
				mysql_query($timesfunc,$connection);
			}
			if($newval%5 == 0){ 
				$newcomment .= "X-ray Testing, ";
				#$timesfunc = "UPDATE times_module_p SET post_tested_xray = NOW() WHERE assoc_module=".$id;
				$timesfunc = "UPDATE times_module_p SET post_tested_xray= CASE WHEN (post_tested_xray IS NULL OR UNIX_TIMESTAMP(post_tested_xray)=0) AND assoc_module=$id THEN NOW() ELSE post_tested_xray END";
				mysql_query($timesfunc,$connection);
			}
			if($newval%7 == 0){ 
				$newcomment .= "Thermal Cycling, ";
				#$timesfunc = "UPDATE times_module_p SET post_tested_thermal_cycle = NOW() WHERE assoc_module=".$id;
				$timesfunc = "UPDATE times_module_p SET post_tested_thermal_cycle= CASE WHEN (post_tested_thermal_cycle IS NULL OR UNIX_TIMESTAMP(post_tested_thermal_cycle)=0) AND assoc_module=$id THEN NOW() ELSE post_tested_thermal_cycle END";
				mysql_query($timesfunc,$connection);
			}
		}
		$newcomment .= "by ".$_POST['user'];
		addcomment_fnal($id, $newcomment, $_POST['user']);
	}
	
}
if ($_FILES['pic']['size'] > 0){

	addpic($_FILES['pic']['name'], $_FILES['pic']['tmp_name'], "sidet_p", $id, $_POST['notes']);
}
else if($_FILES['zip']['size'] > 0){

	batchpic($_FILES['zip']['tmp_name'], $_FILES['zip']['name'], "sidet_p", $id);
}
else if($_FILES['tests']['size'] > 0){

	batchfulltest($_FILES['tests']['tmp_name'], $_FILES['tests']['name'], $_FILES['tests']['size']);
}
if(isset($_POST['newgrade'])){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "UPDATE module_p SET grade=\"".$_POST['newgrade']."\" WHERE id=".$id;
	mysql_query($func, $connection);
}
if($_POST['grade'] != ""){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "UPDATE module_p SET grade=\"".$_POST['grade']."\" WHERE id=".$id;
	mysql_query($func, $connection);
}

include('../../../Submission_p_secure_pages/connect.php');
mysql_query('USE cmsfpix_u', $connection);

### if the module is rejected and there is a comment, we don't care about anything else, just do it
if($_POST['status'] == "Rejected" && $_POST['notes'] != ""){
	
	$func = "UPDATE module_p SET tested_status=\"".$_POST['status']."\" WHERE id=".$id;
	mysql_query($func, $connection);
	
	$funcassembly = "UPDATE module_p SET assembly=15 WHERE id=".$id;
	mysql_query($funcassembly, $connection);
	
	addcomment("module_p", $id, $_POST['status']." by ".$_POST['user'], $_POST['user']);
	addcomment_fnal($id, "Set to ".$_POST['status']." by ".$_POST['user'], $_POST['user']);
}

elseif($_POST['status'] == "Rejected" && $_POST['notes'] == ""){}

### if the status is filled, but not Ready for Mounting or Rejected, and assembly is shipped or lower, set next step
elseif($_POST['status'] != "" &&  $_POST['status'] != "Ready for Mounting" && $assembly <= 12){

	$func = "UPDATE module_p SET tested_status=\"".$_POST['status']."\" WHERE id=".$id;
	mysql_query($func, $connection);

	addcomment_fnal($id, "Next Testing Step set to ".$_POST['status']." by ".$_POST['user'], $_POST['user']);
}
### The next step should only be allowed to be set to Ready for Mounting if the assembly is Shipped or greater
elseif($_POST['status'] == "Ready for Mounting" && $assembly >= 12){
	
	$func = "UPDATE module_p SET tested_status=\"".$_POST['status']."\" WHERE id=".$id;
	mysql_query($func, $connection);    
	
	$funcassembly = "UPDATE module_p SET assembly=13 WHERE id=".$id;
	mysql_query($funcassembly, $connection);
	
	$timesfunc = "UPDATE times_module_p SET fnal_tested = NOW() WHERE assoc_module=".$id;
	mysql_query($timesfunc, $connection);
	
	addcomment("module_p", $id, $_POST['status']." by ".$_POST['user'], $_POST['user']);
	addcomment_fnal($id, "Set to ".$_POST['status']." by ".$_POST['user'], $_POST['user']);	
}
### if the module is mounted or ready for mounting and the next step is changed, demote to shipped
elseif($_POST['status'] != "" && $_POST['status'] != "Ready for Mounting" && $assembly >= 13){
	
	$func = "UPDATE module_p SET tested_status=\"".$_POST['status']."\" WHERE id=".$id;
	mysql_query($func, $connection);    
	
	$funcassembly = "UPDATE module_p SET assembly=12 WHERE id=$id";
	mysql_query($funcassembly, $connection);
	
	addcomment("module_p", $id, $_POST['status']." by ".$_POST['user'], $_POST['user']);
	addcomment_fnal($id, "Set to ".$_POST['status']." by ".$_POST['user'], $_POST['user']);	
}

if($_POST['notes'] != ""){

	addcomment_fnal($id, $_POST['notes']."&nbsp;&nbsp;&nbsp;&nbsp; --".$_POST['user'], $_POST['user']);
}
}
exit();
?>
