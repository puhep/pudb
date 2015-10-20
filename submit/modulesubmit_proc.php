<?php
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');

if(isset($_POST['submit']) && isset($_POST['modules']) && isset($_POST['arrival'])){

	include('../../../Submission_p_secure_pages/connect.php');
	include('../functions/editfunctions.php');

	$sqlarrival = mysql_real_escape_string($_POST['arrival']);
	$sqlnotes = mysql_real_escape_string($_POST['notes']);
	$notes = mysql_real_escape_string($_POST['notes']);


	mysql_query('USE cmsfpix_u', $connection);

	/*
	if(!strcmp($_POST['QC'],"accept")){
		$good = 1;
	}
	else{
		$good = -1;
	}
	*/

	$date = date('Y-m-d H:i:s');

	if($sqlnotes != ""){
		$sqlnotes = $date."  ".$sqlnotes."\n";
	}

	$sqlnotes = $date."  Received\n".$sqlnotes;



	$func = 'UPDATE module_p set assembly=1, arrival="'.$sqlarrival.'", location="'.$_POST['loc'].'", destination="'.$_POST['loc'].'", bonder="'.$_POST['flip'].'", has_ROC="0", notes="'.$sqlnotes.'" WHERE id='.$_POST['modules'];

	if(mysql_query($func, $connection)){

		$id = $_POST['modules'];

		$timefunc = "INSERT INTO times_module_p(assoc_module, received) VALUES($id, \"$date\")";
		mysql_query($timefunc, $connection);

		lastUpdate("module_p", $id, "User", "Received", $notes);

		#echo "<br>";
		#echo "The module was successfully added to the database";
	}
	else{
		#echo "<br>";
		#echo "An error occurred and the module was not added to the database";
	}
	
	$gets = "?wafers=".$_POST['wafers']."&code=1&val=".findname("module_p", $_POST['modules']);

	header("Location: modulesubmit.php".$gets);
}

?>
