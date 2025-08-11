<?

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$IDCN = $_REQUEST['IDCN'];
$Jugada = explode(',', json_decode($_REQUEST['Dividendo']));
$Tandas = explode(',', json_decode($_REQUEST['Tandas']));



for ($i = 1; $i <= count($Jugada); $i++) {
	$llegada = explode('|', $Jugada[$i - 1]);
	$Primero = $llegada[0];
	array_shift($llegada);
	$Segundo = $llegada[0];
	array_shift($llegada);
	$tercero = $llegada[0];
	array_shift($llegada);
	$cuarto = $llegada[0];
	array_shift($llegada);

	$strTandas = explode('|', $Tandas[$i - 1]);
	array_shift($strTandas);
	array_shift($strTandas);
	array_shift($strTandas);

	$strDividendo = implode(',', $llegada);
	$sTandas = implode(',', $strTandas);

	$result5 = mysqli_query($GLOBALS['link'], "Select * from _tdividendohi where IDCN=" . $IDCN . " and carrera=" . $i);

	if (mysqli_num_rows($result5) == 0) :
		$result5 = mysqli_query($GLOBALS['link'], "Insert _tdividendohi values (" . $IDCN . ",'" . $Primero . "','" . $Segundo . "','" . $tercero . "','" . $cuarto . "','" . $strDividendo . "'," . $i . ",'" . $sTandas . "')");

	else :
		$result5 = mysqli_query($GLOBALS['link'], "Update _tdividendohi set  Primero='" . $Primero . "',Segundo='" . $Segundo . "',Tercero='" . $tercero . "',cuarto='" . $cuarto . "',Dividendos='" . $strDividendo . "',tandas='" . $sTandas . "'  where IDCN=" . $IDCN . " and carrera=" . $i);

	endif;
}
