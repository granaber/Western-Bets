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
$grid->event->attach("beforeRender", "formatting");
if (isset($_REQUEST['Fecha'])) :
	$grid->render_sql("SELECT _tbjugadapremio.serial as Serial,sum(premio) as premio,Fecha,Hora,Monto FROM _tjugada,_tjornada,_tbjugadapremio  where  _tjugada.serial=_tbjugadapremio.serial and _tjugada.IDJ=_tjornada.IDJ and _tjugada.IDJ=" . $IDJ . " and _tjugada.activo=1 and IDC=" . $_REQUEST['IDCkk'] . ' group by _tbjugadapremio.serial ', "Serial", "Serial,Fecha,Hora,Monto,premio");
else :
	$grid->render_sql("SELECT _tbjugadapremio.serial as Serial,sum(premio) as premio,Fecha,Hora,Monto FROM _tjugada,_tjornada,_tbjugadapremio  where  _tjugada.serial=_tbjugadapremio.serial and _tjugada.IDJ=_tjornada.IDJ and _tbjugadapremio.serial=" . $Serial . " and _tjugada.activo=1 group by _tbjugadapremio.serial ", "Serial", "Serial,Fecha,Hora,Monto,premio");
endif;

function my_update($data)
{
}
function formatting($row)
{
	$premio = $row->get_value("premio");
	$Monto = $row->get_value("Monto");

	$row->set_value("premio", number_format($premio, 2, ',', '.'));
	$row->set_value("Monto", number_format($Monto, 2, ',', '.'));
}
