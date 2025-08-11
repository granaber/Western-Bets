<?php
require_once('prc_php.php');

$GLOBALS['link'] = Connection::getInstance();

$msg = array();
$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where Estatus=1 and fecha='" . date("d/n/Y") . "' order by IDCN");

if (mysqli_num_rows($result3) != 0) :
	$row3 = mysqli_fetch_array($result3);
	$IDCN = $row3['IDCN'];
	$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfig where IDCN=" . $IDCN);

	if (mysqli_num_rows($result3) != 0) :

		$row3 = mysqli_fetch_array($result3);
		$retirados = explode('|', $row3['_Ret']);
		$msg[1] = '<span  style="color: #FFCC33; font-size:11px">(' . date("d/n/Y") . '): ';

		for ($i = 0; $i <= count($retirados); $i++) {
			if ($retirados[$i] != '') :
				$msg[1] = $msg[1] . ($i + 1) . ')' . $retirados[$i] . '&nbsp;&nbsp;';
			endif;
		}

		$msg[1] = $msg[1] . '</span>';
	else :
		$msg[1] = '<span  style="color: #FFFFFF; font-size:10px"> </span>';
	endif;

	$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _ganadores where IDCN=" . $IDCN . " order by carr");
	if (mysqli_num_rows($result3) != 0) :
		$msg[3] = '<span  style="color: #FFCC33; font-size:11px">(' . date("d/n/Y") . '): ';
		while ($row3 = mysqli_fetch_array($result3)) {
			if ($row3['cirr'] == 1) :
				$ganadores = explode('|', $row3['ganadores']);
				$msg[3] = $msg[3] . $row3['carr'] . ')';
				for ($i = 0; $i <= count($ganadores); $i++) {
					if ($ganadores[$i] != '0' && $ganadores[$i] != '') :
						$msg[3] = $msg[3] . $ganadores[$i] . '-';
					endif;
				}
				$msg[3] = $msg[3] . '&nbsp;&nbsp;';
				if ($row3['carr'] == 5) : $msg[3] = $msg[3] . '<br>';
				endif;
			endif;
		}

		$msg[3] = $msg[3] . '</span>';
	else :
		$msg[3] = '<span  style="color: #FFFFFF; font-size:10px"> </span>';
	endif;

else :
	$msg[1] = '<span  style="color: #FFFFFF; font-size:10px"> </span>';
	$msg[3] = '<span  style="color: #FFFFFF; font-size:11px"> </span>';
endif;






$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _tablademensajes ");
if (mysqli_num_rows($resultp) == 0) :
	$msg[0] = 'NaN';
	$msg[2] = '<span  style="color: #FFFFFF; font-size:10px"></span>';
	$msg[4] = '<span  style="color: #FFFFFF; font-size:11px"></span>';
else :
	$row2 = mysqli_fetch_array($resultp);
	$msg[0] = $row2['fecha'];
	$msg[2] = '<span  style="color: #FFCC33; font-size:11px">' . nl2br($row2['Mensajemcu']) . ' </span>';
	$msg[4] = '<span  style="color: #FFFFFF; font-size:11px"> ' . nl2br($row2['Mensaje']) . '</span>';
endif;

echo (json_encode($msg));
