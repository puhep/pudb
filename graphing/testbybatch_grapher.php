<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
include('../jpgraph/src/jpgraph.php');
include('../jpgraph/src/jpgraph_date.php');
include('../jpgraph/src/jpgraph_line.php');
include('../jpgraph/src/jpgraph_bar.php');

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
	    $arr[1][$g] = $row0['receive'];
	    $arr[2][$g] = $row0['ship'];
	    $arr[3][$g] = $row0['tested'];
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

for($i=0;$i<count($arrIDs);$i++){
	$arrA[$i]=0;
	$arrB[$i]=0;
	$arrC[$i]=0;
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

$graph = new Graph(1340,800);
$graph->SetScale('textlin');
 
#// Adjust the margin a bit to make more room for titles
$graph->SetMargin(70,80,40,40);
 
#// Create a bar pot
$b1plot = new BarPlot($arr[1]);
$b2plot = new BarPlot($arr[2]);
#$b3plot = new BarPlot($arr[3]);

$Aplot = new BarPlot($arrA);
$Bplot = new BarPlot($arrB);
$Cplot = new BarPlot($arrC);

#$Aplot->SetFillColor("green");
#$Bplot->SetFillColor("blue");
#$Cplot->SetFillColor("red");
$ABCplot = new AccBarPlot(array($Aplot,$Bplot,$Cplot));

$graph->legend->SetPos(.1, .1, 'left','top');
$graph->legend->SetFont(FF_FONT2,FS_BOLD);

#// Adjust fill color

$graph->Add($b1plot);
$b1plot->SetFillColor('lightblue');
$b1plot->SetLegend("Not Graded");

#$graph->Add($b2plot);
$b2plot->SetFillColor('orchid');
$b2plot->SetLegend("Shipped");

#$graph->Add($b3plot);
#$b3plot->SetFillColor('lightgreen');
#$b3plot->SetLegend("Tested");

$Aplot->SetLegend("Grade A");

$Bplot->SetLegend("Grade B");

$Cplot->SetLegend("Grade C");

$graph->Add($ABCplot);
$Aplot->SetFillColor("lightgreen");
$Bplot->SetFillColor("lightgoldenrod1");
$Cplot->SetFillColor("lightred");
$Aplot->SetColor("lightgreen");
$Bplot->SetColor("lightgoldenrod1");
$Cplot->SetColor("lightred");

$graph->legend->SetReverse();

#// Setup the titles
$graph->title->Set('Grades by Batch');
$graph->xaxis->title->Set('Day Received');
$graph->yaxis->title->Set('Number in Batch');
 
$graph->title->SetFont(FF_FONT2,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->SetFont(FF_FONT2, FS_BOLD);
$graph->yaxis->SetFont(FF_FONT2, FS_BOLD);
$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->title->SetMargin(60);
$graph->xaxis->SetTickLabels($arr[0]);
$graph->yaxis->title->SetMargin(20);


#// Display the graph
$graph->Stroke();

?>
