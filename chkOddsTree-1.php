<?
// ********** Creacion de archivo XML ************
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$file = "arch/chkOdds-1.xml";

$doc = new DOMDocument('1.0', 'UTF-8');

$element  = $doc->appendChild(new DOMElement('toolbar'));

$element2  = $element->appendChild(new DOMElement('item'));
$element2->setAttribute("text", 'Cerrar');
$element2->setAttribute("id", 'Cerrar_');
$element2->setAttribute("type", "button");
$element2->setAttribute("img", "images/close.gif");

$element2  = $element->appendChild(new DOMElement('item'));
$element2->setAttribute("text", 'Deporte');
$element2->setAttribute("id", 'btnDeporte_');
$element2->setAttribute("type", "buttonSelect");


$resultj = mysqli_query($GLOBALS['link'], 'SELECT * FROM _gruposdd where Grupo>1');
while ($Row = mysqli_fetch_array($resultj)) {
	$element1  = $element2->appendChild(new DOMElement('item'));
	$element1->setAttribute("text", htmlentities($Row['Descripcion']));
	$element1->setAttribute("id", $Row['Grupo']);
	$element1->setAttribute("type", "button");
	if (file_exists("media/" . $Row['imagen'])) :
		$element1->setAttribute("img", "media/" . $Row['imagen']);
	endif;
}
$doc->save($file);
