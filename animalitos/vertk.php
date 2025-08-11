<?
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();

$sql = "Select * from _Jugada_ani where serial=" . $_REQUEST['serial'];
//Serial,Hora,Fecha,Monto,Cantidad de Numeros
$resultj = mysqli_query($link, $sql);
$rowj = mysqli_fetch_array($resultj);
$MND = "?";

$resultj2 = mysqli_query($link, "Select * from _Jornarda_fecha  where IDJ=" . $rowj['IDJ']);
$rowj2 = mysqli_fetch_array($resultj2);

echo ticketDUK($rowj['serial'], _ConverFecha($rowj2['Fecha']), convertirNormal($rowj['hora']), $rowj['IDC'], $rowj['se'], unserialize(decoBaseK($rowj['Jugada'])), $rowj['monto'], $rowj['IDJ'], 3, $_REQUEST['TU'], $MND);
