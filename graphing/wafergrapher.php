<?php
include('../../../Submission_p_secure_pages/connect.php');
require_once('../jpgraph/src/jpgraph.php');
require_once('../jpgraph/src/jpgraph_date.php');
require_once('../jpgraph/src/jpgraph_line.php');

$arr1;
$arr2;
$arr3;

$date = time();

mysql_query("USE cmsfpix_u", $connection);

$func = "SELECT UNIX_TIMESTAMP(received) FROM times_wafer_p ORDER BY received";

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

$graph->xaxis->SetLabelAngle(90);

$graph->img->SetMargin(70,80,40,40);	

$graph->title->Set($graphname);

$graph->title->SetFont(FF_FONT1,FS_BOLD);

$graph->xaxis->title->Set("Time");

#$graph->yaxis->title->Set("");

$graph->yaxis->title->SetMargin(30);
$graph->SetFrame(true,'black',0);

$graph ->img->SetAntiAliasing(false);

$sp1 = new LinePlot($arr1[1],$arr1[0]);
#$sp1->SetFillColor('lightblue@0.5');
$graph->Add($sp1);
$sp1->SetStepStyle();
$sp1->SetWeight(7);
$sp1->SetStyle("solid");
$sp1->SetLegend("Received");

$graph->Stroke();

?>
