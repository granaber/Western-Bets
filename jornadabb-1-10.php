<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$idc = $_REQUEST['idc'];
$fc = $_REQUEST['fc'];
$eqs = $_REQUEST['eq'];
$hrs = $_REQUEST['hr'];
$cant = $_REQUEST['cant'];
$part = explode('/', $_REQUEST["lista"]);
$equiDB = $_REQUEST['equiDB'];
$p = $_REQUEST['p'];
$gp = $_REQUEST['gp'];
$e = $_REQUEST['e'];
$dp = $_REQUEST['dp'];
$Liga = $_REQUEST['liga'] ?? 0;
$IDB = $_REQUEST['IDB'];
$np = explode('|', $_REQUEST['np']);
$ep = explode("|", $p);
$egp = explode("|", $gp);
$ee = explode("|", $e);
$eq = explode("|", $eqs);
$hr = explode("|", $hrs);

$IDEerrores = array();

/// Codigo de Equipo Iguales ///


for ($j = 0; $j <= $cant - 1; $j++) {
	$idp = $j + 1;
	$eq1[] = $eq[$j];
	$eq2[] = $eq[$j + $cant];
}
$result2 = array_intersect($eq1, $eq2);
foreach ($result2 as $Key => $Valoresi)
	if (isset($result2[$Key])) : $IDEerrores[] = 'E|' . $result2[$Key] . '|' . $Key;
	endif;

$result2 = array();

$result1 = array_intersect($eq2, $eq1);
foreach ($result1 as $Key => $Valoresx)
	if (isset($result1[$Key])) : $IDEerrores[] = 'E|' . $result1[$Key] . '|' . $Key;
	endif;


$eq2 = array_pop($eq);
for ($j = 0; $j <= count($eq) - 1; $j++) {
	$candidato = $eq[$j];
	$clave = array_search($candidato, $eq);
	if ($clave !== false) {
		if ($clave != $j) {
			if ($clave >= $cant - 1) $clave = $clave - ($cant - 1);
			$IDEerrores[] = 'E|' . $candidato . '|' . $clave;
		}
	}
}
$logros = array();
for ($j = 0; $j <= $cant - 1; $j++) {

	$idp = $j + 1;
	$valores = explode('*', $part[$j]);

	for ($y = 0; $y <= count($valores) - 1; $y++) {
		$subg = explode('[', $valores[$y]);
		$IDDD = $subg[0];
		$logros[$j][$IDDD] = $subg[1];
	}
}

for ($j = 0; $j <= $cant - 1; $j++) {

	$Campos = $logros[$j];

	foreach ($Campos as $Key => $Valoresi) {
		$TodoOK = true;
		$aLogros = iDeflateLog($Valoresi, 1);
		for ($i = 0; $i <= count($aLogros) - 1; $i++) {
			if (trim($aLogros[$i]) !== '' && trim($aLogros[$i]) !== '0') :
				if (!iLogrosCkeck($aLogros[$i])) :
					$IDEerrores[] = '1|' . $aLogros[$i] . '|' . $j . '|' . $Key;
					$TodoOK = false;
				endif;
			endif;
		}


		if ($TodoOK) :
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbvalidarlogros where  IDDD=" . $Key);
			if (mysqli_num_rows($result) != 0) :
				$row = mysqli_fetch_array($result);
				switch ($row['op']) {
					case 1:
						$aLogros = iDeflateLog($Valoresi, 1);

						if (!OpcionUno($aLogros[0], $aLogros[1], $row['EVE'])) :
							$IDEerrores[] = '2|' . $aLogros[0] . '&' . $aLogros[1] . '|' . $j . '|' . $Key;
						endif;

						break;
					case 2:
						$aLogros = iDeflateLog($Valoresi, 2);
						$aLogros1 = iDeflateLog($Campos[$row['IDDDcmp']], 1);
						if (!OpcionDos(trim($aLogros1[0]), trim($aLogros1[1]), trim($aLogros[0]), trim($aLogros[1]))) :
							$IDEerrores[] = '3|' . $aLogros[0] . '&' . $aLogros[1] . '|' . $j . '|' . $Key;
						endif;
						break;

					case 6:
						$aLogros = explode('|', $Valoresi);
						//$aLogros1=iDeflateLog( $Campos[$row['IDDDcmp']] ,1 ); 
						//print_r($aLogros);
						if (!OpcionTres(trim($aLogros[0]), trim($aLogros[2]), trim($aLogros[1]), trim($aLogros[3]))) :
							$IDEerrores[] = '6|' . $aLogros[0] . '&' . $aLogros[1] . '|' . $j . '|' . $Key;
						endif;
						break;

					case 4:

						if (empty($row['rangoLogro']) && $row['rangoLogro'] != '0|0') :
							$aLogros = iDeflateLog($Valoresi, 1);
							$rango = explode('|', $row['rangoLogro']);
							for ($i = 0; $i <= count($aLogros) - 1; $i++) {
								if (!empty($aLogros[$i])) :
									if (!iRango($rango[0], $rango[1], $aLogros[$i])) :
										$IDEerrores[] = '4|' . $aLogros[0] . '&' . $aLogros[1] . '|' . $j . '|' . $Key . '|1';
									endif;
								endif;
							}
						endif;

						if ($row['rangoCarrera'] != '' && $row['rangoCarrera'] != '0|0') :
							$aLogros = iDeflateLog($Valoresi, 2);
							$rango = explode('|', $row['rangoCarrera']);
							for ($i = 0; $i <= count($aLogros) - 1; $i++) {
								if (!iRango($rango[0], $rango[1], $aLogros[$i])) :
									$IDEerrores[] = '4|' . $aLogros[0] . '&' . $aLogros[1] . '|' . $j . '|' . $Key . '|2';
								endif;
							}
						endif;

						break;

					case 5:
						$aLogros = iDeflateLog($Valoresi, 1);
						$aLogros1 = iDeflateLog($Campos[$row['IDDDcmp']], 1);
						for ($i = 0; $i <= count($aLogros) - 1; $i++) {
							if (!iCompare($aLogros[$i], $aLogros1[$i])) :
								$IDEerrores[] = '5|' . $aLogros[$i] . '&' . $aLogros1[$i] . '|' . $j . '|' . $Key . '-' . $row['IDDDcmp'];
							endif;
						}
						break;
				}



			//	print_r($aLogros); 		echo $j.'<br>';	
			endif;
		endif;
	}
}



echo json_encode($IDEerrores);

function iDeflateLog($Valores, $tipo)
{


	$Verlogros = explode('|', $Valores);
	$cuantoslogros = count($Verlogros) - 1;
	switch ($cuantoslogros) {
		case 1:
			$logro1 = $Verlogros[0];
			$logro2 = 0;
			break;
		case 2:
			$logro1 = $Verlogros[0];
			$logro2 = $Verlogros[1];
			break;
		case 4:
			$logro1 = $Verlogros[0];
			$car1 = $Verlogros[1];
			$logro2 = $Verlogros[2];
			$car2 = $Verlogros[3];
			break;
	}

	if ($tipo == 1) :
		$Respuesta[0] = $logro1;
		$Respuesta[1] = $logro2;
	else :
		$Respuesta[0] = $car1;
		$Respuesta[1] = $car2;
	endif;

	return $Respuesta;
}
function OpcionUno($logro1, $logro2, $EVE)
{
	if ($logro1 > 0 && $logro2 > 0) :
		if ($logro1 == $EVE && $logro2 == $EVE) :
			$respuesta = true;
		else :
			$respuesta = false;
		endif;
	else :
		$respuesta = true;
	endif;

	return $respuesta;
}
function OpcionDos($logro1, $logro2, $carreras1, $carreras2)
{
	if (empty($logro1) && empty($logro2)) :
		return true;
	else :
		if (empty($carreras1) && empty($carreras2)) :
			return true;
		else :
			if (($carreras1 > 0 && $carreras2 < 0) || ($carreras1 < 0 && $carreras2 > 0)) :
				if ($logro1 !== $logro2) :
					if ($logro1 > 0  &&  $logro2  < 0) :
						if ($carreras1 > 0  &&  $carreras2 < 0) : $respuesta = true;
						else :  $respuesta = false;
						endif;
					else :
						if ($carreras1 < 0  &&  $carreras2  > 0) : $respuesta = true;
						else :  $respuesta = false;
						endif;
					endif;
				else :
					if ($carreras1 != $carreras2) : $respuesta = true;
					else :  $respuesta = false;
					endif;
				endif;
			else :
				$respuesta = false;
			endif;

			return $respuesta;
		endif;
	endif;
}

function OpcionTres($logro1, $logro2, $carreras1, $carreras2)
{
	//if (empty($logro1)): echo 'enblanco ('.$logro1.')'; endif;
	if (empty($logro1) && empty($logro2)) :
		return true;
	else :

		if (empty($carreras1) && empty($carreras2)) :
			return true;
		else :
			if ($carreras1 > 0) : $SignoC1 = 'P';
			else :    $SignoC1 = 'N';
			endif;
			if ($carreras2 > 0) : $SignoC2 = 'P';
			else :    $SignoC2 = 'N';
			endif;
			if ($logro1 > 0) :    $SignoL1 = 'P';
			else :    $SignoL1 = 'N';
			endif;
			if ($logro2 > 0) :    $SignoL2 = 'P';
			else :    $SignoL2 = 'N';
			endif;
			/*echo $SignoC1.'-';echo $SignoL1.'<br>';
			echo $SignoC2.'-';echo $SignoL2.'<br>';*/
			if ($SignoC1 != $SignoL1 &&  $SignoC2 != $SignoL2) :
				$respuesta = true;
			else :
				$respuesta = false;
			endif;
			return $respuesta;
		endif;
	endif;
}

function iLogrosCkeck($LogroCk)
{
	if (empty($LogroCk)) :
		return true;
	else :
		if (is_numeric($LogroCk)) :
			if ($LogroCk < 0) :
				$LogroCk = $LogroCk  * -1;
			endif;

			if (strlen($LogroCk) >= 3) : return true;
			else : return false;
			endif;
		else :
			return false;
		endif;
	endif;
}

function iRango($Desde, $Hasta, $Cmp)
{
	if (empty($Cmp)) :
		return true;
	else :
		if ($Cmp < 0) :
			$Cmp = $Cmp  * -1;
		endif;

		if (($Desde) <= ($Cmp) && ($Hasta) >= ($Cmp)) : return true;
		else : return false;
		endif;
	endif;
}
function iCompare($Logro1, $Logro2)
{
	if (empty($Logro1) && empty($Logro2)) :
		return true;
	else :
		if (($Logro1 === $Logro2)) : return true;
		else : return false;
		endif;
	endif;
}
