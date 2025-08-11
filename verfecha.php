<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$fc = $_REQUEST["fc"];

$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
if (mysqli_num_rows($resultj) != 0) :
	$rowj = mysqli_fetch_array($resultj);
	$idj = $rowj["IDJ"];
else :
	$idj = 0;
	$idc = '';
endif;

echo json_encode($idj);
