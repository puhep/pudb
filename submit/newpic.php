<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01//EN' 'http://www.w3.org/TR/html4/strict.dtd'>
<html>
<head>
  <meta content='text/html; charset=ISO-8859-1'
 http-equiv='content-type'>
  <title>New Picture Submission</title>
</head>
<body>
<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include('../functions/popfunctions.php');
include('../functions/editfunctions.php');
include('../functions/curfunctions.php');
include('../functions/submitfunctions.php');
if(!isset($_GET['part'])){
?>
  <form action='newpic.php' method='GET' enctype='multipart/form-data'>
  Wafer <input name='part' value='wafer_p' type='radio'> or Sensor <input name='part'   value='sensor_p' type='radio'>
  <br>
  Select a wafer:
  <select name='wafid'>
  <?php
    waferpop();
  ?>
  </select>
  <br>
  <br>
  BBM: <input name='part' value='module_p'
   type='radio'>
  <br>
  <select name='bbmid'>
  <?php
    receivedmodulepop();
  ?>
  </select>
  <br>
  <br>
  HDI: <input name='part' value='HDI_p' type='radio'>
  <br>
  <select name='hdiid'>
  <?php
    hdipop();
  ?>
  </select>

<?php
}
elseif($_GET['part']=="sensor_p" && !isset($_GET['id'])){
  	echo "<form action='newpic.php' method='GET' enctype='multipart/form-data'>";
	echo "<input type='hidden' name='part' value='".$_GET['part']."'>";

	if($_GET['part'] == 'sensor_p' && !isset($_GET['id'])){
		echo "Available Sensors";
		echo "<select name='id'>";

		sensorpop($_GET['wafid']);
		echo "</select>";
	}
}
elseif(isset($_GET['id']) || $_GET['part'] != "sensor_p"){
  	echo "<form action='newpic_proc.php' method='POST' enctype='multipart/form-data'>";
		if(!isset($_GET['id'])){
			$part = $_GET['part'];

			if($part == 'wafer_p'){
				echo "<input type='hidden' name='id' value='".$_GET['wafid']."'>";
				$id=$_GET['wafid'];}
			if($part == 'sensor_p'){
				echo "<input type='hidden' name='id' value='".$_GET['sensorid']."'>";
				$id=$_GET['sensorid'];}
			if($part == 'module_p'){
				echo "<input type='hidden' name='id' value='".$_GET['bbmid']."'>";
				$id=$_GET['bbmid'];}
			if($part == 'HDI_p'){
				echo "<input type='hidden' name='id' value='".$_GET['hdiid']."'>";
				$id=$_GET['hdiid'];}
		}
		else{
			$id=$_GET['id'];
			$part = $_GET['part'];
		}

		echo "<input type='hidden' name='id' value='".$id."'>";
		echo "<input type='hidden' name='part' value='".$part."'>";
	
		curname($_GET['part'], $id);
		curpics($_GET['part'], $id);

		echo "<br>";

		echo "Picture File <input name=\"pic\" type=\"file\">";
		echo "<br>";
		echo "<br>";
		echo "Additional Notes <textarea cols=\"40\" rows=\"5\" name=\"notes\"></textarea>";
	
}

echo "<br>";
echo "<br>";

conditionalSubmit(1);
?>

</form>
<br>
<br>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
