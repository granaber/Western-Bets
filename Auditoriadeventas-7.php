<?
require_once('codebase/php/grid_connector.php');
require_once('prc_php.php');
global $server;
global $user;
global $clv;
global $db;
$IDJ = $_REQUEST['IDJ'];
$Tipo = $_REQUEST['tipo'];
$activo = $_REQUEST['activo'];
$parametro = explode('(', $_REQUEST['parametro']);
$grupo = 0;


$add1 = 'IDJ=' . $IDJ;

$serial = array(-1);
$colora = array(-1);
$colores = array('#069', '#900', '#C90', '#FC0', '#906', '#FF0', '#6F0', '#333', '#699', '#030', '#366', '#F69', '#636', '#03C', '#F06', '#660', '#F9F', '#930', '#300', '#000');
$GLOBALS['link'] = Connection::getInstance();
$result2 = mysqli_query($GLOBALS['link'], "Select * from _tjugadabb where $add1 and _tjugadabb.activo=$activo");
while ($row = mysqli_fetch_array($result2)) {
	$jud = $row['Jugada'];
	$jgdad = explode('*', $jud);
	$fin = false;
	for ($u = 0; $u <= count($jgdad) - 2; $u++) {
		$opcion = explode('|', $jgdad[$u]);
		$logro = $opcion[1];
		$opcion1 = explode('%', $opcion[0]);
		$carr = $opcion1[1];
		$opcion2 = explode('-', $opcion1[0]);
		$equi = $opcion2[0];
		$iddd = $opcion2[1];

		for ($i = 0; $i <= count($parametro) - 1; $i++) {
			$Con_opcion = explode('|', $parametro[$i]);
			$Con_opcion2 = explode('%', $Con_opcion[0]);
			$Datos = explode('-', $Con_opcion2[0]);

			$IDDD1 = $Datos[1];
			echo $IDDD;
			$vEquipos = explode('y', $Datos[0]);


			if ($IDDD1 == 0) :
				for ($ie = 0; $ie <= count($vEquipos) - 1; $ie++) {
					if ((int)$vEquipos[$ie] == (int)$equi) :  $serial[] = $row['serial'];
						$colora[] = $colores[$i];
						$fin = true;
						break;
					endif;
				}
			else :
				if ($IDDD1 == $iddd) :
					for ($ie = 0; $ie <= count($vEquipos) - 1; $ie++) {
						if ((int)$vEquipos[$ie] == (int)$equi) :  $serial[] = $row['serial'];
							$colora[] = $colores[$i];
							$fin = true;
							break;
						endif;
					}
				endif;
			endif;
			if ($fin) : break;
			endif;
		}
		if ($fin) : break;
		endif;
	}
}

$seriales = join(',', $serial);

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

$grid->render_sql("Select * from _tjugadabb where  serial in ($seriales)", "serial", "serial,IDC,hora,Fecha,ap,acobrar,se,escrute,IDJ");


function validate($data)
{
	global  $Tipo;
	global $Fecha;
	global $serial;
	global $colora;

	$key = array_search($data->get_value("serial"), $serial);
	$colorAsig = $colora[$key];

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
	$data->set_value("Fecha", $colorAsig);
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
