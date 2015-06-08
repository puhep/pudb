<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>6" Wafer Submission</title>
  <script src="../js/wafersubmit.js">
  </script>
  <link rel="stylesheet" type="text/css" href="../css/wafersubmit.css" />
</head>
<body>
<form  action="wafersubmit_proc.php" method="post" enctype="multipart/form-data">

<div> 
	<div class="div1">Wafer Number <textarea cols="3" rows="1" id="wafer_id" name="wafer_id" maxlength="3" ></textarea></div>
	<div id="wafresp" class="div2"></div>
</div>
<br>
<br>
<div>
	<div class="div3">Receive Date (YYYY/MM/DD)<textarea cols="10" rows="1" id="receive" name="receive" maxlength="10"></textarea></div>
	<div id="dateresp" class="div4"></div>
</div>
<br>
<br>
Additional Notes <textarea cols="40" rows="5" name="notes"></textarea>
<br>
<br>

<?php

include('../functions/submitfunctions.php');

if(isset($_GET['submitted'])){
	echo "Wafer ".$_GET['submitted']." and all associated sensors added to the database.<br>";
}

conditionalSubmit(1);
?>

</form>
<br>
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
</body>
</html>
