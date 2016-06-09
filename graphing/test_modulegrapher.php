<?php
#include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
include('../jpgraph/src/jpgraph.php');
include('../jpgraph/src/jpgraph_date.php');
include('../jpgraph/src/jpgraph_line.php');


$connection = mysql_connect('fibonacci.physics.purdue.edu','cmsfpix_u_www','0MKshqtRV6Y');
if(!$connection){
	echo("Unable to connect to the database server at this time.");
	exit();
}
else{
	#echo "Connected";
}



$arrReceived;
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


$func0 = "SELECT a.received, a.post_tested_n20c, b.assembly, a.assoc_module, b.id FROM times_module_p a, module_p b WHERE a.assoc_module=b.id".$hide." ORDER BY a.received";
$func = "SELECT a.HDI_attached, a.post_tested_n20c, b.assembly, a.assoc_module, b.id FROM times_module_p a, module_p b WHERE a.assoc_module=b.id".$hide." ORDER BY HDI_attached";
$func2 = "SELECT a.HDI_attached, a.post_tested_n20c, b.assembly, a.assoc_module, b.id FROM times_module_p a, module_p b WHERE a.assoc_module=b.id".$hide." ORDER BY post_tested_n20c";

$output0 = mysql_query($func0, $connection);
$output = mysql_query($func, $connection);
$output2 = mysql_query($func2, $connection);

$g=0;
$h=0;
$i=0;
$j=0;
$k=0;
$l=0;

while($row0 = mysql_fetch_assoc($output0)){
	#print_r($row0);
	#echo "<br><br>";
	$modloc = curloc("module_p", $row0['assoc_module']);
	$id = $row0['id'];
	if(!is_null($row0['received']) && $loc_condition==$modloc){
		$arrReceived[0][$l] = strtotime($row0['received']);
		$arrReceived[1][$l] = $l+1;
		$l++;
	}	
}

$arrReceived[0][$l] = $date;
$arrReceived[1][$l] = $l;

while($row = mysql_fetch_assoc($output)){

	$modloc = curloc("module_p", $row['assoc_module']);
	$id = $row['id'];
	if(!is_null($row['HDI_attached']) && $loc_condition==$modloc){
		$arrAssembled[0][$g] = strtotime($row['HDI_attached']);
		$arrAssembled[1][$g] = $g+1;
		$g++;
	}	
}

$arrAssembled[0][$g] = $date;
$arrAssembled[1][$g] = $g;



while($row2 = mysql_fetch_assoc($output2)){

	$modloc = curloc("module_p", $row2['assoc_module']);
	$id = $row2['id'];
	$grade = curgrade($id);
	if(!is_null($row2['post_tested_n20c']) && $loc_condition==$modloc){
		$arrTested[0][$h] = strtotime($row2['post_tested_n20c']);
		$arrTested[1][$h] = $h+1;
		$h++;
	}
	if(!is_null($row2['post_tested_n20c']) && $grade=="A" && $loc_condition==$modloc){
		$arr1[0][$i] = strtotime($row2['post_tested_n20c']);
		$arr1[1][$i] = $i+1;
		$i++;
	}
	
	if(!is_null($row2['post_tested_n20c']) && $grade=="B" && $loc_condition==$modloc){
		$arr2[0][$j] = strtotime($row2['post_tested_n20c']);
		$arr2[1][$j] = $j+1;
		$j++;
	}
	
	if(!is_null($row2['post_tested_n20c']) && $grade=="C" && $loc_condition==$modloc){
		$arr3[0][$k] = strtotime($row2['post_tested_n20c']);
		$arr3[1][$k] = $k+1;
		$k++;
	}


}
$arrTested[0][$h] = $date;
$arrTested[1][$h] = $h;

$arr1[0][$i] = $date;
$arr1[1][$i] = $i;

$arr2[0][$j] = $date;
$arr2[1][$j] = $j;

$arr3[0][$k] = $date;
$arr3[1][$k] = $k;

#print_r($arrReceived);
#print_r($arrTested);

$graphname = "Module Grades over Time";

$graph=new Graph(1340,800);
$graph->SetScale("datlin");
$graph->SetFrame(true,'black',0);

$graph->title->SetFont(FF_FONT2,FS_BOLD);
$graph->title->Set($graphname);

$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->title->Set("Time");
$graph->xaxis->title->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->scale->ticks->Set(7*24*60*60);
$graph->xaxis->title->SetMargin(85);

$graph->yaxis->SetFont(FF_FONT2,FS_BOLD);
$graph->yaxis->title->Set("Number of Modules");
$graph->yaxis->title->SetFont(FF_FONT2,FS_BOLD);
$graph->yaxis->title->SetMargin(20);

$graph->legend->SetPos(.1, .1, 'left','top');
$graph->legend->SetFont(FF_FONT2,FS_BOLD);

$graph->img->SetAntiAliasing(false);
$graph->img->SetMargin(70,80,40,40);	

$spR = new LinePlot($arrReceived[1],$arrReceived[0]);
#$spA->SetFillColor('purple@0.5');
$graph->Add($spR);
$spR->SetColor('black');
$spR->SetWeight(7);
$spR->SetStyle("solid");
$spR->SetStepStyle();
$spR->SetLegend("Received");

$spA = new LinePlot($arrAssembled[1],$arrAssembled[0]);
#$spA->SetFillColor('purple@0.5');
$graph->Add($spA);
$spA->SetColor('purple');
$spA->SetWeight(7);
$spA->SetStyle("solid");
$spA->SetStepStyle();
$spA->SetLegend("Assembled");

$spT = new LinePlot($arrTested[1],$arrTested[0]);
#$spT->SetFillColor('yellow@0.5');
$graph->Add($spT);
$spT->SetColor('blue');
$spT->SetWeight(7);
$spT->SetStyle("solid");
$spT->SetStepStyle();
$spT->SetLegend("Tested");

$sp3 = new LinePlot($arr3[1],$arr3[0]);
$graph->Add($sp3);
$sp3->SetColor('red');
$sp3->SetWeight(7);
$sp3->SetStyle("solid");
$sp3->SetStepStyle();

$sp2 = new LinePlot($arr2[1],$arr2[0]);
$graph->Add($sp2);
$sp2->SetColor('orange');
$sp2->SetWeight(7);
$sp2->SetStyle("solid");
$sp2->SetStepStyle();


$sp1 = new LinePlot($arr1[1],$arr1[0]);
$graph->Add($sp1);
$sp1->SetColor('green');
$sp1->SetWeight(7);
$sp1->SetStyle("solid");
$sp1->SetStepStyle();

$sp1->SetLegend("Grade A");
$sp2->SetLegend("Grade B");
$sp3->SetLegend("Grade C");
$graph->legend->SetReverse();

$graph->legend->SetLineWeight(10);
$graph->Stroke();

?>
