<?
date_default_timezone_set('America/Caracas');
if (isset($_REQUEST['tidcn'])) :
	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();

	$idcn = $_REQUEST['tidcn'];
	$tj = $_REQUEST['tj'];
	$activo1 = $_REQUEST['activo1'];
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegoshi where IDJug=" . $tj);
	$row = mysqli_fetch_array($result);
	$cantida_Carrera = $row["CantidadCarr"];
	$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfighi where IDCN=" . $idcn);
	$row3 = mysqli_fetch_array($result4);
	$config = explode("|", $row3["_Jug"]);
	$cantcb = explode("|", $row3["_Fab"]);
	$retira = explode("|", $row3["_Ret"]);
	for ($k = 0; $k <= count($config) - 1; $k++) {
		if ($row["Tandas"] == 2) :
			$_tem1 = explode("*", $config[$k]);
			$_tem = explode("$", $_tem1[0]);

			if ($_tem[0] == $tj) :
				break;
			endif;
		else :
			$_tem = explode("*", $config[$k]);
			if ($_tem[0] == $tj) :
				break;
			endif;
		endif;
	}
	/*   if ($row["Tandas"]==2):
   	$_xc=explode("-",$_tem1[1]);
   else:
   	$_xc=explode("-",$_tem[1]);   
   endif;*/
	$incremento = 0;
	if ($row["Tandas"] == 2) :
		if ($row["Compartir"] == 0) :
			$_xc = explode("-", $_tem1[1]);
		else :



			for ($jj = 0; $jj <= count($config) - 1; $jj++) {
				$_tem1 = explode("*", $config[$jj]);
				$_tem = explode("$", $_tem1[0]);
				$h = 0;
				if ($_tem[0] == $tj) :
					$_xcprototype = explode("-", $_tem1[1]);
					$carreras = 0;
					$h += $incremento;
					for ($ii = 0; $ii <= count($_xcprototype) - 2; $ii++) {
						if ($carreras != $cantida_Carrera) :
							$_xc[$h] = $_xcprototype[$ii];
							$h++;
							$carreras++;
						else :
							$h += $cantida_Carrera;
							$carreras = 0;
							$_xc[$h] = $_xcprototype[$ii];
							$h++;
							$carreras++;
						endif;
					}
					$incremento += $cantida_Carrera;

				endif;
			}

		endif;
		if (count($_xc) > 1) :
			ksort($_xc);
		endif;
	else :
		$_xc = explode("-", $_tem[1]);
	endif;


endif;


?>

<select id="carre_v" name="carre_v" onChange="focoobjhi('valida',<?php echo $tj; ?>,<?php echo $idcn; ?>,<?php echo $row["Tandas"]; ?>,<? echo $row["Compartir"]; ?>);">
	<?php
	$pric = -1;

	if ($row["Tandas"] == 1) :
		for ($r = 0; $r <= count($_xc) - 2; $r++) {
			$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrehi where  IDJug=" . $tj . " and ct=" . $_xc[$r] . " and IDCN=" . $idcn);
			if (mysqli_num_rows($result4) == 0) :
				echo "<option " . $_xc[$r] . " value='" . $r . '||' . $_xc[$r] . "'>" . $_xc[$r] . "</option>";
				if ($pric == -1) :
					$pric = $r;
				endif;
			endif;
		}

	else :
		$ct = 0;
		$tt = 1;
		$ccv = 0;
		/// Debo hacer una funcion que determinar la cantidad de Jornadas Configuradas
		if ($row["Compartir"] == 0) :
			for ($r = 0; $r <= count($_xc) - 2; $r++) {
				$ct++;
				if ($ct == $row["CantidadCarr"]) :
					$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrehi where  IDJug=" . $tj . " and ct=" . $tt . " and IDCN=" . $idcn);

					if (mysqli_num_rows($result4) == 0) :
						echo "<option " . $tt . " value='" . $tt . '||' . $tt . "'>" . $tt . "</option>";
						$tt++;
						if ($pric == -1) :
							if ($ccv != 0) :	$pric = $ccv + 1;
							else : $pric = $ccv;
							endif;
						endif;
					else :
						$tt++;
					endif;
					$ccv = $r;
					$ct = 0;
				endif;
			}
		else :
			for ($r = 0; $r <= count($_xc); $r++) {
				$ct++;
				if ($ct == $row["CantidadCarr"]) :
					$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrehi where  IDJug=" . $tj . " and ct=" . $tt . " and IDCN=" . $idcn);

					if (mysqli_num_rows($result4) == 0) :
						echo "<option " . $tt . " value='" . $tt . '||' . $tt . "'>" . $tt . "</option>";
						$tt++;
						if ($pric == -1) :
							if ($ccv != 0) :	$pric = $ccv + 1;
							else : $pric = $ccv;
							endif;
						endif;
					else :
						$tt++;
					endif;
					$ccv = $r;
					$ct = 0;
				endif;
			}
		endif;

	endif;
	?>
</select>