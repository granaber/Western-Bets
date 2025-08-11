<?
require_once('prc_phpDUK.php');
$IDL = $_REQUEST['IDL'];
$link = ConnectionAnimalitos::getInstance();



$sql = "Select * from _NumeroAnimatios where Activo=1 and IDL=$IDL order by num";
$resultj = mysqli_query($link, $sql);
$json = [];
while ($Row = mysqli_fetch_array($resultj)) {

  $json[] = array("id" => $Row['num'], 'num' => $Row['num'], "img" => $Row['figura'], "nom" => strtoupper($Row['nombre']));
}

$sql = "Select * from _Conf_premio_esp where IDL=$IDL order by numero";
$resultj = mysqli_query($link, $sql);
$json_esp = [];
while ($Row = mysqli_fetch_array($resultj)) {

  $json_esp[] = array("id" => $Row['numero'], 'clas' => 'ireaxion-btn-extra');
}

echo  json_encode(array("data" => $json, "esp" => $json_esp));
