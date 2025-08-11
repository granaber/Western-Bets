<?
// ********** Creacion de archivo XML ************
require_once('prc_skynet.php');
$GLOBALS['link'] = Skynet::getInstance();

$IDJsk = date("Ymd");

//header( "content-type: application/xml; charset=ISO-8859-15" );

$xml = new DOMDocument();

$rows = $xml->createElement("rows");
$i = 1;

/// PRINCIPAL \\\
$sql = "SELECT _tbligasNT . * , _tbjornadaNT.fecha FROM _tbligasNT, _tbjornadaNT WHERE _tbjornadaNT.idj = _tbligasNT.idj AND _tbjornadaNT.fecha >=" . $IDJsk . " ORDER BY _tbjornadaNT.fecha, _tbligasNT.idep";
//echo $sql;
$fecha = 0;
$resultj = mysqli_query($GLOBALS['link'], $sql);
$d = 1;
while ($Row = mysqli_fetch_array($resultj)) {
	if ($fecha != $Row['fecha']) :



		$fecha = $Row['fecha'];
		//echo $fecha.'<br>';

		$row = $xml->createElement("row");
		$row->setAttribute("id",  $d);
		$d++;
		$row->setAttribute("style", 'background-color:#069; color:#FFF');

		$cell =  $xml->createElement("cell", ' '); //$cell->setAttribute("colspan",'2');
		$cell1 = $xml->createElement("cell", "Fecha:" . substr($fecha, 6, 2) . '-' . substr($fecha, 4, 2) . '-' . substr($fecha, 0, 4));
		$cell2 = $xml->createElement("cell", ' ');


		$row->appendChild($cell);
		$row->appendChild($cell1);
		$row->appendChild($cell2);
		$rows->appendChild($row);
	endif;

	$row = $xml->createElement("row");
	$row->setAttribute("id",  $Row['idep'] . '-' . $Row['idj']);
	$cell =  $xml->createElement("cell", "0");
	$cell1 = $xml->createElement("cell", $Row['nombre']);
	$cell2 = $xml->createElement("cell", $Row['idep'] . '-' . $Row['idj']);
	$row->appendChild($cell);
	$row->appendChild($cell1);
	$row->appendChild($cell2);
	$rows->appendChild($row);
}
$xml->appendChild($rows);
$out = $xml->save('doc.xml');
	//print $xml->saveXML();
