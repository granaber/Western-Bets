<?
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();
$IDJ = _FechaDUK($_REQUEST['fecc']);

$MonitorArr = array();
$tik = 0;
$serial = 0;
$result = mysqli_query($link, "Select * From  _Jugada_ani  Where Activo=1  and  IDJ=" . $IDJ . " and serial>" . $_REQUEST['serial']);
//echo ("Select * From  _Jugada_ani  Where Activo=1  and  IDJ=".$IDJ." and serial>".$_REQUEST['serial']);
while ($Row = mysqli_fetch_array($result)) {
  $data = unserialize(decoBaseK($Row['Jugada']));

  $tik++;
  foreach ($data as $i => $value) {

    $numero = $data[$i]->numero;
    $sorteo = $data[$i]->sorteo;
    $monto = $data[$i]->monto;

    if (isset($MonitorArr[$sorteo][$numero])) :
      $MonitorArr[$sorteo][$numero]['monto'] += $monto;
      $MonitorArr[$sorteo][$numero]['tk'] += $tik;
    else :
      $MonitorArr[$sorteo][$numero] = array('monto' => $monto, 'tk' => $tik);

    endif;
  }
  $serial = $Row['serial'];
}


echo json_encode(array($serial, $MonitorArr));
