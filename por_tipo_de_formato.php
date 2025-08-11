<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$op = $_REQUEST['op'];
$fdg = $_REQUEST['fdg'];
$iddd = $_REQUEST['iddd'];
switch ($op) {
	case 1:

		$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where IDDD=" . $iddd);
		if (mysqli_num_rows($resultj) != 0) :
			$Row = mysqli_fetch_array($resultj);
			$cb = $Row['noCombinar'];
		else :
			$cb = '';
		endif;

		$resultj = mysqli_query($GLOBALS['link'], "SELECT _tbjuegodd.*,_gruposdd.imagen,_gruposdd.descripcion as Desjuego,_formatosbb.descripcion as Desform FROM _tbjuegodd,_gruposdd,_formatosbb where _tbjuegodd.Grupo=_gruposdd.Grupo and _tbjuegodd.Formato=_formatosbb.Formato and _formatosbb.Grupo=" . $fdg);
		$j = 1;
		$dm = explode('|', $cb);
		while ($Row = mysqli_fetch_array($resultj)) {
			$key = array_search($j, $dm);
			$tea = 'checked';
			if ($key === false) :
				$tea = '';
			endif;
			echo	'<input type="checkbox"  id="io' . $j . '" onclick="combina_click();" ' . $tea . '/>' . $Row['Descripcion'] . '(' . $Row['Desform'] . ')';
			echo '<br>';
			$j++;
		}
		echo '<samp  id="tdc_c" lang="' . $j . '" style="display:none">';
		echo '<samp  id="noCombinar" lang="' . $cb . '" style="display:none">';
		break;

	case 2:

		$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where IDDD=" . $iddd);
		if (mysqli_num_rows($resultj) != 0) :
			$Row = mysqli_fetch_array($resultj);
			$ops1 = $Row['Formato'];
		else :
			$ops1 = 0;
		endif;

		echo '<select name="Formato" id="Formato" >';
		$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _formatosbb where Grupo=" . $fdg . " Order by formato ");
		while ($row = mysqli_fetch_array($resultj)) {
			if ($ops1 == $row['Formato']) :
				$secc = 'selected="selected"';
			else :
				$secc = '';
			endif;
			echo "<option  value=" . $row["Formato"] . " " . $secc . " >" . $row["Descripcion"] . "</option>";
		}
		echo '</select>';
		break;
}
