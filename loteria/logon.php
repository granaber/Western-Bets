<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$respuesta = array();

$usuario = $_REQUEST['iduser'];
$IDJ = $_REQUEST['IDJ'];
$ip = getip();
if (empty($ip) || !preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $ip)) : $ip = $_SERVER["REMOTE_ADDR"];
endif;



$sql = ("SELECT * FROM _tusu where Usuario='" . $usuario . "'");
$resultj = mysqli_query($GLOBALS['link'], $sql);

if (mysqli_num_rows($resultj) != 0) :
	$row = mysqli_fetch_array($resultj);
	$acceder = true;
	$sql = ("SELECT * FROM _registros_de_acceso where Bloquear=1 and  IDusu=" . $row['IDusu']);
	// echo  	 $sql;
	$resulYK = mysqli_query($GLOBALS['link'], $sql);
	if (mysqli_num_rows($resulYK) != 0) :
		$acceder = false;
	endif;
	if ($acceder) :

		$clave = $_COOKIE['-okwilh'];
		//$desbloquear1= decrypt(decrypt($clave, 'mjuilk091o@'), 'mjuilk091o@');
		// $desbloquear1= decrypt($clave, 'mjuilk091o@');
		// echo strval($row['clave']);  echo '<br>'; echo $_COOKIE['-okwilh'];
		// $desbloquear2= decrypt($row['clave'], 'mjuilk091o@');
		//  echo $desbloquear1.'<br>'; echo $row['clave'].'<br>'; 
		//  echo $clave;
		if (strval($row['clave']) == strval($clave)) :
			$acceder = true;
			if ($row['Tipo'] == 5 || $row['Tipo'] == 6 || $row['Tipo'] == 2 || $row['Tipo'] == 3 || $row['Tipo'] == 4) :   $acceder = false;
			endif;

			if ($acceder) :
				$sql = ("SELECT * FROM _registros_de_acceso where IDusu=" . $row['IDusu']);
				$resultjCodigo = mysqli_query($GLOBALS['link'], $sql);
				if (mysqli_num_rows($resultjCodigo) == 0) :

					$timeserial = explode(':', time());
					$se = chr(rand(1, 25) + 65) . rand(1, 10) . rand(1, intval($timeserial[2])) . rand(1, 100) . '-' . chr(rand(1, 25) + 65) . rand(1, 1000) . '-' . substr(intval($timeserial[0]), 2, 1) . chr(rand(1, 25) + 65) . '-' . rand(1, 10) . rand(1, 50) . rand(1, 100) . chr(rand(1, 25) + 65);


					$result = mysqli_query($GLOBALS['link'], "INSERT INTO _registros_de_acceso   VALUES (" . $row['IDusu'] . ",'" . $se . "','" . $ip . "','','',''," . $IDJ . ",0,1)");


					$respuesta[] = true;
					$respuesta[] = 1;
					$respuesta[] = $se;
					$respuesta[] = $row['IDusu'];
				else :
					$rowgeneral = mysqli_fetch_array($resultjCodigo);

					if ($rowgeneral['SerialGenerado'] != '') :
						$acceder = false;
						$bloqueo = false;
						if ($rowgeneral['Nuevo'] == 1) :
							$timeserial = explode(':', time());
							$se = chr(rand(1, 25) + 65) . rand(1, 10) . rand(1, intval($timeserial[2])) . rand(1, 100) . '-' . chr(rand(1, 25) + 65) . rand(1, 1000) . '-' . substr(intval($timeserial[0]), 2, 1) . chr(rand(1, 25) + 65);
							setcookie('yhki91', encrypt($se, 'mjuilk091o@'), time() + 2 * (60 * 60 * 24 * 365));
							$result = mysqli_query($GLOBALS['link'], "Update  _registros_de_acceso  Set Nuevo=0 where IDusu=" . $row['IDusu']);
							$result = mysqli_query($GLOBALS['link'], "Update  _registros_de_acceso  Set cookieLabor='" . $se . "' where IDusu=" . $row['IDusu']);
							$acceder = true;
						else :
							$cookielabor = decrypt($_COOKIE['yhki91'], 'mjuilk091o@');

							if ($cookielabor == $rowgeneral['cookieLabor']/* && $ip==$rowgeneral['IpLabor']*/) :
								$acceder = true;
							else :
								if ($rowgeneral['IDJ'] == $IDJ) :
									$result = mysqli_query($GLOBALS['link'], "Update  _registros_de_acceso  Set Bloquear=1 where IDusu=" . $row['IDusu']);
									$acceder = false;
									$bloqueo = true;
								else :
									if ($cookielabor == $rowgeneral['cookieLabor']) :
										$result = mysqli_query($GLOBALS['link'], "Update  _registros_de_acceso  Set IDJ=" . $IDJ . " where IDusu=" . $row['IDusu']);
										$acceder = true;
									else :
										$result = mysqli_query($GLOBALS['link'], "Update  _registros_de_acceso  Set Bloquear=1 where IDusu=" . $row['IDusu']);
										$acceder = false;
										$bloqueo = true;
									endif;
								endif;
							endif;

						endif;
						if ($acceder) :
							$respuesta[] = true;
							$respuesta[] = 2;
							$respuesta[] = $row['Nombre'];
							$respuesta[] = $row['IDusu'];
							switch ($row['Tipo']) {
								case 1:
									$respuesta[] = 'Agencia';
									$resultjSQ = mysqli_query($GLOBALS['link'], "Select * From _tagencias Where IDC=" . $row['Asociado']);
									break;
								case 2:
									$respuesta[] = 'Intermediario';
									$resultjSQ = mysqli_query($GLOBALS['link'], "Select * From _tintermediario Where IDI=" . $row['Asociado']);
									break;
								case 3:
									$respuesta[] = 'Zona';
									$resultjSQ = mysqli_query($GLOBALS['link'], "Select * From _tzona Where IDZ=" . $row['Asociado']);
									break;
								case 4:
									$respuesta[] = 'Banca';
									$resultjSQ = mysqli_query($GLOBALS['link'], "Select * From _tbanca Where IDB=" . $row['Asociado']);
									break;
							}
							$rowSQ = mysqli_fetch_array($resultjSQ);
							$respuesta[] = $row['Tipo'];
							$respuesta[] = $rowSQ['Descripcion'];
							$respuesta[] = $row['Asociado'];

							$result = mysqli_query($GLOBALS['link'], "Update  _registros_de_acceso  Set IpLabor='" . $ip . "' where IDusu=" . $row['IDusu']);
						else :
							if ($bloqueo) :
								$respuesta[] = false;
								$respuesta[] = 'Esta Clave se ha Bloqueado Comuniquese con el Administradore';
							else :
								$respuesta[] = false;
								$respuesta[] = 'Debe Comunicarse Con el Administrador ya que debe realizar la Instalacion de Nuevo!';
							endif;
						endif;
					else :
						$respuesta[] = false;
						$respuesta[] = 'Debe Comunicarse Con el Administrador ya que debe realizar la Instalacion de Nuevo!';
					endif;
				endif;
			else :
				$respuesta[] = true;
				$respuesta[] = 3;
				$respuesta[] = $row['Nombre'];
				if ($row['Tipo'] == 2) : $respuesta[] = 'Intermediario';
				endif;
				if ($row['Tipo'] == 3) : $respuesta[] = 'Zona';
				endif;
				if ($row['Tipo'] == 4) : $respuesta[] = 'Banca';
				endif;
				if ($row['Tipo'] == 5) : $respuesta[] = 'Administrador';
				endif;
				if ($row['Tipo'] == 6) : $respuesta[] = 'Usuario';
				endif;
				$respuesta[] = $row['IDusu'];
			endif;
		else :
			$respuesta[] = false;
			$respuesta[] = 'La Clave Introducida es Errada!';
		endif;
	else :
		$respuesta[] = false;
		$respuesta[] = 'Esta Clave se ha Bloqueado Comuniquese con el Administrador';
	endif;
else :
	$respuesta[] = false;
	$respuesta[] = 'Este Nombre de  Usuario No Existe!';
endif;
echo json_encode($respuesta);
