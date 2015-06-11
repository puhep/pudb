<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Flex Cable Submission</title>
</head>
<body>
<form action="flexsubmit_proc.php" method="post" enctype="multipart/form-data">

<?php
include('../functions/submitfunctions.php');
include('../functions/curfunctions.php');
include('../functions/editfunctions.php');
include('../../../Submission_p_secure_pages/connect.php');

mysql_query('USE cmsfpix_u', $connection);

$name = $_GET['name'];
if($name == "Purdue"){$id = 1;}
if($name == "Nebraska"){$id = 2;}
echo "<input type=\"hidden\" value=\"".$_GET['name']."\" name=\"name\">";


$ffunc = "SELECT current FROM flex_p WHERE id=".$id;
$foutput = mysql_query($ffunc, $connection);
$frow = mysql_fetch_assoc($foutput);
$fcurcount = $frow['current'];

$cfunc = "SELECT current FROM carrier_p WHERE id=".$id;
$coutput = mysql_query($cfunc, $connection);
$crow = mysql_fetch_assoc($coutput);
$ccurcount = $crow['current'];
?>

<table cellpadding="20">
	<tr>
		<td>
		Current Number of Flex Cables: 
		<?php echo $fcurcount; ?>
		</td>
		<td>
		Current Number of Module Carriers: 
		<?php echo $ccurcount; ?>
		</td>
	</tr>
	<tr>
		<td>
		New Total Number of Flex Cables: <textarea cols="2" rows="1" name="fcurr"></textarea>
		</td>
		<td>
		New Total Number of Module Carriers: <textarea cols="2" rows="1" name="ccurr"></textarea>
		</td>
	</tr>
	<tr>
		<td>
		<?php curnotes("flex_p",$id); ?>
		</td>
		<td>
		<?php curnotes("carrier_p",$id); ?>
		</td>
	</tr>


</table>

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
