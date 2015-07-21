<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
include('../graphing/xmlgrapher_crit.php');
include('../jpgraph/src/jpgraph.php');
include('../jpgraph/src/jpgraph_date.php');
include('../jpgraph/src/jpgraph_line.php');

$arrAssembled;
$arrTested;
$arr1;
$arr2;
$arr3;

mysql_query("USE cmsfpix_u", $connection);

$date = time();

$loc = $_GET['loc'];
$loc_condition=TRUE;
if($loc == "purdue"){
	$loc_condition = "Purdue";
}
if($loc == "nebraska"){
	$loc_condition = "Nebraska";
}

$func = "SELECT a.HDI_attached, a.tested2, a.assoc_module, b.id, b.assoc_sens FROM times_module_p a, module_p b WHERE a.assoc_module=b.id ORDER BY HDI_attached";
$func2 = "SELECT a.HDI_attached, a.tested2, a.assoc_module, b.id FROM times_module_p a, module_p b WHERE a.assoc_module=b.id ORDER BY tested2";

$output = mysql_query($func, $connection);
$output2 = mysql_query($func2, $connection);

$g=0;
$h=0;
$i=0;
$j=0;
$k=0;
while($row = mysql_fetch_assoc($output)){

	$modloc = curloc("module_p", $row['assoc_module']);
	$id = $row['id'];

	$totgrade = curgrade($id);
	if($totgrade == "I"){ continue;}

	if(!is_null($row['HDI_attached']) && curgrade($id)!="A" && $loc_condition==$modloc){
		$arrAssembled[0][$g] = strtotime($row['HDI_attached']);
		$arrAssembled[1][$g] = $g+1;
		$g++;
	}
	
	if(!is_null($row['HDI_attached']) && badbumps_crit($id)<"A" && $loc_condition==$modloc){
		$arr1[0][$i] = strtotime($row['HDI_attached']);
		$arr1[1][$i] = $i+1;
		$i++;
	}
	
	if(!is_null($row['HDI_attached']) && xmlgrapher_crit_num($row['assoc_sens'], "IV", "module",0)!=1 && $loc_condition==$modloc){
		$arr2[0][$j] = strtotime($row['HDI_attached']);
		$arr2[1][$j] = $j+1;
		$j++;
	}
	
	if(!is_null($row['HDI_attached']) && curgrade($id)=="C" && $loc_condition==$modloc){
		$arr3[0][$k] = strtotime($row['HDI_attached']);
		$arr3[1][$k] = $k+1;
		$k++;
	}
	
}

$arrAssembled[0][$g] = $date;
$arrAssembled[1][$g] = $g;

$arr1[0][$i] = $date;
$arr1[1][$i] = $i;

$arr2[0][$j] = $date;
$arr2[1][$j] = $j;

$arr3[0][$k] = $date;
$arr3[1][$k] = $k;

$graphname = "Module Assembly over Time";

$graph=new Graph(1340,800);
$graph->SetScale("datlin");

$graph->xaxis->SetLabelAngle(90);

$graph->img->SetMargin(70,80,40,40);	

$graph->title->Set($graphname);

$graph->title->SetFont(FF_FONT1,FS_BOLD);

$graph->xaxis->title->Set("Time");
$graph->xaxis->scale->ticks->Set(30*24*60*60);

#$graph->yaxis->title->Set("");

$graph->yaxis->title->SetMargin(30);
$graph->SetFrame(true,'black',0);

$graph->img->SetAntiAliasing(false);

$spA = new LinePlot($arrAssembled[1],$arrAssembled[0]);
#$spA->SetFillColor('purple@0.5');
$spA->SetColor('purple');
$graph->Add($spA);
$spA->SetWeight(7);
#$spA->SetStyle("solid");
$spA->SetStepStyle();
$spA->SetLegend("Assembled");

$sp1 = new LinePlot($arr1[1],$arr1[0]);
#$sp1->SetFillColor('lightblue@0.5');
$graph->Add($sp1);
$sp1->SetWeight(7);
$sp1->SetStyle("solid");
$sp1->SetStepStyle();
$sp1->SetLegend("Bad Bumps");

$sp2 = new LinePlot($arr2[1],$arr2[0]);
#$sp2->SetFillColor('lightred@0.5');
$graph->Add($sp2);
$sp2->SetWeight(7);
$sp2->SetStyle("solid");
$sp2->SetStepStyle();
$sp2->SetLegend("Bad IV");
/*
$sp3 = new LinePlot($arr3[1],$arr3[0]);
$sp3->SetFillColor('lightgreen@0.5');
$graph->Add($sp3);
$sp3->SetWeight(7);
$sp3->SetStyle("solid");
$sp3->SetStepStyle();
$sp3->SetLegend("Grade C");
*/
$graph->Stroke();

?>
