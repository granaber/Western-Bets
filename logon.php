<?php
session_start();

date_default_timezone_set('America/Caracas');

$op = $_REQUEST['op'];
$usu = $_REQUEST['usu'];
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

if ($op == 1) :
	$pw = $_REQUEST['pwd'];
	$ck = $_REQUEST['ck'];

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu where Usuario='" . trim($usu) . "'");
	if (mysqli_num_rows($result) != 0) :

		$row = mysqli_fetch_array($result);
		$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionariodd where IDC='" . $row["Asociado"] . "'");
		if (mysqli_num_rows($result3) != 0) :   $row3 = mysqli_fetch_array($result3);
			$eminutos = $row3["Eminutos"];
			$_SESSION['idCnv'] = $row3['idCnv'];
		else : $eminutos = 0;
		endif;

		$notificacion = '';
		if ($row['Tipo'] == 2) :
			$claveg = $row['clave'] . clavehora();
			$notificacion = $row['Descripcion'];
			$nombreU = $row['Usuario'];
		else :
			$claveg = $row['clave'];
		endif;

		if ($ck != '*' && $ck != 0) :
			if ($ck == $row['bloqueado']) :
				$ck = $row['bloqueado'];
			else :
				if ($row['bloqueado'] == 0) :
					$ck = $row['bloqueado'];
				endif;
			endif;
		endif;
		$ck = $row['bloqueado'];
		if ($row['bloqueado'] == 0 && $ck == '*') :

			if (md5($claveg) === $pw) :
				$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where Estatus=1 and fecha='" . date("d/n/Y") . "' order by IDCN");
				$row2 = mysqli_fetch_array($result2);
				if (mysqli_num_rows($result2) != 0) :
					$jor = $row2["IDCN"];
				else :
					$jor = "Cerrada";
				endif;

				if ($row['Estatus'] == 1) :
					$rnd = rand(1, 32560);
					$result2 = mysqli_query($GLOBALS['link'], "Update _tusu Set bloqueado=" . $rnd . " where IDusu=" . $row['IDusu']);
					if ($row["Tipo"] == 3) :
						if (VerificacionHORARIO()) :
							Logs($row['IDusu'], 0, 'Acceso al Sistema', 1);
							echo  "true||" . $row["Asociado"] . "||" . $row["Estacion"] . "||" . $row["Descripcion"] . "||" . date("d/n/Y") . "||" . $jor . "||" . $rnd . "||" . $row["IDusu"] . "||" . $row["Acceso"] . "||" . $row["AccesoP"] . "||" . $row["bloqueado"] . "||" . $eminutos;
							cRdCreditoAnt($row["Asociado"]);
						else :
							Logs($row['IDusu'], 0, 'Fuera de Horario', 0);
							echo  "false||3";
						endif;
					else :
						if ($row["Tipo"] == 2) :
							SendMail($notificacion, 'Entrada al Sistema', 'La Cuenta de:' . $nombreU . '(' . $row["IDusu"] . ') acaba de entrar al sistema de Parlay, en fecha y hora: ' . date("d/n/Y") . ' ' . date("g:i a") . '\n ** Archivese este email para futuras consultas **', 'skynet@parlayenlinea.org');
						endif;
						$valor = intval($row["Tipo"]) * (-1);
						Logs($row['IDusu'], 0, 'Acceso al Sistema', 1);
						echo  "true||" . $valor . "||" . $row["Estacion"] . "||" . $row["Descripcion"] . "||" . date("d/n/Y") . "||" . $jor . "||" . $rnd . "||" . $row["IDusu"] . "||" . $row["Acceso"] . "||" . $row["AccesoP"] . "||" . $row["bloqueado"] . "||" . $eminutos;
					endif;
				else :
					Logs($row['IDusu'], 0, 'Usuario Bloqueado', 0);
					echo  "false||1";
				endif;

			else :
				Logs(0, 0, 'Intento de Entrada Fallida ' . $usu, 0);
				echo  "false||0";
			endif;
		else :
			if ($row['bloqueado'] == $ck) :
				if (md5($claveg) === $pw) :
					/*    $result2 = mysqli_query($GLOBALS['link'],"SELECT * FROM _tconfjornada where Estatus=1 and fecha='".date("d/n/Y")."' order by IDCN" );
          $row2 = mysqli_fetch_array($result2);
	     if (mysqli_num_rows($result2)!=0):
	      $jor=$row2["IDCN"];
	     else:
	      $jor="Cerrada";
	     endif;*/

					if ($row['Estatus'] == 1) :

						$rnd = rand(1, 32560);
						$result2 = mysqli_query($GLOBALS['link'], "Update _tusu Set bloqueado=" . $rnd . " where IDusu=" . $row['IDusu']);
						if ($row["Tipo"] == 3) :
							if (VerificacionHORARIO()) :
								Logs($row['IDusu'], 0, 'Acceso al Sistema', 1);
								echo  "true||" . $row["Asociado"] . "||" . $row["Estacion"] . "||" . $row["Descripcion"] . "||" . date("d/n/Y") . "||" . $jor . "||" . $rnd . "||" . $row["IDusu"] . "||" . $row["Acceso"] . "||" . $row["AccesoP"] . "||" . $row["bloqueado"] . "||" . $eminutos;
								cRdCreditoAnt($row["Asociado"]);
							else :
								Logs($row['IDusu'], 0, 'Fuera de Horario', 0);
								echo  "false||3";
							endif;
						else :
							if ($row["Tipo"] == 2) :
								SendMail($notificacion, 'Entrada al Sistema', 'La Cuenta de:' . $nombreU . '(' . $row["IDusu"] . ') acaba de entrar al sistema de Parlay, en fecha y hora: ' . date("d/n/Y") . ' ' . date("g:i a") . '\n ** Archivese este email para futuras consultas **', 'skynet@parlayenlinea.org');
							endif;
							$valor = intval($row["Tipo"]) * (-1);
							Logs($row['IDusu'], 0, 'Acceso al Sistema', 1);
							echo  "true||" . $valor . "||" . $row["Estacion"] . "||" . $row["Descripcion"] . "||" . date("d/n/Y") . "||" . $jor . "||" . $rnd . "||" . $row["IDusu"] . "||" . $row["Acceso"] . "||" . $row["AccesoP"] . "||" . $row["bloqueado"] . "||" . $eminutos;
						endif;

					else :
						Logs($row['IDusu'], 0, 'Usuario Bloqueado', 0);
						echo  "false||1";
					endif;

				else :
					Logs(0, 0, 'Intento de Entrada Fallida ' . $usu, 0);
					echo  "false||0";
				endif;
			else :
				Logs($row['IDusu'], 0, 'Usuario Bloqueado', 0);
				echo  "false||1";
			endif;
		endif;
	else :
		Logs(0, 0, 'Intento de Entrada Fallida ' . $usu, 0);
		echo  "false||0";
	endif;
else :
	$result2 = mysqli_query($GLOBALS['link'], "Update _tusu Set bloqueado=0 where IDusu=" . $usu);
	echo  "true||0";
endif;


function VerificacionHORARIO()
{

	$horaticket = Horareal($GLOBALS['minutosh'], "h:i:s A");
	$fecha = Fechareal($GLOBALS['minutosh'], "d/n/Y");

	$permitirgrabar = true;
	$hora = convertirMilitar($horaticket);
	$dia = date('N', str2date($fecha));

	$result2 = mysqli_query($GLOBALS['link'], "Select * From _thorariodeventas Where Dia=" . $dia);

	if (mysqli_num_rows($result2) != 0) :
		$row2 = mysqli_fetch_array($result2);
		$permitirgrabar = EntreHoras($hora, $row2['HoradeVenta'], $row2['HoradeCierre']);
	endif;

	return $permitirgrabar;
}
function clavehora()
{

	$horav = explode(':', Horareal($GLOBALS['minutosh'], "h:i"));

	$strhora = $horav[0] . '' . $horav[1];
	return $strhora;
}
