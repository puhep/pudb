<?php
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');
include('../graphing/xmlgrapher_crit.php');

	$param1 = "";
	$param2 = "";
	$param3 = "";

	if(!empty($_GET)){
		$param1 = $_GET['param1'];
		$param2 = $_GET['param2'];
		$param3 = $_GET['param3'];
	}

?>
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Module List</title>
</head>
<body>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
<br>
<br>
<form name="filter" action="../summary/test_list.php" method="GET">
Filters:
<br>

Name Includes:
<textarea name="param3" cols="10" rows="1"><?php echo $param2; ?></textarea>
<br>
<br>

Assembly Location:
<select name="param1">
<option value=""></option>
<option value="Nebraska"<?php echo $param1 == 'Nebraska' ? 'selected="selected"' : ''; ?>>Nebraska</option>
<option value="Purdue"<?php echo $param1 == 'Purdue' ? 'selected="selected"' : ''; ?>>Purdue</option>
</select>
<br>
<br>

Current Location:
<select name="param2">
<?php locpop($param2); ?>
</select>
<br>
<br>

<?php

$pursel = "";
$nebsel = "";

$hide = hidepre("module",2);
###This is a quick way to fix the fact that hidepre doesn't account for the table references needed 
###for the join statement
if($hide != ""){
	$hide = "AND a.id IN (SELECT assoc_module FROM times_module_p WHERE received > \"2015-09-01\")";
}


$sortmod1 = "";
$sortmod2 = "";
$sortmod3 = "";
if($param1 != ""){
	$sortmod1 = "AND location=\"".$_GET['param1']."\" ";
}
if($param2 != ""){
	$sortmod2 = "AND destination LIKE \"%".$_GET['param2']."%\" ";
}
if($param3 != ""){
	$sortmod3 = "AND (a.name LIKE \"%".$param3."%\" OR a.name_hdi LIKE \"%".$param3."%\")";
}

$sorter = $hide.$sortmod1.$sortmod2.$sortmod3;

?>
<input type="submit" value="Apply">
</form>



<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');

#Using joins to sort by parameters in the times_* tables. Probably helpful in the future.#
$func1 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.name LIKE 'M_BB%' AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.HDI_attached DESC";
$func2 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.name LIKE 'M_CL%' AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.HDI_attached DESC";
$func3 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.name LIKE 'M_CR%' AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.HDI_attached DESC";
$func4 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.name LIKE 'M_FL%' AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.HDI_attached DESC";
$func5 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.name LIKE 'M_FR%' AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.HDI_attached DESC";
$func6 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.name LIKE 'M_LL%' AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.HDI_attached DESC";
$func7 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.name LIKE 'M_RR%' AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.HDI_attached DESC";
$func8 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.name LIKE 'M_TT%' AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.HDI_attached DESC";


$i=0;
$j=0;
$dataarray;
$partarray = array("bbm", "bbm", "bbm", "bbm", "bbm", "bbm", "bbm", "bbm");
$fpartarray = array("M_BB", "M_CL", "M_CR", "M_FL", "M_FR", "M_LL", "M_RR", "M_TT");

mysql_query('USE cmsfpix_u', $connection);

$output1 = mysql_query($func1, $connection);
while($output1 && $row1 = mysql_fetch_assoc($output1)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row1['id']);

	$dataarray[0][$i] = $row1['name'];
	$dataarray[1][$i] = $row1['id'];
	$i++;
}
$fpartarray[0] = $fpartarray[0]." (".$i.")";


$output2 = mysql_query($func2, $connection);
while($output2 && $row2 = mysql_fetch_assoc($output2)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row2['id']);

	$dataarray[2][$j] = $row2['name'];
	$dataarray[3][$j] = $row2['id'];
	$j++;
}
$fpartarray[1] = $fpartarray[1]." (".$j.")";

if($j > $i){$i = $j;}
$j=0;

$output3 = mysql_query($func3, $connection);
while($output3 && $row3 = mysql_fetch_assoc($output3)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row3['id']);

	$dataarray[4][$j] = $row3['name'];
	$dataarray[5][$j] = $row3['id'];
	$j++;
}
$fpartarray[2] = $fpartarray[2]." (".$j.")";

if($j > $i){$i = $j;}
$j=0;

$output4 = mysql_query($func4, $connection);
while($output4 && $row4 = mysql_fetch_assoc($output4)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row4['id']);

	$dataarray[6][$j] = $row4['name'];
	$dataarray[7][$j] = $row4['id'];
	$j++;
}
$fpartarray[3] = $fpartarray[3]." (".$j.")";

if($j > $i){$i = $j;}
$j=0;

$output5 = mysql_query($func5, $connection);
while($output5 && $row5 = mysql_fetch_assoc($output5)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row5['id']);

	$dataarray[8][$j] = $row5['name'];
	$dataarray[9][$j] = $row5['id'];
	$j++;
}
$fpartarray[4] = $fpartarray[4]." (".$j.")";

if($j > $i){$i = $j;}
$j=0;

$output6 = mysql_query($func6, $connection);
while($output6 && $row6 = mysql_fetch_assoc($output6)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row6['id']);

	$dataarray[10][$j] = $row6['name'];
	$dataarray[11][$j] = $row6['id'];
	$j++;
}
$fpartarray[5] = $fpartarray[5]." (".$j.")";

if($j > $i){$i = $j;}
$j=0;

$output7 = mysql_query($func7, $connection);
while($output7 && $row7 = mysql_fetch_assoc($output7)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row7['id']);

	$dataarray[12][$j] = $row7['name'];
	$dataarray[13][$j] = $row7['id'];
	$j++;
}
$fpartarray[6] = $fpartarray[6]." (".$j.")";

if($j > $i){$i = $j;}
$j=0;

$output8 = mysql_query($func8, $connection);
while($output8 && $row8 = mysql_fetch_assoc($output8)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row8['id']);

	$dataarray[14][$j] = $row8['name'];
	$dataarray[15][$j] = $row8['id'];
	$j++;
}
$fpartarray[7] = $fpartarray[7]." (".$j.")";

if($j > $i){$i = $j;}

echo "<table cellspacing=60 border=0>";
echo "<tr valign=top>";

for($l=0;$l<8;$l++){
	echo "<td>";


	echo "<table cellspacing=0 border=2>";
	echo "<tr><td>";
	echo "$fpartarray[$l]";
	echo "</tr></td>";
	for($k=0; $k<$i; $k++){

		if(isset($dataarray[2*$l]) && isset($dataarray[2*$l][$k])){
			echo "<tr>";
			echo "<td>";

			echo "<a href=\"summaryFull.php?name=".findname("module_p",$dataarray[2*$l+1][$k])."\">".findname("module_p", $dataarray[2*$l+1][$k])."</a>";
			
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
