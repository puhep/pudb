<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Test Data Overwrite Confirmation</title>
  <link rel="stylesheet" type="text/css" href="../css/wafersubmit.css" />
</head>
<body>
<form  action="moreweboverwrite_proc.php" method="post" enctype="multipart/form-data">

<br>

WARNING: This will overwrite the following data in the database:
<br>
Number of unmaskable pixels<br>
Number of unaddressable pixels<br>
Number of bad bumps (Electrical) on each ROC<br>
Number of dead pixels on each ROC<br>
Module grade<br>
<br>
Click submit if you wish to continue.
<br>
<br>
<?php

echo "<input type='hidden' name='name' value='".$_GET['name']."'>";
echo "<input type='hidden' name='link' value='".$_GET['link']."'>";

include('../functions/submitfunctions.php');

conditionalSubmit(1);
?>

</form>
<br>
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
</body>
</html>
