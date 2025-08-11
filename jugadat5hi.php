<head>
	<?php
	date_default_timezone_set('America/Caracas');
	$tj = $_GET['tj'];
	$idc = $_GET['idc'];
	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegoshi where IDJug=" . $tj);
	$row = mysqli_fetch_array($result);
	if ($row["Tandas"] == 2) :
		$tex = "Tanda";
	else :
		$tex = "Carrera";
	endif;
	$apm = $row['ApuestaMinima'];
	//$result2 = mysqli_query($GLOBALS['link'],"Select sphonline.vx('Ticket') as num;"  );
	//$row2 = mysqli_fetch_array($result2); 
	// Cheque la configuracion activa
	$masde = false;
	$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where Estatus=1 and fecha='" . date("d/n/Y") . "' order by IDCN");
	// echo "SELECT * FROM _tconfjornada where Estatus=1 and fecha='".date("d/n/Y")."' order by IDCN";
	if (mysqli_num_rows($result3) != 0) :

		if (mysqli_num_rows($result3) > 1) :
			$masde = true;
		endif;

		$row3 = mysqli_fetch_array($result3);
		$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfighi where IDCN=" . $row3["IDCN"]);
		//echo "SELECT * FROM _tconfig where IDCN=".$row3["IDCN"];
		$row3 = mysqli_fetch_array($result4);
		$idcn = $row3["IDCN"];
		$config = explode("|", $row3["_Jug"]);
		$cantcb = explode("|", $row3["_Fab"]);
		$retira = explode("|", $row3["_Ret"]);
		for ($k = 0; $k <= count($config) - 1; $k++) {
			$_tem = explode("*", $config[$k]);
			if ($_tem[0] == $tj) :
				break;
			endif;
		}
		$_xc = explode("-", $_tem[1]);
		//   print_r($_xc);  print_r($cantcb);
		$activo1 = 1;
	else :
		$activo1 = 0;
		$idcn = 0;
		for ($k = 0; $k <= $row["CantidadCarr"] + 1; $k++) {

			$_xc[$k] = $k + 1;
			$cantcb[$k] = 0;
			$retira[$k] = 0;
		}
	endif;
	// print_r($_xc);  print_r($cantcb);
	?>


	<style type="text/css">
		<!--
		.Estilo1 {
			font-family: Arial, Helvetica, sans-serif;
			color: #FFFFFF;
			font-size: 14px;
		}
		-->
	</style>
</head>
<?php
$activar = 0;
$pric = -1;
if ($activo1 == 1) :

	if ($row["Tandas"] == 1) :

		for ($r = 0; $r <= count($_xc) - 2; $r++) {

			$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrehi where  IDJug=" . $tj . " and ct=" . $_xc[$r] . " and IDCN=" . $row3["IDCN"]);
			if (mysqli_num_rows($result4) == 0) :
				$activar = $_xc[$r];
				if ($pric == -1) :
					$pric = $r;
				endif;
			endif;
		}
	else :
		$ct = 0;
		$tt = 1;
		for ($r = 0; $r <= count($_xc) - 2; $r++) {
			$ct++;
			if ($ct == $row["CantidadCarr"]) :
				$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrehi where  IDJug=" . $tj . " and ct=" . $tt . " and IDCN=" . $row3["IDCN"]);
				if (mysqli_num_rows($result4) == 0) :
					$activar = $tt;
					$tt++;
					if ($pric == -1) :
						$pric = $ct;
					endif;
				else :
					$tt++;
				endif;
				$ct = 0;
			endif;
		}
	endif;
endif;

if ($activar != 0) : ?>
	<span id='TIDCN' lang="<? echo $idcn; ?>"></span>
	<div id="box_j" style="background:<?php echo $row["Color"] ?>">

		<a id="apm" lang="<?php echo $apm; ?>"></a>
		<table width="366" height="159" border="0">
			<tr>
				<td colspan="3"><span id='tj' title="<?php echo $tj; ?>" style="color: #FFFFFF; font-size:18px"><?php echo $row["Descrip"] ?></span></td>
			</tr>
			<tr>
				<td><span style="color: #FFCC00"><strong>N.Ticket:</strong> <span id='numet' title="" class="Estilo12"> </span></td>
				<td>&nbsp;</td>
				<td id="multi" align="left" valign="middle" title="<?php echo $row["Multip"]; ?>">
					<div align="right" style="color: #FFCC00; font-size:16px">X <?php echo $row["Multip"]; ?></div>
				</td>
			</tr>
			<tr bgcolor="#4179E0">
				<td>Carrera: <label id="inclcarr">
						<? $uno = 0;
						$idcar = 0;
						include('jugadat5-2hi.php'); ?>
					</label>
					<p title="<?php echo $row["CantidadCarr"]; ?>">Puesto:</p>
					<label>
						<input type="text" id="valida" value="1" onkeyup="pulsarhi(event,1,2,<?php echo $row["calculo"]; ?>)" <?php if ($idc == -2 || $idc == -1) : 	echo 'disabled="disabled"';
																																else : echo '';
																																endif; ?> />
					</label>
					<p id="ejemp" class="Estilo40" title="<?php echo $row["EjemxCarr"]; ?>">Ejemplar:</p>
					<label>
						<input type="text" id="ejem" onkeyup="pulsarhi(event,2,2,<?php echo $row["calculo"]; ?>)" <?php if ($idc == -2 || $idc == -1) : 	echo 'disabled="disabled"';
																													else : echo '';
																													endif; ?> />
						<br />

						<label> </label>
				</td>
				<td colspan="2" valign="middle">
					<?php
					//
					echo '<table border="0">';

					if ($row["Tandas"] == 1) :
						if ($pric != -1) :
							$carrr = $_xc[$pric] - 1;
							$cejem = $cantcb[$carrr];
						else :
							$activo1 = 0;
							for ($k = 0; $k <= $row["CantidadCarr"] + 1; $k++) {
								$_xc[$k] = $k + 1;
								$cantcb[$k] = 0;
								$retira[$k] = 0;
							}
							$carrr = 0;
							$cejem = $cantcb[$carrr];
						endif;
					endif;



					for ($i = 1; $i <= $row["CantidadCarr"]; $i++) {
						if ($row["Tandas"] == 2) :


							if ((count($_xc) - 1) != 0) :
								$cejem = $cantcb[$_xc[$pric] - 1];
								$retirado = explode("-", $retira[$_xc[$pric] - 1]);
								$pric++;
							else :
								$cejem = 0;
								$retirado[0] = 0;
							endif;

						else :
							$retirado = explode("-", $retira[$carrr]);
						endif;

						if ($i != 1) :
							echo '<tr>';
						endif;

						echo '<th width="17" scope="col" title="' . $cejem . '"><span style="color:#000000; font-size:16px">' . $i . '.-</span></th>';
						echo '<th width="6" bordercolor="#ffffff" bgcolor="#FFFFFF" scope="col"><img src="media/marcar_todos_blanco.bmp" onclick="celdasicons(' . $i . ',' . $row["calculo"] . ');" /></th>';
						//print_r($retirado);
						//echo $cejem;
						//echo $_xc[$i-1]-1;

						for ($j = 1; $j <= $row["EjemxCarr"]; $j++) {
							if ($j <= $cejem) :
								$activo = '#26354A';
								$numk = $j;
							else :
								$numk = '';
								$activo = '#999999';
							endif;
							if (!(array_search($j, $retirado) === false)) :
								if ($row["Tandas"] != 2) :
									$numk = '';/*#0066FF*/
									$activo = '#FF0000';
								endif;
							endif;

							echo '<th  id="celda' . $i . '' . $j . '" width="13" scope="col" bgcolor="' . $activo . '" title="' . $numk . '" bordercolor="#ffffff" onclick="cambiarcelda(event,' . $row["calculo"] . ',' . $i . ');"><span class="Estilo1">' . $j . '</span></th>';
						}
						echo '<th width="30" bgcolor="#FFFFFF" scope="col"> <input type="text" id="v' . $i . '" size="3"  disabled="disabled" /></th>';
						echo '<th width="103"  scope="col"></th>';
						echo '</tr>';
					}

					echo '</table>';
					?>

				</td>
			</tr>
			<tr>
				<td>Carrera:<label id="inclcarr"><? $uno = 2;
													$idcar = 1;
													include('jugadat5-2hi.php'); ?>
					</label>
					<p title="<?php echo $row["CantidadCarr"]; ?>">Puesto:</p>
					<label>
						<input type="text" id="valida2" value="1" onkeyup="pulsarhi(event,1,2,<?php echo $row["calculo"]; ?>)" <?php if ($idc == -2 || $idc == -1) : 	echo 'disabled="disabled"';
																																else : echo '';
																																endif; ?> />
					</label>
					<p id="ejemp" class="Estilo40" title="<?php echo $row["EjemxCarr"]; ?>">Ejemplar:</p>
					<label>
						<input type="text" id="ejem2" onkeyup="pulsarhi(event,2,2,<?php echo $row["calculo"]; ?>)" <?php if ($idc == -2 || $idc == -1) : 	echo 'disabled="disabled"';
																													else : echo '';
																													endif; ?> />
						<br />

						<label> </label>
				</td>
				<td colspan="2"><?php
								//
								echo '<table border="0">';

								if ($row["Tandas"] == 1) :
									if ($pric != -1) :
										$carrr = $_xc[$pric] - 1;
										$cejem = $cantcb[$carrr];
									else :
										$activo1 = 0;
										for ($k = 0; $k <= $row["CantidadCarr"] + 1; $k++) {
											$_xc[$k] = $k + 1;
											$cantcb[$k] = 0;
											$retira[$k] = 0;
										}
										$carrr = 0;
										$cejem = $cantcb[$carrr];
									endif;
								endif;



								for ($i = 1; $i <= $row["CantidadCarr"]; $i++) {
									if ($row["Tandas"] == 2) :


										if ((count($_xc) - 1) != 0) :
											$cejem = $cantcb[$_xc[$pric] - 1];
											$retirado = explode("-", $retira[$_xc[$pric] - 1]);
											$pric++;
										else :
											$cejem = 0;
											$retirado[0] = 0;
										endif;

									else :
										$retirado = explode("-", $retira[$carrr]);
									endif;

									if ($i != 1) :
										echo '<tr>';
									endif;

									echo '<th width="17" scope="col" bgcolor=' . $row["Color"] . ' title="' . $cejem . '"><span style="color:#000000; font-size:16px">' . $i . '.-</span></th>';
									echo '<th width="6" bordercolor="#ffffff" bgcolor="#FFFFFF" scope="col"><img src="media/marcar_todos_blanco.bmp" onclick="celdasicons(' . $i . ',' . $row["calculo"] . ');" /></th>';
									//print_r($retirado);
									//echo $cejem;
									//echo $_xc[$i-1]-1;

									for ($j = 1; $j <= $row["EjemxCarr"]; $j++) {
										if ($j <= $cejem) :
											$activo = '#26354A';
											$numk = $j;
										else :
											$numk = '';
											$activo = '#999999';
										endif;
										if (!(array_search($j, $retirado) === false)) :
											if ($row["Tandas"] != 2) :
												$numk = '';/*#0066FF*/
												$activo = '#FF0000';
											endif;
										endif;

										echo '<th  id="celda2_' . $i . '' . $j . '" width="13" scope="col" bgcolor="' . $activo . '" title="' . $numk . '" bordercolor="#ffffff" onclick="cambiarcelda(event,' . $row["calculo"] . ',' . $i . ');"><span class="Estilo1">' . $j . '</span></th>';
									}
									echo '<th width="30" bgcolor="#FFFFFF" scope="col"> <input type="text" id="v2_' . $i . '" size="3"  disabled="disabled" /></th>';
									echo '<th width="103" bgcolor=' . $row["Color"] . ' scope="col"></th>';
									echo '</tr>';
								}

								echo '</table>';
								?> </td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td><span style="color: #000000; font-size:16px"> Monto:</span>
					<input id="idmonto" type="text" size="11" onkeyup="pulsarhi(event,3,2,<?php echo $row["calculo"]; ?>)" disabled="disabled" />
				</td>
				<td>&nbsp;</td>
				<td>
					<div align="right"><span style="color: #000000; font-size:16px">Total Bs.F.</span>
						<input type="text" name="Total" id="Total" disabled="disabled" />
					</div>
				</td>
			</tr>
		</table>
		<script type="text/javascript">
			ticketassig();
			Nifty('div#box_j');
		</script>

	</div>
<?php else :
	echo '<div align="center">
<div class="dialogx">
 <div class="hdx"><div class="cx"></div></div>
 <div class="bdx">
  <div class="cx">
   <div class="sx"><div align="center" style=" font-size:24px; font:bold">Jugada Cerrada</p>
  <table width="300" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center" style="font-size:18px; font:bold"; font:#ffffff>Les notificamos que la jugada ha sido bloqueda para la venta</div></td>
	
  </tr>
</table></div> </div>
  </div>
 </div>
 <div class="ftx"><div class="cx"></div></div>
</div></div>';
endif; ?>
<input id="c" type="text" style="display:none" />