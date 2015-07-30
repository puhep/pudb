<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>HDI Submission</title>
  <script src="../js/HDIsubmit.js">
  </script>
  <link rel="stylesheet" type="text/css" href="../css/HDIsubmit.css" />
</head>
<body onload='FormatDate()'>
<form action="HDIsubmit_proc.php" method="post" enctype="multipart/form-data">
<?php
include('../functions/popfunctions.php');
?>

<img src="../pics/HDI_labels.png" width="320" height="337">
<br>
<br>

Work Order And Date Code <select name="batchdate">
<?php
  HDIbatchpop();
?>
</select><br>
<br>
Panel <textarea cols="20" rows="1" name="panel"></textarea><br>
<br>
Position <textarea cols="20" rows="1" name="pos"></textarea><br>
<br>
<div>
	<div class="arrival">Arrival Date (YYYY/MM/DD) <textarea cols="10" rows="1" name="arrival" id="arrival" maxlength="10"><?php echo date('Y/m/d');?></textarea></div>
	<div class="dateresp" id="dateresp"></div>
</div>
<br>
<br>
<br>
Location <select name="loc">
	<option value="Purdue">Purdue</option>
	<option value="Nebraska">Nebraska</option>
	</select>
	
<br>
<br>
<br>
Additional Notes <textarea cols="40" rows="5" name="notes"></textarea><br>
<br>

<?php
include('../functions/submitfunctions.php');


	if($_GET['code'] == "1"){
		echo "<br>HDI ".$_GET['val']." has successfully been entered into the database<br>";
	}
	elseif($_GET['code'] == "2"){
		echo "<br>Not all forms were filled, please retry<br>";
	}

conditionalSubmit(1);

?>
</form>

<br>
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
<form>

</body>
</html>
