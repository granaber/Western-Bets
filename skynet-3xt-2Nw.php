<?php
$result = mysqli_query($GLOBALS['link'], "Select * From _agendaNT Where idj=$idj and grupo=$Grupo and idb=$IDB and origin=1");
$iDDDs_ag = array();
if (mysqli_num_rows($result) != 0) :
	$row = mysqli_fetch_array($result);
	if ($row['IDDDs'] !== '') {
		$iDDDs_ag = explode(',', $row['IDDDs']);
		$ALiga = explode('|', $row['param']); //14-1109 | 0
		$casino = $ALiga[1];
		echo '**** CASINO:' . $casino;
	}
endif;

if (count($iDDDs_ag) == 0) {
	$result = mysqli_query($GLOBALS['link'], "Select * From _tbjuegodd Where  grupo=$Grupo ");
	while ($row = mysqli_fetch_array($result)) {
		$iDDDs_ag[] = $row['IDDD'];
	}
}


$lcasino = explode(',', $casino);
$acasino = array();
for ($x = 0; $x <= count($lcasino) - 1; $x++) {
	if (intval($lcasino[$x]) != 0)
		$acasino[] = intval($lcasino[$x]);
}
foreach ($iDDDs_ag as $valores) {

	$IDDD = $valores;
	$result2x = mysqli_query($GLOBALS['link'], "Select * From _tbjuegodd where IDDD=" . $IDDD . " Order by Formato,IDDD ");
	$row2x = mysqli_fetch_array($result2x);
	$formato = '';
	$noOptar = true;
	$nameOdds = $row2x['Descripcion'];
	switch ($row2x['procesoescrute']) {
		case 1:
			$prePeriodo = posOdds($row2x['AddTicket'], 1);
			if ($prePeriodo === false) $periodo = 3;
			else  $periodo = $prePeriodo;
			$formato = 'AG';
			break;
		case 4:
			$periodo = 20;
			$formato = 'EP';
			break;
		case 5:
			$formato = 'AG';
			$prePeriodo = posOdds($row2x['AddTicket'], 1);
			if ($prePeriodo === false) $periodo = 3;
			else  $periodo = $prePeriodo;
			break;
		case 2:
			$formato = 'AB';
		case 3:
			$pos = strpos($row2x['AddTicket'], 'SOC');
			if (!($pos === false)) :
				$prePeriodo = posOdds($row2x['AddTicket'], 2);
				if ($prePeriodo === false) $periodo = 0;
				else  $periodo = $prePeriodo;
			// $periodo=0;
			else :
				$prePeriodo = posOdds($row2x['AddTicket'], 2);
				if ($prePeriodo === false) $periodo = 0;
				else  $periodo = $prePeriodo;
			endif;
			if ($formato == '') $formato = 'RL';
			break;
	}



	if ($applicarSCC) {
		//// ADICION PARA QUE SOLO EN EL SOCCER 
		//// LAS A/B tenga la opcion de tablas
		$pos = strpos($row2x['AddTicket'], 'SOC');
		if (!($pos === false)) :
			if ($row2x['procesoescrute'] === '2') :
				if (array_search($valores, $appIDDD) === false)  $appIDDD[] = $valores;
			endif;
		endif;
		/////////////////////////////////////////
	}
	if ($noOptar) : if (array_search($valores, $vIDDD) === false) $vIDDD[] = $valores;
	endif;
	$DEFodds = array();
	//// Registro para Moda de ODDs
	$pOddsA = array();
	$pOddsB = array();
	$pLineA = array();
	$pLineB = array();
	// $result=graphqlQuery($endpoint, $query, ['idequi' => intval($aCode1[$j]),'idj'=>intval($aidj[$i]),'periodo'=>intval($periodo),'tp'=>$acasino,'force'=>$force]);
	// if (567==intval($tCode1)){

	// 	echo '/n';echo '\n';
	// 	print_r(['idequi' => intval($tCode1),'idj'=>intval($aidj[$i]),'periodo'=>intval($periodo),'tp'=>$acasino,'force'=>$force]);
	// }
	// print_r(['idequi' => intval($tCode1),'idj'=>intval($aidj[$i]),'periodo'=>intval($periodo),'tp'=>$acasino,'force'=>$force]);
	$result = graphqlQuery($endpoint, $query, ['idequi' => intval($tCode1), 'idep' => intval($aidep[$i]), 'idj' => intval($aidj[$i]), 'periodo' => intval($periodo), 'tp' => $acasino, 'force' => $force]);
	if (count($result) !== 0) {
		foreach ($result as $regis) {
			$row1 = json_decode(json_encode($regis), True);
			if ($row1['logro'] != '') :
				if ($row1['formato'] == $formato) :
					switch ($row1['formato']) {
						case 'RL':

							$DEFodds[0] = 0;
							$DEFodds[1] = '';
							$DEFodds[2] = 0;
							$DEFodds[3] = '';
							$pos = strpos($row1['logro'], 'u');
							if (!($pos === false)) :
								$allODD = explode('u', $row1['logro']);
								$DEFodds[0] = $allODD[0];
								$DEFodds[1] = $allODD[1];
							else :
								$allODD = explode('o', $row1['logro']);
								$DEFodds[2] = $allODD[0];
								$DEFodds[3] = $allODD[1];
							endif;
							$pOddsA[] = $allODD[1];
							$pLineA[] = $allODD[0];
							break;
						case 'AB':
							$DEFodds[0] = 0;
							$DEFodds[1] = '';
							$DEFodds[2] = 0;
							$DEFodds[3] = '';
							$pos = strpos($row1['logro'], '-');
							if (!($pos === false)) :
								$allODD = explode('-', $row1['logro']);
								$DEFodds[0] = intval($allODD[0]);
								$DEFodds[1] = '-' . $allODD[1];
								$pOddsA[] = '-' . $allODD[1];
								$pLineA[] = $allODD[0];
							else :
								$allODD = explode('+', $row1['logro']);
								$DEFodds[0] = intval($allODD[0]);
								$DEFodds[1] = $allODD[1];
								$pOddsA[] = $allODD[1];
								$pLineA[] = $allODD[0];
							endif;

							break;
						case 'EP':
							$DEFodds[0] = '';
							$DEFodds[0] = $row1['logro'];
							$pOddsA[] = $row1['logro'];
							break;
						default:
							$DEFodds[0] = '';
							$DEFodds[1] = '';
							$DEFodds[0] = $row1['logro'];
							$pOddsA[] = $row1['logro'];
					}
					if (count($pOddsA) == count($acasino)) break;
				endif;
			endif;
		}
	}
	if ($formato !== 'EP') {
		// $result=graphqlQuery($endpoint, $query, ['idequi' => intval($aCode2[$j]),'idj'=>intval($aidj[$i]),'periodo'=>intval($periodo),'tp'=>$acasino,'force'=>$force]);
		$result = graphqlQuery($endpoint, $query, ['idequi' => intval($tCode2), 'idep' => intval($aidep[$i]), 'idj' => intval($aidj[$i]), 'periodo' => intval($periodo), 'tp' => $acasino, 'force' => $force]);
		// print_r($result);
		if (count($result) !== 0) {
			foreach ($result as $regis) {
				$row1 = json_decode(json_encode($regis), True);
				if ($row1['logro'] != '') :
					if ($row1['formato'] == $formato) :
						switch ($row1['formato']) {
							case 'RL':

								if (count($DEFodds) == 0) {
									$DEFodds[0] = 0;
									$DEFodds[1] = '';
									$DEFodds[2] = 0;
									$DEFodds[3] = '';
								}
								$pos = strpos($row1['logro'], 'u');
								if (!($pos === false)) :
									$allODD = explode('u', $row1['logro']);
									$DEFodds[0] = $allODD[0];
									$DEFodds[1] = $allODD[1];
								else :
									$allODD = explode('o', $row1['logro']);
									$DEFodds[2] = $allODD[0];
									$DEFodds[3] = $allODD[1];
								endif;
								$pOddsB[] = $allODD[1];
								$pLineB[] = $allODD[0];
								break;
							case 'AB':
								if (count($DEFodds) == 0) {
									$DEFodds[0] = 0;
									$DEFodds[1] = '';
									$DEFodds[2] = 0;
									$DEFodds[3] = '';
								}
								$pos = strpos($row1['logro'], '-');
								if (!($pos === false)) :
									$allODD = explode('-', $row1['logro']);
									$DEFodds[2] = intval($allODD[0]);
									$DEFodds[3] = '-' . $allODD[1];
									$pLineB[] = $allODD[0];
									$pOddsB[] = '-' . $allODD[1];
								else :
									$allODD = explode('+', $row1['logro']);
									$DEFodds[2] = intval($allODD[0]);
									$DEFodds[3] = intval($allODD[1]);
									$pLineB[] = $allODD[0];
									$pOddsB[] = $allODD[1];
								endif;

								break;
							default:
								if (count($DEFodds) == 0) {
									$DEFodds[0] = 0;
									$DEFodds[1] = 0;
								}
								$DEFodds[1] = $row1['logro'];
								$pOddsB[] = $row1['logro'];
						}
						if (count($pOddsB) == count($acasino)) break;
					endif;
				endif;
			}
		}
	}
	$IDPx = $IDPl;

	if (!evalOdds($DEFodds)) :
		$DEFodds = array();
		echo  '<i class="fas fa-ban" style="font-size: 18px;color:Red;"></i> Logros ' . $nameOdds . ' no aceptados<br>';
	else :
		echo  '<i class="far fa-check-circle" style="font-size: 18px;color:Dodgerblue;"></i> Grabando Logros de ' . $nameOdds . '<br>';
	endif;
	$blanco = false;
	if (count($DEFodds) == 0) :
		switch ($formato) {
			case 'AG':
				$logrosto = '||';
				break;
			case 'AB':
			case 'RL':
				$logrosto = '||||';
				break;
			case 'EP':
				$logrosto = '|';
				break;
		}
		$blanco = true;
	else :
		switch ($formato) {
			case 'AG':
				$DEFodds[0] = moda($pOddsA);
				$DEFodds[1] = moda($pOddsB);
				break;
			case 'AB':
			case 'RL':
				$DEFodds[0] = moda($pOddsA);
				$DEFodds[1] = moda($pLineA);
				$DEFodds[2] = moda($pOddsB);
				$DEFodds[3] = moda($pLineB);
				if ($formato == 'AB') if ($DEFodds[1] != $DEFodds[3]) $DEFodds[3] = $DEFodds[1];
				if ($formato == 'RL') {
					// if ($IDDD==9 && $IDPx==2){
					// 	echo "*******************";
					// 	print_r($DEFodds);
					// 	echo "*******************";
					// }
					if (abs($DEFodds[1]) != abs($DEFodds[3])) {
						if ($DEFodds[3] < 0)
							$DEFodds[3] = -1 * $DEFodds[1];
						else
							$DEFodds[3] = abs($DEFodds[1]);


						// if ($IDDD==9 && $IDPx==2){
						// 	echo "*******************";
						// 	print_r($DEFodds);
						// 	echo "*******************";
						// }
					}
				}

				break;
			case 'EP':
				$DEFodds[0] = moda($pOddsA);
				break;
		}
		if ($formato !== 'EP')
			$logrosto = join('|', $DEFodds) . '|';
		else
			$logrosto = $DEFodds[0] . '|';
	endif;

	$result = mysqli_query($GLOBALS['link'], "Select * From _configuracionjugadabb where IDJ=$idj and Grupo=$Grupo and IDDD=$IDDD and IDP=$IDPx and IDB=$IDB ");

	if (mysqli_num_rows($result) == 0) :
		$result = mysqli_query($GLOBALS['link'], "Insert _configuracionjugadabb values ($idj,$IDPx,$IDDD,'$logrosto',$Grupo,0,$IDB)");
	else :
		$row = mysqli_fetch_array($result);
		$actu = $row['actualizado'] + 1;

		if ($row['Valores'] != $logrosto && !$blanco) {
			$result = mysqli_query($GLOBALS['link'], "Update  _configuracionjugadabb  set 	Valores='$logrosto',actualizado=$actu where IDJ=$idj  and IDDD=$IDDD and Grupo=$Grupo and IDP=$IDPx and IDB=$IDB");
			// echo "Update  _configuracionjugadabb  set 	Valores='$logrosto',actualizado=$actu where IDJ=$idj  and IDDD=$IDDD and Grupo=$Grupo and IDP=$IDPx and IDB=$IDB";
		}
		// else{
		// 	echo $row['Valores'].'!='.$logrosto; print_r($DEFodds); 
		// }
		$result = mysqli_query($GLOBALS['link'], "Insert _uologro values ($idj,$IDDD,$actu,$IDPx,'" . time() . "');");
	endif;
}
