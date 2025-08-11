<?
require_once('prc_skynet.php');
require_once('prc_phpN.php');
require_once('graphql.php');
$force = 0;
$endpoint = "http://parleybets.com:8910/serviceV2";
$query = <<<'GRAPHQL'
query tblogrosNT($idequi:Int!,$idep:Int!,$idj:Int!,$periodo:Int!,$tp:[Int],$force:Int){
	tblogrosNT(idequi:$idequi,idep:$idep,idj:$idj,periodo:$periodo,tp:$tp,force:$force){
		linea
		idequi
		periodo
		logro
		idj
		tp
		formato
	}
	}
GRAPHQL;
$endpointCallMicro = "https://parleybets.com:4433/apply";
$queryCallIDP = <<<'GRAPHQL'
{
	ListIDPClose{
	  IDP
	  Time
	}
  }
GRAPHQL;
$GLOBALS['link'] = mysqli_connect($server, $user, $clv);
mysqli_select_db($GLOBALS['link'], $db);
$skynet = mysqli_connect($server1, $user1, $clv1);
mysqli_select_db($skynet, $db1);

$fecha = date('d/n/Y');
$result = mysqli_query($GLOBALS['link'], "Select * From _jornadabb Where fecha='" . $fecha . "' and auto=1");
if (mysqli_num_rows($result) != 0) :
	$row = mysqli_fetch_array($result);
	$idj = $row['IDJ'];
	$IDB = $row['IDB'];
endif;
$aidj = array();
$aidep = array();
$casino = array();
$lidb = array();

$result1 = mysqli_query($GLOBALS['link'], "Select * From _agendaNT Where newOdds=1 and idj=$idj ");

while ($row1 = mysqli_fetch_array($result1)) {
	$ALiga = explode('|', $row1['param']); //14-1109 | 0
	$casino = $ALiga[1];
	if ($ALiga[0] != -1) :
		$code = explode('-', $ALiga[0]);
		$aidj[] = $code[1];
		$aidep[] = $code[0];
	endif;
}
if ($casino == 0) {
	$Acasino = array();
	$result = mysqli_query($skynet, "Select * From _tbcasinoNTnw Where enabled=1");
	while ($row1 = mysqli_fetch_array($result)) {
		$Acasino[] = $row1['paid'];
	}
	$casino = join(',', $Acasino);
}

echo 'CASINO:';
print_r($casino) . '<br>';
print_r($aidj);
print_r($aidep);
echo $IDB;
for ($i = 0; $i <= count($aidj) - 1; $i++) {

	$result = mysqli_query($skynet, "Select * From _tbligasNTnw Where idep=" . $aidep[$i] . " and idj=" . $aidj[$i]);
	$row = mysqli_fetch_array($result);
	echo "Select * From _tbligasNTnw Where idep=" . $aidep[$i] . " and idj=" . $aidj[$i];
	$nombre = $row['nombre'];
	$result = mysqli_query($GLOBALS['link'], "Select * From _tbligasNT Where nombre='" . trim($nombre, " \t\n\r") . "'");
	$row = mysqli_fetch_array($result);
	echo ("Select * From _tbligasNT Where nombre='" . $nombre . "'");
	$Grupo = $row['grupo'];



	$aCode1 = array();
	$aCode2 = array();
	$aIDE1 = array();
	$aIDE2 = array();
	$result = mysqli_query($GLOBALS['link'], "Select * From _partidosbb Where Grupo=$Grupo and idj=$idj ORDER BY `_partidosbb`.`IDP` ASC");
	echo "Select * From _partidosbb Where Grupo=$Grupo and idj=$idj ORDER BY `_partidosbb`.`IDP` ASC";
	while ($row = mysqli_fetch_array($result)) {
		$aCode1[] = $row['CodEq1'];
		$aIDE1[] = $row['IDE1'];
		$aCode2[] = $row['CodEq2'];
		$aIDE2[] = $row['IDE2'];
	}
	$IDPl = 0;
	for ($j = 0; $j <= count($aIDE1) - 1; $j++) {
		$tCode1 = $aCode1[$j];
		$tCode2 = $aCode2[$j];
		$IDPl++;
		$vIDDD = array();
		$applicarSCC = false;
		include "skynet-3xt-2Nw.php";
	}
}


$resultCallMicro = graphqlQUY($endpointCallMicro, $queryCallIDP, []);
print_r($resultCallMicro);
