        <?php
		$result_qw = mysqli_query($GLOBALS['link'], "SELECT * FROM _tabladetablascnf where  IDCN=" . $IDCN . " and Carr=" . $nc);
		if (mysqli_num_rows($result_qw) == 0) :
			$estatus = 0;
		else :
			$row4 = mysqli_fetch_array($result_qw);
			$estatus = $row4['Estatus'];
		endif;

		?>
        <table border="0" cellspacing="0">
        	<tr bgcolor="#0066FF">
        		<th colspan="6" id="estatus<? echo $i; ?>" bgcolor="#FFFFFF" lang="<? echo $estatus; ?>"> <img id='esta1' src="media/lock.png" <? if ($estatus == 1) : echo 'style="display:none"';
																																				endif; ?> /><img id='esta2' src="media/unlock.png" <? if ($estatus == 0) : echo 'style="display:none"';
																																																	endif; ?> /> Ticket no: <span id='numet' title="" class="Estilo12"> </span>&nbsp;&nbsp;&nbsp;<input id="botonimp" type="button" value="Imprimir Ticket" onclick="imprimirtabla()" /></th>
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
        		<th bgcolor="#FFFFFF">Logro</th>
        		<th bgcolor="#FFFFFF">Apuesta BsF.</th>
        		<th bgcolor="#FFFFFF">Restan Tablas</th>
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

					echo '<tr  class="' . $bgh . '"  class="' . $bgh . '">';

					echo '<th class="' . $bgh . '"><div  align="right"  > <img  src="media/esact.png" height="16" width="16"  /></div></th>';

					echo '<th  class="' . $bgh . '"><div align="center" class="EstiloCC">' . $t . '</div></th>';
					echo '<th  class="' . $bgh . '"><div id="ejemplar' . $t . '" align="letf" class="EstiloCC">' . $nombreEje . '</div></th>';

					echo '<th  class="' . $bgh . '"><div align="left" class="EstiloCC"><span id="logros' . $t . '">' . $xlogros . '</div></th>';

					echo '<th   class="' . $bgh . '"><input id="ap' . $t . '" type="text" size="10" value="0" onkeyup="focusobjbb2(event,' . $uno . '); sumadelticket();" onkeypress="return permitetablas(event,' . $ty . ',' . $t . ');"/></th>';
					echo '<th id="la' . $t . '"  class="' . $bgh . '"></th>';
					echo ' </tr>';

				else :

					echo '<tr class="' . $bgh . '"  class="' . $bgh . '">';

					echo '<th   class="' . $bgh . '"><div  align="right"  > <img  src="media/esiact.png" height="16" width="16"  /></div></th>';

					echo '<th  class="' . $bgh . '"><div align="center" class="EstiloCC">' . $t . '</div></th>';
					echo '<th   class="' . $bgh . '"><div align="letf" class="EstiloCC">' . $nombreEje . '</div></th>';

					echo '<th  class="' . $bgh . '"><div align="left" class="EstiloCC"><span id="sprytextfield1">RETIRADO</div></th>';
					echo '<th  class="' . $bgh . '"></th>';
					echo '<th id="la' . $t . '"  class="' . $bgh . '"></th>';
					echo ' </tr>';

				endif;
			}
			?>
        </table>
        <br /><br />

        <table width="500" border="0" cellspacing="0" cellpadding="0">
        	<tr>
        		<th scope="col" bgcolor="#FFFFFF">Total del Ticket Bsf.:</th>
        		<th scope="col" bgcolor="#FFFFFF" align="right">
        			<div align="right"><samp id="totalver" style=" font-size:16px; color:#000000"> </samp><input id="Total" type="text" disabled="disabled" value="0" style="display:none" /></div>
        		</th>
        	</tr>
        </table>