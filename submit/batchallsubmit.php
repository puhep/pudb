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

<br>
This form is for adding a wide range of data using a single zip file.<br>
To use:<br>
1. Generate a master.xml file (<a href="example_xml.xml" target="_blank">Example</a>) <br>
2. Put this master.xml file plus any required picture, text, or IV/CV files in the top level of a .zip directory. <br>
3. Upload this .zip directory in the form below.<br>
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
	echo "<br>Either username or file upload fields were left blank, please retry<br>";
}
if($_GET['code'] == 3){
	echo "<br>The xml file could not be parsed and the data has not been uploaded<br>";
}
if($_GET['code'] == 4){
	echo "<br>An unknown error has occurred, please retry<br>";
}
if($_GET['code'] == 5){
	echo "<br>Uploaded file was not a .zip, please retry<br>";
}

?>
</form>

<br>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
