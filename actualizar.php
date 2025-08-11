<?php

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$result1 = mysqli_query($GLOBALS['link'], "Select * from _tusu ");
while ($valot = mysqli_fetch_array($result1)) {
	$idu = $valot['IDusu'];
	$agrupo = $valot['AGrupo'];
	$tp = $valot['Tipo'];
	switch ($tp) {
		case 1:
			$sql = "Select * from _tusu where Tipo=2 and IDusu!=" . $idu;
			break;
		case 2:
			$sql = "Select * from _tusu where  IDusu!=" . $idu;
			break;
		case 3:
			$sql = "Select * from _tusu where Tipo=2 and IDusu!=" . $idu; /// Debo hacer Doble Consulta
			break;
		case 4:
			$sql = "Select _tusu.* from _tusu where  IDusu!=" . $idu . " and Asociado in (Select IDC From _tconsecionario Where IDG=" . $agrupo . ")";
			break;
		case 5:
			$sql = "Select * from _tusu where  IDusu!=" . $idu;
			break;
	}
	$result = mysqli_query($GLOBALS['link'], $sql);
	while ($rowg = mysqli_fetch_array($result)) {
		$result1 = mysqli_query($GLOBALS['link'], "Select * from userlist where userid=" . $idu . " and relationid=" . $rowg['IDusu']);
		if (mysqli_num_rows($result1) == 0) :
			$result2 = mysqli_query($GLOBALS['link'], "INSERT userlist VALUES (" . $idu . "," . $rowg['IDusu'] . ",'yes')");
			$result2 = mysqli_query($GLOBALS['link'], "INSERT userlist VALUES (" . $rowg['IDusu'] . "," . $idu . ",'yes')");
		endif;
	}
	if ($tp == 3) :
		$result = mysqli_query($GLOBALS['link'], "Select * from _tusu where  Asociado in (Select IDC From _tconsecionario Where IDG=" . $agrupo . ")");

		while ($rowg = mysqli_fetch_array($result)) {
			$result1 = mysqli_query($GLOBALS['link'], "Select * from userlist where userid=" . $idu . " and relationid=" . $rowg['IDusu']);
			if (mysqli_num_rows($result1) == 0) :
				$result2 = mysqli_query($GLOBALS['link'], "INSERT userlist VALUES (" . $idu . "," . $rowg['IDusu'] . ",'yes')");
				$result2 = mysqli_query($GLOBALS['link'], "INSERT userlist VALUES (" . $rowg['IDusu'] . "," . $idu . ",'yes')");
			endif;
		}
	endif;
}
