<?php
include('../../../Submission_p_secure_pages/connect.php');
include('../functions/submitfunctions.php');
include('../functions/popfunctions.php');
include('../functions/curfunctions.php');
include('../functions/editfunctions.php');

$gets = "?modules=".$_POST['modules'];

header("Location: ROCedit.php".$gets);


mysql_query('USE cmsfpix_u', $connection);


if(isset($_POST['submit']) && isset($_POST['spin']) && isset($_POST['flip'])){

	spinROCs($_POST['modules']);
	flipROCs($_POST['modules']);

}
else if(isset($_POST['submit']) && isset($_POST['spin'])){

	spinROCs($_POST['modules']);

}
else if(isset($_POST['submit']) && isset($_POST['flip'])){

	flipROCs($_POST['modules']);

}

else if(isset($_POST['submit']) && isset($_POST['ROC0'])){
	
	$j = 0;

	for($j=0;$j<16;$j++){

		$roctag = 'ROC'.$j;
		$sqlroc = mysql_real_escape_string($_POST[$roctag]);
		$func2 = 'UPDATE ROC_p SET name="'.$sqlroc.'" WHERE assoc_module='.$_POST['modules'].' AND position='.$j;

		if(!mysql_query($func2,$connection)){
			echo "An error occurred and the changes have not been added to the database.";
		break;
		}

	}
	echo "Changes added to the database.";

	$func3 = 'UPDATE module_p SET has_ROC=\"1\" WHERE id='.$_POST['modules'];
	mysql_query($func3, $connection);
}
?>
