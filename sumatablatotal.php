<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$op = $_REQUEST['op'];
$IDCN = $_REQUEST['IDCN'];
$IDC = $_REQUEST['idc'];
$Idj = $_REQUEST['idj'];
$carr = $_REQUEST['carr'];

switch ($op) {
	case 1:
		$resultj = mysqli_query($GLOBALS['link'], "SELECT sum(Valor_R) as valortotal FROM _tjugada where IDC='" . $IDC . "' and idcn=" . $IDCN . " and IDjug=" . $Idj . " and carr=" . $carr);
		$row = mysqli_fetch_array($resultj);
		echo json_encode(number_format($row['valortotal'], 2, ',', '.'));
		break;
	case 2:
		$lista = array();
		$lista[0] = 0;
		$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbrestricionessph where IDC='" . $IDC . "' and IDJ=" . $Idj);
		if (mysqli_num_rows($resultj) == 0) :
			$maximatablas = 0;
		else :
			$row = mysqli_fetch_array($resultj);
			$maximatablas = $row['mmxj'];
		endif;

		$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugada where IDC='" . $IDC . "' and idcn=" . $IDCN . " and IDjug=" . $Idj . " and carr=" . $carr);

		while ($row = mysqli_fetch_array($resultj)) {
			$k_jug = explode("|", $row['Jugada']);
			for ($i = 1; $i <= count($k_jug) - 1; $i++) {
				$valor = explode("*", $k_jug[$i]);
				$k =	$valor[0];
				$lista[$k]++;
			}
		}
		ksort($lista);
		for ($i = 0; $i <= 20; $i++) {
			$lista2[$i] = $maximatablas - $lista[$i];
		}
		echo json_encode($lista2);
		break;
	case 3:
		$ok = false;

		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tabladetablascnf where Estatus=1 and idcn=" . $IDCN . " and carr=" . $carr);
		if (mysqli_num_rows($result) != 0) :
			$ok = true;


			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierre where  idcn=" . $IDCN . " and ct=" . $carr);
			if (mysqli_num_rows($result) == 0) :
				$ok = true;
			else :
				$ok = false;
			endif;

		endif;

		echo json_encode($ok);
		break;
}
