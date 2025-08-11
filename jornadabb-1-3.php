<?
require_once('codebase/php/grid_connector.php');
require_once('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
global $server;
global $user;
global $clv;
global $db;

$fc = $_REQUEST["fc"];
$Abanca = $_REQUEST["Abanca"];

$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);

$grid = new GridConnector($res);

$grid->event->attach("beforeRender", "formatting");

if ($Abanca == 0) :
	$grid->render_sql("SELECT * From _jornadabb where  Fecha='" . $fc . "' Order by IDB Asc", "", "IDJ,Grupo,Partidos,IDB,Grupo1,IDB1");
else :
	$grid->render_sql("SELECT * From _jornadabb where  Fecha='" . $fc . "' and IDB=$Abanca Order by IDB Asc", "", "IDJ,Grupo,Partidos,IDB,Grupo1,IDB1");
endif;


function formatting($row)
{


	$valor = $row->get_value("Grupo");
	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd where Grupo=$valor");
	$rowj = mysqli_fetch_array($resultj);
	$row->set_value("Grupo", $rowj['Descripcion']);
	$row->set_value("Grupo1", $valor);

	$valor = $row->get_value("IDB");
	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbanca where IDB=$valor");
	$rowj = mysqli_fetch_array($resultj);
	$row->set_value("IDB", $rowj['NombreB']);
	$row->set_value("IDB1", $valor);
}
