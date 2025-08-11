<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


$op = $_REQUEST['op'];

switch ($op) {
	case 1:
		$JugadasMaximas = explode('|', $_REQUEST['JM']);
		$DividendosMaximos = explode('|', $_REQUEST['DM']);
		$IDC = $_REQUEST['IDC'];
		for ($i = 0; $i <= 2; $i++) {
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tcuposgps where ID=" . $i . " and IDC='" . $IDC . "'");

			if (mysqli_num_rows($result) != 0) :
				$result = mysqli_query($GLOBALS['link'], "Update _tcuposgps set JugadaMaxima=" . $JugadasMaximas[$i] . ",DividendosMaximos=" . $DividendosMaximos[$i] . " where  IDC='" . $IDC . "' and  ID=" . $i);
			else :
				$result = mysqli_query($GLOBALS['link'], "Insert _tcuposgps values ('" . $IDC . "'," . $i . "," . $JugadasMaximas[$i] . "," . $DividendosMaximos[$i] . ")");

			endif;
		}
		break;
	case 2:

		$campoActulizar = $_REQUEST['campo'];
		$data = $_REQUEST['data'];
		$idJugada = $_REQUEST['idJugada'];
		$IDRelacionado = explode('-', $_REQUEST['IdRelacionado']);


		$result = mysqli_query($GLOBALS['link'], "Select * from _tcupos where IDC='" . $IDRelacionado[0] . "' and IDJug=" . $idJugada);


		if (mysqli_num_rows($result) == 0) :
			$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tcupos  VALUES ('" . $IDRelacionado[0] . "'," . $idJugada . ",0,0)");
		endif;
		if (ctype_digit($sdc[1])) :
			$Valor = $data;
		else :
			$Valor = "'" . $data . "'";
		endif;

		$result = mysqli_query($GLOBALS['link'], "Update  _tcupos  Set " . $campoActulizar . "=" . $Valor . " Where IDC='" . $IDRelacionado[0] . "' and IDJug=" . $idJugada);

		echo json_encode($result);
		break;
}
