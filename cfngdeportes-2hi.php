<?php

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$IDCN = $_REQUEST['IDCN'];
$LNE = $_REQUEST['LNE'];

$ldc = explode('*', $LNE);

for ($i = 1; $i <= count($ldc) - 2; $i += 2) {
	$lde = explode('|', $ldc[$i]);
	for ($j = 0; $j <= count($lde) - 2; $j++) {
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tablaejempleareshi where  IDCN=" . $IDCN . " and Carr=" . $ldc[$i - 1] . " and Noeje=" . ($j + 1));

		if (mysqli_num_rows($result) == 0) :
			$result = mysqli_query($GLOBALS['link'], "Insert  _tablaejempleareshi values (" . $IDCN . "," . $ldc[$i - 1] . "," . ($j + 1) . ",'" . $lde[$j] . "')");
		else :
			$result = mysqli_query($GLOBALS['link'], "Update  _tablaejempleareshi  set Nombre='" . $lde[$j] . "' where  IDCN=" . $IDCN . " and Carr=" . $ldc[$i - 1] . " and Noeje=" . ($j + 1));
		endif;
	}
}
echo "Informacion Grabada...";
