<?php
include('../functions/submitfunctions.php');
include('../functions/curfunctions.php');

$path_parts = pathinfo($_FILES['tarball']['name']);
$ext = $path_parts['extension'];

if(isset($_POST['submit']) && $_FILES['tarball']['size'] > 0 && $ext == "tar"){
	
	$dir = "/project/cmsfpix/.www/Submission_p/morewebInput/";
	$tmptar = $_FILES['tarball']['tmp_name'];
	$tar = $_FILES['tarball']['name'];

	move_uploaded_file($tmptar, $dir.$tar);
	if(!chmod($dir.$tar, 0666)){
		$gets = "?code=3";
	}
	else{
		$gets = "?code=1";
	}

	#exec("tar -zxvf ".$dir.$tar);


	header("Location: morewebsubmit.php".$gets);
	
	exit();
}
elseif(isset($_POST['submit'])){

	$gets = "?code=2";
	header("Location: morewebsubmit.php".$gets);
	exit();
}
?>
