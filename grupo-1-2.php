<?php

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$pr = $_REQUEST['pr'];

if ($pr == 3) :
	$idg = $_REQUEST['IDG'];
	$maximoCupo = $_REQUEST['maximoCupo'];
	$result = mysqli_query($GLOBALS['link'], "Update _tbrestriccionbygrupo  Set MaximoCupo=" . $maximoCupo . " where IDG=" . $idg);
	echo json_encode($result);
else :
	if ($pr == 1) :
		$idg = $_REQUEST['idg'];
		$nm = $_REQUEST['nm'];
		$res = $_REQUEST['res'];
		$tlf = $_REQUEST['tlf'];
		$dr = $_REQUEST['dr'];
		$es = $_REQUEST['es'];
		$IDB = $_REQUEST['IDB'];
		$participacion = $_REQUEST['participa'];
		$porce_derecho = $_REQUEST['porce_derecho'];
		$porce_parlay = $_REQUEST['porce_parlay'];


		if ($nm != '') :
			if ($res != '') :
				if ($tlf != '') :
					if ($dr != '') :
						$estatus = 0;
					else :
						$estatus = 1;
					endif;
				else :
					$estatus = 2;
				endif;
			else :
				$estatus = 3;
			endif;
		else :
			$estatus = 4;
		endif;

		if ($estatus == 0) :
			$result = mysqli_query($GLOBALS['link'], "Select * from _tgrupo where IDG=" . $idg);
			if (mysqli_num_rows($result) == 0) :
				$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tgrupo VALUES (" . $idg . ",'" . $nm . "','" . $res . "','" . $tlf . "','" . $dr . "'," . $es . ",$participacion,$IDB,$porce_parlay,$porce_derecho)");
			else :
				$result = mysqli_query($GLOBALS['link'], "Update _tgrupo  Set Descrip='" . $nm . "',Responsable='" . $res . "',Telefono='" . $tlf . "',Direccion='" . $dr . "',Estatus=" . $es . ",Participacion=$participacion,IDB=$IDB,porce_parlay=$porce_parlay,porce_derecho=$porce_derecho where IDG=" . $idg);

			endif;
			if ($result) :
				$result = mysqli_query($GLOBALS['link'], "Select * from _tbrestriccionbygrupo where IDG=" . $idg);
				if (mysqli_num_rows($result) == 0) :
					$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tbrestriccionbygrupo VALUES (" . $idg . ",0)");
				endif;
				$result = mysqli_query($GLOBALS['link'], "Select * from _trestricionesbb where IDG=" . $idg);
				if (mysqli_num_rows($result) == 0) :
					$result = mysqli_query($GLOBALS['link'], "INSERT INTO _trestricionesbb VALUES (" . $idg . ",0,0)");
				endif;
			else :
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
		$result = mysqli_query($GLOBALS['link'], "Delete from _tbrestriccionbygrupo  where IDG=" . $idg);
		$result = mysqli_query($GLOBALS['link'], "Delete from _trestricionesbb  where IDG=" . $idg);
		$result1 = mysqli_query($GLOBALS['link'], "Delete from _tgrupo  where IDG=" . $idg);
		echo json_encode($result1);
	endif;
endif;
