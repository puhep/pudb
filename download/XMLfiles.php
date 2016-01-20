<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>XML Files</title>
</head>
<body>

<?php
include("../../../Submission_p_secure_pages/connect.php");
#ini_set('display_errors', 'On');
#error_reporting(E_ALL | E_STRICT);


	mysql_query("USE cmsfpix_u", $connection);

	$part = $_GET['part'];
	$partid = $_GET['partid'];
	$scan = $_GET['scan'];

	$func = "SELECT id,file FROM measurement_p WHERE part_ID=$partid AND part_type=\"$part\" AND scan_type=\"$scan\"";
	
	echo "<table>";
	echo "<tr valign=top>";
	echo "<td>";
	echo "Filename";
	echo "</td>";

	echo "<td>";
	echo "Timestamp";
	echo "</td>";

	echo "<td>";
	echo ".xml";
	echo "</td>";

	echo "<td>";
	echo ".txt";
	echo "</td>";

	echo "</tr>";


	$output = mysql_query($func, $connection);
	while($row = mysql_fetch_assoc($output)){
		echo "<tr>";
		$id = $row['id'];
		$file = $row['file'];
		$doc=simplexml_load_string($file);
		$filename = $doc->DATA_SET->PART->SERIAL_NUMBER."_".$scan;
		$timestamp = $doc->HEADER->RUN->RUN_BEGIN_TIMESTAMP;
		echo "<td>";
		echo $filename;
		echo "</td>";
		
		echo "<td>";
		echo $timestamp;
		echo "</td>";

		echo "<td>";
		echo "<a href=\"../download/dbxmldl.php?id=$id\" target=\"_blank\">Download</a>";
		echo "</td>";

		echo "<td>";
		echo "<a href=\"../download/dbcsvdl.php?id=$id\" target=\"_blank\">Download</a>";
		echo "</td>";



		echo "</tr>";
	}
	echo"</table>";

?>
</body>
</html>
