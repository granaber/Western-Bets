<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$d1 = $_REQUEST['d1'];
$d2 = $_REQUEST['d2'];
$clsi = $_REQUEST['clsi'];
$gp = $_REQUEST['gp'];
$ttex2 = '';



$add = '';




$add = "and  IDJ In (Select IDJ From _jornadabb Where STR_TO_DATE(Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('" . $d1 . "','%d/%m/%Y') and STR_TO_DATE('" . $d2 . "','%d/%m/%Y')) ";




$ttex = " Desde : " . $d1 . " Hasta: " . $d2;





$xpp = 170;



$add1 = '';






$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario " . $add1 . " Order By IDC");
while ($row = mysqli_fetch_array($result)) {
	$totalgventas = 0;
	$totalgpremios = 0;
	$totalgporce = 0;
	$totalgtotal = 0;
	$totalgventaprocen = 0;
	$totalgpremioprocen = 0;
	$totalgdiferencia = 0;
	$totalgparticipacion = 0;
	$totalgparticipacion1 = 0;
	$totalventas1 = 0;
	$totalpremio1 = 0;
	$primerdia = 0;
	$seccion = 1;
	$dpm = true;

	$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tjugadabb  where IDC='" . $row['IDC'] . "'    and activo=1 " . $add . " Order By IDJ");
	// echo ("SELECT *  FROM _tjugadabb  where IDC='".$row['IDC']."'    and activo=1 ".$add." Order By IDJ" );
	/* if(mysqli_num_rows($result2)==0):
	     $result2 = mysqli_query($GLOBALS['link'],"SELECT *  FROM _tjugadabbbk  where IDC='".$row['IDC']."'    and activo=1 ".$add." Order By IDJ" );
	   endif;*/

	while ($row2 = mysqli_fetch_array($result2)) {
		if ($primerdia != $row2['IDJ']) :
			if ($primerdia != 0) :
				if ($dpm) :
					$aa[0] = $row['IDC'];
					$aa[1] = $row['Nombre'];
					$dpm = false;
				else :
					$aa[0] = '';
					$aa[1] = '';
				endif;

				$resultdf = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tconsecionariodd  where IDC='" . $row['IDC'] . "'");

				if (mysqli_num_rows($resultdf) != 0) :

					$row3 = mysqli_fetch_array($resultdf);

					$pdp = $row3['Participacion1'];
					$pdp1 = $row3['Participacion2'];

					if ($row3['tipodev'] == 1) :
						$pdv = $row3['pVentas'];
						$pdv1 = $row3['pVentaspd'];
						$pdv2 = $row3['pVentasEB'];
					else :
						$pdv = -3;
						$pdv1 = -3;
						$pdv2 = -3;
						$mm = asignacion($totalventas, $row['IDC']);
						$mm1 = asignacion($totalventas1, $row['IDC']);
						$mm2 = asignacion($totalventas2, $row['IDC']);
					endif;
				else :

					$pdp = 0;
					$pdv = 0;
					$pdp1 = 0;

				endif;

				$resultdf = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where IDJ=" . $primerdia);



				if (mysqli_num_rows($resultdf) != 0) :

					$row3 = mysqli_fetch_array($resultdf);

					$fch = $row3['Fecha'];

				else :

					$fch = '';

				endif;

				/*Jugada Por Derecho*/
				$aa[2] = fecha_dia($fch) . ' ' . $fch;

				$aa[3] = number_format($totalventas1, 2, '.', '');

				$aa[4] = number_format($totalpremio1, 2, '.', '');
				if ($pdv1 == -3) :
					$aa[5] = number_format($mm1, 2, '.', '');
				else :
					$aa[5] = number_format(($totalventas1 * $pdv1) / 100, 2, '.', '');
				endif;


				$resultres = mysqli_query($GLOBALS['link'], "SELECT * FROM totales where IDJ=" . $primerdia . " and IDC='" . $aa[0] . "'  and tipodejugada=1");
				if (mysqli_num_rows($resultres) == 0) :
					$resultres = mysqli_query($GLOBALS['link'], "INSERT INTO  totales values(" . $primerdia . ",'" . $aa[0] . "'," . $totalventas1 . "," . $aa[5] . "," . $totalpremio1 . ",1)");
				else :
					$resultres = mysqli_query($GLOBALS['link'], "update  totales set ventas=" . $totalventas1 . ",porcentaje=" . $aa[5] . ",premios=" . $totalpremio1 . " where IDJ=" . $primerdia . " and IDC='" . $aa[0] . "' and tipodejugada=1");
				endif;


				/*Jugada Parlay*/


				$aa[3] = number_format($totalventas, 2, '.', '');

				$aa[4] = number_format($totalpremio, 2, '.', '');

				if ($pdv == -3) :
					$aa[5] = number_format($mm, 2, '.', '');
				else :
					$aa[5] = number_format(($totalventas * $pdv) / 100, 2, '.', '');
				endif;


				$resultres = mysqli_query($GLOBALS['link'], "SELECT * FROM totales where IDJ=" . $primerdia . " and IDC='" . $aa[0] . "'  and tipodejugada=2 ");
				//echo ("SELECT * FROM totales where IDJ=".$primerdia." and IDC='".$aa[0]."'  and tipodejugada=2 "); 
				if (mysqli_num_rows($resultres) == 0) :
					$resultres = mysqli_query($GLOBALS['link'], "INSERT INTO  totales values(" . $primerdia . ",'" . $aa[0] . "'," . $totalventas . "," . $aa[5] . "," . $totalpremio . ",2)");
				else :
					$resultres = mysqli_query($GLOBALS['link'], "update  totales set ventas=" . $totalventas . ",porcentaje=" . $aa[5] . ",premios=" . $totalpremio . " where IDJ=" . $primerdia . " and IDC='" . $aa[0] . "' and tipodejugada=2");
				endif;


				/*Jugada Extra base */
				$aa[3] = number_format($totalventas2, 2, '.', '');

				$aa[4] = number_format($totalpremio2, 2, '.', '');

				if ($pdv == -3) :
					$aa[5] = number_format($mm2, 2, '.', '');
				else :
					$aa[5] = number_format(($totalventas2 * $pdv2) / 100, 2, '.', '');
				endif;

				$resultres = mysqli_query($GLOBALS['link'], "SELECT * FROM totales where IDJ=" . $primerdia . " and IDC='" . $aa[0] . "'  and tipodejugada=3");
				if (mysqli_num_rows($resultres) == 0) :
					$resultres = mysqli_query($GLOBALS['link'], "INSERT INTO  totales values(" . $primerdia . ",'" . $aa[0] . "'," . $totalventas2 . "," . $aa[5] . "," . $totalpremio2 . ",3)");
				else :
					$resultres = mysqli_query($GLOBALS['link'], "update  totales set ventas=" . $totalventas2 . ",porcentaje=" . $aa[5] . ",premios=" . $totalpremio2 . " where IDJ=" . $primerdia . " and IDC='" . $aa[0] . "' and tipodejugada=3");
				endif;
				echo $aa[0] . '<br>';
			endif;
			$primerdia = $row2['IDJ'];
			$totalventas = 0;
			$totalpremio = 0;
			$totalventas1 = 0;
			$totalpremio1 = 0;
			$totalventas2 = 0;
			$totalpremio2 = 0;
		endif;

		if ($row2['opcion'] == 'i') :
			$verderecho = explode('*', $row2['Jugada']);
			if (count($verderecho) == 2) :
				$totalventas1 += $row2['ap'];
				$cod = mescrute($row2['serial']);
				if ($cod['condicion'] == true) :
					$totalpremio1 += $cod['acobrar'];
				endif;
			else :
				$totalventas += $row2['ap'];
				$cod = mescrute($row2['serial']);
				if ($cod['condicion'] == true) :
					$totalpremio += $cod['acobrar'];
				endif;
			endif;
		else :
			$totalventas2 += $row2['ap'];
			$cod = mescrute($row2['serial']);
			if ($cod['condicion'] == true) :
				$totalpremio2 += $cod['acobrar'];
			endif;
		endif;
	}

	if ($primerdia != 0) :
		if ($dpm) :
			$aa[0] = $row['IDC'];
			$aa[1] = $row['Nombre'];
			$dpm = false;
		else :
			$aa[0] = '';
			$aa[1] = '';
		endif;



		$resultdf = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tconsecionariodd  where IDC='" . $row['IDC'] . "'");

		if (mysqli_num_rows($resultdf) != 0) :

			$row3 = mysqli_fetch_array($resultdf);

			$pdp = $row3['Participacion1'];
			$pdp1 = $row3['Participacion2'];

			if ($row3['tipodev'] == 1) :
				$pdv = $row3['pVentas'];
				$pdv1 = $row3['pVentaspd'];
				$pdv2 = $row2['pVentaspd'];
			else :
				$pdv = -3;
				$pdv1 = -3;
				$pdv2 = -3;
				$mm = asignacion($totalventas, $row['IDC']);
				$mm1 = asignacion($totalventas1, $row['IDC']);
				$mm2 = asignacion($totalventas2, $row['IDC']);
			endif;



		else :

			$pdp = 0;
			$pdv = 0;
			$pdp1 = 0;

		endif;

		$resultdf = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where IDJ=" . $primerdia);



		if (mysqli_num_rows($resultdf) != 0) :

			$row3 = mysqli_fetch_array($resultdf);

			$fch = $row3['Fecha'];

		else :

			$fch = '';

		endif;



		/*por derecho*/
		$aa[2] = fecha_dia($fch) . ' ' . $fch;

		$aa[3] = number_format($totalventas1, 2, '.', '');

		$aa[4] = number_format($totalpremio1, 2, '.', '');

		$aa[5] = number_format(($totalventas1 * $pdv1) / 100, 2, '.', '');

		if ($pdv1 == -3) :
			$aa[5] = number_format($mm1, 2, '.', '');
		else :
			$aa[5] = number_format(($totalventas1 * $pdv1) / 100, 2, '.', '');
		endif;

		$resultres = mysqli_query($GLOBALS['link'], "SELECT * FROM totales where IDJ=" . $primerdia . " and IDC='" . $aa[0] . "'  and tipodejugada=1");
		if (mysqli_num_rows($resultres) == 0) :
			$resultres = mysqli_query($GLOBALS['link'], "INSERT INTO  totales values(" . $primerdia . ",'" . $aa[0] . "'," . $totalventas1 . "," . $aa[5] . "," . $totalpremio1 . ",1)");
		else :
			$resultres = mysqli_query($GLOBALS['link'], "update  totales set ventas=" . $totalventas1 . ",porcentaje=" . $aa[5] . ",premios=" . $totalpremio1 . " where IDJ=" . $primerdia . " and IDC='" . $aa[0] . "' and tipodejugada=1");
		endif;


		/*parlay */


		$aa[3] = number_format($totalventas, 2, '.', '');

		$aa[4] = number_format($totalpremio, 2, '.', '');

		if ($pdv == -3) :
			$aa[5] = number_format($mm, 2, '.', '');
		else :
			$aa[5] = number_format(($totalventas * $pdv) / 100, 2, '.', '');
		endif;


		$resultres = mysqli_query($GLOBALS['link'], "SELECT * FROM totales where IDJ=" . $primerdia . " and IDC='" . $aa[0] . "'  and tipodejugada=2");
		if (mysqli_num_rows($resultres) == 0) :
			$resultres = mysqli_query($GLOBALS['link'], "INSERT INTO  totales values(" . $primerdia . ",'" . $aa[0] . "'," . $totalventas . "," . $aa[5] . "," . $totalpremio . ",2)");
		else :
			$resultres = mysqli_query($GLOBALS['link'], "update  totales set ventas=" . $totalventas . ",porcentaje=" . $aa[5] . ",premios=" . $totalpremio . " where IDJ=" . $primerdia . " and IDC='" . $aa[0] . "' and tipodejugada=2");
		endif;

		/*Jugada Extra base */
		$aa[3] = number_format($totalventas2, 2, '.', '');

		$aa[4] = number_format($totalpremio2, 2, '.', '');

		if ($pdv == -3) :
			$aa[5] = number_format($mm2, 2, '.', '');
		else :
			$aa[5] = number_format(($totalventas2 * $pdv2) / 100, 2, '.', '');
		endif;

		$resultres = mysqli_query($GLOBALS['link'], "SELECT * FROM totales where IDJ=" . $primerdia . " and IDC='" . $aa[0] . "'  and tipodejugada=3");
		if (mysqli_num_rows($resultres) == 0) :
			$resultres = mysqli_query($GLOBALS['link'], "INSERT INTO  totales values(" . $primerdia . ",'" . $aa[0] . "'," . $totalventas2 . "," . $aa[5] . "," . $totalpremio2 . ",3)");
		else :
			$resultres = mysqli_query($GLOBALS['link'], "update  totales set ventas=" . $totalventas2 . ",porcentaje=" . $aa[5] . ",premios=" . $totalpremio2 . " where IDJ=" . $primerdia . " and IDC='" . $aa[0] . "' and tipodejugada=3");
		endif;
		echo $aa[0] . '<br>';
	endif;
}
echo 'Listo....<br>';
