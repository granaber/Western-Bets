<?
require_once('prc_phpDUK.php');
global $server;
global $user;
global $clv;
global $db;
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

$result2 = @mysqli_query($link, "SELECT * FROM _Concesionario_Ani WHERE  IDC='" . $_REQUEST['IDC'] . "'");
$row2 = mysqli_fetch_array($result2);
$iTkPagar = $row2['iTkPagar'];


$element  = $doc->appendChild(new DOMElement('rows'));


$add = ' and Activo=' . $_REQUEST['Activo'];
$add .= " and IDC='" . $_REQUEST['IDC'] . "'";


$sql = "Select * from _Jugada_ani where IDJ=" . $IDJ . $add . "   order by serial";
//Serial,Hora,Fecha,Monto,Cantidad de Numeros
//Serial,Hora,Fecha,Monto,Premio,Gano con..
//Serial,Hora,Fecha,Monto,Cantidad de Numeros,Hora de Eliminacion
$resultj = @mysqli_query($link, $sql);
while ($Row = mysqli_fetch_array($resultj)) {
  $habilitado = false;
  switch ($op) {
    case '1':
      $resultj2n = @mysqli_query($link, "Select * from _Jugada_ani_prem where serial=" . $Row['serial']);
      if (mysqli_num_rows($resultj2n) == 0 && $Row['down'] == 0) $habilitado = true;
      break;
    case '2':
      if ($Row['down'] == 0) :

        $resultj2n = @mysqli_query($link, "Select * from _Jugada_ani_prem where serial=" . $Row['serial']);
        if (mysqli_num_rows($resultj2n) != 0) :
          $row2n = mysqli_fetch_array($resultj2n);
          $habilitado = true;
          $Premio = $row2n['premio'];
          $APremios = unserialize(decoBaseK($row2n['Jpremio']));
          // print_r($APremios);
          $NumerodePremio = array();
          if ($APremios != '') :
            for ($i = 0; $i <= count($APremios) - 1; $i++) {
              // echo $APremios[$i]['n'];
              $resultj3n = @mysqli_query($link, "SELECT * FROM _Jornada  Where  ID=" . $APremios[$i]['l']);
              $row3n = mysqli_fetch_array($resultj3n);
              $nLis = _verAnimalito($APremios[$i]['n'], $row3n['IDL']);
              $NumerodePremio[] = implode(',', $nLis);
            }
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
  if ($habilitado) :
    $element1  = $element->appendChild(new DOMElement('row'));
    $element1->setAttribute("id", $Row['serial']);

    $element_ns = new DOMElement('cell', $Row['serial'], '');
    $element1->appendChild($element_ns);

    $element_ns = new DOMElement('cell', convertirNormal($Row['hora']), '');
    $element1->appendChild($element_ns);

    $element_ns = new DOMElement('cell', $dfecha, '');
    $element1->appendChild($element_ns);

    $verJugada = unserialize(decoBaseK($Row['Jugada']));

    //if ($ap!=$Row['monto']):
    //  $resultjUPD = @mysqli_query($link,"Update  _Jugada_ani  set monto=".$ap." where serial=".$Row['serial']);
    //  endif;
    $element_ns = new DOMElement('cell', $Row['monto'], ''); //number_format($Row['monto'], 2, ',', '.')
    $element1->appendChild($element_ns);

    $ver = true;
    if ($iTkPagar == 1) :
      $resultHB = @mysqli_query($link, "SELECT * FROM _Jugada_ani_pagado WHERE serial=" . $Row['serial']);
      if (mysqli_num_rows($resultHB) != 0) : $ver = true;
      else :   $ver = false;
      endif;
    endif;

    switch ($op) {
      case '3':
      case '1':
        $ap = _MontoDUK($verJugada);
        $element_ns = new DOMElement('cell', count($verJugada), '');
        $element1->appendChild($element_ns);
        break;

      case '2':
        if ($ver) :
          $element_ns = new DOMElement('cell', $Premio, ''); //number_format($Premio, 2, ',', '.')
          $element1->appendChild($element_ns);
          $element_ns = new DOMElement('cell', implode(',', $NumerodePremio), '');
          $element1->appendChild($element_ns);
        else :
          $element_ns = new DOMElement('cell', '', ''); //number_format($Premio, 2, ',', '.')
          $element1->appendChild($element_ns);
          $element_ns = new DOMElement('cell', 'Ticket no Pagado', '');
          $element1->appendChild($element_ns);
        endif;
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

echo  $doc->saveXML();
