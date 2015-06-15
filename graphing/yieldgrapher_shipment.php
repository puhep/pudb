<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
include('../jpgraph/src/jpgraph.php');
include('../jpgraph/src/jpgraph_date.php');
include('../jpgraph/src/jpgraph_bar.php');

$waferarr;
$sensorarr;
$measarr;
$timesarr;

$mainarr;

mysql_query("USE cmsfpix_u", $connection);

$date = time();

$func1 = "SELECT assoc_module, UNIX_TIMESTAMP(received) FROM times_module_p ORDER BY received ASC";
$output1 = mysql_query($func1, $connection);

$i=0;
$j=-1;
$ship_base = 0;

while($row1 = mysql_fetch_assoc($output1)){
	
	if($row1['UNIX_TIMESTAMP(received)'] - $ship_base > 172800){
		$ship_base = $row1['UNIX_TIMESTAMP(received)'];
		$j++;
		$i=0;
		$mainarr[0][$j] = $row1['UNIX_TIMESTAMP(received)'];
	}
	
	$timesarr[$j][0][$i] = $row1['UNIX_TIMESTAMP(received)'];
	$timesarr[$j][1][$i] = $row1['assoc_module'];

	$i++;
}

#print_r($timesarr[5][1]);

for($k=0; $k<=$j; $k++){
	
	$sensorarr = array();

for($l=0; $l<count($timesarr[$k][1]); $l++){

	$func2 = "SELECT name,id FROM sensor_p WHERE module=\"".$timesarr[$k][1][$l]."\"";
	$output2 = mysql_query($func2, $connection);
	$row2 = mysql_fetch_assoc($output2);

		$sensorarr[0][$l] = $row2['id'];

		$funcw = "SELECT file FROM measurement_p WHERE scan_type=\"IV\" AND part_ID=\"".$sensorarr[0][$l]."\" AND part_type=\"wafer\" ORDER BY time_created DESC";
		$outputw = mysql_query($funcw, $connection);
		if($roww = mysql_fetch_assoc($outputw)){
			$sensorarr[1][$l] = gradeMeas($roww['file']);
		}
		else{
			$sensorarr[1][$l] = "NONE";
		}

		$funcb = "SELECT file FROM measurement_p WHERE scan_type=\"IV\" AND part_ID=\"".$sensorarr[0][$l]."\" AND part_type=\"module\" ORDER BY time_created DESC";
		$outputb = mysql_query($funcb, $connection);
		if($rowb = mysql_fetch_assoc($outputb)){
			$sensorarr[2][$l] = gradeMeas($rowb['file']);
		}
		else{
			$sensorarr[2][$l] = "NONE";
		}

		$funca = "SELECT file FROM measurement_p WHERE scan_type=\"IV\" AND part_ID=\"".$sensorarr[0][$l]."\" AND part_type=\"assembled\" ORDER BY time_created DESC";
		$outputa = mysql_query($funca, $connection);
		if($rowa = mysql_fetch_assoc($outputa)){
			$sensorarr[3][$l] = gradeMeas($rowa['file']);
		}
		else{
			$sensorarr[3][$l] = "NONE";
		}
		if($k==5){
			#echo $sensorarr[0][$l]."<br>";
		}

}


	for($k1=1;$k1<=3;$k1++){

		$passed = 0;
		$failed = 0;
		$tested = 0;
		$untested = 0;
		$total = 0;
		$numer = 0;
		$denom = 0;
		
		for($k2=0;$k2<100;$k2++){
	
			if($sensorarr[$k1][$k2] === NULL){
				break;
			}
	
			if($sensorarr[$k1][$k2] == 1 || $sensorarr[$k1][$k2] == 3){
				$numer++;
				$denom++;
			}
			if($sensorarr[$k1][$k2] == 2 || $sensorarr[$k1][$k2] == 6){
				$failed++;
				$denom++;
			}
			$total++;
		if($k==6){
		#echo $numer."   ".$failed."   ".$total."<br>";
		#echo $sensorarr[$k1][$k2]."<br>";
		}
		}
		#if($denom==0){
		if($total==0){
			$mairarr[$k1][$k] = 0;
			$mairarr[$k1+3][$k] = 0;
		}
		else{
			#$mainarr[$k1][$k] = $numer/$denom;
			$mainarr[$k1][$k] = $numer/$total;
			$mainarr[$k1+3][$k] = $failed/$total;
			#$mainarr[$k1+3][$k] = 0;
		}
	}
	

}


$graphname = "Wafer Yield";

$graph=new Graph(1340,800);
$graph->SetScale("textlin", 0, 1, 0, count($mainarr[0]));

$times = array();
foreach($mainarr[0] as $unix){
	#$times[] = date('Y-m-d H:i:s', $unix);
	$times[] = date('Y-m-d', $unix);
}
$graph->xaxis->SetTickLabels($times);


$graph->xaxis->SetLabelAngle(90);

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

$bplot = new BarPlot($mainarr[1]);
$bplot4 = new BarPlot($mainarr[4]);

$bplot2 = new BarPlot($mainarr[2]);
$bplot5 = new BarPlot($mainarr[5]);

$bplot3 = new BarPlot($mainarr[3]);
$bplot6 = new BarPlot($mainarr[6]);

#$accplot1 = new AccBarPlot(array($bplot,$bplot4));
#$accplot2 = new AccBarPlot(array($bplot2,$bplot5));
#$accplot3 = new AccBarPlot(array($bplot3,$bplot6));


#$gbplot = new GroupBarPlot(array($accplot1, $accplot2, $accplot3));
$gbplot = new GroupBarPlot(array($bplot, $bplot2, $bplot3));

$graph->Add($gbplot);

$bplot->SetFillColor("blue");
$bplot2->SetFillColor("green");
$bplot3->SetFillColor("red");
$bplot4->SetFillColor("blue@1");
$bplot5->SetFillColor("green@1");
$bplot6->SetFillColor("red@1");

$graph->Stroke();

?>
