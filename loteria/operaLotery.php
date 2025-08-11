<?
date_default_timezone_set('America/Caracas');
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();




$op = $_REQUEST['op'];
switch ($op) {
	case 1:
		echo  json_encode(CkqCierreLoteria($_REQUEST['IDLot'], 0));
		break;

	case 2:
		$listadeLoterias = explode(',', json_decode($_REQUEST['IDLots'], true));

		$chqOpenLoterias = array();

		for ($i = 0; $i <= count($listadeLoterias) - 2; $i++) {
			$valor = CkqCierreLoteria($listadeLoterias[$i], 0);
			if ($valor[0]) :
				$chqOpenLoterias[] = 1;
			else :
				$chqOpenLoterias[] = 0;
			endif;
		}


		echo  json_encode($chqOpenLoterias);
		break;
	case 3:
		echo  json_encode(CkqCierreLoteria($_REQUEST['IDLot'], $_REQUEST['Fecha']));
		break;

	case 4:
		$valores = array();
		$Jugada = explode(',', json_decode($_REQUEST["Jugada"], true));
		for ($i = 0; $i <= count($Jugada) - 2; $i++) {
			$descomp = explode('|', $Jugada[$i]);
			$valores[] = CuposMaximo($descomp[0], $descomp[1], $_REQUEST['IDCtt'], $_REQUEST['IDJ'], $descomp[3], $i);
		}
		echo  json_encode($valores);
		break;

	case 5:
		$alotery = array();
		$resultj = mysqli_query($GLOBALS['link'], "select imagen from _tloteria group by imagen");
		while ($Row = mysqli_fetch_array($resultj)) {
			$alotery[] = $Row['imagen'];
		}
		echo  json_encode($alotery);
}
