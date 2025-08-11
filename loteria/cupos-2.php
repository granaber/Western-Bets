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

$IDRelacionado = explode('-', $_REQUEST['IdRelacionado']);


$grid->render_sql("SELECT _tloteria.IDLot as IDLota ,_tloteria.NombrePantalla,_tcupos.* FROM _tloteria  LEFT JOIN _tcupos  ON _tloteria.IDLot=_tcupos.IDLot and _tcupos.Tipo=" . $IDRelacionado[0] . " and _tcupos.ID_Relacionado=" . $IDRelacionado[1], "IDLota", "NombrePantalla,LimiteTerminal,LimiteTriple,Premio,FormulaPago");

/*function my_update($data){
             $Estatus=$data->get_value("Estatus");
             $IDusu=$data->get_value("IDusu");
             $conn->sql->query("Update _tusu set Estatus={$Estatus} where IDusu={$id}");
             $data->success(); //if you have made custom update - mark operation as finished
      }*/

function formatting($row)
{
	//render field as details link
	// $data = $row->get_value("some_field");

	$valor = is_null($row->get_value("FormulaPago"));

	if (!$valor) :
		$row->set_value("FormulaPago", 1);
	else :
		$row->set_value("FormulaPago", 0);
	endif;

	$valor = is_null($row->get_value("Premio"));

	if (!$valor) :
		$row->set_value("Premio", 1);
	else :
		$row->set_value("Premio", 0);
	endif;

	//formatting date field
	//$data = $row->get_value("other_field");
	// $row->set_value("other_field",date("m-d-Y",strtotime($data)));
}
