<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$IDC = $_REQUEST['idc'];

$tcredito = 0;
$tbalance = 0;
$tpendiente = 0;
$Disponible = 0;
$result = mysqli_query($GLOBALS['link'], "SELECT * FROM `_tbcrdcredito`  where IDC='$IDC'");
if (mysqli_num_rows($result) != 0) :
	$row3 = mysqli_fetch_array($result);
	if ($row3['credito'] != 0) :
		$tcredito = $row3['credito'];
		$tbalance = $row3['saldo'] - $row3['credito'];
		$tpendiente = $row3['CreditoDiario'];
		$Disponible = $tbalance + $row3['credito'];

	endif;
	echo json_encode(array($tcredito, $tbalance, $tpendiente, $Disponible));
else :
	echo json_encode(array('NO'));
endif;
