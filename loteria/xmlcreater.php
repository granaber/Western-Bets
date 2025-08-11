<?
// ********** Creacion de archivo XML ************
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$file = $_REQUEST['file'];
$sql = $_REQUEST['sql'];
$campos = explode('|', $_REQUEST['campos']);

$doc = new DOMDocument('1.0', 'UTF-8');

$element  = $doc->appendChild(new DOMElement('rows'));

$i = 1;
$resultj = mysqli_query($GLOBALS['link'], $sql);
while ($Row = mysqli_fetch_array($resultj)) {
	$element1  = $element->appendChild(new DOMElement('row'));
	$element1->setAttribute("id", $Row[$campos[0]]);
	for ($j = 0; $j <= count($campos) - 1; $j++) {
		$DATA = explode('!',	$campos[$j]);

		if (count($DATA) == 2) :
			if ($DATA[0] == 'DATA') :
				$elementns = $doc->createElement('cell');
				$elementns->appendChild($doc->createCDATASection('<img src="images/logo/' . $Row[$DATA[1]] . '" width="59" height="29" />'));
				$element1->appendChild($elementns);
			endif;
			if ($DATA[0] == 'SEL') :
				$element_ns = new DOMElement('cell', $DATA[1], '');
				$element1->appendChild($element_ns);
			endif;

		else :
			$element_ns = new DOMElement('cell', $Row[$campos[$j]], '');
			$element1->appendChild($element_ns);
		endif;
	}
	$i++;
}
$doc->save($file);
