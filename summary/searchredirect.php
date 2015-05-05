<html>
<?php

include('../../../Submission_p_secure_pages/connect.php');
mysql_query('USE cmsfpix_u', $connection);


$name = $_POST['search'];
$sqlname = mysql_real_escape_string($name);
$htmlname = htmlspecialchars($name);

$loc = $_POST['loc'];
$locsort = "";
$filtermessage = "Any";
if($loc == "purdue"){
	$locsort = "AND location=\"Purdue\"";
	$filtermessage = "Purdue";
}
if($loc == "nebraska"){
	$locsort = "AND location=\"Nebraska\"";
	$filtermessage = "Nebraska";
}


$url = "../summary/";
$urn = "";

$results = array();

$waffunc = "SELECT name, id FROM wafer_p WHERE name LIKE \"%$sqlname%\" ".$locsort;
$sensorfunc = "SELECT name, id FROM sensor_p WHERE name LIKE \"%$sqlname%\" ".$locsort;
$bbmfunc = "SELECT name, id FROM module_p WHERE name LIKE \"%$sqlname%\" ".$locsort;
$hdifunc = "SELECT name, id FROM HDI_p WHERE name LIKE \"%$sqlname%\" ".$locsort;

$wafout = mysql_query($waffunc,$connection);
$sensorout = mysql_query($sensorfunc,$connection);
$bbmout = mysql_query($bbmfunc,$connection);
$hdiout = mysql_query($hdifunc,$connection);

if(mysql_num_rows($wafout)){

	$urn = "wafer.php?name=";
	while($row=mysql_fetch_assoc($wafout)){
		$results[0][]=$row['name'];
		$results[1][]=$row['id'];
		$results[2][]="Wafer";
		$results[3][]=$urn;
	}	
}
if(mysql_num_rows($bbmout)){

	$urn = "bbm.php?name=";
	while($row=mysql_fetch_assoc($bbmout)){
		$results[0][]=$row['name'];
		$results[1][]=$row['id'];
		$results[2][]="Module";
		$results[3][]=$urn;
	}	
}
if(mysql_num_rows($hdiout)){

	$urn = "hdi.php?name=";
	while($row=mysql_fetch_assoc($hdiout)){
		$results[0][]=$row['name'];
		$results[1][]=$row['id'];
		$results[2][]="HDI";
		$results[3][]=$urn;
	}	
}
if(mysql_num_rows($sensorout)){

	$urn = "sensor.php?name=";
	while($row=mysql_fetch_assoc($sensorout)){
		$results[0][]=$row['name'];
		$results[1][]=$row['id'];
		$results[2][]="Sensor";
		$results[3][]=$urn;
	}	
}

?>
<head>
<title>Search Results</title>

</head>
<body>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

<form method="link" action="../summary/list.php">
<input type="submit" value="BACK">
</form>
<br>

<?php


echo "Search string: ".$htmlname;
echo "<br>";
echo "<br>";

echo "Location: ".$filtermessage;
echo "<br>";
echo "<br>";


if(count($results[0]) == 0){
	echo "No results meet those criteria";
}

else{

echo "<table>";

echo "<tr>";

echo "<td>";
echo "<b>Name</b>";
echo "</td>";

echo "<td>";
echo "<b>Part Type</b>";
echo "</td>";

echo "</tr>";

for($i=0;$i<count($results[0]);$i++){
	echo "<tr>";

	echo "<td>";
	echo "<a href='".$url.$results[3][$i].$results[0][$i]."'>".$results[0][$i]."</a>";
	echo "</td>";

	echo "<td>";
	echo $results[2][$i];
	echo "</td>";

	echo "</tr>";
	
}

echo "</table>";
}



?>

<br>
<br>

<form method="link" action="../summary/list.php">
<input type="submit" value="BACK">
</form>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
