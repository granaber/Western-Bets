<?php
date_default_timezone_set('America/Caracas');
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


//$serial=bticket();
$serial = 1;
$jgd = $_REQUEST["jgd"];
$ap = $_REQUEST["ap"];
$aco = $_REQUEST["aco"];
$idj = $_REQUEST["idj"];
$terminal = $_REQUEST["termi"];
$idc = $_REQUEST["idc"];
$usu = $_REQUEST["usu"];
$grp = $_REQUEST["grp"];

$result2 = mysqli_query($GLOBALS['link'], "Select * From _tusu Where IDusu=" . $usu . " and Estatus=1");
if (mysqli_num_rows($result2) != 0) : // <== Si el Usuario no esta Bloqueado para la Venta!
	$reslval = array();
	$horaticket = Horareal($GLOBALS['minutosh'], "h:i:s A");
	$fechaactual = Fechareal($GLOBALS['minutosh'], "d/n/Y");
	$aco = recalculoTK(str_replace(')', '%', $jgd), $ap);

	if (restricciones5($idc, $idj, str_replace(')', '%', $jgd), ($aco - $ap))) :
		if (restricciones4($idc, $idj, str_replace(')', '%', $jgd), $ap)) :
			if (chkhora($idj, $horaticket)) :
				if (MaximoCantidaParlay($idc, $jgd)) :
					if (verificaciondeVenta($horaticket, $fechaactual)) : // <== Si No esta Cerrado para la Venta
						if (verificaciondeCUPO(str_replace(')', '%', $jgd), $idc, $ap, $idj)) : // <== Si No Sobrepasa el Cupo Maximo de Venta!
							if (verificaciondejugada($horaticket, str_replace(')', '%', $jgd), $idj, $fechaactual, $idc)) : // <== Si No Hay Partidos Cerrados
								$idcram = rand(1, 2);
								if ($idcram == 1) :
									$se = rand(1, 9) . rand(1, $serial) . '-' . rand(1, 9) . rand(1, $idj) . '-' . substr($serial, 2, 1);
								else :
									$se = rand(1, $serial) . '-' . rand(1, 9) . rand(1, $idj) . '-' . substr($serial, 2, 1) . rand(1, 9) . '-' . rand(1, 9) . rand(1, $ap);
								endif;

								$ip = getip();
								if (empty($ip) || !preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $ip)) : $ip = $_SERVER["REMOTE_ADDR"];
								endif;

								//$result2 = mysqli_query($GLOBALS['link'],"INSERT INTO _tjugadabb2  VALUES (".$serial.",".$idj.",'".str_replace (')','%',$jgd)."',".$ap.",".$aco.",'".$se."','".$idc."','".$horaticket."',".$terminal.",'',".$usu.",".$grp.",1,0,'','".$ip."',0,'','')");  
								$result = true;
								//$result = mysqli_query($GLOBALS['link'],"INSERT INTO _tjugadabb  VALUES (".$serial.",".$idj.",'".str_replace (')','%',$jgd)."',".$ap.",".$aco.",'".$se."','".$idc."','".$horaticket."',".$terminal.",'',".$usu.",".$grp.",1,0,'','".$ip."',0,'','')");  

								/// Si fue Aceptado en la Tabla Error:2
								if ($result) :
									$reslval[0] = $result;
									$reslval[1] = $se;
									$reslval[2] = $serial;
								else :
									$reslval[0] = false;
									$reslval[1] = '2';
								endif;
							////////////////////////////////
							else :
								/// Si Hay Partidos Cerrados Error:0
								$reslval[0] = false;
								$reslval[1] = '0';
							endif;
						else :
							/// Si Sobrepaso el Cupo Maximo de Venta
							$reslval[0] = false;
							$reslval[1] = '4';
						endif;
					else :
						/// Si Esta Cerrado para la Venta Error:3
						$reslval[0] = false;
						$reslval[1] = '3';
					endif;
				else :
					/// Si Hace mas Parlay que el Permitido Error:5
					$reslval[0] = false;
					$reslval[1] = '5';
				endif;
			else :
				/// Hay Problema con la Hora No puede HAcer el Ticket Error:6
				$reslval[0] = false;
				$reslval[1] = '6';
			endif;
		else :
			/// Restricciones
			$reslval[0] = false;
			$reslval[1] = '7';
			$reslval[2] = 'CUPO RUNLINE-6:USTED NO DISPONE DEL SUFICIENTE CUPO DE RL PARA ESTA APUESTA!';
		endif;
	else :
		/// Restricciones
		$reslval[0] = false;
		$reslval[1] = '7';
		$reslval[2] = 'TOPE MAXIMO-7:Usted No tiene suficiente Tope de Ganacias para Esta Apuesta!';
	endif;
else :
	/// Si Esta Bloqueado el Usuario Error:1
	$reslval[0] = false;
	$reslval[1] = '1';
endif;
if (!$reslval[0]) :
	$result3 = mysqli_query($GLOBALS['link'], "INSERT INTO _tbreback  VALUES (" . $serial . ",'" . $idc . "'," . $reslval[1] . ");");
endif;

echo (json_encode($reslval));

function chkhora($idj, $horaticket)
{
	$result2 = mysqli_query($GLOBALS['link'], "Select * From _tbhora2 Where IDJ=$idj");
	if (mysqli_num_rows($result2) != 0) :
		$row2 = mysqli_fetch_array($result2);
		$hora = convertirMilitar($horaticket);
		$horaold = convertirMilitar($row2['HoraActual']);

		if (calculodeMinutos('1/1/2009', $horaold, $hora) < 0) :
			$respuesta = false;
		else :
			$respuesta = true;
			$result = mysqli_query($GLOBALS['link'], "Update _tbhora2  Set HoraActual='$horaticket' where IDJ=$idj");
		endif;
	else :
		$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tbhora2  VALUES ($idj,'$horaticket')");
		$respuesta = true;
	endif;

	return  $respuesta;
}

function verificaciondeVenta($horaticket, $fecha)
{
	$permitirgrabar = true;
	$hora = convertirMilitar($horaticket);
	$dia = date('N', str2date($fecha));

	$result2 = mysqli_query($GLOBALS['link'], "Select * From _thorariodeventas Where Dia=" . $dia);

	if (mysqli_num_rows($result2) != 0) :
		$row2 = mysqli_fetch_array($result2);
		$permitirgrabar = EntreHoras($hora, $row2['HoradeVenta'], $row2['HoradeCierre']);
	endif;

	return $permitirgrabar;
}


function verificaciondeCUPO($jugada, $idc, $ap, $idj)
{
	$permitirgrabar = true;

	$jgdad = explode('*', $jugada);

	$cantidad = count($jgdad) - 1;
	$suma = 0;
	if ($cantidad != 0) :
		$result2 = mysqli_query($GLOBALS['link'], "Select * From _tbrestriccionesxparlay Where IDC='$idc' and Cantidad=$cantidad");
		if (mysqli_num_rows($result2) != 0) :

			$equia = array();
			$iddda = array();
			for ($k = 0; $k <= (count($jgdad) - 1); $k++) {
				$opcion = explode('|', $jgdad[$k]);
				$logro = $opcion[1];
				$opcion1 = explode('%', $opcion[0]);
				$carr = $opcion1[1];
				$opcion2 = explode('-', $opcion1[0]);
				$equi = $opcion2[0];
				$iddd = $opcion2[1];
				$equia[$k] = $equi;
				$iddda[$k] = $iddd;
			}
			array_pop($equia);
			sort($equia);
			array_pop($iddda);
			sort($iddda);
			// print_r($equia);echo'<br>'; 	 print_r($iddda);echo'<br>'; 
			$row2 = mysqli_fetch_array($result2);
			$montodeventa = $row2['MontodeVenta'];
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb  where IDC='$idc' and idj=$idj and activo=1");

			while ($row2 = mysqli_fetch_array($result)) {
				$jud = $row2['Jugada'];
				$jgdad = explode('*', $jud);

				if ((count($jgdad) - 1) == $cantidad) :

					for ($k = 0; $k <= (count($jgdad) - 1); $k++) {
						$opcion = explode('|', $jgdad[$k]);
						$logro = $opcion[1];
						$opcion1 = explode('%', $opcion[0]);
						$carr = $opcion1[1];
						$opcion2 = explode('-', $opcion1[0]);
						$equi = $opcion2[0];
						$iddd = $opcion2[1];
						$equic[$k] = $equi;
						$idddc[$k] = $iddd;
					}
					array_pop($equic);
					sort($equic);
					array_pop($idddc);
					sort($idddc);
					$result1 = array_diff($equia, $equic);
					$result2 = array_diff($iddda, $idddc);
					if (count($result1) == 0 && count($result2) == 0) :
						$suma += intval($row2['ap']);
					endif;
				endif;
			}
			// echo $suma;
			if ($ap <= ($montodeventa - $suma)) :	$permitirgrabar = true;
			else : 	$permitirgrabar = false;
			endif;
		endif;
	else :
		$permitirgrabar = false;
	endif;

	return $permitirgrabar;
}

function verificaciondejugada($horaticket, $jugada, $idj, $fecha, $idc)
{
	$permitirgrabar = true;
	$hora = convertirMilitar($horaticket);



	$result2 = mysqli_query($GLOBALS['link'], "Select * From _jornadabb Where Fecha='" . $fecha . "'");

	if (mysqli_num_rows($result2) != 0) :
		$row2 = mysqli_fetch_array($result2);
		$IDJReal = $row2['IDJ'];
	else :
		$IDJReal = 0;
	endif;

	if ($IDJReal == $idj) :
		$jgdad = explode('*', $jugada);

		for ($u = 0; $u <= count($jgdad) - 2; $u++) {
			$opcion = explode('|', $jgdad[$u]);
			$logro = $opcion[1];
			$opcion1 = explode('%', $opcion[0]);
			$carr = $opcion1[1];
			$opcion2 = explode('-', $opcion1[0]);
			$equi = $opcion2[0];
			$iddd = $opcion2[1];

			$result2 = mysqli_query($GLOBALS['link'], "Select * From _partidosbb Where (IDE1=" . $equi . " or IDE2=" . $equi . ") and IDJ=" . $idj);
			$row2 = mysqli_fetch_array($result2);
			echo $row2['Hora'] . '<br>';
			echo $hora . '<br>';
			echo diferenciadehoras('1/1/2009', $row2['Hora'], $hora) . '<br>';
			if (diferenciadehoras('1/1/2009', $row2['Hora'], $hora)) :
				$permitirgrabar = false;
				break;
			endif;
		}

		if ($permitirgrabar) :
			$permitirgrabar = maximodeparlay($idj, $idc, $jugada);
		endif;

		return 	$permitirgrabar;

	else :
		cerratodos($idj);
		return 	false;
	endif;
}



function diferenciadehoras($fecha, $hora1, $hora2)
{
	$horaM = explode(":", $hora1);
	$fechaMK = explode("/", $fecha);
	if ($horaM[2] == '') : $horaM[2] = 0;
	endif;
	$fechaMK1 = mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);


	$horaM = explode(":", $hora2);
	$fechaMK = explode("/", $fecha);
	if ($horaM[2] == '') : $horaM[2] = 0;
	endif;
	$fechaMK2 =  mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);

	$respuesta = $fechaMK1 <= $fechaMK2;
	return $respuesta;
}

function cerratodos($IDJ)
{
	global $minutosa;
	$resultp1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb where IDJ=" . $IDJ);

	while ($row1 = mysqli_fetch_array($resultp1)) {
		$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrebb where IDJ=" . $IDJ . " and IDP=" . $row1['IDP'] . " and Grupo=" . $row1['Grupo']);

		if (mysqli_num_rows($result3) == 0) :
			$result = mysqli_query($GLOBALS['link'], "INSERT INTO _cierrebb  VALUES (" . $row1['IDP'] . "," . $IDJ . ",'" . Horareal($minutosa, "h:i:s A") . "','" . Fechareal($minutosa, "d-m-y") . "',-2," . $row1['Grupo'] . ")");
		endif;
	}
}
function maximodeparlay($IDJ, $IDC, $Jugada)
{
	$estado = true;

	$resultconf = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionariodd where IDC='" . $IDC . "'");

	if (mysqli_num_rows($resultconf) != 0) :
		$row_cnf = mysqli_fetch_array($resultconf);

		if ($row_cnf['cdpi'] != 0) :
			$result_Cuenta = mysqli_query($GLOBALS['link'], "SELECT count(serial) as total  FROM _tjugadabb where IDJ=" . $IDJ . " and IDC='" . $IDC . "' and Activo=1 and Jugada Like '" . $Jugada . "'");
			$row_Cuenta = mysqli_fetch_array($result_Cuenta);

			if ($row_Cuenta['total'] > $row_cnf['cdpi']) :
				$estado = false;
			endif;
		endif;

	endif;

	return $estado;
}
function MaximoCantidaParlay($IDC, $jugada)
{
	$estado = true;
	$jgdad = explode('*', $jugada);
	$Cuantos = count($jgdad) - 1;

	$resultconf = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionariodd where IDC='" . $IDC . "'");
	if (mysqli_num_rows($resultconf) != 0) :
		$row_cnf = mysqli_fetch_array($resultconf);
		if ($Cuantos <= $row_cnf['cjmp']) :
			$estado = true;
		else :
			$estado = false;
		endif;
	endif;

	return $estado;
}

function restricciones4($conce, $idj, $jugada, $ap)
{
	$arr = array(true, 0, 0);

	$jgdad = explode('*', $jugada);
	$cantidad = count($jgdad) - 1;

	if ($cantidad == 1) :
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionariodd  where idc='" . $conce . "'");

		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);

			if ($row['pdrl'] != 0) :
				$arr[0] = false;
				$arr[1] = 0;
				$arr[2] = $ap;

				$suma = 0;
				$jgdad = explode('*', $jugada);
				$opcion = explode('|', $jgdad[0]);
				$logro = $opcion[1];
				$opcion1 = explode('%', $opcion[0]);
				$carr = $opcion1[1];
				$opcion2 = explode('-', $opcion1[0]);
				$equic = $opcion2[0];
				$iddd = $opcion2[1];
				//echo $iddd;
				if (intval($iddd) == 5) :
					$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb  where idc='" . $conce . "' and idj=" . $idj . " and activo=1");

					while ($row2 = mysqli_fetch_array($result)) {

						$jud = $row2['Jugada'];
						$jgdad = explode('*', $jud);

						if (count($jgdad) == 2) :
							$opcion = explode('|', $jgdad[0]);
							$logro = $opcion[1];
							$opcion1 = explode('%', $opcion[0]);
							$carr = $opcion1[1];
							$opcion2 = explode('-', $opcion1[0]);
							$equi = $opcion2[0];
							$iddd = $opcion2[1];
							//echo $iddd;
							if (intval($iddd) == 5) :
								if (intval($equi) == intval($equic)) :
									$suma += intval($row2['ap']);
								endif;
							endif;
						endif;
					}
					//echo $suma;
					$arr[0] = false;
					$arr[2] = intval($row['pdrl']) - $suma;
				endif;
			endif; //if ($row['pdrl']!=0):

		endif; //   if (mysqli_num_rows($result)!=0):

	endif;
	//print_r($arr);
	if ($arr[0]) :
		return (true);
	else :
		if ($ap <= $arr[2]) :
			return (true);
		else :
			return (false);
		endif;
	endif;
}
function restricciones5($conce, $idj, $jugada, $acobrar)
{
	$arr = array(true, 0, 0);

	$jgdad = explode('*', $jugada);
	$cantidad = count($jgdad) - 1;

	if ($cantidad == 1) :
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionariodd  where idc='" . $conce . "'");

		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);

			if ($row['mxpjpd'] != 0) :
				$arr[0] = false;
				$arr[1] = 0;
				$arr[2] = $acobrar;

				$suma = 0;
				$jgdad = explode('*', $jugada);
				$opcion = explode('|', $jgdad[0]);
				$logro = $opcion[1];
				$opcion1 = explode('%', $opcion[0]);
				$carr = $opcion1[1];
				$opcion2 = explode('-', $opcion1[0]);
				$equic = $opcion2[0];
				$idddc = $opcion2[1];
				$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb  where idc='" . $conce . "' and idj=" . $idj . " and activo=1");

				while ($row2 = mysqli_fetch_array($result)) {

					$jud = $row2['Jugada'];
					$jgdad = explode('*', $jud);

					if (count($jgdad) == 2) :
						$opcion = explode('|', $jgdad[0]);
						$logro = $opcion[1];
						$opcion1 = explode('%', $opcion[0]);
						$carr = $opcion1[1];
						$opcion2 = explode('-', $opcion1[0]);
						$equi = $opcion2[0];
						$iddd = $opcion2[1];
						//echo $iddd;
						if (intval($iddd) == intval($idddc)) :
							if (intval($equi) == intval($equic)) :
								$suma += intval($row2['acobrar']);
							endif;
						endif;
					endif;
				}
				//echo $suma;   echo '<br>';
				$arr[0] = false;
				$arr[2] = intval($row['mxpjpd']) - $suma;

			endif; //if ($row['pdrl']!=0):

		endif; //   if (mysqli_num_rows($result)!=0):

	endif;
	// print_r($arr);
	// echo '<br>'.$acobrar;
	if ($arr[0]) :
		return (true);
	else :
		if ($acobrar <= $arr[2]) :
			return (true);
		else :
			return (false);
		endif;
	endif;
}
