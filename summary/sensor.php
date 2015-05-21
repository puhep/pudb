<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php
	ini_set('display_error', 'On');
	error_reporting(E_ALL | E_STRICT);

	include('../functions/curfunctions.php');

	$name = $_GET['name'];
	$part = "sensor_p";
	$id = findid($part, $name);
	$names = namedump($part, $id);

	$dumped = dump($part, $id);
?>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <link rel="stylesheet" type="text/css" href="../css/summary3.css" />
  <?php
	echo "<title>";
	echo $dumped['name'];
	echo " Summary";
	echo "</title>";
  ?>
</head>
<body>
<?php


		echo "<part>";
		echo $dumped['name'];
		echo "</part>";
		echo "<br>";
		echo "<br>";

		echo "<h>";
		echo "Last Modified: ";
		echo "</h>";
		echo $dumped['time_created'];
		echo "<br>";
		echo "<br>";

		echo "<h>";
		echo "From Wafer: ";
		echo "</h>";
		echo "<br>";
		$wafid = $names['wafer'];
		echo "<a href=\"wafer.php?name=".$wafid."\">$wafid</a>";
		
		echo "<br>";
		echo "<br>";
		echo "<h>";
		echo "On Module: ";
		echo "</h>";
		echo "<br>";
		curmod($id,$part);
		echo "<br>";
		echo "<br>";

		echo "<h>";
		echo "IV/CV Scans: ";
		echo "</h>";
		echo "<br>";
		curgraphs($id,"IV","sensor");
		echo "<br>";
		echo "<br>";
		xmlbuttongen($id, "IV","sensor");
		echo "<br>";
		#echo <a href="../download/XMLfile.php?id=$id&part=sensor&scan=IV>All IV scans</a>";
		echo "<br>";
		echo "<br>";

		curgraphs($id,"CV");
		echo "<br>";
		echo "<br>";
		xmlbuttongen($id,"CV");
		echo "<br>";
		echo "<br>";

		curpics($part, $id);
		echo "<br>";
		echo "<br>";

		echo "<h>";
		echo "Notes: ";
		echo "</h>";
		echo "<br>";
		curnotes("sensor_p", $id);
		echo "<br>";
		echo "<br>";


?>

<form method="get" action="summarycomment.php">
<?php
  echo "<input type='hidden' name='part' value='".$part."'>";
  echo "<input type='hidden' name='id' value='".$id."'>";
?>
<input type="submit" value="Add Comment to This Part">
</form>

<form method="get" action="summarypic.php">
<?php
  echo "<input type='hidden' name='part' value='".$part."'>";
  echo "<input type='hidden' name='id' value='".$id."'>";
?>
<input type="submit" value="Add Picture to This Part">
</form>

<form method="link" action="../assembly/status.php">
<input type="submit" value="BACK">
</form>
</body>
</html>
