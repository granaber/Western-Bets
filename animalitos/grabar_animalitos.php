<?
require_once('prc_phpDUK.php');
global $serverD;
global $userD;
global $clvD;
global $dbD;

$MaxiNumber = 50;
$conexion = mysqli_connect($serverD, $userD, $clvD, $dbD);


$IDC = $_REQUEST['IDC'];
$data = json_decode($_REQUEST['Jugada']);

if (count($data) > $MaxiNumber) {
  $reslval[0] = false;
  $reslval[1] = '7';
  $reslval[2] = 'MAXIMO - El ticket solo acepta hasta ' . $MaxiNumber . ' Numero/Animalitos';
  echo json_encode($reslval);
  exit;
}

$horaticket = HorarealAnimalitos($minutosho, "h:i:s A");
$fechaactual = FecharealAnimalitos($minutosho, "d/n/Y");

$idcram = rand(1, 2);
$Fecha = FecharealAnimalitos($minutosho, 'Y-m-d');
$hora = HorarealAnimalitos($minutosho, "H:i:s");
$usu = $_REQUEST['usu'];
$dataR = array(); // Data devuelta por Cierre de Sorteos
$dataT = array(); // Data devuelta por Tope maximos permitidos
$dataT2 = array(); // Data devuelta por Tope maximos permitidos
$IDG = 0;
$resultj = mysqli_query($conexion, "SELECT * FROM _tconsecionario  Where IDC='" . $IDC . "'");
if (mysqli_num_rows($resultj) != 0) :
  $rowj = mysqli_fetch_array($resultj);
  $IDG = $rowj['IDG'];
endif;

$link = ConnectionAnimalitos::getInstance();

if (isValidNumer($data)) :
  $reslval[0] = false;
  $reslval[1] = '7';
  $reslval[2] = 'NUMERO - Hay Un ANIMALITO que no es VALIDO para la LOTERIA JUGADA';
  echo json_encode($reslval);
  exit;
endif;

if (!VerifHoySor($data, $Fecha)) :
  $reslval[0] = false;
  $reslval[1] = '7';
  $reslval[2] = 'JORNADA - Los Sorteos en el tickets estan Cerrados!';
  echo json_encode($reslval);
  exit;
endif;

$resultj = mysqli_query($link, "SELECT * FROM _Jornarda_fecha  Where Fecha='" . $Fecha . "'");
if (mysqli_num_rows($resultj) != 0) :
  $rowj = mysqli_fetch_array($resultj);
  $IDJ = $rowj["IDJ"];
  $cierre = _check_cierre_sorteo($usu);
  if (count($cierre) != 0) :
    $dataR = _Verficacion_Sorteo($cierre, $data);
  //print_r($dataR);
  else :
    if ($cierre[0] == false   &&  isset($cierre[0])) :
      $reslval[0] = false;
      $reslval[1] = '7';
      $reslval[2] = 'JORNADA - No hay jornada habilitada para esta fecha!';
      echo json_encode($reslval);
      exit;
    endif;
  endif;

  $dataT = TopesxSorteo($IDC, $data, $IDJ, $IDG);
  $dataT2 = TopesxNumero($IDC, $data, $IDJ, $IDG);
  $dataT3 = TopesxNumeroxSorteo($IDC, $data, $IDJ, $IDG);


  if (count($data) == 0) :
    if (count($dataT) == 0) :
      if (count($dataT2) == 0) :
        if (count($dataT3) == 0) :
          $reslval[0] = false;
          $reslval[1] = '7';
          $reslval[2] = 'CIERRE - Todas los Sorteos seleccionados estan cerrados!';
        else :
          $reslval[0] = false;
          $reslval[1] = '7';
          $reslval[2] = 'TOPES - No puedo imprimir el ticket porque todos los sorteo sobrepasa el cupo limite!';
        endif;
      else :
        $reslval[0] = false;
        $reslval[1] = '7';
        $reslval[2] = 'TOPES - No puedo imprimir el ticket porque todos los sorteo sobrepasa el cupo limite!';
      endif;
    else :
      $reslval[0] = false;
      $reslval[1] = '7';
      $reslval[2] = 'TOPES - No puedo imprimir el ticket porque todos los Animalitos sobrepasa el cupo limite!';
    endif;
    echo json_encode($reslval);
    exit;
  endif;

  $dataT = array_merge($dataT, $dataT2, $dataT3);



  $ip = getipAnimalitos();
  if (empty($ip) || !preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $ip)) : $ip = $_SERVER["REMOTE_ADDR"];
  endif;


  if (!verificCountTrack($IDC, $data, $IDJ)) :
    $reslval[0] = false;
    $reslval[1] = '7';
    $reslval[2] = 'TOPES - Supero los topes de sus Ventas en este Ticket!';
    echo json_encode($reslval);
    exit;
  endif;

  $jugada = ecoBaseAnimalitos(serialize($data));
  $ap = _MontoDUK($data);
  $serial = bticketAnimalitos();
  if ($idcram == 1) :
    $se = rand(1, 9) . rand(1, $serial) . '-' . rand(1, 9) . rand(1, $IDJ) . '-' . substr($serial, 2, 1);
  else :
    $se = rand(1, $serial) . '-' . rand(1, 9) . rand(1, $IDJ) . '-' . substr($serial, 2, 1) . rand(1, 9) . '-' . rand(1, 9);
  endif;

  $result2 = mysqli_query($link, "INSERT INTO _Jugada_ani2  VALUES (" . $serial . ",'" . $IDC . "','" . $hora . "'," . $IDJ . ",1,'" . $jugada . "'," . $ap . ",'" . $ip . "','" . $se . "'," . $usu . ")");
  $result = false;
  $result = mysqli_query($link, "INSERT INTO _Jugada_ani  VALUES (" . $serial . ",'" . $IDC . "','" . $hora . "'," . $IDJ . ",1,'" . $jugada . "'," . $ap . ",'" . $ip . "','" . $se . "'," . $usu . ",0,'','',0,0)");
  /// Si fue Aceptado en la Tabla Error:2
  if ($result) :
    $reslval[0] = $result;
    $reslval[1] = ticketDUK($serial, $fechaactual, $horaticket, $IDC, $se, $data, $ap, $IDJ, 1, 1);
    $reslval[2] = $dataR;
    $reslval[3] = $dataT;
  else :
    $reslval[0] = false;
    $reslval[1] = '7';
    $reslval[2] = 'ERROR - Disculpe no puedo almacenar el ticket!';
  endif;

else :
  $reslval[0] = false;
  $reslval[1] = '7';
  $reslval[2] = 'JORNADA - No hay jornada habilitada para este fecha!';
endif;

echo json_encode($reslval);

function _Verficacion_Sorteo($cierre, &$data)
{
  $numeroEl = array();
  foreach ($data as $i => $value) {
    $IDa = $data[$i]->sorteo;
    if (in_array($IDa, $cierre)) :
      $numeroEl[] = $data[$i];
      unset($data[$i]);
    endif;
  }

  return $numeroEl;
}
function verificCountTrack($IDC, $data, $IDJ)
{
  global $link;
  $exits = false;
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
      if ($IDL == 1) :
        $tbl = '_Concesionario_Ani';
        $add = "";
      else :
        $tbl = '_Concesionario_Ani_2';
        $add = " and IDL=" . $IDL;
      endif;
      $resultj = mysqli_query($link, "SELECT * FROM $tbl  Where  IDC='$IDC' $add");
      if (mysqli_num_rows($resultj) != 0) :
        $row = mysqli_fetch_array($resultj);
        $pJgd = $row['iAceptoPorcentaje'];
      endif;
      $resultj = mysqli_query($link, "SELECT * FROM _NumeroAnimatios  Where  activo=1 and IDL=$IDL ");
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
function Counttrack($IDC, $data, $IDJ)
{
  global $link;

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

function TopesxSorteo($IDC, &$data, $IDJ, $IDG)
{
  global $link;
  mysqli_query($link, "begin");
  //[{"numero": "0", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "48", "monto": "10", "modo": 0}]
  //// Buscar los Topes N1 Por Punto de Venta
  $Resp = array();
  $dataT = array();
  $Resp[0] = true;
  $arrayTOPE = array();

  $DatIDS = viewIDJND($IDJ);
  //print_r($DatIDS);

  $resultj = mysqli_query($link, "SELECT * FROM _Concesionario_Ani  Where IDC='" . $IDC . "'");
  if (mysqli_num_rows($resultj) != 0) :
    $row = mysqli_fetch_array($resultj);
    //if ($row['iMontSort']!=0):
    $arrayTOPE[1] = $row['iMontSort'];
    $resultj = mysqli_query($link, "SELECT * FROM _Concesionario_Ani_2  Where IDC='" . $IDC . "'");
    while ($row = mysqli_fetch_array($resultj)) {
      $arrayTOPE[$row['IDL']] = $row['iMontSort'];
    }
    $sumaSor = array();
    foreach ($data as $i => $value) {
      if (isset($sumaSor[$data[$i]->sorteo]))
        $sumaSor[$data[$i]->sorteo] += isset($data[$i]->monto) ? $data[$i]->monto : 0;
    }

    //print_r($sumaSor);
    foreach ($sumaSor as $i => $value) {
      $resultjSN1 = mysqli_query($link, "SELECT * FROM _Jornada  Where ID=" . $i);
      $rowN1 = mysqli_fetch_array($resultjSN1);
      $IDL =  $rowN1['IDL'];
      if ($arrayTOPE[$IDL] != 0) :
        $resultjS = mysqli_query($link, "SELECT * FROM _Tope_Suma_PV  Where IDC='" . $IDC . "' and ID=" . $i);
        if (mysqli_num_rows($resultjS) != 0) :
          $rowS = mysqli_fetch_array($resultjS);
          $Total = $rowS['suma'] + $sumaSor[$i];
          if ($Total > $arrayTOPE[$IDL]) :
            $Resp[0] = false;
            $verS = _verSorteo($i, $IDJ, $IDC);
            $Resp[1] = '1.El tope de venta por el Sorteo ' . $verS[0] . ' solo tiene cupo de ' . ($arrayTOPE[$IDL] - $rowS['suma']) . ' y lo esta pasando con este ticket';
            $dataT[] = $Resp;
            foreach ($data as $x => $y) if ($data[$x]->sorteo == $i) : unset($data[$x]);
            endif;
          else :
            $resultjS = mysqli_query($link, "UPDATE  _Tope_Suma_PV  set suma=$Total where  IDC='$IDC' and ID=$i");
          endif;
        else :
          if ($sumaSor[$i] > $arrayTOPE[$IDL]) :
            $Resp[0] = false;
            $verS = _verSorteo($i, $IDJ, $IDC);
            $Resp[1] = '2.El tope de venta por el Sorteo ' . $verS[0] . ' solo tiene cupo de ' . ($arrayTOPE[$IDL]) . ' y lo esta pasando con este ticket';
            $dataT[] = $Resp;
            foreach ($data as $x => $y) if ($data[$x]->sorteo == $i) : unset($data[$x]);
            endif;
          else :
            $resultjS = mysqli_query($link, "INSERT INTO  _Tope_Suma_PV  (IDC,ID,suma) VALUES ('" . $IDC . "'," . $i . "," . $sumaSor[$i] . ")");
          //  echo ("INSERT INTO  _Tope_Suma_PV  (IDC,ID,suma) VALUES ('".$IDC."',".$i.",".$sumaSor[$i].")");
          endif;
        endif;
      endif;
    }
  //endif;
  endif;
  //[{"numero": "0", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "48", "monto": "10", "modo": 0}]
  //// Buscar los Topes N2 Por Grupo
  $resultj = mysqli_query($link, "SELECT * FROM _Grupo_Tope_S  Where Tope!=0 and IDG=" . $IDG);
  if (mysqli_num_rows($resultj) != 0) :

    $sumaSor = array();
    foreach ($data as $i => $value) {
      if (isset($sumaSor[$data[$i]->sorteo]))
        $sumaSor[$data[$i]->sorteo] += $data[$i]->monto;
    }
    //  print_r($sumaSor);

    foreach ($sumaSor as $i => $value) {
      $id = $DatIDS[$i];
      $resultj = mysqli_query($link, "SELECT * FROM _Grupo_Tope_S  Where Tope!=0 and IDS=" . $id . " and IDG=" . $IDG);
      //  echo ("SELECT * FROM _Grupo_Tope_S  Where Tope!=0 and IDS=".$id." and IDG=".$IDG);
      if (mysqli_num_rows($resultj) != 0) :
        $row = mysqli_fetch_array($resultj);
        $TopeN2 = $row['Tope']; //500
        $Total = $row['Suma'] + $sumaSor[$i]; //30
        if ($Total > $TopeN2) :
          $Resp[0] = false;
          $verS = _verSorteo($i, $IDJ, $IDC);
          $Resp[1] = '3.El tope de venta por el Sorteo ' . $verS[0] . ' solo tiene cupo por GRUPO (' . $IDG . ') de ' . ($TopeN2 - $row['suma']) . ' y lo esta pasando con este ticket';
          $dataT[] = $Resp;
          foreach ($data as $x => $y) if ($data[$x]->sorteo == $i) : unset($data[$x]);
          endif;
        else :
          $resultjS = mysqli_query($link, "UPDATE  _Grupo_Tope_S  set suma=$Total where  IDS=" . $id . " and IDG=" . $IDG);
        //echo ("UPDATE  _Grupo_Tope_S  setSsuma=$Total where  IDS=".$id." and IDG=".$IDG);
        endif;
      endif;
    }

  endif;
  //[{"numero": "0", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "48", "monto": "10", "modo": 0}]
  //// Buscar los Topes N3 Por Banca
  $resultj = mysqli_query($link, "SELECT * FROM _Banca_Tope_S  Where Tope!=0");
  if (mysqli_num_rows($resultj) != 0) :

    $sumaSor = array();
    foreach ($data as $i => $value) {
      if (isset($sumaSor[$data[$i]->sorteo]))
        $sumaSor[$data[$i]->sorteo] += $data[$i]->monto;
    }
    foreach ($sumaSor as $i => $value) {
      $id = $DatIDS[$i];
      $resultj = mysqli_query($link, "SELECT * FROM _Banca_Tope_S  Where Tope!=0 and IDS=" . $id);
      if (mysqli_num_rows($resultj) != 0) :
        $row = mysqli_fetch_array($resultj);
        $TopeN3 = $row['Tope']; //500
        $Total = $row['Suma'] + $sumaSor[$i]; //30
        if ($Total > $TopeN3) :
          $Resp[0] = false;
          $verS = _verSorteo($i, $IDJ, $IDC);
          $Resp[1] = '4.El tope de venta por el Sorteo ' . $verS[0] . ' solo tiene cupo por BANCA de ' . ($TopeN3 - $row['suma']) . ' y lo esta pasando con este ticket';
          $dataT[] = $Resp;
          foreach ($data as $x => $y) if ($data[$x]->sorteo == $i) : unset($data[$x]);
          endif;
        else :
          $resultjS = mysqli_query($link, "UPDATE  _Banca_Tope_S  set suma=$Total where  IDS=" . $id);
        //echo ("UPDATE  _Grupo_Tope_S  setSsuma=$Total where  IDS=".$id." and IDG=".$IDG);
        endif;
      endif;
    }

  endif;


  if (count($dataT) == 0) :
    mysqli_query($link, "commit");
  else :
    mysqli_query($link, "rollback");
  endif;
  return $dataT;
}


function isValidNumer(&$data)
{
  global $link;

  foreach ($data as $i => $value) {
    $numero = $data[$i]->numero; //_NumeroAnimatios
    $sorteo = $data[$i]->sorteo; //_Jornada

    $resultjSN1 = mysqli_query($link, "SELECT * FROM _Jornada  Where ID=" . $sorteo);
    $rowN1 = mysqli_fetch_array($resultjSN1);
    $IDL =  $rowN1['IDL'];

    $resultj = mysqli_query($link, "SELECT * FROM _NumeroAnimatios  Where  num='$numero' and IDL=$IDL ");
    if (mysqli_num_rows($resultj) == 0) :
      return true;
    endif;
  }
  return false;
}

///////////////////////////////// Tope por numero //////////////////////////////////
function TopesxNumero($IDC, &$data, $IDJ, $IDG)
{
  global $link;

  mysqli_query($link, "begin");

  $Resp = array();
  $dataT = array();
  $Resp[0] = true;


  $DatIDS = viewIDJND($IDJ);
  //[{"numero": "0", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "48", "monto": "10", "modo": 0}]
  //// Buscar los Topes N2 Por Grupo
  $resultj = mysqli_query($link, "SELECT * FROM _Grupo_Tope_N  Where Tope!=0 and IDG=" . $IDG);
  if (mysqli_num_rows($resultj) != 0) :
    foreach ($data as $i => $value) {
      $id = $DatIDS[$data[$i]->sorteo];
      $resultj = mysqli_query($link, "SELECT * FROM _Grupo_Tope_N  Where  IDS=" . $id . " and numero='" . $data[$i]->numero . "' and Tope!=0 and IDG=" . $IDG);
      if (mysqli_num_rows($resultj) != 0) :
        $row = mysqli_fetch_array($resultj);
        $TopeN2 = $row['Tope']; //500
        $Total = $row['Suma'] + $data[$i]->monto; //30
        if ($Total > $TopeN2) :
          $Resp[0] = false;
          $verS = _verSorteo($data[$i]->sorteo, $IDJ, $IDC);
          $Resp[1] = '5.El tope de venta por el Sorteo ' . $verS[0] . ' y Animalito ' . $data[$i]->numero . ' del Grupo ' . $IDG . ' solo tiene cupo por ' . ($TopeN2 - $row['Suma']) . ' y lo esta pasando con este ticket';
          $dataT[] = $Resp;
          unset($data[$i]);
        else :
          $resultjS = mysqli_query($link, "UPDATE  _Grupo_Tope_N  set suma=$Total  Where numero='" . $data[$i]->numero . "' and Tope!=0 and IDG=" . $IDG);
        endif;
      endif;
    }
  endif;

  //[{"numero": "0", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "48", "monto": "10", "modo": 0}]
  //// Buscar los Topes N3 Por Banca
  $resultj = mysqli_query($link, "SELECT * FROM _Banca_Tope_N  Where Tope!=0");
  if (mysqli_num_rows($resultj) != 0) :
    foreach ($data as $i => $value) {
      $id = $DatIDS[$data[$i]->sorteo];
      $resultj = mysqli_query($link, "SELECT * FROM _Banca_Tope_N  Where IDS=" . $id . " and numero='" . $data[$i]->numero . "' and Tope!=0");
      if (mysqli_num_rows($resultj) != 0) :
        $row = mysqli_fetch_array($resultj);
        $TopeN3 = $row['Tope']; //500
        $Total = $row['Suma'] + $data[$i]->monto; //30
        if ($Total > $TopeN3) :
          $Resp[0] = false;
          $verS = _verSorteo($data[$i]->sorteo, $IDJ, $IDC);
          $Resp[1] = '6.El tope de venta por el Sorteo ' . $verS[0] . ' y Animalito ' . $data[$i]->numero . '  solo tiene cupo por ' . ($TopeN3 - $row['Suma']) . ' y lo esta pasando con este ticket';
          $dataT[] = $Resp;
          unset($data[$i]);
        else :
          $resultjS = mysqli_query($link, "UPDATE  _Grupo_Tope_N  set suma=$Total  Where numero='" . $data[$i]->numero . "' and Tope!=0 and IDG=" . $IDG);
        endif;
      endif;
    }
  endif;


  if (count($dataT) == 0) :
    mysqli_query($link, "commit");
  else :
    mysqli_query($link, "rollback");
  endif;
  return $dataT;
}
function VerifHoySor($data, $Fecha)
{
  global $link;

  $resultj = mysqli_query($link, "SELECT * FROM _Jornarda_fecha  Where Fecha='" . $Fecha . "'");
  if (mysqli_num_rows($resultj) != 0) :
    $rowj = mysqli_fetch_array($resultj);
    $IDJ = $rowj["IDJ"];
    $aSorteosAct = array();
    $result = mysqli_query($link, "SELECT * FROM  _Jornada WHERE IDJ =" . $IDJ);
    while ($row = mysqli_fetch_array($result)) {
      $aSorteosAct[] = $row['ID'];
    }
    // Los Sorteos DE HOY y Solo hoy

    $cerrar = true;
    foreach ($data as $i => $value) {
      $ide = array_search($data[$i]->sorteo, $aSorteosAct);
      //  echo $data[$i]->sorteo;echo '*';
      if ($ide === false) :
        $cerrar = false;
        break;
      endif;
    }

    //
    return $cerrar;
  else :
    return false;
  endif;
}


function TopesxNumeroxSorteo($IDC, &$data, $IDJ, $IDG)
{
  global $link;

  mysqli_query($link, "begin");

  $Resp = array();
  $dataT = array();
  $Resp[0] = true;
  $arrayTOPE = array();

  $resultj = mysqli_query($link, "SELECT * FROM _Concesionario_Ani  Where IDC='$IDC'");
  if (mysqli_num_rows($resultj) != 0) :
    $row = mysqli_fetch_array($resultj);
    $arrayTOPE[1] = $row['iMontMax']; //1000

    $resultj = mysqli_query($link, "SELECT * FROM _Concesionario_Ani_2  Where IDC='" . $IDC . "'");
    while ($row = mysqli_fetch_array($resultj)) {
      $arrayTOPE[$row['IDL']] = $row['iMontMax'];
    }


    foreach ($data as $i => $value) {


      $id = $data[$i]->sorteo;

      $resultjSN1 = mysqli_query($link, "SELECT * FROM _Jornada  Where ID=" . $id);
      $rowN1 = mysqli_fetch_array($resultjSN1);
      $IDL =  $rowN1['IDL'];
      if (isset($arrayTOPE[$IDL])) :
        if ($arrayTOPE[$IDL] != 0) :
          $num = $data[$i]->numero;
          $monto = $data[$i]->monto; //1000
          //ln 	IDC 	num 	ID 	total
          //echo ("SELECT * FROM _Tope_Suma_PV_Xnum  Where  IDC='$IDC' and ID=$id and num='$num' ");
          $resultj = mysqli_query($link, "SELECT * FROM _Tope_Suma_PV_Xnum  Where  IDC='$IDC' and ID=$id and num='$num' ");
          if (mysqli_num_rows($resultj) != 0) :
            $row = mysqli_fetch_array($resultj);
            $TopeN4 = $row['total'] + $monto; // $row['total']=50  $monto=1000
            if ($TopeN4 <= $arrayTOPE[$IDL]) :
              $resultjS = mysqli_query($link, "Update   _Tope_Suma_PV_Xnum  Set total=$TopeN4 Where  IDC='$IDC' and ID=$id and num='$num' ");

            else :
              $Resp[0] = false;
              $verS = _verSorteo($data[$i]->sorteo, $IDJ, $IDC);
              $Resp[1] = '7.El tope de venta por el Sorteo ' . $verS[0] . ' y Animalito ' . $data[$i]->numero . '  solo tiene cupo por ' . ($arrayTOPE[$IDL] - $row['total']) . ' y lo esta pasando con este ticket';
              $dataT[] = $Resp;
              unset($data[$i]);
            endif;
          else :
            if ($monto <= $arrayTOPE[$IDL]) :
              $resultjS = mysqli_query($link, "Insert  _Tope_Suma_PV_Xnum  (IDC,num,ID,total) values ('$IDC','$num',$id,$monto) ");
            //      echo ("Insert  _Tope_Suma_PV_Xnum  (IDC,num,ID,total) values ('$IDC','$num',$id,$monto) ");//
            else :
              $Resp[0] = false;
              $verS = _verSorteo($data[$i]->sorteo, $IDJ, $IDC);
              $Resp[1] = '8.El tope de venta por el Sorteo ' . $verS[0] . ' y Animalito ' . $data[$i]->numero . '  solo tiene cupo por ' . ($arrayTOPE[$IDL] - $monto) . ' y lo esta pasando con este ticket';
              $dataT[] = $Resp;
              unset($data[$i]);
            endif;
          endif;

        endif;
      else :
        $Resp[0] = false;
        $verS = _verSorteo($data[$i]->sorteo, $IDJ, $IDC);
        $Resp[1] = '9.El tope de venta por el Sorteo ' . $verS[0] . ' y Animalito ' . $data[$i]->numero . '  solo tiene cupo por ' . ($arrayTOPE[$IDL]) . ' y lo esta pasando con este ticket';
        $dataT[] = $Resp;
        unset($data[$i]);
      endif;
    }

  endif;

  if (count($dataT) == 0) :
    mysqli_query($link, "commit");
  else :
    mysqli_query($link, "rollback");
  endif;
  return $dataT;
}
