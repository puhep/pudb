<?php
ini_set('display_error', 'On');
error_reporting(E_ALL | E_STRICT);

include('../../../Submission_p_secure_pages/connect.php');
include('../functions/editfunctions.php');
include('../functions/curfunctions.php');
include('../functions/popfunctions.php');
include('../functions/submitfunctions.php');

mysql_query('USE cmsfpix_u', $connection);

$name = $_POST['name'];
$id = findid("module_p", $name);
$name = findname("module_p",$id);

$search = "SELECT name, assembly, destination, location FROM module_p WHERE id=$id";
$table = mysql_query($search, $connection);
$row = mysql_fetch_assoc($table);
$assembly = $row['assembly'];
$location = $row['location'];

if($assembly != $_POST['assembly']){
	header("Location: bbm.php?code=2&name=".$name);
	exit();
}

$steparray = array("Received", "Inspected", "IV Tested", "Ready for HDI Assembly", "HDI Attached", "Wirebonded", "Encapsulated", "Tested", "Thermally Cycled", "Tested", "Ready for Shipping", "Shipped", "Ready for Mounting", "On Blade");

###This is sort of a messy solution. This is because the name changes after HDI assembly###
if($assembly == 4){
	header("Location: bbm.php?name=M".substr($name,2));
}
else{
	header("Location: bbm.php?name=".$name);
}

if(isset($_POST['submit']) && ((isset($_POST['box']) && $_POST['who'] != "") || (isset($_POST['shipbox']) && $_POST['who_ship'] != "" && $_POST['track'] && $_POST['recipient'] != "")) && (!is_null($_POST['hdi']) || $assembly!=4)){
	

	if(isset($_POST['shipbox'])){
		$assembly = 11;
		#$functested = "UPDATE module_p SET tested_status=\"To Be Tested\" WHERE id=".$id;
		#mysql_query($functested, $connection);
	}
	if($_POST['box'] == "ready"){
		$assembly = 9;
	}
	if(isset($_POST['shipbox'])){
		$submittedstep = $steparray[$assembly]." by ".$_POST['who_ship']." to ".$_POST['dest'];
	}
	else{
		$submittedstep = $steparray[$assembly]." by ".$_POST['who'];
	}
	$assembly++;
	
	milestone("module_p", $id, $assembly);


	if(isset($_POST['shipbox'])){
		if($_POST['notes_ship']!=""){
			$submittednotes = $_POST['notes_ship'];
		}
	}
	else{
		if($_POST['notes']!=""){
			$submittednotes = $_POST['notes'];
		}
	}
	if($_FILES['comments']['size'] > 0 && substr($_FILES['comments']['name'], -3) === "txt"){
		$fp = fopen($_FILES['comments']['tmp_name'], "r");
		if($submittednotes != ""){
			$submittednotes .= "\n";
		}
		$submittednotes .= fread($fp, $_FILES['comments']['size']);
		fclose($fp);
	}
	if(isset($_POST['pos_on_blade'])){
		$pos = $_POST['pos_on_blade'];
		$funcpos = "UPDATE module_p SET pos_on_blade=\"$pos\" WHERE id=$id";
		mysql_query($funcpos, $connection);
		$funcmounted = "UPDATE module_p SET tested_status = \"Mounted\" WHERE id=$id";
		mysql_query($funcmounted, $connection);
		addcomment_fnal($id, "Mounted on blade at position ".$pos." by ".$_POST['who'],$_POST['who']);
	}
	addcomment("module_p", $id, $submittedstep);
	addcomment("module_p", $id, $submittednotes);
	$funcassembly = "UPDATE module_p SET assembly=$assembly WHERE id=$id";
	mysql_query($funcassembly, $connection);
	
	if(isset($_POST['shipbox'])){
		if(preg_match("/(([0-9])( *))+/", $_POST['track'])){
			$formattedtrack = preg_replace("/[ ]/","",$_POST['track']);
		}
		else{
			$formattedtrack = $_POST['track'];
		}
		$funcship = "UPDATE module_p SET shipped=\"".$_POST['date']."\", destination=\"In transit to ".$_POST['dest']."\", tracking_number=\"".$formattedtrack."\" WHERE id=$id";
		mysql_query($funcship, $connection);
		$flexfunc = "UPDATE flex_p set current=current-1 WHERE name=\"".$location."\"";
		$carrierfunc = "UPDATE carrier_p set current=current-1 WHERE name=\"".$location."\"";
		mysql_query($flexfunc, $connection);
		mysql_query($carrierfunc, $connection);
		$flexid = 0;
		$carrierid = 0;
		if($location == "Purdue"){ $flexid = 1; $carrierid = 1;}
		if($location == "Nebraska"){ $flexid = 2; $carrierid = 2;}
		addcomment("flex_p", $flexid, "Flex cable shipped out on module ".$name);
		addcomment("carrier_p", $carrierid, "Module carrier shipped out on module ".$name);
		$mailsubject = "Purdue DB Module Shipment Message";
		$mailmessage = "This is an automated message from the Purdue CMSFPIX database. You have been designated as the recipient for module ".$name.". Be prepared to recieve this module soon. The user-submitted tracking information is as follows: ".$formattedtrack;
		mail($_POST['recipient'], $mailsubject, $mailmessage);
	}
	
	if($assembly==5){
		$hdi = $_POST['hdi'];
		$newname = "M".substr($row['name'], 2);
		$funchdi = "UPDATE HDI_p SET module=$id WHERE id=$hdi";
		$funchdi2 = "UPDATE HDI_p SET assembly=3 WHERE id=$hdi";
		$funcmod = "UPDATE module_p SET assoc_HDI=$hdi WHERE id=$id";
		$funcmod2 = "UPDATE module_p SET name=\"$newname\" WHERE id=$id";
		mysql_query($funchdi, $connection);
		mysql_query($funchdi2, $connection);
		mysql_query($funcmod, $connection);
		mysql_query($funcmod2, $connection);

		$hdiname = generateHDImodulename($id);

		milestone("HDI_p", $hdi, 3);
	
		#echo "<input type='hidden' name='name' value='".$hdiname."'>";
		#$_GET['name'] = $hdiname;
	}
	else{
		#echo "<input type='hidden' name='name' value='".$name."'>";
		#$_GET['name'] = $name;
	}
	lastUpdate("module_p", $id, $_POST['who'], $steparray[$assembly-1], $submittednotes);
	exit();
}

?>
