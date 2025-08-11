<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb  where idj=69 and activo=1");
while ($row2 = mysqli_fetch_array($result)) {
	$jud = $row2['Jugada'];
	$jgdad = explode('*', $jud);

	/*	19-5%-1.5|-120
				23-3%|-155
				11-5%-1.5|-150
				30-5%-1.5|-150
				10-3%|-170**/
	for ($i = 0; $i <= count($jgdad) - 1; $i++) {
		$opcion = explode('|', $jgdad[$i]);
		$logro = $opcion[1];
		$opcion1 = explode('%', $opcion[0]);
		$carr = $opcion1[1];
		$opcion2 = explode('-', $opcion1[0]);
		$equi = $opcion2[0];
		$iddd = $opcion2[1];
		if (intval($carr) == 15) :
			$opcion1[1] = 1.5;
		endif;
		if (intval($carr) == -15) :
			$opcion1[1] = -1.5;
		endif;
		if (intval($carr) == 15 || intval($carr) == -15) :
			/*   print_r($jgdad);
						print_r($opcion);*/
			echo $row2['serial'];
			$jgdad[$i] = implode('%', $opcion1) . '|' . $logro;
			print_r($jgdad);
			/*	print_r($opcion2);*/
			echo '<br>';
		endif;
	}

	$resultupp = mysqli_query($GLOBALS['link'], "Update  _tjugadabb set Jugada='" . implode('*', $jgdad) . "'  where serial=" . $row2['serial']);
}
