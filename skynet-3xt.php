<?
require_once('prc_skynet.php');
require('prc_php.php');
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



for ($i = 0; $i <= count($aidj) - 1; $i++) {
	$result = mysqli_query($GLOBALS['link'], "Select * From _tbjornadaNT Where idj=" . $aidj[$i], $skynet);
	$row = mysqli_fetch_array($result);
	echo '<br>';
	echo "Select * From _tbjornadaNT Where idj=" . $aidj[$i];
	echo '<br>';
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

	$result = mysqli_query($GLOBALS['link'], "Select * From _tbligasNT Where idep=" . $aidep[$i] . " and idj=" . $aidj[$i], $skynet);
	$row = mysqli_fetch_array($result);
	echo "Select * From _tbligasNT Where idep=" . $aidep[$i] . " and idj=" . $aidj[$i];
	$nombre = $row['nombre'];
	$result = mysqli_query($GLOBALS['link'], "Select * From _tbligasNT Where nombre='" . $nombre . "'");
	$row = mysqli_fetch_array($result);
	echo "Select * From _tbligasNT Where nombre='" . $nombre . "'";
	$Grupo = $row['grupo'];



	$result = mysqli_query($GLOBALS['link'], "Select * From _tbequiposNT Where nombre!='' and idj=" . $aidj[$i] . " and idep=" . $aidep[$i] . " GROUP BY idequi order by idequi ", $skynet);
	echo "Select * From _tbequiposNT Where idj=" . $aidj[$i] . " and idep=" . $aidep[$i] . " order by idequi ";
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
				$aIDE1[] = BuscarIDE($row1['nombre'], $Grupo);
				$partidos++;
				$n1[] = $row1['nombre'];
				$pich1[] = $row1['pch'];
				$linea = 2;
				break;
			case 2:
				$aCode2[] = $row1['idequi'];
				$aIDE2[] = BuscarIDE($row1['nombre'], $Grupo);
				$n2[] = $row1['nombre'];
				$pich2[] = $row1['pch'];
				$linea = 1;
				break;
		}
	}
	print_r($aIDE1);
	print_r($aIDE2);
	/// Crear Partidos
	$result = mysqli_query($GLOBALS['link'], "Select * From _partidosbb  order by IDP DESC");
	$row = mysqli_fetch_array($result);
	$IDP = $row['IDP'];
	$result = mysqli_query($GLOBALS['link'], "Select * From _tbjornada where gmdt=" . $gmtdt, $skynet);
	$row = mysqli_fetch_array($result);
	echo "***Select * From _tbjornada where gmdt=" . $gmtd;
	$IDJsk = $row['IDJsk'];
	$IDPl = 0;
	for ($j = 0; $j <= count($aIDE1) - 1; $j++) {
		$IDPl++;

		$result = mysqli_query($GLOBALS['link'], "Select * From _tbhorariosNT where idequi1=" . $aCode1[$j] . " and idj=" . $aidj[$i], $skynet);
		$row = mysqli_fetch_array($result);
		$horap =	substr($row['hora'], 0, 2) . ':' . substr($row['hora'], 2, 2);

		$result = mysqli_query($GLOBALS['link'], "Select * From _jornadaequipos where ( CodigoE1=" . $aCode1[$j] . " or CodigoE2=" . $aCode1[$j] . " ) and idgm=" . $IDJsk, $skynet);
		echo "Select * From _jornadaequipos where ( CodigoE1=" . $aCode1[$j] . " or CodigoE2=" . $aCode1[$j] . " ) and idgm=" . $IDJsk;
		echo '<br>';
		$row = mysqli_fetch_array($result);
		if ($row['Pich1'] == '') : $Pich1 = $pich1[$j + 1];
		else : $Pich1 = $row['Pich1'];
		endif;
		if ($row['Pich2'] == '') : $Pich2 = $pich2[$j + 1];
		else : $Pich2 = $row['Pich2'];
		endif;

		$IDP++;
		$IDPn = 0;
		$result = mysqli_query($GLOBALS['link'], "Select * From _partidosbb where  (CodEq1=" . $aCode1[$j] . " or CodEq2=" . $aCode1[$j] . " ) and IDJ=" . $idj);

		echo '<br>';
		echo "Select * From _partidosbb where  (CodEq1=" . $aCode1[$j] . " or CodEq2=" . $aCode1[$j] . " ) and IDJ=" . $idj;
		echo '<br>';
		if (mysqli_num_rows($result) == 0) :
			$result = mysqli_query($GLOBALS['link'], "Insert _partidosbb values (" . $IDP . "," . $aIDE1[$j] . "," . $aIDE2[$j] . "," . $idj . ",'" . $horap . "','" . $Pich1 . "','" . $Pich2 . "','','','',''," . $aCode1[$j] . "," . $aCode2[$j] . "," . $Grupo . "," . $IDB . ")");
			echo "Insert _partidosbb values (" . $IDP . "," . $aIDE1[$j] . "," . $aIDE2[$j] . "," . $idj . ",'" . $horap . "','" . $Pich1 . "','" . $Pich2 . "','','','',''," . $aCode1[$j] . "," . $aCode2[$j] . "," . $Grupo . "," . $IDB . ")<br>";
		else :
			$n = 1;
			$result = mysqli_query($GLOBALS['link'], "Select * From _partidosbb where grupo=$Grupo and IDJ=" . $idj);
			while ($row_g = mysqli_fetch_array($result)) {
				if ($row_g['CodEq1'] == $aCode1[$j] or $row_g['CodEq2'] == $aCode1[$j]) : $IDPl = $n;
					$IDPn = $row_g['IDP'];
					break;
				endif;
				$n++;
			}

			$result = mysqli_query($GLOBALS['link'], "Update  _partidosbb set IDE1=" . $aIDE1[$j] . ",IDE2=" . $aIDE2[$j] . ",	Hora='" . $horap . "',PIDE1='" . $Pich1 . "',PIDE2='" . $Pich2 . "' where IDP=" . $IDPn);  //(CodEq1=".." or CodEq2=".$aCode1[$j]." ) 
		endif;



		$vIDDD = array();

		include "skynet-3xt-1.php";
		///// Do while Select * From _tbjuegodd where.......

	}

	$result = mysqli_query($GLOBALS['link'], "Select * From _jornadabb Where idj=$idj and Grupo=$Grupo and IDB=$IDB");
	echo "Select * From _jornadabb Where idj=$idj and Grupo=$Grupo and IDB=$IDB";
	echo "insert _jornadabb values ( $idj,0,0,'$fecha',$partidos,$Grupo,$IDB,1)";
	if (mysqli_num_rows($result) == 0) :
		$result = mysqli_query($GLOBALS['link'], "insert _jornadabb values ( $idj,0,0,'$fecha',$partidos,$Grupo,$IDB,1)");
		echo "insert _jornadabb values ( $idj,0,0,'$fecha',$partidos,$Grupo,$IDB,1)";
	endif;
	$result = mysqli_query($GLOBALS['link'], "Select * From _agendaNT Where idj=$idj and grupo=$Grupo and idb=$IDB");
	if (mysqli_num_rows($result) == 0) :
		$result = mysqli_query($GLOBALS['link'], "insert _agendaNT (grupo,idj,IDDDs,IDB,param) values ( $Grupo,$idj,'" . implode(',', $vIDDD) . "',$IDB,'" . $param[$i] . "')");
	else :
		$result = mysqli_query($GLOBALS['link'], "Update _agendaNT  set param='" . $param[$i] . "' Where idj=$idj and grupo=$Grupo and idb=$IDB");
	endif;
}




function BuscarIDE($nombre, $Grupo)
{
	$result = mysqli_query($GLOBALS['link'], "Select * From _equiposbb where Descripcion like '" . strtoupper($nombre) . "%'  and (grupo=" . $Grupo . " or grupo1=" . $Grupo . " or grupo2=" . $Grupo . ")");
	echo "Select * From _equiposbb where Descripcion like '" . strtoupper($nombre) . "%'  and (grupo=" . $Grupo . " or grupo1=" . $Grupo . " or grupo2=" . $Grupo . ")";
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$IDE = $row['IDE'];
	else :
		$result = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Order by IDE Desc");
		$row = mysqli_fetch_array($result);
		$IDE = $row['IDE'] + 1;
		$result = mysqli_query($GLOBALS['link'], "Insert   _equiposbb values ($IDE,'" . $nombre . "','" . substr($nombre, 0, 3) . "',$Grupo,0,0)");
	//$result = mysqli_query($GLOBALS['link'],"Insert   _tbequixml values ($IDE,$Grupo,'".$nombre."')",$GLOBALS['link']);
	endif;
	return $IDE;
}
