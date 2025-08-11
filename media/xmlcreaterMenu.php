<?
// ********** Creacion de archivo XML ************
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$file = $_REQUEST['file'];

$campos = explode('|', $_REQUEST['Autorizados']);
/////////////////////
$adm = false; //<----- Animalitos
$resultj = mysqli_query($GLOBALS['link'], 'SELECT * FROM _tusu where 	bloqueado=' . $_REQUEST['rndusr']);
$Row = mysqli_fetch_array($resultj);
$numeCam = array();
if ($Row['AGrupo'] != 0) :
	$adm = true;
	for ($c = 0; $c <= count($campos) - 1; $c++) {
		if ($campos[$c] == 'so07' || $campos[$c] == 'so08' || $campos[$c] == 'so05') :
			continue;
		endif;
		$numeCam[] =  $campos[$c];
	}
	$campos = $numeCam;
endif;
/////////////////////

$doc = new DOMDocument('1.0', 'UTF-8');

$element  = $doc->appendChild(new DOMElement('menu'));

$i = 1;

/// PRINCIPAL \\\
$sql = 'SELECT * FROM _tmenu Where Submodulo="0" order by Submodulo,IDM';

$resultj = mysqli_query($GLOBALS['link'], $sql);
while ($Row = mysqli_fetch_array($resultj)) {
	$key = array_search($Row['variable'], $campos); //
	if (($key === false)) :
		$element1  = $doc->appendChild(new DOMElement('item'));
		$element->appendChild($element1);
		$element1->setAttribute("id",  $Row['variable']);
		$element1->setAttribute("text", $Row['Descripcion']);
	endif;
}
$incicio = 0;
/// DATOS \\\

$sql = 'SELECT * FROM _tmenu Where Submodulo="DATOS" order by Submodulo,IDM';
$resultj = mysqli_query($GLOBALS['link'], $sql);
while ($Row = mysqli_fetch_array($resultj)) {
	$key = array_search($Row['variable'], $campos); //
	if (($key === false)) :
		if ($incicio == 0) :
			$element1  = $doc->appendChild(new DOMElement('item'));
			$element->appendChild($element1);
			$element1->setAttribute("id", 'm1');
			$element1->setAttribute("text", 'Datos');
			$incicio = -1;
		endif;
		$element2  = $doc->appendChild(new DOMElement('item'));
		$element1->appendChild($element2);
		$element2->setAttribute("id", $Row['variable']);
		$element2->setAttribute("text", $Row['Descripcion']);
		$element2->setAttribute("img", $Row['img']);
	endif;
}
$incicio = 0;
/// REPORTES \\\

$sql = 'SELECT * FROM _tmenu Where Submodulo="REPORTES" order by Submodulo,IDM';
$resultj = mysqli_query($GLOBALS['link'], $sql);
while ($Row = mysqli_fetch_array($resultj)) {
	$key = array_search($Row['variable'], $campos); //
	if (($key === false)) :
		if ($incicio == 0) :
			$element1  = $doc->appendChild(new DOMElement('item'));
			$element->appendChild($element1);
			$element1->setAttribute("id", 'm2');
			$element1->setAttribute("text", 'Reportes');
			$incicio = -1;
		endif;
		$element2  = $doc->appendChild(new DOMElement('item'));
		$element1->appendChild($element2);
		$element2->setAttribute("id", $Row['variable']);
		$element2->setAttribute("text", $Row['Descripcion']);
		$element2->setAttribute("img", $Row['img']);
	endif;
}
$incicio = 0;
/// ADMINISTRATIVOS \\\

$sql = 'SELECT * FROM _tmenu Where Submodulo="Administrativos" order by Submodulo,IDM';
$resultj = mysqli_query($GLOBALS['link'], $sql);
while ($Row = mysqli_fetch_array($resultj)) {
	$key = array_search($Row['variable'], $campos); //
	if (($key === false)) :
		if ($incicio == 0) :
			$element1  = $doc->appendChild(new DOMElement('item'));
			$element->appendChild($element1);
			$element1->setAttribute("id", 'm3');
			$element1->setAttribute("text", 'Administrativos');
			$incicio = -1;
		endif;
		$element2  = $doc->appendChild(new DOMElement('item'));
		$element1->appendChild($element2);
		$element2->setAttribute("id", $Row['variable']);
		$element2->setAttribute("text", $Row['Descripcion']);
		$element2->setAttribute("img", $Row['img']);
	endif;
}
$incicio = 0;
//ANIMALITOS
$sql = 'SELECT * FROM _tmenu Where Submodulo="Animalitos" order by Submodulo,IDM';
$resultj = mysqli_query($GLOBALS['link'], $sql);
while ($Row = mysqli_fetch_array($resultj)) {
	$key = array_search($Row['variable'], $campos); //
	if (($key === false)) :
		if ($incicio == 0) :
			$element1  = $doc->appendChild(new DOMElement('item'));
			$element->appendChild($element1);
			$element1->setAttribute("id", 'm5');
			$element1->setAttribute("text", '<p style="color:red">Animalitos</p>');
			$incicio = -1;
		endif;
		$element2  = $doc->appendChild(new DOMElement('item'));
		$element1->appendChild($element2);
		$element2->setAttribute("id", $Row['variable']);
		$element2->setAttribute("text", $Row['Descripcion']);
		$element2->setAttribute("img", $Row['img']);
	endif;
}
if (!$adm) :
	$element1  = $doc->appendChild(new DOMElement('item'));
	$element->appendChild($element1);
	$element1->setAttribute("id", 'Animalitos');
	$element1->setAttribute("text", '<p style="color:red">Venta Animalitos</p>');
endif;

$element1  = $doc->appendChild(new DOMElement('item'));
$element->appendChild($element1);
$element1->setAttribute("id", 'm4');
$element1->setAttribute("text", 'Salir del Sistema');
$doc->save($file);
