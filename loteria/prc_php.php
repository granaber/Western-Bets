<?php
date_default_timezone_set('America/Caracas');
$server = 'localhost'; //zuloteria.db.5144062.hostedresource.com;localhost
$user = 'parlayen_lottery'; //root; bancala_loteria
$clv = 'intra255'; //Legna113;intra
$db = 'parlayen_lottery'; //bancala_loteria; lotery
$GLOBALS['minutosh']o = 0;
$arrayvendido = array();
class Connection
{
	 protected $link;
	private $server, $username, $password, $db;
	private static $_singleton;



	public static function getInstance()
	{
		if (is_null(self::$_singleton)) {
			self::$_singleton = new Connection();
		}
		return self::$_singleton;
	}

	public function __construct()
	{
		global $server;
		global $user;
		global $clv;
		global $db;

		$this->server = $server; //"sql213.xtreemhost.com";
		$this->username = $user; //"xth_2440073";sphonlin_cateca
		$this->password = $clv; //"legna113";ctco%&
		$this->db = $db; //"xth_2440073_cateca";sphonlin_cateca
		$this->connect();
	}


	private function connect()
	{
		$this->link = mysqli_connect($this->server, $this->username, $this->password);
		mysql_select_db($this->db, $this->link);
	}
}


function Horareal($minutos, $fm)/*"h:i:s A"*/
{
	$x = date("H i s m d Y", time());
	$fecha = explode(" ", $x);
	$fecha[1] = $fecha[1] + $minutos;
	$fecha2 = date($fm, mktime($fecha[0], $fecha[1], $fecha[2], $fecha[3], $fecha[4], $fecha[5]));
	return $fecha2;
}
function Fechareal($minutos, $formato)
{
	$x = date("H i s m d Y", time());
	$fecha = explode(" ", $x);
	$fecha[1] = $fecha[1] + $minutos;
	$fecha2 = date($formato, mktime($fecha[0], $fecha[1], $fecha[2], $fecha[3], $fecha[4], $fecha[5]));
	return $fecha2;
}

function Jornada($Fecha, $anexar)
{
	//$d1=Fechareal(0,'d/m/Y');
	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjornada  Where Fecha=STR_TO_DATE('" . $Fecha . "','%d/%m/%Y')");

	if (mysqli_num_rows($resultj) == 0) :
		if ($anexar) :
			$result2 = mysqli_query($GLOBALS['link'], "START TRANSACTION");
			$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjornada  Order by IDJ Desc FOR UPDATE");
			$rowj = mysqli_fetch_array($resultj);
			$IDJ = $rowj["IDJ"] + 1;
			$resultj = mysqli_query($GLOBALS['link'], "Insert _tjornada set IDJ=" . $IDJ . ",Fecha=STR_TO_DATE('" . $Fecha . "','%d/%m/%Y')");
			$result2 = mysqli_query($GLOBALS['link'], "COMMIT");
		else :
			$IDJ = 0;
		endif;
	else :
		$rowj = mysqli_fetch_array($resultj);
		$IDJ = $rowj["IDJ"];
	endif;

	return $IDJ;
}



function getip()
{
	if ($_SERVER) {
		if ($_SERVER[HTTP_X_FORWARDED_FOR]) {
			$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} elseif ($_SERVER["HTTP_CLIENT_IP"]) {
			$realip = $_SERVER["HTTP_CLIENT_IP"];
		} else {
			$realip = $_SERVER["REMOTE_ADDR"];
		}
	} else {
		if (getenv('HTTP_X_FORWARDED_FOR')) {
			$realip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif (getenv('HTTP_CLIENT_IP')) {
			$realip = getenv('HTTP_CLIENT_IP');
		} else {
			$realip = getenv('REMOTE_ADDR');
		}
	}
	return $realip;
}

function decrypt($string, $key)
{
	$result = '';
	$string = base64_decode($string);
	for ($i = 0; $i < strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key)) - 1, 1);
		$char = chr(ord($char) - ord($keychar));
		$result .= $char;
	}
	return $result;
}

function encrypt($string, $key)
{
	$result = '';
	for ($i = 0; $i < strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key)) - 1, 1);
		$char = chr(ord($char) + ord($keychar));
		$result .= $char;
	}
	return base64_encode($result);
}
function ProcesoEscrute($IDJ, $IDLot, $Numero, $Adicional)
{
	$totalpremios = 0;
	$IDC = 0;
	$sumaTotalPremio = 0;
	$result = mysqli_query($GLOBALS['link'], "Select * from _tbpremios where IDJ=" . $IDJ . " and IDLot=" . $IDLot);

	$row = mysqli_fetch_array($result);
	$IDPremio = $row['IDPremio'];
	$resultUpdate = mysqli_query($GLOBALS['link'], "Delete  from  _tbjugadapremio where premiado=" . $IDPremio);


	$cdu = str_split($Numero); // C=0 D=1 U=2

	$resultprint = mysqli_query($GLOBALS['link'], "Select * from _tjugada,_tjugada_data where _tjugada.serial=_tjugada_data.serial and _tjugada.IDJ=" . $IDJ . " and _tjugada_data.IDLot=" . $IDLot);



	while ($rowprint = mysqli_fetch_array($resultprint)) {

		if ($rowprint['activo'] == 1) :
			if ($IDC != $rowprint['IDC']) :
				$IDC = $rowprint['IDC'];
				$PagoPremioTotal = PagoporConcesion($IDC, $IDLot);

				$numeroganadores = array();
				if ($PagoPremioTotal[0] != -1) :
					$numeroganadores = AmarNumero($PagoPremioTotal, $cdu);
				endif;
			endif;


			for ($pr = 0; $pr <= count($numeroganadores) - 1; $pr++) {
				$dividirlo = explode('-', $numeroganadores[$pr]);
				//echo $rowprint['numero'].'-'.$rowprint['IDLot'].' C '.$IDLot.'-'.$dividirlo[0].' C '.$Adicional.'-'.$rowprint['Adicional'].'<br>';
				if ($dividirlo[0] == $rowprint['numero'] && $rowprint['IDLot'] == $IDLot && $rowprint['Adicional'] == $Adicional) :

					$pago = $rowprint['Monto'] * intval($dividirlo[1]);
					$sumaTotalPremio += $pago;
					$resultUpdate = mysqli_query($GLOBALS['link'], "Insert  _tbjugadapremio values (" . $rowprint['Serial'] . "," . $IDPremio . "," . $pago . ",'" . $rowprint['numero'] . "'," . $rowprint['Adicional'] . ")");
					//	echo ("Insert  _tbjugadapremio values (".$rowprint['Serial'].",".$IDPremio.",".$pago.",'".$rowprint['numero']."',".$rowprint['Adicional'].")");

					if ($resultUpdate) :			$totalpremios += mysql_affected_rows();
					endif;
				endif;
			}

		endif;
	}
	$resultados = array();

	$resultados[] = $totalpremios;
	$resultados[] = $sumaTotalPremio;

	return $resultados;
}
function AmarNumero($PagoPremioTotal, $cdu)
{
	$cdu_FdP = explode('|', $PagoPremioTotal[0]);
	$cdu_Pre = explode('|', $PagoPremioTotal[1]);
	$listadenumeros = array();
	for ($j = 0; $j <= count($cdu_FdP) - 1; $j++) {

		if ($cdu_FdP[$j] != '') :
			$dcuApagar = str_split($cdu_FdP[$j]); // D=0 C=1 U=2
			$numero = '';                         //  CD| |  |CDU
			for ($p = 0; $p <= count($dcuApagar) - 1; $p++) {
				switch ($dcuApagar[$p]) {
					case 'C':
						$numero .= $cdu[0];
						break;
					case 'D':
						$numero .= $cdu[1];
						break;
					case 'U':
						$numero .= $cdu[2];
						break;
				}
			}
			$listadenumeros[] =	$numero . '-' . $cdu_Pre[$j];
		endif;
	}
	return 	$listadenumeros;
}
function PagoporConcesion($IDC, $IDLot)
{
	$pagopremio = array();
	$Formuladepago = -1;
	$Formuladepremio = -1;

	$result2 = mysqli_query($GLOBALS['link'], "Select * from _tcupos where Tipo=4 and ID_Relacionado=" . $IDC . " and IDLot=$IDLot");

	if (mysqli_num_rows($result2) == 0) :
		$relacion = relacion($IDC, 4);

		for ($i = 0; $i <= count($relacion) - 1; $i++) {
			$Arelacion = explode('-', $relacion[$i]);
			if ($Arelacion[0] != '') :
				$result2 = mysqli_query($GLOBALS['link'], "Select * from _tcupos where Tipo=" . $Arelacion[0] . " and ID_Relacionado=" . $Arelacion[1] . " and IDLot=$IDLot");
				if (mysqli_num_rows($result2) != 0) :
					$row = mysqli_fetch_array($result2);
					$Formuladepago = $row['FormulaPago'];
					$Formuladepremio = $row['Premio'];
					break;
				endif;
			endif;
		}

	else :
		$row = mysqli_fetch_array($result2);
		if ($row['FormulaPago'] == '|||') :
			$Formuladepago = VerFormuladepagoOrFormuladepremio($IDC, 1);
		else :
			$Formuladepago = $row['FormulaPago'];
		endif;
		if (trim($row['Premio']) == '|||') :
			$Formuladepremio = VerFormuladepagoOrFormuladepremio($IDC, 2);
		else :
			$Formuladepremio = $row['Premio'];
		endif;
	//echo $Formuladepremio;
	endif;

	$pagopremio[] = $Formuladepago;
	$pagopremio[] = $Formuladepremio;

	return $pagopremio;
}
function VerFormuladepagoOrFormuladepremio($IDC, $op)
{
	// op
	//  1 = Formuladepago
	//  2 = Formuladepremio
	$relacion = relacion($IDC, 4);
	$Formuladepago = '|||';
	$Formuladepremio = '|||';

	for ($i = 0; $i <= count($relacion) - 1; $i++) {
		$Arelacion = explode('-', $relacion[$i]);
		if ($Arelacion[0] != '') :
			$resultTY = mysqli_query($GLOBALS['link'], "Select * from _tcupos where Tipo=" . $Arelacion[0] . " and ID_Relacionado=" . $Arelacion[1]);

			if (mysqli_num_rows($resultTY) != 0) :
				$rowTY = mysqli_fetch_array($resultTY);
				if ($op == 1 && trim($rowTY['FormulaPago']) != '|||') : $Formuladepago = $rowTY['FormulaPago'];
					break;
				endif;
				if ($op == 2 && trim($rowTY['Premio']) != '|||') : $Formuladepremio = $rowTY['Premio'];
					break;
				endif;

			endif;
		endif;
	}
	if ($op == 1) :
		$ValoraD = $Formuladepago;
	else :
		$ValoraD = $Formuladepremio;
	endif;

	return $ValoraD;
}

/*
---- Relacion de Tipos de Usuario ----
Tipo	Descripcion
1		Banca
2		Zona
3		Intermediario
4		Agencia

===>  Tipo Relacion - ID
*/
function relacion($IDC, $Tipo)
{
	$relacionarr = array();
	$relacion = 0;
	$tipor = 0;
	$result_relacion = mysqli_query($GLOBALS['link'], "Select * from _trelacionbanca where Tipo=" . $Tipo . " and ID_Relacionado=" . $IDC);

	$row_relacion = mysqli_fetch_array($result_relacion);

	if ($row_relacion['Intermediario'] != 0) :
		$opcion = '3-' . $row_relacion['Intermediario'];
		$relacion = $row_relacion['Intermediario'];
		$tipor = 3;
	endif;

	if ($row_relacion['Zona'] != 0) :
		$opcion = '2-' . $row_relacion['Zona'];
		$relacion = $row_relacion['Zona'];
		$tipor = 2;
	endif;

	if ($row_relacion['Banca'] != 0) :
		$opcion = '1-' . $row_relacion['Banca'];
		$relacion = $row_relacion['Banca'];
		$tipor = 1;
	endif;

	$relacionarr[] = $opcion;
	while (true) {
		if ($row_relacion['Banca'] == 0 && mysqli_num_rows($result_relacion) != 0) :
			$result_relacion = mysqli_query($GLOBALS['link'], "Select * from _trelacionbanca where Tipo=" . $tipor . " and ID_Relacionado=" . $relacion);
			$row_relacion = mysqli_fetch_array($result_relacion);

			if ($row_relacion['Intermediario'] != 0) :
				$opcion = '3-' . $row_relacion['Intermediario'];
				$relacion = $row_relacion['Intermediario'];
				$tipor = 3;
			endif;

			if ($row_relacion['Zona'] != 0) :
				$opcion = '2-' . $row_relacion['Zona'];
				$relacion = $row_relacion['Zona'];
				$tipor = 2;
			endif;

			if ($row_relacion['Banca'] != 0) :
				$opcion = '1-' . $row_relacion['Banca'];
				$relacion = $row_relacion['Banca'];
				$tipor = 1;
			endif;
			$relacionarr[] = $opcion;
		else :
			break;
		endif;
	}

	return $relacionarr;
}

function relacionaNivel($Kserial, $KNoOptar)
{
	$campoR = array('Banca', 'Zona', 'Intermediario');

	$Relacion = explode('-', $Kserial); /// 2-1   $Relacion[0]=2   $campoR[1]='Zona'  || Zona=1 && Tipo=2
	$NOOpta = explode('-', $KNoOptar);

	$opcion = array();
	$result_relacion = mysqli_query($GLOBALS['link'], "Select * from _trelacionbanca where " . $campoR[intval($Relacion[0]) - 1] . "=" . $Relacion[1]);
	if (mysqli_num_rows($result_relacion) != 0) :

		while ($row_relacion = mysqli_fetch_array($result_relacion)) {

			if ($row_relacion['Tipo'] != $NOOpta[0] || $row_relacion['ID_Relacionado'] != $NOOpta[1]) :

				$opcion[] = $row_relacion['Tipo'] . '-' . $row_relacion['ID_Relacionado'];

			endif;
		}

	endif;


	return $opcion;
}
function recursivoNivel($Nivel, $NOK)
{

	global $arrayRelacion;

	$relacion = relacionaNivel($Nivel, $NOK);
	for ($i = 0; $i <= count($relacion) - 1; $i++) {
		$Arelacion = explode('-', $relacion[$i]);
		if ($Arelacion[0] == 4) :
			$arrayRelacion[] = $Arelacion[1];
		//echo $Arelacion[1];echo '--<br>';
		else :
			//print_r($relacion[$i]);
			if ($i == 0) :
				$OKAnt = '0-0';
			else :
				$OKAnt = $relacion[$i - 1];
			endif;
			//echo $i.'-'.$OKAnt.'<br>';
			recursivoNivel($relacion[$i], $OKAnt);

		endif;
	}
}
////////////////////////////////////////////////////////////////////////


function DiaenLetras($dia)
{
	switch ($dia) {

		case 1:
			$enletras = 'L';
			break;
		case 2:
			$enletras = 'M';
			break;
		case 3:
			$enletras = 'MI';
			break;
		case 4:
			$enletras = 'J';
			break;
		case 5:
			$enletras = 'V';
			break;
		case 6:
			$enletras = 'S';
			break;
		case 7:
			$enletras = 'D';
			break;
	}

	return $enletras;
}


function CkqCierreLoteria($IDLot, $Fecha)
{
	//  ===Opciones de Errores===
	//  1: Loteria No Activa
	//  2: Loteria Fuera de Hora
	//  3: Loteria No Existe

	global $GLOBALS['minutosh']o;
	if ($Fecha == 0) :
		$dia = Fechareal($GLOBALS['minutosh']o, 'N');
		$Fecha = Fechareal($GLOBALS['minutosh']o, 'd/n/Y');
	else :
		$dia = date('N', $Fecha);
	endif;
	$Fecha_Actual = Fechareal($GLOBALS['minutosh']o, 'd/n/Y');
	$hora = convertirMilitar(Horareal($GLOBALS['minutosh']o, "h:i:s A"));

	$resultado = array();
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tloteria  where IDLot=" . $IDLot);
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$campoDia = DiaenLetras($dia);
		if ($row[($campoDia . 'A')] == 1 && $row['Estatus'] == 1) :
			if (diferenciadehoras($Fecha, $Fecha_Actual, $row[($campoDia . 'H')], $hora)) :
				$resultado[] = false;
				$resultado[] = '2';
			else :
				$resultado[] = true;
				$resultado[] = 'Ok';
			endif;
		else :
			$resultado[] = false;
			$resultado[] = '1';
		endif;
	else :
		$resultado[] = false;
		$resultado[] = '3';
	endif;

	return $resultado;
}
///////////////////////////////////////
function convertirMilitar($Hora)
{
	$PMAM = explode(" ", $Hora);
	$horaM = explode(":", $PMAM[0]);
	if (strtoupper($PMAM[1]) == 'PM') :
		if (intval($horaM[0]) != 12) :
			$horaM[0] = intval($horaM[0]) + 12;
		endif;
	endif;
	return implode(':', $horaM);
}
//////////////////////////////////////
function diferenciadehoras($fecha1, $fecha2, $hora1, $hora2)
{
	$horaM = explode(":", $hora1);
	$fechaMK = explode("/", $fecha1);
	if ($horaM[2] == '') : $horaM[2] = 0;
	endif;
	$fechaMK1 = mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);

	$horaM = explode(":", $hora2);
	$fechaMK = explode("/", $fecha2);
	if ($horaM[2] == '') : $horaM[2] = 0;
	endif;
	$fechaMK2 =  mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);

	$respuesta = $fechaMK1 <= $fechaMK2;
	return $respuesta;
}
//////////////////////////////////////
function diferenciadehorasxMIN($fecha1, $fecha2, $hora1, $hora2, $cMin)
{
	$horaM = explode(":", $hora1);
	$fechaMK = explode("/", $fecha1);
	if ($horaM[2] == '') : $horaM[2] = 0;
	endif;
	$fechaMK1 = mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);

	$horaM = explode(":", $hora2);
	$fechaMK = explode("/", $fecha2);
	if ($horaM[2] == '') : $horaM[2] = 0;
	endif;
	$fechaMK2 =  mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);


	$respuesta = ($fechaMK2 - $fechaMK1) >= $cMin;
	//if ($respuesta): echo 1; else: echo 2; endif;
	return $respuesta;
}
////////////////////////////////////
////// Calculo de Cupos ///////////
function CuposMaximo($Numero, $IDLot, $IDC, $IDJ, $Monto, $idx)
{
	global $arrayvendido;

	if ($IDC == -2) : $IDC = 1;
	endif;

	$relacion = relacion($IDC, 4);
	$triple = 0;
	$terminal = 0;
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tcupos  where ID_Relacionado=" . $IDC . " and Tipo=4 and IDLot=$IDLot");


	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$terminal = $row['LimiteTerminal'];
		$triple = $row['LimiteTriple'];
	endif;

	$estatus = true;
	$MontoVendido = 0;
	for ($j = 0; $j <= count($relacion) - 1; $j++) {
		if ($j == 0) :
			$OKAnt = '0-0';
		else :
			$OKAnt = $relacion[$j - 1];
		endif;
		$arrayvendido = array();
		recursivo($relacion[$j], $OKAnt, $IDLot, $Numero, $IDJ);
		//print_r($arrayvendido);

		$AKRla = explode('-', $relacion[$j]);
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tcupos  where ID_Relacionado=" . $AKRla[1] . " and Tipo=" . $AKRla[0] . " and IDLot=$IDLot");
		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			$terminal = $row['LimiteTerminal'];
			$triple = $row['LimiteTriple'];
		endif;
		$NumeroS = str_split($Numero);
		for ($c = 0; $c <= count($arrayvendido) - 1; $c++)
			$MontoVendido += $arrayvendido[$c];

		switch (count($NumeroS)) {
			case 2:
				$Resultado = $terminal - $MontoVendido;
				break;
			case 3:
				$Resultado = $triple - $MontoVendido;
				break;
		}
		//echo $Numero.'-N<br>';echo $IDLot.'-L<br>';echo $Resultado.'-R<br>';echo $Monto.'-M<br><br>';

		if ($Resultado <= 0) :
			$Valores = 'false|0|' . $idx;
			$estatus = false;
			break;
		else :
			if ($Resultado != 0 && ($Resultado - $Monto) < 0) :
				$Valores = 'false|' . $Resultado . '|' . $idx;
				$estatus = false;
				break;
			endif;
		endif;
	}

	if ($estatus) :
		$AResultado = 'true|';
	else :
		$AResultado = $Valores;
	endif;


	return $AResultado;
}
function recursivo($Nivel, $NOK, $IDLot, $Numero, $IDJ)
{

	global $arrayvendido;

	$relacion = relacionaNivel($Nivel, $NOK);
	for ($i = 0; $i <= count($relacion) - 1; $i++) {
		$Arelacion = explode('-', $relacion[$i]);
		if ($Arelacion[0] == 4) :

			$resultChq1 = mysqli_query($GLOBALS['link'], "SELECT Sum(_tjugada_data.Monto) as Vendido FROM _tjugada_data,_tjugada where _tjugada_data.Serial=_tjugada.Serial and IDC=" . $Arelacion[1] . " and IDLot=" . $IDLot . " and numero='" . $Numero . "' and _tjugada.IDJ=" . $IDJ . " and _tjugada.activo=1");

			if (mysqli_num_rows($resultChq1) == 0) :
				$arrayvendido[] = 0;
			else :
				$row = mysqli_fetch_array($resultChq1);
				$arrayvendido[] = $row['Vendido'];
			endif;

		else :
			// print_r($relacion[$i]);		echo '--<br>';
			if ($i == 0) :
				$OKAnt = '0-0';
			else :
				$OKAnt = $relacion[$i - 1];
			endif;
			//echo $i.'-'.$OKAnt.'<br>';
			recursivo($relacion[$i], $OKAnt, $IDLot, $Numero, $IDJ);

		endif;
	}
}
function convertirH_AMPM($Hora)
{
	$fho = explode(':', $Hora);
	if ($fho[0] < 12) :
		$ann = 'a';
	endif;
	if ($fho[0] == 12) :
		$ann = 'm';
	endif;
	if ($fho[0] > 12) :
		$ann = 'p';
		$horr = $fho[0] - 12;
	else :
		$horr = $fho[0];
	endif;
	$HoraR = $horr . ':' . $fho[1] . $ann;
	return $HoraR;
}
function ConsultadeVentas($IDC, $IDJ)
{
	$resultChq1 = mysqli_query($GLOBALS['link'], "SELECT Sum(Monto) as Vendido FROM _tjugada where IDC=" . $IDC . " and IDJ=" . $IDJ . " and activo=1");
	$row = mysqli_fetch_array($resultChq1);
	if (is_null($row['Vendido'])) :
		$Ventas = 0;
	else :
		$Ventas = $row['Vendido'];
	endif;

	return $Ventas;
}
function ConsultadeGastos($IDC, $IDJ)
{
	$resultChq1 = mysqli_query($GLOBALS['link'], "SELECT Sum(Monto) as Vendido FROM _tgastos where IDC=" . $IDC . " and IDJ=" . $IDJ);

	$row = mysqli_fetch_array($resultChq1);
	if (is_null($row['Vendido'])) :
		$Gastos = 0;
	else :
		$Gastos = $row['Vendido'];
	endif;

	return $Gastos;
}
function ConsultadePremiosPagados($IDC, $IDJ)
{
	$resultChq1 = mysqli_query($GLOBALS['link'], "SELECT sum(Premio) as Pagado FROM _tjugada,_tpremiospagados,_tbjugadapremio where _tpremiospagados.serial=_tbjugadapremio.serial and _tpremiospagados.serial=_tjugada.serial and _tpremiospagados.IDC=" . $IDC . " and _tjugada.IDJ=" . $IDJ);
	$row = mysqli_fetch_array($resultChq1);
	if (is_null($row['Pagado'])) :
		$pagado = 0;
	else :

		$pagado = $row['Pagado'];
	endif;

	return $pagado;
}
function ConsultadeFondo($IDC, $IDJ)
{
	$resultChq1 = mysqli_query($GLOBALS['link'], "SELECT sum(MontodeApetura) as Fondo FROM _tapertura where IDC=" . $IDC . " and IDJ=" . $IDJ);
	$row = mysqli_fetch_array($resultChq1);
	return $row['Fondo'];
}
function tabla_tipo($idTipo, &$valor1, &$valor2)
{

	$resultChq1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbtipo where tipo=" . $idTipo);
	$row = mysqli_fetch_array($resultChq1);
	$valor1 = $row['relacionTabla'];
	$valor2 = $row['Clave'];
}

function bticket()
{

	$result2 = mysqli_query($GLOBALS['link'], "START TRANSACTION");
	$result2 = mysqli_query($GLOBALS['link'], "SELECT N_x  FROM _conteo Where Modulo='Ticket' FOR UPDATE");
	$result2 = mysqli_query($GLOBALS['link'], "UPDATE _conteo SET N_x = LAST_INSERT_ID(N_x + 1) Where Modulo='Ticket'");
	$result2 = mysqli_query($GLOBALS['link'], "SELECT LAST_INSERT_ID() as N_x;");
	$row2 = mysqli_fetch_array($result2);
	$result2 = mysqli_query($GLOBALS['link'], "COMMIT");

	$tik = $row2["N_x"];

	return $tik;
}
