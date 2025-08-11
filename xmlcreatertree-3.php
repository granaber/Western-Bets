<?
// ********** Creacion de archivo XML ************
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$file = "arch/gridRelaCIONDeport.xml";



$doc = new DOMDocument('1.0', 'UTF-8');

$element  = $doc->appendChild(new DOMElement('tree'));
$element->setAttribute("id", "0");

$element2  = $element->appendChild(new DOMElement('item'));
$element2->setAttribute("text", "Deportes");
$element2->setAttribute("id", "Deportes");
$element2->setAttribute("open", "1");


$i = 1;
$resultj = mysqli_query($GLOBALS['link'], 'SELECT * FROM _gruposdd where Grupo<>1  Order By Grupo');
while ($Row = mysqli_fetch_array($resultj)) {
	$element1  = $element2->appendChild(new DOMElement('item'));
	$element1->setAttribute("text", $Row['Descripcion']);
	$element1->setAttribute("id", $Row['Grupo']);
	$element1->setAttribute("im0", $Row['imagen']);
	$element1->setAttribute("im1", $Row['imagen']);
	$element1->setAttribute("im2", $Row['imagen']);

	$i++;
}
$doc->save($file);
