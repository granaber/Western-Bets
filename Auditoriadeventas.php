<?
date_default_timezone_set('America/Caracas');
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$grupo = $_REQUEST['grupo'];
$idj = $_REQUEST['IDJ'];


$existe = false;

$result_lo = mysqli_query($GLOBALS['link'], "SELECT _partidosbb.* FROM _partidosbb,_equiposbb  where _partidosbb.IDE1=_equiposbb.IDE and  _partidosbb.IDJ=$idj and _partidosbb.grupo=$grupo and  ( _equiposbb.Grupo=$grupo or _equiposbb.Grupo1=$grupo or _equiposbb.Grupo2=$grupo) order by _partidosbb.IDP");

$t = 0;

while ($row3 = mysqli_fetch_array($result_lo)) {


	$eq1 = $row3["IDE1"];
	$eq2 = $row3["IDE2"];
	$result2 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $eq1);
	$row2 = mysqli_fetch_array($result2);
	$estadistica[$eq1][0] = str_replace('�', 'n', $row2["Descripcion"]) . '(a)';
	$estadistica[$eq1][1] = $eq1;
	$estadistica[$eq1][2] = 0;
	$result3 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $eq2);
	$row = mysqli_fetch_array($result3);
	$t++;
	$estadistica[$eq2][0] = str_replace('�', 'n', $row["Descripcion"]) . '(b)';
	$estadistica[$eq2][1] = $eq2;
	$estadistica[$eq2][2] = 0;
}

$estadistica1 = $estadistica;
$estadistica2 = $estadistica;
$Parlay = $estadistica;
$Derecho = $estadistica;
//$result = mysqli_query($GLOBALS['link'],"SELECT * FROM _configuracionjugadabb,_tbjuegodd where _configuracionjugadabb.IDDD=_tbjuegodd.IDDD  and  _configuracionjugadabb.IDJ=".$idj." and _configuracionjugadabb.grupo=$grupo  and _tbjuegodd.grupo=$grupo  and _configuracionjugadabb.IDB=$IDB Order by _configuracionjugadabb.IDP,_tbjuegodd.Formato,_configuracionjugadabb.IDDD");


$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd  where _tbjuegodd.grupo=$grupo Order by IDDD");
while ($row3 = mysqli_fetch_array($result)) {
	$columnas[] = $row3['IDDD'];
}
$columnas[] = -1;
$doc = new DOMDocument('1.0', 'UTF-8');
$element  = $doc->appendChild(new DOMElement('rows'));
$i = 1;
$sumaTotal = 0;
while (list($key, $val) = each($estadistica)) {
	$element1  = $element->appendChild(new DOMElement('row'));
	$element1->setAttribute("id", $val[1]);
	$element_ns = new DOMElement('cell', $i, '');
	$i++;
	$element1->appendChild($element_ns);
	$element_ns = new DOMElement('cell', $val[0], '');
	$element1->appendChild($element_ns);
	$element_ns = new DOMElement('cell', $val[2], '');
	$sumaTotal = 0;
	$j = 0;
	while ($j <= count($columnas)) {
		if (array_key_exists($columnas[$j], $val)) :
			$element1->appendChild($element_ns);
			$element_ns = new DOMElement('cell', $val[$columnas[$j]], '');
			$sumaTotal += $val[$columnas[$j]];
		else :
			if ($columnas[$j] == -1) :
				$element1->appendChild($element_ns);
				$element_ns = new DOMElement('cell', $sumaTotal, '');
			else :
				$element1->appendChild($element_ns);
				$element_ns = new DOMElement('cell', '0', '');
			endif;
		endif;
		$j++;
	}
}
$doc->save('VentasAuditoria.xml');

echo json_encode(true);

function searcharry($haystack, $needle)
{
	$search = false;
	for ($t = 0; count($haystack) - 1; $t++) {
		if ($haystack[$t][1] == $needle) :
			$search = $t;
			break;
		endif;
	}
	return  $search;
}
function redondear($valor)
{
	$float_redondeado = round($valor * 100) / 100;
	return $float_redondeado;
}
