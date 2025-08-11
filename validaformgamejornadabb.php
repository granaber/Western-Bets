<?php

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


if (isset($_GET["fc"])) {
	$fc = $_GET["fc"];
	$datoresques = array();



	$idj = 0;
	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");

	if (mysqli_num_rows($resultj) != 0) :

		$rowj = mysqli_fetch_array($resultj);

		$datoresques['idj'] = $rowj["IDJ"];
		$datoresques['cant'] = $rowj["Partidos"];
		$idj = $rowj["IDJ"];

	else :

		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb Order by IDJ DESC ");
		$row = mysqli_fetch_array($result);
		if ($result) :
			$datoresques['idj'] = $row["IDJ"] + 1;
		else :
			$datoresques['idj'] = 1;
		endif;
		$datoresques['cant'] = 0;

	endif;
	$y = 1;
	$datoresques['dispatch'] = '<div></div>';
	if ($idj != 0) {
		$datoresques['dispatch'] = "<span style='color:#000000; background:#FFFFFF; font-size:11px'><input id='chk0' type='checkbox' value='0' onclick='marcat(0)'/>TODOS</span><br />";

		$resultj = mysqli_query($GLOBALS['link'], "SELECT _gruposdd.* FROM _gruposdd,_jornadabb where _gruposdd.grupo=_jornadabb.grupo and _jornadabb.IDJ=" . $rowj["IDJ"] . "  Order by grupo ");
		while ($row = mysqli_fetch_array($resultj)) {
			$datoresques['dispatch'] .= "<input id='chk0" . $y . "' type='checkbox' lang=" . $row["Grupo"] . " /><span class='text-warning' style='font-size:11px'>" . $row["Descripcion"] . '</span><br />';
			$y++;
		}
	}
	$datoresques['totalg'] = $y;
} else if (isset($_GET["nom"])) {
}

echo json_encode($datoresques);
