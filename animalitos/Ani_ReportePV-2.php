<?php
require_once('prc_phpDUK.php');
require_once('Ani_struct_xLoteri.php');
$link = ConnectionAnimalitos::getInstance();

$aIDJs = array();
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
		$aIDJs[] = $row['IDJ'];
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
	echo '   <th colspan="3" scope="col">Reporte Resumido de Ventas</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th colspan="3" scope="col">' . $ttex . '</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th colspan="3" scope="col">' . $ttex2 . '</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th colspan="3" scope="col">-----------------------------------</th>';
	echo '  </tr>';




	$result2 = mysqli_query($link, "SELECT count( serial ) AS cuanto, Sum( monto ) AS Venta FROM _Jugada_ani  where IDC='" . $IDC . "' and Activo=1 " . $add);
	$row2 = mysqli_fetch_array($result2);
	$Ventas = $row2['Venta'];
	$somos = $row2['cuanto'];

	$result2 = mysqli_query($link, "SELECT * FROM _Concesionario_Ani WHERE  IDC='" . $IDC . "'");
	$row2 = mysqli_fetch_array($result2);
	$iPorcentaje = $row2['iPVenta'];
	$iParticipa = $row2['iPParti'];
	$iTkPagar = $row2['iTkPagar'];

	if ($iTkPagar == 1) :
		$result2 = mysqli_query($link, "SELECT Sum(montopagado) as Premio FROM _Jugada_ani_pagado WHERE serial IN (SELECT serial FROM _Jugada_ani WHERE IDC='" . $IDC . "' and Activo=1 " . $add . ")");
		$row2 = mysqli_fetch_array($result2);
		$Premios = $row2['Premio'];
	else :
		$result2 = mysqli_query($link, "SELECT Sum(premio) as Premio FROM _Jugada_ani_prem WHERE Serial IN (SELECT serial FROM _Jugada_ani WHERE IDC='" . $IDC . "' and Activo=1 " . $add . ")");
		$row2 = mysqli_fetch_array($result2);
		$Premios = $row2['Premio'];
	endif;




	echo '  <tr>';
	echo '   <th colspan="2" scope="col" aling="left"><p style="font-weight: bold; background:#CCC" align="left"> Ventas:</p> </th>';
	echo '   <th ><p align="right" style=" background:#CCC"> ' . number_format($Ventas, 2, ',', '.') . '</p></th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th colspan="2" scope="col"><p style="font-weight: bold; " align="left"> Premios:</p>  </th>';
	echo '   <th ><p align="right" > ' . number_format($Premios, 2, ',', '.') . '</p></th>';
	echo '  </tr>';

	$PorcentaTotal = 0;
	// print_r($aIDJs);
	for ($i = 0; $i < count($aIDJs); $i++) {
		$dataStructxLotery = StructuData($aIDJs[$i], $IDC);
		// print_r($dataStructxLotery);
		$PorcentaTotal += array_sum($dataStructxLotery[1]);
	}

	// $PorcentaTotal=($Ventas*$iPorcentaje)/100;('.$iPorcentaje.'%)
	echo '  <tr>';
	echo '   <th colspan="2" scope="col"><p style="font-weight: bold; background:#CCC" align="left">Porcentaje:</p> </th>';
	echo '   <th  scope="col"><p style="font-weight: bold; background:#CCC" align="right"> ' . number_format($PorcentaTotal, 2, ',', '.') . '</p> </th>';
	echo '  </tr>';
	$Diferencia = $Ventas - ($PorcentaTotal + $Premios);
	echo '  <tr>';
	echo '   <th colspan="2" scope="col"><p style="font-weight: bold; " align="left"> Diferencia:</p> </th>';
	echo '   <th  scope="col"><p align="right" > ' . number_format($Diferencia, 2, ',', '.') . ' </p></th>';
	echo '  </tr>';
	$Participa = ($Diferencia * $iParticipa) / 100;
	echo '  <tr>';
	echo '   <th colspan="2" scope="col"><p style="font-weight: bold; background:#CCC" align="left">Participacion:(' . $iParticipa . '%)</p> </th>';
	echo '   <th  scope="col"><p style="font-weight: bold; background:#CCC" align="right">' . number_format($Participa, 2, ',', '.') . '</p> </th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th colspan="2" scope="col"><p style="font-weight: bold; " align="left">Cantidad de Tickets:</p></th>';
	echo '   <th  scope="col"><p align="right" > (' . $somos . ') </p></th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th  scope="col">-</th>';
	echo '   <th  scope="col">-</th>';
	echo '   <th  scope="col">-</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th colspan="3" scope="col">Impreso:' . FecharealAnimalitos($minutosho, "d/n/Y") . '-' . HorarealAnimalitos($minutosho, "h:i:s A") . '</th>';
	echo '  </tr>';
	echo '</table></samp>';


else :
	echo "No Hay Informacion...";
endif;
