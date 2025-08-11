<?

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
// id_tbcondiciones, IDCN, Carr, Ejemplar, DF, Premio, Cupo

$IDCN = $_REQUEST['IDCN'];
$Carr = $_REQUEST['Carr'];
$DF = explode('|', $_REQUEST['DiviFijo']);
$Premio = explode('|', $_REQUEST['Premio']);
$Cupo = explode('|', $_REQUEST['Cupo']);

for ($i = 0; $i <= count($DF) - 2; $i++) {
	if ($DF[$i] != '*') :
		$resulti = mysqli_query($GLOBALS['link'], "select * from _tbcondiciones where IDCN=$IDCN and Carr=$Carr and Ejemplar=" . ($i + 1) . " and nivel=" . $_REQUEST['nivel'] . " and cod='" . $_REQUEST['cod'] . "'");
		if (mysqli_num_rows($resulti) == 0) :
			$resultok = mysqli_query($GLOBALS['link'], "Insert _tbcondiciones ( IDCN, Carr, Ejemplar, DF, Premio, Cupo,nivel,cod) values ($IDCN,$Carr," . ($i + 1) . "," . $DF[$i] . "," . $Premio[$i] . "," . $Cupo[$i] . "," . $_REQUEST['nivel'] . ",'" . $_REQUEST['cod'] . "')");
		else :



			$resultok = mysqli_query($GLOBALS['link'], "Update _tbcondiciones set nivel=" . $_REQUEST['nivel'] . ",cod='" . $_REQUEST['cod'] . "', DF=" . $DF[$i] . ",Premio=" . $Premio[$i] . ",Cupo=" . $Cupo[$i] . " where IDCN=$IDCN and Carr=$Carr and Ejemplar=" . ($i + 1) . " and nivel=" . $_REQUEST['nivel'] . " and cod='" . $_REQUEST['cod'] . "'");

		endif;
	endif;
}

echo json_encode($resultok);
