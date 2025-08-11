<?

require_once('codebase/php/grid_connector.php');
require_once('prc_php.php');
global $server;
global $user;
global $clv;
global $db;


$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);

$grid = new GridConnector($res);
//$grid->render_table("_tusu","IDusu","IDusu,Usuario,Estatus");
//$grid->sql->attach("Update","Update _tusu set Estatus={Estatus} where IDusu={IDusu}");
//$grid->event->attach("beforeUpdate","my_update");
//$grid->event->attach("beforeProcessing","formatting");

$grid->render_sql("SELECT Cantidad,TxtDenomiacion,Cantidad as Cantidad2,_tbdenominaciones.Denominacion FROM _tbdenominaciones  LEFT JOIN _tbcuadre_denominacion  ON _tbdenominaciones.Denominacion=_tbcuadre_denominacion.Denominacion and IDCierre=" . $_REQUEST['IDCierre'] . " Order by posicion asc", "Denominacion", "Cantidad,TxtDenomiacion,Cantidad2,Denominacion");

function formatting($row)
{
	$row->add_field('Total', '0');
}
