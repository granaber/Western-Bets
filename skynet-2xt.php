<?
require_once('codebase/php/grid_connector.php');
require_once('prc_skynet.php');
$GLOBALS['link'] = Skynet::getInstance();
global $server1;
global $user1;
global $clv1;
global $db1;

$fc = explode("/", $_REQUEST["fc"]);
if (strlen($fc[1]) == 1) : $fc[1] = '0' . $fc[1];
endif;
if (strlen($fc[0]) == 1) : $fc[0] = '0' . $fc[0];
endif;
$fechaactual = $fc[2] . $fc[1] . $fc[0];

$IDJsk = 0;
$result = mysqli_query($GLOBALS['link'], "Select * From _tbjornadaNT Where fecha>=" . $fechaactual . " ORDER BY fecha ASC ");
//echo ("Select * From _tbjornada Where gmdt='".$fechaactual."'"); 
if (mysqli_num_rows($result) != 0) :
	$row = mysqli_fetch_array($result);
	$IDJsk = $row['IDJsk'];
endif;
//echo "SELECT * From _tbligas where  IDJsk=".$IDJsk." and Liga in (select Liga from _tbvalidas where estatus=1)";

$res = mysqli_connect($server1, $user1, $clv1);
mysql_select_db($db1);

$grid = new GridConnector($res);

//$grid->event->attach("beforeRender","formatting");


$grid->render_sql("SELECT * From _tbligasNT where  fecha>=" . $IDJsk . " and Liga in (select Liga from _tbvalidas where estatus=1)", "Liga", "sel,Liga,Descripcion");

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
