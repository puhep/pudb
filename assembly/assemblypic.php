<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>New Picture Submission</title>
</head>
<body>
<form action="assemblypic.php" method="post" enctype="multipart/form-data">

<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');

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
	
	fwrite($fp, $date.$_POST['notes']);
	

	fclose($fp);
}

echo "<input type='hidden' name='part' value='".$_POST['part']."'>";

echo "<input type='hidden' name='id' value='".$_POST['id']."'>";
curname($_POST['part'], $_POST['id']);
curpics($_POST['part'], $_POST['id']);

?>


<br>
Picture File <input name="pic" type="file">
<br>
<br>
Additional Notes <textarea cols="40" rows="5" name="notes"></textarea><br>
<br>

<?php
  conditionalSubmit(0);
?>

</form>

<br>

<form mehod="GET" action="
<?php
  if($_POST['part']=="wafer_p"){echo "wafer";}
  if($_POST['part']=="sensor_p"){echo "sensor";}
  if($_POST['part']=="module_p"){echo "bbm";}
  if($_POST['part']=="HDI_p"){echo "hdi";}

  echo ".php\">";

  $dumped=dump($_POST['part'],$_POST['id']);

  echo "<input type='hidden' name='name' value='".$dumped['name']."'>";
?>
<input type="submit" value="Back to Assembly">
</form>
<br>
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
</body>
</html>
