<?php
date_default_timezone_set('America/Caracas');
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb WHERE IDJ =161");
while ($row2 = mysqli_fetch_array($result2)) {

	$jgdad = explode('*', $row2['Jugada']);

	for ($u = 0; $u <= count($jgdad) - 2; $u++) {
		$opcion = explode('|', $jgdad[$u]);
		$logro = $opcion[1];
		$opcion1 = explode('%', $opcion[0]);
		$carr = $opcion1[1];
		$opcion2 = explode('-', $opcion1[0]);
		$equi = $opcion2[0];
		$iddd = $opcion2[1];  //60-9%-6|-120
		if ($equi == 60 || $equi == 56) :
			if ($iddd == 9) :
				echo $row2['serial'] . '-' . $row2['hora'] . ' Equipo:' . $equi . ' Carrera:' . $carr . '<br>';
				break;
			endif;
		endif;
	}
}
