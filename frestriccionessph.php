<?php
require('prc_sph.php');
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$op = $_REQUEST["op"];

if ($op == 1) :
	$monto = $_REQUEST["monto"];
	$idcn = $_REQUEST["idcn"];

	echo json_encode(restricjugadasph($monto, $idcn));
endif;
if ($op == 2) :
	$monto = $_REQUEST["monto"];
	$idcn = $_REQUEST["idcn"];
	$jugada = $_REQUEST["jugada"];
	$idc = $_REQUEST["idc"];
	$idj = $_REQUEST["idj"];
	echo json_encode(restricjugadasph2($monto, $idcn, $jugada, $idc, $idj));
endif;
if ($op == 3) :
	$idcn = $_REQUEST["idcn"];
	$jugada = $_REQUEST["jugada"];
	$idj = $_REQUEST["idj"];
	$result = mysqli_query($GLOBALS['link'], 'Select * from  _tbbloquecmb where IDJ=' . $idj . ' and IDCN=' . $idcn);

	if (mysqli_num_rows($result) == 0) :
		$result = mysqli_query($GLOBALS['link'], 'Insert _tbbloquecmb values(' . $idj . ',' . $idcn . ',"' . $jugada . '","' . date("h:i:s A") . '")');
		$i = true;
	else :
		$result = mysqli_query($GLOBALS['link'], 'Delete from _tbbloquecmb where IDJ=' . $idj . ' and IDCN=' . $idcn);
		$i = false;
	endif;
	echo json_encode($i);

endif;

if ($op == 4) :
	$monto = $_REQUEST["monto"];
	$idcn = $_REQUEST["idcn"];
	$jugada = $_REQUEST["jugada"];
	$idc = $_REQUEST["idc"];
	$idj = $_REQUEST["idj"];
	echo json_encode(restricjugadasph3($monto, $idcn, $jugada, $idc, $idj));
endif;
