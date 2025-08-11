<?php
date_default_timezone_set('America/Caracas');
require('prc_php.php');
global $GLOBALS['minutosh']o;
$GLOBALS['link'] = Connection::getInstance();

$serial = bticket();
$idj = $_REQUEST["idj"];
$monto = $_REQUEST["monto"];
$IDC = $_REQUEST["IDCtt"];
$Jugada = explode(',', ($_REQUEST["Jugada"]));
$IDLots = explode(',', ($_REQUEST["IDLots"]));
$chqOpenLoterias = '';
$valores = '';
$reslval = array();
$horaticket = Horareal($GLOBALS['minutosh']o, "h:i:s A");

//if; ( verificaciondejugada($horaticket,str_replace (;')','%',$jgd),$idj) ):

if (verificaciondejugada($idj, $IDC, $Jugada, $IDLots) == 1) :
	$idcram = rand(1, 2);
	if ($idcram == 1) :
		$se = chr(rand(1, 25) + 65) . rand(1, $serial) . '-' . chr(rand(1, 25) + 65) . rand(1, $idj) . '-' . substr($serial, 2, 1) . chr(rand(1, 25) + 65);
	else :
		$se = rand(1, $serial) . chr(rand(1, 25) + 65) . '-' . chr(rand(1, 25) + 65) . rand(1, $idj) . '-' . substr($serial, 2, 1) . chr(rand(1, 25) + 65) . '-' . chr(rand(1, 25) + 65) . rand(1, $ap);
	endif;

	$ip = getip();
	if (empty($ip) || !preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $ip)) : $ip = $_SERVER["REMOTE_ADDR"];
	endif;

	$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tjugada  VALUES (" . $serial . "," . $idj . "," . $monto . "," . $IDC . ",'" . $ip . "','" . $horaticket . "','" . $se . "',1)");
	//echo ("INSERT INTO _tjugada  VALUES (".$serial.",".$idj.",".$monto.",".$IDC.",'".$ip."','".$horaticket."','".$se."',1)");    
	for ($i = 0; $i <= count($Jugada) - 2; $i++) {
		$descomp = explode('|', $Jugada[$i]);
		$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tjugada_data  VALUES (" . $serial . "," . $descomp[1] . "," . $descomp[2] . "," . $descomp[3] . ",'" . $descomp[0] . "')");


		$arrayNumeroCheck[0][$i] = $descomp[1];
		$DesripcioMasLotery = _SrtLotery($descomp[1], $descomp[2]);

		$arrayNumeroCheck[1][$i] = $DesripcioMasLotery[0];
		$arrayNumeroCheck[2][$i] = $DesripcioMasLotery[1];
		$arrayNumeroCheck[3][$i] = $descomp[3];
		$arrayNumeroCheck[4][$i] = $descomp[0];
	}

	array_multisort($arrayNumeroCheck[1], $arrayNumeroCheck[0], $arrayNumeroCheck[2], $arrayNumeroCheck[3], $arrayNumeroCheck[4]);
	$arreglos_implode = array();
	for ($i = 0; $i <= count($arrayNumeroCheck[1]); $i++) {
		$arreglos_implode[$i] =	$arrayNumeroCheck[1][$i] . '|' . $arrayNumeroCheck[2][$i] . '|' . $arrayNumeroCheck[3][$i] . '|' . $arrayNumeroCheck[4][$i];
	}

	$reslval[0] = $result;
	$reslval[1] = Fechareal($GLOBALS['minutosh']o, 'd/n/y');
	$reslval[2] = $se;
	$reslval[3] = implode('*', $arreglos_implode);
	$reslval[4] = $horaticket;
	$reslval[5] = $serial;
else :
	$reslval[0] = false;
	$reslval[2] = $chqOpenLoterias; /// Loterias Cerradas
	$reslval[1] = $valores;		///  Numeros con Topes
endif;


echo (json_encode($reslval));


function _SrtLotery($_IdLot, $_IdAddic)
{
	$Resultados = array();
	$resultCONS = mysqli_query($GLOBALS['link'], "Select * from  _tloteria  Where IDLot=" . $_IdLot);
	$rowCONS = mysqli_fetch_array($resultCONS);
	$Resultados[] = $rowCONS['NombreTicket'];
	if ($rowCONS['Formato'] != 1) :
		$resultCONS = mysqli_query($GLOBALS['link'], "Select * from  _tloteria_formato  Where Formato=" . $rowCONS['Formato']);
		$rowCONS = mysqli_fetch_array($resultCONS);
		$Adicional = explode('|', $rowCONS['Lista']);
		$Resultados[] = $Adicional[$_IdAddic - 1];
	else :
		$resultCONS = mysqli_query($GLOBALS['link'], "Select * from  _tloteria  Where IDLot=" . $_IdLot);
		$Resultados[] = '';
	endif;

	return $Resultados;
}

function verificaciondejugada($idj, $IDC, $Jugada, $IDLots)
{

	global $chqOpenLoterias;
	global $valores;
	$valor = array();
	$Lcerrado = 1;

	//  print_r( $IDLots );
	for ($i = 0; $i <= count($IDLots) - 2; $i++) {
		if ($i != 0) : $chqOpenLoterias .= ',';
		endif;
		$valor = CkqCierreLoteria($IDLots[$i], 0);
		if ($valor[0] == 1) :
			$chqOpenLoterias .= '1';
		else :
			$chqOpenLoterias .= '0';
			$Lcerrado = 0;
		endif;
	}



	for ($i = 0; $i <= count($Jugada) - 2; $i++) {
		if ($i != 0) : $valores .= ',';
		endif;
		$descomp = explode('|', $Jugada[$i]);
		//echo $descomp[0].'-'.$descomp[1].'<br>';
		$respuesta = CuposMaximo($descomp[0], $descomp[1], $IDC, $idj, $descomp[3], $i);

		$vxRs = explode('|', $respuesta);

		if ($vxRs[0] == 'false') :
			$Lcerrado = 0;
		endif;
		$valores .= $respuesta;
	}



	return ($Lcerrado);
}
