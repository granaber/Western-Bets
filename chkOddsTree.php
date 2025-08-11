<?
// ********** Creacion de archivo XML ************
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$Grupo = $_REQUEST['Grupo'];
$file = "arch/chkOdds.xml";
$resultj = mysqli_query($GLOBALS['link'], 'SELECT * FROM _gruposdd  where Grupo=' . $Grupo);
$row = mysqli_fetch_array($resultj);
$Descripcion = $row['Descripcion'];
$logo = $row['imagen'];


$doc = new DOMDocument('1.0', 'UTF-8');

$element  = $doc->appendChild(new DOMElement('tree'));
$element->setAttribute("id", "0");

$element2  = $element->appendChild(new DOMElement('item'));
$element2->setAttribute("text", $Descripcion);
$element2->setAttribute("id", $Grupo);
$element2->setAttribute("open", "1");


$i = 1;
$resultj = mysqli_query($GLOBALS['link'], 'SELECT * FROM _tbjuegodd  where Grupo=' . $Grupo);
while ($Row = mysqli_fetch_array($resultj)) {
	$resultj2 = mysqli_query($GLOBALS['link'], 'SELECT * FROM _formatosbb  where 	Formato=' . $Row['Formato']);
	$row2 = mysqli_fetch_array($resultj2);
	$element1  = $element2->appendChild(new DOMElement('item'));
	$element1->setAttribute("text", htmlentities($Row['Descripcion'] . '-' . $row2['Descripcion']));
	$element1->setAttribute("id", $Row['IDDD']);
	$element1->setAttribute("im0", $logo);
	$element1->setAttribute("im1", $logo);
	$element1->setAttribute("im2", $logo);
	$i++;
}
$doc->save($file);
