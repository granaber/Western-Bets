<?php
require('prc_php.php');
require('escruteshi.php');

$GLOBALS['link'] = Connection::getInstance();

$desdeIDCN = 0;
$hastaIDCN = 0;
$desde = $_REQUEST['desde'];
$hasta = $_REQUEST['hasta'];
$IDC = $_REQUEST['IDC'];


$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where (STR_TO_DATE(Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('" . $desde . "','%d/%m/%Y') and STR_TO_DATE('" . $hasta . "','%d/%m/%Y')) ");
if (mysqli_num_rows($result) != 0) :

	$add = ' and (';
	$totalderegistro =	mysqli_num_rows($result);

	$i = 1;
	while ($row = mysqli_fetch_array($result)) {
		$add .= ' _tconfighi.IDCN=' . $row['IDCN'];

		if (($totalderegistro) != $i) :
			$add .= ' or ';
			$i++;
		endif;
	}



	$add .= ")";
	$ttex = " Desde : " . $desde . " Hasta: " . $hasta;



	$add = $add . " and _tjugadahi.IDC='" . $IDC . "'";






	$aa = array();
	$bb = array();
	$row = mysqli_fetch_array($result);

	$diassemana = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo', 'Totales');
	$aa[0] = 0;
	$bb[0] = 0;
	$aat[0] = 'TOTALES';
	$bbt[0] = 0;
	for ($i = 1; $i <= 7; $i++) {
		$aa[$i] = 0;
		$bb[$i] = 0;
		$aat[$i] = 0;
		$bbt[$i] = 0;
	}

	$aa[$i] = 0;
	$bb[$i] = 0;
	$aat[$i] = 0;
	$bbt[$i] = 0;
	$aa[$i + 1] = 0;
	$bb[$i + 1] = 0;
	$aat[$i + 1] = 0;
	$bbt[$i + 1] = 0;
	$aa[$i + 2] = 0;
	$bb[$i + 2] = 0;
	$aat[$i + 2] = 0;
	$bbt[$i + 2] = 0;
	$aa[$i + 3] = 0;
	$bb[$i + 3] = 0;
	$aat[$i + 3] = 0;
	$bbt[$i + 3] = 0;

	$result = mysqli_query($GLOBALS['link'], "SELECT _tjugadahi.*,_tconfighi._Fecha  FROM _tjugadahi,_tconfighi  where  _tjugadahi.IDCN=_tconfighi.IDCN  and   (anulado=0 or anulado=4 or anulado=3 )   " . $add . " order by IDC,IDJug,_tjugadahi.IDCN,carr,serial ");

	echo '<table border="0">';
	echo '  <tr>';
	echo '  <th><input name="" type="button" value="Imprimir" onclick="print();"/><input name="" type="button" value="Cerrar" onclick="window.close();"/></th>';
	echo '  </tr>';
	echo '</table>';
	echo '<table border="0">';

	echo '  <tr>';
	echo '    <td colspan="5"  align="center" >Reporte de Venta/Premio Semanal</td>';
	echo '  </tr>';
	echo '  <tr align="left" >';
	echo '    <td colspan="5">Fecha/Hora:  ' . Fechareal(-30, "d/m/y") . '-' . Horareal(-30, "h:i:s A") . '</td>';
	echo '  </tr>';
	echo '  <tr>';
	echo '    <td colspan="5">Letra:  ' . $IDC . '</td>';
	echo '  </tr>';
	echo '  <tr>';
	echo '    <td colspan="5">Rango:' . $desde . ' - ' . $hasta . '</td>';
	echo '  </tr>';
	echo '   <tr>';
	echo '      <td colspan="5">===================================</td>';
	echo '    </tr>';
	echo '  <tr>';
	echo '    <td>Dia</td>';
	echo '    <td>Venta</td>';
	echo '    <td>%</td>';
	echo '    <td>Premio</td>';
	echo '    <td>Difere.</td>';
	echo '  </tr>';

	$IDC = '';

	while ($row = mysqli_fetch_array($result)) {
		if ($IDC != $row['IDC']) :
			$IDC = $row['IDC'];
			$aa[0] = $IDC;
			$bb[0] = '';
		endif;
		$fechaporparte = explode('/', $row['_Fecha']);
		$dia = (date("N", mktime(0, 0, 0, $fechaporparte[1], $fechaporparte[0], $fechaporparte[2])));
		if ($row['IDJug'] == 0) :
			/*  $premacion=EscrutarHI($row['Serial'],1);
     if ($premacion[1]>0):	
	    // Total Generales ///
 	 	$aa[$dia]+=$row['Valor_J']; $bb [$dia]+=$premacion[1];
	 	$aat[$dia]+=$row['Valor_J'];$bbt[$dia]+=$premacion[1];
	 else:
	 	$result_RESTORE = mysqli_query($GLOBALS['link'],"Select * from  _tjugadahi where Serial=".$row['Serial']);
		$row_Rest = mysqli_fetch_array($result_RESTORE);
		$aa[$dia]+=$row_Rest['Valor_J']; 
	 	$aat[$dia]+=$row_Rest['Valor_J'];
		$premacion=EscrutarHI($row['Serial'],1);
		if ($premacion[1]>=0):
			$bb [$dia]+=$premacion[1];
			$bbt[$dia]+=$premacion[1];
		endif;	
	 endif;*/
			$premacion = VerPremios($row['Serial'], 1, '');
			$aa[$dia] += $row['Valor_J'];
			$bb[$dia] += $premacion;
			$aat[$dia] += $row['Valor_J'];
			$bbt[$dia] += $premacion;

		else :
			/* $premacion=EscrutarHI($row['Serial'],1);
	 if (!$premacion[3]):
	  $aa[$dia]+=$row['Valor_J'];
	  $bb[$dia]+=$premacion[1];
	 
	   // Total Generales ///
	  $aat[$dia]+=$row['Valor_J'];
	  $bbt[$dia]+=$premacion[1];
	 else:
	   $result_RESTORE = mysqli_query($GLOBALS['link'],"Select * from  _tjugadahi  where Serial=".$row['Serial']);$row_Rest = mysqli_fetch_array($result_RESTORE);
	   if ($row_Rest['Anulado']==0 || $row_Rest['Anulado']==4):
	   	  $aa[$dia]+=$row_Rest['Valor_J'];
	 	  $bb[$dia]+=$premacion[1];
	 	  // Total Generales ///
	  	  $aat[$dia]+=$row_Rest['Valor_J'];
	   	  $bbt[$dia]+=$premacion[1];
	   endif;
	 endif;*/
			$premacion = VerPremios($row['Serial'], 2, '');
			if ($premacion != -1) :
				$aa[$dia] += $row['Valor_J'];
				$bb[$dia] += $premacion;
				$aat[$dia] += $row['Valor_J'];
				$bbt[$dia] += $premacion;
			endif;
		////////////////////////////////	  
		endif;
	}
	$sumar1 = 0;
	$sumar2 = 0;
	for ($c = 1; $c <= count($aa) - 4; $c++) {
		$sumar1 += $aa[$c];
		$sumar2 += $bb[$c];
	}

	$aa[count($aa) - 4] = $sumar1;
	$bb[count($bb) - 4] = $sumar2;
	$aat[count($aat) - 4] += $sumar1;
	$bbt[count($bbt) - 4] += $sumar2;

	$datosr = verporcetajes($IDC);

	$aa[count($aa) - 3] = number_format(($sumar1 * $datosr[0]) / 100, 2, ',', '.') . '(' . $datosr[0] . '%)';
	$bb[count($bb) - 3] = 0;
	$aat[count($aat) - 3] += ($sumar1 * $datosr[0]) / 100;
	$bbt[count($bbt) - 3] += $bb[count($bb) - 3];

	//// Diferencia
	$diferencia = $sumar1 - (($sumar1 * $datosr[0]) / 100 + $sumar2);
	$aa[count($aa) - 2] = number_format($diferencia, 2, ',', '.');
	$bb[count($bb) - 2] = 0;
	$aat[count($aat) - 2] += $diferencia;
	$bbt[count($bbt) - 2] += 0;

	//// Participacion
	$aa[count($aa) - 1] = number_format(($diferencia * $datosr[1]) / 100, 2, ',', '.') . '(' . $datosr[1] . '%)';
	$bb[count($bb) - 1] = 0;
	$aat[count($aat) - 1] += ($diferencia * $datosr[1]) / 100;
	$bbt[count($bbt) - 1] += 0;


	for ($c = 1; $c <= count($aa) - 4; $c++) {
		$diferencia = $aa[$c] - (($aa[$c] * $datosr[0]) / 100 + $bb[$c]);
		echo '  <tr>';
		echo '    <td>' . $diassemana[($c - 1)] . '</td>';
		echo '    <td  align="right">' . number_format($aa[$c], 2, ',', '.') . '|</td>';
		echo '    <td align="right">' . number_format(($aa[$c] * $datosr[0]) / 100, 2, ',', '.') . '|</td>';
		echo '    <td align="right">' . number_format($bb[$c], 2, ',', '.') . '|</td>';
		echo '    <td align="right">' . number_format($diferencia, 2, ',', '.') . '|</td>';
		echo '  </tr>';
	}


	for ($c = 1; $c <= count($aa) - 1; $c++) {
		$aat[$c] = number_format($aat[$c], 2, ',', '.');
		$bbt[$c] = number_format($bbt[$c], 2, ',', '.');
	}

	$bbt[0] = '';

	echo '  <tr>';
	echo '     <td>Participacion:</td>';
	echo '     <td colspan="2">' . $aa[count($aa) - 1] . '</td>';
	echo '     <td>&nbsp;</td>';
	echo '     <td>&nbsp;</td>';
	echo '   </tr>';
	echo '   <tr>';
	echo '      <td colspan="5">===================================</td>';
	echo '    </tr>';
	echo ' </table>';
	echo '-<br>';
	echo '-<br>';
	echo '-<br>';
	echo '-<br>';
	echo '-<br>';
else :
	echo ' NO existe la INFORMACION SOLICITADA!!';
endif;
