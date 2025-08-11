<?
// ********** Creacion de archivo XML ************
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$file = "arch/gridRelaCIONAudi.xml";



$doc = new DOMDocument('1.0', 'UTF-8');

$element  = $doc->appendChild(new DOMElement('tree'));
$element->setAttribute("id", "0");

$element2  = $element->appendChild(new DOMElement('item'));
$element2->setAttribute("text", "Logs");
$element2->setAttribute("id", "Logs");
$element2->setAttribute("open", "1");

$logs = array(0, -1, -2, -3, -4);
$logsTxt = array('Acceso', 'Usuario', 'Concesionario', 'Logros', 'Escrutes');
$imag = "user.png";
for ($i = 0; $i <= count($logs) - 1; $i++) {
	$element1  = $element2->appendChild(new DOMElement('item'));
	$element1->setAttribute("text", $logsTxt[$i]);
	$element1->setAttribute("id", 'k-' . $i);
	$element1->setAttribute("im0", "ver.png");
	$element1->setAttribute("im1", "ver.png");
	$element1->setAttribute("im2", "ver.png");

	$resultj1 = mysqli_query($GLOBALS['link'], 'SELECT * FROM _auditoria_accesos  where IDM=' . $logs[$i] . ' Group by IDusu');
	while ($Row1 = mysqli_fetch_array($resultj1)) {
		if ($Row1['IDusu'] != 0) :
			$resultj2 = mysqli_query($GLOBALS['link'], 'SELECT * FROM _tusu  where IDusu=' . $Row1['IDusu']);
			$Row2 = mysqli_fetch_array($resultj2);
			$element3  = $element1->appendChild(new DOMElement('item'));
			$element3->setAttribute("text", $Row2['Usuario']);
			$element3->setAttribute("id", $i . '-' . $Row2['IDusu']);
			$element3->setAttribute("im0", $imag);
			$element3->setAttribute("im1", $imag);
			$element3->setAttribute("im2", $imag);
		endif;
	}
}
$doc->save($file);
