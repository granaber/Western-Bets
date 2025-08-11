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
//
//$IDRelacionado=explode('-',$_REQUEST['IdRelacionado']);

$grid->render_sql("select _tgrupo.*,_trestricionesbb.MxD,_trestricionesbb.MxP,_trestricionesbb.Aplicar from _tgrupo,_trestricionesbb where  _tgrupo.IDG=_trestricionesbb.IDG ", "IDG", "IDG,Descrip,Responsable,MxD,MxP,Aplicar");
/*function my_update($data){
             $Estatus=$data->get_value("Estatus");
             $IDusu=$data->get_value("IDusu");
             $conn->sql->query("Update _tusu set Estatus={$Estatus} where IDusu={$id}");
             $data->success(); //if you have made custom update - mark operation as finished
			 
			 case 1: $campo='Usuario';break;
		case 2: $campo='Administrador';break;
		case 3: $campo='Vendedor';break;
		case 4: $campo='Info';break;
		case 5: $campo='Sistema';break;
      }*/

function formatting($row)
{

	switch ($row->get_value("Tipo")) {

		case 1:
			$row->set_value("Tipo", 'Usuario');
			break;
		case 2:
			$row->set_value("Tipo", 'Administrador');
			break;
		case 3:
			$row->set_value("Tipo", 'Vendedor');
			break;
		case 4:
			$row->set_value("Tipo", 'Admin.Grupo');
			break;
		case 5:
			$row->set_value("Tipo", 'Sistema');
			break;
	}
}
