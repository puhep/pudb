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

<form name="filter" action="../summary/recently_updated.php" method="GET">
Enter number of modules to display:
<br>
<textarea name="num" cols="10" rows="1"><?php if($_GET['num']==""){echo 40;} else{ echo $_GET['num'];} ?></textarea>
<br>
<input type="submit" value="Apply">
</form>

<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');

$hide = hidepre("module",2);

$func = "SELECT name, id, time_created, last_user, last_update, last_comment, destination from module_p WHERE assembly>0 AND (name NOT LIKE '%95%' AND name NOT LIKE '%96%' AND name NOT LIKE '%97%')".$hide." ORDER BY time_created DESC";
$i=0;
$j=0;
$dataarray;

mysql_query('USE cmsfpix_u', $connection);

$output = mysql_query($func, $connection);
while($row = mysql_fetch_assoc($output)){
	$dataarray[0][$i] = findname("module_p",$row['id']);
	$dataarray[1][$i] = $row['id'];
	$dataarray[2][$i] = $row['time_created'];
	$dataarray[3][$i] = $row['last_user'];
	$dataarray[4][$i] = $row['last_update'];
	$dataarray[5][$i] = $row['last_comment'];
	$dataarray[6][$i] = $row['destination'];
	$i++;
}

echo "<br>";

echo "<b>Recently Updated Modules:</b>";

echo "<table cellspacing=20 border=0>";
	echo "<tr>";

	echo "<td>";
	echo "Module Name";
	echo "</td>";

	echo "<td>";
	echo "Last Updated";
	echo "</td>";

	echo "<td>";
	echo "Current Location";
	echo "</td>";

	echo "<td>";
	echo "User";
	echo "</td>";

	echo "<td>";
	echo "Update";
	echo "</td>";

	echo "<td>";
	echo "Comments";
	echo "</td>";

	echo "</tr>";

        if($_GET['num'] != ""){$num = $_GET['num']; }
        else{ $num = 40; }
	for($k=0; $k<$num; $k++){

			echo "<tr>";

			echo "<td>";
			echo "<a href=\"bbm.php?name=".$dataarray[0][$k]."\">".$dataarray[0][$k]."</a>";
			echo "</td>";

			echo "<td>";
			echo $dataarray[2][$k];
			echo "</td>";

			echo "<td>";
			echo $dataarray[6][$k];
			echo "</td>";

			echo "<td>";
			echo $dataarray[3][$k];
			echo "</td>";

			echo "<td>";
			echo $dataarray[4][$k];
			echo "</td>";

			echo "<td>";
			echo $dataarray[5][$k];
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
