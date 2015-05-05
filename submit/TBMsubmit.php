<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>TBM Submission</title>
  <link rel="stylesheet" type="text/css" href="../css/HDIsubmit.css" />
</head>
<body>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
 TBM ID <textarea cols="20" rows="1" name="tbm_id"></textarea><br>
<br>
<br>
Additional Notes <textarea cols="40" rows="5" name="notes"></textarea><br>
<br>

<?php
include('../functions/submitfunctions.php');

conditionalSubmit(1);

if(isset($_POST['submit']) && isset($_POST['tbm_id'])){
 
 tbminfo($_POST['tbm_id'],$_POST['notes']);
}
elseif(isset($_POST['submit'])){
 echo "Not all forms were filled, please retry.";
}
?>
</form>

<br>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
<form>

</body>
</html>
