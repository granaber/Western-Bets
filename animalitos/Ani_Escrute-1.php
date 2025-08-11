<?
require_once('prc_phpDUK.php');
global $server;
global $user;
global $clv;
global $db;
header("Content-type:text/xml");
$link = ConnectionAnimalitos::getInstance();
$IDJ = _FechaDUK($_REQUEST['Fee'], 0);
$IDL = $_REQUEST['IDL'];
if ($_REQUEST['Fee'] == FecharealAnimalitos(0, 'd/n/Y')) :
  _NowCaptEscrutesDUL($IDJ, $IDL);
endif;
$doc = new DOMDocument('1.0', 'UTF-8'); //encoding="iso-8859-1"?
$element  = $doc->appendChild(new DOMElement('rows'));

$sql = "Select * from _Escritu_Ani where  IDJ=" . $IDJ . "   and ID in (Select ID from _Jornada where IDL=$IDL and IDJ=" . $IDJ . ")  order by ID";
//echo $sql;
$sql = "SELECT _Escritu_Ani . * FROM _Escritu_Ani, _Jornada WHERE _Escritu_Ani.IDJ =$IDJ AND _Escritu_Ani.ID = _Jornada.ID AND _Jornada.IDL =$IDL ORDER BY _Jornada.HoraCierre";
$resultj = mysqli_query($link, $sql);
while ($Row = mysqli_fetch_array($resultj)) {

  $element1  = $element->appendChild(new DOMElement('row'));
  $element1->setAttribute("id", $Row['ID']);

  $element_ns = new DOMElement('cell', $Row['ID'], '');
  $element1->appendChild($element_ns);

  $element_ns = new DOMElement('cell', $Row['Publicar'], '');
  $element1->appendChild($element_ns);

  $resultj2n = mysqli_query($link, "Select * From _Jornada Where ID=" . $Row['ID']);
  $Row2n = mysqli_fetch_array($resultj2n);
  $element_ns = new DOMElement('cell', 'Sorteo de: ' . convertirNormal($Row2n['HoraCierre']), '');
  $element1->appendChild($element_ns);
  if ($Row['G1'] != -1) :
    $NomAnimalito = _verAnimalito($Row['G1'], $IDL);
    $Numero = $Row['G1'];
    $txto = $NomAnimalito[0] . '(' . $Numero . ')';
  else :
    $NomAnimalito = array('');
    $Numero = '';
    $txto = '';
  endif;
  $element_ns = new DOMElement('cell', $txto, '');
  $element1->appendChild($element_ns);
  $NomAnimalito = '';
  if ($Row['G2'] != -1) :
    $NomAnimalito = _verAnimalito($Row['G2'], $IDL);
    $Numero = $Row['G2'];
    $txto = $NomAnimalito[0] . '(' . $Numero . ')';
  else :
    $NomAnimalito = array('');
    $Numero = '';
    $txto = '';
  endif;
  $element_ns = new DOMElement('cell', $txto, '');
  $element1->appendChild($element_ns);
  $NomAnimalito = '';
  if ($Row['G3'] != -1) :
    $NomAnimalito = _verAnimalito($Row['G3'], $IDL);
    $Numero = $Row['G3'];
    $txto = $NomAnimalito[0] . '(' . $Numero . ')';
  else :
    $NomAnimalito = array('');
    $Numero = '';
    $txto = '';
  endif;
  $element_ns = new DOMElement('cell', $txto, '');
  $element1->appendChild($element_ns);
  $element_ns = new DOMElement('cell', $Row2n['HoraCierre'], '');
  $element1->appendChild($element_ns);
}

echo  $doc->saveXML();
