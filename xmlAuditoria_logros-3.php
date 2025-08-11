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
$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM `_auditoria_logros` WHERE idj = $IDJ and Grupo=$Grupo And IDB=$IDB and (`Valores`!='||' and `Valores`!='||||')  Order by IDP,IDDD");
//echo ("SELECT * FROM `_auditoria_logros` WHERE idj = $IDJ and Grupo=$Grupo And IDB=$IDB  Order by IDP,IDDD" );
$listaModi = array();
$i = 0;
while ($row = mysqli_fetch_array($result2))
	$listaModi[$row['IDP']][$row['IDDD']] = 1;

$listaIDD = '';
$i = 1;
$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tbjuegodd  where Grupo=$Grupo ORDER BY  _tbjuegodd.Formato,IDDD");
while ($row = mysqli_fetch_array($result2)) {
	$listaIDD .= $row['IDDD'] . ',';
	$i++;
}


$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM `_auditoria_logros_ext1` WHERE idj = $IDJ and Grupo=$Grupo And IDB=$IDB  Order by IDP");
$ListaEquiHore = array();
while ($row = mysqli_fetch_array($result2))
	if (isset($ListaEquiHore[$row['IDP']][$row['Tipo']])) : $ListaEquiHore[$row['IDP']][$row['Tipo']]++;
	else : $ListaEquiHore[$row['IDP']][$row['Tipo']] = 1;
	endif;



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
$grid->render_sql("Select * from _partidosbb Where IDJ = $IDJ and Grupo=$Grupo And IDB=1", "IDP", "IDP,Hora,IDE1,IDE2," . $listaIDD);





function formatting($data)
{
	global $lista;
	global $partido;
	global $listaModi;
	global $ListaEquiHore;
	$IDP = $data->get_value("IDP");

	$hora = $data->get_value("Hora");
	$data->set_value("Hora", HoraNormal($hora));

	if (isset($ListaEquiHore[$IDP][0])) :
		if ($ListaEquiHore[$IDP][0] > 1) :
			$data->set_cell_style("Hora", "background:#900; color:#FFF; font:bold");
		else :
			$data->set_cell_style("Hora", "text-decoration:underline");
		endif;
	endif;

	$resultEqu = mysqli_query($GLOBALS['link'], "SELECT * FROM `_equiposbb` WHERE IDE = " . $data->get_value("IDE1"));
	$rowEqu = mysqli_fetch_array($resultEqu);
	$data->set_value("IDE1", htmlentities($rowEqu['Descripcion']));
	if (isset($ListaEquiHore[$IDP][1])) :
		if ($ListaEquiHore[$IDP][1] > 1) :
			$data->set_cell_style("IDE1", "background:#900; color:#FFF; font:bold");
		else :
			$data->set_cell_style("IDE1", "text-decoration:underline");
		endif;
	endif;



	$resultEqu = mysqli_query($GLOBALS['link'], "SELECT * FROM `_equiposbb` WHERE IDE = " . $data->get_value("IDE2"));
	$rowEqu = mysqli_fetch_array($resultEqu);
	$data->set_value("IDE2", htmlentities($rowEqu['Descripcion']));
	if (isset($ListaEquiHore[$IDP][2])) :
		if ($ListaEquiHore[$IDP][2] > 1) :
			$data->set_cell_style("IDE2", "background:#900; color:#FFF; font:bold");
		else :
			$data->set_cell_style("IDE2", "text-decoration:underline");
		endif;
	endif;


	foreach ($lista[$partido] as $vector => $index) {
		$logros = explode('|', $index);

		$tam = count($logros) - 1;
		switch ($tam) {
			case 2:
				$data->set_value(strval($vector), ($logros[0] . ' / ' . $logros[1]));

				break;
			case 4:
				if ($logros[1] == $logros[3]) :
					$data->set_value(strval($vector), ($logros[0] . ' / ' . $logros[2] . ' (' . ($logros[1]) . ')Ab'));
				else :
					$data->set_value(strval($vector), ($logros[0] . '(' . $logros[1] . ') / ' . $logros[2] . '(' . ($logros[3]) . ')'));
				endif;
				break;
			default:
				$data->set_value(strval($vector),  $logros[0]);
		}
		if (isset($listaModi[$partido][$vector])) :
			$data->set_cell_style(strval($vector), "background:#900; color:#FFF; font:bold");
		endif;
	}


	$partido++;
}
