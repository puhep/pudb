<?php
include('../jpgraph/src/jpgraph.php');
include('../jpgraph/src/jpgraph_scatter.php');
include('../jpgraph/src/jpgraph_log.php');

include('../../../Submission_p_secure_pages/connect.php');
mysql_query('USE cmsfpix_u',$connection);

$wafid = $_GET['partid'];
$type = $_GET['type'];
$scan = $_GET['scan'];
$hl = $_GET['hl'];


$sensorsout = array();
$sensors = array();
$timestamps = array();
$measurements = array();
$modules = array();
$colors = array("#000000","#ffff00","#a020f0","#ffa500","#add8e6","#ff0000","#bebebe","#00ff00","#ff1493","#0000ff","#ee82ee","#ffa07a","#98fb98","#8b4513","#9acd32","#6b8e23");
$lowmodules = array("M_RR_913", "M_CR_913", "M_TT_902", "M_CL_913", "M_CR_902", "M_RR_906", "M_LL_902", "M_CL_902", "M_CR_902", "M_LL_906");

$highmodules = array("M_FR_906", "M_FL_906", "M_FL_902", "M_BB_923");

if($hl == "l"){
	$modules = $lowmodules;
}
else if($hl == "h"){
	$modules = $highmodules;
}


$arr1 = array();
$limitarr;
$markedarr = array();
$empty=1;
$i = 0;

for($looper=0;$looper<14;$looper++){

$modfunc = "SELECT assoc_sens FROM module_p WHERE name=\"$modules[$looper]\"";
$modout = mysql_query($modfunc, $connection);
$modrow = mysql_fetch_assoc($modout);
$mod_assoc_sens = $modrow['assoc_sens'];

$sensorfunc = "SELECT name, id FROM sensor_p WHERE id=$mod_assoc_sens";
$sensoroutput = mysql_query($sensorfunc, $connection);

while($sensrow = mysql_fetch_assoc($sensoroutput)){
	$sensorsout[$i][0] = $sensrow['name'];
	$sensorsout[$i][1] = $sensrow['id'];
	$i++;
}
}

$j = 0;
for($j=0;$j<$i;$j++){

$func = "SELECT file FROM measurement_p WHERE scan_type=\"$scan\" AND part_type=\"$type\" AND part_ID=\"".$sensorsout[$j][1]."\" ORDER BY time_created DESC";
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
$y = "ACTV_CURRENT_AMP";
$y2 = "ACTV_CURRENT_AMP";}
if($scan == "CV"){
$y = "ACTV_CAP_FRD";}

$graphname = $partname." ".$scan." Scan";
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
		
		if($doc1->DATA_SET->DATA[$loop]->VOLTAGE_VOLT > 750){
			continue;
		}

		$arr1[$k][0][$loop]=$doc1->DATA_SET->DATA[$loop]->VOLTAGE_VOLT;

		settype($arr1[$k][0][$loop],"float");

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

	if($I150>2E-6 || $I150/$I100>2){
		$markedarr[$k]=1;
	}
	else{
		$markedarR[$k]=0;
	}

$k++;

}

$graph=new Graph(1340,800);

if(!$empty){
$graph->SetScale("linlog",-9,-3.9,0,750);
}
else{
$graph->SetScale("linlog",-9,-3.9,0,750);
}

$graph->legend->SetPos(.5,.85, 'left', 'bottom');

$graph->img->SetMargin(70,80,40,40);	

$graph->title->Set($graphname);

$graph->title->SetFont(FF_FONT1,FS_BOLD);

$graph->xaxis->title->Set("Bias Voltage [V]");

if($scan=="IV"){
$graph->yaxis->title->Set("Sensor Leakage Current [A]");}
if($scan=="CV"){
$graph->yaxis->title->Set("Capacitance [F]");}

$graph->yaxis->title->SetMargin(30);
$graph->SetFrame(true,'black',0);

$sp1 = array();

$l=0;
for($l=0;$l<$k;$l++){


$QC = " PASS";
if($markedarr[$l]){
	$QC = " FAIL";
}

$sp1[$l] = new ScatterPlot($arr1[$l][1],$arr1[$l][0]);
$sp1[$l]->mark->SetWidth(8);
$sp1[$l]->mark->SetFillColor($colors[$l]);
$sp1[$l]->link->Show();
$graph->Add($sp1[$l]);
$sp1[$l]->SetLegend($sensors[$l][0]."\n".$timestamps[$l]);
}

#if($scan=="IV"){
#$splim = new ScatterPlot($limitarr[1],$limitarr[0]);
#$splim->mark->SetWidth(8);
#$splim->mark->SetFillColor("red");
#$splim->link->Show();
#$graph->Add($splim);
#$splim->SetLegend("Limit");
#}

$graph->Stroke();
?>
