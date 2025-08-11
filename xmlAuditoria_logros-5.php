<?
require_once('codebase/php/grid_connector.php');
require_once('prc_php.php');
global $server;
global $user;
global $clv;
global $db;


$GLOBALS['link'] = Connection::getInstance();


$IDJ = $_REQUEST['IDJ'];
$Grupo = $_REQUEST['Grupo'];
$IDB = $_REQUEST['IDB'];
$IDP = $_REQUEST['IDP'];
$Tipo = $_REQUEST['Tipo'];

$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);
$grid = new GridConnector($res);
$grid->event->attach("beforeRender", "formatting");
$grid->render_sql("SELECT _auditoria_logros_ext1.*,_tusu.Usuario as NombreUsu FROM `_auditoria_logros_ext1`, _tusu WHERE _auditoria_logros_ext1.IDusu= _tusu.IDusu and idj = $IDJ and Grupo=$Grupo And IDB=$IDB and IDP=$IDP and _auditoria_logros_ext1.Tipo=$Tipo order by IdAudi Desc", "IdAudi", "dat_hour,Despues,Ahora,NombreUsu");


function formatting($data)
{
	global $Tipo;

	/*$hora =explode('-',$data->get_value("dat_hour"));
			$data->set_value("dat_hour", $hora[1] ); */

	if ($Tipo == 1 || $Tipo == 2) :
		if ($data->get_value("Despues") != 'Nuevo') :
			$resultEqu = mysqli_query($GLOBALS['link'], "SELECT * FROM `_equiposbb` WHERE IDE = " . $data->get_value("Despues"));
			$rowEqu = mysqli_fetch_array($resultEqu);
			$data->set_value("Despues", htmlentities($rowEqu['Descripcion']));
		endif;
		if ($data->get_value("Ahora") != 'Nuevo') :
			$resultEqu = mysqli_query($GLOBALS['link'], "SELECT * FROM `_equiposbb` WHERE IDE = " . $data->get_value("Ahora"));
			$rowEqu = mysqli_fetch_array($resultEqu);
			$data->set_value("Ahora", htmlentities($rowEqu['Descripcion']));
		endif;
	endif;
}
