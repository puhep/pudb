<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <title>Assembly Over Time</title>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <link rel="stylesheet" type="text/css" href="../css/assemblyovertime.css" />
</head>
<body>
<?php


		echo "<h>";
		echo "Module";
		echo "</h>";
		echo "<br>";
		
		echo "<div id=\"module\">";
                echo "<a href=\"../graphing/module_summary_grapher.php\" target=\"blank\"><img src=\"../graphing/module_summary_grapher.php\" width=\"710\" height=\"400\" /></a>";
                echo "<br>";
                echo "<a href=\"../graphing/module_summary_grapher.php?plot_condition=log\" target=\"blank\"><img src=\"../graphing/module_summary_grapher.php?plot_condition=log\" width=\"710\" height=\"400\" /></a>";
                echo "<br>";
		echo "Total";
		echo "<br>";
		echo "<a href=\"../graphing/modulegrapher.php\" target=\"blank\"><img src=\"../graphing/modulegrapher.php\" width=\"710\" height=\"400\" /></a>";
		echo "<br>";
		echo "Purdue";
		echo "<br>";
		echo "<a href=\"../graphing/modulegrapher.php?loc=purdue\" target=\"blank\"><img src=\"../graphing/modulegrapher.php?loc=purdue\" width=\"710\" height=\"400\" /></a>";
		echo "<br>";
		echo "Nebraska";
		echo "<br>";
		echo "<a href=\"../graphing/modulegrapher.php?loc=nebraska\" target=\"blank\"><img src=\"../graphing/modulegrapher.php?loc=nebraska\" width=\"710\" height=\"400\" /></a>";
		echo "</div>";
		echo "<br>";
		echo "<br>";
		echo "<br>";

		echo "<h>";
		echo "HDI";
		echo "</h>";
		echo "<br>";
		echo "Total";
		echo "<br>";
		echo "<a href=\"../graphing/hdigrapher.php\" target=\"blank\"><img src=\"../graphing/hdigrapher.php\" width=\"710\" height=\"400\" /></a>";
		echo "<br>";
		echo "Purdue";
		echo "<br>";
		echo "<a href=\"../graphing/hdigrapher.php?loc=purdue\" target=\"blank\"><img src=\"../graphing/hdigrapher.php?loc=purdue\" width=\"710\" height=\"400\" /></a>";
		echo "<br>";
		echo "Nebraska";
		echo "<br>";
		echo "<a href=\"../graphing/hdigrapher.php?loc=nebraska\" target=\"blank\"><img src=\"../graphing/hdigrapher.php?loc=nebraska\" width=\"710\" height=\"400\" /></a>";
		echo "<br>";
		echo "<br>";
		echo "<br>";

		echo "<h>";
		echo "Wafer";
		echo "</h>";
		echo "<br>";
		echo "<a href=\"../graphing/wafergrapher.php\" target=\"blank\"><img src=\"../graphing/wafergrapher.php\" width=\"710\" height=\"400\" /></a>";
		echo "<br>";
		echo "<br>";
		echo "<br>";


?>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
</body>
</html>
