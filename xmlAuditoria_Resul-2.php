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
$IDP = $_REQUEST['IDP'];
$IDDD = $_REQUEST['IDDD'];

$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);
$grid = new GridConnector($res);
$grid->event->attach("beforeRender", "formatting");
$grid->render_sql("SELECT _auditoria_logros_ext2.*,_tusu.Usuario as NombreUsu FROM `_auditoria_logros_ext2`, _tusu WHERE _auditoria_logros_ext2.IDusu= _tusu.IDusu and idj = $IDJ and Grupo=$Grupo And IDP=$IDP and IDCNGE=$IDDD  order by IdAudi Desc", "IdAudi", "dat_hour,Despues,Ahora,NombreUsu");




function formatting($data)
{
	global $IDDD;



	if ($data->get_value("Despues") != 'Nuevo') :
		if ($data->get_value("Despues") == '!-!-') :
			$data->set_value("Despues", 'SUSPENDIDO');
		else :
			$valores1 = explode('-', $data->get_value("Despues"));
			$resultj2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cngescrute where IDCNGE=" . $IDDD);
			$Row2 = mysqli_fetch_array($resultj2);
			switch ($Row2['Formato']) {
				case 1:
				case 3:
					if (($valores1[0]) == 'NaN') :  $ValoresK = 'SUPENDIDO';
					else : $ValoresK = $valores1[0] . ' - ' . $valores1[1];
					endif;
					break;
				case 2:
				case 4:
					if ($valores1[0] == 1) : $ValoresK = 'SI - NO';
					endif;
					if ($valores1[1] == 1) : $ValoresK = 'NO - SI';
					endif;
					break;
			}
			$data->set_value("Despues",  $ValoresK);
		endif;
	else :
		$resultj2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cngescrute where IDCNGE=" . $IDDD);
		$Row2 = mysqli_fetch_array($resultj2);
	endif;
	if ($data->get_value("Ahora") == '!-!-') :
		$data->set_value("Ahora", 'SUSPENDIDO');
	else :
		$valores1 = explode('-', $data->get_value("Ahora"));
		switch ($Row2['Formato']) {
			case 1:
			case 3:
				if (($valores1[0]) == 'NaN') : $ValoresK = 'SUPENDIDO';
				else :  $ValoresK = $valores1[0] . ' - ' . $valores1[1];
				endif;
				break;
			case 2:
			case 4:
				if ($valores1[0] == 1) : $ValoresK = 'SI - NO';
				endif;
				if ($valores1[1] == 1) : $ValoresK = 'NO - SI';
				endif;
				break;
		}
		$data->set_value("Ahora",  $ValoresK);
	endif;
}
