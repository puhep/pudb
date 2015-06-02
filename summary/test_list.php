<?php
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');
include('../graphing/xmlgrapher_crit.php');

	$param1 = "";
	$param2 = "";
	$param3 = "";
	$param4 = "";
	$param5 = "";
	$param6 = "";
	$param7 = "";
	$param8 = "";
	$param9 = "";
	$param10 = "";
	$param11 = "";
	$param12 = "";
	$param13 = "";
	$param14 = "";
	$param15 = "";
	$param16 = "";
	$param17 = "";
	$param18 = "";
	$param19 = "";


	$param1 = $_POST['param1'];
	$param2 = $_POST['param2'];
	$param3 = $_POST['param3'];
	$param4 = $_POST['param4'];
	$param5 = $_POST['param5'];
	$param6 = $_POST['param6'];
	$param7 = $_POST['param7'];
	$param8 = $_POST['param8'];
	$param9 = $_POST['param9'];
	$param10 = $_POST['param10'];
	$param11 = $_POST['param11'];
	$param12 = $_POST['param12'];
	$param13 = $_POST['param13'];
	$param14 = $_POST['param14'];
	$param15 = $_POST['param15'];
	$param16 = $_POST['param16'];
	$param17 = $_POST['param17'];
	$param18 = $_POST['param18'];
	$param18 = $_POST['param19'];


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
<form name="filter" action="../summary/test_list.php" method="post">
Filters:
<br>

Name Includes:
<textarea name="param19" cols="10" rows="1"><?php echo $_POST['param19']; ?></textarea>
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
<select name="param8">
<?php locpop("param8"); ?>
</select>
<br>
<br>

Grade:
<select name="comp2">
<?php comparepop("comp2"); ?>
</select>
<select name="param2">
<option value=""></option>
<option value="A"<?php echo $_POST['param2'] == 'A' ? 'selected="selected"' : ''; ?>>A</option>
<option value="B"<?php echo $_POST['param2'] == 'B' ? 'selected="selected"' : ''; ?>>B</option>
<option value="C"<?php echo $_POST['param2'] == 'C' ? 'selected="selected"' : ''; ?>>C</option>
<option value="F"<?php echo $_POST['param2'] == 'F' ? 'selected="selected"' : ''; ?>>F</option>
</select>
<br>
<br>

# Bad ROCs:
<select name="comp3">
<?php comparepop("comp3"); ?>
</select>
<textarea name="param3" cols="10" rows="1"><?php echo $_POST['param3']; ?></textarea>
<br>

# Dead Pixels: 
<select name="comp4">
<?php comparepop("comp4"); ?>
</select>
<textarea name="param4" cols="10" rows="1"><?php echo $_POST['param4']; ?></textarea>
<br>

# Un-Maskable Pixels: 
<select name="comp10">
<?php comparepop("comp10"); ?>
</select>
<textarea name="param10" cols="10" rows="1"><?php echo $_POST['param10']; ?></textarea>
<br>

# Un-Addressable Pixels: 
<select name="comp11">
<?php comparepop("comp11"); ?>
</select>
<textarea name="param11" cols="10" rows="1"><?php echo $_POST['param11']; ?></textarea>
<br>

# Bad Bumps (Electrical): 
<select name="comp5">
<?php comparepop("comp5"); ?>
</select>
<textarea name="param5" cols="10" rows="1"><?php echo $_POST['param5']; ?></textarea>
<br>

# Bad Bumps (Reverse Bias): 
<select name="comp6">
<?php comparepop("comp6"); ?>
</select>
<textarea name="param6" cols="10" rows="1"><?php echo $_POST['param6']; ?></textarea>
<br>

# Bad Bumps (X-Ray): 
<select name="comp7">
<?php comparepop("comp7"); ?>
</select>
<textarea name="param7" cols="10" rows="1"><?php echo $_POST['param7']; ?></textarea>
<br>

X-Ray Slope: 
<select name="comp12">
<?php comparepop("comp12"); ?>
</select>
<textarea name="param12" cols="10" rows="1"><?php echo $_POST['param12']; ?></textarea>
<br>

X-Ray Offset: 
<select name="comp13">
<?php comparepop("comp13"); ?>
</select>
<textarea name="param13" cols="10" rows="1"><?php echo $_POST['param13']; ?></textarea>
<br>

<?php /* ?>
IV Breakdown 
<select name="comp14">
<?php comparepop("comp14"); ?>
</select>
<textarea name="param14" cols="10" rows="1"><?php echo $_POST['param14']; ?></textarea>
<br>

IV Compliance
<select name="comp15">
<?php comparepop("comp15"); ?>
</select>
<textarea name="param15" cols="10" rows="1"><?php echo $_POST['param15']; ?></textarea>
<br>
<?php */ ?>

<br>
Timeable:
<select name="param9">
<option value=""></option>
<option value="1"<?php echo $_POST['param9'] == '1' ? 'selected="selected"' : ''; ?>>Yes</option>
<option value="0"<?php echo $_POST['param9'] == '0' ? 'selected="selected"' : ''; ?>>No</option>
</select>
<br>
<br>

IV Scan Thresholds:
<select name="comp18">
<option value=""></option>
<option value="1"<?php echo $_POST['comp18'] == '1' ? 'selected="selected"' : ''; ?>>Pass</option>
<option value="0"<?php echo $_POST['comp18'] == '0' ? 'selected="selected"' : ''; ?>>Fail</option>
</select>
<select name="param18">
<option value=""></option>
<option value="0"<?php echo $_POST['param18'] == '0' ? 'selected="selected"' : ''; ?>>I(V=150)<2uA</option>
<option value="1"<?php echo $_POST['param18'] == '1' ? 'selected="selected"' : ''; ?>>I(V=150)/I(V=100)<2</option>
<option value="2"<?php echo $_POST['param18'] == '2' ? 'selected="selected"' : ''; ?>>Both</option>
<option value="3"<?php echo $_POST['param18'] == '3' ? 'selected="selected"' : ''; ?>>Either</option>
</select>
<br>
<br>

<?php

$pursel = "";
$nebsel = "";
$sortmod1 = "";
$sortmod2 = "";
$sortmod3 = "";
$sortmod4 = "";
$sortmod5 = "";
$sortmod6 = "";
$sortmod7 = "";
$sortmod8 = "";
$sortmod9 = "";
$sortmod10 = "";
$sortmod11 = "";
$sortmod12 = "";
$sortmod13 = "";
$sortmod14 = "";
$sortmod15 = "";
if($_POST['param1'] != ""){
	$sortmod1 = "AND location=\"".$_POST['param1']."\" ";
}
if($_POST['param2'] != ""){
	$sortmod2 = "AND grade".$_POST['comp2']."\"".$_POST['param2']."\" ";
}
if($_POST['param3'] != ""){
	$sortmod3 = "AND badrocs".$_POST['comp3']."\"".$_POST['param3']."\" ";
}
if($_POST['param4'] != ""){
	$sortmod4 = "AND badpix".$_POST['comp4']."\"".$_POST['param4']."\" ";
}
if($_POST['param5'] != ""){
	$sortmod5 = "AND badbumps_electrical".$_POST['comp5']."\"".$_POST['param5']."\" ";
}
if($_POST['param6'] != ""){
	$sortmod6 = "AND badbumps_reversebias".$_POST['comp6']."\"".$_POST['param6']."\" ";
}
if($_POST['param7'] != ""){
	$sortmod7 = "AND badbumps_xray".$_POST['comp7']."\"".$_POST['param7']."\" ";
}
if($_POST['param8'] != ""){
	$sortmod8 = "AND destination LIKE \"%".$_POST['param8']."%\" ";
}
if($_POST['param9'] != ""){
	$sortmod9 = "AND can_time=\"".$_POST['param9']."\" ";
}
if($_POST['param10'] != ""){
	$sortmod10 = "AND unmaskable_pix".$_POST['comp10']."\"".$_POST['param10']."\" ";
}
if($_POST['param11'] != ""){
	$sortmod11 = "AND unaddressable_pix".$_POST['comp11']."\"".$_POST['param11']."\" ";
}
if($_POST['param12'] != ""){
	$sortmod12 = "AND xray_slope".$_POST['comp12']."\"".$_POST['param12']."\" ";
}
if($_POST['param13'] != ""){
	$sortmod13 = "AND xray_offset".$_POST['comp13']."\"".$_POST['param13']."\" ";
}
if($_POST['param14'] != ""){
	$breakdownlimit = $_POST['param14'];
}
if($_POST['param15'] != ""){
	$compliancelimit = $_POST['param15'];
}
if($_POST['param19'] != ""){
	$sortmod19 = "AND (name LIKE \"%".$_POST['param19']."%\" OR name_hdi LIKE \"%".$_POST['param19']."%\")";
}

$sorter = $sortmod1.$sortmod2.$sortmod3.$sortmod4.$sortmod5.$sortmod6.$sortmod7.$sortmod8.$sortmod9.$sortmod10.$sortmod11.$sortmod12.$sortmod13.$sortmod19;

?>
<input type="submit" value="Apply">
</form>



<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');

#Using joins to sort by parameters in the times_* tables. Probably helpful in the future.#
$func1 = "SELECT a.name, a.id from module_p a, times_module_p b WHERE a.name LIKE 'M_BB%' AND a.id=b.assoc_module ".$sorter." ORDER BY b.HDI_attached DESC";
$func2 = "SELECT a.name, a.id from module_p a, times_module_p b WHERE a.name LIKE 'M_CL%' AND a.id=b.assoc_module ".$sorter." ORDER BY b.HDI_attached DESC";
$func3 = "SELECT a.name, a.id from module_p a, times_module_p b WHERE a.name LIKE 'M_CR%' AND a.id=b.assoc_module ".$sorter." ORDER BY b.HDI_attached DESC";
$func4 = "SELECT a.name, a.id from module_p a, times_module_p b WHERE a.name LIKE 'M_FL%' AND a.id=b.assoc_module ".$sorter." ORDER BY b.HDI_attached DESC";
$func5 = "SELECT a.name, a.id from module_p a, times_module_p b WHERE a.name LIKE 'M_FR%' AND a.id=b.assoc_module ".$sorter." ORDER BY b.HDI_attached DESC";
$func6 = "SELECT a.name, a.id from module_p a, times_module_p b WHERE a.name LIKE 'M_LL%' AND a.id=b.assoc_module ".$sorter." ORDER BY b.HDI_attached DESC";
$func7 = "SELECT a.name, a.id from module_p a, times_module_p b WHERE a.name LIKE 'M_RR%' AND a.id=b.assoc_module ".$sorter." ORDER BY b.HDI_attached DESC";
$func8 = "SELECT a.name, a.id from module_p a, times_module_p b WHERE a.name LIKE 'M_TT%' AND a.id=b.assoc_module ".$sorter." ORDER BY b.HDI_attached DESC";

$i=0;
$j=0;
$dataarray;
$partarray = array("bbm", "bbm", "bbm", "bbm", "bbm", "bbm", "bbm", "bbm");
$fpartarray = array("M_BB", "M_CL", "M_CR", "M_FL", "M_FR", "M_LL", "M_RR", "M_TT");

mysql_query('USE cmsfpix_u', $connection);

$output1 = mysql_query($func1, $connection);
while($row1 = mysql_fetch_assoc($output1)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row1['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module");
	if($_POST['comp18'] === "0" && $_POST['param18'] === "0" && $crit%5 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "0" && $crit%5 == 0){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "1" && $crit%7 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "1" && $crit%7 == 0){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "2" && $crit%35 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "2" && $crit != 1){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "3" && $crit == 1){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "3" && $crit == 35){ continue;}

	$dataarray[0][$i] = $row1['name'];
	$dataarray[1][$i] = $row1['id'];
	$i++;
}
$fpartarray[0] = $fpartarray[0]." (".$i.")";


$output2 = mysql_query($func2, $connection);
while($row2 = mysql_fetch_assoc($output2)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row2['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module");
	
	if($_POST['comp18'] === "0" && $_POST['param18'] === "0" && $crit%5 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "0" && $crit%5 == 0){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "1" && $crit%7 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "1" && $crit%7 == 0){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "2" && $crit%35 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "2" && $crit != 1){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "3" && $crit == 1){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "3" && $crit == 35){ continue;}

	$dataarray[2][$j] = $row2['name'];
	$dataarray[3][$j] = $row2['id'];
	$j++;
}
$fpartarray[1] = $fpartarray[1]." (".$j.")";

if($j > $i){$i = $j;}
$j=0;

$output3 = mysql_query($func3, $connection);
while($row3 = mysql_fetch_assoc($output3)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row3['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module");
	
	if($_POST['comp18'] === "0" && $_POST['param18'] === "0" && $crit%5 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "0" && $crit%5 == 0){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "1" && $crit%7 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "1" && $crit%7 == 0){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "2" && $crit%35 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "2" && $crit != 1){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "3" && $crit == 1){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "3" && $crit == 35){ continue;}

	$dataarray[4][$j] = $row3['name'];
	$dataarray[5][$j] = $row3['id'];
	$j++;
}
$fpartarray[2] = $fpartarray[2]." (".$j.")";

if($j > $i){$i = $j;}
$j=0;

$output4 = mysql_query($func4, $connection);
while($row4 = mysql_fetch_assoc($output4)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row4['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module");
	
	if($_POST['comp18'] === "0" && $_POST['param18'] === "0" && $crit%5 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "0" && $crit%5 == 0){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "1" && $crit%7 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "1" && $crit%7 == 0){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "2" && $crit%35 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "2" && $crit != 1){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "3" && $crit == 1){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "3" && $crit == 35){ continue;}

	$dataarray[6][$j] = $row4['name'];
	$dataarray[7][$j] = $row4['id'];
	$j++;
}
$fpartarray[3] = $fpartarray[3]." (".$j.")";

if($j > $i){$i = $j;}
$j=0;

$output5 = mysql_query($func5, $connection);
while($row5 = mysql_fetch_assoc($output5)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row5['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module");
	
	if($_POST['comp18'] === "0" && $_POST['param18'] === "0" && $crit%5 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "0" && $crit%5 == 0){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "1" && $crit%7 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "1" && $crit%7 == 0){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "2" && $crit%35 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "2" && $crit != 1){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "3" && $crit == 1){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "3" && $crit == 35){ continue;}

	$dataarray[8][$j] = $row5['name'];
	$dataarray[9][$j] = $row5['id'];
	$j++;
}
$fpartarray[4] = $fpartarray[4]." (".$j.")";

if($j > $i){$i = $j;}
$j=0;

$output6 = mysql_query($func6, $connection);
while($row6 = mysql_fetch_assoc($output6)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row6['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module");
	
	if($_POST['comp18'] === "0" && $_POST['param18'] === "0" && $crit%5 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "0" && $crit%5 == 0){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "1" && $crit%7 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "1" && $crit%7 == 0){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "2" && $crit%35 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "2" && $crit != 1){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "3" && $crit == 1){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "3" && $crit == 35){ continue;}

	$dataarray[10][$j] = $row6['name'];
	$dataarray[11][$j] = $row6['id'];
	$j++;
}
$fpartarray[5] = $fpartarray[5]." (".$j.")";

if($j > $i){$i = $j;}
$j=0;

$output7 = mysql_query($func7, $connection);
while($row7 = mysql_fetch_assoc($output7)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row7['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module");
	
	if($_POST['comp18'] === "0" && $_POST['param18'] === "0" && $crit%5 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "0" && $crit%5 == 0){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "1" && $crit%7 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "1" && $crit%7 == 0){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "2" && $crit%35 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "2" && $crit != 1){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "3" && $crit == 1){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "3" && $crit == 35){ continue;}

	$dataarray[12][$j] = $row7['name'];
	$dataarray[13][$j] = $row7['id'];
	$j++;
}
$fpartarray[6] = $fpartarray[6]." (".$j.")";

if($j > $i){$i = $j;}
$j=0;

$output8 = mysql_query($func8, $connection);
while($row8 = mysql_fetch_assoc($output8)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row8['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module");
	
	if($_POST['comp18'] === "0" && $_POST['param18'] === "0" && $crit%5 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "0" && $crit%5 == 0){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "1" && $crit%7 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "1" && $crit%7 == 0){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "2" && $crit%35 > 0){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "2" && $crit != 1){ continue;}
	if($_POST['comp18'] === "0" && $_POST['param18'] === "3" && $crit == 1){ continue;}
	if($_POST['comp18'] === "1" && $_POST['param18'] === "3" && $crit == 35){ continue;}

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

		if(is_array($dataarray[2*$l]) && isset($dataarray[2*$l][$k])){
			echo "<tr>";
			echo "<td>";

			echo "<a href=\"summaryFull.php?name=".$dataarray[2*$l][$k]."\">".findname("module_p", $dataarray[2*$l+1][$k])."</a>";
			
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
