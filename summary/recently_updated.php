<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Recently Updated</title>
</head>
<body>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');


$func = "SELECT name, id, time_created from module_p ORDER BY time_created DESC";
$i=0;
$j=0;
$dataarray;

mysql_query('USE cmsfpix_u', $connection);

$output = mysql_query($func, $connection);
while($row = mysql_fetch_assoc($output)){
	$dataarray[0][$i] = $row['name'];
	$dataarray[1][$i] = $row['id'];
	$dataarray[2][$i] = $row['time_created'];
	$i++;
}

echo "<br>";

echo "Recently Updated Modules:";

#echo "<table cellspacing=60 border=0>";
echo "<table cellspacing=20 border=0>";
	echo "<tr>";

	echo "<td>";
	echo "Module Name";
	echo "</td>";

	echo "<td>";
	echo "Last Updated";
	echo "</td>";

	echo "</tr>";


	for($k=0; $k<10; $k++){

			echo "<tr>";

			echo "<td>";
			echo "<a href=\"bbm.php?name=".$dataarray[0][$k]."\">".$dataarray[0][$k]."</a>";
			echo "</td>";

			echo "<td>";
			echo $dataarray[2][$k];
			echo "</td>";

			echo "</tr>";

	}
	echo "</table>";

echo"<br>";
echo"<br>";
?>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
