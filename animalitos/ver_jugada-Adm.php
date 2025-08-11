<?
require_once('prc_phpDUK.php');
global $serverD;
global $userD;
global $clvD;
global $dbD;
$lis = '';
$IDL = $_REQUEST['IDL'];

$conection = mysqli_connect($serverD, $userD, $clvD, $dbD);
if ($_REQUEST['IDG'] != 0) :
  $lIDC = array();
  $resultj = mysqli_query($conection, 'Select * from _tconsecionario where IDG in (' . $_REQUEST['IDG'] . ')');
  while ($Row = mysqli_fetch_array($resultj))
    $lIDC[] = "'" . $Row['IDC'] . "'";

  $lis = implode(',', $lIDC);
endif;

header("Content-type:text/xml");
$link = ConnectionAnimalitos::getInstance();
$op = $_REQUEST['op'];
if (isset($_REQUEST['fecc'])) :
  $IDJ = _FechaDUK($_REQUEST['fecc']);
  $dfecha = $_REQUEST['fecc'];
else :
  $IDJ = _FechaDUK();
  $dfecha = FecharealAnimalitos($minutosho, "d/n/Y");
endif;
$fecha = FecharealAnimalitos($minutosho, "d/n/Y");
$doc = new DOMDocument('1.0', 'UTF-8'); //encoding="iso-8859-1"?

$element  = $doc->appendChild(new DOMElement('rows'));


$add = ' and Activo=' . $_REQUEST['Activo'];
if ($_REQUEST['IDG'] != 0) :
  $add .= " and IDC in (" . $lis . ")";
endif;
$dxh = array();
$IDC = array();
$NOSI = array();
$FIlt = false;

if (isset($_REQUEST['dhx_colls'])) :
  $dxh = explode(',', $_REQUEST['dhx_colls']);
  $IDC = array();
  $NOSI = array();
  $FIlt = true;
endif;

$add1 = '';
$Derivado = '';
if (isset($_REQUEST['dhx_filter'])) :
  $dhx_filter = $_REQUEST['dhx_filter'];
  if ($op == 2) :
    if ($dhx_filter[0] != '') : $add1 = ' and serial Like "' . $dhx_filter[0] . '%" ';
    endif;
    if ($dhx_filter[1] != '') : $Derivado = $dhx_filter[1];
    endif;
    if ($dhx_filter[2] != '') : $add1 .= " and IDC='" . $dhx_filter[2] . "'";
    endif;
  else :
    if ($dhx_filter[0] != '') : $add1 = ' and serial Like "' . $dhx_filter[0] . '%" ';
    endif;
    if ($dhx_filter[1] != '') : $add1 .= " and IDC='" . $dhx_filter[1] . "'";
    endif;
  endif;
endif;


$sql = "Select * from _Jugada_ani where  IDJ=" . $IDJ . $add . $add1 . "   order by serial";
//echo $Derivado;
//Serial,Hora,Fecha,Monto,Cantidad de Numeros
//Serial,Hora,Fecha,Monto,Premio,Gano con..
//Serial,Hora,Fecha,Monto,Cantidad de Numeros,Hora de Eliminacion
$resultj = mysqli_query($link, $sql);
while ($Row = mysqli_fetch_array($resultj)) {
  $habilitado = false;
  switch ($op) {
    case '1':
      $resultj2n = mysqli_query($link, "Select * from _Jugada_ani_prem where serial=" . $Row['serial']);
      if (mysqli_num_rows($resultj2n) == 0 && $Row['down'] == 0) $habilitado = true;
      break;
    case '2':
      if ($Row['down'] == 0) :
        $resultj2n = mysqli_query($link, "Select * from _Jugada_ani_prem where serial=" . $Row['serial']);
        if (mysqli_num_rows($resultj2n) != 0) :
          $row2n = mysqli_fetch_array($resultj2n);
          $habilitado = true;
          $Premio = $row2n['premio'];
          $APremios = unserialize(decoBaseK($row2n['Jpremio']));
          $NumerodePremio = array();
          if ($APremios != '') :
            for ($i = 0; $i <= count($APremios) - 1; $i++) {
              $resultj3n = mysqli_query($link, "SELECT * FROM _Jornada  Where  ID=" . $APremios[$i]['l']);
              $row3n = mysqli_fetch_array($resultj3n);
              $nLis = _verAnimalito($APremios[$i]['n'], $row3n['IDL']);
              $NumerodePremio[] = implode(',', $nLis);
            }
          endif;
        endif;
        $pagado = false;
        $datospago = '';
        $resultj2n = mysqli_query($link, "Select * from _Jugada_ani_pagado where serial=" . $Row['serial']);
        if (mysqli_num_rows($resultj2n) != 0) :
          $row2n = mysqli_fetch_array($resultj2n);
          $pagado = true;
          $datos = explode('-', $row2n['usu_f_h']);
          $datospago = $datos[1] . '/' . $datos[2];
        endif;
      endif;

      if ($Derivado != '') :
        if ($Derivado == 'si') : if ($pagado) : $HBA = true;
          else : $HBA = false;
          endif;
        endif;
        if ($Derivado == 'no') :  if ($pagado == false) : $HBA = true;
          else : $HBA = false;
          endif;
        endif;
        if ($habilitado) :
          if ($HBA == false) : $habilitado = false;
          endif;
        endif;
      endif;
      //print_r($NumerodePremio);
      break;
    case '3':
      if ($Row['down'] == 1) $habilitado = true;
      break;
    case '4':
      $habilitado = true;
      break;
  }
  $verJugada = unserialize(decoBaseK($Row['Jugada']));
  if ($habilitado && $IDL != 0) :
    $find = false;
    foreach ($verJugada as $i => $Xvalue) {
      $IDSorteo = $verJugada[$i]->sorteo;
      // echo '**'.listLoteriByIDJ($IDSorteo,$IDJ)."-".$IDSorteo."-".$IDL;
      if (listLoteriByIDJ($IDSorteo, $IDJ) == $IDL) :
        $find = true;
        break;
      endif;
    }
    $habilitado = $find;
  endif;
  if ($habilitado) :
    $element1  = $element->appendChild(new DOMElement('row'));
    $element1->setAttribute("id", $Row['serial']);

    $element_ns = new DOMElement('cell', $Row['serial'], '');
    $element1->appendChild($element_ns);

    if ($op == 2) :
      if ($pagado) :
        $element_ns = new DOMElement('cell', 'si', '');
        $element1->appendChild($element_ns);
      else :
        $element_ns = new DOMElement('cell', 'no', '');
        $element1->appendChild($element_ns);
      endif;
      $NOSI['si'] = 'si';
      $NOSI['no'] = 'no';
    endif;

    //////////////
    $name = '';
    $idu = $Row['IDU'];
    $q = mysqli_query($conection, "Select * from _tusu where IDusu=$idu");
    if (mysqli_num_rows($q) != 0) :
      $r = mysqli_fetch_array($q);
      $name = $r['Nombre'];
    endif;

    ////////////

    $element_ns = new DOMElement('cell', $name . " (" . $Row['IDC'] . ")", '');
    $IDC[$Row['IDC']] = $Row['IDC'];
    $element1->appendChild($element_ns);

    $element_ns = new DOMElement('cell', convertirNormal($Row['hora']), '');
    $element1->appendChild($element_ns);

    $element_ns = new DOMElement('cell', $dfecha, '');
    $element1->appendChild($element_ns);



    //if ($ap!=$Row['monto']):
    //  $resultjUPD = mysqli_query($link,"Update  _Jugada_ani  set monto=".$ap." where serial=".$Row['serial']);
    //  endif;
    $element_ns = new DOMElement('cell', $Row['monto'], ''); //number_format($Row['monto'], 2, ',', '.')
    $element1->appendChild($element_ns);


    switch ($op) {
      case '3':
      case '1':
        $ap = _MontoDUK($verJugada);
        $element_ns = new DOMElement('cell', count($verJugada), '');
        $element1->appendChild($element_ns);
        break;

      case '2':
        $element_ns = new DOMElement('cell', $Premio, ''); //number_format($Premio, 2, ',', '.')
        $element1->appendChild($element_ns);
        if (count($NumerodePremio) == 0) :
          $element_ns = new DOMElement('cell', '', '');
        else :
          $element_ns = new DOMElement('cell', implode(',', $NumerodePremio), '');
        endif;
        $element1->appendChild($element_ns);
        $element_ns = new DOMElement('cell', $datospago, '');
        $element1->appendChild($element_ns);
        break;

      case '4':
        $verJugada = unserialize(decoBaseK($Row['Jugada']));
        $element_ns = new DOMElement('cell', count($verJugada), '');
        $element1->appendChild($element_ns);
        $element_ns = new DOMElement('cell', $Row['HE'], '');
        $element1->appendChild($element_ns);
        break;
    }

  endif;
}
if ($FIlt) :
  $idk = 1;
  if ($op == 2) :
    $idk = 2;
    $element1  = $element->appendChild(new DOMElement('coll_options'));
    $element1->setAttribute("for", 1);
    //  if (count($NOSI))
    foreach ($NOSI as $i => $x) {

      $me_ta = $element1->appendChild(new DOMElement('item'));
      $me_ta->setAttributeNode(new DOMAttr('value', $i));

      //$element_ns = new DOMElement('item','', '');
      //$element_ns->setAttributeNode(new DOMAttr('value', $i));
      //$element1->appendChild($element_ns);
    }
  endif;
  if (isset($IDC)) :
    $element1  = $element->appendChild(new DOMElement('coll_options'));
    $element1->setAttribute("for", $idk);
    foreach ($IDC as $i => $x) {

      $me_ta = $element1->appendChild(new DOMElement('item'));
      $me_ta->setAttributeNode(new DOMAttr('value', $i));

      //$element_ns = new DOMElement('item','', '');
      //$element_ns->setAttributeNode(new DOMAttr('value', $i));
      //$element1->appendChild($element_ns);
    }
  endif;
endif;

//endif;
echo  $doc->saveXML();