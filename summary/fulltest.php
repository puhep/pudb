<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <title>Module Quality Graphs</title>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <link rel="stylesheet" type="text/css" href="../css/assemblyovertime.css" />
</head>
<body>
<?php


		echo "<h>";
		echo "Grade Over Time";
		echo "</h>";
		echo "<br>";
                echo "<p>Grades and test dates are based on the -20C Full Test at FNAL</p>";
		
		echo "<div id=\"module\">";
		echo "Total";
		echo "<br>";
		echo "<a href=\"../graphing/test_modulegrapher.php\" target=\"blank\"><img src=\"../graphing/test_modulegrapher.php\" width=\"710\" height=\"400\" /></a>";
		echo "<br>";
		echo "Purdue";
		echo "<br>";
		echo "<a href=\"../graphing/test_modulegrapher.php?loc=purdue\" target=\"blank\"><img src=\"../graphing/test_modulegrapher.php?loc=purdue\" width=\"710\" height=\"400\" /></a>";
		echo "<br>";
		echo "Nebraska";
		echo "<br>";
		echo "<a href=\"../graphing/test_modulegrapher.php?loc=nebraska\" target=\"blank\"><img src=\"../graphing/test_modulegrapher.php?loc=nebraska\" width=\"710\" height=\"400\" /></a>";
		echo "</div>";
		echo "<br>";
		echo "<br>";
		echo "<br>";

		echo "<h>";
		echo "Defects Over Time";
		echo "</h>";
		echo "<br>";
                echo "<p>Includes modules that have been tested at -20C and have a grade of neither A nor I</p>";
		echo "Total";
		echo "<br>";
		echo "<a href=\"../graphing/bad_modulegrapher.php\" target=\"blank\"><img src=\"../graphing/bad_modulegrapher.php\" width=\"710\" height=\"400\" /></a>";
		echo "<br>";
		echo "Purdue";
		echo "<br>";
		echo "<a href=\"../graphing/bad_modulegrapher.php?loc=purdue\" target=\"blank\"><img src=\"../graphing/bad_modulegrapher.php?loc=purdue\" width=\"710\" height=\"400\" /></a>";
		echo "<br>";
		echo "Nebraska";
		echo "<br>";
		echo "<a href=\"../graphing/bad_modulegrapher.php?loc=nebraska\" target=\"blank\"><img src=\"../graphing/bad_modulegrapher.php?loc=nebraska\" width=\"710\" height=\"400\" /></a>";
		echo "<br>";
		echo "<br>";
		echo "<br>";

?>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
</body>
</html>
