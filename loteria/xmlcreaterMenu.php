<?
// ********** Creacion de archivo XML ************
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$file = $_REQUEST['file'];

$campos = $_REQUEST['Autorizados'] . '=1';


$doc = new DOMDocument('1.0', 'UTF-8');

$element  = $doc->appendChild(new DOMElement('menu'));

$i = 1;

/// PRINCIPAL \\\
$sql = 'SELECT * FROM _tmenu Where Submodulo="0" and ' . $campos . ' order by Submodulo,IDM';

$resultj = mysqli_query($GLOBALS['link'], $sql);
while ($Row = mysqli_fetch_array($resultj)) {
	//$key = array_search($Row['variable'] ,$campos); // 		
	//if  (($key === false)):	
	$element1  = $doc->appendChild(new DOMElement('item'));
	$element->appendChild($element1);
	$element1->setAttribute("id",  $Row['variable']);
	$element1->setAttribute("text", $Row['Descripcion']);
	//endif;	
}
$incicio = '1';
$id = 1;

/// DATOS \\\
$sql = 'SELECT * FROM _tmenu Where Submodulo="1" and ' . $campos . ' order by MODULO,Submodulo,IDM';

$resultj = mysqli_query($GLOBALS['link'], $sql);
while ($Row = mysqli_fetch_array($resultj)) {
	//$key = array_search($Row['variable'] ,$campos); // 		
	//if  (($key === false)):	

	if ($incicio <> $Row['MODULO']) :
		$element1  = $doc->appendChild(new DOMElement('item'));
		$element->appendChild($element1);
		$element1->setAttribute("id", 'm' . $id);
		$element1->setAttribute("text", $Row['MODULO']);
		$incicio = $Row['MODULO'];
		$id++;
		$linea = 0;
	endif;
	$element2  = $doc->appendChild(new DOMElement('item'));
	$element1->appendChild($element2);
	$element2->setAttribute("id", $Row['variable']);
	$element2->setAttribute("text", $Row['Descripcion']);
	$element2->setAttribute("img", $Row['img']);
	if ($linea == 5) :
		$element2  = $doc->appendChild(new DOMElement('item'));
		$element1->appendChild($element2);
		$element2->setAttribute("id", 'ms' . $id);
		$element2->setAttribute("type", "separator");
		$linea = 0;
	endif;
	$linea++;
	//	endif;
}


$element1  = $doc->appendChild(new DOMElement('item'));
$element->appendChild($element1);
$element1->setAttribute("id", 'm4');
$element1->setAttribute("text", 'Salir del Sistema');
$doc->save($file);
