<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Module Assembly Flow</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
<?php

ini_set('display_error', 'On');
error_reporting(E_ALL | E_STRICT);

include('../../../Submission_p_secure_pages/connect.php');
include('../functions/editfunctions.php');
include('../functions/curfunctions.php');
include('../functions/popfunctions.php');
include('../functions/submitfunctions.php');


mysql_query('USE cmsfpix_u', $connection);

$name = $_GET['name'];
$id = findid("module_p", $name);
echo "<input type='hidden' name='id' value='".$_GET['id']."'>";

$search = "SELECT name, assembly, destination FROM module_p WHERE id=$id";
$table = mysql_query($search, $connection);
$row = mysql_fetch_assoc($table);
$assembly = $row['assembly'];
curname("module_p", $id);


$steparray = array("Received", "Inspected", "IV Tested", "Ready for HDI Assembly", "HDI Attached", "Wirebonded", "Encapsulated", "Tested", "Thermally Cycled", "Tested", "Ready for Shipping", "Shipped");

if(isset($_POST['submit']) && ((isset($_POST['box']) && $_POST['who'] != "") || (isset($_POST['shipbox']) && $_POST['who_ship'] != "")) && (!is_null($_POST['hdi']) || $assembly!=4)){
	
	if(isset($_POST['shipbox'])){
		$assembly = 11;
	}
	
	if(isset($_POST['shipbox'])){
	$submittedstep = $steparray[$assembly]." by ".$_POST['who_ship']." to ".$_POST['dest'];
	}
	else{
	$submittedstep = $steparray[$assembly]." by ".$_POST['who'];
	}
	$assembly++;
	
	milestone("module_p", $id, $assembly);


	if(isset($_POST['shipbox'])){
		if($_POST['notes_ship']!=""){
			$submittednotes = $_POST['notes_ship'];
		}
	}
	else{
		if($_POST['notes']!=""){
			$submittednotes = $_POST['notes'];
		}
	}
	addcomment("module_p", $id, $submittedstep);
	addcomment("module_p", $id, $submittednotes);
	$funcassembly = "UPDATE module_p SET assembly=$assembly WHERE id=$id";
	$funcship = "UPDATE module_p SET shipped=\"".$_POST['date']."\", destination=\"".$_POST['dest']."\" WHERE id=$id";
	mysql_query($funcassembly, $connection);
	mysql_query($funcship, $connection);
	
	if($assembly==5){
		$hdi = $_POST['hdi'];
		$newname = "M".substr($row['name'], 2);
		$funchdi = "UPDATE HDI_p SET module=$id WHERE id=$hdi";
		$funchdi2 = "UPDATE HDI_p SET assembly=3 WHERE id=$hdi";
		$funcmod = "UPDATE module_p SET assoc_HDI=$hdi WHERE id=$id";
		$funcmod2 = "UPDATE module_p SET name=\"$newname\" WHERE id=$id";
		mysql_query($funchdi, $connection);
		mysql_query($funchdi2, $connection);
		mysql_query($funcmod, $connection);
		mysql_query($funcmod2, $connection);

		generateHDImodulename($id);

		milestone("HDI_p", $hdi, 3);
	}
}

$checker = " CHECKED ";

if($assembly == 0){
	echo"Received   <input name=\"box\" value=\"rec\" type=\"checkbox\">";
	echo"User: <input name=\"who\" type=\"text\">   ";
	echo"Comments: <textarea name=\"notes\"></textarea>   ";
	$checker = "";
}
else{
	echo"Received   <input name=\"box\" value=\"rec\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly == 1){
	echo"Inspected   <input name=\"box\" value=\"inspect\" type=\"checkbox\">";
	echo"User: <input name=\"who\" type=\"text\">   ";
	echo"Comments: <textarea name=\"notes\"></textarea>   ";
	$checker = "";
}
else{
	echo"Inspected   <input name=\"box\" value=\"inspect\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly == 2){
	echo"IV Tested   <input name=\"box\" value=\"iv\" type=\"checkbox\">";
	echo"User: <input name=\"who\" type=\"text\">   ";
	echo"Comments: <textarea name=\"notes\"></textarea>   ";
	$checker = "";
}
else{
	echo"IV Tested   <input name=\"box\" value=\"iv\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly == 3){
	echo"Ready for HDI Assembly   <input name=\"box\" value=\"HDIready\" type=\"checkbox\">";
	echo"User: <input name=\"who\" type=\"text\">   ";
	echo"Comments: <textarea name=\"notes\"></textarea>   ";
	$checker = "";
}
else{
	echo"Ready for HDI Assembly   <input name=\"box\" value=\"HDIready\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly == 4){
	echo"HDI Attached   <input name=\"box\" value=\"hdi\" type=\"checkbox\">";
	echo"HDI: <select name=\"hdi\">";
	availhdi();
	echo"</select>";
	echo"User: <input name=\"who\" type=\"text\">   ";
	echo"Comments: <textarea name=\"notes\"></textarea>   ";
	$checker = "";
}
else{
	echo"HDI Attached   <input name=\"box\" value=\"hdi\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly == 5){
	echo"Wirebonded   <input name=\"box\" value=\"wb\" type=\"checkbox\">";
	echo"User: <input name=\"who\" type=\"text\">   ";
	echo"Comments: <textarea name=\"notes\"></textarea>   ";
	$checker = "";
}
else{
	echo"Wirebonded   <input name=\"box\" value=\"wb\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly == 6){
	echo"Encapsulated   <input name=\"box\" value=\"encapsulate\" type=\"checkbox\">";
	echo"User: <input name=\"who\" type=\"text\">   ";
	echo"Comments: <textarea name=\"notes\"></textarea>   ";
	$checker = "";
}
else{
	echo"Encapsulated   <input name=\"box\" value=\"encapsulate\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly == 7){
	echo"Tested   <input name=\"box\" value=\"test2\" type=\"checkbox\">";
	echo"User: <input name=\"who\" type=\"text\">   ";
	echo"Comments: <textarea name=\"notes\"></textarea>   ";
	$checker = "";
}
else{
	echo"Tested   <input name=\"box\" value=\"test2\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

If($assembly == 8){
	echo"Thermally Cycled    <input name=\"box\" value=\"thermal\" type=\"checkbox\">";
	echo"User: <input name=\"who\" type=\"text\">   ";
	echo"Comments: <textarea name=\"notes\"></textarea>   ";
	$checker = "";
}
else{
	echo"Thermally Cycled    <input name=\"box\" value=\"thermal\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly == 9){
	echo"Tested    <input name=\"box\" value=\"test3\" type=\"checkbox\">";
	echo"User: <input name=\"who\" type=\"text\">   ";
	echo"Comments: <textarea name=\"notes\"></textarea>   ";
	$checker = "";
}
else{
	echo"Tested    <input name=\"box\" value=\"test3\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly == 10){
	echo"Ready for Shipping    <input name=\"box\" value=\"ready\" type=\"checkbox\">";
	echo"User: <input name=\"who\" type=\"text\">   ";
	echo"Comments: <textarea name=\"notes\"></textarea>   ";
	$checker = "";
}
else{
	echo"Ready for Shipping    <input name=\"box\" value=\"ready\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly >= 6 && $assembly <= 11){
	echo"Shipped    <input name=\"shipbox\" value=\"ship\" type=\"checkbox\">";
	echo"User: <input name=\"who_ship\" type=\"text\">   ";
	echo"Comments: <textarea name=\"notes_ship\"></textarea>   ";
	echo"Destination: <input name=\"dest\" type=\"text\">   ";
	echo"Date (yyyy/mm/dd): <input name=\"date\" type=\"text\">   ";
	$checker = "";
}
else{
	echo"Shipped    <input name=\"shipbox\" value=\"ship\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly > 11){
	echo "Module fully assembled and shipped to ".$row['destination'];
}

echo"<br>";

conditionalSubmit(0);

?>
</form>

<br>

<form method="post" action="assemblypic.php">
<?php
   echo "<input type='hidden' name='part' value='module_p'>";
   echo "<input type='hidden' name='id' value='".$id."'>";
?>
<input type="submit" value="Add a Picture">
</form>

<br>

<form method="get" action="../summary/bbm.php">
<?php
   echo "<input type='hidden' name='name' value='".$name."'>";
?>
<input type="submit" value="Part Summary">
</form>

<br>

<form method="link" action="status.php">
<input type="submit" value="Assembly Status">
</form>

<br>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
</body>
</html>
