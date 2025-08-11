     <?php
		date_default_timezone_set('America/Caracas');
		$result_qw = mysqli_query($GLOBALS['link'], "SELECT * FROM _tabladetablascnf where  IDCN=" . $IDCN . " and Carr=" . $nc);
		if (mysqli_num_rows($result_qw) == 0) :
			$estatus = 0;
		else :
			$row4 = mysqli_fetch_array($result_qw);
			$estatus = $row4['Estatus'];
		endif;

		$result_por = mysqli_query($GLOBALS['link'], "SELECT * FROM _tablapremios where IDCN=" . $IDCN);
		$row_i = mysqli_fetch_array($result_por);
		$result_ejet = mysqli_query($GLOBALS['link'], "SELECT sum(logros) as logros FROM _tabladetablas where  IDCN=" . $IDCN . " and Carr=" . $nc . " and logros!=-1");
		$row_t = mysqli_fetch_array($result_ejet);


		$arepar = 0;
		if (mysqli_num_rows($result_por) != 0) :		$arepar = $row_i['Premio'];
		endif;
		if ($row_t['logros'] != 0) :
			$porcentaje = number_format(100 - ((($row_t['logros'] - $arepar) * 100) / $row_t['logros']), 2, '.', '');
		else :
			$porcentaje = 0;
		endif;

		?>
     <table border="0" cellspacing="0">
     	<tr bgcolor="#0066FF">
     		<th colspan="4" rowspan="2" bgcolor="#FFFFFF" id="estatus<? echo $i; ?>" lang="<? echo $estatus; ?>"> <img id='esta1' src="media/lock.png" <? if ($estatus == 1) : echo 'style="display:none"';
																																						endif; ?> /><img id='esta2' src="media/unlock.png" <? if ($estatus == 0) : echo 'style="display:none"';
																																																			endif; ?> /> &nbsp;&nbsp;&nbsp;</th>
     		<th rowspan="2" bgcolor="#993333" id="estatus<? echo $i; ?>" lang="<? echo $estatus; ?>"><span style="color:#FFFFFF">Premio x Tabla Bs.f:&nbsp;</span><span id="premiacion" lang="<? echo 	$arepar;  ?>" style="color:#FFFFFF; font-size:22px"> <? echo 	$arepar;  ?></span></th>
     		<th rowspan="2" bgcolor="#FFFFFF" id="estatus<? echo $i; ?>" lang="<? echo $estatus; ?>">&nbsp;</th>
     		<th id="estatus<? echo $i; ?>" bgcolor="#FFFFFF" lang="<? echo $estatus; ?>"><input id="botonimp" type="button" value="Cerrar Monitor" onclick="window.close();" /></th>
     	</tr>
     	<tr bgcolor="#0066FF">
     		<th id="estatus<? echo $i; ?>2" bgcolor="#FFFFFF" lang="<? echo $estatus; ?>">&nbsp;</th>
     	</tr>
     	<tr bgcolor="#0066FF">
     		<th bgcolor="#FFFFFF">
     			<div></div>
     		</th>
     		<th bgcolor="#FFFFFF">
     			<div align="center">Ejemplar No.</div>
     		</th>
     		<th bgcolor="#FFFFFF" width="250">
     			<div align="left">Nombre</div>
     		</th>
     		<th bgcolor="#FFFFFF" colspan="2">Logro</th>
     		<th bgcolor="#FFFFFF" colspan="2">Restan Tablas</th>
     	</tr>
     	<samp id="ne" lang="<?php echo $canteje[$nc - 1]; ?>"></samp>
     	<?php


			/* $result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tjugadabb where IDJ=".$idj."  and IDC='".$idc."' Order by Serial"); $insslq="SELECT * FROM _tjugadabb where IDJ=".$idj."  and IDC='".$idc."' Order by Serial"; */

			$rteje = explode('-', $retirados[$nc - 1]);
			$u = 1;
			$ty = "'num'";
			for ($t = 1; $t <= intval($canteje[$nc - 1]); $t++) {
				if ($u == 1) :
					$bgh = "nom3";
					$u = 2;
				else :
					$bgh = "nom4";
					$u = 1;
				endif;
				$result_qw = mysqli_query($GLOBALS['link'], "SELECT * FROM _tablaejempleares where  IDCN=" . $IDCN . " and Carr=" . $nc . " and Noeje=" . $t);
				if (mysqli_num_rows($result_qw) == 0) :
					$nombreEje = '';
				else :
					$row = mysqli_fetch_array($result_qw);
					$nombreEje = $row['Nombre'];
				endif;

				$key = array_search($t, $rteje); // 	

				if ($key === false) :
					if (($t + 1) <= intval($canteje[$nc - 1])) :
						$uno = "'ap" . ($t + 1) . "'";
					else :
						$uno = "'ap1'";
					endif;


					$result_eje = mysqli_query($GLOBALS['link'], "SELECT * FROM _tabladetablas where  IDCN=" . $IDCN . " and Carr=" . $nc . " and Noeje=" . $t);
					if (mysqli_num_rows($result_eje) == 0) :
						$xlogros = 0;
					else :
						$row_eje = mysqli_fetch_array($result_eje);
						$xlogros = $row_eje['logros'];
					endif;

					echo '<tr   id="linr' . $t . '" class="' . $bgh . '" >';

					echo '<th class="' . $bgh . '"><div  align="right"  > <img  src="media/esact.png" height="16" width="16"  /></div></th>';

					echo '<th  class="' . $bgh . '"><div align="center" style="color:#FFFFFF; font-size:22px" >' . $t . '</div></th>';
					echo '<th  class="' . $bgh . '"><div id="ejemplar' . $t . '" align="letf" style="color:#FFFFFF; font-size:22px">' . $nombreEje . '</div></th>';

					echo '<th  class="' . $bgh . '" colspan="2" align="left"><div align="left" style="color:#FFFFFF; font-size:22px"><span id="logros' . $t . '" lang="' . $xlogros . '">' . $xlogros . '</span></th>';


					echo '<th id="la' . $t . '"  class="' . $bgh . '" colspan="2"></th>';

					echo ' </tr>';

				else :

					echo '<tr id="linr' . $t . '" class="retirado"  >';

					echo '<th  class="retirado"><div  align="right"  > <img  src="media/esiact.png" height="16" width="16"  /></div></th>';

					echo '<th  class="retirado"><div align="center" class="EstiloCC">' . $t . '</div></th>';
					echo '<th   class="retirado"><div align="letf" class="EstiloCC">' . $nombreEje . '</div></th>';


					echo '<th id="la_1' . $t . '" class="retirado" colspan="2">RETIRADO</th>';
					echo '<th id="la' . $t . '"  class="retirado" colspan="2">RETIRADO</th>';

					echo ' </tr>';

				endif;
			}
			?>
     </table>