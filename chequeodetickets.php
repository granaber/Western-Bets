<?

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


$fc = $_REQUEST['fc'];


$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");

$row = mysqli_fetch_array($result);
$idj = 	$row['IDJ'];
//echo $idj;
$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb where IDJ=" . $idj . ' and activo=1'); //
//echo "SELECT * FROM _tjugadabb where IDJ=".$idj;
while ($row = mysqli_fetch_array($result)) {
	$hora = convertirMilitar($row['hora']);
	//echo $hora.'<br>';

	$jgdad = explode('*', $row['Jugada']);
	//print_r($jgdad);
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

		if (diferenciadehoras($fc, $row2['Hora'], $hora)) :
			echo $row['serial'] . ' Hora ticket:' . $hora . ' Hora del partido: ' . $row2['Hora'] . ' Letra: ' . $row['IDC'] . '<br>';
			break;
		/*else:
				  				  echo $row['serial'].'Hora ticket:'.$hora.' Hora del partido: '.$row2['Hora'].'<br>';*/

		endif;
	}
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
