<?php
require('prc_skynet.php');
$GLOBALS['link'] = Skynet::getInstance();


switch ($_REQUEST['op']) {

	case '1':
		$result = mysqli_query($GLOBALS['link'], "Select * from iwhatsapp  where IDCLIENT=$IDCLIENT and serial=" . $_REQUEST['serial']);
		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			$reENV = $row['reENV'] + 1;
			$numero = $_REQUEST['phsnd'];
			$PhoneNumber = '58' . $numero;
			$result = mysqli_query($GLOBALS['link'], "Update  iwhatsapp set  reENV=$reENV,ENV=0,err=0,telefono='$PhoneNumber' where IDCLIENT=$IDCLIENT and serial=" . $_REQUEST['serial']);
			//echo ("Update  iwhatsapp  reENV=$reENV,ENV=0,err=0,telefono='$PhoneNumber' where serial=".$_REQUEST['serial'] );
			echo  json_encode($result);
		else :
			echo  json_encode(-1);
		endif;
		break;
	case '2':
		$result = mysqli_query($GLOBALS['link'], "Select * from _tjugadabbmsg  where serial=" . $_REQUEST['serial']);
		$row = mysqli_fetch_array($result);

		$text = urlencode(myUrlEncode($row['msg']));

		$result = mysqli_query($GLOBALS['link'], "Update  _tjugadabbmsg  set phone=" . $_REQUEST['phone'] . " where serial=" . $_REQUEST['serial']);

		$user = "juliogutierrez";
		$password = "MW0VJ8";
		//echo "http://www.interconectados.net/api2/?PhoneNumber=".$PhoneNumber."&user=".$user."&password=".$password."&text=".$text." ";

		// Se crea un manejador CURL para realizar la petición
		$ch = curl_init();
		// Se establece la URL y algunas opciones
		curl_setopt(
			$ch,
			CURLOPT_URL,
			"http://www.interconectados.net/api2/?PhoneNumber=" . $_REQUEST['phone'] . "&text=" . $text . "&user=" . $user . "&password=" . $password
		);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		// Se obtiene la URL del SMS Gateway
		curl_exec($ch);
		// Se cierra el recurso CURL y se liberan los recursos del sistema
		// curl_close($ch);
		break;
}
