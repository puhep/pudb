<?php
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');

	$gets = "?part=".$_POST['part']."&id=".$_POST['id'];

	header("Location: assemblypic.php".$gets);


if (isset($_POST['submit']) && $_FILES['pic']['size'] > 0){

	$filename = $_FILES['pic']['name'];
	$tmploc = $_FILES['pic']['tmp_name'];

	$part = $_POST['part'];
	$id = $_POST['id'];
	$cwd = getcwd();

	$num = 0;

	while(file_exists($cwd."/../pics/".$part."/".$part.$id."pic".$num.".jpg")){
		$num = $num +1;
	}

	$newfilename = $part.$id."pic".$num;

	copy($tmploc, $cwd."/../pics/".$part."/".$newfilename.".jpg");

	$textfile = $cwd."/../pics/".$part."/".$newfilename.".txt";
	$fp = fopen($textfile, 'w');

	$date = date('Y-m-d H:i:s ');
	
	fwrite($fp, $date.$_POST['notes']."\n");
	

	fclose($fp);
	exit();
}

?>
