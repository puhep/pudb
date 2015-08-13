<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Update Module Location</title>
</head>
<body>
<form  action="updatelocation_proc.php" method="post" enctype="multipart/form-data">

<?php
include('../functions/curfunctions.php');
include('../functions/editfunctions.php');
include('../functions/popfunctions.php');

echo "<input type='hidden' name='name' value='".$_GET['name']."'>";

$id = findid("module_p", $_GET['name']);
curname("module_p", $id);

?>

<br>
New Location: 
	<select name="newloc">
	<?php locpop(""); ?>
	</select>
<br>
<br>
User: <textarea cols="10" rows="1" name="user"></textarea>
<br>
<br>
Additional Notes: <textarea cols="40" rows="5" name="notes"></textarea>
<br>
<br>

<?php
include('../functions/submitfunctions.php');
include('../functions/curfunctions.php');

if($_GET['code'] == "1"){
	echo "Location changed successfully<br>";
}
if($_GET['code'] == "2"){
	echo "Not all forms were filled, please retry<br>";
}

conditionalSubmit(1);

?>

</form>
<br>
<form method="GET" action="../summary/bbm.php">
<?php
	echo "<input type='hidden' name='name' value='".$_GET['name']."'>";
?>
<input type="submit" value="BACK">
</form>
<br>
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
</body>
</html>
