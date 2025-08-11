<?
require_once('../ganadores/codebase/php/grid_connector.php');
require_once('prc_php.php');
global $server;
global $user;
global $clv;
global $db;

$GLOBALS['link'] = Connection::getInstance();
$IDCN = $_REQUEST['IDCN'];
$carr = $_REQUEST['carr'];

$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);
$grid = new GridConnector($res);


$grid->event->attach("beforeRender", "validate");
$grid->render_sql("Select * from _tbcondiciones where ( DF!=0 or Premio!=0 or Cupo!=0) and IDCN=$IDCN and Carr=" . $carr, "id_tbcondiciones", "Aplica,Seleccion,Ejemplar,DF,Premio,Cupo,nivel,cod");


function validate($data)
{


	switch ($data->get_value("nivel")) {
		case 0:
			$data->set_value('Aplica', 'Todos');
			$data->set_value('Seleccion', 'Todos');
			break;
		case 1:
			$data->set_value('Aplica', 'Grupo');
			$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tgrupo  where IDG=" . $data->get_value("cod"));
			$row2 = mysqli_fetch_array($result2);
			$data->set_value('Seleccion', $row2['Descrip']);
			break;
		case 2:
			$data->set_value('Aplica', 'PV');
			$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tbconcesionario  where IDC='" . $data->get_value("cod") . "'");
			$row2 = mysqli_fetch_array($result2);
			$data->set_value('Seleccion', $data->get_value("cod") . '-' . $row2['Nombre']);
			break;
	}

	if ($data->get_value("DF") == 0)  $data->set_value('DF', '');
	if ($data->get_value("Premio") == 0) $data->set_value('Premio', '');
	if ($data->get_value("Cupo") == 0) $data->set_value('Cupo', '');
}
