<?php
ini_set('display_error', 'On');
error_reporting(E_ALL | E_STRICT);

include('../../../Submission_p_secure_pages/connect.php');
include('../functions/editfunctions.php');
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');


mysql_query('USE cmsfpix_u', $connection);

$name = $_POST['name'];
$id = findid("wafer_p", $name);

$search = "SELECT assembly,name FROM wafer_p WHERE id=$id";
$table = mysql_query($search, $connection);
$row = mysql_fetch_assoc($table);
$assembly = $row['assembly'];

$steparray = array("Inspected", "Tested", "Promoted", "Ready for Shipping", "Shipped");

$gets = "?name=".$name;

header("Location: wafer.php".$gets);

if(isset($_POST['submit']) && isset($_POST['box']) && $_POST['who'] != ""){
	$submittedstep = $steparray[$assembly]." by ".$_POST['who'];
	if($_POST['notes']!=""){
		$submittednotes =$_POST['notes'];
	}

	addcomment("wafer_p", $id, $submittedstep);
	addcomment("wafer_p", $id, $submittednotes);


	$assembly++;
	$funcassembly = "UPDATE wafer_p SET assembly=$assembly WHERE id=$id";
	mysql_query($funcassembly, $connection);

	milestone("wafer_p", $id, $assembly); 
	
	if($assembly == 3){
		if(!empty($_POST[sens])){
			foreach($_POST[sens] as $promotedid){
				sensorSetPromote($promotedid);
			}
		}

	}
	if($assembly == 5){
		promoteSensors($id);
	}
	
	exit();

}

?>
