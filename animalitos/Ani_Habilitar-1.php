<?
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', 'error.log');
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// ********** Creacion de archivo XML ************
require('prc_phpDUK.php');
global $serverD;
global $userD;
global $clvD;
global $dbD;

global $serverA;
global $userA;
global $clvA;
global $dbA;

header("Content-type:text/xml");
if ($_REQUEST['op'] == 1) {
	$link = mysqli_connect($serverD, $userD, $clvD, $dbD);
} else {
	$link = mysqli_connect($serverA, $userA, $clvA, $dbA);
}

$accesoBanca = $_REQUEST['accesoBanca'];

$add2 = $accesoBanca == 0 ? '' :  " where IDB = $accesoBanca";

$doc = new DOMDocument('1.0', 'UTF-8');

$element  = $doc->appendChild(new DOMElement('tree'));
$element->setAttribute("id", "0");

$element2  = $element->appendChild(new DOMElement('item'));
$element2->setAttribute("text", "Banca");
$element2->setAttribute("id", "Banca");
$element2->setAttribute("open", "1");


$i = 1;
if ($_REQUEST['op'] == 2) $add = ' IDC!="-2" and ';
else $add = '';
$resultj = mysqli_query($link, "SELECT * FROM _tgrupo  $add2   Order By IDG");
while ($Row = mysqli_fetch_array($resultj)) {
	$element1  = $element2->appendChild(new DOMElement('item'));
	$element1->setAttribute("text", $Row['Descrip']);
	$element1->setAttribute("id", '1$' . $Row['IDG']);
	$element1->setAttribute("im0", "noun_737661_cc.png");
	$element1->setAttribute("im1", "noun_737661_cc.png");
	$element1->setAttribute("im2", "noun_737661_cc.png");
	/// Primer Nivel
	$resultj1 = mysqli_query($link, 'SELECT * FROM _tconsecionario  where ' . $add . ' IDG=' . $Row['IDG']);
	while ($Row1 = mysqli_fetch_array($resultj1)) {
		$imag = "noun_737678_cc.png";
		$element3  = $element1->appendChild(new DOMElement('item'));
		$element3->setAttribute("text", $Row1['IDC'] . '-' . $Row1['Nombre']);
		$element3->setAttribute("id", $Row1['IDC'] . '$' . $Row1['IDG']);
		$element3->setAttribute("im0", $imag);
		$element3->setAttribute("im1", $imag);
		$element3->setAttribute("im2", $imag);
	}

	$i++;
}
echo  $doc->saveXML();
