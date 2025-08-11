<?
require_once('codebase/php/grid_connector.php');
require_once('prc_php.php');
global $server;
global $user;
global $clv;
global $db;


$Grupo = $_REQUEST['Grupo'];


$GLOBALS['link'] = Connection::getInstance();
$Descrip = array();
$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tbjuegodd where Grupo=$Grupo");

while ($row = mysqli_fetch_array($result2))
	$Descrip[$row['IDDD']] = $row['Descripcion'];

$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);

$grid = new GridConnector($res);

$grid->event->attach("beforeRender", "formatting");
$grid->render_sql("SELECT *  FROM _tbvalidarlogros  WHERE IDDD In (Select IDDD from _tbjuegodd where Grupo=$Grupo)", "Idval", "Idval,Descrip1,op,rangoLogro,rangoCarrera,Descrip2,EVE,IDDD,IDDDcmp");



function formatting($row)
{
	global $Descrip;

	$row->set_value("Descrip1", $Descrip[$row->get_value("IDDD")]);
	$row->set_value("Descrip2", $Descrip[$row->get_value("IDDDcmp")]);
}
