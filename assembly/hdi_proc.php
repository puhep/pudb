<?php
ini_set('display_error', 'On');
error_reporting(E_ALL | E_STRICT);

include('../../../Submission_p_secure_pages/connect.php');
include('../functions/editfunctions.php');
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');

mysql_query('USE cmsfpix_u', $connection);

$name = $_POST['name'];
$id = findid("HDI_p", $name);

$search = "SELECT assembly FROM HDI_p WHERE id=$id";
$table = mysql_query($search, $connection);
$row = mysql_fetch_assoc($table);
$assembly = $row['assembly'];

$steparray = array("Inspected", "Ready for Assembly", "On Module");

$gets = "?name=".$name;

header("Location: hdi.php".$gets);

if(isset($_POST['submit']) && isset($_POST['box']) && $_POST['who'] != ""){
	$submittedstep = $steparray[$assembly]." by ".$_POST['who'];
	if($_POST['notes']!=""){
		$submittednotes = $_POST['notes'];
	}
	addcomment("HDI_p", $id, $submittedstep);
	addcomment("HDI_p", $id, $submittednotes);
	$assembly++;

	milestone("HDI_p",$id,$assembly);

	if($_POST['box'] == "reject"){
		$assembly = 4;
	}
	$funcassembly = "UPDATE HDI_p SET assembly=$assembly WHERE id=$id";
	mysql_query($funcassembly, $connection);

	exit();
}

?>
