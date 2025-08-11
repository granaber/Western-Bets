<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$ticket = array();
$serial = $_REQUEST['serial'];

$result = mysqli_query($GLOBALS['link'], "SELECT _tjugadahi.*,_tconsecionario.Direccion FROM _tjugadahi,_tconsecionario where _tjugadahi.IDC=_tconsecionario.IDC  and serial=" . $serial);

$row = mysqli_fetch_array($result);

$ticket[] = $row['Fecha'];
$ticket[] = $row['Hora'];
$ticket[] = $row['Jugada'];
$ticket[] = $row['se'];
$ticket[] = $row['Direccion'];

$resulthiop = mysqli_query($GLOBALS['link'], "SELECT _hipodromoshi.Descripcion FROM _hipodromoshi,_tconfjornadahi where _hipodromoshi._idhipo=_tconfjornadahi.IDhipo  and  IDCN=" . $row['IDCN']);
$rowhip = mysqli_fetch_array($resulthiop);

$ticket[] = $rowhip['Descripcion'];
$ticket[] = $row['carr'];

$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _ticketpagados where serial=" . $serial);
if (mysqli_num_rows($result) == 0) :
	$ticket[] = true;
else :
	$ticket[] = false;
endif;

echo json_encode($ticket);
