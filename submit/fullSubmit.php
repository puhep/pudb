<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Full Test Submission</title>
</head>
<body>
<form action="fullSubmit.php" method="POST" enctype="multipart/form-data">

<?php
 #ini_set('display_errors', 'On');
 #error_reporting(E_ALL | E_STRICT);
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');

$id = $_POST['id'];
$name = findname("module_p", $id);

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

if(isset($_POST['submit']) && ($_POST['newpix'] != "")){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "UPDATE module_p SET badpix=\"".$_POST['newpix']."\" WHERE id=".$id;
	mysql_query($func, $connection);
}
if(isset($_POST['submit']) && ($_POST['bumps_elec'] != "")){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "UPDATE module_p SET badbumps_electrical=\"".$_POST['bumps_elec']."\" WHERE id=".$id;
	mysql_query($func, $connection);
}
if(isset($_POST['submit']) && ($_POST['bumps_revbias'] != "")){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "UPDATE module_p SET badbumps_reversebias=\"".$_POST['bumps_revbias']."\" WHERE id=".$id;
	mysql_query($func, $connection);
}
if(isset($_POST['submit']) && ($_POST['bumps_xray'] != "")){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "UPDATE module_p SET badbumps_xray=\"".$_POST['bumps_xray']."\" WHERE id=".$id;
	mysql_query($func, $connection);
}
if(isset($_POST['submit']) && ($_POST['grade'] != "")){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "UPDATE module_p SET grade=\"".$_POST['grade']."\" WHERE id=".$id;
	mysql_query($func, $connection);
}

echo "<input type='hidden' name='id' value='".$_POST['id']."'>";
curname("module_p", $id);
curtestgrade($id);
curpics("sidet_p", $id);

?>


<br>
Picture File <input name="pic" type="file">
<br>
OR
<br>
Zip File of Pictures <input name="zip" type="file">
<br>
OR
<br>
XML File of Test Results <input name="tests" type="file">
<br>
<br>
Number of Bad Pixels: <textarea cols="10" rows="1" name="newpix"></textarea>
<br>
<br>
Number of Bad Bump Bonds (Electrical): <textarea cols="10" rows="1" name="bumps_elec"></textarea>
<br>
<br>
Number of Bad Bump Bonds (Reverse Bias): <textarea cols="10" rows="1" name="bumps_revbias"></textarea>
<br>
<br>
Number of Bad Bump Bonds (X-Ray): <textarea cols="10" rows="1" name="bumps_xray"></textarea>
<br>
<br>
Grade: <select name="grade">
	<option value=""></option>
	<option value="A">A</option>
	<option value="B">B</option>
	<option value="C">C</option>
	<option value="F">F</option>
	</select>
<br>
<br>
Timeable: <select name="timeable">
	<option value=""></option>
	<option value="YES">YES</option>
	<option value="NO">NO</option>
	</select>
<br>
<br>
Additional Notes <textarea cols="40" rows="5" name="notes"></textarea>
<br>
<br>

<?php
  conditionalSubmit(0);
?>

<br>
<br>
</form>

<form method="GET" action="../summary/summaryFull.php">
<?php
  echo "<input type='hidden' name='name' value='".$name."'>";
?>
<input type="submit" value="Back to Testing Summary">
</form>
<br>
<form method="GET" action="../summary/bbm.php">
<?php
  echo "<input type='hidden' name='name' value='".$name."'>";
?>
<input type="submit" value="Back to Part Summary">
</fOrm>
<br>
<form method="GET" action="../summary/test_list.php">
<input type="submit" value="Back to Tested Module List">
</form>
<br>
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
