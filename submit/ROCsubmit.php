<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>ROC Submission</title>
</head>
<body>
<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');
include('../functions/editfunctions.php');
if(!isset($_GET['modules'])){
?>
<form action='ROCsubmit.php' method='GET' enctype='multipart/form-data'>
Available Modules
<select name="modules">
<?php
modulepopnoroc();
?>
</select>

<?php

if($_GET['code'] == "1"){
	echo "<br>The ROCS have successfully been added to the module<br>";
}
if($_GET['code'] == "2"){
	echo "<br>Not all forms were filled, please retry<br>";
}

}
else{
?>
<form action='ROCsubmit_proc.php' method='post' enctype='multipart/form-data'>
<?php

echo "<input type='hidden' name='modules' value='".$_GET['modules']."'>";

curname("module_p", $_GET['modules']);

$func = 'SELECT name from ROC_p WHERE assoc_module='.$_GET['modules'].' ORDER BY position';

$i = 0;

mysql_query('USE cmsfpix_u', $connection);
$output = mysql_query($func, $connection);
while($rocrow = mysql_fetch_assoc($output)){
	$i++;
}
if($i == 0){
	ROCinfo($_GET['modules']);
}

?>

<table>
	<tr>
		<td>
		ROC0
		<textarea cols="20" rows="1" name="ROC0"></textarea> 
		</td>
		<td>
		ROC15
		<textarea cols="20" rows="1" name="ROC15"></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC1
		<textarea cols="20" rows="1" name="ROC1"></textarea> 
		</td>
		<td>
		ROC14
		<textarea cols="20" rows="1" name="ROC14"></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC2
		<textarea cols="20" rows="1" name="ROC2"></textarea> 
		</td>
		<td>
		ROC13
		<textarea cols="20" rows="1" name="ROC13"></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC3
		<textarea cols="20" rows="1" name="ROC3"></textarea> 
		</td>
		<td>
		ROC12
		<textarea cols="20" rows="1" name="ROC12"></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC4
		<textarea cols="20" rows="1" name="ROC4"></textarea> 
		</td>
		<td>
		ROC11
		<textarea cols="20" rows="1" name="ROC11"></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC5
		<textarea cols="20" rows="1" name="ROC5"></textarea> 
		</td>
		<td>
		ROC10
		<textarea cols="20" rows="1" name="ROC10"></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC6
		<textarea cols="20" rows="1" name="ROC6"></textarea> 
		</td>
		<td>
		ROC9
		<textarea cols="20" rows="1" name="ROC9"></textarea> 
		</td>
	</tr>
	<tr>
		<td>
		ROC7
		<textarea cols="20" rows="1" name="ROC7"></textarea> 
		</td>
		<td>
		ROC8
		<textarea cols="20" rows="1" name="ROC8"></textarea> 
		</td>
	</tr>
</table>
<br>
<br>

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
