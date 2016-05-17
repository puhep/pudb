<?php
ini_set('display_error', 'On');
error_reporting(E_ALL | E_STRICT);

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
	$param18 = "";
	$param19 = "";
	$param20 = "";
	#$param21 = "";
	$param22 = "";
	$param23 = "";
	$param24 = 1;
	$param25 = "";
	$param26 = 1;
	$param27 = "";
	$param28 = "";
	$param29 = "";
	$param30 = "";
	$param31 = "";
	$param34 = "";
	$param35 = "";
	$param36 = "";
	$param37 = "";
	$param38 = "";
	$param39 = "";
	$param40 = "";
	$param41 = "";

	$comp2 = "";
	$comp3 = "";
	$comp4 = "";
	$comp5 = "";
	$comp6 = "";
	$comp7 = "";
	$comp10 = "";
	$comp11 = "";
	$comp12 = "";
	$comp13 = "";
	$comp18 = "";
	$comp25 = "";
	$comp28 = "";
	$comp29 = "";
	#$comp30 = "";
	$comp36 = "";
	$comp37 = "";
	$comp38 = "";
	$comp39 = "";	
	$comp40 = "";	
	$comp41 = "";	

	if(!empty($_GET)){
		$param1 = $_GET['param1'];
		$param2 = $_GET['param2'];
		$param3 = $_GET['param3'];
		$param4 = $_GET['param4'];
		$param5 = $_GET['param5'];
		#$param6 = $_GET['param6'];
		$param7 = $_GET['param7'];
		$param8 = $_GET['param8'];
		$param9 = $_GET['param9'];
		$param10 = $_GET['param10'];
		$param11 = $_GET['param11'];
		$param12 = $_GET['param12'];
		$param13 = $_GET['param13'];
		#$param14 = $_GET['param14'];
		#$param15 = $_GET['param15'];
		$param18 = $_GET['param18'];
		$param19 = $_GET['param19'];
		$param20 = $_GET['param20'];
		#$param21 = $_GET['param21'];
		$param22 = $_GET['param22'];
		$param23 = $_GET['param23'];
		if(!empty($_GET['PA'])){
			$param24 = 1;
			foreach($_GET['PA'] as $check){
				$param24 *= $check;
			}
			echo "<input type='hidden' name='param24' value='".$param24."'>";
		}
		$param25 = $_GET['param25'];
		$checkarr;
		if(!empty($_GET['PAN'])){
			$param26 = 1;
			foreach($_GET['PAN'] as $checkn){
				$checkarr[] = $checkn;
				$param26 *= $checkn;
			}
			echo "<input type='hidden' name='param26' value='".$param26."'>";
		}
		$param27 = $_GET['param27'];
		$param28 = $_GET['param28'];
		$param29 = $_GET['param29'];
		$param30 = $_GET['param30'];
		$param31 = $_GET['param31'];
		$param34 = $_GET['param34'];
		$param35 = $_GET['param35'];	
		$param36 = $_GET['param36'];
		$param37 = $_GET['param37'];
		$param38 = $_GET['param38'];
		$param39 = $_GET['param39'];
		$param40 = $_GET['param40'];		
		$param41 = $_GET['param41'];		

		$comp2 = $_GET['comp2'];
		$comp3 = $_GET['comp3'];
		$comp4 = $_GET['comp4'];
		$comp5 = $_GET['comp5'];
		#$comp6 = $_GET['comp6'];
		$comp7 = $_GET['comp7'];
		$comp10 = $_GET['comp10'];
		$comp11 = $_GET['comp11'];
		$comp12 = $_GET['comp12'];
		$comp13 = $_GET['comp13'];
		$comp18 = $_GET['comp18'];
		$comp25 = $_GET['comp25'];
		$comp28 = $_GET['comp28'];
		$comp29 = $_GET['comp29'];
		#$comp30 = $_GET['comp30'];
		$comp36 = $_GET['comp36'];
		$comp37 = $_GET['comp37'];
		$comp38 = $_GET['comp38'];
		$comp39 = $_GET['comp39'];
		$comp40 = $_GET['comp40'];
		$comp41 = $_GET['comp41'];
	}

?>
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Module List</title>
</head>
<body>


<a href="../graphing/post_assembly_grapher.php" target="blank"><img src="../graphing/post_assembly_grapher.php" style="float:right;width:1100px;height:700px"/></a>


<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

<br>
<form name="filter" action="../summary/test_list.php" method="GET">
Filters:
<br>

Name Includes:
<textarea name="param19" cols="10" rows="1"><?php echo $param19; ?></textarea>
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

Flip-Chip Bonder:
<select name="param20">
<option value=""></option>
<option value="FC150"<?php echo $param20 == 'FC150' ? 'selected="selected"' : ''; ?>>FC150</option>
<option value="Datacon"<?php echo $param20 == 'Datacon' ? 'selected="selected"' : ''; ?>>Datacon</option>
</select>
<br>
<br>

ROC Thickness:
<select name="param23">
<option value=""></option>
<option value="150"<?php echo $param23 == '150' ? 'selected="selected"' : ''; ?>>150um</option>
<option value="200"<?php echo $param23 == '200' ? 'selected="selected"' : ''; ?>>200um</option>
</select>
<br>
<br>

Current Location:
<select name="param8">
<?php locpop($param8); ?>
</select>
<br>
<br>

In transit?
<select name="param27">
<option value=""></option>
<option value="Yes"<?php echo $param27 == 'Yes' ? 'selected="selected"' : ''; ?>>Yes</option>
<option value="No"<?php echo $param27 == 'No' ? 'selected="selected"' : ''; ?>>No</option>
</select>
<br>
<br>

Module Shipped Between:
<textarea placeholder="2015-09-01" name="param30" cols="10" rows="1"><?php echo $param30; ?></textarea>
and: 
<textarea placeholder=<?php echo date("Y-m-d"); ?> name="param31" cols="10" rows="1"><?php echo $param31; ?></textarea>
(yyyy-mm-dd)
<br>

Module Received Between:
<textarea placeholder="2015-09-01" name="param34" cols="10" rows="1"><?php echo $param34; ?></textarea>
and: 
<textarea placeholder=<?php echo date("Y-m-d"); ?> name="param35" cols="10" rows="1"><?php echo $param35; ?></textarea>
(yyyy-mm-dd)
<br>
<br>

<!-- commenting out redundant feature
Next Testing Step:
<select name="param21">
<option value=""></option>
<option value="Not Set"<?php echo $param21 == 'Not Set' ? 'selected="selected"' : ''; ?>>Not Set</option>
<option value="Full test at 17C"<?php echo $param21 == 'Full test at 17C' ? 'selected="selected"' : ''; ?>>Full test at 17C</option>
<option value="Full test at -20C"<?php echo $param21 == 'Full test at -20C' ? 'selected="selected"' : ''; ?>>Full test at -20C</option>
<option value="X-ray testing"<?php echo $param21 == 'X-ray testing' ? 'selected="selected"' : ''; ?>>X-ray testing</option>
<option value="Thermal cycling"<?php echo $param21 == 'Thermal cycling' ? 'selected="selected"' : ''; ?>>Thermal cycling</option>
<option value="Final Judgement"<?php echo $param21 == 'Final Judgement' ? 'selected="selected"' : ''; ?>>Final Judgement</option>
<option value="Debugging"<?php echo $param21 == 'Debugging' ? 'selected="selected"' : ''; ?>>Debugging</option>
<option value="Ready for Mounting"<?php echo $param21 == 'Ready for Mounting' ? 'selected="selected"' : ''; ?>>Ready for Mounting</option>
<option value="Rejected"<?php echo $param21 == 'Rejected' ? 'selected="selected"' : ''; ?>>Rejected</option>
</select>
<br>
<br>
-->

Completed Testing Steps:
<?php
postassembly_radio_show($param24);?>
<br>

Testing Steps not Completed:
<?php
postassembly_radio_show_not($param26);?>
<br>

Mounted on Blade: 
<select name="param22">
<option value=""></option>
<option value="Yes"<?php echo $param22 == 'Yes' ? 'selected="selected"' : ''; ?>>Yes</option>
<option value="No"<?php echo $param22 == 'No' ? 'selected="selected"' : ''; ?>>No</option>
</select>
<br>
<br>

Grade:
<select name="comp2">
<?php comparepop($comp2); ?>
</select>
<select name="param2">
<option value=""></option>
<option value="A"<?php echo $param2 == 'A' ? 'selected="selected"' : ''; ?>>A</option>
<option value="B"<?php echo $param2 == 'B' ? 'selected="selected"' : ''; ?>>B</option>
<option value="C"<?php echo $param2 == 'C' ? 'selected="selected"' : ''; ?>>C</option>
<option value="I"<?php echo $param2 == 'I' ? 'selected="selected"' : ''; ?>>I</option>
</select>
<br>
<br>

Has ROC Failure Mode: 
<select name="param36">
<option value=""></option>
<option value="Dead DC w/ good Trim"<?php echo $param36 == 'Dead DC w/ good Trim' ? 'selected="selected"' : ''; ?>>Dead DC w/ good Trim</option>
<option value="Dead DC w/ bad Trim"<?php echo $param36 == 'Dead DC w/ bad Trim' ? 'selected="selected"' : ''; ?>>Dead DC w/ bad Trim</option>
<option value="Bad Trim w/ no Bad DC"<?php echo $param36 == 'Bad Trim w/ no Bad DC' ? 'selected="selected"' : ''; ?>>Bad Trim w/ no Bad DC</option>
<option value="Zombie"<?php echo $param36 == 'Zombie' ? 'selected="selected"' : ''; ?>>Zombie</option>
<option value="Zero PH"<?php echo $param36 == 'Zero PH' ? 'selected="selected"' : ''; ?>>Zero PH</option>
<option value="Low Iana / High Vana"<?php echo $param36 == 'Low Iana / High Vana' ? 'selected="selected"' : ''; ?>>Low Iana / High Vana</option>
<option value="Iana Short"<?php echo $param36 == 'Iana Short' ? 'selected="selected"' : ''; ?>>Iana Short</option>
<option value="Idig Short"<?php echo $param36 == 'Idig Short' ? 'selected="selected"' : ''; ?>>Idig Short</option>
<option value="Partially Detached"<?php echo $param36 == 'Partially Detached' ? 'selected="selected"' : ''; ?>>Partially Detached</option>
<option value="Dead Pixels"<?php echo $param36 == 'Dead Pixels' ? 'selected="selected"' : ''; ?>>Dead Pixels</option>
<option value="Bad Bumps"<?php echo $param36 == 'Bad Bumps' ? 'selected="selected"' : ''; ?>>Bad Bumps</option>
<option value="No Token Pass"<?php echo $param36 == 'No Token Pass' ? 'selected="selected"' : ''; ?>>No Token Pass</option>
<option value="Unprogrammable"<?php echo $param36 == 'Unprogrammable' ? 'selected="selected"' : ''; ?>>Unprogrammable</option>
<option value="Pulse Height Issue"<?php echo $param36 == 'Pulse Height Issue' ? 'selected="selected"' : ''; ?>>Pulse Height Issue</option>
<option value="Other"<?php echo $param36 == 'Other' ? 'selected="selected"' : ''; ?>>Other</option>
</select>
<br>
<br>

#pXar Errors:
<select name="comp41">
<?php comparepop($comp41); ?>
</select>
<textarea name="param41" cols="10" rows="1"><?php echo $param41; ?></textarea>
<br>
<br>

# Bad ROCs:
<select name="comp3">
<?php comparepop($comp3); ?>
</select>
<textarea name="param3" cols="10" rows="1"><?php echo $param3; ?></textarea>
<br>

# Dead Pixels per ROC: 
<select name="comp4">
<?php comparepop($comp4); ?>
</select>
<textarea name="param4" cols="10" rows="1"><?php echo $param4; ?></textarea>
<br>

# VCal thresh defect Pixels per ROC: 
<select name="comp28">
<?php comparepop($comp28); ?>
</select>
<textarea name="param28" cols="10" rows="1"><?php echo $param28; ?></textarea>
<br>

# Un-Maskable Pixels: 
<select name="comp10">
<?php comparepop($comp10); ?>
</select>
<textarea name="param10" cols="10" rows="1"><?php echo $param10; ?></textarea>
<br>

# Un-Addressable Pixels: 
<select name="comp11">
<?php comparepop($comp11); ?>
</select>
<textarea name="param11" cols="10" rows="1"><?php echo $param11; ?></textarea>
<br>

# Bad Bumps per ROC (Electrical): 
<select name="comp5">
<?php comparepop($comp5); ?>
</select>
<textarea name="param5" cols="10" rows="1"><?php echo $param5; ?></textarea>
<br>

<?php /* ?>
# Bad Bumps (Reverse Bias): 
<select name="comp6">
<?php comparepop($comp6); ?>
</select>
<textarea name="param6" cols="10" rows="1"><?php echo $param6; ?></textarea>
<br>
<?php */ ?>

# Bad Bumps per ROC (X-Ray): 
<select name="comp7">
<?php comparepop($comp7); ?>
</select>
<textarea name="param7" cols="10" rows="1"><?php echo $param7; ?></textarea>
<br>
<br>

X-Ray Slope: 
<select name="comp12">
<?php comparepop($comp12); ?>
</select>
<textarea name="param12" cols="10" rows="1"><?php echo $param12; ?></textarea>
<br>

X-Ray Offset: 
<select name="comp13">
<?php comparepop($comp13); ?>
</select>
<textarea name="param13" cols="10" rows="1"><?php echo $param13; ?></textarea>
<br>

#DC with Efficiency < 98%: 
<select name="comp37">
<?php comparepop($comp37); ?>
</select>
<textarea name="param37" cols="10" rows="1"><?php echo $param37; ?></textarea>
<br>

#DC with Efficiency < 95%: 
<select name="comp38">
<?php comparepop($comp38); ?>
</select>
<textarea name="param38" cols="10" rows="1"><?php echo $param38; ?></textarea>
<br>

#DC with Uniformity < 0.60: 
<select name="comp39">
<?php comparepop($comp39); ?>
</select>
<textarea name="param39" cols="10" rows="1"><?php echo $param39; ?></textarea>
<br>

#DC with Uniformity > 1.50: 
<select name="comp40">
<?php comparepop($comp40); ?>
</select>
<textarea name="param40" cols="10" rows="1"><?php echo $param40; ?></textarea>
<br>

<?php /* ?>
IV Breakdown 
<select name="comp14">
<?php comparepop($comp14); ?>
</select>
<textarea name="param14" cols="10" rows="1"><?php echo $param14; ?></textarea>
<br>

IV Compliance
<select name="comp15">
<?php comparepop($comp15); ?>
</select>
<textarea name="param15" cols="10" rows="1"><?php echo $param15; ?></textarea>
<br>
<?php */ ?>

<br>
Timeable:
<select name="param9">
<option value=""></option>
<option value="1"<?php echo $param9 == '1' ? 'selected="selected"' : ''; ?>>Yes</option>
<option value="0"<?php echo $param9 == '0' ? 'selected="selected"' : ''; ?>>No</option>
</select>
<br>
<br>

RTD Temperature:
<select name="comp25">
<?php comparepop($comp25); ?>
</select>
<textarea name="param25" cols="10" rows="1"><?php echo $param25; ?></textarea>
<br>
<br>

IV Scan Thresholds:
<select name="comp18">
<option value=""></option>
<option value="1"<?php echo $comp18 == '1' ? 'selected="selected"' : ''; ?>>Pass</option>
<option value="0"<?php echo $comp18 == '0' ? 'selected="selected"' : ''; ?>>Fail</option>
</select>
<select name="param18">
<option value=""></option>
<option value="0"<?php echo $param18 == '0' ? 'selected="selected"' : ''; ?>>I(V=150)<2uA</option>
<option value="1"<?php echo $param18 == '1' ? 'selected="selected"' : ''; ?>>I(V=150)/I(V=100)<2</option>
<option value="2"<?php echo $param18 == '2' ? 'selected="selected"' : ''; ?>>Both</option>
<option value="3"<?php echo $param18 == '3' ? 'selected="selected"' : ''; ?>>Either</option>
</select>
<br>
<br>

<!--
IV Scan Thresholds (+17C):
<select name="comp29">
<option value=""></option>
<option value="1"<?php echo $comp29 == '1' ? 'selected="selected"' : ''; ?>>Pass</option>
<option value="0"<?php echo $comp29 == '0' ? 'selected="selected"' : ''; ?>>Fail</option>
</select>
<select name="param29">
<option value=""></option>
<option value="0"<?php echo $param29 == '0' ? 'selected="selected"' : ''; ?>>I(V=150)<2uA</option>
<option value="1"<?php echo $param29 == '1' ? 'selected="selected"' : ''; ?>>I(V=150)/I(V=100)<2</option>
<option value="2"<?php echo $param29 == '2' ? 'selected="selected"' : ''; ?>>Both</option>
<option value="3"<?php echo $param29 == '3' ? 'selected="selected"' : ''; ?>>Either</option>
</select>
<br>
<br>
-->

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
$sortmod19 = "";
$sortmod20 = "";
$sortmod21 = "";
$sortmod22 = "";
$sortmod23 = "";
$sortmod24 = "";
$sortmod25 = "";
$sortmod26 = "";
$sortmod27 = "";
$sortmod28 = "";
$sortmod29 = "";
$sortmod30 = "";
$sortmod34 = "";
$sortmod36 = "";
$sortmod37 = "";
$sortmod38 = "";
$sortmod39 = "";
$sortmod40 = "";
$sortmod41 = "";

if($param1 != ""){
	$sortmod1 = "AND location=\"".$_GET['param1']."\" ";
}
if($param2 != ""){
	#$sortmod2 = "AND grade".$_GET['comp2']."\"".$_GET['param2']."\" ";
}
if($param3 != ""){
	$sortmod3 = "AND badrocs".$_GET['comp3']."\"".$_GET['param3']."\" ";
}
if($param4 != ""){
	$sortmod4 = "AND c.deadpix".$_GET['comp4']."\"".$_GET['param4']."\" ";
}
if($param5 != ""){
	$sortmod5 = "AND c.badbumps_elec".$_GET['comp5']."\"".$_GET['param5']."\" ";
}
if($param6 != ""){
	$sortmod6 = "AND badbumps_reversebias".$_GET['comp6']."\"".$_GET['param6']."\" ";
}
if($param7 != ""){
	$sortmod7 = "AND c.badbumps_xray".$_GET['comp7']."\"".$_GET['param7']."\" ";
}
if($param8 != ""){
	$sortmod8 = "AND destination LIKE \"%".$_GET['param8']."%\" ";
}
if($param9 != ""){
	$sortmod9 = "AND can_time=\"".$_GET['param9']."\" ";
}
if($param10 != ""){
	$sortmod10 = "AND unmaskable_pix".$_GET['comp10']."\"".$_GET['param10']."\" ";
}
if($param11 != ""){
	$sortmod11 = "AND unaddressable_pix".$_GET['comp11']."\"".$_GET['param11']."\" ";
}
if($param12 != ""){
	$sortmod12 = "AND c.xray_slope".$_GET['comp12']."\"".$_GET['param12']."\" ";
}
if($param13 != ""){
	$sortmod13 = "AND c.xray_offset".$_GET['comp13']."\"".$_GET['param13']."\" ";
}
if($param14 != ""){
	$breakdownlimit = $_GET['param14'];
}
if($param15 != ""){
	$compliancelimit = $_GET['param15'];
}
if($param19 != ""){
	$sortmod19 = "AND (a.name LIKE \"%".$param19."%\" OR a.name_hdi LIKE \"%".$param19."%\")";
}
if($param20 != ""){
	$sortmod20 = "AND bonder=\"".$_GET['param20']."\" ";
}
#if($param21 != ""){
#	if($_GET['param21'] == 'Not Set'){
#		$sortmod21 = "AND tested_status IS NULL ";	
#	}
#	else{
#		$sortmod21 = "AND tested_status=\"".$_GET['param21']."\" ";
#	}
#}
if($param22 != ""){
	if($_GET['param22'] == 'Yes'){
		$sortmod22 = "AND assembly = 14 ";
	}
	elseif($_GET['param22'] == "No"){
		$sortmod22 = "AND assembly != 14 ";
	}
}
if($param23 != ""){
	    $sortmod23 = "AND c.thickness =". $_GET['param23']." ";
}

$sortmod24 = "AND a.assembly_post % ".$param24." = 0 ";

if($param25 != ""){
	 $sortmod25 = "AND rtd_temp ".$_GET['comp25']." ".$_GET['param25'];
}

if($param26 != 1){
	    for($i=0; $i<count($checkarr); $i++){ 
	    	      $sortmod26 .= "AND a.assembly_post % ".$checkarr[$i]." != 0 ";
	    }
}
if($param27 != ""){
	if($_GET['param27'] == 'Yes'){
		$sortmod27 = "AND destination LIKE \"In transit%\" ";
	}
	elseif($_GET['param27'] == "No"){
		$sortmod27 = "AND destination NOT LIKE \"In transit%\" ";
	}
}
if($param28 != ""){
	$sortmod28 = "AND c.vcal_thresh".$_GET['comp28']."\"".$_GET['param28']."\" ";
}
if($param30 != "" && $param31 != ""){
	$sortmod30 = "AND DATE_FORMAT(b.shipped,\"%Y-%m-%d\") BETWEEN \"".$_GET['param30']."\" AND \"".$_GET['param31']."\" ";
}
elseif($param30 != "" && $param31 == ""){
	$d = date("Y-m-d");
	$sortmod30 = "AND DATE_FORMAT(b.shipped,\"%Y-%m-%d\") BETWEEN \"".$_GET['param30']."\" AND \"$d\" ";
}
elseif($param30 == "" && $param31 != ""){
	$d = "2015-09-01";
	$sortmod30 = "AND DATE_FORMAT(b.shipped,\"%Y-%m-%d\") BETWEEN \"".$d."\" AND \"".$_GET['param31']."\" ";
}

if($param35 != "" && $param34 != ""){
	$sortmod34 = "AND arrival BETWEEN \"".$_GET['param34']."\" AND \"".$_GET['param35']."\" ";
}
elseif($param34 != "" && $param35 == ""){
	$d = date("Y-m-d");
	$sortmod34 = "AND arrival BETWEEN \"".$_GET['param34']."\" AND \"$d\" ";
}
elseif($param34 == "" && $param35 != ""){
	$d = "2015-09-01";
	$sortmod34 = "AND arrival BETWEEN \"".$d."\" AND \"".$_GET['param35']."\" ";
}
if($param36 != ""){
	$sortmod36 = "AND c.failure_mode = \"". $_GET['param36']."\" ";
}
if($param37 != ""){
	$sortmod37 = "AND a.DC_below_98".$_GET['comp37'].$_GET['param37']." ";
}
if($param38 != ""){
	$sortmod38 = "AND a.DC_below_95".$_GET['comp38'].$_GET['param38']." ";
}
if($param39 != ""){
	$sortmod39 = "AND a.DC_below_60_uni".$_GET['comp39'].$_GET['param39']." ";
}
if($param40 != ""){
	$sortmod40 = "AND a.DC_above_150_uni".$_GET['comp40'].$_GET['param40']." ";
}
if($param41 != ""){
	$sortmod41 = "AND a.pxar_errors".$_GET['comp41'].$_GET['param41']." ";
}

#$sortmod32 = "AND a.name NOT LIKE '%95%' AND a.name NOT LIKE '%96%' AND a.name NOT LIKE '%97%' ";
$sortmod32 = "";

$sortmod33 = "AND a.assembly >= 11 ";

$sorter = $hide.$sortmod1.$sortmod3.$sortmod4.$sortmod5.$sortmod6.$sortmod7.$sortmod8.$sortmod9.$sortmod10.$sortmod11.$sortmod12.$sortmod13.$sortmod19.$sortmod20.$sortmod21.$sortmod22.$sortmod23.$sortmod24.$sortmod25.$sortmod26.$sortmod27.$sortmod28.$sortmod29.$sortmod30.$sortmod32.$sortmod33.$sortmod34.$sortmod36.$sortmod37.$sortmod38.$sortmod39.$sortmod40.$sortmod41;

#echo $sorter."<br>";

?>
<input type="submit" value="Apply">

</form>

<form method="link" action="../summary/test_list.php">
<input type="submit" value="Reset Form">
</form>

<?php
include('../../../Submission_p_secure_pages/connect.php');

#include('../functions/curfunctions.php');

#Using joins to sort by parameters in the times_* tables. Probably helpful in the future.#
#$func1 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.name LIKE 'M_BB%' AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.HDI_attached DESC";
#$func2 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.name LIKE 'M_CL%' AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.HDI_attached DESC";
#$func3 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.name LIKE 'M_CR%' AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.HDI_attached DESC";
#$func4 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.name LIKE 'M_FL%' AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.HDI_attached DESC";
#$func5 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.name LIKE 'M_FR%' AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.HDI_attached DESC";
#$func6 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.name LIKE 'M_LL%' AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.HDI_attached DESC";
#$func7 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.name LIKE 'M_RR%' AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.HDI_attached DESC";
#$func8 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.name LIKE 'M_TT%' AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.HDI_attached DESC";

#Updated grouping by next testing step instead of wafer position
$func1 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.tested_status LIKE \"Full test at 17C\" AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.shipped DESC";
$func2 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.tested_status LIKE \"Full test at -20C\" AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.shipped DESC";
$func3 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.tested_status LIKE \"X-ray testing\" AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.shipped DESC";
$func4 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.tested_status LIKE \"Thermal cycling\" AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.shipped DESC";
$func5 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.tested_status LIKE \"Final Judgement\" AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.shipped DESC";
$func6 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.tested_status LIKE \"Debugging\" AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.shipped DESC";
$func7 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.tested_status LIKE \"Ready for Mounting\" AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY SUM(c.deadpix+c.badbumps_elec+c.unmaskable+c.unaddressable+IFNULL(c.vcal_thresh,0)) ASC";
$func10 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.tested_status LIKE \"Mounted\" AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." and a.assembly = 14 GROUP BY a.name ORDER BY b.on_blade DESC";
$func8 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.tested_status LIKE \"Rejected\" AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY SUM(IFNULL(c.deadpix,1000000)+IFNULL(c.badbumps_elec,1000000)+IFNULL(c.unmaskable,0)+IFNULL(c.unaddressable,0)+IFNULL(c.vcal_thresh,0)) ASC";
$func9 = "SELECT a.name, a.id from module_p a, times_module_p b, ROC_p c WHERE a.tested_status IS NULL AND a.id=b.assoc_module AND a.id=c.assoc_module ".$sorter." GROUP BY a.name ORDER BY b.shipped DESC";


$i=0;
$j=0;
$total=0;
$dataarray;
$partarray = array("bbm", "bbm", "bbm", "bbm", "bbm", "bbm", "bbm", "bbm");
$fpartarray = array("Full Test at 17C", "Full Test at -20C", "X-ray testing", "Thermal cycling", "Final Judgement", "Debugging", "Ready for Mounting", "Rejected", "Not Set", "Mounted on Blade");

mysql_query('USE cmsfpix_u', $connection);

$output1 = mysql_query($func1, $connection);
while($output1 && $row1 = mysql_fetch_assoc($output1)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row1['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module", 0);
	
	if($comp2 === "=" && $param2 !== "" && $param2 != curgrade($row1['id'])){ continue;}
	if($comp2 === ">" && $param2 !== "" && $param2 <= curgrade($row1['id'])){ continue;}
	if($comp2 === "<" && $param2 !== "" && $param2 >= curgrade($row1['id'])){ continue;}
	if($comp2 === ">=" && $param2 !== "" && $param2 < curgrade($row1['id'])){ continue;}
	if($comp2 === "<=" && $param2 !== "" && $param2 > curgrade($row1['id'])){ continue;}
	if($comp2 === "!=" && $param2 !== "" && $param2 == curgrade($row1['id'])){ continue;}

	if($comp18 === "0" && $param18 === "0" && $crit%5 > 0){ continue;}
	if($comp18 === "1" && $param18 === "0" && $crit%5 == 0){ continue;}
	if($comp18 === "0" && $param18 === "1" && $crit%7 > 0){ continue;}
	if($comp18 === "1" && $param18 === "1" && $crit%7 == 0){ continue;}
	if($comp18 === "0" && $param18 === "2" && $crit%35 > 0){ continue;}
	if($comp18 === "1" && $param18 === "2" && $crit != 1){ continue;}
	if($comp18 === "0" && $param18 === "3" && $crit == 1){ continue;}
	if($comp18 === "1" && $param18 === "3" && $crit == 35){ continue;}

	$dataarray[0][$i] = $row1['name'];
	$dataarray[1][$i] = $row1['id'];
	$i++;
}
$fpartarray[0] = $fpartarray[0]." (".$i.")";
$total = $total + $i;

$output2 = mysql_query($func2, $connection);
while($output2 && $row2 = mysql_fetch_assoc($output2)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row2['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module", 0);
	
	if($comp2 === "=" && $param2 !== "" && $param2 != curgrade($row2['id'])){ continue;}
	if($comp2 === ">" && $param2 !== "" && $param2 <= curgrade($row2['id'])){ continue;}
	if($comp2 === "<" && $param2 !== "" && $param2 >= curgrade($row2['id'])){ continue;}
	if($comp2 === ">=" && $param2 !== "" && $param2 < curgrade($row2['id'])){ continue;}
	if($comp2 === "<=" && $param2 !== "" && $param2 > curgrade($row2['id'])){ continue;}
	if($comp2 === "!=" && $param2 !== "" && $param2 == curgrade($row2['id'])){ continue;}

	if($comp18 === "0" && $param18 === "0" && $crit%5 > 0){ continue;}
	if($comp18 === "1" && $param18 === "0" && $crit%5 == 0){ continue;}
	if($comp18 === "0" && $param18 === "1" && $crit%7 > 0){ continue;}
	if($comp18 === "1" && $param18 === "1" && $crit%7 == 0){ continue;}
	if($comp18 === "0" && $param18 === "2" && $crit%35 > 0){ continue;}
	if($comp18 === "1" && $param18 === "2" && $crit != 1){ continue;}
	if($comp18 === "0" && $param18 === "3" && $crit == 1){ continue;}
	if($comp18 === "1" && $param18 === "3" && $crit == 35){ continue;}

	$dataarray[2][$j] = $row2['name'];
	$dataarray[3][$j] = $row2['id'];
	$j++;
}
$fpartarray[1] = $fpartarray[1]." (".$j.")";
$total = $total + $j;

if($j > $i){$i = $j;}
$j=0;

$output3 = mysql_query($func3, $connection);
while($output3 && $row3 = mysql_fetch_assoc($output3)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row3['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module", 0);
	
	if($comp2 === "=" && $param2 !== "" && $param2 != curgrade($row3['id'])){ continue;}
	if($comp2 === ">" && $param2 !== "" && $param2 <= curgrade($row3['id'])){ continue;}
	if($comp2 === "<" && $param2 !== "" && $param2 >= curgrade($row3['id'])){ continue;}
	if($comp2 === ">=" && $param2 !== "" && $param2 < curgrade($row3['id'])){ continue;}
	if($comp2 === "<=" && $param2 !== "" && $param2 > curgrade($row3['id'])){ continue;}
	if($comp2 === "!=" && $param2 !== "" && $param2 == curgrade($row3['id'])){ continue;}
	
	if($comp18 === "0" && $param18 === "0" && $crit%5 > 0){ continue;}
	if($comp18 === "1" && $param18 === "0" && $crit%5 == 0){ continue;}
	if($comp18 === "0" && $param18 === "1" && $crit%7 > 0){ continue;}
	if($comp18 === "1" && $param18 === "1" && $crit%7 == 0){ continue;}
	if($comp18 === "0" && $param18 === "2" && $crit%35 > 0){ continue;}
	if($comp18 === "1" && $param18 === "2" && $crit != 1){ continue;}
	if($comp18 === "0" && $param18 === "3" && $crit == 1){ continue;}
	if($comp18 === "1" && $param18 === "3" && $crit == 35){ continue;}

	$dataarray[4][$j] = $row3['name'];
	$dataarray[5][$j] = $row3['id'];
	$j++;
}
$fpartarray[2] = $fpartarray[2]." (".$j.")";
$total = $total + $j;

if($j > $i){$i = $j;}
$j=0;

$output4 = mysql_query($func4, $connection);
while($output4 && $row4 = mysql_fetch_assoc($output4)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row4['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module", 0);
	
	if($comp2 === "=" && $param2 !== "" && $param2 != curgrade($row4['id'])){ continue;}
	if($comp2 === ">" && $param2 !== "" && $param2 <= curgrade($row4['id'])){ continue;}
	if($comp2 === "<" && $param2 !== "" && $param2 >= curgrade($row4['id'])){ continue;}
	if($comp2 === ">=" && $param2 !== "" && $param2 < curgrade($row4['id'])){ continue;}
	if($comp2 === "<=" && $param2 !== "" && $param2 > curgrade($row4['id'])){ continue;}
	if($comp2 === "!=" && $param2 !== "" && $param2 == curgrade($row4['id'])){ continue;}
	
	if($comp18 === "0" && $param18 === "0" && $crit%5 > 0){ continue;}
	if($comp18 === "1" && $param18 === "0" && $crit%5 == 0){ continue;}
	if($comp18 === "0" && $param18 === "1" && $crit%7 > 0){ continue;}
	if($comp18 === "1" && $param18 === "1" && $crit%7 == 0){ continue;}
	if($comp18 === "0" && $param18 === "2" && $crit%35 > 0){ continue;}
	if($comp18 === "1" && $param18 === "2" && $crit != 1){ continue;}
	if($comp18 === "0" && $param18 === "3" && $crit == 1){ continue;}
	if($comp18 === "1" && $param18 === "3" && $crit == 35){ continue;}

	$dataarray[6][$j] = $row4['name'];
	$dataarray[7][$j] = $row4['id'];
	$j++;
}
$fpartarray[3] = $fpartarray[3]." (".$j.")";
$total = $total + $j;

if($j > $i){$i = $j;}
$j=0;

$output5 = mysql_query($func5, $connection);
while($output5 && $row5 = mysql_fetch_assoc($output5)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row5['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module", 0);
	
	if($comp2 === "=" && $param2 !== "" && $param2 != curgrade($row5['id'])){ continue;}
	if($comp2 === ">" && $param2 !== "" && $param2 <= curgrade($row5['id'])){ continue;}
	if($comp2 === "<" && $param2 !== "" && $param2 >= curgrade($row5['id'])){ continue;}
	if($comp2 === ">=" && $param2 !== "" && $param2 < curgrade($row5['id'])){ continue;}
	if($comp2 === "<=" && $param2 !== "" && $param2 > curgrade($row5['id'])){ continue;}
	if($comp2 === "!=" && $param2 !== "" && $param2 == curgrade($row5['id'])){ continue;}

	if($comp18 === "0" && $param18 === "0" && $crit%5 > 0){ continue;}
	if($comp18 === "1" && $param18 === "0" && $crit%5 == 0){ continue;}
	if($comp18 === "0" && $param18 === "1" && $crit%7 > 0){ continue;}
	if($comp18 === "1" && $param18 === "1" && $crit%7 == 0){ continue;}
	if($comp18 === "0" && $param18 === "2" && $crit%35 > 0){ continue;}
	if($comp18 === "1" && $param18 === "2" && $crit != 1){ continue;}
	if($comp18 === "0" && $param18 === "3" && $crit == 1){ continue;}
	if($comp18 === "1" && $param18 === "3" && $crit == 35){ continue;}

	$dataarray[8][$j] = $row5['name'];
	$dataarray[9][$j] = $row5['id'];
	$j++;
}
$fpartarray[4] = $fpartarray[4]." (".$j.")";
$total = $total + $j;

if($j > $i){$i = $j;}
$j=0;

$output6 = mysql_query($func6, $connection);
while($output6 && $row6 = mysql_fetch_assoc($output6)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row6['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module", 0);
	
	if($comp2 === "=" && $param2 !== "" && $param2 != curgrade($row6['id'])){ continue;}
	if($comp2 === ">" && $param2 !== "" && $param2 <= curgrade($row6['id'])){ continue;}
	if($comp2 === "<" && $param2 !== "" && $param2 >= curgrade($row6['id'])){ continue;}
	if($comp2 === ">=" && $param2 !== "" && $param2 < curgrade($row6['id'])){ continue;}
	if($comp2 === "<=" && $param2 !== "" && $param2 > curgrade($row6['id'])){ continue;}
	if($comp2 === "!=" && $param2 !== "" && $param2 == curgrade($row6['id'])){ continue;}
	
	if($comp18 === "0" && $param18 === "0" && $crit%5 > 0){ continue;}
	if($comp18 === "1" && $param18 === "0" && $crit%5 == 0){ continue;}
	if($comp18 === "0" && $param18 === "1" && $crit%7 > 0){ continue;}
	if($comp18 === "1" && $param18 === "1" && $crit%7 == 0){ continue;}
	if($comp18 === "0" && $param18 === "2" && $crit%35 > 0){ continue;}
	if($comp18 === "1" && $param18 === "2" && $crit != 1){ continue;}
	if($comp18 === "0" && $param18 === "3" && $crit == 1){ continue;}
	if($comp18 === "1" && $param18 === "3" && $crit == 35){ continue;}

	$dataarray[10][$j] = $row6['name'];
	$dataarray[11][$j] = $row6['id'];
	$j++;
}
$fpartarray[5] = $fpartarray[5]." (".$j.")";
$total = $total + $j;

if($j > $i){$i = $j;}
$j=0;

$output7 = mysql_query($func7, $connection);
while($output7 && $row7 = mysql_fetch_assoc($output7)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row7['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module", 0);
	
	if($comp2 === "=" && $param2 !== "" && $param2 != curgrade($row7['id'])){ continue;}
	if($comp2 === ">" && $param2 !== "" && $param2 <= curgrade($row7['id'])){ continue;}
	if($comp2 === "<" && $param2 !== "" && $param2 >= curgrade($row7['id'])){ continue;}
	if($comp2 === ">=" && $param2 !== "" && $param2 < curgrade($row7['id'])){ continue;}
	if($comp2 === "<=" && $param2 !== "" && $param2 > curgrade($row7['id'])){ continue;}
	if($comp2 === "!=" && $param2 !== "" && $param2 == curgrade($row7['id'])){ continue;}
	
	if($comp18 === "0" && $param18 === "0" && $crit%5 > 0){ continue;}
	if($comp18 === "1" && $param18 === "0" && $crit%5 == 0){ continue;}
	if($comp18 === "0" && $param18 === "1" && $crit%7 > 0){ continue;}
	if($comp18 === "1" && $param18 === "1" && $crit%7 == 0){ continue;}
	if($comp18 === "0" && $param18 === "2" && $crit%35 > 0){ continue;}
	if($comp18 === "1" && $param18 === "2" && $crit != 1){ continue;}
	if($comp18 === "0" && $param18 === "3" && $crit == 1){ continue;}
	if($comp18 === "1" && $param18 === "3" && $crit == 35){ continue;}

	$dataarray[12][$j] = $row7['name'];
	$dataarray[13][$j] = $row7['id'];
	$j++;
}
$fpartarray[6] = $fpartarray[6]." (".$j.")";
$total = $total + $j;

if($j > $i){$i = $j;}
$j=0;

$output8 = mysql_query($func8, $connection);
while($output8 && $row8 = mysql_fetch_assoc($output8)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row8['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module", 0);
	
	if($comp2 === "=" && $param2 !== "" && $param2 != curgrade($row8['id'])){ continue;}
	if($comp2 === ">" && $param2 !== "" && $param2 <= curgrade($row8['id'])){ continue;}
	if($comp2 === "<" && $param2 !== "" && $param2 >= curgrade($row8['id'])){ continue;}
	if($comp2 === ">=" && $param2 !== "" && $param2 < curgrade($row8['id'])){ continue;}
	if($comp2 === "<=" && $param2 !== "" && $param2 > curgrade($row8['id'])){ continue;}
	if($comp2 === "!=" && $param2 !== "" && $param2 == curgrade($row8['id'])){ continue;}
	
	if($comp18 === "0" && $param18 === "0" && $crit%5 > 0){ continue;}
	if($comp18 === "1" && $param18 === "0" && $crit%5 == 0){ continue;}
	if($comp18 === "0" && $param18 === "1" && $crit%7 > 0){ continue;}
	if($comp18 === "1" && $param18 === "1" && $crit%7 == 0){ continue;}
	if($comp18 === "0" && $param18 === "2" && $crit%35 > 0){ continue;}
	if($comp18 === "1" && $param18 === "2" && $crit != 1){ continue;}
	if($comp18 === "0" && $param18 === "3" && $crit == 1){ continue;}
	if($comp18 === "1" && $param18 === "3" && $crit == 35){ continue;}

	$dataarray[14][$j] = $row8['name'];
	$dataarray[15][$j] = $row8['id'];
	$j++;
}
$fpartarray[7] = $fpartarray[7]." (".$j.")";
$total = $total + $j;

if($j > $i){$i = $j;}
$j=0;

$output9 = mysql_query($func9, $connection);
while($output9 && $row9 = mysql_fetch_assoc($output9)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row9['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module", 0);
	
	if($comp2 === "=" && $param2 !== "" && $param2 != curgrade($row9['id'])){ continue;}
	if($comp2 === ">" && $param2 !== "" && $param2 <= curgrade($row9['id'])){ continue;}
	if($comp2 === "<" && $param2 !== "" && $param2 >= curgrade($row9['id'])){ continue;}
	if($comp2 === ">=" && $param2 !== "" && $param2 < curgrade($row9['id'])){ continue;}
	if($comp2 === "<=" && $param2 !== "" && $param2 > curgrade($row9['id'])){ continue;}
	if($comp2 === "!=" && $param2 !== "" && $param2 == curgrade($row9['id'])){ continue;}
	
	if($comp18 === "0" && $param18 === "0" && $crit%5 > 0){ continue;}
	if($comp18 === "1" && $param18 === "0" && $crit%5 == 0){ continue;}
	if($comp18 === "0" && $param18 === "1" && $crit%7 > 0){ continue;}
	if($comp18 === "1" && $param18 === "1" && $crit%7 == 0){ continue;}
	if($comp18 === "0" && $param18 === "2" && $crit%35 > 0){ continue;}
	if($comp18 === "1" && $param18 === "2" && $crit != 1){ continue;}
	if($comp18 === "0" && $param18 === "3" && $crit == 1){ continue;}
	if($comp18 === "1" && $param18 === "3" && $crit == 35){ continue;}

	$dataarray[16][$j] = $row9['name'];
	$dataarray[17][$j] = $row9['id'];
	$j++;
}
$fpartarray[8] = $fpartarray[8]." (".$j.")";
$total = $total + $j;

if($j > $i){$i = $j;}
$j=0;

$output10 = mysql_query($func10, $connection);
while($output10 && $row10 = mysql_fetch_assoc($output10)){
	#Testing Pass/Fail of IV test
	$dumped = dump("module_p", $row10['id']);
	$crit =  xmlgrapher_crit_num($dumped['assoc_sens'],"IV","module", 0);
	
	if($comp2 === "=" && $param2 !== "" && $param2 != curgrade($row10['id'])){ continue;}
	if($comp2 === ">" && $param2 !== "" && $param2 <= curgrade($row10['id'])){ continue;}
	if($comp2 === "<" && $param2 !== "" && $param2 >= curgrade($row10['id'])){ continue;}
	if($comp2 === ">=" && $param2 !== "" && $param2 < curgrade($row10['id'])){ continue;}
	if($comp2 === "<=" && $param2 !== "" && $param2 > curgrade($row10['id'])){ continue;}
	if($comp2 === "!=" && $param2 !== "" && $param2 == curgrade($row10['id'])){ continue;}
	
	if($comp18 === "0" && $param18 === "0" && $crit%5 > 0){ continue;}
	if($comp18 === "1" && $param18 === "0" && $crit%5 == 0){ continue;}
	if($comp18 === "0" && $param18 === "1" && $crit%7 > 0){ continue;}
	if($comp18 === "1" && $param18 === "1" && $crit%7 == 0){ continue;}
	if($comp18 === "0" && $param18 === "2" && $crit%35 > 0){ continue;}
	if($comp18 === "1" && $param18 === "2" && $crit != 1){ continue;}
	if($comp18 === "0" && $param18 === "3" && $crit == 1){ continue;}
	if($comp18 === "1" && $param18 === "3" && $crit == 35){ continue;}

	$dataarray[18][$j] = $row10['name'];
	$dataarray[19][$j] = $row10['id'];
	$j++;
}
$fpartarray[9] = $fpartarray[9]." (".$j.")";
$total = $total + $j;

if($j > $i){$i = $j;}


echo $total." matching modules";

echo "<table cellspacing=60 border=0>";
echo "<tr valign=top>";

for($l=0;$l<10;$l++){
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

?>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
