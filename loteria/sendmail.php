<?
require_once('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

global $GLOBALS['minutosh']o;

$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu  Where email<>''");
if (mysqli_num_rows($resultj) != 0) :
	$rowj = mysqli_fetch_array($resultj);
	$resultj1 = mysqli_query($GLOBALS['link'], "SELECT *  FROM  _tbclavebli ORDER BY  NIBL DESC");

	$acceso = true;
	if (mysqli_num_rows($resultj) != 0) :
		$rowj1 = mysqli_fetch_array($resultj1);
		if ($rowj1['Usuario'] ==  $rowj['Usuario']) :
			$Fecha_Actual = Fechareal($GLOBALS['minutosh']o, 'd/n/Y');
			$hora = convertirMilitar(Horareal($GLOBALS['minutosh']o, "h:i:s A"));
			if (!diferenciadehorasxMIN($rowj1['fecha'], $Fecha_Actual, $rowj1['hora'], $hora, 600)) :
				$acceso = false;
			endif;
		endif;
	endif;

	if ($acceso) :
		$se = rand(1, 10) . chr(rand(1, 25) + 65) . chr(rand(1, 25) + 65) . rand(1, 5) . chr(rand(1, 25) + 65) . chr(rand(1, 25) + 65) . rand(1, 50);


		$header = 'From: noresponder<noresponder@bancalatina1.net>\n';
		$header .= 'MIME-Version: 1.0\n';
		$header .= 'Content-type: text/html; charset=iso-8859-1';
		$msj = 'Clave de BLI' . "\"\n";
		$msj .= 'Esta clave tiene una duracion de 10 minutos, al acabo de este tiempo el sistema automaticamente genera otra y usted debe verificar el correo principal' . "\"\n";
		$msj .= 'USUARIO:' . $rowj['Usuario'] . "\"\n";
		$msj .= 'CLAVE BLI:' . $se;
		$dest = $rowj['email']; //$rowj['email'];//<- Aqui debo colocar el correo que recibira la clave BLI
		$asunto = 'Clave BLI Sistema Lotery';
		$ok = @mail($dest, $asunto, $msj, $header);
		if ($ok) {
			$resultUpdate = mysqli_query($GLOBALS['link'], "Insert  _tbclavebli (Usuario,BLI,fecha,hora) values ('" . $rowj['Usuario'] . "','" . $se . "','" . Fechareal($GLOBALS['minutosh']o, 'd/n/Y') . "','" . convertirMilitar(Horareal($GLOBALS['minutosh']o, "h:i:s A")) . "')");
			echo json_encode(array(true, true));
		} else {
			echo json_encode(array(false, false));
		}
	else :
		echo json_encode(array(true, false));
	endif;
else :
	echo json_encode(array(false, false));
endif;
