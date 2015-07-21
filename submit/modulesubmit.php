<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Recieved Module Submission</title>
</head>
<body>

<img src="../pics/RTI_Numbering_Scheme.png" width="200" height="200">
<img src="../pics/SINTEF_numbering_diagram_2x8s_Updated.jpg" width="270" height="250">

<br>`
<br>`

<?php
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');



if(!isset($_GET['wafers'])){
?>
<form action='modulesubmit.php' method='get' enctype='multipart/form-data'>
Available Wafers
<select name="wafers">
<?php
shippedwaferpop();
?>
</select>

<?php
}
else{
echo "<form action='modulesubmit_proc.php' method='post' enctype='multipart/form-data'>";
echo "<input type='hidden' name='wafers' value='".$_GET['wafers']."'>";
?>

Available Modules
<select name="modules">
<?php
availmodule($_GET['wafers']);
?>
</select>

<br>
<br>

Location <select name="loc">
	<option value="Purdue">Purdue</option>
	<option value="Nebraska">Nebraska</option>
	</select>
<br>
<br>

Flip-Chip Bonder <select name="flip">
	<option value="FC150">FC150</option>
	<option value="Datacon">Datacon</option>
	</select>
<br>
<br>


Arrival Date (yyyy/mm/dd) <textarea cols="10" rows="1" name="arrival"></textarea>
<br>

Additional Notes <textarea cols="40" rows="5" name="notes"></textarea>
<?php
}
?>

<br>
<br>

<?php

conditionalSubmit(1);

if($_GET['code'] == 1){
	echo "<br>Module ".$_GET['val']." has been entered into the database<br>";
}


?>
</form>
<br>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
