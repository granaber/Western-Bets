<?
require_once('codebase/php/grid_connector.php');
require_once('prc_php.php');
global $server;
global $user;
global $clv;
global $db;
global $GLOBALS['minutosh']o;	

$dia=Fechareal($GLOBALS['minutosh']o,'N');
$campoDia=DiaenLetras($dia);

$res=mysqli_connect($server,$user,$clv);
mysqli_select_db($res,$db);

$grid= new GridConnector($res);
//$grid->render_table("_tusu","IDusu","IDusu,Usuario,Estatus");
//$grid->sql->attach("Update","Update _tusu set Estatus={Estatus} where IDusu={IDusu}");
//$grid->event->attach("beforeUpdate","my_update");
//

//$IDRelacionado=explode('-',$_REQUEST['IdRelacionado']);

$grid->event->attach("beforeRender","formatting");
$grid->render_sql("SELECT ".$campoDia."H FROM _tloteria GROUP BY ".$campoDia."H",$campoDia."H" ,"sel,".$campoDia."H");

 /*function my_update($data){
             $Estatus=$data->get_value("Estatus");
             $IDusu=$data->get_value("IDusu");
             $conn->sql->query("Update _tusu set Estatus={$Estatus} where IDusu={$id}");
             $data->success(); //if you have made custom update - mark operation as finished
      }*/
	  
	  function formatting($row){
				  global $campoDia;
								 
				 $valor=$row->get_value($campoDia."H");
				 $valor1=convertirH_AMPM($valor);
				 $row->set_value($campoDia."H",$valor1);
	}
     

?>
