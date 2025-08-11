<?
require_once('prc_phpDUK.php');
global $server;
global $user;
global $clv;
global $db;
$IDL = $_REQUEST['IDL'];
header("Content-type:text/xml");
$link = ConnectionAnimalitos::getInstance();
$doc = new DOMDocument('1.0', 'UTF-8'); //encoding="iso-8859-1"?

$element  = $doc->appendChild(new DOMElement('rows'));

$sql = "Select * from _NumeroAnimatios where Activo=1 and IDL=$IDL order by num";
$resultj = mysqli_query($link, $sql);
while ($Row = mysqli_fetch_array($resultj)) {

  $element1  = $element->appendChild(new DOMElement('row'));
  $element1->setAttribute("id", $Row['num']);

  $element_ns = new DOMElement('cell', '0', '');
  $element1->appendChild($element_ns);

  $element_ns = new DOMElement('cell', $Row['num'], '');
  $element1->appendChild($element_ns);

  $elementns = $doc->createElement('cell');
  $elementns->appendChild($doc->createCDATASection('<img style="width: 50px;height: 50px;" src="animalitos/imag/' . $Row['figura'] . '" />'));
  $element1->appendChild($elementns);

  $element_ns = new DOMElement('cell', $Row['nombre'], ''); //str_replace('ñ','&#224;',$Row['nombre'])
  $element1->appendChild($element_ns);
}

echo  $doc->saveXML();
