<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Full Test Summary</title>
</head>
<body>
<form action="summaryFull.php" method="GET" enctype="multipart/form-data">

<?php
 #ini_set('display_errors', 'On');
 #error_reporting(E_ALL | E_STRICT);
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');

$name = $_GET['name'];
$id = findid("module_p", $name);



echo "<input type='hidden' name='name' value='".$_GET['name']."'>";
curname("module_p", $id);
echo "<br>";
curtestgrade($id);
morewebLinkList($id);
curpics("sidet_p", $id);

?>
<br>
<br>
<br>
</form>

<form method="POST" action="../submit/fullSubmit.php">
<?php
  echo "<input type='hidden' name='id' value='".$id."'>";
?>
<input type="submit" value="Update">
</form>
<br>
<form method="GET" action="../download/configfiles.php" target="_blank">
<?php
  echo "<input type='hidden' name='name' value='".$name."'>";
?>
<input type="submit" value="Config Files">
</form>
<br>
<form method="GET" action="test_list.php" ">
<input type="submit" value="Back to Tested Module List">
</form>
<br>
<form method="GET" action="bbm.php">
<?php
  echo "<input type='hidden' name='name' value='".$name."'>";
?>
<input type="submit" value="Back to Part Summary">
</form>
<br>
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
