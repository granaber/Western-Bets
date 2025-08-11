<?
date_default_timezone_set('America/Caracas');
require('prc_php.php');
global $minutosa;
$GLOBALS['link'] = Connection::getInstance();



$Serial = $_REQUEST['Serial'];
$IDCN = $_REQUEST['IDCN'];
$fecha = date("d/m/y");
$IDJugada = $_REQUEST['IDJugada'];
$Valor_R = $_REQUEST['Valor_R'];
$Valor_J = $_REQUEST['Valor_J'];
$terminal = $_REQUEST['terminal'];
$IDusu = $_REQUEST['IDusu'];
$jugada = $_REQUEST['jugada'];
$hora = Horareal($minutosa, "h:i:s A");
$IDC = $_REQUEST['idc'];
$multi = $_REQUEST['multi'];
$carr = $_REQUEST['carr'];
$fmr = $_REQUEST['fmr'];
$org = $_REQUEST['org'];
$nom = $_REQUEST['nom'];
$arr = array();

if (verificarcierre($IDCN, $carr)) :
	$idcram = rand(1, 2);
	if ($idcram == 1) :
		$se = chr(rand(1, 25) + 65) . rand(1, $Serial) . '-' . chr(rand(1, 25) + 65) . rand(1, $IDCN) . '-' . substr($Serial, 2, 1) . chr(rand(1, 25) + 65);
	else :
		$se = rand(1, $Serial) . chr(rand(1, 25) + 65) . '-' . chr(rand(1, 25) + 65) . rand(1, $IDCN) . '-' . substr($Serial, 2, 1) . chr(rand(1, 25) + 65) . '-' . chr(rand(1, 25) + 65) . rand(1, $Valor_J);
	endif;



	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrehi where ct=" . $carr . " and IDCN=" . $IDCN);

	if (mysqli_num_rows($result) == 0) :

		if (Verificacion($jugada, $IDC)) :

			$activar = 1;

			$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tjugadahi  (Serial,IDCN,Fecha,Hora,Jugada,IDJug,Valor_R,Valor_J,Terminal,IDusu,Anulado,IDC,carr,carr1,nom,org,se) VALUES (" . $Serial . "," . $IDCN . ",'" . $fecha . "','" . $hora . "','" . $jugada . "'," . $IDJugada . "," . $Valor_R . "," . $Valor_J . "," . $terminal . "," . $IDusu . ",0,'" . $IDC . "'," . $carr . ",0,'" . $nom . "'," . $org . ",'" . $se . "')");

			if ($result == false) :
				$arr[] = false;
				$arr[] = '1';

				$result2 = mysqli_query($GLOBALS['link'], "INSERT INTO _tjugada2hi  (Serial,IDCN,Fecha,Hora,Jugada,IDJug,Valor_R,Valor_J,Terminal,IDusu,Anulado,IDC,carr,carr1,nom,org,se) VALUES (" . $Serial . "," . $IDCN . ",'" . $fecha . "','" . $hora . "','" . $jugada . "'," . $IDJugada . "," . $Valor_R . "," . $Valor_J . "," . $terminal . "," . $IDusu . ",0,'" . $IDC . "'," . $carr . ",0,'" . $nom . "'," . $org . ",'" . $se . "')");
			else :
				$arr[] = true;
				$arr[] = $se;
				$arr[] = $hora;
				$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario where IDC='" . $IDC . "'");
				$row = mysqli_fetch_array($result);
				$arr[] = $row['Direccion'];

				$result = mysqli_query($GLOBALS['link'], "SELECT _hipodromoshi.* FROM _tconfjornadahi,_hipodromoshi where _tconfjornadahi.IDhipo=_hipodromoshi._idhipo  and  IDCN=" . $IDCN);
				$row = mysqli_fetch_array($result);
				$arr[] = $row['Descripcion'];
			endif;
		else :
			$arr[] = false;
			$arr[] = '3';
		endif;
	else :

		$arr[] = false;
		$arr[] = '2';
	endif;
else :
	//// Realizo el Cierre de la Carrera ////	
	cierreHI($IDCN, $carr, 0);
	////////////////////////////////////////	
	$arr[] = false;
	$arr[] = '2';
endif;
echo json_encode($arr);
// 1= No Hay almacenamiento FALLA Comunicacion con el Servidor 
// 2= La Carrera se encuentra CERRADA...
// 3= Por Cupo Maximo de la Jugada....


///// Modulo: Verificacion de Topes ////
function Verificacion($jugada, $IDC)
{
	$pasar = true;
	$verjugada = explode('|', $jugada);

	for ($i = 0; $i <= count($verjugada) - 1; $i++) {

		$detalle = explode('-', $verjugada[$i]);

		for ($y = 0; $y <= 2; $y++) {
			if ($detalle[$y] != 0) :
				$cupo = verCupos($IDC, $y);
				if ($cupo != -1) :
					if ($detalle[$y] > $cupo) :
						$pasar = false;
						break;
					endif;
				endif;
			endif;
		}
		if (!$pasar) : break;
		endif;
	}
	return $pasar;
}

function verCupos($IDC, $GPS)
{
	$cupoMaximo = -1;

	$result = mysqli_query($GLOBALS['link'], " SELECT * FROM _tcuposgps Where IDC='" . $IDC . "' and ID=" . $GPS);

	if (mysqli_num_rows($result) == 0) :
		$result = mysqli_query($GLOBALS['link'], " SELECT * FROM _tcuposgps Where IDC='Banca' and ID=" . $GPS);
		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			$cupoMaximo = $row['JugadaMaxima'];
		endif;
	else :
		$row = mysqli_fetch_array($result);
		$cupoMaximo = $row['JugadaMaxima'];
	endif;

	return $cupoMaximo;
}
