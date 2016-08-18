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

<p>The linked document contains a current list of the modules in the database, including their name, grade, ROC failure modes (if any), received date, shipped date, and date of final judgement ("Rejected" or "Ready for Mounting").</p>

<a href="../tmp/modulereport2.csv" download>Module Report Document</a>
<br>

<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');
include('../../../Submission_p_secure_pages/connect.php');

$bbmfunc = "SELECT a.id, a.assembly, b.received as received, b.shipped as shipped, b.fnal_tested as judged, b.rejected as rejected, a.pos_on_blade as pos from module_p a,times_module_p b where a.id=b.assoc_module AND a.arrival>\"2015-09-01\" ORDER BY a.arrival";
$dlstring = "Module, Grade, X-Ray Grade, IV Grade, NBadPix, Received, Shipped, Judged, Position, ROC0, ROC1, ROC2, ROC3, ROC4, ROC5, ROC6, ROC7, ROC8, ROC9, ROC10, ROC11, ROC12, ROC13, ROC14, ROC15, \n";

$i=0;
$k=0;
$k_adj=0;
$l=0;

mysql_query('USE cmsfpix_u', $connection);

$output = mysql_query($bbmfunc, $connection);
while($row = mysql_fetch_assoc($output)){
	$bbmarray[0][$k] = findname("module_p",$row['id']);
	$bbmarray[1][$k] = $row['id'];
	$bbmarray[2][$k] = $row['assembly'];
	$bbmarray[3][$k] = $row['received'];
	$bbmarray[4][$k] = $row['shipped'];
	$bbmarray[5][$k] = $row['judged'];
        $bbmarray[6][$k] = $row['pos'];
        $bbmarray[7][$k] = $row['rejected'];
#	if($bbmarray[2][$k] != 0){
#		$k_adj++;
#	}
	$k++;

}


for($j=0;$j<$k;$j++){
	$rocfunc = "SELECT failure_mode FROM ROC_p where assoc_module=".$bbmarray[1][$j]." ORDER BY position";
	$rocoutput = mysql_query($rocfunc,$connection);
	$rocstr = "";
	while($rocrow = mysql_fetch_assoc($rocoutput)){
	      $rocstr .= $rocrow['failure_mode'].", ";
	}
	$rocarr[$j] = $rocstr;
}

for($loop=0; $loop<$k; $loop++){
		       $id = $bbmarray[1][$loop];
		       # module name
		       $dlstring .= $bbmarray[0][$loop].", ";
		       # grade
		       $dlstring .= curgrade($id).", ";
		       # X-Ray grade
		       $dlstring .= xray_crit($id).", ";
		       # IV grade
		       $crit = xmlgrapher_crit_num(findsensor($id), "IV", "module", 0);
		       if($crit == 0){
		        $dlstring .= "I, ";

		       }
		       elseif($crit%7 == 0){
		        $dlstring .= "C, ";

		       }
		       elseif($crit%5 == 0 && $crit%7 != 0){
		        $dlstring .= "B, ";

		       }
		       elseif($crit == 1){
		        $dlstring .= "A, ";
		       }
		       else{ $dlstring .= "$crit, "; }
		       # NBadPix
		       $dlstring .= totbad_crit($id).", ";
		       # Received date
		       $dlstring .= $bbmarray[3][$loop].", ";
		       # shipped date
		       $dlstring .= $bbmarray[4][$loop].", ";
		       # Judged date
		       if($bbmarray[7][$loop] != ""){
		        $dlstring .= $bbmarray[7][$loop].", ";
		       }
		       else{
		       $dlstring .= $bbmarray[5][$loop].", ";

		       }
		       # position on blade
		       $dlstring .= $bbmarray[6][$loop].", ";
		       # ROC failure modes
		       $dlstring .= $rocarr[$loop];

		       #$dlstring .= $bbmarray[11][$loop].", ";

		       $dlstring .= "\n";

}

$fp = fopen("../tmp/modulereport2.csv", "w");
fwrite($fp, $dlstring);
fclose($fp);

?>





</body?
</html>
