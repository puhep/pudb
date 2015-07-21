<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Consolidated Batch Submit</title>
</head>
<body>

<form action='batchallsubmit_proc.php' method='post' enctype='multipart/form-data'>
<?php
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');
?>

<a href="example_xml.xml" target="_blank">Example master.xml Format</a>

<br>
<br>
User:
<textarea name="user" rows="1" cols="10"></textarea>
<br>
<br>
.zip file:
<input name="zip" type="file">
<br>
<br>

<?php
conditionalSubmit(0);

if($_GET['code'] == 1){
	echo "<br>The data has successfully been uploaded to the database<br>";
}
if($_GET['code'] == 2){
	echo "<br>Not all fields were filled, please retry<br>";
}
if($_GET['code'] == 3){
	echo "<br>The xml file could not be parsed and the data has not been uploaded<br>";
}
if($_GET['code'] == 4){
	echo "<br>An unknown error has occurred<br>";
}


?>
</form>

<br>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
