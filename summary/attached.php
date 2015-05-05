<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Exploded Module View</title>
</head>
<body>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
<br>

<?php
#ini_set('display_errors', 'On');
#error_reporting(E_ALL | E_STRICT);
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');
  include('../graphing/xmlgrapher_crit.php');
include('../../../Submission_p_secure_pages/connect.php');


$sortby = $_GET['sort'];


$bbmfunc = "SELECT name, id, assembly, assoc_sens, bonder, location, time_created from module_p WHERE name LIKE 'M%' ORDER BY name";

$partarray = array("Module","Location", "Bonder", "HDI", "Sensor", "ROCs", "IV Scans", "Criteria", "Date Assembled", "Last Modified");
$sortarray = array("mod", "loc", "fcb", "hdi", "sen", "", "", "", "dat", "lm");


$i=0;
$k=0;
$k_adj=0;
$l=0;

mysql_query('USE cmsfpix_u', $connection);

$output = mysql_query($bbmfunc, $connection);
while($row = mysql_fetch_assoc($output)){

	$timefunc = "SELECT HDI_attached FROM times_module_p WHERE assoc_module=".$row['id'];
	$timeout = mysql_query($timefunc, $connection);
	$timerow = mysql_fetch_assoc($timeout);

	$bbmarray[0][$k] = $row['name'];
	$bbmarray[1][$k] = $row['id'];
	$bbmarray[2][$k] = $row['assembly'];
	$bbmarray[3][$k] = $row['assoc_sens'];
	$bbmarray[4][$k] = $timerow['HDI_attached'];

	$names = namedump("module_p",$bbmarray[1][$k]); 
	$bbmarray[5][$k] = $names['sensor'];
	$bbmarray[6][$k] = $names['hdi'];
	$bbmarray[7][$k] = $row['bonder'];
	$bbmarray[8][$k] = $row['location'];
	$bbmarray[9][$k] = $row['time_created'];
	$bbmarray[10][$k] = findname("module_p", $row['id']);

	if($bbmarray[2][$k] != 0){
		$k_adj++;
	}
	$k++;

}

if($sortby == "mod"){
	#SORTING ALREADY DONE
}
if($sortby == "hdi"){
	array_multisort($bbmarray[6], SORT_ASC, SORT_STRING,$bbmarray[0],$bbmarray[1],$bbmarray[2],$bbmarray[3],$bbmarray[4],$bbmarray[5],$bbmarray[7],$bbmarray[8],$bbmarray[9]);
}
if($sortby == "sen"){
	array_multisort($bbmarray[5], SORT_ASC, SORT_STRING,$bbmarray[0],$bbmarray[1],$bbmarray[2],$bbmarray[3],$bbmarray[4],$bbmarray[6],$bbmarray[7],$bbmarray[8],$bbmarray[9]);
}
if($sortby == "dat"){
	array_multisort($bbmarray[4], SORT_ASC, SORT_STRING,$bbmarray[0],$bbmarray[1],$bbmarray[2],$bbmarray[3],$bbmarray[5],$bbmarray[6],$bbmarray[7],$bbmarray[8],$bbmarray[9]);
}
if($sortby == "fcb"){
	array_multisort($bbmarray[7], SORT_ASC, SORT_STRING,$bbmarray[4], SORT_ASC, SORT_STRING, $bbmarray[0],$bbmarray[1],$bbmarray[2],$bbmarray[3],$bbmarray[5],$bbmarray[6],$bbmarray[8],$bbmarray[9]);
}
if($sortby == "loc"){
	array_multisort($bbmarray[8], SORT_ASC, SORT_STRING,$bbmarray[4], SORT_ASC, SORT_STRING, $bbmarray[0],$bbmarray[1],$bbmarray[2],$bbmarray[3],$bbmarray[5],$bbmarray[6],$bbmarray[7],$bbmarray[9]);
}
if($sortby == "lm"){
	array_multisort($bbmarray[9], SORT_ASC, SORT_STRING,$bbmarray[4], SORT_ASC, SORT_STRING, $bbmarray[0],$bbmarray[1],$bbmarray[2],$bbmarray[3],$bbmarray[5],$bbmarray[6],$bbmarray[7],$bbmarray[8]);
}



echo "<table cellspacing=20 border=2>";

echo "<tr valign=top>";

for($loop=0;$loop<count($partarray);$loop++){

echo "<td valign=middle>";
echo "<a href=../summary/attached.php?sort=".$sortarray[$loop].">".$partarray[$loop]."</a>";
echo "</td>";

}

echo "</tr>";

for($loop=0; $loop<$k; $loop++){

echo "<tr>";

echo "<td valign=middle>";
echo "<a href=../summary/bbm.php?name=".$bbmarray[0][$loop].">".$bbmarray[10][$loop]."</a>";
echo "</td>";

echo "<td valign=middle>";
echo $bbmarray[8][$loop];
echo "</td>";

echo "<td valign=middle>";
echo $bbmarray[7][$loop];
echo "</td>";

echo "<td valign=middle>";
echo "<a href=../summary/hdi.php?name=".$bbmarray[6][$loop].">".$bbmarray[6][$loop]."</a>";
echo "</td>";

echo "<td valign=middle>";
echo "<a href=../summary/sensor.php?name=".$bbmarray[5][$loop].">".$bbmarray[5][$loop]."</a>";
echo "</td>";

echo "<td valign=middle>";
currocs($bbmarray[1][$loop]);
echo "</td>";

echo "<td valign=middle>";
curgraphs($bbmarray[3][$loop], "IV", "module");
echo "</td>";

echo "<td valign=middle>";
xmlgrapher_crit($bbmarray[3][$loop], "IV", "module");
echo "</td>";

echo "<td valign=middle>";
echo $bbmarray[4][$loop];
echo "</td>";

echo "<td valign=middle>";
echo $bbmarray[9][$loop];
echo "</td>";

echo "</tr>";
}

echo "</table>";

?>
<br>
<br>
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
