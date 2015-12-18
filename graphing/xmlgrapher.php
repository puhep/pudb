<?php
require_once('../jpgraph/src/jpgraph.php');
require_once('../jpgraph/src/jpgraph_scatter.php');
require_once('../jpgraph/src/jpgraph_log.php');

include('../../../Submission_p_secure_pages/connect.php');

$id = $_GET['id'];
$scan = $_GET['scan'];
$level = $_GET['level'];

$func = "SELECT file, filesize, part_type FROM measurement_p WHERE part_ID=\"$id\" AND scan_type=\"$scan\"";
$namefunc = "SELECT name, module FROM sensor_p WHERE id=\"$id\"";
$modfunc = "SELECT name FROM module_p WHERE assoc_sens=\"$id\"";

mysql_query('USE cmsfpix_u', $connection);

$file = mysql_query($func, $connection);

$nameout = mysql_query($namefunc, $connection);
$namerow = mysql_fetch_assoc($nameout);
$name = $namerow['name'];


if($namerow['module']){	
	$modout = mysql_query($modfunc, $connection);
	$modrow = mysql_fetch_assoc($modout);
	$name = $modrow['name'];
}

$file1 = NULL;
$file2 = NULL;
$file3 = NULL;
$file4 = NULL;

while($row = mysql_fetch_assoc($file)){
	
	if($row['part_type'] == "wafer"){
		$file1 = $row['file'];
	}
	if($level != "sensor"){
		if($row['part_type'] == "module"){
			$file2 = $row['file'];
		}
		if($level == "module"){
			if($row['part_type'] == "assembled"){
				$file3 = $row['file'];
			}
			if($row['part_type'] == "fnal"){
				$file4 = $row['file'];
			}
		}
	}
}

$imagefile = "/project/cmsfpix/.www/Submission_p/pics/graphs/".$level."_".$id."_".$scan.".png";

if(!is_null($file1)){
$doc1=simplexml_load_string($file1);}

if(!is_null($file2)){
$doc2=simplexml_load_string($file2);}

if(!is_null($file3)){
$doc3=simplexml_load_string($file3);}

if(!is_null($file4)){
$doc4=simplexml_load_string($file4);}

if($scan == "IV"){
$y = "ACTV_CURRENT_AMP";
$y2 = "TOT_CURRENT_AMP";
$y3 = "GRD_CURRENT_AMP";}
if($scan == "CV"){
$y = "ACTV_CAP_FRD";}

$graphname = $partname." ".$scan." Scan";
$datacountlim = 0;

if(!is_null($file1)){
	$datacount1 = count($doc1->DATA_SET->DATA);
	$datacountlim = $datacount1;
	$timestamp1 = $doc1->HEADER->RUN->RUN_BEGIN_TIMESTAMP;
	if($timestamp1 == ""){
		$timestamp1 = "No Timestamp";
	}
}
if(!is_null($file2)){
	$datacount2 = count($doc2->DATA_SET->DATA);
	if($datacount2 > $datacountlim){
		$datacountlim = $datacount2;
	}

	$timestamp2 = $doc2->HEADER->RUN->RUN_BEGIN_TIMESTAMP;
	if($timestamp2 == ""){
		$timestamp2 = "No Timestamp";
	}
}
if(!is_null($file3)){
	$datacount3 = count($doc3->DATA_SET->DATA);
	if($datacount3 > $datacountlim){
		$datacountlim = $datacount3;
	}

	$timestamp3 = $doc3->HEADER->RUN->RUN_BEGIN_TIMESTAMP;
	if($timestamp3 == ""){
		$timestamp3 = "No Timestamp";
	}
}
if(!is_null($file4)){
	$datacount4 = count($doc4->DATA_SET->DATA);
	if($datacount4 > $datacountlim){
		$datacountlim = $datacount4;
	}

	$timestamp4 = $doc4->HEADER->RUN->RUN_BEGIN_TIMESTAMP;
	if($timestamp4 == ""){
		$timestamp4 = "No Timestamp";
	}
}
$arr1;
$arr2;
$arr3;
$arr4;
$limitarr;
$markedA=0;
$markedB=0;
$markedC=0;
$markedD=0;


###Array for a limit line
#for($loop=0;$loop<$datacountlim;$loop++){

	#$limitarr[0][$loop]=$doc2->DATA_SET->DATA[$loop]->VOLTAGE_VOLT;

	#	settype($limitarr[0][$loop],"float");
	#	if($limitarr[0][$loop]<=260){
	#		$limitarr[1][$loop]=8E-6;}
	#	elseif($limitarr[0][$loop]<=310){
	#		$limitarr[1][$loop]=9E-6;}
	#	else{
	#		$limitarr[1][$loop]=1E-3;}
#}


if(!is_null($file1)){
	for($loop=0;$loop<$datacount1;$loop++){

		$arr1[0][$loop]=$doc1->DATA_SET->DATA[$loop]->VOLTAGE_VOLT;

		settype($arr1[0][$loop],"float");

		$arr1[0][$loop]=abs($arr1[0][$loop]);

		$arr1[1][$loop]=$doc1->DATA_SET->DATA[$loop]->$y;
		if($arr1[1][$loop] == "NaN"){
			$arr1[1][$loop] = 1E-10;
		}
			settype($arr1[1][$loop],"float");
			if($arr1[1][$loop] == 0){
				$arr1[1][$loop] = 1E-10;
			}	
			if($arr1[1][$loop] < 0 || $arr1[1][$loop] == "NaN"){
				#$arr1[1][$loop] = 1E-10;
				$arr1[1][$loop] *= -1;
			}
	}
	
	$index100 = array_search(100, $arr1[0]);
		$I100=$arr1[1][$index100];

	$index150 = array_search(150, $arr1[0]);
		$I150=$arr1[1][$index150];

	if($I150>1E-6 || $I150/$I100>2){
		$markedA=1;
	}
}

if(!is_null($file2)){
	for($loop=0;$loop<$datacount2;$loop++){

		$arr2[0][$loop]=$doc2->DATA_SET->DATA[$loop]->VOLTAGE_VOLT;
		
		settype($arr2[0][$loop],"float");

		$arr2[0][$loop]=abs($arr2[0][$loop]);

		if($doc2->DATA_SET->DATA[$loop]->$y3 != "" && $doc2->DATA_SET->DATA[$loop]->$y != ""){
			$tmp1 = $doc2->DATA_SET->DATA[$loop]->$y3;
			$tmp2 = $doc2->DATA_SET->DATA[$loop]->$y;
			settype($tmp1,"float");
			settype($tmp2,"float");
			$arr2[1][$loop]=$tmp1 + $tmp2;
		}	
		else{
			$arr2[1][$loop]=$doc2->DATA_SET->DATA[$loop]->$y2;
		}
		if($arr2[1][$loop] == "NaN"){
			$arr2[1][$loop] = 1E-10;
		}
			settype($arr2[1][$loop],"float");
			if($arr2[1][$loop] == 0){
				$arr2[1][$loop] = 1E-10;
			}	
			if($arr2[1][$loop] < 0){
				#$arr2[1][$loop] = 1E-10;
				$arr2[1][$loop] *= -1;
			}
			if($arr2[1][$loop] > $limitarr[$loop]){
				$markedB=1;
			}
	}
	$index100 = array_search(100, $arr2[0]);
		$I100=$arr2[1][$index100];

	$index150 = array_search(150, $arr2[0]);
		$I150=$arr2[1][$index150];

	if($I150>1E-6 || $I150/$I100>2){
		$markedB=1;
	}
}

if(!is_null($file3)){
	for($loop=0;$loop<$datacount3;$loop++){

		$arr3[0][$loop]=$doc3->DATA_SET->DATA[$loop]->VOLTAGE_VOLT;
		
		settype($arr3[0][$loop],"float");

		$arr3[0][$loop]=abs($arr3[0][$loop]);

		$arr3[1][$loop]=$doc3->DATA_SET->DATA[$loop]->$y2;
		if($arr3[1][$loop] == "NaN"){
			$arr3[1][$loop] = 1E-10;
		}
			settype($arr3[1][$loop],"float");
			if($arr3[1][$loop] == 0){
				$arr3[1][$loop] = 1E-10;
			}	
			if($arr3[1][$loop] < 0){
				#$arr3[1][$loop] = 1E-10;
				$arr3[1][$loop] *= -1;
			}
			if($arr3[1][$loop] > $limitarr[$loop]){
				$markedC=1;
			}
	}
	$index100 = array_search(100, $arr3[0]);
		$I100=$arr3[1][$index100];

	$index150 = array_search(150, $arr3[0]);
		$I150=$arr3[1][$index150];

	if($I150>1E-6 || $I150/$I100>2){
		$markedC=1;
	}
}

if(!is_null($file4)){
	for($loop=0;$loop<$datacount4;$loop++){

		$arr4[0][$loop]=$doc4->DATA_SET->DATA[$loop]->VOLTAGE_VOLT;
		
		settype($arr4[0][$loop],"float");

		$arr4[0][$loop]=abs($arr4[0][$loop]);

		$arr4[1][$loop]=$doc4->DATA_SET->DATA[$loop]->$y2;
		if($arr4[1][$loop] == "NaN"){
			$arr4[1][$loop] = 1E-10;
		}
			settype($arr4[1][$loop],"float");
			if($arr4[1][$loop] == 0){
				$arr4[1][$loop] = 1E-10;
			}	
			if($arr4[1][$loop] < 0){
				#$arr4[1][$loop] = 1E-10;
				$arr4[1][$loop] *= -1;
			}
			if($arr4[1][$loop] > $limitarr[$loop]){
				$markedD=1;
			}
	}
	$index100 = array_search(100, $arr4[0]);
		$I100=$arr4[1][$index100];

	$index150 = array_search(150, $arr4[0]);
		$I150=$arr4[1][$index150];

	if($I150>1E-6 || $I150/$I100>2){
		$markedD=1;
	}
}

$graph=new Graph(1340,800);
$graph->SetScale("linlog",1,1,0,600);
$graph->xaxis->scale->ticks->Set(100,10);

$graph->img->SetMargin(85,80,40,40);	

$graph->title->Set($graphname);

$graph->title->SetFont(FF_FONT2,FS_BOLD);

$graph->xaxis->title->Set("Bias Voltage [V]");
$graph->xaxis->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT2,FS_BOLD);

if($scan=="IV"){
$graph->yaxis->title->Set("Sensor Leakage Current [A]");}
if($scan=="CV"){
$graph->yaxis->title->Set("Capacitance [F]");}
$graph->yaxis->SetFont(FF_FONT2,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT2,FS_BOLD);

$graph->yaxis->title->SetMargin(40);
$graph->SetFrame(true,'black',0);
$graph->legend->SetFont(FF_FONT2,FS_BOLD);
$graph->legend->SetLineWeight(10);


if(!is_null($file1)){
$sp1 = new ScatterPlot($arr1[1],$arr1[0]);
$sp1->mark->SetWidth(8);
$sp1->mark->SetFillColor("blue");
$sp1->link->Show();
$graph->Add($sp1);
$sp1->SetLegend("On Wafer\n".$timestamp1);
}

if(!is_null($file2)){
$sp2 = new ScatterPlot($arr2[1],$arr2[0]);
$sp2->mark->SetWidth(8);
$sp2->mark->SetFillColor("chartreuse3");
$sp2->link->Show();
$graph->Add($sp2);
$sp2->SetLegend("Bare Module\n".$timestamp2);
}

if(!is_null($file3)){
$sp3 = new ScatterPlot($arr3[1],$arr3[0]);
$sp3->mark->SetWidth(8);
$sp3->mark->SetFillColor("orange");
$sp3->link->Show();
$graph->Add($sp3);
$sp3->SetLegend("Assembled Module\n".$timestamp3);
}

if(!is_null($file4)){
$sp4 = new ScatterPlot($arr4[1],$arr4[0]);
$sp4->mark->SetWidth(8);
$sp4->mark->SetFillColor("red");
$sp4->link->Show();
$graph->Add($sp4);
$sp4->SetLegend("Module at FNAL\n".$timestamp4);
}

#if($scan=="IV"){
#$splim = new ScatterPlot($limitarr[1],$limitarr[0]);
#$splim->mark->SetWidth(8);
#$splim->mark->SetFillColor("red");
#$splim->link->Show();
#$graph->Add($splim);
#$splim->SetLegend("Limit");
#}

$graph->StrokeStore($imagefile);

?>
