<?
session_start();
$agrupo = $_SESSION['Agrupo'];

// ********** Creacion de archivo XML ************
require('prc_php.php');
$link = ConnectionAnimalitos::getInstance();

if (isset($_SESSION['count'])) :
	if ($_SESSION['count'] != '') :
		$resultj = mysqli_query($link, 'SELECT * FROM _tusu where 	IDusu=' . $_SESSION['count']);
		$Row = mysqli_fetch_array($resultj);
		$file = 'xmln/' . $_SESSION['flx'];
		$campos = explode('|', $Row['Acceso']);
	else :
		exit;
	endif;
else :
	exit;
endif;

$doc = new DOMDocument('1.0', 'UTF-8');

$element  = $doc->appendChild(new DOMElement('menu'));

$i = 1;
/// JUEGOS \\\
$element1  = $doc->appendChild(new DOMElement('item'));
$element->appendChild($element1);
$element1->setAttribute("id", 'm1');

$hay = false;
$MENUprin = 'op10';
$key = array_search($MENUprin, $campos); //
if (($key === false)) :
	if ($agrupo == 0) :
		$element2  = $doc->appendChild(new DOMElement('item'));
		$element1->appendChild($element2);
		$element2->setAttribute("id", 'm1-0');
		$element2->setAttribute("text", 'Ganadores/Place/Show');
		$element2->setAttribute("img", 'dhtmlxgrid_icon.gif');
		$hay = true;
	endif;
endif;
if ($agrupo == 0) :
	$sql = 'SELECT * FROM _tdjuegoshi order by 1';
	$resultj = mysqli_query($link, $sql);
	while ($Row = mysqli_fetch_array($resultj)) {
		$MENUprin = 'op1' . $Row['IDJug'];
		$key = array_search($MENUprin, $campos); //
		if (($key === false)) :
			$element2  = $doc->appendChild(new DOMElement('item'));
			$element1->appendChild($element2);
			$element2->setAttribute("id", 'm1-' . $Row['IDJug']);
			$element2->setAttribute("text", $Row['Descrip']);
			$element2->setAttribute("img", 'dhtmlxgrid_icon.gif');
			$hay = true;
		endif;
	}
endif;
if ($hay) :
	$element1->setAttribute("text", 'Jugadas');
else :
	//$element1->setAttribute("text", '' );
	$element1->setAttribute("style", 'display:none');
endif;
/// DATOS \\\
$element1  = $doc->appendChild(new DOMElement('item'));
$element->appendChild($element1);
$element1->setAttribute("id", 'm2');
$element1->setAttribute("text", 'Datos');
$sql = 'SELECT * FROM _tmenu Where Submodulo="DATOS" order by Submodulo,IDM';
$resultj = mysqli_query($link, $sql);
while ($Row = mysqli_fetch_array($resultj)) {
	$key = array_search($Row['variable'], $campos); //
	if (($key === false)) :
		$element2  = $doc->appendChild(new DOMElement('item'));
		$element1->appendChild($element2);
		$element2->setAttribute("id", $Row['variable']);
		$element2->setAttribute("text", $Row['Descripcion']);
		$element2->setAttribute("img", $Row['img']);
	endif;
}
/// REPORTES \\\
$element1  = $doc->appendChild(new DOMElement('item'));
$element->appendChild($element1);
$element1->setAttribute("id", 'm3');
$element1->setAttribute("text", 'Reportes');
$sql = 'SELECT * FROM _tmenu Where Submodulo="REPORTES" order by Submodulo,IDM';
$resultj = mysqli_query($link, $sql);
while ($Row = mysqli_fetch_array($resultj)) {
	$key = array_search($Row['variable'], $campos); //
	if (($key === false)) :
		$element2  = $doc->appendChild(new DOMElement('item'));
		$element1->appendChild($element2);
		$element2->setAttribute("id", $Row['variable']);
		$element2->setAttribute("text", $Row['Descripcion']);
		$element2->setAttribute("img", $Row['img']);
	endif;
}


$element1  = $doc->appendChild(new DOMElement('item'));
$element->appendChild($element1);
$element1->setAttribute("id", 'm4');
$element1->setAttribute("text", 'PastPerformat/Winners/Resultados');

$element1  = $doc->appendChild(new DOMElement('item'));
$element->appendChild($element1);
$element1->setAttribute("id", 'm6');
$element1->setAttribute("text", 'Tv En Vivo');


$incicio = 0;
//ANIMALITOS
$sql = 'SELECT * FROM _tmenu Where Submodulo="Animalitos" order by Submodulo,IDM';
$resultj = mysqli_query($link, $sql);
while ($Row = mysqli_fetch_array($resultj)) {
	$key = array_search($Row['variable'], $campos); //
	if (($key === false)) :
		if ($incicio == 0) :
			$element1  = $doc->appendChild(new DOMElement('item'));
			$element->appendChild($element1);
			$element1->setAttribute("id", 'm7');
			$element1->setAttribute("text", '<p style="color:yellow">Animalitos</p>');
			$incicio = -1;
		endif;
		$element2  = $doc->appendChild(new DOMElement('item'));
		$element1->appendChild($element2);
		$element2->setAttribute("id", $Row['variable']);
		$element2->setAttribute("text", $Row['Descripcion']);
		$element2->setAttribute("img", $Row['img']);
	endif;
}

$element1  = $doc->appendChild(new DOMElement('item'));
$element->appendChild($element1);
$element1->setAttribute("id", 'Animalitos');
$element1->setAttribute("text", '<p style="color:yellow">Venta Animalitos</p>');


$element1  = $doc->appendChild(new DOMElement('item'));
$element->appendChild($element1);
$element1->setAttribute("id", 'm5');
$element1->setAttribute("text", 'Salir del Sistema');
$doc->save($file);
