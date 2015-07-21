<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>HDI Work Order Submission</title>
</head>
<body>
<form  action="workordersubmit_proc.php" method="post" enctype="multipart/form-data">

<br>
 <img src="../pics/HDI_labels.png" width="320" height="337"> 
<br>
<br>
New HDI Work Order and Date Code:
<textarea cols="10" rows="1" name="neworder"></textarea>
<br>
Note: Should be of the form XXXXX-XXXX
<br>
<br>

<?php

include('../functions/submitfunctions.php');

conditionalSubmit(1);

if($_GET['code'] == "1"){
	echo "<br>The work order has been added to the database<br>";
}
elseif($_GET['code'] == "2"){
	echo "<br>Work order formatting incorrect, please retry<br>";
}
?>

</form>
<br>
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
</body>
</html>
