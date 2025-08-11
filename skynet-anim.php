<?
require_once('prc_phpDUK.php');
$GLOBALS['link'] = Connection::getInstance();
$url = "http://www.granjamillonaria.com/Resource?a=hoy"; // url de la pagina que queremos obtener
$contents = file_get_contents($url);
$contents = utf8_encode($contents);
$results = json_decode($contents);
$IDJ = _FechaDUK();
$valor = $results->rss;
$iSorteo = array();
$iResultado = array();
foreach ($valor as $i => $delta) {
  print_r($valor[$i]);
  echo '<br>';
  $iSorteo[] = convertirMilitar($valor[$i]->h);
  $iResultado[] = $valor[$i]->nu;
}
for ($i = 0; $i <= count($iSorteo) - 1; $i++) {
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _Jornada  Where IDJ=" . $IDJ . " and HoraCierre='" . $iSorteo[$i] . "'");
  if (mysqli_num_rows($resultj) == 0) :
    $resultj2N = mysqli_query($GLOBALS['link'], "Insert _Jornada (	IDJ,IDJS,HoraCierre,Activa,CantidadNum ) values($IDJ,0,'" . $iSorteo[$i] . "',0,36)");
  endif;
}
