<?php

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$pr = $_REQUEST['pr'];

if ($pr == 1) :
	$idg = $_REQUEST['idg'];
	$nm = $_REQUEST['nm'];
	$res = $_REQUEST['res'];
	$es = $_REQUEST['es'];

	if ($nm != '') :
		if ($res != '') :
			$estatus = 0;
		else :
			$estatus = 3;
		endif;
	else :
		$estatus = 4;
	endif;

	if ($estatus == 0) :
		$result = mysqli_query($GLOBALS['link'], "Select * from _tbanca where IDB=" . $idg);
		if (mysqli_num_rows($result) == 0) :
			$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tbanca VALUES (" . $idg . ",'" . $nm . "','" . $res . "',''," . $es . ")");
		else :
			$result = mysqli_query($GLOBALS['link'], "Update _tbanca  Set NombreB='" . $nm . "',Propietario='" . $res . "',Estatus=" . $es . " where IDB=" . $idg);
		endif;
		if (!$result) :
			$estatus = 5;
		endif;
	endif;

	if ($estatus == 0) :
		$resultado[] = true;
	else :
		$resultado[] = false;
		switch ($estatus) {
			case 1:
				$resultado[] = 'LA  DIRECCION NO PUEDE ESTAR EN BLANCO!';
				break;
			case 2:
				$resultado[] = 'EL TELEFONO NO PUEDE ESTAR EN BLANCO!';
				break;
			case 3:
				$resultado[] = 'EL RESPONSABLE  NO PUEDE ESTAR EN BLANCO!';
				break;
			case 4:
				$resultado[] = 'EL NOMBRE  NO PUEDE ESTAR EN BLANCO!';
				break;
			case 5:
				$resultado[] = 'NO PUEDO ACTUALIZAR INTENTE DE NUEVO!';
				break;
		}
	endif;
	echo json_encode($resultado);
else :
	$idg = $_REQUEST['idg'];
	$result1 = mysqli_query($GLOBALS['link'], "Delete from _tbanca  where IDB=" . $idg);
	echo json_encode($result1);
endif;
