<?php
include('../functions/submitfunctions.php');

$fp = fopen('php://stdin','r');
$user = unserialize(fgets($fp));
$tmpname = unserialize(fgets($fp));
$name = unserialize(fgets($fp));
$size = unserialize(fgets($fp));
fclose($fp);

	bigbatch($tmpname,$name,$size, $user);
?>
