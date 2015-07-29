<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <title>IV Difference by Position</title>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <link rel="stylesheet" type="text/css" href="../css/assemblyovertime.css" />
</head>
<body>

<?php
include("../graphing/positiongrapher_crit.php");
include("../functions/curfunctions.php");

		echo "<h>";
		echo "TT";
		echo "</h>";
		echo "<br>";
		
		echo "<div id=\"TT\">";
		echo "<br>";
		echo "<table>";
		echo "<tr>";
		echo "<td>";
		curgraphs_diff_summary("assembled", "IV","TT");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("module", "IV","TT");
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<br>";
		echo "<br>";
		echo "</div>";

		echo "<h>";
		echo "FL";
		echo "</h>";
		echo "<br>";
		
		echo "<div id=\"FL\">";
		echo "<br>";
		echo "<table>";
		echo "<tr>";
		echo "<td>";
		curgraphs_diff_summary("assembled", "IV","FL");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("module", "IV","FL");
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<br>";
		echo "<br>";
		echo "</div>";

		echo "<h>";
		echo "LL";
		echo "</h>";
		echo "<br>";
		
		echo "<div id=\"LL\">";
		echo "<br>";
		echo "<table>";
		echo "<tr>";
		echo "<td>";
		curgraphs_diff_summary("assembled", "IV","LL");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("module", "IV","LL");
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<br>";
		echo "<br>";
		echo "</div>";

		echo "<h>";
		echo "CL";
		echo "</h>";
		echo "<br>";
		
		echo "<div id=\"CL\">";
		echo "<br>";
		echo "<table>";
		echo "<tr>";
		echo "<td>";
		curgraphs_diff_summary("assembled", "IV","CL");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("module", "IV","CL");
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<br>";
		echo "<br>";
		echo "</div>";

		echo "<h>";
		echo "CR";
		echo "</h>";
		echo "<br>";
		
		echo "<div id=\"CR\">";
		echo "<br>";
		echo "<table>";
		echo "<tr>";
		echo "<td>";
		curgraphs_diff_summary("assembled", "IV","CR");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("module", "IV","CR");
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<br>";
		echo "<br>";
		echo "</div>";

		echo "<h>";
		echo "RR";
		echo "</h>";
		echo "<br>";
		
		echo "<div id=\"RR\">";
		echo "<br>";
		echo "<table>";
		echo "<tr>";
		echo "<td>";
		curgraphs_diff_summary("assembled", "IV","RR");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("module", "IV","RR");
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<br>";
		echo "<br>";
		echo "</div>";

		echo "<h>";
		echo "FR";
		echo "</h>";
		echo "<br>";
		
		echo "<div id=\"FR\">";
		echo "<br>";
		echo "<table>";
		echo "<tr>";
		echo "<td>";
		curgraphs_diff_summary("assembled", "IV","FR");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("module", "IV","FR");
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<br>";
		echo "<br>";
		echo "</div>";

		echo "<h>";
		echo "BB";
		echo "</h>";
		echo "<br>";
		
		echo "<div id=\"BB\">";
		echo "<br>";
		echo "<table>";
		echo "<tr>";
		echo "<td>";
		curgraphs_diff_summary("assembled", "IV","BB");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("module", "IV","BB");
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<br>";
		echo "<br>";
		echo "</div>";



?>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
</body>
</html>
