<?php
function avg_positiongrapher_crit($level, $scan, $loc){
require_once('../jpgraph/src/jpgraph.php');
require_once('../jpgraph/src/jpgraph_scatter.php');
require_once('../jpgraph/src/jpgraph_log.php');
require_once('../jpgraph/src/jpgraph_line.php');

include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
mysql_query('USE cmsfpix_u',$connection);

if($hider == ""){
	$imagefile = "../pics/graphs/".$level."_".$loc."_".$scan."_with_preproduction.png";
}
else{
	$imagefile = "../pics/graphs/".$level."_".$loc."_".$scan.".png";
}

$sensorsout = array();
$sensors = array();
$timestamps = array();
$measurements = array();
$colors = array("#000000","#ffff00","#a020f0","#ffa500","#add8e6","#ff0000","#bebebe","#00ff00","#ff1493","#0000ff","#ee82ee","#ffa07a","#98fb98","#8b4513","#9acd32","#6b8e23");


$hide = hidepre("sensor", 2);

$arr1 = array();
$limitarr;
$markedarr = array();
$I150 = array();
$empty=1;

###Array for a limit line
for($loop=0;$loop<=15;$loop++){
	$limitarr[0][$loop]=$loop*10;
	$limitarr[1][$loop]=2E-6;
}
	$limitarr[0][16]=150.1;
	$limitarr[1][16]=1E-10;

$sensorfunc = "SELECT name, id FROM sensor_p WHERE name LIKE \"%".$loc."%\"".$hide;
$sensoroutput = mysql_query($sensorfunc, $connection);

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
#if($roW = mysql_fetch_assoc($output)){
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
		$I150[$k]=log($arr1[$k][1][$index150], 10);
		#$I150[$k]=$arr1[$k][1][$index150];

	if($I150>2E-6){
		$markedarr[$k]=1;
	}
	else if($I150/$I100>2){
		$markedarr[$k]=2;
	}
	else{
		$markedarr[$k]=0;
	}

$k++;
}

return mean_and_dev($I150);

}
?>
