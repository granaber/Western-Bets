<?php
// session_start();
// $iSecury=explode('/',getenv("HTTP_REFERER"));
// 		if ( !($iSecury[2]==="parlayenlinea.tk" || $iSecury[2]==="www.parlayenlinea.tk"  ) ):

// 		header("Location:index.php");
// 		exit;
// 	endif;	

require('prc_php.php');


$op = $_REQUEST['op'];

switch ($op) {

	case 2:
		$ldv = $_REQUEST['ldv'];
		$tb = $_REQUEST['tb'];
		$idusu = $_REQUEST['idt'];
		$idusu = $_REQUEST['idt'];

		$lcampos = explode(',', $ldv);
		$campos = array();
		$valores = array();
		$lista_insert = '';
		$lista_update = '';
		$Resultados = '';
		$IDP = 0;
		$Grupo = 0;
		$IDJ = 0;
		for ($i = 0; $i <= count($lcampos) - 1; $i++) {
			if ($i != 0) :
				$lista_update = $lista_update . ',';
				$lista_insert = $lista_insert . ',';
			endif;

			$sdc = explode(':', $lcampos[$i]);
			$campos[$i] = $sdc[0];
			$vv = var_export($sdc[1], true);

			if (ctype_digit($sdc[1])) :
				$valores[$i] = $sdc[1];
			else :
				$valores[$i] = '"' . $sdc[1] . '"';
			endif;

			$lista_update = $lista_update . $campos[$i] . '=' . $valores[$i];
			$lista_insert = $lista_insert . $valores[$i];
			if ($campos[$i] == 'Escrute') :   $Resultados = $sdc[1];
			endif;
			if ($campos[$i] == 'IDP') : 	    $IDP = $valores[$i];
			endif;
			if ($campos[$i] == 'Grupo') :     $Grupo = $valores[$i];
			endif;
			if ($campos[$i] == 'IDJ') :       $IDJ = $valores[$i];
			endif;
		}

		if ($tb == "_tbescrute" ||   $tb == "_tconsecionariodd" || $tb == "_tbjuegodd") :
			$GLOBALS['link'] = Connection::getInstance();
			$result2k = mysqli_query($GLOBALS['link'], "SELECT * FROM " . $tb . " where " . $campos[0] . "=" . $valores[0]);

			if (mysqli_num_rows($result2k) == 0) :
				$result = mysqli_query($GLOBALS['link'], "INSERT INTO " . $tb . "  VALUES (" . $lista_insert . ")");
				if (trim($tb) == "_tbescrute") :
					$ResultadoNue = explode('|', $Resultados);
					for ($x = 1; $x <= count($ResultadoNue) - 1; $x += 2) {
						$horaticket = Horareal($GLOBALS['minutosh'], "h:i:s A");
						$fechaactual = Fechareal($GLOBALS['minutosh'], "d/n/Y");
						$Despu = "Nuevo";
						$Ahora = $ResultadoNue[$x];
						$result3 = mysqli_query($GLOBALS['link'], "Insert _auditoria_logros_ext2 (IDP,IDJ,Despues,Ahora,dat_hour,IDusu,Grupo,IDCNGE) values ($IDP,$IDJ,'" . $Despu . "','" . $Ahora . "','" . $fechaactual . "-" . $horaticket . "', $idusu,$Grupo," . $ResultadoNue[$x - 1] . ");");
						echo ("Insert _auditoria_logros_ext2 (IDP,IDJ,Despues,Ahora,dat_hour,IDusu,Grupo,IDCNGE) values ($IDP,$IDJ,'" . $Despu . "','" . $Ahora . "','" . $fechaactual . "-" . $horaticket . "', $idusu,$Grupo," . $ResultadoNue[$x - 1] . ");");
					}
				endif;
			else :
				$result = mysqli_query($GLOBALS['link'], "Update " . $tb . " Set " . $lista_update . " where " . $campos[0] . "=" . $valores[0]);
				if (trim($tb) == "_tbescrute") :
					$Row2k = mysqli_fetch_array($result2k);
					$ResultadoAlm = explode('|', $Row2k['Escrute']);
					$ResultadoNue = explode('|', $Resultados);

					for ($x = 1; $x <= count($ResultadoNue) - 1; $x += 2) {
						$compara = strcmp($ResultadoAlm[$x], $ResultadoNue[$x]);

						if ($compara) :
							$horaticket = Horareal($GLOBALS['minutosh'], "h:i:s A");
							$fechaactual = Fechareal($GLOBALS['minutosh'], "d/n/Y");
							$Despu = $ResultadoAlm[$x];
							$Ahora = $ResultadoNue[$x];
							$result3 = mysqli_query($GLOBALS['link'], "Insert _auditoria_logros_ext2 (IDP,IDJ,Despues,Ahora,dat_hour,IDusu,Grupo,IDCNGE) values ($IDP,$IDJ,'" . $Despu . "','" . $Ahora . "','" . $fechaactual . "-" . $horaticket . "', $idusu,$Grupo," . $ResultadoAlm[$x - 1] . ");");
							echo ("Insert _auditoria_logros_ext2 (IDP,IDJ,Despues,Ahora,dat_hour,IDusu,Grupo,IDCNGE) values ($IDP,$IDJ,'" . $Despu . "','" . $Ahora . "','" . $fechaactual . "-" . $horaticket . "', $idusu,$Grupo," . $ResultadoAlm[$x - 1] . ");");
						endif;
					}
				endif;
			endif;
			echo "Grabado... ";
		endif;
		break;
	case 3:
		$ldv = $_REQUEST['ldv'];
		$tb = $_REQUEST['tb'];
		$sdc = explode(':', $ldv);

		$GLOBALS['link'] = Connection::getInstance();
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM " . $tb . " where " . $sdc[0] . "=" . $sdc[1]);

		$row = mysqli_fetch_array($result);
		if ($row['Estatus'] == 1) :
			$result = mysqli_query($GLOBALS['link'], "Update " . $tb . " Set Estatus=2 where " . $sdc[0] . "=" . $sdc[1]);
			$eta = 2;
		else :
			$result = mysqli_query($GLOBALS['link'], "Update " . $tb . " Set Estatus=1 where " . $sdc[0] . "=" . $sdc[1]);
			$eta = 1;
		endif;
		echo json_encode($eta);

		break;
	case 4:
		$ldv = $_REQUEST['ldv'];
		$tb = $_REQUEST['tb'];

		$lcampos = explode(',', $ldv);
		$campos = array();
		$valores = array();
		$lista_insert = '';
		$lista_update = '';
		for ($i = 0; $i <= count($lcampos) - 1; $i++) {


			$sdc = explode(':', $lcampos[$i]);
			$campos[$i] = $sdc[0];
			$vv = var_export($sdc[1], true);

			if ($i != 0 &&  $campos[$i] != 'imagen') :
				$lista_update = $lista_update . ',';
				$lista_insert = $lista_insert . ',';
			endif;

			if (ctype_digit($sdc[1])) :
				$valores[$i] = $sdc[1];
			else :
				$valores[$i] = '"' . $sdc[1] . '"';
			endif;
			if ($campos[$i] != 'imagen') :
				$lista_update = $lista_update . $campos[$i] . '=' . $valores[$i];
				$lista_insert = $lista_insert . $valores[$i];
			else :
				$nomarchi = $sdc[1];
			endif;
		}
		if (!file_exists('images/logo/eq' . $valores[0] . '.png')) :
			rename('images/logo/' . $nomarchi, 'images/logo/eq' . $valores[0] . '.png');
		else :
			if (file_exists('images/logo/' . $nomarchi) && strcmp($nomarchi, 'eq' . $valores[0] . '.png') != 0) :
				unlink('images/logo/eq' . $valores[0] . '.png');
				rename('images/logo/' . $nomarchi, 'images/logo/eq' . $valores[0] . '.png');
			endif;
		endif;
		$GLOBALS['link'] = Connection::getInstance();
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM " . $tb . " where " . $campos[0] . "=" . $valores[0]);

		if (mysqli_num_rows($result) == 0) :
		// $result = mysqli_query($GLOBALS['link'],"INSERT INTO ".$tb."  VALUES (".$lista_insert.")");

		else :
		// $result = mysqli_query($GLOBALS['link'],"Update ".$tb." Set ".$lista_update." where ".$campos[0]."=".$valores[0]);

		endif;
		echo "Grabado... ";
		break;
	case 5:
		$ldv = $_REQUEST['ldv'];
		$tb = $_REQUEST['tb'];
		$lcampos = explode(',', $ldv);


		$GLOBALS['link'] = Connection::getInstance();
		for ($i = 1; $i <= count($lcampos) - 1; $i++) {

			$sdc = explode('|', $lcampos[$i]);
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbrestricionessph where IDC='" . $sdc[0] . "' and IDJ=" . $sdc[2]);

			if (mysqli_num_rows($result) == 0) :
				$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tbrestricionessph  VALUES ('" . $sdc[0] . "'," . $sdc[1] . "," . $sdc[2] . ")");
			else :
				$result = mysqli_query($GLOBALS['link'], "Update _tbrestricionessph Set mmxj=" . $sdc[1] . " where IDC='" . $sdc[0] . "' and IDJ=" . $sdc[2]);
			endif;
		}


		echo "Grabado... ";
		break;

	case 6:

		$ldv = $_REQUEST['ldv'];
		$tb = $_REQUEST['tb'];

		$lcampos = explode(',', $ldv);
		$campos = array();
		$valores = array();
		$lista_insert = '';
		$lista_update = '';
		for ($i = 0; $i <= count($lcampos) - 1; $i++) {
			$sdc = explode(':', $lcampos[$i]);
			$campos[$i] = $sdc[0];
			$vv = var_export($sdc[1], true);

			if (ctype_digit($sdc[1])) :
				$valores[$i] = $sdc[1];
			else :
				$valores[$i] = '"' . $sdc[1] . '"';
			endif;

			if ($i != 0 && $i != 1) :
				$lista_update = $lista_update . $campos[$i] . '=' . $valores[$i];
				$lista_insert = $lista_insert . $valores[$i];
			else :
				$lista_insert = $lista_insert . $valores[$i];
			endif;
			if ($i != 0 && $i != 1 && $i < count($lcampos) - 1) :
				$lista_update = $lista_update . ',';
				$lista_insert = $lista_insert . ',';
			else :
				if ($i < count($lcampos) - 1) :
					$lista_insert = $lista_insert . ',';
				endif;
			endif;
		}
		$GLOBALS['link'] = Connection::getInstance();
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM " . $tb . " where " . $campos[0] . "=" . $valores[0] . " and " . $campos[1] . "=" . $valores[1]);

		if (mysqli_num_rows($result) == 0) :
		// $result = mysqli_query($GLOBALS['link'],"INSERT INTO ".$tb."  VALUES (".$lista_insert.")");			

		else :
		//	 $result = mysqli_query($GLOBALS['link'],"Update ".$tb." Set ".$lista_update." where ".$campos[0]."=".$valores[0]." and ".$campos[1]."=".$valores[1]);			
		endif;
		echo "Grabado..";
		break;
	case 7:

		$ldv = $_REQUEST['ldv'];
		$tb = $_REQUEST['tb'];

		$lcampos = explode(',', $ldv);

		for ($i = 0; $i <= count($lcampos) - 1; $i++) {
			$sdc = explode('=', $lcampos[$i]);
			$campos[$i] = $sdc[0];
			$vv = var_export($sdc[1], true);

			if (ctype_digit($sdc[1])) :
				$valores[$i] = $sdc[1];
			else :
				$valores[$i] = '"' . $sdc[1] . '"';
			endif;

			$lista = $lista . $campos[$i] . '=' . $valores[$i];

			if ($i < count($lcampos) - 1) :
				$lista = $lista . " and ";
			endif;
		}


		$GLOBALS['link'] = Connection::getInstance();
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM " . $tb . " where " . $lista);

		if (mysqli_num_rows($result) != 0) :
		//	 $result = mysqli_query($GLOBALS['link'],"Delete  from ".$tb."  where ".$lista);	
		endif;

		break;
}
