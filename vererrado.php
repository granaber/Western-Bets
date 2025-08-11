<?

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


$fc = $_REQUEST['fc'];


$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");

$row = mysqli_fetch_array($result);
$idj = $row['IDJ'];
//echo $idj;
$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb where IDJ=" . $idj . ' and activo=1'); //
//echo "SELECT * FROM _tjugadabb where IDJ=".$idj;
while ($row = mysqli_fetch_array($result)) {

	//echo $hora.'<br>';
	//40-21%6.5|-110*34-21%-2.5|-110*63-21%1.5|-110*51-21%0|-110*59-21%-4|-110*
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
		$errado = false;
		if ($logro > 0 && strlen(trim($logro)) == 2) :
			$errado = true;
		endif;


		if (!$errado) :

			if ($logro < 0 && strlen(trim($logro)) == 3) :
				$errado = true;
			endif;
		endif;


		if ($errado) :
			echo $row['serial'] . '-' . $row['IDC'] . '<br>';
			break;
		endif;
	}
}
