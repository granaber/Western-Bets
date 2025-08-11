<div id='tpg2' class='tabPanelGroup'>
	<div class='tabGroup'>
		<a href='#tpg21' class='tabDefault'>Seriales monitoreados</a><span class='linkDelim'>&nbsp;|&nbsp;</span>
	</div>
	<div id='tpg21' class='tabPanel'>
		<table width="360" border="0" cellspacing="0" style="font-size:10px">
			<tr bgcolor="#0066FF">
				<th bgcolor="#FFFFFF">
					<div></div>
				</th>
				<th bgcolor="#FFFFFF">
					<div align="center">Serial</div>
				</th>
				<th bgcolor="#FFFFFF">Hora</th>
				<th bgcolor="#FFFFFF">Fecha</th>
				<th bgcolor="#FFFFFF">Concesionario</th>
				<th bgcolor="#FFFFFF">Apuesta</th>
				<th bgcolor="#FFFFFF">Terminal</th>
			</tr>
			<?php
			if (isset($_REQUEST['seriales'])) :
				require('prc_php.php');
				$GLOBALS['link'] = Connection::getInstance();
				$serial = explode('|', $_REQUEST["seriales"]);
				for ($j = 0; $j <= count($serial) - 2; $j++) {
					$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugada where Serial=" . $serial[$j]);
					$Row = mysqli_fetch_array($result);
					if ($i == 1) :
						$bgh = "nom1";
						$i = 2;
					else :
						$bgh = "nom2";
						$i = 1;
					endif;
					echo '<tr id="la' . $Row['Serial'] . '" class="' . $bgh . '"  ">';
					echo '<th  id="la' . $Row['Serial'] . '1" class="' . $bgh . '"><div  align="right"  > <img id="bt' . $Row['Serial'] . 'o" src="media/esact.png" height="16" width="16"/></div></th>';
					echo '<th id="la' . $Row['Serial'] . '2" class="' . $bgh . '"><div align="center" class="EstiloCC">' . $Row['Serial'] . '</div></th>';
					echo '<th id="la' . $Row['Serial'] . '3" class="' . $bgh . '"><div align="center" class="EstiloCC">' . $Row['Hora'] . '</div></th>';
					echo '<th id="la' . $Row['Serial'] . '4" class="' . $bgh . '"><div align="center" class="EstiloCC">' . $Row['Fecha'] . '</div></th>';
					echo '<th id="la' . $Row['Serial'] . '5" class="' . $bgh . '"><div align="center" class="EstiloCC">' . $Row['IDC'] . '</div></th>';
					echo '<th id="la' . $Row['Serial'] . '6" class="' . $bgh . '"><div  align="right" class="EstiloCC">' . number_format($Row['Valor_J'], 2, ',', '.') . '</div></th>';
					echo '<th id="la' . $Row['Serial'] . '7" class="' . $bgh . '"><div  align="right" class="EstiloCC">' . $Row['Terminal'] . '</div></th>';
				}
			endif;
			?>
		</table>
	</div>

	<script type="text/javascript">
		new xTabPanelGroup('tpg2', 360, 250, 40, 'tabPanel', 'tabGroup', 'tabDefault', 'tabSelected');
	</script>