<?php
require('prc_php.php');
$serial = 1625;
$GLOBALS['link'] = mysqli_connect("localhost", "sphonlin_root", "intra");
mysql_select_db("sphonlin_sphonline", $GLOBALS['link']);
$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb  where serial=" . $serial,  $GLOBALS['link']);
$row4 = mysqli_fetch_array($result);

$result7 = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb  where IDJ=" . $row4['IDJ'],  $GLOBALS['link']);
$row7 = mysqli_fetch_array($result7);

$jud = $row4['Jugada'];
$jgdad = explode('*', $jud);
$Lineaticket = array();
$Lineaticket[0] = $row4['hora'] . '|' . $row7['Fecha'] . '|' . $row4['ap'] . '|' . $row4['acobrar'] . '|' . $row4['se'];

for ($u = 0; $u <= count($jgdad) - 2; $u++) {

	$opcion = explode('|', $jgdad[$u]);

	if ($row4['Grupo'] == 2) :
		$logro = $opcion[1];
		$opcion1 = explode('%', $opcion[0]);
		$carr = $opcion1[1];
		$opcion2 = explode('-', $opcion1[0]);
		$equi = $opcion2[0];
		$iddd = $opcion2[1];
	endif;

	if ($row4['Grupo'] == 1) :
		$opcion2 = explode(' ', $opcion[1]);
		$opcionv = $opcion2[0];
		$logro = $opcion2[1];
		$opcion2 = explode('-', $opcion[0]);
		$part = $opcion2[0];
		$iddd = $opcion2[1];
	endif;


	if ($row4['Grupo'] == 2) :
		$result1 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $equi, $GLOBALS['link']);
		$row1 = mysqli_fetch_array($result1);
		$result2 = mysqli_query($GLOBALS['link'], "Select * From _partidosbb Where (IDE1=" . $equi . " or IDE2=" . $equi . ") and IDJ=" . $row4['IDJ'], $GLOBALS['link']);
		$row2 = mysqli_fetch_array($result2);
		$result3 = mysqli_query($GLOBALS['link'], "Select * From _tbjuegodd Where IDDD=" . $iddd, $GLOBALS['link']);
		$row3 = mysqli_fetch_array($result3);
		if ($row2['IDE1'] == $equi) :
			$y = 0;
		endif;
		if ($row2['IDE2'] == $equi) :
			$y = 1;
		endif;
		$cln = explode('|', $row3['AddTicket']);
		if (count($cln) == 1) :
			$valoaad = '';
		else :
			$valoaad = $cln[$y];
		endif;

		$Lineaticket[$u + 1] = $u . '|' . convertirhora($row2['Hora']) . '|' . $row1['Descripcion'] . ' ' . convertir($carr) . ' ' . $valoaad . '|' . convertir($logro);


	endif;

	if ($row4['Grupo'] == 1) :
		$result2 = mysqli_query($GLOBALS['link'], "Select * From _partidosbb Where IDP=" . $equi . " and IDJ=" . $row4['IDJ'], $GLOBALS['link']);
		$row2 = mysqli_fetch_array($result2);

	endif;
}
//echo json_encode($Lineaticket);
print_r($Lineaticket);
