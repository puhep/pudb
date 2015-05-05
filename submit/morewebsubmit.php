<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>MoReWeb Data Submission</title>
</head>
<body>
<form  method="post" enctype="multipart/form-data">

Tarball to be uploaded to MoReWeb:
<br>
<br>
<input type="file" name="tarball">
<br>
<br>

<?php
include('../functions/submitfunctions.php');
include('../functions/curfunctions.php');

conditionalSubmit(1);

if(isset($_POST['submit']) && $_FILES['tarball']['size'] > 0){


	$dir = "/project/cmsfpix/.www/Submission_p/morewebInput/";
	$tmptar = $_FILES['tarball']['tmp_name'];
	$tar = $_FILES['tarball']['name'];

	move_uploaded_file($tmptar, $dir.$tar);

	exec("tar -xvf $dir.$tar");

	echo "File uploaded";
}
elseif(isset($_POST['submit'])){
 	echo "All fields were not filled, please retry";
}
?>

</form>
<br>
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
</body>
</html>
