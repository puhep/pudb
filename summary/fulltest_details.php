<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<style> form { display: inline; } </style>
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
<form method="link" action="../summary/fulltest.php">
<input type="submit" value="Module Quality Summary">
</form>
<br>
<br>

<head>
  <title>Module Quality Graphs</title>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <link rel="stylesheet" type="text/css" href="../css/assemblyovertime.css" />
</head>
<body>
<!--
<ul style="columns: 2 200px; -moz-columns: 2 200px; -webkit-columns: 2 200px;">
<li>
-->
<?php
                #echo "<div class=\"left\">";
		echo "<h>";
		echo "Grade Over Time";
		echo "</h>";
		echo "<br>";
                echo "Grades and test dates are based on the -20C Full Test at FNAL";
		echo "<br>Note: the tested and graded modules for this graph only do not include rejected modules that were not tested at -20C<br>";

		#echo "<div id=\"module\">";
		#echo "Total";
		#echo "<br>";
		echo "<a href=\"../graphing/test_modulegrapher.php\" target=\"blank\"><img src=\"../graphing/test_modulegrapher.php\" width=\"710\" height=\"400\" /></a>";
		echo "<br>";
		/*echo "Purdue";
		echo "<br>";
		echo "<a href=\"../graphing/test_modulegrapher.php?loc=purdue\" target=\"blank\"><img src=\"../graphing/test_modulegrapher.php?loc=purdue\" width=\"710\" height=\"400\" /></a>";
		echo "<br>";
		echo "Nebraska";
		echo "<br>";
		echo "<a href=\"../graphing/test_modulegrapher.php?loc=nebraska\" target=\"blank\"><img src=\"../graphing/test_modulegrapher.php?loc=nebraska\" width=\"710\" height=\"400\" /></a>";
		#echo "</div>";
		echo "<br>"; */
		echo "<br>";
		#echo "<br>";
                
                echo "<h>Grade by Batch Over Time</h>";
                echo "<br>";
                echo "<p>Grades are based on the -20C Full Test at FNAL; modules are binned by batch</p>";
		echo "<a href=\"../graphing/testbybatch_lin_grapher.php\" target=\"blank\"><img src=\"../graphing/testbybatch_lin_grapher.php\" width=\"710\" height=\"400\" /></a>";
                echo "<br>";

                #echo "<div class=\"right\">";
                echo "<h>Grade by Batch</h>";
                echo "<br>";
                echo "<p>Grades are based on the -20C Full Test at FNAL; modules are binned by batch</p>";
		echo "<a href=\"../graphing/testbybatch_grapher.php\" target=\"blank\"><img src=\"../graphing/testbybatch_grapher.php\" width=\"710\" height=\"400\" /></a>";
                echo "<br>";
                #echo "</div>";
                
		echo "<h>";
		echo "Defects Over Time";
		echo "</h>";
		echo "<br>";
                echo "<p>Includes modules that have been tested at -20C and have a grade of B or C</p>";
		#echo "Total";
		echo "<br>";
		echo "<a href=\"../graphing/bad_modulegrapher.php\" target=\"blank\"><img src=\"../graphing/bad_modulegrapher.php\" width=\"710\" height=\"400\" /></a>";
		echo "<br>";
		/*echo "Purdue";
		echo "<br>";
		echo "<a href=\"../graphing/bad_modulegrapher.php?loc=purdue\" target=\"blank\"><img src=\"../graphing/bad_modulegrapher.php?loc=purdue\" width=\"710\" height=\"400\" /></a>";
		echo "<br>";
		echo "Nebraska";
		echo "<br>";
		echo "<a href=\"../graphing/bad_modulegrapher.php?loc=nebraska\" target=\"blank\"><img src=\"../graphing/bad_modulegrapher.php?loc=nebraska\" width=\"710\" height=\"400\" /></a>";
		echo "<br>"; */
		echo "<br>";
		echo "<br>";
                #echo "</div>";

?>


<!--
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
-->
</body>
</html>
