<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Update Module Location</title>
</head>
<body>
<form  method="post" enctype="multipart/form-data">

<?php
include('../functions/curfunctions.php');
include('../functions/editfunctions.php');
include('../functions/popfunctions.php');

echo "<input type='hidden' name='name' value='".$_GET['name']."'>";

$id = findid("module_p", $_GET['name']);
curname("module_p", $id);

?>

<br>
New Location 
	<select name="newloc">
	<?php locpop(); ?>
	</select>
<br>
<br>
Additional Notes <textarea cols="40" rows="5" name="notes"></textarea>
<br>
<br>

<?php
include('../functions/submitfunctions.php');
include('../functions/curfunctions.php');

conditionalSubmit(1);

if(isset($_POST['submit']) && $_POST['newloc']!=""){

	changeloc($id, $_POST['newloc']);

	$newlocnote = "Module moved to ".$_POST['newloc'];
	addcomment("module_p", $id, $newlocnote);

	if($_POST['notes'] !=""){
		addcomment("module_p", $id, $_POST['notes']);
	}
	echo $newlocnote;

}
elseif(isset($_POST['submit'])){
 	echo "New Location field was not filled, please retry";
}
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
