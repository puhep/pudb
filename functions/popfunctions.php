<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

function comparepop($formname){
	
	echo "<option value=\"=\"";
	if($_POST[$formname] == "="){ echo 'selected="selected"';}
	echo ">=</option>\n";
	
	echo "<option value=\">\"";
	if($_POST[$formname] == ">"){ echo 'selected="selected"';}
	echo ">></option>\n";
	
	echo "<option value=\"<\"";
	if($_POST[$formname] == "<"){ echo 'selected="selected"';}
	echo "><</option>\n";
	
	echo "<option value=\">=\"";
	if($_POST[$formname] == ">="){ echo 'selected="selected"';}
	echo ">>=</option>\n";
	
	echo "<option value=\"<=\"";
	if($_POST[$formname] == "<="){ echo 'selected="selected"';}
	echo "><=</option>\n";
	
	echo "<option value=\"!=\"";
	if($_POST[$formname] == "!="){ echo 'selected="selected"';}
	echo ">!=</option>\n";
}

function locpop($formname){
	
	echo "<option value=\"\"";
	echo "></option>\n";
	
	echo "<option value=\"CERN\"";
	if($_POST[$formname] == "CERN"){ echo 'selected="selected"';}
	echo ">CERN</option>\n";
	
	echo "<option value=\"Fermilab\"";
	if($_POST[$formname] == "Fermilab"){ echo 'selected="selected"';}
	echo ">Fermilab</option>\n";
	
	echo "<option value=\"Kansas\"";
	if($_POST[$formname] == "Kansas"){ echo 'selected="selected"';}
	echo ">Kansas</option>\n";
	
	echo "<option value=\"Nebraska\"";
	if($_POST[$formname] == "Nebraska"){ echo 'selected="selected"';}
	echo ">Nebraska</option>\n";
	
	echo "<option value=\"Purdue\"";
	if($_POST[$formname] == "Purdue"){ echo 'selected="selected"';}
	echo ">Purdue</option>\n";
	
	echo "<option value=\"UIC\"";
	if($_POST[$formname] == "UIC"){ echo 'selected="selected"';}
	echo ">UIC</option>\n";
}

function waferpop(){

include('../../../Submission_p_secure_pages/connect.php');
include('../function/curfunctions.php');

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
include('../function/curfunctions.php');

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
include('../function/curfunctions.php');

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
include('../function/curfunctions.php');

	$hide = hidepre("sensor",2);

	mysql_query('USE cmsfpix_u', $connection);
	$funcA = 'SELECT name,id FROM sensor_p WHERE assoc_wafer='.$wafer.$hide.' AND name LIKE \'WA_%\' ORDER BY name ASC';
	$funcL = 'SELECT name,id FROM sensor_p WHERE assoc_wafer='.$wafer.$hide.' AND name LIKE \'WL_%\' ORDER BY name ASC';
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
		echo "<a href=\"sensor.php?name=".$sensid."\">$sensid</a><br>";
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
include('../function/curfunctions.php');

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
include('../functions/curfunctions.php');

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
include('../functions/curfunctions.php');

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
include('../functions/curfunctions.php');

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
include('../functions/curfunctions.php');

	$hide = hidepre("module",2);

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT id FROM module_p WHERE has_ROC=\"1\"".$hide;

	$available = mysql_query($func,$connection);

	echo "<option value=\"NULL\">Select a module</option>\n";

	while($modrow = mysql_fetch_assoc($available)){
		$id = $modrow['id'];
		$name = findname("module_p", $id);
		echo "<option value=\"$id\">".$name."</option>\n";
	}
}
	
function availmodule($wafer){

include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');

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
include('../functions/curfunctions.php');

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
include('../functions/curfunctions.php');

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
include('../functions/curfunctions.php');

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

	echo "<option value=\"YHC69-1015\">YHC69-1015</option>\n";

}

function morewebLinkList($modid){
include('../functions/curfunctions.php');

	$doc = new DOMDocument();
	$doc->loadHTMLFile("/project/cmsfpix/.www/MoReWeb/Results/Overview.html");

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
			echo "<a href=\"../../MoReWeb/Results/$curlink\" target=\"blank_\">".$exploded[2]."</a>";
			echo "<br>";
			$found=1;
		}
	}
	if(!$found){
		echo "No MoReWeb results for this module";
	}
	echo "<br>";
}

?>
