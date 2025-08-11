<?php
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', 'error.log');
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include('../class.ezpdf.php');
require_once('prc_phpDUK.php');
require_once('Ani_struct_xLoteri.php');

$link = ConnectionAnimalitos::getInstance();
global $minutosh;

class Creport extends Cezpdf
{

  var $reportContents = array();

  function Creport($p, $o)
  {
    $this->Cezpdf($p, $o);
  }

  function rf($info)
  {
    // this callback records all of the table of contents entries, it also places a destination marker there
    // so that it can be linked too
    $tmp = $info['p'];
    $lvl = $tmp[0];
    $lbl = rawurldecode(substr($tmp, 1));
    $num = $this->ezWhatPageNumber($this->ezGetCurrentPageNumber());
    $this->reportContents[] = array($lbl, $num, $lvl);
    $this->addDestination('toc' . (count($this->reportContents) - 1), 'FitH', $info['y'] + $info['height']);
  }

  function dots($info)
  {
    // draw a dotted line over to the right and put on a page number
    $tmp = $info['p'];
    $lvl = $tmp[0];
    $lbl = substr($tmp, 1);
    $xpos = 520;

    switch ($lvl) {
      case '1':
        $size = 16;
        $thick = 1;
        break;
      case '2':
        $size = 12;
        $thick = 0.5;
        break;
    }

    $this->saveState();
    $this->setLineStyle($thick, 'round', '', array(0, 10));
    $this->line($xpos, $info['y'], $info['x'] + 5, $info['y']);
    $this->restoreState();
    $this->addText($xpos + 5, $info['y'], $size, $lbl);
  }
}

function hiline($line)
{
  global  $pdf;
  $tmp = substr($line, 2, strlen($line) - 3);
  // add a grey bar, highlighting the change
  $tmp2 = $tmp . '<C:rf:2' . rawurlencode($tmp) . '>';
  $pdf->transaction('start');
  $ok = 0;
  while (!$ok) {
    $thisPageNum = $pdf->ezPageCount;
    $pdf->saveState();
    $pdf->setColor(0, 0, 0);
    $pdf->filledRectangle($pdf->ez['leftMargin'], $pdf->y - $pdf->getFontHeight(10) + $pdf->getFontDecender(10), $pdf->ez['pageWidth'] - $pdf->ez['leftMargin'] - $pdf->ez['rightMargin'], $pdf->getFontHeight(10));
    $pdf->restoreState();
    $pdf->setColor(1, 1, 1);
    $pdf->ezText($line, 10, array('justification' => 'center'));
    if ($pdf->ezPageCount == $thisPageNum) {
      $pdf->transaction('commit');
      $ok = 1;
    } else {
      // then we have moved onto a new page, bad bad, as the background colour will be on the old one
      $pdf->transaction('rewind');
      $pdf->ezNewPage();
    }
  }
}

$d1 = _ConverFecha($_REQUEST['d1']);
$d2 = _ConverFecha($_REQUEST['d2']);
$IDC = $_REQUEST['IDC'];
$ttex2 = '';
$add = '';
$desdeIDC = 0;
$hastaIDC = 0;
//// Determin rango de Lectura de IDJ
$result = mysqli_query($link, "SELECT * FROM _Jornarda_fecha  Where Fecha BETWEEN '" . $d1 . "' and '" . $d2 . "' ");
if (mysqli_num_rows($result) != 0) :
  $sihay = true;
  $verdatos = '';
  $i = 1;
  while ($row = mysqli_fetch_array($result)) {
    /*$hastaIDC=$row['IDJ']; */
    $verdatos .= ' IDJ=' . $row['IDJ'];
    if ($i < mysqli_num_rows($result)) :
      $verdatos .= ' or ';
      $i++;
    endif;
  }

  $add = " and  (" . $verdatos . " ) ";

  $iIDC = array();
  $result = mysqli_query($link, "SELECT * FROM _Concesionario_Ani order by IDC");
  while ($row = mysqli_fetch_array($result)) $iIDC[] = "'" . $row['IDC'] . "'";

  ///// Ver Opciones de Impresion ////
  $iGp = $_REQUEST['gp']; //<- Indica el Rango 0=Todas , 0<>Indica uno en especifico, Grupo, o PV
  $iOp = $_REQUEST['op']; //<- 2= Grupo 1=Punto de Venta
  $iGrupo = $_REQUEST['iGrupo']; // <- Esta opcion para determinar los Administradores de Grupo

  if ($iGrupo == 0) :
    $addn = '';
  else :
    $addn = ' and IDG in (' . $iGrupo . ')';
  endif;

  global $serverD;
  global $userD;
  global $clvD;
  global $dbD;

  $TextoSol = '';

  $conexion = mysqli_connect($serverD, $userD, $clvD, $dbD);

  $pIDG = array();
  $result = mysqli_query($link, "SELECT * FROM _tconsecionario where IDC in (" . implode(',', $iIDC) . ")  " . $addn . " order by IDC");
  while ($row = mysqli_fetch_array($result)) {
    if ($row['IDG'] != 0) :
      $lIDC[] = "'" . $row["IDC"] . "'";
      $lIDG[$row['IDG']] = $row['IDG'];
      $pIDG[$row['IDG']] .= "'" . $row["IDC"] . "',";
    endif;
  }
  asort($lIDG);
  ksort($pIDG);
  //print_r($lIDG);

  $pg = false;
  if ($iOp == 1) :
    if ($iGp != '0') :
      $add1 = " IDC='" . $iGp . "'";
      $TextoSol = 'Punto de Venta: ' . $iGp;
    else :
      $add1 = " IDC in (" . implode(',', $lIDC) . ")";
      $TextoSol = 'Todos los Punto de Venta';
    endif;
  else :
    if ($iGp != '0') :
      $vIDGtmp = explode(',', $pIDG[$iGp]);
      $vIDG = array_pop($vIDGtmp);
      $add1 = " IDC in (" . implode(',', $vIDGtmp) . ")";
      $TextoSol = 'Grupo No: ' . $iGp;
    else :
      $add1 = " IDC in (" . implode(',', $lIDC) . ")";
      $TextoSol = 'Reporte por Grupo ';
      $pg = true;
    endif;
  endif;





  global $server;
  global $user;
  global $clv;
  global $db;


  $conexion = mysqli_connect($server, $user, $clv, $db);

  $pdf = new Creport('LETTER', 'portrait');

  //$pdf =& new Cezpdf();
  $pdf->selectFont('../fonts/Helvetica.afm');
  $pdf->ezSetMargins(5, 5, 30, 30);

  $all = $pdf->openObject();
  $pdf->saveState();
  $pdf->addText(17, 50, 8, '** impreso:' . FecharealAnimalitos($minutosh, "d-m-y") . " " . HorarealAnimalitos($minutosh, "h:i:s A") . ' **', -90);
  $pdf->restoreState();
  $pdf->closeObject();

  $pdf->addObject($all, 'all');


  $pdf->ezSetY(puntos_cm(26.5));

  $pdf->ezText('Reporte de Ventas Resumido', 14, array('justification' => 'center'));
  $pdf->ezText('Venta desde:' . $_REQUEST['d1'] . ' Hasta:' . $_REQUEST['d2'], 10, array('justification' => 'center'));
  $pdf->ezText($TextoSol, 10, array('justification' => 'center'));
  if ($iGrupo != 0) : $pdf->ezText('Administrador de Grupo', 8, array('justification' => 'center'));
  endif;
  //$pdf->ezSetY(1);

  if ($pg) :
    $show['PVenta'] = 'Grupo';
  else :
    $show['PVenta'] = 'Punto de Venta';
  endif;
  $show['Ventas'] = 'Ventas';
  $show['Porcentaje'] = 'Porcentaje';
  $show['Premios'] = 'Premios';
  //$show['PremiosP']='Premios Pagados';
  $show['Diferencia'] = 'Diferencia';
  $show['DiferenciaP'] = 'Diferencia PP';
  $show['Participacion'] = 'Participacion';
  $show['Banca'] = 'Banca';




  $data = array();
  $Suma1 = 0;
  $Suma2 = 0;
  $Suma3 = 0;
  $Suma4 = 0;
  $Suma5 = 0;
  $Suma6 = 0;
  $Suma7 = 0;
  $Suma8 = 0;

  if ($pg) :
    foreach ($pIDG as $i => $delta) {
      $vIDGtmp = explode(',', $pIDG[$i]);
      $vIDG = array_pop($vIDGtmp);
      $add1 = " IDC in (" . implode(',', $vIDGtmp) . ")";
      $VentasG = 0;
      $Porcentaje = 0;
      $PorcentajeG = 0;
      $PremiosPG = 0;
      $PremiosG = 0;
      $Diferencia = 0;
      $DiferenciaG = 0;
      $DiferenciaPG = 0;
      $ParticipacionG = 0;
      $somosG = 0;
      $result2 = mysqli_query($link, "SELECT * FROM _Concesionario_Ani WHERE  " . $add1);
      while ($row = mysqli_fetch_array($result2)) {
        $aa = array();
        $iPorcentaje = $row['iPVenta'];
        $iParticipa = $row['iPParti'];
        $iTkPagar = $row['iTkPagar'];
        $Ventas = 0;
        $PremiosP = 0;
        $Premios = 0;
        $somos = 0;
        $Porcentaje = 0;
        _datossearch($row['IDC'], $add, $Ventas, $PremiosP, $Premios, $somos, $Porcentaje);
        $VentasG += $Ventas;
        // $Porcentaje=($Ventas*$iPorcentaje)/100;
        $PorcentajeG +=  ($Porcentaje);
        $PremiosPG += $PremiosP;
        $PremiosG += $Premios;
        $Diferencia = $Ventas - ($Porcentaje + $Premios);
        $DiferenciaG += ($Diferencia);
        $DiferenciaPG += ($VentasG - ($Porcentaje + $PremiosPG));
        $ParticipacionG += (($Diferencia * $iParticipa) / 100);
        $somosG += $somos;
      }

      $aa['PVenta'] = 'Grupo ' . $i;
      $aa['Ventas'] = number_format($VentasG, 2, ',', '.');
      $Suma1 += $VentasG;
      $aa['Porcentaje'] = number_format($PorcentajeG, 2, ',', '.');
      $Suma2 += $PorcentajeG;
      $aa['Premios'] = number_format($PremiosG, 2, ',', '.');
      $Suma3 += $PremiosG;
      //      $aa['PremiosP']=number_format($PremiosPG, 2, ',', '.');$Suma4+=$PremiosPG;

      $aa['Diferencia'] = number_format($DiferenciaG, 2, ',', '.');
      $Suma5 += $DiferenciaG;

      $aa['DiferenciaP'] = number_format($DiferenciaPG, 2, ',', '.');
      $Suma6 += $DiferenciaPG;

      $aa['Participacion'] = number_format($ParticipacionG, 2, ',', '.');
      $Suma7 += $ParticipacionG;
      $banca = $DiferenciaG - $ParticipacionG;
      $aa['Banca'] = number_format($banca, 2, ',', '.');
      $Suma8 += $banca;
      if ($VentasG != 0)
        $data[] = $aa;
    }
  else :
    $result2 = mysqli_query($link, "SELECT * FROM _Concesionario_Ani WHERE  " . $add1);
    while ($row = mysqli_fetch_array($result2)) {
      $aa = array();
      $iPorcentaje = $row['iPVenta'];
      $iParticipa = $row['iPParti'];
      $iTkPagar = $row['iTkPagar'];
      $Ventas = 0;
      $PremiosP = 0;
      $Premios = 0;
      $somos = 0;
      $Porcentaje = 0;
      _datossearch($row['IDC'], $add, $Ventas, $PremiosP, $Premios, $somos, $Porcentaje);

      $aa['PVenta'] = $row['IDC'];
      $aa['Ventas'] = number_format($Ventas, 2, ',', '.');
      $Suma1 += $Ventas;
      // $Porcentaje=($Ventas*$iPorcentaje)/100;
      $aa['Porcentaje'] = number_format($Porcentaje, 2, ',', '.');
      $Suma2 += $Porcentaje;
      $aa['Premios'] = number_format($Premios, 2, ',', '.');
      $Suma3 += $Premios;
      //      $aa['PremiosP']=number_format($PremiosP, 2, ',', '.');$Suma4+=$PremiosP;
      $Diferencia = $Ventas - ($Porcentaje + $Premios);
      $aa['Diferencia'] = number_format($Diferencia, 2, ',', '.');
      $Suma5 += $Diferencia;
      $DiferenciaP = $Ventas - ($Porcentaje + $PremiosP);
      $aa['DiferenciaP'] = number_format($DiferenciaP, 2, ',', '.');
      $Suma6 += $DiferenciaP;
      $Participacion = ($Diferencia * $iParticipa) / 100;
      $aa['Participacion'] = number_format($Participacion, 2, ',', '.') . '(' . $iParticipa . '%)';
      $Suma7 += $Participacion;
      $banca = $Diferencia - $Participacion;
      $aa['Banca'] = number_format($banca, 2, ',', '.');
      $Suma8 += $banca;
      if ($Ventas != 0)
        $data[] = $aa;
    }
  endif;
  $aa = array();
  $aa['PVenta'] = 'Totales:';
  $aa['Ventas'] = number_format($Suma1, 2, ',', '.');
  $aa['Porcentaje'] = number_format($Suma2, 2, ',', '.');
  $aa['Premios'] = number_format($Suma3, 2, ',', '.');
  //$aa['PremiosP']=number_format($Suma4, 2, ',', '.');
  $aa['Diferencia'] = number_format($Suma5, 2, ',', '.');
  $aa['DiferenciaP'] = number_format($Suma6, 2, ',', '.');
  $aa['Participacion'] = number_format($Suma7, 2, ',', '.');
  $aa['Banca'] = number_format($Suma8, 2, ',', '.');

  $data[] = $aa;

  $pdf->ezTable($data, $show, '', array('fontSize' => 8, 'showLines' => 1, 'xPos' => 35, 'xOrientation' => 'right', 'rowGap' => 1, 'cols' => array('Ventas' => array('justification' => 'right'), 'Porcentaje' => array('justification' => 'right'), 'Premios' => array('justification' => 'right'), 'PremiosP' => array('justification' => 'right'), 'Diferencia' => array('justification' => 'right'), 'DiferenciaP' => array('justification' => 'right'), 'Participacion' => array('justification' => 'right'), 'Banca' => array('justification' => 'right'))));

  $pdf->ezStream();
endif;
function puntos_cm($medida, $resolucion = 72)
{
  //// 2.54 cm / pulgada
  return ($medida / (2.54)) * $resolucion;
}

function _datossearch($IDC, $add, &$Ventas, &$PremiosP, &$Premios, &$somos, &$Porcentaje)
{
  global $link;

  $serK = array();
  //  echo '<span style="position: absolute;top:50px;left: 50px;"> Procesando:'.$IDC.' Seriales: ';
  //  echo ("SELECT serial , monto FROM _Jugada_ani  where IDC='".$IDC."' and Activo=1 ".$add);
  $result2D1 = mysqli_query($link, "SELECT serial , monto,IDJ,Jugada FROM _Jugada_ani  where IDC='" . $IDC . "' and Activo=1 " . $add);
  while ($row2 = mysqli_fetch_array($result2D1)) {
    $Ventas += $row2['monto'];
    $somos++;
    $serK[] = $row2['serial'];
    $ventasQ =  thisStructData($row2['Jugada']);
    $porcen =  thisPorcentaje($IDC, $ventasQ);
    $Porcentaje += array_sum($porcen);
  }

  $PremiosP = 0;
  $Premios = 0;
  //echo "SELECT Sum(montopagado) as Premio FROM _Jugada_ani_pagado WHERE serial IN (".implode(",", $serK).")";
  if (count($serK) != 0) :
    $result2D1 = mysqli_query($link, "SELECT Sum(montopagado) as Premio FROM _Jugada_ani_pagado WHERE serial IN (" . implode(",", $serK) . ")");
    $row2 = mysqli_fetch_array($result2D1);
    $PremiosP = $row2['Premio'];

    //if ($IDC=='NAVIS-18'):
    //  echo ("SELECT Sum(premio) as Premio FROM _Jugada_ani_prem WHERE Serial IN (".implode(",", $serK).")");
    //SELECT Sum(premio) as Premio FROM _Jugada_ani_prem WHERE Serial IN (2000722,2000723,2000731,2000740,2000741,2000778,2000781,2000812,2000815,2000976,2001005,2001047,2001077,2001096,2001121,2001153,2001216,2001303,2001321,2001346,2001487,2001500,2001521,2001701,2001711,2001876,2001888,2001891,2001910,2001921,2001955,2002018,2002042,2002461,2002464,2002468,2002487,2002490,2002494,2002496,2002497,2002518,2002521,2002553,2002585,2002599,2002609,2002613,2002633,2002704,2002832,2002858,2002953,2002957,2002990,2003081,2003140,2003148,2003154,2003160,2003173,2003189,2003204,2003211,2003220,2003315,2003322,2003403,2003419,2003456,2003462,2003558,2003562,2003575,2003579,2003582,2003627,2003629,2003637,2003756,2003760,2003767,2003844,2003849,2003899,2003907,2003951,2003965,2003969,2003972,2003990,2003994)
    //endif;

    $result2D1 = mysqli_query($link, "SELECT Sum(premio) as Premio FROM _Jugada_ani_prem WHERE Serial IN (" . implode(",", $serK) . ")");
    $row2 = mysqli_fetch_array($result2D1);
    $Premios = $row2['Premio'];
  endif;

  //echo implode(',',$serK);
}
