<?
require_once('prc_skynet.php');
require('prc_phpN.php');

$GLOBALS['link'] = mysqli_connect($server, $user, $clv);
mysql_select_db($db, $GLOBALS['link']);
$skynet = mysqli_connect($server1, $user1, $clv1);
mysql_select_db($db1, $skynet);

$fecha = date('d/n/Y');
$result = mysqli_query($GLOBALS['link'], "Select * From _jornadabb Where fecha='" . $fecha . "' and auto=1", $GLOBALS['link']);
if (mysqli_num_rows($result) != 0) :
	$row = mysqli_fetch_array($result);
	$idj = $row['IDJ'];
	$IDB = $row['IDB'];
endif;
$aidj = array();
$aidep = array();
$casino = array();
$lidb = array();

$result1 = mysqli_query($GLOBALS['link'], "Select * From _agendaNT Where idj=$idj ", $GLOBALS['link']);
echo "Select * From _agendaNT Where idj=$idj ";
while ($row1 = mysqli_fetch_array($result1)) {
	$ALiga = explode('|', $row1['param']);
	$casino[] = $ALiga[1];
	if ($ALiga[0] != -1) :
		$code = explode('-', $ALiga[0]);
		$aidj[] = $code[1];
		$aidep[] = $code[0];
	endif;
}
echo 'CASINO:';
print_r($casino) . '<br>';
print_r($aidj);
print_r($aidep);
echo $IDB;
for ($i = 0; $i <= count($aidj) - 1; $i++) {

	$result = mysqli_query($GLOBALS['link'], "Select * From _tbligasNT Where idep=" . $aidep[$i] . " and idj=" . $aidj[$i], $skynet);
	$row = mysqli_fetch_array($result);
	echo "Select * From _tbligasNT Where idep=" . $aidep[$i] . " and idj=" . $aidj[$i];
	$nombre = $row['nombre'];
	$result = mysqli_query($GLOBALS['link'], "Select * From _tbligasNT Where nombre='" . $nombre . "'", $GLOBALS['link']);
	$row = mysqli_fetch_array($result);
	echo ("Select * From _tbligasNT Where nombre='" . $nombre . "'");
	$Grupo = $row['grupo'];



	$aCode1 = array();
	$aCode2 = array();
	$aIDE1 = array();
	$aIDE2 = array();
	$result = mysqli_query($GLOBALS['link'], "Select * From _partidosbb Where Grupo=$Grupo and idj=$idj ORDER BY `_partidosbb`.`IDP` ASC", $GLOBALS['link']);
	echo "Select * From _partidosbb Where Grupo=$Grupo and idj=$idj ORDER BY `_partidosbb`.`IDP` ASC";
	while ($row = mysqli_fetch_array($result)) {
		$aCode1[] = $row['CodEq1'];
		$aIDE1[] = $row['IDE1'];
		$aCode2[] = $row['CodEq2'];
		$aIDE2[] = $row['IDE2'];
	}
	$IDPl = 0;
	for ($j = 0; $j <= count($aIDE1) - 1; $j++) {
		$IDPl++;
		$vIDDD = array();
		include "skynet-3xt-1.php";
	}
}
