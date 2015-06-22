<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php 
	ini_set('display_error', 'On');
	error_reporting(E_ALL | E_STRICT);


	include('../functions/curfunctions.php');
	include('../graphing/xmlgrapher_crit.php');

	$name = $_GET['name'];
	$part = "module_p";
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
	echo findname("module_p",$id);
	echo " Summary";
	echo "</title>";
  ?>
</head>
<body>
<?php

		echo "<part>";
		echo findname("module_p",$id);
		echo "</part>";
		echo "<br>";
		echo "<br>";

		#echo "<h>";
		#echo "Arrival Date:";
		#echo "</h>";
		#echo $dumped['arrival'];
		#echo "<br>";
		#echo "<br>";

		if($dumped['assembly'] != 12){
		echo "<h>";
		echo "Processing at: ";
		echo "</h>";
		}
		else{
		echo "<h>";
		echo "Processed at: ";
		echo "</h>";
		}

		echo $dumped['location'];
		echo "<br>";
		echo "<br>";

		if($dumped['assembly'] == 12){
		echo "<h>";
		echo "Current Location: ";
		echo "</h>";
		echo $dumped['destination'];
		echo "<br>";
		echo "<a href=\"../submit/updatelocation.php?name=$name\">Update Location</a>";
		echo "<br>";
		echo "<br>";
		}

		echo "<h>";
		echo "Flip-Chip Bonder: ";
		echo "</h>";
		echo $dumped['bonder'];
		echo "<br>";
		echo "<a href=\"../submit/updatebonder.php?name=$name\">Update Bonder</a>";
		echo "<br>";
		echo "<br>";

		echo "<h>";
		echo "Status: ";
		echo "</h>";
		curstep("module", $dumped['assembly']);
		echo "<br>";
		echo "<a href=\"../assembly/bbm.php?name=$name\">Update Status</a>";
		echo "<br>";
		echo "<br>";

		echo "<form method=\"GET\" action=\"summaryFull.php\">";
   		echo "<input type='hidden' name='name' value='".$name."'>";
		echo "<input type=\"submit\" value=\"Full Test Summary\">";
		echo "</form>";
		echo "<br>";

		echo "<h>";
		echo "Last Modified: ";
		echo "</h>";
		echo $dumped['time_created'];
		echo "<br>";
		echo "<br>";

		echo "<h>";
		echo "Comprised of:";
		echo "</h>";
		echo "<br>";
		$sensid = $names['sensor'];
		$hdiid = $names['hdi'];
		echo "Sensor: <a href=\"sensor.php?name=".$sensid."\">$sensid</a>";
		echo "<br>";
		echo "HDI: <a href=\"hdi.php?name=".$hdiid."\">$hdiid</a>";
		echo "<br>";
		echo "ROCs:";
		echo "<br>";
		currocs($dumped['id']);
		echo "<br>";

		echo "<table>";
		echo "<tr>";

		echo "<td>";
		echo "<h>";
		echo "IV/CV Scans:";
		echo "</h>";
		echo "</td>";

		echo "<td>";
		echo "</td>";

		echo "</tr>";
		echo "<tr>";

		echo "<td>";
		curgraphs($dumped['assoc_sens'], "IV", "module");
		echo "<br>";
		echo "</td>";

		echo "<td>";
		xmlgrapher_crit($dumped['assoc_sens'], "IV", "module");
		echo "</td>";

		echo "</tr>";
		echo "</table>";	

		xmlbuttongen($dumped['assoc_sens'], "IV");
		echo "<br>";
		echo "<br>";

		curgraphs($dumped['assoc_sens'], "CV", "module");
		echo "<br>";
		echo "<br>";
		xmlbuttongen($dumped['assoc_sens'], "CV");
		echo "<br>";
		echo "<br>";

		#echo "<h>";
		#echo "DAQ Data:";
		#echo "</h>";
		#echo "<br>";
		#daqdump($id);
		#echo "<br>";
		#echo "<br>";
		#echo "<br>";

		curpics($part, $id);
		echo "<br>";
		echo "<br>";

		echo "<notes>";
		echo "<h>";
		echo "Notes: ";
		echo "</h>";
		echo "<br>";
		curnotes("module_p", $id);
		echo "</notes>";
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

<form method="get" action="../assembly/bbm.php">
<?php
   echo "<input type='hidden' name='name' value='".$name."'>";
?>
<input type="submit" value="Part Assembly Flow">
</form>

<form method="link" action="../assembly/status.php">
<input type="submit" value="Assembly Status">
</form>
<form method="link" action="test_list.php">
<input type="submit" value="Tested Module List">
</form>
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
</body>
</html>
