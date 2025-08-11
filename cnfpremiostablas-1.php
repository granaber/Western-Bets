<div id='tpg2' class='tabPanelGroup'>
	<div class='tabGroup'>
		<a href='#tpg21' class='tabDefault'>Premiacion y Porcentajes</a>
	</div>
	<div id='tpg21' class='tabPanel'>
		<table width="436px" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td bgcolor="#333333">&nbsp;</td>
				<td bgcolor="#333333">
					<div style="color: #FFFFFF">Ejem.</div>
				</td>
				<td bgcolor="#333333">
					<div style="color: #FFFFFF">%</div>
				</td>
				<td bgcolor="#333333">
					<div style="color: #FFFFFF">Premio</div>
				</td>
			</tr>
			<?php
			require('prc_php.php');
			$GLOBALS['link'] = Connection::getInstance();
			if (isset($_REQUEST['op'])) :
				$op = $_REQUEST['op'];
			else :
				$eje = 0;
			endif;

			if ($op == 1) :
				$result2 = mysqli_query($GLOBALS['link'], "INSERT INTO _tcnftablaspor  VALUES (" . $eje . "," . $prem . "," . $porc . ")");
			endif;

			$result_b = mysqli_query($GLOBALS['link'], "SELECT * FROM _tcnftablaspor ");
			//echo "SELECT * FROM _tcnftablaspor  where CantidaEje=".$eje;
			$Y = 1;
			while ($row = mysqli_fetch_array($result_b)) {
				if ($Y == 1) :
					$Y = 2;
					echo "<tr  >";
				else :
					$Y = 1;
					echo "<tr  bgcolor='#5F92C1'>";
				endif;
				$campod = "eliminar_cnf1(7,'CantidaEje=" . $row['CantidaEje'] . "','_tcnftablaspor');makeResultwin2('cnfpremiostablas-1.php?op=2','esckk');";
				$campor = "$('CantidaEje').value=" . $row['CantidaEje'] . ";$('Porcentaje').value=" . $row['Porcentaje'] . ";$('Premio').value=" . $row['Premio'] . ";";
				echo "<td><img src='media/estrella.png' height='16'  width='16' onclick=" . $campor . "><img src='media/borrar2.png' height='16'  width='16' onclick=" . $campod . "></td>";
				echo '<td><samp style="color:#FFFFFF">' . $row['CantidaEje'] . '</samp></td>';
				echo '<td><samp style="color:#FFFFFF">' . $row['Porcentaje'] . '</samp></td>';
				echo '<td><samp style="color:#FFFFFF">' . $row['Premio'] . '</samp></td>';
				echo "</tr>";
			}
			?>

		</table>
	</div>
</div>

<script>
	Nifty('div#box2', 'big');
	new xTabPanelGroup('tpg2', 436, 150, 0, 'tabPanel', 'tabGroup', 'tabDefault', 'tabSelected');
</script>