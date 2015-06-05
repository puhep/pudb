<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Measurement Submission</title>
</head>
<body>
<?php
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');
if(!isset($_GET['wafers'])){
?>
<form action='meassubmit.php' method='get' enctype='multipart/form-data'>
Available Wafers
<select name="wafers">
<?php
waferpop();
?>
</select>

<?php
}
else{
?>
<form action='meassubmit_proc.php' method='post' enctype='multipart/form-data'>

Available Sensors
<select name="sensors">
<?php
sensorpop($_GET['wafers']);
?>
</select>

<br>
<br>

Scan Type: <input name="scan" value="IV" type="radio">IV
&nbsp; &nbsp; <input name="scan" value="CV"
 type="radio">CV<br>
<br>
Scan Level: &nbsp;<input name="level" value="wafer" type="radio"> On Wafer
 &nbsp; &nbsp; 
 <input name="level" value="module" type="radio"> Bare Module
 &nbsp; &nbsp; 
 <input name="level" value="assembled" type="radio"> Fully-Assembled Module
 &nbsp; &nbsp; 
 <input name="level" value="fnal" type="radio"> Testing at FermiLab
<br>
<br>
Breakdown Voltage: &nbsp;<textarea cols="10" rows="1" name="breakdown">0</textarea>
<br>
<br>
Compliance Voltage: &nbsp;<textarea cols="10" rows="1" name="compliance">0</textarea>
<br>
<br>
XML file:
<input name="xml" type="file">
<?php
echo "<input type='hidden' name='wafers' value='".$_GET['wafers']."'>";
?>
<br>
<br>
Additional Notes <textarea cols="40" rows="5" name="notes"></textarea>
<?php
}
?>

<br>
<br>

<?php
conditionalSubmit(1);
?>
</form>

<br>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
