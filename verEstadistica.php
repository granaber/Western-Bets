<?
date_default_timezone_set('America/Caracas');
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$grupo = $_REQUEST['grupo'];
$idj = $_REQUEST['IDJ'];

$resultlo = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbestadisticas where Grupo=$grupo and IDJ=$idj");

if (mysqli_num_rows($resultlo) == 0) :
	$existe = false;

	$result_lo = mysqli_query($GLOBALS['link'], "SELECT _partidosbb.* FROM _partidosbb,_equiposbb  where _partidosbb.IDE1=_equiposbb.IDE and  _partidosbb.IDJ=$idj and _partidosbb.grupo=$grupo and  ( _equiposbb.Grupo=$grupo or _equiposbb.Grupo1=$grupo or _equiposbb.Grupo2=$grupo) order by _partidosbb.IDP");

	$t = 0;

	while ($row3 = mysqli_fetch_array($result_lo)) {


		$eq1 = $row3["IDE1"];
		$eq2 = $row3["IDE2"];
		$result2 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $eq1);
		$row2 = mysqli_fetch_array($result2);
		$estadistica[$eq1][0] = $row2["Descripcion"] . '(a)';
		$estadistica[$eq1][1] = $eq1;
		$estadistica[$eq1][2] = 0;
		$result3 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $eq2);
		$row = mysqli_fetch_array($result3);
		$t++;
		$estadistica[$eq2][0] = $row["Descripcion"] . '(b)';
		$estadistica[$eq2][1] = $eq2;
		$estadistica[$eq2][2] = 0;
	}

	$estadistica1 = $estadistica;
	$estadistica2 = $estadistica;
	$Parlay = $estadistica;
	$Derecho = $estadistica;
	//$result = mysqli_query($GLOBALS['link'],"SELECT * FROM _configuracionjugadabb,_tbjuegodd where _configuracionjugadabb.IDDD=_tbjuegodd.IDDD  and  _configuracionjugadabb.IDJ=".$idj." and _configuracionjugadabb.grupo=$grupo  and _tbjuegodd.grupo=$grupo  and _configuracionjugadabb.IDB=$IDB Order by _configuracionjugadabb.IDP,_tbjuegodd.Formato,_configuracionjugadabb.IDDD");

	$result = mysqli_query($GLOBALS['link'], "Select * from _tjugadabb where IDJ=$idj and activo=1");

else :
	$existe = true;
	$row3 = mysqli_fetch_array($resultlo);
	$serial = $row3['UltimoSerial'];
	$result = mysqli_query($GLOBALS['link'], "Select * from _tjugadabb where serial>$serial and IDJ=$idj and activo=1");
	$estadistica = unserialize($row3['estadistica']);
	$estadistica1 = unserialize($row3['estadistica1']);
	$estadistica2 = unserialize($row3['estadistica2']);
	$Parlay = unserialize($row3['Parlay']);
	$Derecho = unserialize($row3['Derecho']);
endif;
$ultimo = 0;
while ($row3 = mysqli_fetch_array($result)) {
	$jgdad = explode('*', $row3['Jugada']);
	$ultimo = $row3['serial'];
	$cantidad = count($jgdad) - 1;
	//  echo $cantidad;
	$cantidadAP =   $row3['ap'] / $cantidad;
	$premio = $row3['acobrar'] / $cantidad;
	for ($u = 0; $u <= count($jgdad) - 2; $u++) {
		$opcion = explode('|', $jgdad[$u]);
		$logro = $opcion[1];
		$opcion1 = explode('%', $opcion[0]);
		$carr = $opcion1[1];
		$opcion2 = explode('-', $opcion1[0]);
		$equi = $opcion2[0];
		$iddd = $opcion2[1];
		//$key = searcharry($estadistica,intval($equi));
		// echo $key;
		// if ($key!=false):
		$result2 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . intval($equi) . "  and  ( _equiposbb.Grupo=$grupo or _equiposbb.Grupo1=$grupo or _equiposbb.Grupo2=$grupo) ");
		if (mysqli_num_rows($result2) != 0) :
			$estadistica[intval($equi)][$iddd] += redondear($cantidadAP);
			$estadistica[intval($equi)][2]++;
			$estadistica1[intval($equi)][$iddd] += redondear($premio);

			$estadistica2[intval($equi)][2]++;
			$estadistica2[intval($equi)][3] += redondear($cantidadAP);
			$estadistica2[intval($equi)][4] += redondear($premio);

			if ($cantidad == 1) :
				$Derecho[intval($equi)][$iddd] += redondear($cantidadAP);
				$Derecho[intval($equi)][2]++;
			else :
				$Parlay[intval($equi)][$iddd] += redondear($cantidadAP);
				$Parlay[intval($equi)][2]++;
			endif;

		endif;
		// endif;

	}
}

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
$doc->save('Total.xml');

$doc = new DOMDocument('1.0', 'UTF-8');
$element  = $doc->appendChild(new DOMElement('rows'));
$i = 1;
$sumaTotal = 0;
while (list($key, $val) = each($Parlay)) {
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
$doc->save('Parlay.xml');



$doc = new DOMDocument('1.0', 'UTF-8');
$element  = $doc->appendChild(new DOMElement('rows'));
$i = 1;
$sumaTotal = 0;
while (list($key, $val) = each($Derecho)) {
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
$doc->save('Derecho.xml');

$doc = new DOMDocument('1.0', 'UTF-8');
$element  = $doc->appendChild(new DOMElement('rows'));
$i = 1;
$sumaTotal = 0;
while (list($key, $val) = each($estadistica1)) {
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
$doc->save('Premio.xml');

$columnasG = array();
$columnasG[] = 3;
$columnasG[] = 4;
$columnasG[] = -1;
$doc = new DOMDocument('1.0', 'UTF-8');
$element  = $doc->appendChild(new DOMElement('rows'));
$i = 1;
$sumaTotal = 0;
while (list($key, $val) = each($estadistica2)) {
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
	while ($j <= count($columnasG)) {
		if (array_key_exists($columnasG[$j], $val)) :
			$element1->appendChild($element_ns);
			$element_ns = new DOMElement('cell', $val[$columnasG[$j]], '');
			$sumaTotal += $val[$columnasG[$j]];
		else :
			if ($columnasG[$j] == -1) :
				$element1->appendChild($element_ns);
				$element_ns = new DOMElement('cell', 0, '');
			else :
				$element1->appendChild($element_ns);
				$element_ns = new DOMElement('cell', '0', '');
			endif;
		endif;
		$j++;
	}
}
$doc->save('Grafico.xml');
//IDJ, estadistica, estadistica2, Parlay, Derecho, UltimoSerial, HoraCheck
if ($existe) :
	if ($ultimo == 0) :
		$resultlo = mysqli_query($GLOBALS['link'], "Update  _tbestadisticas set estadistica='" . serialize($estadistica) . "',estadistica2='" . serialize($estadistica2) . "',Parlay='" . serialize($Parlay) . "',Derecho='" . serialize($Derecho) . "',HoraCheck='" . Horareal($GLOBALS['minutosh'], "h:i:s A") . "',estadistica1='" . serialize($estadistica1) . "'    where Grupo=$grupo and IDJ=$idj");
	else :
		$resultlo = mysqli_query($GLOBALS['link'], "Update  _tbestadisticas set estadistica='" . serialize($estadistica) . "',estadistica2='" . serialize($estadistica2) . "',Parlay='" . serialize($Parlay) . "',Derecho='" . serialize($Derecho) . "',UltimoSerial=$ultimo,HoraCheck='" . Horareal($GLOBALS['minutosh'], "h:i:s A") . "',estadistica1='" . serialize($estadistica1) . "'  where Grupo=$grupo and IDJ=$idj");

	endif;
else :
	$resultlo = mysqli_query($GLOBALS['link'], "Insert  _tbestadisticas Values ($idj,'" . serialize($estadistica) . "','" . serialize($estadistica2) . "','" . serialize($Parlay) . "','" . serialize($Derecho) . "',$ultimo,'" . Horareal($GLOBALS['minutosh'], "h:i:s A") . "', $grupo,'" . serialize($estadistica1) . "')");
endif;

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
