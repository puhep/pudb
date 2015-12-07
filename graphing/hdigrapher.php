<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
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

$loc = $_GET['loc'];
$loc_condition=TRUE;
if($loc == "purdue"){
	$loc_condition = "Purdue";
}
if($loc == "nebraska"){
	$loc_condition = "Nebraska";
}


mysql_query("USE cmsfpix_u", $connection);

$func1 = "SELECT UNIX_TIMESTAMP(received), assoc_hdi FROM times_HDI_p".$hide." ORDER BY received";
$func2 = "SELECT UNIX_TIMESTAMP(on_module), assoc_hdi FROM times_HDI_p".$hide." ORDER BY on_module";

$output1 = mysql_query($func1, $connection);
$output2 = mysql_query($func2, $connection);

$i=0;
while($row1 = mysql_fetch_assoc($output1)){

	$hdiloc = curloc("HDI_p", $row1['assoc_hdi']);

	#if(!is_null($row1['UNIX_TIMESTAMP(received)'])){
	if(!is_null($row1['UNIX_TIMESTAMP(received)']) && $loc_condition==$hdiloc){
		$arr1[0][$i] = $row1['UNIX_TIMESTAMP(received)'];
		$arr1[1][$i] = $i+1;
		$i++;
	}
}
$arr1[0][$i] = $date;
$arr1[1][$i] = $i;


$j=0;
while($row2 = mysql_fetch_assoc($output2)){

	$hdiloc = curloc("HDI_p", $row2['assoc_hdi']);

	if(!is_null($row2['UNIX_TIMESTAMP(on_module)']) && $loc_condition==$hdiloc){
		$arr2[0][$j] = $row2['UNIX_TIMESTAMP(on_module)'];
		$arr2[1][$j] = $j+1;
		$j++;
	}
}
$arr2[0][$j] = $date;
$arr2[1][$j] = $j;

$graphname = "HDI Assembly over Time";


$graph=new Graph(1340,800);
$graph->SetScale("datlin");
$graph->SetFrame(true,'black',0);

$graph->title->Set($graphname);
$graph->title->SetFont(FF_FONT2,FS_BOLD);

$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->title->Set("Time");
$graph->xaxis->title->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->scale->ticks->Set(30*24*60*60);
$graph->xaxis->SetFont(FF_FONT2,FS_BOLD);

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
$sp1->SetWeight(7);
#$sp1->SetStyle("solid");
$sp1->SetStepStyle();
$sp1->SetLegend("Received");

$sp2 = new LinePlot($arr2[1],$arr2[0]);
#$sp2->SetFillColor('red@0.5');
$graph->Add($sp2);
$sp2->SetWeight(7);
#$sp2->SetStyle("solid");
$sp2->SetStepStyle();
$sp2->SetLegend("On Module");

$graph->Stroke();

?>
