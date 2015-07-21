<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Batch Submission</title>
</head>
<body>
<form action='batchmeassubmit_proc.php' method='post' enctype='multipart/form-data'>
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
<br>
<br>
Additional Notes <textarea cols="40" rows="5" name="notes"></textarea>

<br>
<br>

<?php
conditionalSubmit(0);

if($_GET['code'] == "1"){
	echo "<br>The measurements have successfully been added to the database<br>";
}
if($_GET['code'] == "2"){
	echo "<br>Not all forms were filled, please retry<br>";
}
if($_GET['code'] == "3"){
	echo "<br>An error occurred and the measurements have not been added to the database<br>";
}

?>
</form>

<br>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
