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

$resultj = mysqli_query($link, "Select * from _NumeroAnimatios ");
while ($Row = mysqli_fetch_array($resultj)) {
  $resultj2n = mysqli_query($link, "Select * from _Grupo_Tope_N Where IDS=" . $_REQUEST['id'] . " and numero='" . $Row['num'] . "' and IDG=" . $_REQUEST['IDG']);
  if (mysqli_num_rows($resultj2n) == 0)
    $resultj2n = mysqli_query($link, "Insert _Grupo_Tope_N Value (" . $_REQUEST['id'] . ",0,0,'" . $Row['num'] . "'," . $_REQUEST['IDG'] . ")");
}

$sql = "Select * from _Grupo_Tope_N Where IDS=" . $_REQUEST['id'] . " and IDG=" . $_REQUEST['IDG'] . " order by numero";
//echo $sql;
$resultj = mysqli_query($link, $sql);
while ($Row = mysqli_fetch_array($resultj)) {

  $element1  = $element->appendChild(new DOMElement('row'));
  $element1->setAttribute("id", $Row['numero']);

  $element_ns = new DOMElement('cell', $Row['numero'], '');
  $element1->appendChild($element_ns);

  $NomAnimalito = _verAnimalito($Row['numero']);
  $lTexto = $NomAnimalito[0];

  $element_ns = new DOMElement('cell', $lTexto, '');
  $element1->appendChild($element_ns);


  $element_ns = new DOMElement('cell', $Row['Tope'], '');
  $element1->appendChild($element_ns);
}

echo  $doc->saveXML();
