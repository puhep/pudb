<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01//EN' 'http://www.w3.org/TR/html4/strict.dtd'>
<html>
<head>
  <meta content='text/html; charset=ISO-8859-1'
 http-equiv='content-type'>
  <title>Attach TBM</title>
</head>
<body>
<form action='connecttbm.php' method='post' enctype='multipart/form-data'>

<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include('../functions/popfunctions.php');
include('../functions/editfunctions.php');
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');
?>
  <input type='hidden' name='screen' value='1'>

  HDI:
  <br>
  <select name='hdiid'>
  <?php
    barehdi();
  ?>
  </select>
  <br>
  <br>
  TBM:
  <br>
  <select name='tbmid'>
  <?php
    availtbm();
  ?>
  </select>
  <br>
  <br>

<?php

	if(isset($_POST['submit']) && $_POST['hdiid'] != "NULL" && $_POST['tbmid'] != "NULL"){
		
	}

conditionalSubmit(1);
?>

</form>
<br>

<form method='link' action='../index.php'>
<input type='submit' value='MAIN MENU'>
</form>

</body>
</html>
