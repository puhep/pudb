<?php
include('../functions/submitfunctions.php');
include('../functions/curfunctions.php');


if(isset($_POST['submit']) && $_FILES['tarball']['size'] > 0){

	$dir = "/project/cmsfpix/.www/Submission_p/morewebInput/";
	$tmptar = $_FILES['tarball']['tmp_name'];
	$tar = $_FILES['tarball']['name'];

	move_uploaded_file($tmptar, $dir.$tar);

	#exec("tar -zxvf ".$dir.$tar);

	$gets = "?code=1";

	header("Location: morewebsubmit.php".$gets);
	
	exit();
}
elseif(isset($_POST['submit'])){

	$gets = "?code=2";

	header("Location: morewebsubmit.php".$gets);
	
	exit();
}
?>
