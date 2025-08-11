<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();



$relacion = relacion(1, 4);
$IDLot = 1;
$Numero = '10';
print_r($relacion);
echo '<br><br>';
for ($j = 0; $j <= count($relacion) - 1; $j++) {
	if ($j == 0) :
		$OKAnt = '0-0';
	else :
		$OKAnt = $relacion[$j - 1];
	endif;
	$arrayvendido = array();
	recursivo($relacion[$j], $OKAnt);
	print_r($arrayvendido);
	echo '****<br>';
}

function recursivo($Nivel, $NOK)
{
	global $IDLot;
	global $Numero;
	global $arrayvendido;
	$relacion = relacionaNivel($Nivel, $NOK);
	for ($i = 0; $i <= count($relacion) - 1; $i++) {
		$Arelacion = explode('-', $relacion[$i]);
		if ($Arelacion[0] == 4) :
			echo 'Depende de:' . $Nivel . '<br>';
			print_r($Arelacion);
			echo '<br>';
			$resultChq1 = mysqli_query($GLOBALS['link'], "SELECT Sum(_tjugada_data.Monto) as Vendido FROM _tjugada_data,_tjugada where _tjugada_data.Serial=_tjugada.Serial and IDC=" . $Arelacion[1] . " and IDLot=" . $IDLot . " and numero='" . $Numero . "'");

			if (mysqli_num_rows($resultChq1) == 0) :
				$arrayvendido[] = 0;
			else :
				$row = mysqli_fetch_array($resultChq1);
				$arrayvendido[] = $row['Vendido'];
			endif;

		else :
			// print_r($relacion[$i]);		echo '--<br>';
			if ($i == 0) :
				$OKAnt = '0-0';
			else :
				$OKAnt = $relacion[$i - 1];
			endif;
			//echo $i.'-'.$OKAnt.'<br>';
			recursivo($relacion[$i], $OKAnt);

		endif;
	}
}
