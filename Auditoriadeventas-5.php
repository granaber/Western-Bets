<?

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$verparametros1 = explode('|', $_REQUEST['param']);
$IDJ = $_REQUEST['IDJ'];

$jug = array();

//142-34%|-600*156-34%|-330*173-39%|-450*print_r($verparametros1);	

for ($i = 0; $i <= count($verparametros1) - 1; $i++) {
	$datos = explode('-', $verparametros1[$i]);
	switch ($datos[0]) {
		case 'e':
			$jug[$i] = equipo($IDJ, $datos[2], $datos[1]) . '-0%|Equipos';
			break;
		case 'j':
			$jug[$i] = equipo2($IDJ, $datos[2]) . '-' . $datos[1] . '%|';
			break;
	}
}


echo json_encode(array($jug, RestruAudi($jug, $IDJ)));

function equipo($IDJ, $RowId, $NumEqui)
{
	$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _partidosbb  where IDJ=$IDJ and IDP=$RowId");
	$row2 = mysqli_fetch_array($result2);
	switch ($NumEqui) {
		case 1:
			$equi = $row2['IDE1'];
			break;
		case 2:
			$equi = $row2['IDE2'];
			break;
	}
	return $equi;
}

function equipo2($IDJ, $RowId)
{
	$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _partidosbb  where IDJ=$IDJ and IDP=$RowId");
	$row2 = mysqli_fetch_array($result2);
	$equi = $row2['IDE1'] . 'y' . $row2['IDE2'];
	return $equi;
}

function RestruAudi($jgdad, $IDJ)
{
	$colores = array('#069', '#900', '#C90', '#FC0', '#906', '#FF0', '#6F0', '#333', '#699', '#030', '#366', '#F69', '#636', '#03C', '#F06', '#660', '#F9F', '#930', '#300', '#000');

	for ($u = 0; $u <= count($jgdad) - 1; $u++) {

		$opcion = explode('|', $jgdad[$u]);
		$logro = $opcion[1];
		$opcion1 = explode('%', $opcion[0]);
		$carr = $opcion1[1];
		$opcion2 = explode('-', $opcion1[0]);
		$equi = $opcion2[0];
		$iddd = $opcion2[1];
		$code = '';

		$vequipo = explode('y', $equi);

		for ($i = 0; $i <= count($vequipo) - 1; $i++) {
			$result1 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $vequipo[$i]);
			$row1 = mysqli_fetch_array($result1);

			if (count($vequipo) > 1) :
				if ($i == 0) :
					$code .= htmlentities($row1['Descripcion']) . ' y ';
				else :
					$code .= htmlentities($row1['Descripcion']);
				endif;
			else :
				$code = htmlentities($row1['Descripcion']);
			endif;
		}
		if ($iddd != 0) :
			$result3 = mysqli_query($GLOBALS['link'], "Select * From _tbjuegodd Where IDDD=" . $iddd);
			$row3 = mysqli_fetch_array($result3);

			if ($row2['IDE1'] == $equi) :	$y = 0;
			endif;
			if ($row2['IDE2'] == $equi) :	 $y = 1;
			endif;
			$cln = explode('|', $row3['AddTicket']);
			if (count($cln) == 1) :
				$valoaad = $row3['AddTicket'];
			else :
				$valoaad = $cln[$y];
			endif;
		else :
			$valoaad = 'TODAS AP';
		endif;

		$result2 = mysqli_query($GLOBALS['link'], "Select * From _partidosbb Where (IDE1=" . $vequipo[0] . " or IDE2=" . $vequipo[0] . ") and IDJ=$IDJ");
		$row2 = mysqli_fetch_array($result2);

		if ($u <= count($colores)) :
			$ColoKK = $colores[$u];
		else :
			$ColoKK = $colores[0];
		endif;

		$Lineaticket[$u] = $u . '|' . convertirhora($row2['Hora']) . '|' . $code . '  ' . $valoaad . '|<samp style="background:' . $ColoKK . '">&nbsp;&nbsp;</samp>';
	}


	return ($Lineaticket);
}
