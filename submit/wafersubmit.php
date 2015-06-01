<?php
include('../functions/submitfunctions.php');
include('../functions/curfunctions.php');


if(isset($_POST['submit']) && $_POST['wafer_id']!="" && $_POST['receive']!=""){

	$gets = "?submitted=".$_POST['wafer_id'];
	header("Location: wafersubmit.php".$gets);


	$iwafer = intval($_POST['wafer_id']);
	if(($iwafer < 0) || ($iwafer > 999)){
		echo "Wafer ID formatting incorrect, please retry";
	}
	else{ 
   		$name=str_pad($_POST['wafer_id'],3,"0", STR_PAD_LEFT);

 		waferinfo($name,$_POST['receive'],$_POST['notes']);

  		$wafid = findid("wafer_p",$name); 

  		sensorinfo("WL_TT_".$name,"2x8 automatically added to the database",$wafid);
 		sensorinfo("WL_FL_".$name,"2x8 automatically added to the database",$wafid);
  		sensorinfo("WL_LL_".$name,"2x8 automatically added to the database",$wafid);
  		sensorinfo("WL_CL_".$name,"2x8 automatically added to the database",$wafid);
  		sensorinfo("WL_CR_".$name,"2x8 automatically added to the database",$wafid);
  		sensorinfo("WL_RR_".$name,"2x8 automatically added to the database",$wafid);
  		sensorinfo("WL_FR_".$name,"2x8 automatically added to the database",$wafid);
  		sensorinfo("WL_BB_".$name,"2x8 automatically added to the database",$wafid);
  		sensorinfo("WS_TR_".$name,"1x1 automatically added to the database",$wafid);
  		sensorinfo("WS_CR_".$name,"1x1 automatically added to the database",$wafid);
  		sensorinfo("WS_BR_".$name,"1x1 automatically added to the database",$wafid);
  		sensorinfo("WS_TL_".$name,"1x1 automatically added to the database",$wafid);
  		sensorinfo("WS_CL_".$name,"1x1 automatically added to the database",$wafid);
  		sensorinfo("WS_BL_".$name,"1x1 automatically added to the database",$wafid);
  		sensorinfo("WA_TL_".$name,"Slim-edge 1x1 automatically added to the database",$wafid);
  		sensorinfo("WA_BL_".$name,"Slim-edge 1x1 automatically added to the database",$wafid);
  		sensorinfo("WA_TR_".$name,"Slim-edge 1x1 automatically added to the database",$wafid);
  		sensorinfo("WA_BR_".$name,"Slim-edge 1x1 automatically added to the database",$wafid);
  		#sensorinfo("WD_TL_".$name,"Diode automatically added to the database",$wafid);
  		#sensorinfo("WD_TR_".$name,"Diode automatically added to the database",$wafid);
  		#sensorinfo("WD_BL_".$name,"Diode automatically added to the database",$wafid);
  		#sensorinfo("WD_BR_".$name,"Diode automatically added to the database",$wafid);
	}
	exit();
}
?>
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>6" Wafer Submission</title>
  <script src="../js/wafersubmit.js">
  </script>
  <link rel="stylesheet" type="text/css" href="../css/wafersubmit.css" />
</head>
<body>
<form  method="post" enctype="multipart/form-data">

<div> 
	<div class="div1">Wafer Number <textarea cols="3" rows="1" id="wafer_id" name="wafer_id" maxlength="3" ></textarea></div>
	<div id="wafresp" class="div2"></div>
</div>
<br>
<br>
<div>
	<div class="div3">Receive Date (YYYY/MM/DD)<textarea cols="10" rows="1" id="receive" name="receive" maxlength="10"></textarea></div>
	<div id="dateresp" class="div4"></div>
</div>
<br>
<br>
Additional Notes <textarea cols="40" rows="5" name="notes"></textarea>
<br>
<br>

<?php

if(isset($_GET['submitted'])){
	echo "Wafer ".$_GET['submitted']." and all associated sensors added to the database.<br>";
}

conditionalSubmit(1);
?>

</form>
<br>
<form method="link" action="../index.php">
<input type="submit" value="MAIN MENU">
</form>
</body>
</html>
