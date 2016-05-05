<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
require_once('../jpgraph/src/jpgraph.php');
require_once('../jpgraph/src/jpgraph_date.php');
require_once('../jpgraph/src/jpgraph_line.php');
require_once('../jpgraph/src/jpgraph_log.php');
require_once('../jpgraph/src/jpgraph_plotline.php');

#ini_set('display_errors','On');
#error_reporting(E_ALL | E_STRICT);

$arr1;
$arr2;
$arr3;
$arr4;
$arr_install;
$arr_spare;

mysql_query("USE cmsfpix_u", $connection);

$date = time();

$hide= "";
if(!$_SESSION['hidepre']){
	#$hide = " WHERE received > \"2015-09-01\"";
	$hide = " AND received > \"2015-09-01\"";
	$day = 31;
}
else{$day=30;}

$loc = $_GET['loc'];
$loc_condition=TRUE;
if($loc == "purdue"){
	$loc_condition = "Purdue";
}
if($loc == "nebraska"){
	$loc_condition = "Nebraska";
}

#Stress test functions
$func1 = "SELECT UNIX_TIMESTAMP(a.received), a.assoc_module FROM times_module_p a, module_p b WHERE a.assoc_module=b.id AND (b.name NOT LIKE \"%95%\" AND b.name NOT LIKE \"%96%\" AND b.name NOT LIKE \"%97%\")".$hide." ORDER BY received";
$func2 = "SELECT UNIX_TIMESTAMP(a.post_tested_n20c), a.assoc_module FROM times_module_p a, module_p b WHERE a.assoc_module=b.id AND (b.name NOT LIKE \"%95%\" AND b.name NOT LIKE \"%96%\" AND b.name NOT LIKE \"%97%\") AND post_tested_17c IS NOT NULL AND post_tested_thermal_cycle IS NOT NULL".$hide." ORDER BY post_tested_n20c";
$func3 = "SELECT UNIX_TIMESTAMP(a.shipped), a.assoc_module FROM times_module_p a, module_p b WHERE a.assoc_module=b.id AND (b.name NOT LIKE \"%95%\" AND b.name NOT LIKE \"%96%\" AND b.name NOT LIKE \"%97%\")".$hide." ORDER BY a.shipped";
$func4 = "SELECT UNIX_TIMESTAMP(a.fnal_tested), a.assoc_module FROM times_module_p a, module_p b WHERE a.assoc_module=b.id AND (b.name NOT LIKE \"%95%\" AND b.name NOT LIKE \"%96%\" AND b.name NOT LIKE \"%97%\")".$hide." ORDER BY a.fnal_tested";
$func5 = "SELECT UNIX_TIMESTAMP(a.on_blade), a.assoc_module FROM times_module_p a, module_p b WHERE a.assoc_module=b.id AND (b.name NOT LIKE \"%95%\" AND b.name NOT LIKE \"%96%\" AND b.name NOT LIKE \"%97%\")".$hide." ORDER BY a.on_blade";
#Old functions. We might want to re-use them after the stress test
#$func1 = "SELECT UNIX_TIMESTAMP(received), assoc_module FROM times_module_p".$hide." ORDER BY received";
#$func2 = "SELECT UNIX_TIMESTAMP(HDI_attached), assoc_module FROM times_module_p".$hide." ORDER BY HDI_attached";
#$func3 = "SELECT UNIX_TIMESTAMP(shipped), assoc_module FROM times_module_p".$hide." ORDER BY shipped";

$output1 = mysql_query($func1, $connection);
$output2 = mysql_query($func2, $connection);
$output3 = mysql_query($func3, $connection);
$output4 = mysql_query($func4, $connection);
$output5 = mysql_query($func5, $connection);

$i=0;
while($row1 = mysql_fetch_assoc($output1)){

	$modloc = curloc("module_p", $row1['assoc_module']);

	if(!is_null($row1['UNIX_TIMESTAMP(a.received)']) && $loc_condition==$modloc){
		$arr1[0][$i] = $row1['UNIX_TIMESTAMP(a.received)'];
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

	if(!is_null($row3['UNIX_TIMESTAMP(a.shipped)']) && $loc_condition==$modloc){
		$arr3[0][$k] = $row3['UNIX_TIMESTAMP(a.shipped)'];
		$arr3[1][$k] = $k+1;
		$k++;
	}
}
$arr3[0][$k] = $date;
$arr3[1][$k] = $k;

$l=0;
while($row4 = mysql_fetch_assoc($output4)){

	$modloc = curloc("module_p", $row4['assoc_module']);

	if(!is_null($row4['UNIX_TIMESTAMP(a.fnal_tested)']) && $loc_condition==$modloc){
		$arr4[0][$l] = $row4['UNIX_TIMESTAMP(a.fnal_tested)'];
		$arr4[1][$l] = $l+1;
		$l++;
	}
}
$arr4[0][$l] = $date;
$arr4[1][$l] = $l;

$m=0;
while($row5 = mysql_fetch_assoc($output5)){

	$modloc = curloc("module_p", $row5['assoc_module']);

	if(!is_null($row5['UNIX_TIMESTAMP(a.on_blade)']) && $loc_condition==$modloc){
		$arr5[0][$m] = $row5['UNIX_TIMESTAMP(a.on_blade)'];
		$arr5[1][$m] = $m+1;
		$m++;
	}
}
$arr5[0][$m] = $date;
$arr5[1][$m] = $m;

$arr_install[0][0] = strtotime("2015-12-01");
$arr_install[1][0] = 672;
$arr_install[0][1] = strtotime("2016-06-30");
$arr_install[1][1] = 672;

$arr_spare[0][0] = strtotime("2015-12-01");
$arr_spare[1][0] = 940;
$arr_spare[0][1] = strtotime("2016-06-30");
$arr_spare[1][1] = 940;

$graph=new Graph(1340,800);

$plot_condition = $_GET['plot_condition'];
if($plot_condition=="log"){
	   $graph->SetScale("datlog");
	   $add = " (log)";
}
else{
	$graph->SetScale("datlin");
	$add = " (lin)";
}

$graphname = "Module Production over Time".$add;

$graph->SetFrame(true,'black',0);

$graph->title->Set($graphname);
$graph->title->SetFont(FF_FONT2,FS_BOLD);

$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->title->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->title->Set("Time");
$graph->xaxis->SetFont(FF_FONT2, FS_BOLD);
$graph->xaxis->scale->SetDateAlign( MONTHADJ_1 );
$graph->xaxis->scale->ticks->Set($day*24*60*60);

$graph->xaxis->SetLabelFormatString('Y-m',true);

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
$sp1->SetLegend("Bump-Bonded");

$sp3 = new LinePlot($arr3[1],$arr3[0]);
#$sp3->SetColor('lightgreen@0.5');
$sp3->SetFillColor('lightred@0.5');
$graph->Add($sp3);
$sp3->SetWeight(7);
$sp3->SetStyle("solid");
$sp3->SetStepStyle();
$sp3->SetLegend("Assembled");

$sp2 = new LinePlot($arr2[1],$arr2[0]);
$sp2->SetFillColor('lightgreen@0.5');
$graph->Add($sp2);
$sp2->SetWeight(7);
$sp2->SetStyle("solid");
$sp2->SetStepStyle();
$sp2->SetLegend("Qualified");

$sp4 = new LinePlot($arr4[1],$arr4[0]);
$sp4->SetColor('purple@0.5');
$sp4->SetFillColor('purple@0.5');
$graph->Add($sp4);
$sp4->SetColor('purple@0.5');
$sp4->SetWeight(7);
$sp4->SetStyle("solid");
$sp4->SetStepStyle();
$sp4->SetLegend("Detector Grade");

$sp5 = new LinePlot($arr5[1],$arr5[0]);
$sp5->SetColor('orange@0.5');
$sp5->SetFillColor('orange@0.5');
$graph->Add($sp5);
$sp5->SetColor('orange@0.5');
$sp5->SetWeight(7);
$sp5->SetStyle("solid");
$sp5->SetStepStyle();
$sp5->SetLegend("Mounted");

$spin = new LinePlot($arr_install[1],$arr_install[0]);
$graph->Add($spin);
$spin->setColor('blue');
$spin->SetWeight(3);
$spin->SetLegend("Install");

$spsp = new LinePlot($arr_spare[1],$arr_spare[0]);
$graph->Add($spsp);
$spsp->setColor('black');
$spsp->SetWeight(3);
$spsp->SetLegend("Spare");

$line = new PlotLine(VERTICAL,strtotime("2016-06-30"),"red",2); 
$graph->AddLine($line);
$line->SetLegend("End of Mounting");

$line25 = new PlotLine(HORIZONTAL,168,"blue",1);
$line25->SetLineStyle('dashed'); 
$graph->AddLine($line25);

$line75 = new PlotLine(HORIZONTAL,504,"blue",1); 
$line75->SetLineStyle('dashed');
$graph->AddLine($line75);

$line50 = new PlotLine(HORIZONTAL,336,"blue",1); 
$line50->SetLineStyle('dashed');
$graph->AddLine($line50);

$graph->Stroke();

?>
