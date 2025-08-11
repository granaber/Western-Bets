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
$tipo = $_REQUEST['tipo'];


$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where (STR_TO_DATE(Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('" . $desde . "','%d/%m/%Y') and STR_TO_DATE('" . $hasta . "','%d/%m/%Y')) ");
//echo ("SELECT * FROM _tconfjornadahi where (STR_TO_DATE(Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('".$desde."','%d/%m/%Y') and STR_TO_DATE('".$hasta."','%d/%m/%Y')) and IDhipo=".$hipodromo);
if (mysqli_num_rows($result) != 0) :
	if ($tipo == 3) :
		$add = '  (anulado=1 or anulado=3 )  and (';
	else :
		$add = '  (anulado=0 or anulado=4 or anulado=3 )   and (';
	endif;
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


	$add = $add . " and IDC='" . $IDC . "'";
	$ttex3 = " Letra: " . $grupo;





	$aa = array();
	$bb = array();
	$cc = array();
	$dd = array();


	echo '<table border="0">';
	echo '  <tr>';
	echo '  <th><input name="" type="button" value="Imprimir" onclick="print();"/><input name="" type="button" value="Cerrar" onclick="window.close();"/></th>';
	echo '  </tr>';
	echo '</table>';
	echo '<table border="0">';

	echo '  <tr>';
	echo '    <td colspan="5"  align="center" >Reporte de Ventas/Premio Detallado </td>';
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
	echo '    <td>Serial</td>';
	echo '    <td>Jugada</td>';
	echo '    <td>Venta</td>';
	echo '    <td>Premio</td>';
	echo '    <td>Hora</td>';
	echo '  </tr>';


	$result = mysqli_query($GLOBALS['link'], "SELECT _tjugadahi.*  FROM _tjugadahi  where    " . $add . " order by IDC,IDJug,IDCN,carr,serial");

	//echo ("SELECT _tjugadahi.*  FROM _tjugadahi  where     anulado=0  ".$add." order by IDC,IDJug,IDCN,carr,serial" );


	$IDC = '';

	while ($row = mysqli_fetch_array($result)) {

		if ($tipo != 3) :
			if ($row['IDJug'] == 0) :
				$premacion = EscrutarHI($row['Serial'], 1);
				if ($tipo == 2 && ($premacion[1] != 0 || $premacion[1] != -1)) :
					$result_P = mysqli_query($GLOBALS['link'], " SELECT * FROM _ticketpagados Where serial=" . $row['Serial']);
					if (mysqli_num_rows($result_P) != 0) :
						$aa[] = $row['Serial'];
						$bb[] = 'G/P/S';
						$cc[] = $row['Valor_J'];
						$dd[] = $premacion[1];
					endif;
				endif;
				if ($tipo == 1 &&  $premacion[1] != -1) :
					$aa[] = $row['Serial'];
					$bb[] = 'G/P/S';
					$cc[] = $row['Valor_J'];
					$result_P = mysqli_query($GLOBALS['link'], " SELECT * FROM _ticketpagados Where serial=" . $row['Serial']);
					if (mysqli_num_rows($result_P) != 0) :
						$dd[] = $premacion[1];
					else :
						$dd[] = 0;
					endif;
				endif;
			else :
				$premacion = EscrutarHI($row['Serial'], 1);

				if ($premacion[3]) :
					$result_RESTORE = mysqli_query($GLOBALS['link'], "Select * from  _tjugadahi  where Serial=" . $row['Serial']);
					$row_Rest = mysqli_fetch_array($result_RESTORE);
					if ($row_Rest['Anulado'] == 0 || $row_Rest['Anulado'] == 4) : $okey = true;
					else :  $okey = false;
					endif;
				else :
					$okey = true;
				endif;

				if ($okey) :
					$resultjugada = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tdjuegoshi  where IDJug=" . $row['IDJug']);
					$rowjugada = mysqli_fetch_array($resultjugada);
					if ($tipo == 2 && ($premacion[1] != 0 || $premacion[1] != -1)) :
						$result_P = mysqli_query($GLOBALS['link'], " SELECT * FROM _ticketpagados Where serial=" . $row['Serial']);
						if (mysqli_num_rows($result_P) != 0) :
							$aa[] = $row['Serial'];
							$bb[] = $rowjugada['Descrip'];
							$cc[] = $row['Valor_J'];
							$dd[] = $premacion[1];
						endif;
					endif;
					if ($tipo == 1 &&  $premacion[1] != -1) :
						$aa[] = $row['Serial'];
						$bb[] = $rowjugada['Descrip'];
						$cc[] = $row['Valor_J'];
						$result_P = mysqli_query($GLOBALS['link'], " SELECT * FROM _ticketpagados Where serial=" . $row['Serial']);
						if (mysqli_num_rows($result_P) != 0) :
							$dd[] = $premacion[1];
						else :
							$dd[] = 0;
						endif;
					endif;
				endif;

			endif;
		else :
			if ($row['IDJug'] == 0) :
				$aa[] = $row['Serial'];
				$bb[] = 'G/P/S';
				$cc[] = $row['Valor_J'];
				$dd[] = 0;
			else :
				if ($premacion[3]) :
					$result_RESTORE = mysqli_query($GLOBALS['link'], "Select * from  _tjugadahi  where Serial=" . $row['Serial']);
					$row_Rest = mysqli_fetch_array($result_RESTORE);
					if ($row_Rest['Anulado'] == 0 || $row_Rest['Anulado'] == 3) : $okey = true;
					else :  $okey = false;
					endif;
				else :
					$okey = true;
				endif;
				if ($okey) :
					$resultjugada = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tdjuegoshi  where IDJug=" . $row['IDJug']);
					$rowjugada = mysqli_fetch_array($resultjugada);
					$aa[] = $row['Serial'];
					$bb[] = $rowjugada['Descrip'];
					$cc[] = $row['Valor_J'];
					$dd[] = 0;
				endif;
			endif;
		endif;
		$ee[] = $row['Hora'];
	}
	$sumar1 = 0;
	$sumar2 = 0;

	for ($c = 0; $c <= count($aa); $c++) {
		$sumar1 += $cc[$c];
		$sumar2 += $dd[$c];
	}



	$datosr = verporcetajes($IDC);



	for ($c = 0; $c <= count($aa) - 1; $c++) {
		$diferencia = $aa[$c] - (($aa[$c] * $datosr[0]) / 100 + $bb[$c]);
		echo '  <tr>';
		echo '    <td>' . $aa[$c] . '</td>';
		echo '    <td  align="right">' . Incialies($bb[$c]) . '|</td>';
		echo '    <td align="right">' . number_format($cc[$c], 2, ',', '.') . '|</td>';
		if ($dd[$c] != 0) :
			echo '    <td align="right">' . number_format($dd[$c], 2, ',', '.') . '|</td>';
		else :
			echo '    <td align="right"></td>';
		endif;
		echo '    <td align="right">' . $ee[$c] . '</td>';
		echo '  </tr>';
	}


	echo '  <tr>';
	echo '     <td>Totales:</td>';

	echo '     <td colspan="2" align="right">' . number_format($sumar1, 2, ',', '.') . '|</td>';
	echo '     <td colspan="2">' . number_format($sumar2, 2, ',', '.') . '</td>';

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

function Incialies($texto)
{
	$iniciales = explode(' ', $texto);
	if (count($iniciales) >= 2) :
		return substr($iniciales[0], 0, 1) . substr($iniciales[1], 0, 1);
	else :
		return $texto;
	endif;
}
