<?php
function xmlgrapher_crit($id, $scan, $level){
include('../../../Submission_p_secure_pages/connect.php');

$func = "SELECT file, filesize, part_type FROM measurement_p WHERE part_ID=\"$id\" AND scan_type=\"$scan\"";
$namefunc = "SELECT name, module FROM sensor_p WHERE id=\"$id\"";
$modfunc = "SELECT name FROM module_p WHERE assoc_sens=\"$id\"";

mysql_query('USE cmsfpix_u', $connection);

$file = mysql_query($func, $connection);

$nameout = mysql_query($namefunc, $connection);
$namerow = mysql_fetch_assoc($nameout);
$name = $namerow['name'];

if($namerow['module']){	
	$modout = mysql_query($modfunc, $connection);
	$modrow = mysql_fetch_assoc($modout);
	$name = $modrow['name'];
}

$file1 = NULL;
$file2 = NULL;
$file3 = NULL;
$file4 = NULL;

while($row = mysql_fetch_assoc($file)){
	
	if($row['part_type'] == "wafer"){
		$file1 = $row['file'];
	}
	if($level != "sensor"){
		if($row['part_type'] == "module"){
			$file2 = $row['file'];
		}
		if($level == "module"){
			if($row['part_type'] == "assembled"){
				$file3 = $row['file'];
			}
			if($row['part_type'] == "fnal"){
				$file4 = $row['file'];
			}
		}
	}
}


if(!is_null($file1)){
$doc1=simplexml_load_string($file1);}

if(!is_null($file2)){
$doc2=simplexml_load_string($file2);}

if(!is_null($file3)){
$doc3=simplexml_load_string($file3);}

if(!is_null($file4)){
$doc4=simplexml_load_string($file4);}

if($scan == "IV"){
$y = "ACTV_CURRENT_AMP";
$y2 = "TOT_CURRENT_AMP";}
if($scan == "CV"){
$y = "ACTV_CAP_FRD";}

$datacountlim = 0;

if(!is_null($file1)){
	$datacount1 = count($doc1->DATA_SET->DATA);
	$datacountlim = $datacount1;
	$timestamp1 = $doc1->HEADER->RUN->RUN_BEGIN_TIMESTAMP;
	if($timestamp1 == ""){
		$timestamp1 = "No Timestamp";
	}
}
if(!is_null($file2)){
	$datacount2 = count($doc2->DATA_SET->DATA);
	if($datacount2 > $datacountlim){
		$datacountlim = $datacount2;
	}

	$timestamp2 = $doc2->HEADER->RUN->RUN_BEGIN_TIMESTAMP;
	if($timestamp2 == ""){
		$timestamp2 = "No Timestamp";
	}
}
if(!is_null($file3)){
	$datacount3 = count($doc3->DATA_SET->DATA);
	if($datacount3 > $datacountlim){
		$datacountlim = $datacount3;
	}

	$timestamp3 = $doc3->HEADER->RUN->RUN_BEGIN_TIMESTAMP;
	if($timestamp3 == ""){
		$timestamp3 = "No Timestamp";
	}
}
if(!is_null($file4)){
	$datacount4 = count($doc4->DATA_SET->DATA);
	if($datacount4 > $datacountlim){
		$datacountlim = $datacount4;
	}

	$timestamp4 = $doc4->HEADER->RUN->RUN_BEGIN_TIMESTAMP;
	if($timestamp4 == ""){
		$timestamp4 = "No Timestamp";
	}
}
$arr1;
$arr2;
$arr3;
$arr4;
$limitarr;
$markedA=1;
$markedB=1;
$markedC=1;
$markedD=1;

if(!is_null($file1)){
	for($loop=0;$loop<$datacount1;$loop++){

		$arr1[0][$loop]=$doc1->DATA_SET->DATA[$loop]->VOLTAGE_VOLT;

		settype($arr1[0][$loop],"float");
			$arr1[0][$loop] = round(abs($arr1[0][$loop]));

		$arr1[1][$loop]=$doc1->DATA_SET->DATA[$loop]->$y;
		if($arr1[1][$loop] == "NaN"){
			$arr1[1][$loop] = 1E-10;
		}
			settype($arr1[1][$loop],"float");
			if($arr1[1][$loop] < 0 || $arr1[1][$loop] == "NaN"){
				#$arr1[1][$loop] = 1E-10;
				$arr1[1][$loop] *= -1;
			}
	}
	
	$index100 = array_search(100, $arr1[0]);
	if($index100 === FALSE){
		$I100 = INF;
	}
	else{
		$I100=$arr1[1][$index100];
	}
	$index150 = array_search(150, $arr1[0]);
	if($index150 === FALSE){
		$I150 = INF;
	}
	else{
		$I150=$arr1[1][$index150];
	}
	if($I150>2E-6){
		$markedA*=2;
	}
	if($I150/$I100>2){
		$markedA*=3;
	}
}

if(!is_null($file2)){
	for($loop=0;$loop<$datacount2;$loop++){

		$arr2[0][$loop]=$doc2->DATA_SET->DATA[$loop]->VOLTAGE_VOLT;
		
		settype($arr2[0][$loop],"float");
			$arr2[0][$loop] = round(abs($arr2[0][$loop]));

		$arr2[1][$loop]=$doc2->DATA_SET->DATA[$loop]->$y2;
		if($arr2[1][$loop] == "NaN"){
			$arr2[1][$loop] = 1E-10;
		}
			settype($arr2[1][$loop],"float");
			if($arr2[1][$loop] < 0){
				#$arr2[1][$loop] = 1E-10;
				$arr2[1][$loop] *= -1;
			}
	}
	$index100 = array_search(100, $arr2[0]);
	if($index100 === FALSE){
		$I100 = INF;
	}
	else{
		$I100=$arr2[1][$index100];
	}
	$index150 = array_search(150, $arr2[0]);
	if($index150 === FALSE){
		$I150 = INF;
	}
	else{
		$I150=$arr2[1][$index150];
	}
	if($I150>2E-6){
		$markedB*=2;
	}
	if($I150/$I100>2){
		$markedB*=3;
	}
}

if(!is_null($file3)){
	for($loop=0;$loop<$datacount3;$loop++){

		$arr3[0][$loop]=$doc3->DATA_SET->DATA[$loop]->VOLTAGE_VOLT;
		
		settype($arr3[0][$loop],"float");
			$arr3[0][$loop] = round(abs($arr3[0][$loop]));

		$arr3[1][$loop]=$doc3->DATA_SET->DATA[$loop]->$y2;
		if($arr3[1][$loop] == "NaN"){
			$arr3[1][$loop] = 1E-10;
		}
			settype($arr3[1][$loop],"float");
			if($arr3[1][$loop] < 0){
				#$arr3[1][$loop] = 1E-10;
				$arr3[1][$loop] *= -1;
			}
	}
	$index100 = array_search(100, $arr3[0]);
	if($index100 === FALSE){
		$I100 = INF;
	}
	else{
		$I100=$arr3[1][$index100];
	}
	$index150 = array_search(150, $arr3[0]);
	if($index150 === FALSE){
		$I150 = INF;
	}
	else{
		$I150=$arr3[1][$index150];
	}
	if($I150>2E-6){
		$markedC*=2;
	}
	if($I150/$I100>2){
		$markedC*=3;
	}
}

if(!is_null($file4)){
	for($loop=0;$loop<$datacount4;$loop++){

		$arr4[0][$loop]=$doc4->DATA_SET->DATA[$loop]->VOLTAGE_VOLT;
		
		settype($arr4[0][$loop],"float");
			$arr4[0][$loop] = round(abs($arr4[0][$loop]));

		$arr4[1][$loop]=$doc4->DATA_SET->DATA[$loop]->$y2;
		if($arr4[1][$loop] == "NaN"){
			$arr4[1][$loop] = 1E-10;
		}
			settype($arr4[1][$loop],"float");
			if($arr4[1][$loop] < 0){
				#$arr4[1][$loop] = 1E-10;
				$arr4[1][$loop] *= -1;
			}
	}
	$index100 = array_search(100, $arr4[0]);
	if($index100 === FALSE){
		$I100 = INF;
	}
	else{
		$I100=$arr4[1][$index100];
	}
	$index150 = array_search(150, $arr4[0]);
	if($index150 === FALSE){
		$I150 = INF;
	}
	else{
		$I150=$arr4[1][$index150];
	}
	if($I150>2E-6){
		$markedD*=2;
	}
	if($I150/$I100>2){
		$markedD*=3;
	}
}

echo "<table border=1>";

echo "<tr>";
echo "<td>";
echo "</td>";
echo "<td>";
echo "I(V=150) < 2uA";
echo "</td>";
echo "<td>";
echo "I(V=150)/I(V=100) < 2";
echo "</td>";
echo "</tr>";

if(!is_null($file1)){

	echo "<tr>";
	echo "<td>";
	echo "On Wafer:";
	echo "</td>";

	echo "<td>";
	if(!($markedA%2)){echo "<p style=\"background-color:red;\">FAIL</p>";}
	else{echo "<p style=\"background-color:green;\">PASS</p>";}
	echo "</td>";

	echo "<td>";
	if(!($markedA%3)){echo "<p style=\"background-color:red;\">FAIL</p>";}
	else{echo "<p style=\"background-color:green;\">PASS</p>";}
	echo "</td>";

	echo "</tr>";
}

if(!is_null($file2)){

	echo "<tr>";
	echo "<td>";
	echo "Bare Module:";
	echo "</td>";

	echo "<td>";
	if(!($markedB%2)){echo "<p style=\"background-color:red;\">FAIL</p>";}
	else{echo "<p style=\"background-color:green;\">PASS</p>";}
	echo "</td>";

	echo "<td>";
	if(!($markedB%3)){echo "<p style=\"background-color:red;\">FAIL</p>";}
	else{echo "<p style=\"background-color:green;\">PASS</p>";}
	echo "</td>";

	echo "</tr>";
}

if(!is_null($file3)){

	echo "<tr>";
	echo "<td>";
	echo "Fully Assembled:";
	echo "</td>";

	echo "<td>";
	if(!($markedC%2)){echo "<p style=\"background-color:red;\">FAIL</p>";}
	else{echo "<p style=\"background-color:green;\">PASS</p>";}
	echo "</td>";

	echo "<td>";
	if(!($markedC%3)){echo "<p style=\"background-color:red;\">FAIL</p>";}
	else{echo "<p style=\"background-color:green;\">PASS</p>";}
	echo "</td>";

	echo "</tr>";
}

if(!is_null($file4)){

	echo "<tr>";
	echo "<td>";
	echo "Module at FNAL:";
	echo "</td>";

	echo "<td>";
	if(!($markedD%2)){echo "<p style=\"background-color:red;\">FAIL</p>";}
	else{echo "<p style=\"background-color:green;\">PASS</p>";}
	echo "</td>";

	echo "<td>";
	if(!($markedD%3)){echo "<p style=\"background-color:red;\">FAIL</p>";}
	else{echo "<p style=\"background-color:green;\">PASS</p>";}
	echo "</td>";

	echo "</tr>";
}

echo "</table>";
}

function xmlgrapher_crit_num($id, $scan, $level, $exclusive){
include('../../../Submission_p_secure_pages/connect.php');

$func = "SELECT file, filesize, part_type FROM measurement_p WHERE part_ID=\"$id\" AND scan_type=\"$scan\"";
$namefunc = "SELECT name, module FROM sensor_p WHERE id=\"$id\"";
$modfunc = "SELECT name FROM module_p WHERE assoc_sens=\"$id\"";

mysql_query('USE cmsfpix_u', $connection);

$file = mysql_query($func, $connection);

$nameout = mysql_query($namefunc, $connection);
$namerow = mysql_fetch_assoc($nameout);
$name = $namerow['name'];

if($namerow['module']){	
	$modout = mysql_query($modfunc, $connection);
	$modrow = mysql_fetch_assoc($modout);
	$name = $modrow['name'];
}

$file1 = NULL;
$file2 = NULL;
$file3 = NULL;
$file4 = NULL;

while($row = mysql_fetch_assoc($file)){
	
	if($row['part_type'] == "wafer"){
		$file1 = $row['file'];
	}
	if($level != "sensor"){
		if($row['part_type'] == "module"){
			$file2 = $row['file'];
		}
		if($level == "module"){
			if($row['part_type'] == "assembled"){
				$file3 = $row['file'];
			}
			if($row['part_type'] == "fnal"){
				$file4 = $row['file'];
			}
		}
	}
}


if(!is_null($file1)){
$doc1=simplexml_load_string($file1);}

if(!is_null($file2)){
$doc2=simplexml_load_string($file2);}

if(!is_null($file3)){
$doc3=simplexml_load_string($file3);}

if(!is_null($file4)){
$doc4=simplexml_load_string($file4);}

if($scan == "IV"){
$y = "ACTV_CURRENT_AMP";
$y2 = "TOT_CURRENT_AMP";}
if($scan == "CV"){
$y = "ACTV_CAP_FRD";}

$datacountlim = 0;

if(!is_null($file1)){
	$datacount1 = count($doc1->DATA_SET->DATA);
	$datacountlim = $datacount1;
	$timestamp1 = $doc1->HEADER->RUN->RUN_BEGIN_TIMESTAMP;
	if($timestamp1 == ""){
		$timestamp1 = "No Timestamp";
	}
}
if(!is_null($file2)){
	$datacount2 = count($doc2->DATA_SET->DATA);
	if($datacount2 > $datacountlim){
		$datacountlim = $datacount2;
	}

	$timestamp2 = $doc2->HEADER->RUN->RUN_BEGIN_TIMESTAMP;
	if($timestamp2 == ""){
		$timestamp2 = "No Timestamp";
	}
}
if(!is_null($file3)){
	$datacount3 = count($doc3->DATA_SET->DATA);
	if($datacount3 > $datacountlim){
		$datacountlim = $datacount3;
	}

	$timestamp3 = $doc3->HEADER->RUN->RUN_BEGIN_TIMESTAMP;
	if($timestamp3 == ""){
		$timestamp3 = "No Timestamp";
	}
}
if(!is_null($file4)){
	$datacount4 = count($doc4->DATA_SET->DATA);
	if($datacount4 > $datacountlim){
		$datacountlim = $datacount4;
	}

	$timestamp4 = $doc4->HEADER->RUN->RUN_BEGIN_TIMESTAMP;
	if($timestamp4 == ""){
		$timestamp4 = "No Timestamp";
	}
}
$arr1;
$arr2;
$arr3;
$arr4;
$limitarr;
$markedA=0;
$markedB=0;
$markedC=0;
$markedD=0;
$totmarked=0;

if(!is_null($file1)){
	$markedA=1;
	$totmarked=1;
	for($loop=0;$loop<$datacount1;$loop++){

		$arr1[0][$loop]=$doc1->DATA_SET->DATA[$loop]->VOLTAGE_VOLT;

		settype($arr1[0][$loop],"float");
			$arr1[0][$loop] = round(abs($arr1[0][$loop]));

		$arr1[1][$loop]=$doc1->DATA_SET->DATA[$loop]->$y;
		if($arr1[1][$loop] == "NaN"){
			$arr1[1][$loop] = 1E-10;
		}
			settype($arr1[1][$loop],"float");
			if($arr1[1][$loop] < 0 || $arr1[1][$loop] == "NaN"){
				#$arr1[1][$loop] = 1E-10;
				$arr1[1][$loop] *= -1;
			}
	}
	
	$index100 = array_search(100, $arr1[0]);
		$I100=$arr1[1][$index100];

	$index150 = array_search(150, $arr1[0]);
		$I150=$arr1[1][$index150];

	if($I150>2E-6){
		$markedA*=5;
	}
	if($I150>10E-6){
		$markedA*=5;
	}
	if($I150/$I100>2){
		$markedA*=7;
	}
}

if(!is_null($file2)){
	$markedB=1;
	$totmarked=1;
	for($loop=0;$loop<$datacount2;$loop++){

		$arr2[0][$loop]=$doc2->DATA_SET->DATA[$loop]->VOLTAGE_VOLT;
		
		settype($arr2[0][$loop],"float");
			$arr2[0][$loop] = round(abs($arr2[0][$loop]));

		$arr2[1][$loop]=$doc2->DATA_SET->DATA[$loop]->$y2;
		if($arr2[1][$loop] == "NaN"){
			$arr2[1][$loop] = 1E-10;
		}
			settype($arr2[1][$loop],"float");
			if($arr2[1][$loop] < 0){
				#$arr2[1][$loop] = 1E-10;
				$arr2[1][$loop] *= -1;
			}
	}
	$index100 = array_search(100, $arr2[0]);
		$I100=$arr2[1][$index100];

	$index150 = array_search(150, $arr2[0]);
		$I150=$arr2[1][$index150];

	if($I150>2E-6){
		$markedB*=5;
	}
	if($I150>10E-6){
		$markedB*=5;
	}
	if($I150/$I100>2){
		$markedB*=7;
	}
}

if(!is_null($file3)){
	$markedC=1;
	$totmarked=1;
	for($loop=0;$loop<$datacount3;$loop++){

		$arr3[0][$loop]=$doc3->DATA_SET->DATA[$loop]->VOLTAGE_VOLT;
		
		settype($arr3[0][$loop],"float");
			$arr3[0][$loop] = round(abs($arr3[0][$loop]));

		$arr3[0][$loop]=abs($arr3[0][$loop]);


		$arr3[1][$loop]=$doc3->DATA_SET->DATA[$loop]->$y2;
		if($arr3[1][$loop] == "NaN"){
			$arr3[1][$loop] = 1E-10;
		}
			settype($arr3[1][$loop],"float");
			if($arr3[1][$loop] < 0){
				#$arr3[1][$loop] = 1E-10;
				$arr3[1][$loop] *= -1;
			}
	}
	$index100 = array_search(100, $arr3[0]);
		$I100=$arr3[1][$index100];

	$index150 = array_search(150, $arr3[0]);
		$I150=$arr3[1][$index150];

	if($I150>2E-6){
		$markedC*=5;
	}
	if($I150>10E-6){
		$markedC*=5;
	}
	if($I150/$I100>2){
		$markedC*=7;
	}
}

if(!is_null($file4)){
	$markedD=1;
	$totmarked=1;
	for($loop=0;$loop<$datacount4;$loop++){

		$arr4[0][$loop]=$doc4->DATA_SET->DATA[$loop]->VOLTAGE_VOLT;
		
		settype($arr4[0][$loop],"float");
			$arr4[0][$loop] = round(abs($arr4[0][$loop]));

		$arr4[0][$loop]=abs($arr4[0][$loop]);


		$arr4[1][$loop]=$doc4->DATA_SET->DATA[$loop]->$y2;
		if($arr4[1][$loop] == "NaN"){
			$arr4[1][$loop] = 1E-10;
		}
			settype($arr4[1][$loop],"float");
			if($arr4[1][$loop] < 0){
				#$arr4[1][$loop] = 1E-10;
				$arr4[1][$loop] *= -1;
			}
	}
	$index100 = array_search(100, $arr4[0]);
		$I100=$arr4[1][$index100];

	$index150 = array_search(150, $arr4[0]);
		$I150=$arr4[1][$index150];

	if($I150>2E-6){
		$markedD*=5;
	}
	if($I150>10E-6){
		$markedD*=5;
	}
	if($I150/$I100>2){
		$markedD*=7;
	}
}

if($exclusive == 0){

	if(!is_null($file1) && $level=="wafer"){

		#$totmarked*=$markedA;
		return $markedA;
	}

	if(!is_null($file4) && $level=="module"){

		#$totmarked*=$markedD;
		return $markedD;
	}
	if(!is_null($file3) && $level=="module"){

		#$totmarked*=$markedC;
		return $markedC;
	}
	if(!is_null($file2) && $level=="module"){

		#$totmarked*=$markedB;
		return $markedB;
	}

	#return $totmarked;
}
else{
	switch($level){
		case "wafer":
			return $markedA;
			break;
		case "module":
			return $markedB;
			break;
		case "assembled":
			return $markedC;
			break;
		case "fnal":
			return $markedD;
			break;
		default:
			return 1;
	}
}
}
?>
