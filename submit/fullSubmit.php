<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Full Test Submission</title>
</head>
<body>
<form action="fullSubmit_proc.php" method="POST" enctype="multipart/form-data">

<?php
 #ini_set('display_errors', 'On');
 #error_reporting(E_ALL | E_STRICT);
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');

$name = $_GET['name'];
$id = findid("module_p", $name);

echo "<input type='hidden' name='name' value='".$_GET['name']."'>";

curname("module_p", $id);
curtestparams($id);
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
