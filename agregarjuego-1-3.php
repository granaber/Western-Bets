<div id='tpg2' class='tabPanelGroup'>
	<div class='tabGroup'>
		<a href='#tpg21' class='tabDefault'>Escrute</a>
	</div>
	<div id='tpg21' class='tabPanel'>
		<table width="278px" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td bgcolor="#999999">&nbsp;</td>
				<td bgcolor="#999999">
					<div style="color: #FFFFFF">No.Ejemplares</div>
				</td>
				<td bgcolor="#999999">
					<div style="color: #FFFFFF">Puesto a Escrutar</div>
				</td>
			</tr>
			<?php
			if (isset($_REQUEST['idjug'])) :
				require('prc_php.php');
				$GLOBALS['link'] = Connection::getInstance();
				$pfc = $_REQUEST['idjug'];
			endif;
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos_escrute where IDJug=" . $pfc . " Order by NumeroEje");
			$Y = 1;
			while ($row = mysqli_fetch_array($result)) {
				if ($Y == 1) :
					$Y = 2;
					echo "<tr  >";
				else :
					$Y = 1;
					echo "<tr  bgcolor='#5F92C1'>";
				endif;
				$campod = "eliminar_cnf1(7,'IDJug=" . $pfc . "|NumeroEje=" . $row['NumeroEje'] . "','_tdjuegos_escrute');makeResultwin('agregarjuego-1-3.php?idjug=" . $pfc . "','esc');";
				$campor = "$('NumeroEje').value=" . $row['NumeroEje'] . ";$('NumeroPuesto').value=" . $row['NumeroPuesto'] . ";";
				echo "<td><img src='media/estrella.png' height='16'  width='16' onclick=" . $campor . "><img src='media/borrar2.png' height='16'  width='16' onclick=" . $campod . "></td>";
				echo '<td><samp style="color:#FFFFFF">' . $row['NumeroEje'] . '</samp></td>';
				echo '<td><samp style="color:#FFFFFF">' . $row['NumeroPuesto'] . '</samp></td>';
				echo "</tr>";
			}
			?>

		</table>
	</div>
</div>
</div>
<script>
	new xTabPanelGroup('tpg2', 310, 150, 0, 'tabPanel', 'tabGroup', 'tabDefault', 'tabSelected');
</script>