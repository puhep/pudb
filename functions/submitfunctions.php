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

		echo("Wafer ".$htmlname." has been added to the database.<br>");
	}
	else{
		echo("An error has occurred and the data has not been added.<br>");
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
		echo("Sensor ".$htmlid." has been added to the database.<br>");
	}
	else{
		echo("An error has occurred and the data has not been added.<br>");
	}

}

function wafersensorinfo($wafname, $rec, $notes){
	include('../functions/curfunctions.php');

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
	#sensorinfo("WD_BR_".$wafname, "Diode automatically added to the database",$wafid);


}

### Submits a new IV or CV scan to the database
function measurement($id, $parttype, $scan, $notes, $file, $size, $name, $breakdown, $compliance){
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
include('../functions/editfunctions.php');
include('../graphing/xmlgrapher_writer.php');
include('../graphing/positiongrapher_writer.php');

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
		echo "The $scan measurement on sensor $sensorname has been added to the database.<br>";
		xmlgrapher_writer($id, $scan, $parttype);	
		positiongrapher_writer($parttype, $scan, $loc);	
	}
	else{
		echo("An error has occurred and the data has not been added.<br>");
	}
	
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
	
}

function batchfulltest($txtfile, $name, $size, $notes){
include("../../../Submission_p_secure_pages/connect.php");
include("../functions/curfunctions.php");

	ini_set('display_error', 'On');
	error_reporting(E_ALL | E_STRICT);

	$dir = "/project/cmsfpix/.www/Submission_p/tmp/tmptests/";

	#####Clear the tmp directory before putting in new files#####
	exec("rm $dir*");

	move_uploaded_file($txtfile, $dir.$name);

	chmod($dir.$name, 0777);

	$i = 0;

	if($handle = opendir($dir)){
		
		while(false !== ($entry=readdir($handle))){
		
			if(substr($entry, -3) == "xml"){

				$doc = simplexml_load_file($dir.$entry);
				
				########ALL ROCS##########
				$i = 0;
				while($doc->ROCS[$i]->NAME !=""){

					$name = $doc->ROCS[$i]->NAME;
					$id = findid("module_p", $name);
					
					$k = 0;
					while($doc->ROCS[$i]->ROC[$k]->POSITION !=""){

						mysql_query('USE cmsfpix_u', $connection);
					
						$pos = $doc->ROCS[$i]->ROC[$k]->POSITION;
						if(($status=$doc->ROCS[$i]->ROC[$k]->IS_DEAD)!=""){
							$func = "UPDATE ROC_p SET is_dead=\"".$status."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
							mysql_query($func, $connection);
							echo "ROC ".$pos." on ".$name." status updated<br>";
						}
						if(($offset=$doc->ROCS[$i]->ROC[$k]->XRAY_OFFSET)!=""){
							$func = "UPDATE ROC_p SET xray_offset=\"".$offset."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
							mysql_query($func, $connection);
							echo "ROC ".$pos." on ".$name." X-ray offset: ".$offset."<br>";
						}
						if(($slope=$doc->ROCS[$i]->ROC[$k]->XRAY_SLOPE)!=""){
							$func = "UPDATE ROC_p SET xray_slope=\"".$slope."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
							mysql_query($func, $connection);
							echo "ROC ".$pos." on ".$name." X-ray slope: ".$slope."<br>";
						}
				
					$k++;
					}
					lastUpdate("module_p", $id, "User", "Updated Fulltest Values", "");
				$i++;
				}


				$i=0;
				while($doc->TEST[$i]->NAME != ""){

					$name = $doc->TEST[$i]->NAME;
					$id = findid("module_p", $name);
					
							
					########DEAD ROCS##########
					$j = 0;
					while($doc->TEST[$i]->DEAD_ROCS->ROC[$j] != ""){

						$deadroc = $doc->TEST[$i]->DEAD_ROCS->ROC[$j];

						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE ROC_p SET is_dead=\"1\" WHERE assoc_module=\"".$id."\"  AND position=\"".$deadroc."\"";
						mysql_query($func, $connection);

						echo "Bad ROC on ".$name." at position ".$deadroc;
						echo "<br>";
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

						echo "Good ROC on ".$name." at position ".$liveroc;
						echo "<br>";
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

						echo "Dead pixels on ".$name.":  ".$deadpix;
						echo "<br>";
					}

					#####################

					########UNMASKABLE PIXELS#####
				
					$umpix = $doc->TEST[$i]->UNMASKABLE_PIX;
					if($umpix != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET unmaskable_pix=\"".$umpix."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "Unmaskable pixels on ".$name.":  ".$umpix;
						echo "<br>";
					}

					#####################

					########UNADDRESSABLE PIXELS#####
				
					$uapix = $doc->TEST[$i]->UNADDRESSABLE_PIX;
					if($uapix != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET unaddressable_pix=\"".$uapix."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "Unaddressable pixels on ".$name.":  ".$uapix;
						echo "<br>";
					}

					#####################

					#######BAD BUMPS ELECTRICAL#####

					$badbumps_ele = $doc->TEST[$i]->DEAD_BUMPS_ELEC;
					if($badbumps_ele != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET badbumps_electrical=\"".$badbumps_ele."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "Bad Bumps (Electrical) on ".$name.":  ".$badbumps_ele;
						echo "<br>";
					}

					####################

					#######BAD BUMPS REV BIAS#####

					$badbumps_rb = $doc->TEST[$i]->DEAD_BUMPS_REVBIAS;
					if($badbumps_rb != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET badbumps_reversebias=\"".$badbumps_rb."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "Bad Bumps (Reverse Bias) on ".$name.":  ".$badbumps_rb;
						echo "<br>";
					}

					####################

					#######BAD BUMPS XRAY#####

					$badbumps_xray = $doc->TEST[$i]->DEAD_BUMPS_XRAY;
					if($badbumps_xray != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET badbumps_xray=\"".$badbumps_xray."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "Bad Bumps (X-Ray) on ".$name.":  ".$badbumps_xray;
						echo "<br>";
					}

					####################

					#######XRAY SLOPE#####

					$xray_slope = $doc->TEST[$i]->XRAY_SLOPE;
					if($xray_slope != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET xray_slope=\"".$xray_slope."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "X-Ray Slope on ".$name.":  ".$xray_slope;
						echo "<br>";
					}

					####################
  
					#######XRAY OFFSET#####

					$xray_offset = $doc->TEST[$i]->XRAY_OFFSET;
					if($xray_offset != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET xray_offset=\"".$xray_offset."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "X-Ray Offset on ".$name.":  ".$xray_offset;
						echo "<br>";
					}

					####################
  
					#######GRADE##########


					$grade = $doc->TEST[$i]->GRADE;
					if($grade != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET grade=\"".$grade."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "Grade of ".$name.":  ".$grade;
						echo "<br>";

					}

					#####################

					##########TIMEABLE########

					$timeable = $doc->TEST[$i]->CAN_TIME;
					if($timeable != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET can_time=\"".$timeable."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "Can time ".$name.":  ".$timeable;
						echo "<br>";
					}

					#####################

					echo "Changes Submitted for ".$name."<br>";
					
					lastUpdate("module_p", $id, "User", "Updated Fulltest Values", "");
					$i++;
				}
			}
		}

	}

}

function bigbatch($zip, $name, $size, $notes){
include("../../../Submission_p_secure_pages/connect.php");
include("../functions/curfunctions.php");
include("../functions/editfunctions.php");

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

	chmod($dir.$name, 0777);

	exec("/usr/local/bin/unzip ../tmp/tmpbig/".$name." -d ../tmp/tmpbig");
	
	$i = 0;

	if($handle = opendir($dir)){
		
		while(false !== ($entry=readdir($handle))){
		
			if($entry == "master.xml"){

				$doc = simplexml_load_file($dir.$entry);

				########ALL ROCS##########
				$i = 0;
				while($doc->ROCS[$i]->NAME !=""){

					$name = $doc->ROCS[$i]->NAME;
					$id = findid("module_p", $name);
					
					$k = 0;
					while($doc->ROCS[$i]->ROC[$k]->POSITION !=""){

						mysql_query('USE cmsfpix_u', $connection);
					
						$pos = $doc->ROCS[$i]->ROC[$k]->POSITION;

						if(($status=$doc->ROCS[$i]->ROC[$k]->IS_DEAD)!=""){
							$func = "UPDATE ROC_p SET is_dead=\"".$status."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
							mysql_query($func, $connection);
						}
						if(($offset=$doc->ROCS[$i]->ROC[$k]->XRAY_OFFSET)!=""){
							$func = "UPDATE ROC_p SET xray_offset=\"".$offset."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
							mysql_query($func, $connection);
						}
						if(($slope=$doc->ROCS[$i]->ROC[$k]->XRAY_SLOPE)!=""){
							$func = "UPDATE ROC_p SET xray_slope=\"".$slope."\" WHERE assoc_module=\"".$id."\"  AND position=\"".$pos."\"";
							mysql_query($func, $connection);
						}
						echo "ROC ".$pos." on ".$name." has been updated";
					$k++;
					}
					lastUpdate("module_p", $id, "User", "Updated Fulltest Values", "");
				$i++;
				}

				$i=0;
				while($doc->TEST[$i]->NAME != ""){

					$name = $doc->TEST[$i]->NAME;
					$id = findid("module_p", $name);

					########DEAD ROCS##########
					$j = 0;
					while($doc->TEST[$i]->DEAD_ROCS->ROC[$j] != ""){

						$deadroc = $doc->TEST[$i]->DEAD_ROCS->ROC[$j];

						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE ROC_p SET is_dead=\"1\" WHERE assoc_module=\"".$id."\"  AND position=\"".$deadroc."\"";
						echo $func;
						mysql_query($func, $connection);

						echo "Bad ROC on ".$name." at position ".$deadroc;
						echo "<br>";
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

						echo "Good ROC on ".$name." at position ".$liveroc;
						echo "<br>";
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

						echo "Dead pixels on ".$name.":  ".$deadpix;
						echo "<br>";
					}

					#####################

					########UNMASKABLE PIXELS#####
				
					$umpix = $doc->TEST[$i]->UNMASKABLE_PIX;
					if($umpix != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET unmaskable_pix=\"".$umpix."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "Unmaskable pixels on ".$name.":  ".$umpix;
						echo "<br>";
					}

					#####################

					########UNADDRESSABLE PIXELS#####
				
					$uapix = $doc->TEST[$i]->UNADDRESSABLE_PIX;
					if($uapix != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET unaddressable_pix=\"".$uapix."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "Unaddressable pixels on ".$name.":  ".$uapix;
						echo "<br>";
					}

					#####################

					#######BAD BUMPS ELECTRICAL#####

					$badbumps_ele = $doc->TEST[$i]->DEAD_BUMPS_ELEC;
					if($badbumps_ele != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET badbumps_electrical=\"".$badbumps_ele."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "Bad Bumps (Electrical) on ".$name.":  ".$badbumps_ele;
						echo "<br>";
					}

					####################

					#######BAD BUMPS REV BIAS#####

					$badbumps_rb = $doc->TEST[$i]->DEAD_BUMPS_REVBIAS;
					if($badbumps_rb != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET badbumps_reversebias=\"".$badbumps_rb."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "Bad Bumps (Reverse Bias) on ".$name.":  ".$badbumps_rb;
						echo "<br>";
					}

					####################

					#######BAD BUMPS XRAY#####

					$badbumps_xray = $doc->TEST[$i]->DEAD_BUMPS_XRAY;
					if($badbumps_xray != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET badbumps_xray=\"".$badbumps_xray."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "Bad Bumps (X-Ray) on ".$name.":  ".$badbumps_xray;
						echo "<br>";
					}

					####################

					#######XRAY SLOPE#####

					$xray_slope = $doc->TEST[$i]->XRAY_SLOPE;
					if($xray_slope != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET xray_slope=\"".$xray_slope."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "X-Ray Slope on ".$name.":  ".$xray_slope;
						echo "<br>";
					}

					####################
  
					#######XRAY OFFSET#####

					$xray_offset = $doc->TEST[$i]->XRAY_OFFSET;
					if($xray_offset != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET xray_offset=\"".$xray_offset."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "X-Ray Offset on ".$name.":  ".$xray_offset;
						echo "<br>";
					}

					####################
  
					#######GRADE##########


					$grade = $doc->TEST[$i]->GRADE;
					if($grade != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET grade=\"".$grade."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "Grade of ".$name.":  ".$grade;
						echo "<br>";

					}
					#####################

					##########TIMEABLE########

					$timeable = $doc->TEST[$i]->CAN_TIME;
					if($timeable != ""){
						mysql_query('USE cmsfpix_u', $connection);

						$func = "UPDATE module_p SET can_time=\"".$timeable."\" WHERE id=\"".$id."\"";
						mysql_query($func, $connection);

						echo "Can time ".$name.":  ".$timeable;
						echo "<br>";
					}

					#####################

					lastUpdate("module_p", $id, "User", "Updated Fulltest Values", "");
					
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
					addpic($picfile, $dir.$picfile,$part, $id, $notes); 
					echo "Picture for ".$name." added to the database.<br>";
					$i++;
				}
				##########################

				#####IV/CV SCAN SUBMISSION####
				$i=0;
				while($doc->SCAN[$i]->NAME != ""){

					$name = $doc->SCAN[$i]->NAME;
					$modid = findid("module_p", $name);
					$dumped = dump("module_p", $id);
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

					$breakdown = $doc->SCAN[$i]->BREAKDOWN;
					$compliance = $doc->SCAN[$i]->COMPLIANCE;
	
					measurement($id, $level, $type, $notes, $content, filesize($dir.$file), $file, $breakdown, $compliance);

					lastUpdate("module_p", $modid, "User", "Fulltest IV/CV scan", $notes);
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

}


### Submits a new HDI to the database
function hdiinfo($name, $notes, $arrival, $loc){
include('../../../Submission_p_secure_pages/connect.php');

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

	$func;

		$func = "INSERT INTO HDI_p(notes, name, arrival, assembly, location) VALUES (\"$sqlnotes\", \"$sqlname\", \"$sqlarrival\", 0, \"$loc\")";

	mysql_query('USE cmsfpix_u' , $connection);

	if(mysql_query($func,$connection)){

		$id = mysql_insert_id();

		$timesfunc = "INSERT INTO times_HDI_p(received, assoc_hdi) VALUES (\"$date\", \"$id\")";
	
		mysql_query($timesfunc, $connection);	

		echo("HDI ".$htmlname." has been added to the database.<br>");
		
	}
	else{
		echo("An error has occurred and the data has not been added.<br>");
	}

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

		echo("TBM ".$htmlname." has been added to the database.<br>");
		
	}
	else{
		echo("An error has occurred and the data has not been added.<br>");
	}

}

### Submits a new module to the database
function moduleinfo($sensor){
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');
include('../functions/editfunctions.php');

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
		echo("An error has occurred and the data has not been added.<br>");
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
			echo("An error has occurred.<br>");
			break;
		}
	}



}

### Submits DAQ information to the database
### UNUSED AND LIKELY DEPRECIATED
### USING MOREWEB INSTEAD
function DAQinfo($module, $C0file, $C0size, $aPfile, $dPfile, $phfile, $sumfile, $SCDfile, $tPfile, $tP60file, $notes, $noise, $gain){

	include('../../../Submission_p_secure_pages/connect.php');
	include('../functions/curfunctions.php');

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
		echo "Parameters have been added to the database.<br>";
	}
	else{
		echo "An error has occurred and data has not been added.<br>";
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
  include("../functions/curfunctions.php");
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
	$steps = array("expected", "received","inspected", "IV_tested","ready_HDI", "HDI_attached", "wirebonded", "encapsulated","tested2","thermal_cycling","tested3","ready_ship", "shipped");
  	$func = "UPDATE times_module_p SET $steps[$assembly]=\"$date\" WHERE assoc_module=\"$id\"";
  }
  
  mysql_query($func, $connection);
}

function addpic($filename, $tmploc, $part, $id, $notes){
	include('../functions/editfunctions.php');

	$cwd = getcwd();
	$dir = "/project/cmsfpix/.www/Submission_p";
	
	$num = 0;

	while(file_exists($dir."/pics/".$part."/".$part.$id."pic".$num.".jpg")){
		$num++;
	}

	$newfilename = $part.$id."pic".$num;

	#move_uploaded_file($tmploc, $dir."/pics/".$part."/".$newfilename.".jpg");
	rename($tmploc, $dir."/pics/".$part."/".$newfilename.".jpg");
	$textfile = $dir."/pics/".$part."/".$newfilename.".txt";

	$fp = fopen($textfile, 'w');

	$date = date('Y-m-d H:i:s ');

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

function addconfig($filename, $tmploc, $part, $id){
include("../functions/editfunctions.php");

	$dir = "/project/cmsfpix/.www/Submission_p/module_config_files/";
	
	$id = findid("module_p", $part);

	if(!file_exists($dir.$id)){
		mkdir($dir.$id);
		chmod($dir.$id, 0777);
	}
	
	rename($tmploc, $dir.$id."/".$filename);
	chmod($dir.$id."/".$filename, 0777);
	
	echo "Config file for ".$part." added to the database.<br>";

	lastUpdate("module_p", $id, "User", "Config File Added", "");

}

function batchroc($xml, $name, $size, $location){
include("../../../Submission_p_secure_pages/connect.php");
include("../functions/curfunctions.php");
include("../functions/editfunctions.php");

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

					$delivered =$doc->Worksheet[0]->Table->Row[$i]->Cell[1]->Data;
					sscanf($delivered, "A%s", $strwafer);

					$wafer = intval($strwafer)+900;

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
						echo "Module ".$name." was already found in the database.";
						echo "<br>";
						continue;
					}

					$date = date('Y-m-d H:i:s');

					$notes = $date." Received\n";

					$func = "UPDATE module_p SET assembly=1, arrival=\"".$date."\", location=\"".$location."\", destination=\"".$location."\", has_ROC=\"1\", notes=\"".$notes."\" WHERE id=".$id;

					mysql_query("USE cmsfpix_u", $connection);
					if(mysql_query($func, $connection)){
						
						$timefunc = "INSERT INTO times_module_p(assoc_module, received) VALUES($id, \"$date\")";
						echo $timefunc;
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
					flipROCs($id); ####RTI handles the ROCS upside down ####
					echo "Module ".$name." added to the database";		
					echo "<br>";
					$i++;
					
					lastUpdate("module_p", $id, "User", "Batch Module Submit", "");

				}

			}	
		}	
	}	
}

function batchwafer($xml, $name, $size, $user, $loc){
include("../../../Submission_p_secure_pages/connect.php");
include("../functions/curfunctions.php");
include("../functions/editfunctions.php");

	ini_set('display_error', 'On');
	error_reporting(E_ALL | E_STRICT);

	$dir = "/project/cmsfpix/.www/Submission_p/tmp/tmpwafer/";
	$date = date('Y-m-d H:i:s');
	
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
	
				$i=0;


				while(strpos($doc->Worksheet[$i]->attributes('ss',TRUE)->Name,"") === false){
					
					
					if(strpos($doc->Worksheet[$i]->attributes('ss',TRUE)->Name,"B") === false){
						$i++;
						continue;
					}
					
					$wafnum = substr($doc->Worksheet[$i]->attributes('ss', TRUE)->Name, 1);
					$wafnum = str_pad($wafnum, 3, "0", STR_PAD_LEFT);
					echo $wafnum."<br>";

					#wafersensorinfo($wafnum, $date, "Wafer submitted automatically through batch submission");


					$k=0;
					for($j=0; $j<8; $j++){

						$sensnum = "WL_".$RTI2PDB[$j+1]."_".$wafnum;

						$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"true\"?>";
						$xml .= "<ROOT xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">";
						$xml .= "<HEADER>";
						$xml .= "<TYPE><EXTENSION_TABLE_NAME>UPGRADE_FPIX_SNSRWAFR_IV</EXTENSION_TABLE_NAME><NAME/>";
						$xml .= "<RUN><RUN_NAME/><RUN_BEGIN_TIMESTAMP>";
						$xml .= $date;
						$xml .= "</RUN_BEGIN_TIMESTAMP>";

						$xml .= "<INITIATED_BY_USER>".$user."</INITIATED_BY_USER>";
						$xml .= "<LOCATION>".$loc."</LOCATION>";
						$xml .= "<COMMENT_DESCRIPTION/></RUN></HEADER>";

						$xml .= "<DATA_SET><VERSION/><COMMENT_DESCRIPTION/>";
						$xml .= "<PART><SERIAL_NUMBER>".$sensnum."</SERIAL_NUMBER><KIND_OF_PART/></PART>";
						
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

						#measurement($sensid, "wafer", "IV", "Automatically uploaded through batch submission", $xml, strlen($xml), $sensnum."_IV.xml", 0, 0){
						
					}

				$i++;
				}

			}	
		}	
	}	
}

