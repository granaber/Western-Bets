<?
require_once('prc_phpDUK.php');
global $server;
global $user;
global $clv;
global $db;
header("Content-type:text/xml");
$link = ConnectionAnimalitos::getInstance();
$doc = new DOMDocument('1.0', 'UTF-8'); //encoding="iso-8859-1"?

$element  = $doc->appendChild(new DOMElement('rows'));
$IDL = $_REQUEST['IDL'];
$sql = "Select * from _NumeroAnimatios where IDL=$IDL ";
$resultj = mysqli_query($link, $sql);
while ($Row = mysqli_fetch_array($resultj)) {

  $element1  = $element->appendChild(new DOMElement('row'));
  $element1->setAttribute("id", $Row['num']);

  $element_ns = new DOMElement('cell', $Row['num'], '');
  $element1->appendChild($element_ns);

  $element_ns = new DOMElement('cell', $Row['nombre'], '');
  $element1->appendChild($element_ns);

  $elementns = $doc->createElement('cell');
  $elementns->appendChild($doc->createCDATASection('<img style="width: 50px;height: 50px;" src="animalitos/imag/' . $Row['figura'] . '" />'));
  $element1->appendChild($elementns);

  $element_ns = new DOMElement('cell', $Row['activo'], ''); //str_replace('ñ','&#224;',$Row['nombre'])
  $element1->appendChild($element_ns);
}

echo  $doc->saveXML();
