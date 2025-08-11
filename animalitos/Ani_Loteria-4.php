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

$sql = "Select * from _JornadaStandar where IDL=$IDL order by id";
//echo $sql;
$resultj = mysqli_query($link, $sql);
$n = 1;
while ($Row = mysqli_fetch_array($resultj)) {

  $element1  = $element->appendChild(new DOMElement('row'));
  $element1->setAttribute("id", $Row['ID']);
  $element_ns = new DOMElement('cell', $n, '');
  $element1->appendChild($element_ns);
  $element_ns = new DOMElement('cell', $Row['Hora'], '');
  $element1->appendChild($element_ns);
  $element_ns = new DOMElement('cell', $Row['Descripcion'], '');
  $element1->appendChild($element_ns);
  $element_ns = new DOMElement('cell', $Row['Activo'], '');
  $element1->appendChild($element_ns);
  $n++;
}

echo  $doc->saveXML();
