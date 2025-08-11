<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _uologro where time>='1397596425'");
while ($row = mysqli_fetch_array($result)) {
	$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd  where  IDDD=" . $row['iddd']);
	$row4 = mysqli_fetch_array($result3);
	$resultact = mysqli_query($GLOBALS['link'], "SELECT * FROM `_configuracionjugadabb` where IDDD=" . $row['iddd'] . ' and idj=' . $row['idj'] . ' and idp=' . $row['ln'] . ' and IDB=3');
	$rowact = mysqli_fetch_array($resultact);
	$valoresdd = explode('|', $rowact['Valores']);
	$vdlo = '';
	$vdy = '';
	$dex = '';
	$vdy2 = '';
	$dex2 = '';
	$nuevoLogro = 0;
	$idCnv = 1;

	$key = strpos($row4['Columnas'], 'Ax');
	if ($key === false) : $eAB = false;
	else : $eAB = true;
	endif;

	if ($nuevoLogro == 0) :
		switch (count($valoresdd)) {

			case 3:
				if ($valoresdd[1] < 0 && $valoresdd[0] < 0) :
					if ($valoresdd[0] < $valoresdd[1]) :
						$LogroM = $valoresdd[0];
						$macho = 0;
					else :
						$LogroM = $valoresdd[1];
						$macho = 1;
					endif;

				else :
					if ($valoresdd[1] < 0) :
						$LogroM = $valoresdd[1];
						$macho = 1;
					else :
						$LogroM = $valoresdd[0];
						$macho = 0;
					endif;
				endif;
				$modo = 3;
				break;

			case 5:
				//-130|1.5|110|-1.5|
				if ($valoresdd[2] < 0 && $valoresdd[0] < 0) :
					if ($valoresdd[0] < $valoresdd[2]) :
						$LogroM = $valoresdd[0];
						$macho = 0;
					else :
						$LogroM = $valoresdd[2];
						$macho = 2;
					endif;
				else :
					if ($valoresdd[2] < 0) :
						$LogroM = $valoresdd[2];
						$macho = 2;
					else :
						$LogroM = $valoresdd[0];
						$macho = 0;
					endif;
				endif;
				$modo = 5;
				break;
		}
		$arrayNOdds = DBconver($idCnv, $LogroM, $modo, $macho, $eAB);
	/*if ($eAB):
					echo $LogroM;
					print_r($arrayNOdds);
					endif;*/
	endif;

	for ($ii = 0; $ii <= count($valoresdd) - 2; $ii++) {
		$valorss = $valoresdd[$ii];
		$lgo = $valoresdd[$ii];
		$subcol = explode('-', $col[$ii]);
		$pos = strpos($subcol[1], 'car');
		if ($pos === false) :
			if (abs($valorss) <= 99) :
				$valordysplay = $valorss;
				$r = fmod($valoresdd[$ii], 1);
			else :
				$valordysplay = $valorss / 10;
				$r = fmod($valoresdd[$ii], 10);
			endif;
		else :
			$valordysplay = $valorss;
			$valorREAL = $valorss;
			$r = fmod($valoresdd[$ii], 1);
		endif;

		if ($r != 0) :
			if ($valorss < 0) :
				$valordysplay = $valordysplay + .5;
				if ($valordysplay == 0) : $valordysplay = '-';
				endif;
			else :
				$valordysplay = ($valordysplay - .5);
			endif;
			$valordysplay = $valordysplay . "&frac12;";
		endif;
		$anexo = '';
		if ($valorss > 0) :
			$anexo = '+';
		endif;
		$valordysplay = $anexo . $valordysplay;
		$valorsss = $valordysplay;
		$stl = true;
		if (count($subcol) == 1) :
			$nomc = $col[$ii];
		else :
			if ($pos == 0) :
				$stl = false;
			endif;
			$nomc = $subcol[1];
		endif;

		if ($stl) :


			if ($IDB == 3) :


				if ($arrayNOdds[$nuevoLogro] == 0) :
					$nuevoLogro++;
					$vdy .= $arrayNOdds[$nuevoLogro] . '%';
					$vdlo .= $arrayNOdds[$nuevoLogro] . '%';
				else :
					$vdy .= $arrayNOdds[$nuevoLogro] . '%';
					$vdlo .= $arrayNOdds[$nuevoLogro] . '%';
					$nuevoLogro++;
				endif;



			else :
				$vdlo = $vdlo . $lgo . '%';
				$vdy = $vdy . $valordysplay . '%';
			endif;




		else :
			$dex = $dex . $row4['AddTicket'] . '|' . $valordysplay . '%';
			$vdy2 = $vdy2 . $valordysplay . '%';
			$dex2 = $dex2 . $valorREAL . '%';
		endif;
	}

	$arr = array($vdy, $vdlo, $vdy2, $dex, $row['actualizado'], $dex2);
	echo json_encode($arr);
}
