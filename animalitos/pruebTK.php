<?
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();

$sql = "Select * from _Jugada_ani where serial=" . $_REQUEST['serial'];
//Serial,Hora,Fecha,Monto,Cantidad de Numeros
$resultj = mysqli_query($link, $sql);
$rowj = mysqli_fetch_array($resultj);

$resultj2 = mysqli_query($link, "Select * from _Jornarda_fecha  where IDJ=" . $rowj['IDJ']);
$rowj2 = mysqli_fetch_array($resultj2);

print_r(sDataTicket2($rowj['serial']));
//,_ConverFecha($rowj2['Fecha']),convertirNormal($rowj['hora']),$rowj['IDC'],$rowj['se'],
//0,6:05p,0-METS  A Ganar,-120|1,7:40p,0-REDS  A Ganar,+15|2,9:10p,0-GIANTS  A Ganar,+12.5
//8:00:00 pm(La Granja Millonaria)-1x30|Gato#1#|Caballo#1#|Cochino#1#-|8:00:00 pm(Loto Selva)-1x30|Cochino#0.01#|Gallo#0.01#3,02A Pagar: 0,00
////////////////////////////////////////////////////////
function sDataTicket2($serial)
{
  $r = array();
  $b = '';

  $sql = "Select * from _Jugada_ani where serial=" . $serial;
  //Serial,Hora,Fecha,Monto,Cantidad de Numeros
  $resultj = mysqli_query($link, $sql);
  $rowj = mysqli_fetch_array($resultj);

  $resultj2 = mysqli_query($link, "Select * from _Jornarda_fecha  where IDJ=" . $rowj['IDJ']);
  $rowj2 = mysqli_fetch_array($resultj2);

  $r[] = $rowj2['Fecha'] . '|' . $rowj['hora'] . '|' . $rowj['se'];
  $data = unserialize(decoBaseK($rowj['Jugada']));
  $ap = $rowj['monto'];
  $IDJ = $rowj['IDJ'];
  $MODO = 3;



  if ($MODO == 3) :

    $ver = true;
    if ($TU == 1) :
      $resultj2n = mysqli_query($link, "SELECT * FROM _Concesionario_Ani WHERE  IDC='" . $IDC . "'");
      $row2n = mysqli_fetch_array($resultj2n);
      $iTkPagar = $row2n['iTkPagar'];

      if ($iTkPagar == 1) :
        $resultHB = mysqli_query($link, "SELECT * FROM _Jugada_ani_pagado WHERE serial=" . $serial);
        if (mysqli_num_rows($resultHB) != 0) : $ver = true;
        else :   $ver = false;
        endif;
      endif;
    endif;
    $APremios = array();
    $Premio = 0;
    if ($ver) :
      $resultj2n = mysqli_query($link, "SELECT * FROM _Jugada_ani_prem  Where serial=" . $serial);
      if (mysqli_num_rows($resultj2n) != 0) :
        $row2n = mysqli_fetch_array($resultj2n);
        $habilitado = true;
        $Premio = $row2n['premio'];
        $APremios = unserialize(decoBaseK($row2n['Jpremio']));
      // print_r($APremios);
      endif;
    endif;
  endif;


  $sorteo = 0;
  $columna = 1;
  //for ($i=0;$i<=count($data)-1;$i++){

  foreach ($data as $i => $value) {
    if ($sorteo != $data[$i]->sorteo) :
      if ($sorteo !== 0) :
        $b .= '|';
        foreach ($arrNumeros as $n => $valueN) {
          $utl = strlen($valueN);
          $SvalueN = $valueN;
          $SvalueN[($utl - 1)] = ' ';
          $worP = $SvalueN . 'X' . $n;
          $b .= wordwrap($worP, 40, "*", TRUE) . '&';
        }
      //$b.='-';
      endif;
      $arrNumeros = array();
      if ($columna == 2) $b .= '|';

      if ($sorteo != 0) :
        foreach ($APremios as $s => $vs) {
          if ($APremios[$s]['l'] == $sorteo) :
            $nLis = _verAnimalito($APremios[$s]['n'], $datos[2]);
            $NumerodePremio[] = implode(',', $nLis);
            $b .= 'GANO CON:' . implode(',', $NumerodePremio) . ' PREMIO:' . $APremios[$s]['p'] . '|';
            $NumerodePremio = array();
          endif;
        }
      endif;
      $columna = 1;
      $sorteo = $data[$i]->sorteo;

      if ($MODO == 1) :
        $datos = _verSorteoTK($sorteo, $IDJ, $IDC);
        $b .= $datos[0] . '-1x' . $datos[1] . '=';
      else :
        $datos = _verSorteo($sorteo, $IDJ, $IDC);
        $b .= $datos[0] . '-1x' . $datos[1] . '|';
      endif;
      if ($MODO == 2) :
        $b .= '';
      endif;
    endif;

    switch ($data[$i]->modo) {
      case '0':
        $nombre = _verAnimalito($data[$i]->numero, $datos[2]);
        if ($MODO == 1) :
          $ind = (string)$data[$i]->monto;
          $arrNumeros[$ind] .= $nombre[0] . ',';
        else :
          if ($columna == 1) :
            $b .= $nombre[0] . '= ' . $data[$i]->monto . '#';
            $columna = 2;
          else :
            $b .= $nombre[0] . '= ' . $data[$i]->monto . '#';
            $columna = 1;
          endif;
        endif;
        break;
      case '1':
        $nombre = _verAnimalito($data[$i]->numero1 . ',' . $data[$i]->numero2, $datos[2]);
        if ($columna == 1) :
          $b .= $nombre[0] . '/' . $nombre[1] . '=' . $data[$i]->monto . '#';
          $columna = 2;
        else :
          $b .= $nombre[0] . '/' . $nombre[1] . '=' . $data[$i]->monto . '#';
          $columna = 1;
        endif;
        break;
      case '2':
        $nombre = _verAnimalito($data[$i]->numero1 . ',' . $data[$i]->numero2 . ',' . $data[$i]->numero3, $datos[2]);
        if ($columna == 1) :
          $b .= $nombre[0] . '/' . $nombre[1] . '/' . $nombre[2] . '=' . $data[$i]->monto . '#';
          $columna = 2;
        else :
          $b .= $nombre[0] . '/' . $nombre[1] . '/' . $nombre[2] . '=' . $data[$i]->monto . '#';
          $columna = 1;
        endif;
        break;
    }

    ///


  }
  if ($sorteo !== 0) :
    foreach ($arrNumeros as $n => $valueN) {
      $utl = strlen($valueN);
      $SvalueN = $valueN;
      $SvalueN[($utl - 1)] = ' ';
      $worP = $SvalueN . 'X' . $n;
      $b .= wordwrap($worP, 40, "*", TRUE) . '&';
    }
    foreach ($APremios as $s => $vs) {
      if ($APremios[$s]['l'] == $sorteo) :
        $nLis = _verAnimalito($APremios[$s]['n'], $datos[2]);
        $NumerodePremio[] = implode(',', $nLis);
        $b .= 'GANO CON:' . implode(',', $NumerodePremio) . ' PREMIO:' . $APremios[$s]['p'] . '|';
        $NumerodePremio = array();
      endif;
    }
  endif;
  $r[] = $b;
  $b = '';
  $b .= number_format($ap, 2, '.', '.');
  $r[] = $b;
  $b = '';
  if ($ver) :
    $b = number_format($Premio, 2, '.', '');
  endif;
  $r[] = $b;
  $b = '';


  return $r;
}
   /////////////////////////////////////////////////////////
