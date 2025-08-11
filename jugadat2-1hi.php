 <?php
	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();

	$tp = $_REQUEST['tp'];
	$cr = $_REQUEST['cr'];
	$IDCN = $_REQUEST['idcn'];
	$et = $_REQUEST['ept'];
	$crv = $_REQUEST['crv'];
	$compartir = $_REQUEST['compartir'];
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrehi where  IDJug=" . $tp . " and ct=" . $crv . " and IDCN=" . $IDCN);

	if (mysqli_num_rows($result) == 0) :
		$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfighi where IDCN=" . $IDCN);
		$row3 = mysqli_fetch_array($result4);
		$config = explode("|", $row3["_Jug"]);
		$cantcb = explode("|", $row3["_Fab"]);
		$retira = explode("|", $row3["_Ret"]);
		for ($k = 0; $k <= count($config) - 1; $k++) {
			if ($et == 2) :
				$_tem1 = explode("*", $config[$k]);
				$_tem = explode("$", $_tem1[0]);

				if ($_tem[0] == $tp) :
					break;
				endif;
			else :
				$_tem = explode("*", $config[$k]);
				if ($_tem[0] == $tp) :
					break;
				endif;
			endif;
		}
		if ($et == 2) :
			if ($compartir == 0) :
				$_xc = explode("-", $_tem1[1]);
			else :
				$result5 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegoshi where IDJug=" . $tp);
				$row = mysqli_fetch_array($result5);

				$incremento = 0;
				for ($jj = 0; $jj <= count($config) - 1; $jj++) {
					$_tem1 = explode("*", $config[$jj]);
					$_tem = explode("$", $_tem1[0]);
					$h = 0;
					if ($_tem[0] == $tp) :
						$_xcprototype = explode("-", $_tem1[1]);
						$carreras = 0;
						$h += $incremento;
						for ($ii = 0; $ii <= count($_xcprototype) - 2; $ii++) {
							if ($carreras != $row["CantidadCarr"]) :
								$_xc[$h] = $_xcprototype[$ii];
								$h++;
								$carreras++;
							else :
								$h += $row["CantidadCarr"];
								$carreras = 0;
								$_xc[$h] = $_xcprototype[$ii];
								$h++;
								$carreras++;
							endif;
						}
						$incremento += $row["CantidadCarr"];
					endif;
				}

			endif;
		else :
			$_xc = explode("-", $_tem[1]);
		endif;
		ksort($_xc);

		if ($et == 2) :
			$result5 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegoshi where IDJug=" . $tp);
			$row5 = mysqli_fetch_array($result5);

			if (((count($_xc) + 1) / $row5['CantidadCarr']) >= $cr) :
				$ici = ($row5['CantidadCarr'] * $cr) - $row5['CantidadCarr'];
			else :
				$ici = 0;
			endif;

			$cvde = array_slice($_xc, $ici, $row5['CantidadCarr']);


			if (count($cantcb) != 0) :
				for ($e = 0; $e <= count($cvde) - 1; $e++) {
					$cb[$e] = $cantcb[$cvde[$e] - 1];
				}
			endif;
			echo "true||" . implode('-', $cb) . "||" . implode('-', $cvde) . '||' . $cvde[0];
		else :
			$carrr = $_xc[$cr] - 1;
			$cejem = $cantcb[$carrr];
			echo "true||" . $cejem . "||" . $retira[$carrr] . '||0';
		endif;


	else :
		echo "false||0";
	endif
	?>
