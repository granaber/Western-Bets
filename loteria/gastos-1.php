<?

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
global $GLOBALS['minutosh']o;
$horaticket = Horareal($GLOBALS['minutosh']o, "h:i:s A");

$op = $_REQUEST['op'];


switch ($op) {

	case 1:
		$respuesta = array();
		$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgastos Where IDGas=" . $_REQUEST['IDGas']);
		if ($_REQUEST['IDCtrr'] == -2) :
			$x = 1;
		else :
			$x = $_REQUEST['IDCtrr'];
		endif;

		$Ventas = ConsultadeVentas($x, $_REQUEST['IDJ']);
		$Fondo = ConsultadeFondo($x, $_REQUEST['IDJ']);
		$Gastos = ConsultadeGastos($x, $_REQUEST['IDJ']);
		$Premios = ConsultadePremiosPagados($x, $_REQUEST['IDJ']);

		$Diferencia = ($Ventas + $Fondo) - ($Gastos + $Premios);


		if (mysqli_num_rows($resultj) == 0) :
			if (($Diferencia - $_REQUEST['Monto']) >= 0) :
				$resultj = mysqli_query($GLOBALS['link'], "Insert _tgastos Values(" . $_REQUEST['IDGas'] . ",'" . $horaticket . "','" . $_REQUEST['Descripcion'] . "'," . $_REQUEST['Monto'] . "," . $x . "," . $_REQUEST['IDJ'] . ")");
				$respuesta[] = $resultj;
			else :
				$respuesta[] = false;
				$respuesta[] = 'El Monto colocado No esta Disponible en Caja, Monto Disponible:  Bsf.' . $Diferencia;
			endif;

		else :
			$row = mysqli_fetch_array($resultj);
			$DiferenciaX = $Diferencia - $row['Monto'];
			if (($DiferenciaX - $_REQUEST['Monto']) >= 0) :
				$resultj = mysqli_query($GLOBALS['link'], "Update _tgastos Set Hora='" . $horaticket . "',Descripcion='" . $_REQUEST['Descripcion'] . "',Monto=" . $_REQUEST['Monto'] . " where   IDGas=" . $_REQUEST['IDGas']);
				$respuesta[] = $resultj;
			else :
				$respuesta[] = false;
				$respuesta[] = 'El Monto colocado No esta Disponible en Caja, Monto Disponible: Bsf.' . $Diferencia;
			endif;

		endif;
		echo json_encode($respuesta);
		break;
	case 2:
		$resultj = mysqli_query($GLOBALS['link'], "Delete from _tgastos Where IDGas=" . $_REQUEST['IDGas']);
		echo json_encode($resultj);
		break;
}
