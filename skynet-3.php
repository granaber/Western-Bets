<?
require_once('prc_skynet.php');
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$MinutosAdd = 0;

//********************************************************************************//

$Liga = $_REQUEST['liga'];
$result = mysqli_query($GLOBALS['link'], "Select * From _tbligaxml Where Liga=$Liga");

if (mysqli_num_rows($result) != 0) :
	$row = mysqli_fetch_array($result);
	$Grupo = $row['Grupo'];
	$LigaP = $row['Grupo'];
	$MinutosAdd = $row['Minutos'];

	$Campos = array();
	$tiempo = array();
	$Princp = '0';
	$result1 = mysqli_query($GLOBALS['link'], "Select * From _tblogrosxml Where xLiga=$Liga");
	while ($row1 = mysqli_fetch_array($result1)) {
		$Campos[$row1['Liga']][$row1['IDDD']] = $row1['logro'];
		$tiempo[$row1['Liga']] = $row1['tiempo'];
		if ($Princp == '0' && $row1['tiempo'] != '') :
			$Princp = $row1['tiempo'];
		endif;
	}

	$Equipos = array();
	$IDE = array();
	$result1 = mysqli_query($GLOBALS['link'], "Select * From _tbequixml  Where Liga=$Liga");
	while ($row1 = mysqli_fetch_array($result1)) {
		$Equipos[] = trim($row1['Equal']);
		$aIDE[] = $row1['IDE'];
	}

	//print_r($Equipos);print_r($aIDE);

	$TxEquipos = array();
	$result1 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb  Where Grupo=$Grupo or Grupo1=$Grupo or Grupo2=$Grupo ");
	while ($row1 = mysqli_fetch_array($result1))
		$TxEquipos[] = strtoupper($row1['Descripcion']);


	$fc = $_REQUEST["fc"];
	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "' order by Grupo");
	if (mysqli_num_rows($resultj) != 0) :
		$rowj = mysqli_fetch_array($resultj);
		$idj = $rowj["IDJ"];
	else :
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb Order by IDJ DESC ");
		$row = mysqli_fetch_array($result);
		if ($result) :
			$idj = $row["IDJ"] + 1;
		else :
			$idj = 1;
		endif;
	endif;

	$fc1 = explode("/", $fc);
	if (strlen($fc1[1]) == 1) : $fc1[1] = '0' . $fc1[1];
	endif;
	if (strlen($fc1[0]) == 1) : $fc1[0] = '0' . $fc1[0];
	endif;
	$fechaactual = $fc1[2] . $fc1[1] . $fc1[0];


	$equipo1 = array();
	$equipo2 = array();
	$hora = array();
	$COD1 = array();
	$COD2 = array();
	$Pich1 = array();
	$Pich2 = array();


	$GLOBALS['link'] = Skynet::getInstance();

	$result = mysqli_query($GLOBALS['link'], "Select * From _tbjornada  Where gmdt='$fechaactual'");
	echo "Select * From _tbjornada  Where gmdt='$fechaactual'";
	$row = mysqli_fetch_array($result);
	$IDJsk = $row['IDJsk'];

	$j = 0;

	if ($Princp == '0') :
		$result1 = mysqli_query($GLOBALS['link'], "Select * From _jornadaequipos  Where Liga=$Liga and IDJsk=$IDJsk");  //  Busca los Equipos en Skynet Segun Liga Seleccionada y Dia (IDJsk)
		echo ("Select * From _jornadaequipos  Where Liga=$Liga and IDJsk=$IDJsk");;
	else :
		$result1 = mysqli_query($GLOBALS['link'], "Select * From _jornadaequipos  Where Liga=$Liga and IDJsk=$IDJsk and Tiempo='$Princp'");  //  Busca los Equipos en Skynet Segun Liga Seleccionada y Dia (IDJsk)
		echo ("Select * From _jornadaequipos  Where Liga=$Liga and IDJsk=$IDJsk and Tiempo='$Princp'");
	endif;
	while ($row1 = mysqli_fetch_array($result1)) {
		$equipo1[$j] = iCodeArray($row1['Equi1'], $Equipos); 	// Equipo No.1
		$equipo2[$j] = iCodeArray($row1['Equi2'], $Equipos);	// Equipo No.2
		$Pich1[$j] = htmlentities($row1['Pich1']);							// Pitcher del Equipo No.1
		$Pich2[$j] = htmlentities($row1['Pich2']);							// Pitcher del Equipo No.2
		$COD1[$j] = $row1['CodigoE1'];						// Codigo  del Equipo No.1  Segun DonBest
		$COD2[$j] = $row1['CodigoE2'];						// Pitcher del Equipo No.2	Segun DonBest
		$hora[$j] = ColocarHora($MinutosAdd, $row1['Hora']);	// Hora COLOCARHORA Funcion que resta o Suma de acuerdo al Horario Solicitado!
		$j++;																		// Nuevo Partido!
	}
	//	print_r($Campos);	print_r($tiempo);
	$cantidad = $j;
	$pvLiga = 0;
	foreach ($Campos as $Key => $Valores) {
		$vLiga = $Key;
		$CamposN2 = $Campos[$Key];
		if ($pvLiga == 0) : $pvLiga = $vLiga;
		endif;
		$j = 0;
		if ($Princp == '0') :
			$result1 = mysqli_query($GLOBALS['link'], "Select * From _jornadaequipos  Where Liga=$vLiga and IDJsk=$IDJsk");  //  Busca los Equipos en Skynet Segun Liga Seleccionada y Dia (IDJsk)
		else :
			$result1 = mysqli_query($GLOBALS['link'], "Select * From _jornadaequipos  Where Liga=$pvLiga and IDJsk=$IDJsk and Tiempo='" . $tiempo[$vLiga] . "'");
			$pvLiga = 0;
		endif;
		while ($row1 = mysqli_fetch_array($result1)) {
			$result2 = mysqli_query($GLOBALS['link'], "Select * From _tblogros  Where idgm='" . $row1['idgm'] . "' ORDER BY id DESC"); // Busco en el los Logros idgm es el equipo ID Unico
			if (mysqli_num_rows($result2) != 0) :
				$row2 = mysqli_fetch_array($result2);
				foreach ($CamposN2 as $KeyN2 => $ValoresN2) {								// El Array $Campos se encuentra la Configuracion segun la Liga Seleccionada
					$verCampos = explode('|', $ValoresN2); 								// En verCampos descompone los valores de $Campos asignado a $Valores, $Key tiene el IDDD de la Apuesta
					$logros[$j][$KeyN2] = '';
					for ($x = 0; $x <= count($verCampos) - 1; $x++)							// $j controla la cantidad de partidos!!
						$logros[$j][$KeyN2] .= $row2[$verCampos[$x]] . '|';					// $row2[$verCampos[$x]] = Busco el campo segun $verCampos[$x] 

				}
			endif;
			$j++;																		// Nuevo Partido!
		}
	}
endif;


function iCodeArray($Busca, $Arreglo)
{
	global $TxEquipos;
	global $aIDE;
	//echo trim($Busca);
	$clave = array_search(($Busca), $Arreglo);
	//echo "*";echo $clave; echo "*";
	if ($clave === false) :
		$valor = 0;
		for ($i = 0; $i <= count($TxEquipos) - 1; $i++)
			if (strpos($Busca, $TxEquipos[$i]) !== false) : $valor = '$1*' . htmlentities($TxEquipos[$i]);
				break;
			endif;


		if ($valor == 0) : $valor = '2$*' . str_replace('.', ' ', $Busca);
		endif;
	else :
		$valor = $aIDE[$clave];
	endif;
	//echo $valor.'<br>';
	return $valor;
}

function ColocarHora($minutos, $hora)/*"h:i:s A"*/
{
	$fm = "G:i";
	$horaM = explode(":", $hora);
	$horaM[1] = $horaM[1] + $minutos;
	$HoraNew = date($fm, mktime($horaM[0], $horaM[1], $horaM[2], 1, 1, 1));
	return $HoraNew;
}


?>

<script>
	var equipo1 = '<? echo join('|', $equipo1); ?>';
	var equipo2 = '<? echo join('|', $equipo2); ?>';
	var Pich1 = '<? echo join('|', $Pich1); ?>';
	var Pich2 = '<? echo join('|', $Pich2); ?>';
	var COD1 = '<? echo join('|', $COD1); ?>';
	var COD2 = '<? echo join('|', $COD2); ?>';
	var hora = '<? echo join('|', $hora); ?>';
	var cant = <? echo $cantidad; ?>;
	var dp = <? echo $Grupo; ?>;
	var fc = <? echo $Grupo; ?>;
	var idj = <? echo $idj; ?>;
	var fc = '<? echo  $fc; ?>';
	var liga = '<? echo  $Liga; ?>';
	var logros = '<? echo json_encode($logros); ?>';

	new Ajax.Request('jornadabb.php', {
		parameters: {
			cant: cant,
			idj: idj,
			dp: dp,
			IDB: 1,
			fc: fc,
			skynet: 'eGhtd4ewq',
			equiz1: equipo1,
			equiz2: equipo2,
			ptch1: Pich1,
			ptch2: Pich2,
			hra: hora,
			code1: COD1,
			code2: COD2,
			logros: logros,
			liga: liga
		},
		method: 'post',
		onComplete: function(transport) {
			var response = transport.responseText;
			$('tablemenu').innerHTML = response;
			response.evalScripts();
		},
		onCreate: function() {
			$('tablemenu').innerHTML = '<img src="media/ajax-loader.gif" />';
		},
		onFailure: function() {
			alert('No tengo respuesta Comuniquese con el Administrador!');
		}
	});
</script>