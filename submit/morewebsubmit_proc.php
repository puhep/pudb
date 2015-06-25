<?php
include('../functions/submitfunctions.php');
include('../functions/curfunctions.php');

	$gets = "?";

	header("Location: morewebsubmit.php".$gets);

if(isset($_POST['submit']) && $_FILES['tarball']['size'] > 0){


	$dir = "/project/cmsfpix/.www/Submission_p/morewebInput/";
	$tmptar = $_FILES['tarball']['tmp_name'];
	$tar = $_FILES['tarball']['name'];

	move_uploaded_file($tmptar, $dir.$tar);

	exec("tar -zxvf ".$dir.$tar);

	echo "File uploaded";

	exit();
}
elseif(isset($_POST['submit'])){
 	echo "All fields were not filled, please retry";
	exit();
}
?>
