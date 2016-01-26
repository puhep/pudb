<?php


### Displays the list of notes for a given part
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

### Displays the list of notes for the Full Test Summary page.
### The process is slightly different than curnotes
function curnotes_fnal($id){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT notes_fnal from module_p WHERE id=".$id;

	$output = mysql_query($func, $connection);
	$noterow = mysql_fetch_assoc($output);
	if($noterow['notes_fnal']!=""){
		echo "<br>";
		echo nl2br(stripslashes(stripslashes($noterow["notes_fnal"])));
	}
	else{
		echo "This part has no comments";
	}
}

### Displays the list of pictures and picture comments for a given part. Also works with "sidet_p".
function curpics($type, $id){

	$cwd = getcwd();
	$num = 0;

	echo "<table border=1 align=\"center\">";
	while(file_exists($cwd."/../../Submission_p/pics/".$type."/".$type.$id."pic".$num.".jpg")){
	
		echo "<tr>";

		$src = "../../Submission_p/pics/".$type."/".$type.$id."pic".$num.".jpg";
		$txt = "../../Submission_p/pics/".$type."/".$type.$id."pic".$num.".txt";
	
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

### Displays IV/CV graphs for a given part. Can be forced to generate graphs on the fly
### instead of loading the pre-generated pictures.
function curgraphs($sensorid, $scan, $level, $efficient){
	include('../../../Submission_p_secure_pages/connect.php');

	$imagefile = "../pics/graphs/".$level."_".$sensorid."_".$scan.".png";

	if(file_exists($imagefile) && $efficient){
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

### Displays "IV by Position" graphs
function curgraphs_pos_summary($level, $scan, $loc){

	#if(isset($_SESSION['hidepre']) && $_SESSION['hidepre']){
	#	$imagefile = "../pics/graphs/".$level."_".$loc."_".$scan.".png";
	#}
	#else{
	#	$imagefile = "../pics/graphs/".$level."_".$loc."_".$scan."_with_preproduction.png";
	#}

	#if(file_exists($imagefile)){
	#	echo "<a href=\"$imagefile\" target=\"_blank\"><img src=\"$imagefile\" width=\"710\" height=\"400\" /></a>";
	#}
	#else{

		echo "<a href=\"../graphing/positiongrapher.php?level=$level&scan=$scan&loc=$loc\" target=\"_blank\"><img src=\"../graphing/positiongrapher.php?level=$level&scan=$scan&loc=$loc\" width=\"710\" height=\"400\" /></a>";
	#}
}

### Displays difference graphs
### Pretty much depreciated
function curgraphs_diff_summary($level, $scan, $loc){

		echo "<a href=\"../graphing/diff_positiongrapher.php?level=$level&scan=$scan&loc=$loc\" target=\"_blank\"><img src=\"../graphing/diff_positiongrapher.php?level=$level&scan=$scan&loc=$loc\" width=\"710\" height=\"400\" /></a>";
}

### Displays the name of the part, bolded (usually used for the top of a page)
### For modules will display the HDI-based name if available
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

### Displays the name of the part's current location in the assembly process
function curstep($part, $assembly){

	$wafsteps = array("Received", "Inspected", "Tested", "Promoted", "Ready for Shipping", "Shipped");
	$modulesteps = array("Expected", "Recieved", "Inspected", "IV Tested", "Ready for HDI Assembly", "HDI Attached", "Wirebonded", "Encapsulated", "Tested (Post-Encapsulation)", "Thermally Cycled", "Tested (Post-Thermal Cycling)", "Ready for Shipping", "Shipped", "Ready for Mounting", "On Blade", "Rejected");
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

### Displays the table of ROCs on the given module. 
### Dead ROCs are given a red background, live ROCs are given a green background 
function currocs($module){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT name,is_dead,thickness from ROC_p WHERE assoc_module=\"$module\" AND position<=7 ORDER BY position ASC";
	$revfunc = "SELECT name,is_dead,thickness from ROC_p WHERE assoc_module=\"$module\" AND position>=8 ORDER BY position DESC";

	$output = mysql_query($func, $connection);
	$outputrev = mysql_query($revfunc, $connection);
	
	$out = mysql_fetch_assoc($output);
	echo "(".$out['thickness']."um):<br>";
	echo "<table border=0>";

	echo "<tr>";
	echo "<td>";

	echo "<table border=1>";
	for($i=0;$i<8;$i++){
		if($i==0){$rocrow = $out;}
		else{$rocrow = mysql_fetch_assoc($output);}
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
}

### Generates a comma-delimited string of ROCs on the given module.
function currocs_string($module){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT name,thickness from ROC_p WHERE assoc_module=\"$module\" ORDER BY position ASC";
	$output = mysql_query($func, $connection);

	$rocstring = "";

	while($row = mysql_fetch_assoc($output)){
		$name = $row['name'];
		if(strpos($name, " ") == false){}
		else{
			$first = substr($name, 0,strpos($name, " "));
			$second = substr($name, strpos($name," ")+1, strlen($name));
			$name = $first."-".$second;
		}
		if(strpos($rocstring, "um") == false){
			$rocstring .= $row['thickness']."um, ";
		}	
		if(strpos($name, '(') == false){
			$rocstring .= $name.", ";
		}
		else{ 
			$first = substr($name,0,strpos($name,'('));
			$second = substr($name,strpos($name,')')+1,strlen($name));
			$rocstring .= $first.$second.", ";
		}
	}

	return $rocstring;
}

### Displays a table of values for a given ROC parameter (badbumps_elec, deadpix, etc...)
function currocparams($module, $param){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT $param from ROC_p WHERE assoc_module=\"$module\" AND position<=7 ORDER BY position ASC";
	$revfunc = "SELECT $param from ROC_p WHERE assoc_module=\"$module\" AND position>=8 ORDER BY position DESC";

	$output = mysql_query($func, $connection);
	$outputrev = mysql_query($revfunc, $connection);

	echo "<table border=0>";
	
	echo "<tr>";
	echo "<td>".$param."</td>";
	echo "<td>";
	echo "</td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td>";

	echo "<table border=1>";
	for($i=0;$i<8;$i++){

		$rocrow = mysql_fetch_assoc($output);
		echo "<tr>";

		echo "<td>";
		echo "ROC".$i;
		echo "</td>";

		echo "<td style=\"height: 100%;\">";
	
		echo $rocrow[$param];

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
		echo "ROC".$i;
		echo "</td>";

		echo "<td>";
		echo $rocrowrev[$param];

		echo "</td>";

		echo "</tr>";
	}
	echo "</table>";

	echo "</td>";
	echo "</tr>";

	echo "</table>";
}

### Echoes a string of grades that are not A
### For each ROC, includes the number that contributed most to the grade (bad bumps, dead pix, etc)
function curgrades_string($id){
	include('../../../Submission_p_secure_pages/connect.php');
	include_once('../graphing/xmlgrapher_crit.php');
	$dumped = dump("module_p", $id);

	mysql_query('USE cmsfpix_u', $connection);
	
	$func = "SELECT badbumps_elec, deadpix from ROC_p WHERE assoc_module=".$id;
	$output = mysql_query($func, $connection);
	$rocgrades = "";
	$biggest_contributors = array();
	$ret = "";
	$i = 0;
	while($array = mysql_fetch_assoc($output)){
		if(is_null($array['badbumps_elec']) || is_null($array['deadpix']) ){
			$rocsnull = 1;
			break;
		}
		if(is_null($array['unaddressable'])){
			$array['unaddressable']=0;
		}
		if(is_null($array['unmaskable'])){
			$array['unmaskable']=0;
		}
		$totbad = $array['badbumps_elec'] + $array['deadpix'] + $array['unaddressable'] + $array['unmaskable'];
		if($totbad > 166){
			$rocgrades = $rocgrades."C";
		}
		else if($totbad > 41 && $totbad <= 166){
			$rocgrades = $rocgrades."B";
		}
		else if($totbad <= 41){
			$rocgrades = $rocgrades."A";
		}
		if($array['badbumps_elec'] > $array['deadpix'] and $array['badbumps_elec'] > $array['unaddressable'] and $array['badbumps_elec'] > $array['unmaskable']){
			$biggest_contributors[$i] = $array['badbumps_elec']." bad bumps";
		}
		else if(($array['deadpix'] > $array['badbumps_elec']) and ($array['deadpix'] > $array['unaddressable']) and ($array['deadpix'] > $array['unmaskable'])){
			$biggest_contributors[$i] = $array['deadpix']." dead pixels";
		}
		else if(($array['unaddressable'] > $array['badbumps_elec']) and ($array['unaddressable'] > $array['deadpix']) and ($array['unaddressable'] > $array['unmaskable'])){
			$biggest_contributors[$i] = $array['unaddressable']." unaddressable pixels";
		}
		else if(($array['unmaskable'] > $array['badbumps_elec']) and ($array['unmaskable'] > $array['deadpix']) and ($array['unmaskable'] > $array['unaddressable'])){
			$biggest_contributors[$i] = $array['unmaskable']." unmaskable pixels";
		}
		else{
			$biggest_contributors[] = "";
		}
		$i++;
	}
	if($rocsnull == 1){
		     $ret = $ret."ROCs: I <br>";
	}
	else{
	for($i=0; $i<16; $i++){
		  if($rocgrades[$i] != "A" && isset($rocgrades[$i])){
		  	$ret = $ret."ROC".$i.": Grade ".$rocgrades[$i]."; biggest contribution: ".$biggest_contributors[$i]."<br>";
		  }
		  elseif(!isset($rocgrades[$i])){
			#$ret = $ret."ROC".$i.": Grade not set <br>";
		  }
	}
	}
	$crit = xmlgrapher_crit_num($dumped['assoc_sens'], "IV", "module", 0);
	if($crit%25 == 0 || $crit%7 == 0){
		    $ret = $ret."IV: C <br>";
	}
	elseif($crit%5 == 0){
		   $ret = $ret."IV: B <br>";
	}
	if($ret == ""){
		$ret = "None <br>";
	}
	echo $ret;	 
}

### Evaluates a module and returns its grade
function curgrade($id){
	include_once('../graphing/xmlgrapher_crit.php');
	#include_once('../functions/curfunctions.php');
	$dumped = dump("module_p", $id);

	$crit = xmlgrapher_crit_num($dumped['assoc_sens'], "IV", "module", 0);

	$bumpcrit = badbumps_crit($id);

	if($bumpcrit == "" || $crit == 0){
		return "I";
	}

	if($crit%25 == 0 || $crit%7 == 0 || $bumpcrit == "C"){
		return "C";
	}
	if($crit%5 == 0 || $bumpcrit == "B"){
		return "B";
	}
	
	return "A";
	
}


### Evaluates a module and return's its grade based only on its number of bad bumps.
### Bad bumps include electrically bad, unaddressable, unmaskable, dead pixels
### Every ROC is assessed and the grade of the worst ROC is returned
function badbumps_crit($id){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);
	
	$func = "SELECT badbumps_elec, deadpix, unaddressable, unmaskable from ROC_p WHERE assoc_module=".$id;
	$output = mysql_query($func, $connection);
	$ret = "";
	while($array = mysql_fetch_assoc($output)){
		if(is_null($array['badbumps_elec']) || is_null($array['deadpix']) ){
			return "";
		}
		if(is_null($array['unaddressable'])){
			$array['unaddressable']=0;
		}
		if(is_null($array['unmaskable'])){
			$array['unmaskable']=0;
		}
		$totbad = $array['badbumps_elec'] + $array['deadpix'] + $array['unaddressable'] + $array['unmaskable'];
		if($totbad > 166){
			$ret = "C";
		}
		else if($totbad > 41 && $ret != "C"){
			$ret = "B";
		}
		else if($ret != "B" && $ret != "C"){
			$ret = "A";
		}
	}
		return $ret;
}

### Evaluates a module and return's its grade based only on its number of electrically bad bumps.
### Every ROC is assessed and the grade of the worst ROC is returned
function badbumps_elec_crit($id){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);
	
	$func = "SELECT badbumps_elec from ROC_p WHERE assoc_module=".$id;
	$output = mysql_query($func, $connection);
	$ret = "";
	while($array = mysql_fetch_assoc($output)){
		if(is_null($array['badbumps_elec']) ){
			return "";
		}
		$totbad = $array['badbumps_elec'];
		if($totbad > 166){
			$ret = "C";
		}
		else if($totbad > 41 && $ret != "C"){
			$ret = "B";
		}
		else if($ret != "B" && $ret != "C"){
			$ret = "A";
		}
	}
		return $ret;
}

### Evaluates a module and return's its grade based only on its number of bad pixels
### Bad pixels include unaddressable, unmaskable, dead pixels
### Every ROC is assessed and the grade of the worst ROC is returned
function badpix_crit($id){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);
	
	$func = "SELECT deadpix, unaddressable, unmaskable from ROC_p WHERE assoc_module=".$id;
	$output = mysql_query($func, $connection);
	$ret = "";
	while($array = mysql_fetch_assoc($output)){
		if(is_null($array['deadpix']) ){
			return "";
		}
		if(is_null($array['unaddressable'])){
			$array['unaddressable']=0;
		}
		if(is_null($array['unmaskable'])){
			$array['unmaskable']=0;
		}
		$totbad = $array['deadpix'] + $array['unaddressable'] + $array['unmaskable'];
		if($totbad > 166){
			$ret = "C";
		}
		else if($totbad > 41 && $ret != "C"){
			$ret = "B";
		}
		else if($ret != "B" && $ret != "C"){
			$ret = "A";
		}
	}
		return $ret;
}


### Returns the total number of electrically bad bumps on a module
function badbumps($id){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);
	$func = "SELECT badbumps_elec, deadpix from ROC_p WHERE assoc_module=".$id;
	$output = mysql_query($func, $connection);
	$totbad = 0;
	while($array = mysql_fetch_assoc($output)){
		     if(is_null($array['badbumps_elec'])){
			return "No Data";
		     }
		     $totbad += $array['badbumps_elec'];
		     
	}
	return $totbad;
}



### Returns the number of ROCs for a given module that are flagged as bad
function badrocs($id){
	include('../../../Submission_p_secure_pages/connect.php');
	
	mysql_query('USE cmsfpix_u', $connection);
	
	$func = "SELECT COUNT(position) FROM ROC_p WHERE assoc_module=\"$id\" AND is_dead=1";

	$output = mysql_query($func, $connection);
	$array = mysql_fetch_assoc($output);
	$count = $array['COUNT(position)'];

	return $count;
}

### Returns the "location" value of a given part 
function curloc($db, $id){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT location FROM $db WHERE id=\"$id\"";
	
	$output = mysql_query($func, $connection);
	$array = mysql_fetch_assoc($output);
	$loc = $array['location'];

	return $loc;
}

### Displays a link to the fedex.com tracking page for the given module
function curtrack($id){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);
	
	$func = "SELECT tracking_number from module_p WHERE tracking_number IS NOT NULL AND id=".$id;

	$output = mysql_query($func, $connection);
	if($row = mysql_fetch_assoc($output)){
		$track = $row['tracking_number'];
		if(strtolower($track) == "courier"){
			echo "Module transported by hand";
		}
		else if(is_numeric($track)){
			echo "<a target=\"_blank\" href=\"https://www.fedex.com/apps/fedextrack/?trknbr=".$track."\">Tracking Number: $track </a>";
		}
		else{
			echo "Tracking information: ".$track;
		}
	}

	return;
}

### Displays a block of text detailing the test parameters of a given module
### This includes per-roc values
function curtestparams($id, $edit=0){

	include_once("../functions/popfunctions.php");

	$dumped = dump("module_p", $id);

	$badrocs = badrocs($id);
	$badbumps = badbumps($id);
	if($badbumps == "No Data"){
		$percent_badbumps = "No Data";	    
	}
	else{
		$percent_badbumps = round($badbumps/(16*4160)*100,2)."%";	
	}
	
	echo "Number of Bad Rocs: ".$badrocs."<br>";
	
	#echo "Number of Dead Pixels: ".$dumped['deadpix']."<br>";
	#echo "Number of Unmaskable Pixels: ".$dumped['unmaskable_pix']."<br>";
	#echo "Number of Unaddressable Pixels: ".$dumped['unaddressable_pix']."<br>";
	#echo "Number of Bad Bump Bonds (Electrical): ".$dumped['badbumps_electrical']."<br>";
	#echo "Number of Bad Bump Bonds (Electrical): ".$badbumps."<br>";
	echo "Percent Bad Bump Bonds (Electrical): ".$percent_badbumps."<br>";
	#echo "Number of Bad Bump Bonds (Reverse Bias): ".$dumped['badbumps_reversebias']."<br>";
	#echo "Number of Bad Bump Bonds (X-Ray): ".$dumped['badbumps_xray']."<br>";

	$grade = curgrade($id);
	echo "Grade: ".$grade."<br>";
	if($grade != "A"){
		  echo "Grades that were not A: <br>";
		  curgrades_string($id);
		  #echo "<br>";
	}
	
	if($dumped['can_time']==1){
	echo "Timeable: Yes<br>";
	}
	elseif(is_null($dumped['can_time'])){
	echo "Timeable:<br>";
	}
	else{
	echo "Timeable: No<br>";
	}

	echo "RTD temperature during testing: ";
	if(!is_null($dumped['rtd_temp'])){ echo $dumped['rtd_temp']."C"; }
	else{ echo "Not Set"; }
	echo "<br>";
	
	if(is_null($dumped['tested_status'])){
		echo "Next Testing Step: Not Set<br>";
	}
	elseif(!is_null($dumped['tested_status']) && $dumped['tested_status'] != "Mounted" ){
		echo "Next Testing Step: ".$dumped['tested_status']."<br>";
	}
	elseif($dumped['tested_status'] == "Mounted"){
		echo "Module mounted on blade at position ".$dumped['pos_on_blade']."<br>";
	}
	echo "<br>";
	postassembly_radio_pop($id, $edit);
	echo "<br>";

	echo "<table border=0>";
	echo "<tr>";
	echo "<td>";
	#currocgrades($id);
	#echo "</td>";
	#echo "<td>";
	currocparams($id, "unaddressable");
	echo "</td>";
	echo "<td>";
	currocparams($id, "unmaskable");
	echo "</td>";
	echo "<td>";
	currocparams($id, "xray_slope");
	echo "</td>";
	echo "<td>";
	currocparams($id, "xray_offset");
	echo "</td>";
	echo "<td>";
	currocparams($id, "badbumps_elec");
	echo "</td>";
	echo "<td>";
	currocparams($id, "badbumps_xray");
	echo "</td>";
	echo "<td>";
	currocparams($id, "deadpix");
	echo "</td>";
	#echo "<td>";
	#curgraphs($dumped['assoc_sens'], "IV", "module");
	#echo "</td>";
	echo "<td>";
	echo "IV Criteria<br>";
	xmlgrapher_crit($dumped['assoc_sens'], "IV", "module");
	echo "</td>";
	echo "</tr>";
	echo "</table>";

	return;
}

### Returns the ID of a part given its name (for modules, either module name or HDI name will work)
function findid($db, $name){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$sqlname = mysql_real_escape_string($name);

	$func = "SELECT id FROM $db WHERE name=\"$sqlname\"";

	if($db == "module_p"){
		$func = "SELECT id FROM $db WHERE name=\"$sqlname\" OR name_hdi=\"$sqlname\"";
	}
	
	$output = mysql_query($func, $connection);
	$array = mysql_fetch_assoc($output);
	$id = $array['id'];

	return $id;
}

### Returns the name of a part, given its ID
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

### Returns the current assembly step of a module, given its id
function findmodassembly($id){
	include('../../../Submission_p_secure_pages/connect.php');
	mysql_query('USE cmsfpix_u', $connection);
	$func = "SELECT assembly FROM module_p  WHERE id=$id";
	$output = mysql_query($func, $connection);
	$array = mysql_fetch_assoc($output);
	$assembly = $array['assembly'];
	return $assembly;
}

### Returns the current post-assembly testing status, given its id
function findassembly_post($id){
	include('../../../Submission_p_secure_pages/connect.php');
	mysql_query('USE cmsfpix_u', $connection);
	$func = "SELECT assembly_post FROM module_p  WHERE id=$id";
	$output = mysql_query($func, $connection);
	$array = mysql_fetch_assoc($output);
	$assembly_post = $array['assembly_post'];
	return $assembly_post;
}

### Returns all the data in the table for a given part
### Not recommended to use often, but sometimes it's the most efficient way to do it
function dump($db, $id){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query("USE cmsfpix_u", $connection);

	$func = "SELECT * FROM $db WHERE id=$id";
	
	$output = mysql_query($func, $connection);
	$dump = mysql_fetch_assoc($output);
	return $dump;
}

### Entirely depreciated
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

### Returns an array of all of the parts that have anything to do with this part
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

### Displays the buttons and links needed to download IV/CV scan files
function xmlbuttongen($id, $scan, $level){
	include('../../../Submission_p_secure_pages/connect.php');

	$func = "SELECT id, part_type FROM measurement_p WHERE part_ID=\"$id\" AND scan_type=\"$scan\"";
	
	$id1=0;
	$id2=0;
	$id3=0;
	$id4=0;
	$id5=0;
	
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
		if($row['part_type'] == "fnal_17c"){
			$id5 = $row['id'];
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
	if($id5>0 && $level!="sensor"){
		echo "<form><input type=\"button\" value=\"Download FNAL (+17C) Module $scan Data\" onClick=\"window.location.href='../download/dbxmldl.php?id=$id4'\"></form>";
		echo "<a href=\"../download/dbcsvdl.php?id=$id5\" target=\"_blank\">Download as .txt</a>";
		echo "   ";
		echo "<a href=\"../download/XMLfiles.php?part=fnal&partid=$id&scan=$scan\" target=\"_blank\">More Files</a>";
	}
	if($id4>0 && $level!="sensor"){
		echo "<form><input type=\"button\" value=\"Download FNAL (-20C) Module $scan Data\" onClick=\"window.location.href='../download/dbxmldl.php?id=$id4'\"></form>";
		echo "<a href=\"../download/dbcsvdl.php?id=$id4\" target=\"_blank\">Download as .txt</a>";
		echo "   ";
		echo "<a href=\"../download/XMLfiles.php?part=fnal&partid=$id&scan=$scan\" target=\"_blank\">More Files</a>";
	}
}

### Displays the name of (and link to) the module associated to a given sensor or HDI
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

### Returns letter code for HDI batch
function batchCode($curbatch){
	include('../../../Submission_p_secure_pages/connect.php');
	
	$alphabet = array("A","B","C","D","E","F","G","Z","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

	$func = "SELECT id, name FROM work_orders_p";
	mysql_query('USE cmsfpix_u', $connection);

	$output = mysql_query($func, $connection);
	
	while($row = mysql_fetch_assoc($output)){

		if($row['name'] == $curbatch){

			return $alphabet[$row['id']-1];
		}

	}
}

### Depreciated
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

### Depreciated
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

### Depreciated
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

### Generates checkboxes for promoting sensors on wafer to modules
function promoteBoxes($id){
	include('../../../Submission_p_secure_pages/connect.php');
	mysql_query("USE cmsfpix_u", $connection);

	$func = "SELECT name, id FROM sensor_p WHERE assoc_wafer=$id AND name LIKE 'WL%'";

	$output = mysql_query($func, $connection);

	echo"<br>";

	while($row = mysql_fetch_assoc($output)){
		$sensid = $row['id'];
		$sensname = $row['name'];
		echo ($sensname."<input name=\"sens[]\" value=\"$sensid\" type=\"checkbox\" CHECKED>"); 
		echo "<br>";
	}
}

### Flags sensors for promotion
function sensorSetPromote($id){
	include('../../../Submission_p_secure_pages/connect.php');
	mysql_query("USE cmsfpix_u", $connection);

	$func = "UPDATE sensor_p SET promote=1 WHERE id=".$id;

	mysql_query($func, $connection);
}

### Generates modules based on sensors that were flagged for promotion
function promoteSensors($id){
	include('../../../Submission_p_secure_pages/connect.php');
	include_once('../functions/submitfunctions.php');
	mysql_query("USE cmsfpix_u", $connection);
	
	$func = "SELECT name,promote,id FROM sensor_p WHERE assoc_wafer=$id";

	$output = mysql_query($func, $connection);

	while($row = mysql_fetch_assoc($output)){
		if($row['promote']==1){
			moduleinfo($row['name']);		
		}
	}
}

### Checks to see if the session is by a logged-in user (or user at Purdue)
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

### Finds quality issues with a given IV scaN
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

###Found on internet###
function mean_and_dev($arr){
	$vals = array();
	if(is_array($arr)){
		$mean = array_sum($arr)/count($arr);
			$vals[0] = $mean;
		foreach($arr as $key => $num){$devs[$key] = pow($num - $mean, 2);}
		$stdev = sqrt(array_sum($devs) / (count($devs) - 1));
			$vals[1] = $stdev;
	}
	return $vals;
}

####Pulls the breakdown and compliance from the most recently submitted 
function moduleMeasParams($modid){
	include('../../../Submission_p_secure_pages/connect.php');
	include_once('../functions/submitfunctions.php');

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

### Possibly depreciated
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

### Returns a string that, when appended to a MySQL query, restricts the query to
### parts uploaded after a certain datE
function hidepre($part, $opt){

	$hider = "";
	$cutoff = "\"2015-09-01\"";


	if(!isset($_SESSION['hidepre']) || !($_SESSION['hidepre'])){

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
