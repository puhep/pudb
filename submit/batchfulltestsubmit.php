<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Batch Fulltest</title>
</head>
<body>

<form action='batchfulltestsubmit.php' method='post' enctype='multipart/form-data'>
<?php
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');
?>

<a href="example_xml.xml" target="_blank">Example .xml Format</a>

<br>
<br>
.xml file:
<input name="txt" type="file">
<br>
<br>

<?php
conditionalSubmit(0);
echo "<br>";


if(isset($_POST['submit']) &&  $_FILES['txt']['size'] > 0){
	batchfulltest($_FILES['txt']['tmp_name'],$_FILES['txt']['name'],$_FILES['txt']['size']);

}
?>
</form>

<br>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
