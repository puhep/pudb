<?php
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');

if(isset($_POST['submit']) && $_POST['user'] != "" && $_FILES['zip']['size'] > 0){

	$errcode = 4;

	#$errcode = bigbatch($_FILES['zip']['tmp_name'],$_FILES['zip']['name'],$_FILES['zip']['size'], $_POST['user']);
	
	$bgproc = popen('php /project/cmsfpix/.www/Submission_p/submit/batchallsubmit_bg.php', 'w');

	if($bgproc===false){
		$errcode = 4;
	}
	else{
		$errcode = 1;	
		$p1 = serialize($_POST['user']);
		$p2 = serialize($_FILES['zip']['tmp_name']);
		$p3 = serialize($_FILES['zip']['name']);
		$p4 = serialize($_FILES['zip']['size']);
		fwrite($bgproc, $p1."\n".$p2."\n".$p3."\n".$p4."\n");
		#echo $bgproc;
		pclose($bgproc);
	}
	
	$gets = "?code=".$errcode;

	header("Location: batchallsubmit.php".$gets);
	
	exit();
}
else{

	$gets = "?code=2";

	header("Location: batchallsubmit.php".$gets);

}
?>
