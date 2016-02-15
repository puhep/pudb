<?php

function addcomment($db, $id, $new, $user="User"){

	include('../../../Submission_p_secure_pages/connect.php');

	$sqlnew = mysql_real_escape_string(addslashes($new));

	if($new == ""){
		return;
	}

	mysql_query('USE cmsfpix_u', $connection);

	$func1 = "SELECT notes from ".$db." WHERE id=".$id;
	$oldnotes = "";

	$output = mysql_query($func1, $connection);
	$noterow = mysql_fetch_assoc($output);
	$oldnotes = mysql_real_escape_string($noterow["notes"]);
	#echo "oldnotes: ".nl2br($oldnotes)."<br>";
	$date = date('Y-m-d H:i:s');

	$newnotes = $oldnotes.$date."  ".$sqlnew."\n";
	#echo $newnotes."<br>";
	$func2 = "UPDATE ".$db." SET notes=\"".$newnotes."\" WHERE id=".$id;
	#echo $func2;
	if(!mysql_query($func2, $connection)){
		echo "An error has occurred and the comment has not been added";
	}

	if($db == "module_p"){
		lastUpdate($db, $id, $user, "Comment", $new);
	}
}

function addcomment_fnal($id, $new, $user="User"){

	include('../../../Submission_p_secure_pages/connect.php');

	$sqlnew = mysql_real_escape_string(addslashes($new));

	if($new == ""){
		return;
	}

	mysql_query('USE cmsfpix_u', $connection);

	$func1 = "SELECT notes_fnal from module_p WHERE id=".$id;
	$oldnotes = "";

	$output = mysql_query($func1, $connection);
	$noterow = mysql_fetch_assoc($output);
	$oldnotes = mysql_real_escape_string($noterow["notes_fnal"]);

	$date = date('Y-m-d H:i:s');

	$newnotes = $oldnotes.$date."  ".$sqlnew."\n";

	$func2 = "UPDATE module_p SET notes_fnal=\"".$newnotes."\" WHERE id=".$id;
	
	if(!mysql_query($func2, $connection)){
		echo "An error has occurred and the comment has not been added";
	}

	lastUpdate("module_p", $id, $user, "FNAL Testing Comment", $new);
}

function connecttbm($hdi, $tbm){

	include('../../../Submission_p_secure_pages/connect.php');
	
	mysql_query('USE cmsfpix_u', $connection);

	$tbmfunc = "UPDATE TBM_p SET assoc_hdi=$hdi WHERE id=$tbm";
	$hdifunc = "UPDATE HDI_p SET assoc_tbm=$tbm WHERE id=$hdi";

	mysql_query($tbmfunc, $connection);
	mysql_query($hdifunc, $connection);
}

function changeloc($id, $newloc, $notes, $user){
	include('../../../Submission_p_secure_pages/connect.php');
	
	mysql_query('USE cmsfpix_u', $connection);

	$func = "UPDATE module_p SET destination=\"$newloc\" WHERE id=$id";
	
	mysql_query($func, $connection);

	$newlocnote = "Module moved to ".$newloc." by ".$user;
	addcomment("module_p", $id, $newlocnote);

	if($notes != ""){
		addcomment("module_p", $id, $notes);
	}

	lastUpdate("module_p", $id, $user, "Location Changed to ".$newloc, $notes);

}

function changebonder($id, $newbonder, $notes, $user){
	include('../../../Submission_p_secure_pages/connect.php');
	
	mysql_query('USE cmsfpix_u', $connection);

	$func = "UPDATE module_p SET bonder=\"$newbonder\" WHERE id=$id";
	
	mysql_query($func, $connection);

	$newbondernote = "Module bonder set to ".$newbonder." by ".$user;
	addcomment("module_p", $id, $newbondernote);

	if($notes != ""){
		addcomment("module_p", $id, $notes);
	}

	lastUpdate("module_p", $id, $user, "Bonder Changed to ".$newbonder, $notes);

}

function generateHDImodulename($modid){
	include('../../../Submission_p_secure_pages/connect.php');
	
	mysql_query('USE cmsfpix_u', $connection);
	
	include_once('curfunctions.php');

	$dumped = dump("module_p", $modid);
	
	$ispre = substr($dumped['name'], 5,1);;

	$newname = "";
	if($ispre == '9'){
		$newname = "P-";
	}
	else{
		$newname = "M-";
	}

	$hdiname = findname("HDI_p", $dumped['assoc_HDI']);
	
	$exploded = explode('-', $hdiname);

	$batch = $exploded[0];
	$datecode = $exploded[1];
	$panel = $exploded[2];
	$pos = $exploded[3];

	$padpos = str_pad($pos, 2, "0", STR_PAD_LEFT);

	$batchdate = $batch."-".$datecode;

	$newname .= batchCode($batchdate)."-";

	$newname = $newname.$panel."-".$padpos;

	#echo $newname;
	$func = "UPDATE module_p SET name_hdi=\"".$newname."\" WHERE id=".$modid;
	mysql_query($func, $connection);

	return $newname;

}

####Transpose 0 and 8; 15 and 7 ####
function spinROCs($id){
	include('../../../Submission_p_secure_pages/connect.php');
	
	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT name from ROC_p WHERE assoc_module=".$id." ORDER BY position";

	$output = mysql_query($func, $connection);

	$rocs = array();;
	$i=0;

	while($rocrow = mysql_fetch_assoc($output)){
		$rocs[$i] = $rocrow['name'];
		$i++;
	}

	for($j=0;$j<16;$j++){
		if($j < 8){
			$flipfunc = "UPDATE ROC_p SET name=\"".$rocs[$j]."\" WHERE assoc_module=".$id." AND position=".($j+8);
		}
		if($j >= 8){
			$flipfunc = "UPDATE ROC_p SET name=\"".$rocs[$j]."\" WHERE assoc_module=".$id." AND position=".($j-8);
		}

		if(!mysql_query($flipfunc, $connection)){
			echo "An error has occurred and the changes have not been added to the database.";
			break;
		}
	}

	lastUpdate("module_p", $id, "User", "ROCs spun", "");

}

####Transpose 0 and 15; 8 and 7 ####
function flipROCs($id){
	include('../../../Submission_p_secure_pages/connect.php');

	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT name from ROC_p WHERE assoc_module=".$id." ORDER BY position";

	$output = mysql_query($func, $connection);

	$rocs;
	$i=0;

	while($rocrow = mysql_fetch_assoc($output)){
		$rocs[$i] = $rocrow['name'];
		$i++;
	}

	for($j=0;$j<16;$j++){
			$flipfunc = "UPDATE ROC_p SET name=\"".$rocs[$j]."\" WHERE assoc_module=".$id." AND position=".(15-$j);

		if(!mysql_query($flipfunc, $connection)){
			#echo "An error has occurred and the changes have not been added to the database.";
			echo "<br>There was an error in flipROCs()<br>";
			break;
		}
	}

	lastUpdate("module_p", $id, "User", "ROCs flipped", "");

}

####Transpose 8 and 15####
function RTIROCs($id){
	include('../../../Submission_p_secure_pages/connect.php');
	
	mysql_query('USE cmsfpix_u', $connection);

	$func = "SELECT name from ROC_p WHERE assoc_module=".$id." ORDER BY position";

	$output = mysql_query($func, $connection);

	$rocs;
	$i=0;

	while($rocrow = mysql_fetch_assoc($output)){
		$rocs[$i] = $rocrow['name'];
		$i++;
	}

	for($j=8;$j<16;$j++){
			$flipfunc = "UPDATE ROC_p SET name=\"".$rocs[$j]."\" WHERE assoc_module=".$id." AND position=".(23-$j);

		if(!mysql_query($flipfunc, $connection)){
			#echo "An error has occurred and the changes have not been added to the database.";
			echo "<br> There was an error in RTIROCs()<br>";
			break;
		}
	}

	lastUpdate("module_p", $id, "User", "ROCs adjusted for RTI scheme", "");

}

function ROCThickness($id, $newTh){

	include('../../../Submission_p_secure_pages/connect.php');
	
	$func = "UPDATE ROC_p SET thickness=".$newTh." WHERE id=".$id;

	mysql_query('USE cmsfpix_u', $connection);
	mysql_query($func, $connection);

}

function lastUpdate($db, $id, $who, $what, $comments){
	include('../../../Submission_p_secure_pages/connect.php');

	$update = $what." by ".$who;

	mysql_query('USE cmsfpix_u', $connection);

	$func = "UPDATE ".$db." SET last_update=\"".$what."\", last_user=\"".$who."\", last_comment=\"".$comments."\" WHERE id=".$id;
	
	mysql_query($func, $connection);
}

?>
