<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Batch Submission</title>
</head>
<body>
<form action='batchmeassubmit.php' method='post' enctype='multipart/form-data'>
<?php
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');
?>

Scan Level: &nbsp;<input name="level" value="wafer" type="radio"> On Wafer
 &nbsp; &nbsp; 
 <input name="level" value="module" type="radio"> On Module
 &nbsp; &nbsp; 
 <input name="level" value="assembled" type="radio"> Fully Assembled
<br>
<br>
.zip file:
<input name="zipped" type="file">
<?php
echo "<input type='hidden' name='wafers' value='".$_POST['wafers']."'>";
?>
<br>
<br>
Additional Notes <textarea cols="40" rows="5" name="notes"></textarea>

<br>
<br>

<?php
conditionalSubmit(0);
echo "<br>";


if(isset($_POST['submit']) &&  $_FILES['zipped']['size'] > 0 && isset($_POST['level'])){
	batchmeasurement($_FILES['zipped']['tmp_name'],$_FILES['zipped']['name'],$_FILES['zipped']['size'], $_POST['level'],$_POST['notes']);
}
	#if($_POST['level'] == "wafer"){
		#isTestedWaferUpdate($_POST['wafers']);
	#}
?>
</form>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
