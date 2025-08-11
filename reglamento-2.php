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
//$grid->event->attach("beforeRender","formatting");

$IDRelacionado = explode('-', $_REQUEST['IdRelacionado']);

if ($IDRelacionado[0] == 'Banca') :
	$grid->render_sql("SELECT * FROM _tbrestricciones,_hipodromoshi  where IDC='0' and IDG=0 and _tbrestricciones._idhipo=_hipodromoshi._idhipo ", "id_tbrestricciones", "id_tbrestricciones,CantidadEje,DivUno,DivDos,DividendoFijo,Premio,Descripcion,_idhipo");
else :
	if (is_numeric($IDRelacionado[0])) :
		$grid->render_sql("SELECT * FROM _tbrestricciones,_hipodromoshi   where IDC='0' and _tbrestricciones._idhipo=_hipodromoshi._idhipo and IDG=" . $IDRelacionado[1], "id_tbrestricciones", "id_tbrestricciones,CantidadEje,DivUno,DivDos,DividendoFijo,Premio,Descripcion,_idhipo");
	else :
		$grid->render_sql("SELECT * FROM _tbrestricciones,_hipodromoshi   where IDG=0 and _tbrestricciones._idhipo=_hipodromoshi._idhipo and IDC='" . $IDRelacionado[0] . "' ", "id_tbrestricciones", "id_tbrestricciones,CantidadEje,DivUno,DivDos,DividendoFijo,Premio,Descripcion,_idhipo");
	endif;
endif;



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
