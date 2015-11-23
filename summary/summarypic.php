<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>New Picture Submission</title>
</head>
<body>
<form action="summarypic_proc.php" method="post" enctype="multipart/form-data">

<?php
 #ini_set('display_errors', 'On');
 #error_reporting(E_ALL | E_STRICT);
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');

$part = $_GET['part'];
$id = $_GET['id'];

echo "<input type='hidden' name='part' value='".$part."'>";
echo "<input type='hidden' name='id' value='".$id."'>";

curname($part, $id);
curpics($part, $id);

?>

<br>
<br>
Picture File <input name="pic" type="file">
<br>
<br>
Additional Notes <textarea cols="40" rows="5" name="notes"></textarea><br>
<br>
User: <input name="user" type="text">
<br>
<br>

<?php
  conditionalSubmit(0);
?>

<br>
<br>
</form>

<form method="GET" action="
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

</form>
</body>
</html>
