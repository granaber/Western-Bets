<?
require_once('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


$opcion = $_REQUEST['opcion'];
switch ($opcion) {
	case 1:
		$resultjCodigo = mysqli_query($GLOBALS['link'], " Delete from _registros_de_acceso Where IDusu=" . $_REQUEST['IDusu']);

		break;
	case 2:
		$timeserial = explode(':', time());
		$se = chr(rand(1, 25) + 65) . rand(1, 10) . rand(1, intval($timeserial[2])) . rand(1, 100) . '-' . chr(rand(1, 25) + 65) . rand(1, 1000) . '-' . substr(intval($timeserial[0]), 2, 1) . chr(rand(1, 25) + 65);
		$resultjCodigo = mysqli_query($GLOBALS['link'], " Update  _registros_de_acceso set SerialGenerado='" . $se . "' Where IDusu=" . $_REQUEST['IDusu']);

		break;
}

echo json_encode($resultjCodigo);
