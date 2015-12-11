<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
require_once('../jpgraph/src/jpgraph.php');
require_once('../jpgraph/src/jpgraph_date.php');
require_once('../jpgraph/src/jpgraph_line.php');

$arr1;
$arr2;
$arr3;

mysql_query("USE cmsfpix_u", $connection);

$date = time();

$hide= "";
if($_SESSION['hidepre']){
	#$hide = " WHERE received > \"2015-09-01\"";
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

#Stress test functions
#$func1 = "SELECT UNIX_TIMESTAMP(a.post_tested_17c), a.assoc_module FROM times_module_p a, module_p b WHERE a.assoc_module=b.id AND (b.name NOT LIKE \"%95%\" AND b.name NOT LIKE \"%96%\" AND b.name NOT LIKE \"%97%\")".$hide." ORDER BY post_tested_17c";
#$func2 = "SELECT UNIX_TIMESTAMP(a.post_tested_n20c), a.assoc_module FROM times_module_p a, module_p b WHERE a.assoc_module=b.id AND (b.name NOT LIKE \"%95%\" AND b.name NOT LIKE \"%96%\" AND b.name NOT LIKE \"%97%\")".$hide." ORDER BY post_tested_n20c";
#$func3 = "SELECT UNIX_TIMESTAMP(a.post_tested_xray), a.assoc_module FROM times_module_p a, module_p b WHERE a.assoc_module=b.id AND (b.name NOT LIKE \"%95%\" AND b.name NOT LIKE \"%96%\" AND b.name NOT LIKE \"%97%\")".$hide." ORDER BY a.post_tested_xray";

$func1 = "SELECT UNIX_TIMESTAMP(a.post_tested_17c), a.assoc_module FROM times_module_p a, module_p b WHERE a.assoc_module=b.id".$hide." ORDER BY post_tested_17c";
$func2 = "SELECT UNIX_TIMESTAMP(a.post_tested_n20c), a.assoc_module FROM times_module_p a, module_p b WHERE a.assoc_module=b.id".$hide." ORDER BY post_tested_n20c";
$func3 = "SELECT UNIX_TIMESTAMP(a.post_tested_xray), a.assoc_module FROM times_module_p a, module_p b WHERE a.assoc_module=b.id".$hide." ORDER BY a.post_tested_xray";
#Old functions. We might want to re-use them after the stress test
#$func1 = "SELECT UNIX_TIMESTAMP(post_tested_17c), assoc_module FROM times_module_p".$hide." ORDER BY post_tested_17c";
#$func2 = "SELECT UNIX_TIMESTAMP(post_tested_n20c), assoc_module FROM times_module_p".$hide." ORDER BY post_tested_n20c";
#$func3 = "SELECT UNIX_TIMESTAMP(post_tested_xray), assoc_module FROM times_module_p".$hide." ORDER BY post_tested_xray";

$output1 = mysql_query($func1, $connection);
$output2 = mysql_query($func2, $connection);
$output3 = mysql_query($func3, $connection);

$i=0;
while($row1 = mysql_fetch_assoc($output1)){

	$modloc = curloc("module_p", $row1['assoc_module']);

	if(!is_null($row1['UNIX_TIMESTAMP(a.post_tested_17c)']) && $loc_condition==$modloc){
		$arr1[0][$i] = $row1['UNIX_TIMESTAMP(a.post_tested_17c)'];
		$arr1[1][$i] = $i+1;
		$i++;
	}
}
$arr1[0][$i] = $date;
$arr1[1][$i] = $i;


$j=0;
while($row2 = mysql_fetch_assoc($output2)){

	$modloc = curloc("module_p", $row2['assoc_module']);

	if(!is_null($row2['UNIX_TIMESTAMP(a.post_tested_n20c)']) && $loc_condition==$modloc){
		$arr2[0][$j] = $row2['UNIX_TIMESTAMP(a.post_tested_n20c)'];
		$arr2[1][$j] = $j+1;
		$j++;
	}
}
$arr2[0][$j] = $date;
$arr2[1][$j] = $j;


$k=0;
while($row3 = mysql_fetch_assoc($output3)){

	$modloc = curloc("module_p", $row3['assoc_module']);

	if(!is_null($row3['UNIX_TIMESTAMP(a.post_tested_xray)']) && $loc_condition==$modloc){
		$arr3[0][$k] = $row3['UNIX_TIMESTAMP(a.post_tested_xray)'];
		$arr3[1][$k] = $k+1;
		$k++;
	}
}
$arr3[0][$k] = $date;
$arr3[1][$k] = $k;




$graphname = "Post-Assembly Testing over Time";


$graph=new Graph(1340,800);
$graph->SetScale("datlin");
$graph->SetFrame(true,'black',0);

$graph->title->Set($graphname);
$graph->title->SetFont(FF_FONT2,FS_BOLD);

$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->title->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->title->Set("Time");
$graph->xaxis->SetFont(FF_FONT2, FS_BOLD);
#$graph->xaxis->scale->ticks->Set(30*24*60*60);

#$graph->yaxis->title->Set("");
$graph->yaxis->SetFont(FF_FONT2, FS_BOLD);
$graph->yaxis->title->SetMargin(30);

$graph->img->SetAntiAliasing(false);
$graph->img->SetMargin(70,80,40,40);	

$graph->legend->SetPos(.1, .1, 'left','top');
$graph->legend->SetFont(FF_FONT2,FS_BOLD);

$sp1 = new LinePlot($arr1[1],$arr1[0]);
$sp1->SetFillColor('lightblue@0.5');
$graph->Add($sp1);
$sp1->SetWeight(7);
$sp1->SetStyle("solid");
$sp1->SetStepStyle();
$sp1->SetLegend("Tested at 17C");

$sp2 = new LinePlot($arr2[1],$arr2[0]);
$sp2->SetFillColor('lightred@0.5');
$graph->Add($sp2);
$sp2->SetWeight(7);
$sp2->SetStyle("solid");
$sp2->SetStepStyle();
$sp2->SetLegend("Tested at -20C");

$sp3 = new LinePlot($arr3[1],$arr3[0]);
$sp3->SetFillColor('lightgreen@0.5');
$graph->Add($sp3);
$sp3->SetWeight(7);
$sp3->SetStyle("solid");
$sp3->SetStepStyle();
$sp3->SetLegend("X Ray Tested");

$graph->Stroke();

?>
