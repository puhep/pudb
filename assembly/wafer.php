<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Wafer Assembly Flow</title>
</head>
<body>
<form action="wafer_proc.php" method="post" enctype="multipart/form-data">
<?php

ini_set('display_error', 'On');
error_reporting(E_ALL | E_STRICT);

include('../../../Submission_p_secure_pages/connect.php');
include('../functions/editfunctions.php');
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');


mysql_query('USE cmsfpix_u', $connection);

$name = $_GET['name'];
$id = findid("wafer_p", $name);
echo "<input type='hidden' name='name' value='".$name."'>";

$search = "SELECT assembly,name FROM wafer_p WHERE id=$id";
$table = mysql_query($search, $connection);
$row = mysql_fetch_assoc($table);
$assembly = $row['assembly'];

curname("wafer_p", $id);

 echo "<input type='hidden' name='assembly' value='$assembly'>";


$steparray = array("Inspected", "Tested", "Promoted", "Ready for Shipping", "Shipped");

$checker = " CHECKED ";
$rework = "";
#if($assembly < 0){
	#$rework = " DISABLED ";
#}

if($assembly == 0){
	echo"Inspected   <input name=\"box\" value=\"insp\" type=\"checkbox\"".$rework.">";
	echo"User: <input name=\"who\" type=\"text\"".$rework.">   ";
	echo"Comments: <textarea name=\"notes\" ".$rework."></textarea>   ";
	$checker = "";
}  
else{
	echo"Inspected   <input name=\"box\" value=\"insp\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly == 1){
	echo"Tested   <input name=\"box\" value=\"test\" type=\"checkbox\"".$rework.">";
	echo"User: <input name=\"who\" type=\"text\"".$rework.">   ";
	echo"Comments: <textarea name=\"notes\" ".$rework."></textarea>   ";
	$checker = "";
}
else{
	echo"Tested   <input name=\"box\" value=\"test\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly == 2){
	echo"Promoted   <input name=\"box\" value=\"promote\" type=\"checkbox\"".$rework.">";
	echo"User: <input name=\"who\" type=\"text\"".$rework.">   ";
	echo"Comments: <textarea name=\"notes\" ".$rework."></textarea>   ";
	$checker = "";
	promoteBoxes($id);
}
else{
	echo"Promoted   <input name=\"box\" value=\"promote\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly == 3){
	echo"Ready for Shipping   <input name=\"box\" value=\"ready\" type=\"checkbox\"".$rework.">";
	echo"User: <input name=\"who\" type=\"text\"".$rework.">   ";
	echo"Comments: <textarea name=\"notes\" ".$rework."></textarea>   ";
	$checker = "";
}
else{
	echo"Ready for Shipping   <input name=\"box\" value=\"ready\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly == 4){
	echo"Shipped   <input name=\"box\" value=\"ship\" type=\"checkbox\"".$rework.">";
	echo"User: <input name=\"who\" type=\"text\"".$rework.">   ";
	echo"Comments: <textarea name=\"notes\" ".$rework."></textarea>   ";
	$checker = "";
}
else{
	echo"Shipped   <input name=\"box\" value=\"ship\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly > 4){
	echo "Wafer fully tested and shipped";
}

if($_GET['code']=="2"){
	echo "Another user has already promoted this part. Your changes have not been added";
}

echo"<br>";
echo"<br>";

conditionalSubmit(0);

?>
</form>

<br>

<form method="GET" action="assemblypic.php">
<?php
   echo "<input type='hidden' name='part' value='wafer_p'>";
   echo "<input type='hidden' name='id' value='".$id."'>";
?>
<input type="submit" value="Add a Picture">
</form>

<br>

<form method="get" action="../summary/wafer.php">
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
