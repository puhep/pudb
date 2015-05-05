<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Picture Comment Submission</title>
</head>
<body>
<form action="piccomedit.php" method="post" enctype="multipart/form-data">

<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include('../functions/editfunctions.php');
include('../functions/curfunctions.php');

$txtfile = $_POST['file'];

if (isset($_POST['submit']) && $_POST['notes'] != ""){

	$fp = fopen($txtfile, 'a');
	$date = date('Y-m-d H:i:s ');

	fwrite($fp, $date.$_POST['notes']."\n");
	fclose($fp);
}

chmod("/project/cmsfpix/.www/Submission_p/pics/module_p/module_p84pic18.txt",0777);

echo "<input type='hidden' name='file' value='".$_POST['file']."'>";
echo "<input type='hidden' name='id' value='".$_POST['id']."'>";
echo "<input type='hidden' name='part' value='".$_POST['part']."'>";

if(file_exists($txtfile)){
	$fp = fopen($txtfile, 'r');
	$txt = fread($fp, filesize($txtfile));
	echo nl2br($txt);
	fclose($fp);
}
else{echo "No Current Comments";}

?>
<br>
<br>
Additional Notes <textarea cols="40" rows="5" name="notes"></textarea>
<br>
<br>

<input name="submit" value="SUBMIT" type="submit">
</form>
<br>
<br>

<form method="GET" action="../summary/
<?php
  if($_POST['part'] == "module_p"){
  echo "bbm";}	
  if($_POST['part'] == "wafer_p"){
  echo "wafer";}	
  if($_POST['part'] == "sensor_p"){
  echo "sensor";}	
  if($_POST['part'] == "ROC_p"){
  echo "roc";}	
  if($_POST['part'] == "HDI_p"){
  echo "hdi";}	

  echo ".php";
?>
">
<?php
  $dumped = dump($_POST['part'], $_POST['id']);
  echo "<input type='hidden' name='name' value='".$dumped['name']."'>";
?>
<input type="submit" value="Back to Summary">
</form>

</body>
</html>
