<br />
<div id="box3" style=" background:#333">
	<div id='tabladeconfiguracion'>
		<?php
		function configuracion($vl, $ntc, $ntpc, $ntdp)
		{
			$pos = strrpos($vl, "U");
			if ($pos === false) :
				$pos = strrpos($vl, "P");
				if ($pos === false) :
					$pos = strrpos($vl, "T");
					if ($pos === false) :
						$pos = strrpos($vl, "Y");
						if ($pos === false) :
							$pos = strrpos($vl, "Z");
							if ($pos === false) :
								return 1000;
							else :
								return $ntc - ($ntdp * substr($vl, 0, strrpos($vl, "Z")));
							endif;
						else :
							return $ntc - ($ntpc * substr($vl, 0, strrpos($vl, "Y")));
						endif;
					else :
						return 0;
					endif;
				else :
					return -1;
				endif;
			else :
				return $ntc - substr($vl, 0, strrpos($vl, "U"));
			endif;
		}


		$tc = $_REQUEST['nc'];
		$ntp4 = $_REQUEST['ntp4'];
		$ntdp = $_REQUEST['ntdp'];
		$tnj = $_REQUEST['nj'];

		require('prc_php.php');
		$GLOBALS['link'] = Connection::getInstance();
		$carga = 0;
		$result = mysqli_query($GLOBALS['link'], "Select * from _tconfig where IDCN=" . $tnj);

		if (mysqli_num_rows($result) != 0) :
			$carga = 1;
			$row = mysqli_fetch_array($result);
			$config = explode("|", $row["_Jug"]);
			$cantcb = explode("|", $row["_Fab"]);
			$retira = explode("|", $row["_Ret"]);
			$hora = explode("|", $row["_hora"]);

			$fecha = $row["_Fecha"];

			$result = mysqli_query($GLOBALS['link'], "Select * from _tconfjornada where IDCN=" . $tnj);
			$row = mysqli_fetch_array($result);
			$idhipo = $row["IDhipo"];
			$CantCarr = $row["Cantcarr"];
			$NTDp2 = $row["NTDp"];
			$NTDta2 = $row["NTDta"];
			$NTDP42 = $row["NTDP4"];
			if ($CantCarr != $tc or $NTDp2 != $ntdp or $NTDP42 != $ntp4) :
				$carga = 0;
			endif;

		endif;

		$result = mysqli_query($GLOBALS['link'], "Select * from _tdjuegos");
		?>
		<table id='tblcgn' border="1" cellpadding="3" cellspacing="-1">
			<tr bgcolor="#4179E0 ">
				<th width="45" scope="col" align="center" style="color:#FFF">
					<div align="center">Carr</div>
				</th>
				<th width="38" scope="col" align="center" style="color:#FFF">
					<div align="center">Ejem.</div>
				</th>
				<?php
				$ti = 0;
				while ($row = mysqli_fetch_array($result)) {
					$ti++;
					$identi = "'t" . $ti . "'";
					echo '<th width="100" scope="col" align="center"  style="color:#FFF"><span id=' . $identi . ' title="' . $row["IDJug"] . '" >' . $row["Descrip"] . '</span></th>';
				}
				echo '<th scope="col" align="center"  style="color:#FFF" colspan="4"><span  align="center">Hora<br />(HH:MM)</span></th>';

				echo '<th width="200" scope="col" align="center"  style="color:#FFF"><span id="reti">Retirados</span></th>';

				?>
			</tr>
			<?php

			for ($i = 1; $i <= $tc; $i++) {
				if (fmod($i, 2) == 0) :
					echo '<tr style=" background: #666 ">';
				else :
					echo '<tr>';
				endif;

				for ($j = 0; $j <= $ti + 1; $j++) {

					switch ($j) {
						case 0:
							echo '<th width="28" scope="col" align="center"><span style="color:#FFF">' . $i . '</span></th>';
							break;
						case 1:

							if ($i == $tc) {
								$g = "'ejem1'";
							} else {
								$g = "'ejem" . ($i + 1) . "'";
							}
							if ($carga == 0) :
								echo '<th width="28" scope="col" align="center"> <input type="text" size="4" name="ejem' . $i . '" id="ejem' . $i . '" value=0 onkeyup = "pulsart(event,' . $g . ')"" > </th>';
							else :
								//$valoresdec=explode("*",$config[$i]);
								echo '<th width="28" scope="col" align="center"> <input type="text" size="4" name="ejem' . $i . '" id="ejem' . $i . '" value="' . $cantcb[$i - 1] . '" onkeyup = "pulsart(event,' . $g . ')"" > </th>';
							endif;
							break;

						default:

							$result = mysqli_query($GLOBALS['link'], "Select * from _tdjuegos where IDjug=" . ($j - 1));
							//  echo "Select * from _tdjuegos where IDjug=".($j-1);
							$row = mysqli_fetch_array($result);
							$idchel = "chek" . ($j - 1) . "-" . $i;

							if ($carga == 0) :  //realiza este proceso en casos de que no se tenga que cargar la configuracion
								if ($row['Tandas'] != 2) :
									$marcar = configuracion($row['Config'], $tc, $ntp4, $ntdp);
								else :
									$marcar = configuracion($row['CantidadCarr'] . 'Y', $tc, $ntp4, $ntdp);
								endif;

								if ($marcar == -1) :
									$tope = substr($row['Config'], 0, strrpos($row['Config'], "P"));
									if ($i <= $tope) :
										echo '<th width="28" scope="col" align="center"> <input id=' . $idchel . ' type="checkbox" value="" title="' . $idchel . '" checked></th>';
									else :
										echo '<th width="28" scope="col" align="center"> <input id=' . $idchel . ' name="" type="checkbox" value="" title="' . $idchel . '" ></th>';
									endif;
								else :
									if ($i > $marcar) :
										echo '<th width="28" scope="col" align="center"> <input id=' . $idchel . ' name="" type="checkbox" value=""  title="' . $idchel . '"checked></th>';
									else :
										echo '<th width="28" scope="col" align="center"> <input id=' . $idchel . ' name="" type="checkbox" title="' . $idchel . '" value="" ></th>';
									endif;
								endif;

							else :
								//****************************************
								$valoresdec = explode("*", $config[($j - 1)]);
								$valorverr = explode("-", $valoresdec[1]);
								//echo $i;
								//$v=array_search($i,$valorverr);
								//print_r($valorverr);
								if (is_int(array_search($i, $valorverr))) :
									echo '<th width="28" scope="col" align="center"> <input id=' . $idchel . ' type="checkbox" value="" title="' . $idchel . '" checked></th>';
								else :
									echo '<th width="28" scope="col" align="center"> <input id=' . $idchel . ' name="" type="checkbox" value="" title="' . $idchel . '" ></th>';
								endif;
							//***************************************
							endif;
					}
				}
				if ($i == $tc) {
					$g = "'reti1'";
				} else {
					$g = "'reti" . ($i + 1) . "'";
				}
				$uno = "'m" . $i . "'";
				$dos = "'h" . $i . "'";
				$h = explode(":", $hora[$i - 1]);
				if ($carga == 0) :
					echo '<th  > <input id="h' . $i . '"  type="text"  size="1"  onkeypress="focusobjbbg(event,' . $uno . ',1);"/> </th><th  >:</th><th ><input id="m' . $i . '"  type="text"  size="1"  onkeypress="focusobjbbg(event,' . $dos . ',2);"/></th> <th  ><img id="i' . $i . '" src="media/estrella.png" width="8" height="8"  lang="' . $i . '"title="Copiar Horas" onclick="copiarhoras(event);"/></th>';
				else :
					echo '<th   <input id="h' . $i . '" value="' . $h[0] . '"  size="1" type="text" onkeyup = " onkeypress="focusobjbbg(event,' . $uno . ',1);"/> </th><th  >:</th><th ><input id="m' . $i . '" value="' . $h[1] . '"  size="1" type="text" onkeyup = " onkeypress="focusobjbbg(event,' . $dos . ',2);"/> </th> <th  ><img id="i' . $i . '" src="media/estrella.png" width="8" height="8"  lang="' . $i . '"title="Copiar Horas" onclick="copiarhoras(event);"/></th>';

				endif;
				if ($carga == 0) :
					echo '<th width="28" scope="col" align="center"> <input id="reti' . $i . '"  type="text"   onkeyup = "pulsart(event,' . $g . ')""/> </th>';
				else :
					echo '<th width="28" scope="col" align="center"> <input id="reti' . $i . '" value="' . $retira[$i - 1] . '" type="text" onkeyup = "pulsart(event,' . $g . ')"/> </th>';
				endif;
				echo '</tr>';
			}
			?>
		</table>

		<input id="btngrb" type="button" value="Grabar" onClick="_grabcont('jornada-3.php');" alt="<?php echo $ti; ?>">
		<div id="divresul" style="color:#FFF; font-size:12px"></div>
	</div>
</div>

<script>
	Nifty('div#box3');
</script>