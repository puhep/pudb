<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');
include('../functions/editfunctions.php');


if(isset($_POST['submit']) && $_POST['ROC0']!=""){
	
	$j = 0;

	for($j=0;$j<16;$j++){

		$roctag = "ROC".$j;
		$sqlroc = mysql_real_escape_string($_POST[$roctag]);
		$func2 = "UPDATE ROC_p SET name=\"".$sqlroc."\" WHERE assoc_module=".$_POST['modules']." AND position=".$j;
		mysql_query('USE cmsfpix_u', $connection);
		if(!mysql_query($func2,$connection)){
			$gets = "?code=4";
			header("Location: ROCsubmit.php".$gets);
			exit();
			#break;
		}

	}

	$func3 = "UPDATE module_p SET has_ROC=\"1\" WHERE id=".$_POST['modules'];
	
	if(mysql_query($func3, $connection)){
		lastUpdate("module_p", $_POST['modules'], "User", "Added ROCs", "");
		$gets = "?code=1";
	}
	else{
		$gets = "?code=3";
	}

	header("Location: ROCsubmit.php".$gets);
	exit();

}
else{
	
	$gets = "?code=2";

	header("Location: ROCsubmit.php".$gets);

	exit();
}

?>
