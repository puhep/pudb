<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Batch ROC Submission</title>
</head>
<body>

<form action='batchrocsubmit_proc.php' method='post' enctype='multipart/form-data'>
<?php
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');
?>


<br>
This form is for populating module ROCs in batch using the document generated by RTI.<br>
To use:<br>
1. Download the assembled module document from RTI (<a href="example_RTI.xlsx" download>example here</a>). It should be in .xlsx format (Excel Spreadsheet)<br>
2. Open the file in Microsoft Excel (or equivalent).<br>
3. Save it as an XML Spreadsheet.<br>
4. Upload this XML spreadsheet to the form below.<br>
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
User:
<textarea name="user" cols="10" rows="1"></textarea>
<br>
<br>
Additional Notes:
<textarea name="notes" cols="40" rows="5"></textarea>
<br>
<br>

<?php
conditionalSubmit(0);
echo "<br>";

if($_GET['code'] == "1"){
	echo "<br>The modules and associated ROCs have been added to the database<br>";
}
if($_GET['code'] == "2"){
	echo "<br>An error occurred and the modules have not been added, please try again<br>";
}

?>
</form>

<br>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
