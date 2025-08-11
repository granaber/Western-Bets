<?php
date_default_timezone_set('America/Caracas');
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


$serial = bticket();
$jgd = $_REQUEST["jgd"];
$ap = $_REQUEST["ap"];
$aco = $_REQUEST["aco"];
$idj = $_REQUEST["idj"];
$terminal = $_REQUEST["termi"];
$idc = $_REQUEST["idc"];
$usu = $_REQUEST["usu"];
$grp = $_REQUEST["grp"];
$ArrJugada = array();

$aequipo1 = array();
$aequipo2 = array();
$aiddd = array();
$agrupo = array();
$aNoCombinar = array();
$aPosicion = array();
$eAB = false; //<= Auto
$tablaID = 0;
$result2 = mysqli_query($GLOBALS['link'], "Select * From _tconsecionariodd Where IDC='$idc' ");
if (mysqli_num_rows($result2) != 0) :
	$row2 = mysqli_fetch_array($result2);
	if ($row2['ventaMin'] != -1) {
		if (!(floatval($ap) >= floatval($row2['ventaMin']))) {
			/// Restricciones
			$reslval[0] = false;
			$reslval[1] = '7';
			$reslval[2] = 'VENTAS MAXIMAS-11:El monto minimo del ticket es de:' . $row2['ventaMin'];
			echo (json_encode($reslval));
			exit;
		}
	}
endif;
////////////////////////////////////////////////
$respuesta = rst2($idc, $idj, str_replace(')', '%', $jgd), $aco, $ap);
if ($respuesta !== 0) {
	switch ($respuesta) {
		case 1:
			$reslval[0] = false;
			$reslval[1] = '7';
			$reslval[2] = '3:La apuesta que usted ha seleccionado, ha sobrepasado el Monto del Premio Permitido!';
			echo (json_encode($reslval));
			exit;
		case 2:
			$reslval[0] = false;
			$reslval[1] = '7';
			$reslval[2] = '2:La apuesta que usted ha seleccionado, ha sobrepasado el monto permitido!';
			echo (json_encode($reslval));
			exit;
		case 3:
			$reslval[0] = false;
			$reslval[1] = '7';
			$reslval[2] = '1:La apuesta que usted ha seleccionado, ha sobrepasado el monto permitido!';
			echo (json_encode($reslval));
			exit;
	}
}
////////////////////////////////////////////////

$result2 = mysqli_query($GLOBALS['link'], "Select * From _tusu Where IDusu=" . $usu . " and Estatus=1");
if (mysqli_num_rows($result2) != 0) : // <== Si el Usuario no esta Bloqueado para la Venta!
	$valores = verificaciondelogros(str_replace(')', '%', $jgd), $idj, $idc);
	if ($valores[0]) :
		if ($valores[2]) : $jgd = $valores[1] . '*';
			$njgd = $valores[1];
		else : $njgd = '0';
		endif;
		if (verificaciondeCombina($idc)) :
			$reslval = array();
			$horaticket = Horareal($GLOBALS['minutosh'], "h:i:s A");
			$fechaactual = Fechareal($GLOBALS['minutosh'], "d/n/Y");
			$aco = recalculoTK(str_replace(')', '%', $jgd), $ap);
			$veri = Restri_Derecho($idc, $idj, str_replace(')', '%', $jgd), $ap);
			if ($veri[0]) :
				if (restricciones5($idc, $idj, str_replace(')', '%', $jgd), ($aco - $ap))) :
					if (restricciones4($idc, $idj, str_replace(')', '%', $jgd), $ap)) :
						if (chkhora($idj, $horaticket)) :
							if (MaximoCantidaParlay($idc, $jgd)) :
								if (verificaciondeVenta($horaticket, $fechaactual)) : // <== Si No esta Cerrado para la Venta
									if (verificaciondeCUPO(str_replace(')', '%', $jgd), $idc, $ap, $idj)) : // <== Si No Sobrepasa el Cupo Maximo de Venta!
										if (verificaciondejugada($horaticket, str_replace(')', '%', $jgd), $idj, $fechaactual, $idc)) : // <== Si No Hay Partidos Cerrados ////

											$veri = escrute_jugada($ArrJugada, $idc);

											if ($veri[0]) : ////$arr[0]=false; $arr[1]=$row['Minimas']; $arr[2]=$rowG['Descripcion']; $arr[3]=1;

												$veri2 = cRdSaldo($idc, $ap, $idj, 'D', $serial);
												if ($veri2[0]) :

													if (!maximodeparlay($idj, $idc, str_replace(')', '%', $jgd), $ap)) :  // <= Maximo de Apuesta del ticket con Numero de parlay
														/// Restricciones
														$reslval[0] = false;
														$reslval[1] = '7';
														$reslval[2] = 'TOPE MAXIMO-10:El Monto de la Apuesta o el Numero de Parlay(s) fue rebasado!';
														$result3 = mysqli_query($GLOBALS['link'], "INSERT INTO _tbreback  VALUES (" . $serial . ",'" . $idc . "'," . $reslval[1] . ");");

														echo (json_encode($reslval));
														exit;
													endif;


													$idcram = rand(1, 2);
													if ($idcram == 1) :
														$se = rand(1, 9) . rand(1, $serial) . '-' . rand(1, 9) . rand(1, $idj) . '-' . substr($serial, 2, 1);
													else :
														$se = rand(1, $serial) . '-' . rand(1, 9) . rand(1, $idj) . '-' . substr($serial, 2, 1) . rand(1, 9) . '-' . rand(1, 9) . rand(1, $ap);
													endif;

													$ip = getip();
													if (empty($ip) || !preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $ip)) : $ip = $_SERVER["REMOTE_ADDR"];
													endif;

													$result2 = mysqli_query($GLOBALS['link'], "INSERT INTO _tjugadabb2  VALUES (" . $serial . "," . $idj . ",'" . str_replace(')', '%', $jgd) . "'," . $ap . "," . $aco . ",'" . $se . "','" . $idc . "','" . $horaticket . "'," . $terminal . ",''," . $usu . "," . $grp . ",1,0,'','" . $ip . "',0,'','')");
													$result = false;
													$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tjugadabb  VALUES (" . $serial . "," . $idj . ",'" . str_replace(')', '%', $jgd) . "'," . $ap . "," . $aco . ",'" . $se . "','" . $idc . "','" . $horaticket . "'," . $terminal . ",''," . $usu . "," . $grp . ",1,0,'','" . $ip . "',0,'','')");

													/// Si fue Aceptado en la Tabla Error:2
													if ($result) :
														$reslval[0] = $result;
														$reslval[1] = $se;
														$reslval[2] = $serial;
														if ($valores[2]) $reslval[3] = 1;
														else $reslval[3] = 0;
														$reslval[4] = ecoBase($njgd);
													else :
														$reslval[0] = false;
														$reslval[1] = '2';
													endif;
												////////////////////////////////
												else :
													$reslval[0] = false;
													$reslval[1] = '7';
													$reslval[2] = 'CREDITO -Ya Usted paso el limite de Credito (No tiene Saldo Suficiente para esta Venta) Saldo: ' . $veri2[1];
												endif;
											else :
												/// Restricciones Por Parlay Min y Max
												$reslval[0] = false;
												$reslval[1] = '7';
												if ($veri[3] == 1) :
													$reslval[2] = 'Bloqueo de Apuesta-Debe Seleccionar de ' . $veri[1] . ' o mas Combinaciones en ' . $veri[2];
												else :
													$reslval[2] = 'Bloqueo de Apuesta-Debe Seleccionar hasta de ' . $veri[1] . ' Combinaciones en ' . $veri[2];
												endif;
											endif;

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
				/// Restricciones Por Derecho en Restricciones
				$reslval[0] = false;
				if ($veri[1] == -1) :
					$reslval[1] = '7';
					$reslval[2] = 'Bloqueo de Apuesta-Esta Jugada Esta bloqueada para ser Vendida por Derecho';
				else :
					$reslval[1] = '7';
					$reslval[2] = 'Tope Maximo-El Tope Maximo para esta Jugada por Derecho Esta Bloqueada Restan (' . $veri[1] . ')';
				endif;
			endif;
		else :
			/// Restricciones de Combinaciones
			$reslval[0] = false;
			$reslval[1] = '7';
			$reslval[2] = 'COMBINACIONES-Estas Combinaciones dentro del ticket no estan permitidas!';
			$result2 = mysqli_query($GLOBALS['link'], "INSERT INTO _terrores VALUES (" . $idj . ",'" . str_replace(')', '%', $jgd) . "'," . $ap . "," . $aco . ",'" . $idc . "'," . $usu . ")");
		endif;
	else :
		/// Restricciones
		$reslval[0] = false;
		$reslval[1] = '7';
		$reslval[2] = 'ERROR EN LOGROS-Estos no son los logros Actualizados!';
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
	global $ArrJugada;
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

			$resultIDDD = mysqli_query($GLOBALS['link'], "Select * From _tbjuegodd  Where IDDD=" . $iddd);
			$rowIDDD = mysqli_fetch_array($resultIDDD);
			if (isset($ArrJugada[$rowIDDD['Grupo']])) :
				$ArrJugada[$rowIDDD['Grupo']]++;
			else :
				$ArrJugada[$rowIDDD['Grupo']] = 1;
			endif;

			$result2 = mysqli_query($GLOBALS['link'], "Select * From _partidosbb Where (IDE1=" . $equi . " or IDE2=" . $equi . ") and IDJ=" . $idj);
			$row2 = mysqli_fetch_array($result2);

			if (diferenciadehoras('1/1/2009', $row2['Hora'], $hora)) :
				$permitirgrabar = false;
				break;
			endif;
			if ($logro == 0 ||  $logro == '0' || $logro == '') :
				$permitirgrabar = false;
				break;
			endif;
		}

		/*if ($permitirgrabar):
				$permitirgrabar=maximodeparlay($idj,$idc,$jugada);
			endif;*/

		return 	$permitirgrabar;

	else :
		cerratodos($idj);
		return 	false;
	endif;
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
/*function maximodeparlay($IDJ,$IDC,$Jugada){
	$estado=true;

	$resultconf = mysqli_query($GLOBALS['link'],"SELECT * FROM _tconsecionariodd where IDC='".$IDC."'");

	if(mysqli_num_rows($resultconf)!=0):
		$row_cnf = mysqli_fetch_array($resultconf);

		if ($row_cnf['cdpi']!=0):
			$result_Cuenta= mysqli_query($GLOBALS['link'],"SELECT count(serial) as total  FROM _tjugadabb where IDJ=".$IDJ." and IDC='".$IDC."' and Activo=1 and Jugada Like '".$Jugada."'");
			$row_Cuenta= mysqli_fetch_array($result_Cuenta);

			if ($row_Cuenta['total']>$row_cnf['cdpi']):
				$estado=false;
			endif;
		endif;

	endif;

	return $estado;

}*/
function maximodeparlay($IDJ, $IDC, $Jugada, $ap)
{
	$estado = true;

	$jgdad = explode('*', $Jugada);
	$cantidad = count($jgdad) - 1;

	if ($cantidad > 1) :

		$resultconf = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionariodd where IDC='" . $IDC . "'");

		if (mysqli_num_rows($resultconf) != 0) :
			$row_cnf = mysqli_fetch_array($resultconf);
			if ($row_cnf['mma2'] != 0) :
				if ($ap <= $row_cnf['mma2']) :
					$evaluar = true;
				else :
					$evaluar = false;
				endif;
			else :
				$evaluar = true;
			endif;
			if ($evaluar) :
				if ($row_cnf['cdpi'] != 0) :
					$result_Cuenta = mysqli_query($GLOBALS['link'], "SELECT count(serial) as total  FROM _tjugadabb where IDJ=" . $IDJ . " and IDC='" . $IDC . "' and Activo=1 and Jugada Like '" . $Jugada . "'");
					$row_Cuenta = mysqli_fetch_array($result_Cuenta);

					if (($row_Cuenta['total'] + 1) > $row_cnf['cdpi']) :
						$estado = false;
					endif;
				endif;
			else :
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
								$suma += intval(($row2['acobrar'] - $row2['ap']));
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


//// restricciones de Jugada por Derecho /////


function Restri_Derecho($IDC, $IDJ, $jugada, $ap)
{
	$arr = array(true, 0, 0);

	$jgdad = explode('*', $jugada);
	$cantidad = count($jgdad) - 1;

	if ($cantidad == 1) :
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario  where idc='" . $IDC . "'");
		$row = mysqli_fetch_array($result);
		$IDG = $row['IDG'];
		$jgdad = explode('*', $jugada);
		$opcion = explode('|', $jgdad[0]);
		$logro = $opcion[1];
		$opcion1 = explode('%', $opcion[0]);
		$carr = $opcion1[1];
		$opcion2 = explode('-', $opcion1[0]);
		$equic = $opcion2[0];
		$iddd = $opcion2[1];

		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbreglas_1   Where IDC='$IDC' and IDG=0 and IDDD=$iddd and (monto<>0 or bloqueo<>0)");

		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			$arr = Search_Restri_Derecho($row, $arr, $iddd, $IDC, $IDJ, $equic, $ap);
		else :
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbreglas_1   Where IDC='0' and IDG=$IDG and IDDD=$iddd and (monto<>0 or bloqueo<>0)");
			if (mysqli_num_rows($result) != 0) :
				$row = mysqli_fetch_array($result);
				$arr = Search_Restri_Derecho($row, $arr, $iddd, $IDC, $IDJ, $equic, $ap);
			else :
				$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbreglas_1   Where IDC='0' and IDG=0 and IDDD=$iddd and (monto<>0 or bloqueo<>0)");

				if (mysqli_num_rows($result) != 0) :
					$row = mysqli_fetch_array($result);
					$arr = Search_Restri_Derecho($row, $arr, $iddd, $IDC, $IDJ, $equic, $ap);
				endif;
			endif;
		endif;

	endif;

	return $arr;
}
function Search_Restri_Derecho($row, $arr, $IDDD, $IDC, $IDJ, $equic, $ap)
{
	if ($row['bloqueo'] == 1) :
		$arr[0] = false;
		$arr[1] = -1; //<-Significa que esta Bloqueado!
	else :
		if ($row['monto'] != 0) :
			$SumaJugada = sumarIDDD_Derecho($IDDD, $IDC, $IDJ, $equic);

			if (($row['monto'] - $SumaJugada) < $ap) :
				$arr[0] = false;
				$arr[1] = ($row['monto'] - $SumaJugada); //<-Significa que esta Pasado por el Monto Maximo
			endif;
		endif;
	endif;

	return $arr;
}



function sumarIDDD_Derecho($IDDD, $IDC, $IDJ, $equic)
{
	$suma = 0;
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb  where idc='" . $IDC . "' and idj=" . $IDJ . " and activo=1");

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
			if (intval($iddd) == $IDDD) :
				if (intval($equi) == intval($equic)) :
					$suma += intval($row2['ap']);
				endif;
			endif;
		endif;
	}

	return $suma;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function escrute_jugada($ArrJugada, $IDC)
{
	$arr = array(true, 0, 0, 0);



	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario  where idc='" . $IDC . "'");
	$row = mysqli_fetch_array($result);
	$IDG = $row['IDG'];

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbreglas_2   Where IDC='$IDC' and IDG=0");

	if (mysqli_num_rows($result) != 0) :
		while ($row = mysqli_fetch_array($result)) {
			if (isset($ArrJugada[$row['Grupo']])) :
				$arr = EvaluarMaxMin($row, $ArrJugada, $arr);
				if (!$arr[0]) : break;
				endif;
			endif;
		}
	else :
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbreglas_2   Where IDC='0' and IDG=$IDG ");
		if (mysqli_num_rows($result) != 0) :
			while ($row = mysqli_fetch_array($result)) {
				if (isset($ArrJugada[$row['Grupo']])) :
					$arr = EvaluarMaxMin($row, $ArrJugada, $arr);
					if (!$arr[0]) : break;
					endif;
				endif;
			}
		else :
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbreglas_2   Where IDC='0' and IDG=0");

			if (mysqli_num_rows($result) != 0) :
				while ($row = mysqli_fetch_array($result)) {
					if (isset($ArrJugada[$row['Grupo']])) :
						$arr = EvaluarMaxMin($row, $ArrJugada, $arr);
						if (!$arr[0]) : break;
						endif;
					endif;
				}
			endif;
		endif;
	endif;



	return $arr;
}

function EvaluarMaxMin($row, $ArrJugada, $arr)
{
	if ($ArrJugada[$row['Grupo']] < $row['Minimas'] && $row['Minimas'] != 0) :
		$resultG = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd  Where Grupo=" . $row['Grupo']);
		$rowG = mysqli_fetch_array($resultG);
		$arr[0] = false;
		$arr[1] = $row['Minimas'];
		$arr[2] = $rowG['Descripcion'];
		$arr[3] = 1;

	endif;

	if ($ArrJugada[$row['Grupo']] > $row['Maximas'] && $row['Maximas'] != 0) :
		$resultG = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd  Where Grupo=" . $row['Grupo']);
		$rowG = mysqli_fetch_array($resultG);
		$arr[0] = false;
		$arr[1] = $row['Maximas'];
		$arr[2] = $rowG['Descripcion'];
		$arr[3] = 2;

	endif;


	return $arr;
}

$Posicion = 0;
function verificaciondelogros($jugada, $IDJ, $IDC)
{
	global $Posicion;
	global $aiddd;
	global $eAB; //<= Auto
	global $tablaID;

	// Auto
	$result2 = mysqli_query($GLOBALS['link'], "Select * From _tconsecionario Where IDC='$IDC'");
	$rowI2 = mysqli_fetch_array($result2);
	$tb = $rowI2['tb'];
	// Auto
	$IDB = WhatBanca($IDC);
	$jgdad = explode('*', $jugada);
	$equia = array();
	$iddda = array();
	$logro = array();
	$carr = array();
	//echo count( $jgdad ).'CountTT<br>';
	for ($k = 0; $k <= (count($jgdad) - 2); $k++) {
		$check = false;
		$opcion = explode('|', $jgdad[$k]);
		$logro = $opcion[1];
		$opcion1 = explode('%', $opcion[0]);
		$carr = $opcion1[1];
		$opcion2 = explode('-', $opcion1[0]);
		$equi = $opcion2[0];
		$iddd = $opcion2[1];
		$aiddd[] = $iddd;

		if (count($equia) == 0) :
			$clave1 = false;
			$clave2 = false;
		else :
			$clave1 = array_search($equi, $equia);
			$clave2 = array_search($iddd, $iddda);
		endif;


		$accder = true;
		if (($clave1 === false)) :
			$equia[$k] = $equi;
			$iddda[$k] = $iddd;
		else :
			if ($iddda[$clave1] != $iddd) :
				$equia[$k] = $equi;
				$iddda[$k] = $iddd;
			else :
				$accder = false;
			endif;
		endif;



		if ($accder) :
			$IDP =	 iLineaLogros($equi, $IDJ, $iddd);
			//echo $IDP.'IDP<br>';
			//				echo $Posicion.'Posicion<br>';

			$result2 = mysqli_query($GLOBALS['link'], "Select * From _configuracionjugadabb Where IDJ=$IDJ and IDDD=$iddd and IDP=$IDP and IDB=$IDB");
			//echo ("Select * From _configuracionjugadabb Where  IDJ=$IDJ and IDDD=$iddd and IDP=$IDP and IDB=$IDB");
			$rowI2 = mysqli_fetch_array($result2);
			$valores = explode('|',	$rowI2['Valores']);
			//echo count( $valores ).'Count<br>';
			// Auto
			if ($tb != 0) :
				//print_r($valores);
				$idg = $rowI2['Grupo'];
				$resultNK = mysqli_query($GLOBALS['link'], "Select * from _agendaNT where Grupo=$idg and IDB=$IDB and idj=$IDJ");
				$rowNK = mysqli_fetch_array($resultNK);
				$lisAUTO = explode(',', $rowNK['IDDDs']);

				if ($rowNK['apptbls'] != null)
					$appIDDD = explode(',', $rowNK['apptbls']);
				else
					$appIDDD = array();

				$busIDDS = array_search($iddd, $lisAUTO);

				if (count($appIDDD) != 0) {
					if (array_search($iddd, $appIDDD) === false) $busIDDS = false;
				}

				if ($busIDDS !== false) :
					$modo = 0;
					switch (count($valores)) {
						case 3:
							if ($valores[1] < 0 && $valores[0] < 0) :
								if ($valores[0] < $valores[1]) :
									$LogroM = $valores[0];
									$macho = 0;
								else :
									$LogroM = $valores[1];
									$macho = 1;
								endif;

							else :
								if ($valores[1] < 0) :
									$LogroM = $valores[1];
									$macho = 1;
								else :
									$LogroM = $valores[0];
									$macho = 0;
								endif;
							endif;
							$modo = 3;
							break;

						case 5:
							//-130|1.5|110|-1.5|
							if ($valores[2] < 0 && $valores[0] < 0) :
								if ($valores[0] < $valores[2]) :
									$LogroM = $valores[0];
									$macho = 0;
								else :
									$LogroM = $valores[2];
									$macho = 2;
								endif;
							else :
								if ($valores[2] < 0) :
									$LogroM = $valores[2];
									$macho = 2;
								else :
									$LogroM = $valores[0];
									$macho = 0;
								endif;
							endif;
							$modo = 5;
							break;
					}
					//print_r($valores);
					$tvalores = $valores;
					if ($modo != 0) : $valores = DBconver(1, $LogroM, $modo, $macho, $eAB, $tablaID);
						$valores[] = '';
					endif;
					if ($modo == 5) :
						$valores[1] = $tvalores[1];
						$valores[3] = $tvalores[3];
					endif;
				//print_r($valores);
				//echo $tb.' '.$LogroM.' '.$modo.' '.$macho.' '.$eAB;
				//print_r($valores);
				endif;

			endif;
			// Auto

			if (count($valores) == 5) :
				switch ($Posicion) {
					case 1:
						if ($valores[0] == $logro && $valores[1] == $carr) : $check = true;
						else : $logro = $valores[0];
							$carr = $valores[1];
							$Ncam = true;
						endif;
						break;
					case 2:
						if ($valores[2] == $logro && $valores[3] == $carr) : $check = true;
						else : $logro = $valores[2];
							$carr = $valores[3];
							$Ncam = true;
						endif;
						break;
				}
			endif;
			if (count($valores) == 3) :
				switch ($Posicion) {
					case 1:
						if ($valores[0] == $logro) : $check = true;
						else : $logro = $valores[0];
							$Ncam = true;
						endif;
						break;
					case 2:
						if ($valores[1] == $logro) : $check = true;
						else : $logro = $valores[1];
							$Ncam = true;
						endif;
						break;
				}
			endif;
			if (count($valores) == 2) :

				if ($valores[0] == $logro) : $check = true;
				else : $logro = $valores[0];
					$Ncam = true;
				endif;
			endif;
		endif;
		//if ( !$check ): break; endif;
		$nuevologro[$k] = $equi . '-' . $iddd . ')' . $carr . '|' . $logro;
	}


	return array(true, implode('*', $nuevologro), $Ncam);
}
function iLineaLogros($IDE, $IDJ, $iddd)
{
	global $Posicion;
	global $aequipo1;
	global $aequipo2;
	global $agrupo;
	global $eAB; //<= Auto
	global $tablaID;

	$resultiLine = mysqli_query($GLOBALS['link'], "Select * From _tbjuegodd Where IDDD=$iddd");
	$rowIiLine = mysqli_fetch_array($resultiLine);
	$sGrupo = $rowIiLine['Grupo'];
	// Auto
	$key = strpos($rowIiLine['Columnas'], 'Ax');
	$tablaID = $rowIiLine['tabla'];

	if ($key === false) : $eAB = false;
	else : $eAB = true;
	endif;
	// Auto


	$linea = 0;
	$resultiLine = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=$IDE");
	if (mysqli_num_rows($resultiLine) != 0) :
		$grupo = array();
		$rowIiLine = mysqli_fetch_array($resultiLine);
		if ($rowIiLine['Grupo'] != 0 && $sGrupo == $rowIiLine['Grupo']) :  $grupo[] = $rowIiLine['Grupo'];
		endif;
		if ($rowIiLine['Grupo1'] != 0 && $sGrupo == $rowIiLine['Grupo1']) : $grupo[] = $rowIiLine['Grupo1'];
		endif;
		if ($rowIiLine['Grupo2'] != 0 && $sGrupo == $rowIiLine['Grupo2']) : $grupo[] = $rowIiLine['Grupo2'];
		endif;
		$iGrupos = join(',', $grupo);
		//SELECT * FROM _partidosbb WHERE IDJ =867 AND Grupo IN ( 3 )
		$resultiLine = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb WHERE IDJ =$IDJ AND Grupo IN (" . $iGrupos . ")  ORDER BY IDP ASC");
		//echo ("SELECT * FROM _partidosbb WHERE IDJ =$IDJ AND Grupo IN (".$iGrupos.")");
		while ($rowiLines = mysqli_fetch_array($resultiLine)) {
			if ($rowiLines['IDE1'] == $IDE || $rowiLines['IDE2'] == $IDE) :
				if ($rowiLines['IDE1'] == $IDE) :  $Posicion = 1;
				endif;
				if ($rowiLines['IDE2'] == $IDE) :  $Posicion = 2;
				endif;
				$aequipo1[] = $rowiLines['IDE1'];
				$aequipo2[] = $rowiLines['IDE2'];
				$agrupo[] = $rowiLines['Grupo'];
				$linea++;
				break;
			endif;
			$linea++;
		}
	endif;

	return $linea;
}

function verificaciondeCombina($IDC)
{
	global 	$aequipo1;
	global 	$aequipo2;
	global 	$agrupo;
	global  $aPosicion;
	global  $aiddd;
	global  $aNoCombinar;

	for ($i = 0; $i <= count($agrupo) - 1; $i++) {
		$result2 = mysqli_query($GLOBALS['link'], "Select * From _tbjuegodd Where Grupo=" . $agrupo[$i] . "  Order by Formato,IDDD");
		$posi = 1;
		while ($row = mysqli_fetch_array($result2))
			if ($aiddd[$i] == $row['IDDD']) :
				$aPosicion[] = $posi;
				$resultIDDD = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbreglas_1  where IDC='$IDC'  and IDDD=" . $row['IDDD']);
				if (mysqli_num_rows($resultIDDD) != 0) :
					$rowI2 = mysqli_fetch_array($resultIDDD);
					$aNoCombinar[] = $rowI2['noCombinar'];
				else :
					$IDG = WhatGrupo($IDC);
					$resultIDDD = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbreglas_1  where IDG=$IDG and IDC='0'  and IDDD=" . $row['IDDD']);
					if (mysqli_num_rows($resultIDDD) != 0) :
						$rowI2 = mysqli_fetch_array($resultIDDD);
						$aNoCombinar[] = $rowI2['noCombinar'];
					else :
						$aNoCombinar[] = $row['noCombinar'];
					endif;
				endif;
				break;

			else : $posi++;
			endif;
	}
	$egrupo = array();
	$Resultado = true;
	for ($i = 0; $i <= count($agrupo) - 1; $i++) {
		$tomogrupo = array();
		$iposicion = array();
		$idddSele = array();
		$nivel = array();
		$esgrupo = $agrupo[$i];
		$searchG = array_search($esgrupo, $egrupo);
		if ($searchG === false) :
			$egrupo[] = $esgrupo;
			for ($j = $i; $j <= count($agrupo) - 1; $j++) {
				$nivel[] = $j;
				$iposicion[] = $aPosicion[$j];
				$tomogrupo[] = $agrupo[$j];
				$idddSele[] = $aiddd[$j];
			}
		endif;

		///// Veo los IDDD de los mismos grupos ////

		for ($x = 0; $x <= count($nivel) - 1; $x++) {
			$verNoCombinar =	explode('|', $aNoCombinar[$nivel[$x]]);
			$buscarSiHay = array_search($esgrupo, $egrupo);
			for ($b = 0; $b <= count($verNoCombinar) - 1; $b++) {

				$encontrador = array_count_values($iposicion);
				if ($encontrador[$verNoCombinar[$b]] >= 1) :

					$IDDDaNoCombinar = $verNoCombinar[$b];
					/// Buscar que Combinacion Tiene el IDDD que no debe estar ///
					$elProhibido = 0;
					for ($n = 0; $n <= count($iposicion) - 1; $n++) {
						if ($n != $nivel[$x]) :
							if ($iposicion[$n] == $IDDDaNoCombinar) :
								$elProhibido = $nivel[$n];
								$equipoA1 = $aequipo1[$nivel[$x]];
								$equipoA2 = $aequipo2[$nivel[$x]];
								// Equipo de la Segunda Apuesta Prohibida
								$equipoB1 = $aequipo1[$elProhibido];
								$equipoB2 = $aequipo2[$elProhibido];
								if ($equipoA1 == $equipoB1 && $equipoA2 == $equipoB2) : $Resultado = false;
									break;
								endif;
							endif;
						endif;
					}
					///// Busco los equipo para verificar que no este en el mismo partido ////
					// Equipo de la primera Apuesta Prohibida
					if (!$Resultado) : break;
					endif;
				endif;
			}
			if (!$Resultado) : break;
			endif;
		}
		if (!$Resultado) : break;
		endif;
		/////////////////////////////////////////////
	}
	return $Resultado;
}


function rst2($idc, $idj, $jugada, $acobrar, $ap)
{

	$jgdad = explode('*', $jugada);

	$equia = array();
	$iddda = array();
	$cantidad = 0;
	for ($k = 0; $k <= (count($jgdad) - 2); $k++) {
		$opcion = explode('|', $jgdad[$k]);
		$logro = $opcion[1];
		$opcion1 = explode('%', $opcion[0]);
		$carr = $opcion1[1];
		$opcion2 = explode('-', $opcion1[0]);
		$equi = $opcion2[0];
		$iddd = $opcion2[1];
		$equia[$k] = $equi;
		$iddda[$k] = $iddd;
		$cantidad++;
	}
	//  print_r($idc);echo '-';
	//  print_r($idj);echo '-';
	//  print_r($equia);echo '-';
	//  print_r($cantidad);echo '-';
	//  print_r($iddda);echo '-';
	//  print_r($ap);echo '-';
	//  print_r($acobrar);echo '-';
	if ($cantidad > 1) {
		$restric2 = new_restricciones2($idc, $idj, $equia, $cantidad, $iddda, $acobrar, $ap);
		// echo ('restricciones2**');
		// print_r( $restric2);
		if (!$restric2[0]) {
			// echo '***V***';
			if ($restric2[1] == 'A')
				return 1;
		} else {
			// echo '***F***';
			if ($ap > $restric2[1])
				return 2;
		}
	} else {

		$restric2 = new_restricciones1($idc, $idj, $equia[0], $cantidad, $iddda[0]);
		// echo ('restricciones1**');
		// print_r( $restric2);
		if (!$restric2[0]) {
			// echo '*** RESTR ES FALSO ***';
			if (!($ap <= $restric2[1]))
				return 3;
		}
	}
	return 0;
}

function new_restricciones2($conce, $idj, $equia, $cantidad, $iddda, $acobrar, $ap)
{
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionariodd  where idc='" . $conce . "'");
	$arr = array(true, 0);
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$valuar = true;
		if ($row['mmdp'] != 0) :
			$mmda = $row['mmdp'] * $ap;
			if (($acobrar - $ap) > $mmda) : $valuar = false;
			endif;
		else :
			if (($acobrar - $ap) > $row['maxpremio']) : $valuar = false;
			endif;
		endif;
		if ($valuar) :
			if ($row['mmjpp'] != 0 && $cantidad != 1) :
				$suma = 0;
				// $equia=explode('|', $lequic); array_pop($equia); sort($equia);
				// $iddda=explode('|', $lidddc); array_pop($iddda); sort($iddda);
				sort($equia);
				sort($iddda);
				$equic = array();
				$idddc = array();
				$result = mysqli_query($GLOBALS['link'], "SELECT * FROM tbljgdprnk  where idc='" . $conce . "' and idj=" . $idj . " and activo=1");
				while ($row2 = mysqli_fetch_array($result)) {
					$jud = $row2['Jugada'];
					$jgdad = explode('*', $jud);

					if ((count($jgdad) - 1) == $cantidad) :
						for ($k = 0; $k <= (count($jgdad) - 2); $k++) {
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
				$arr[0] = true;
				$arr[1] = intval($row['mmjpp']) - $suma;
				$arr[2] = $suma;
			endif;
		else :
			$arr[0] = false;
			$arr[1] = 'A';
		endif;
	endif;
	return ($arr);
}


function new_restricciones1($conce, $idj, $equic, $cantidad, $idddc)
{
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionariodd  where idc='" . $conce . "'");
	$arr = array(true, 0, 0);
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		if ($row['mmjpd'] != 0 && $cantidad == 1) :
			$suma = 0;
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM tbljgdprnk  where idc='" . $conce . "' and idj=" . $idj . " and activo=1");
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
					if (intval($equi) == intval($equic) && intval($iddd) == intval($idddc)) :
						$suma += intval($row2['ap']);
					endif;
				endif;
			}
			$arr[0] = false;
			$arr[1] = intval($row['mmjpd']) - $suma;
		endif;
	endif;
	return ($arr);
}
