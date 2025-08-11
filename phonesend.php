<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$numero = $_REQUEST['phsnd'];

$serial = $_REQUEST['serial'];
//Asignamos variables
if (is_numeric($numero)) :
	$PhoneNumber = $numero;
else :
	echo json_encode(array(0));
	exit;
endif;


if ($_REQUEST['op'] == 0) :
	$tk = $_REQUEST['tk'];
	$text = urlencode(myUrlEncode($tk));
	$result = mysqli_query($GLOBALS['link'], "insert _tjugadabbmsg  values(" . $serial . ",'" . $numero . "','" . $tk . "');");
else :
	$result = mysqli_query($GLOBALS['link'], "Select * from _tjugadabbmsg  where  IDCLIENT=$IDCLIENT and serial=" . $serial);
	$row = mysqli_fetch_array($result);
	$text = urlencode(myUrlEncode($row['msg']));
	$result = mysqli_query($GLOBALS['link'], "Update  _tjugadabbmsg  set phone=" . $_REQUEST['phone'] . " where IDCLIENT=$IDCLIENT and serial=" . $_REQUEST['serial']);
endif;
//echo ("insert _tjugadabbmsg  values(".$serial.",'".$numero."','".$tk."');" );
$user = "juliogutierrez";
$password = "MW0VJ8";
//echo "http://www.interconectados.net/api2/?PhoneNumber=".$PhoneNumber."&user=".$user."&password=".$password."&text=".$text." ";

// Se crea un manejador CURL para realizar la petición
$ch = curl_init();
// Se establece la URL y algunas opciones
curl_setopt(
	$ch,
	CURLOPT_URL,
	"http://www.interconectados.net/api2/?PhoneNumber=" . $PhoneNumber . "&text=" . $text . "&user=" . $user . "&password=" . $password
);
curl_setopt($ch, CURLOPT_HEADER, 0);
// Se obtiene la URL del SMS Gateway
curl_exec($ch);
// Se cierra el recurso CURL y se liberan los recursos del sistema
// curl_close($ch);




function myUrlEncode($string)
{
	$entities = array('½');
	$replacements = array('.5');
	return str_replace($entities, $replacements, ($string));
}
