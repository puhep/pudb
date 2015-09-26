<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Module Assembly Flow</title>
</head>
<body>
<form action="bbm_proc.php" method="post" enctype="multipart/form-data">
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
echo "<input type='hidden' name='name' value='".$name."'>";

$search = "SELECT name, assembly, destination FROM module_p WHERE id=$id";
$table = mysql_query($search, $connection);
$row = mysql_fetch_assoc($table);
$assembly = $row['assembly'];
curname("module_p", $id);

echo "<input type='hidden' name='assembly' value='$assembly'>";

$steparray = array("Received", "Inspected", "IV Tested", "Ready for HDI Assembly", "HDI Attached", "Wirebonded", "Encapsulated", "Tested", "Thermally Cycled", "Tested", "Ready for Shipping", "Shipped");

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
	echo"Comments File: <input name=\"comments\" type=\"file\">    ";
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
	echo"Comments File: <input name=\"comments\" type=\"file\">    ";
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
	echo"Comments File: <input name=\"comments\" type=\"file\">    ";
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
	echo"Comments File: <input name=\"comments\" type=\"file\">    ";
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
	echo"Comments File: <input name=\"comments\" type=\"file\">    ";
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
	echo"Comments File: <input name=\"comments\" type=\"file\">    ";
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
	echo"Comments File: <input name=\"comments\" type=\"file\">    ";
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
	echo"Comments File: <input name=\"comments\" type=\"file\">    ";
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
	echo"Comments File: <input name=\"comments\" type=\"file\">    ";
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
	echo"Comments File: <input name=\"comments\" type=\"file\">    ";
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
	echo"Comments File: <input name=\"comments\" type=\"file\">    ";
	echo"Destination: <input name=\"dest\" type=\"text\">   ";
	echo"Date (yyyy/mm/dd): <textarea cols='10' rows='1'  name=\"date\">".date('Y/m/d')."</textarea>    ";
	echo"Tracking Number: <input name=\"track\" type=\"text\">   ";
	echo"Notify Recipient: <input name=\"recipient\" type=\"text\">   ";
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

if($_GET['code']=="2"){
	echo "Another user has already promoted this part. Your changes have not been added.";
}

echo"<br>";

conditionalSubmit(0);

?>
</form>

<br>

<form method="GET" action="assemblypic.php">
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
