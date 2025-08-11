<?
require_once('codebase/php/grid_connector.php');
require_once('prc_php.php');
global $server;
global $user;
global $clv;
global $db;

$GLOBALS['link'] = Connection::getInstance();

$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);

$grid = new GridConnector($res);
//$grid->render_table("_tusu","IDusu","IDusu,Usuario,Estatus");
//$grid->sql->attach("Update","Update _tusu set Estatus={Estatus} where IDusu={IDusu}");
//$grid->event->attach("beforeUpdate","my_update");
//
//$IDRelacionado=explode('-',$_REQUEST['IdRelacionado']);
$grid->event->attach("beforeRender", "formatting");
$IDG = $_REQUEST['IDG'];
$grid->render_sql("SELECT * FROM  _tconsecionario where IDG=$IDG  ", "IDC", "IDC,Nombre,credito,saldo,debe,ultimtrans");

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

       $resultEqu = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbcrdcredito WHERE IDC = '" . $row->get_value("IDC") . "'");
       if (mysqli_num_rows($resultEqu) != 0) :
              $rowEqu = mysqli_fetch_array($resultEqu);
              $row->set_value("credito", ($rowEqu['credito']));
              $row->set_value("saldo", ($rowEqu['saldo']));
              $row->set_value("debe", ($rowEqu['credito'] - $rowEqu['saldo']));
              $row->set_value("ultimtrans", ($rowEqu['ultimtrans']));
       endif;

       //formatting date field
       //$data = $row->get_value("other_field");
       // $row->set_value("other_field",date("m-d-Y",strtotime($data)));
}
