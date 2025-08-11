        <?php
		$result_qw = mysqli_query($GLOBALS['link'], "SELECT * FROM _tabladetablascnf where  IDCN=" . $IDCN . " and Carr=" . $i);
		if (mysqli_num_rows($result_qw) == 0) :
			$estatus = 0;
		else :
			$row4 = mysqli_fetch_array($result_qw);
			$estatus = $row4['Estatus'];
		endif;

		?>
        <table width="720" border="0" cellspacing="0">
        	<tr bgcolor="#0066FF">
        		<th colspan="5" id="estatus<? echo $i; ?>" bgcolor="#FFFFFF" lang="<? echo $estatus; ?>">CARRERA No: <?php echo $i; ?> <img id='esta1<? echo $i; ?>' src="media/lock.png" onclick="click_mensaje_tabla(<? echo $i; ?>,<? echo $IDCN; ?>)" <? if ($estatus == 1) : echo 'style="display:none"';
																																																															endif; ?> /><img id='esta2<? echo $i; ?>' src="media/unlock.png" onclick="click_mensaje_tabla(<? echo $i; ?>,<? echo $IDCN; ?>)" ; <? if ($estatus == 0) : echo 'style="display:none"';
																																																																																																endif; ?> /></th>
        	</tr>
        	<tr bgcolor="#0066FF">
        		<th bgcolor="#FFFFFF">
        			<div></div>
        		</th>
        		<th bgcolor="#FFFFFF">
        			<div align="center">Ejemplar No.</div>
        		</th>
        		<th bgcolor="#FFFFFF">
        			<div align="left">Nombre</div>
        		</th>
        		<th bgcolor="#FFFFFF">Logro</th>
        		<th bgcolor="#FFFFFF"></th>
        	</tr>
        	<samp id="ne<?php echo $i; ?>" lang="<?php echo $canteje[$i - 1]; ?>"></samp>
        	<?php


			/* $result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tjugadabb where IDJ=".$idj."  and IDC='".$idc."' Order by Serial"); $insslq="SELECT * FROM _tjugadabb where IDJ=".$idj."  and IDC='".$idc."' Order by Serial"; */

			$rteje = explode('-', $retirados[$i - 1]);
			$u = 1;
			$ty = "'num'";
			for ($t = 1; $t <= intval($canteje[$i - 1]); $t++) {

				if ($u == 1) :
					$bgh = "nom3";
					$u = 2;
				else :
					$bgh = "nom4";
					$u = 1;
				endif;

				$result_qw = mysqli_query($GLOBALS['link'], "SELECT * FROM _tablaejempleares where  IDCN=" . $IDCN . " and Carr=" . $i . " and Noeje=" . $t);
				if (mysqli_num_rows($result_qw) == 0) :
					$nombreEje = '';
				else :
					$row = mysqli_fetch_array($result_qw);
					$nombreEje = $row['Nombre'];
				endif;

				$key = array_search($t, $rteje); // 										
				if ($key === false) :
					if (($t + 1) <= intval($canteje[$i - 1])) :
						$uno = "'eje" . $i . ($t + 1) . "'";
					else :
						$uno = "'eje" . $i . "1'";
					endif;

					$result_eje = mysqli_query($GLOBALS['link'], "SELECT * FROM _tabladetablas where  IDCN=" . $IDCN . " and Carr=" . $i . " and Noeje=" . $t);
					if (mysqli_num_rows($result_eje) == 0) :
						$xlogros = 0;
					else :
						$row_eje = mysqli_fetch_array($result_eje);
						$xlogros = $row_eje['logros'];
					endif;

					echo '<tr id="la' . $canteje[$i - 1] . '" class="' . $bgh . '"  class="' . $bgh . '">';

					echo '<th  id="la' . $canteje[$i - 1] . '1" class="' . $bgh . '"><div  align="right"  > <img  src="media/esact.png" height="16" width="16"  /></div></th>';

					echo '<th id="la' . $canteje[$i - 1] . '2" class="' . $bgh . '"><div align="center" class="EstiloCC">' . $t . '</div></th>';
					echo '<th id="la' . $canteje[$i - 1] . '3"  class="' . $bgh . '"><div align="letf" class="EstiloCC">' . $nombreEje . '</div></th>';

					echo '<th id="la' . $canteje[$i - 1] . '4"  class="' . $bgh . '"><div align="left" class="EstiloCC"><input type="text" id="eje' . $i . $t . '"  size="10"  value="' . $xlogros . '" onkeyup="focusobjbb2(event,' . $uno . ')" onkeypress="return permite(event,' . $ty . ');"/></div></th>';
				else :

					echo '<tr id="la' . $canteje[$i - 1] . '" class="' . $bgh . '"  class="' . $bgh . '">';

					echo '<th  id="la' . $canteje[$i - 1] . '1" class="' . $bgh . '"><div  align="right"  > <img  src="media/esact.png" height="16" width="16"  /></div></th>';

					echo '<th id="la' . $canteje[$i - 1] . '2" class="' . $bgh . '"><div align="center" class="EstiloCC">' . $t . '</div></th>';
					echo '<th id="la' . $canteje[$i - 1] . '3"  class="' . $bgh . '"><div align="letf" class="EstiloCC">' . $nombreEje . '</div></th>';

					echo '<th id="la' . $canteje[$i - 1] . '4"  class="' . $bgh . '"><div align="left" class="EstiloCC">RETIRADO</div></th>';

				endif;

				echo ' </tr>';
			}
			?>
        </table>