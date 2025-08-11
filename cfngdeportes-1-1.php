 <table width="720" border="0" cellspacing="0">
 	<tr bgcolor="#0066FF">
 		<th colspan="4" bgcolor="#FFFFFF">CARRERA No: <?php echo $i; ?></th>
 	</tr>
 	<tr bgcolor="#0066FF">
 		<th bgcolor="#FFFFFF" width="50px">
 			<div></div>
 		</th>
 		<th bgcolor="#FFFFFF" width="50px">
 			<div align="center">Ejemplar No.</div>
 		</th>
 		<th bgcolor="#FFFFFF" width="300px">
 			<div align="center">Nombre</div>
 		</th>

 		<th bgcolor="#FFFFFF"></th>
 	</tr>
 	<samp id="ne<?php echo $i; ?>" lang="<?php echo $canteje[$i - 1]; ?>"></samp>
 	<?php


		/* $result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tjugadabb where IDJ=".$idj."  and IDC='".$idc."' Order by Serial"); $insslq="SELECT * FROM _tjugadabb where IDJ=".$idj."  and IDC='".$idc."' Order by Serial"; */


		$u = 1;
		for ($t = 1; $t <= intval($canteje[$i - 1]); $t++) {

			if ($u == 1) :
				$bgh = "nom1";
				$u = 2;
			else :
				$bgh = "nom2";
				$u = 1;
			endif;
			if (($t + 1) <= intval($canteje[$i - 1])) :
				$uno = "'eje" . $i . ($t + 1) . "'";
			else :
				$uno = "'eje" . $i . "1'";
			endif;
			$result_qw = mysqli_query($GLOBALS['link'], "SELECT * FROM _tablaejempleares where  IDCN=" . $IDCN . " and Carr=" . $i . " and Noeje=" . $t);
			if (mysqli_num_rows($result_qw) == 0) :
				$nombreEje = '';
			else :
				$row = mysqli_fetch_array($result_qw);
				$nombreEje = $row['Nombre'];
			endif;
			echo '<tr id="la' . $canteje[$i - 1] . '" class="' . $bgh . '"  class="' . $bgh . '">';

			echo '<th  id="la' . $canteje[$i - 1] . '1" class="' . $bgh . '"><div  align="right"  > <img  src="media/esact.png" height="16" width="16"  /></div></th>';

			echo '<th id="la' . $canteje[$i - 1] . '2" class="' . $bgh . '"><div align="center" class="EstiloCC">' . $t . '</div></th>';
			echo '<th id="la' . $canteje[$i - 1] . '3"  class="' . $bgh . '"><div align="center" class="EstiloCC"><input type="text" id="eje' . $i . $t . '"  size="60" value="' . $nombreEje . '" onkeyup="focusobjbb2(event,' . $uno . ')" /></div></th>';



			echo ' </tr>';
		}
		?>
 </table>