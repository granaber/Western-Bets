<?
date_default_timezone_set('America/Caracas');
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$IDC = $_REQUEST['IDC'];
$valorjugado = $_REQUEST['valorj'];
$valorreal = $_REQUEST['valorr'];

$tj = $_REQUEST['idj'];

$maximoValor = verCuposExoticas($IDC, $tj);

$permitido = 0;

if ($maximoValor != -1) :

	if ($valorjugado > ($maximoValor * $valorreal)) :
		$permitido = $maximoValor;
	endif;

endif;

echo json_encode($permitido);



function verCuposExoticas($IDC, $tj)
{
	$cupoMaximo = -1;

	$result = mysqli_query($GLOBALS['link'], " SELECT * FROM _tcupos Where IDC='" . $IDC . "' and IDJug=" . $tj);

	if (mysqli_num_rows($result) == 0) :
		$result = mysqli_query($GLOBALS['link'], " SELECT * FROM _tcupos Where IDC='Banca'  and IDJug=" . $tj);
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
