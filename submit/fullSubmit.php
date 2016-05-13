<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Full Test Submission</title>
</head>
<body>

<div style="position:absolute;left:500px;top:10px;">
<form method="GET" action="../summary/summaryFull.php" >
<?php
	echo "<input type='hidden' name='name' value='".$_GET['name']."'>";
?>
<input type="submit" value="Back to Full Test Summary">
</form>
</div>

<div2 style="position:absolute;left:500px;top:38px;">
<form method="GET" action="../summary/test_list.php" >
<input type="submit" value="Back to Tested Module List">
</form>
</div2>

<div3 style="position:absolute;left:500px;top:66px;">
<form method="GET" action="../summary/bbm.php" >
<?php
	echo "<input type='hidden' name='name' value='".$_GET['name']."'>";
?>
<input type="submit" value="Back to Part Summary">
</form>
</div3>

<div5 style="position:absolute;left:500px;top:94px;">
<form method="GET" action="../index.php" >
<input type="submit" value="MAIN MENU">
</form>
</div5>

<form action="fullSubmit_proc.php" method="POST" enctype="multipart/form-data">

<?php
 #ini_set('display_errors', 'On');
 #error_reporting(E_ALL | E_STRICT);
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');

$name = $_GET['name'];
$id = findid("module_p", $name);

echo "<input type='hidden' name='name' value='".$_GET['name']."'>";

curname("module_p", $id);
echo "<br>";
curtestparams($id,1);

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
Timeable: <select name="timeable">
	<option value=""></option>
	<option value="YES">YES</option>
	<option value="NO">NO</option>
	</select>
<br>
<br>
Next Testing Step: <select name="status">
	<option value=""></option>
	<option value="Full test at 17C">Full test at 17C</option>
	<option value="Full test at -20C">Full test at -20C</option>
	<option value="X-ray testing">X-ray testing</option>
	<option value="Thermal cycling">Thermal cycling</option>
	<option value="Final Judgement">Final Judgement</option>
	<option value="Debugging">Debugging</option>
	<option value="Ready for Mounting">Ready for Mounting</option>
	<option value="Rejected">Rejected</option>
	</select>
<br>
<br>

ROC: <select name="ROC"><?php rocpop($id) ?></select>
Failure Mode: <select name="mode">
	<option value=""></option>
	<option value="Dead DC w/ good Trim">Dead DC w/ good Trim</option>
	<option value="Dead DC w/ bad Trim">Dead DC w/ bad Trim</option>
	<option value="Bad Trim w/ no Bad DC">Bad Trim w/ no Bad DC</option>
	<option value="Zombie">Zombie</option>
	<option value="Zero PH">Zero PH</option>
	<option value="Low Iana / High Vana">Low Iana / High Vana</option>
	<option value="Iana Short">Iana Short</option>
	<option value="Idig Short">Idig Short</option>
	<option value="Partially Detached">Partially Detached</option>
	<option value="Dead Pixels">Dead Pixels</option>
	<option value="Bad Bumps">Bad Bumps</option>
	<option value="No Token Pass">No Token Pass</option>
	<option value="Unprogrammable">Unprogrammable</option>
	<option value="Pulse Height Issue">Pulse Height Issue</option>
	<option value="Other">Other</option>
	</select>
<br>
<br>

Additional Notes <textarea cols="40" rows="5" name="notes"></textarea>
<br>
<br>

User: <input name="user" type="text">
<br>
Note: User field is required
<br>
<br>

<?php
  	conditionalSubmit(1);
        echo "<br> <br>";
	curpics("sidet_p", $id);
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
