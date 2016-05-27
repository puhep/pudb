<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Modules by Batch</title>
</head>
<body>

<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

<?php
include('../../../Submission_p_secure_pages/connect.php');
include_once('../functions/curfunctions.php');

ini_set('display_errors','On');
error_reporting(E_ALL | E_STRICT);

mysql_query("USE cmsfpix_u", $connection);

$func0 = "select count(id) as num,arrival,WEEK(DATE_SUB(arrival, INTERVAL 3 DAY)) as date from module_p where arrival >\"2015-09-01\" group by date order by arrival";

$output0 = mysql_query($func0,$connection);

$i = 0;
$num_in_batch = array();
$dates = array();
$arrivals = array();
$ranges = array();
while($row0 = mysql_fetch_assoc($output0)){
	    $num_in_batch[$i] = $row0['num'];
	    $dates[$i] = $row0['date'];
	    $arrivals[$i] = $row0['arrival'];
            #if(date("N",strtotime($arrivals[$i]))<3){
		$startdate = date("Y-m-d", strtotime("Wednesday $arrivals[$i] -1 week"));
		$enddate = date("Y-m-d", strtotime("Tuesday $arrivals[$i]"));
		#}
	    #else{
		#$startdate = date("Y-m-d", strtotime("Wednesday $arrivals[$i]"));
		#$enddate = date("Y-m-d", strtotime("Tuesday $arrivals[$i] +1 week"));
		#}
	    $ranges[$i] = $startdate." to ".$enddate;
            $i++;
}


#echo date("l", strtotime($arrivals[0]));
#print_r($dates);
echo "<br>";
#echo date("Y-m-d",strtotime("Wednesday  2015-12-07 -1 week")). " to ".date("Y-m-d",strtotime("Tuesday 2015-12-07"));
echo "<br>";

echo "<table border=1 cellspacing=5>";
echo "<tr>";
echo "<td>";
echo "Batch"; 
echo "</td>";
echo "<td>";
echo "Date Range"; 
echo "</td>";
echo "<td>";
echo "Number of Modules"; 
echo "</td>";
echo "</tr>";
for($j=0; $j<count($num_in_batch); $j++){
	  $l = $j+1;
	  echo "<tr>";
	  echo "<td>";
	  #echo "#".(string)($j+1); 
	  echo "<a href=\"singlebatch.php?batch=$l&week=$arrivals[$j]\">#$l</a>";
	  echo "</td>";
	  echo "<td>";
	  echo $ranges[$j];
	  echo "</td>";
	  echo "<td>";
	  echo $num_in_batch[$j];
	  echo "</td>";
	  echo "</tr>";
	  #echo "</tr>";
}
echo "</table>";

?>




<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
