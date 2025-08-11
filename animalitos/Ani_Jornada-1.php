<?
require_once('prc_phpDUK.php');
global $server;
global $user;
global $clv;
global $db;
header("Content-type:text/xml");
$link = ConnectionAnimalitos::getInstance();
$IDJ = _FechaDUK($_REQUEST['Fee']);
$IDL = $_REQUEST['IDL'];
_NowCaptDUL($IDJ, $IDL);

$doc = new DOMDocument('1.0', 'UTF-8'); //encoding="iso-8859-1"?
$element  = $doc->appendChild(new DOMElement('rows'));
$sql = "Select * from _Jornada where  IDJ=" . $IDJ . " and IDL=" . $IDL . "   order by HoraCierre ASC";
//$sql="Select * from _Jornada where  IDJ=".$IDJ." and IDL=".$IDL."   order by ID";
//echo $sql;
$resultj = mysqli_query($link, $sql);
while ($Row = mysqli_fetch_array($resultj)) {

  $element1  = $element->appendChild(new DOMElement('row'));
  $element1->setAttribute("id", $Row['ID']);

  $element_ns = new DOMElement('cell', $Row['ID'], '');
  $element1->appendChild($element_ns);

  //echo 'Select * from _JornadaStandar where ID='.$Row['IDS'];
  $element_ns = new DOMElement('cell', 'Sorteo de: ' . convertirNormal($Row['HoraCierre']), '');
  $element1->appendChild($element_ns);

  $element_ns = new DOMElement('cell', $Row['CantidadNum'], '');
  $element1->appendChild($element_ns);

  $element_ns = new DOMElement('cell', $Row['Activa'], '');
  $element1->appendChild($element_ns);
}

echo  $doc->saveXML();
