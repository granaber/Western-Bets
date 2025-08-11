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
	echo '   <th scope="col">Reporte Detallado de Ventas</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th scope="col">' . $ttex . '</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th  scope="col">' . $ttex2 . '</th>';
	echo '  </tr>';
	echo '  <tr>';
	echo '   <th  scope="col">*****************************************</th>';
	echo '  </tr>';

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario " . $add1 . " Order By IDC");



	while ($row = mysqli_fetch_array($result)) {
		echo '  <tr>';
		$tv = 0;
		$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tjugadabb  where IDC='" . $row['IDC'] . "'    and activo=1 " . $add . " Order By IDJ");


		while ($row2 = mysqli_fetch_array($result2)) {

			$arr = resstruc_tick($row2['serial']);
			$head = explode('|', $arr[0]);
			echo '<table  border="0">';
			echo '  <tr>';
			echo '  <th colspan="2" scope="col" >Serial:' . $row2['serial'] . '|&nbsp;Fecha:' . $head[1] . '|&nbsp;Hora:' . $head[0] . '</th>';
			echo '  </tr>';

			for ($j = 1; $j <= count($arr) - 1; $j++) {
				$despligue = explode('|', $arr[$j]);
				echo '  <tr>';
				echo '   <th scope="col"><div align="left">' . (isset($despligue[2]) ? $despligue[2] : '') . '  </div> </th>';
				echo '   <th scope="col"><div align="left">' . (isset($despligue[3]) ? $despligue[3] : '') . '  </div> </th>';
				echo '  </tr>';
			}
			echo '  <tr>';
			echo '   <th scope="col"><div align="left">Apuesta:Bs.f    </div> </th>';
			echo '   <th scope="col"><div align="right">' . number_format($head[2], 2, '.', '') . '</div></th>';
			echo '  </tr>';
			echo '  <tr>';
			echo '   <th scope="col"><div align="left">a Cobrar:Bs.f    </div> </th>';
			echo '   <th scope="col"><div align="right">' . number_format($head[3], 2, '.', '') . '</div></th>';
			echo '  </tr>';
			echo '</table>';
			echo '  <tr>';
			echo '   <th  scope="col">*****************************************</th>';
			echo '  </tr>';
		}
		echo '  </tr>';
	}

	echo '</table></samp>';


else :
	echo "No Hay Informacion...";
endif;

?>