<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>HDI Assembly Flow</title>
</head>
<body>
<form action="hdi_proc.php" method="post" enctype="multipart/form-data">
<?php

ini_set('display_error', 'On');
error_reporting(E_ALL | E_STRICT);

include('../../../Submission_p_secure_pages/connect.php');
include('../functions/editfunctions.php');
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');

mysql_query('USE cmsfpix_u', $connection);

$name = $_GET['name'];
$id = findid("HDI_p", $name);
echo "<input type='hidden' name='name' value='".$name."'>";

$search = "SELECT assembly FROM HDI_p WHERE id=$id";
$table = mysql_query($search, $connection);
$row = mysql_fetch_assoc($table);
$assembly = $row['assembly'];

curname("HDI_p", $id);

echo "<input type='hidden' name='assembly' value='$assembly'>";

$steparray = array("Inspected", "Ready for Assembly", "On Module");

$checker = " CHECKED ";
$rework = "";
if($assembly < 0){
	$rework = " DISABLED ";
}

if($assembly == 0){
	echo"Inspected   <input name=\"box\" value=\"inspect\" type=\"checkbox\"".$rework.">";
	echo"User: <input name=\"who\" type=\"text\"".$rework.">   ";
	echo"Comments: <textarea name=\"notes\" ></textarea>   ";
	$checker = "";
}
else{
	echo"Inspected   <input name=\"box\" value=\"inspect\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly == 1){
	echo"Ready for Assembly   <input name=\"box\" value=\"ready\" type=\"checkbox\">";
	echo"OR   Reject   <input name=\"box\" value=\"reject\" type=\"checkbox\">";
	echo"<br>";
	echo"User: <input name=\"who\" type=\"text\">   ";
	echo"Comments: <textarea name=\"notes\" ></textarea>   ";
	$checker = "";
}
else{
	if($assembly > 0){
		$readychecker = " CHECKED ";
		$rejectchecker = "";
	}
	else{
		$readychecker = "";
		$rejectchecker = " CHECKED ";
		$checker = "";
	}
	echo"Ready for Assembly   <input name=\"box\" value=\"ready\"
 	type=\"checkbox\"".$readychecker."DISABLED>";

	echo"Reject   <input name=\"box\" value=\"reject\"
 	type=\"checkbox\"".$rejectchecker."DISABLED>";
}

echo"<br>";

if($assembly == 2){
	echo"On Module   <input name=\"box\" value=\"on\" type=\"checkbox\" DISABLED>";
	echo"Attached to $mod";
	$checker = "";
}
else{
	echo"On Module   <input name=\"box\" value=\"on\"
 	type=\"checkbox\"".$checker."DISABLED>";
}

echo"<br>";

if($assembly > 2){
	echo "Attached to ";
	curmod($id, "HDI_p");
}

if($assembly < 0){
	echo "HDI rejected";
}

if($_GET['code']=="2"){
	echo "Another user has already promoted this part. Your changes have not been added.";
}

echo"<br>";
echo"<br>";

conditionalSubmit(0);

?>
</form>

<br>

<form method="GET" action="assemblypic.php">
<?php
   echo "<input type='hidden' name='part' value='HDI_p'>";
   echo "<input type='hidden' name='id' value='".$id."'>";
?>
<input type="submit" value="Add a Picture">
</form>

<br>

<form method="get" action="../summary/hdi.php">
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
