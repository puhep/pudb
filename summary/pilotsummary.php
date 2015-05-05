<html>
<head>
  <title>Pilot Module Graphs</title>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <link rel="stylesheet" type="text/css" href="../css/summary3.css" />
</head>
<body>
<?php

		echo "<table>";
		echo "<tr>";

		echo "<td>";
		echo "<h>";
		echo "High Leakage Current Fully Assembled Modules";
		echo "</h>";
		echo "</td>";

		
		echo "<td>";
		echo "<h>";
		echo "Low Leakage Current Fully Assembled Modules";
		echo "</h>";
		echo "</td>";

		echo "</tr>";
		echo "<tr>";

		echo "<td>";
		echo "<a href=\"../graphing/pilotgrapher.php?type=assembled&scan=IV&hl=h\" target=\"blank\"><img src=\"../graphing/pilotgrapher.php?type=assembled&scan=IV&hl=h\" width=\"710\" height=\"400\" /></a>";
		echo "</td>";

		echo "<td>";
		echo "<a href=\"../graphing/pilotgrapher.php?type=assembled&scan=IV&hl=l\" target=\"blank\"><img src=\"../graphing/pilotgrapher.php?type=assembled&scan=IV&hl=l\" width=\"710\" height=\"400\" /></a>";
		echo "</td>";

		echo "</tr>";

		echo "<tr>";

		echo "<td>";
		echo "<h>";
		echo "High Leakage Current Bare Modules";
		echo "</h>";
		echo "</td>";

		
		echo "<td>";
		echo "<h>";
		echo "Low Leakage Current Bare Modules";
		echo "</h>";
		echo "</td>";

		echo "</tr>";
		echo "<tr>";

		echo "<td>";
		echo "<a href=\"../graphing/pilotgrapher.php?type=module&scan=IV&hl=h\" target=\"blank\"><img src=\"../graphing/pilotgrapher.php?type=module&scan=IV&hl=h\" width=\"710\" height=\"400\" /></a>";
		echo "</td>";

		echo "<td>";
		echo "<a href=\"../graphing/pilotgrapher.php?type=module&scan=IV&hl=l\" target=\"blank\"><img src=\"../graphing/pilotgrapher.php?type=module&scan=IV&hl=l\" width=\"710\" height=\"400\" /></a>";
		echo "</td>";

		echo "</tr>";

		echo "</table>";


?>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
</body>
</html>
