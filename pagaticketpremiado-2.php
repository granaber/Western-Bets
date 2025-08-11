<?
require('prc_php.php');
global $minutosa;
$GLOBALS['link'] = Connection::getInstance();

$serial = $_REQUEST['serial'];
$Idusu = $_REQUEST['Idusu'];

$result = mysqli_query($GLOBALS['link'], "Insert _ticketpagados values(" . $serial . ",'" . Horareal($minutosa, "h:i:s A") . "','" . date("d/m/y") . "'," . $Idusu . ")");
echo json_encode($result);
