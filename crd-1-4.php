<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
global $minutosa;
$op = $_REQUEST['op'];


switch ($op) {

	case 1:
		$IDC = $_REQUEST['IDC'];
		$crd = $_REQUEST['credito'];
		$fecha = Fechareal($minutosa, "d/n/Y");
		$hora = Horareal($minutosa, "h:i:s A");
		$ultran = $fecha . '-' . $hora;
		$resultEqu = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbcrdcredito WHERE IDC = '$IDC'");
		if (mysqli_num_rows($resultEqu) != 0) :
			$result = mysqli_query($GLOBALS['link'], "Update _tbcrdcredito  Set  credito=$crd,ultimtrans='$ultran' where IDC='$IDC'");
		else :
			$result = mysqli_query($GLOBALS['link'], "Insert _tbcrdcredito  values ('$IDC',$crd,0,'$ultran','',0,'" . Fechareal($minutosa, "d/m/Y") . "')");
		endif;
		break;
}

echo json_encode($result);
