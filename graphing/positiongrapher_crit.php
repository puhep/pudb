<?php
function positiongrapher_crit($level, $scan, $loc){

require_once('../jpgraph/src/jpgraph.php');
require_once('../jpgraph/src/jpgraph_scatter.php');
require_once('../jpgraph/src/jpgraph_log.php');

include('../../../Submission_p_secure_pages/connect.php');
mysql_query('USE cmsfpix_u',$connection);

$sensorsout = array();
$sensors = array();
$timestamps = array();
$measurements = array();
$colors = array("#000000","#ffff00","#a020f0","#ffa500","#add8e6","#ff0000","#bebebe","#00ff00","#ff1493","#0000ff","#ee82ee","#ffa07a","#98fb98","#8b4513","#9acd32","#6b8e23");


$arr1 = array();
$limitarr;
$markedarr = array();
$empty=1;

$sensorfunc = "SELECT name, id FROM sensor_p WHERE name LIKE \"%".$loc."%\"";
$sensoroutput = mysql_query($sensorfunc, $connection);

#echo $sensorfunc;

$i = 0;
while($sensrow = mysql_fetch_assoc($sensoroutput)){
	$sensorsout[$i][0] = $sensrow['name'];
	$sensorsout[$i][1] = $sensrow['id'];
	$i++;
}

$j = 0;
for($j=0;$j<$i;$j++){

$func = "SELECT file FROM measurement_p WHERE scan_type=\"$scan\" AND part_type=\"".$level."\" AND part_ID=\"".$sensorsout[$j][1]."\" ORDER BY time_created DESC";
$output = mysql_query($func, $connection);
#if($row = mysql_fetch_assoc($output)){
if(mysql_num_rows($output)){
	
	$empty=0;
	$row = mysql_fetch_assoc($output);
	$measurements[] = $row['file'];
	$sensors[] = $sensorsout[$j];
}

}


if($scan == "IV"){
	if($level == "wafer"){
		$y = "ACTV_CURRENT_AMP";
	}
	else{
		$y = "TOT_CURRENT_AMP";
	}
}
if($scan == "CV"){
$y = "ACTV_CAP_FRD";}

$graphname = "All ".$loc." ".$scan." Scans";
$datacountlim = 0;

$k=0;
foreach($measurements as $xml){


$doc1=simplexml_load_string($xml);

	$datacount1 = count($doc1->DATA_SET->DATA);
	$datacountlim = $datacount1;
	$timestamps[$k] = $doc1->HEADER->RUN->RUN_BEGIN_TIMESTAMP;
	if($timestamps[$k] == ""){
		$timestamps[$k] = "No Timestamp";
	}

	for($loop=0;$loop<$datacount1;$loop++){

		$arr1[$k][0][$loop]=$doc1->DATA_SET->DATA[$loop]->VOLTAGE_VOLT;

		settype($arr1[$k][0][$loop],"float");

		$arr1[$k][0][$loop] = abs($arr1[$k][0][$loop]);

		$arr1[$k][1][$loop]=$doc1->DATA_SET->DATA[$loop]->$y;
		if($arr1[$k][1][$loop] == "NaN"){
			$arr1[$k][1][$loop] = 1E-10;
		}	
			settype($arr1[$k][1][$loop],"float");
			if($arr1[$k][1][$loop] < 0){
				#$arr1[$k][1][$loop] = 1E-10;
				$arr1[$k][1][$loop] *= -1;
			}
			#if($arr1[$k][1][$loop] > $limitarr[$loop]){
			#	$markedA=1;
			#}
	}

	$index100 = array_search(100, $arr1[$k][0]);
		$I100=$arr1[$k][1][$index100];

	$index150 = array_search(150, $arr1[$k][0]);
		$I150=$arr1[$k][1][$index150];

	if($I150>2E-6){
		$markedarr[0]++;
	}
	if($I150/$I100>2){
		$markedarr[1]++;
	}

$k++;

}

echo "<div style='font-size:120%'>";
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

echo "<tr>";
echo "<td>";
echo "Passing Modules";
echo "</td>";
echo "<td>";
echo $k-$markedarr[0]."/".$k;
echo "</td>";
echo "<td>";
echo $k-$markedarr[1]."/".$k;
echo "</td>";
echo "</tr>";


echo "</table>";
echo "</div>";
}
?>
