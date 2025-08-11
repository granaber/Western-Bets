<?
require_once('prc_phpDUK.php');
global $server;
global $user;
global $clv;
global $db;
header("Content-type:text/xml");
$link = ConnectionAnimalitos::getInstance();
$cierre = _check_cierre_sorteo($_REQUEST['usu']);
$Loteria = array();
$resultj = mysqli_query($link, 'Select * from _Loterias Where Activa=1');
while ($Row = mysqli_fetch_array($resultj)) $Loteria[$Row['IDL']] = $Row['Nombre'];
$IDJ = _FechaDUK();
$IDL = $_REQUEST['IDL'];
$doc = new DOMDocument('1.0', 'UTF-8'); //encoding="iso-8859-1"?

$element  = $doc->appendChild(new DOMElement('rows'));

if (count($cierre) == 0) :
  $add = '';
else :
  if ($cierre[0] == false) :
    echo  $doc->saveXML();
    exit;
  else :
    $add = '  and not ID  in (' . implode(",", $cierre) . ')';
  endif;
endif;



//$sql="Select * from _Jornada where Activa=1 and IDJ=".$IDJ.$add."  and IDL=$IDL order by ID";
$sql = "Select * from _Jornada where Activa=1 and IDJ=" . $IDJ . $add . "  and IDL=$IDL order by HoraCierre ASC";
//echo $sql;
$resultj = mysqli_query($link, $sql);
while ($Row = mysqli_fetch_array($resultj)) {

  $element1  = $element->appendChild(new DOMElement('row'));
  $element1->setAttribute("id", $Row['ID']);

  $element_ns = new DOMElement('cell', '0', '');
  $element1->appendChild($element_ns);

  //echo 'Select * from _JornadaStandar where ID='.$Row['IDS'];
  //  $resultj2N = mysqli_query($link,'Select * from _JornadaStandar where ID='.$Row['IDJS']);$Row2N = mysqli_fetch_array($resultj2N);
  $element_ns = new DOMElement('cell', 'Sorteo de: ' . convertirNormal($Row['HoraCierre']), '');
  $element1->appendChild($element_ns);

  $element_ns = new DOMElement('cell', $Loteria[$Row['IDL']], '');
  $element1->appendChild($element_ns);
}

echo  $doc->saveXML();
