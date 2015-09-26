<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Assembly</title>
</head>
<body>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

<br>

<form method="link" action="../assembly/status.php">
<input type="submit" value="BACK">
</form>

<br>

<?php
#ini_set('display_errors', 'On');
#error_reporting(E_ALL | E_STRICT);
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');

include('../../../Submission_p_secure_pages/connect.php');

$hide = hidepre($_GET['part'], 2);

$prepart = $_GET['part'];
$sl = $_GET['sl'];
$part = $prepart."_p";

$sortby = $_GET['sort'];

$func = "SELECT name, id, arrival, shipped, time_created from ".$part." WHERE assembly=".$sl.$hide;


if($part == "wafer_p"){
	$steparray = array("Received", "Inspected", "Tested", "Promoted", "Ready for Shipping", "Shipped");
	$page = "wafer.php";
}
elseif($part == "module_p"){
	$steparray = array("Expected", "Received", "Inspected", "IV Tested", "Ready for HDI Assembly", "HDI Attached", "Wirebonded", "Encapsulated", "Tested", "Thermally Cycled", "Tested", "Ready for Shipping", "Shipped");
	$page = "bbm.php"; 
}
elseif($part == "HDI_p"){
	$steparray = array("Received", "Inspected", "Ready for Assembly", "On Module", "Rejected");
	$page = "hdi.php"; 
}

$num=count($steparray);

mysql_query('USE cmsfpix_u', $connection);

$output = mysql_query($func, $connection);

echo "<table cellspacing=10 border=2>";

echo "<tr valign=top>";

echo "<td valign=top>";
echo "<a href=step.php?sort=nm&part=".$prepart."&sl=".$sl."><b>".$steparray[$sl]."</b></a>";
echo "</td>";

echo "<td valign=top>";
echo "<a href=step.php?sort=lm&part=".$prepart."&sl=".$sl."><b>Last Modified</b></a>";
echo "</td>";

if($part=="module_p" || $part=="HDI_p"){
echo "<td valign=top>";
echo "<a href=step.php?sort=lo&part=".$prepart."&sl=".$sl."><b>Assembly Location</b></a>";
echo "</td>";
}

if($part=="module_p" && $sl==12){
echo "<td valign=top>";
echo "<a href=step.php?sort=as&part=".$prepart."&sl=".$sl."><b>Assembly Date</b></a>";
echo "</td>";

echo "<td valign=top>";
echo "<a href=step.php?sort=sh&part=".$prepart."&sl=".$sl."><b>Ship Date</b></a>";
echo "</td>";

echo "<td valign=top>";
echo "<a href=step.php?sort=de&part=".$prepart."&sl=".$sl."><b>Destination</b></a>";
echo "</td>";
}

echo "</tr>";


$results = array();
$i=0;

while($output && $row = mysql_fetch_assoc($output)){

	$results[0][$i] = $row['name'];
	$results[6][$i] = $row['name'];
	
	if($part=="module_p"){
		$results[0][$i] = findname("module_p",$row['id']);
		$results[6][$i] = findname("module_p",$row['id']);
	}

	$results[1][$i] = $row['time_created'];

	if($part=="module_p" || $part=="HDI_p"){

	$locfunc = "SELECT location FROM ".$part." WHERE id=".$row['id'];
	$locout = mysql_query($locfunc, $connection);
	$locrow = mysql_fetch_assoc($locout);

	$results[2][$i] = $locrow['location'];

	}

	if($part=="module_p" && $sl==12){

	$modfunc = "SELECT destination FROM module_p WHERE id=".$row['id'];
	$modout = mysql_query($modfunc, $connection);
	$modrow = mysql_fetch_assoc($modout);

	$timefunc = "SELECT DATE(HDI_attached) FROM times_module_p WHERE assoc_module=".$row['id'];
	$timeout = mysql_query($timefunc, $connection);
	$timerow = mysql_fetch_assoc($timeout);

	$results[3][$i] = $timerow['DATE(HDI_attached)'];
	$results[4][$i] = $row['shipped'];
	$results[5][$i] = $modrow['destination'];

	}

	$i++;
}

if(!empty($results)){
if($part == "module_p" && $sl == 12){
	if($sortby == "nm"){
		array_multisort($results[6], SORT_ASC, SORT_STRING,$results[1],$results[2],$results[3],$results[4],$results[5],$results[0]);
	}
	if($sortby == "lm"){
		array_multisort($results[1], SORT_DESC, SORT_STRING,$results[6],$results[2],$results[3],$results[4],$results[5],$results[0]);
	}
	if($sortby == "lo"){
		array_multisort($results[2], SORT_ASC, SORT_STRING,$results[6],$results[1],$results[3],$results[4],$results[5],$results[0]);
	}
	if($sortby == "as"){
		array_multisort($results[3], SORT_DESC, SORT_STRING,$results[6],$results[1],$results[2],$results[4],$results[5],$results[0]);
	}
	if($sortby == "sh"){
		array_multisort($results[4], SORT_DESC, SORT_STRING,$results[6],$results[1],$results[2],$results[3],$results[5],$results[0]);
	}
	if($sortby == "de"){
		array_multisort($results[5], SORT_ASC, SORT_STRING,$results[6],$results[1],$results[2],$results[3],$results[4],$results[0]);
	}
}
else if($part == "module_p" || $part == "HDI_p"){
	if($sortby == "nm"){
		array_multisort($results[0], SORT_ASC, SORT_STRING,$results[1],$results[2],$results[6]);
	}
	if($sortby == "lm"){
		array_multisort($results[1], SORT_DESC, SORT_STRING,$results[0],$results[2],$results[6]);
	}
	if($sortby == "lo"){
		array_multisort($results[2], SORT_ASC, SORT_STRING,$results[0],$results[1],$results[6]);
	}
}
else{
	if($sortby == "nm"){
		array_multisort($results[0], SORT_ASC, SORT_STRING, $results[1],$results[6]);
	}
	if($sortby == "lm"){
		array_multisort($results[1], SORT_DESC, SORT_STRING, $results[0],$results[6]);
	}
}
}

for($loop=0;$loop<$i;$loop++){

	echo "<tr valign=top>";

	echo "<td valign=top>";
	echo "<a href=\"../summary/".$page."?name=".$results[0][$loop]."\">".$results[6][$loop]."</a>";
	echo "</td>";

	echo "<td valign=top>";
	echo $results[1][$loop];
	echo "</td>";

	if($part=="module_p" || $part=="HDI_p"){
	
	echo "<td valign=top>";
	echo $results[2][$loop];
	echo "</td>";
	}

	if($part=="module_p" && $sl==12){

	echo "<td valign=top>";
	echo $results[3][$loop];
	echo "</td>";

	echo "<td valign=top>";
	echo $results[4][$loop];
	echo "</td>";

	echo "<td valign=top>";
	echo $results[5][$loop];
	echo "</td>";
	}

	echo "</tr>";
}
echo "</table>";

?>

<br>

<form method="link" action="../assembly/status.php">
<input type="submit" value="BACK">
</form>

<br>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
