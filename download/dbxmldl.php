<?php
include('../../../Submission_p_secure_pages/connect.php');

$id = $_GET["id"];

$func = "SELECT file, filesize, part_type, scan_type FROM measurement_p WHERE id=\"$id\"";


mysql_query('USE cmsfpix_u', $connection);

$output = mysql_query($func, $connection);

$row = mysql_fetch_array($output, MYSQL_ASSOC);

$type = $row['part_type'];
$scan = $row['scan_type'];

$file = $row['file'];
$doc = simplexml_load_string($file);
$filename = $doc->DATA_SET->PART->SERIAL_NUMBER."_".$scan;

mysql_free_result($output);

	    header ("Content-Type: {application/xml}\n");
            header ("Content-disposition: attachment; filename=\"$filename.xml\"\n");
            header ("Content-Length: {$row['filesize']}\n");

echo $file;

?>
