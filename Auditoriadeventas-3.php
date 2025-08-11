<?
require_once('codebase/php/grid_connector.php');
require_once('prc_php.php');
global $server;
global $user;
global $clv;
global $db;


$IDJ = $_REQUEST['IDJ'];
$Grupo = $_REQUEST['Grupo'];
$IDB = $_REQUEST['IDB'];



$GLOBALS['link'] = Connection::getInstance();
$listaIDD = '';
$i = 1;
$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tbjuegodd  where Grupo=$Grupo ORDER BY  _tbjuegodd.Formato");
while ($row = mysqli_fetch_array($result2)) {
	$listaIDD .= $row['IDDD'] . ',';
	$i++;
}

$result2 = mysqli_query($GLOBALS['link'], "SELECT _configuracionjugadabb . *
FROM `_configuracionjugadabb` , _formatosbb, _tbjuegodd
WHERE _configuracionjugadabb.IDDD = _tbjuegodd.IDDD
AND _tbjuegodd.Formato = _formatosbb.Formato
AND _configuracionjugadabb.idj =$IDJ 
AND _configuracionjugadabb.Grupo =$Grupo
AND _configuracionjugadabb.IDB =$IDB
ORDER BY IDP, _tbjuegodd.Formato, _configuracionjugadabb.IDDD");
$lista = array();
while ($row = mysqli_fetch_array($result2)) {
	$lista[$row['IDP']][$row['IDDD']] = $row['Valores'];
}
$partido = 1;
$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);
$grid = new GridConnector($res);
$grid->event->attach("beforeRender", "formatting");
$grid->render_sql("Select * from _partidosbb Where IDJ = $IDJ and Grupo=$Grupo And IDB=1", "IDP", "IDP,Hora,uno,IDE1,dos,IDE2," . $listaIDD);





function formatting($data)
{
	global $lista;
	global $partido;
	global $listaModi;
	$hora = $data->get_value("Hora");
	$data->set_value("Hora", HoraNormal($hora));
	$data->set_value("uno", 0);
	$resultEqu = mysqli_query($GLOBALS['link'], "SELECT * FROM `_equiposbb` WHERE IDE = " . $data->get_value("IDE1"));
	$rowEqu = mysqli_fetch_array($resultEqu);
	$data->set_value("IDE1", htmlentities($rowEqu['Descripcion']));
	$data->set_value("dos", 0);
	$resultEqu = mysqli_query($GLOBALS['link'], "SELECT * FROM `_equiposbb` WHERE IDE = " . $data->get_value("IDE2"));
	$rowEqu = mysqli_fetch_array($resultEqu);
	$data->set_value("IDE2", htmlentities($rowEqu['Descripcion']));


	foreach ($lista[$partido] as $vector => $index) {

		$data->set_value(strval($vector), 0);
	}

	$partido++;
}
