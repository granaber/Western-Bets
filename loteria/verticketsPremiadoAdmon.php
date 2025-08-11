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

$filter1 = new OptionsConnector($res);
$filter1->render_table("_tagencias", "IDC", "Descripcion(value)");
$grid->set_options("Descripcion", $filter1);


$grid->event->attach("beforeRender", "formatting");
if (isset($_REQUEST['Fecha'])) :
	if (isset($_REQUEST['dhx_filter'])) :
		$search = $_REQUEST['dhx_filter'];

		if ($search[0] != '') :

			$grid->render_sql('SELECT _tbjugadapremio.serial as SeriaK,sum(premio) as premio,Fecha,Hora,Monto,_tagencias.Descripcion,_tjugada.activo  FROM _tjugada,_tjornada,_tbjugadapremio,_tagencias  where  _tjugada.serial=_tbjugadapremio.serial and _tagencias.IDC=_tjugada.IDC and _tjugada.IDJ=_tjornada.IDJ and _tbjugadapremio.serial=' . $search[0] . '  group by _tbjugadapremio.serial ', "SeriaK", "SeriaK,Descripcion,Fecha,Hora,Monto,premio");

		else :
			$IDJ = Jornada($_COOKIE['FechaCookie'], false);
			if ($search[1] != '') :
				$grid->render_sql('SELECT _tbjugadapremio.serial as Serial,sum(premio) as premio,Fecha,Hora,Monto,_tagencias.Descripcion,_tjugada.activo  FROM _tjugada,_tjornada,_tbjugadapremio,_tagencias  where  _tjugada.serial=_tbjugadapremio.serial and _tagencias.IDC=_tjugada.IDC and _tjugada.IDJ=_tjornada.IDJ   group by _tbjugadapremio.serial ', "Serial", "Serial,Descripcion,Fecha,Hora,Monto,premio");
			else :
				$grid->render_sql('SELECT _tbjugadapremio.serial as Serial,sum(premio) as premio,Fecha,Hora,Monto,_tagencias.Descripcion,_tjugada.activo  FROM _tjugada,_tjornada,_tbjugadapremio,_tagencias  where  _tjugada.serial=_tbjugadapremio.serial and _tagencias.IDC=_tjugada.IDC and _tjugada.IDJ=_tjornada.IDJ and _tjugada.IDJ=' . $IDJ . '  group by _tbjugadapremio.serial ', "Serial", "Serial,Descripcion,Fecha,Hora,Monto,premio");
			endif;

		endif;

	else :
		$grid->render_sql('SELECT _tbjugadapremio.serial as Serial,sum(premio) as premio,Fecha,Hora,Monto,_tagencias.Descripcion,_tjugada.activo  FROM _tjugada,_tjornada,_tbjugadapremio,_tagencias  where  _tjugada.serial=_tbjugadapremio.serial and _tagencias.IDC=_tjugada.IDC and _tjugada.IDJ=_tjornada.IDJ and _tjugada.IDJ=' . $IDJ . '  group by _tbjugadapremio.serial ', "Serial", "Serial,Descripcion,Fecha,Hora,Monto,premio");
	endif;
else :
	$grid->render_sql("SELECT _tbjugadapremio.serial as Serial,sum(premio) as premio,Fecha,Hora,Monto,_tagencias.Descripcion,_tjugada.activo FROM _tjugada,_tjornada,_tbjugadapremio,_tagencias  where  _tjugada.serial=_tbjugadapremio.serial and _tagencias.IDC=_tjugada.IDC and _tjugada.IDJ=_tjornada.IDJ and _tbjugadapremio.serial=" . $Serial . "  group by _tbjugadapremio.serial ", "Serial", "Serial,Descripcion,Fecha,Hora,Monto,premio");
endif;


function formatting($row)
{
	if ($row->get_value("activo") == 0) :
		$serial = $row->get_value("Serial");
		$row->set_value("Serial", $serial * -1);
	endif;
	$premio = $row->get_value("premio");
	$Monto = $row->get_value("Monto");
	$row->set_value("premio", number_format($premio, 2, ',', '.'));
	$row->set_value("Monto", number_format($Monto, 2, ',', '.'));
}
