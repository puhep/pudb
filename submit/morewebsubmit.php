<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>MoReWeb Data Submission</title>
</head>
<body>
<form  action="morewebsubmit_proc.php" method="post" enctype="multipart/form-data">

Tarball to be uploaded to MoReWeb:
<br>
<br>
<input type="file" name="tarball">
<br>
<br>

<?php
include('../functions/submitfunctions.php');
include('../functions/curfunctions.php');

conditionalSubmit(1);

?>

</form>
<br>
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
</body>
</html>
