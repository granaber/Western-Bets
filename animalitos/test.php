<?

require_once('prc_phpDUK.php');

$link = ConnectionAnimalitos::getInstance();
$IDJ = 877;


$result = mysqli_query($link, "Select * From  _Jugada_ani  Where Activo=1  and  IDJ=" . $IDJ);
while ($Row = mysqli_fetch_array($result)) {
  $data = unserialize(decoBaseK($Row['Jugada']));
  $IDC = $Row['IDC'];
  Counttrack($IDC, $data, $IDJ);
  // if (verificCountTrack($IDC,$data,$IDJ)){
  //   echo 'Aceptado '. $IDC;
  // }else{
  //   echo 'NO Aceptado '. $IDC;
  //   print_r($data);
  // }
  // echo '\n';
}

function Counttrack($IDC, $data, $IDJ)
{

  $sorteos = [];
  foreach ($data as $i => $value) {
    $sorteos[] = $data[$i]->sorteo;
  }
  $exits = false;
  $json = [];
  $resultj = mysqli_query($link, "SELECT * FROM _Count_Track  Where IDJ=$IDJ and IDC='$IDC' and IDL in (" . join(',', $sorteos) . ")");
  if (mysqli_num_rows($resultj) != 0) :
    $exits = true;
    while ($row = mysqli_fetch_array($resultj)) {
      $json[$row['IDL']] = unserialize($row['iJson']);
    }
  endif;

  foreach ($data as $i => $value) {
    $numero = $data[$i]->numero;
    $sorteo = $data[$i]->sorteo;

    if (isset($json[$sorteo])) {
      $vnum = $json[$sorteo];
      if (isset($vnum[$numero])) {
        $vnum[$numero]++;
      } else {
        $vnum[$numero] = 1;
      }
      $json[$sorteo] = $vnum;
    } else {
      $vnum = [];
      $vnum[$numero] = 1;
      $json[$sorteo] =  $vnum;
    }
  }
  foreach ($json as $i => $value) {
    $sorteo = $i;
    $jData = $json[$i];
    if ($exits) {
      $resultj = mysqli_query($link, "Update   _Count_Track  set iJson='" . serialize($jData) . "' Where IDJ=$IDJ and IDC='$IDC' and IDL=$sorteo");
    } else {
      $resultj = mysqli_query($link, "Insert  _Count_Track  values ($sorteo,$IDJ,'$IDC','" . serialize($jData) . "')");
    }
  }
}


function verificCountTrack($IDC, $data, $IDJ)
{
  $sorteos = [];
  $NoGrabar = true;
  foreach ($data as $i => $value) {
    $sorteos[] = $data[$i]->sorteo;
  }
  $resultj = mysqli_query($link, "SELECT * FROM _Count_Track  Where IDJ=$IDJ and IDC='$IDC' and IDL in (" . join(',', $sorteos) . ")");
  if (mysqli_num_rows($resultj) != 0) :
    $exits = true;
    while ($row = mysqli_fetch_array($resultj)) {
      $json[$row['IDL']] = unserialize($row['iJson']);
    }
  endif;
  foreach ($data as $i => $value) {
    $numero = $data[$i]->numero;
    $sorteo = $data[$i]->sorteo;

    if (isset($json[$sorteo])) {

      $vnum = $json[$sorteo];
      if (isset($vnum[$numero])) {
        $vnum[$numero]++;
      } else {
        $vnum[$numero] = 1;
      }
      $json[$sorteo] = $vnum;
      $jData = $json[$sorteo];

      $resultj = mysqli_query($link, "SELECT * FROM _Jornada  Where ID=$sorteo");
      $row = mysqli_fetch_array($resultj);
      $IDL = $row['IDL'];
      $pJgd = 100;
      if ($IDL == 1) : $tbl = '_Concesionario_Ani';
      else : $tbl = '_Concesionario_Ani_2';
      endif;
      $resultj = mysqli_query($link, "SELECT * FROM $tbl  Where  IDC='$IDC' ");
      if (mysqli_num_rows($resultj) != 0) :
        $row = mysqli_fetch_array($resultj);
        $pJgd = $row['iAceptoPorcentaje'];
      endif;
      $resultj = mysqli_query($link, "SELECT * FROM _NumeroAnimatios  Where  IDL=$IDL ");
      $CountData = count($jData) * 100 / mysqli_num_rows($resultj);
      if ($CountData > $pJgd) {
        $NoGrabar = false;
        break;
      }
    } else {
      $vnum = [];
      $vnum[$numero] = 1;
      $json[$sorteo] =  $vnum;
    }

    if (!$NoGrabar) break;
  }
  if ($NoGrabar) {

    foreach ($json as $i => $value) {
      $sorteo = $i;
      $jData = $json[$i];
      if ($exits) {
        $resultj = mysqli_query($link, "Update   _Count_Track  set iJson='" . serialize($jData) . "' Where IDJ=$IDJ and IDC='$IDC' and IDL=$sorteo");
      } else {
        $resultj = mysqli_query($link, "Insert  _Count_Track  values ($sorteo,$IDJ,'$IDC','" . serialize($jData) . "')");
      }
    }
  }

  return $NoGrabar;
}
