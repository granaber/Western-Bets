

<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


$d1 = $_REQUEST['d1'];
$d2 = $_REQUEST['d2'];
$clsi = $_REQUEST['clsi'];
$gp = $_REQUEST['gp'];
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
	$ttex = " Desde : " . $d1 . " Hasta: " . $d2;



	$add1 = '';

	switch ($clsi) {
		case 1:
			if ($gp != "0") :
				$add1 = " where IDC='" . $gp . "'";
				$ttex2 = 'Concesionario : ' . $gp;
			endif;
			break;
	}


	echo '<table  border="0">';
	echo '  <tr>';
	echo '  <th><input name="" type="button" value="Imprimir" onclick="print();"/><input name="" type="button" value="Cerrar" onclick="window.close();"/></th>';
	echo '  </tr>';
	echo '</table>';

	echo '<samp><table  border="0">';
	echo '  <tr>';
	echo '   <th colspan="4" scope="col">Reporte Resumido de Premios</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th colspan="4" scope="col">' . $ttex . '</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th colspan="4" scope="col">' . $ttex2 . '</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th  scope="col">Serial</th>';
	echo '   <th  scope="col">Fecha/hora</th>';
	echo '   <th  scope="col">Apuesta</th>';
	echo '   <th  scope="col">Pago</th>';
	echo '   <th  scope="col">Est.</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th colspan="4" scope="col">*************************************</th>';
	echo '  </tr>';

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario " . $add1 . " Order By IDC");
	/* echo "SELECT * FROM _tconsecionario ".$add1." Order By IDC"; */
	$pagados = 0;

	while ($row = mysqli_fetch_array($result)) {

		$tv = 0;
		$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tjugadabb  where IDC='" . $row['IDC'] . "'    and activo=1 " . $add . " Order By IDJ");


		while ($row2 = mysqli_fetch_array($result2)) {
			$cod = mescrute($row2['serial']);

			if ($cod['condicion'] == true) :
				echo '  <tr>';

				$resultdf = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where IDJ=" . $row2['IDJ']);

				if (mysqli_num_rows($resultdf) != 0) :
					$row3 = mysqli_fetch_array($resultdf);
					$fch = $row3['Fecha'] . ' ' . $row2['hora'];
				else :
					$fch = '';
				endif;
				echo '   <th scope="col">' . $row2['serial'] . '</th>';
				echo '   <th scope="col">' . $fch . '</th>';
				echo '   <th scope="col">' . $row2['ap'] . '</th>';
				echo '   <th scope="col"><p align="right">' . number_format($cod['acobrar'], 2, ',', '.') . '</p></th>';;
				if ($row2['pagado'] == 1) {
					echo ' <th scope="col">Pag.</th>';
					$pagados += $cod['acobrar'];
				} else {
					echo ' <th scope="col"></th>';
				}

				$tv += $cod['acobrar'];
				echo '  </tr>';
			endif;
		}
		echo '  <tr>';
		echo '   <th  scope="col"></th>';
		echo '   <th  scope="col">Total de Premios</th>';
		echo '   <th  scope="col"><div align="right">' . number_format($tv, 2, ',', '.') . '</div></th>';
		echo '   <th  scope="col"></th>';
		echo '  </tr>';
		echo '  <tr>';
		echo '   <th  scope="col"></th>';
		echo '   <th  scope="col">Prem.PAGADOS</th>';
		echo '   <th  scope="col"><div align="right">' . number_format($pagados, 2, ',', '.') . '</div></th>';
		echo '   <th  scope="col"></th>';
		echo '  </tr>';
	}
	echo '  <tr>';
	echo '   <th  scope="col">-</th>';
	echo '   <th  scope="col">-</th>';
	echo '   <th  scope="col">-</th>';
	echo '  </tr>';

	echo '</table></samp>';


else :
	echo "No Hay Informacion...";
endif;

?>
