<?
// ********** Creacion de archivo XML ************
require('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();

header("Content-type:text/xml");

$doc = new DOMDocument('1.0', 'UTF-8');

$element  = $doc->appendChild(new DOMElement('tree'));
$element->setAttribute("id", "0");

$element2  = $element->appendChild(new DOMElement('item'));
$element2->setAttribute("text", "Loteria");
$element2->setAttribute("id", "Loteria");
$element2->setAttribute("open", "1");


$i = 1;
$resultj = mysqli_query($link, 'SELECT * FROM _Loterias Order By IDL');
while ($Row = mysqli_fetch_array($resultj)) {
	$element1  = $element2->appendChild(new DOMElement('item'));
	$element1->setAttribute("text", $Row['Nombre']);
	$element1->setAttribute("id", '1$' . $Row['IDL']);
	$element1->setAttribute("im0", "noun_28078_cc.png");
	$element1->setAttribute("im1", "noun_28078_cc.png");
	$element1->setAttribute("im2", "noun_28078_cc.png");
}
echo  $doc->saveXML();
