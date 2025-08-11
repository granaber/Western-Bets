<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


$op = $_REQUEST['op'];

switch ($op) {
	case 1:
		$IDRelacionado = explode('-', $_REQUEST['idk']);

		if ($IDRelacionado[0] == 'Banca') :
			$IDC = '0';
			$IDG = 0;
		else :
			if (is_numeric($IDRelacionado[0])) :
				$IDC = '0';
				$IDG = $IDRelacionado[1];
			else :
				$IDG = 0;
				$IDC = $IDRelacionado[0];
			endif;
		endif;


		if ($_REQUEST['id'] == 0) :
			$result = mysqli_query($GLOBALS['link'], "Insert _tbrestricciones (IDC,IDG,CantidadEje,DivUno,DivDos,DividendoFijo,Premio,_idhipo) values ('$IDC',$IDG," . $_REQUEST['CantidadEje'] . "," . $_REQUEST['DivUno'] . "," . $_REQUEST['DivDos'] . "," . $_REQUEST['DividendoFijo'] . "," . $_REQUEST['Premio'] . "," . $_REQUEST['_idhipo'] . ")");

		else :
			$result = mysqli_query($GLOBALS['link'], "Update  _tbrestricciones set DivUno=" . $_REQUEST['DivUno'] . ",DivDos=" . $_REQUEST['DivDos'] . ",DividendoFijo=" . $_REQUEST['DividendoFijo'] . ",Premio=" . $_REQUEST['Premio'] . ",_idhipo=" . $_REQUEST['_idhipo'] . " where  id_tbrestricciones=" . $_REQUEST['id']);
		endif;
		if ($result) :
			echo json_encode(array(true));
		else :
			echo json_encode(array(false, 'NO SE PUEDE GRABAR EL REGLAMENTO!'));
		endif;

		break;
	case 2:

		$result = mysqli_query($GLOBALS['link'], "Delete from   _tbrestricciones  where  id_tbrestricciones=" . $_REQUEST['id']);


		if ($result) :
			echo json_encode(array(true));
		else :
			echo json_encode(array(false, 'NO SE PUEDE ELIMINAR ESTE REGLAMENTO!'));
		endif;

		break;
}
