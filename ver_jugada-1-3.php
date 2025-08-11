<style type="text/css">
	.tip3 {
		color: #3366FF;
		border-bottom: 1px dashed #FFFF33;
	}
</style>
<?

if (isset($serial)) :
	$result_search = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugada where serial=" . $serial);
	$rowsearch = mysqli_fetch_array($result_search);
	$idj = $rowsearch['IDJug'];
	$idcn = $rowsearch['IDCN'];
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugada where serial=" . $serial);
else :
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugada where IDC='" . $conse1 . "' and IDCN=" . $idcn . " and IDJug=" . $idj);
endif;



if (mysqli_num_rows($result) != 0) :

	$resultdivi = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where  idcn=" . $idcn);
	$rowdivi = mysqli_fetch_array($resultdivi);
	$divi = $rowdivi['Macuare'];

	$result_r = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where IDJug=" . $idj);
	$row_r = mysqli_fetch_array($result_r);
	echo '<table  id="mnu"  border="0" >';
	echo '<tr  bgcolor="#999999">';
	echo '<th  scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>';
	echo '<th  scope="col">Serial </th>';
	if (isset($serial)) :
		echo '<th  scope="col">Consec.</th>';
		echo '<th  scope="col">Jugada</th>';
	endif;
	echo '<th  scope="col">Fecha</th>';
	echo '<th  scope="col">Hora</th>';
	if ($row_r['Formato'] != 5) :
		if ($row_r['CantidadCarr'] <= 6) :
			for ($r = 1; $r <= $row_r['CantidadCarr']; $r++) {
				echo '<th  bgcolor="#0099FF" scope="col">Valida ' . $r . '</th>';
			}
		else :
			echo '<th  bgcolor="#0099FF"  scope="col">Validas</th>';
		endif;

		if ($row_r['Tandas'] == 2) :
			echo '<th  bgcolor="#0099FF"  scope="col">Tanda</th>';
		else :
			if ($row_r['Formato'] == 2) :
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
	echo '<th  scope="col">Precio </th>';
	echo '<th  scope="col">Premio</th>';
	echo '</tr>';

	$iii = 1;
	$un = 1;
	while ($row = mysqli_fetch_array($result)) {
		if ($un == 1) :
			$bk = '#D3DCE6';
			$un = 2;
		else :
			$bk = '#999999';
			$un = 1;
		endif;

		$tl = '1';
		$vl = '';
		$en = '';
		$img = 'media/estrella.png';
		$rim = 'media/impresora.png';
		if ($row['Anulado'] == 1) :
			$tl = '0';
			$bk = '#FFCC33';
			$vl = 'checked';
			$img = 'media/estrellaout.gif';
			$rim = '';
		endif;

		$result5 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierre  where  IDCN=" . $row['IDCN'] . " and IDJug=" . $row['IDJug']);
		$en = '';
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
		if ($modo == 2) :
			$rim = '';
		endif;
		/* Verifico si esta premiado */
		$arrayes = poolescrute($row['Serial']);
		$atp = contarenblanco($arrayes, 5);

		if ($atp == $totaldeb) :
			$premios = ($row['Valor_J'] * $divi);
		else :
			$premios = 0;
		endif;
		/******************************/
		if ($premios != 0) :
			echo " <tr id='f" . $row["Serial"] . "' title='" . $tl . "'   style='background: #FF0 ; color:#FFF'  >";
		else :
			echo " <tr id='f" . $row["Serial"] . "' title='" . $tl . "' bgcolor='" . $bk . "'  >";
		endif;
		if ($premios != 0) :
			echo "<th ><img id='im" . $row["Serial"] . "' src='" . $img . "' width='15' /><img  src='" . $rim . "' width='15' onclick='_reimpresiondl(" . $row["Serial"] . ");' /><a id='" . $iii . "' lang='" . $row["Serial"] . "' name='' ></a><img src='media/estrella.png' width='16' height='16' /></th>";
		else :
			echo "<th ><img id='im" . $row["Serial"] . "' src='" . $img . "' width='15' /><img  src='" . $rim . "' width='15' onclick='_reimpresiondl(" . $row["Serial"] . ");' /><a id='" . $iii . "' lang='" . $row["Serial"] . "' name='' ></a><input id='i" . $row["Serial"] . "' type='checkbox' value='' title='" . $row["Serial"] . "'  " . $vl . " onclick='incluirlista(event);' " . $en . " ></th>";
		endif;
		echo "<th><span class='tip3' lang='Serial:" . $row["Serial"] . "<br>Consecionario:" . $row["IDC"] . "<br>Estatus: " . ($row["Anulado"] == 1 ? "Anulado" : "Activo") . '' . ($en != '' ? " JUG.CERRADA" : '') . "' >" . $row["Serial"] . "</span></th>";
		if (isset($serial)) :
			echo '<th  scope="col">' . $row["IDC"] . '</th>';
			echo '<th  scope="col">' . $row_r["Descrip"] . '</th>';
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
					echo "<th>" . $kj2[0] . "</th>";
					$g++;
				else :
					echo "<th></th>";
				endif;
			}
			echo '<th  >' . $row["carr"] . '</th>';
		else :
			$kj = explode("|", $row["Jugada"]);
			if ($row_r['CantidadCarr'] <= 6) :
				for ($t = 1; $t <= count($kj) - 1; $t++) {
					echo "<th>" . $kj[$t] . "</th>";
				}
			else :
				echo "<th>";
				for ($t = 1; $t <= count($kj) - 1; $t++) {
					echo $t . ")  " . $kj[$t] . "<br>";
				}
				echo "</th>";
			endif;
			if ($row_r['Tandas'] == 2 || $row_r['Formato'] == 2) :
				echo '<th  scope="col" >' . $row["carr"] . '</th>';
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
		echo "<th>" . number_format($row["Valor_J"], 2, ',', '.') . "</th>";



		echo "<th>" . number_format($premios, 2, ',', '.') . "</th>";

		echo "</tr>";
		$iii++;
	}
	echo "<a id='cot' lang='" . ($iii - 1) . "'  ></a>";
else :
	echo '<p  align="center" style="color:#FFFFFF; font-size:16px; " ><blink>NO HAY INFORMACION</blink></p>';
endif;
echo '</table>';

?>