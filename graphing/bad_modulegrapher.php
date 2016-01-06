<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
include('../graphing/xmlgrapher_crit.php');
include('../jpgraph/src/jpgraph.php');
include('../jpgraph/src/jpgraph_date.php');
include('../jpgraph/src/jpgraph_line.php');

#ini_set('display_errors','On');
#error_reporting(E_ALL | E_STRICT);

$arrAssembled;
$arrTested;
$arr1;
$arr2;
$arr3;
$arr4;

mysql_query("USE cmsfpix_u", $connection);

$date = time();

$hide="";
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

$func = "SELECT a.HDI_attached, a.post_tested_n20c, a.assoc_module, b.id, b.assoc_sens FROM times_module_p a, module_p b WHERE a.assoc_module=b.id".$hide." ORDER BY HDI_attached";
$func2 = "SELECT a.HDI_attached, a.post_tested_n20c, a.assoc_module, b.id FROM times_module_p a, module_p b WHERE a.assoc_module=b.id".$hide." ORDER BY post_tested_n20c";

$output = mysql_query($func, $connection);
$output2 = mysql_query($func2, $connection);

$g=0;
$h=0;
$i=0;
$j=0;
$k=0;
$l=0;
while($row = mysql_fetch_assoc($output)){

	$modloc = curloc("module_p", $row['assoc_module']);
	$id = $row['id'];

	$totgrade = curgrade($id);
	if($totgrade == "I"){ continue;}

	if(!is_null($row['HDI_attached']) && curgrade($id)!="A" && !is_null($row['post_tested_n20c']) && $loc_condition==$modloc){
		if($g==0){
			$arrAssembled[0][$g] = strtotime($row['post_tested_n20c']);
			$arrAssembled[1][$g] = 0;
			$g++;
		}
		$arrAssembled[0][$g] = strtotime($row['post_tested_n20c']);
		$arrAssembled[1][$g] = $g;
		$g++;
	}

	$badbump = 0;
	$badpix = 0;
	$badbump_elec = 0;
	if(badpix_crit($id)>"A"){ $badpix = 1; }
	if(badbumps_crit($id)>"A"){ $badbump = 1; }
	if(badbumps_elec_crit($id)>"A"){ $badbump_elec = 1;}

	#if(!is_null($row['post_tested_n20c']) && $badbump && xmlgrapher_crit_num($row['assoc_sens'], "IV", "module",0)!=1 && $loc_condition==$modloc){
	#	if($k==0){
	#		$arr3[0][$k] = strtotime($row['post_tested_n20c']);
	#		$arr3[1][$k] = 0;
	#		$k++;
	#	}
	#	$arr3[0][$k] = strtotime($row['post_tested_n20c']);
	#	$arr3[1][$k] = $k;
	#	$k++;
	#}

	if(!is_null($row['post_tested_n20c']) && $badbump_elec && $loc_condition==$modloc){
		if($k==0){
			$arr3[0][$k] = strtotime($row['post_tested_n20c']);
			$arr3[1][$k] = 0;
			$k++;
		}
		$arr3[0][$k] = strtotime($row['post_tested_n20c']);
		$arr3[1][$k] = $k;
		$k++;
	}

	if(!is_null($row['post_tested_n20c']) && $badbump && !badbump_elec && !badpix && $loc_condition==$modloc){
		if($i==0){
			$arr1[0][$i] = strtotime($row['post_tested_n20c']);
			$arr1[1][$i] = 0;
			$i++;
		}
		$arr1[0][$i] = strtotime($row['post_tested_n20c']);
		$arr1[1][$i] = $i;
		$i++;
	}

	if(!is_null($row['post_tested_n20c']) && $badpix && $loc_condition==$modloc){
		if($l==0){
			$arr4[0][$l] = strtotime($row['post_tested_n20c']);
			$arr4[1][$l] = 0;
			$l++;
		}
		$arr4[0][$l] = strtotime($row['post_tested_n20c']);
		$arr4[1][$l] = $l;
		$l++;
	}
	
	if(!is_null($row['post_tested_n20c']) && xmlgrapher_crit_num($row['assoc_sens'], "IV", "module",0)!=1 && $loc_condition==$modloc){
		if($j==0){
			$arr2[0][$j] = strtotime($row['post_tested_n20c']);
			$arr2[1][$j] = 0;
			$j++;
		}
		$arr2[0][$j] = strtotime($row['post_tested_n20c']);
		$arr2[1][$j] = $j;
		$j++;
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

$arr4[0][$l] = $date;
$arr4[1][$l] = $l;

$graphname = "Module Defects over Time";

$graph=new Graph(1340,800);
$graph->SetScale("datlin");
$graph->SetFrame(true,'black',0);

$graph->title->Set($graphname);
$graph->title->SetFont(FF_FONT2,FS_BOLD);

$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->title->Set("Time");
$graph->xaxis->scale->ticks->Set(7*24*60*60);
$graph->xaxis->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT2,FS_BOLD);

$graph->yaxis->title->SetMargin(30);
$graph->yaxis->scale->SetAutoMin(0);
$graph->yaxis->SetFont(FF_FONT2,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT2,FS_BOLD);

$graph->legend->SetPos(.08,.08,'left','top');
$graph->legend->SetFont(FF_FONT2,FS_BOLD);

$graph->img->SetMargin(70,80,40,40);	
$graph->img->SetAntiAliasing(false);

$spA = new LinePlot($arrAssembled[1],$arrAssembled[0]);
$sp1 = new LinePlot($arr1[1],$arr1[0]);
$sp2 = new LinePlot($arr2[1],$arr2[0]);
$sp3 = new LinePlot($arr3[1],$arr3[0]);
$sp4 = new LinePlot($arr4[1],$arr4[0]);

$graph->Add($spA);

$graph->Add($sp2);
$graph->Add($sp1);
$graph->Add($sp3);
$graph->Add($sp4);


#$spA->SetFillColor('black@0.5');
$spA->SetColor('black');
$spA->SetWeight(7);
$spA->SetStyle("solid");
$spA->SetStepStyle();
$spA->SetLegend("Defective Modules");

#$sp1->SetFillColor('lightblue@0.5');
$sp1->SetColor('purple@0.5');
$sp1->SetWeight(7);
$sp1->SetStyle("solid");
$sp1->SetStepStyle();
$sp1->SetLegend("Bad Pixels+Bumps");

#$sp2->SetFillColor('lightred@0.5');
$sp2->SetColor('red@0.5');
$sp2->SetWeight(7);
$sp2->SetStyle("solid");
$sp2->SetStepStyle();
$sp2->SetLegend("Bad IV");

#$sp3->SetFillColor('lightgreen@0.5');
$sp3->SetColor('blue@0.5');
$sp3->SetWeight(7);
$sp3->SetStyle("solid");
$sp3->SetStepStyle();
$sp3->SetLegend("Bad Bumps");

#$sp4->SetFillColor('lightgreen@0.5');
$sp4->SetColor('green@0.5');
$sp4->SetWeight(7);
$sp4->SetStyle("solid");
$sp4->SetStepStyle();
$sp4->SetLegend("Bad Pixels");

$graph->legend->SetLineWeight(10);
$graph->Stroke();

?>
