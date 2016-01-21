<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
<br>


<head>
  <title>Module Report Document</title>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <link rel="stylesheet" type="text/css" href="../css/assemblyovertime.css" />
</head>
<body>

<p>The linked document contains a current list of the modules in the database, including their name, assembly site, assembly date, and part information.</p>

<a href="../tmp/modulereport.csv" download>Module Report Document</a>
<br>

<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');
include('../../../Submission_p_secure_pages/connect.php');

$dlstring;
#$hide = "";
$hide = " AND c.received > \"2015-09-01\" and c.assoc_module=a.id and c.assoc_module = b.module";
#$hide = hidepre("module",2);


$bbmfunc = "SELECT a.name, a.id, a.assembly, a.assoc_sens, a.bonder, a.location, a.time_created, b.module, b.TBM_wafer, c.received from module_p a, HDI_p b, times_module_p c WHERE a.name LIKE 'M%' AND a.id=b.module ".$hide." ORDER BY name";

$partarray = array("Module","Location", "Bonder", "Sensor", "HDI", "ROCs", "IV Scans", "Criteria", "Date Assembled", "Last Modified");
$sortarray = array("mod", "loc", "fcb", "sen", "hdi", "", "", "", "dat", "lm");

$dlstring = "module, assembly site, assembly date, sensor, HDI, TBM wafer, ROC thickness, ROC0, ROC1, ROC2, ROC3, ROC4, ROC5, ROC6, ROC7, ROC8, ROC9, ROC10, ROC11, ROC12, ROC13, ROC14, ROC15,\n";


$i=0;
$k=0;
$k_adj=0;
$l=0;

mysql_query('USE cmsfpix_u', $connection);

$output = mysql_query($bbmfunc, $connection);
while($row = mysql_fetch_assoc($output)){

	$timefunc = "SELECT HDI_attached FROM times_module_p WHERE assoc_module=".$row['id'];
	$timeout = mysql_query($timefunc, $connection);
	$timerow = mysql_fetch_assoc($timeout);

	$bbmarray[0][$k] = findname("module_p",$row['id']);
	$bbmarray[1][$k] = $row['id'];
	$bbmarray[2][$k] = $row['assembly'];
	$bbmarray[3][$k] = $row['assoc_sens'];
	$bbmarray[4][$k] = $timerow['HDI_attached'];

	$names = namedump("module_p",$bbmarray[1][$k]); 
	$bbmarray[5][$k] = $names['sensor'];
	$bbmarray[6][$k] = $names['hdi'];
	$bbmarray[7][$k] = $row['bonder'];
	$bbmarray[8][$k] = $row['location'];
	$bbmarray[9][$k] = $row['time_created'];
	$bbmarray[10][$k] = findname("module_p", $row['id']);
   
        $bbmarray[11][$k] = $row['TBM_wafer'];
   
	if($bbmarray[2][$k] != 0){
		$k_adj++;
	}
	$k++;

}


for($loop=0; $loop<$k; $loop++){

$dlstring .= $bbmarray[10][$loop].", ";

$dlstring .= $bbmarray[8][$loop].", ";

$dlstring .= $bbmarray[4][$loop].", ";

$dlstring .= $bbmarray[5][$loop].", ";

$dlstring .= $bbmarray[6][$loop].", ";

$dlstring .= $bbmarray[11][$loop].", ";

$dlstring .= currocs_string($bbmarray[1][$loop])."\n";
}

$fp = fopen("../tmp/modulereport.csv", "w");
fwrite($fp, $dlstring);
fclose($fp);

?>





</body?
</html>
