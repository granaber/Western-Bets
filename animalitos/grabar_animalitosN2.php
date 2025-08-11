<?
require_once('func_grabar_animalitos.php');

$IDC = $_REQUEST['IDC'];
$data = json_decode($_REQUEST['Jugada']);
$vf = $_REQUEST['vf'];
$usu = $_REQUEST['usu'];

$r = saveTicket($IDC, $data, $vf, $usu, "");


echo $r;
