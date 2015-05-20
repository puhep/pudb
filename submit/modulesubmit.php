<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Recieved Module Submission</title>
</head>
<body>
<form action='modulesubmit.php' method='post' enctype='multipart/form-data'>

<img src="../pics/RTI_Numbering_Scheme.png" width="200" height="200">
<img src="../pics/SINTEF_numbering_diagram_2x8s_Updated.jpg" width="270" height="250">

<br>`
<br>`

<?php
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');



if(!isset($_POST['wafers'])){
?>
Available Wafers
<select name="wafers">
<?php
shippedwaferpop();
?>
</select>

<?php
}
else{
echo "<input type='hidden' name='wafers' value='".$_POST['wafers']."'>";
?>

Available Modules
<select name="modules">
<?php
availmodule($_POST['wafers']);
?>
</select>

<br>
<br>

<input name="QC" value="accept" type="radio">Accept
&nbsp; &nbsp; <input name="QC" value="reject"
 type="radio">Reject<br>
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

if(isset($_POST['submit']) && isset($_POST['modules']) && isset($_POST['QC']) && isset($_POST['arrival'])){

	include('../../../Submission_p_secure_pages/connect.php');

	$sqlarrival = mysql_real_escape_string($_POST['arrival']);
	$sqlnotes = mysql_real_escape_string($_POST['notes']);


	mysql_query('USE cmsfpix_u', $connection);

	if(!strcmp($_POST['QC'],"accept")){
		$good = 1;
	}
	else{
		$good = -1;
	}

	$date = date('Y-m-d H:i:s');

	$notes="";

	if($sqlnotes != ""){
		$sqlnotes = $date."  ".$sqlnotes."\n";
	}

	$sqlnotes = $date."  Received\n".$sqlnotes;



	$func = 'UPDATE module_p set assembly='.$good.', arrival="'.$sqlarrival.'", location="'.$_POST['loc'].'", destination="'.$_POST['loc'].'", bonder="'.$_POST['flip'].'", has_ROC="0", notes="'.$sqlnotes.'" WHERE id='.$_POST['modules'];

	if(mysql_query($func, $connection)){

		$id = $_POST['modules'];

		$timefunc = "INSERT INTO times_module_p(assoc_module, received) VALUES($id, \"$date\")";
		echo $timefunc;
		mysql_query($timefunc, $connection);

		echo "<br>";
		echo "The module was successfully added to the database";
	}
	else{
		echo "<br>";
		echo "An error occurred and the module was not added to the database";
	}
}

?>
</form>
<br>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
