<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/curfunctions.php');


$id = $_GET["id"];

$wafername = findname("wafer_p", $id);

$filename = $wafername."_approved_sensors";

$func = "SELECT name, promote FROM sensor_p WHERE assoc_wafer=\"$id\" ORDER BY promote DESC";

mysql_query('USE cmsfpix_u', $connection);

$output = mysql_query($func, $connection);

$tsvfile = "";

$tsvfile .= "Approved and rejected sensors for wafer $wafername:\n";

$old = 1;

while($row = mysql_fetch_assoc($output)){
	if($old == 1 && $row['promote'] == 0){
		$tsvfile .= "\n";
		$old = 0;
	}

	if(substr($row['name'],1,1) == "L"){
		$tsvfile .= $row['name'];
		$tsvfile .= "\t";
		if($row['promote'] == 1){
			$tsvfile .= "good";
		}
		else{
			$tsvfile .= "bad";
		}
		$tsvfile .= "\n";
	}
}

mysql_free_result($output);

	    header ("Content-Type: {text/tab-separated-values}\n");
            header ("Content-disposition: attachment; filename=\"$filename.txt\"\n");
            header ("Content-Length: {$row['filesize']}\n");

echo $tsvfile;

?>
