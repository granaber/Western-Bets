<?

require_once('prc_php.php');

if (isset($_REQUEST['Fecha'])) :
	$GLOBALS['link'] = Connection::getInstance();
	$IDJ = Jornada($_REQUEST['Fecha'], false);
else :
	$Serial = $_REQUEST['Serial'];
endif;

require_once('codebase/php/grid_connector.php');
global $server;
global $user;
global $clv;
global $db;



$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);

$grid = new GridConnector($res);
//$grid->render_table("_tusu","IDusu","IDusu,Usuario,Estatus");

//$grid->sql->attach("Update","Update _tusu set Estatus={Estatus} where IDusu={IDusu}");
$grid->event->attach("beforeUpdate", "my_update");
//$grid->event->attach("beforeOutput","color_rows");
$grid->event->attach("beforeRender", "color_rows");
if (isset($_REQUEST['Fecha'])) :
	$grid->render_sql("Select * from _tjugada,_tjornada where _tjugada.IDJ=_tjornada.IDJ and _tjugada.IDJ=" . $IDJ . " and IDC=" . $_COOKIE['IDC'], "Serial", "Serial,Fecha,Hora,Monto");
else :
	$grid->render_sql("Select * from _tjugada,_tjornada where _tjugada.IDJ=_tjornada.IDJ and IDC=" . $_COOKIE['IDC'] . " and Serial=" . $Serial, "Serial", "Serial,Fecha,Hora,Monto");
endif;

function my_update($data)
{
}
function color_rows($row)
{
	if ($row->get_value("activo") == 0) {
		$row->set_row_color("#3399FF");
	}
}
