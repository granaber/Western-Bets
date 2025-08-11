<?php

require('prc_php.php');
require('escruteshi.php');

$GLOBALS['link'] = Connection::getInstance();

$xpp = 170;
$desdeIDCN = 0;
$hastaIDCN = 0;
$desde = $_REQUEST['desde'];
$hasta = $_REQUEST['hasta'];
$IDC = $_REQUEST['IDC'];
$hipodromo = $_REQUEST['hipodromo'];

$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where (STR_TO_DATE(Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('" . $desde . "','%d/%m/%Y') and STR_TO_DATE('" . $hasta . "','%d/%m/%Y')) and IDhipo=" . $hipodromo);
//echo ("SELECT * FROM _tconfjornadahi where (STR_TO_DATE(Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('".$desde."','%d/%m/%Y') and STR_TO_DATE('".$hasta."','%d/%m/%Y')) and IDhipo=".$hipodromo);
if (mysqli_num_rows($result) != 0) :
	$add = ' and (';
	$totalderegistro =	mysqli_num_rows($result);

	$i = 1;
	while ($row = mysqli_fetch_array($result)) {
		$add .= ' IDCN=' . $row['IDCN'];

		if (($totalderegistro) != $i) :
			$add .= ' or ';
			$i++;
		endif;
	}



	$add .= ")";
	$ttex = " Desde : " . $desde . " Hasta: " . $hasta;

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _hipodromoshi where _idhipo=" . $hipodromo);
	$row = mysqli_fetch_array($result);


	$ttex2 = " Hipodromo: " . $row['Descripcion'];


	$add = $add . " and IDC='" . $IDC . "'";
	$ttex3 = " Letra: " . $grupo;



	$header2 = array();
	$w2 = array();
	$w1 = array();
	$aa = array();
	$bb = array();

	$row = mysqli_fetch_array($result);


	$aa[0] = 0;
	$bb[0] = 0;
	$aat[0] = 'TOTALES';
	$bbt[0] = 0;
	$header[1] = 'WIN';
	$w[1] = 16;
	$w1[1] = 'R';
	$w2[1] = 'R';
	$aa[1] = 0;
	$bb[1] = 0;
	$aat[1] = 0;
	$bbt[1] = 0;
	$header[2] = 'PLACE';
	$w[2] = 16;
	$w1[2] = 'R';
	$w2[2] = 'R';
	$aa[2] = 0;
	$bb[2] = 0;
	$aat[2] = 0;
	$bbt[2] = 0;
	$header[3] = 'SHOW';
	$w[3] = 16;
	$w1[3] = 'R';
	$w2[3] = 'R';
	$aa[4] = 0;
	$bb[3] = 0;
	$aat[3] = 0;
	$bbt[3] = 0;
	$i = 4;
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegoshi where Estatus=1");
	while ($row = mysqli_fetch_array($result)) {
		$header[$i] = $row['Descrip'];
		$w[$i] = 14;
		$w1[$i] = 'R';
		$w2[$i] = 'R';
		$aa[$i] = 0;
		$bb[$i] = 0;
		$aat[$i] = 0;
		$bbt[$i] = 0;
		$i++;
	}
	$header[$i] = 'TOTALES';
	$w[$i] = 14;
	$w1[$i] = 'R';
	$w2[$i] = 'L';
	$aa[$i] = 0;
	$bb[$i] = 0;
	$aat[$i] = 0;
	$bbt[$i] = 0;



	echo '<table border="0">';
	echo '  <tr>';
	echo '  <th><input name="" type="button" value="Imprimir" onclick="print();"/><input name="" type="button" value="Cerrar" onclick="window.close();"/></th>';
	echo '  </tr>';
	echo '</table>';
	echo '<table border="0">';

	echo '  <tr>';
	echo '    <td colspan="5"  align="center" >Reporte de Ventas por Jugada/Hipodromo </td>';
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
	echo '  <tr>';
	echo '    <td colspan="5">' . $ttex2 . '</td>';
	echo '  </tr>';
	echo '   <tr>';
	echo '      <td colspan="5">===================================</td>';
	echo '    </tr>';
	echo '  <tr>';
	echo '    <td>Jugada</td>';
	echo '    <td>Venta</td>';
	echo '    <td>%</td>';
	echo '    <td>Premio</td>';
	echo '    <td>Difere.</td>';
	echo '  </tr>';


	$result = mysqli_query($GLOBALS['link'], "SELECT _tjugadahi.*  FROM _tjugadahi  where     (anulado=0 or anulado=4 or anulado=3 )  " . $add . " order by IDC,IDJug,IDCN,carr,serial");

	//echo ("SELECT _tjugadahi.*  FROM _tjugadahi  where     anulado=0  ".$add." order by IDC,IDJug,IDCN,carr,serial" );


	$IDC = '';

	while ($row = mysqli_fetch_array($result)) {
		if ($IDC != $row['IDC']) :

			$IDC = $row['IDC'];


			$aa[0] = $IDC;
			$bb[0] = '';
		endif;

		if ($row['IDJug'] == 0) :
			//$resultado=montojugadapremio($row['Jugada'],$row['Serial']);



			/* $aa[1]+=$resultado[0];$bb[1]+=$resultado[3]; 
	 $aa[2]+=$resultado[1];$bb[2]+=$resultado[4];
	 $aa[3]+=$resultado[2];$bb[3]+=$resultado[5];
	 
	 // Total Generales ///
	 
	 $aat[1]+=$resultado[0];$bbt[1]+=$resultado[3]; 
	 $aat[2]+=$resultado[1];$bbt[2]+=$resultado[4];
	 $aat[3]+=$resultado[2];$bbt[3]+=$resultado[5];*/

			$resultado = VerPremios($row['Serial'], 3, $row['Jugada']);


			$aa[1] += $resultado[0];
			$aa[2] += $resultado[1];
			$aa[3] += $resultado[2];
			if ($resultado[6]) :
				$bb[1] += $resultado[3];
				$bb[2] += $resultado[4];
				$bb[3] += $resultado[5];
			endif;
			// Total Generales ///

			$aat[1] += $resultado[0];
			$aat[2] += $resultado[1];
			$aat[3] += $resultado[2];
			if ($resultado[6]) :
				$bbt[3] += $resultado[5];
				$bbt[1] += $resultado[3];
				$bbt[2] += $resultado[4];
			endif;
		else :
			/* $premacion=EscrutarHI($row['Serial'],1);
	 if (!$premacion[3]):
	  $aa[$row['IDJug']+3]+=$row['Valor_J'];
	  $bb[$row['IDJug']+3]+=$premacion[1];
	 
	  // Total Generales ///
	  $aat[$row['IDJug']+3]+=$row['Valor_J'];
	  $bbt[$row['IDJug']+3]+=$premacion[1];
	 else:
	   $result_RESTORE = mysqli_query($GLOBALS['link'],"Select * from  _tjugadahi  where Serial=".$row['Serial']);$row_Rest = mysqli_fetch_array($result_RESTORE);
	   if ($row_Rest['Anulado']==0 || $row_Rest['Anulado']==4):
	     $aa[$row['IDJug']+3]+=$row_Rest['Valor_J'];
	     $bb[$row['IDJug']+3]+=$premacion[1];
	 
	     // Total Generales ///
	     $aat[$row['IDJug']+3]+=$row_Rest['Valor_J'];
	     $bbt[$row['IDJug']+3]+=$premacion[1];
	   endif;
	 endif;  */
			$premacion = VerPremios($row['Serial'], 2, '');
			if ($premacion != -1) :
				$aa[$row['IDJug'] + 3] += $row['Valor_J'];
				$bb[$row['IDJug'] + 3] += $premacion;
				$aat[$row['IDJug'] + 3] += $row['Valor_J'];
				$bbt[$row['IDJug'] + 3] += $premacion;
			endif;

		endif;
	}
	$sumar1 = 0;
	$sumar2 = 0;
	echo count($header);
	for ($c = 1; $c <= count($aa); $c++) {
		$sumar1 += $aa[$c];
		$sumar2 += $bb[$c];
	}
	$aa[count($header)] = $sumar1;
	$bb[count($header)] = $sumar2;


	$datosr = verporcetajes($IDC);



	for ($c = 1; $c <= count($header); $c++) {
		$diferencia = $aa[$c] - (($aa[$c] * $datosr[0]) / 100 + $bb[$c]);
		echo '  <tr>';
		echo '    <td>' . $header[$c] . '</td>';
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
	echo '     <td colspan="2">' . number_format((($diferencia * $datosr[1]) / 100), 2, ',', '.') . '(' . $datosr[1] . '%)' . '</td>';
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
