<?php
include('../functions/submitfunctions.php');

if(isset($_POST['submit']) && isset($_POST['panel']) && isset($_POST['pos']) && isset($_POST['arrival'])){
 

 $HDI_id = $_POST['batchdate']."-".$_POST['panel']."-".$_POST['pos'];
 
 $gets = "?submitted=".$HDI_id;

 hdiinfo($HDI_id,$_POST['notes'],$_POST['arrival'],$_POST['loc']);
header("Location: HDIsubmit.php".$gets);
exit();
}
elseif(isset($_POST['submit'])){
 $gets = "?submitted=x";
 echo "Not all forms were filled, please retry.";
header("Location: HDIsubmit.php".$gets);
exit();
}
?>
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
<body>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
<?php
include('../functions/popfunctions.php');
?>

Batch And Date Code <select name="batchdate">
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
	<div class="arrival">Arrival Date (YYYY/MM/DD) <textarea cols="10" rows="1" name="arrival" id="arrival" maxlength="10"></textarea></div>
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

if(isset($_GET['submitted'])){
	if($_GET['submitted'] == "x"){
		echo "Not all forms were filled, please retry";
	}
	else{
		echo "HDI ".$_GET['submitted']." has been added to the database.<br>";
	}
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
