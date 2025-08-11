<?
/*require('prc_php.php'); 
$GLOBALS['link'] = Connection::getInstance();  

$serial=$_REQUEST['serial'];
  EscrutarHI($serial,0);*/

//// SkyNet
function EscrutarHI($serial, $opcion)
{

	$result = mysqli_query($GLOBALS['link'], "Select * from _tjugadahi where Serial=" . $serial);
	$premioR = 0;

	if (mysqli_num_rows($result) != 0) :

		$row = mysqli_fetch_array($result);
		switch ($row['IDJug']) {
			case 0:
				//echo '****'.$serial;
				if (verificacionTiempo($serial, $row['Hora'], $row['IDCN'], $row['carr'], 0)) :
					$retiro = retiros_chk_Ganadores($row['Jugada'], $row['IDCN'], $row['carr'], $serial, $row['Valor_J']);
					if ($retiro == 0) :
						$pmi = escrute_ganadores($row['Jugada'], $row['IDCN'], $row['carr'], $opcion);
					else :
						$pmi[0] = -1;
						$pmi[1] = -1;
					endif;
				else :
					$pmi[0] = -1;
					$pmi[1] = -1;
				endif;
				break;
			default:
				if (verificacionTiempo($serial, $row['Hora'], $row['IDCN'], $row['carr'], $row['IDJug'])) :
					$resultJug = mysqli_query($GLOBALS['link'], "Select * from _tdjuegoshi where IDJug=" . $row['IDJug']);
					$rowJug = mysqli_fetch_array($resultJug);
					switch ($rowJug['calculo']) {
						case 2:
							$pmi = escrute_porpuesto($row['Jugada'], $row['IDCN'], $row['carr'], $row['IDJug'], $row['Valor_J'], $row['Valor_R'], $serial, $row['Anulado']);
							break;
						case 1:
							$pmi = escrute_porvalida($row['Jugada'], $row['IDCN'], $row['carr'], $row['IDJug'], $row['Valor_J'], $row['Valor_R'], $serial, $rowJug['relpos']);
							break;
					}
				else :
					$pmi[0] = -1;
					$pmi[1] = -1;
				endif;
		}

	endif;
	//print_r($pmi); 
	return $pmi;
}
function verificacionTiempo($serial, $horaTK, $IDCN, $carr, $tipo)
{
	global $minutosa;

	if ($tipo != 0) :
		$carr = verpimeracarrera($carr, $IDCN, $tipo);

	endif;
	$horaactual = convertirMilitar($horaTK);
	$horacierre = restantiempo($IDCN, $carr);
	$fechaactual = Fechareal($minutosa, "d/m/Y");


	if ($horacierre != '0:0') :
		if (diferenciadehoras($fechaactual, $horacierre, $fechaactual, $horaactual)) :
			$result = mysqli_query($GLOBALS['link'], "Update  _tjugadahi set Anulado=3 where Serial=" . $serial);
			return false;
		else :
			$result = mysqli_query($GLOBALS['link'], "Update  _tjugadahi set Anulado=0 where Serial=" . $serial);
			return true;
		endif;
	else :
		// $result = mysqli_query($GLOBALS['link'],"Update  _tjugadahi set Anulado=3 where Serial=".$serial);

		return true;
	endif;
}
function inicializar_ganadores($Jugada, $IDCN, $serial)
{
	$pos = strrpos($Jugada, "R");
	$marcado = false;
	if (!($pos === false)) { // note: three equal signs
		$suma = 0;
		$Jugada_x_Carrera = explode('|', $Jugada);

		for ($x = 0; $x <= count($Jugada_x_Carrera) - 1; $x++) {
			$verEjemplares = explode('-', $Jugada_x_Carrera[$x]);
			$verEjemplares[0] = intval($verEjemplares[0]);
			$suma += $verEjemplares[0];
			$verEjemplares[1] = intval($verEjemplares[1]);
			$suma += $verEjemplares[1];
			$verEjemplares[2] = intval($verEjemplares[2]);
			$suma += $verEjemplares[2];

			$Jugada_x_Carrera[$x] = implode('-', $verEjemplares);
		}
		$result = mysqli_query($GLOBALS['link'], "Update  _tjugadahi set Valor_J=" . $suma . ", Jugada='" . implode('|', $Jugada_x_Carrera) . "' where Serial=" . $serial);
		$marcado = true;
	}

	return $marcado;
}
function retiros_chk_Ganadores($Jugada, $IDCN, $carrera, $serial, $Valor)
{
	$inicializado = inicializar_ganadores($Jugada, $IDCN, $serial);
	$restar = 0;
	$suma = 0;
	$Jugada_x_Carrera = explode('|', $Jugada);

	$result_retiros = mysqli_query($GLOBALS['link'], "Select * from _tconfighi where IDCN=" . $IDCN);
	$row_retiros = mysqli_fetch_array($result_retiros);

	$ejem_retiros = explode('|', $row_retiros['_Ret']);

	$verEjemplaresReti = explode('-', $ejem_retiros[$carrera - 1]); // Verifico la Carrera del Ejemplar RETIRADO!!

	//	 0-0-0|0-0-0|0-0-0|0-0-0|150-0-0|0-0-0|0-0-0|
	//	 ||||||13-14|1|3-10-13-14|12|

	// print_r($verEjemplaresReti); 
	for ($x = 0; $x <= count($verEjemplaresReti) - 1; $x++) {
		$verEjemplares = explode('-', $Jugada_x_Carrera[intval($verEjemplaresReti[$x]) - 1]);
		// print_r($verEjemplares);
		$verEjemplares[0] = intval($verEjemplares[0]);

		if ($verEjemplares[0] != 0) :
			$restar += $verEjemplares[0];
			$verEjemplares[0] = $verEjemplares[0] . 'R';
		endif;

		if ($verEjemplares[1] != 0) :
			$restar += $verEjemplares[1];
			$verEjemplares[1] = $verEjemplares[1] . 'R';
		endif;


		if ($verEjemplares[2] != 0) :
			$verEjemplares[2] = $verEjemplares[2] . 'R';
			$restar += $verEjemplares[2];
		endif;

		$Jugada_x_Carrera[intval($verEjemplaresReti[$x]) - 1] = implode('-', $verEjemplares);
	}

	if ($restar != 0) :
		if (($Valor - $restar) >= 0) :
			$operacion = ($Valor - $restar);
		else :
			$operacion = 0;
		endif;

		$result = mysqli_query($GLOBALS['link'], "Update  _tjugadahi set Valor_J=" . $operacion . ", Jugada='" . implode('|', $Jugada_x_Carrera) . "' where Serial=" . $serial);

	endif;
	if ($restar != 0 || $inicializado) :
		$restar = 1;
	endif;


	return $restar;
}
function escrute_ganadores($Jugada, $IDCN, $carrera, $opcion)
{
	$arreglo_De_premicion = array();
	$arreglo_x_premiacion = array(0, 0, 0);
	$Jugada_x_Carrera = explode('|', $Jugada);
	$premiando = '';
	$premio = 0;
	$dividendo = '';






	$result = mysqli_query($GLOBALS['link'], "Select * from _tdividendohi where IDCN=" . $IDCN . " and carrera=" . $carrera);
	$row = mysqli_fetch_array($result);

	$empate1 = explode('-', $row['Primero']);
	$empate2 = explode('-', $row['Segundo']);
	$empate3 = explode('-', $row['Tercero']);
	$dividendos = explode(',', $row['Dividendos']);

	//print_r($Jugada_x_Carrera); 
	if (count($empate1) == 1 && count($empate2) == 1 && count($empate3) == 1) :

		$primero = explode('-', $Jugada_x_Carrera[$row['Primero'] - 1]);
		$segundo = explode('-', $Jugada_x_Carrera[$row['Segundo'] - 1]);
		$tercero = explode('-', $Jugada_x_Carrera[$row['Tercero'] - 1]);

		//print_r('**'.$primero);	 print_r($segundo); print_r($tercero);
		if ($primero[0] != 0) :
			$premio += ($primero[0] * ($dividendos[0] / 2));
			$arreglo_x_premiacion[0] += ($primero[0] * ($dividendos[0] / 2));
			$premiando .= $row['Primero'] . '-';
			$dividendo .= ($dividendos[0] / 2) . '-';
		endif;

		if ($primero[1] != 0) :
			$premio += ($primero[1] * ($dividendos[1] / 2));
			$arreglo_x_premiacion[1] += ($primero[1] * ($dividendos[1] / 2));
			$premiando .= $row['Primero'] . '-';
			$dividendo .= ($dividendos[0] / 2) . '-';
		endif;

		if ($primero[2] != 0) :
			$premio += ($primero[2] * ($dividendos[2] / 2));
			$arreglo_x_premiacion[2] += ($primero[2] * ($dividendos[2] / 2));
			$premiando .= $row['Primero'] . '-';
			$dividendo .= ($dividendos[0] / 2) . '-';
		endif;

		$premiando .= ',';

		if ($segundo[1] != 0) :
			$premio += ($segundo[1] * ($dividendos[3] / 2));
			$arreglo_x_premiacion[1] += ($segundo[1] * ($dividendos[3] / 2));
			$premiando .= $row['Segundo'] . '-';
			$dividendo .= ($dividendos[0] / 2) . '-';
		endif;

		if ($segundo[2] != 0) :
			$premio += ($segundo[2] * ($dividendos[4] / 2));
			$arreglo_x_premiacion[2] += ($segundo[2] * ($dividendos[4] / 2));
			$premiando .= $row['Segundo'] . '-';
			$dividendo .= ($dividendos[0] / 2) . '-';
		endif;
		$premiando .= ',';
		if ($tercero[2] != 0) :

			$premio += ($tercero[2] * ($dividendos[6] / 2));
			$arreglo_x_premiacion[2] += ($tercero[2] * ($dividendos[6] / 2));
			$premiando .= $row['Tercero'] . '-';
			$dividendo .= ($dividendos[0] / 2) . '-';
		endif;

	else :
		if (count($empate1) == 2) :
			$primero = explode('-', $Jugada_x_Carrera[$empate1[0] - 1]);
			$segundo = explode('-', $Jugada_x_Carrera[$empate1[1] - 1]);
			$tercero = explode('-', $Jugada_x_Carrera[$row['Tercero'] - 1]);

			if ($primero[0] != 0) :
				$premio += ($primero[0] * ($dividendos[0] / 2));
				$arreglo_x_premiacion[0] += ($primero[0] * ($dividendos[0] / 2));
				$premiando .= $empate1[0] . '-';
				$dividendo .= ($dividendos[0] / 2) . '-';
			endif;
			if ($primero[1] != 0) :
				$premio += ($primero[1] * ($dividendos[1] / 2));
				$arreglo_x_premiacion[0] += ($primero[1] * ($dividendos[1] / 2));
				$premiando .= $empate1[0] . '-';
				$dividendo .= ($dividendos[0] / 2) . '-';
			endif;
			if ($primero[2] != 0) :
				$premio += ($primero[2] * ($dividendos[2] / 2));
				$arreglo_x_premiacion[0] += ($primero[2] * ($dividendos[2] / 2));
				$premiando .= $empate1[0] . '-';
				$dividendo .= ($dividendos[0] / 2) . '-';
			endif;
			$premiando .= ',';

			if ($segundo[0] != 0) :
				$premio += ($segundo[0] * ($dividendos[3] / 2));
				$arreglo_x_premiacion[1] += ($segundo[0] * ($dividendos[3] / 2));
				$premiando .= $empate1[1] . '-';
				$dividendo .= ($dividendos[0] / 2) . '-';
			endif;
			if ($segundo[1] != 0) :
				$premio += ($segundo[1] * ($dividendos[4] / 2));
				$arreglo_x_premiacion[1] += ($segundo[1] * ($dividendos[4] / 2));
				$premiando .= $empate1[1] . '-';
				$dividendo .= ($dividendos[0] / 2) . '-';
			endif;
			if ($segundo[2] != 0) :
				$premio += ($segundo[2] * ($dividendos[5] / 2));
				$arreglo_x_premiacion[1] += ($segundo[2] * ($dividendos[5] / 2));
				$premiando .= $empate1[1] . '-';
				$dividendo .= ($dividendos[0] / 2) . '-';
			endif;
			$premiando .= ',';

			if ($tercero[2] != 0) :
				$premio += ($tercero[2] * ($dividendos[6] / 2));
				$arreglo_x_premiacion[2] += ($tercero[2] * ($dividendos[6] / 2));
				$premiando .= $row['Tercero'] . '-';
				$dividendo .= ($dividendos[0] / 2) . '-';
			endif;

		endif;
		if (count($empate2) == 2) :
			$primero = explode('-', $Jugada_x_Carrera[$row['Primero'] - 1]);
			$segundo = explode('-', $Jugada_x_Carrera[$empate2[0] - 1]);
			$tercero = explode('-', $Jugada_x_Carrera[$empate2[1] - 1]);

			if ($primero[0] != 0) :
				$premio += ($primero[0] * ($dividendos[0] / 2));
				$arreglo_x_premiacion[0] += ($primero[0] * ($dividendos[0] / 2));
				$premiando .= $row['Primero'] . '-';
				$dividendo .= ($dividendos[0] / 2) . '-';
			endif;

			if ($primero[1] != 0) :
				$premio += ($primero[1] * ($dividendos[1] / 2));
				$arreglo_x_premiacion[0] += ($primero[1] * ($dividendos[1] / 2));
				$premiando .= $row['Primero'] . '-';
				$dividendo .= ($dividendos[0] / 2) . '-';
			endif;

			if ($primero[2] != 0) :
				$premio += ($primero[2] * ($dividendos[2] / 2));
				$arreglo_x_premiacion[0] += ($primero[2] * ($dividendos[2] / 2));
				$premiando .= $row['Primero'] . '-';
				$dividendo .= ($dividendos[0] / 2) . '-';
			endif;
			$premiando .= ',';


			if ($segundo[1] != 0) :
				$premio += ($segundo[1] * ($dividendos[3] / 2));
				$arreglo_x_premiacion[1] += ($segundo[1] * ($dividendos[3] / 2));
				$premiando .= $empate2[0] . '-';
				$dividendo .= ($dividendos[0] / 2) . '-';
			endif;
			if ($segundo[2] != 0) :
				$premio += ($segundo[2] * ($dividendos[4] / 2));
				$arreglo_x_premiacion[1] += ($segundo[2] * ($dividendos[4] / 2));
				$premiando .= $empate2[0] . '-';
				$dividendo .= ($dividendos[0] / 2) . '-';
			endif;
			$premiando .= ',';

			if ($tercero[1] != 0) :
				$premio += ($tercero[1] * ($dividendos[5] / 2));
				$arreglo_x_premiacion[2] += ($tercero[1] * ($dividendos[5] / 2));
				$premiando .= $empate2[1] . '-';
				$dividendo .= ($dividendos[0] / 2) . '-';
			endif;
			if ($tercero[2] != 0) :
				$premio += ($tercero[2] * ($dividendos[6] / 2));
				$arreglo_x_premiacion[2] += ($tercero[2] * ($dividendos[6] / 2));
				$premiando .= $empate2[1] . '-';
				$dividendo .= ($dividendos[0] / 2) . '-';
			endif;
			$premiando .= ',';

		endif;

		if (count($empate3) == 2) :

		endif;

	endif;

	if ($opcion == 1) :
		$arreglo_De_premicion[] = $premiando;
		$arreglo_De_premicion[] = $premio;
		$arreglo_De_premicion[] = $dividendo;
		return 	$arreglo_De_premicion;
	else :
		$arreglo_x_premiacion[] = $dividendo;
		return 	$arreglo_x_premiacion;
	endif;
	//  100-0-0|0-0-0|0-0-0|0-0-0|0-0-0|
}
//|1-2-|3-
function verretirados($ListaApuesta, $ListaRetirados)
{
	$resultados = array(false, '');
	$listaNApuesta = array();
	for ($j = 0; $j <= count($ListaApuesta) - 1; $j++) {

		if (intval($ListaApuesta[$j]) != 0) :
			if (contarvalor($ListaRetirados, $ListaApuesta[$j]) == 0) :
				$listaNApuesta[] = $ListaApuesta[$j];
			else :
				$resultados[0] = true;
			endif;
		else :
			$listaNApuesta[] = $ListaApuesta[$j];
		endif;
	}

	$resultados[1] = implode(',', $listaNApuesta);

	return $resultados;
}

// Escrutes Juegos por puestos
function escrute_porpuesto($Jugada, $IDCN, $carrera, $IDJug, $pagado, $valorReal, $serial, $Vestatus)
{
	$arreglo_De_premicion = array();
	$Jugada_x_Carrera = explode('|', $Jugada);
	$dividendo = 0;

	$Llegada = array('Primero', 'Segundo', 'Tercero', 'cuarto');
	$apuesta = 0;
	$result_RETIR = mysqli_query($GLOBALS['link'], "Select * from _tconfighi where IDCN=" . $IDCN);
	$row_RETIR = mysqli_fetch_array($result_RETIR);
	$aRetir = explode('|', $row_RETIR['_Ret']);

	$ejemplares_retirados = explode('-', $aRetir[$carrera - 1]);

	$result = mysqli_query($GLOBALS['link'], "Select * from _tdividendohi where IDCN=" . $IDCN . " and carrera=" . $carrera);
	$row = mysqli_fetch_array($result);

	$dividendo = 0;
	$premiando = '';
	$Vrecalculo = false;
	$arrayNJugada = array();
	for ($i = 1; $i <= count($Jugada_x_Carrera) - 1; $i++) {
		$ejemplares_apostados = explode('-', $Jugada_x_Carrera[$i]);

		$ejemplares_ganadores = explode('-', $row[$Llegada[$i - 1]]);

		$resultado = verretirados($ejemplares_apostados, $ejemplares_retirados);
		if ($resultado[0]) :
			// print_r( $resultado);
			$Vrecalculo = true;
			$ejemplares_apostados = explode(',', $resultado[1]);
			$arrayNJugada[] = implode('-', explode(',', $resultado[1]));
		else :
			$arrayNJugada[] = $Jugada_x_Carrera[$i];
		endif;


		if (count($ejemplares_ganadores) == 1) :
			if (!(array_search($row[$Llegada[$i - 1]], $ejemplares_apostados) === false)) :
				$premiando .= $row[$Llegada[$i - 1]] . '-';
				$apuesta++;
			endif;
		else :
			for ($j = 0; $j <= count($ejemplares_ganadores) - 1; $j++) {
				if (!(array_search($ejemplares_ganadores[$j], $ejemplares_apostados) === false)) :
					$premiando .= $ejemplares_ganadores[$j] . '-';
					$apuesta++;
					if ($j != 0) : $dividendo = 1;
					endif;
				endif;
			}
		endif;
		$premiando .= ',';
	}
	$aceptarPremio = true;
	$Nestatus = 4;
	$premiomas = 0;
	if ($Vestatus == 4 || $Vestatus == 3) :
		$Vrecalculo = true;
	endif;
	if ($Vrecalculo) :
		$valaornuevo = calularcarra($arrayNJugada);
		if ($valaornuevo != 0) :	// En el caso que al calcular la Jugada es =0 la Jugada quedara
			// anulada.
			if ($valorReal != $valaornuevo) :
				$valorReal = $valaornuevo;
				$result_RETIR = mysqli_query($GLOBALS['link'], "Update _tjugadahi set Valor_R=" . $valorReal . ",Anulado=4 where serial=" . $serial);
			endif;
		else :
			$result_RETIR = mysqli_query($GLOBALS['link'], "Update _tjugadahi set Anulado=3 where serial=" . $serial);
			$aceptarPremio = false;
		endif;
	endif;

	if ($aceptarPremio) :

		$A_premios = explode(',', $row['Dividendos']);

		for ($i = 0; $i <= 8; $i++)
			array_shift($A_premios);

		$premio = 0;

		if ($apuesta >= (count($Jugada_x_Carrera) - 1)) :
			$vdividendos = explode('-', $A_premios[$IDJug - 1]);
			$cantidaVeces = $pagado / $valorReal;
			if (count($vdividendos) == 1) :
				$premio = (($vdividendos[0]) * $cantidaVeces);
				$dividendo = ($vdividendos[0]);
			else :
				$premio = (($vdividendos[$dividendo]) * $cantidaVeces);
				$dividendo = $vdividendos[$dividendo];
			endif;
		endif;

		$arreglo_De_premicion[] = $premiando;
		$arreglo_De_premicion[] = $premio;
		$arreglo_De_premicion[] = $dividendo;
	else :
		$arreglo_De_premicion[] = '';
		$arreglo_De_premicion[] = 0;
		$arreglo_De_premicion[] = '';
	endif;

	$arreglo_De_premicion[] = $Vrecalculo;

	return $arreglo_De_premicion;
}
function verretirados_favoritos($ListaApuesta, $ListaRetirados, $ListaFavoritos, $TomarEncuentaF)
{
	//print_r($ListaRetirados);
	$resultados = array(false, '');
	$listaNApuesta = array();
	for ($j = 0; $j <= count($ListaApuesta) - 1; $j++) {

		if (intval($ListaApuesta[$j]) != 0) :
			if (contarvalor($ListaRetirados, $ListaApuesta[$j]) == 0) :
				$listaNApuesta[] = $ListaApuesta[$j];
			else :
				if ($TomarEncuentaF) :
					$listaNApuesta[] = $ListaFavoritos;
				endif;
				$resultados[0] = true;
			endif;
		else :
			$listaNApuesta[] = $ListaApuesta[$j];
		endif;
	}

	$resultados[1] = implode(',', $listaNApuesta);

	return $resultados;
}

// Escrutes Juegos por Validas
function escrute_porvalida($Jugada, $IDCN, $tanda, $IDJug, $pagado, $valorReal, $serial, $opcionfavoritos)
{
	$arreglo_De_premicion = array();
	$Jugada_x_Carrera = explode('|', $Jugada);
	$dividendo = 0;

	$Llegada = array('Primero', 'Segundo', 'Tercero', 'cuarto');
	$apuesta = 0;


	$carreras = array();
	$result = mysqli_query($GLOBALS['link'], "Select * from _tconfighi where IDCN=" . $IDCN);
	$row = mysqli_fetch_array($result);
	$x1 = explode('|', $row['_Jug']);
	$aFavoritos = explode('|', $row['_Favoritos']);
	$aRetir = explode('|', $row['_Ret']);
	// print_r($aRetir); 
	for ($i = 1; $i <= count($x1) - 1; $i++) {
		$VerJugada1 = explode('*', $x1[$i]);
		$VerJugada2 = explode('$', $VerJugada1[0]);
		if ($VerJugada2[0] == $IDJug) :
			$x2_Impar = explode('-', $VerJugada1[1]);
			array_pop($x2_Impar);
			$VerJugada1 = explode('*', $x1[$i + 1]);
			$x2_Par = explode('-', $VerJugada1[1]);
			array_pop($x2_Par);
			break;
		endif;
	}


	$carreras = array();
	$cantidad_carreras = count($Jugada_x_Carrera) - 1;
	if (($tanda % 2) == 1) :
		$conteodetandas = 1;
		$restamas = 0;
		for ($t = 1; $t <= count($x2_Impar) - 1; $t += $cantidad_carreras) {

			if ($tanda == $conteodetandas) :
				$carreras = array_slice($x2_Impar, $t - 1, $cantidad_carreras);
				break;
			else :
				$conteodetandas += 2;
			endif;
		}
	else :
		$conteodetandas = 2;
		$restamas = 1;
		for ($t = 1; $t <= count($x2_Par) - 1; $t += $cantidad_carreras) {

			if ($tanda == $conteodetandas) :
				$carreras = array_slice($x2_Par, $t - 1, $cantidad_carreras);
				break;
			else :
				$conteodetandas += 2;
			endif;
		}
	endif;


	$apuesta = 0;
	$premiando = '';
	$participaciones = array();
	$recalculo = false;
	for ($i = 1; $i <= count($carreras); $i++) {
		$result = mysqli_query($GLOBALS['link'], "Select * from _tdividendohi where IDCN=" . $IDCN . " and carrera=" . $carreras[$i - 1]);
		$row = mysqli_fetch_array($result);


		$ejemplares_apostados = explode('-', $Jugada_x_Carrera[$i]);
		$ejemplares_ganadores = explode('-', $row['Primero']);

		$ejemplares_retirados = explode('-', $aRetir[($carreras[$i - 1] - 1)]);
		$ejemplares_Favoritos = $aFavoritos[($carreras[$i - 1] - 1)];

		$resultado = verretirados_favoritos($ejemplares_apostados, $ejemplares_retirados, $ejemplares_Favoritos, $opcionfavoritos);
		//  print_r( $resultado);
		if ($resultado[0]) :

			$recalculo = true;
			$ejemplares_apostados = explode(',', $resultado[1]);
			$arrayNJugada[] = implode('-', explode(',', $resultado[1]));
		else :
			$arrayNJugada[] = $Jugada_x_Carrera[$i];
		endif;


		if (count($ejemplares_ganadores) == 1) :
			if (!(array_search($row['Primero'], $ejemplares_apostados) === false)) :
				$apuesta++;
				$participaciones[$i] += contarvalor($ejemplares_apostados, $row['Primero']);
				$premiando .= $row['Primero'] . '-';
			endif;
		else :
			for ($j = 0; $j <= count($ejemplares_ganadores) - 1; $j++) {
				if (!(array_search($ejemplares_ganadores[$j], $ejemplares_apostados) === false)) :
					$apuesta++;
					$participaciones[$i] += contarvalor($ejemplares_apostados, $ejemplares_ganadores[$j]);
					$premiando .= $ejemplares_ganadores[$j] . '-';
				endif;
			}
		endif;
		$premiando .= ',';
	}


	if ($recalculo && $opcionfavoritos == 0) :
		$pago = 1;
		for ($x = 0; $x <= count($arrayNJugada) - 1; $x++) {
			$Jugada_V = explode('-', $arrayNJugada[$x]);
			$pago *= (count($Jugada_V) - 1);
		}
		if ($pago != 0) :
			$valorReal = $pago;
			$result_RETIR = mysqli_query($GLOBALS['link'], "Update _tjugadahi set Valor_R=" . $pago . ",Anulado=4 where serial=" . $serial);
		else :
			$result_RETIR = mysqli_query($GLOBALS['link'], "Update _tjugadahi set Anulado=3 where serial=" . $serial);
		endif;

	endif;
	/// print_r($carreras);echo $tanda.'<br>';

	$result = mysqli_query($GLOBALS['link'], "Select * from _tdividendohi where IDCN=" . $IDCN . " and carrera=" . $carreras[0]);
	$row = mysqli_fetch_array($result);
	$A_premios = explode(',', $row['Dividendos']);
	$A_Dividendos = explode(',', $row['tandas']);
	for ($i = 0; $i <= 11; $i++)
		array_shift($A_premios);
	$Dividendo = -1;
	//echo $carreras[0];
	//print_r( $A_premios);
	for ($i = 0; $i <= count($A_Dividendos); $i++) {
		$busco =	explode('-', $A_Dividendos[$i]);
		if ($busco[1] == $IDJug) : $Dividendo = $i;
			break;
		endif;
	}
	$premio = 0;
	// echo $Dividendo;
	//

	// print_r( $participaciones);
	if ($apuesta >= $cantidad_carreras) :
		$mutiplicacion = 1;
		for ($i = 1; $i <= count($participaciones) - 1; $i++) $mutiplicacion *= $participaciones[$i];

		$cantidaVeces = $pagado / $valorReal;
		if ($Dividendo != -1) :
			$premio = $mutiplicacion * (($A_premios[$Dividendo]) * $cantidaVeces);
			$dividendo = $A_premios[$Dividendo];
		else :
			$premio = 0;
		endif;
	endif;

	$arreglo_De_premicion[] = $premiando;
	$arreglo_De_premicion[] = $premio;
	$arreglo_De_premicion[] = $dividendo;
	$arreglo_De_premicion[] = $recalculo;

	return $arreglo_De_premicion;
}
