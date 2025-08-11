<?php
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', 'error.log');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../class.ezpdf.php');
require_once('prc_phpDUK.php');

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
$link = ConnectionAnimalitos::getInstance();
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

  global $serverD;
  global $userD;
  global $clvD;
  global $dbD;

  $TextoSol = '';

  $conexion = mysqli_connect($serverD, $userD, $clvD, $dbD);

  $pIDG = array();
  $result = mysqli_query($conexion, "SELECT * FROM _tconsecionario where IDC in (" . implode(',', $iIDC) . ")   order by IDC");
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

  $add1 = " IDC in (" . implode(',', $lIDC) . ")";
  $TextoSol = 'Todos los Punto de Venta';

  // global $server;
  // global $user;
  // global $clv;
  // global $db;


  // $conexion = mysqli_connect($server, $user, $clv, $db);

  $pdf = new Creport('A3', 'landscape');

  //$pdf =& new Cezpdf();
  $pdf->selectFont('../fonts/Helvetica.afm');
  $pdf->ezSetMargins(5, 5, 30, 30);

  $all = $pdf->openObject();
  $pdf->saveState();
  $pdf->addText(17, 50, 8, '** impreso:' . FecharealAnimalitos($minutosh, "d-m-y") . " " . HorarealAnimalitos($minutosh, "h:i:s A") . ' **', -90);
  $pdf->restoreState();
  $pdf->closeObject();

  $pdf->addObject($all, 'all');


  // $pdf->ezSetY(puntos_cm(26.5));

  $pdf->ezText('Reporte de Conteo ', 14, array('justification' => 'center'));
  $pdf->ezText('Venta desde:' . $_REQUEST['d1'] . ' Hasta:' . $_REQUEST['d2'], 10, array('justification' => 'center'));
  $pdf->ezText($TextoSol, 10, array('justification' => 'center'));

  $show['PVenta'] = 'Punto de Venta';
  $show['Sorteo'] = 'Sorteo';
  $show['Loteria'] = 'Loteria';
  for ($i = 1; $i <= 40; $i++) {
    $show['n' . $i] = "n$i";
  }
  $show['procion'] = 'Porcion';
  $data = array();
  //  echo ("SELECT * FROM _Count_Track WHERE  ".$add1." ".$add);
  $result2 = mysqli_query($link, "SELECT * FROM _Count_Track WHERE  " . $add1 . " " . $add);
  while ($row = mysqli_fetch_array($result2)) {
    $aa = array();
    $dataX = unserialize($row['iJson']);
    $aa['PVenta'] = $row['IDC'];
    $aa['Sorteo'] = $row['IDL'];
    foreach ($dataX as $i => $value) {
      $id = 'n' . $i;
      $aa[$id] = $dataX[$i];
    }
    $result3 = mysqli_query($link, "SELECT _Jornada.*,_Loterias.Nombre FROM _Jornada,_Loterias  Where  _Jornada.IDL=_Loterias.IDL and  _Jornada.ID=" . $row['IDL']);
    $row = mysqli_fetch_array($result3);
    $aa['Sorteo'] = $row['HoraCierre'];
    $aa['Loteria'] = $row['Nombre'];
    $aa['procion'] = count($dataX) . ' / ' . $row['CantidadNum'];
    $data[] = $aa;
  }


  $pdf->ezTable($data, $show, '', array('fontSize' => 8, 'showLines' => 1, 'xPos' => 35, 'xOrientation' => 'right', 'rowGap' => 1));

  $pdf->ezStream();
endif;
function puntos_cm($medida, $resolucion = 72)
{
  //// 2.54 cm / pulgada
  return ($medida / (2.54)) * $resolucion;
}
