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
$grid->dynamic_loading(100);

//$grid->render_table("_tusu","IDusu","IDusu,Usuario,Estatus");
//$grid->sql->attach("Update","Update _tusu set Estatus={Estatus} where IDusu={IDusu}");
$filter1 = new OptionsConnector($res);
$filter1->render_table("_tagencias", "IDC", "Descripcion(value)");
$grid->set_options("Descripcion", $filter1);



$grid->event->attach("beforeRender", "color_rows");
if (isset($_REQUEST['Fecha'])) :
	if (isset($_REQUEST['dhx_filter'])) :
		$search = $_REQUEST['dhx_filter'];

		if ($search[0] != '') :
			$grid->render_sql("Select * from _tjugada,_tjornada,_tagencias where _tjugada.IDJ=_tjornada.IDJ and _tagencias.IDC=_tjugada.IDC  and Serial=" . $search[0], "Serial", "Serial,Descripcion,Fecha,Hora,Monto");
		else :
			if ($search[1] != '') :
				$IDJ = Jornada($_COOKIE['FechaCookie'], false);
				$grid->render_sql("Select * from _tjugada,_tjornada,_tagencias where _tjugada.IDJ=_tjornada.IDJ and _tagencias.IDC=_tjugada.IDC  and _tagencias.Descripcion='" . $search[1] . "' and _tjugada.IDJ=" . $IDJ . " and not serial in (select serial from _tbjugadapremio)", "Serial", "Serial,Descripcion,Fecha,Hora,Monto");
			else :
				$IDJ = Jornada($_COOKIE['FechaCookie'], false);
				$grid->render_sql("Select * from _tjugada,_tjornada,_tagencias where _tjugada.IDJ=_tjornada.IDJ and _tagencias.IDC=_tjugada.IDC and _tjugada.IDJ=" . $IDJ . " and not serial in (select serial from _tbjugadapremio)", "Serial", "Serial,Descripcion,Fecha,Hora,Monto");

			endif;
		endif;

	else :
		//echo ("Select * from _tjugada,_tjornada,_tagencias where _tjugada.IDJ=_tjornada.IDJ and _tagencias.IDC=_tjugada.IDC and _tjugada.IDJ=".$IDJ." and not serial in (select serial from _tbjugadapremio)");
		$grid->render_sql("Select * from _tjugada,_tjornada,_tagencias where _tjugada.IDJ=_tjornada.IDJ and _tagencias.IDC=_tjugada.IDC and _tjugada.IDJ=" . $IDJ . " and not serial in (select serial from _tbjugadapremio)", "Serial", "Serial,Descripcion,Fecha,Hora,Monto");

	endif;
else :
	$grid->render_sql("Select * from _tjugada,_tjornada,_tagencias where _tjugada.IDJ=_tjornada.IDJ and _tagencias.IDC=_tjugada.IDC and Serial=" . $Serial . " and not serial in (select serial from _tbjugadapremio)", "Serial", "Serial,Descripcion,Fecha,Hora,Monto");
endif;



function color_rows($row)
{
	if ($row->get_value("activo") == 0) {
		$row->set_row_color("#3399FF");
		$serial = $row->get_value("Serial");
		$row->set_value("Serial", $serial * -1);
	}
}
