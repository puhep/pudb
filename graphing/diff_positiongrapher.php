<?php
require_once('../jpgraph/src/jpgraph.php');
require_once('../jpgraph/src/jpgraph_scatter.php');
require_once('../jpgraph/src/jpgraph_log.php');
require_once('../jpgraph/src/jpgraph_line.php');

include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
mysql_query('USE cmsfpix_u',$connection);

$level = $_GET['level'];
$scan = $_GET['scan'];
$loc = $_GET['loc'];

#if($hider == ""){
	#$imagefile = "../pics/graphs/".$level."_".$loc."_".$scan."_with_preproduction.png";
#}
#else{
	#$imagefile = "../pics/graphs/".$level."_".$loc."_".$scan.".png";
#}
	


$sensorsout = array();
$sensors = array();
$timestamps = array();
$measurements = array();
$colors = array("#000000","#ffff00","#a020f0","#ffa500","#add8e6","#ff0000","#bebebe","#00ff00","#ff1493","#0000ff","#ee82ee","#ffa07a","#98fb98","#8b4513","#9acd32","#6b8e23");


$hide = hidepre("sensor", 2);

$arr1 = array();
$limitarr;
$markedarr = array();
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

$func_waf = "SELECT file FROM measurement_p WHERE scan_type=\"$scan\" AND part_type=\"wafer\" AND part_ID=\"".$sensorsout[$j][1]."\" ORDER BY time_created DESC";
$func_bare = "SELECT file FROM measurement_p WHERE scan_type=\"$scan\" AND part_type=\"module\" AND part_ID=\"".$sensorsout[$j][1]."\" ORDER BY time_created DESC";

$output_waf = mysql_query($func_waf, $connection);
$output_bare = mysql_query($func_bare, $connection);

if(mysql_num_rows($output_waf) && mysql_num_rows($output_bare)){
	
	$empty=0;
	$row_waf = mysql_fetch_assoc($output_waf);
	$row_bare = mysql_fetch_assoc($output_bare);
	$measurements[0][] = $row_waf['file'];
	$measurements[1][] = $row_bare['file'];
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
foreach($measurements[0] as $xml_waf){

$xml_bare = $measurements[1][$k];

$doc_waf=simplexml_load_string($xml_waf);
$doc_bare=simplexml_load_string($xml_bare);

	$datacount1 = count($doc_waf->DATA_SET->DATA);
	$datacountlim = $datacount1;
	$timestamps[$k] = $doc_waf->HEADER->RUN->RUN_BEGIN_TIMESTAMP;
	if($timestamps[$k] == ""){
		$timestamps[$k] = "No Timestamp";
	}

	for($loop=0;$loop<$datacount1;$loop++){

		$tmpval=$doc_waf->DATA_SET->DATA[$loop]->VOLTAGE_VOLT;

		settype($tmpval,"float");

		$tmpval = abs($tmpval);
		
		if($tmpval > 200){break;}

		$arr1[$k][0][$loop] = $tmpval;

		$bareval = $doc_bare->DATA_SET->DATA[$loop]->TOT_CURRENT_AMP;
			settype($bareval,"float");
		$wafval=$doc_waf->DATA_SET->DATA[$loop]->ACTV_CURRENT_AMP;
			settype($wafval,"float");

		$arr1[$k][1][$loop]=abs($bareval - $wafval);
		if($arr1[$k][1][$loop] == "NaN"){
			$arr1[$k][1][$loop] = 1E-10;
		}	
			settype($arr1[$k][1][$loop],"float");
	}

	$index100 = array_search(100, $arr1[$k][0]);
		$I100=$arr1[$k][1][$index100];

	$index150 = array_search(150, $arr1[$k][0]);
		$I150=$arr1[$k][1][$index150];

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

$graph=new Graph(1340,800);

if(!$empty){
$graph->SetScale("linlog");
}
else{
$graph->SetScale("linlog",-10,-4,0,600);
}

$graph->img->SetMargin(70,80,40,40);	

$graph->img->SetAntiAliasing(false);	

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
if($markedarr[$l]==1){
	$QC = " FAIL1";
}
if($markedarr[$l]==2){
	$QC = " FAIL2";
}

$sp1[$l] = new ScatterPlot($arr1[$l][1],$arr1[$l][0]);
$sp1[$l]->mark->SetWidth(8);
$color = sprintf('#%06X', mt_rand(0,0xFFFFFF));
$sp1[$l]->mark->SetFillColor($color);
$sp1[$l]->link->Show();
$graph->Add($sp1[$l]);
$sp1[$l]->SetLegend($sensors[$l][0]);
}

/*
if($scan=="IV"){
$splim = new LinePlot($limitarr[1],$limitarr[0]);
$graph->Add($splim);
$splim->SetWeight(2);
$splim->SetColor("black");
$splim->SetLegend("2uA at 150V Limit");
#$splim->SetStyle("dotted");
}
*/

 #$graph->StrokeStore($imagefile);
 $graph->Stroke();
?>
