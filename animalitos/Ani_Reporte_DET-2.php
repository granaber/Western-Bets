<?php
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', 'error.log');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../Cezpdf.php');
require_once('prc_phpDUK.php');
require_once('Ani_struct_xLoteri.php');


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
$IDC = $_REQUEST['IDC'] ?? '';
$ttex2 = '';
$add = '';
$desdeIDC = 0;
$hastaIDC = 0;
//// Determin rango de Lectura de IDJ
$link = ConnectionAnimalitos::getInstance();
$result = mysqli_query($link, "SELECT * FROM _Jornarda_fecha  Where Fecha BETWEEN '" . $d1 . "' and '" . $d2 . "' ");
if (mysqli_num_rows($result) != 0) :
  $sihay = true;
  $verdatos = '';
  $i = 1;
  $iFechas = array();
  while ($row = mysqli_fetch_array($result)) {
    $iFechas[$row['IDJ']] = _ConverFechaT2($row['Fecha']);
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
  //  echo ("SELECT * FROM _tconsecionario where IDC in (".implode(',',$iIDC).")  ".$addn." order by IDC");
  $result = mysqli_query($conexion, "SELECT * FROM _tconsecionario where IDC in (" . implode(',', $iIDC) . ")  " . $addn . " order by IDC");
  while ($row = mysqli_fetch_array($result)) {
    if ($row['IDG'] != 0) :
      $lIDC[] = "'" . $row["IDC"] . "'";
      $lIDG[$row['IDG']] = $row['IDG'];
      $pIDG[$row['IDG']] = $pIDG[$row['IDG']] ?? '';
      $pIDG[$row['IDG']] .= "'" . $row["IDC"] . "',";
    endif;
  }
  asort($lIDG);
  ksort($pIDG);

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

  // global $server;
  // global $user;
  // global $clv;
  // global $db;


  // $conexion = mysqli_connect($server, $user, $clv, $db);

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

  $pdf->ezText('Reporte de Ventas Detallado', 14, array('justification' => 'center'));
  $pdf->ezText('Venta desde:' . $_REQUEST['d1'] . ' Hasta:' . $_REQUEST['d2'], 10, array('justification' => 'center'));
  $pdf->ezText($TextoSol, 10, array('justification' => 'center'));
  if ($iGrupo != 0) : $pdf->ezText('Administrador de Grupo (' . $iGrupo . ')', 8, array('justification' => 'center'));
  endif;


  if ($pg) :
    $show['PVenta'] = 'Grupo';
  else :
    $show['PVenta'] = 'Punto de Venta';
  endif;
  $show['Ventas'] = 'Ventas';
  $show['Porcentaje'] = 'Porcentaje';
  $show['Premios'] = 'Premios';
  $show['PremiosP'] = 'Premios Pagados';
  $show['Diferencia'] = 'Diferencia';
  $show['DiferenciaP'] = 'Diferencia PP';
  $show['Participacion'] = 'Participacion';
  $show['Banca'] = 'Banca';


  $Suma1 = 0;
  $Suma2 = 0;
  $PremiosF = 0;
  $Suma3 = 0;
  $PremiosPF = 0;
  $Suma4 = 0;
  $DiferenciaF = 0;
  $Suma5 = 0;
  $DiferenciaPF = 0;
  $Suma6 = 0;
  $ParticipacionF = 0;
  $Suma7 = 0;
  $DiferenciaF = 0;
  $ParticipacionF = 0;
  $PorcentajeF = 0;
  $Suma8 = 0;
  $VentasF = 0;
  $Suma1G = 0;
  $Suma2G = 0;
  $Suma3G = 0;
  $Suma4G = 0;
  $Suma5G = 0;
  $Suma6G = 0;
  $Suma7G = 0;
  $Suma8G = 0;
  $somosF = 0;

  $data = array();


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
      $DatosIDC = array();




      $IDJ = 0;
      $resultD = mysqli_query($link, "SELECT IDJ, IDC,count( serial ) AS cuanto, Sum( monto ) AS Venta FROM _Jugada_ani  where " . $add1 . " and Activo=1 " . $add . " GROUP BY IDC,IDJ ORDER BY IDJ");
      while ($rowD = mysqli_fetch_array($resultD)) {
        if ($IDJ == 0) : $IDJ = $rowD['IDJ'];
        endif;

        $Ventas = $rowD['Venta'];
        $somos = $rowD['cuanto'];

        if (!isset($DatosIDC[$rowD['IDC']])) :
          $resultD2 = mysqli_query($link, "SELECT * FROM _Concesionario_Ani WHERE IDC='" . $rowD['IDC'] . "'");
          $rowD1 = mysqli_fetch_array($resultD2);
          $iPorcentaje = $rowD1['iPVenta'];
          $iParticipa = $rowD1['iPParti'];
          $iTkPagar = $rowD1['iTkPagar'];
          $DatosIDC[$rowD['IDC']] = array($iPorcentaje, $iParticipa, $iTkPagar);
        else :
          $iPorcentaje = $DatosIDC[$rowD['IDC']][0];
          $iParticipa = $DatosIDC[$rowD['IDC']][1];
          $iTkPagar = $DatosIDC[$rowD['IDC']][2];
        endif;


        $resultD2 = mysqli_query($link, "SELECT Sum(montopagado) as Premio FROM _Jugada_ani_pagado WHERE serial IN (SELECT serial FROM _Jugada_ani WHERE IDC='" . $rowD['IDC'] . "' and Activo=1 and IDJ=" . $rowD['IDJ'] . ")");
        $rowD2 = mysqli_fetch_array($resultD2);
        $PremiosP = $rowD2['Premio'];

        $resultD2 = mysqli_query($link, "SELECT Sum(premio) as Premio FROM _Jugada_ani_prem WHERE Serial IN (SELECT serial FROM _Jugada_ani WHERE IDC='" . $rowD['IDC'] . "' and Activo=1  and IDJ=" . $rowD['IDJ'] . ")");
        $rowD2 = mysqli_fetch_array($resultD2);
        $Premios = $rowD2['Premio'];

        if ($IDJ == $rowD['IDJ']) :
          $dataStructxLotery = StructuData($rowD['IDJ'], $rowD['IDC']);

          $VentasF += $Ventas;
          $Porcentaje = array_sum($dataStructxLotery[1]);
          $PorcentajeF += ($Porcentaje);
          $PremiosPF += $PremiosP;
          $PremiosF += $Premios;
          $Diferencia = $Ventas - ($Porcentaje + $Premios);
          $DiferenciaF += ($Diferencia);
          $DiferenciaPF += ($Ventas - ($Porcentaje + $PremiosP));
          $ParticipacionF += (($Diferencia * $iParticipa) / 100);
          $somosF += $somos;
        else :
          $aa = array();
          $aa['PVenta'] = 'Grupo: ' . $i;
          $data[] = $aa;
          $aa = array();
          $aa['PVenta'] = $iFechas[$IDJ];
          $aa['Ventas'] = number_format($VentasF, 2, ',', '.');
          $Suma1 += $VentasF;
          $aa['Porcentaje'] = number_format($PorcentajeF, 2, ',', '.');
          $Suma2 += $PorcentajeF;
          $aa['Premios'] = number_format($PremiosF, 2, ',', '.');
          $Suma3 += $PremiosF;
          $aa['PremiosP'] = number_format($PremiosPF, 2, ',', '.');
          $Suma4 += $PremiosPF;
          $aa['Diferencia'] = number_format($DiferenciaF, 2, ',', '.');
          $Suma5 += $DiferenciaF;
          $aa['DiferenciaP'] = number_format($DiferenciaPF, 2, ',', '.');
          $Suma6 += $DiferenciaPF;
          $aa['Participacion'] = number_format($ParticipacionF, 2, ',', '.');
          $Suma7 += $ParticipacionF;
          $banca = $DiferenciaF - $ParticipacionF;
          $aa['Banca'] = number_format($banca, 2, ',', '.');
          $Suma8 += $banca;
          $data[] = $aa;

          $VentasF = 0;
          $PorcentajeF = 0;
          $PremiosPF = 0;
          $PremiosF = 0;
          $DiferenciaF = 0;
          $DiferenciaPF = 0;
          $ParticipacionF = 0;
          $somosF = 0;

          $dataStructxLotery = StructuData($IDJ, $rowD['IDC']);

          $VentasF += $Ventas;

          $Porcentaje = array_sum($dataStructxLotery[1]);
          $PorcentajeF +=  ($Porcentaje);
          $PremiosPF += $PremiosP;
          $PremiosF += $Premios;
          $Diferencia = $Ventas - ($Porcentaje + $Premios);
          $DiferenciaF += ($Diferencia);
          $DiferenciaPF += ($VentasG - ($Porcentaje + $PremiosPG));
          $ParticipacionF += (($Diferencia * $iParticipa) / 100);
          $somosF += $somos;
          $IDJ = $rowD['IDJ'];

        endif;
      }

      $aa = array();
      $aa['PVenta'] = $iFechas[$IDJ] ?? '';
      $aa['Ventas'] = number_format($VentasF ?? 0, 2, ',', '.');
      $Suma1 += ($VentasF ?? 0);
      $aa['Porcentaje'] = number_format($PorcentajeF ?? 0, 2, ',', '.');
      $Suma2 += ($PorcentajeF ?? 0);
      $aa['Premios'] = number_format($PremiosF, 2, ',', '.');
      $Suma3 += $PremiosF;
      $aa['PremiosP'] = number_format($PremiosPF, 2, ',', '.');
      $Suma4 += $PremiosPF;
      $aa['Diferencia'] = number_format($DiferenciaF, 2, ',', '.');
      $Suma5 += $DiferenciaF;
      $aa['DiferenciaP'] = number_format($DiferenciaPF, 2, ',', '.');
      $Suma6 += $DiferenciaPF;
      $aa['Participacion'] = number_format($ParticipacionF, 2, ',', '.');
      $Suma7 += $ParticipacionF;
      $banca = $DiferenciaF - $ParticipacionF;
      $aa['Banca'] = number_format($banca, 2, ',', '.');
      $Suma8 += $banca;
      if ($VentasF != 0) $data[] = $aa;
      $aa = array();
      $VentasF = 0;
      $PorcentajeF = 0;
      $PremiosPF = 0;
      $PremiosF = 0;
      $DiferenciaF = 0;
      $DiferenciaPF = 0;
      $ParticipacionF = 0;
      $somosF = 0;

      $aa['PVenta'] = 'Subtotal Grupo ' . $i;
      $aa['Ventas'] = number_format($Suma1, 2, ',', '.');
      $Suma1G += $Suma1;
      $aa['Porcentaje'] = number_format($Suma2, 2, ',', '.');
      $Suma2G += $Suma2;
      $aa['Premios'] = number_format($Suma3, 2, ',', '.');
      $Suma3G += $Suma3;
      $aa['PremiosP'] = number_format($Suma4, 2, ',', '.');
      $Suma4G += $Suma4;
      $aa['Diferencia'] = number_format($Suma5, 2, ',', '.');
      $Suma5G += $Suma5;
      $aa['DiferenciaP'] = number_format($Suma6, 2, ',', '.');
      $Suma6G += $Suma6;
      $aa['Participacion'] = number_format($Suma7, 2, ',', '.');
      $Suma7G += $Suma7;
      $aa['Banca'] = number_format($Suma8, 2, ',', '.');
      $Suma8G += $Suma8;
      if ($Suma1 != 0)  $data[] = $aa;
      $Suma1 = 0;
      $Suma2 = 0;
      $Suma3 = 0;
      $Suma4 = 0;
      $Suma5 = 0;
      $Suma6 = 0;
      $Suma7 = 0;
      $Suma8 = 0;
    }
  else :
    $Suma1G = 0;
    $Suma2G = 0;
    $Suma3G = 0;
    $Suma4G = 0;
    $Suma5G = 0;
    $Suma6G = 0;
    $Suma7G = 0;
    $Suma8G = 0;
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

      $Suma1 = 0;
      $Suma2 = 0;
      $Suma3 = 0;
      $Suma4 = 0;
      $Suma5 = 0;
      $Suma6 = 0;
      $Suma7 = 0;
      $Suma8 = 0;


      //_datossearch($row['IDC'],$add,$Ventas,$PremiosP,$Premios,$somos);
      $resultD1 = mysqli_query($link, "SELECT IDJ,count( serial ) AS cuanto, Sum( monto ) AS Venta FROM _Jugada_ani  where IDC='" . $row['IDC'] . "' and Activo=1 " . $add . " GROUP BY IDJ ORDER BY IDJ");
      while ($rowD1 = mysqli_fetch_array($resultD1)) {
        $dataStructxLotery = StructuData($rowD1['IDJ'], $row['IDC']);
        $Ventas = $rowD1['Venta'];
        $somos = $rowD1['cuanto'];

        $resultD2 = mysqli_query($link, "SELECT Sum(montopagado) as Premio FROM _Jugada_ani_pagado WHERE serial IN (SELECT serial FROM _Jugada_ani WHERE IDC='" . $row['IDC'] . "' and Activo=1 and IDJ=" . $rowD1['IDJ'] . ")");
        $rowD2 = mysqli_fetch_array($resultD2);
        $PremiosP = $rowD2['Premio'];

        $resultD2 = mysqli_query($link, "SELECT Sum(premio) as Premio FROM _Jugada_ani_prem WHERE Serial IN (SELECT serial FROM _Jugada_ani WHERE IDC='" . $row['IDC'] . "' and Activo=1  and IDJ=" . $rowD1['IDJ'] . ")");
        $rowD2 = mysqli_fetch_array($resultD2);
        $Premios = $rowD2['Premio'];

        $aa['PVenta'] = 'PV:' . $row['IDC'];
        // $data[]=$aa;
        $aa = array();

        $aa['PVenta'] = $iFechas[$rowD1['IDJ']];
        $aa['Ventas'] = number_format($Ventas, 2, ',', '.');
        $Suma1 += $Ventas;
        $Porcentaje = array_sum($dataStructxLotery[1]); //($Ventas*$iPorcentaje)/100;
        $aa['Porcentaje'] = number_format($Porcentaje, 2, ',', '.');
        $Suma2 += $Porcentaje;
        $aa['Premios'] = number_format($Premios, 2, ',', '.');
        $Suma3 += $Premios;
        $aa['PremiosP'] = number_format($PremiosP, 2, ',', '.');
        $Suma4 += $PremiosP;
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

        if ($Ventas != 0)  $data[] = $aa;
      }
      $aa = array();
      $aa['PVenta'] = 'Sub Totales(' . $row['IDC'] . '):';
      $aa['Ventas'] = number_format($Suma1, 2, ',', '.');
      $Suma1G += $Suma1;
      $aa['Porcentaje'] = number_format($Suma2, 2, ',', '.');
      $Suma2G += $Suma2;
      $aa['Premios'] = number_format($Suma3, 2, ',', '.');
      $Suma3G += $Suma3;
      $aa['PremiosP'] = number_format($Suma4, 2, ',', '.');
      $Suma4G += $Suma4;
      $aa['Diferencia'] = number_format($Suma5, 2, ',', '.');
      $Suma5G += $Suma5;
      $aa['DiferenciaP'] = number_format($Suma6, 2, ',', '.');
      $Suma6G += $Suma6;
      $aa['Participacion'] = number_format($Suma7, 2, ',', '.');
      $Suma7G += $Suma7;
      $aa['Banca'] = number_format($Suma8, 2, ',', '.');
      $Suma8G += $Suma8;

      if ($Suma1 != 0) $data[] = $aa;
    }
  endif;
  $aa = array();
  $aa['PVenta'] = ' Totales';
  $aa['Ventas'] = number_format($Suma1G, 2, ',', '.');
  $aa['Porcentaje'] = number_format($Suma2G, 2, ',', '.');
  $aa['Premios'] = number_format($Suma3G, 2, ',', '.');
  $aa['PremiosP'] = number_format($Suma4G, 2, ',', '.');
  $aa['Diferencia'] = number_format($Suma5G, 2, ',', '.');
  $aa['DiferenciaP'] = number_format($Suma6G, 2, ',', '.');
  $aa['Participacion'] = number_format($Suma7G, 2, ',', '.');
  $aa['Banca'] = number_format($Suma8G, 2, ',', '.');

  if ($Suma1G != 0) $data[] = $aa;

  $pdf->ezTable($data, $show, '', array('fontSize' => 8, 'showLines' => 1, 'xPos' => 35, 'xOrientation' => 'right', 'rowGap' => 1, 'cols' => array('Ventas' => array('justification' => 'right'), 'Porcentaje' => array('justification' => 'right'), 'Premios' => array('justification' => 'right'), 'PremiosP' => array('justification' => 'right'), 'Diferencia' => array('justification' => 'right'), 'DiferenciaP' => array('justification' => 'right'), 'Participacion' => array('justification' => 'right'), 'Banca' => array('justification' => 'right'))));
  $pdf->ezStream();
endif;
function puntos_cm($medida, $resolucion = 72)
{
  //// 2.54 cm / pulgada
  return ($medida / (2.54)) * $resolucion;
}
//function _datossearch($IDC,$add,&$Ventas,&$PremiosP,&$Premios,&$somos){


//}