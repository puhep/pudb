<?php

function curnotes($db, $id){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT notes from ".$db." WHERE id=".$id;

	$output = mysql_query($func, $connection);
	$noterow = mysql_fetch_assoc($output);
	if($noterow['notes']!=""){
		echo "<br>";
		echo nl2br(stripslashes(stripslashes($noterow["notes"])));
	}
	else{
		echo "This part has no comments";
	}
}

function curpics($type, $id){

	$cwd = getcwd();
	$num = 0;

	echo "<table border=1 align=\"center\">";
	while(file_exists($cwd."/../pics/".$type."/".$type.$id."pic".$num.".jpg")){
	
		echo "<tr>";

		$src = "../pics/".$type."/".$type.$id."pic".$num.".jpg";
		$txt = "../pics/".$type."/".$type.$id."pic".$num.".txt";
	
		echo "<td>";	
		echo "<a href=".$src." target =\"_blank\"><img src=".$src." width=\"200\" height=\"200\" /></a>";
		echo "</td>";

		echo "<td>";
		if(file_exists($txt)){
			$fp = fopen($txt, 'r');
			echo nl2br(fread($fp, filesize($txt)));
			fclose($fp);
		}
		echo "</td>";
		
		echo "<td>";
		
		echo "<form method=\"get\" action=\"../summary/piccomedit.php\">";
		echo "<input type='hidden' name='file' value='".$txt."'>";
		echo "<input type='hidden' name='id' value='".$id."'>";
		echo "<input type='hidden' name='part' value='".$type."'>";
		echo "<input type='submit' value='Add Comments'>";
		echo "</form>";

		echo "</td>";

		echo "</tr>";

		$num = $num+1;
	}
	echo "</table>";

	if($num==0){
		echo "No pictures for this part";
	}
}

function curgraphs($sensorid, $scan, $level){
	include('../../../Submission_p_secure_pages/connect.php');

	$imagefile = "../pics/graphs/".$level."_".$sensorid."_".$scan.".png";

	if(file_exists($imagefile)){
		echo "<a href=\"$imagefile\" target=\"_blank\"><img src=\"$imagefile\" width=\"335\" height=\"200\" /></a>";
	}
	else{

		$func = "SELECT filesize,notes  FROM measurement_p WHERE part_ID =$sensorid AND scan_type=\"$scan\"";
		mysql_query('USE cmsfpix_u', $connection);

		$output = mysql_query($func, $connection);
	
		$name = findname("sensor_p", $sensorid);
		if(substr($name, 0, 2) == "WS"){
			$level = "";
		}

		$any = 0;
		while($row = mysql_fetch_assoc($output)){
			$exists = $row['filesize'];
			if($exists){
				break;}
		}
		if($exists){
			echo "<a href=\"../graphing/xmlgrapher.php?id=$sensorid&scan=$scan&level=$level\" target =\"_blank\"><img src=\"../graphing/xmlgrapher.php?id=$sensorid&scan=$scan&level=$level\" width=\"335\" height=\"200\" /></a>";
		
		}
		else{
			echo "No ".$scan." scan data for this part";
		}
	}
}

function curgraphs_pos_summary($level, $scan, $loc){

	$imagefile = "../pics/graphs/".$level."_".$loc."_".$scan.".png";

	if(file_exists($imagefile)){
		echo "<a href=\"$imagefile\" target=\"_blank\"><img src=\"$imagefile\" width=\"710\" height=\"400\" /></a>";
	}
	else{

		echo "<a href=\"../graphing/positiongrapher.php?level=$level&scan=$scan&loc=$loc\" target=\"_blank\"><img src=\"../graphing/positiongrapher.php?level=$level&scan=$scan&loc=$loc\" width=\"710\" height=\"400\" /></a>";
	}

}

function curname($db, $id){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT name FROM $db WHERE id=$id";

	if($db == "module_p"){
		$func = "SELECT name,name_hdi FROM $db WHERE id=$id";
	}

	$output = mysql_query($func, $connection);
	$array = mysql_fetch_assoc($output);
	$name = $array['name'];
	$name_hdi = NULL;
	if($db == "module_p"){
		$name_hdi = $array['name_hdi'];
	}

	if($name_hdi == NULL){
		echo "<b>$name</b><br>";
	}
	else{
		echo "<b>$name_hdi</b><br>";
	}
}

function curstep($part, $assembly){

	$wafsteps = array("Received", "Inspected", "Tested", "Promoted", "Ready for Shipping", "Shipped");
	$modulesteps = array("Expected", "Recieved", "Inspected", "IV Tested", "Ready for HDI Assembly", "HDI Attached", "Wirebonded", "Encapsulated", "Tested (Post-Encapsulation)", "Thermally Cycled", "Tested (Post-Thermal Cycling)", "Ready for Shipping", "Shipped");
	$hdisteps = array("Recieved", "Inspected", "Ready for Assembly", "On Module", "Rejected");

	if(!strcmp($part, "wafer")){
		echo $wafsteps[$assembly];}
	if(!strcmp($part, "module")){
		echo $modulesteps[$assembly];}
	if(!strcmp($part, "hdi")){
		if($assembly == -2){
			echo "Rejected";
		}
		else{
			echo $hdisteps[$assembly];
		}
	}

}

function currocs($module){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT name,is_dead from ROC_p WHERE assoc_module=\"$module\" AND position<=7 ORDER BY position ASC";
	$revfunc = "SELECT name,is_dead from ROC_p WHERE assoc_module=\"$module\" AND position>=8 ORDER BY position DESC";

	$output = mysql_query($func, $connection);
	$outputrev = mysql_query($revfunc, $connection);

	echo "<table border=0>";

	echo "<tr>";
	echo "<td>";

	echo "<table border=1>";
	for($i=0;$i<8;$i++){

		$rocrow = mysql_fetch_assoc($output);
		echo "<tr>";

		echo "<td>";
		if($rocrow['is_dead']){
		echo "<p style=\"background-color:red;\">";
		}
		else{
		echo "<p style=\"background-color:#00FF00;\">";
		}
		echo "ROC".$i;
		echo "</p>";
		echo "</td>";

		echo "<td style=\"height: 100%;\">";
	
		echo $rocrow['name'];

		echo "</td>";

		echo "</tr>";
	}
	echo "</table>";

	echo "</td>";

	echo "<td>";

	echo "<table border=1>";
	for($i=15;$i>7;$i--){

		$rocrowrev = mysql_fetch_assoc($outputrev);
		echo "<tr>";

		echo "<td>";
		if($rocrowrev['is_dead']){
		echo "<p style=\"background-color:red;\">";
		}
		else{
		echo "<p style=\"background-color:#00FF00;\">";
		}
		echo "ROC".$i;
		echo "</p>";
		echo "</td>";

		echo "<td>";
		echo $rocrowrev['name'];

		echo "</td>";

		echo "</tr>";
	}
	echo "</table>";

	echo "</td>";
	echo "</tr>";

	echo "</table>";

	/*echo "<table border=0>";

	echo "<tr>";
	echo "<td>";

	echo "<table border=1>";
	echo "<tr>";
	for($i=7;$i>=0;$i--){

		echo "<td>";
		echo "ROC".$i;
		echo "</td>";
		
	}
	echo "</tr>";
	echo "<tr>";
	for($i=7;$i>=0;$i--){
		
		echo "<td>";
		$rocrowrev = mysql_fetch_assoc($outputrev);
		echo $rocrowrev['name'];
		echo "</td>";
	}
	echo "</tr>";
	echo "</table>";

	echo "</td>";
	echo "</tr>";
	echo "<tr>";

	echo "<td>";

	echo "<table border=1>";
	echo "<tr>";
	for($i=8;$i<=15;$i++){

		echo "<td>";
		echo "ROC".$i;
		echo "</td>";

	}
	echo "</tr>";
	echo "<tr>";
	for($i=8;$i<=15;$i++){

		echo "<td>";
		$rocrow = mysql_fetch_assoc($output);
		echo $rocrow['name'];
		echo "</td>";

	}
	echo "</tr>";
	echo "</table>";

	echo "</td>";

	echo "</tr>";

	echo "</table>";*/
}

function badrocs($id){
	include('../../../Submission_p_secure_pages/connect.php');
	
	mysql_query('USE cmsfpix_u', $connection);
	
	$func = "SELECT COUNT(position) FROM ROC_p WHERE assoc_module=\"$id\" AND is_dead=1";

	$output = mysql_query($func, $connection);
	$array = mysql_fetch_assoc($output);
	$count = $array['COUNT(position)'];

	return $count;
}

function curloc($db, $id){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT location FROM $db WHERE id=\"$id\"";
	
	$output = mysql_query($func, $connection);
	$array = mysql_fetch_assoc($output);
	$loc = $array['location'];

	return $loc;
}

function curtestgrade($id){

	$dumped = dump("module_p", $id);

	$badrocs = badrocs($id);

	echo "Number of Bad Rocs: ".$badrocs."<br>";
	echo "Number of Dead Pixels: ".$dumped['deadpix']."<br>";
	echo "Number of Unmaskable Pixels: ".$dumped['unmaskable_pix']."<br>";
	echo "Number of Unaddressable Pixels: ".$dumped['unaddressable_pix']."<br>";
	echo "Number of Bad Bump Bonds (Electrical): ".$dumped['badbumps_electrical']."<br>";
	echo "Number of Bad Bump Bonds (Reverse Bias): ".$dumped['badbumps_reversebias']."<br>";
	echo "Number of Bad Bump Bonds (X-Ray): ".$dumped['badbumps_xray']."<br>";
	echo "X-Ray Slope: ".$dumped['xray_slope']."<br>";
	echo "X-Ray Offset: ".$dumped['xray_offset']."<br>";
	echo "Grade: ".$dumped['grade']."<br>";
	if($dumped['can_time']==1){
	echo "Timeable: Yes<br>";
	}
	elseif(is_null($dumped['can_time'])){
	echo "Timeable:<br>";
	}
	else{
	echo "Timeable: No<br>";
	}

	return;
}

function findid($db, $name){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$sqlname = mysql_real_escape_string($name);

	$func = "SELECT id FROM $db WHERE name=\"$sqlname\"";

	if($db === "module_p"){
		$func = "SELECT id FROM $db WHERE name=\"$sqlname\" OR name_hdi=\"$sqlname\"";
	}
	
	$output = mysql_query($func, $connection);
	$array = mysql_fetch_assoc($output);
	$id = $array['id'];

	return $id;
}

function findname($db, $id){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT name FROM $db WHERE id=\"$id\"";
	if($db == "module_p"){
		$func = "SELECT name,name_hdi FROM $db WHERE id=$id";
	}
	
	$output = mysql_query($func, $connection);
	$array = mysql_fetch_assoc($output);
	$name = $array['name'];
	$name_hdi = $array['name_hdi'];

	if($name_hdi == NULL){
		return $name;
	}
	else{
		return  $name_hdi;
	}
}

function dump($db, $id){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query("USE cmsfpix_u", $connection);

	$func = "SELECT * FROM $db WHERE id=$id";
	
	$output = mysql_query($func, $connection);
	$dump = mysql_fetch_assoc($output);
	return $dump;
}

function daqdump($id){

	$src = "../download/dbc0dl.php?id=$id";

	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT * from DAQ_p WHERE assoc_module=\"$id\"";

	$output = mysql_query($func, $connection);
	$row = mysql_fetch_assoc($output);

	$C0=$row['C0'];
	if($C0){
		echo "<a href=".$src." target =\"_blank\"><img src=".$src." height=\"300\" width=\"300\"></a><br>";
	
	$addressParameters = $row['addressParameters'];
	$dacParameters = $row['dacParameters'];
	$phCalibrationFitTan = $row['phCalibrationFitTan'];
	$summary = $row['summary'];
	$SCurveData = $row['SCurveData'];
	$testParameters = $row['testParameters'];
	$trimParameters = $row['trimParameters'];
	$notes = $row['notes'];

	$tmpaP = "tmpaP.txt";
	$fh = fopen($tmpaP, 'w') or die("This file cannot be opened");
	fwrite($fh, $addressParameters);
	echo "<a href=".$tmpaP." target =\"blank\">Address Parameters</a><br>";
	fclose($fh);

	$tmpdP = "tmpdP.txt";
	$fh = fopen($tmpdP, 'w') or die("This file cannot be opened");
	fwrite($fh, $dacParameters);
	echo "<a href=".$tmpdP." target =\"blank\">DAC Parameters</a><br>";

	$tmpph = "tmpph.txt";
	$fh = fopen($tmpph, 'w') or die("This file cannot be opened");
	fwrite($fh, $phCalibrationFitTan);
	echo "<a href=".$tmpph." target =\"blank\">PH Calibration Fit</a><br>";

	$tmpsummary = "tmpsummary.txt";
	$fh = fopen($tmpsummary, 'w') or die("This file cannot be opened");
	fwrite($fh, $summary);
	echo "<a href=".$tmpsummary." target =\"blank\">Summary</a><br>";

	$tmpSCD = "tmpSCD.txt";
	$fh = fopen($tmpSCD, 'w') or die("This file cannot be opened");
	fwrite($fh, $SCurveData);
	echo "<a href=".$tmpSCD." target =\"blank\">SCurve Data</a><br>";

	$tmptest = "tmptest.txt";
	$fh = fopen($tmptest, 'w') or die("This file cannot be opened");
	fwrite($fh, $testParameters);
	echo "<a href=".$tmptest." target =\"blank\">Test Parameters</a><br>";

	$tmptrim = "tmptrim.txt";
	$fh = fopen($tmptrim, 'w') or die("This file cannot be opened");
	fwrite($fh, $trimParameters);
	echo "<a href=".$tmptrim." target =\"blank\">Trim Parameters</a><br>";
	
	echo $notes;
	echo "<br><br>";
	}
	else{
		echo "No DAQ data for this part";
	}

}

function namedump($db, $id){
	include('../../../Submission_p_secure_pages/connect.php');

	$namearr;
	$hdi = $id;

	if($db == "module_p" || $db == "HDI_p"){$hdidb = 1;}
	else{$hdidb = 0;}

	mysql_query("USE cmsfpix_u", $connection);

	if($db == "module_p"){
		$bbmfunc = "SELECT name,assoc_HDI,assoc_sens FROM module_p WHERE id=$id";
		$bbm = mysql_query($bbmfunc, $connection);
		$row = mysql_fetch_assoc($bbm);
		$namearr["bbm"] = $row['name'];
		$id = $row['assoc_sens'];
		$hdi = $row['assoc_HDI'];
		$db="sensor_p";
	}
	
	if($db == "sensor_p"){
		$sensorfunc = "SELECT name, assoc_wafer FROM sensor_p WHERE id=$id";
		$sensor = mysql_query($sensorfunc, $connection);
		$row = mysql_fetch_assoc($sensor);
		$namearr["sensor"] = $row['name'];
		if($namearr['bbm'] == ""){
			$bbmfunc = "SELECT name from module_p WHERE assoc_sens=$id";
			$bbm = mysql_query($bbmfunc, $connection);
			$subrow = mysql_fetch_assoc($bbm);
			$namearr['bbm'] = $row['name'];
		}
		$id = $row['assoc_wafer'];
		$db = "wafer_p";
	}

	if($db == "wafer_p"){
		$waferfunc = "SELECT name FROM wafer_p WHERE id=$id";
		$wafer = mysql_query($waferfunc, $connection);
		$row = mysql_fetch_assoc($wafer);
		$namearr["wafer"] = $row['name'];
		if(isset($namearr['sensor']) && $namearr['sensor'] == ""){
			$sensorfunc = "SELECT name from sensor_p WHERE assoc_wafer=$id";
			$sensor = mysql_query($sensorfunc, $connection);
			$subrow = mysql_fetch_assoc($sensor);
			$namearr['sensor'] = $row['name'];
		}
	}
	
	if($hdidb == 1){
		$id = $hdi;
		$hdifunc = "SELECT name from HDI_p WHERE id=$id";
		$hdi = mysql_query($hdifunc, $connection);
		$row = mysql_fetch_assoc($hdi);
		$namearr["hdi"] = $row['name'];
		if($namearr['bbm'] == ""){
			$bbmfunc = "SELECT name from module_p WHERE assoc_sens=$id";
			$bbm = mysql_query($bbmfunc, $connection);
			$subrow = mysql_fetch_assoc($bbm);
			$namearr['bbm'] = $row['name'];
		}
	}
	
	return $namearr;
}

function xmlbuttongen($id, $scan, $level){
	include('../../../Submission_p_secure_pages/connect.php');

	$func = "SELECT id, part_type FROM measurement_p WHERE part_ID=\"$id\" AND scan_type=\"$scan\"";
	
	$id1=0;
	$id2=0;
	$id3=0;
	$id4=0;
	
	mysql_query('USE cmsfpix_u', $connection);

	$output = mysql_query($func, $connection);

	while($row = mysql_fetch_assoc($output)){
		
		if($row['part_type'] == "wafer"){
			$id1 = $row['id'];
		}
		if($row['part_type'] == "module"){
			$id2 = $row['id'];
		}
		if($row['part_type'] == "assembled"){
			$id3 = $row['id'];
		}
		if($row['part_type'] == "fnal"){
			$id4 = $row['id'];
		}
	}

	if($id1>0){
		echo "<form><input type=\"button\" value=\"Download On-Wafer $scan Data\" onClick=\"window.location.href='../download/dbxmldl.php?id=$id1'\"></form>";
		echo "<a href=\"../download/dbcsvdl.php?id=$id1\" target=\"_blank\">Download as .txt</a>";
		echo "   ";
		echo "<a href=\"../download/XMLfiles.php?part=wafer&partid=$id&scan=$scan\" target=\"_blank\">More Files</a>";
	}
	if($id2>0 && $level!="sensor"){
		echo "<form><input type=\"button\" value=\"Download Bare Module $scan Data\" onClick=\"window.location.href='../download/dbxmldl.php?id=$id2'\"></form>";
		echo "<a href=\"../download/dbcsvdl.php?id=$id2\" target=\"_blank\">Download as .txt</a>";
		echo "   ";
		echo "<a href=\"../download/XMLfiles.php?part=module&partid=$id&scan=$scan\" target=\"_blank\">More Files</a>";
	}
	if($id3>0 && $level!="sensor"){
		echo "<form><input type=\"button\" value=\"Download Assembled Module $scan Data\" onClick=\"window.location.href='../download/dbxmldl.php?id=$id3'\"></form>";
		echo "<a href=\"../download/dbcsvdl.php?id=$id3\" target=\"_blank\">Download as .txt</a>";
		echo "   ";
		echo "<a href=\"../download/XMLfiles.php?part=assembled&partid=$id&scan=$scan\" target=\"_blank\">More Files</a>";
	}
	if($id4>0 && $level!="sensor"){
		echo "<form><input type=\"button\" value=\"Download FNAL Module $scan Data\" onClick=\"window.location.href='../download/dbxmldl.php?id=$id4'\"></form>";
		echo "<a href=\"../download/dbcsvdl.php?id=$id4\" target=\"_blank\">Download as .txt</a>";
		echo "   ";
		echo "<a href=\"../download/XMLfiles.php?part=fnal&partid=$id&scan=$scan\" target=\"_blank\">More Files</a>";
	}
}

function curmod($id,$part){
	include('../../../Submission_p_secure_pages/connect.php');

	if($part=="sensor_p"){
		$field = "assoc_sens";
	}
	if($part=="HDI_p"){
		$field = "assoc_HDI";
	}

	$func = "SELECT name, id FROM module_p WHERE $field=$id AND assembly!=0";
	mysql_query('USE cmsfpix_u', $connection);

	$output = mysql_query($func, $connection);
	
	$any=0;
	while($row = mysql_fetch_assoc($output)){
		$bbmid = $row['id'];
		$name = $row['name'];
		echo "<a href=\"../summary/bbm.php?name=".$name."\">".findname("module_p", $bbmid)."</a>";
		$any=1;
	}

	if($any == 0){
		echo "None";
	}
}

function isTestedWaferDisp($id){
	include('../../../Submission_p_secure_pages/connect.php');
	mysql_query("USE cmsfpix_u", $connection);

	$sensorfunc = "SELECT name,id FROM sensor_p WHERE assoc_wafer=$id ORDER BY name";
	$sensorout = mysql_query($sensorfunc, $connection);
	while($sensorrow = mysql_fetch_assoc($sensorout)){
		$sensid = $sensorrow['id'];
		$sensname = $sensorrow['name'];
		$measfunc = "SELECT filesize FROM measurement_p WHERE part_type=\"wafer\" AND scan_type=\"IV\" AND part_ID=$sensid";
		$measout = mysql_query($measfunc, $connection);
		$measrow = mysql_fetch_assoc($measout);
		echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "$sensname  &nbsp;&nbsp;&nbsp;"; 
		echo "IV  <input name=\"box\" value=\"$sensname\" type=\"checkbox\""; 
		if($measrow['filesize'] >0){
			echo " CHECKED";
		}
		echo " DISABLED> &nbsp;&nbsp;&nbsp;";
		if(substr($sensname,0,1) != "S"){
			$measfunc2 = "SELECT filesize from measurement_p WHERE part_type=\"wafer\" AND scan_type=\"CV\" AND part_ID=$sensid";
			$measout2 = mysql_query($measfunc2, $connection);
			$measrow2 = mysql_fetch_assoc($measout2);

		echo "CV  <input name=\"box\" value=\"$sensname\" type=\"checkbox\""; 
			if($measrow2['filesize']>0){
				echo " CHECKED";
			}
		echo " DISABLED>";
		}
	}

}

function isTestedWaferUpdate($id){
	include('../../../Submission_p_secure_pages/connect.php');
	mysql_query("USE cmsfpix_u", $connection);

	$all=0;
	$lastname="";

	$sensorfunc = "SELECT name,id FROM sensor_p WHERE assoc_wafer=$id";
	$sensorout = mysql_query($sensorfunc, $connection);
	while($sensorrow = mysql_fetch_assoc($sensorout)){
		$sensid = $sensorrow['id'];
		$sensname = $sensorrow['name'];
		$measfunc = "SELECT filesize FROM measurement_p WHERE part_type=\"wafer\" AND scan_type=\"IV\" AND part_ID=$sensid";
		$measout = mysql_query($measfunc, $connection);
		$measrow = mysql_fetch_assoc($measout);
		
		if($measrow['filesize'] >0 && $sensname != $lastname){
			$all++;
		}
		if(substr($sensname,0,1) != "S"){
			$measfunc2 = "SELECT filesize from measurement_p WHERE part_type=\"wafer\" AND scan_type=\"CV\" AND part_ID=$sensid";
			$measout2 = mysql_query($measfunc2, $connection);
			$measrow2 = mysql_fetch_assoc($measout2);

			if($measrow2['filesize']>0 && $sensname != $lastname){
				$all++;
			}
		}
		$lastname = $sensname;
	}
	if($all == 22){

		$updatefunc = "UPDATE wafer_p SET assembly=2 WHERE id=$id";
		mysql_query($updatefunc, $connection);
	}

}

function isTestedModuleUpdate($id){
	include('../../../Submission_p_secure_pages/connect.php');
	mysql_query("USE cmsfpix_u", $connection);

	$sensorfunc = "SELECT name,id FROM sensor_p WHERE assoc_wafer=$id";
	$sensorout = mysql_query($sensorfunc, $connection);
	while($sensorrow = mysql_fetch_assoc($sensorout)){
		$sensid = $sensorrow['id'];
		$sensname = $sensorrow['name'];
		$measfunc = "SELECT filesize FROM measurement_p WHERE part_type=\"wafer\" AND scan_type=\"IV\" AND part_ID=$sensid";
		$measout = mysql_query($measfunc, $connection);
		$measrow = mysql_fetch_assoc($measout);
		echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "$sensname  &nbsp;&nbsp;&nbsp;"; 
		echo "IV  <input name=\"box\" value=\"$sensname\" type=\"checkbox\""; 
		if($measrow['filesize'] >0){
			echo " CHECKED";
		}
		echo " DISABLED> &nbsp;&nbsp;&nbsp;";
		if(substr($sensname,0,1) == "S"){
			$measfunc2 = "SELECT filesize from measurement_p WHERE part_type=\"wafer\" AND scan_type=\"CV\" AND part_ID=$sensid";
			$measout2 = mysql_query($measfunc2, $connection);
			$measrow2 = mysql_fetch_assoc($measout2);

		echo "CV  <input name=\"box\" value=\"$sensname\" type=\"checkbox\""; 
			if($measrow2['filesize']>0){
				echo " CHECKED";
			}
		echo " DISABLED>";
		}
	}

}

function promoteBoxes($id){
	include('../../../Submission_p_secure_pages/connect.php');
	mysql_query("USE cmsfpix_u", $connection);

	$func = "SELECT name, id FROM sensor_p WHERE assoc_wafer=$id AND name LIKE 'WL%'";

	$output = mysql_query($func, $connection);

	echo"<br>";

	while($row = mysql_fetch_assoc($output)){
		$sensid = $row['id'];
		$sensname = $row['name'];
		echo ($sensname."<input name=\"sens[]\" value=\"$sensid\" type=\"checkbox\">"); 
		echo "<br>";
	}
}

function sensorSetPromote($id){
	include('../../../Submission_p_secure_pages/connect.php');
	mysql_query("USE cmsfpix_u", $connection);

	$func = "UPDATE sensor_p SET promote=1 WHERE id=".$id;

	mysql_query($func, $connection);
}

function promoteSensors($id){
	include('../../../Submission_p_secure_pages/connect.php');
	include('../functions/submitfunctions.php');
	mysql_query("USE cmsfpix_u", $connection);
	
	$func = "SELECT name,promote,id FROM sensor_p WHERE assoc_wafer=$id";

	$output = mysql_query($func, $connection);

	while($row = mysql_fetch_assoc($output)){
		if($row['promote']==1){
			moduleinfo($row['name']);		
		}
	}
}

function isLoggedIn(){
	if(!isset($_SESSION)){
		session_start();
	}

	if(substr($_SERVER['REMOTE_ADDR'],0,11) == "128.210.67." || substr($_SERVER['REMOTE_ADDR'],0,10) == "192.168.1."){
		$_SESSION['user'] = "PurdueUser";
	}

	if(isset($_SESSION['user'])){
		$temp = $_SESSION['user'];
		$_SESSION['user'] = $temp;
		return 1;
	}
	else{
		return 0;
	}
}

function gradeMeas($filestr){

	$arr;
	$grade = 1;


	$doc = simplexml_load_string($filestr);
	$datacount = count($doc->DATA_SET->DATA);
	for($loop=0;$loop<$datacount;$loop++){
		$arr[0][$loop]=$doc->DATA_SET->DATA[$loop]->VOLTAGE_VOLT;

		settype($arr[0][$loop],"float");

		$arr[1][$loop]=$doc->DATA_SET->DATA[$loop]->ACTV_CURRENT_AMP;
		if($arr[1][$loop] == "NaN"){
			$arr[1][$loop] = 1E-10;
		}
		settype($arr[1][$loop],"float");
		if($arr[1][$loop] < 0){
			$arr[1][$loop] *= -1;
		}
	}

	$index100 = array_search(100, $arr[0]);
		$I100=$arr[1][$index100];

	$index150 = array_search(150, $arr[0]);
		$I150=$arr[1][$index150];

	if($I150>2E-6){
		$grade*=2;
	}
	if($I150/$I100>2){
		$grade*=3;
	}

	return $grade;
}

####Taken from php.net####
function human_filesize($bytes, $decimals=2){
	$sz = 'BKMGTP';
	$factor = floor((strlen($bytes)-1)/3);
	return sprintf("%.{$decimals}f", $bytes/pow(1024, $factor)) . @$sz[$factor];
}

####Pulls the breakdown and compliance from the most recently submitted 
function moduleMeasParams($modid){
	include('../../../Submission_p_secure_pages/connect.php');
	include('../functions/submitfunctions.php');

	$moddumped = dump("module_p", $modid);

	$sensid = $moddumped['assoc_sens'];

	$func = "SELECT breakdown, compliance FROM measurement_p WHERE part_ID=$sensid AND scan_type=\"IV\" ORDER BY time_created DESC";
	$output = mysql_query($func, $connection);
	$row = mysql_fetch_assoc($output);

	$params = array();
	$params[0] = $row['breakdown'];
	$params[1] = $row['compliance'];

	return $params;

}

function compareParams($comper, $limit, $param){

$overwrite=0;

switch($comper){
	case "=":
		if($param != $limit){
			$overwrite=1;}
		break;
	case ">":
		if($param <= $limit){
			$overwrite=1;}
		break;
	case "<":
		if($param >= $limit){
			$overwrite=1;}
		break;
	case "<=":
		if($param > $limit){
			$overwrite=1;}
		break;
	case ">=":
		if($param < $limit){
			$overwrite=1;}
		break;
	case "!=":
		if($param == $limit){
			$overwrite=1;}
		break;
	default:
		break;
}

	return $overwrite;
}

function hidepre($part, $opt){

	$hider = "";
	$cutoff = "\"2015-05-30\"";


	if(isset($_SESSION['hidepre']) && $_SESSION['hidepre']){

		if($opt == 1){ $hider .= " WHERE ";}
		if($opt == 2){ $hider .= " AND ";}

		if($part == "sensor"){
			$hider .="assoc_wafer IN (SELECT assoc_wafer FROM times_wafer_p WHERE received > ".$cutoff.")";
		}
		else{
			$hider .= "id IN (SELECT assoc_".strtolower($part)." FROM times_".$part."_p WHERE received > ".$cutoff.")";
		}
	}
	return $hider;
}
?>
