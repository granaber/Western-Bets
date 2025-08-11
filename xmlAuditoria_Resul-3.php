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
$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM `_auditoria_logros_ext2` WHERE idj = $IDJ and Grupo=$Grupo Order by IDP");
//echo ("SELECT * FROM `_auditoria_logros` WHERE idj = $IDJ and Grupo=$Grupo And IDB=$IDB  Order by IDP,IDDD" );
$listaModi = array();
$i = 0;
while ($row = mysqli_fetch_array($result2))
	if (isset($listaModi[$row['IDP']][$row['IDCNGE']])) :  $listaModi[$row['IDP']][$row['IDCNGE']]++;
	else :  $listaModi[$row['IDP']][$row['IDCNGE']] = 1;
	endif;

$listaIDD = '';
$i = 1;
$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _cngescrute order by posicion");
while ($Row = mysqli_fetch_array($resultj)) {
	$IDDD = explode('|', $Row['IDDD_AESC']);
	for ($l = 0; $l <= count($IDDD) - 1; $l++) {
		$resultj2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where IDDD=" . $IDDD[$l] . " and Grupo=$Grupo");
		if (mysqli_num_rows($resultj2) != 0) :
			$Row2 = mysqli_fetch_array($resultj2);
			$listaIDD .= $Row['IDCNGE'] . ',';
			$i++;
			break;
		endif;
	}
}

$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbescrute WHERE idj = $IDJ and Grupo=$Grupo Order by IDP");
$lista = array();
while ($row = mysqli_fetch_array($result2)) {
	$lista[$row['IDP']] = $row['Escrute'];
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


	$resultEqu = mysqli_query($GLOBALS['link'], "SELECT * FROM `_equiposbb` WHERE IDE = " . $data->get_value("IDE1"));
	$rowEqu = mysqli_fetch_array($resultEqu);
	$data->set_value("IDE1", htmlentities($rowEqu['Descripcion']));




	$resultEqu = mysqli_query($GLOBALS['link'], "SELECT * FROM `_equiposbb` WHERE IDE = " . $data->get_value("IDE2"));
	$rowEqu = mysqli_fetch_array($resultEqu);
	$data->set_value("IDE2", htmlentities($rowEqu['Descripcion']));

	$IDP = $data->get_value("IDP");
	$valores = explode('|', $lista[$IDP]);

	for ($x = 1; $x <= count($valores) - 1; $x += 2) {
		if ($valores[$x] == '!-!-') :
			$data->set_value(strval($valores[$x - 1]), 'SUSPENDIDO');
		else :
			$valores1 = explode('-', $valores[$x]);

			$resultj2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cngescrute where IDCNGE=" . $valores[$x - 1]);
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
					if (($valores1[0]) == 'NaN') :  $ValoresK = 'SUPENDIDO';
					else : if ($valores1[0] == 1) : $ValoresK = 'SI - NO';
						endif;
					endif;
					if (($valores1[1]) == 'NaN') :  $ValoresK = 'SUPENDIDO';
					else : if ($valores1[1] == 1) : $ValoresK = 'NO - SI';
						endif;
					endif;
					break;
			}


			$data->set_value(strval($valores[$x - 1]),  $ValoresK);
		endif;
		if (isset($listaModi[$IDP][strval($valores[$x - 1])])) :
			if ($listaModi[$IDP][strval($valores[$x - 1])] > 1) :
				$data->set_cell_style(strval($valores[$x - 1]), "background:#900; color:#FFF; font:bold");
			else :
				$data->set_cell_style(strval($valores[$x - 1]), "text-decoration:underline");
			endif;
		endif;
	}
}
