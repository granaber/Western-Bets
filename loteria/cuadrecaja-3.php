<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbcuadre Order by IDCierre Desc");
if (mysqli_num_rows($resultj) != 0) :
	$rowj = mysqli_fetch_array($resultj);
	$IDCierre = $rowj["IDCierre"] + 1;
else :
	$IDCierre = 1;
endif;

if ($_REQUEST['IDCtrr'] == -2) :
	$x = 1;
else :
	$x = $_REQUEST['IDCtrr'];
endif;
$resultj = mysqli_query($GLOBALS['link'], "Insert  _tbcuadre Values (" . $IDCierre . "," . $_REQUEST['PremiosPagados'] . "," . $_REQUEST['TotalGastos'] . "," . $_REQUEST['TotalVenta'] . "," . $x . "," . $_REQUEST['IDJ'] . "," . $_REQUEST['IDAp'] . ")");

if ($resultj) :
	$valores = explode(',', $_REQUEST['valores']);

	for ($j = 0; $j <= count($valores) - 2; $j++) {
		$valores2 = explode('-',	$valores[$j]);
		if ($valores2[1] == '') :
			$resultj = mysqli_query($GLOBALS['link'], "Insert  _tbcuadre_denominacion Values (" . $IDCierre . "," . $valores2[0] . ",0)");
		else :
			$resultj = mysqli_query($GLOBALS['link'], "Insert  _tbcuadre_denominacion Values (" . $IDCierre . "," . $valores2[0] . "," . $valores2[1] . ")");
		endif;
	}

endif;
$respuesta[] = $resultj;
$respuesta[] = $IDCierre;
echo json_encode($respuesta);
