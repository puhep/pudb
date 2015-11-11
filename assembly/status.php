<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Assembly</title>
  <link rel="stylesheet" type="text/css" href="../css/purduenebraska.css" />
</head>
<body>
<form method="get" enctype="mulitpart/form-data">
<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include('../functions/curfunctions.php');
include('../../../Submission_p_secure_pages/connect.php');

$hidew = hidepre("wafer",1);
$hideh = hidepre("HDI",1);
$hidem = hidepre("module",1);

$waferfunc = "SELECT name, id, assembly FROM wafer_p ".$hidew." ORDER BY name";
$bbmfunc = "SELECT name, id, assembly, location FROM module_p ".$hidem." ORDER BY name";
$hdifunc = "SELECT name, id, assembly, location FROM HDI_p ".$hideh." ORDER BY name";

$wafersteparray = array("Received", "Inspected", "Tested", "Promoted", "Ready for Shipping", "Shipped");
$bbmsteparray = array("Expected", "Received", "Inspected", "IV Tested", "Ready for HDI Assembly",  "HDI Attached", "Wirebonded", "Encapsulated", "Tested", "Thermally Cycled", "Tested", "Ready for Shipping", "Shipped", "Ready for Mounting", "On Blade"); 
$hdisteparray = array("Received", "Inspected", "Ready for Assembly","On Module", "Rejected");

$wafernum=count($wafersteparray);
$bbmnum=count($bbmsteparray);
$hdinum=count($hdisteparray);

$i=0;
$k=0;
$k_adj=0;
$l=0;

mysql_query('USE cmsfpix_u', $connection);

$output = mysql_query($waferfunc, $connection);
while($output && $row = mysql_fetch_assoc($output)){
	$waferarray[$i][0] = $row['name'];
	$waferarray[$i][1] = $row['id'];
	$waferarray[$i][2] = $row['assembly'];
	$i++;
}
$output = mysql_query($bbmfunc, $connection);
while($output && $row = mysql_fetch_assoc($output)){
	$bbmarray[$k][0] = $row['name'];
	$bbmarray[$k][1] = $row['id'];
	$bbmarray[$k][2] = $row['assembly'];
	$bbmarray[$k][3] = $row['location'];
	if($bbmarray[$k][2] != 0){
		$k_adj++;
	}
	$k++;
}
$output = mysql_query($hdifunc, $connection);
while($output && $row = mysql_fetch_assoc($output)){
	$hdiarray[$l][0] = $row['name'];
	$hdiarray[$l][1] = $row['id'];
	$hdiarray[$l][2] = $row['assembly'];
	$hdiarray[$l][3] = $row['location'];
	$l++;
}

echo "<table cellspacing=20 border=2>";

echo "<tr valign=top>";
echo "<td valign=middle>";
echo "Wafers";
echo "</td>";
for($loop=0;$loop<$wafernum;$loop++){

echo "<td valign=middle>";
echo "<a href=\"step.php?sort=sh&part=wafer&sl=".$loop."\">".$wafersteparray[$loop]."</a>";
echo "</td>";

}

echo "<td valign=middle>";
echo "Total";
echo "</td>";

echo "</tr>";
echo "<tr>";
echo "<td>";
echo "</td>";

for($loop=0; $loop<$wafernum; $loop++){
$numatthislevel=0;

	for($subloop=0; $subloop<$i; $subloop++){
		if($waferarray[$subloop][2] == $loop){
			$numatthislevel++;
		}
	}
	echo "<td>";
	echo $numatthislevel;
	echo "</td>";
}

echo "<td>";
echo $i;
echo "</td>";

	echo "</tr>";
	echo "</table><br>";

echo "<table cellspacing=20 border=2>";

echo "<tr valign=top>";
echo "<td valign=middle>";
echo "HDIs";
echo "</td>";
for($loop=0;$loop<$hdinum;$loop++){

echo "<td valign=middle>";
echo "<a href=\"step.php?sort=sh&part=HDI&sl=".$loop."\">".$hdisteparray[$loop]."</a>";
echo "</td>";

}

echo "<td valign=middle>";
echo "Total";
echo "</td>";

echo "</tr>";
echo "<tr>";
echo "<td>";
echo "Total <br> Purdue <br> Nebraska";
echo "</td>";

$purduetot = 0;
$nebraskatot = 0;
for($loop=0; $loop<$hdinum; $loop++){
$numatthislevel=0;
$purduenum = 0;
$nebraskanum = 0;


	for($subloop=0; $subloop<$l; $subloop++){
		if($hdiarray[$subloop][2] == $loop){
			$numatthislevel++;
			if($hdiarray[$subloop][3] == "Purdue"){
				$purduenum++;
				$purduetot++;
			}
			if($hdiarray[$subloop][3] == "Nebraska"){
				$nebraskanum++;
				$nebraskatot++;
			}
						
		}
	}

	echo "<td>";
	echo $numatthislevel."<br>".$purduenum."<br>".$nebraskanum;
	echo "</td>";
}

echo "<td>";
echo $l."<br>".$purduetot."<br>".$nebraskatot;
echo "</td>";

	echo "</tr>";
	echo "</table>";
echo "<table cellspacing=20 border=2>";

echo "<tr valign=top>";
echo "<td valign=middle>";
echo "Modules";
echo "</td>";
for($loop=1;$loop<$bbmnum;$loop++){

echo "<td valign=middle>";
echo "<a href=\"step.php?sort=sh&part=module&sl=".$loop."\">".$bbmsteparray[$loop]."</a>";
echo "</td>";

}

echo "<td valign=middle>";
echo "Total";
echo "</td>";

echo "</tr>";
echo "<tr>";
echo "<td>";
echo "Total <br> Purdue <br> Nebraska";
echo "</td>";

$purduetot = 0;
$nebraskatot = 0;
for($loop=1; $loop<$bbmnum; $loop++){
$numatthislevel=0;
$purduenum = 0;
$nebraskanum = 0;

	for($subloop=0; $subloop<$k; $subloop++){
		if($bbmarray[$subloop][2] == $loop){
			$numatthislevel++;
			if($bbmarray[$subloop][3] == "Purdue"){
				$purduenum++;
				$purduetot++;
			}
			if($bbmarray[$subloop][3] == "Nebraska"){
				$nebraskanum++;
				$nebraskatot++;
			}
		}
	}
	echo "<td>";
	if($loop == $bbmnum-1 || $loop == $bbmnum-2){
		echo $numatthislevel."<br><br><br>";
	}
	else{
		echo $numatthislevel."<br>".$purduenum."<br>".$nebraskanum;
	}
	echo "</td>";
}

echo "<td>";
echo $k_adj."<br>".$purduetot."<br>".$nebraskatot;
echo "</td>";

	echo "</tr>";
	echo "</table>";

?>
</form>
<br>
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
