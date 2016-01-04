<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
require_once('../jpgraph/src/jpgraph.php');
require_once('../jpgraph/src/jpgraph_date.php');
require_once('../jpgraph/src/jpgraph_line.php');

ini_set('display_errors','On');
error_reporting(E_ALL | E_STRICT);

$arr1;
$arr2;
$arr3;
$arr4;

mysql_query("USE cmsfpix_u", $connection);

$date = time();

$hide = "";
#if(!$_SESSION['hidepre']){
	$hide = " AND received > \"2015-09-01 \"";
#}


#$loc = $_GET['loc'];
#$loc_condition=TRUE;
#if($loc == "purdue"){
#	$loc_condition = "Purdue";
#}
#if($loc == "nebraska"){
#	$loc_condition = "Nebraska";
#}

$func1 =  "SELECT UNIX_TIMESTAMP(post_tested_17c), assoc_module FROM times_module_p WHERE UNIX_TIMESTAMP(post_tested_17c) IS NOT NULL AND UNIX_TIMESTAMP(post_tested_17c) != 0".$hide." ORDER BY UNIX_TIMESTAMP(post_tested_17c)";
$func2 =  "SELECT UNIX_TIMESTAMP(post_tested_n20c), assoc_module FROM times_module_p WHERE UNIX_TIMESTAMP(post_tested_n20c) IS NOT NULL AND UNIX_TIMESTAMP(post_tested_n20c) != 0".$hide." ORDER BY UNIX_TIMESTAMP(post_tested_n20c)";
$func3 =  "SELECT UNIX_TIMESTAMP(post_tested_xray), assoc_module FROM times_module_p WHERE UNIX_TIMESTAMP(post_tested_xray) IS NOT NULL AND UNIX_TIMESTAMP(post_tested_xray) != 0".$hide." ORDER BY UNIX_TIMESTAMP(post_tested_xray)";
$func4 =  "SELECT UNIX_TIMESTAMP(post_tested_thermal_cycle), assoc_module FROM times_module_p WHERE UNIX_TIMESTAMP(post_tested_thermal_cycle) IS NOT NULL AND UNIX_TIMESTAMP(post_tested_thermal_cycle) != 0".$hide." ORDER BY UNIX_TIMESTAMP(post_tested_thermal_cycle)";

$output1 = mysql_query($func1, $connection);
$output2 = mysql_query($func2, $connection);
$output3 = mysql_query($func3, $connection);
$output4 = mysql_query($func4, $connection);

$i=0;
while($row1 = mysql_fetch_assoc($output1)){

	#$modloc = curloc("module_p", $row1['assoc_module']);

	#if(!is_null($row1['UNIX_TIMESTAMP(a.post_tested_17c)']) && $loc_condition==$modloc){
		$arr1[0][$i] = $row1['UNIX_TIMESTAMP(post_tested_17c)'];
		$arr1[1][$i] = $i+1;
		$i++;
	#}
}
$arr1[0][$i] = $date;
$arr1[1][$i] = $i;


$j=0;
while($row2 = mysql_fetch_assoc($output2)){

	#$modloc = curloc("module_p", $row2['assoc_module']);

	#if(!is_null($row2['UNIX_TIMESTAMP(a.post_tested_n20c)']) && $loc_condition==$modloc){
		$arr2[0][$j] = $row2['UNIX_TIMESTAMP(post_tested_n20c)'];
		$arr2[1][$j] = $j+1;
		$j++;
	#}
}
$arr2[0][$j] = $date;
$arr2[1][$j] = $j;


$k=0;
while($row3 = mysql_fetch_assoc($output3)){

	#$modloc = curloc("module_p", $row3['assoc_module']);

	#if(!is_null($row3['UNIX_TIMESTAMP(a.post_tested_xray)']) && $loc_condition==$modloc){
		$arr3[0][$k] = $row3['UNIX_TIMESTAMP(post_tested_xray)'];
		$arr3[1][$k] = $k+1;
		$k++;
	#}
}
$arr3[0][$k] = $date;
$arr3[1][$k] = $k;

$l=0;
while($row4 = mysql_fetch_assoc($output4)){

	#$modloc = curloc("module_p", $row4['assoc_module']);

	#if(!is_null($row4['UNIX_TIMESTAMP(a.post_tested_thermal_cycle)']) && $loc_condition==$modloc){
		$arr4[0][$l] = $row4['UNIX_TIMESTAMP(post_tested_thermal_cycle)'];
		$arr4[1][$l] = $l+1;
		$l++;
	#}
}
$arr4[0][$l] = $date;
$arr4[1][$l] = $l;


$graphname = "Post-Assembly Testing over Time";


$graph=new Graph(1340,800);
$graph->SetScale("datint");
$graph->SetFrame(true,'black',0);

$graph->title->Set($graphname);
$graph->title->SetFont(FF_FONT2,FS_BOLD);

$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->title->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->title->Set("Time");
$graph->xaxis->SetFont(FF_FONT2, FS_BOLD);
$graph->xaxis->scale->ticks->Set(1*24*60*60);

#$graph->yaxis->title->Set("");
$graph->yaxis->SetFont(FF_FONT2, FS_BOLD);
$graph->yaxis->title->SetMargin(30);
$graph->yaxis->scale->SetAutoMin(0);

$graph->img->SetAntiAliasing(false);
$graph->img->SetMargin(70,80,40,40);	

$graph->legend->SetPos(.1, .1, 'left','top');
$graph->legend->SetFont(FF_FONT2,FS_BOLD);

$sp1 = new LinePlot($arr1[1],$arr1[0]);
$graph->Add($sp1);
$sp1->SetColor('blue@0.5');
$sp1->SetWeight(7);
$sp1->SetStyle("solid");
$sp1->SetStepStyle();
$sp1->SetLegend("Tested at 17C");

$sp2 = new LinePlot($arr2[1],$arr2[0]);
$graph->Add($sp2);
$sp2->SetColor('red@0.5');
$sp2->SetWeight(7);
$sp2->SetStyle("solid");
$sp2->SetStepStyle();
$sp2->SetLegend("Tested at -20C");

$sp3 = new LinePlot($arr3[1],$arr3[0]);
$graph->Add($sp3);
$sp3->SetColor('green@0.5');
$sp3->SetWeight(7);
$sp3->SetStyle("solid");
$sp3->SetStepStyle();
$sp3->SetLegend("X Ray Tested");

$sp4 = new LinePlot($arr4[1],$arr4[0]);
$graph->Add($sp4);
$sp4->SetColor('orange@0.5');
$sp4->SetWeight(7);
$sp4->SetStyle("solid");
$sp4->SetStepStyle();
$sp4->SetLegend("Thermal Cycled");

$graph->legend->SetLineWeight(12);
$graph->Stroke();

?>
