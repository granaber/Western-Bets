<?

require('prc_php.php');
require('escruteshi.php');

$GLOBALS['link'] = Connection::getInstance();

$prem = array(false, 0, 0);
$serial = $_REQUEST['serial'];

$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadahi where serial=" . $serial);

if (mysqli_num_rows($result) != 0) :

	$row = mysqli_fetch_array($result);

	if ($row['IDJug'] == 0) :
		$premacion = EscrutarHI($row['Serial'], 1);
		$prem[2] = 0;
		if ($premacion[1] > 0) :
			$prem[0] = true;
			$prem[1] = $premacion[1];
			$prem[3] = $premacion[2];
		endif;
	else :
		$premacion = EscrutarHI($row['Serial'], 1);
		$prem[2] = 1;

		if ($premacion[1] > 0) :
			$prem[0] = true;
			$prem[1] = $premacion[1];
			$prem[3] = $premacion[2];
		endif;
	endif;


else :
	$prem[0] = true;
	$prem[1] = -1;
endif;

echo json_encode($prem);

//   valor True 
//  -1= Ticket No Existe
//  >0= Premiado (Monto de Premio)
//  Valor false : Ticket No Premiado
