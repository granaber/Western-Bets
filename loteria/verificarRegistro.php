<?

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$OKey = false;
$sql = ("SELECT * FROM _registros_de_acceso where   IDusu=" . $_REQUEST['idusert']);

$resulYK = mysqli_query($GLOBALS['link'], $sql);
if (mysqli_num_rows($resulYK) != 0) :
	$row = mysqli_fetch_array($resulYK);

	$listado = explode('|', $_REQUEST['codigo']);

	$listadogenerado = explode('-', $row['SerialGenerado']);

	if (count($listadogenerado) > 1) :
		$revisado = 0;
		for ($i = 0; $i <= 3; $i++) {

			if ($listado[$i] ==	$listadogenerado[$i]) :
				$revisado++;
			endif;
		}

		if ($revisado == 4) :
			//$result = mysqli_query($GLOBALS['link'],"Update  _registros_de_acceso  Set Nuevo=0 where IDusu=".$_REQUEST['idusert']);	
			$OKey = true;
		endif;
	endif;

endif;

echo json_encode($OKey);
