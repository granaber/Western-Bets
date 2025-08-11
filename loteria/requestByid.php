<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$op = $_REQUEST['op'];

switch ($op) {
	case 1:
		$respuesta = 0;
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tloteria where IDLot=" . $_REQUEST['IDLot']);
		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			$respuesta = $row['NombreTicket'];
		endif;
		break;
	case 2:
		$respuesta = array();
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tloteria,_tloteria_formato where _tloteria.Formato=_tloteria_formato.Formato and IDLot=" . $_REQUEST['IDLot']);
		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);

			if ($row['Lista'] != '0') :
				$x = explode('|', $row['Lista']);
				$respuesta[] = $x[$_REQUEST['IdAdd'] - 1];
			else :
				$respuesta[] = '';
			endif;
			$respuesta[] = $row['NombreTicket'];
		endif;
		break;
}

echo json_encode($respuesta);
