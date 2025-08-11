<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario ");
while ($row = mysqli_fetch_array($result)) {
	$idr = $row["IDRow"];
	$idc = substr($row["IDC"], 0, strlen($row["IDC"]) - 1);
	switch ($row["IDG"]) {
		case 5:
			$nuevo = 1;
			break;
		case 8:
			$nuevo = 2;
			break;
		case 9:
			$nuevo = 3;
			break;
		default:
			$nuevo = 0;
	}
	if ($nuevo != 0) :
		$result2 = mysqli_query($GLOBALS['link'], "Update _tconsecionario set IDG=" . $nuevo . ",IDC='" . $idc . $nuevo . "' where IDC='" . $row["IDC"] . "'");
		$result2 = mysqli_query($GLOBALS['link'], "Update _tusu set Asociado='" . $idc . $nuevo . "' where Asociado='" . $row["IDC"] . "'");
		$result2 = mysqli_query($GLOBALS['link'], "Update _tconsecionariodd set IDC='" . $idc . $nuevo . "' where IDC='" . $row["IDC"] . "'");
		$result2 = mysqli_query($GLOBALS['link'], "Update _tconsecionariodd_tb set IDC='" . $idc . $nuevo . "' where IDC='" . $row["IDC"] . "'");
	endif;
}
