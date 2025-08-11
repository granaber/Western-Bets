<?php
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', 'error.log');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
date_default_timezone_set('America/Caracas');
require_once('prc_php.php');
require_once 'prc_credit.php';
require_once 'function_parameters_for_api.php';


function cierredebb($idj, $idp, $dp, $idu)
{
	$resl = true;
	$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrebb where IDJ=" . $idj . " and IDP=" . $idp . " and Grupo=" . $dp);
	if (mysqli_num_rows($resultp) == 0) :
		$result = mysqli_query($GLOBALS['link'], "INSERT INTO _cierrebb  VALUES (" . $idp . "," . $idj . ",'" . Horareal($GLOBALS['minutosh'], "h:i:s A") . "','" . Fechareal($GLOBALS['minutosh'], "d-m-y") . "'," . $idu . "," . $dp . ")");
		Bitacora("Se Cerro el partido No. " . $idp . " de Jornada " . $idj . " Usuario:" . $idu);
	else :
		$resultj3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbescrute where IDJ=" . $idj . " and Grupo=" . $dp . " and IDP=" . $idp);
		if (mysqli_num_rows($resultj3) == 0) :
			$result = mysqli_query($GLOBALS['link'], "Delete from _cierrebb  where IDJ=" . $idj . " and IDP=" . $idp . " and Grupo=" . $dp);
			Bitacora("Se Apeturo el partido No. " . $idp . " de Jornada " . $idj . " Usuario:" . $idu);
		else :
			$resl = false;
		endif;
	endif;
	$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrebb_bloqueo where IDJ=" . $idj . " and IDP=" . $idp . " and Grupo=" . $dp);

	if (mysqli_num_rows($resultp) == 0) :
		$result = mysqli_query($GLOBALS['link'], "INSERT INTO _cierrebb_bloqueo  VALUES (" . $idp . "," . $idj . ",'" . Horareal($GLOBALS['minutosh'], "h:i:s A") . "','" . Fechareal($GLOBALS['minutosh'], "d-m-y") . "'," . $idu . "," . $dp . ")");
	endif;
	return $resl;
}

$GLOBALS['link'] = Connection::getInstance();

$op = $_REQUEST["op"];

if ($op == 1) :
	$idj = $_REQUEST["idj"];
	$idp = $_REQUEST["idp"];
	$idu = $_REQUEST["idu"];
	$dp = $_REQUEST['dp'];
	echo (json_encode(cierredebb($idj, $idp, $dp, $idu)));
endif;

if ($op == 2) :

	$idj = $_REQUEST["idj"];

	$dp = $_REQUEST['dp'];

	$resultp = mysqli_query($GLOBALS['link'], "SELECT IDP FROM _cierrebb where IDJ=" . $idj . " and Grupo=" . $dp);

	$aa = '';

	while ($row = mysqli_fetch_array($resultp)) {

		$aa = $aa . $row['IDP'] . '|';
	}



	echo $aa;

//echo "SELECT IDP FROM _cierrebb where IDJ=".$idj." and Grupo=".$dp;

endif;



if ($op == 3) :
	$idj = $_REQUEST["idj"];
	$idp = $_REQUEST["idp"];
	$iddd = $_REQUEST["iddd"];
	$idg = $_REQUEST["idg"];
	$IDB = $_REQUEST["IDB"];
	$tablaID = $_REQUEST["tablaID"];
	session_start();
	$tp = 0;
	if (isset($_SESSION['tb_session']))
		$tp = $_SESSION['tb_session'];
	else
		$tp = 0;
	$actualizado = $_REQUEST["actualiza"];
	$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd  where Estatus=1 and grupo=" . $idg . " and IDDD=" . $iddd);
	$row4 = mysqli_fetch_array($result3);
	$col = explode('|', $row4['Columnas']);
	$resultp = mysqli_query($GLOBALS['link'], "SELECT Valores,actualizado FROM _configuracionjugadabb where IDJ=" . $idj . " and IDP=" . $idp . " and IDDD=" . $iddd . " and Grupo=" . $idg . " and actualizado<>$actualizado and IDB=$IDB");
	//echo ("SELECT Valores,actualizado FROM _configuracionjugadabb where IDJ=".$idj." and IDP=".$idp." and IDDD=".$iddd." and Grupo=".$idg." and actualizado=1 and IDB=$IDB");
	//if ($row['actualizado']==1):

	if (mysqli_num_rows($resultp) != 0) :
		$row = mysqli_fetch_array($resultp);
		$valoresdd = explode('|', $row['Valores']);
		$vdlo = '';
		$vdy = '';
		$dex = '';
		$vdy2 = '';
		$dex2 = '';
		$nuevoLogro = 0;

		$key = strpos($row4['Columnas'], 'Ax');
		if ($key === false) : $eAB = false;
		else : $eAB = true;
		endif;

		if ($tp != 0) :
			$lisAUTO = array();
			$resultnk = mysqli_query($GLOBALS['link'], "Select * from _agendaNT where Grupo=$idg and IDB=$IDB and idj=$idj");
			if (mysqli_num_rows($resultnk) != 0) :
				$rownk = mysqli_fetch_array($resultnk);
				$lisAUTO = explode(',', $rownk['IDDDs']);
			else :
				$tp = 0;
			endif;
			$busIDDS = array_search($iddd, $lisAUTO);

			if ($rownk['apptbls'] != null)
				$appIDDD = explode(',', $rownk['apptbls']);
			else
				$appIDDD = array();

			if (count($appIDDD) != 0) {
				if (array_search($iddd, $appIDDD) === false) $busIDDS = false;
			}

			if ($busIDDS !== false) :
				if ($nuevoLogro == 0) :
					switch (count($valoresdd)) {

						case 3:
							if ($valoresdd[1] < 0 && $valoresdd[0] < 0) :
								if ($valoresdd[0] < $valoresdd[1]) :
									$LogroM = $valoresdd[0];
									$macho = 0;
								else :
									$LogroM = $valoresdd[1];
									$macho = 1;
								endif;

							else :
								if ($valoresdd[1] < 0) :
									$LogroM = $valoresdd[1];
									$macho = 1;
								else :
									$LogroM = $valoresdd[0];
									$macho = 0;
								endif;
							endif;
							$modo = 3;
							break;

						case 5:
							//-130|1.5|110|-1.5|
							if ($valoresdd[2] < 0 && $valoresdd[0] < 0) :
								if ($valoresdd[0] < $valoresdd[2]) :
									$LogroM = $valoresdd[0];
									$macho = 0;
								else :
									$LogroM = $valoresdd[2];
									$macho = 2;
								endif;
							else :
								if ($valoresdd[2] < 0) :
									$LogroM = $valoresdd[2];
									$macho = 2;
								else :
									$LogroM = $valoresdd[0];
									$macho = 0;
								endif;
							endif;
							$modo = 5;
							break;
					}
					$arrayNOdds = DBconver(1, $LogroM, $modo, $macho, $eAB, $tablaID);
				/*if ($eAB):
					echo $LogroM;
					print_r($arrayNOdds);
					endif;*/
				endif;
			else :
				$tp = 0;
			endif;
		endif;
		for ($ii = 0; $ii <= count($valoresdd) - 2; $ii++) {
			$valorss = $valoresdd[$ii];
			$lgo = $valoresdd[$ii];
			$subcol = explode('-', $col[$ii]);
			$pos = strpos($subcol[1], 'car');
			if ($pos === false) :
				if (abs($valorss) <= 99) :
					$valordysplay = $valorss;
					$r = fmod($valoresdd[$ii], 1);
				else :
					$valordysplay = $valorss / 10;
					$r = fmod($valoresdd[$ii], 10);
				endif;
			else :
				$valordysplay = $valorss;
				$valorREAL = $valorss;
				$r = fmod($valoresdd[$ii], 1);
			endif;

			if ($r != 0) :
				if ($valorss < 0) :
					$valordysplay = $valordysplay + .5;
					if ($valordysplay == 0) : $valordysplay = '-';
					endif;
				else :
					$valordysplay = ($valordysplay - .5);
				endif;
				$valordysplay = $valordysplay . "&frac12;";
			endif;
			$anexo = '';
			if ($valorss > 0) :
				$anexo = '+';
			endif;
			$valordysplay = $anexo . $valordysplay;
			$valorsss = $valordysplay;
			$stl = true;
			if (count($subcol) == 1) :
				$nomc = $col[$ii];
			else :
				if ($pos == 0) :
					$stl = false;
				endif;
				$nomc = $subcol[1];
			endif;

			if ($stl) :


				if ($tp != 0) :


					if ($arrayNOdds[$nuevoLogro] == 0) :
						$nuevoLogro++;
						$vdy .= $arrayNOdds[$nuevoLogro] . '%';
						$vdlo .= $arrayNOdds[$nuevoLogro] . '%';
					else :
						$vdy .= $arrayNOdds[$nuevoLogro] . '%';
						$vdlo .= $arrayNOdds[$nuevoLogro] . '%';
						$nuevoLogro++;
					endif;



				else :
					$vdlo = $vdlo . $lgo . '%';
					$vdy = $vdy . $valordysplay . '%';
				endif;




			else :
				$dex = $dex . $row4['AddTicket'] . '|' . $valordysplay . '%';
				$vdy2 = $vdy2 . $valordysplay . '%';
				$dex2 = $dex2 . $valorREAL . '%';
			endif;
		}

		$arr = array($vdy, $vdlo, $vdy2, $dex, $row['actualizado'], $dex2);
		/*  echo $vdy.'$'.$vdlo.'$'.$vdy2.'$'.$dex; */
		echo json_encode($arr);
	else :
		$arr = array(-2);
		echo json_encode($arr);
	endif;



endif;



if ($op == 4) :

	$serial = $_REQUEST["serial"];

	echo json_encode(resstruc_tick($serial));

endif;

if ($op == 5) :
	$rndusr = $_COOKIE['rndusr'];
	$data = getParamUser($rndusr, $GLOBALS['link']);
	$serial = $_REQUEST["serial"];
	$opadmon = $_REQUEST["opadmon"];
	$idc = $data['IDC'] ?? "GEN";
	$idAuth = '0';
	$ip = getip();
	if (empty($ip) || !preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $ip)) : $ip = $_SERVER["REMOTE_ADDR"];
	endif;

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb  where serial=" . $serial);
	$row4 = mysqli_fetch_array($result);
	$IDCR = $row4['IDC'];
	$ap = $row4['ap'];
	$idj = $row4['IDJ'];
	$MYIDC = $row4['IDC'];
	$MYAP = $row4['ap'];

	$hora = convertirMilitar(Horareal($GLOBALS['minutosh'], "h:i:s A"));
	$horaT = convertirMilitar($row4['hora']);
	$fecha = Fechareal($GLOBALS['minutosh'], 'd/n/Y');

	$result7 = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb  where IDJ=" . $row4['IDJ']);
	$row7 = mysqli_fetch_array($result7);
	$jud = $row4['Jugada'];
	$fecha1 = $row7['Fecha'];

	$jgdad = explode('*', $jud);
	$cerrado = true;
	for ($u = 0; $u <= count($jgdad) - 2; $u++) {
		$opcion = explode('|', $jgdad[$u]);
		$logro = $opcion[1];
		$opcion1 = explode('%', $opcion[0]);
		$carr = $opcion1[1];
		$opcion2 = explode('-', $opcion1[0]);
		$equi = $opcion2[0];
		$iddd = $opcion2[1];

		if ($row4['Grupo'] == 1) :
			$opcion2 = explode(' ', $opcion[1]);
			$opcionv = $opcion2[0];
			$logro = $opcion2[1];
			$opcion2 = explode('-', $opcion[0]);
			$part = $opcion2[0];
			$iddd = $opcion2[1];
		endif;


		$result2 = mysqli_query($GLOBALS['link'], "Select * From _partidosbb Where (IDE1=" . $equi . " or IDE2=" . $equi . ") and IDJ=" . $row4['IDJ']);
		$row2 = mysqli_fetch_array($result2);

		// else:
		// if (diferenciadehoras2($fecha1,$row2['Hora'],$fecha,$hora)):
		// echo 'HAY DIFERENCIA **'.$fecha1.','.$row2['Hora'].','.$fecha.','.$hora.'<br>';
		// else:
		// 	echo 'NO HAY DIFERENCIA **'.$fecha1.','.$row2['Hora'].','.$fecha.','.$hora.'<br>';
		// endif;
		if (diferenciadehoras2($fecha1, $row2['Hora'], $fecha, $hora)) :
			$cerrado = false;
			break;
		endif;
		$result3 = mysqli_query($GLOBALS['link'], "Select * From _cierrebb Where IDP=" . $row2['IDP'] . " and IDJ=" . $row4['IDJ']);
		if (mysqli_num_rows($result3) != 0) :
			$cerrado = false;
			// echo json_encode(array('status' => 1, 'id' => $idAuth));
			// exit;
			break;

		endif;
		// endif;


	}
	// $cerrado = true;
	///TOKENT:ADD FOR ACCEPT TOKENT SUCCESS
	// if (false) :
	if ($opadmon == 1) :
		if (isset($_REQUEST["tipousu"])) :
			if ($_REQUEST["tipousu"] == "-2") :
				$cerrado = true;
			endif;
		else :
			if (!$cerrado) :
				$rndusr = $_COOKIE['rndusr'];
				$result2 = mysqli_query($GLOBALS['link'], "Select * From _tusu Where Tipo=2 and Asociado='-2' and bloqueado=" . $rndusr);
				if (mysqli_num_rows($result2) == 0) :
					$cerrado = false;
					echo json_encode(array('status' => 1, 'id' => $idAuth));
					exit;
				else:
					$cerrado = true;
				endif;
			// if (vericToken($rndusr)) {
			// 	$cerrado = true;
			// } else {
			// 	$idAuth = viewIDReG($rndusr);
			// 	$cerrado = false;
			// }
			endif;
		endif;
	endif;
	///TOKENT:ADD FOR ACCEPT TOKENT SUCCESS
	if ($cerrado == true) :
		if ($opadmon == 1) :
			$result = mysqli_query($GLOBALS['link'], "Update _tjugadabb set Activo=2,hc='" . date("h:i:s A") . "-" . $ip . "-Admin' where serial=" . $serial);
			$ResponseCredito = BackendCredito($MYIDC, $serial, $MYAP, $TYPE_REVERSO);
			$estado = 0;
		else :
			$result_c = mysqli_query($GLOBALS['link'], 'Select cmaxelim,Eminutos from _tconsecionariodd where IDC="' . $row4['IDC'] . '"');
			if (mysqli_num_rows($result_c) != 0) :
				$row2 = mysqli_fetch_array($result_c);
				$result_b = mysqli_query($GLOBALS['link'], 'Select count(serial) as nde from _tjugadabb where Idj=' . $row4['IDJ'] . ' and IDC="' . $row4['IDC'] . '" and activo=2');
				$row1 = mysqli_fetch_array($result_b);

				if ($row2['cmaxelim'] != 0) :
					if ($row1['nde'] < $row2['cmaxelim']) :
						if ($row2['Eminutos'] == 0) :
							$result = mysqli_query($GLOBALS['link'], "Update _tjugadabb set Activo=2,hc='" . Horareal($GLOBALS['minutosh'], "h:i:s A") . "-" . $ip . "-" . $idc . "' where serial=" . $serial);
							$ResponseCredito = BackendCredito($MYIDC, $serial, $MYAP, $TYPE_REVERSO);
							$estado = 0;
						else :
							$minutosTrans = abs(calculodeMinutos('1/1/2010', $horaT, convertirMilitar(Horareal($GLOBALS['minutosh'], "h:i:s A"))));
							//echo $hora.'<br>';echo Horareal($GLOBALS['minutosh'],"h:i:s A").'<br>';echo $minutosTrans.'<br>';echo $row2['Eminutos'].'<br>';
							if ($minutosTrans <= $row2['Eminutos']) :
								$result = mysqli_query($GLOBALS['link'], "Update _tjugadabb set Activo=2,hc='" . Horareal($GLOBALS['minutosh'], "h:i:s A") . "-" . $ip . "-" . $idc . "' where serial=" . $serial);
								$ResponseCredito = BackendCredito($MYIDC, $serial, $MYAP, $TYPE_REVERSO);
								$estado = 0;
							else :
								$estado = 3;
							endif;
						endif;
					else :
						$estado = 2;
					endif;
				else :
					$minutosTrans = abs(calculodeMinutos('1/1/2010', $horaT, convertirMilitar(Horareal($GLOBALS['minutosh'], "h:i:s A"))));
					if ($minutosTrans <= $row2['Eminutos']) :
						$result = mysqli_query($GLOBALS['link'], "Update _tjugadabb set Activo=2,hc='" . Horareal($GLOBALS['minutosh'], "h:i:s A") . "-" . $ip . "-" . $idc . "' where serial=" . $serial);
						$ResponseCredito = BackendCredito($MYIDC, $serial, $MYAP, $TYPE_REVERSO);
						$estado = 0;
					else :
						$estado = 3;
					endif;

				endif;

			else :

				$result = mysqli_query($GLOBALS['link'], "Update _tjugadabb set Activo=2,hc='" . Horareal($GLOBALS['minutosh'], "h:i:s A") . "-" . $ip . "-" . $idc . "' where serial=" . $serial);
				$ResponseCredito = BackendCredito($MYIDC, $serial, $MYAP, $TYPE_REVERSO);


				$estado = 0;

			endif;

		endif;

	else :

		$estado = 1;

	endif;




	echo json_encode(array('status' => $estado, 'id' => $idAuth));

endif;



// if ($op==5):
// 	$serial=$_REQUEST["serial"];
// 	$opadmon=$_REQUEST["opadmon"];
// 	$idc=$_REQUEST["idc"];


// 	$result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tjugadabb  where serial=".$serial);
// 	$row4 = mysqli_fetch_array($result);
// 	$hora = convertirMilitar($row4['hora']);$fecha= Fechareal($GLOBALS['minutosh'],'d/n/Y');

// 	$result7 = mysqli_query($GLOBALS['link'],"SELECT * FROM _jornadabb  where IDJ=".$row4['IDJ']);
// 	$row7 = mysqli_fetch_array($result7);
// 	$jud=$row4['Jugada'];$fecha1=$row7['Fecha'];

// 	$jgdad=explode('*',$jud);
// 	$cerrado=true;
// 	for ($u=0;$u<=count($jgdad)-2;$u++){
// 	 $opcion=explode('|',$jgdad[$u]);
// 	 $logro=$opcion[1];
// 	 $opcion1=explode('%',$opcion[0]);
// 	 $carr=$opcion1[1];
// 	 $opcion2=explode('-',$opcion1[0]);
// 	 $equi=$opcion2[0];
// 	 $iddd=$opcion2[1];

// 	if ($row4['Grupo']==1):
// 	 $opcion2=explode(' ',$opcion[1]);
// 	 $opcionv=$opcion2[0];
// 	 $logro=$opcion2[1];
// 	 $opcion2=explode('-',$opcion[0]);
// 	 $part=$opcion2[0];
// 	 $iddd=$opcion2[1];
// 	endif;



// 		$result2 = mysqli_query($GLOBALS['link'],"Select * From _partidosbb Where (IDE1=".$equi." or IDE2=".$equi.") and IDJ=".$row4['IDJ']);
// 		$row2 = mysqli_fetch_array($result2);
// 		$result3 = mysqli_query($GLOBALS['link'],"Select * From _cierrebb Where IDP=".$row2['IDP']." and IDJ=".$row4['IDJ']);
// 	    if(mysqli_num_rows($result3)!=0):
// 		 $cerrado=false;
// 		 break;
// 		else:
// 		 if (diferenciadehoras2($fecha1,$row2['Hora'],$fecha,$hora)):
// 		  $cerrado=false;
// 		  break;
// 		 endif;
// 		endif;


// 	}

//  if ($cerrado==true):
//   if ($opadmon==1):
// 		$result = mysqli_query($GLOBALS['link'],"Update _tjugadabb set Activo=2,hc='".date("h:i:s A")."' where serial=".$serial);
// 	    $estado=0;
//   else:
//     $result_c = mysqli_query($GLOBALS['link'],'Select cmaxelim,Eminutos from _tconsecionariodd where IDC="'.$row4['IDC'].'"');
// 	   if(mysqli_num_rows($result_c)!=0):
// 		   $row2 = mysqli_fetch_array($result_c);
// 	 	   $result_b = mysqli_query($GLOBALS['link'],'Select count(serial) as nde from _tjugadabb where Idj='.$row4['IDJ'].' and IDC="'.$row4['IDC'].'" and activo=2');
// 	       $row1 = mysqli_fetch_array($result_b);

//            if ($row2['cmaxelim']!=0):
// 			if ($row1['nde']<$row2['cmaxelim']):
// 			   if ($row2['Eminutos']==0):
// 				$result = mysqli_query($GLOBALS['link'],"Update _tjugadabb set Activo=2,hc='".Horareal($GLOBALS['minutosh'],"h:i:s A")."' where serial=".$serial);
// 			    $estado=0;
// 			   else:
// 			  	    $minutosTrans=abs(calculodeMinutos('1/1/2010',$hora,convertirMilitar(Horareal($GLOBALS['minutosh'],"h:i:s A")) ));
// 					//echo $hora.'<br>';echo Horareal($GLOBALS['minutosh'],"h:i:s A").'<br>';echo $minutosTrans.'<br>';echo $row2['Eminutos'].'<br>';
// 					if ($minutosTrans<=$row2['Eminutos']):
// 						$result = mysqli_query($GLOBALS['link'],"Update _tjugadabb set Activo=2,hc='".Horareal($GLOBALS['minutosh'],"h:i:s A")."' where serial=".$serial);
// 			    		$estado=0;
// 					else:
// 						$estado=3;
// 					endif;
// 			   endif;
// 			else:
// 				$estado=2;
// 	    	endif;
// 		   else:
// 		   	        $minutosTrans=abs(calculodeMinutos('1/1/2010',$hora,convertirMilitar(Horareal($GLOBALS['minutosh'],"h:i:s A"))));
// 					if ($minutosTrans<=$row2['Eminutos']):
// 						$result = mysqli_query($GLOBALS['link'],"Update _tjugadabb set Activo=2,hc='".Horareal($GLOBALS['minutosh'],"h:i:s A")."' where serial=".$serial);
// 			    		$estado=0;
// 					else:
// 						$estado=3;
// 					endif;

// 		   endif;

// 		else:

// 			$result = mysqli_query($GLOBALS['link'],"Update _tjugadabb set Activo=2,hc='".date("h:i:s A")."' where serial=".$serial);

// 		    $estado=0;

// 		endif;

//    endif;

//  else:

//   $estado=1;

//  endif;





// 	echo json_encode($estado);

// endif;


if ($op == 6) :
	$idj = $_REQUEST["idj"];
	$grupo = $_REQUEST["grupo"];
	$IDB = $_REQUEST["IDB"];
	$opp = 0;

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbpublicaciones  where idj=" . $idj . " and grupo=" . $grupo . " and IDB=$IDB");
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);

		if ($row['Publicar'] == 1) :
			$opp = 2;
			$result = mysqli_query($GLOBALS['link'], "Update _tbpublicaciones set Publicar=2 where idj=" . $idj . " and grupo=" . $grupo . " and IDB=$IDB");
			////
			$result = mysqli_query($GLOBALS['link'], "Delete  from listactualiza where  idj=" . $idj . " and grupo=" . $grupo . " and IDB=$IDB");
		else :
			$opp = 1;
			$result = mysqli_query($GLOBALS['link'], "Update _tbpublicaciones set Publicar=1,Actualiza=Actualiza+1 where idj=" . $idj . " and grupo=" . $grupo . " and IDB=$IDB");
		endif;
	else :
		$opp = 1;
		$result = mysqli_query($GLOBALS['link'], "INSERT _tbpublicaciones  VALUES (" . $idj . "," . $grupo . ",1,'" . date("d/m/y") . "',$IDB,0)");
	endif;

	echo json_encode($opp);
endif;

if ($op == 7) :
	$idj = $_REQUEST["idj"];
	$idu = $_REQUEST["idu"];
	$listac[] = Horareal($GLOBALS['minutosh'], 'H:i:s');

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb where  IDj=" . $idj . " and IDP NOT IN  (select IDP FROM _cierrebb where IDj=" . $idj . " )");

	if (mysqli_num_rows($result) != 0) :
		$horaactual = explode(':', Horareal($GLOBALS['minutosh'], 'H:i'));
		while ($row = mysqli_fetch_array($result)) {
			$hdp = explode(':', $row['Hora']);
			if (($hdp[0] - $horaactual[0]) == 0) :
				if (($hdp[1] - $horaactual[1]) == 0) :
					$listac[] = $row['IDP'];
					$a = cierredebb($idj, $row['IDP'], $row['Grupo'], $idu);
				else :
					if (($hdp[1] - $horaactual[1]) < 0) :
						$listac[] = $row['IDP'];
						$a = cierredebb($idj, $row['IDP'], $row['Grupo'], $idu);
					endif;
				endif;
			else :
				if (($hdp[0] - $horaactual[0]) < 0) :
					$listac[] = $row['IDP'];
					$a = cierredebb($idj, $row['IDP'], $row['Grupo'], $idu);
				endif;
			endif;
		}

	endif;

	echo json_encode($listac);

endif;


if ($op == 8) :
	/* $horaactual=explode(':',Horareal($horasretro,'H:i'));
		print_r( $horaactual);*/
	$idp = $_REQUEST["idp"];
	$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrebb where IDP=" . $idp);
	if (mysqli_num_rows($resultp) != 0) :
		echo json_encode(true);
	else :
		$resultadodecierre = false;
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb where  IDP=" . $idp);
		if (mysqli_num_rows($result) != 0) :
			$horaactual = explode(':', Horareal($horasretro, 'H:i'));

			$row = mysqli_fetch_array($result);
			$hdp = explode(':', $row['Hora']);
			if (($hdp[0] - $horaactual[0]) == 0) :
				if (($hdp[1] - $horaactual[1]) == 0) :
					$resultadodecierre = true;
				else :
					if (($hdp[1] - $horaactual[1]) < 0) :
						$resultadodecierre = true;
					endif;
				endif;
			else :
				if (($hdp[0] - $horaactual[0]) < 0) :
					$resultadodecierre = true;
				endif;
			endif;
		endif;
		if ($resultadodecierre) : $a = cierredebb($row['IDJ'], $idp, $row['Grupo'], '-2');
		endif;
		echo json_encode($resultadodecierre);
	endif;


endif;


if ($op == 9) :
	$serial = $_REQUEST["serial"];
	$se = $_REQUEST["se"];
	$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb where Serial=" . $serial);
	$row = mysqli_fetch_array($resultp);
	if ($row['se'] == $se) :
		$result = mysqli_query($GLOBALS['link'], "Update _tjugadabb set pagado=1,fechapagado='" . Horareal(4, 'H:i') . ' ' . Fechareal(4, 'd/n/Y') . "' where serial=" . $serial);
		echo json_encode(true);
	else :
		echo json_encode(false);
	endif;
endif;
if ($op == 11) :
	$opcion = false;
	if (isset($_REQUEST["IDusu"])) :
		$IDusu = $_REQUEST["IDusu"];
		$idj = $_REQUEST["idj"];
		$idg = $_REQUEST["idg"];
		$IDB = $_REQUEST["IDB"];
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbpublicaciones where IDJ=" . $idj . " and Grupo=" . $idg . " and IDB=$IDB");
		if (mysqli_num_rows($result) != 0) :
			$row3 = mysqli_fetch_array($result);
			if ($row3['Publicar'] == 1) :
				if ($row3['Actualiza'] == 0) :
					$opcion = true;
				else :
					$resultchk = mysqli_query($GLOBALS['link'], "SELECT * FROM  listactualiza Where IDusu=$IDusu and  IDJ=" . $idj . " and Grupo=" . $idg . " and IDB=$IDB");
					//echo ("SELECT * FROM  listactualiza Where IDusu=$IDusu and  IDJ=".$idj." and Grupo=".$idg." and IDB=$IDB");
					if (mysqli_num_rows($resultchk) == 0) :
						// $resultchk = mysqli_query($GLOBALS['link'],"Insert listactualiza (IDJ,Grupo,IDusu,IDB) values ($idj,$idg,$IDusu,$IDB)");
						$opcion = false;
					else :
						$opcion = true;
					endif;
				endif;

			endif;
		endif;
	endif;
	echo json_encode($opcion);
endif;

if ($op == 12) :
	$IDC = $_REQUEST["IDC"];

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbstandarxparlay ");
	while ($row = mysqli_fetch_array($result))
		$result2 = mysqli_query($GLOBALS['link'], "Update _tbrestriccionesxparlay  set MontodeVenta=" . $row['MontodeVenta'] . " where Cantidad=" . $row['Cantidad'] . " and IDC='$IDC'");

	echo json_encode(true);
endif;

if ($op == 13) :
	$usuario = $_REQUEST["usu"];
	$clave = $_REQUEST["pwdnew"];
	$result = mysqli_query($GLOBALS['link'], "Select * from _tusu  where usuario='$usuario' ");
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$rnd = rand(1, 32560);
		$result2 = mysqli_query($GLOBALS['link'], "Update _tusu  set clave='$clave',bloqueado=$rnd where usuario='$usuario'");
		Logs($row['IDusu'], -1, 'Cambio de Clave', 1);
		echo json_encode($result2);
	else :
		echo json_encode(false);

	endif;
endif;

if ($op == 14) :
	$usuario = $_REQUEST["usu"];
	$clave = $_REQUEST["pwdnew"];
	$result2 = mysqli_query($GLOBALS['link'], "Select * from _tusu  where usuario='$usuario' and clave='$clave'");

	if (mysqli_num_rows($result2) != 0) :
		echo json_encode(true);
	else :
		echo json_encode(false);
	endif;
endif;
if ($op == 20) :
	$idj = intval($_REQUEST["idj"]);
	$grupo = explode(",", $_REQUEST["grupo"]);
	if (count($grupo) == 0 || $grupo[0] == "") {
		echo json_encode(true);
		exit;
	}
	$result = mysqli_query(
		$link,
		"UPDATE _tbpubliresultados  set Publicar=2 where idj=$idj "
	);
	$list_Check = [];
	for ($s = 0; $s < count($grupo); $s++) {
		$check_grupo = intval($grupo[$s]);
		if ($check_grupo != 0) {
			$result = mysqli_query(
				$link,
				"SELECT * FROM _tbpubliresultados  where idj=$idj and grupo = $check_grupo"
			);
			if (mysqli_num_rows($result) == 0) {
				$result = mysqli_query(
					$link,
					"INSERT _tbpubliresultados  VALUES (" .
						$idj .
						"," .
						$check_grupo .
						",1,'" .
						date("d/m/y") .
						"')"
				);
				$list_Check[] = $result;
				continue;
			}
			$result = mysqli_query(
				$link,
				"Update _tbpubliresultados set Publicar=1 where idj=" .
					$idj .
					" and grupo=" .
					$check_grupo
			);
			$list_Check[] = $result;
		}
	}
	$result = mysqli_query(
		$link,
		"SELECT * FROM _jornadabb where idj=$idj Group by Grupo"
	);
	$row = mysqli_fetch_array($result);
	$fecha = $row['Fecha'];
	$cuanto_jornada = mysqli_num_rows($result);
	$result = mysqli_query(
		$link,
		"SELECT * FROM _tbpubliresultados where idj=$idj and Publicar=1 "
	);
	$cuanto_publicacion = mysqli_num_rows($result);

	$result = mysqli_query($link, "SELECT * FROM _tbcierresemana  where idj=" . $idj);
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		if ($cuanto_jornada == $cuanto_publicacion) :
			$result = mysqli_query(
				$link,
				"Update  _tjugadabb  set  escrute='' where  idj=" . $idj
			);
		// $result = mysqli_query($link,"Update _tbcierresemana set Cierre=2 where idj=".$idj);
		else :
			$result = mysqli_query(
				$link,
				"Update _tbcierresemana set Cierre=2 where idj=" . $idj
			);
		endif;
	//echo $cuanto_jornada.'<br>';echo $cuanto_publicacion.'<br>';
	else :
		if ($cuanto_jornada == $cuanto_publicacion) :
			$result = mysqli_query(
				$link,
				"Update  _tjugadabb  set  escrute='' where  idj=" . $idj
			);
			$result = mysqli_query(
				$link,
				"INSERT _tbcierresemana (IDJ,Cierre) VALUES (" . $idj . ",1)"
			);
		endif;
	endif;

	escrute_ALL($fecha);
	// acredit_all($idj, 1);

	echo json_encode(count($grupo) == count($list_Check));
endif;
if ($op == 202) :
	$idj = intval($_REQUEST["idj"]);
	$grupo = intval($_REQUEST["grupo"]);
	$result = mysqli_query(
		$link,
		"UPDATE _tbpubliresultados  set Publicar=2 where idj=$idj and Grupo=$grupo "
	);
	$result = mysqli_query(
		$link,
		"SELECT * FROM _jornadabb where idj=$idj Group by Grupo"
	);
	$row = mysqli_fetch_array($result);
	$fecha = $row['Fecha'];

	escrute_ALL($fecha);
	// acredit_all($idj, 1);

	echo json_encode($result);
endif;
if ($op == 21) :
	$idj = $_REQUEST["idj"];
	$grupo = $_REQUEST["grupo"];

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbpubliresultados  where idj=" . $idj . " and grupo=" . $grupo);
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);

		if ($row['Publicar'] == 1) :
			$permite = false;
		else :
			$permite = true;
		endif;
	else :
		$permite = true;
	endif;



	echo json_encode($permite);

endif;
if ($op == 221) :
	$data = $_REQUEST["data"];
	$search = ["\\", "[", "]", "\""];
	$xdata = explode(",", str_replace($search, "", $data));
	$Response = ['state' => true, 'publicresul' => false, 'closeplay' => true, 'codeerror' => 0];
	$IDP = $_REQUEST["idp"];
	$activo	= json_decode($_REQUEST["activo"]);
	$result = mysqli_query($link, "SELECT * FROM _partidosbb  where IDP=$IDP");
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$IDJ = $row['IDJ'];
		$Grupo	= $row['Grupo'];
		$result = mysqli_query(
			$link,
			"SELECT * FROM _tbpubliresultados  where idj=$IDJ and grupo=$Grupo"
		);
		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			if ($row["Publicar"] == 1) :
				$Response['state'] = false;
				$Response['publicresul'] = true;
				$Response['codeerror'] = 1;
				echo json_encode($Response);
				exit;
			endif;
		endif;
		$result = mysqli_query(
			$link,
			"SELECT * FROM _cierrebb where IDJ=$IDJ  and IDP=$IDP and Grupo=$Grupo"
		);
		if (mysqli_num_rows($result) == 0) :
			$Response['state'] = false;
			$Response['closeplay'] = false;
			$Response['codeerror'] = 2;
			echo json_encode($Response);
			exit;
		endif;
		$juego_completo = 0;
		$new_data = [];
		for ($i = 0; $i < count($xdata); $i += 2) {

			if (trim($xdata[$i]) == 'jc') {
				$juego_completo = trim($xdata[$i + 1]);
				continue;
			}
			$new_data[] = trim($xdata[$i]);
			if (!$activo) {
				$new_data[] = '!-!-';
				continue;
			}
			$new_data[] = trim($xdata[$i + 1] . '-');
		}
		$Escrute = implode("|", $new_data);

		$result = mysqli_query(
			$link,
			"SELECT * FROM _tbescrute where IDP = $IDP"
		);
		$h = Horareal($minutosh, "h:i:s A");
		$f = Fechareal($minutosh, "d-m-y");
		$sql = "";
		if (mysqli_num_rows($result) == 0) :
			$sql = "Insert _tbescrute (`IDP`, `Grupo`, `Fecha`, `Hora`, `Escrute`, `IDJ`, `juegocompleto`) values ($IDP,$Grupo,'$f','$h','$Escrute|',$IDJ,$juego_completo)";
		else :
			$sql = "Update _tbescrute set Fecha='$f',Hora='$h',Escrute='$Escrute|',juegocompleto=$juego_completo where IDP=$IDP";
		endif;

		$result = mysqli_query($link, $sql);
		$Response['state'] = $result;
		$Response['codeerror'] = $result ? 0 : 4;

	else :
		$Response['state'] = false;
		$Response['codeerror'] = 3;
		echo json_encode($Response);
		exit;
	endif;
	echo json_encode($Response);
	exit;
endif;
if ($op == 30) :
	$IDJ = $_REQUEST['IDJ'];
	escrutesticket($IDJ, $_REQUEST['accesogp'], $_REQUEST['grupo']);
endif;

if ($op == 31) :
	$permite = false;
	$nivel = $_REQUEST['nivel'];
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM listaclaves  where nivel=$nivel");
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);

		if (trim($_REQUEST['clave']) == $row['clave']) :
			$permite = true;
		else :
			$permite = false;
		endif;
	endif;
	echo json_encode($permite);
endif;
if ($op == 32) :
	$noCombinar = explode('-', $_REQUEST['noCombinar']);
	$porDerecho = explode('-', $_REQUEST['porDerecho']);
	$IDC = $_REQUEST['IDC'];
	$IDG = $_REQUEST['IDG'];

	if ($IDC == '0' && $IDG == 0) :
		for ($i = 0; $i <= count($noCombinar) - 2; $i++) {
			$verDatos = explode('*', $noCombinar[$i]);
			$result = mysqli_query($GLOBALS['link'], "Update _tbjuegodd  set noCombinar='" . $verDatos[1] . "' Where IDDD=" . $verDatos[0]);
		}



	else :
		for ($i = 0; $i <= count($noCombinar) - 2; $i++) {
			$verDatos = explode('*', $noCombinar[$i]);
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbreglas_1  Where IDC='$IDC' and IDG=$IDG and IDDD=" . $verDatos[0]);
			if (mysqli_num_rows($result) != 0) :
				$result = mysqli_query($GLOBALS['link'], "Update _tbreglas_1  set noCombinar='" . $verDatos[1] . "' Where IDC='$IDC' and IDG=$IDG and IDDD=" . $verDatos[0]);
			else :
				$result = mysqli_query($GLOBALS['link'], "Insert  _tbreglas_1 (IDDD,IDC,IDG,noCombinar) values (" . $verDatos[0] . ",'$IDC',$IDG,'" . $verDatos[1] . "')");
			endif;
		}


	endif;
	$result2 = true;
	for ($i = 0; $i <= count($porDerecho) - 2; $i++) {
		$verDatos = explode('*', $porDerecho[$i]);
		$valores = explode('|', $verDatos[1]);
		if ($valores[0] != 0 || $valores[1] != 0) :
			$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbreglas_1  Where IDC='$IDC' and IDG=$IDG and IDDD=" . $verDatos[0]);

			if (mysqli_num_rows($result2) != 0) :
				$result2 = mysqli_query($GLOBALS['link'], "Update _tbreglas_1  set monto=" . $valores[0] . ",bloqueo=" . $valores[1] . " Where IDC='$IDC' and IDG=$IDG  and IDDD=" . $verDatos[0]);
			else :
				$result2 = mysqli_query($GLOBALS['link'], "Insert  _tbreglas_1 (IDDD,IDC,IDG,monto,bloqueo) values (" . $verDatos[0] . ",'$IDC',$IDG," . $valores[0] . "," . $valores[1] . ")");
			endif;
		endif;
	}



	echo json_encode($result && $result2);

endif;

if ($op == 33) :
	$IDC = $_REQUEST['IDC'];
	$IDG = $_REQUEST['IDG'];
	$Grupo = $_REQUEST['Grupo'];
	$Minimas = $_REQUEST['Minimas'];
	$Maximas = $_REQUEST['Maximas'];
	$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbreglas_2  Where IDC='$IDC' and IDG=$IDG and Grupo=$Grupo");

	if (mysqli_num_rows($result2) != 0) :
		$result2 = mysqli_query($GLOBALS['link'], "Update _tbreglas_2  set Minimas=$Minimas,Maximas=$Maximas Where IDC='$IDC' and IDG=$IDG and Grupo=$Grupo");
	else :
		$result2 = mysqli_query($GLOBALS['link'], "Insert  _tbreglas_2 (IDC,IDG,Grupo,Minimas,Maximas) values ('$IDC',$IDG,$Grupo,$Minimas,$Maximas)");

	endif;

	echo json_encode($result2);

endif;

///TOKENT:ADD FOR ACCEPT TOKENT SUCCESS
if ($op == 34) :
	$rndusr = $_COOKIE['rndusr'];
	echo json_encode(array('status' => acceptTocket($rndusr)));
endif;
if ($op == 35) :
	$idusu = $_REQUEST['idusu'];
	$q = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu_ext  Where IDusu=$idusu");
	$dark = 1;
	if (mysqli_num_rows($q) != 0) :
		$row = mysqli_fetch_array($q);
		$dark = $row['dark'] == 1 ? 0 : 1;
		$q = mysqli_query($GLOBALS['link'], "Update _tusu_ext  set dark=$dark Where IDusu=$idusu");
	else :
		$q = mysqli_query($GLOBALS['link'], "Insert  _tusu_ext (IDusu,dark) values ($idusu,$dark)");
	endif;
	echo json_encode($dark);

endif;
if ($op == 36) :
	$idusu = $_REQUEST['idusu'];
	$q = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu_ext  Where IDusu=$idusu");
	$isdecimalparlay = 1;
	if (mysqli_num_rows($q) != 0) :
		$row = mysqli_fetch_array($q);
		$isdecimalparlay = $row['isdecimalparlay'] == 1 ? 0 : 1;
		$q = mysqli_query($GLOBALS['link'], "Update _tusu_ext  set isdecimalparlay=$isdecimalparlay Where IDusu=$idusu");
	else :
		$q = mysqli_query($GLOBALS['link'], "Insert  _tusu_ext (IDusu,dark,isdecimalparlay) values ($idusu,0,$isdecimalparlay)");
	endif;
	echo json_encode($isdecimalparlay);

endif;
function diferenciadehoras2($fecha, $hora1, $fecha1, $hora2)
{
	$horaM = explode(":", $hora1);
	$fechaMK = explode("/", $fecha);
	if (!isset($horaM[2])) :
		$horaM[2] = 0;
	endif;
	$fechaMK1 = mktime(
		$horaM[0],
		$horaM[1],
		$horaM[2],
		$fechaMK[1],
		$fechaMK[0],
		$fechaMK[2]
	);

	$horaM = explode(":", $hora2);
	$fechaMK = explode("/", $fecha1);
	if (!isset($horaM[2])) :
		$horaM[2] = 0;
	endif;
	$fechaMK2 = mktime(
		$horaM[0],
		$horaM[1],
		$horaM[2],
		$fechaMK[1],
		$fechaMK[0],
		$fechaMK[2]
	);

	$respuesta = $fechaMK1 <= $fechaMK2;
	return $respuesta;
}