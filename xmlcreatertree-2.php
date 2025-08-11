<?
// ********** Creacion de archivo XML ************
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$file = "arch/gridRelaCION.xml";



$doc = new DOMDocument('1.0', 'UTF-8');

$element  = $doc->appendChild(new DOMElement('tree'));
$element->setAttribute("id", "0");

$element2  = $element->appendChild(new DOMElement('item'));
$element2->setAttribute("text", "Banca");
$element2->setAttribute("id", "Banca");
$element2->setAttribute("open", "1");


$i = 1;
$resultj = mysqli_query($GLOBALS['link'], 'SELECT * FROM _tgrupo Order By IDG');
while ($Row = mysqli_fetch_array($resultj)) {
	$element1  = $element2->appendChild(new DOMElement('item'));
	$element1->setAttribute("text", $Row['Descrip']);
	$element1->setAttribute("id", '1-' . $Row['IDG']);
	$element1->setAttribute("im0", "banca.ico");
	$element1->setAttribute("im1", "banca.ico");
	$element1->setAttribute("im2", "banca.ico");
	/// Primer Nivel
	$resultj1 = mysqli_query($GLOBALS['link'], 'SELECT * FROM _tconsecionario  where IDG=' . $Row['IDG']);
	while ($Row1 = mysqli_fetch_array($resultj1)) {
		$imag = "zona.gif";
		$element3  = $element1->appendChild(new DOMElement('item'));
		$element3->setAttribute("text", $Row1['IDC'] . '-' . $Row1['Nombre']);
		$element3->setAttribute("id", $Row1['IDC'] . '-' . $Row1['IDG']);
		$element3->setAttribute("im0", $imag);
		$element3->setAttribute("im1", $imag);
		$element3->setAttribute("im2", $imag);
	}

	$i++;
}
$doc->save($file);
