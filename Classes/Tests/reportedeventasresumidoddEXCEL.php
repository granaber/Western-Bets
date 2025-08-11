<?php
set_time_limit(1200);
require('prc_php.php');

$GLOBALS['link'] = Connection::getInstance();




require_once 'Classes/PHPExcel.php';










$d1 = $_REQUEST['d1'];

$d2 = $_REQUEST['d2'];

$clsi = $_REQUEST['clsi'];

$gp = $_REQUEST['gp'];

$ttex2 = '';







$add = '';


$ArrayCierre = array();
$TodosIDC = array();
$sihay = false;
$desdeIDC = 0;
$hastaIDC = 0;
//// Determin rango de Lectura de IDJ
echo 'Procesando...<br>';
$result = mysqli_query($GLOBALS['link'], "Select IDJ From _jornadabb Where STR_TO_DATE(Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('" . $d1 . "','%d/%m/%Y') and STR_TO_DATE('" . $d2 . "','%d/%m/%Y') Group by IDJ Order by IDJ");
if (mysqli_num_rows($result) != 0) :
	/*$row = mysqli_fetch_array($result);
$desdeIDC=$row['IDJ']; */ $sihay = true;
	$verdatos = '';
	$i = 1;
	while ($row = mysqli_fetch_array($result)) {
		if (!isset($ArrayCierre[$row['IDJ']])) :
			$resultOpen = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tbcierresemana  where IDJ=" . $row['IDJ']);
			if (mysqli_num_rows($resultOpen) != 0) :
				$rowOpen = mysqli_fetch_array($resultOpen);
				if ($rowOpen['Cierre'] == 1) :  $ArrayCierre[$row['IDJ']] = 1;
				endif;
			endif;
		endif;
		$TodosIDC[] = $row['IDJ'];
		/*$hastaIDC=$row['IDJ']; */
		$verdatos .= ' IDJ=' . $row['IDJ'];
		if ($i < mysqli_num_rows($result)) :
			$verdatos .= ' or ';
			$i++;
		endif;
	}
/*if ($hastaIDC==0): $hastaIDC=$desdeIDC; endif;*/
endif;

$add = " and (" . $verdatos . ") ";

if ($sihay) :
	//$add="and  (IDJ BETWEEN ".$desdeIDC." and ".$hastaIDC.") ";



	$ttex = " Desde : " . $d1 . " Hasta: " . $d2;





	$xpp = 170;



	$add1 = '';
	$Npasan = array();
	$Npasan1 = array();
	$np = 0;
	$header = array();
	$w = array();
	$w1 = array();
	$totalg1 = 0;
	$totalg2 = 0;
	$totalg3 = 0;
	$totalg4 = 0;
	$totalg5 = 0;
	$totalg6 = 0;


	switch ($clsi) {

		case 1:
			if ($gp != "0") :
				$add1 = " where IDC='" . $gp . "'";
				$ttex2 = 'Concesionarion : ' . $gp;
			endif;
			$order = ' IDC';
			$header[0] = 'Ltr';
			$w[0] = 20;
			$w1[0] = 'R';
			$header[1] = 'Empresa';
			$w[1] = 40;
			$w1[1] = 'L';
			break;



		case 2:

			if ($gp != 0) :
				$add1 = " where IDG=" . $gp;
				$ttex2 = 'Grupo: ' . $gp;
				$clsi = 1;
			endif;
			$order = ' IDG';
			$header[0] = 'Grupo';
			$w[0] = 15;
			$w1[0] = 'R';
			$header[1] = 'Nombre';
			$w[1] = 40;
			$w1[1] = 'L';
			break;
	}






	$header[2] = 'A';
	$w[2] = 5;
	$w1[2] = 'C';
	$header[3] = 'Ventas Bs.F.';
	$w[3] = 20;
	$w1[3] = 'R';
	$header[4] = '% Ventas';
	$w[4] = 15;
	$w1[4] = 'R';
	$header[5] = 'Premios Bs.F.';
	$w[5] = 20;
	$w1[5] = 'R';
	$header[6] = 'Diferencia';
	$w[6] = 20;
	$w1[6] = 'R';
	$header[7] = '% Banca';
	$w[7] = 15;
	$w1[7] = 'R';
	$header[8] = 'Res.Banca';
	$w[8] = 20;
	$w1[8] = 'R';
	if ($clsi == 2) :
		$header[9] = '% Inter.';
		$w[9] = 15;
		$w1[9] = 'R';
		$header[10] = 'Res.Inter.';
		$w[10] = 20;
		$w1[10] = 'R';
	else :
		$header[9] = '% P.V.';
		$w[9] = 15;
		$w1[9] = 'R';
		$header[10] = 'Res.P.V.';
		$w[10] = 20;
		$w1[10] = 'R';
	endif;

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("LosAngelesHK")
		->setLastModifiedBy("LosAngelesHK")
		->setTitle("Reporte Resumido de Ventas Deporte")
		->setSubject("Reporte Resumido de Ventas Deporte")
		->setDescription("Reporte Resumido de Ventas Deporte")
		->setKeywords("Reporte Resumido de Ventas Deporte")
		->setCategory("Reporte");



	$objPHPExcel->setActiveSheetIndex(0);
	$linea = 5;
	$UltimaC = '';
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Reporte Resumido de Ventas Deporte');
	$objPHPExcel->getActiveSheet()->setCellValue('A2', $ttex);
	$objPHPExcel->getActiveSheet()->setCellValue('A4', $ttex2);
	for ($i = 0; $i <= 10; $i++) {
		$celda = chr(65 + $i) . $linea;
		$UltimaC = $celda;
		$objPHPExcel->getActiveSheet()->setCellValue($celda, $header[$i]);
		$objPHPExcel->getActiveSheet()->getStyle($celda)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
		$objPHPExcel->getActiveSheet()->getStyle($celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle($celda)->getFill()->getStartColor()->setARGB('FF808080');
	}

	$linea++;


	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario " . $add1 . " Order By " . $order);
	$grupo = 0;
	$totalporcentajeGRUPO = 0;
	$totalParticipacionB = 0;
	$totalParticipacionI = 0;
	while ($row = mysqli_fetch_array($result)) {
		echo $row['IDC'] . '..ckeck<br>';
		$totalventas = 0;
		$totalpremio = 0;
		$totalventas1 = 0;
		$totalpremio1 = 0;
		if ($clsi == 2) :
			if ($grupo != $row['IDG']) :
				if ($grupo != 0) :
					$result_grp = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo where IDG=$grupo");
					$row_grp = mysqli_fetch_array($result_grp);
					$aa[0] = $grupo;
					$aa[1] = $row_grp['Descrip'];
					$aa[2] = 'D';
					$aa[3] = number_format($totalventasGD, 2, '.', '');
					$porcentajedeportegrupo1 = ($row_grp['porce_derecho'] * $totalventasGD) / 100;
					$aa[4] = number_format($porcentajedeportegrupo1, 2, '.', '');
					$aa[5] = number_format($totalpremioGD, 2, '.', '');
					$aa[6] = number_format(($totalventasGD - $porcentajedeportegrupo1) - $totalpremioGD, 2, '.', '');
					$aa[7] = number_format(0, 2, '.', '');
					$aa[8] = number_format(0, 2, '.', '');
					$aa[9] = number_format(0, 2, '.', '');
					$aa[10] = number_format(0, 2, '.', '');
					registroE($aa, $w, $w1, 0);
					$aa[0] = '';
					$aa[1] = '';
					$aa[2] = 'P';
					$aa[3] = number_format($totalventasGP, 2, '.', '');
					$porcentajedeportegrupo2 = ($row_grp['porce_parlay'] * $totalventasGP) / 100;
					$aa[4] = number_format($porcentajedeportegrupo2, 2, '.', '');
					$aa[5] = number_format($totalpremioGP, 2, '.', '');
					$aa[6] = number_format(($totalventasGP - $porcentajedeportegrupo2) - $totalpremioGP, 2, '.', '');
					$aa[7] = number_format(0, 2, '.', '');
					$aa[8] = number_format(0, 2, '.', '');
					$aa[9] = number_format(0, 2, '.', '');
					$aa[10] = number_format(0, 2, '.', '');
					registroE($aa, $w, $w1, 0);
					$aa[0] = '';
					$aa[1] = '';
					$aa[2] = 'T';
					$aa[3] = number_format($totalventasGP + $totalventasGD, 2, '.', '');
					$aa[4] = number_format($porcentajedeportegrupo2 + $porcentajedeportegrupo1, 2, '.', '');
					$aa[5] = number_format($totalpremioGP + $totalpremioGD, 2, '.', '');
					$diferencia1 = ($totalventasGD - $porcentajedeportegrupo1) - $totalpremioGD;
					$diferencia2 = ($totalventasGP - $porcentajedeportegrupo2) - $totalpremioGP;
					$aa[6] = number_format($diferencia1 + $diferencia2, 2, '.', '');
					$aa[7] = number_format(100 - $row_grp['Participacion'], 2, '.', '');
					$partiBanca = ((100 - $row_grp['Participacion']) * ($diferencia1 + $diferencia2)) / 100;
					$aa[8] = number_format($partiBanca, 2, '.', '');
					$aa[9] = number_format($row_grp['Participacion'], 2, '.', '');
					$aa[10] = number_format(($diferencia1 + $diferencia2) - $partiBanca, 2, '.', '');
					registroE($aa, $w, $w1, 1);
					$totalParticipacionB += $partiBanca;
					$totalParticipacionI += (($diferencia1 + $diferencia2) - $partiBanca);
					$totalporcentajeGRUPO += ($porcentajedeportegrupo2 + $porcentajedeportegrupo1);
				endif;
				$totalventasGD = 0;
				$totalpremioGD = 0;
				$totalporcentajeGD = 0;
				$totalventasGP = 0;
				$totalpremioGP = 0;
				$totalporcentajeGP = 0;
				$grupo = $row['IDG'];
			endif;
		endif;

		for ($t = 0; $t <= count($TodosIDC) - 1; $t++) {
			////////////////////////////////////////////////////////////////////////////////////////

			$aIDJ = $TodosIDC[$t];
			if (isset($ArrayCierre[$aIDJ])) :
				$Bpasa = true;
			else :
				$Bpasa = false;
			endif;
			if (!$Bpasa) :

				$result2 = mysqli_query($GLOBALS['link'], "SELECT escrute,serial,Jugada,ap,acobrar,IDJ  FROM _tjugadabb  where IDC='" . $row['IDC'] . "' and activo=1 and IDJ=" . $aIDJ);
				while ($row2 = mysqli_fetch_array($result2)) {

					if ($row2['escrute'] == '') :
						$cod = vescrute($row2['serial']);
					else :
						$cod = k1escrute(unserialize($row2['escrute']));
					endif;

					$verderecho = explode('*', $row2['Jugada']);
					if (count($verderecho) == 2) :
						$totalventas1 += $row2['ap'];
						if ($cod == true) :
							$totalpremio1 += $row2['acobrar'];
						endif;
					else :
						$totalventas += $row2['ap'];
						if ($cod == true) :
							$totalpremio += $row2['acobrar'];
						endif;
					endif;
				}

			else :
				// tipo=1 Derecho
				// tipo=2 Parlay
				// Premios Derecho
				$result2 = mysqli_query($GLOBALS['link'], "SELECT SUM( acobrar ) as X FROM _tjugadabb WHERE SERIAL IN (SELECT SERIAL FROM  `_tbticketescrute`  WHERE  `premiado` =1 and itipo=1) AND idj =" . $aIDJ . " and IDC='" . $row['IDC'] . "' and activo=1");
				$row2 = mysqli_fetch_array($result2);
				$totalpremio1 += $row2['X'];
				// Premios Parlay
				$result2 = mysqli_query($GLOBALS['link'], "SELECT SUM( acobrar ) as X  FROM _tjugadabb WHERE SERIAL IN (SELECT SERIAL FROM  `_tbticketescrute`  WHERE  `premiado` =1 and itipo=2) AND idj =" . $aIDJ . " and IDC='" . $row['IDC'] . "' and activo=1");
				$row2 = mysqli_fetch_array($result2);
				$totalpremio += $row2['X'];
				// Ventas Derecho
				$result2 = mysqli_query($GLOBALS['link'], "SELECT sum(ap) as Y  FROM _tjugadabb WHERE SERIAL IN (SELECT SERIAL FROM  `_tbticketescrute`  WHERE   itipo=1) AND idj =" . $aIDJ . " and IDC='" . $row['IDC'] . "' and activo=1");
				$row2 = mysqli_fetch_array($result2);
				$totalventas1 += $row2['Y'];
				// Ventas Parlay
				$result2 = mysqli_query($GLOBALS['link'], "SELECT sum(ap) as Y  FROM _tjugadabb WHERE SERIAL IN (SELECT SERIAL FROM  `_tbticketescrute`  WHERE   itipo=2) AND idj =" . $aIDJ . " and IDC='" . $row['IDC'] . "' and activo=1");
				$row2 = mysqli_fetch_array($result2);
				$totalventas += $row2['Y'];

			endif;


			////////////////////////////////////////////////////////////////////////////////////////



		}
		//print_r($ArrayCierre);
		//exit;

		if (($totalventas1 + $totalventas) != 0) :

			$resultdf = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tconsecionariodd  where IDC='" . $row['IDC'] . "'");

			if (mysqli_num_rows($resultdf) != 0) :
				$row3 = mysqli_fetch_array($resultdf);
				$pdp = $row3['Participacion1'];
				$pdv = $row3['pVentas'];
				$pdp1 = $row3['Participacion2'];
				if ($row3['tipodev'] == 1) :
					$pdv = $row3['pVentas'];
					$pdv1 = $row3['pVentaspd'];
				else :
					$pdv = -3;
					if ($row3['porcentajextablad'] == 0) :
						$pdv1 = -3;
					else :
						$pdv1 = $row3['porcentajextablad'];
					endif;
				endif;
			else :
				$pdp = 0;
				$pdp1 = 0;
				$pdv1 = 0;
				$pdv = 0;
			endif;

			if ($pdv == -3) :
				$totalgporce = asignacion($totalventas, $row['IDC']);
			else :
				$totalgporce = ($totalventas * $pdv) / 100;
			endif;
			if ($pdv1 == -3) :
				$totalgporce1 = 0;
			else :
				$totalgporce1 = ($totalventas1 * $pdv1) / 100;
			endif;

			switch ($clsi) {
				case 1:
					$aa[0] = $row['IDC'];
					$aa[1] = $row['Nombre'];
					$aa[2] = 'D';
					$aa[3] = number_format($totalventas1, 2, '.', '');

					if ($pdv1 == -3) :
						$aa[4] = number_format(0, 2, '.', '');
					else :
						$aa[4] = number_format(0, 2, '.', '');
					endif;

					$aa[5] = number_format($totalpremio1, 2, '.', '');
					$aa[6] = number_format(($totalventas1 - $aa[4]) - $totalpremio1, 2, '.', '');
					if ((($totalventas1 - $aa[4]) - $totalpremio1) < 0) :
						$pr = $pdp1;
					else :
						$pr = $pdp;
					endif;
					$aa[7] = number_format((100 - $pr), 2, '.', '');
					$aa[8] = number_format(($aa[6] * $aa[7]) / 100, 2, '.', '');
					$aa[9] = number_format($pr, 2, '.', '');
					$aa[10] = number_format($aa[6] - $aa[8], 2, '.', '');
					$total3 = $aa[3];
					$total4 = $aa[4];
					$total5 = $aa[5];
					$total6 = $aa[6];
					$total7 = $aa[7];
					$total8 = $aa[8];
					$total9 = $aa[9];
					$total10 = $aa[10];
					$aa[6] = $aa[6] . '**';
					if ($totalventas1 != 0 || $totalventas != 0) :
						registroE($aa, $w, $w1, 0);
					endif;
					$aa[0] = '';
					$aa[1] = '';
					$aa[2] = 'P';
					$aa[3] = number_format($totalventas, 2, '.', '');
					if ($pdv == -3) :
						$aa[4] = number_format(0, 2, '.', '');
					else :
						$aa[4] = number_format(0, 2, '.', '');
					endif;
					$aa[5] = number_format($totalpremio, 2, '.', '');
					$aa[6] = number_format(($totalventas - $aa[4]) - $totalpremio, 2, '.', '');
					if ((($totalventas - $aa[4]) - $totalpremio) < 0) :
						$pr = $pdp1;
					else :
						$pr = $pdp;
					endif;
					$aa[7] = number_format((100 - $pr), 2, '.', '');
					$aa[8] = number_format(($aa[6] * $aa[7]) / 100, 2, '.', '');
					$aa[9] = number_format($pr, 2, '.', '');
					$aa[10] = number_format($aa[6] - $aa[8], 2, '.', '');
					$total3 += $aa[3];
					$total4 += $aa[4];
					$total5 += $aa[5];
					$total6 += $aa[6];
					$total7 += $aa[7];
					$total8 += $aa[8];
					$total9 += $aa[9];
					$total10 += $aa[10];

					$aa[6] = $aa[6] . '**';
					if ($totalventas1 != 0 || $totalventas != 0) :
						registroE($aa, $w, $w1, 0);
					endif;

					$aa[0] = '';
					$aa[1] = '';
					$aa[2] = 'T';
					$aa[3] = number_format($total3, 2, '.', '');
					$aa[4] = number_format($totalgporce + $totalgporce1, 2, '.', ''); //Porcentaje
					$totaldiferencia = $total3  -  (($totalgporce1 + $totalgporce) + $total5);
					$aa[5] = number_format($total5, 2, '.', '');
					$aa[6] = number_format($totaldiferencia, 2, '.', '');
					$aa[7] = '';
					if ($totaldiferencia < 0) :
						$aa[8] = number_format(($totaldiferencia * (100 - $pdp1)) / 100, 2, '.', '');
						$aa[9] = '';
						$aa[10] = number_format(($totaldiferencia * $pdp1) / 100, 2, '.', '');
					else :
						$aa[8] = number_format(($totaldiferencia * (100 - $pdp)) / 100, 2, '.', '');
						$aa[9] = '';
						$aa[10] = number_format(($totaldiferencia * $pdp) / 100, 2, '.', '');
					endif;
					if ($totalventas1 != 0 || $totalventas != 0) :
						registroE($aa, $w, $w1, 1);
					endif;
					$totalg1 += $aa[3];
					$totalg2 += $aa[4];
					$totalg3 += $aa[5];
					$totalg4 += $aa[6];
					$totalg5 += $aa[8];
					$totalg6 += $aa[10];
					break;
				case 2:
					$totalventasGD += $totalventas1;
					$totalpremioGD += $totalpremio1;
					$totalporcentajeGD += $totalgporce1;

					$totalventasGP += $totalventas;
					$totalpremioGP += $totalpremio;
					$totalporcentajeGP += $totalgporce;


					$diferencia1 = ($totalventas1 - $totalpremio1) - $totalgporce1;
					$diferencia2 = ($totalventas - $totalpremio) - $totalgporce;


					$totalg1 += $totalventas1 + $totalventas;
					$totalg2 += $totalgporce1 + $totalgporce;
					$totalg3 += $totalpremio1 + $totalpremio;
					$totalg4 += $diferencia1 + $diferencia2;
					$totalg5 += 0;
					$totalg6 += 0;
					break;
				case 3:
					break;
			}
		else :
			$Npasan[$np] = $row['IDC'];
			$Npasan1[$np] = $row['Nombre'];
			$np++;

		endif;
	}

	if ($clsi == 2) :
		$result_grp = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo where IDG=$grupo");
		$row_grp = mysqli_fetch_array($result_grp);
		$aa[0] = $grupo;
		$aa[1] = $row_grp['Descrip'];
		$aa[2] = 'D';
		$aa[3] = number_format($totalventasGD, 2, '.', '');
		$porcentajedeportegrupo1 = ($row_grp['porce_derecho'] * $totalventasGD) / 100;
		$aa[4] = number_format($porcentajedeportegrupo1, 2, '.', '');
		$aa[5] = number_format($totalpremioGD, 2, '.', '');
		$aa[6] = number_format(($totalventasGD - $porcentajedeportegrupo1) - $totalpremioGD, 2, '.', '');
		$aa[7] = number_format(0, 2, '.', '');
		$aa[8] = number_format(0, 2, '.', '');
		$aa[9] = number_format(0, 2, '.', '');
		$aa[10] = number_format(0, 2, '.', '');
		registroE($aa, $w, $w1, 0);
		$aa[0] = '';
		$aa[1] = '';
		$aa[2] = 'P';
		$aa[3] = number_format($totalventasGP, 2, '.', '');
		$porcentajedeportegrupo2 = ($row_grp['porce_parlay'] * $totalventasGP) / 100;
		$aa[4] = number_format($porcentajedeportegrupo2, 2, '.', '');
		$aa[5] = number_format($totalpremioGP, 2, '.', '');
		$aa[6] = number_format(($totalventasGP - $porcentajedeportegrupo2) - $totalpremioGP, 2, '.', '');
		$aa[7] = number_format(0, 2, '.', '');
		$aa[8] = number_format(0, 2, '.', '');
		$aa[9] = number_format(0, 2, '.', '');
		$aa[10] = number_format(0, 2, '.', '');
		registroE($aa, $w, $w1, 0);
		$aa[0] = '';
		$aa[1] = '';
		$aa[2] = 'T';
		$aa[3] = number_format($totalventasGP + $totalventasGD, 2, '.', '');
		$aa[4] = number_format($porcentajedeportegrupo2 + $porcentajedeportegrupo1, 2, '.', '');
		$aa[5] = number_format($totalpremioGP + $totalpremioGD, 2, '.', '');
		$diferencia1 = ($totalventasGD - $porcentajedeportegrupo1) - $totalpremioGD;
		$diferencia2 = ($totalventasGP - $porcentajedeportegrupo2) - $totalpremioGP;
		$aa[6] = number_format($diferencia1 + $diferencia2, 2, '.', '');
		$aa[7] = number_format(100 - $row_grp['Participacion'], 2, '.', '');
		$partiBanca = ((100 - $row_grp['Participacion']) * ($diferencia1 + $diferencia2)) / 100;
		$aa[8] = number_format($partiBanca, 2, '.', '');
		$aa[9] = number_format($row_grp['Participacion'], 2, '.', '');
		$aa[10] = number_format(($diferencia1 + $diferencia2) - $partiBanca, 2, '.', '');
		$totalParticipacionB += $partiBanca;
		$totalParticipacionI += (($diferencia1 + $diferencia2) - $partiBanca);
		$totalporcentajeGRUPO += ($porcentajedeportegrupo2 + $porcentajedeportegrupo1);
		registroE($aa, $w, $w1, 1);
	endif;
	$linea++;

	if ($clsi == 2) :
		$aa[0] = '';
		$aa[1] = 'TOTAL GENERAL:';
		$aa[2] = 'TG';
		$aa[3] = number_format($totalg1, 2, '.', '');
		$aa[4] = number_format($totalporcentajeGRUPO, 2, '.', '');
		$aa[5] = number_format($totalg3, 2, '.', '');
		$aa[6] = number_format($totalg1 - $totalporcentajeGRUPO - $totalg3, 2, '.', '');
		$aa[7] = '';
		$aa[8] = number_format($totalParticipacionB, 2, '.', '');
		$aa[9] = '';
		$aa[10] = number_format($totalParticipacionI, 2, '.', '');
		registroE($aa, $w, $w1, 1);
		$UltimaCt = $UltimaC;
	else :
		$aa[0] = '';
		$aa[1] = 'TOTAL GENERAL:';
		$aa[2] = 'TG';
		$aa[3] = number_format($totalg1, 2, '.', '');
		$aa[4] = number_format($totalg2, 2, '.', '');
		$aa[5] = number_format($totalg3, 2, '.', '');
		$aa[6] = number_format($totalg4, 2, '.', '');
		$aa[7] = '';
		$aa[8] = number_format($totalg5, 2, '.', '');
		$aa[9] = '';
		$aa[10] = number_format($totalg6, 2, '.', '');
		registroE($aa, $w, $w1, 1);
		$UltimaCt = $UltimaC;
	endif;

	$linea += 5;

	if ($clsi == 1) :
		for ($k = 0; $k <= $np - 1; $k++) {
			$aa[0] = $Npasan[$k];
			$aa[1] = $Npasan1[$k];
			for ($p = 2; $p <= 10; $p++) $aa[$p] = 'S/I';
			$aa[11] = '';
			registroE($aa, $w, $w1, 1);
		}
	endif;

	// AUTO 
	for ($i = 0; $i <= 10; $i++) {
		$celda = chr(65 + $i);
		$objPHPExcel->getActiveSheet()->getColumnDimension($celda)->setAutoSize(true);
	}
	// BORDES
	$styleThinBlackBorderOutline = array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('argb' => 'FF000000'),
			),
		),
	);
	$objPHPExcel->getActiveSheet()->getStyle('A5:' . $UltimaCt)->applyFromArray($styleThinBlackBorderOutline);

	$objPHPExcel->setActiveSheetIndex(0);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save(str_replace('.php', '.xls', __FILE__));

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="ReporteDeVentasResumido.xls"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
/*$pdf->Ln(5);
$pdf->SetFont('Arial','B',6); 
$pdf->Cell(1,1,' **El Porcentaje no esta incluido en la Diferencia, solamente se toma en cuenta en el Total Subtotal y Total General',1,0,"L");
$pdf->Ln(3);
if( $clsi==2 ):
	$pdf->Cell(1,1, ' D = Jugada por Derecho, P = Jugada Parlay, T=Total de Intermediario, TG=Total General del Reporte',1,0,"L");
else:
	$pdf->Cell(1,1, ' D = Jugada por Derecho, P = Jugada Parlay, T=Total de Punto de Venta, TG=Total General del Reporte',1,0,"L");
endif;
$pdf->SetFont('Arial','B',4);
$pdf->Ln(8);
$pdf->Cell(1,1,date("d-m-y")." ".date("g:i a"),1,0,"L");

$pdf->Output(); */

else :

	echo "No Hay Informacion...";

endif;

function registroE($varlo, $w, $w1, $fill)
{
	global $linea;
	global $objPHPExcel;
	global $UltimaC;

	for ($i = 0; $i <= 10; $i++) {
		$celda = chr(65 + $i) . $linea;
		$UltimaC = $celda;
		$objPHPExcel->getActiveSheet()->setCellValue($celda, $varlo[$i]);
		switch ($w1[$i]) {

			case 'C':
				$alineacion = 'HORIZONTAL_CENTER';
				$objPHPExcel->getActiveSheet()->getStyle($celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				break;
			case 'L':
				$alineacion = 'HORIZONTAL_LEFT';
				$objPHPExcel->getActiveSheet()->getStyle($celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				break;
			case 'R':
				$alineacion = 'HORIZONTAL_RIGHT';
				$objPHPExcel->getActiveSheet()->getStyle($celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				break;
		}

		if ($fill == 1) :
			$objPHPExcel->getActiveSheet()->getStyle($celda)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
			$objPHPExcel->getActiveSheet()->getStyle($celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objPHPExcel->getActiveSheet()->getStyle($celda)->getFill()->getStartColor()->setARGB('FF808080');
		endif;
	}
	$linea++;/*
$this->SetFont('Arial','B',7);

$this->Setx(1);

$this->SetFillColor(205, 205 ,205);

    for($i=0;$i<count($varlo);$i++){
		$this->Cell($w[$i],4,$varlo[$i],1,0,$w1[$i],$fill);   
    }

	  $this->Ln();*/
}
