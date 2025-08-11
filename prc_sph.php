<?php
function restricjugadasph($monto, $idcn)
{

	$result = mysqli_query($GLOBALS['link'], 'SELECT count(serial) as c, jugada, sum(valor_j) as mt FROM _tjugada where IDCN=' . $idcn . ' and IDJug=4 and Anulado=0 group by jugada order by  c desc');
	$arr = array();
	$arr[0] = false;
	if (mysqli_num_rows($result) != 0) :

		while ($row = mysqli_fetch_array($result)) {
			if ($row['mt'] >= $monto) :
				$jud = $row['jugada'];
				$arr[0] = true;
				$arr[1] = number_format($row['mt'], 2,  ',', '.');
				$arr[2] = $jud;
				$i = 3;
				$result2 = mysqli_query($GLOBALS['link'], "SELECT serial FROM _tjugada where jugada='" . $jud . "' and IDCN=" . $idcn . " and  IDJug=4 and Anulado=0 ");
				while ($row2 = mysqli_fetch_array($result2)) {
					$arr[$i] = $row2['serial'];
					$i++;
				}
				break;
			endif;
		}
	endif;
	return ($arr);
}

function restricjugadasph2($monto, $idcn, $jugada, $idc, $idj)
{
	$arr = array(false, -1);
	$result = mysqli_query($GLOBALS['link'], 'Select * from  _tbbloquecmb where IDJ=' . $idj . ' and IDCN=' . $idcn . ' and jugada="' . $jugada . '"');
	if (mysqli_num_rows($result) == 0) :

		$result = mysqli_query($GLOBALS['link'], 'SELECT sum(valor_j) as mt FROM _tjugada where IDC="' . $idc . '" and IDCN=' . $idcn . ' and IDJug=' . $idj . ' and Anulado=0 and jugada="' . $jugada . '"');
		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbrestricionessph where IDC='" . $idc . "'  and IDJ=" . $idj);
			if (mysqli_num_rows($result2) != 0) :
				$row2 = mysqli_fetch_array($result2);
				$arr[0] = true;
				$arr[1] = $row2['mmxj'] - $row['mt'];
			endif;
		else :
			$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbrestricionessph where IDC='" . $idc . "'  and IDJ=" . $idj);
			echo "SELECT * FROM _tbrestricionessph where IDC='" . $idc . "'  and IDJ=" . $idj;
			if (mysqli_num_rows($result2) != 0) :
				$row2 = mysqli_fetch_array($result2);
				$arr[0] = true;
				$arr[1] = $row2['mmxj'];
			endif;

		endif;

	else :
		$arr = array(true, 0);
	endif;
	return ($arr);
}


function restricjugadasph3($monto, $idcn, $jugada, $idc, $idj)
{
	$arr = array(false, -1);
	$result = mysqli_query($GLOBALS['link'], 'Select * from  _tbbloquecmb where IDJ=' . $idj . ' and IDCN=' . $idcn . ' and jugada="' . $jugada . '"');
	if (mysqli_num_rows($result) == 0) :

		$result = mysqli_query($GLOBALS['link'], 'Select * from  _tconsecionario where IDC="' . $idc . '"');
		$row = mysqli_fetch_array($result);
		$IDG = $row['IDG'];

		$result = mysqli_query($GLOBALS['link'], 'SELECT sum(valor_j) as mt FROM _tjugada where  IDCN=' . $idcn . ' and IDJug=' . $idj . ' and jugada="' . $jugada . '" and Anulado=0 and IDC in (Select IDC From _tconsecionario where IDG=' . $IDG . ')');
		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			$result2 = mysqli_query($GLOBALS['link'], 'SELECT * FROM _tbrestriccionbygrupo where IDG=' . $IDG);
			if (mysqli_num_rows($result2) != 0) :
				$row2 = mysqli_fetch_array($result2);
				$arr[0] = true;
				$arr[1] = $row2['MaximoCupo'] - $row['mt'];
			endif;
		else :
			$result2 = mysqli_query($GLOBALS['link'], 'SELECT * FROM _tbrestriccionbygrupo where IDG=' . $IDG);
			if (mysqli_num_rows($result2) != 0) :
				$row2 = mysqli_fetch_array($result2);
				$arr[0] = true;
				$arr[1] = $row2['MaximoCupo'];
			endif;
		endif;

	else :
		$arr = array(true, 0);
	endif;
	return ($arr);
}
