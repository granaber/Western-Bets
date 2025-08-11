<?
// ********** Creacion de archivo XML ************

require_once('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$IDJ = Jornada($_REQUEST['Fecha'], false);

require_once('codebase/php/grid_connector.php');
global $server;
global $user;
global $clv;
global $db;



$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);



$grid = new GridConnector($res);
//$grid->render_table("_tusu","IDusu","IDusu,Usuario,Estatus");

//$grid->sql->attach("Update","Update _tusu set Estatus={Estatus} where IDusu={IDusu}");
$grid->event->attach("beforeUpdate", "my_update");
//$grid->event->attach("beforeOutput","color_rows");
$grid->event->attach("beforeRender", "color_rows");

$grid->render_sql("SELECT * FROM _tloteria where Estatus=1 Order by IDLot", "IDLot", "imagen,NombrePantalla,IDLot,NombreTicket");

function my_update($data)
{
}
function color_rows($row)
{
	$GLOBALS['link'] = Connection::getInstance();
	$resultado = CkqCierreLoteria($row->get_value("IDLot"), 0);
	if ($resultado[0]) :
		$exvalor = $row->get_value("imagen");
		$row->set_value('imagen', "images/logo/" . $exvalor);
		return false;
	else :

		return true;
	endif;
}
