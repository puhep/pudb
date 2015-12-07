<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../jpgraph/src/jpgraph.php');
include('../jpgraph/src/jpgraph_date.php');
include('../jpgraph/src/jpgraph_line.php');

$arr1;
$arr2;
$arr3;

$date = time();

$hide = "";
if(!$_SESSION['hidepre']){
	$hide = " WHERE received > \"2015-09-01\"";
}

mysql_query("USE cmsfpix_u", $connection);

$func = "SELECT UNIX_TIMESTAMP(received) FROM times_wafer_p".$hide." ORDER BY received";

$output = mysql_query($func, $connection);

$i=0;
while($row = mysql_fetch_assoc($output)){

	$arr1[0][$i] = (int)$row['UNIX_TIMESTAMP(received)'];
	$arr1[1][$i] = $i+1;
	$i++;
}
$arr1[0][$i] = $date;
$arr1[1][$i] = $i;


$graphname = "Wafer Assembly over Time";


$graph=new Graph(1340,800);
$graph->SetScale("datlin");
$graph->SetFrame(true,'black',0);

$graph->title->Set($graphname);
$graph->title->SetFont(FF_FONT2,FS_BOLD);

$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->title->Set("Time");
$graph->xaxis->title->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->scale->ticks->Set(30*24*60*60);

#$graph->yaxis->title->Set("");
$graph->yaxis->title->SetMargin(30);
$graph->yaxis->SetFont(FF_FONT2,FS_BOLD);

$graph->legend->SetPos(.1,.1,'left','top');
$graph->legend->SetFont(FF_FONT2,FS_BOLD);

$graph->img->SetMargin(70,80,40,40);	
$graph->img->SetAntiAliasing(false);

$sp1 = new LinePlot($arr1[1],$arr1[0]);
#$sp1->SetFillColor('lightblue@0.5');
$graph->Add($sp1);
$sp1->SetStepStyle();
$sp1->SetWeight(7);
$sp1->SetStyle("solid");
$sp1->SetLegend("Received");

$graph->Stroke();

?>
