<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php $title = $_GET['name']; ?>
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title><?php echo $title." " ?>Full Test Summary</title>
</head>
<body>
<form action="summaryFull.php" method="GET" enctype="multipart/form-data">

<?php
 #ini_set('display_errors', 'On');
 #error_reporting(E_ALL | E_STRICT);
include_once('../functions/curfunctions.php');
include_once('../functions/submitfunctions.php');
include_once('../functions/popfunctions.php');

$name = $_GET['name'];
$id = findid("module_p", $name);

echo "<input type='hidden' name='name' value='".$_GET['name']."'>";
curname("module_p", $id);
echo "<br>";
curtestparams($id);
if($_GET['links']=="show"){
   morewebLinkList($id);
}
curnotes_fnal($id);
echo "<br>";
curpics("sidet_p", $id);

?>
<br>
<br>
<br>
</form>

<div style="position:absolute;left:500px;top:10px;">
<form method="GET" action="../submit/fullSubmit.php">
<?php
  echo "<input type='hidden' name='name' value='".$name."'>";
?>
<input type="submit" value="Manual Update">
</form>
</div>

<div2 style="position:absolute;left:500px;top:38px;">
<form method="GET" action="../download/configfiles.php" target="_blank">
<?php
  echo "<input type='hidden' name='name' value='".$name."' >";
?>
<input type="submit" value="Extra Files">
</form>
</div2>

<div3 style="position:absolute;left:500px;top:66px;">
<form method="GET" action="test_list.php">
<input type="submit" value="Back to Tested Module List">
</form>
</div3>

<div4 style="position:absolute;left:500px;top:94px;">
<form method="GET" action="bbm.php">
<?php
  echo "<input type='hidden' name='name' value='".$name."'>";
?>
<input type="submit" value="Back to Part Summary">
</form>
</div4>

<div5 style="position:absolute;left:500px;top:122px;">
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
</div5>

<div6 style="position:absolute;left:500px;top:150px;">
<form method="GET" action="../summary/summaryFull.php">
<?php
  echo "<input type='hidden' name='name' value='".$name."'>";
   if($_GET['links']!="show"){
     echo "<input type='hidden' name='links' value='show'>";

   }
  #echo "<input type='hidden' name='links' value=''>";
?>
<input type="submit" value="Show/Hide MoReWeb Links">
</form>
</div6>

<form method="GET" action="../submit/fullSubmit.php">
<?php
  echo "<input type='hidden' name='name' value='".$name."'>";
?>
<input type="submit" value="Manual Update">
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
