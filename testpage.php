<?php

ini_set('display_errors','On');
error_reporting(E_ALL | E_STRICT);

#phpinfo();

$im = new imagick('/project/cmsfpix/.www/Submission_p/pics/module_p/module_p154pic2.jpg[0]');
$im->setImageFormat('jpg');
header('Content-Type: image/jpeg');
echo $im;

?>
