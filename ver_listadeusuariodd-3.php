<div id='tpg2' class='tabPanelGroup'>
	<div class='tabGroup'>
		<a href='#tpg21' class='tabDefault'>Asignacion de Ventas</a>
	</div>
	<div id='tpg21' class='tabPanel'>
		<table width="300px" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td bgcolor="#333333">&nbsp;</td>
				<td bgcolor="#333333">
					<div style="color: #FFFFFF">Desde</div>
				</td>
				<td bgcolor="#333333">
					<div style="color: #FFFFFF">Hasta</div>
				</td>
				<td bgcolor="#333333">
					<div style="color: #FFFFFF">a Cobrar</div>
				</td>
			</tr>
			<?php
			if (isset($_REQUEST['idc'])) :
				require('prc_php.php');
				$GLOBALS['link'] = Connection::getInstance();
				$idc = $_REQUEST['idc'];
				$op = $_REQUEST['op'];
			endif;

			if ($op == 1) :
				$result = mysqli_query($GLOBALS['link'], "Delete from   _tconsecionariodd_tb where IDC='" . $idc . "'");
				$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionariodd_tb_cngin");
				while ($Row = mysqli_fetch_array($result)) {
					$result2 = mysqli_query($GLOBALS['link'], "INSERT INTO _tconsecionariodd_tb  VALUES ('" . $idc . "'," . $Row['MontoDesde'] . "," . $Row['MontoHasta'] . ",'" . $Row['aCobrar'] . "')");
				}
			endif;

			$result_b = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionariodd_tb  where IDC='" . $idc . "'");
			$Y = 1;
			while ($row = mysqli_fetch_array($result_b)) {
				if ($Y == 1) :
					$Y = 2;
					echo "<tr  >";
				else :
					$Y = 1;
					echo "<tr  bgcolor='#5F92C1'>";
				endif;
				$campod = "eliminar_cnf1(7,'IDC=" . $idc . "|MontoDesde=" . $row['MontoDesde'] . "|MontoHasta=" . $row['MontoHasta'] . "','_tconsecionariodd_tb');makeResultwin2('ver_listadeusuariodd-3.php?op=2&idc=" . $idc . "','esckk');";
				$campor = "$('MontoDesde').value=" . $row['MontoDesde'] . ";$('MontoHasta').value=" . $row['MontoHasta'] . ";$('aCobrar').value=" . '"' . $row['aCobrar'] . '"' . ";";
				echo "<td><img src='media/estrella.png' height='16'  width='16' onclick=" . $campor . "><img src='media/borrar2.png' height='16'  width='16' onclick=" . $campod . "></td>";
				echo '<td><samp style="color:#FFFFFF">' . $row['MontoDesde'] . '</samp></td>';
				echo '<td><samp style="color:#FFFFFF">' . $row['MontoHasta'] . '</samp></td>';
				echo '<td><samp style="color:#FFFFFF">' . $row['aCobrar'] . '</samp></td>';
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