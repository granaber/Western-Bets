<?
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();
$IDJ = _FechaDUK($_REQUEST['fecc']);
$isorteo = array();
$result = mysqli_query($link, "Select * From  _Jornada  Where IDJ=" . $IDJ);
while ($Row = mysqli_fetch_array($result)) {
  $isorteo[] = $Row['ID'];
}
$i = 0;
foreach ($isorteo as $i => $delta) {
  echo '<div id="ave' . $i . '" style="display:none"> ';
  $IDS = $isorteo[$i];
  include 'Ani_Monitor-1.php';
  echo '<div>';
}
