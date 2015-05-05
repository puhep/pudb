<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php
	ini_set('display_error', 'On');
	error_reporting(E_ALL | E_STRICT);

	include('../functions/curfunctions.php');
	include('../functions/popfunctions.php');
	include('../graphing/fullwafer_crit.php');

	$name = $_GET['name'];
	$part = "wafer_p";
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

		#echo "<h>";
		#echo "Arrival Date: ";
		#echo "</h>";
		#echo $dumped['arrival'];
		#echo "<br>";
		#echo "<br>";

		echo "<h>";
		echo "Status: ";
		echo "</h>";
		curstep("wafer",$dumped['assembly']);
		echo "<br>";
		echo "<a href=\"../assembly/wafer.php?name=$name\">Update Status</a>";
		echo "<br>";
		echo "<br>";

		echo "<h>";
		echo "Last Modified: ";
		echo "</h>";
		echo $dumped['time_created'];
		echo "<br>";
		echo "<br>";

		echo "<h>";
		echo "Vendor: ";
		echo "</h>";
		echo $dumped['vendor'];
		echo "<br>";
		echo "<br>";

		echo "<h>";
		echo "Thickness: ";
		echo "</h>";
		echo $dumped['thickness'];
		echo "<br>";
		echo "<br>";

		echo "<h>";
		echo "Comprised of:";
		echo "</h>";
		echo "<br>";
		sensorlist($id);
		echo "<br>";
		echo "<br>";



		echo "<h>";
		echo "IV Scans:";
		echo "</h>";
		echo "<br>";
		echo "<br>";


		echo "<table>";

		#echo "Diodes";
		#echo "<br>";
		#echo "<a href=\"../graphing/fullwafer.php?scan=IV&partid=$id&type=D\" target=\"_blank\"><img src=\"../graphing/fullwafer.php?scan=IV&partid=$id&type=D\" width=\"355\" height=\"200\" /></a>";
		#echo "<br>";
		#echo "<br>";

		echo "<tr>";

		echo "<td>";
		echo "2x8s";
		echo "</td>";

		echo "<td>";
		echo "1x1s";
		echo "</td>";

		echo "</tr>";


		echo "<tr>";

		echo "<td>";
		echo "<a href=\"../graphing/fullwafer.php?scan=IV&partid=$id&type=L\" target=\"_blank\"><img src=\"../graphing/fullwafer.php?scan=IV&partid=$id&type=L\" width=\"355\" height=\"200\" /></a>";
		echo "</td>";

		echo "<td>";
		echo "<a href=\"../graphing/fullwafer.php?scan=IV&partid=$id&type=S\" target=\"_blank\"><img src=\"../graphing/fullwafer.php?scan=IV&partid=$id&type=S\" width=\"355\" height=\"200\" /></a>";
		echo "</td>";

		echo "</tr>";

		echo "</table>";

		#echo "<br>";
		#echo "<br>";
		echo "<br>";
		fullwafer_crit($id, "L", "IV");
		echo "<br>";
		echo "<br>";

		if($dumped['assembly'] == 5){
			echo "<h>";
			echo "Approval Document";
			echo "</h>";
			echo "<br>";
			echo "<form><input type=\"button\" value=\"Approved Sensors\" onClick=\"window.location.href='../download/wafercsvdl.php?id=$id'\"></form>";
			echo "<br>";
			echo "<br>";
		}
			

		curpics($part, $id);
		echo "<br>";
		echo "<br>";


		echo "<notes>";
		echo "<h>";
		echo "Notes: ";
		echo "</h>";
		echo "<br>";
		curnotes("wafer_p", $id);
		echo "</notes>";
		echo "<br>";
		echo "<br>";


?>
<p>
<form method="post" action="summarycomment.php">
<?php
  echo "<input type='hidden' name='part' value='".$part."'>";
  echo "<input type='hidden' name='id' value='".$id."'>";
?>
<input type="submit" value="Add Comment to This Part">
</form>

<form method="post" action="summarypic.php">
<?php
  echo "<input type='hidden' name='part' value='".$part."'>";
  echo "<input type='hidden' name='id' value='".$id."'>";
?>
<input type="submit" value="Add Picture to This Part">
</form>

<form method="get" action="../assembly/wafer.php">
<?php
  echo "<input type='hidden' name='name' value='".$name."'>";
?>
<input type="submit" value="Part Assembly Flow">
</form>

<form method="link" action="../assembly/status.php">
<input type="submit" value="BACK">
</form>
</p>
</body>
</html>
