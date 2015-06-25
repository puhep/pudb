<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Config Files</title>
</head>
<body>

<?php
include("../../../Submission_p_secure_pages/connect.php");
include("../functions/curfunctions.php");
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);


	$name = $_GET['name'];
	$id = findid("module_p", $name);
	
	$basedir = "../module_config_files/";

	$dir = $basedir.$id;

	echo "<table>";
	echo "<tr valign=top>";
	echo "<th>";
	echo "File";
	echo "</th>";

	echo "<th>";
	echo "&nbsp";
	echo "</th>";

	echo "<th>";
	echo "Size";
	echo "</th>";
	
	echo "<th>";
	echo "&nbsp";
	echo "</th>";


	echo "<th>";
	echo "Timestamp";
	echo "</th>";

	echo "</tr>";


	if(file_exists($dir) && ($handle = opendir($dir))){

		while(false !== ($entry=readdir($handle))){

			if($entry != "." && $entry != ".."){

				echo "<tr valign=top>";
			
				echo "<td>";
				echo "<a href=\"$dir/$entry\" target=\"_blank\">$entry</a>";;
				echo "</td>";

				echo "<td>";
				echo "&nbsp";
				echo "&nbsp";
				echo "&nbsp";
				echo "&nbsp";
				echo "&nbsp";
				echo "&nbsp";
				echo "&nbsp";
				echo "&nbsp";
				echo "</td>";

				echo "<td>";
				echo human_filesize(filesize($dir."/".$entry));
				echo "</td>";

				echo "<td>";
				echo "&nbsp";
				echo "&nbsp";
				echo "&nbsp";
				echo "&nbsp";
				echo "&nbsp";
				echo "&nbsp";
				echo "&nbsp";
				echo "&nbsp";
				echo "</td>";

				echo "<td>";
				echo date('Y-m-d H:i:s', filemtime($dir."/".$entry));
				echo "</td>";

				echo "</tr>";
			}
		}
	}

	echo"</table>";

?>
</body>
</html>
