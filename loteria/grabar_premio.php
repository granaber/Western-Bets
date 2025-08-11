<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
global $GLOBALS['minutosh']o;


$op = $_REQUEST['op'];
$IDJ = Jornada($_REQUEST['Fecha'], false);
$IDLot = $_REQUEST['IDLot'];

switch ($op) {


	case 1:
		$NumeroP = $_REQUEST['NumeroP'];
		$Adicional = $_REQUEST['Adicional'];

		$horaticket = Horareal($GLOBALS['minutosh']o, "h:i:s A");


		$result = mysqli_query($GLOBALS['link'], "Select * from _tbpremios where IDJ=" . $IDJ . " and IDLot=" . $IDLot);

		if (mysqli_num_rows($result) == 0) :
			$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tbpremios  (IDJ,IDLot,NumeroP,Adicional,HoraProceso) VALUES (" . $IDJ . "," . $IDLot . ",'" . $NumeroP . "'," . $Adicional . ",'" . $horaticket . "')");
		else :
			$result = mysqli_query($GLOBALS['link'], "Update  _tbpremios  Set  NumeroP='" . $NumeroP . "', Adicional=" . $Adicional . " where IDJ=" . $IDJ . " and IDLot=" . $IDLot);
		endif;

		echo json_encode($result);

		break;

	case 2:

		$respuesta = array();
		$result = mysqli_query($GLOBALS['link'], "Select * from _tbpremios where IDJ=" . $IDJ . " and IDLot=" . $IDLot);
		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			$respuesta[] = true;
			$respuesta[] = $row['NumeroP'];
			$respuesta[] = $row['Adicional'];
		else :
			$respuesta[] = false;
		endif;
		echo json_encode($respuesta);
		break;

	case 3:
		$resultado = ProcesoEscrute($IDJ, $IDLot, $_REQUEST['NumeroP'], $_REQUEST['Adicional']);
		echo json_encode($resultado);
		break;
}
