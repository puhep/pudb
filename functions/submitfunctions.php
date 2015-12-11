<?php
### submitfunctions.php
### functions for inserting data into the database via MySQL commands


### Submits a new wafer to the database
function waferinfo($name, $rec, $notes){
include('../../../Submission_p_secure_pages/connect.php');

	$sqlname = mysql_real_escape_string($name);
	$sqlrec = mysql_real_escape_string($rec);
	$sqlnotes = addslashes(mysql_real_escape_string($notes));

	$htmlname = htmlspecialchars($name);

	$fthickness = 285;

	$date = date('Y-m-d H:i:s');

	if($sqlnotes != ""){
		$sqlnotes = $date."  ".$sqlnotes."\n";
	}

	$func = "INSERT INTO wafer_p(notes, name, vendor, thickness, arrival, assembly) VALUES (\"$sqlnotes\", \"$sqlname\", \"SINTEF\", \"$fthickness\", \"$sqlrec\", \"0\")";
	
	mysql_query('USE cmsfpix_u' , $connection);

	if(mysql_query($func,$connection)){

		$id = mysql_insert_id();

		$timesfunc = "INSERT INTO times_wafer_p(received, assoc_wafer) VALUES (\"$date\", \"$id\")";
	
		mysql_query($timesfunc, $connection);	

		#echo("Wafer ".$htmlname." has been added to the database.<br>");
	}
	else{
		#echo("An error has occurred and the data has not been added.<br>");
	}


}

### Submits a new sensor to the database
function sensorinfo($id, $notes, $wafer){
include('../../../Submission_p_secure_pages/connect.php');

	$sqlid = mysql_real_escape_string($id);
	$sqlnotes = mysql_real_escape_string($notes);
	$sqlwafer = mysql_real_escape_string($wafer);

	$htmlid = htmlspecialchars($id);

	$date = date('Y-m-d H:i:s');

	if($sqlnotes != ""){
		$sqlnotes = $date."  ".$sqlnotes."\n";
	}

	$func = "INSERT INTO sensor_p(notes, name, assoc_wafer, assembly) VALUES (\"$sqlnotes\", \"$sqlid\", \"$sqlwafer\", 0)";

	mysql_query('USE cmsfpix_u' , $connection);

	if(mysql_query($func,$connection)){
		#echo("Sensor ".$htmlid." has been added to the database.<br>");
	}
	else{
		#echo("An error has occurred and the data has not been added.<br>");
	}

}

function wafersensorinfo($wafname, $rec, $notes){
	include_once('../functions/curfunctions.php');

	waferinfo($wafname, $rec, $notes);

	$wafid = findid("wafer_p", $wafname);

	sensorinfo("WL_TT_".$wafname, "2x8 automatically added to the database",$wafid);
	sensorinfo("WL_FL_".$wafname, "2x8 automatically added to the database",$wafid);
	sensorinfo("WL_LL_".$wafname, "2x8 automatically added to the database",$wafid);
	sensorinfo("WL_CL_".$wafname, "2x8 automatically added to the database",$wafid);
	sensorinfo("WL_CR_".$wafname, "2x8 automatically added to the database",$wafid);
	sensorinfo("WL_RR_".$wafname, "2x8 automatically added to the database",$wafid);
	sensorinfo("WL_FR_".$wafname, "2x8 automatically added to the database",$wafid);
	sensorinfo("WL_BB_".$wafname, "2x8 automatically added to the database",$wafid);
	sensorinfo("WS_TR_".$wafname, "1x1 automatically added to the database",$wafid);
	sensorinfo("WS_CR_".$wafname, "1x1 automatically added to the database",$wafid);
	sensorinfo("WS_BR_".$wafname, "1x1 automatically added to the database",$wafid);
	sensorinfo("WS_TL_".$wafname, "1x1 automatically added to the database",$wafid);
	sensorinfo("WS_CL_".$wafname, "1x1 automatically added to the database",$wafid);
	sensorinfo("WS_BL_".$wafname, "1x1 automatically added to the database",$wafid);
	sensorinfo("WA_TL_".$wafname, "Slim-edge 1x1 automatically added to the database",$wafid);
	sensorinfo("WA_BL_".$wafname, "Slim-edge 1x1 automatically added to the database",$wafid);
	sensorinfo("WA_TR_".$wafname, "Slim-edge 1x1 automatically added to the database",$wafid);
	sensorinfo("WA_BR_".$wafname, "Slim-edge 1x1 automatically added to the database",$wafid);
	
	#sensorinfo("WD_TL_".$wafname, "Diode automatically added to the database",$wafid);
	#sensorinfo("WD_BL_".$wafname, "Diode automatically added to the database",$wafid);
	#sensorinfo("WD_TR_".$wafname, "Diode automatically added to the database",$wafid);


}

### Submits a new IV or CV scan to the database
function measurement($id, $parttype, $scan, $notes, $file, $size, $name, $breakdown, $compliance, $update_graphs=1){
include('../../../Submission_p_secure_pages/connect.php');
include_once('../functions/curfunctions.php');
include_once('../functions/editfunctions.php');
include_once('../graphing/xmlgrapher_writer.php');
include_once('../graphing/positiongrapher_writer.php');

	
	$sqlnotes = mysql_real_escape_string($notes);

	$sensordata = dump("sensor_p", $id);
	$sensorname = $sensordata['name'];
		$loc = substr($sensorname,3,2);

	$date = date('Y-m-d H:i:s');

	if($sqlnotes != ""){
		$sqlnotes = $date."  ".$sqlnotes."\n";
	}


	$func = "INSERT INTO measurement_p(part_ID, part_type, scan_type, notes, file, filesize, filename, breakdown, compliance) VALUES (\"$id\", \"$parttype\", \"$scan\", \"$sqlnotes\", \"$file\",\"$size\",\"$name\", $breakdown, $compliance)";
	
	mysql_query('USE cmsfpix_u', $connection);

	if(mysql_query($func,$connection)){
		#echo "The $scan measurement on sensor $sensorname has been added to the database.<br>";
		if($update_graphs == 1){
			xmlgrapher_writer($id, $scan, $parttype);	
			positiongrapher_writer($parttype, $scan, $loc);
		}	
	}
	else{
		#echo("An error has occurred and the data has not been added.<br>");
	}

	return;
	
}

### Submits a zip file of IV and CV scans to the database
### Must all be of the same level (on wafer, on module, etc)
function batchmeasurement($zipfile, $name, $size, $level, $notes){
include("../../../Submission_p_secure_pages/connect.php");

	$dir = "/project/cmsfpix/.www/Submission_p/tmp/tmpmeas/";

	#####Clear the tmp directory before putting in new files#####
	exec("rm $dir*");

	move_uploaded_file($zipfile, $dir.$name);

	chmod($dir.$name, 0777);

	exec("/usr/local/bin/unzip ../tmp/tmpmeas/".$name." -d ../tmp/tmpmeas");

	if($handle = opendir($dir)){
		
		while(false !== ($entry=readdir($handle))){
	
			$scan = "";
			$db = "";
			$namelen = 0;
		
			if(substr($entry, -3) == "xml"){

				$doc = simplexml_load_file($dir.$entry);
				
				if($doc->DATA_SET->DATA[0]->ACTV_CURRENT_AMP != ""){
					$scan = "IV";
				}
				if($doc->DATA_SET->DATA[0]->ACTV_CAP_FRD != ""){
					$scan = "CV";
				}
				if($scan == ""){
					continue;
				}

				$assoc_part_type = substr($doc->DATA_SET->PART->SERIAL_NUMBER, 0, 1);
				if($assoc_part_type == "M"){
					$namelen = 8;
					$db = "module_p";
				}
				if($assoc_part_type == "W"){
					$namelen = 9;
					$db = "sensor_p";
				}
				if($assoc_part_type == "B"){
					$namelen = 9;
					$db = "module_p";
				}


				$assoc_part_name = substr($doc->DATA_SET->PART->SERIAL_NUMBER, 0, $namelen);

				$assoc_part_id = findid($db, $assoc_part_name);

				if($assoc_part_type == "W"){
					$assoc_sens = $assoc_part_id;
				}
				if($assoc_part_type == "M"){
					$dumped = dump($db, $assoc_part_id);
					$assoc_sens = $dumped['assoc_sens'];
				}
				if($assoc_part_type == "B"){
					$dumped = dump($db, $assoc_part_id);
					$assoc_sens = $dumped['assoc_sens'];
				}

				$fp = fopen($dir.$entry, 'r');
				$content = fread($fp,filesize($dir.$entry));
				$content = addslashes($content);
				fclose($fp);
				
				measurement($assoc_sens, $level, $scan, $notes, $content, $size, $entry);
			}
				
		}
	closedir($handle);
	}

	exec("rm $dir*");

	return 1;
}

function batchfulltest($txtfile, $name, $size, $user){
include("../../../Submission_p_secure_pages/connect.php");
include_once("../functions/curfunctions.php");
include_once("../functions/editfunctions.php");

	#ini_set('display_error', 'On');
	#error_reporting(E_ALL | E_STRICT);

	$dir = "/project/cmsfpix/.www/Submission_p/tmp/tmptests/";

	#####Clear the tmp directory before putting in new files#####
	exec("rm $dir*");

	move_uploaded_file($txtfile, $dir.$name);

	chmod($dir.$name, 0777);

	$i = 0;

	if($handle = opendir($dir)){
		
		while(false !== ($entry=readdir($handle))){
		
			if(substr($entry, -3) == "xml"){

				if(!($doc = simplexml_load_file($dir.$entry))){
					return 3;
				}
				
				$i=0;
				while($doc->TEST[$i]->NAME != ""){

					$name = $doc->TEST[$i]->NAME;
					$id = findid("module_p", $name);
					
					########ALL ROCS##########
				
					for($k=0;$k<16;$k++){
						
						if(($pos = $doc->TEST[$i]->ROCS->ROC[$k]->POSITION) != ""){
							mysql_query('USE cmsfpix_u', $connection);
				
							if(($status=$doc->TEST[$i]->ROCS->ROC[$k]->IS_DEAD)!=""){
								$func = "UPDATE ROC_p SET is_dead=\"".$status."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
								mysql_query($func, $connection);
								#echo "ROC ".$pos." on ".$name." status updated<br>";
							}
							if(($unadd_roc=$doc->TEST[$i]->ROCS->ROC[$k]->UNADDRESSABLE_PIX)!=""){
								$func = "UPDATE ROC_p SET unaddressable=\"".$unadd_roc."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
								mysql_query($func, $connection);
							}
							if(($unmask_roc=$doc->TEST[$i]->ROCS->ROC[$k]->UNMASKABLE_PIX)!=""){
								$func = "UPDATE ROC_p SET unmaskable=\"".$unmask_roc."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
								mysql_query($func, $connection);
							}
							if(($offset=$doc->TEST[$i]->ROCS->ROC[$k]->XRAY_OFFSET)!=""){
								$func = "UPDATE ROC_p SET xray_offset=\"".$offset."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
								mysql_query($func, $connection);
								#echo "ROC ".$pos." on ".$name." X-ray offset: ".$offset."<br>";
							}
							if(($slope=$doc->TEST[$i]->ROCS->ROC[$k]->XRAY_SLOPE)!=""){
								$func = "UPDATE ROC_p SET xray_slope=\"".$slope."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
								mysql_query($func, $connection);
								#echo "ROC ".$pos." on ".$name." X-ray slope: ".$slope."<br>";
							}
							if(($bb_elec=$doc->TEST[$i]->ROCS->ROC[$k]->BADBUMPS_ELEC)!=""){
								$func = "UPDATE ROC_p SET badbumps_elec=\"".$bb_elec."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
								mysql_query($func, $connection);
								#echo "ROC ".$pos." on ".$name." Bad Bumps (Electrical): ".$bb_elec."<br>";
							}
							if(($bb_xray=$doc->TEST[$i]->ROCS->ROC[$k]->BADBUMPS_XRAY)!=""){
								$func = "UPDATE ROC_p SET badbumps_xray=\"".$bb_xray."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
								mysql_query($func, $connection);
								#echo "ROC ".$pos." on ".$name." Bad Bumps (X-Ray): ".$bb_xray."<br>";
							}
							if(($deadpix=$doc->TEST[$i]->ROCS->ROC[$k]->DEAD_PIX)!=""){
								$func = "UPDATE ROC_p SET deadpix=\"".$deadpix."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
								mysql_query($func, $connection);
								#echo "ROC ".$pos." on ".$name." Dead Pixels: ".$deadpix."<br>";
							}
						}
					}

					########DEAD ROCS##########
					$j = 0;
					while($doc->TEST[$i]->DEAD_ROCS->ROC[$j] != ""){

						$deadroc = $doc->TEST[$i]->DEAD_ROCS->ROC[$j];

						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE ROC_p SET is_dead=\"1\" WHERE assoc_module=\"".$id."\"  AND position=\"".$deadroc."\"";
						mysql_query($func, $connection);

						#echo "Bad ROC on ".$name." at position ".$deadroc;
						#echo "<br>";
						$j++;
					}

					#######################

					########LIVE ROCS##########
					$j = 0;
					while($doc->TEST[$i]->LIVE_ROCS->ROC[$j] != ""){

						$liveroc = $doc->TEST[$i]->LIVE_ROCS->ROC[$j];

						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE ROC_p SET is_dead=\"0\" WHERE assoc_module=\"".$id."\"  AND position=\"".$liveroc."\"";
						mysql_query($func, $connection);

						#echo "Good ROC on ".$name." at position ".$liveroc;
						#echo "<br>";
						$j++;
					}
					
					$badrocs = badrocs($id);

					mysql_query('USE cmsfpix_u', $connection);
					$func = "UPDATE module_p SET badrocs=\"".$badrocs."\" WHERE id=\"".$id."\"";
					mysql_query($func, $connection);

					#######################

					########DEAD PIXELS#####
				
					$deadpix = $doc->TEST[$i]->DEAD_PIX;
					if($deadpix != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET deadpix=\"".$deadpix."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "Dead pixels on ".$name.":  ".$deadpix;
						#echo "<br>";
					}

					#####################

					########UNMASKABLE PIXELS#####
				
					$umpix = $doc->TEST[$i]->UNMASKABLE_PIX;
					if($umpix != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET unmaskable_pix=\"".$umpix."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "Unmaskable pixels on ".$name.":  ".$umpix;
						#echo "<br>";
					}

					#####################

					########UNADDRESSABLE PIXELS#####
				
					$uapix = $doc->TEST[$i]->UNADDRESSABLE_PIX;
					if($uapix != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET unaddressable_pix=\"".$uapix."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "Unaddressable pixels on ".$name.":  ".$uapix;
						#echo "<br>";
					}

					#####################

					#######BAD BUMPS ELECTRICAL#####

					$badbumps_ele = $doc->TEST[$i]->DEAD_BUMPS_ELEC;
					if($badbumps_ele != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET badbumps_electrical=\"".$badbumps_ele."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "Bad Bumps (Electrical) on ".$name.":  ".$badbumps_ele;
						#echo "<br>";
					}

					####################

					#######BAD BUMPS REV BIAS#####

					$badbumps_rb = $doc->TEST[$i]->DEAD_BUMPS_REVBIAS;
					if($badbumps_rb != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET badbumps_reversebias=\"".$badbumps_rb."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "Bad Bumps (Reverse Bias) on ".$name.":  ".$badbumps_rb;
						#echo "<br>";
					}

					####################

					#######BAD BUMPS XRAY#####

					$badbumps_xray = $doc->TEST[$i]->DEAD_BUMPS_XRAY;
					if($badbumps_xray != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET badbumps_xray=\"".$badbumps_xray."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "Bad Bumps (X-Ray) on ".$name.":  ".$badbumps_xray;
						#echo "<br>";
					}

					####################

					#######XRAY SLOPE#####

					$xray_slope = $doc->TEST[$i]->XRAY_SLOPE;
					if($xray_slope != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET xray_slope=\"".$xray_slope."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "X-Ray Slope on ".$name.":  ".$xray_slope;
						#echo "<br>";
					}

					####################
  
					#######XRAY OFFSET#####

					$xray_offset = $doc->TEST[$i]->XRAY_OFFSET;
					if($xray_offset != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET xray_offset=\"".$xray_offset."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "X-Ray Offset on ".$name.":  ".$xray_offset;
						#echo "<br>";
					}

					####################
  
					#######GRADE##########


					$grade = $doc->TEST[$i]->GRADE;
					if($grade != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET grade=\"".$grade."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "Grade of ".$name.":  ".$grade;
						#echo "<br>";

					}

					#####################

					##########TIMEABLE########

					$timeable = $doc->TEST[$i]->CAN_TIME;
					if($timeable != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET can_time=\"".$timeable."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "Can time ".$name.":  ".$timeable;
						#echo "<br>";
					}

					#####################

					##########NOTES########

					$testnotes = $doc->TEST[$i]->NOTES;
					if($testnotes != ""){
						addcomment_fnal($id, $testnotes);
					}

					#####################

					#echo "Changes Submitted for ".$name."<br>";
					
					lastUpdate("module_p", $id, $user, "Updated Fulltest Values", "");
					$i++;
				}
			}
		}

	}
	return 1;
}

function bigbatch($zip, $name, $size, $user){
include("../../../Submission_p_secure_pages/connect.php");
include_once("../functions/curfunctions.php");
include_once("../functions/editfunctions.php");

	ini_set('display_error', 'On');
	error_reporting(E_ALL | E_STRICT);

	$dir = "/project/cmsfpix/.www/Submission_p/tmp/tmpbig/";

	#####Clear the tmp directory before putting in new files#####
	exec("rm $dir*");

	if(!file_exists($dir)){
		mkdir($dir);
		chmod($dir, 0777);
	}

	move_uploaded_file($zip, $dir.$name);

	#echo $dir.$name;

	chmod($dir.$name, 0777);

	if(substr($dir.$name,-3) != "zip"){
		return 5;
	}
	
	$out = array();
	$retval;

	exec("/usr/bin/unzip ../tmp/tmpbig/".$name." -d ../tmp/tmpbig",$out,$retval);
	
	#print_r($out);
	#print_r($retval);

	#return;

	$i = 0;

	if($handle = opendir($dir)){
		
		while(false !== ($entry=readdir($handle))){
		
			if($entry == "master.xml"){

				if(!($doc = simplexml_load_file($dir.$entry))){
					return 3;
				}

				$i=0;
				$time = $doc->TIME;
				while($doc->TEST[$i]->NAME != ""){

					$name = $doc->TEST[$i]->NAME;
					$id = findid("module_p", $name);

					########ALL ROCS##########
				
					for($k=0;$k<16;$k++){
						
						if(($pos = $doc->TEST[$i]->ROCS->ROC[$k]->POSITION) != ""){
							mysql_query('USE cmsfpix_u', $connection);
				
							if(($status=$doc->TEST[$i]->ROCS->ROC[$k]->IS_DEAD)!=""){
								$func = "UPDATE ROC_p SET is_dead=\"".$status."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
								mysql_query($func, $connection);
								#echo "ROC ".$pos." on ".$name." status updated<br>";
							}
							if(($unadd_roc=$doc->TEST[$i]->ROCS->ROC[$k]->UNADDRESSABLE_PIX)!=""){
								$func = "UPDATE ROC_p SET unaddressable=\"".$unadd_roc."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
								mysql_query($func, $connection);
							}
							if(($unmask_roc=$doc->TEST[$i]->ROCS->ROC[$k]->UNMASKABLE_PIX)!=""){
								$func = "UPDATE ROC_p SET unmaskable=\"".$unmask_roc."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
								mysql_query($func, $connection);
							}
							if(($offset=$doc->TEST[$i]->ROCS->ROC[$k]->XRAY_OFFSET)!=""){
								$func = "UPDATE ROC_p SET xray_offset=\"".$offset."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
								mysql_query($func, $connection);
								#echo "ROC ".$pos." on ".$name." X-ray offset: ".$offset."<br>";
							}
							if(($slope=$doc->TEST[$i]->ROCS->ROC[$k]->XRAY_SLOPE)!=""){
								$func = "UPDATE ROC_p SET xray_slope=\"".$slope."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
								mysql_query($func, $connection);
								#echo "ROC ".$pos." on ".$name." X-ray slope: ".$slope."<br>";
							}
							if(($bb_elec=$doc->TEST[$i]->ROCS->ROC[$k]->BADBUMPS_ELEC)!=""){
								$func = "UPDATE ROC_p SET badbumps_elec=\"".$bb_elec."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
								mysql_query($func, $connection);
								#echo "ROC ".$pos." on ".$name." Bad Bumps (Electrical): ".$bb_elec."<br>";
							}
							if(($bb_xray=$doc->TEST[$i]->ROCS->ROC[$k]->BADBUMPS_XRAY)!=""){
								$func = "UPDATE ROC_p SET badbumps_xray=\"".$bb_xray."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
								mysql_query($func, $connection);
								#echo "ROC ".$pos." on ".$name." Bad Bumps (X-Ray): ".$bb_xray."<br>";
							}
							if(($deadpix=$doc->TEST[$i]->ROCS->ROC[$k]->DEAD_PIX)!=""){
								$func = "UPDATE ROC_p SET deadpix=\"".$deadpix."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
								mysql_query($func, $connection);
								#echo "ROC ".$pos." on ".$name." Dead Pixels: ".$deadpix."<br>";
							}
						}
					}

					########DEAD ROCS##########
					$j = 0;
					while($doc->TEST[$i]->DEAD_ROCS->ROC[$j] != ""){

						$deadroc = $doc->TEST[$i]->DEAD_ROCS->ROC[$j];

						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE ROC_p SET is_dead=\"1\" WHERE assoc_module=\"".$id."\"  AND position=\"".$deadroc."\"";
						#echo $func;
						mysql_query($func, $connection);

						#echo "Bad ROC on ".$name." at position ".$deadroc;
						#echo "<br>";
						$j++;
					}

					#######################

					########LIVE ROCS##########
					$j = 0;
					while($doc->TEST[$i]->LIVE_ROCS->ROC[$j] != ""){

						$liveroc = $doc->TEST[$i]->LIVE_ROCS->ROC[$j];

						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE ROC_p SET is_dead=\"0\" WHERE assoc_module=\"".$id."\"  AND position=\"".$liveroc."\"";
						mysql_query($func, $connection);

						#echo "Good ROC on ".$name." at position ".$liveroc;
						#echo "<br>";
						$j++;
					}
					
					$badrocs = badrocs($id);

					mysql_query('USE cmsfpix_u', $connection);
					$func = "UPDATE module_p SET badrocs=\"".$badrocs."\" WHERE id=\"".$id."\"";
					mysql_query($func, $connection);

					#######################

					########DEAD PIXELS#####
				
					$deadpix = $doc->TEST[$i]->DEAD_PIX;
					if($deadpix != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET deadpix=\"".$deadpix."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "Dead pixels on ".$name.":  ".$deadpix;
						#echo "<br>";
					}

					#####################

					########UNMASKABLE PIXELS#####
				
					$umpix = $doc->TEST[$i]->UNMASKABLE_PIX;
					if($umpix != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET unmaskable_pix=\"".$umpix."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "Unmaskable pixels on ".$name.":  ".$umpix;
						#echo "<br>";
					}

					#####################

					########UNADDRESSABLE PIXELS#####
				
					$uapix = $doc->TEST[$i]->UNADDRESSABLE_PIX;
					if($uapix != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET unaddressable_pix=\"".$uapix."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "Unaddressable pixels on ".$name.":  ".$uapix;
						#echo "<br>";
					}

					#####################

					#######BAD BUMPS ELECTRICAL#####

					$badbumps_ele = $doc->TEST[$i]->DEAD_BUMPS_ELEC;
					if($badbumps_ele != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET badbumps_electrical=\"".$badbumps_ele."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "Bad Bumps (Electrical) on ".$name.":  ".$badbumps_ele;
						#echo "<br>";
					}

					####################

					#######BAD BUMPS REV BIAS#####

					$badbumps_rb = $doc->TEST[$i]->DEAD_BUMPS_REVBIAS;
					if($badbumps_rb != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET badbumps_reversebias=\"".$badbumps_rb."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "Bad Bumps (Reverse Bias) on ".$name.":  ".$badbumps_rb;
						#echo "<br>";
					}

					####################

					#######BAD BUMPS XRAY#####

					$badbumps_xray = $doc->TEST[$i]->DEAD_BUMPS_XRAY;
					if($badbumps_xray != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET badbumps_xray=\"".$badbumps_xray."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "Bad Bumps (X-Ray) on ".$name.":  ".$badbumps_xray;
						#echo "<br>";
					}

					####################

					#######XRAY SLOPE#####

					$xray_slope = $doc->TEST[$i]->XRAY_SLOPE;
					if($xray_slope != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET xray_slope=\"".$xray_slope."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "X-Ray Slope on ".$name.":  ".$xray_slope;
						#echo "<br>";
					}

					####################
  
					#######XRAY OFFSET#####

					$xray_offset = $doc->TEST[$i]->XRAY_OFFSET;
					if($xray_offset != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET xray_offset=\"".$xray_offset."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "X-Ray Offset on ".$name.":  ".$xray_offset;
						#echo "<br>";
					}

					####################
  
					#######GRADE##########


					$grade = $doc->TEST[$i]->GRADE;
					if($grade != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET grade=\"".$grade."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "Grade of ".$name.":  ".$grade;
						#echo "<br>";

					}
					#####################

					##########TIMEABLE########

					$timeable = $doc->TEST[$i]->CAN_TIME;
					if($timeable != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET can_time=\"".$timeable."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						#echo "Can time ".$name.":  ".$timeable;
						#echo "<br>";
					}

					#####################

					##########NOTES########

					$testnotes = $doc->TEST[$i]->NOTES;
					if($testnotes != ""){
						addcomment_fnal($id, $testnotes);
					}

					#####################

					lastUpdate("module_p", $id, $user, "Updated Fulltest Values", "");
					
					$i++;
				}


				####PICTURE SUBMISSION####
				$i=0;
				while($doc->PIC[$i]->NAME != ""){
					
					$part = $doc->PIC[$i]->PART;
					$name = $doc->PIC[$i]->NAME;
					if($part == "sidet_p"){
						$id = findid("module_p", $name);
					}
					else{
						$id = findid($part, $name);
					}
					
					$picfile = $doc->PIC[$i]->FILE;
					$notesfile = $doc->PIC[$i]->TXT;

					$notes = file_get_contents($dir.$notesfile);
					addpic($picfile, $dir.$picfile,$part, $id, $notes, $time); 
					
					#addpic($picfile, $dir.$picfile,$part, $id, $notes); 
					#echo "Picture for ".$name." added to the database.<br>";
					$i++;
				}
				##########################
				#####IV/CV SCAN SUBMISSION####
				$i=0;
				while($doc->SCAN[$i]->NAME != ""){

					$name = $doc->SCAN[$i]->NAME;
					$modid = findid("module_p", $name);
					$dumped = dump("module_p", $modid);
					$id = $dumped['assoc_sens'];

					$level = strtolower($doc->SCAN[$i]->LEVEL);
					$type = $doc->SCAN[$i]->TYPE;
								
					$file = $doc->SCAN[$i]->FILE;

					$notesfile = $doc->SCAN[$i]->TXT;
					$notes = file_get_contents($dir.$notesfile);

					$fp = fopen($dir.$file, 'r');
					$content = fread($fp,filesize($dir.$file));
					$content = addslashes($content);
					fclose($fp);

					$breakdown = 0;				
					$compliance = 0;

					if(isset($doc->SCAN[$i]->BREAKDOWN)){
						$breakdown = $doc->SCAN[$i]->BREAKDOWN;
						$breakdown = settype($breakdown, "float");
					}
					if(isset($doc->SCAN[$i]->COMPLIANCE)){
						$compliance = $doc->SCAN[$i]->COMPLIANCE;
						$compliance = settype($compliance, "float");
					}
					measurement($id, $level, $type, $notes, $content, filesize($dir.$file), $file, $breakdown, $compliance);

					lastUpdate("module_p", $modid, $user, "Fulltest IV/CV scan", $notes);
					$i++;
				}
				##########################

				#####CONFIG FILE SUBMISSION####
				$i=0;
				while($doc->CONFIG[$i]->NAME != ""){

					$name = $doc->CONFIG[$i]->NAME;
								
					$file = $doc->CONFIG[$i]->FILE;

					addconfig($file, $dir.$file, $name);

		
					$i++;
				}
				##########################

			}
		}

	}

	return 1;

}


### Submits a new HDI to the database
function hdiinfo($name, $notes, $arrival, $loc, $TBM_wafer=""){
include('../../../Submission_p_secure_pages/connect.php');
	$num = 0;
	$sqlname = mysql_real_escape_string($name);
	$sqlarrival = mysql_real_escape_string($arrival);
	$sqlnotes = mysql_real_escape_string($notes);

	$htmlname = htmlspecialchars($name);

	$date = date('Y-m-d H:i:s');

	if($sqlnotes != ""){
		$sqlnotes = $date."  ".$sqlnotes."\n";
	}

	$sqlnotes = $date."  Received\n".$sqlnotes;

	$assembly = 0;

	mysql_query('USE cmsfpix_u' , $connection);

	$func = "SELECT COUNT(name) FROM HDI_p WHERE name=\"$name\" ";
	$output = mysql_query($func, $connection);
	$array = mysql_fetch_assoc($output);
	$count = $array['COUNT(name)'];	
	
	$func2;
	$func2 = "INSERT INTO HDI_p(notes, name, arrival, assembly, location, TBM_wafer) VALUES (\"$sqlnotes\", \"$sqlname\", \"$sqlarrival\", 0, \"$loc\", \"$TBM_wafer\")";

	if ($count == 0){
	   if(mysql_query($func2,$connection)){

		    $id = mysql_insert_id();
		    if ($id!=0){
			    $timesfunc = "INSERT INTO times_HDI_p(received, assoc_hdi) VALUES (\"$date\", \"$id\")";

			    mysql_query($timesfunc, $connection);	
			    $num = 1;
			    #echo("HDI ".$htmlname." has been added to the database.<br>"); 
		    }

	    }
	    else{
		    #echo("An error has occurred and the data has not been added.<br>");
	    }
	}
	return $num;
}

### Submits a new TBM to the database
function tbminfo($name, $notes){
include('../../../Submission_p_secure_pages/connect.php');

	$sqlname = mysql_real_escape_string($name);
	#$sqlarrival = mysql_real_escape_string($arrival);
	$sqlnotes = mysql_real_escape_string($notes);

	$htmlname = htmlspecialchars($name);

	$date = date('Y-m-d H:i:s');

	if($sqlnotes != ""){
		$sqlnotes = $date."  ".$sqlnotes."\n";
	}

	$sqlnotes = $date."  Received\n".$sqlnotes;

	$func = "INSERT INTO TBM_p(notes, name, assembly) VALUES (\"$sqlnotes\", \"$sqlname\", 0)";

	mysql_query('USE cmsfpix_u' , $connection);

	if(mysql_query($func,$connection)){

		#$id = mysql_insert_id();

		#$timesfunc = "INSERT INTO times_TBM_p(received, assoc_tbm) VALUES (\"$date\", \"$id\")";
	
		#mysql_query($timesfunc, $connection);	

		#echo("TBM ".$htmlname." has been added to the database.<br>");
		
	}
	else{
		#echo("An error has occurred and the data has not been added.<br>");
	}

}

### Submits a new module to the database
function moduleinfo($sensor){
include('../../../Submission_p_secure_pages/connect.php');
include_once('../functions/curfunctions.php');
include_once('../functions/editfunctions.php');

	mysql_query('USE cmsfpix_u' , $connection);
	
	$date = date('Y-m-d H:i:s');

	$sensorid = findid("sensor_p", $sensor);
	
	$name = "B".substr($sensor,1);

	$func = "INSERT INTO module_p(name, assoc_sens, assembly) VALUES (\"$name\", \"$sensorid\", 0)";


	if(mysql_query($func,$connection)){
	
		$modid = findid("module_p", $name);	

		$func2 = "UPDATE sensor_p SET module=\"$modid\" WHERE id=\"$sensorid\"";
		mysql_query($func2, $connection);
		#echo("BBM ".$name." has been added to the database.<br>");

		lastUpdate("module_p", $modid, "User", "New Module (Not yet received)");
	}
	else{
		#echo("An error has occurred and the data has not been added.<br>");
	}

}

### Submits a new ROC to the database
function ROCinfo($module){
include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$date = date('Y-m-d H:i:s');

	$i = 0;

	for($i=0;$i<16;$i++){

	$func = "INSERT INTO ROC_p(assoc_module, position) VALUES (\"$module\", \"$i\")";

		if(!mysql_query($func,$connection)){
			#echo("An error has occurred.<br>");
			break;
		}
	}
}

function workorderinfo($neworder){
include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "INSERT INTO work_orders_p(name) VALUE(\"$neworder\")";

	mysql_query($func, $connection);

}

### Submits DAQ information to the database
### UNUSED AND LIKELY DEPRECIATED
### USING MOREWEB INSTEAD
function DAQinfo($module, $C0file, $C0size, $aPfile, $dPfile, $phfile, $sumfile, $SCDfile, $tPfile, $tP60file, $notes, $noise, $gain){

	include('../../../Submission_p_secure_pages/connect.php');
	include_once('../functions/curfunctions.php');

	$date = date('Y-m-d H:i:s');
	
	if($notes != ""){
		$notes = $date."  ".$notes."\n";
	}

	$fnoise = floatval($noise);
	$fgain = floatval($gain);

	$C0 = fopen($C0file, 'r');
	$C0content = fread($C0, filesize($C0file));
	$C0content = addslashes($C0content);

	$aP = fopen($aPfile, 'r');
	$apcontent = fread($aP, filesize($aPfile));
	$apcontent = addslashes($apcontent);
	
	$dP = fopen($dPfile, 'r');
	$dpcontent = fread($dP, filesize($dPfile));
	$dpcontent = addslashes($dpcontent);

	$ph = fopen($phfile, 'r');
	$phcontent = fread($ph, filesize($phfile));
	$phcontent = addslashes($phcontent);

	$sum = fopen($sumfile, 'r');
	$sumcontent = fread($sum, filesize($sumfile));
	$sumcontent = addslashes($sumcontent);

	$SCD = fopen($SCDfile, 'r');
	$SCDcontent = fread($SCD, filesize($SCDfile));
	$SCDcontent = addslashes($SCDcontent);

	$tP = fopen($tPfile, 'r');
	$tpcontent = fread($tP, filesize($tPfile));
	$tpcontent = addslashes($tpcontent);
	
	$tP60 = fopen($tP60file, 'r');
	$tp60content = fread($tP60, filesize($tP60file));
	$tp60content = addslashes($tp60content);

	$func = "INSERT INTO DAQ_p(assoc_module, C0, C0size, addressParameters, dacParameters, phCalibrationFitTan, summary, SCurveData, testParameters, trimParameters, notes, Noise, Gain) VALUES (\"$module\",\"$C0content\", \"$C0size\",\"$apcontent\", \"$dpcontent\", \"$phcontent\", \"$sumcontent\", \"$SCDcontent\", \"$tpcontent\", \"$tp60content\", \"$notes\", \"$fnoise\", \"$fgain\")";

	mysql_query('USE cmsfpix_u', $connection);

	if(mysql_query($func, $connection)){
		$dumped = dump("module_p",$module);
		if($dumped['assembly'] == 5){
			$modfunc = "UPDATE module_p SET assembly=6 WHERE id=$module";
			mysql_query($modfunc, $connection);
		}
		#echo "Parameters have been added to the database.<br>";
	}
	else{
		#echo "An error has occurred and data has not been added.<br>";
	} 

	fclose($C0);
	fclose($aP);
	fclose($dP);
	fclose($sum);
	fclose($ph);
	fclose($SCD);
	fclose($tP);
	fclose($tP60);
}

### Generates submit button if user is logged in
### Links to login page if user is only one page away from the main menu
function conditionalSubmit($link){
  include_once("../functions/curfunctions.php");
  if(isLoggedIn()){ 
      echo "<input name=\"submit\" id=\"submit\" value=\"SUBMIT\" type=\"submit\">";
  }
  else{
     $curURL = $_SERVER['REQUEST_URI'];
     
     if($link){
     	echo "<a href=\"../login.php?prev=$curURL\">Log in </a> to edit and submit";
     }
     else{
     	echo "Log in to edit and submit";
     }
  }

}

### Update a part's time table with the most recent assembly status update
function milestone($db, $id, $assembly){
  include("../../../Submission_p_secure_pages/connect.php");

  mysql_query("USE cmsfpix_u", $connection);
  
  $date = date('Y-m-d H:i:s');

  $func = "";

  $steps;

  if($db == "wafer_p"){
	$steps = array("received", "inspected", "tested", "promoted", "ready", "shipped");
  	$func = "UPDATE times_wafer_p SET $steps[$assembly]=\"$date\" WHERE assoc_wafer=\"$id\"";
  }
  if($db == "HDI_p"){
	$steps = array("received", "inspected", "ready", "on_module");
  	$func = "UPDATE times_HDI_p SET $steps[$assembly]=\"$date\" WHERE assoc_hdi=\"$id\"";
  }
  if($db == "module_p"){
	$steps = array("expected", "received","inspected", "IV_tested","ready_HDI", "HDI_attached", "wirebonded", "encapsulated","tested2","thermal_cycling","tested3","ready_ship", "shipped", "fnal_tested", "on_blade");
  	$func = "UPDATE times_module_p SET $steps[$assembly]=\"$date\" WHERE assoc_module=\"$id\"";
  }
  
  mysql_query($func, $connection);
}

function addpic($filename, $tmploc, $part, $id, $notes, $time=""){
	include_once('../functions/editfunctions.php');

	$cwd = getcwd();
	$dir = "/project/cmsfpix/.www/Submission_p";
	
	$num = 0;

	while(file_exists($dir."/pics/".$part."/".$part.$id."pic".$num.".jpg")){
		$num++;
	}

	$newfilename = $part.$id."pic".$num;

	#move_uploaded_file($tmploc, $dir."/pics/".$part."/".$newfilename.".jpg");
	copy($tmploc, $dir."/pics/".$part."/".$newfilename.".jpg");
	unlink($tmploc);
	$textfile = $dir."/pics/".$part."/".$newfilename.".txt";

	$fp = fopen($textfile, 'w');

	$date = "";
	if($time != "" && preg_match('/\d{4}-\d{2}-\d{2}( \d{2}:\d{2}:\d{2})?/', $time)){
		$date = $time." ";
	}
	else{
		$date = date('Y-m-d H:i:s ');
	}

	fwrite($fp, $date.$notes."\n");
	fclose($fp);

	if($part == "module_p"){
		lastUpdate($part, $id, "User", "New Picture", $notes);
	}
}

function batchpic($zipfile, $name, $part, $id){

	$dir = "/project/cmsfpix/.www/Submission_p/tmp/tmppic/";

	#####Clear the tmp directory before putting in new files#####
	exec("rm $dir*");

	move_uploaded_file($zipfile, $dir.$name);

	chmod($dir.$name, 0777);

	exec("/usr/local/bin/unzip ".$dir.$name." -d ".$dir, $out, $ret);

	if($handle = opendir($dir)){
		while(false !== ($entry=readdir($handle))){
			
			$notes = "";
			
			$filetype = substr($entry, -3);

			if($filetype === "jpg" || $filetype === "png" || $filetype === "gif"){

				$textfile = substr($entry, 0, strlen($entry)-3)."txt";
				if(file_get_contents($dir.$textfile)){
					$notes = file_get_contents($dir.$textfile);	
				}
				addpic($entry, $dir.$entry,$part, $id, $notes); 

			}

		}
	}
}

function addconfig($filename, $tmploc, $part, $id, $user="User"){
include_once("../functions/editfunctions.php");

	$dir = "/project/cmsfpix/.www/Submission_p/module_config_files/";
	
	###Not sure why this line is here, it seems to be redundant
	#$id = findid("module_p", $part);

	if(!file_exists($dir.$id)){
		mkdir($dir.$id);
		chmod($dir.$id, 0777);
	}
	
	rename($tmploc, $dir.$id."/".$filename);
	chmod($dir.$id."/".$filename, 0777);
	
	#echo "Config file for ".$part." added to the database.<br>";

	lastUpdate("module_p", $id, $user, "Config File Added", "");

}

function batchroc($xml, $name, $size, $location, $user, $notes, $bonder){
include("../../../Submission_p_secure_pages/connect.php");
include_once("../functions/curfunctions.php");
include_once("../functions/editfunctions.php");

	ini_set('display_error', 'On');
	error_reporting(E_ALL | E_STRICT);

	$dir = "/project/cmsfpix/.www/Submission_p/tmp/tmproc/";
	
	#####Clear the tmp directory before putting in new files#####
	exec("rm $dir*");

	move_uploaded_file($xml, $dir.$name);

	chmod($dir.$name, 0777);

	$i = 0;
	$RTI2PDB = array("","TT","FL","LL","CL","CR","RR","FR","BB");
	
	if($handle = opendir($dir)){
		
		while(false !== ($entry=readdir($handle))){
		
			if(substr($entry, -3) == "xml"){

				$doc = simplexml_load_file($dir.$entry);
	
				$i=1;

				while(strcmp($doc->Worksheet[0]->Table->Row[$i]->Cell[0]->Data,"") != 0){
					
					if($doc->Worksheet[0]->Table->Row[$i]->Cell[0]->Data != $location){
						$i++;
						continue;
					}

					$delivered = $doc->Worksheet[0]->Table->Row[$i]->Cell[1]->Data;
					#echo "delivered: ".$delivered."<br>";
					
					#sscanf($delivered, "C%s", $strwafer);
					### strings now have several different formats
					$strwafer = substr($delivered,1);
					#echo "strwafer: ".$strwafer."<br>";
					if($delivered[0] == "C"){
						$wafer = intval($strwafer)+100;
					}
					elseif($delivered[0] == "B"){
						$wafer = intval($strwafer)+000;	
					}
					elseif($delivered[0] == "D"){
						$wafer = intval($strwafer)+200;	
					}
					#$wafer = intval($strwafer)+100;
					#echo "wafer: ".$wafer."<br>";
					
					$rtimodule = $doc->Worksheet[0]->Table->Row[$i]->Cell[2]->Data;
					$pdbmodule = $RTI2PDB[intval($rtimodule)];

					$name =  "BL_".$pdbmodule."_".$wafer;
					$later_name =  "M_".$pdbmodule."_".$wafer;
					#echo "BL_".$pdbmodule."_".$wafer;
					#echo "<br>";

					$id = findid("module_p", $name);
					$later_id = findid("module_p", $later_name);

					$dump = dump("module_p", $id);
					$later_dump = dump("module_p", $later_id);
					if($dump['assembly'] > 0 || $later_dump['assembly'] > 0){
						$i++;
						#echo "Module ".$name." was already found in the database.";
						#echo "<br>";
						continue;
					}

					$date = date('Y-m-d H:i:s');

					$newnotes = $date." Received by ".$user."\n";
					if($notes != ""){
						$newnotes .= $date." ".$notes."\n";
					}

					$func = "UPDATE module_p SET assembly=1, arrival=\"".$date."\", location=\"".$location."\", bonder=\"".$bonder."\", destination=\"".$location."\", has_ROC=\"1\", notes=\"".$newnotes."\" WHERE id=".$id;

					mysql_query("USE cmsfpix_u", $connection);
					if(mysql_query($func, $connection)){
						
						$timefunc = "INSERT INTO times_module_p(assoc_module, received) VALUES($id, \"$date\")";
						#echo $timefunc;
						mysql_query($timefunc, $connection);
					}
					ROCinfo($id);

					for($j=1;$j<=16;$j++){

						$roc =$doc->Worksheet[0]->Table->Row[$i]->Cell[2+$j]->Data;

						$rocwafer =  $doc->Worksheet[0]->Table->Row[$i]->Cell[18+$j]->Data;

						$rocname = $rocwafer." ".$roc;


						$rocfunc = "UPDATE ROC_p SET name=\"".$rocname."\" WHERE assoc_module=".$id." AND position=".($j-1);	
						mysql_query($rocfunc, $connection);
					}
					RTIROCs($id); ####RTI's numbering scheme is different ####
					flipROCs($id); ####RTI's numbering scheme is different ####
					#echo "Module ".$name." added to the database";		
					#echo "<br>";
					$i++;
					
					lastUpdate("module_p", $id, $user, "Batch Module Submit", "");

				}

			}	
		}	
	}	
}

function batchHDI($xml, $name, $size, $location, $user, $notes, $arrival){
include("../../../Submission_p_secure_pages/connect.php");
include_once("../functions/curfunctions.php");
include_once("../functions/editfunctions.php");

	#ini_set('display_error', 'On');
	#error_reporting(E_ALL | E_STRICT);

	$dir = "/project/cmsfpix/.www/Submission_p/tmp/tmphdi/";
	
	#####Clear the tmp directory before putting in new files#####
	exec("rm $dir*");

	move_uploaded_file($xml, $dir.$name);

	chmod($dir.$name, 0777);

	$i = 0;
	
	if($handle = opendir($dir)){
		
		while(false !== ($entry=readdir($handle))){
		
			if(substr($entry, -3) == "xml"){

				$doc = simplexml_load_file($dir.$entry);
	
				$i=1;

				while(strcmp($doc->Worksheet[0]->Table->Row[$i]->Cell[0]->Data,"") != 0){
					
					if($doc->Worksheet[0]->Table->Row[$i]->Cell[0]->Data != $location){
						$i++;
						continue;
					}

					$wo =$doc->Worksheet[0]->Table->Row[$i]->Cell[1]->Data;
					$dc =$doc->Worksheet[0]->Table->Row[$i]->Cell[2]->Data;
					$panel =$doc->Worksheet[0]->Table->Row[$i]->Cell[3]->Data;
					$pos =$doc->Worksheet[0]->Table->Row[$i]->Cell[4]->Data;
					$TBM_wafer =$doc->Worksheet[0]->Table->Row[$i]->Cell[5]->Data;
					$name = $wo."-".$dc."-".$panel."-".$pos;

					$date = date('Y-m-d H:i:s');

					hdiinfo($name,$notes,$arrival,$location,$TBM_wafer);
					$i++;
				}
			}	
		}	
	}	
}

function batchwafer($xml, $name, $size, $user, $loc){
include("../../../Submission_p_secure_pages/connect.php");
include_once("../functions/curfunctions.php");
include_once("../functions/editfunctions.php");

	#ini_set('display_error', 'On');
	#error_reporting(E_ALL | E_STRICT);

	$dir = "/project/cmsfpix/.www/Submission_p/tmp/tmpwafer/";
	$date = date('Y-m-d H:i:s');
	
	#####Clear the tmp directory before putting in new files#####
	exec("rm $dir*");

	move_uploaded_file($xml, $dir.$name);

	chmod($dir.$name, 0777);

	$i = 0;
	$RTI2PDB = array("","TT","FL","LL","CL","CR","RR","FR","BB");
	$ALPHA2IND = array("B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");


	if($handle = opendir($dir)){
		
		while(false !== ($entry=readdir($handle))){
		
			if(substr($entry, -3) == "xml"){

				$doc = simplexml_load_file($dir.$entry);
	
				$i=0;


				while(strpos($doc->Worksheet[$i]->attributes('ss',TRUE)->Name,"") === false){
					
					if($doc->Worksheet[$i]->attributes('ss',TRUE)->Name == "Summary"){
						$i++;
						continue;
					}
					
					$batchlet = substr($doc->Worksheet[$i]->attributes('ss', TRUE)->Name,0, 1);
					$batchnum = array_search($batchlet, $ALPHA2IND);
					$wafnum = substr($doc->Worksheet[$i]->attributes('ss', TRUE)->Name, 1);
					$wafnum = str_pad($wafnum, 2, "0", STR_PAD_LEFT);
					$wafnum = $batchnum.$wafnum;

					if(findid("wafer_p",$wafnum) === NULL){
						wafersensorinfo($wafnum, $date, "Wafer submitted automatically through batch submission");
						$wafid = findid("wafer_p", $wafnum);
						###update assembly variable to shipped
						$funcassembly = "UPDATE wafer_p SET assembly=5 WHERE id=$wafid";
						mysql_query($funcassembly, $connection);
						###call setpromote() for each sensor in wafer; easier to do here
						$funcpromote = "UPDATE sensor_p SET promote=1 WHERE assoc_wafer=$wafid";
						mysql_query($funcpromote, $connection);
						###call promotesensors for the wafer
						promoteSensors($wafid);
					}
					#echo $wafnum."<br>";



					$k=0;
					for($j=0; $j<8; $j++){

						$sensnum = "WL_".$RTI2PDB[$j+1]."_".$wafnum;

						$xml = "";
						$xml .= "<?xml version=\"1.0\" ?>";
						$xml .= "<ROOT xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">";
						$xml .= "<HEADER>";
						$xml .= "<TYPE><EXTENSION_TABLE_NAME>UPGRADE_FPIX_SNSRWAFR_IV</EXTENSION_TABLE_NAME><NAME></NAME></TYPE>";
						$xml .= "<RUN><RUN_NAME></RUN_NAME><RUN_BEGIN_TIMESTAMP>";
						$xml .= $date;
						$xml .= "</RUN_BEGIN_TIMESTAMP>";

						$xml .= "<INITIATED_BY_USER>".$user."</INITIATED_BY_USER>";
						$xml .= "<LOCATION>".$loc."</LOCATION>";
						$xml .= "<COMMENT_DESCRIPTION></COMMENT_DESCRIPTION></RUN></HEADER>";

						$xml .= "<DATA_SET><VERSION></VERSION><COMMENT_DESCRIPTION></COMMENT_DESCRIPTION>";
						$xml .= "<PART><SERIAL_NUMBER>".$sensnum."</SERIAL_NUMBER><KIND_OF_PART></KIND_OF_PART></PART>";
						
						$l=0;
						while(!($doc->Worksheet[$i]->Table->Row[$k]->Cell[0]->Data->attributes('ss',TRUE)->Type == "Number")){
						$k++;
						}

						while($doc->Worksheet[$i]->Table->Row[$k]->Cell[0]->Data->attributes('ss',TRUE)->Type == "Number"){
							
							$gr = $doc->Worksheet[$i]->Table->Row[$k]->Cell[0]->Data;
							$actv = $doc->Worksheet[$i]->Table->Row[$k]->Cell[2]->Data;
							$vol = $doc->Worksheet[$i]->Table->Row[$k]->Cell[4]->Data;

							$xml .= "<DATA>";
							$xml .= "<VOLTAGE_VOLT>".$vol."</VOLTAGE_VOLT>";
							$xml .= "<ACTV_CURRENT_AMP>".$actv."</ACTV_CURRENT_AMP>";
							$xml .= "<GRD_CURRENT_AMP>".$gr."</GRD_CURRENT_AMP>";
							$xml .= "</DATA>";
							
						$k++;
						}

						$xml .= "</DATA_SET></ROOT>";
							
						$sensid = findid("sensor_p", $sensnum);

						#echo $sensid."<br>";
						measurement($sensid, "wafer", "IV", "Automatically uploaded through batch submission", addslashes($xml), strlen($xml), $sensnum."_IV.xml", 0, 0, 0);
						
					}

				$i++;
				}

			}	
		}	
	}	
}

function log2xml($log, $user, $loc, $partname){

	$timestamp = date("Y-m-d H:i:s", filemtime($log));

	$xmlstr = "";
	$xmlstr .= "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\" ?>";
	$xmlstr .= "<ROOT xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">";
	$xmlstr .= "<HEADER><TYPE>";
	$xmlstr .= "<EXTENSION_TABLE_NAME>UPGRADE_FPIX_SNSRWAFR_IV</EXTENSION_TABLE_NAME>";
	$xmlstr .= "<NAME></NAME></TYPE>";
	$xmlstr .= "<RUN><RUN_NAME></RUN_NAME>";
	$xmlstr .= "<RUN_BEGIN_TIMESTAMP>".$timestamp."</RUN_BEGIN_TIMESTAMP>";
	$xmlstr .= "<INITIATED_BY_USER>".$user."</INITIATED_BY_USER>";
	$xmlstr .= "<LOCATION>".$loc."</LOCATION>";
	$xmlstr .= "<COMMENT_DESCRIPTION></COMMENT_DESCRIPTION></RUN></HEADER>";
	
	$xmlstr .= "<DATA_SET><VERSION></VERSION><COMMENT_DESCRIPTION></COMMENT_DESCRIPTION>";
	$xmlstr .= "<PART><SERIAL_NUMBER>".$partname."</SERIAL_NUMBER>";
	$xmlstr .= "<KIND_OF_PART></KIND_OF_PART></PART>";

	$fp = fopen($log, 'r');
	$content = "";
	if($fp){
		while(($line = fgets($fp)) !== false){

			if($line{0} == "#" || $line == ""){
				continue;
			}
			$linearr = preg_split("/[ \t]+/", $line, -1, PREG_SPLIT_NO_EMPTY);
			if(!is_numeric($linearr[0])){
				continue;
			}
			$voltage = $linearr[0];
			$current = $linearr[1];

			$xmlstr .= "<DATA>";
			$xmlstr .= "<VOLTAGE_VOLT>".$voltage."</VOLTAGE_VOLT>";
			$xmlstr .= "<TOT_CURRENT_AMP>".$current."</TOT_CURRENT_AMP>";
			$xmlstr .= "</DATA>";
		}
	}

	$xmlstr .= "</DATA_SET></ROOT>";
	fclose($fp);

	return addslashes($xmlstr);

}

function moreweb2database($id, $link){
include("../../../Submission_p_secure_pages/connect.php");
#include("../../Submission_p_secure_pages/connect.php");

	mysql_query('USE cmsfpix_u', $connection);

	$predoc = new DOMDocument();
	
	libxml_use_internal_errors(true);
	$predoc->loadHTMLFile($link);
	libxml_use_internal_errors(false);

	$nextpage;

	$tags = $predoc->getElementsByTagName('a');
	foreach($tags as $tag){
		if(strpos($tag->getAttribute('href'), "/QualificationGroup/")){
			$nextpage = $tag->getAttribute('href');		
		}
	}

	$prepage = substr($link,0,-15).substr($nextpage,22, -15);


	$i=0;
	$doc = new DOMDocument();

	$deadpix_arr = array();
	$unmaskable_arr = array();
	$unmaskable_tot = 0;
	$unaddressable_arr = array();
	$unaddressable_tot = 0;
	$badbumps_arr = array();

	for($i=0;$i<16;$i++){

		$page = $prepage."Chips/Chip".$i."/TestResult.html";


		libxml_use_internal_errors(true);
		$doc->loadHTMLFile($page);
		libxml_use_internal_errors(false);
	
		$xpath = new DOMXpath($doc);

		$deadpix = $xpath->query("/html/body/div/div[3]/div/div/div[4]/div[8]/div/div[3]/div[1]/table/tbody/tr[2]/td[3]");
		$badmask = $xpath->query("/html/body/div/div[3]/div/div/div[4]/div[8]/div/div[3]/div[1]/table/tbody/tr[3]/td[3]");
		$badaddress = $xpath->query("/html/body/div/div[3]/div/div/div[4]/div[8]/div/div[3]/div[1]/table/tbody/tr[6]/td[3]");
		$badbumps = $xpath->query("/html/body/div/div[3]/div/div/div[4]/div[8]/div/div[3]/div[1]/table/tbody/tr[4]/td[3]");

		$deadpix_arr[$i] = $deadpix->item(0)->nodeValue;
	
		$unmaskable_arr[$i] = $badmask->item(0)->nodeValue;
		$unmaskable_tot += $badmask->item(0)->nodeValue;
	
		$unaddressable_arr[$i] = $badaddress->item(0)->nodeValue;
		$unaddressable_tot += $badaddress->item(0)->nodeValue;
	
		$badbumps_arr[$i] = $badbumps->item(0)->nodeValue;
	}
	
	/*
	echo "Dead Pixels: ";
	print_r($deadpix_arr);
	echo "<br>";

	echo "Unmaskable Pixels: ";
	print_r($unmaskable_arr);
	echo "<br>";

	echo "Unaddressable Pixels: ";
	print_r($unaddressable_arr);
	echo "<br>";

	echo "Bad Bumps: ";
	print_r($badbumps_arr);
	echo "<br>";
	*/


	for($j=0;$j<16;$j++){

		$func1 = "UPDATE ROC_p SET deadpix=".$deadpix_arr[$j]." WHERE assoc_module=".$id." AND position=".$j;
		$func2 = "UPDATE ROC_p SET badbumps_elec=".$badbumps_arr[$j]." WHERE assoc_module=".$id." AND position=".$j;

		mysql_query($func1, $connection);
		
		mysql_query($func2, $connection);
	}

	$func3 = "UPDATE module_p SET unmaskable_pix=".$unmaskable_tot.", unaddressable_pix=".$unaddressable_tot." WHERE id=".$id;

	mysql_query($func3, $connection);
	
}
