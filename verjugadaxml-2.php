<?

require_once('prc_php.php');

/*if (isset($_REQUEST['Fecha'])):
	$GLOBALS['link'] = Connection::getInstance(); 
	$IDJ=Jornada($_REQUEST['Fecha'],false);
else:
	$Serial=$_REQUEST['Serial'];
endif;*/

require_once('codebase/php/grid_connector.php');
global $server;
global $user;
global $clv;
global $db;



$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);

$grid = new GridConnector($res);
$grid->dynamic_loading(100);



$grid->event->attach("beforeRender", "Verificacion");

$grid->render_sql("Select * from _tjugadabb,_jornadabb where _tjugadabb.IDJ=_jornadabb.IDJ", "serial", "serial,IDC,Hora,Fecha,ap,premio,se");

/*	$filter1 = new OptionsConnector($res);
$filter1->render_table("_tagencias","IDC","Descripcion(value)");
$grid->set_options("Descripcion",$filter1);
$grid->render_sql("SELECT _tbjugadapremio.serial as Serial,sum(premio) as premio,Fecha,Hora,Monto FROM _tjugada,_tjornada,_tbjugadapremio  where  _tjugada.serial=_tbjugadapremio.serial and _tjugada.IDJ=_tjornada.IDJ and _tjugada.IDJ=".$IDJ." and _tjugada.activo=1 and IDC=".$_REQUEST['IDCkk'].' group by _tbjugadapremio.serial ',"Serial","Serial,IDC,Hora,Fecha,Monto,premio");



if (isset($_REQUEST['dhx_filter'])):
	 $search=$_REQUEST['dhx_filter'];
	 
	 if ($search[0]!=''):
	   	$grid->render_sql("Select * from _tjugada,_tjornada,_tagencias where _tjugada.IDJ=_tjornada.IDJ and _tagencias.IDC=_tjugada.IDC  and Serial=".$search[0],"Serial","Serial,Descripcion,Fecha,Hora,Monto");
	 else:
	   	if ($search[1]!=''):
	 	$IDJ=Jornada($_COOKIE['FechaCookie'],false);
	   	$grid->render_sql("Select * from _tjugada,_tjornada,_tagencias where _tjugada.IDJ=_tjornada.IDJ and _tagencias.IDC=_tjugada.IDC  and _tagencias.Descripcion='".$search[1]."' and _tjugada.IDJ=".$IDJ." and not serial in (select serial from _tbjugadapremio)","Serial","Serial,Descripcion,Fecha,Hora,Monto");
		else:
			$IDJ=Jornada($_COOKIE['FechaCookie'],false);
			$grid->render_sql("Select * from _tjugada,_tjornada,_tagencias where _tjugada.IDJ=_tjornada.IDJ and _tagencias.IDC=_tjugada.IDC and _tjugada.IDJ=".$IDJ." and not serial in (select serial from _tbjugadapremio)","Serial","Serial,Descripcion,Fecha,Hora,Monto");

		endif;
	 endif;*/

function Verificacion($row)
{
	$serial = $row->get_value("serial");
	switch (vescruteBytree($serial)) {
		case 2:
			$row->invalid();
			//$row->set_value("Serial",$serial*-1);
			break;
		default:
			$row->invalid();
	}
}
