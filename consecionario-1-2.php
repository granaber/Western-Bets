<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$pr = $_REQUEST['pr'];

$serverA =  'localhost'; //zuloteria.db.5144062.hostedresource.com;localhost
$userA =  'plinea_animalito'; //root; bancala_loteria
$clvA =  'T-!OV33R}e;}'; //Legna113;intra
$dbA = 'tujugada_animalitos'; //bancala_loteria; lotery


if ($pr == 1) :
	$idc = $_REQUEST['idc'];
	$nm = $_REQUEST['nm'];
	$dr = $_REQUEST['dr'];
	$est = $_REQUEST['est'];
	$mup = $_REQUEST['mup'];
	$tel = $_REQUEST['tel'];
	$idg = $_REQUEST['idg'];
	$es = $_REQUEST['es'];
	$idr = $_REQUEST['idr'];
	$cel = $_REQUEST['cel'];
	$mail = $_REQUEST['mail'];
	$resp = $_REQUEST['resp'];
	$tb = $_REQUEST['tb'];
	$idm = $_REQUEST['idm'];

	$grabar = false;
	if ($idc != '') :
		if ($nm != '') :
			if ($dr != '') :
				if ($est != '') :
					if ($mup != '') :
						$grabar = true;
					else :
						$error = 5;
					endif;
				else :
					$error = 4;
				endif;
			else :
				$error = 3;
			endif;
		else :
			$error = 2;
		endif;
	else :
		$error = 1;
	endif;


	$result = mysqli_query($GLOBALS['link'], "Select * from _tconsecionario where IDRow=" . $idr);
	if (mysqli_num_rows($result) == 0) :
		if ($grabar) :
			$result = mysqli_query($GLOBALS['link'], "Select * from _tconsecionario where IDC='$idc'");

			if (mysqli_num_rows($result) == 0) :
				$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tconsecionario  (IDRow,Nombre,Telefono,Estatus,Direccion,Estado,Municipio,IDG,IDC,celular,email,responsable,tb,idm) VALUES (" . $idr . ",'" . $nm . "','" . $tel . "'," . $es . ",'" . $dr . "','" . $est . "','" . $mup . "'," . $idg . ",'" . $idc . "','" . $cel . "','" . $mail . "','" . $resp . "'," . $tb . "," . $idm . ")"); ////<----- Corregir datos
				Logs($_REQUEST['idt'], -2, 'Creacion de Concesionario ' . $idc, 1);
				$error = 0;
			else :
				$error = 6;
			endif;
		endif;






	else :
		if ($grabar) :
			$row = mysqli_fetch_array($result);
			$result = mysqli_query($GLOBALS['link'], "Update _tconsecionario  Set  idm=" . $idm . ",IDC='" . $idc . "',Nombre='" . $nm . "',celular='" . $cel . "',email='" . $mail . "',responsable='" . $resp . "',Telefono='" . $tel . "',Estatus=" . $es . ",Direccion='" . $dr . "',Estado='" . $est . "',Municipio='" . $mup . "',IDG=" . $idg . ",tb=" . $tb . " where IDRow=" . $idr);
			//echo ("Update _tconsecionario  Set  IDC='".$idc."',Nombre='".$nm."',celular='".$cel."',email='".$mail."',responsable='".$resp."',Telefono='".$tel."',Estatus=".$es.",Direccion='".$dr."',Estado='".$est."',Municipio='".$mup."',IDG=".$idg.",tb=".$tb." where IDRow=".$idr);
			Logs($_REQUEST['idt'], -2, 'Modificacion de Concesionario ' . $idc, 1);
			$error = 0;
			$OldIdc = $row['IDC'];
			$NewIdc = $idc;

			if ($OldIdc != $NewIdc) :
				/// Hacer Cambios en Animalitos!!!!
				$linkA = mysqli_connect($serverA, $userA, $clvA, $dbA);
				mysqli_query($linkA, "begin");
				$result = mysqli_query($linkA, "Update _Concesionario_Ani  Set  IDC='" . $NewIdc . "' where IDC='" . $OldIdc . "'");
				//echo "Update _Concesionario_Ani  Set  IDC='".$NewIdc."' where IDC='".$OldIdc."'";
				$result1 = mysqli_query($linkA, "Update _Concesionario_Ani_2  Set  IDC='" . $NewIdc . "' where IDC='" . $OldIdc . "'");
				//echo "Update _Concesionario_Ani_2  Set  IDC='".$NewIdc."' where IDC='".$OldIdc."'";
				$result2 = mysqli_query($linkA, "Update _Jugada_ani  Set  IDC='" . $NewIdc . "' where IDC='" . $OldIdc . "'");
				//echo "Update _Jugada_ani  Set  IDC='".$NewIdc."' where IDC='".$OldIdc."'";
				if ($result && $result1 && $result2) :
					mysqli_query($linkA, "commit");
					$error = 0;
				else :
					mysqli_query($linkA, "rollback");
					$error = 1;
				endif;
			/////////////////////////////

			else :
				$error = 0;
			endif;

		endif;

	endif;

	$aResul = array();
	if ($error == 0) :
		$aResul[] = $result;
		$aResul[] = $error;
	else :
		$aResul[] = false;
		$aResul[] = $error;
	endif;

	echo json_encode($aResul);

else :
	$idr = $_REQUEST['idr'];
	$result = mysqli_query($GLOBALS['link'], 'Delete from _tconsecionario  where IDRow=' . $idr); ////<-----NO ES IDROW es IDC
	Logs($_REQUEST['idt'], -2, 'Eliminar de Concesionario ' . $idc, 1);
	echo json_encode($result);
endif;
