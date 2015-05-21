<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Picture Comment Submission</title>
</head>
<body>
<form action="piccomedit_proc.php" method="post" enctype="multipart/form-data">

<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include('../functions/editfunctions.php');
include('../functions/curfunctions.php');

$txtfile = $_GET['file'];
$id = $_GET['id'];
$part = $_GET['part'];

echo "<input type='hidden' name='file' value='".$txtfile."'>";
echo "<input type='hidden' name='id' value='".$id."'>";
echo "<input type='hidden' name='part' value='".$part."'>";

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
  if($part == "module_p"){
  echo "bbm";}	
  if($part == "wafer_p"){
  echo "wafer";}	
  if($part == "sensor_p"){
  echo "sensor";}	
  if($part == "ROC_p"){
  echo "roc";}	
  if($part == "HDI_p"){
  echo "hdi";}	

  echo ".php";
?>
">
<?php
  $dumped = dump($part, $id);
  echo "<input type='hidden' name='name' value='".$dumped['name']."'>";
?>
<input type="submit" value="Back to Summary">
</form>

</body>
</html>
