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
$IDP = $_REQUEST['IDP'];
$IDDD = $_REQUEST['IDDD'];

$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);
$grid = new GridConnector($res);
$grid->event->attach("beforeRender", "formatting");
$grid->render_sql("SELECT _auditoria_logros.*,_tusu.Usuario as NombreUsu FROM `_auditoria_logros`, _tusu WHERE _auditoria_logros.IDusu= _tusu.IDusu and idj = $IDJ and Grupo=$Grupo And IDB=$IDB and IDP=$IDP and IDDD=$IDDD  and (Valores<>'||||' and  Valores<>'||' )order by ID_Mod Desc", "ID_Mod", "dat_hour,Valores,ValoresAHO,NombreUsu");




function formatting($data)
{
	global $lista;
	global $partido;
	global $listaModi;
	$hora = explode('-', $data->get_value("dat_hour"));
	$data->set_value("dat_hour", $hora[1]);

	$logros = explode('|', $data->get_value("Valores"));

	$tam = count($logros) - 1;
	switch ($tam) {
		case 2:
			$data->set_value("Valores", ($logros[0] . ' / ' . $logros[1]));
			break;
		case 4:
			if ($logros[1] == $logros[3]) :
				if ($logros[1] != '') :
					$data->set_value("Valores", ($logros[0] . ' / ' . $logros[2] . ' (' . ($logros[1]) . ')Ab'));
				else :
					$data->set_value("Valores", ('S/I'));
				endif;
			else :
				$data->set_value("Valores", ($logros[0] . '(' . $logros[1] . ') / ' . $logros[2] . '(' . ($logros[3]) . ')'));
			endif;
			break;
		default:
			$data->set_value("Valores",  $logros[0]);
	}
	// Logros Actuales 
	$logros = explode('|', $data->get_value("ValoresAHO"));

	$tam = count($logros) - 1;
	switch ($tam) {
		case 2:
			$data->set_value("ValoresAHO", ($logros[0] . ' / ' . $logros[1]));
			break;
		case 4:
			if ($logros[1] == $logros[3]) :
				if ($logros[1] != '') :
					$data->set_value("ValoresAHO", ($logros[0] . ' / ' . $logros[2] . ' (' . ($logros[1]) . ')Ab'));
				else :
					$data->set_value("ValoresAHO", ('S/I'));
				endif;
			else :
				$data->set_value("ValoresAHO", ($logros[0] . '(' . $logros[1] . ') / ' . $logros[2] . '(' . ($logros[3]) . ')'));
			endif;
			break;
		default:
			$data->set_value("ValoresAHO",  $logros[0]);
	}
}
