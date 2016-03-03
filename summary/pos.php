<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <title>IV by Position</title>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <link rel="stylesheet" type="text/css" href="../css/assemblyovertime.css" />
</head>
<body>

<div style="position:fixed;left:1200px;top:58px;">
<img src="../pics/SINTEF_numbering_diagram_2x8s_Updated.jpg">
</div>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
<br>

<?php
include("../graphing/positiongrapher_crit.php");
include("../functions/curfunctions.php");

		echo "<h>";
		echo "All -20C FNAL Scans";
		echo "</h>";
		echo "<br>";
		
		echo "<div id=\"Total\">";
		echo "<br>";
		echo "<table>";
		echo "<tr>";
		echo "<td>";
		curgraphs_pos_summary("fnal", "IV","");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("fnal", "IV","");
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<br>";
		echo "<br>";
		echo "</div>";

		echo "<h>";
		echo "All +17C FNAL Scans";
		echo "</h>";
		echo "<br>";
		
		echo "<div id=\"Total\">";
		echo "<br>";
		echo "<table>";
		echo "<tr>";
		echo "<td>";
		curgraphs_pos_summary("fnal_17c", "IV","");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("fnal_17c", "IV","");
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<br>";
		echo "<br>";
		echo "</div>";

		echo "<h>";
		echo "TT";
		echo "</h>";
		echo "<br>";
		
		echo "<div id=\"TT\">";
		echo "<br>";
		echo "<table>";
		echo "<tr>";
		echo "<td>";
		curgraphs_pos_summary("fnal", "IV","TT");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("fnal", "IV","TT");
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
		curgraphs_pos_summary("fnal", "IV","FL");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("fnal", "IV","FL");
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
		curgraphs_pos_summary("fnal", "IV","LL");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("fnal", "IV","LL");
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
		curgraphs_pos_summary("fnal", "IV","CL");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("fnal", "IV","CL");
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
		curgraphs_pos_summary("fnal", "IV","CR");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("fnal", "IV","CR");
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
		curgraphs_pos_summary("fnal", "IV","RR");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("fnal", "IV","RR");
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
		curgraphs_pos_summary("fnal", "IV","FR");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("fnal", "IV","FR");
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
		curgraphs_pos_summary("fnal", "IV","BB");
		echo "</td>";
		echo "<td>";
		positiongrapher_crit("fnal", "IV","BB");
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
