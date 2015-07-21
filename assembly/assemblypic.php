<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>New Picture Submission</title>
</head>
<body>
<form action="assemblypic_proc.php" method="post" enctype="multipart/form-data">

<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');

echo "<input type='hidden' name='part' value='".$_GET['part']."'>";

echo "<input type='hidden' name='id' value='".$_GET['id']."'>";
curname($_GET['part'], $_GET['id']);
curpics($_GET['part'], $_GET['id']);

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
<br>

<form mehod="GET" action="
<?php
  if($_GET['part']=="wafer_p"){echo "wafer";}
  if($_GET['part']=="sensor_p"){echo "sensor";}
  if($_GET['part']=="module_p"){echo "bbm";}
  if($_GET['part']=="HDI_p"){echo "hdi";}

  echo ".php\">";

  $dumped=dump($_GET['part'],$_GET['id']);

  echo "<input type='hidden' name='name' value='".$dumped['name']."'>";
?>
<input type="submit" value="Back to Assembly">
</form>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
</body>
</html>
