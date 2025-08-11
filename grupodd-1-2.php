<?php

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();




$idg = $_REQUEST['IDG'];
$maximoCupo = $_REQUEST['maximoCupo'];
$celda = $_REQUEST['celda'];
switch ($celda) {
	case 3:
		$campo = 'MxD';
		break;
	case 4:
		$campo = 'MxP';
		break;
}
$result = mysqli_query($GLOBALS['link'], "Update _trestricionesbb  Set " . $campo . "=" . $maximoCupo . " where IDG=" . $idg);

echo json_encode($result);
