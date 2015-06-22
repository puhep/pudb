<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>ROC Editing</title>
</head>
<body>
<form action='ROCedit.php' method='post' enctype='multipart/form-data'>
<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');
include('../functions/editfunctions.php');
if(!isset($_POST['modules'])){
?>
Available Modules
<select name="modules">
<?php
modulepopwithroc();
?>
</select>

<?php
}
else{

echo "<input type='hidden' name='modules' value='".$_POST['modules']."'>";

curname("module_p", $_POST['modules']);

$i = 0;

$rocs = array();

mysql_query('USE cmsfpix_u', $connection);


$func = 'SELECT name from ROC_p WHERE assoc_module='.$_POST['modules'].' ORDER BY position';
$output = mysql_query($func, $connection);
while($rocrow = mysql_fetch_assoc($output)){
	$rocs[$i] = $rocrow['name'];
	$i++;
}
if($i == 0){
	ROCinfo($_POST['modules']);
}

?>

<table>
	<tr>
		<td>
		ROC0
		<textarea cols="20" rows="1" name="ROC0"><?php echo $rocs[0]; ?></textarea> 
		</td>
		<td>
		ROC15
		<textarea cols="20" rows="1" name="ROC15"><?php echo $rocs[15]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC1
		<textarea cols="20" rows="1" name="ROC1"><?php echo $rocs[1]; ?></textarea> 
		</td>
		<td>
		ROC14
		<textarea cols="20" rows="1" name="ROC14"><?php echo $rocs[14]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC2
		<textarea cols="20" rows="1" name="ROC2"><?php echo $rocs[2]; ?></textarea> 
		</td>
		<td>
		ROC13
		<textarea cols="20" rows="1" name="ROC13"><?php echo $rocs[13]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC3
		<textarea cols="20" rows="1" name="ROC3"><?php echo $rocs[3]; ?></textarea> 
		</td>
		<td>
		ROC12
		<textarea cols="20" rows="1" name="ROC12"><?php echo $rocs[12]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC4
		<textarea cols="20" rows="1" name="ROC4"><?php echo $rocs[4]; ?></textarea> 
		</td>
		<td>
		ROC11
		<textarea cols="20" rows="1" name="ROC11"><?php echo $rocs[11]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC5
		<textarea cols="20" rows="1" name="ROC5"><?php echo $rocs[5]; ?></textarea> 
		</td>
		<td>
		ROC10
		<textarea cols="20" rows="1" name="ROC10"><?php echo $rocs[10]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC6
		<textarea cols="20" rows="1" name="ROC6"><?php echo $rocs[6]; ?></textarea> 
		</td>
		<td>
		ROC9
		<textarea cols="20" rows="1" name="ROC9"><?php echo $rocs[9]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC7
		<textarea cols="20" rows="1" name="ROC7"><?php echo $rocs[7]; ?></textarea> 
		</td>
		<td>
		ROC8
		<textarea cols="20" rows="1" name="ROC8"><?php echo $rocs[8]; ?></textarea> 
		</td>
	</tr>
</table>
<br>
OR
<br>

<input type="checkbox" name="spin" value="1"> Spin orientation of ROCs (0 becomes 8)
<br>
Result:
<table>
	<tr>
		<td>
		ROC0
		<textarea cols="20" rows="1" DISABLED ><?php echo $rocs[8]; ?></textarea> 
		</td>
		<td>
		ROC15
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[7]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC1
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[9]; ?></textarea> 
		</td>
		<td>
		ROC14
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[6]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC2
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[10]; ?></textarea> 
		</td>
		<td>
		ROC13
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[5]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC3
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[11]; ?></textarea> 
		</td>
		<td>
		ROC12
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[4]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC4
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[12]; ?></textarea> 
		</td>
		<td>
		ROC11
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[3]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC5
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[13]; ?></textarea> 
		</td>
		<td>
		ROC10
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[2]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC6
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[14]; ?></textarea> 
		</td>
		<td>
		ROC9
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[1]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC7
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[15]; ?></textarea> 
		</td>
		<td>
		ROC8
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[0]; ?></textarea> 
		</td>
	</tr>
</table>
<br>
OR
<input type="checkbox" name="flip" value="1"> Flip orientation of ROCs (0 becomes 15)
<br>
Result:
<table>
	<tr>
		<td>
		ROC0
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[15]; ?></textarea> 
		</td>

		<td>
		ROC15
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[0]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC1
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[14]; ?></textarea> 
		</td>
		<td>
		ROC14
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[1]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC2
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[13]; ?></textarea> 
		</td>
		<td>
		ROC13
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[2]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC3
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[12]; ?></textarea> 
		</td>
		<td>
		ROC12
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[3]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC4
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[11]; ?></textarea> 
		</td>
		<td>
		ROC11
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[4]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC5
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[10]; ?></textarea> 
		</td>
		<td>
		ROC10
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[5]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC6
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[9]; ?></textarea> 
		</td>
		<td>
		ROC9
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[6]; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC7
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[8]; ?></textarea> 
		</td>
		<td>
		ROC8
		<textarea cols="20" rows="1" DISABLED><?php echo $rocs[7]; ?></textarea> 
		</td>
	</tr>
</table>

<?php
}
?>

<br>
<br>

<?php

conditionalSubmit(1);

?>
</form>

<br>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
