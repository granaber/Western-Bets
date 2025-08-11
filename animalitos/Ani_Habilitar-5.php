<?
require_once('prc_phpDUK.php');
global $server;
global $user;
global $clv;
global $db;
header("Content-type:text/xml");
$link = ConnectionAnimalitos::getInstance();


$doc = new DOMDocument('1.0', 'UTF-8'); //encoding="iso-8859-1"?

$element  = $doc->appendChild(new DOMElement('rows'));

$resultj = mysqli_query($link, "Select * from _JornadaStandar ");
while ($Row = mysqli_fetch_array($resultj)) {
  $resultj2n = mysqli_query($link, "Select * from _Grupo_Tope_S Where IDG=" . $_REQUEST['IDG'] . " and IDS=" . $Row['id']);
  if (mysqli_num_rows($resultj2n) == 0)
    $resultj2n = mysqli_query($link, "Insert _Grupo_Tope_S Value (" . $Row['id'] . ",0,0," . $_REQUEST['IDG'] . ")");
}




$sql = "Select * from _Grupo_Tope_S  where IDG=" . $_REQUEST['IDG'] . " order by IDS";
//echo $sql;
$resultj = mysqli_query($link, $sql);
while ($Row = mysqli_fetch_array($resultj)) {

  $element1  = $element->appendChild(new DOMElement('row'));
  $element1->setAttribute("id", $Row['IDS']);

  $element_ns = new DOMElement('cell', $Row['IDS'], '');
  $element1->appendChild($element_ns);

  $resultj2n = mysqli_query($link, "Select * from _JornadaStandar where ID=" . $Row['IDS']);
  $Row2N = mysqli_fetch_array($resultj2n);
  $element_ns = new DOMElement('cell', 'Hora del Sorteo:' . $Row2N['Descripcion'], '');
  $element1->appendChild($element_ns);


  $element_ns = new DOMElement('cell', $Row['Tope'], '');
  $element1->appendChild($element_ns);
}

echo  $doc->saveXML();
