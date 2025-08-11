<?php
require('prc_php.php');
require_once 'function_parameters_for_api.php';

$GLOBALS['link'] = Connection::getInstance();
$d1 = $_REQUEST['d1'];
$d2 = $_REQUEST['d2'];


$rndusr = $_COOKIE['rndusr'];
$data = getParamUser($rndusr, $GLOBALS['link']);

if ($data["IDusu"] == -1) {
	echo " Acceso  no  permitido";
	exit;
}

$gp = $data['IDC'];
$ttex2 = '';
$add = '';

if (true) :

	$desdeIDC = 0;
	$hastaIDC = 0;
	//// Determin rango de Lectura de IDJ

	$result = mysqli_query($GLOBALS['link'], "Select IDJ From _jornadabb Where STR_TO_DATE(Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('" . $d1 . "','%d/%m/%Y') and STR_TO_DATE('" . $d2 . "','%d/%m/%Y') Group by IDJ Order by IDJ");

	if (mysqli_num_rows($result) != 0) :
		/*$row = mysqli_fetch_array($result);
	$desdeIDC=$row['IDJ']; */
		$sihay = true;
		$verdatos = '';
		$i = 1;
		while ($row = mysqli_fetch_array($result)) {
			/*$hastaIDC=$row['IDJ']; */
			$verdatos .= ' IDJ=' . $row['IDJ'];
			if ($i < mysqli_num_rows($result)) :
				$verdatos .= ' or ';
				$i++;
			endif;
		}
	/*if ($hastaIDC==0): $hastaIDC=$desdeIDC; endif;*/
	endif;
	$add = "and  (" . $verdatos . " ) ";
	$textDesde = "Desde: $d1";
	$textHasta = "Hasta: $d2";

	$add1 = " where IDC='" . $gp . "'";
	$ttex2 = 'Cliente : ' . $gp;






	echo '<section id="report-contable-client" style="margin-top:10px">';
	echo '<samp><table  border="0">';
	// echo '  <tr>';
	// echo '   <th colspan="2" scope="col">Reporte Contable</th>';
	// echo '  </tr>';
	echo '  <tr>';
	echo '   <th colspan="2" scope="col">' . $textDesde . '</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th colspan="2" scope="col">' . $textHasta . '</th>';
	echo '  </tr>';

	echo '  <tr>';
	echo '   <th colspan="2" scope="col">' . $ttex2 . '</th>';
	echo '  </tr>';

	echo '  <tr>';

	echo '   <th colspan="2" scope="col">--------- Parlay --------</th>';

	echo '  </tr>';


	$resultdf = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tconsecionariodd  where IDC='" . $gp . "'");

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



	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario " . $add1 . " Order By IDC");


	$tv = 0;
	$tv1 = 0;
	$totalgventas = 0;
	$totalgpremios = 0;
	$totalgpremios1 = 0;

	$pagados = 0;

	while ($row = mysqli_fetch_array($result)) {






		$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tjugadabb  where IDC='" . $row['IDC'] . "'    and activo=1 " . $add . " Order By IDJ");

		while ($row2 = mysqli_fetch_array($result2)) {

			////////////////////////////////////////////////////////////////////////////////////////
			$resultOpen = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tbcierresemana  where IDJ=" . $row2['IDJ']);
			if (mysqli_num_rows($resultOpen) != 0) :
				$rowOpen = mysqli_fetch_array($resultOpen);
				if ($rowOpen['Cierre'] == 1) :
					if ($row2['escrute'] == '') :
						$cod = mescrute($row2['serial']);
					else :
						$cod = kescrute(unserialize($row2['escrute']), $row2['acobrar']);
					endif;
				else :
					$cod = mescrute($row2['serial']);
				endif;
			else :
				$cod =  mescrute($row2['serial']);
			endif;
			////////////////////////////////////////////////////////////////////////////////////////
			$Tac = 0;
			$verderecho = explode('*', $row2['Jugada']);
			$tv1 += $row2['ap'];
			if (isset($cod['condicion'])) :
				if ($cod['condicion'] == true) :
					$totalgpremios1 += $cod['acobrar'];
					// if ($row2['pagado'] == 1) {
					$pagados += $cod['acobrar'];
				// }
				endif;
			endif;
		}
		$totalgventas = ($tv + $tv1);
	}

	echo '  <tr>';
	echo '   <th scope="col">Total Tickets:' . $data['moneda'] .  number_format($totalgventas, 2, '.', ''), '</th>';
	// echo '   <th scope="col"><div align="right">' . . '</div></th>';
	echo '  </tr>';

	echo '  <tr>';
	echo '   <th scope="col">Total Premios:' . $data['moneda'] . number_format($totalgpremios + $totalgpremios1, 2, '.', '') . '</th>';
	// echo '   <th scope="col"><div align="right">' .  . '</div></th>';
	echo '  </tr>';

	echo '  <tr>';
	echo '   <th scope="col">Premios Pagados:' . $data['moneda'] .  number_format($pagados, 2, '.', '') . '</th>';
	// echo '   <th scope="col"><div align="right">' .  . '</div></th>';
	echo '  </tr>';

	echo '  <tr>';
	echo '   <th colspan="2" scope="col"></br></th>';
	echo '  </tr>';

	require_once 'animalitos/api_report_animalito.php';

	$data_animalitos = get_data_animalitos($d1, $d2, $gp);

	$totalgventasAnimalitos = $data_animalitos['ventas'];
	$totalgpremiosAnimalitos = $data_animalitos['premios'];

	echo '  <tr>';

	echo '   <th colspan="2" scope="col">--------- Animalitos --------</th>';

	echo '  </tr>';

	echo '  <tr>';
	echo '   <th scope="col">Total Tickets:' . $data['moneda'] .  number_format($totalgventasAnimalitos, 2, '.', ''), '</th>';
	// echo '   <th scope="col"><div align="right">' . . '</div></th>';
	echo '  </tr>';

	echo '  <tr>';
	echo '   <th scope="col">Total Premios:' . $data['moneda'] . number_format($totalgpremiosAnimalitos, 2, '.', '') . '</th>';
	// echo '   <th scope="col"><div align="right">' .  . '</div></th>';
	echo '  </tr>';

	echo '  <tr>';
	echo '   <th colspan="2" scope="col"></br></th>';
	echo '  </tr>';

	$data_americanas  = fetchAmericana($d1, $d2, $gp);
	$totalgventasAmericanas = $data_americanas['totalventas'] ?? 0;
	$totalgpremiosAmericanas = $data_americanas['totalpremio'] ?? 0;

	echo '   <th colspan="2" scope="col">--------- Americanas --------</th>';

	echo '  </tr>';

	echo '  <tr>';
	echo '   <th scope="col">Total Tickets:' . $data['moneda'] .  number_format($totalgventasAmericanas, 2, '.', ''), '</th>';
	// echo '   <th scope="col"><div align="right">' . . '</div></th>';
	echo '  </tr>';

	echo '  <tr>';
	echo '   <th scope="col">Total Premios:' . $data['moneda'] . number_format($totalgpremiosAmericanas, 2, '.', '') . '</th>';
	// echo '   <th scope="col"><div align="right">' .  . '</div></th>';
	echo '  </tr>';

	echo '  <tr>';
	echo '   <th colspan="2" scope="col"></br></th>';
	echo '  </tr>';

	$totalVentas = $totalgventas + $totalgventasAnimalitos + $totalgventasAmericanas;
	$totalPremios = $totalgpremios + $totalgpremios1 + $totalgpremiosAnimalitos + $totalgpremiosAmericanas;
	echo '   <th colspan="2" scope="col">--------- Contable --------</th>';

	echo '  </tr>';

	echo '  <tr>';
	echo '   <th scope="col">Gastos Tickets:' . $data['moneda'] .  number_format($totalVentas, 2, '.', ''), '</th>';
	// echo '   <th scope="col"><div align="right">' . . '</div></th>';
	echo '  </tr>';

	echo '  <tr>';
	echo '   <th scope="col">Premios Acreditados:' . $data['moneda'] . number_format($totalPremios, 2, '.', '') . '</th>';
	// echo '   <th scope="col"><div align="right">' .  . '</div></th>';
	echo '  </tr>';

	// echo '  <tr>';
	// echo '   <th scope="col">Acreditado:' . $data['moneda'] . number_format(abs($totalVentas - $totalPremios), 2, '.', '') . '</th>';
	// // echo '   <th scope="col"><div align="right">' .  . '</div></th>';
	// echo '  </tr>';

	echo '  <tr>';
	echo '   <th colspan="2" scope="col">--------------------------------</th>';
	echo '  </tr>';

	// echo '  <tr>';


	// echo '   <th scope="col">Sub Total:' . $data['moneda'] . number_format($totalgventas - ($totalgpremios + $totalgpremios1), 2, '.', '') . '</th>';
	// echo '   <th scope="col"><div align="right">' .  . '</div></th>';
	// echo '  </tr>';

	// if ($pdv == -3) :
	// 	$pdvt = asignacion($totalgventas, $gp);
	// else :
	// 	$pdvt = ($tv * $pdv) / 100;
	// endif;
	// if ($pdv1 == -3) :
	// 	$pdvt1 = 0;
	// else :
	// 	$pdvt1 = ($tv1 * $pdv1) / 100;
	// endif;

	// echo '  <tr>';
	// echo '   <th scope="col">% de Ventas:</th>';
	// echo '   <th scope="col"><div align="right">' . number_format($pdvt + $pdvt1, 2, '.', '') . '</div></th>';
	// echo '  </tr>';



	// $ttgs = ($totalgventas - ($totalgpremios + $totalgpremios1)) - ($pdvt + $pdvt1);

	// echo '  <tr>';
	// echo '   <th scope="col">Total :' . $data['moneda'] . number_format($ttgs, 2, '.', '') . '</th>';
	// // echo '   <th scope="col"><div align="right">' . . '</div></th>';
	// echo '  </tr>';



	// if ($ttgs < 0) :

	// 	$pr = $pdp1;

	// else :

	// 	$pr = $pdp;

	// endif;

	// echo '  <tr>';
	// echo '   <th scope="col">Procentaje Banca:' . number_format((100 - $pr), 2, '.', '') . '%</th>';
	// echo '   <th scope="col"><div align="right">' . number_format(($ttgs * (100 - $pr)) / 100, 2, '.', '') . '</div></th>';
	// echo '  </tr>';



	// echo '  <tr>';
	// echo '   <th scope="col">Procentaje Concesi.:' . number_format($pr, 2, '.', '') . '%</th>';
	// echo '   <th scope="col"><div align="right">' . number_format(($ttgs * $pr) / 100, 2, '.', '') . '</div></th>';
	// echo '  </tr>';





	echo '  <tr>';
	echo '   <th  scope="col">-</th>';
	echo '   <th  scope="col">-</th>';
	echo '   <th  scope="col">-</th>';
	echo '  </tr>';

	echo '</table></samp>';

	echo '</section>';


else :
	echo '<section id="report-contable-client">';
	echo "<h3?>No Hay Informacion...</h3>";
echo '</section>';
endif;