<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
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
if(!$_SESSION['hidepre']){
	$hide = " AND received > \"2015-09-01\"";
}

$loc = $_GET['loc'];
$loc_condition=TRUE;
if($loc == "purdue"){
	$loc_condition = "Purdue";
}
if($loc == "nebraska"){
	$loc_condition = "Nebraska";
}

$func = "SELECT a.HDI_attached, a.tested2, a.assoc_module, b.id FROM times_module_p a, module_p b WHERE a.assoc_module=b.id".$hide." ORDER BY HDI_attached";
$func2 = "SELECT a.HDI_attached, a.tested2, a.assoc_module, b.id FROM times_module_p a, module_p b WHERE a.assoc_module=b.id".$hide." ORDER BY tested2";

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

	if(!is_null($row['HDI_attached']) && $loc_condition==$modloc){
		$arrAssembled[0][$g] = strtotime($row['HDI_attached']);
		$arrAssembled[1][$g] = $g+1;
		$g++;
	}
	
	if(!is_null($row['HDI_attached']) && curgrade($id)=="A" && $loc_condition==$modloc){
		$arr1[0][$i] = strtotime($row['HDI_attached']);
		$arr1[1][$i] = $i+1;
		$i++;
	}
	
	if(!is_null($row['HDI_attached']) && curgrade($id)=="B" && $loc_condition==$modloc){
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

while($row2 = mysql_fetch_assoc($output2)){

	$modloc = curloc("module_p", $row2['assoc_module']);

	if(!is_null($row2['tested2']) && $loc_condition==$modloc){
		$arrTested[0][$h] = strtotime($row2['tested2']);
		$arrTested[1][$h] = $h+1;
		$h++;
	}
}
$arrTested[0][$h] = $date;
$arrTested[1][$h] = $h;


$graphname = "Module Grade over Time";

$graph=new Graph(1340,800);
$graph->SetScale("datlin");
$graph->SetFrame(true,'black',0);

$graph->title->SetFont(FF_FONT2,FS_BOLD);
$graph->title->Set($graphname);

$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->title->Set("Time");
$graph->xaxis->title->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->scale->ticks->Set(30*24*60*60);

$graph->yaxis->title->SetMargin(30);
$graph->yaxis->SetFont(FF_FONT2,FS_BOLD);

$graph->legend->SetPos(.1, .1, 'left','top');
$graph->legend->SetFont(FF_FONT2,FS_BOLD);

$graph->img->SetAntiAliasing(false);
$graph->img->SetMargin(70,80,40,40);	

$spA = new LinePlot($arrAssembled[1],$arrAssembled[0]);
#$spA->SetFillColor('purple@0.5');
$graph->Add($spA);
$spA->SetColor('blue@0.5');
$spA->SetWeight(7);
$spA->SetStyle("solid");
$spA->SetStepStyle();
$spA->SetLegend("Assembled");

$spT = new LinePlot($arrTested[1],$arrTested[0]);
#$spT->SetFillColor('yellow@0.5');
$graph->Add($spT);
$spT->SetColor('green@0.5');
$spT->SetWeight(7);
$spT->SetStyle("solid");
$spT->SetStepStyle();
$spT->SetLegend("Tested");

$sp1 = new LinePlot($arr1[1],$arr1[0]);
#$sp1->SetFillColor('lightblue@0.5');
$graph->Add($sp1);
$sp1->SetColor('red@0.5');
$sp1->SetWeight(7);
$sp1->SetStyle("solid");
$sp1->SetStepStyle();
$sp1->SetLegend("Grade A");

$sp2 = new LinePlot($arr2[1],$arr2[0]);
#$sp2->SetFillColor('lightred@0.5');
$graph->Add($sp2);
$sp2->SetColor('purple@0.5');
$sp2->SetWeight(7);
$sp2->SetStyle("solid");
$sp2->SetStepStyle();
$sp2->SetLegend("Grade B");

$sp3 = new LinePlot($arr3[1],$arr3[0]);
#$sp3->SetFillColor('lightgreen@0.5');
$graph->Add($sp3);
$sp3->SetColor('deeppink@0.5');
$sp3->SetWeight(7);
$sp3->SetStyle("solid");
$sp3->SetStepStyle();
$sp3->SetLegend("Grade C");

$graph->Stroke();

?>
