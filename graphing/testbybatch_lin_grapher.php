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

$arrA = array();
$arrB = array();
$arrC = array();

mysql_query("USE cmsfpix_u", $connection);

$g = 0;

$func0 = "select count(received) as receive, count(shipped) as ship, count(post_tested_n20C) as tested, WEEK(DATE_SUB(received, INTERVAL 3 DAY)) as batch, DATE_FORMAT(received, \"%y-%m-%d\") as date from times_module_p where received > \"2015-09-01\" group by batch order by received";

$output0 = mysql_query($func0,$connection);

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

$arrIDs = array();
for($z=0;$z<count($arr[0]);$z++){
	$funcIDs = "select a.id from times_module_p b, module_p a where WEEK(DATE_SUB(received, INTERVAL 3 DAY)) = WEEK(DATE_SUB(\"".$arr[0][$z]."\", INTERVAL 3 DAY)) and a.id=b.assoc_module and received>\"2015-09-01\" and assembly>11";
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
		$grade = curgrade($arrIDs[$i][$j]);
		if($grade == "A"){
			$arrA[$i]++;
		}
		if($grade == "B"){
			$arrB[$i]++;	
		}
		if($grade == "C"){
			$arrC[$i]++;	
		}
		
	}
}

#make 'tested' list equal to the sum of the graded modules for each batch
for($g=0;$g<count($arrIDs)+1;$g++){
	$arr[3][$g] = $arrA[$g]+$arrB[$g]+$arrC[$g];
}

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
