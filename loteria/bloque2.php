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
$grid->event->attach("beforeRender", "formatting");

//$IDRelacionado=explode('-',$_REQUEST['IdRelacionado']);


$grid->render_sql("SELECT * From _tbbloqueo", "IDBlq", "IDBlq,xFecha,Aplicar,numero,xLoteria,Adicional,Monto,xBloqueado,tipo,Fecha,Select1,Select2");



function formatting($row)
{

	$Select1 = $row->get_value("Select1");

	if ($Select1 == 1) :

		$row->set_value("xFecha", $row->get_value("Fecha"));
	else :
		$row->set_value("xFecha", 'Todos los Dias');
	endif;


	$tipo = $row->get_value("tipo");

	switch ($tipo) {

		case 1:
			$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbanca where IDB=" . $row->get_value("Aplicar"));
			break;
		case 2:
			$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tzona where IDZ=" . $row->get_value("Aplicar"));
			break;
		case 3:
			$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tintermediario where IDI=" . $row->get_value("Aplicar"));
			break;
		case 4:
			$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tagencias where IDC=" . $row->get_value("Aplicar"));
			break;
	}

	$RowR = mysqli_fetch_array($resultj);
	$row->set_value("Aplicar", $RowR['Descripcion']);



	$IDLot = $row->get_value("IDLot");
	if ($IDLot == 0) :
		$row->set_value("xLoteria", 'Todas');
		$row->set_value("Adicional", 'Todas');
	else :
		$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tloteria where 	IDLot= $IDLot");
		$RowR = mysqli_fetch_array($resultj);
		$row->set_value("xLoteria", $RowR['NombrePantalla']);

		if ($row->get_value("Adicional") != '0') :
			$Formato = $RowR['Formato'];
			$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tloteria_formato where 	Formato= $Formato");
			echo ("SELECT * FROM _tloteria_formato where 	Formato= $Formato");
			$RowR = mysqli_fetch_array($resultj);
			$LisF = explode('|', $RowR['Lista']);
			$row->set_value("Adicional", $LisF[($row->get_value("Adicional")) - 1]);
		else :
			$row->set_value("Adicional", 'Todas');
		endif;

	endif;



	$Select2 = $row->get_value("Select2");

	if ($Select2 == 1) :
		$row->set_value("xBloqueado", 'No');
	else :
		$row->set_value("xBloqueado", 'Si');
		$row->set_value("Monto", 0);
	endif;
}
