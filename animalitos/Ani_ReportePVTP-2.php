
<?php
require_once('prc_phpDUK.php');
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
		$verdatos .= ' _Jugada_ani.IDJ=' . $row['IDJ'];
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
	echo '   <th colspan="4" scope="col">Reporte de Tickets Pagados</th>';
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
	echo '   <th >Serial</th>';
	echo '   <th >Premio</th>';
	echo '   <th >Monto</th>';
	echo '   <th >Ganacia</th>';
	echo '  </tr>';

	$result2 = mysqli_query($link, "SELECT * FROM _Concesionario_Ani WHERE  IDC='" . $IDC . "'");
	$row2 = mysqli_fetch_array($result2);
	$iTkPagar = $row2['iTkPagar'];


	$SumC1 = 0;
	$SumC2 = 0;
	$SumC3 = 0;
	$SumC4 = 0;
	$nivel = '1';
	if ($iTkPagar == 1) :
		$result2 = mysqli_query($link, "SELECT _Jugada_ani.*,_Jugada_ani_pagado.montopagado as premio FROM _Jugada_ani_pagado,_Jugada_ani  where _Jugada_ani_pagado.serial=_Jugada_ani.serial and _Jugada_ani.IDC='" . $IDC . "' and _Jugada_ani.Activo=1 " . $add);
	else :
		$result2 = mysqli_query($link, "SELECT _Jugada_ani.*,_Jugada_ani_prem.premio FROM _Jugada_ani_prem,_Jugada_ani  where _Jugada_ani_prem.serial=_Jugada_ani.serial and _Jugada_ani.IDC='" . $IDC . "' and _Jugada_ani.Activo=1 " . $add);
	endif;
	while ($row2 = mysqli_fetch_array($result2)) {



		$resultN2 = mysqli_query($link, "SELECT * FROM _Jornarda_fecha WHERE  IDJ=" . $row2['IDJ']);
		$row2N = mysqli_fetch_array($resultN2);

		switch ($nivel) {
			case '1':
				# code...
				$Backg = 'style="background:#CCC"';
				$nivel = '2';
				break;

			case '2':
				# code...
				$Backg = 'style=""';
				$nivel = '1';
				break;
		}
		$cobra = $row2['premio'] - $row2['monto'];
		echo '  <tr>';
		echo '   <th ><p ' . $Backg . ' align="right">' . $row2['serial'] . '</p></th>';
		$SumC1++;
		echo '   <th ><p ' . $Backg . ' align="right">' . number_format($row2['premio'], 2, ',', '.') . '</p></th>';
		$SumC2 += $row2['premio'];
		echo '   <th ><p ' . $Backg . ' align="right">' . number_format($row2['monto'], 2, ',', '.') . '</p></th>';
		$SumC3 += $row2['monto'];
		echo '   <th ><p ' . $Backg . ' align="right">' . number_format($cobra, 2, ',', '.') . '</p></th>';
		$SumC4 += $cobra;
		echo '  </tr>';
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

?>
