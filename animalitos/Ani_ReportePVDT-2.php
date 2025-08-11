<?php
require_once('prc_phpDUK.php');
require_once('Ani_struct_xLoteri.php');

$link = ConnectionAnimalitos::getInstance();


$d1 = _ConverFecha($_REQUEST['d1']);
$d2 = _ConverFecha($_REQUEST['d2']);
$IDC = $_REQUEST['IDC'];
$ttex2 = '';
$add = '';
$desdeIDC = 0;
$hastaIDC = 0;
//// Determin rango de Lectura de IDJ
$result = mysqli_query($link, "SELECT * FROM _Jornarda_fecha  Where Fecha BETWEEN '" . $d1 . "' and '" . $d2 . "' ");
if (mysqli_num_rows($result) != 0) :
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

	$add = " and  (" . $verdatos . " ) ";

	$ttex = " Desde : " . $_REQUEST['d1'] . " Hasta: " . $_REQUEST['d2'];
	$ttex2 = "Punto de Venta: " . $IDC;


	echo '<table  border="0">';
	echo '  <tr>';
	echo '  <th><input name="" type="button" value="Imprimir" onclick="print();"/><input name="" type="button" value="Cerrar" onclick="window.close();"/></th>';
	echo '  </tr>';
	echo '</table>';

	echo '<samp><table  border="0">';
	echo '  <tr>';
	echo '   <th colspan="4" scope="col">Reporte Detallado de Ventas</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th colspan="4" scope="col">' . $ttex . '</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th colspan="4" scope="col">' . $ttex2 . '</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th colspan="4" scope="col">-----------------------------------</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th >Fecha</th>';
	echo '   <th >Venta</th>';
	echo '   <th >Premio</th>';
	echo '   <th >%</th>';
	echo '  </tr>';

	$result2 = mysqli_query($link, "SELECT * FROM _Concesionario_Ani WHERE  IDC='" . $IDC . "'");
	$row2 = mysqli_fetch_array($result2);
	$iPorcentaje = $row2['iPVenta'];
	$iParticipa = $row2['iPParti'];
	$iTkPagar = $row2['iTkPagar'];
	$SumC1 = 0;
	$SumC2 = 0;
	$SumC3 = 0;
	$SumC4 = 0;
	$nivel = '1';
	$result2 = mysqli_query($link, "SELECT IDJ,count( serial ) AS cuanto, Sum( monto ) AS Venta FROM _Jugada_ani  where IDC='" . $IDC . "' and Activo=1 " . $add . " GROUP BY IDJ ORDER BY IDJ");
	while ($row2 = mysqli_fetch_array($result2)) {
		$Ventas = $row2['Venta'];
		$SumC1 += $row2['cuanto'];

		if ($iTkPagar == 0) :
			$resultN2 = mysqli_query($link, "SELECT Sum(premio) as Premio FROM _Jugada_ani_prem WHERE Serial IN ( SELECT serial FROM _Jugada_ani WHERE IDC='" . $IDC . "' and Activo=1 and IDJ=" . $row2['IDJ'] . " )");
			$row2N = mysqli_fetch_array($resultN2);
			$Premios = $row2N['Premio'];
		else :
			$resultN2 = mysqli_query($link, "SELECT Sum(montopagado) as Premio FROM _Jugada_ani_pagado WHERE Serial IN ( SELECT serial FROM _Jugada_ani WHERE IDC='" . $IDC . "' and Activo=1 and IDJ=" . $row2['IDJ'] . " )");
			$row2N = mysqli_fetch_array($resultN2);
			$Premios = $row2N['Premio'];
		endif;


		$dataStructxLotery = StructuData($row2['IDJ'], $IDC);
		$PorcentaTotal = array_sum($dataStructxLotery[1]);

		// $PorcentaTotal=($Ventas*$iPorcentaje)/100;

		$resultN2 = mysqli_query($link, "SELECT * FROM _Jornarda_fecha WHERE  IDJ=" . $row2['IDJ']);
		$row2N = mysqli_fetch_array($resultN2);

		// switch ($nivel) {
		// 	case '1':
		// 		# code...
		// 		$Backg='style="background:#CCC"';
		// 		$nivel='2';
		// 		break;

		// 	case '2':
		// 		# code...
		// 		$Backg='style=""';
		// 		$nivel='1';
		// 		break;
		// }
		$Backg = 'style="background:#CCC"';
		echo '  <tr>';
		echo '   <th ><p ' . $Backg . ' align="right">' . _ConverFechaT2($row2N['Fecha']) . '</p></th>';
		echo '   <th ><p ' . $Backg . ' align="right">' . number_format($Ventas, 2, ',', '.') . '</p></th>';
		$SumC2 += $Ventas;
		echo '   <th ><p ' . $Backg . ' align="right">' . number_format($Premios, 2, ',', '.') . '</p></th>';
		$SumC3 += $Premios;
		echo '   <th ><p ' . $Backg . ' align="right">' . number_format($PorcentaTotal, 2, ',', '.') . '</p></th>';
		$SumC4 += $PorcentaTotal;
		echo '  </tr>';
		$Backg = 'style=""';
		echo '  <tr>';
		echo '   <th colspan="4" ><p ' . $Backg . ' align="center">**** DESGLOSE DEL ' . _ConverFechaT2($row2N['Fecha']) . ' ****</p></th>';
		echo '  </tr>';

		$detailVentas = $dataStructxLotery[0];
		$detailPorcentaje =  $dataStructxLotery[1];
		$lotteris =  $dataStructxLotery[2];
		$strucPorcentaje = $dataStructxLotery[3];
		foreach ($detailVentas as $idx => $value) {
			echo '  <tr>';
			echo '   <th ><p ' . $Backg . ' align="right">' . $lotteris[$idx] . '</p></th>';
			echo '   <th ><p ' . $Backg . ' align="right">' . number_format($detailVentas[$idx], 2, ',', '.') . '</p></th>';
			echo '   <th ><p ' . $Backg . ' align="right">' . $strucPorcentaje[$idx] . '%</p></th>';
			echo '   <th ><p ' . $Backg . ' align="right">' . number_format($detailPorcentaje[$idx], 2, ',', '.') . '</p></th>';
			echo '  </tr>';
		}
	}

	echo '  <tr>';
	echo '   <th colspan="4" scope="col">-----------------------------------</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th ><p align="right">(' . number_format($SumC1, 2, ',', '.') . ')|</p></th>';
	echo '   <th ><p align="right">' . number_format($SumC2, 2, ',', '.') . '|</p></th>';
	echo '   <th ><p align="right">' . number_format($SumC3, 2, ',', '.') . '|</p></th>';
	echo '   <th ><p align="right">' . number_format($SumC4, 2, ',', '.') . '|</p></th>';
	echo '  </tr>';

	$Diferencia = $SumC2 - ($SumC4 + $SumC3);
	echo '  <tr>';
	echo '   <th colspan="2" scope="col"><p style="font-weight: bold; " align="left"> Diferencia:</p> </th>';
	echo '   <th  colspan="2" scope="col"><p align="right" > ' . number_format($Diferencia, 2, ',', '.') . ' </p></th>';
	echo '  </tr>';
	$Participa = ($Diferencia * $iParticipa) / 100;
	echo '  <tr>';
	echo '   <th colspan="2" scope="col"><p style="font-weight: bold; background:#CCC" align="left">Participacion:(' . $iParticipa . '%)</p> </th>';
	echo '   <th  colspan="2"scope="col"><p style="font-weight: bold; background:#CCC" align="right">' . number_format($Participa, 2, ',', '.') . '</p> </th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th colspan="2" scope="col"><p style="font-weight: bold; " align="left">Cantidad de Tickets:</p></th>';
	echo '   <th  colspan="2"scope="col"><p align="right" > (' . $SumC1 . ') </p></th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th  scope="col">-</th>';
	echo '   <th  scope="col">-</th>';
	echo '   <th  scope="col">-</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th colspan="3" scope="col">Impreso:' . FecharealAnimalitos($minutosh, "d/n/Y") . '-' . HorarealAnimalitos($minutosh, "h:i:s A") . '</th>';
	echo '  </tr>';
	echo '</table></samp>';


else :
	echo "No Hay Informacion...";
endif;
