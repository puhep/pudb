<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
require_once('../jpgraph/src/jpgraph.php');
require_once('../jpgraph/src/jpgraph_date.php');
require_once('../jpgraph/src/jpgraph_bar.php');

$waferarr;
$sensorarr;
$measarr;

mysql_query("USE cmsfpix_u", $connection);

$date = time();

$func1 = "SELECT name,id FROM wafer_p WHERE assembly>=2 ORDER BY name ASC";

$output1 = mysql_query($func1, $connection);

$i=0;


while($row1 = mysql_fetch_assoc($output1)){

	if(!is_null($row1['name'])){
		$waferarr[0][$i] = $row1['name'];
		$waferarr[1][$i] = $id;
	}

	$sensorarr = array();

	$func2 = "SELECT name,id FROM sensor_p WHERE name LIKE \"WL_%_".$row1['name']."\"";
	$output2 = mysql_query($func2, $connection);

	$j=0;

	while($row2 = mysql_fetch_assoc($output2)){

		$recfunc = "SELECT assembly FROM module_p WHERE assoc_sens=".$row2['id'];
		$recout = mysql_query($recfunc, $connection);
		$recrow = mysql_fetch_assoc($recout);
		if($recrow['assembly'] == 0){
			continue;
		}

		$sensorarr[0][$j] = $row2['id'];

		$funcw = "SELECT file FROM measurement_p WHERE scan_type=\"IV\" AND part_ID=\"".$sensorarr[0][$j]."\" AND part_type=\"wafer\" ORDER BY time_created DESC";
		$outputw = mysql_query($funcw, $connection);
		if($roww = mysql_fetch_assoc($outputw)){
			$sensorarr[1][$j] = gradeMeas($roww['file']);
		}
		else{
			$sensorarr[1][$j] = 0;
		}

		$funcb = "SELECT file FROM measurement_p WHERE scan_type=\"IV\" AND part_ID=\"".$sensorarr[0][$j]."\" AND part_type=\"module\" ORDER BY time_created DESC";
		$outputb = mysql_query($funcb, $connection);
		if($rowb = mysql_fetch_assoc($outputb)){
			$sensorarr[2][$j] = gradeMeas($rowb['file']);
		}
		else{
			$sensorarr[2][$j] = 0;
		}

		$funca = "SELECT file FROM measurement_p WHERE scan_type=\"IV\" AND part_ID=\"".$sensorarr[0][$j]."\" AND part_type=\"assembled\" ORDER BY time_created DESC";
		$outputa = mysql_query($funca, $connection);
		if($rowa = mysql_fetch_assoc($outputa)){
			$sensorarr[3][$j] = gradeMeas($rowa['file']);
		}
		else{
			$sensorarr[3][$j] = 0;
		}

		$j++;	


	}

	for($k1=1;$k1<=3;$k1++){

		$numer = 0;
		$denom = 0;
		

		for($k2=0;$k2<$j;$k2++){
	
			if($sensorarr[$k1][$k2] > 0){
				$denom++;
			}
			if($sensorarr[$k1][$k2] == 1 || $sensorarr[$k1][$k2] == 3){
				$numer++;
			}
		}

		$waferarr[$k1+1][$i] = $numer/$denom;
		if($waferarr[$k1+1][$i] == ""){
			$waferarr[$k1+1][$i] = 0;
		}
			
	}

		$i++;
}

#echo $waferarr[2][6];

 #print_r($waferarr[2]);
 #echo $waferarr[2][0];

$graphname = "Wafer Yield";

$graph=new Graph(1340,800);
$graph->SetScale("textlin", 0, 1, 0, count($waferarr[0]));
$graph->xaxis->SetTickLabels($waferarr[0]);


#$graph->xaxis->SetLabelAngle(90);

#$graph->img->SetMargin(70,80,40,40);	

#$graph->title->Set($graphname);

#$graph->title->SetFont(FF_FONT1,FS_BOLD);

#$graph->xaxis->title->Set("Time");
$graph->xaxis->scale->ticks->Set(1);

#$graph->yaxis->title->Set("");

#$graph->yaxis->title->SetMargin(30);
#$graph->SetFrame(true,'black',0);

#$graph->img->SetAntiAliasing(false);

$bplot = new BarPlot($waferarr[2]);


$bplot2 = new BarPlot($waferarr[3]);
#$bplot2->SetFillColor('blue');

$bplot3 = new BarPlot($waferarr[4]);
#$bplot3->SetFillColor('green');

$gbplot = new GroupBarPlot(array($bplot, $bplot2, $bplot3));

$graph->Add($gbplot);

$bplot->SetFillColor('blue');
$bplot2->SetFillColor('green');
$bplot3->SetFillColor('red');
#$bplot->value->Show();
#$bplot2->value->Show();
#$bplot3->value->Show();

$graph->Stroke();
?>
