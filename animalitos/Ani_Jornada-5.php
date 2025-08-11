<?
require_once('prc_phpDUK.php');
global $server;
global $user;
global $clv;
global $db;
header("Content-type:text/xml");
$link = ConnectionAnimalitos::getInstance();
//$IDJ=_FechaDUK($_REQUEST['Fee']);

$doc = new DOMDocument('1.0', 'UTF-8'); //encoding="iso-8859-1"?
$element  = $doc->appendChild(new DOMElement('rows'));

$sql = "Select * from _Conf_premio where  ID=" . $_REQUEST['ID'] . "   order by l";
//echo $sql;
$resultj = mysqli_query($link, $sql);
while ($Row = mysqli_fetch_array($resultj)) {

  $element1  = $element->appendChild(new DOMElement('row'));
  $element1->setAttribute("id", $Row['l']);

  if ($Row['numero'] == -1) :
    $lTexto = 'Todos';
  else :
    $NomAnimalito = _verAnimalito($Row['numero']);
    $lTexto = $NomAnimalito[0] . '(' . $Row['numero'] . ')';
  endif;
  $element_ns = new DOMElement('cell', $lTexto, '');
  $element1->appendChild($element_ns);

  $element_ns = new DOMElement('cell', $Row['logro'], '');
  $element1->appendChild($element_ns);

  switch ($Row['modo']) {
    case '0':
      $lTexto = 'Terminal';
      break;
    case '1':
      $lTexto = 'Combinada 2';
      break;
    case '2':
      $lTexto = 'Combinada 3';
      break;
  }

  $element_ns = new DOMElement('cell', $lTexto, '');
  $element1->appendChild($element_ns);
}

echo  $doc->saveXML();
