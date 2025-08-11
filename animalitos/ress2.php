<?php
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();
//$fc=FecharealAnimalitos(0,'d/m/Y');
//$IDJ=_FechaDUK($fc,0);
$result = mysqli_query($link, "Select * From  _Jugada_ani  Where serial=118967");
$row = mysqli_fetch_array($result);
echo $row['serial'];
echo '<br>';
$data = unserialize(decoBaseK($row['Jugada']));
print_r($data);
echo '<br>';
echo '<br>';
$result = mysqli_query($link, "Select * From  _Jugada_ani2  Where serial=118967");
$row = mysqli_fetch_array($result);
echo $row['serial'];
echo '<br>';
$data = unserialize(decoBaseK($row['Jugada']));
print_r($data);

function validarNumer($data)
{

  foreach ($data as $i => $value) {
    $result = mysqli_query($link, "Select * From  _Jornada  Where IDJ=" . $data[$i]->sorteo);
  }
}
/*foreach ($data as $i => $value) {
  $data[$i]->sorteo='646';

}
$data[7]->numero='30';
$data[8]->numero='36';
//$data[0]->sorteo='646';
//$data[0]->numero='30';
$jugada=ecoBaseAnimalitos(serialize($data));
$result = mysqli_query($link,"INSERT INTO _Jugada_ani  VALUES (290,'-2','14:15:27',45,1,'".$jugada."',500,'200.82.185.156','91-425-1',1000038,0,'','',0,0)");
/// Si fue Aceptado en la Tabla Error:2*/
