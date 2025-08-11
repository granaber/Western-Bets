<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$fc = $_REQUEST["fc"];
$resultx = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
if (mysqli_num_rows($resultx) != 0) :
	$rowx = mysqli_fetch_array($resultx);
	$idj = $rowx["IDJ"];
	$sumatotal = 0;
	$resultx = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb where IDJ>=" . $idj . " and activo=1");
	while ($row = mysqli_fetch_array($resultx)) {
		$aco = recalculoTK($row['Jugada'], $row['ap']);

		if ($row['acobrar'] > ceil($aco)) :
			echo $row['serial'] . '  ' . $row['IDC'] . ' Real:' . ceil($aco) . ' Cobrado:' . $row['acobrar'];
			$premio = mescrute($row['serial']);
			if ($premio['condicion']) :
				echo '  Premiado :' . ($row['acobrar'] - ceil($aco));
				$sumatotal += ($row['acobrar'] - ceil($aco));
			endif;
			echo '</br>';
		endif;
	}
endif;
echo 'Total Cobrado de mas:' . $sumatotal;
