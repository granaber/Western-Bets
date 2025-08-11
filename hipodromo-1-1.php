<?php

/*$fc=$_REQUEST['fc'];*/


require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$estado[1] = "Activo";
$estado[2] = "Suspendido";

?>
<div id='box15'>
	<span style="color:#FFFF00; font-size:18px"><strong>Hipodromo</strong></span>
	<table border="0" cellpadding="3" cellspacing="0" width="505">
		<tbody>
			<?php
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _hipodromos ");

			if (mysqli_num_rows($result) != 0) :
				$un = 1;
				while ($row = mysqli_fetch_array($result)) {
					if ($un == 1) :
						echo "<tr bgcolor='#333333' >";
						$un = 0;
					else :
						echo "<tr >";
						$un = 1;
					endif;
					if ($row["Estatus"] == 1) :
						echo "<td  width='400'> <img src='media/hip.png' width='24' height='24'/>";
					endif;
					if ($row["Estatus"] == 2) :
						echo "<td  width='400' > <img src='media/delete.png' width='16' height='16'/ />";
					endif;
					echo "<span style='color:#FFFFFF'>  Grupo no:" . $row["_idhipo"] . " Nombre: " . $row["Descripcion"] . " Estatus: " . $estado[$row["Estatus"]];

					echo "</span></td>";
					$vc = "'hipodromo.php?fc=" . $row["_idhipo"] . "'";
					echo '<td > <input type="button" value="ver" title="' . $vc . '" onclick="javascript:makeRequest(' . $vc . ');"></td>';
				}
			endif;
			?>
			</tr>
		</tbody>
	</table>
	<p>

		<input type="submit" name="Submit" value="Agregar Hipodromo" onclick="javascript: yq=true;makeRequestHIPI('hipodromo.php?fc=0');" />

	</p>
</div>
<div id='tablemenu1'>
</div>
<script>
	Nifty('div#box15', 'big');
</script>