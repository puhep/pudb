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

$g = 0;

$func0 = "select count(received) as receive, count(shipped) as ship, count(post_tested_n20C) as tested, WEEK(DATE_SUB(received, INTERVAL 3 DAY)) as batch, DATE_FORMAT(received, \"%y-%m-%d\") as date from times_module_p where received > \"2015-09-01\" group by batch order by received";
$func1 = "select count(a.id) as num, WEEK(DATE_SUB(received, INTERVAL 3 DAY)) as batch,  date_format(received,\"%y-%m-%d\") as date from module_p a, times_module_p b where a.id=b.assoc_module and b.received>\"2015-09-01\" and a.tested_status=\"Rejected\" and b.post_tested_n20C is null group by batch order by received";

#echo $func0."<br>";
$output0 = mysql_query($func0,$connection);
#$output1 = mysql_query($func1,$connection);

while($row0 = mysql_fetch_assoc($output0)){
	    $arr[0][$g] = ($row0['date']);
	    $arr[1][$g] = $row0['receive'];
	    $arr[2][$g] = $row0['ship'];
	    $arr[3][$g] = $row0['tested'];
	    $g++;
}

#$g = 0;
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

for($i=0;$i<count($arrIDs);$i++){
	$arrA[$i]=0;
	$arrB[$i]=0;
	$arrC[$i]=0;
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

for($i=0; $i<count($arr[1]); $i++){
	  $arrA[$i] = $arrA[$i]/count($arrIDs[$i])*100;
	  $arrB[$i] = $arrB[$i]/count($arrIDs[$i])*100;
	  $arrC[$i] = $arrC[$i]/count($arrIDs[$i])*100;
	  $arr[1][$i] = 100;
}

$graph = new Graph(1340,800);
$graph->SetScale('textlin',0,100);
$graph->yaxis->scale->ticks->Set(20);
#// Add a drop shadow
#$graph->SetShadow();
 
#// Adjust the margin a bit to make more room for titles
$graph->SetMargin(80,90,50,120);
 
#// Create a bar pot
$b1plot = new BarPlot($arr[1]);
$b2plot = new BarPlot($arr[2]);

$Aplot = new BarPlot($arrA);
$Bplot = new BarPlot($arrB);
$Cplot = new BarPlot($arrC);

$ABCplot = new AccBarPlot(array($Aplot,$Bplot,$Cplot));
#$ABCplot = new GroupBarPlot(array($Aplot,$Bplot,$Cplot));

$graph->legend->SetPos(.1, .1, 'left','top');
$graph->legend->SetFont(FF_FONT2,FS_BOLD);

#// Adjust fill color

$graph->Add($b1plot);
$b1plot->SetFillColor('lightblue');
$b1plot->SetLegend("Not Graded");

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
$graph->yaxis->title->Set('Percent Modules in Batch');
 
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
