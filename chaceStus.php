<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

switch ($_REQUEST['opk']) {

	case 1:
		$result = mysqli_query($GLOBALS['link'], "Update _tusu Set Estatus=" . $_REQUEST['estado'] . " where IDusu=" . $_REQUEST['IDusu']);
		break;
	case 2:
		$result = mysqli_query($GLOBALS['link'], "Update _tbmensaje Set fechaModi='" . $_REQUEST['fechaModi'] . "', mensaje='" . $_REQUEST['mensaje'] . "'");
		break;
	case 3:
		$result = mysqli_query($GLOBALS['link'], "Update _tbrestriccionesxparlay Set MontodeVenta='" . $_REQUEST['MontodeVenta'] . "' where Cantidad=" . $_REQUEST['Cantidad'] . " and IDC='" . $_REQUEST['IDC'] . "'");
		break;
	case 4:
		$result = mysqli_query($GLOBALS['link'], "Update _thorariodeventas Set HoradeVenta='" . $_REQUEST['HoradeVenta'] . "' where Dia=" . $_REQUEST['Dia']);
		break;
	case 5:
		$result = mysqli_query($GLOBALS['link'], "Update _thorariodeventas Set HoradeCierre='" . $_REQUEST['HoradeCierre'] . "' where Dia=" . $_REQUEST['Dia']);
		break;
	case 6:
		$result = mysqli_query($GLOBALS['link'], "Select * from _tconsecionariodd_tb  where IDC='" . $_REQUEST['IDC'] . "' and MontoDesde=" . $_REQUEST['MontoDesde'] . " and MontoHasta=" . $_REQUEST['MontoHasta']);
		if (mysqli_num_rows($result) != 0) :
			$result = mysqli_query($GLOBALS['link'], "Delete from _tconsecionariodd_tb where IDC='" . $_REQUEST['IDC'] . "' and MontoDesde=" . $_REQUEST['MontoDesde'] . " and MontoHasta=" . $_REQUEST['MontoHasta']);
		endif;
		break;
	case 7:
		$result = mysqli_query($GLOBALS['link'], "Select * from _tconsecionariodd_tb  where IDC='" . $_REQUEST['IDC'] . "' and MontoDesde=" . $_REQUEST['MontoDesde'] . " and MontoHasta=" . $_REQUEST['MontoHasta']);
		if (mysqli_num_rows($result) != 0) :
			$result = mysqli_query($GLOBALS['link'], "Update  _tconsecionariodd_tb set aCobrar='" . $_REQUEST['aCobrar'] . "' where IDC='" . $_REQUEST['IDC'] . "' and MontoDesde=" . $_REQUEST['MontoDesde'] . " and MontoHasta=" . $_REQUEST['MontoHasta']);
		else :
			$result = mysqli_query($GLOBALS['link'], "Insert _tconsecionariodd_tb  values ('" . $_REQUEST['IDC'] . "'," . $_REQUEST['MontoDesde'] . "," . $_REQUEST['MontoHasta'] . ",'" . $_REQUEST['aCobrar'] . "')");
		endif;
		break;
}
echo json_encode($result);
