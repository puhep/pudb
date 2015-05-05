<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Summary</title>
</head>
<body>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
<br>
<form name="searcher" action="../summary/searchredirect.php" method="post">
Search: <input type="text" name="search">
<?php echo "<input type=\"hidden\" value=".$_POST['loc']." name=\"loc\">"; ?>
<input type="submit" value="Search">
</form>
<br>
<form name="filter" action="../summary/list.php" method="post">
List Filter:
<br>
Location:
<select name="loc">
<?php

$pursel = "";
$nebsel = "";
$locsort = "";
$locsortmod = "";

if($_POST['loc'] == "purdue"){
	$pursel = "selected";
	$locsort = "WHERE location=\"Purdue\"";
	$locsortmod = "AND location=\"Purdue\"";
}
if($_POST['loc'] == "nebraska"){
	$nebsel = "selected";
	$locsort = "WHERE location=\"Nebraska\"";
	$locsortmod = "AND location=\"Nebraska\"";
}


	echo "<option value=\"NULL\"></option>";
	echo "<option ".$pursel." value=\"purdue\">Purdue</option>";
	echo "<option ".$nebsel." value=\"nebraska\">Nebraska</option>";
?>
</select>
<input type="submit" value="Apply">
</form>



<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');

$func1 = "SELECT name, id from wafer_p ".$locsort." ORDER BY name";
$func2 = "SELECT name, id from sensor_p ".$locsort." ORDER BY name";
$func3 = "SELECT name, id from HDI_p ".$locsort." ORDER BY name";
$func4 = "SELECT name, id from module_p WHERE name LIKE 'B%' AND assembly!=0 ".$locsortmod." ORDER BY name";
$func5 = "SELECT name, id from module_p WHERE name LIKE 'M%' ".$locsortmod." ORDER BY name";
$i=0;
$j=0;
$dataarray;
$partarray = array("wafer", "sensor", "hdi", "bbm", "bbm");
$fpartarray = array("Wafer", "Sensor", "HDI", "Bare Module", "Fully Assembled Module");

mysql_query('USE cmsfpix_u', $connection);

$output1 = mysql_query($func1, $connection);
while($row1 = mysql_fetch_assoc($output1)){
	$dataarray[0][$i] = $row1['name'];
	$dataarray[1][$i] = $row1['id'];
	$i++;
}
$fpartarray[0] = $fpartarray[0]." (".$i.")";


$output2 = mysql_query($func2, $connection);
while($row2 = mysql_fetch_assoc($output2)){
	$dataarray[2][$j] = $row2['name'];
	$dataarray[3][$j] = $row2['id'];
	$j++;
}
$fpartarray[1] = $fpartarray[1]." (".$j.")";

if($j > $i){$i = $j;}
$j=0;

$output3 = mysql_query($func3, $connection);
while($row3 = mysql_fetch_assoc($output3)){
	$dataarray[4][$j] = $row3['name'];
	$dataarray[5][$j] = $row3['id'];
	$j++;
}
$fpartarray[2] = $fpartarray[2]." (".$j.")";

if($j > $i){$i = $j;}
$j=0;

$output4 = mysql_query($func4, $connection);
while($row4 = mysql_fetch_assoc($output4)){
	$dataarray[6][$j] = $row4['name'];
	$dataarray[7][$j] = $row4['id'];
	$j++;
}
$fpartarray[3] = $fpartarray[3]." (".$j.")";

if($j > $i){$i = $j;}
$j=0;

$output5 = mysql_query($func5, $connection);
while($row5 = mysql_fetch_assoc($output5)){
	$dataarray[8][$j] = findname("module_p", $row5['id']);
	$dataarray[9][$j] = $row5['id'];
	$dataarray[10][$j] = $row5['name'];
	$j++;
}
$fpartarray[4] = $fpartarray[4]." (".$j.")";

if($j > $i){$i = $j;}

echo "<table cellspacing=60 border=0>";
echo "<tr valign=top>";

for($l=0;$l<5;$l++){
	echo "<td>";


	echo "<table cellspacing=0 border=2>";
	echo "<tr><td>";
	echo "$fpartarray[$l]";
	echo "</tr></td>";
	for($k=0; $k<$i; $k++){

		if(is_array($dataarray[2*$l]) && isset($dataarray[2*$l][$k])){
			echo "<tr>";
			echo "<td>";

			if($l==4){ ####Assembled Modules####
				echo "<a href=\"".$partarray[$l].".php?name=".$dataarray[10][$k]."\">".$dataarray[8][$k]."</a>";
			}
			else{
				echo "<a href=\"".$partarray[$l].".php?name=".$dataarray[2*$l][$k]."\">".$dataarray[2*$l][$k]."</a>";
			}
			echo "</td>";
			echo "</tr>";
		}

	}
	echo "</table>";
	echo "</td>";
}

echo "</tr>";
echo "</table>";

echo"<br>";
echo"<br>";
?>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
