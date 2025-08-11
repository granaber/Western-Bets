<?php

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$op = $_REQUEST['op'];
$IDCN = $_REQUEST['IDCN'];

if ($op == 1) :
	$LNE = $_REQUEST['LNE'];
	$LNCi = $_REQUEST['LNC'];

	$ldc = explode('*', $LNE);
	$ldci = explode('|', $LNCi);

	for ($i = 1; $i <= count($ldc) - 2; $i += 2) {
		$lde = explode('|', $ldc[$i]);
		for ($j = 0; $j <= count($lde) - 2; $j++) {
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tabladetablas where  IDCN=" . $IDCN . " and Carr=" . $ldc[$i - 1] . " and Noeje=" . ($j + 1));

			if (mysqli_num_rows($result) == 0) :
				$result = mysqli_query($GLOBALS['link'], "Insert  _tabladetablas values (" . $IDCN . "," . $ldc[$i - 1] . "," . ($j + 1) . "," . $lde[$j] . ")");
			/*  echo "Insert  _tabladetablas values (".$IDCN.",".$ldc[$i-1].",".($j+1).",".$lde[$j].")"; */
			else :
				$result = mysqli_query($GLOBALS['link'], "Update  _tabladetablas  set logros=" . $lde[$j] . " where  IDCN=" . $IDCN . " and Carr=" . $ldc[$i - 1] . " and Noeje=" . ($j + 1));
			endif;
		}

		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tabladetablascnf where  IDCN=" . $IDCN . " and Carr=" . $ldc[$i - 1]);

		if (mysqli_num_rows($result) == 0) :
			$result = mysqli_query($GLOBALS['link'], "Insert  _tabladetablascnf values (" . $IDCN . "," . $ldc[$i - 1] . "," . $LNCi[$i - 1] . ")");
		/*  echo "Insert  _tabladetablas values (".$IDCN.",".$ldc[$i-1].",".($j+1).",".$lde[$j].")"; */
		else :
			$result = mysqli_query($GLOBALS['link'], "Update  _tabladetablascnf  set Estatus=" . $LNCi[$i - 1] . " where  IDCN=" . $IDCN . " and Carr=" . $ldc[$i - 1]);
		endif;
	}
	echo "Informacion Grabada...";
endif;
