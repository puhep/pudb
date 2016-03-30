<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
include('../jpgraph/src/jpgraph.php');
include('../jpgraph/src/jpgraph_date.php');
include('../jpgraph/src/jpgraph_line.php');
include('../jpgraph/src/jpgraph_bar.php');

#ini_set('display_errors','On');
#error_reporting(E_ALL | E_STRICT);

#$arrDates;
#$arrReceived;
#$arrAssembled;
#$arrTested;

$arr = array();
$arrFix = array();

$arrA = array();
$arrB = array();
$arrC = array();

mysql_query("USE cmsfpix_u", $connection);

#$date = time();
#if(!$_SESSION['hidepre']){
#	$hide = " AND received > \"2015-09-01\"";
#}
#
#$loc = $_GET['loc'];
#$loc_condition=TRUE;
#if($loc == "purdue"){
#	$loc_condition = "Purdue";
#}
#if($loc == "nebraska"){
#	$loc_condition = "Nebraska";
#}

$g = 0;

$func0 = "select count(received) as receive, count(shipped) as ship, count(post_tested_n20C) as tested, WEEK(DATE_SUB(received, INTERVAL 3 DAY)) as batch, DATE_FORMAT(received, \"%y-%m-%d\") as date from times_module_p where received > \"2015-09-01\" group by batch order by received";
$func1 = "select count(a.id) as num, WEEK(DATE_SUB(received, INTERVAL 3 DAY)) as batch,  date_format(received,\"%y-%m-%d\") as date from module_p a, times_module_p b where a.id=b.assoc_module and b.received>\"2015-09-01\" and a.tested_status=\"Rejected\" and b.post_tested_n20C is null group by batch order by received";

#echo $func0."<br>";
$output0 = mysql_query($func0,$connection);
$output1 = mysql_query($func1,$connection);

while($row0 = mysql_fetch_assoc($output0)){
	    $arr[0][$g] = ($row0['date']);
	    if($g==0){
	    $arr[1][$g] = $row0['receive'];
	    $arr[2][$g] = $row0['ship'];
	    $arr[3][$g] = $row0['tested'];
	    }
	    else{
	    $arr[1][$g] = $row0['receive']+$arr[1][$g-1];
	    $arr[2][$g] = $row0['ship']+$arr[2][$g-1];
	    $arr[3][$g] = $row0['tested']+$arr[3][$g-1];
	    }
	    $g++;
}

$g = 0;
### fix for modules that have been rejected without being tested
#while($row1 = mysql_fetch_assoc($output1)){
#	    $arrFix[0][$g] = $row1['date'];
#	    $arrFix[1][$g] = $row1['num'];
#	    $g++;
#}

$arrIDs = array();
for($z=0;$z<count($arr[0]);$z++){
	#echo $arr[0][$z];
	$funcIDs = "select a.id from times_module_p b, module_p a where WEEK(DATE_SUB(received, INTERVAL 3 DAY)) = WEEK(DATE_SUB(\"".$arr[0][$z]."\", INTERVAL 3 DAY)) and a.id=b.assoc_module and received>\"2015-09-01\" and assembly>11";
	#if($z==0){echo $funcIDs."<br>";}
	$outputIDs = mysql_query($funcIDs,$connection);
	$a = 0;	
	while($rowIDs = mysql_fetch_assoc($outputIDs)){
		     $arrIDs[$z][$a] = $rowIDs['id'];
		     $a++;
	}
}

for($i=0;$i<count($arrIDs)+1;$i++){
	if($i==0){
	$arrA[$i]=0;
	$arrB[$i]=0;
	$arrC[$i]=0;
	}
	else{
	$arrA[$i]=$arrA[$i-1];
	$arrB[$i]=$arrB[$i-1];
	$arrC[$i]=$arrC[$i-1];
	}
	for($j=0;$j<count($arrIDs[$i]);$j++){
		if(curgrade($arrIDs[$i][$j]) == "A"){
			$arrA[$i]++;
		}
		if(curgrade($arrIDs[$i][$j]) == "B"){
			$arrB[$i]++;	
		}
		if(curgrade($arrIDs[$i][$j]) == "C"){
			$arrC[$i]++;	
		}
		
	}
}
#$arrA[$i+1]=$arrA[$i];
#$arrB[$i+1]=$arrB[$i];
#$arrC[$i+1]=$arrC[$i];

#echo $arr[0][0]."<br>";
#print_r($arrIDs[0]);
#echo "<br>";
#echo count($arrIDs[0])."<br>";
#print_r($arr[0]);
#echo "<br>";
#echo count($arr[0])."<br>";
#print_r($arrFix[0]);
#echo "<br>";
#echo count($arrFix[0]);

$graph = new Graph(1340,800);
$graph->SetScale('textlin');

$graph->SetScale('textlin');
$graph->SetFrame(true,'black',0);

$graph->title->SetFont(FF_FONT2,FS_BOLD);

$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->title->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->title->Set("Time");
$graph->xaxis->title->SetMargin(60);
$graph->xaxis->SetFont(FF_FONT2, FS_BOLD);
#$graph->xaxis->scale->ticks->Set(7*24*60*60);
$graph->xaxis->SetTickLabels($arr[0]);

$graph->yaxis->SetFont(FF_FONT2, FS_BOLD);
$graph->yaxis->title->SetMargin(20);
$graph->yaxis->scale->SetAutoMin(0);

$graph->yaxis->title->SetFont(FF_FONT2,FS_BOLD);
$graph->legend->SetLineWeight(12);

$graph->img->SetAntiAliasing(false);
$graph->img->SetMargin(70,80,40,40);	

$graph->legend->SetPos(.1, .1, 'left','top');
$graph->legend->SetFont(FF_FONT2,FS_BOLD);
 
#// Create a bar pot
$b1plot = new LinePlot($arr[1]);
$b2plot = new LinePlot($arr[2]);
$b3plot = new LinePlot($arr[3]);

$Aplot = new LinePlot($arrA);
$Bplot = new LinePlot($arrB);
$Cplot = new LinePlot($arrC);

#$Aplot->SetFillColor("green");
#$Bplot->SetFillColor("blue");
#$Cplot->SetFillColor("red");

#// Adjust fill color

$graph->Add($b1plot);
#$graph->Add($b2plot);
$graph->Add($b3plot);
$graph->Add($Aplot);
$graph->Add($Bplot);
$graph->Add($Cplot);

$b1plot->SetColor('black');
$b1plot->SetLegend("Received");
$b1plot->SetWeight(7);
$b1plot->SetStyle("solid");
$b1plot->SetStepStyle();

$b2plot->SetColor('purple');
$b2plot->SetLegend("Shipped");
$b2plot->SetWeight(7);
$b2plot->SetStyle("solid");
$b2plot->SetStepStyle();

$b3plot->SetColor('blue');
$b3plot->SetLegend("Tested");
$b3plot->SetWeight(7);
$b3plot->SetStyle("solid");
$b3plot->SetStepStyle();

$Aplot->SetWeight(7);
$Aplot->SetStepStyle();
$Aplot->SetLegend("Grade A");

$Bplot->SetStepStyle();
$Bplot->SetWeight(7);
$Bplot->SetLegend("Grade B");

$Cplot->SetStepStyle();
$Cplot->SetWeight(7);
$Cplot->SetLegend("Grade C");

#$graph->Add($ABCplot);
$Aplot->SetColor("green");
$Bplot->SetColor("orange");
$Cplot->SetColor("red");

#$graph->legend->SetReverse();

#// Setup the titles
$graph->title->Set('Module -20C Grades by Batch');
$graph->xaxis->title->Set('Day Received');
$graph->yaxis->title->Set('Number of Modules');

#// Display the graph
$graph->Stroke();

?>
