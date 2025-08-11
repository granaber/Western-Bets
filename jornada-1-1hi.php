<div id='parametrodeconfigu'>
	<?php

	$fc = $_REQUEST['fc'];
	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();


	?>
	<div style="color:#FFCC00; font-size:14px">Ver Datos de Jornadas de fecha:<?php echo $fc; ?> </div>

	<table class="ta_borde" border="0" cellpadding="3" cellspacing="0" width="505">
		<tbody>
			<?php
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where Fecha='" . $fc . "'");

			if (mysqli_num_rows($result) != 0) :
				$un = 1;
				while ($row = mysqli_fetch_array($result)) {
					$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _hipodromoshi where _idhipo=" . $row["IDhipo"]);
					$row2 = mysqli_fetch_array($result2);
					if ($un == 1) :
						echo "<tr bgcolor='#5F92C1' >";
						$un = 0;
					else :
						echo "<tr  >";
						$un = 1;
					endif;

					if ($row["Estatus"] == 1) :
						$dibujo = "<img src='media/estrella.png' />";
					else :
						$dibujo = "<img src='media/estrellaout.gif' />";
					endif;

					echo "<td  width='400'> " . $dibujo . "  <span style='color:#FFFFFF'> Jornada no:" . $row["IDCN"] . "- Hora: " . $row["Hora"] . " Carreras:" . $row["Cantcarr"] . " Hipodromo:" . $row2["Descripcion"] . "</span></td>";

					$vc = "'jornada-2hi.php?nc=" . $row["Cantcarr"] . "&ntp4=" . $row["NTDP4"] . "&ntdp=" . $row["NTDp"] . "&nj=" . $row["IDCN"] . "'";
					$tb = "'tabladeconfiguracion'";
					echo '<td > <input type="button" value="ver" onclick="makeResEsp2hi(' . $vc . ',' . $tb . ',' . $row["IDCN"] . ');"></td>';
				}
			endif;
			?>
			</tr>
		</tbody>
	</table>
	<p class="Estilo39">
		<input type="submit" name="Submit" value="&lt;-Volver" onclick="javascript:makeRequest('jornadahi.php');" />

	</p>
</div>