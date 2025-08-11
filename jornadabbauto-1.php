<?
require_once('codebase/php/grid_connector.php');
require_once('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
global $server;
global $user;
global $clv;
global $db;

$Grupo = $_REQUEST["Grupo"];
$idj = $_REQUEST["idj"];
$idb = $_REQUEST["idb"];

$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);

$grid = new GridConnector($res);

$grid->event->attach("beforeRender", "formatting");


$grid->render_sql("SELECT * From _tbjuegodd where  Grupo=" . $Grupo . " order by Formato,IDDD ASC", "", "op,Descripcion,opFormato,IDDD");


function formatting($row)
{
	global $Grupo;
	global $idj;
	global $idb;

	$valor = $row->get_value("IDDD");
	$valorIDD = $valor;
	$resultj = mysqli_query($GLOBALS['link'], "SELECT _formatosbb.Descripcion FROM _tbjuegodd,_formatosbb WHERE _tbjuegodd.Formato=_formatosbb.Formato and IDDD=$valor");
	$rowj = mysqli_fetch_array($resultj);
	$row->set_value("opFormato", $rowj['Descripcion']);

	$valor = $row->get_value("IDB");
	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _agendaNT where 	grupo=$Grupo and idj=$idj and idb=$idb");
	$rowj = mysqli_fetch_array($resultj);
	$varl = explode(',', $rowj['IDDDs']);
	for ($i = 0; $i <= count($varl) - 1; $i++)
		if ($varl[$i] == $valorIDD)
			$row->set_value("op", 1);
}
