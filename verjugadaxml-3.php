<?
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', 'error.log');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once('codebase/php/grid_connector.php');
require_once('prc_php.php');
global $server;
global $user;
global $clv;
global $db;
$IDJ = $_REQUEST['IDJ'];
$IDJ1 = $_REQUEST['IDJ1'];
$Tipo = $_REQUEST['tipo'];
$activo = $_REQUEST['activo'];
$accesogp = $_REQUEST['accesogp'];
$grupo = $_REQUEST['grupo'];
$idbanca = $_REQUEST['idb'];

$GLOBALS['link'] = Connection::getInstance();
/*$result2 = mysqli_query($GLOBALS['link'],"SELECT *  FROM _jornadabb  where IDJ=$IDJ " );
$lista='';
while($row = mysqli_fetch_array($result2)) {
   $lista.=$row['IDDD'].','; 
  }*/

if ($IDJ != 0 && $IDJ1 != 0) :
	$add = array();
	$Fecha = array();
	$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _jornadabb  where IDJ=$IDJ Group by IDJ ");
	$row = mysqli_fetch_array($result2);
	$d1 = $row['Fecha'];
	$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _jornadabb  where IDJ=$IDJ1 Group by IDJ ");
	$row = mysqli_fetch_array($result2);
	$d2 = $row['Fecha'];

	$result = mysqli_query($GLOBALS['link'], "Select IDJ,Fecha From _jornadabb Where STR_TO_DATE(Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('" . $d1 . "','%d/%m/%Y') and STR_TO_DATE('" . $d2 . "','%d/%m/%Y') Group by IDJ Order by IDJ");
	if (mysqli_num_rows($result) != 0) :
		$verdatos = '';
		$i = 1;
		while ($row = mysqli_fetch_array($result)) {
			$verdatos .= ' IDJ=' . $row['IDJ'];
			$Fecha[$row['IDJ']] = $row['Fecha'];
			if ($i < mysqli_num_rows($result)) :
				$verdatos .= ' or ';
				$i++;
			endif;
		}
	else :
		$verdatos = ' IDJ=0 ';
	endif;


	$add1 = " (" . $verdatos . " ) ";

else :
	$Fecha[0] = '';
	if ($IDJ == 0 && $IDJ1 != 0) : $add1 = ' ( IDJ=' . $IDJ1 . ') ';
	endif;
	if ($IDJ != 0 && $IDJ1 == 0) : $add1 = ' ( IDJ=' . $IDJ . ') ';
	endif;
	if ($IDJ == 0 && $IDJ1 == 0) : $add1 = ' ( IDJ=0) ';
	endif;

endif;

// print_r($Fecha);
//echo "Select * from _tjugadabb where $add1 and _tjugadabb.activo=$activo and IDC in ( Select IDC From _tconsecionario where IDG=$accesogp)";
if ($grupo != 0) :
	$accesogp = $grupo;
endif;

if ($idbanca != 0) :
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo  where IDB=" . $idbanca);
	while ($row = mysqli_fetch_array($result)) {
		$listGrupo[] = $row['IDG'];
	}
	$accesogp = implode(',', $listGrupo);
endif;
//escrutesticket($IDJ); /// DEBE EJECUTARSE UNA SOLA VEZ!!!!!
// print_r($Fecha);
$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);

$grid = new GridConnector($res);
if ($activo == 1) :
	$grid->event->attach("beforeRender", "validate");
else :
	$grid->event->attach("beforeRender", "validate2");

endif;

if ($accesogp == 0) :
	$grid->render_sql("Select * from _tjugadabb where $add1 and _tjugadabb.activo=$activo", "serial", "serial,IDC,Usu,hora,Fecha,ap,acobrar,ip,se,escrute,IDJ,IDusu");
else :
	$grid->render_sql("Select * from _tjugadabb where $add1 and _tjugadabb.activo=$activo and IDC in ( Select IDC From _tconsecionario where IDG in ($accesogp))", "serial", "serial,IDC,Usu,hora,Fecha,ap,acobrar,ip,se,escrute,IDJ,IDusu");
endif;
function validate2($data)
{
	global $Fecha;
	$IDJ = $data->get_value("IDJ");
	$data->set_value("Fecha", '11/11/11');
	$data->set_value('Usu', getNameUser($data->get_value('IDusu')));
}
function validate($data)
{
	global  $Tipo;
	global $Fecha;
	// 3= Mostrar los ticket GANADORES
	// 2= Mostrar los ticket QUE FALTA POR ESCRUTAR POR ESPERA DE RESULTADOS
	// 1= Mostrar los ticket PERDEDORES
	if ($data->get_value("escrute") != '') :
		$arr = unserialize($data->get_value("escrute"));
		$Escrute = vescruteBytree2($arr);
		if ($Escrute != $Tipo) :
			$data->skip();
		endif;
	else :
		if ($Tipo != 2) :
			$data->skip();
		endif;
	endif;
	$IDJ = $data->get_value("IDJ");
	$data->set_value("Fecha", $Fecha[$IDJ]);
	$data->set_value('Usu', getNameUser($data->get_value('IDusu')));
}


function getNameUser($IDusu)
{
	$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tusu  where IDusu=$IDusu");
	$row = mysqli_fetch_array($result2);
	return $row['Usuario'];
}