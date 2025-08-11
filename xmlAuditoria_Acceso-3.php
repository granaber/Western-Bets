<?
require_once('codebase/php/grid_connector.php');
require_once('prc_php.php');
global $server;
global $user;
global $clv;
global $db;

$IDusu = $_REQUEST['IDusu'];
$IDM = $_REQUEST['IDM'];
$logs = array(0, -1, -2, -3, -4);
$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);

$grid = new GridConnector($res);
$grid->event->attach("beforeRender", "formatting");

$grid->render_sql("SELECT * FROM _auditoria_accesos WHERE IDusu=$IDusu and IDM=" . $logs[$IDM], "idacceso", "idacceso,fecha,hora,actividad,estatus");

function formatting($row)
{
	global $noCombinar;

	if ($row->get_value("estatus") == 1) :
		$row->set_value('estatus', 'OK');
	else :
		$row->set_value('estatus', 'Fallo!');
		$row->set_cell_style('estatus', "color:red; ");
	endif;
}
