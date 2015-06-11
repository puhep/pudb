<?php
include('../functions/submitfunctions.php');
include('../functions/curfunctions.php');
include('../functions/editfunctions.php');
include('../../../Submission_p_secure_pages/connect.php');

mysql_query('USE cmsfpix_u', $connection);

	$name = $_POST['name'];
	if($name == "Purdue"){$id = 1;}
	if($name == "Nebraska"){$id = 2;}

	$gets = "?name=".$name;

	header("Location: flexsubmit.php".$gets);


if(isset($_POST['submit'])){

	if($_POST['fcurr'] != ""){
		$fcurr = $_POST['fcurr'];
	
		$func1 = "UPDATE flex_p SET current=".$fcurr." WHERE id=".$id;
		mysql_query($func1, $connection);
	
		$ftally = "Current Count of Flex Cables: ".$fcurr;
		addcomment("flex_p",$id,$ftally);
	}

	if($_POST['ccurr'] != ""){
		$ccurr = $_POST['ccurr'];

		$func2 = "UPDATE carrier_p SET current=".$ccurr." WHERE id=".$id;
		mysql_query($func2, $connection);
	
		$ctally = "Current Count of Module Carriers: ".$ccurr;
		addcomment("carrier_p",$id,$ctally);
	}
	exit();
}
?>
