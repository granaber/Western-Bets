<?
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
//escrutesticket($IDJ); /// DEBE EJECUTARSE UNA SOLA VEZ!!!!!

$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);

$grid = new GridConnector($res);
if ($activo == 1) :
	$grid->event->attach("beforeRender", "validate");
endif;
if ($accesogp == 0) :
	$grid->render_sql("Select * from _tjugadabb where $add1 and _tjugadabb.activo=$activo", "serial", "serial,IDC,hora,Fecha,ap,acobrar,se,escrute,IDJ");
else :
	$grid->render_sql("Select * from _tjugadabb where $add1 and _tjugadabb.activo=$activo and IDC in ( Select IDC From _tconsecionario where IDG=$accesogp)", "serial", "serial,IDC,hora,Fecha,ap,acobrar,se,escrute,IDJ");
endif;
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
}
function vescruteBytree2($arr)
{
	$tipo = 3; // El ticket es GANADOR
	$key0 = array_search(0, $arr);
	if (!($key0 === false)) :
		$tipo = 1;  /// Ticket Perdido
	else :
		$key_1 = array_search(-1, $arr);
		if (!($key_1 === false)) : $tipo = 2;
		endif;
	endif; /// Ticket No Hay Escrutes
	return $tipo;
}
