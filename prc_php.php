<?php
require_once 'send_grpc.php';
require_once 'set_stateenv.php';
if (!isset($FlatPass)) {
	if ($mode == $PRODUCCION) {
		ini_set('display_errors', 'On');
		ini_set('log_errors', 'On');
		ini_set('error_log', 'error.log');
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		$iSecury = explode('/', getenv("HTTP_REFERER"));
		if (!($iSecury[2] === "test.saamqx.net" || $iSecury[2] === "pay.westernbets.pro" || $iSecury[2] === "admin.westernbets.pro" || $iSecury[2] === "westernbets.pro"  || $iSecury[2] === "www.westernbets.pro")) :
			header("Location:index.php");
			exit;
		endif;
	}
}
date_default_timezone_set('America/Caracas');
$GLOBALS['link'] = null;
$GLOBALS['minutosh'] = 0;
$PUNTODEVENTA = 3;
$horasretro = 0;
$cantidadParlay = 8;
$IDCLIENT = 1;
$path = "publish-load";

////////////////////////////
$serverCA = '10.136.242.179';
$userCA = "parlayen_skynet";
$clvCA = 'tiqkSlT8y-!3';
$dbCA = "parlayen_skynet";
////////////////////////////



$server = ($mode == $PRODUCCION) ? '10.136.242.179' : '127.0.0.1:1653'; //; //;  //'159.89.93.31'
$user = ($mode == $PRODUCCION) ? "westernbets_root" : 'root'; //"root";
$clv = ($mode == $PRODUCCION) ? '8I#q}*7sGWC]' : 'H4W29ZoGSxKU'; //intra//
$db =  ($mode == $PRODUCCION) ? "parlay_westernbets" : "parlay_westernbets"; //
$port = ($mode == $PRODUCCION) ? 3306 : 1653; //


//amerbet_root:muf5iThic2*1@10.136.242.179/amerinca_betgambler
$serverAME = ($mode == $PRODUCCION) ? '10.136.242.179' : '127.0.0.1:1653'; //; //;  //'159.89.93.31'
$userAME = ($mode == $PRODUCCION) ? "amerweste_root" : 'root'; //"root";
$clvAME = ($mode == $PRODUCCION) ? 'muf5iThic2*1' : 'H4W29ZoGSxKU'; //intra//
$dbAME =  ($mode == $PRODUCCION) ? "amerinca_westernbets" : "amerinca_westernbets"; //
$portAME = ($mode == $PRODUCCION) ? 3306 : 1653; //

class Servidordual
{
	protected $link;
	private $server, $username, $password, $db, $port;
	private static $_singleton;

	public static function getInstance()
	{
		if (is_null(self::$_singleton)) {
			self::$_singleton = new Servidordual();
		}
		return self::$_singleton;
	}

	public function __construct()
	{
		global $server;
		global $user;
		global $clv;
		global $db;
		global $port;


		$this->server = $server; //"sql213.xtreemhost.com";
		$this->username = $user; //"xth_2440073";sphonlin_cateca
		$this->password = $clv; //"legna113";ctco%&
		$this->db = $db; //"xth_2440073_cateca";sphonlin_cateca

		$this->connect();
	}

	private function connect()
	{
		$this->link = mysqli_connect($this->server, $this->username, $this->password);
		mysqli_select_db($this->link, $this->db);
	}
}

class Connection
{
	protected $_link;
	public static function getInstance()
	{
		global $server;
		global $user;
		global $clv;
		global $db;
		global $port;

		return mysqli_connect($server, $user, $clv, $db);
	}
}



function asignacion($montov, $idc)

{

	$result_d = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionariodd_tb where IDC='" . $idc . "' and " . $montov . " BETWEEN  montodesde and montohasta");



	if (mysqli_num_rows($result_d) != 0) :

		$row_d = mysqli_fetch_array($result_d);

		$pos = strrpos($row_d['aCobrar'], "%");

		if ($pos === false) :

			$mona = $row_d['aCobrar'];

		else :

			$mona = ($montov * intval($row_d['aCobrar'])) / 100;

		endif;

	else :

		$mona = 0;

	endif;





	return $mona;
}









function convertir($valorss, $ndiv, $ilos)
{

	if ($valorss != '') :
		if ($ndiv == false) :
			if (abs($valorss) <= 99) :
				$valordysplay = $valorss;
				$r = fmod($valorss, 1);
			else :
				$valordysplay = $valorss / 10;
				$r = fmod($valorss, 10);
			endif;
		else :
			$valordysplay = $valorss;
			$r = fmod($valorss, 1);
		endif;


		if ($r != 0) :

			if ($valorss < 0) :

				$valordysplay = $valordysplay + .5;

			else :

				$valordysplay = ($valordysplay - .5);

			endif;

			$valordysplay = $valordysplay . chr(189);

		endif;



		$anexo = '';





		if ($valorss > 0) :

			if ($ilos) :

				$anexo = '+';

			else :

				$anexo = ' ';

			endif;

		endif;







		$valordysplay = $anexo . $valordysplay;





		return  $valordysplay;





	else :

		return '';

	endif;
}















function convertirtk($valorss, $ndiv)
{

	if ($valorss != '') :

		if (floatval($valorss) < 1) :
			$valordysplay = $valorss;
		else :
			if ($ndiv == false) :
				if (abs($valorss) <= 99) :
					$valordysplay = $valorss;
					$r = fmod($valorss, 1);
				else :
					$valordysplay = $valorss / 10;
					$r = fmod($valorss, 10);
				endif;
			else :
				$valordysplay = $valorss;
				$r = fmod($valorss, 1);
			endif;

			if ($r != 0) :
				if ($valorss < 0) :
					$valordysplay = $valordysplay + .5;
				else :
					$valordysplay = ($valordysplay - .5);
				endif;
				$valordysplay = $valordysplay . '.5';
			endif;
			$anexo = '';
			if ($valorss > 0) :
				$anexo = '+';
			endif;
			$valordysplay = $anexo . $valordysplay;
		endif;
		return  $valordysplay;
	else :
		return '';
	endif;
}







function convertirhora($hor)







{







	if ($hor != '') :







		$fho = explode(':', $hor);







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















		$aa = $horr . ':' . $fho[1] . $ann;























		return $aa;







	else :







		return '';







	endif;
}







function Es_numero($IDDD)
{
	$escrute_v = 0;
	$formato = 0;
	$resultjmain = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd");

	while ($row = mysqli_fetch_array($resultjmain)) {
		// Voy a determinar quien Gano
		if ($row['IDDD'] == $IDDD) : // A Ganar
			$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _cngescrute ");
			while ($row2 = mysqli_fetch_array($resultj)) {
				$lis_1 = explode('|', $row2['IDDD_AESC']);
				$key = array_search($row['IDDD'], $lis_1);
				if (!($key === false)) :
					$escrute_v = $row2['IDCNGE'];
					$formato = $row2['Formato'];
					break;
				endif;
			}
		endif;
	}
	return array($escrute_v, $formato);
}


function pescrute($serial, $map)
{
	$link = Connection::getInstance();
	$resul_escrute = [];
	$resultjj = mysqli_query($link, "SELECT * FROM _tjugadabb where serial=" . $serial);
	if (mysqli_num_rows($resultjj) != 0) :
		$row2 = mysqli_fetch_array($resultjj);
		$pass = $row2['escrute'] == '';

		if ($row2['escrute'] != ''):
			$arr =  unserialize($row2['escrute']);
			$key_1 = array_search(-1, $arr);
			$pass = !($key_1 === false);
		endif;


		if ($pass) :
			$serial = $row2['serial'];
			$data = escrute_SERIAL($serial);
			$state = $data['State'] == 0;
			$resul_escrute = $state ? unserialize($data['Respuesta']) : [];
			$valorini = $state ? $data['valorini'] : $row2['acobrar'];
			if ($map == 1) :
				array_push($resul_escrute, $valorini);
			endif;
		else:
			$resul_escrute =  unserialize($row2['escrute']);
			$valorini = $row2['acobrar'];
			if ($map == 1) :
				array_push($resul_escrute, $valorini);
			endif;
		endif;
	endif;
	return $resul_escrute;
}



function vescruteBytree($serial)
{
	$arr = pescrute($serial, 0);
	$tipo = 3; // El ticket es GANADOR

	$key0 = array_search(0, $arr);
	if (!($key0 === false)) :
		$tipo = 1;  /// Ticket Perdido
	else :
		$key_1 = array_search(-1, $arr);
		if (!($key_1 === false)) : $tipo = 2;
		endif;
	endif; /// Ticket No Hay Escrutes




	return $tipo;
}



function vescrute($serial)
{
	$arr = pescrute($serial, 0);
	$key0 = array_search(0, $arr);
	$key_1 = array_search(-1, $arr);
	return (($key0 === false) && ($key_1 === false));
}
function k1escrute($arr)
{
	$key0 = array_search(0, $arr);
	$key_1 = array_search(-1, $arr);
	return (($key0 === false) && ($key_1 === false));
}
function mescrute($serial)
{
	$arr = pescrute($serial, 1);
	$key0 = array_search(0, $arr);
	$key_1 = array_search(-1, $arr);

	$arr2['condicion'] = (($key0 === false) && ($key_1 === false));
	$arr2['acobrar'] = $arr[count($arr) - 1];

	return ($arr2);
}

function kescrute($arr, $pago)
{
	$key0 = array_search(0, $arr);
	$key_1 = array_search(-1, $arr);

	$arr2['condicion'] = (($key0 === false) && ($key_1 === false));
	$arr2['acobrar'] = $pago;
	return ($arr2);
}













function fecha_dia($fecha)
{
	switch (date('N', str2date($fecha))) {
		case 7:
			$di = 'Dom';
			break;
		case 1:
			$di = 'Lun';
			break;
		case 2:
			$di = 'Mar';
			break;
		case 3:
			$di = 'Mie';
			break;
		case 4:
			$di = 'Jue';
			break;
		case 5:
			$di = 'Vie';
			break;
		case 6:
			$di = 'Sab';
			break;
	}
	return $di;
}











function str2date($in)
{
	$t = explode("/", $in);
	if (count($t) != 3) $t = explode("-", $in);







	if (count($t) != 3) $t = explode(" ", $in);







	if (count($t) != 3) return -1;







	if (!is_numeric($t[0])) return -1;







	if (!is_numeric($t[1])) return -2;







	if (!is_numeric($t[2])) return -3;















	if ($t[2] < 1902 || $t[2] > 2037) return -3;







	return mktime(0, 0, 0, $t[1], $t[0], $t[2]);
}























function resstruc_tick($serial)
{

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb  where serial=" . $serial);
	$row4 = mysqli_fetch_array($result);

	$result7 = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb  where IDJ=" . $row4['IDJ']);
	$row7 = mysqli_fetch_array($result7);
	$jud = $row4['Jugada'];
	$tmd = $row4['idm'];

	$result10 = mysqli_query($GLOBALS['link'], "SELECT * FROM sbmonedas  where id=$tmd");
	$row10 = mysqli_fetch_array($result10);
	$moneda = $row10['moneda'];

	$jgdad = explode('*', $jud);
	$Lineaticket = array();
	$Lineaticket[0] = $row4['hora'] . '|' . $row7['Fecha'] . '|' . $row4['ap'] . '|' . $row4['acobrar'] . '|' . $row4['se'] . '|' . $moneda . '|' . $row4['activo'];

	for ($u = 0; $u <= count($jgdad) - 2; $u++) {
		$opcion = explode('|', $jgdad[$u]);
		/* 	if ($row4['Grupo']>=2): */
		$logro = $opcion[1];
		$opcion1 = explode('%', $opcion[0]);
		$carr = $opcion1[1];
		$opcion2 = explode('-', $opcion1[0]);
		$equi = $opcion2[0];
		$iddd = $opcion2[1];
		/* 	endif; */

		if ($row4['Grupo'] == 1) :
			$opcion2 = explode(' ', $opcion[1]);
			$opcionv = $opcion2[0];
			$logro = $opcion2[1];
			$opcion2 = explode('-', $opcion[0]);
			$part = $opcion2[0];
			$iddd = $opcion2[1];
		endif;

		/* if ($row4['Grupo']>=2): */


		$result1 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $equi);
		$row1 = mysqli_fetch_array($result1);

		$result3 = mysqli_query($GLOBALS['link'], "Select * From _tbjuegodd Where IDDD=" . $iddd);
		$row3 = mysqli_fetch_array($result3);

		$cln = explode('|', $row3['AddTicket']);
		$grupo = $row3['Grupo'];
		// echo ("Select * From _partidosbb Where Grupo=$grupo and (IDE1=".$equi." or IDE2=".$equi.") and IDJ=".$row4['IDJ']); 
		$result2 = mysqli_query($GLOBALS['link'], "Select * From _partidosbb Where Grupo=$grupo and (IDE1=" . $equi . " or IDE2=" . $equi . ") and IDJ=" . $row4['IDJ']);
		$row2 = mysqli_fetch_array($result2);
		if ($row2['IDE1'] == $equi) : $code = $row2['CodEq1'];
		endif;
		if ($row2['IDE2'] == $equi) : $code = $row2['CodEq2'];
		endif;
		if ($row2['IDE1'] == $equi) :
			$y = 0;
		endif;
		if ($row2['IDE2'] == $equi) :
			$y = 1;
		endif;

		if (count($cln) == 1) :
			$valoaad = $row3['AddTicket'];
		else :
			$valoaad = $cln[$y];
		endif;

		$Lineaticket[$u + 1] = $u . '|' . convertirhora($row2['Hora']) . '|' . $code . '-' . $row1['Descripcion'] . ' ' . $carr . ' ' . trim($valoaad) . '|' . $logro; //convertirtk($logro,false);
		$Lineaticket[$u + 2] = $row4['IDC'];


		/* 	endif; */


		if ($row4['Grupo'] == 1) :
			$result2 = mysqli_query($GLOBALS['link'], "Select * From _partidosbb Where IDP=" . $equi . " and IDJ=" . $row4['IDJ']);
			$row2 = mysqli_fetch_array($result2);
		endif;
	}

	return ($Lineaticket);
}































function restricciones1($conce, $idj, $equic, $cantidad, $idddc)

{

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionariodd  where idc='" . $conce . "'");
	//echo "SELECT * FROM _tconsecionariodd  where idc='".$conce."'";
	$arr = array(true, 0, 0);

	if (mysqli_num_rows($result) != 0) :

		$row = mysqli_fetch_array($result);

		if ($row['mma'] != 0) :

			$arr[0] = false;

			$arr[1] = 0;

			$arr[2] = intval($row['mma']);

		endif;
		//echo $row['mmjpd'];
		if ($row['mmjpd'] != 0 && $cantidad == 1) :

			$suma = 0;

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



					if (intval($equi) == intval($equic) && intval($iddd) == intval($idddc)) :

						$suma += intval($row2['ap']);

					endif;

				endif;
			}

			$arr[0] = false;

			$arr[1] = intval($row['mmjpd']) - $suma;

		else :
			$arr = array(true, 0, 0);
		endif;

	endif;

	return ($arr);
}







function restricciones2($conce, $idj, $lequic, $cantidad, $lidddc, $acobrar, $ap)

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
		endif;

		if ($row['maxpremio'] != 0) :
			if (($acobrar - $ap) > $row['maxpremio']) : $valuar = false;
			endif;
		endif;

		if ($valuar) :

			if ($row['mmjpp'] != 0 && $cantidad != 1) :

				$suma = 0;

				$equia = explode('|', $lequic);
				array_pop($equia);
				sort($equia);

				$iddda = explode('|', $lidddc);
				array_pop($iddda);
				sort($iddda);

				$equic = array();
				$idddc = array();

				$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb  where idc='" . $conce . "' and idj=" . $idj . " and activo=1");



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





						/* 					 print_r($idddc);print_r($iddda);echo "<br>";



 */



						if (count($result1) == 0 && count($result2) == 0) :

							$suma += intval($row2['ap']);

						/*    print_r($equic);print_r($equia);echo "<br>"; */

						endif;

					endif;
				}

				$arr[0] = false;

				$arr[1] = intval($row['mmjpp']) - $suma;

			endif;

		else :

			$arr[0] = true;

			$arr[1] = 'A';

		endif;

	endif;



	return ($arr);
}




function contarvalor($arr, $valor)
{
	$cuen = 0;

	for ($c = 0; $c <= count($arr) - 1; $c++) {
		if (intval($arr[$c]) == intval($valor)) :
			$cuen++;
		endif;
	}
	return $cuen;
}

function contarenblanco($arr, $desde)
{
	$cuen = 0;
	for ($c = $desde; $c <= count($arr) - 1; $c++) {
		if ($arr[$c] == 0) :
			$cuen++;
		endif;
	}
	return $cuen;
}


function calculodepago($vj, $vr, $pb, $pm, $parti, $divi, $factor)
{
	//calulo del pago
	$pago = 0;
	if ($pb != 0) :
		$pago = $parti * $divi;
	endif;
	if ($pm != 0) :
		$pago += $parti * (($factor * $vj) / $vr);
	endif;
	return $pago;
}





function participaciones($array, $tp)

{

	$suma = 0;

	for ($c = 0; $c <= count($array) - 1; $c++) {

		$suma += $array[$c][$tp];
	}

	return $suma;
}
function calculoparticipaciones($array)
{
	$part = 1;

	for ($c = 0; $c <= count($array) - 1; $c++) {
		$key = substr_count($array[$c], '*');
		if ($key != 0) :
			$part = $part * $key;
		endif;

		$vepar = explode('-', $array[$c]);

		for ($hv = 0; $hv <= count($vepar) - 2; $hv++) {
			$vepar1 = explode('*', $vepar[$hv]);
			$part = $part * $vepar1[1];
		}
	}
	return $part;
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



function getip()
{

	if (getenv('HTTP_X_FORWARDED_FOR')) {

		$realip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif (getenv('HTTP_CLIENT_IP')) {

		$realip = getenv('HTTP_CLIENT_IP');
	} else {

		$realip = getenv('REMOTE_ADDR');
	}




	return $realip;
}

function accesolimitado($idu)

{
	if ($idu != '') :
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu  where IDusu=" . $idu);

		if (mysqli_num_rows($result) != 0) :

			$row = mysqli_fetch_array($result);

			if ($row['ABanca'] == 0):
				return $row['AGrupo'];
			endif;

			$idbanca = $row['ABanca'];
			$listGrupo = [];
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo  where IDB=" . $idbanca);
			while ($row = mysqli_fetch_array($result)) {
				$listGrupo[] = $row['IDG'];
			}
			return join(',', $listGrupo);

		else :

			return 0;

		endif;
	else :
		return 0;
	endif;
}

function accesolimitadobanca($idu)
{
	if ($idu != '') :
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu  where IDusu=" . $idu);

		if (mysqli_num_rows($result) != 0) :

			$row = mysqli_fetch_array($result);

			return $row['ABanca'];

		else :

			return 0;

		endif;
	else :
		return 0;
	endif;
}



function Bitacora($texto)

{

	$result = mysqli_query($GLOBALS['link'], "Insert _logs values('" . Horareal(-30, "h:i:s A") . "','" . Fechareal(-30, "d/m/y") . "','" . $texto . "')");
}

function permitemodif($dp, $idj)

{

	$rjuh = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrebb_bloqueo where IDJ=" . $idj . " and Grupo=" . $dp);

	if (mysqli_num_rows($rjuh) == 0) :

		return true;

	else :

		return false;

	endif;
}



function convertirvtk($valorss, $ndiv, $ilos)
{

	if ($valorss != '') :
		if ($ndiv == false) :
			if (abs($valorss) <= 99) :
				$valordysplay = $valorss;
				$r = fmod($valorss, 1);
			else :
				$valordysplay = $valorss / 10;
				$r = fmod($valorss, 10);
			endif;
		else :
			$valordysplay = $valorss;
			$r = fmod($valorss, 1);
		endif;


		if ($r != 0) :
			if ($valorss < 0) :
				$valordysplay = $valordysplay + .5;
			else :
				$valordysplay = ($valordysplay - .5);
			endif;
			$valordysplay = $valordysplay . '.5';
		endif;

		$anexo = '';

		if ($valorss > 0) :
			if ($ilos) :
				$anexo = '+';
			else :
				$anexo = ' ';
			endif;
		endif;

		$valordysplay = $anexo . $valordysplay;

		return  $valordysplay;

	else :
		return '';
	endif;
}
function recalculoTK($jud, $ap)
{

	$jgdad = explode('*', $jud);
	$valorini = 0;
	for ($u = 0; $u <= count($jgdad) - 2; $u++) {

		$opcion = explode('|', $jgdad[$u]);
		$logro = intval($opcion[1]);
		// ********************  Calculo del Parlay ***********************************
		if ($logro < 0) {
			$valorf = $logro * -1;      // Factor  <0 100/Logro + 1 * Apuesta
			$factor = (100 / $valorf) + 1;
			$ap = ($factor * $ap);
			$valorini = $ap;
		} else {
			$factor = ($logro / 100) + 1; // Factor  >0 Logro/100 + 1 * Apuesta
			$ap = ($factor * $ap);
			$valorini = $ap;
		}
		//*********************************************************************************

	}
	return $valorini;
}



function restricciones3($conce, $idj, $lequic, $cantidad, $lidddc, $acobrar, $ap)
{

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario where idc='" . $conce . "'");
	$arr = array(true, 0);

	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$valuar = true;

		/*if ($row['mmdp']!=0):
		$mmda=$row['mmdp']*$ap;
	    if   (($acobrar-$ap)>$mmda): $valuar=false;   endif;
	endif;*/
		$idg = $row['IDG'];
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _trestricionesbb where IDG=" . $row['IDG']);


		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			if ($valuar) :
				if ($row['MxP'] != 0 && $cantidad != 1) :
					$suma = 0;
					$monto = $row['MxP'];
					$equia = explode('|', $lequic);
					array_pop($equia);
					sort($equia);
					$iddda = explode('|', $lidddc);
					array_pop($iddda);
					sort($iddda);
					$equic = array();
					$idddc = array();

					$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb  where idj=" . $idj . " and activo=1 and IDC in (select IDC from _tconsecionario where IDG=" . $idg . ")");

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

					$arr[0] = false;
					$arr[1] = intval($monto) - $suma;
				else :
					if ($row['MxD'] != 0 && $cantidad == 1) :
						///////
						$monto = $row['MxD'];
						$suma = 0;
						$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb  where idj=" . $idj . " and activo=1 and IDC in (select IDC from _tconsecionario where IDG=" . $idg . ")");

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

								if (intval($equi) == intval($lequic) && intval($iddd) == intval($lidddc)) :
									$suma += intval($row2['ap']);
								endif;
							endif;
						}

						$arr[0] = false;
						$arr[1] = intval($monto) - $suma;
					///////
					endif;
				endif;
			else :
				$arr[0] = true;
				$arr[1] = 'A';
			endif;
		endif;

	endif;


	return ($arr);
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

function EntreHoras($hora, $horaDesde, $horaHasta)
{
	$horaM = explode(":", $horaDesde);
	$fechaMK = explode("/", '1/1/2009');
	if (!isset($horaM[2])) : $horaM[2] = 0;
	endif;
	$fechaDESDE = mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);


	$horaM = explode(":", $horaHasta);
	$fechaMK = explode("/", '1/1/2009');
	if (!isset($horaM[2])) : $horaM[2] = 0;
	endif;
	$fechaHASTA =  mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);


	$horaM = explode(":", $hora);
	$fechaMK = explode("/", '1/1/2009');
	if (!isset($horaM[2])) : $horaM[2] = 0;
	endif;
	$fechaACTUAL =  mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);

	$respuesta =	($fechaACTUAL >= $fechaDESDE  and  $fechaACTUAL <= $fechaHASTA);
	return $respuesta;
}
function WhatBancaByUsuario($IDT)
{

	$result = mysqli_query($GLOBALS['link'], "SELECT _tgrupo.IDB FROM `_tusu` , _tgrupo WHERE _tusu.AGrupo = _tgrupo.IDG AND IDusu = $IDT");

	$rowIDC = mysqli_fetch_array($result);

	return $rowIDC['IDB'];
}
function WhatBanca($IDC)
{

	$result = mysqli_query($GLOBALS['link'], "SELECT _tgrupo.IDB FROM `_tconsecionario` , _tgrupo WHERE _tconsecionario.IDG = _tgrupo.IDG AND IDC = '$IDC'");
	//echo ("SELECT _tgrupo.IDB FROM `_tconsecionario` , _tgrupo WHERE _tconsecionario.IDG = _tgrupo.IDG AND IDC = '$IDC'");
	$rowIDC = mysqli_fetch_array($result);

	return $rowIDC['IDB'];
}
function WhatGrupo($IDC)
{
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM `_tconsecionario` , _tgrupo WHERE IDC = '$IDC'");
	$rowIDC = mysqli_fetch_array($result);
	return $rowIDC['IDG'];
}

function calculodeMinutos($fecha, $hora1, $hora2)
{
	$horaM = explode(":", $hora1);
	$fechaMK = explode("/", $fecha);
	if (!isset($horaM[2])) : $horaM[2] = 0;
	endif;
	$fechaMK1 = mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);


	$horaM = explode(":", $hora2);
	$fechaMK = explode("/", $fecha);
	if (!isset($horaM[2])) : $horaM[2] = 0;
	endif;
	$fechaMK2 =  mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);

	$respuesta = $fechaMK2 - $fechaMK1;
	return ($respuesta / 60);
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

function evaluarLogro($logro)
{
	$logro = round($logro);
	if ($logro > 0) :

		if (strlen($logro) == 3 || strlen($logro) == 4) :
			return true;
		else :

			return false;
		endif;
	else :
		if (strlen($logro) == 4 || strlen($logro) == 5) :
			return true;
		else :
			return false;
		endif;
	endif;

	return true;
}
function escrutesticket($IDJ)
{ //SELECT * FROM _tbpubliresultados where IDJ=2497

	$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tbpubliresultados  where IDJ=$IDJ  ");
	if (mysqli_num_rows($result2) != 0) :
		$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tbescrute  where IDJ=$IDJ  ");
		if (mysqli_num_rows($result2) != 0) :
			$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tjugadabb  where IDJ=$IDJ  Order By IDJ");
			while ($row2 = mysqli_fetch_array($result2)) {
				////////////////////////////////////////////////////////////////////////////////////////
				$resultOpen = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tbcierresemana  where IDJ=" . $row2['IDJ']);
				if (mysqli_num_rows($resultOpen) != 0) :
					$rowOpen = mysqli_fetch_array($resultOpen);
					if ($rowOpen['Cierre'] == 1) :
						if ($row2['escrute'] == '') :
							$cod = pescrute($row2['serial'], 1, false);
						endif;
					else :
						$cod = pescrute($row2['serial'], 1, false);
					endif;
				else :
					$cod = pescrute($row2['serial'], 1, false);
				endif;
				////////////////////////////////////////////////////////////////////////////////////////
			}
		endif;
	endif;
}
function HoraNormal($HoraM)
{
	$fho = explode(':', $HoraM);
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

	return ($horr . ':' . $fho[1] . $ann);
}
function Logs($IDusu, $IDM, $Actividad, $Estatus)
{
	$horaticket = Horareal($GLOBALS['minutosh'], "h:i:s A");
	$fechaactual = Fechareal($GLOBALS['minutosh'], "d/n/Y");
	$ip = getip();
	if (empty($ip) || !preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $ip)) : $ip = $_SERVER["REMOTE_ADDR"];
	endif;

	$resultLogs = mysqli_query($GLOBALS['link'], "Insert _auditoria_accesos (IDusu, IDM, fecha,hora, ip, actividad,estatus) values ($IDusu,$IDM,'" . $fechaactual . "','" . $horaticket . "','$ip','$Actividad',$Estatus)");
}

function diferenciadehoras($fecha, $hora1, $hora2)
{
	$horaM = explode(":", $hora1);
	$fechaMK = explode("/", $fecha);
	if (!isset($horaM[2])) : $horaM[2] = 0;
	endif;
	$fechaMK1 = mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);


	$horaM = explode(":", $hora2);
	$fechaMK = explode("/", $fecha);
	if (!isset($horaM[2])) : $horaM[2] = 0;
	endif;
	$fechaMK2 =  mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);

	$respuesta = $fechaMK1 <= $fechaMK2;
	return $respuesta;
}
function SendMail($iemail, $motivo, $texto, $correp)
{
	if ($iemail != '') :
		$header = 'From: noresponder<' . $correp . '>\n';
		$header .= 'MIME-Version: 1.0\n';
		$header .= 'Content-type: text/html; charset=iso-8859-1';
		$msj = $motivo . "\"\n";
		$msj .= $texto . "\"\n";
		$dest = $iemail; //$rowj['email'];//<- Aqui debo colocar el correo que recibira la clave BLI
		$asunto = 'Sistema de Notificaciones SKYNET';
		$ok = @mail($dest, $asunto, $msj, $header);
		return $ok;
	endif;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function dSpe($vlor, $pro)
{
	$ecua = false;


	$varl = $vlor;
	$es = '';
	if ($pro == 8) :
		$pos = strpos($varl, 'o');
		if (!($pos === false)) $es = 'o';
		$pos = strpos($varl, 'u');
		if (!($pos === false)) $es = 'u';
	endif;
	///// con signo adelante y compuesto /////
	$signo = strpos($varl, '-');
	$slas = strpos($varl, '/');
	$cuentsig = substr_count($varl, '-');
	if ($signo == 0 && strlen($varl) > 6 && $slas > 0) :
		$vl = explode('/', $varl);
		$ecua = true;
		$vl[] = 1;
	endif;
	if ($signo > 0 && strlen($varl) > 6 && $slas == 0) :
		$vl = explode('-', $varl);
		if ($pro != 4) $vl[1] = '-' . $vl[1];
		$ecua = true;
		$vl[] = 2;
	endif;

	if ($signo > 0 && strlen($varl) >= 5 && $slas == 0) :
		$vl = explode('-', $varl);
		// if ($pro!=4)
		$vl[1] = '-' . $vl[1];
		$ecua = true;
		$vl[] = 2;
	endif;
	if (strlen($varl) >= 5 && $slas == 0 && $cuentsig == 2) :
		$vl = explode('-', $varl);
		$vl[0] = '-' . $vl[1];
		$vl[1] = $vl[2];
		$vl[1] = '-' . $vl[1];
		$ecua = true;
		$vl[2] = 2;
	endif;

	$mas = strpos($varl, '+');
	$cuentsig = substr_count($varl, '+');
	if ($signo == 0 && strlen($varl) >= 5 && $slas == 0 && $mas > 0) :
		$vl = explode('+', $varl);
		$vl[1] = '+' . $vl[1];
		$ecua = true;
		$vl[] = 2;
	endif;


	if ($signo == 0 && strlen($varl) > 6 && $slas == 0 && $mas > 0) :
		$vl = explode('+', $varl);
		$vl[1] = '+' . $vl[1];
		$ecua = true;
		$vl[] = 2;
	endif;

	if ($signo == 0 && strlen($varl) >= 5 && $slas == 0 && $cuentsig == 2) :
		$vl = explode('+', $varl);
		$vl[0] = '+' . $vl[1];
		$vl[1] = $vl[2];
		$vl[2] = 2;
		$vl[1] = '+' . $vl[1];
		$ecua = true;
	endif;

	$letra = strpos($varl, 'o');
	if ($letra > 0) :
		$vl = explode('o', $varl);
		$ecua = true;
		$vl[] = 2;
	endif;
	$letra = strpos($varl, 'u');
	if ($letra > 0) :
		$vl = explode('u', $varl);
		$ecua = true;
		$vl[] = 2;
	endif;

	//if ($pro==7): if ($vl[2]==1):

	if ($ecua) : if ($vl[0] == 'pk') $vl[0] = 0;
		$vl[] = $es;
		return ($vl);
	else : return array($varl, 0, 0, $es);
	endif;
}

function Detect($valores)
{
	if ($valores < 0) $valores = $valores * -1;

	if (strlen($valores) >= 4) :
		$tipo = 1;
	else :
		if ($valores > 100) $tipo = 1;
		else $tipo = 0;
	endif;

	return $tipo;
}
function redonl($vlor)
{
	$decil = explode('.', $vlor);
	if (count($decil) == 2) :
		if ($decil[1] != 5) :
			if ($decil[1] < 5) :
				$vf = $decil[0];
			else :
				if ($decil[0] < 0) $vf = $decil[0] - 1;
				else $vf = $decil[0] + 1;
			endif;
		else :
			$vf = $vlor;
		endif;

	else :
		$vf = $vlor;
	endif;
	return $vf;
}
function DBconver($idCnv, $LogroM, $modo, $macho, $eAB, $TablaxLogro)
{
	//echo $idCnv.'-'.$TablaxLogro;
	if ($TablaxLogro == 0) :
		if ($eAB) :
			$CampoM = 'AMacho';
			$CampoH = 'BHembra';
		else :
			switch ($idCnv) {
				case  1:
					$CampoM = 'A20M';
					$CampoH = 'A20H';
					break;
				case  2:
					$CampoM = 'A30M';
					$CampoH = 'A30H';
					break;
				case  3:
					$CampoM = 'A40M';
					$CampoH = 'A40H';
					break;
				case  4:
					$CampoM = 'AMacho';
					$CampoH = 'BHembra';
					break;
				case  5:
					$CampoM = 'ApreMedM';
					$CampoH = 'ApreMedH';
					break;
				case  6:
					$CampoM = 'ApreUnM';
					$CampoH = 'ApreUnH';
					break;
				case  7:
					$CampoM = 'ApreUnMedM';
					$CampoH = 'ApreUnMedH';
					break;
				case  8:
					$CampoM = 'MoneyLM';
					$CampoH = 'MoneyLH';
					break;
				case  9:
					$CampoM = 'Logro5inM';
					$CampoH = 'Logro5inH';
					break;
			}
		endif;
	else :
		$idCnv = $TablaxLogro;
		switch ($idCnv) {
			case  1:
				$CampoM = 'A20M';
				$CampoH = 'A20H';
				break;
			case  2:
				$CampoM = 'A30M';
				$CampoH = 'A30H';
				break;
			case  3:
				$CampoM = 'A40M';
				$CampoH = 'A40H';
				break;
			case  4:
				$CampoM = 'AMacho';
				$CampoH = 'BHembra';
				break;
			case  5:
				$CampoM = 'ApreMedM';
				$CampoH = 'ApreMedH';
				break;
			case  6:
				$CampoM = 'ApreUnM';
				$CampoH = 'ApreUnH';
				break;
			case  7:
				$CampoM = 'ApreUnMedM';
				$CampoH = 'ApreUnMedH';
				break;
			case  8:
				$CampoM = 'MoneyLM';
				$CampoH = 'MoneyLH';
				break;
			case  9:
				$CampoM = 'Logro5inM';
				$CampoH = 'Logro5inH';
				break;

				/*case  2:
			$CampoM='A30M';$CampoH='A30H';break;
		case  3:
			$CampoM='A40M';$CampoH='A40H';break;*/
		}
	endif;
	//echo $CampoM.'_'.$CampoH;
	$LogroM = round($LogroM);
	//echo ("SELECT *  FROM _DBconver  where BaseM=$LogroM  " ); echo '*'.$modo.'*';echo '*'.$macho.'*'; echo '*'.$idCnv.'*';
	$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _DBconver  where BaseM=$LogroM  ");
	if (mysqli_num_rows($result2) != 0) :
		$rowOpen = mysqli_fetch_array($result2);
		if ($modo == 3) :
			if ($macho == 1) :
				$NewLogro = array($rowOpen[$CampoH], $rowOpen[$CampoM]);
			else :
				$NewLogro = array($rowOpen[$CampoM], $rowOpen[$CampoH]);
			endif;
		else :
			if ($macho == 2) :
				$NewLogro = array($rowOpen[$CampoH], 0, $rowOpen[$CampoM], 0);
			else :
				$NewLogro = array($rowOpen[$CampoM], 0, $rowOpen[$CampoH], 0);
			endif;
		//  print_r($NewLogro);
		endif;
	else :
		$NewLogro = array($LogroM, 0);
	endif;
	//print_r($NewLogro);
	return $NewLogro;
}
function moda($tuArray)
{
	$cuenta = array_count_values($tuArray);
	arsort($cuenta);
	return key($cuenta);
}
function _findsigno($periodo, $idequi, $idj, $add)
{
	global $skynet;
	global $proceso;
	$lcx = array();
	$result = mysqli_query($GLOBALS['link'], "Select * From _tblogrosNT where idequi=" . $idequi . " and idj=" . $idj . " and periodo=" . $periodo . $add, $skynet);
	while ($row1 = mysqli_fetch_array($result)) {
		if ($row1['logro'] != '') :
			$dett = dSpe($row1['logro'], $proceso);
			$lcx[] = $dett[0];
		endif;
	}

	$valmoda = moda($lcx);

	echo '=>*' . $valmoda;
	echo '<br>';

	return $valmoda;
}

function decoBase($_decoParam)
{
	// Proceso DECODE param
	$_utxprm = urldecode(base64_decode($_decoParam));
	$_utxprm = explode(',', $_utxprm);
	// print_r($_utxprm);
	for ($i = 0; $i <= count($_utxprm) - 1; $i++) {
		$varibles = explode(':', $_utxprm[$i]);
		$_REQUEST[$varibles[0]] = $varibles[1];
	}
	// Fin Proceso DECODE

}

function ecoBase($_ecoParam)
{
	// Proceso DECODE param
	$_utxprm = base64_encode(urlencode($_ecoParam));
	return $_utxprm;
}
///////////////////////////////////////////////////  CREDITOS ////////////////////////////////////////////////////
function  cRdSaldo($IDC, $Monto, $IDCN, $Tipo, $Ref)
{
	$queda = array(true, 0);
	$resultij = mysqli_query($GLOBALS['link'], "select * from _tbcrdcredito  where  IDC='$IDC'");
	if (mysqli_num_rows($resultij) != 0) :
		$AuCredito = 0;
		$rowij = mysqli_fetch_array($resultij);
		if ($rowij['saldo'] != 0) : $AuCredito = cRdCredito($IDC);
		endif;

		if ($rowij['saldo'] == 0) : $valorSaldo = $rowij['credito'];
		else :  $valorSaldo = $rowij['saldo'];
		endif;
		if (($valorSaldo + $AuCredito) >= $Monto) :

			if ($rowij['saldo'] == 0) :
				$SaldoN = $rowij['credito'] - $Monto;
			else :
				$SaldoN = $rowij['saldo'] - $Monto;
			endif;
			//echo $rowij['saldo']+$AuCredito;
			$fecha = Fechareal($GLOBALS['minutosh'], "d/n/Y");
			$hora = Horareal($GLOBALS['minutosh'], "h:i:s A");
			$ultran = $fecha . '-' . $hora;
			$resultij = mysqli_query($GLOBALS['link'], "Update _tbcrdcredito set saldo=$SaldoN,ultimtrans='$ultran' where  IDC='$IDC'");
			//echo ("Update _tbcrdcredito set saldo=$SaldoN,ultimtrans='$ultran' where  IDC='$IDC'");
			$resultij = mysqli_query($GLOBALS['link'], "Insert _tbcrdtranss (IDJ,Ref,fechahora,tipo,monto,saldo) values  ($IDCN,'$Ref','$ultran','$Tipo',$Monto,$SaldoN)");
			return $queda;
		else :
			$queda = array(false, $valorSaldo);
			return $queda;
		endif;
	else :
		return $queda;
	endif;
}

function cRdCredito($IDC)
{
	global $minutosa;
	$fecha = Fechareal($minutosa, "d/n/Y");
	$aIDCNr = array();
	$TotalIDCN = array();
	// Buscar Fecha de Hoy///
	$resultCONFI = mysqli_query($GLOBALS['link'], "Select * from _jornadabb  where  	Fecha='" . $fecha . "' order by IDJ");
	while ($rowgrupo = mysqli_fetch_array($resultCONFI)) {
		// echo ("Select * from _tbcrdtranss  where IDJ='".$rowgrupo['IDJ']."' and Ref='".$IDC."' order by IDJ");
		$resultCONFI2 = mysqli_query($GLOBALS['link'], "Select * from _tbcrdtranss  where IDJ='" . $rowgrupo['IDJ'] . "' and Ref='" . $IDC . "' order by IDJ") or die(mysqli_error($GLOBALS['minutosh']));
		if (mysqli_num_rows($resultCONFI2) == 0) :
			$aIDCNr[] = $rowgrupo['IDJ'];
			$TotalIDCN[$rowgrupo['IDJ']] = 0;
		endif;
	}
	/////////////////////////
	$totalsuma = 0;
	for ($ir = 0; $ir <= count($aIDCNr) - 1; $ir++) {
		$resultCONFIn2 = mysqli_query($GLOBALS['link'], "Select * from  _tjugadabb where IDJ=" . $aIDCNr[$ir] . " and IDC='$IDC' and Activo=1");
		while ($rowgrupo2 = mysqli_fetch_array($resultCONFIn2)) {
			$premacion = mescrute($rowgrupo2["serial"]); //EscrutarHI($rowgrupo2["Serial"],1);
			if ($premacion['condicion']) :
				$totalsuma += $premacion['acobrar'];
			endif;
		}
	}

	$resultCONFI2 = mysqli_query($GLOBALS['link'], "Update _tbcrdcredito set CreditoDiario=$totalsuma where  IDC='$IDC'");
	return  $totalsuma;
}

function cRdCreditoAnt($IDC)
{
	global $minutosa;
	//echo '1<br>';
	$resultij = mysqli_query($GLOBALS['link'], "select * from _tbcrdcredito  where  IDC='$IDC'");
	if (mysqli_num_rows($resultij) != 0) :
		$rowij = mysqli_fetch_array($resultij);

		if ($rowij['CierreDebi'] != FechaAnt("d/n/Y") && $rowij['nuevo'] != Fechareal($minutosa, "d/n/Y")) :

			$SaldoN = $rowij['saldo'];
			$aIDCNr = array();
			$TotalIDCN = array();
			$FC = explode('-', $rowij['ultimtrans']);
			$FechaUltima = $FC[0];
			// Buscar Fecha de Ayer///
			$resultCONFI = mysqli_query($GLOBALS['link'], "Select IDJ,Fecha from _jornadabb  where Fecha='" . $FechaUltima . "' group by IDJ order by IDJ ");
			//echo("Select IDJ,Fecha from _jornadabb  where Fecha='".$FechaUltima."' group by IDJ order by IDJ ");
			while ($rowgrupo = mysqli_fetch_array($resultCONFI)) {
				$resultCONFI2 = mysqli_query($GLOBALS['link'], "Select * from _tbcrdtranss  where IDJ='" . $rowgrupo['IDJ'] . "' and Ref='" . $IDC . "' order by IDJ");
				if (mysqli_num_rows($resultCONFI2) == 0) :
					$aIDCNr[] = $rowgrupo['IDJ'];
					$TotalIDCN[$rowgrupo['IDJ']] = 0;
				endif;
			}
			/////////////////////////

			$totalsuma = 0;

			for ($ir = 0; $ir <= count($aIDCNr) - 1; $ir++) {
				$resultCONFI2 = mysqli_query($GLOBALS['link'], "Select * from _tjugadabb where 	IDJ=" . $aIDCNr[$ir] . " And IDC='$IDC' and activo=1");
				//echo ("Select * from _tjugadabb where 	IDJ=".$aIDCNr[$ir]." And IDC='$IDC' and activo=1");
				while ($rowgrupo2 = mysqli_fetch_array($resultCONFI2)) {
					$premacion = mescrute($rowgrupo2["serial"]); //EscrutarHI($rowgrupo2["Serial"],1);

					if ($premacion['condicion']) :
						$TotalIDCN[$aIDCNr[$ir]] += $premacion['acobrar'];
						$totalsuma += $premacion['acobrar'];
					endif;
				}
			}

			$fecha = FechaAnt("d/n/Y");
			$hora = Horareal($minutosa, "h:i:s A");
			$ultran = $fecha . '-' . $hora;
			$Tipo = 'C';
			$resultij = true;
			mysqli_query($GLOBALS['link'], "begin");
			///////////////////////////////////// DEBO INCLUIR EN TRANSACCIONES /////////////////////////////
			$SaldoNv = $SaldoN;
			foreach ($TotalIDCN as $KeyN2 => $Valor) {
				$SaldoNv += $Valor;
				$resultij = mysqli_query($GLOBALS['link'], "Insert _tbcrdtranss (IDJ,Ref,fechahora,tipo,monto,saldo) values  ($KeyN2,'$IDC','$ultran','$Tipo',$Valor,$SaldoNv)");
				if (!$resultij) : exit;
				endif;
			}

			if (!$resultij) :
				mysqli_query($GLOBALS['link'], "rollback");
			else :
				mysqli_query($GLOBALS['link'], "commit");
				$SaldoN += $totalsuma;
				$resultij = mysqli_query($GLOBALS['link'], "Update _tbcrdcredito set saldo=$SaldoN,ultimtrans='$ultran',CierreDebi='" . $FechaUltima . "',CreditoDiario=0 where  IDC='$IDC'");
			endif;



		//////////////////////////////////////////////////////////////////////////////////////////////////
		endif;
	endif;
	return true;
}
function FechaAnt($formato)
{
	$x = date("H i s m d Y", time());
	$fecha = explode(" ", $x);
	$fecha[4] = $fecha[4] - 1;
	$fecha2 = date($formato, mktime($fecha[0], $fecha[1], $fecha[2], $fecha[3], $fecha[4], $fecha[5]));
	return $fecha2;
}
function namerand()
{

	//To Pull 7 Unique Random Values Out Of AlphaNumeric

	//removed number 0, capital o, number 1 and small L
	//Total: keys = 32, elements = 33
	$characters = array(
		"A",
		"B",
		"C",
		"D",
		"E",
		"F",
		"G",
		"H",
		"J",
		"K",
		"L",
		"M",
		"N",
		"P",
		"Q",
		"R",
		"S",
		"T",
		"U",
		"V",
		"W",
		"X",
		"Y",
		"Z",
		"1",
		"2",
		"3",
		"4",
		"5",
		"6",
		"7",
		"8",
		"9"
	);

	//make an "empty container" or array for our keys
	$keys = array();

	//first count of $keys is empty so "1", remaining count is 1-6 = total 7 times
	while (count($keys) < 7) {
		//"0" because we use this to FIND ARRAY KEYS which has a 0 value
		//"-1" because were only concerned of number of keys which is 32 not 33
		//count($characters) = 33
		$x = mt_rand(0, count($characters) - 1);
		if (!in_array($x, $keys)) {
			$keys[] = $x;
		}
	}
	$random_chars = '';
	foreach ($keys as $key) {
		$random_chars .= $characters[$key];
	}

	return  $random_chars;
}
///TOKENT:ADD FOR ACCEPT TOKENT SUCCESS 
function timeStamp()
{
	$fecha = new DateTime();
	return $fecha->getTimestamp();
}
function viewIDReG($rndusr)
{
	$resultij = mysqli_query($GLOBALS['link'], "select * from _tusu where  bloqueado=$rndusr");
	if (mysqli_num_rows($resultij) != 0) {
		$rowij = mysqli_fetch_array($resultij);
		$IDusu = $rowij['IDusu'];
		$resultij = mysqli_query($GLOBALS['link'], "select * from _tusu_2fa where  idusu=$IDusu");
		if (mysqli_num_rows($resultij) != 0) {
			$rowij = mysqli_fetch_array($resultij);
			return $rowij['authid'];
		} else
			return '0';
	} else
		return '0';
}
function vericToken($rndusr)
{
	$resultij = mysqli_query($GLOBALS['link'], "select * from _tusu where  bloqueado=$rndusr");
	if (mysqli_num_rows($resultij) != 0) {
		$rowij = mysqli_fetch_array($resultij);
		$IDusu = $rowij['IDusu'];
		$resultij = mysqli_query($GLOBALS['link'], "select * from tokents where  idusu=$IDusu");
		if (mysqli_num_rows($resultij) != 0) {
			$rowij = mysqli_fetch_array($resultij);
			$hashtime = timeStamp() - intval($rowij['timelast']);
			if ($hashtime > 600) // 10 min timelaps in valied if 
				return false;
			else
				return true;
		} else
			return false;
	} else
		return false;
}
function acceptTocket($rndusr)
{
	$resultij = mysqli_query($GLOBALS['link'], "select * from _tusu where  bloqueado=$rndusr");
	if (mysqli_num_rows($resultij) != 0) {
		$rowij = mysqli_fetch_array($resultij);
		$IDusu = $rowij['IDusu'];
		$hashtime = timeStamp();
		$resultij = mysqli_query($GLOBALS['link'], "select * from tokents where  idusu=$IDusu");
		if (mysqli_num_rows($resultij) != 0)
			$sql = "Update tokents set timelast='$hashtime'  where  idusu=$IDusu";
		else
			$sql = "Insert tokents (idusu,timelast) values ($IDusu,'$hashtime')";


		$resultij = mysqli_query($GLOBALS['link'], $sql);

		return $resultij;
	} else
		return false;
}

function json_response($code = 200, $message = null)
{
	// clear the old headers
	header_remove();
	// set the actual code
	http_response_code($code);
	// set the header to make sure cache is forced
	header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
	// treat this as json
	header('Content-Type: application/json');
	$status = array(
		200 => '200 OK',
		404 => '404 Not Found',
		406 => ' 406 Not Acceptable'
	);
	// ok, validation error, or failure
	header('Status: ' . $status[$code]);
	// return the encoded json
	return json_encode(array(
		'status' => $code < 300, // success or not?
		'message' => $message
	));
}
///TOKENT:ADD FOR ACCEPT TOKENT SUCCESS 
function getCode2fa($IDusu)
{
	global $link;
	$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu_2fa where IDusu=$IDusu");
	if (mysqli_num_rows($result2) == 0) return 0;

	$row2 = mysqli_fetch_array($result2);

	return $row2['authid'];
}
function SendMessageforCODE($uid)
{
	$THISURL = "https://token.saamqx.net:4700/send?id=$uid";

	return  fetch($THISURL);
}

function VerifiToketSend($uid, $Tk)
{
	$code = $uid . 'opop' . $Tk;
	$THISURL = "https://token.saamqx.net:4700/verify?code=$code";

	return fetch($THISURL);
}

function fetch($THISURL)
{

	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => $THISURL,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache"
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);
	$data = json_decode($response, true);

	return $data;
}
// $TYPE_VENTA = 1;
// $TYPE_PREMIO = 2;
// $TYPE_SALDO = 3;
// $TYPE_REVERSO = 5;
// $TYPE_PREMIO_REVERSO = 5;
// $MSG_NO_AVALIBLE_CREDIT = 'No tiene credito DISPONIBLE';
// $token = 'w8D3rTzCrxw968OhtanyMdOUC9AMYe3L';
// $API_REST = $mode == $PRODUCCION ?  'https://credito.westernbets.pro:3145' : 'http://localhost:3145';

// function BackendCredito($IDC, $Serial, $Monto, $Tipo)
// {
// 	global $MSG_NO_AVALIBLE_CREDIT;
// 	$IDCwithCredit = ListCredit();

// 	$key = array_search($IDC, $IDCwithCredit);

// 	if ($key === false) :
// 		return ['err' => true, 'mensaje' => $MSG_NO_AVALIBLE_CREDIT];
// 	endif;

// 	global $TYPE_PREMIO;
// 	global $TYPE_VENTA;
// 	global $TYPE_SALDO;
// 	global $token;
// 	global $API_REST;
// 	if ($Tipo == $TYPE_SALDO) :
// 		$API_SALDO = '/currentvalue';
// 		$URL = $API_REST . $API_SALDO . '/' . $IDC;
// 		$Response = endPoint($URL, 'GET', [], $token);
// 	// if ($Tipo == $TYPE_VENTA || $Tipo == $TYPE_PREMIO || $Tipo == $TYPE_REVERSO):
// 	else :
// 		$API_VENTA = '/apply';
// 		$URL = $API_REST . $API_VENTA;
// 		$Data = [
// 			'idc' => $IDC,
// 			'monto' => $Monto,
// 			'serial' => $Serial,
// 			'tipo' => $Tipo,
// 		];
// 		$Response = endPoint($URL, 'PUT', $Data, $token);
// 	endif;

// 	$Error = $Response['err'];
// 	if (!$Error) {
// 		$Saldo = $Response['saldo'];
// 		$Moneda = $Response['moneda'] ?? "NA";
// 		return ['err' => false, 'saldo' => $Saldo, 'moneda' => $Moneda];
// 	}
// 	$Mensaje = $Response['msg'];
// 	return ['err' => true, 'mensaje' => $Mensaje];
// }
// function ListCredit()
// {
// 	global $token;
// 	global $API_REST;
// 	$URL = $API_REST . '/list';
// 	$Data = [];
// 	$Response = endPoint($URL, 'GET', $Data, $token);
// 	return $Response['data'] ?? [];
// }
// function ReverSerialWin($IDJ)
// {
// 	global $link;

// 	global $TYPE_PREMIO_REVERSO;
// 	$IDCwithCredit = ListCredit();
// 	$joinIdc = '';
// 	foreach ($IDCwithCredit as $a) {
// 		$joinIdc = $joinIdc . '"' . $a . '",';
// 	}
// 	$joinIdc = trim($joinIdc, ',');

// 	$sqlReverse = 'Select * from tbljgdprnk where IDC in (' . $joinIdc . ") and activo = 1 and idj=$IDJ";
// 	$resultReverse = mysqli_query($GLOBALS['link'], $sqlReverse);
// 	while ($rowReverse = mysqli_fetch_array($resultReverse)) {
// 		if ($rowReverse['escrute'] != '') {
// 			$escrute = unserialize($rowReverse['escrute']);

// 			if (k1escrute($escrute) && count($escrute) > 0) {
// 				$resul = BackendCredito($rowReverse['IDC'], $rowReverse['serial'], $rowReverse['acobrar'], $TYPE_PREMIO_REVERSO);
// 			}
// 		}
// 	}
// }
// function endPoint($URL, $Method, $Data, $token)
// {
// 	$curl = curl_init();

// 	curl_setopt_array($curl, [
// 		CURLOPT_URL => $URL,
// 		CURLOPT_RETURNTRANSFER => true,
// 		CURLOPT_TIMEOUT => 30,
// 		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
// 		CURLOPT_CUSTOMREQUEST => $Method,
// 		CURLOPT_HTTPHEADER => ['cache-control: no-cache', 'Content-Type: application/json', 'Authorization: Bearer ' . $token],
// 	]);
// 	if ($Data) {
// 		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($Data));
// 	}
// 	$response = curl_exec($curl);
// 	$err = curl_error($curl);
// 	curl_close($curl);
// 	$resp = json_decode($response, true);
// 	return $resp;
// }

function getlistBank()
{
	$list = [];
	$sql = 'Select * from _transac_portal_sbbancos order by idban';
	$result = mysqli_query($GLOBALS['link'], $sql);
	while ($row = mysqli_fetch_array($result)) {
		$list[$row["idban"]] = $row['Descripcion'];
	}
	return $list;
}
function getListformatpay()
{
	$list = [];
	$sql = 'Select * from _transac_portal_formpay  order by formatpay';
	$result = mysqli_query($GLOBALS['link'], $sql);
	while ($row = mysqli_fetch_array($result)) {
		$list[$row["formatpay"]] = $row['text'];
	}
	return $list;
}


$CONSTAPROBADO = "APROBADO";
$CONSTENESPERA = "ENESPERA";
$CONSTNOAPROBADO = "NOAPROBADO";
$RETIRO = 1;
$RECARGA = 2;
function setReportPay($IDC, $idusu_temp, $Monto, $Referencia, $formatpay, $tel_user, $idban)
{
	global $CONSTENESPERA;

	$datecreater = time();
	$date_transac = date('d/n/Y');

	$field = '(idusu_temp,datecreater,formatpay,status,email,phone,code_confirm,name_confirm,date_confirm,monto,errortext,idban,reportepago)';
	$value = [$idusu_temp, "'$datecreater'", $formatpay, "'$CONSTENESPERA'", "''", "'$tel_user'", "'$Referencia'", "'$Referencia'", "'$date_transac'", $Monto, "''", $idban, 1];

	$sql = "Insert _transac_portal_register $field values (" . implode(",", $value) . ")";
	$result = mysqli_query($GLOBALS['link'], $sql);
	$recibo =	mysqli_insert_id($GLOBALS['link']);
	return [$result, $recibo];
}

function setReportRet($IDC, $idusu_temp, $Monto, $Referencia, $formatpay, $tel_user, $idban, $passport)
{
	global $CONSTENESPERA;

	$datecreater = time();

	$field = '(idusu_temp,datecreater,formatpay,status,monto,phone,tosend,idban,procesado,dateprocesado,passport)';
	$value = [$idusu_temp, "'$datecreater'", $formatpay, "'$CONSTENESPERA'", $Monto, "'$tel_user'", "'$Referencia'", $idban, 0, "''", "'$passport'"];
	$sql = "Insert _transac_portal_retiros $field values (" . implode(",", $value) . ")";
	$result = mysqli_query($GLOBALS['link'], $sql);
	$recibo =	mysqli_insert_id($GLOBALS['link']);
	return [$result, $recibo];
}
$PERDEDOR = 1;
$NOTIENEESCRUTE = 2;
$GANADOR = 3;
function vescruteBytree2($arr)
{
	global $NOTIENEESCRUTE, $PERDEDOR, $GANADOR;

	$tipo = $GANADOR; // El ticket es GANADOR
	$key0 = array_search(0, $arr);
	if (!($key0 === false)) :
		$tipo = $PERDEDOR;  /// Ticket Perdido
	else :
		$key_1 = array_search(-1, $arr);
		if (!($key_1 === false)) : $tipo = $NOTIENEESCRUTE;
		endif;
	endif; /// Ticket No Hay Escrutes
	return $tipo;
}

function acredit_all_DEPRECATE($IDJ, $type)
{
	global $TYPE_PREMIO, $TYPE_PREMIO_REVERSO;
	$sql = "Select * from _tjugadabb where IDJ=$IDJ and activo=1";
	$result = mysqli_query($GLOBALS['link'], $sql);

	while ($row = mysqli_fetch_array($result)) {
		echo  $row['escrute'];
		$cod = $row['escrute'] != '' ? kescrute(unserialize($row['escrute']), $row['acobrar']) : ["condicion" => false];
		print_r($cod);
		if ($cod['condicion']) {
			BackendCredito($row['IDC'], $row['serial'], $row['acobrar'], $type == 1 ? $TYPE_PREMIO : $TYPE_PREMIO_REVERSO);
		} else {
			$check = checkSerialData($row['serial'], $row['acobrar']);
			if ($check && !$cod['condicion']) {
				BackendCredito($row['IDC'], $row['serial'], $row['acobrar'],  $TYPE_PREMIO_REVERSO);
			}
		}
	}
}
function checkSerialData($Serial, $MontoPremio)
{
	global $TYPE_PREMIO;
	$sql = "Select * from _tbcredito where Serial=$Serial and Tipo=$TYPE_PREMIO";
	$result = mysqli_query($GLOBALS['link'], $sql);

	if (mysqli_num_rows($result) != 0) {
		$row = mysqli_fetch_array($result);
		return $row['monto'] === $MontoPremio;
	}
	return false;
}


function convertEpochToDate($epoch)
{
	$dt = new DateTime("@$epoch");  // convert UNIX timestamp to PHP DateTime
	return $dt->format('Y-m-d H:i:s');
}

function isModeDart($idusu)
{
	$dark = 1;
	$sql = "SELECT *  FROM `_tusu_ext` WHERE `IDusu`=" . $idusu;
	$query = mysqli_query($GLOBALS['link'], $sql);
	if (mysqli_num_rows($query) != 0) :
		$row = mysqli_fetch_array($query);
		$dark = $row['dark'];
	else:
		$q = mysqli_query($GLOBALS['link'], "Insert  _tusu_ext (IDusu,dark) values ($idusu,1)");
	endif;

	return $dark;
}


function fetchAmericana($d1, $d2, $idc)
{

	global $mode;
	global $PRODUCCION;

	$curl = curl_init();

	$THISURL =  ($mode == $PRODUCCION) ? 'https://api2.westernbets.pro:60051' : 'http://localhost:9800';
	$data = [
		"dfecha" => $d1,
		"hfecha" => $d2,
		"idc" => $idc,
	];
	$THISURL .= '/report/detal';
	curl_setopt_array($curl, array(
		CURLOPT_URL => $THISURL,
		CURLOPT_POSTFIELDS => json_encode($data),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"Content-Type: application/json", // Tipo de contenido JSON
			"cache-control: no-cache",
			"OriginTocket: APUESTASBET"
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);
	$data = json_decode($response, true);

	return $data;
}

function isTicketBono($serial)
{
	$sql = "SELECT * FROM `_tjugadabb_descuento` WHERE `serial`=" . $serial;
	$query = mysqli_query($GLOBALS['link'], $sql);
	if (mysqli_num_rows($query) != 0) {
		$row = mysqli_fetch_array($query);
		return [true, $row['descont']];
	} else {
		return [false, 0];
	}
}