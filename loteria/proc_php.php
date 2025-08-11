<?
date_default_timezone_set('America/Caracas');
require_once('prc_php.php');

$op = $_REQUEST["op"];

switch ($op) {
	case 1: // HORA SERVIDOR	
		$fechada = array();

		$fechada[] = Horareal(0, 'h:i:s A');
		$fechada[] = Fechareal(0, 'd/m/Y');
		echo json_encode($fechada);
		break;
	case 2: // Tipo de Loteria
		$GLOBALS['link'] = Connection::getInstance();
		$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tloteria  Where IDLot=" . $_REQUEST["IDLot"]);
		$rowj = mysqli_fetch_array($resultj);
		if ($rowj['Formato'] != 1) :
			$resultj1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tloteria_formato  Where Formato=" . $rowj["Formato"]);
			$rowj2 = mysqli_fetch_array($resultj1);
			$arr = array(true, $rowj2['Lista']);
		else :
			$arr = array(false, '');
		endif;
		echo json_encode($arr);
		break;
	case 3:
		$GLOBALS['link'] = Connection::getInstance();
		$resultj1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tloteria_formato  Where Formato=" . $_REQUEST["formato"]);
		$rowj2 = mysqli_fetch_array($resultj1);
		$arr = explode('|', $rowj2['Lista']);
		echo json_encode($arr);
		break;
	case 4:
		$GLOBALS['link'] = Connection::getInstance();
		$resultj1 = mysqli_query($GLOBALS['link'], "SELECT *  FROM  _tbclavebli ORDER BY  NIBL DESC");
		$rowj2 = mysqli_fetch_array($resultj1);
		if (trim($rowj2['Usuario']) == trim($_REQUEST['ikUsu'])  && trim($rowj2['BLI']) == trim($_REQUEST['ikClave'])) :
			echo json_encode(true);
		else :
			echo json_encode(false);
		endif;
		break;
	case 5:
		$GLOBALS['link'] = Connection::getInstance();
		$resData = array();
		$resData[0] = false;
		$fila = 1;
		$resultj1 = mysqli_query($GLOBALS['link'], "SELECT *  FROM  _tjugada_data WHERE  Serial=" . intval($_REQUEST['serial']));
		while ($row1 = mysqli_fetch_array($resultj1)) {
			$resData[0] = true;

			$resultj2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM  _tloteria WHERE  IDLot =" . $row1['IDLot']);
			$row2 = mysqli_fetch_array($resultj2);
			$adicional = 0;
			if ($row1['Adicional'] != 0) :
				$resultj3 = mysqli_query($GLOBALS['link'], "SELECT *  FROM  _tloteria_formato WHERE  Formato =" . $row2['Formato']);
				$row3 = mysqli_fetch_array($resultj3);
				$VerAdd = explode('|', $row3['Lista']);
				$adicional = $VerAdd[$row1['Adicional']];
			endif;
			$resData[$fila] = $row1['numero'] . '|' . $row1['IDLot'] . '|' . $row2['NombrePantalla'] . '|' . $row1['Monto'] . '|' . $row1['Adicional'] . '|' . $adicional;
			$fila++;
		}
		echo json_encode($resData);
		break;
}
