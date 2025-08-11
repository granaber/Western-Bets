<div id='parametrodeconfigu'>
	<?php

	$fc = $_REQUEST['fc'];


	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();


	?>
	<p style="color: #FF0; font-size:12px"><b>Ver Datos de Jornadas de fecha:<?php echo $fc; ?> </b>
	</p>

	<table border="0" cellpadding="3" cellspacing="0" width="505">
		<tbody>
			<?
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where Fecha='" . $fc . "'");

			if (mysqli_num_rows($result) != 0) :
				$un = 1;
				while ($row = mysqli_fetch_array($result)) {
					$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _hipodromos where _idhipo=" . $row["IDhipo"]);
					$row2 = mysqli_fetch_array($result2);
					if ($un == 1) :
						echo "<tr style='background:#09F'>";
						$un = 0;
					else :
						echo "<tr  >";
						$un = 1;
					endif;

					if ($row["Estatus"] == 1) :
						$dibujo = "<img src='media/estrella.png' />";
					else :
						$dibujo = "<img src='media/lock.png' height='24'  width='24' />";
					endif;

					echo "<td  width='400' style='color:#FFFFFF'> " . $dibujo . " Jornada no:" . $row["IDCN"] . "- Hora: " . $row["Hora"] . " Carreras:" . $row["Cantcarr"] . " Hipodromo:" . $row2["Descripcion"] . "</td>";

					$vc = "'jornada-2.php?nc=" . $row["Cantcarr"] . "&ntp4=" . $row["NTDP4"] . "&ntdp=" . $row["NTDp"] . "&nj=" . $row["IDCN"] . "'";
					$tb = "'tabladeconfiguracion'";
					echo '<td > <input type="button" value="ver" onclick="makeResEsp2(' . $vc . ',' . $tb . ',' . $row["IDCN"] . ');"></td>';
				}
			endif;
			?>
			</tr>
		</tbody>
	</table>
	<p class="Estilo39">
		<input type="submit" name="Submit" value="&lt;-Volver" onclick="javascript:makeRequestSP('jornada.php');" />

	</p>
</div>