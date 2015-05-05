<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
require_once('../jpgraph/src/jpgraph.php');
require_once('../jpgraph/src/jpgraph_date.php');
require_once('../jpgraph/src/jpgraph_bar.php');

$sensorarr;
$measarr;
$posarr;

mysql_query("USE cmsfpix_u", $connection);

$date = time();

$func1 = "SELECT name,id FROM sensor_p WHERE module IS NOT NULL";
$output1 = mysql_query($func1, $connection);

$i=0;
$j=-1;
$ship_base = 0;

while($row1 = mysql_fetch_assoc($output1)){
	
	
	$recfunc = "SELECT assembly FROM module_p WHERE assoc_sens=".$row1['id'];
	$recout = mysql_query($recfunc, $connection);
	$recrow = mysql_fetch_assoc($recout);

	if($recrow['assembly'] == 0){
		continue;
	}

	$pos = substr($row1['name'],3,2);
	$posarr[] = $pos;


	$sensorarr[$pos][0][] = $row1['name'];
	$sensorarr[$pos][1][] = $row1['id'];

	$i++;

		$funcw = "SELECT file FROM measurement_p WHERE scan_type=\"IV\" AND part_ID=\"".$row1['id']."\" AND part_type=\"wafer\" ORDER BY time_created DESC";
		$outputw = mysql_query($funcw, $connection);
		if($roww = mysql_fetch_assoc($outputw)){
			$sensorarr[$pos][2][] = gradeMeas($roww['file']);
		}
		else{
			$sensorarr[$pos][2][] = "NONE";
		}

		$funcb = "SELECT file FROM measurement_p WHERE scan_type=\"IV\" AND part_ID=\"".$row1['id']."\" AND part_type=\"module\" ORDER BY time_created DESC";
		$outputb = mysql_query($funcb, $connection);
		if($rowb = mysql_fetch_assoc($outputb)){
			$sensorarr[$pos][3][] = gradeMeas($rowb['file']);
		}
		else{
			$sensorarr[$pos][3][] = "NONE";
		}

		$funca = "SELECT file FROM measurement_p WHERE scan_type=\"IV\" AND part_ID=\"".$row1['id']."\" AND part_type=\"assembled\" ORDER BY time_created DESC";
		$outputa = mysql_query($funca, $connection);
		if($rowa = mysql_fetch_assoc($outputa)){
			$sensorarr[$pos][4][] = gradeMeas($rowa['file']);
		}
		else{
			$sensorarr[$pos][4][] = "NONE";
		}

}

$i=0;

foreach($sensorarr as $row){

	for($k1=1;$k1<=3;$k1++){

		$failed = 0;
		$total = 0;
		$numer = 0;
		$denom = 0;
		
		foreach($row[$k1+1] as $grade){
	
			if($grade === NULL){
				break;
			}
	
			if($grade == 1 || $grade == 3){
				$numer++;
				$denom++;
			}
			if($grade == 2 || $grade == 6){
				$failed++;
				$denom++;
			}
			$total++;
		}
		if($total==0){
			$measarr[$k1-1][$pos] = 0;
		}
		else{
			$measarr[$k1-1][$i] = $numer/$total;
			#$measarr[$k1-1][$i] = $failed/$total;
		}
	}

$i++;
}



$graphname = "Wafer Yield";

$graph=new Graph(1340,800);
$graph->SetScale("textlin", 0, 1, 0, $i);

$graph->xaxis->SetTickLabels($posarr);

#$graph->xaxis->SetLabelAngle(90);

#$graph->img->SetMargin(70,80,40,40);	

#$graph->title->Set($graphname);

#$graph->title->SetFont(FF_FONT1,FS_BOLD);

#$graph->xaxis->title->Set("Time");
$graph->xaxis->scale->ticks->Set(1);

#$graph->yaxis->title->Set("");

#$graph->yaxis->title->SetMargin(30);
#$graph->SetFrame(true,'black',0);

$graph->img->SetAntiAliasing(false);

#print_r($mainarr[1]);
#echo "<br>";

#print_r($mainarr[4]);
#echo "<br>";

$bplot = new BarPlot($measarr[0]);

$bplot2 = new BarPlot($measarr[1]);

$bplot3 = new BarPlot($measarr[2]);

$gbplot = new GroupBarPlot(array($bplot, $bplot2, $bplot3));

$graph->Add($gbplot);

$bplot->SetFillColor("blue");
$bplot2->SetFillColor("green");
$bplot3->SetFillColor("red");

$graph->Stroke();

?>
