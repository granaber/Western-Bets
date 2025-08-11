<?php
$valid = "false";
$mesanje = "po";

if (isset($_GET["cons"])) {
	if (strlen($_GET["cons"]) < 1) {
		$mesanje = "El Nombre del Concesionario NO debe estar en blanco";
	} else {
		require('prc_php.php');
		$GLOBALS['link'] = Connection::getInstance();
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario where  IDC='" . $_GET["cons"] . "'");
		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			if ($row['Estatus'] == 1) :
				$valid = "true";
				$mesanje = "";
			else :
				$mesanje = "Este Concesionario ESTA BLOQUEADO!";
			endif;
		else :
			$mesanje = "Este Concesionario NO EXISTE!";
		endif;
	}
} else if (isset($_GET["nom"])) {
	if (strlen($_GET["nom"]) < 1) {
		$mesanje = "El Nombre del Concesionario NO debe estar en blanco";
	} else {
		$valid = "true";
		$mesanje = "";
	}
}

echo $valid . "||" . $mesanje;
