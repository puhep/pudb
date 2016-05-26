<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Module Batch #<?php echo $_GET['batch'] ?></title>
</head>
<body>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

<form method="link" action="../summary/modulesbybatch.php">
<input type="submit" value="BACK">
</form>

<?php
include('../../../Submission_p_secure_pages/connect.php');
include_once('../functions/curfunctions.php');

ini_set('display_errors','On');
error_reporting(E_ALL | E_STRICT);

mysql_query("USE cmsfpix_u", $connection);

$week = $_GET['week'];
$ids = array();
$received = array();
$locations = array();

$func0 = "SELECT id,arrival,location,destination,assembly,tested_status FROM module_p where WEEK(DATE_SUB(arrival, INTERVAL 3 DAY))=WEEK(DATE_SUB(\"$week\",INTERVAL 3 DAY))and arrival>\"2015-09-01\" order by assembly DESC,tested_status DESC, destination DESC,location DESC";
$output0 = mysql_query($func0, $connection);

$steparray = array("Expected", "Received", "Inspected", "IV Tested", "Ready for HDI Assembly",  "HDI Attached", "Wirebonded", "Encapsulated", "Tested", "Thermally Cycled", "Tested", "Ready for Shipping", "Shipped", "Ready for Mounting", "On Blade", "Rejected"); 

$m = 0;
while($row0 = mysql_fetch_assoc($output0)){
   $ids[$m] = $row0['id'];
   $received[$m] = $row0['arrival'];
   $locations[$m] = $row0['location'];
   $curlocations[$m] = $row0['destination'];
   $assembly[$m] = $steparray[$row0['assembly']];
   $next_steps[$m] = $row0['tested_status'];
   $m++;
}

echo "<b>".count($ids)." modules in Batch ".$_GET['batch'].":</b><br>";
echo "<table border=1 cellspacing=5>";
echo "<tr>";
echo "<td>";
echo "Module"; 
echo "</td>";
echo "<td>";
echo "Date Received"; 
echo "</td>";
echo "<td>";
echo "Location Received"; 
echo "</td>";
echo "<td>";
echo "Current Location";
echo "</td>";
echo "<td>";
echo "Current Status"; 
echo "</td>";
echo "</tr>";
for($n=0; $n<count($ids); $n++){
	echo "<tr><td>";
	$name = findname("module_p",$ids[$n]);
	echo "<a href=../summary/bbm.php?name=$name>$name</a>";
	echo "</td><td>";
	echo $received[$n];
	echo "</td><td>";
	echo $locations[$n];
	echo "</td><td>";
	echo $curlocations[$n];
	echo "</td><td>";
	if($assembly[$n] != "Shipped"){
		echo $assembly[$n];
	}
	elseif($assembly[$n] == "Shipped" && $next_steps[$n] != NULL){
		echo $next_steps[$n];
	}
	else{
		echo $assembly[$n];
	}
	echo "</td></tr>";
}

?>



<!--
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
-->
</body>
</html>
