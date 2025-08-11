<?
require('prc_php.php');

$ldv = $_REQUEST['ldv'];
$tb = $_REQUEST['tb'];

$op = $_REQUEST['op'];

$lcampos = explode(',', $ldv);
$campos = array();
$valores = array();
$lista_insert = '';
$lista_update = '';
for ($i = 0; $i <= count($lcampos) - 1; $i++) {
	if ($i != 0) :
		$lista_update = $lista_update . ',';
		$lista_insert = $lista_insert . ',';
	endif;

	$sdc = explode('!', $lcampos[$i]);
	$campos[$i] = $sdc[0];
	$vv = var_export($sdc[1], true);



	if (ctype_digit($sdc[1])) :
		$valores[$i] = $sdc[1];
	else :
		$valores[$i] = '"' . $sdc[1] . '"';
	endif;

	if ($campos[$i] == 'Clave') :
		$valores[$i] = '"' . encrypt(strval($valores[$i]), 'mjuilk091o@') . '"';
	endif;

	$lista_update = $lista_update . $campos[$i] . '=' . $valores[$i];
	$lista_insert = $lista_insert . $valores[$i];
}
$GLOBALS['link'] = Connection::getInstance();
$camposClave = '';
for ($i = 1; $i <= $op; $i++) {
	$camposClave .= $campos[$i - 1] . "=" . $valores[$i - 1];
	if ($i < $op) :
		$camposClave .= " and ";
	endif;
}
$result = mysqli_query($GLOBALS['link'], "SELECT * FROM " . $tb . " where " . $camposClave);



if (mysqli_num_rows($result) == 0) :
	$result = mysqli_query($GLOBALS['link'], "INSERT INTO " . $tb . "  VALUES (" . $lista_insert . ")");

else :
	$result = mysqli_query($GLOBALS['link'], "Update " . $tb . " Set " . $lista_update . " where " . $camposClave);

endif;
echo "Grabado";
