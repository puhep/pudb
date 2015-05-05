<?php

function addcomment($db, $id, $new){

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

	$date = date('Y-m-d H:i:s');

	$newnotes = $oldnotes.$date."  ".$sqlnew."\n";

	$func2 = "UPDATE ".$db." SET notes=\"".$newnotes."\" WHERE id=".$id;
	
	if(!mysql_query($func2, $connection)){
		echo "An error has occurred and the comment has not been added";
	}
}

function connecttbm($hdi, $tbm){

	include('../../../Submission_p_secure_pages/connect.php');
	
	mysql_query('USE cmsfpix_u', $connection);

	$tbmfunc = "UPDATE TBM_p SET assoc_hdi=$hdi WHERE id=$tbm";
	$hdifunc = "UPDATE HDI_p SET assoc_tbm=$tbm WHERE id=$hdi";

	mysql_query($tbmfunc, $connection);
	mysql_query($hdifunc, $connection);
}

function changeloc($id, $newloc){
	include('../../../Submission_p_secure_pages/connect.php');
	
	mysql_query('USE cmsfpix_u', $connection);

	$func = "UPDATE module_p SET destination=\"$newloc\" WHERE id=$id";
	
	mysql_query($func, $connection);

}

function generateHDImodulename($modid){
	include('../../../Submission_p_secure_pages/connect.php');
	
	mysql_query('USE cmsfpix_u', $connection);
	
	include('curfunctions.php');

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

	if($batch === "YHC69" && $datecode === "1015"){
		$newname = $newname."A-";
	}

	$newname = $newname.$panel."-".$padpos;

	echo $newname;
	$func = "UPDATE module_p SET name_hdi=\"".$newname."\" WHERE id=".$modid;
	mysql_query($func, $connection);

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
			echo "An error has occurred and the changes have not been added to the database.";
			break;
		}
	}
}

?>
