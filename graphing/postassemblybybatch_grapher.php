<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
include('../jpgraph/src/jpgraph.php');
include('../jpgraph/src/jpgraph_date.php');
include('../jpgraph/src/jpgraph_line.php');
include('../jpgraph/src/jpgraph_bar.php');

ini_set('display_errors','On');
error_reporting(E_ALL | E_STRICT);

#$arrDates;
#$arrReceived;
#$arrAssembled;
#$arrTested;

$arr = array();
$arrFix = array();

$arrA = array();
$arrB = array();
$arrC = array();

mysql_query("USE cmsfpix_u", $connection);

#$date = time();
#if(!$_SESSION['hidepre']){
#	$hide = " AND received > \"2015-09-01\"";
#}
#
#$loc = $_GET['loc'];
#$loc_condition=TRUE;
#if($loc == "purdue"){
#	$loc_condition = "Purdue";
#}
#if($loc == "nebraska"){
#	$loc_condition = "Nebraska";
#}

$g = 0;

$func0 = "select count(received) as receive, count(shipped) as ship, count(post_tested_n20C) as tested, count(post_tested_17c) as ptested, count(post_tested_xray) as xrayed, count(post_tested_thermal_cycle) as thermal, WEEK(DATE_SUB(received, INTERVAL 3 DAY)) as batch, DATE_FORMAT(received, \"%y-%m-%d\") as date from times_module_p where received > \"2015-09-01\" group by batch order by received";
$func1 = "select count(a.id) as num, WEEK(DATE_SUB(received, INTERVAL 3 DAY)) as batch,  date_format(received,\"%y-%m-%d\") as date from module_p a, times_module_p b where a.id=b.assoc_module and b.received>\"2015-09-01\" and a.tested_status=\"Rejected\" and b.post_tested_n20C is null group by batch order by received";

#echo $func0."<br>";
$output0 = mysql_query($func0,$connection);
$output1 = mysql_query($func1,$connection);

while($row0 = mysql_fetch_assoc($output0)){
	    if($g!=0){
	    $arr[0][$g] = ($row0['date']);
	    $arr[1][$g] = $row0['receive']+$arr[1][$g-1];
	    $arr[2][$g] = $row0['ship']+$arr[2][$g-1];
	    $arr[3][$g] = $row0['tested']+$arr[3][$g-1];
	    $arr[4][$g] = $row0['batch']+$arr[4][$g-1];
	    $arr[5][$g] = $row0['ptested']+$arr[5][$g-1];
	    $arr[6][$g] = $row0['xrayed']+$arr[6][$g-1];
	    $arr[7][$g] = $row0['thermal']+$arr[7][$g-1];
	    }
	    else{
	    $arr[0][$g] = ($row0['date']);
	    $arr[1][$g] = $row0['receive'];
	    $arr[2][$g] = $row0['ship'];
	    $arr[3][$g] = $row0['tested'];
	    $arr[4][$g] = $row0['batch'];
	    $arr[5][$g] = $row0['ptested'];
	    $arr[6][$g] = $row0['xrayed'];
	    $arr[7][$g] = $row0['thermal'];
	    }
	    $g++;
}

$g = 0;
### fix for modules that have been rejected without being tested
while($row1 = mysql_fetch_assoc($output1)){
	    $arrFix[0][$g] = $row1['date'];
	    $arrFix[1][$g] = $row1['num'];
	    $arrFix[2][$g] = $row1['batch'];
	    $g++;
}
#echo ($arrFix[0][0])." ".$arrFix[1][0];
for($x=0; $x<count($arrFix[0]);$x++){
	  for($y=0;$y<count($arr[0]);$y++){
	  if($arrFix[2][$x] == $arr[4][$y]){
	  	$arr[3][$y] += $arrFix[1][$x];
	  }
	  }
}

#echo $arr[0][0]."<br>";
#print_r($arrIDs[0]);
#print_r($arr[0]);
#echo "<br>";
#print_r($arrFix[0]);

$graph = new Graph(1340,800);

$graph->SetScale('textlin');
$graph->SetFrame(true,'black',0);

$graph->title->SetFont(FF_FONT2,FS_BOLD);

$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->title->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->title->Set("Time");
$graph->xaxis->title->SetMargin(60);
$graph->xaxis->SetFont(FF_FONT2, FS_BOLD);
#$graph->xaxis->scale->ticks->Set(7*24*60*60);
$graph->xaxis->SetTickLabels($arr[0]);

$graph->yaxis->SetFont(FF_FONT2, FS_BOLD);
$graph->yaxis->title->SetMargin(20);
$graph->yaxis->scale->SetAutoMin(0);

$graph->title->Set('Post-Assembly Testing by Batch');
$graph->xaxis->title->Set('Day Received');
$graph->yaxis->title->Set('Number');

$graph->img->SetAntiAliasing(false);
$graph->img->SetMargin(70,80,40,40);	

$graph->legend->SetPos(.1, .1, 'left','top');
$graph->legend->SetFont(FF_FONT2,FS_BOLD);
 
#// Create a line plot
$b1plot = new LinePlot($arr[1]);
$b2plot = new LinePlot($arr[2]);
$b3plot = new LinePlot($arr[3]);
$b5plot = new LinePlot($arr[5]);
$b6plot = new LinePlot($arr[6]);
$b7plot = new LinePlot($arr[7]);

$graph->Add($b1plot);
$b1plot->SetColor('black@0.5');
$b1plot->SetWeight(7);
$b1plot->SetStyle("solid");
$b1plot->SetStepStyle();
$b1plot->SetLegend("Received");

$graph->Add($b2plot);
$b2plot->SetColor('purple@0.5');
$b2plot->SetWeight(7);
$b2plot->SetStyle("solid");
$b2plot->SetStepStyle();
$b2plot->SetLegend("Shipped");

$graph->Add($b3plot);
$b3plot->SetColor('blue@0.5');
$b3plot->SetWeight(7);
$b3plot->SetStyle("solid");
$b3plot->SetStepStyle();
$b3plot->SetLegend("Tested at -20C");

$graph->Add($b5plot);
$b5plot->SetColor('red@0.5');
$b5plot->SetWeight(7);
$b5plot->SetStyle("solid");
$b5plot->SetStepStyle();
$b5plot->SetLegend("Tested at +17C");

$graph->Add($b6plot);
$b6plot->SetColor('green@0.5');
$b6plot->SetWeight(7);
$b6plot->SetStyle("solid");
$b6plot->SetStepStyle();
$b6plot->SetLegend("X Ray Tested");

$graph->Add($b7plot);
$b7plot->SetColor('orange@0.5');
$b7plot->SetWeight(7);
$b7plot->SetStyle("solid");
$b7plot->SetStepStyle();
$b7plot->SetLegend("Thermal Cycled");

$graph->yaxis->title->SetFont(FF_FONT2,FS_BOLD);
$graph->legend->SetLineWeight(12);
#// Display the graph
$graph->Stroke();

?>
