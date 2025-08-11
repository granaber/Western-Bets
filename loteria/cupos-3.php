<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();



$IDRelacionado = explode('-', $_REQUEST['IdRelacionado']);
$IDLot = $_REQUEST['idLoteria'];

$op = $_REQUEST['op'];

switch ($op) {

	case 1:

		$campoActulizar = $_REQUEST['campo'];
		$data = $_REQUEST['data'];


		$result = mysqli_query($GLOBALS['link'], "Select * from _tcupos where Tipo=" . $IDRelacionado[0] . " and ID_Relacionado=" . $IDRelacionado[1] . ' And IDLot=' . $IDLot);


		if (mysqli_num_rows($result) == 0) :
			$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tcupos  VALUES (" . $IDRelacionado[1] . "," . $IDRelacionado[0] . "," . $IDLot . ",0,0,'0','0')");
		endif;
		if (ctype_digit($sdc[1])) :
			$Valor = $data;
		else :
			$Valor = "'" . $data . "'";
		endif;

		$result = mysqli_query($GLOBALS['link'], "Update  _tcupos  Set " . $campoActulizar . "=" . $Valor . " Where Tipo=" . $IDRelacionado[0] . " and ID_Relacionado=" . $IDRelacionado[1] . ' And IDLot=' . $IDLot);

		echo json_encode($result);
		break;

	case 2:

		$campo = $_REQUEST['campo'];

		$result = mysqli_query($GLOBALS['link'], "Select * from _tcupos where Tipo=" . $IDRelacionado[0] . " and ID_Relacionado=" . $IDRelacionado[1] . ' And IDLot=' . $IDLot);
		//echo ("Select * from _tcupos where Tipo=".$IDRelacionado[0]." and ID_Relacionado=".$IDRelacionado[1].' And IDLot='.$IDLot);   
		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			echo $row[$campo];
		else :
			echo json_encode(false);
		endif;


		break;
}
