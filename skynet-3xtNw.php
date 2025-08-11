<?
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', 'error.log');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once('prc_skynet.php');
require('prc_php.php');
require('graphql.php');
$MinutosAdd = 0;
$IDB = $_REQUEST['idb'];
//********************************************************************************//

$casino = $_REQUEST['casino'];
$ALiga = explode(',', $_REQUEST['liga']);
$aidj = array();
$aidep = array();
for ($i = 0; $i <= count($ALiga) - 1; $i++) {
	if ($ALiga[$i] != -1) :
		$code = explode('-', $ALiga[$i]);
		$aidj[] = $code[1];
		$aidep[] = $code[0];
		$param[] = $ALiga[$i] . '|' . $_REQUEST['casino'];
	endif;
}

$GLOBALS['link'] = mysqli_connect($server, $user, $clv);
mysqli_select_db($GLOBALS['link'], $db);
$skynet = mysqli_connect($server1, $user1, $clv1);
mysqli_select_db($skynet, $db1);

$result = mysqli_query($GLOBALS['link'], "Select * From _tusu Where bloqueado=" . $_COOKIE['rndusr']);
$row = mysqli_fetch_array($result);
$usercp = $row['Usuario'];

if ($casino == 0) {
	$Acasino = array();
	$result = mysqli_query($skynet, "Select * From _tbcasinoNTnw Where enabled=1");
	while ($row1 = mysqli_fetch_array($result)) {
		$Acasino[] = $row1['paid'];
	}
	$casino = join(',', $Acasino);
}


for ($i = 0; $i <= count($aidj) - 1; $i++) {
	$result = mysqli_query($skynet, "Select * From _tbjornadaNT Where idj=" . $aidj[$i]);
	$row = mysqli_fetch_array($result);
	if (substr($row['fecha'], 4, 1) == 0)
		$fecha = substr($row['fecha'], 6, 2) . '/' . substr($row['fecha'], 5, 1) . '/' . substr($row['fecha'], 0, 4);
	else
		$fecha = substr($row['fecha'], 6, 2) . '/' . substr($row['fecha'], 4, 2) . '/' . substr($row['fecha'], 0, 4);

	$gmtdt = $row['fecha'];

	$result = mysqli_query($GLOBALS['link'], "Select * From _jornadabb Where fecha='" . $fecha . "'");
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$idj = $row['IDJ'];
	else :
		$result = mysqli_query($GLOBALS['link'], "Select * From _jornadabb  order by idj DESC");
		if (mysqli_num_rows($result) == 0) :
			$idj = 1;
		else :
			$row = mysqli_fetch_array($result);
			$idj = $row['IDJ'] + 1;
		endif;
	endif;

	$result = mysqli_query($skynet, "Select * From _tbligasNTnw Where idep=" . $aidep[$i] . " and idj=" . $aidj[$i]);
	$row = mysqli_fetch_array($result);
	$nombre = $row['nombre'];
	$spid = $row['spid'];
	$lid = $row['lid'];
	$result = mysqli_query($GLOBALS['link'], "Select * From _tbligasNT Where nombre='" . trim($nombre, " \t\n\r") . "'");
	if (mysqli_num_rows($result) == 0) :
		/// Bucando los ultimos ID's
		$goCapture = false;
		$resultj = mysqli_query($skynet, "SELECT * FROM _tbligaxml Where spid=$spid");
		if (mysqli_num_rows($resultj) != 0) :
			$row = mysqli_fetch_array($resultj);
			$Tipo = $row['tipo'];
			$Firma = trim(substr($nombre, 0, 3)) . '_' . $aidep[$i] . '_';
			$Descripcion = str_replace('-', '', $nombre);
			$Ainiciales = explode(' ', $Descripcion);
			$InicTicket = $Tipo;
			$InicTicket .= substr($Ainiciales[0], 0, 5);
			for ($y = 1; $y <= count($Ainiciales) - 1; $y++) {
				$InicTicket .= ' ';
				$InicTicket .= substr($Ainiciales[$y], 0, 2);
			}
			$resultj = mysqli_query($skynet, "SELECT * FROM _TLigasNTnw Where  lid=$lid and spid=$spid");
			$row = mysqli_fetch_array($resultj);
			$img = $row['urlL'];

			$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd ORDER BY Grupo DESC");
			$row = mysqli_fetch_array($resultj);
			$ValorG = $row['Grupo'] + 1;

			$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _formatosbb ORDER BY Formato DESC");
			$row = mysqli_fetch_array($resultj);
			$Valor1 = $row['Formato'] + 1;

			$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd ORDER BY IDDD DESC");
			$row = mysqli_fetch_array($resultj);
			$ValorJ1 = $row['IDDD'] + 1;
			$ok = false;

			include('skynet-creatorDB_Nw.php');
			if ($ok) :
				echo  '<i class="far fa-check-circle" style="font-size: 18px;color:Dodgerblue;"></i> Creando el Deporte ' . $nombre . '<br>';
				mysqli_query($GLOBALS['link'], "START TRANSACTION;");

				$resultj1 = mysqli_query($GLOBALS['link'], $Grupo);
				$resultj2 = mysqli_query($GLOBALS['link'], $Formato);
				$resultj3 = mysqli_query($GLOBALS['link'], $Apuestas);
				$resultj4 = mysqli_query($GLOBALS['link'], "Insert _tbligasNT (nombre,grupo) values ('$nombre',$ValorG) ");
				for ($y = 0; $y <= count($Escrute) - 1; $y++) $resultjk = mysqli_query($GLOBALS['link'], $Escrute[$y]);

				if ($resultjk && $resultj1 && $resultj2 && $resultj3 && $resultj4) :
					mysqli_query($GLOBALS['link'], "commit");
					echo  '<i class="far fa-check-circle" style="font-size: 18px;color:Dodgerblue;"></i> Listo ' . $nombre . '<br>';
					$goCapture = true;
					$result = mysqli_query($GLOBALS['link'], "Select * From _tbligasNT Where nombre='" . trim($nombre, " \t\n\r") . "'");
				else :
					mysqli_query($GLOBALS['link'], "rollback");
					echo  '<i class="fas fa-ban" style="font-size: 18px;color:Red;"></i> Error Creando ' . $nombre . '<br>';
				endif;

			endif;
		else :
			echo  '<i class="fas fa-ban" style="font-size: 18px;color:Red;"></i> No puedo crear ' . $nombre . '<br>';
		endif;
	else :
		$goCapture = true;
	endif;
	if ($goCapture) :
		$row = mysqli_fetch_array($result);
		$Grupo = $row['grupo'];
		echo  '<i class="far fa-check-circle" style="font-size: 18px;color:Dodgerblue;"></i> Captando Deporte ' . $nombre . '<br>';

		if (intval($spid) == 2) : $order = "linea";
		else :  $order = " eid,ih,idequi,linea";
		endif;

		$result = mysqli_query($skynet, "Select * From _tbequiposNTnw Where nombre!='' and idj=" . $aidj[$i] . " and idep=" . $aidep[$i] . " order by $order ");
		// echo "Select * From _tbequiposNTnw Where nombre!='' and idj=" . $aidj[$i] . " and idep=" . $aidep[$i] . " order by $order ";
		$partidos = 0;
		$linea = 1;
		$aCode1 = array();
		$aIDE1 = array();
		$aCode2 = array();
		$aIDE2 = array();
		$n1 = array();
		$n2 = array();
		$pich1[] = array();
		$pich2[] = array();
		while ($row1 = mysqli_fetch_array($result)) {
			switch ($linea) {
				case 1:
					$aCode1[] = $row1['idequi'];
					$aIDE1[] = BuscarIDE($row1['nombre'], $Grupo, $row1['imageurl']);
					$partidos++;
					$n1[] = $row1['nombre'];
					$pich1[] = $row1['pch'];
					$linea = 2;
					break;
				case 2:
					$aCode2[] = $row1['idequi'];
					$aIDE2[] = BuscarIDE($row1['nombre'], $Grupo, $row1['imageurl']);
					$n2[] = $row1['nombre'];
					$pich2[] = $row1['pch'];
					$linea = 1;
					break;
			}
		}

		/// Crear Partidos
		$result = mysqli_query($GLOBALS['link'], "Select * From _partidosbb  order by IDP DESC");
		$row = mysqli_fetch_array($result);
		$IDP = $row['IDP'];
		$result = mysqli_query($skynet, "Select * From _tbjornada where gmdt=" . $gmtdt);
		$row = mysqli_fetch_array($result);
		$IDJsk = $row['IDJsk'];
		$IDPl = 0;
		$vIDDD = array();
		$appIDDD = array();
		$force = 1;
		$endpoint = "http://parleybets.com:8910/serviceV2";
		$query = <<<'GRAPHQL'
query tblogrosNT($idequi:Int!,$idep:Int!,$idj:Int!,$periodo:Int!,$tp:[Int],$force:Int){
	tblogrosNT(idequi:$idequi,idep:$idep,idj:$idj,periodo:$periodo,tp:$tp,force:$force){
		linea
		idequi
		periodo
		logro
		idj
		tp
		formato
	}
	}
GRAPHQL;
		$lCodeAll = array();
		for ($j = 0; $j <= count($aIDE1) - 1; $j++) {
			$result = mysqli_query($skynet, "Select * From _tbhorariosNTnw where idequi1=" . $aCode1[$j] . " and idep=$aidep[$i] and idj=" . $aidj[$i]);
			if (mysqli_num_rows($result) == 0) :
				$result = mysqli_query($skynet, "Select * From _tbhorariosNTnw where idequi2=" . $aCode1[$j] . " and idep=$aidep[$i]   and idj=" . $aidj[$i]);
			endif;
			$Pich1 = $pich1[$j + 1];
			$Pich2 = $pich2[$j + 1];
			$row = mysqli_fetch_array($result);
			$horap =	substr($row['hora'], 0, 2) . ':' . substr($row['hora'], 2, 2);
			/////				0	,	1	   ,  2		  , 3     ,       4      ,  5       , 6    , 7
			/////				Hora,   HoraPub, CodeE1   , CodeE2,		 IDE1    ,  IDE2    , PicH1, PicH2,  
			$lCodeAll[] = array($row['hora'], $horap, $aCode1[$j], $aCode2[$j], $aIDE1[$j], $aIDE2[$j], $Pich1, $Pich2);
		}
		foreach ($lCodeAll as $clave => $fila) {
			$hora[$clave] = $fila[0];
			$CODE_E1[$clave] = $fila[2];
			$CODE_E2[$clave] = $fila[3];
		}
		array_multisort($hora, SORT_ASC, $CODE_E1, SORT_ASC, $CODE_E2, SORT_ASC, $lCodeAll);
		// print_r($lCodeAll);
		// for ($j = 0; $j <= count($aIDE1) - 1; $j++) {

		foreach ($lCodeAll as $clave => $fila) {
			$tCode1 = $fila[2];
			$tCode2 = $fila[3];
			$iaIDE1 = $fila[4];
			$iaIDE2 = $fila[5];
			$horap = $fila[1];
			$Pich1 = $fila[6];
			$Pich2 = $fila[7];
			echo  '<i class="far fa-check-circle" style="font-size: 18px;color:Dodgerblue;"></i> Capturando datos de ' . $tCode1 . '-' . $tCode2 . '<br>';
			$IDPl++;
			// $result = mysqli_query($GLOBALS['link'],"Select * From _tbhorariosNTnw where idequi1=" . $aCode1[$j] . " and idj=" . $aidj[$i]
			// if (mysqli_num_rows($result) == 0) :
			// 	$result = mysqli_query($GLOBALS['link'],"Select * From _tbhorariosNTnw where idequi2=" . $aCode1[$j] . " and idj=" . $aidj[$i]
			// endif;
			// $row = mysqli_fetch_array($result);
			// $horap =	substr($row['hora'], 0, 2) . ':' . substr($row['hora'], 2, 2);

			// $result = mysqli_query($GLOBALS['link'],"Select * From _jornadaequipos where ( CodigoE1=".$aCode1[$j]." or CodigoE2=".$aCode1[$j]." ) and idgm=".$IDJsk;
			// echo "Select * From _jornadaequipos where ( CodigoE1=".$aCode1[$j]." or CodigoE2=".$aCode1[$j]." ) and idgm=".$IDJsk;echo '<br>';
			// $row = mysqli_fetch_array($result);
			// if ($row['Pich1']==''): $Pich1=$pich1[$j+1]; else: $Pich1=$row['Pich1']; endif;
			// if ($row['Pich2']==''): $Pich2=$pich2[$j+1]; else: $Pich2=$row['Pich2']; endif;
			// $Pich1 = $pich1[$j + 1];
			// $Pich2 = $pich2[$j + 1];
			$IDP++;
			$IDPn = 0;
			$result = mysqli_query($GLOBALS['link'], "Select * From _partidosbb where  (CodEq1=" . $tCode1 . " or CodEq2=" . $tCode1 . " ) and Grupo=$Grupo and IDJ=" . $idj);
			// $result = mysqli_query($GLOBALS['link'],"Select * From _partidosbb where  (CodEq1=" . $aCode1[$j] . " or CodEq2=" . $aCode1[$j] . " ) and IDJ=" . $idj);
			// echo "**Select * From _partidosbb where  (CodEq1=" . $aCode1[$j] . " or CodEq2=" . $aCode1[$j] . " ) and IDJ=" . $idj;
			if (mysqli_num_rows($result) == 0) :
				// echo "Insert _partidosbb values (" . $IDP . "," . $aIDE1[$j] . "," . $aIDE2[$j] . "," . $idj . ",'" . $horap . "','" . $Pich1 . "','" . $Pich2 . "','','','',''," . $aCode1[$j] . "," . $aCode2[$j] . "," . $Grupo . "," . $IDB . ")";
				$result = mysqli_query($GLOBALS['link'], "Insert _partidosbb values (" . $IDP . "," . $iaIDE1 . "," . $iaIDE2 . "," . $idj . ",'" . $horap . "','" . $Pich1 . "','" . $Pich2 . "','','','',''," . $tCode1 . "," . $tCode2 . "," . $Grupo . "," . $IDB . ")");
			else :
				$n = 1;
				$result = mysqli_query($GLOBALS['link'], "Select * From _partidosbb where grupo=$Grupo and IDJ=" . $idj);
				while ($row_g = mysqli_fetch_array($result)) {
					// if ($row_g['CodEq1'] == $aCode1[$j] or $row_g['CodEq2'] == $aCode1[$j]) : $IDPl = $n;
					if ($row_g['CodEq1'] == $tCode1 or $row_g['CodEq2'] == $tCode1) : $IDPl = $n;
						$IDPn = $row_g['IDP'];
						break;
					endif;
					$n++;
				}
				// echo "Update  _partidosbb set IDE1=" . $aIDE1[$j] . ",IDE2=" . $aIDE2[$j] . ",	Hora='" . $horap . "',PIDE1='" . $Pich1 . "',PIDE2='" . $Pich2 . "' where IDP=" . $IDPn;
				$result = mysqli_query($GLOBALS['link'], "Update  _partidosbb set IDE1=" . $iaIDE1 . ",IDE2=" . $iaIDE2 . ",	Hora='" . $horap . "',PIDE1='" . $Pich1 . "',PIDE2='" . $Pich2 . "' where IDP=" . $IDPn);  //(CodEq1=".." or CodEq2=".$aCode1[$j]." ) 
			endif;

			$applicarSCC = true;


			include "skynet-3xt-2Nw.php";
			///// Do while Select * From _tbjuegodd where.......
			echo  '<i class="far fa-check-circle" style="font-size: 18px;color:Dodgerblue;"></i> Fin de Captura de datos de ' . $iaIDE1 . '-' . $iaIDE2 . '<br>';
		}

		$result = mysqli_query($GLOBALS['link'], "Select * From _jornadabb Where idj=$idj and Grupo=$Grupo and IDB=$IDB");
		if (mysqli_num_rows($result) == 0) :
			$result = mysqli_query($GLOBALS['link'], "insert _jornadabb values ( $idj,0,0,'$fecha',$partidos,$Grupo,$IDB,1)");
		endif;
		$result = mysqli_query($GLOBALS['link'], "Select * From _agendaNT Where idj=$idj and grupo=$Grupo and idb=$IDB");
		if (mysqli_num_rows($result) == 0) :
			$result = mysqli_query($GLOBALS['link'], "insert _agendaNT (grupo,idj,IDDDs,IDB,param,newOdds,apptbls,origin) values ( $Grupo,$idj,'" . implode(',', $vIDDD) . "',$IDB,'" . $param[$i] . "',1,'" . implode(',', $appIDDD) . "',1)");
		else :
			$result = mysqli_query($GLOBALS['link'], "Update _agendaNT  set origin=1, param='" . $param[$i] . "',IDDDs='" . implode(',', $vIDDD) . "',apptbls='" . implode(',', $appIDDD) . "' Where idj=$idj and grupo=$Grupo and idb=$IDB");
		endif;
	else :
		echo  '<i class="fas fa-ban" style="font-size: 18px;color:Red;"></i> Captura de datos NO SE PUEDE EJECUTAR!<br>';
	endif;
}




function BuscarIDE($nombre, $Grupo, $imga)
{
	$vnombre = '"' . str_replace("'", "", strtoupper($nombre)) . '"';
	// echo "Select * From _equiposbb where Descripcion like $vnombre  and (grupo=$Grupo or grupo1=$Grupo or grupo2=$Grupo)";
	$result = mysqli_query($GLOBALS['link'], "Select * From _equiposbb where Descripcion like $vnombre  and (grupo=$Grupo or grupo1=$Grupo or grupo2=$Grupo)");
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$IDE = $row['IDE'];
		$result = mysqli_query($GLOBALS['link'], "Update   _equiposbb  set imga= '$imga' where IDE=$IDE");
	else :
		$result = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Order by IDE Desc");
		$row = mysqli_fetch_array($result);
		$IDE = $row['IDE'] + 1;
		// echo 'Insert   _equiposbb values ('.$IDE.',"' . $nombre . '","' . substr($nombre, 0, 3) . '",'.$Grupo.',0,0,"'.$imga.'")';
		$result = mysqli_query($GLOBALS['link'], 'Insert   _equiposbb values (' . $IDE . ',"' . $nombre . '","' . substr($nombre, 0, 3) . '",' . $Grupo . ',0,0,"' . $imga . '")');
	endif;
	return $IDE;
}
