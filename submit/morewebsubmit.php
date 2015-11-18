<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>MoReWeb Data Submission</title>
</head>
<body>
<form  action="morewebsubmit_proc.php" method="post" enctype="multipart/form-data">

Tarball to be uploaded to MoReWeb:<br>
Uploaded data can be accessed through the "MoReWeb Results" button on the main page<br>
To populate the database with MoReWeb data (for grading and search filtering), click "Write to database" on the "Full Test Summary" page<br>
<br>
<input type="file" name="tarball">
<br>
<br>

<?php
include('../functions/submitfunctions.php');
include('../functions/curfunctions.php');

conditionalSubmit(1);

if($_GET['code'] == 1){
	echo "<br>The data is uploaded and ready to be parsed<br>";
}
if($_GET['code'] == 2){
	echo "<br>Not all forms were filled or the filetype is incorrect, please retry<br>";
}

?>

</form>
<br>
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
</body>
</html>
