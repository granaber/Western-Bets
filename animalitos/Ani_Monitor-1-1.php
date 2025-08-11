<?
header("Content-type:text/xml");
require_once('prc_phpDUK.php');
global $server;
global $user;
global $clv;
global $db;

$link = ConnectionAnimalitos::getInstance();
$ArrMon = _NowMonitor($_REQUEST['IDJ'], $_REQUEST['IDS']);
$doc = new DOMDocument('1.0', 'UTF-8'); //encoding="iso-8859-1"?

$sql = "Select * from _NumeroAnimatios where Activo=1  and IDL=" . $_REQUEST['IDL'];
$resultj = mysqli_query($link, $sql);
$suma = 0;
while ($Row = mysqli_fetch_array($resultj)) {
  $suma = $ArrMon[$_REQUEST['IDS']][$Row['num']]['monto'] + $suma;
}

$element  = $doc->appendChild(new DOMElement('rows'));
$c = 0;
$sql = "Select * from _NumeroAnimatios where Activo=1  and IDL=" . $_REQUEST['IDL'];
$resultj = mysqli_query($link, $sql);
$somos = 0;
while ($Row = mysqli_fetch_array($resultj)) {

  if ($c == 0) :
    $element1  = $element->appendChild(new DOMElement('row'));
    $element1->setAttribute("id", $Row['num']);

  endif;
  $element_ns = new DOMElement('cell', $Row['num'], '');
  $element1->appendChild($element_ns);

  $elementns = $doc->createElement('cell');
  $elementns->appendChild($doc->createCDATASection('<img style="width: 50px;height: 50px;" src="animalitos/imag/' . $Row['figura'] . '" />'));
  $element1->appendChild($elementns);

  $sup = $ArrMon[$_REQUEST['IDS']][$Row['num']]['monto'];
  if ($sup != 0) : $sup = number_format($sup, 2, ',', '.');
  else : $sup = '';
  endif;
  $element_ns = new DOMElement('cell', $sup, '');
  $element1->appendChild($element_ns);

  $element_ns = new DOMElement('cell', $ArrMon[$_REQUEST['IDS']][$Row['num']]['tk'], '');
  $element1->appendChild($element_ns);
  $somos = $ArrMon[$_REQUEST['IDS']][$Row['num']]['tk'] + $somos;
  $sup = $ArrMon[$_REQUEST['IDS']][$Row['num']]['monto'];
  if ($sup != 0) : $porc = ($sup / $suma) * 100;
    $porc = number_format($porc, 2, ',', '.') . '%';
  else : $porc = '';
  endif;
  $element_ns = new DOMElement('cell', $porc, '');
  $element1->appendChild($element_ns);

  $c++;

  if ($c == 2) $c = 0;
}

$element1  = $element->appendChild(new DOMElement('row'));
$element1->setAttribute("id", 'TOTAL');


$element_ns = new DOMElement('cell', '', '');
$element1->appendChild($element_ns);

$element_ns = new DOMElement('cell', 'TOTAL APUESTA:', '');
$element1->appendChild($element_ns);

$element_ns = new DOMElement('cell', number_format($suma, 2, ',', '.'), '');
$element1->appendChild($element_ns);

$element_ns = new DOMElement('cell', '', '');
$element1->appendChild($element_ns);

$element_ns = new DOMElement('cell', '', '');
$element1->appendChild($element_ns);

$element_ns = new DOMElement('cell', 'TOTAL TICKETS:', '');
$element1->appendChild($element_ns);

$element_ns = new DOMElement('cell', $somos, '');
$element1->appendChild($element_ns);

$element_ns = new DOMElement('cell', '', '');
$element1->appendChild($element_ns);


echo  $doc->saveXML();
