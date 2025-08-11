<style type="text/css">
	.tip3 {
		color: #3366FF;
		border-bottom: 1px dashed #FFFF33;
	}
</style>
<?
if (isset($serial)) :
	$result_search = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadahi where serial=" . $serial);
	$rowsearch = mysqli_fetch_array($result_search);
	$idj = $rowsearch['IDJug'];
	$idcn = $rowsearch['IDCN'];
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadahi where serial=" . $serial);
else :
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadahi where IDC='" . $conse1 . "' and IDCN=" . $idcn . " and IDJug=" . $idj);
endif;
$resultConce = mysqli_query($GLOBALS['link'], "SELECT *,_hipodromoshi.Descripcion FROM _tconfjornadahi,_hipodromoshi where _tconfjornadahi.IDhipo=_hipodromoshi._idhipo and _tconfjornadahi.IDCN=" . $idcn);
$rowsConce = mysqli_fetch_array($resultConce);
$total_Carrera = $rowsConce['Cantcarr'];

$totalventas = 0;
$totalpremios = 0;
if (mysqli_num_rows($result) != 0) :

	$result_r = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegoshi where IDJug=" . $idj);
	$row_r = mysqli_fetch_array($result_r);
	echo '<table  id="mnu"  border="0" >';
	echo '<tr  bgcolor="#999999">';
	echo '<th  scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>';
	echo '<th  scope="col">Serial </th>';
	if (isset($serial)) :
		echo '<th  scope="col">Consec.</th>';
		echo '<th  scope="col">Jugada</th>';
		if ($idj == 0) :
			$descrip = 'Win/Pla/Show<br>' . $rowsConce['Descripcion'];
		else :
			$descrip = $row_r['Descrip'] . '<br>' . $rowsConce['Descripcion'];
		endif;
	endif;
	echo '<th  scope="col">Fecha</th>';
	echo '<th  scope="col">Hora</th>';
	if ($idj == 0) :
		$arreglocolor = array('#81AFFE', '#4B79A7');
		$c = 0;
		for ($r = 1; $r <= 14; $r++) {
			echo "<th scope='col'   colspan='3' style='background: " . $arreglocolor[$c] . ";' >Ejem." . $r . "</th>";
			if ($c == 0) : $c = 1;
			else : $c = 0;
			endif;
		}
		echo '<th  bgcolor="#0099FF"  scope="col">Carr</th>';
	endif;
	if ($row_r['Formato'] != 5) :

		for ($r = 1; $r <= $row_r['CantidadCarr']; $r++) {
			echo '<th  bgcolor="#0099FF" scope="col">Valida ' . $r . '</th>';
		}


		if ($row_r['Tandas'] == 2) :
			echo '<th  bgcolor="#0099FF"  scope="col">Tanda</th>';
		else :
			if ($row_r['Formato'] != 0) :
				echo '<th  bgcolor="#0099FF"  scope="col">Carr</th>';
			endif;
		endif;
	else :

		/*  $result2 = mysqli_query($GLOBALS['link'],"SELECT * FROM _tconfig where IDCN=".$idcn);
				 $row2 = mysqli_fetch_array($result2); 
				 $canteje=explode('|',$row2['_Fab']); */

		for ($r = 1; $r <= 14; $r++) {
			echo '<th  bgcolor="#0099FF" scope="col">' . $r . '</th>';
		}
		echo '<th  bgcolor="#0099FF"  scope="col">Carr</th>';
	endif;

	echo '<th  scope="col">Origen</th>';
	echo '<th  scope="col">Nom/Fax/Bol</th>';
	echo '<th  scope="col">Premio </th>';
	if ($row_r['Formato'] == 5) :
		echo '<th  scope="col">Premio</th>';
	else :
		echo '<th  scope="col">Total Pagado</th>';
		echo '<th  scope="col">Precio</th>';
	endif;
	echo '</tr>';

	$iii = 1;
	$un = 1;
	while ($row = mysqli_fetch_array($result)) {

		$cobra = array();
		if ($un == 1) :
			$bk = '#D3DCE6';
			$un = 2;
		else :
			$bk = '#999999';
			$un = 1;
		endif;
		$cobra[0] = 0;
		$en = '';
		$tl = '1';
		$vl = '';
		$en = '';
		$img = 'media/estrella.png';
		$rim = 'media/impresora.png';
		if ($row['Anulado'] == 1 || $row['Anulado'] == 3) :
			switch ($row['Anulado']) {
				case 1:
				case 4:
					$tl = '0';
					$bk = '#FFCC33';
					$vl = 'checked';
					$img = 'media/estrellaout.gif';
					$rim = 'media/tray_down.ico';
					break;
				case 3:
					$tl = '0';
					$bk = '#FFCC33';
					$vl = 'checked';
					$img = 'media/tray_err.ico';
					$rim = 'media/lock.png';
					$en = 'disabled="disabled"';
					break;
			}

		else :
			if ($row_r['Formato'] == 5) :
				$cobra = escrutetablas($row["Serial"]);
				if ($cobra[0] != 0) : $bk = '#4179E0';
				endif;
			endif;
		endif;
		if ($row_r['Formato'] == 0) :
			$result5 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrehi  where  IDCN=" . $row['IDCN'] . " and  ct=" . $row["carr"]);
		else :
			$result5 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrehi  where  IDCN=" . $row['IDCN'] . " and IDJug=" . $row['IDJug'] . " and  ct=" . $row["carr"]);
		endif;

		if (mysqli_num_rows($result5) != 0) :
			$img = 'media/lock.png';
			if ($row_r['Tandas'] == 2 || $row_r['Formato'] == 2) :
				while ($row3 = mysqli_fetch_array($result5)) {
					if ($row["carr"] == $row3['ct']) :
						$en = 'disabled="disabled"';
						break;
					endif;
				}
			else :
				$en = 'disabled="disabled"';
			endif;
		endif;
		/*if ($modo==2 ):
					 $rim='';
				 endif;*/
		$premacion = EscrutarHI($row["Serial"], 1);
		if ($premacion[1] > 0) : $bk = '#4179E0';
		endif;
		if ($premacion[1] < 0) :
			$tl = '0';
			$bk = '#FFCC33';
			$vl = 'checked';
			$img = 'media/estrellaout.gif';
			$rim = 'media/tray_down.ico';
			$result_RESTORE = mysqli_query($GLOBALS['link'], "Select * from _tjugadahi where Serial=" . $row["Serial"]);
			$row = mysqli_fetch_array($result_RESTORE);
		endif;
		if ($row_r['Formato'] != 0) :
			if ($premacion[3]) :
				$result_RESTORE = mysqli_query($GLOBALS['link'], "Select * from  _tjugadahi  where Serial=" . $row['Serial']);
				$row_Rest = mysqli_fetch_array($result_RESTORE);
				if ($row_Rest['Anulado'] == 3 || $row_Rest['Anulado'] == 1) :
					$tl = '0';
					$bk = '#FFCC33';
					$vl = 'checked';
					$img = 'media/estrellaout.gif';
					$rim = 'media/tray_down.ico';
				endif;
			endif;
		endif;
		//echo "SELECT * FROM _cierre  where  IDCN=".$row['IDCN']." and IDJug=".$row['IDJug']; RImprimirTicket(_serial)
		echo " <tr id='f" . $row["Serial"] . "' title='" . $tl . "' bgcolor='" . $bk . "'  >";
		echo "<th ><img id='im" . $row["Serial"] . "' src='" . $img . "' width='15' /><img  src='" . $rim . "' width='15' onclick='RImprimirTicket(" . $row["Serial"] . ");' /><a id='" . $iii . "' lang='" . $row["Serial"] . "' name='' ></a><input id='i" . $row["Serial"] . "' type='checkbox' value='' title='" . $row["Serial"] . "'  " . $vl . " onclick='incluirlista(event);' " . $en . " ></th>";
		echo "<th><span lang='Serial:" . $row["Serial"] . "<br>Consecionario:" . $row["IDC"] . "<br>Estatus: " . ($row["Anulado"] == 1 ? "Anulado" : "Activo") . '' . ($en != '' ? " JUG.CERRADA" : '') . "' >" . $row["Serial"] . "</span></th>";
		if (isset($serial)) :
			echo '<th  scope="col">' . $row["IDC"] . '</th>';
			echo '<th  scope="col">' . $descrip . '</th>';
		endif;
		echo "<th>" . $row["Fecha"] . "</th>";
		echo "<th>" . $row["Hora"] . "</th>";
		//.$row["Jugada"]."</td>";
		//echo "<tr>";
		if ($row_r['Formato'] == 5) :
			$kj = explode("|", $row["Jugada"]);
			$g = 1;
			for ($t = 1; $t <= 14; $t++) {
				$kj1 = explode("*", $kj[$g]);
				if ($kj1[0] == $t) :
					$kj2 = explode("-", $kj1[1]);
					if ($cobra[1] == $t) :
						echo "<th style='background: #FF3300; '><span >" . $kj2[0] . "</span></th>";
					else :
						echo "<th>" . $kj2[0] . "</th>";
					endif;
					$g++;
				else :
					echo "<th></th>";
				endif;
			}
			echo '<th  >' . $row["carr"] . '</th>';
		else :

			$kj = explode("|", $row["Jugada"]);

			if ($idj == 0) :

				$c = 0;
				$espacio = '50';
				for ($t = 0; $t <= 13; $t++) {
					if ($t <= (count($kj) - 1)) :
						$kj2 = explode("-", $kj[$t]);
						for ($g = 0; $g <= 2; $g++) {
							if (intval($kj2[$g]) != 0) :
								echo "<th  align='right' style='background: " . $arreglocolor[$c] . ";width:" . $espacio . "px; text-align:right  '><span  style='color: #FFFFFF; font-size:16px'><strong>" . trim($kj2[$g]) . "</strong></span></th>";
							else :
								echo "<th  style='background: " . $arreglocolor[$c] . "; width:" . $espacio . "px '>&nbsp;&nbsp;&nbsp;&nbsp;</th>";
							endif;
						}
					else :
						echo "<th style='background:" . $arreglocolor[$c] . ";width:" . $espacio . "px  '>&nbsp;&nbsp;&nbsp;&nbsp;</th><th style='background: " . $arreglocolor[$c] . ";width:" . $espacio . "px  '>&nbsp;&nbsp;&nbsp;&nbsp;</th><th style='background: " . $arreglocolor[$c] . ";width:" . $espacio . "px  '>&nbsp;&nbsp;&nbsp;&nbsp;</th>";
					endif;
					if ($c == 0) : $c = 1;
					else : $c = 0;
					endif;
				}


				echo '<th  scope="col" >' . $row["carr"] . '</th>';

			else :
				for ($t = 1; $t <= count($kj) - 1; $t++) {
					echo "<th>" . $kj[$t] . "</th>";
				}

				// if ($row_r['Tandas']==2 || $row_r['Formato']==2):
				echo '<th  scope="col" >' . $row["carr"] . '</th>';
			//endif;
			endif;

		endif;
		switch ($row['org']) {
			case 1:
				$orig = 'Tel';
				$ms = $row['nom'];
				break;
			case 2:
				$orig = 'Bol';
				$ms = $row['nom'];
				break;
			case 3:
				$orig = 'Fax';
				$ms = $row['nom'];
				break;
			case 4:
				$orig = 'Onl';
				$ms = 'Online';
				break;
			default:
				$orig = 'Onl';
				$ms = 'Online';
				break;
		}
		echo '<th  >' . $orig . '</th>';
		echo '<th  >' . $ms . '</th>';
		if ($row_r['Formato'] == 5) :
			if ($row["Valor_R"] == 0) :
				$preciopagadoxboleto = calculo_tablasencero($row['Jugada']);
				if ($row['Anulado'] != 1) :	 $totalventas += $preciopagadoxboleto;
				endif;
				echo "<th>" . number_format($preciopagadoxboleto, 2, ',', '.') . "</th>";
			else :
				if ($row['Anulado'] != 1) :	$totalventas += $row["Valor_R"];
				endif;
				echo "<th>" . number_format($row["Valor_R"], 2, ',', '.') . "</th>";
			endif;
		else :
			if ($premacion[1] > 0) :
				echo "<th>" . number_format($premacion[1], 2, ',', '.') . "</th>"; /////<--- Coloco el PREMIO
			else :
				echo "<th>0</th>";
			endif;
		endif;

		if ($row_r['Formato'] == 5) :
			if ($row['Anulado'] != 1) : $totalpremios += $cobra[0];
			endif;
			echo "<th>" . number_format($cobra[0], 2, ',', '.') . "</th>";
		else :
			echo "<th>" . number_format($row["Valor_J"], 2, ',', '.') . "</th>";
			echo "<th>" . number_format($row["Valor_R"], 2, ',', '.') . "</th>";
		endif;

		echo "</tr>";
		$iii++;
	}
	if ($row_r['Formato'] == 5) :
		echo '<tr  bgcolor="#006699">';
		echo '<th></th>';
		echo '<th></th>';
		echo '<th></th>';
		echo '<th></th>';
		for ($r = 1; $r <= 14; $r++) {
			echo '<th></th>';
		}
		echo '<th></th>';
		echo '<th></th>';
		echo '<th><div style="color:#FFFFFF">TOTAL VENTAS</div></th>';
		echo '<th><div style="color:#FFFFFF">' . number_format($totalventas, 2, ',', '.') . '</div></th>';
		echo '<th><div style="color:#FFFFFF">' . number_format($totalpremios, 2, ',', '.') . '</div></th>';
		echo "</tr>";
	endif;
	echo "<a id='cot' lang='" . ($iii - 1) . "'  ></a>";
else :
	echo '<p  align="center" style="color:#FFFFFF; font-size:16px; " ><blink>NO HAY INFORMACION</blink></p>';
endif;
echo '</table>';

?>