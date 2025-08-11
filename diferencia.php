<?

require('prc_php.php');

$GLOBALS['link'] = Connection::getInstance();

$result = mysqli_query($GLOBALS['link'], "SELECT IDC,sum(ap) as suma FROM _tjugadabb where idj=84 and activo=1 group by IDC order by IDC");
while ($row = mysqli_fetch_array($result)) {
	$resultCMP = mysqli_query($GLOBALS['link'], "SELECT sum(ventas) as suma FROM totales where idj=84 and IDC='" . $row['IDC'] . "'");
	if (mysqli_num_rows($resultCMP) != 0) :
		$rowO = mysqli_fetch_array($resultCMP);
		if ($row['suma'] != $rowO['suma']) :
			echo " Esta la Diferencia " . $row['suma'] . "!=" . $rowO['suma'] . "-" . $row['IDC'] . "<br>";
		endif;

	else :
		echo "No existe " . $row['IDC'] . "<br>";
	endif;
}
/*for ($i=1;$i<=288;$i++){
	$resultCMP = mysqli_query($GLOBALS['link'],"Insert  _tbaccesoreportes Values (1,".$i.")");
	
}*/
