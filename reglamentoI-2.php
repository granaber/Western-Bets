<?
require_once('codebase/php/grid_connector.php');
require_once('prc_php.php');
global $server;
global $user;
global $clv;
global $db;


$Grupo = $_REQUEST['Grupo'];
$IDC = $_REQUEST['IDC'];
$IDG = $_REQUEST['IDG'];

$GLOBALS['link'] = Connection::getInstance();
$deDerecho[0] = false;
$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tbreglas_1  Where IDC='$IDC' and IDG=$IDG and IDDD in (SELECT IDDD  FROM _tbjuegodd  where Grupo=$Grupo )");

while ($row = mysqli_fetch_array($result2)) {
	$deDerecho[0] = true;
	$deDerecho[$row['IDDD']]['monto'] = $row['monto'];
	$deDerecho[$row['IDDD']]['bloqueo'] = $row['bloqueo'];
}

$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);

$grid = new GridConnector($res);

$grid->event->attach("beforeRender", "formatting");
$grid->render_sql("SELECT *  FROM _tbjuegodd  WHERE grupo=$Grupo ", "IDDD", "Descripcion,Monto,Bloqueo,IDDD");



function formatting($row)
{
	global $deDerecho;
	if ($row->get_value("Monto") == '') :
		if ($deDerecho[0] && isset($deDerecho[$row->get_value("IDDD")]['monto'])) :
			$row->set_value("Monto", $deDerecho[$row->get_value("IDDD")]['monto']);
			$row->set_value("Bloqueo", $deDerecho[$row->get_value("IDDD")]['bloqueo']);
		else :
			$row->set_value("Monto", 0);
		endif;
	else :
		if ($deDerecho[0] && isset($deDerecho[$row->get_value("IDDD")]['monto'])) :
			$row->set_value("Monto", $deDerecho[$row->get_value("IDDD")]['monto']);
			$row->set_value("Bloqueo", $deDerecho[$row->get_value("IDDD")]['bloqueo']);
		endif;
	endif;
}
