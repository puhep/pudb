<?php

#ini_set('display_errors', 'On');
#error_reporting(E_ALL | E_STRICT);

function comparepop($comparator){
	
	echo "<option value=\"=\"";
	if($comparator == "="){ echo 'selected="selected"';}
	echo ">=</option>\n";
	
	echo "<option value=\">\"";
	if($comparator == ">"){ echo 'selected="selected"';}
	echo ">></option>\n";
	
	echo "<option value=\"<\"";
	if($comparator == "<"){ echo 'selected="selected"';}
	echo "><</option>\n";
	
	echo "<option value=\">=\"";
	if($comparator == ">="){ echo 'selected="selected"';}
	echo ">>=</option>\n";
	
	echo "<option value=\"<=\"";
	if($comparator == "<="){ echo 'selected="selected"';}
	echo "><=</option>\n";
	
	echo "<option value=\"!=\"";
	if($comparator == "!="){ echo 'selected="selected"';}
	echo ">!=</option>\n";
}

function locpop($loc){
	
	echo "<option value=\"\"";
	echo "></option>\n";
	
	echo "<option value=\"CERN\"";
	if($loc == "CERN"){ echo 'selected="selected"';}
	echo ">CERN</option>\n";
	
	echo "<option value=\"Cornell\"";
	if($loc == "Cornell"){ echo 'selected="selected"';}
	echo ">Cornell</option>\n";
	
	echo "<option value=\"Fermilab\"";
	if($loc == "Fermilab"){ echo 'selected="selected"';}
	echo ">Fermilab</option>\n";
	
	echo "<option value=\"KSU\"";
	if($loc == "KSU"){ echo 'selected="selected"';}
	echo ">KSU</option>\n";
	
	echo "<option value=\"KU\"";
	if($loc == "KU"){ echo 'selected="selected"';}
	echo ">KU</option>\n";
	
	echo "<option value=\"Nebraska\"";
	if($loc == "Nebraska"){ echo 'selected="selected"';}
	echo ">Nebraska</option>\n";
	
	echo "<option value=\"Purdue\"";
	if($loc == "Purdue"){ echo 'selected="selected"';}
	echo ">Purdue</option>\n";
	
	echo "<option value=\"UIC\"";
	if($loc == "UIC"){ echo 'selected="selected"';}
	echo ">UIC</option>\n";
}

function bonderpop(){

	echo "<option value=\"\"";
	echo "></option>\n";
	
	echo "<option value=\"FC150\"";
	#if($loc == "UIC"){ echo 'selected="selected"';}
	echo ">FC150</option>\n";

	echo "<option value=\"Datacon\"";
	#if($loc == "UIC"){ echo 'selected="selected"';}
	echo ">Datacon</option>\n";


}

function waferpop(){

include('../../../Submission_p_secure_pages/connect.php');
include_once('../functions/curfunctions.php');

	$hide = hidepre("wafer",1);

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT name,id FROM wafer_p".$hide." ORDER BY name ASC";

	$available = mysql_query($func,$connection);

	echo "<option value=\"NULL\">Select a wafer</option>\n";

	while($available && $waferrow = mysql_fetch_assoc($available)){
		$id = $waferrow['id'];
		$waferid = $waferrow['name'];
		echo "<option value=\"$id\">".$waferid."</option>\n";
	}	
}

function shippedwaferpop(){

include('../../../Submission_p_secure_pages/connect.php');
include_once('../functions/curfunctions.php');

	$hide = hidepre("wafer",2);

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT name,id FROM wafer_p WHERE assembly=5".$hide." ORDER BY name ASC";
	
	$available = mysql_query($func,$connection);

	echo "<option value=\"NULL\">Select a wafer</option>\n";

	while($waferrow = mysql_fetch_assoc($available)){
		$id = $waferrow['id'];
		$waferid = $waferrow['name'];
		echo "<option value=\"$id\">".$waferid."</option>\n";
	}	
}

function sensorpop($wafer){

include('../../../Submission_p_secure_pages/connect.php');
include_once('../functions/curfunctions.php');

	$hide = hidepre("sensor",2);

	mysql_query('USE cmsfpix_u', $connection);
	
	$func = 'SELECT name,id FROM sensor_p WHERE assoc_wafer='.$wafer.$hide.' ORDER BY name ASC';
	
	$available = mysql_query($func, $connection);

	echo "<option value=\"NULL\">Select a sensor</option>\n";

	while($sensrow = mysql_fetch_assoc($available)){
		$id = $sensrow['id'];
		$sensid = $sensrow['name'];
		echo "<option value=\"$id\">".$sensid."</option>\n";
	}	
}

function sensorlist($wafer){

include('../../../Submission_p_secure_pages/connect.php');
include_once('../functions/curfunctions.php');

	$hide = hidepre("sensor",2);

	mysql_query('USE cmsfpix_u', $connection);
	$funcA = 'SELECT name,id FROM sensor_p WHERE assoc_wafer='.$wafer.$hide.' AND name LIKE \'WA_%\' ORDER BY name ASC';
	$funcL = 'SELECT name,id FROM sensor_p WHERE assoc_wafer='.$wafer.$hide.' AND name LIKE \'WL_%\' ORDER BY name ASC';
	#$funcL = 'SELECT b.name as sensorname,b.id,c.name as modulename FROM wafer_p a, sensor_p b, module_p c WHERE b.assoc_wafer='.$wafer.$hide.' AND b.name LIKE \'WL_%\' AND a.id=b.assoc_wafer AND c.assembly>0 ORDER BY b.name ASC';
	$funcS = 'SELECT name,id FROM sensor_p WHERE assoc_wafer='.$wafer.$hide.' AND name LIKE \'WS_%\' ORDER BY name ASC';
	


	$availableA = mysql_query($funcA, $connection);
	$availableL = mysql_query($funcL, $connection);
	$availableS = mysql_query($funcS, $connection);

	echo "<table cellspacing=10>";
	echo "<tr valign=top>";

	echo "<td>";
	while($sensrow = mysql_fetch_assoc($availableA)){
		$id = $sensrow['id'];
		$sensid = $sensrow['name'];
		echo "<a href=\"sensor.php?name=".$sensid."\">$sensid</a><br>";
	}
	echo "</td>";

	echo "<td>";
	while($sensrow = mysql_fetch_assoc($availableL)){
		$id = $sensrow['id'];
		$sensid = $sensrow['name'];

		$modname = "";

		$modfunc = "SELECT id FROM module_p WHERE assembly>0 AND assoc_sens=".$id;
		$modout = mysql_query($modfunc, $connection);
		if($modrow = mysql_fetch_assoc($modout)){
			$modname = findname("module_p",$modrow['id']);
		}

		echo "<a href=\"sensor.php?name=".$sensid."\">$sensid</a>";
		if($modname != ""){
			echo "&nbsp;";
			echo "&nbsp;";
			echo "<a href=\"bbm.php?name=".$modname."\">($modname)</a>";
		}
		echo "<br>";
		
	}
	echo "</td>";

	echo "<td>";
	while($sensrow = mysql_fetch_assoc($availableS)){
		$id = $sensrow['id'];
		$sensid = $sensrow['name'];
		echo "<a href=\"sensor.php?name=".$sensid."\">$sensid</a><br>";
	}
	echo "</td>";

	echo "</tr>";
	echo "</table>";
	
}

function availsensor(){

include('../../../Submission_p_secure_pages/connect.php');
include_once('../functions/curfunctions.php');

	$hide = hidepre("wafer",1);

	mysql_query('USE cmsfpix_u', $connection);

	$waffunc = 'SELECT id from wafer_p".$hide." ORDER BY name';
	$output = mysql_query($waffunc, $connection);
	
	echo "<option value=\"NULL\">Select a sensor</option>\n";
	
	while($wafrow = mysql_fetch_assoc($output)){
		$wafer = $wafrow['id'];

		$func = 'SELECT name,id FROM sensor_p WHERE assoc_wafer LIKE '.$wafer.' AND module IS NULL';

		$available = mysql_query($func, $connection);

		while($sensrow = mysql_fetch_assoc($available)){
			$id = $sensrow['id'];
			$sensid = $sensrow['name'];
			echo "<option value=\"$id\">".$sensid."</option>\n";
		}	
	}	
}

function modulepop(){

include('../../../Submission_p_secure_pages/connect.php');
include_once('../functions/curfunctions.php');

	$hide = hidepre("module",1);

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT id FROM module_p".$hide;

	$available = mysql_query($func,$connection);

	echo "<option value=\"NULL\">Select a module</option>\n";

	while($modrow = mysql_fetch_assoc($available)){
		$id = $modrow['id'];
		$name = findname("module_p",$id);
		echo "<option value=\"$id\">".$name."</option>\n";
	}	
}

function receivedmodulepop(){

include('../../../Submission_p_secure_pages/connect.php');
include_once('../functions/curfunctions.php');

	$hide = hidepre("module",2);

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT id FROM module_p WHERE assembly>0".$hide;
	
	$available = mysql_query($func,$connection);

	echo "<option value=\"NULL\">Select a module</option>\n";

	while($modrow = mysql_fetch_assoc($available)){
		$id = $modrow['id'];
		$name = findname("module_p", $id);
		echo "<option value=\"$id\">".$name."</option>\n";
	}	
}

function modulepopnoroc(){

include('../../../Submission_p_secure_pages/connect.php');
include_once('../functions/curfunctions.php');

	$hide = hidepre("module",2);

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT id FROM module_p WHERE has_ROC=\"0\"".$hide;

	$available = mysql_query($func,$connection);

	echo "<option value=\"NULL\">Select a module</option>\n";

	while($modrow = mysql_fetch_assoc($available)){
		$id = $modrow['id'];
		$name = findname("module_p", $id);
		echo "<option value=\"$id\">".$name."</option>\n";
	}	
}

function modulepopwithroc(){

include('../../../Submission_p_secure_pages/connect.php');
include_once('../functions/curfunctions.php');
	$modules = array();
	$hide = hidepre("module",2);

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT name,name_hdi,id FROM module_p WHERE has_ROC=\"1\"".$hide;

	$available = mysql_query($func,$connection);

	echo "<option value=\"NULL\">Select a module</option>\n";
	$i=0;
	while($modrow = mysql_fetch_assoc($available)){
		$id = $modrow['id'];
		$name = findname("module_p", $id);
		$modules[$i] = $name;
		#echo "<option value=\"$id\">".$name."</option>\n";
		$i++;
	}
	sort($modules);
	for($x=0; $x<$i; $x++){
		  $id = findid("module_p",$modules[$x]);
		  echo "<option value=\"$id\">".$modules[$x]."</option>\n";	  
	}
}
	
function availmodule($wafer){

include('../../../Submission_p_secure_pages/connect.php');
include_once('../functions/curfunctions.php');

	$hide = hidepre("sensor",2);

	mysql_query('USE cmsfpix_u', $connection);

	$sensfunc = 'SELECT id from sensor_p WHERE assoc_wafer='.$wafer.$hide;
	$output = mysql_query($sensfunc, $connection);
	
	echo "<option value=\"NULL\">Select a module</option>\n";

	while($sensrow = mysql_fetch_assoc($output)){
		$sensor = $sensrow['id'];
	
		$func = 'SELECT name,id FROM module_p WHERE assoc_sens='.$sensor.' AND assembly=0';

		$available = mysql_query($func, $connection);

		while($modrow = mysql_fetch_assoc($available)){
			$id = $modrow['id'];
			$modid = $modrow['name'];
			echo "<option value=\"$id\">".$modid."</option>\n";
		}	
	}	
}

function hdipop(){

include('../../../Submission_p_secure_pages/connect.php');
include_once('../functions/curfunctions.php');

	$hide = hidepre("HDI",1);

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT name,id FROM HDI_p".$hide;

	$available = mysql_query($func,$connection);

	echo "<option value=\"NULL\">Select an HDI </option>\n";

	while($hdirow = mysql_fetch_assoc($available)){
		$id = $hdirow['id'];
		$hdiid = $hdirow['name'];
		echo "<option value=\"$id\">".$hdiid."</option>\n";
	}	
}

function availhdi(){

include('../../../Submission_p_secure_pages/connect.php');
include_once('../functions/curfunctions.php');

	$hide = hidepre("HDI",2);

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT name, id FROM HDI_p WHERE assembly=2".$hide;

	$available = mysql_query($func, $connection);

	echo "<option value=\"NULL\">Select an HDI</option>\n";

	while($hdirow = mysql_fetch_assoc($available)){
		$id = $hdirow['id'];
		$hdiid = $hdirow['name'];
		echo "<option value=\"$id\">".$hdiid."</option>\n";
	}	
	
}

function barehdi(){

include('../../../Submission_p_secure_pages/connect.php');
include_once('../functions/curfunctions.php');

	$hide = hidepre("HDI",2);

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT name, id FROM HDI_p WHERE assoc_tbm IS NULL".$hide;

	$available = mysql_query($func, $connection);

	echo "<option value=\"NULL\">Select an HDI</option>\n";

	while($hdirow = mysql_fetch_assoc($available)){
		$id = $hdirow['id'];
		$hdiid = $hdirow['name'];
		echo "<option value=\"$id\">".$hdiid."</option>\n";
	}	
	
}

function availtbm(){

include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT name, id FROM TBM_p WHERE assoc_hdi IS NULL";

	$available = mysql_query($func, $connection);

	echo "<option value=\"NULL\">None</option>\n";

	while($tbmrow = mysql_fetch_assoc($available)){
		$id = $tbmrow['id'];
		$tbmid = $tbmrow['name'];
		echo "<option value=\"$id\">".$tbmid."</option>\n";
	}	
	
}

function HDIbatchpop(){

include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT name FROM work_orders_p";

	$available = mysql_query($func, $connection);

	while($row = mysql_fetch_assoc($available)){
		$name = $row['name'];
		echo "<option value=\"$name\">".$name."</option>\n";
	}	
}

function morewebLinkList($modid){
include_once('../functions/curfunctions.php');

	$doc = new DOMDocument();
	
	libxml_use_internal_errors(true);
	$doc->loadHTMLFile("/project/cmsfpix/.www/MoReWeb/Results/Overview.html");
	libxml_use_internal_errors(false);


	$tags = $doc->getElementsByTagName('a');

	$found = 0;

	echo "<br>";
	echo "MoReWeb Results:<br>";

	foreach($tags as $tag){
		$curname = $tag->nodeValue;
		$curid = findid("module_p",$curname);
		$curlink = $tag->getAttribute('href');
		$exploded = explode('_',$curlink);
		
		if($curid == $modid){
			
			$fulllink = "../../MoReWeb/Results/".$curlink;

			echo "<a href=\"$fulllink\" target=\"blank_\">".$exploded[2]."</a>";
			echo "&nbsp;";
			echo "&nbsp;";
			echo "<a href=\"../submit/moreweboverwrite.php?name=$curname&link=$fulllink\">Write to database</a>";
			echo "<br>";
			$found=1;
		}
	}
	if(!$found){
		echo "No MoReWeb results for this module";
	}
	echo "<br>";
}

function postassembly_radio_pop($id, $active){

include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT assembly_post FROM module_p WHERE id=".$id;

	$output = mysql_query($func, $connection);
	$row = mysql_fetch_assoc($output);
	$PAval = $row['assembly_post'];

	$disabled = " DISABLED";

	$checker = " CHECKED";

	if($active == 1){
		$disabled = "";
	}

	if($PAval%2 == 0){ $checker = " CHECKED";}
	else{ $checker = "";}
	echo "Full Test at 17C <input name=\"PA[]\" value=\"2\" type=\"checkbox\"".$checker.$disabled.">";
	
	if($PAval%3 == 0){ $checker = " CHECKED";}
	else{ $checker = "";}
	echo "Full Test at -20C <input name=\"PA[]\" value=\"3\" type=\"checkbox\"".$checker.$disabled.">";
	
	if($PAval%5 == 0){ $checker = " CHECKED";}
	else{ $checker = "";}
	echo "X-ray Testing <input name=\"PA[]\" value=\"5\" type=\"checkbox\"".$checker.$disabled.">";
	
	if($PAval%7 == 0){ $checker = " CHECKED";}
	else{ $checker = "";}
	echo "Thermal Cycling <input name=\"PA[]\" value=\"7\" type=\"checkbox\"".$checker.$disabled.">";
	echo "<br>";
}

function postassembly_radio_show($PAval){

	if($PAval%2 == 0){ $checker = " CHECKED";}
	else{ $checker = "";}
	echo "Full Test at 17C <input name=\"PA[]\" value=\"2\" type=\"checkbox\"".$checker.">";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";

	if($PAval%3 == 0){ $checker = " CHECKED";}
	else{ $checker = "";}
	echo "Full Test at -20C <input name=\"PA[]\" value=\"3\" type=\"checkbox\"".$checker.">";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	
	if($PAval%5 == 0){ $checker = " CHECKED";}
	else{ $checker = "";}
	echo "X-ray Testing <input name=\"PA[]\" value=\"5\" type=\"checkbox\"".$checker.">";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	
	if($PAval%7 == 0){ $checker = " CHECKED";}
	else{ $checker = "";}
	echo "Thermal Cycling <input name=\"PA[]\" value=\"7\" type=\"checkbox\"".$checker.">";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "<br>";

}

function postassembly_radio_show_not($PAvaln){

	if($PAvaln%2 == 0){ $checker = " CHECKED";}
	else{ $checker = "";}
	echo "Full Test at 17C <input name=\"PAN[]\" value=\"2\" type=\"checkbox\"".$checker.">";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";

	if($PAvaln%3 == 0){ $checker = " CHECKED";}
	else{ $checker = "";}
	echo "Full Test at -20C <input name=\"PAN[]\" value=\"3\" type=\"checkbox\"".$checker.">";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	
	if($PAvaln%5 == 0){ $checker = " CHECKED";}
	else{ $checker = "";}
	echo "X-ray Testing <input name=\"PAN[]\" value=\"5\" type=\"checkbox\"".$checker.">";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	
	if($PAvaln%7 == 0){ $checker = " CHECKED";}
	else{ $checker = "";}
	echo "Thermal Cycling <input name=\"PAN[]\" value=\"7\" type=\"checkbox\"".$checker.">";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "&nbsp;";
	echo "<br>";

}

function rocpop($id){
	 include('../../../Submission_p_secure_pages/connect.php');
	 mysql_query('USE cmsfpix_u', $connection);
	 $func = "select name,id,position from ROC_p where assoc_module=$id order by position";
	 $out = mysql_query($func, $connection);

	 while($row = mysql_fetch_assoc($out)){
		$name = $row['name'];
		$rocid = $row['id'];
		if(strpos($name," ")){
			$name = substr($name,strpos($name," ")+1);
		}
		$position = $row['position'];
		echo "<option value=\"$rocid\">$position ($name)</option>\n";
	}
}

?>
