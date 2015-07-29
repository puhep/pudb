<?php
require_once('../jpgraph/src/jpgraph.php');
require_once('../jpgraph/src/jpgraph_scatter.php');
require_once('../jpgraph/src/jpgraph_bar.php');
require_once('../jpgraph/src/jpgraph_error.php');
require_once('../jpgraph/src/jpgraph_log.php');
require_once('../jpgraph/src/jpgraph_line.php');

include('../graphing/avg_positiongrapher_crit.php');


$posvals = array();
$arr1 = array();
$arr2 = array();

$ticklabels = array("","TT","FL","LL","CL","CR","RR","FR","BB","");
$xarr = array(1,2,3,4,5,6,7,8);


$posvals[0] = avg_positiongrapher_crit("module", "IV", "TT");
$posvals[1] = avg_positiongrapher_crit("module", "IV", "FL");
$posvals[2] = avg_positiongrapher_crit("module", "IV", "LL");
$posvals[3] = avg_positiongrapher_crit("module", "IV", "CL");
$posvals[4] = avg_positiongrapher_crit("module", "IV", "CR");
$posvals[5] = avg_positiongrapher_crit("module", "IV", "RR");
$posvals[6] = avg_positiongrapher_crit("module", "IV", "FR");
$posvals[7] = avg_positiongrapher_crit("module", "IV", "BB");

foreach($posvals as $row){
	$arr1[] = $row[0];
	$arr2[] = $row[0]-$row[1]/2;
	$arr2[] = $row[0]+$row[1]/2;
}

$datay = array(12,8,19,3,10,5);

#print_r($arr1);
#print_r($arr2);

$graph=new Graph(1340,800);

$graph->SetScale("textlin",-8,-5,-1,8);

$graph->xaxis->SetTickLabels($ticklabels);

$graph->xaxis->SetPos('min');
$graph->xaxis->scale->ticks->Set(1,1);
$graph->xaxis->title->Set("Wafer Position");

$graph->yaxis->SetPos('min');
$graph->yaxis->title->Set("Average Log(I(V=150))");

$graph->img->SetMargin(70,80,40,40);	


#$graph->title->Set($graphname);

$graph->title->SetFont(FF_FONT1,FS_BOLD);

$graph->xaxis->title->Set("Bias Voltage [V]");

if($scan=="IV"){
$graph->yaxis->title->Set("Sensor Leakage Current [A]");}

$graph->yaxis->title->SetMargin(30);
$graph->SetFrame(true,'black',0);


$sp1 = new ScatterPlot($arr1);
$graph->Add($sp1);

$sp2 = new ErrorPlot($arr2);
$graph->Add($sp2);

 $graph->Stroke();
?>
