<?

$result2x = mysqli_query($GLOBALS['link'], "Select * From _tbjuegodd where Grupo=" . $Grupo . " Order by Formato,IDDD ", $GLOBALS['link']);
while ($row2x = mysqli_fetch_array($result2x)) {
	$result = mysqli_query($GLOBALS['link'], "Select * From _agendaNT Where idj=$idj and grupo=$Grupo and idb=$IDB", $GLOBALS['link']);

	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$verl = explode(',', $row['IDDDs']);
		if ((array_search($row2x['IDDD'], $verl) === false)) continue;
		else echo $row['IDDD'] . '<br>';
	endif;
	$IDDD = $row2x['IDDD'];
	$result = mysqli_query($GLOBALS['link'], "Select * From _tblogrosXmlNT where IDDD=" . $IDDD, $GLOBALS['link']);
	echo "Select * From _tblogrosXmlNT where IDDD=" . $IDDD;
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$periodo = $row['periodo'];
		$proceso = $row['proceso'];
		$dproceso = $row['dproceso'];
		$msim = $row['msim'];
		$_2periodo = $row['2periodo']; /// en caso de saber de donde voy a sacar el signo de algun logro 0=ND 0!=el periodo de tomar el signo
		$vIDDD[] = $IDDD;
		if ($casino[$i] == 0) :
			$add = '';
		else :
			$add = ' and tp in (' . $casino[$i] . ')';
		endif;
		$logro1 = array();
		$logro2 = array();
		$logro1[0] = 0;
		$logro1[1] = 0;
		$l1[0] = 0;
		$l1[1] = 0;
		$logro2[0] = 0;
		$logro2[1] = 0;
		$l2[0] = 0;
		$l2[1] = 0;
		$carrera1[0] = 0;
		$carrera1[1] = 0;
		$c1[0] = 0;
		$c1[1] = 0;
		$ldc1 = array();
		$Sou[0] = 0;
		$Sou[1] = 0;
		$carrera2[0] = 0;
		$carrera2[1] = 0;
		$c2[0] = 0;
		$c2[1] = 0;
		$ldc2 = array();
		$sdlP[0] = 0;
		$sdlP[1] = 0;
		$sdlN[0] = 0;
		$sdlN[1] = 0;
		$ubi[0] = 0;
		$ubi[1] = 0;
		$Soup[0] = 0;
		$Soup[1] = 0;
		$Soun[0] = 0;
		$Soun[1] = 0;
		//   o+           u+         o-          u- 
		$sdlP2[0] = 0;
		$sdlP2[1] = 0;
		$sdlN2[0] = 0;
		$sdlN2[1] = 0;
		$Soup2[0] = 0;
		$Soup2[1] = 0;
		$Soun2[0] = 0;
		$Soun2[1] = 0;
		$modaLogros1 = array();
		$modaLogros2 = array();
		$Ldldc1 = array();
		$Ldldc2 = array();
		$ldlSel = array();
		$PCarrera1 = 0;
		$PCarrera2 = 0;
		$Plogros1 = 0;
		$Plogros2 = 0;


		switch ($periodo) {
			case 1000:
				$result = mysqli_query($GLOBALS['link'], "Select * From _tblogrosXmlNT where IDDD=" . $proceso, $GLOBALS['link']);
				$row = mysqli_fetch_array($result);
				$periodo2 = $row['periodo'];
				$proceso = $dproceso;
				if ($_2periodo != -1) :
					$basesigno1 = _findsigno($_2periodo, $aCode1[$j], $aidj[$i], $add);
				endif;
				$result = mysqli_query($GLOBALS['link'], "Select * From _tblogrosNT where idequi=" . $aCode1[$j] . " and idj=" . $aidj[$i] . " and periodo=" . $periodo2 . $add, $skynet);
				echo "*=>1Select * From _tblogrosNT where idequi=" . $aCode1[$j] . " and idj=" . $aidj[$i] . " and periodo=" . $periodo2 . $add;
				echo '*' . $proceso . ' *<br>';
				break;
			case 1001:
				$result = mysqli_query($GLOBALS['link'], "Select * From _tblogrosXmlNT where IDDD=" . $proceso, $GLOBALS['link']);
				$row = mysqli_fetch_array($result);
				$periodo2 = $row['periodo'];
				$proceso = $row['proceso'];
				$result = mysqli_query($GLOBALS['link'], "Select * From _tblogrosNT where idequi=" . $aCode1[$j] . " and idj=" . $aidj[$i] . " and periodo=" . $periodo2 . $add, $skynet);
				echo "*=>1Select * From _tblogrosNT where idequi=" . $aCode1[$j] . " and idj=" . $aidj[$i] . " and periodo=" . $periodo2 . $add;
				echo '*' . $proceso . ' *<br>';
				break;
			default:
				$result = mysqli_query($GLOBALS['link'], "Select * From _tblogrosNT where idequi=" . $aCode1[$j] . " and idj=" . $aidj[$i] . " and periodo=" . $periodo . $add, $skynet);
				echo "Select * From _tblogrosNT where idequi=" . $aCode1[$j] . " and idj=" . $aidj[$i] . " and periodo=" . $periodo . $add . '<br>';
				break;
		}
		while ($row1 = mysqli_fetch_array($result)) {
			if ($row1['logro'] != '') :

				$dett = dSpe($row1['logro'], $proceso);
				$pos = -1;
				print_r($dett);

				switch ($proceso) {
					case 10:
						if ($dett[2] != 2) $dett[2] = -1;
						break;
					case 7:
						if ($dett[2] != 1) $dett[2] = -1;
						if ($dett[0] > 0 && $dett[1] > 0) $dett[2] = -1;
						break;
					case 8:
						if ($dett[2] != 2 && $dett[2] != 0) : $dett[2] = -1;
						endif;
						if ($dett[2] != -1) if (($dett[1] == 0 || $dett[2] == 0) && $dett[2] != 0) : $dett[2] = -1;
						endif;

						if ($dett[2] != -1) :
							if ($dett[3] == 'o') : $Sou[0]++;
								$pos = 0;
							endif;
							if ($dett[3] == 'u') : $Sou[1]++;
								$pos = 1;
							endif;
							$ldlSel[] = $dett;
						endif;
						break;
					case 9:
					case 4:
						if (!($dett[0] <= $msim)) : $dett[2] = -1;
						endif;
						break;
					case 5:
						echo $dett[0] . '<=' . $msim;
						if (($dett[0] <= $msim)) : $dett[2] = -1;
						else : echo 'si';
						endif;
						break;
				}




				switch ($dett[2]) {
					case 0:
						$ubi[0] = 1;
						if ($dett[0] != 0) :
							if (Detect($dett[0]) == 1) :
								if ($dett[0] > 0) :
									$logro1[0] += $dett[0];
									$l1[0]++;
									$sdlP[$pos] += $dett[0];
									$Soup[$pos]++;
								else :
									$logro1[1] += $dett[0];
									$l1[1]++;
									$sdlN[$pos] += $dett[0];
									$Soun[$pos]++;
								endif;
								if ($proceso == 5) : $ldc1[] = strval($dett[0]);
								endif;
								$modaLogros1[] = $dett[0];
							else :
								if ($dett[0] > 0) :
									$carrera1[0] += $dett[0];
									$c1[0]++;
									$ldc1[] = strval($dett[0]);
									$Ldldc1[] = $dett[1];
								else :
									$carrera1[1] += $dett[0];
									$c1[1]++;
									$ldc1[] = strval($dett[0]);
									$Ldldc1[] = $dett[1];
								endif;
							endif;
						endif;
						break;
					case 1:
						/*if (Detect($dett[0])==1): */
						$ubi[0] = 1;
						if ($dett[0] != 0) :
							if ($dett[0] > 0) :
								$logro1[0] += $dett[0];
								$l1[0]++;
							else :
								$logro1[1] += $dett[0];
								$l1[1]++;
							endif;
							$modaLogros1[] = $dett[0];
						endif;
						if ($dett[1] != 0) :
							if ($dett[1] > 0) :
								$logro2[0] += $dett[1];
								$l2[0]++;
							else :
								$logro2[1] += $dett[1];
								$l2[1]++;
							endif;
							$modaLogros1[] = $dett[1];
						endif;
						/*else: 
							if ($dett[0]!=0): $carrera1+=$dett[0]; $c1++; endif;
							if ($dett[1]!=0): $carrera2+=$dett[1]; $c2++; endif;
						endif;*/
						break;
					case 2:
						/*if (Detect($dett[0])==1): 
							if ($dett[0]!=0): $logro1+=$dett[0]; $l1++;  endif;
							if ($dett[1]!=0): $carrera1+=$dett[1]; $c1++;endif;
						else:*/
						$ubi[0] = 1;
						if ($dett[0] != 0) :
							if ($dett[0] > 0) :
								$carrera1[0] += $dett[0];
								$c1[0]++;
								$ldc1[] = strval($dett[0]);
								$Ldldc1[] = $dett[1];
							else :
								$carrera1[1] += $dett[0];
								$c1[1]++;
								$ldc1[] = strval($dett[0]);
								$Ldldc1[] = $dett[1];
							endif;
						endif;
						if ($dett[1] != 0) :
							if ($dett[1] > 0) :
								$logro1[0] += $dett[1];
								$l1[0]++;
								$sdlP[$pos] += $dett[1];
								$Soup[$pos]++;
							else :
								$logro1[1] += $dett[1];
								$l1[1]++;
								$sdlN[$pos] += $dett[1];
								$Soun[$pos]++;
							endif;
							if ($proceso == 5) : $ldc1[] = strval($dett[0]);
							endif;
							$modaLogros1[] = $dett[1];
						endif;
						/*endif;*/
						break;
				}

			endif;
		}
		switch ($periodo) {
			case 1000:
				//$result = mysqli_query($GLOBALS['link'],"Select * From _tblogrosXmlNT where IDDD=".$proceso ,$GLOBALS['link']);$row = mysqli_fetch_array($result);
				//$periodo2=$row['periodo'];
				//$proceso=$dproceso;
				if ($_2periodo != -1) :
					$basesigno2 = _findsigno($_2periodo, $aCode2[$j], $aidj[$i], $add);
				endif;
				$result = mysqli_query($GLOBALS['link'], "Select * From _tblogrosNT where idequi=" . $aCode2[$j] . " and idj=" . $aidj[$i] . " and periodo=" . $periodo2 . $add, $skynet);
				echo "*=>2Select * From _tblogrosNT where idequi=" . $aCode2[$j] . " and idj=" . $aidj[$i] . " and periodo=" . $periodo2 . $add;
				echo '<br>';
				break;
			case 1001:

				$result = mysqli_query($GLOBALS['link'], "Select * From _tblogrosNT where idequi=" . $aCode2[$j] . " and idj=" . $aidj[$i] . " and periodo=" . $periodo2 . $add, $skynet);
				echo "*=>2Select * From _tblogrosNT where idequi=" . $aCode2[$j] . " and idj=" . $aidj[$i] . " and periodo=" . $periodo2 . $add;
				echo '<br>';
				break;
			default:
				$result = mysqli_query($GLOBALS['link'], "Select * From _tblogrosNT where idequi=" . $aCode2[$j] . " and idj=" . $aidj[$i] . " and periodo=" . $periodo . $add, $skynet);
				break;
		}
		while ($row1 = mysqli_fetch_array($result)) {
			if ($row1['logro'] != '') :

				$dett = dSpe($row1['logro'], $proceso);
				print_r($dett);


				switch ($proceso) {
					case 10:
						if ($dett[2] != 2) $dett[2] = -1;
						break;
					case 7:
						if ($dett[2] != 1) $dett[2] = -1;
						if ($dett[0] > 0 && $dett[1] > 0) $dett[2] = -1;

						break;
					case 8:
						if ($dett[2] != 2 && $dett[2] != 0) : $dett[2] = -1;
						endif;
						if ($dett[2] != -1) if (($dett[1] == 0 || $dett[2] == 0) && $dett[2] != 0) : $dett[2] = -1;
						endif;

						if ($dett[2] != -1) :
							if ($dett[3] == 'o') : $Sou[0]++;
								$pos = 0;
							endif;
							if ($dett[3] == 'u') : $Sou[1]++;
								$pos = 1;
							endif;
							$ldlSel[] = $dett;
						endif;
						break;
					case 9:
					case 4:
						if (!($dett[0] <= $msim)) : $dett[2] = -1;
						endif;
						break;
					case 5:
						if (($dett[0] <= $msim)) : $dett[2] = -1;
						endif;
						break;
				}
				switch ($dett[2]) {
					case 0:
						$ubi[1] = 1;
						if ($dett[0] != 0) :
							if (Detect($dett[0]) == 1) :
								if ($dett[0] > 0) :
									$logro2[0] += +$dett[0];
									$l2[0]++;
									$sdlP2[$pos] += $dett[0];
									$Soup2[$pos]++;
								else :
									$logro2[1] += $dett[0];
									$l2[1]++;
									$sdlN2[$pos] += $dett[0];
									$Soun2[$pos]++;
								endif;
								if ($proceso == 5) : $ldc2[] = strval($dett[0]);
								endif;
								$modaLogros2[] = $dett[0];
							else :
								if ($dett[0] > 0) :
									$carrera2[0] += $dett[0];
									$c2[0]++;
									$ldc2[] = strval($dett[0]);
									$Ldldc2[] = $dett[1];
								else :
									$carrera2[1] += $dett[0];
									$c2[1]++;
									$ldc2[] = strval($dett[0]);
									$Ldldc2[] = $dett[1];
								endif;
							endif;
						endif;
						break;
					case 1:
						/*if (Detect($dett[0])==1): */
						$ubi[1] = 1;
						if ($dett[0] != 0) :
							if ($dett[0] > 0) :
								$logro1[0] += $dett[0];
								$l1[0]++;
							else :
								$logro1[1] += $dett[0];
								$l1[1]++;
							endif;
							$modaLogros2[] = $dett[0];
						endif;
						if ($dett[1] != 0) :
							if ($dett[1] > 0) :
								$logro2[0] += $dett[1];
								$l2[0]++;
							else :
								$logro2[1] += $dett[1];
								$l2[1]++;
							endif;
							$modaLogros2[] = $dett[1];
						endif;
						/*else: 
							if ($dett[0]!=0):$carrera1+=$dett[0]; $c1++; endif;
							if ($dett[1]!=0):$carrera2+=$dett[1]; $c2++;endif;
						endif;*/
						break;
					case 2:
						/*if (Detect($dett[0])==1): 
							if ($dett[0]!=0):$logro2+=$dett[0]; $l2++; endif;
							if ($dett[1]!=0):$carrera2+=$dett[1]; $c2++;endif;
						else: */
						$ubi[1] = 1;
						if ($dett[0] != 0) :
							if ($dett[0] > 0) :
								$carrera2[0] += $dett[0];
								$c2[0]++;
								$ldc2[] = strval($dett[0]);
								$Ldldc2[] = $dett[1];
							else :
								$carrera2[1] += $dett[0];
								$c2[1]++;
								$ldc2[] = strval($dett[0]);
								$Ldldc2[] = $dett[1];
							endif;
						endif;
						if ($dett[1] != 0) :
							if ($dett[1] > 0) :
								$logro2[0] += $dett[1];
								$l2[0]++;
								$sdlP2[$pos] += $dett[1];
								$Soup2[$pos]++;
							else :
								$logro2[1] += $dett[1];
								$l2[1]++;
								$sdlN2[$pos] += $dett[1];
								$Soun2[$pos]++;
							endif;
							if ($proceso == 5) : $ldc2[] = strval($dett[0]);
							endif;
							$modaLogros2[] = $dett[1];
						endif;
						/*endif;*/
						break;
				}

			endif;
		}
		///// o+          u+           o-         u-
		//// $sdlP[0]=0; $sdlP[1]=0; $sdlN[0]=0; $sdlN[1]=0;
		//// Promedios de Logros
		$Plogros1 = 0;
		$Plogros2 = 0;
		$PCarrera1 = 0;
		$PCarrera2 = 0;
		echo '**';
		print_r($logro1);
		print_r($logro2);
		print_r($carrera1);
		print_r($carrera2);
		print_r($ubi);
		echo 'o/u:';
		print_r($Sou);
		print_r($ldlSel);
		echo '**';


		/////////////// Carreras ////////////////
		$cantidad2 = 0;
		$cantidad1 = 0;
		if ($proceso == 8 || $proceso == 9 || $proceso == 4 || $proceso == 5 || $proceso == 10) :
			//echo 'logrodes:';print_r($Ldldc1); echo 'moda:';print_r($ldc1);
			if (count($ldc1) != 0) :
				$PCarrera1 = moda($ldc1);
				$cantidad1 = count($ldc1);
				echo '1)LA MODA:';
				print_r($ldc1);
				echo 'MODA:(' . $PCarrera1 . ')';
				if ($proceso != 8) :
					for ($e = 0; $e <= count($ldc1) - 1; $e++)
						if ($ldc1[$e] != $PCarrera1) :
							echo $Ldldc1[$e];
							echo '<br>';
							if ($Ldldc1[$e] > 0) :  $logro1[0] = $logro1[0] - $Ldldc1[$e];
								if ($Ldldc1[$e] != 0) : $l1[0]--;
								endif;
							else :                $logro1[1] = $logro1[1] - $Ldldc1[$e];
								if ($Ldldc1[$e] != 0) : $l1[1]--;
								endif;
							endif;
						endif;
				endif;
				if ($proceso == 8) :
					if ($PCarrera1 != 0) :
						for ($e = 0; $e <= count($ldlSel) - 1; $e++) {
							$eval =	$ldlSel[$e];
							if ($eval[0] != $PCarrera1) :	$eval[1] = 0;
								$ldlSel[$e] = $eval;
							endif;
						}
					endif;
				endif;
			endif;


			if ($periodo == 1000) :
				if ($_2periodo != -1) :
					if ($basesigno1 > 0) :
						$PCarrera1 = $msim;
					else :
						$PCarrera1 = -1 * $msim;
					endif;

					echo '##1' . $PCarrera1 . '<br>';
				endif;
			endif;
		else :
			$PCarrera1Pos = 0;
			$PCarrera1Neg = 0;
			if ($c1[0] != 0)  $PCarrera1Pos = $carrera1[0] / $c1[0];
			if ($c1[1] != 0)  $PCarrera1Neg = $carrera1[1] / $c1[1];

			if ($PCarrera1Neg != 0 && $PCarrera1Pos != 0) :
				$PCarrera1Neg = -1 * $PCarrera1Neg;
				$promedio = ($PCarrera1Pos + $PCarrera1Neg) / 2;
				if ($PCarrera1Pos > $PCarrera1Neg) : $PCarrera1 = $promedio;
				else : $PCarrera1 = '-' . $promedio;
				endif;
			else :
				if ($PCarrera1Neg == 0) :
					$PCarrera1 = $PCarrera1Pos;
				else :
					$PCarrera1 = $PCarrera1Neg;
				endif;
			endif;

			if ($periodo == 1000) :
				if ($_2periodo != -1) :
					if ($basesigno1 > 0) :
						$PCarrera1 = $msim;
					else :
						$PCarrera1 = -1 * $msim;
					endif;

					echo '##1' . $PCarrera1 . '<br>';

				endif;
			endif;
		endif;



		if ($proceso == 8 || $proceso == 9 || $proceso == 4 || $proceso == 5  || $proceso == 10) :
			if (count($ldc2) != 0) :
				print_r($ldc2);
				$PCarrera2 = moda($ldc2);
				$cantidad2 = count($ldc2);
				echo '2)LA MODA:';
				print_r($ldc2);
				echo 'MODA:(' . $PCarrera2 . ')';
				//	echo '<br>';echo 'LOG2:';print_r($logro2);
				if ($proceso != 8) :

					for ($e = 0; $e <= count($ldc2) - 1; $e++)
						if ($ldc2[$e] != $PCarrera2) :
							echo '%' . $Ldldc2[$e] . '%<br>';
							if ($Ldldc2[$e] > 0) :  $logro2[0] = $logro2[0] - $Ldldc2[$e];
								if ($Ldldc2[$e] != 0) : $l2[0]--;
								endif;
							else :                $logro2[1] = $logro2[1] - $Ldldc2[$e];
								if ($Ldldc2[$e] != 0) : $l2[1]--;
								endif;
							endif;
						endif;
					print_r($logro2);


				endif;
				if ($proceso == 8) :
					if ($PCarrera2 != 0) :
						for ($e = 0; $e <= count($ldlSel) - 1; $e++) {
							$eval =	$ldlSel[$e];
							if (($eval[0]) != ($PCarrera2)) :	$eval[1] = 0;
								$ldlSel[$e] = $eval;
							endif;
						}
					//	echo $PCarrera2.' CAMBIO:'; print_r($ldlSel); echo '$$';
					endif;
				endif;
			endif;
			if ($periodo == 1000) :
				if ($_2periodo != -1) :
					if ($basesigno2 > 0) :
						$PCarrera2 = $msim;
					else :
						$PCarrera2 = -1 * $msim;
					endif;
					echo '##2' . $PCarrera2 . '<br>';
				endif;
			endif;

		else :
			$PCarrera2Pos = 0;
			$PCarrera2Neg = 0;
			if ($c2[0] != 0)  $PCarrera2Pos = $carrera2[0] / $c2[0];
			if ($c2[1] != 0)  $PCarrera2Neg = $carrera2[1] / $c2[1];

			if ($PCarrera2Neg != 0 && $PCarrera2Pos != 0) :
				$PCarrera2Neg = -1 * $PCarrera2Neg;
				$promedio = ($PCarrera2Pos + $PCarrera2Neg) / 2;
				if ($PCarrera2Pos > $PCarrera2Neg) : $PCarrera2 = $promedio;
				else : $PCarrera2 = '-' . $promedio;
				endif;
			else :
				if ($PCarrera2Neg == 0) :
					$PCarrera2 = $PCarrera2Pos;
				else :
					$PCarrera2 = $PCarrera2Neg;
				endif;
			endif;
			if ($periodo == 1000) :
				if ($_2periodo != -1) :
					if ($basesigno2 > 0) :
						$PCarrera2 = $msim;
					else :
						$PCarrera2 = -1 * $msim;
					endif;
					echo '##2' . $PCarrera2 . '<br>';
				endif;
			endif;
		endif;

		/// LOGROS COHERENTES
		if ($logro1[0] > 0) :
			if ($logro1[0] < 100) : $logro1[0] = 0;
			endif;
		else :
			$Nlogro1 = $logro1[0] * -1;
			if ($Nlogro1 < 100) : $logro1[0] = 0;
			endif;
		endif;
		if ($logro2[0] > 0) :
			if ($logro2[0] < 100) : $logro2[0] = 0;
			endif;
		else :
			$Nlogro1 = $logro2[0] * -1;
			if ($Nlogro1 < 100) : $logro2[0] = 0;
			endif;
		endif;
		for ($e = 0; $e <= count($ldlSel) - 1; $e++) {
			$eval =	$ldlSel[$e];
			if ($eval[1] > 0) :
				if ($eval[1] < 100) : $eval[1] = 0;
				endif;
			else :
				$Nlogro1 = $eval[1] * -1;
				if ($Nlogro1 < 100) : $eval[1] = 0;
				endif;
			endif;
			$ldlSel[$e] = $eval;
		}


		//////////////// Logros /////////////////////
		if ($proceso == 8 || $proceso == 10) :
			// o es mayor que u, tengo que quitar los logros con u
			if ($Sou[0] > $Sou[1] && ($Sou[0] > 1 || $Sou[1] > 1)) :
				$logro1[0] = $logro1[0] - $sdlP[1];
				$l1[0] = $l1[0] - $Soup[1];
				$logro1[1] = $logro1[1] - $sdlN[1];
				$l1[1] = $l1[1] - $Soun[1];
				if ($proceso == 8) :
					for ($e = 0; $e <= count($ldlSel) - 1; $e++) {
						$eval =	$ldlSel[$e];
						if ($eval[3] == 'u')  $eval[1] = 0;
						$ldlSel[$e] = $eval;
					}
				endif;

			else :
				if ($Sou[0] > 1 || $Sou[1] > 1) :
					// u es mayor que o, tengo que quitar los logros con o
					$logro1[0] = $logro1[0] - $sdlP[0];
					$l1[0] = $l1[0] - $Soup[0];
					$logro1[1] = $logro1[1] - $sdlN[0];
					$l1[1] = $l1[1] - $Soun[0];
					if ($proceso == 8) :
						for ($e = 0; $e <= count($ldlSel) - 1; $e++) {
							$eval =	$ldlSel[$e];
							if ($eval[3] == 'o')  $eval[1] = 0;
							$ldlSel[$e] = $eval;
						}
					endif;
				endif;
			endif;
			if ($proceso == 8) :
				$logro1 = array();
				$l1 = array();
				for ($e = 0; $e <= count($ldlSel) - 1; $e++) {
					$eval =	$ldlSel[$e];
					if ($eval[1] > 0) : $logro1[0] += $eval[1];
						$l1[0]++;
					endif;
					if ($eval[1] < 0) : $logro1[1] += $eval[1];
						$l1[1]++;
					endif;
				}
			endif;
		endif;
		echo '1===';
		print_r($logro1);
		print_r($l1);
		print_r($ldlSel);
		echo '===';
		/*if ($proceso==4):
		 $Plogros1=moda($modaLogros1);
		else:*/
		$Plogros1Pos = 0;
		$Plogros1Neg = 0;
		if ($l1[0] != 0) $Plogros1Pos = $logro1[0] / $l1[0];
		if ($l1[1] != 0) $Plogros1Neg = $logro1[1] / $l1[1];

		if ($Plogros1Neg != 0 && $Plogros1Pos != 0) :
			$Plogros1Neg = -1 * $Plogros1Neg;
			$promedio = ($Plogros1Pos + $Plogros1Neg) / 2;
			if ($Plogros1Pos > $Plogros1Neg) : $Plogros1 = $promedio;
			else : $Plogros1 = '-' . $promedio;
			endif;
		else :
			if ($Plogros1Neg == 0) :
				$Plogros1 = $Plogros1Pos;
			else :
				$Plogros1 = $Plogros1Neg;
			endif;
		endif;
		/*endif;	*/


		if ($proceso == 8 || $proceso == 10) :
			// o es mayor que u, tengo que quitar los logros con u
			if ($Sou[0] > $Sou[1] && ($Sou[0] > 1 || $Sou[1] > 1)) :
				$logro2[0] = $logro2[0] - $sdlP2[1];
				$l2[0] = $l2[0] - $Soup2[1];
				$logro2[1] = $logro2[1] - $sdlN2[1];
				$l2[1] = $l2[1] - $Soun2[1];
				if ($proceso == 8) :
					for ($e = 0; $e <= count($ldlSel) - 1; $e++) {
						$eval =	$ldlSel[$e];
						if ($eval[3] == 'u')  $eval[1] = 0;
						$ldlSel[$e] = $eval;
					}
				endif;
			else :
				// u es mayor que o, tengo que quitar los logros con o
				if ($Sou[0] > 1 || $Sou[1] > 1) :
					$logro2[0] = $logro2[0] - $sdlP2[0];
					$l2[0] = $l2[0] - $Soup2[0];
					$logro2[1] = $logro2[1] - $sdlN2[0];
					$l2[1] = $l2[1] - $Soun2[0];
				endif;
				if ($proceso == 8) :
					for ($e = 0; $e <= count($ldlSel) - 1; $e++) {
						$eval =	$ldlSel[$e];
						if ($eval[3] == 'o')  $eval[1] = 0;
						$ldlSel[$e] = $eval;
					}
				endif;
			endif;
			if ($proceso == 8) :
				$logro2 = array();
				$l2 = array();
				for ($e = 0; $e <= count($ldlSel) - 1; $e++) {
					$eval =	$ldlSel[$e];
					if ($eval[1] > 0) : $logro2[0] += $eval[1];
						$l2[0]++;
					endif;
					if ($eval[1] < 0) : $logro2[1] += $eval[1];
						$l2[1]++;
					endif;
				}
			endif;
		endif;
		echo '2===';
		print_r($logro2);
		print_r($l2);
		print_r($ldlSel);
		echo '===';
		/*if ($proceso==4):
		 $Plogros2=moda($modaLogros2);
		else:*/
		$Plogros2Pos = 0;
		$Plogros2Neg = 0;
		if ($l2[0] != 0) $Plogros2Pos = $logro2[0] / $l2[0];
		if ($l2[1] != 0) $Plogros2Neg = $logro2[1] / $l2[1];
		if ($Plogros2Neg != 0 && $Plogros2Pos != 0) :
			$Plogros2Neg = -1 * $Plogros2Neg;
			$promedio = ($Plogros2Pos + $Plogros2Neg) / 2;
			if ($Plogros2Pos > $Plogros2Neg) : $Plogros2 = $promedio;
			else : $Plogros2 = '-' . $promedio;
			endif;
		else :
			if ($Plogros2Neg == 0) :
				$Plogros2 = $Plogros2Pos;
			else :
				$Plogros2 = $Plogros2Neg;
			endif;
		endif;
		/*endif;*/


		echo 'LOGROS:' . $Plogros1 . '_' . $Plogros2 . '(' . $proceso . ')';


		echo $n1[$j] . ' ' . $n2[$j] . '<br>';

		$result = mysqli_query($GLOBALS['link'], "Select * From _tbjuegodd where IDDD=$IDDD", $GLOBALS['link']);
		$row = mysqli_fetch_array($result);
		$columas = explode('|', $row['Columnas']);
		switch ($proceso) {
			case 4:
				$logrosto = '0|0|0|0';
				$logro1 = '';
				$logro2 = '';
				if ($row['logrosxdefecto'] != '') : $vl = explode('|', $row['logrosxdefecto']);
					$logro1 = $vl[0];
					$logro2 = $vl[1];
				endif;
				echo 'LOG' . $Plogros1 . '_' . $Plogros2;
				if ($Plogros1 != 0) :
					$logro1 = $Plogros1;
				else :
					if ($Plogros2 != 0) :
						$logro1 = $Plogros2;
					else :
						if ($Plogros1 >= 100) : $logro1 = $Plogros1;
						else : $logro1 = -110;
						endif;
					endif;
				endif;
				if ($PCarrera1 <= $msim && $PCarrera1 != 0  && $cantidad1 > $cantidad2) :
					$logrosto = redonl($logro1) . '|-' . redonl($PCarrera1) . '|' . redonl($logro1) . '|' . redonl($PCarrera1);
					if ($PCarrera1 == 0) : $logrosto = '|||';
					endif;
				else :
					if ($PCarrera2 <= $msim && $PCarrera2 != 0 && $cantidad2 > $cantidad1)
						$logrosto = redonl($logro1) . '|' . redonl($PCarrera2) . '|' . redonl($logro1) . '|-' . redonl($PCarrera2);
					if ($PCarrera2 == 0) : $logrosto = '|||';
					endif;
				endif;


				break;
			case 9:
				$logrosto = '0|0|0|0';
				$logro1 = '';
				$logro2 = '';
				if ($row['logrosxdefecto'] != '') : $vl = explode('|', $row['logrosxdefecto']);
					$logro1 = $vl[0];
					$logro2 = $vl[1];
				endif;
				echo 'LOG' . $Plogros1 . '_' . $Plogros2;
				if ($Plogros1 != 0) :
					$logro1 = round($Plogros1);

					$result = mysqli_query($GLOBALS['link'], "SELECT *  FROM _DBconver  where BaseM=$logro1", $GLOBALS['link']);
					$row = mysqli_fetch_array($result);
					echo "1SELECT *  FROM _DBconver  where BaseM=$logro1<br>";
					$logro2 = strval($row['BaseH']);

				else :
					if ($Plogros2 != 0) :
						$logro2 = round($Plogros2);
						$result = mysqli_query($GLOBALS['link'], "SELECT *  FROM _DBconver  where BaseM=$logro2", $GLOBALS['link']);
						$row = mysqli_fetch_array($result);
						echo "1SELECT *  FROM _DBconver  where BaseM=$logro2<br>";
						$logro1 = strval($row['BaseH']);
					endif;
				endif;
				echo '<br>****';
				echo $PCarrera1 . '<=' . $msim . '<br>';
				echo $PCarrera1 . '<br>';
				echo $PCarrera2 . '<br>';
				echo $cantidad1 . '>' . $cantidad2 . '<br>';
				echo '****<br>';
				switch ($periodo) {
					case 1000:
						$logrosto = redonl($logro2) . '|' . redonl($PCarrera1) . '|' . redonl($logro1) . '|' . redonl($PCarrera2);
						if ($PCarrera1 == 0) : $logrosto = '|||';
						endif;
						break;

					default:
						if ($PCarrera1 <= $msim && $PCarrera1 != 0  && $cantidad1 > $cantidad2) :
							$logrosto = redonl($logro1) . '|-' . redonl($PCarrera1) . '|' . redonl($logro2) . '|' . redonl($PCarrera1);
							if ($PCarrera1 == 0) : $logrosto = '|||';
							endif;
						else :
							if ($PCarrera2 <= $msim && $PCarrera2 != 0 && $cantidad2 > $cantidad1)
								$logrosto = redonl($logro1) . '|' . redonl($PCarrera2) . '|' . redonl($logro2) . '|-' . redonl($PCarrera2);
							if ($PCarrera2 == 0) : $logrosto = '|||';
							endif;
						endif;
				}
				break;
			case 8:
				$logrosto = '0|0|0|0';
				$logro1 = '';
				$logro2 = '';
				echo 'PC:' . $PCarrera1 . '_' . $PCarrera2;
				switch ($periodo) {
					case 1001:
						if ($PCarrera1 == 0) $nc = $PCarrera2;
						else $nc = $PCarrera1;
						echo "SELECT *  FROM _DBconverC  where Base=" . $nc;
						$result = mysqli_query($GLOBALS['link'], "SELECT *  FROM _DBconverC  where Base=" . $nc, $GLOBALS['link']);
						$row = mysqli_fetch_array($result);
						$logrosto = redonl($row['LogroSi']) . '|' . redonl($row['LogroNo']);
						break;

					default:


						if ($Plogros2 == 0 && $Plogros1 == 0) :
							$result = mysqli_query($GLOBALS['link'], "Select * From _tbjuegodd where IDDD=$IDDD", $GLOBALS['link']);
							$row = mysqli_fetch_array($result);
							if ($row['logrosxdefecto'] != '') : $vl = explode('|', $row['logrosxdefecto']);
								$logro1 = $vl[0];
								$logro2 = $vl[1];
							endif;
							if ($PCarrera1 == 0) :
								$logrosto = redonl($logro1) . '|' . redonl($PCarrera2) . '|' . redonl($logro2) . '|' . redonl($PCarrera2);
								if ($PCarrera2 == 0) : $logrosto = '|||';
								endif;
							else :
								$logrosto = redonl($logro1) . '|' . redonl($PCarrera1) . '|' . redonl($logro2) . '|' . redonl($PCarrera1);
								if ($PCarrera1 == 0) : $logrosto = '|||';
								endif;
							endif;
						else :
							if ($PCarrera1 == 0) :
								if ($Plogros2 != 0) :
									$logro1 = round($Plogros2);
									$logro2 = round($Plogros2);
								else :
									$logro1 = round($Plogros1);
									$logro2 = round($Plogros1);
								endif;
								//      o        u
								if ($Sou[0] > $Sou[1]) :
									$result = mysqli_query($GLOBALS['link'], "SELECT *  FROM _DBconver  where BaseM=$logro1", $GLOBALS['link']);
									$row = mysqli_fetch_array($result);
									echo "1SELECT *  FROM _DBconver  where BaseM=$logro1<br>";
									$logro2 = strval($row['BaseH']);
								//echo $logro2;
								else :
									$result = mysqli_query($GLOBALS['link'], "SELECT *  FROM _DBconver  where BaseM=$logro2", $GLOBALS['link']);
									$row = mysqli_fetch_array($result);
									echo "2SELECT *  FROM _DBconver  where BaseM=$logro2<br>";
									$logro1 = strval($row['BaseH']);
								//echo $logro1;
								endif;

								//if ( $row['logrosxdefecto']!='' ): $vl=explode('|',$row['logrosxdefecto']); $logro1=$vl[0]; $logro2=$vl[1]; endif;
								$logrosto = redonl($logro1) . '|' . redonl($PCarrera2) . '|' . redonl($logro2) . '|' . redonl($PCarrera2);
								if ($PCarrera2 == 0) : $logrosto = '|||';
								endif;
							else :
								if ($Plogros1 == 0 && $Plogros2 != 0) :
									$logro1 = round($Plogros2);
									$logro2 = round($Plogros2);
								else :
									$logro1 = round($Plogros1);
									$logro2 = round($Plogros1);
								endif;
								echo '&&&' . $logro1 . '_' . $logro2 . '&&&';
								if ($Sou[0] > $Sou[1]) :
									$result = mysqli_query($GLOBALS['link'], "SELECT *  FROM _DBconver  where BaseM=$logro1", $GLOBALS['link']);
									$row = mysqli_fetch_array($result);
									echo "3SELECT *  FROM _DBconver  where BaseM=$logro1<br>";
									$logro2 = strval($row['BaseH']);
								else :
									$resultdbo = mysqli_query($GLOBALS['link'], "SELECT *  FROM _DBconver  where BaseM=$logro2", $GLOBALS['link']);
									$rowdbo = mysqli_fetch_array($resultdbo);
									echo "4SELECT *  FROM _DBconver  where BaseH=$logro2<br>";
									$logro1 = strval($rowdbo['BaseH']);
									echo '*' . $rowdbo['BaseH'] . '*';
								endif;
								//if ( $row['logrosxdefecto']!='' ): $vl=explode('|',$row['logrosxdefecto']); $logro1=$vl[0]; $logro2=$vl[1]; endif;
								$logrosto = redonl($logro1) . '|' . redonl($PCarrera1) . '|' . redonl($logro2) . '|' . redonl($PCarrera1);
								if ($PCarrera1 == 0) : $logrosto = '|||';
								endif;

							endif;
						endif;
				}







				break;
			case 5:
				$logrosto = '0|0|0|0';
				$logro1 = '';
				$logro2 = '';
				if ($row['logrosxdefecto'] != '') : $vl = explode('|', $row['logrosxdefecto']);
					$logro1 = $vl[0];
					$logro2 = $vl[1];
				endif;
				if ($PCarrera1 != 0) :
					if ($logro1 == '') $logro1 = -110;
					$logrosto = redonl($logro1) . '|' . redonl($PCarrera1) . '|' . redonl($logro1) . '|' . redonl($PCarrera1);
					if ($PCarrera1 == 0) : $logrosto = '|||';
					endif;
				else :
					if ($logro1 == '') $logro1 = -110;

					$logrosto = redonl($logro1) . '|' . redonl($PCarrera2) . '|' . redonl($logro1) . '|' . redonl($PCarrera2);
					if ($PCarrera2 == 0) : $logrosto = '|||';
					endif;
				endif;

				break;
			case 6:
				$logrosto = '0|0|0|0';
				$logro1 = '';
				$logro2 = '';
				if ($row['logrosxdefecto'] != '') : $vl = explode('|', $row['logrosxdefecto']);
					$logro1 = $vl[0];
					$logro2 = $vl[1];
				endif;
				if ($PCarrera1 <= $msim && $PCarrera1 != 0 && $Plogros2 > 0) :
					if ($logro1 == '') $logro1 = -110;
					$logrosto = redonl($logro1) . '|' . redonl($Plogros2) . '|' . redonl($logro1) . '|' . redonl($Plogros2);
				else :
					if ($logro1 == '') $logro1 = -110;
					if ($PCarrera2 <= $msim && $PCarrera2 != 0 && $PCarrera1 > 0)
						$logrosto = redonl($logro1) . '|' . redonl($PCarrera1) . '|' . redonl($logro1) . '|' . redonl($PCarrera1);
					else
						$logrosto = redonl($logro1) . '|' . redonl($Plogros1) . '|' . redonl($logro1) . '|' . redonl($Plogros1);
				endif;

				break;
			default:
				if ($row['logrosxdefecto'] != '') : $vl = explode('|', $row['logrosxdefecto']);
					$Plogros1 = $vl[0];
					$Plogros2 = $vl[1];
				endif;
				if (count($columas) == 4) :
					echo 'Carreras:' . $PCarrera1 . ' ' . $PCarrera2;
					if ($periodo == 1000) :
						if ($Plogros1 == 0 || $Plogros2 == 0) :
							$logrosto = '|||';
						else :
							if ($ubi[0] == 1) : $logrosto = redonl($Plogros1) . '|' . $PCarrera1 . '|' . redonl($Plogros2) . '|' . $PCarrera2;
							endif;
							if ($ubi[1] == 1) : $logrosto = redonl($Plogros2) . '|' . $PCarrera1 . '|' . redonl($Plogros1) . '|' . $PCarrera2;
							endif;
						endif;
					else :
						if ($PCarrera1 == $PCarrera2)
							$logrosto = '|||';
						else
							$logrosto = redonl($Plogros1) . '|' . $PCarrera1 . '|' . redonl($Plogros2) . '|' . $PCarrera2;
					endif;
				endif;
				if (count($columas) == 2) :
					if ($proceso == 7) :
						if ($Plogros1 == 0 || $Plogros2 == 0) :
							$logrosto = '|';
						else :
							if ($ubi[0] == 1) : $logrosto = redonl($Plogros1) . '|' . redonl($Plogros2);
							endif;
							if ($ubi[1] == 1) : $logrosto = redonl($Plogros2) . '|' . redonl($Plogros1);
							endif;
						endif;
					else :
						$logrosto = redonl($Plogros1) . '|' . redonl($Plogros2);
					endif;
				endif;
				if (count($columas) == 1) :
					if ($Plogros1 != 0) : $logrosto = redonl($Plogros1);
					else : $logrosto = redonl($Plogros2);
					endif;
				endif;
		}
		$logrosto = $logrosto . '|';
		echo $logrosto . '<br>';

		/*if ($IDPn==0) $IDPx=$IDPn; else*/
		$IDPx = $IDPl;


		$result = mysqli_query($GLOBALS['link'], "Select * From _configuracionjugadabb where IDJ=$idj and Grupo=$Grupo and IDDD=$IDDD and IDP=$IDPx and IDB=$IDB ", $GLOBALS['link']);
		echo "Select * From _configuracionjugadabb where IDJ=$idj and Grupo=$Grupo and IDDD=$IDDD and IDP=$IDPx and IDB=$IDB ";
		if (mysqli_num_rows($result) == 0) :
			$result = mysqli_query($GLOBALS['link'], "Insert _configuracionjugadabb values ($idj,$IDPx,$IDDD,'$logrosto',$Grupo,0,$IDB)", $GLOBALS['link']);
			echo "Insert _configuracionjugadabb values ($idj,$IDPx,$IDDD,'$logrosto',$Grupo,0,$IDB)" . '<br>';
		else :
			$row = mysqli_fetch_array($result);
			$actu = $row['actualizado'] + 1;
			if ($row['Valores'] != $logrosto)
				$result = mysqli_query($GLOBALS['link'], "Update  _configuracionjugadabb  set 	Valores='$logrosto',actualizado=$actu where IDJ=$idj  and IDDD=$IDDD and Grupo=$Grupo and IDP=$IDPx and IDB=$IDB", $GLOBALS['link']);
			$result = mysqli_query($GLOBALS['link'], "Insert _uologro values ($idj,$IDDD,$actu,$IDPx,'" . time() . "');", $GLOBALS['link']);
			echo "Update  _configuracionjugadabb  set 	Valores='$logrosto',actualizado=$actu where IDJ=$idj  and IDDD=$IDDD and Grupo=$Grupo and IDP=$IDPx and IDB=$IDB<br>";
		endif;

	endif;
}
