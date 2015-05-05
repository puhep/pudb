<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Batch ROC Submission</title>
</head>
<body>

<form action='batchrocsubmit.php' method='post' enctype='multipart/form-data'>
<?php
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');
?>


<br>
<br>
.xml file:
<input name="txt" type="file">
<br>
<br>
Location:
<select name="location">
<option value="Purdue">Purdue</option>
<option value="Nebraska">Nebraska</option>
</select>
<br>
<br>

<?php
conditionalSubmit(0);
echo "<br>";


if(isset($_POST['submit']) &&  $_FILES['txt']['size'] > 0){

	batchroc($_FILES['txt']['tmp_name'],$_FILES['txt']['name'],$_FILES['txt']['size'],$_POST['location']);

}
?>
</form>

<br>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
