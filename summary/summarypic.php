<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>New Picture Submission</title>
</head>
<body>
<form action="summarypic.php" method="post" enctype="multipart/form-data">

<?php
 #ini_set('display_errors', 'On');
 #error_reporting(E_ALL | E_STRICT);
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');

if (isset($_POST['submit']) && $_FILES['pic']['size'] > 0){

	addpic($_FILES['pic']['name'], $_FILES['pic']['tmp_name'], $_POST['part'], $_POST['id'], $_POST['notes']);

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

<br>
<br>
</form>

<form method="GET" action="
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

</form>
</body>
</html>
