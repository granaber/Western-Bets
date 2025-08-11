<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$Grupo = $_REQUEST['Grupo'];
$IDPagina = $_REQUEST['IDPagina'];

$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbformato_lectura where Grupo=$Grupo and IDPagina=$IDPagina");
$row = mysqli_fetch_array($resultj);
$lectura = explode('|', $row['Formato']);


$string = $_REQUEST['proceso'];
$order   = array("\r\n", "\n", "\r");
$replace = '*';
$newstr = str_replace($order, $replace, $string);

$order   = array("\t");
$replace = '-';
$newstr = str_replace($order, $replace, $newstr);

$verarray = explode('*', $newstr);

//$msg = split(chr(13),$_REQUEST['msg']);

/*echo json_encode($verarray);
		
		echo json_encode(explode('-',$verarray[0]));*/

for ($i = 0; $i <= count($verarray) - 1; $i++) {

	$descomprimir = explode('-', $verarray[$i]);

	for ($j = 0; $j <= count($lectura) - 1; $j++) {
		if ($lectura[$j] != '') :
			$verFunction = explode(':', $lectura[$j]);
			if (count($verFunction) == 1) :
				echo $descomprimir[$j] . '<br>';
			else :
				$exe = "\$respuesta=" . $verFunction[1] . '("' . $descomprimir[$j] . '");';
				eval($exe);
				echo $respuesta . '<br>';
			endif;
		endif;
	}
}
