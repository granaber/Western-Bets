<style type="text/css">
	<!--
	.Estilo1 {
		color: #FFFFFF
	}
	-->
</style>
<div id="box7" style="width:560px">
	<table width="550" border="0" cellspacing="0">
		<tr bgcolor="#0066FF">
			<th bgcolor="#FFFFFF" width="5"></th>
			<th bgcolor="#FFFFFF">No.</th>
			<th bgcolor="#FFFFFF">Descripcion</th>
			<th bgcolor="#FFFFFF">Imagen</th>
		</tr>

		<?php

		require('prc_php.php');

		$GLOBALS['link'] = Connection::getInstance();


		$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd Order by Grupo");
		$i = 1;

		while ($Row = mysqli_fetch_array($resultj)) {
			if ($i == 1) :
				$bgh = "nom1";
				$i = 2;
			else :
				$bgh = "nom2";
				$i = 1;
			endif;
			$tb = "'_gruposdd'";
			$grpu = "'Grupo:" . $Row['Grupo'] . "'";
			echo '<tr  id="la' . $Row['Grupo'] . '" class="' . $bgh . '"  ondblclick="verlista(' . $Row['Grupo'] . ');"  onMouseOver="browsell(this,1,4);"   onMouseOut="browsell(this,2,4);" >';
			if ($Row['Estatus'] == 1) :
				echo '<th  id="la' . $Row['Grupo'] . '1" class="' . $bgh . '"  ><div  align="right"  > <img src="media/esact.png" height="16" width="16" onclick="caet(this,' . $tb . ',' . $grpu . ');"/></div></th>';
			else :
				echo '<th id="la' . $Row['Grupo'] . '1" class="' . $bgh . '" ><div  align="right"><img src="media/esiact.png" height="16" width="16"   onclick="caet(this,' . $tb . ',' . $grpu . ');"/></div></th>';
			endif;
			echo '<th id="la' . $Row['Grupo'] . '2" class="' . $bgh . '"  ><div align="center" >' . $Row['Grupo'] . '</div></th>';
			echo '<th id="la' . $Row['Grupo'] . '3"class="' . $bgh . '"  ><div align="center" >' . $Row['Descripcion'] . '</div></th>';
			echo '<th id="la' . $Row['Grupo'] . '4"class="' . $bgh . '"  ><div  align="center" ><img  src="media/' . $Row['imagen'] . '"  height="32" width="32"  onmouseover="Pop(this,-50,-25,200,200,10,null);" onmouseout="Revert(this,10,null);"/></div></th></tr>';
		}
		?>
	</table>
</div>
<p>&nbsp;</p>
<div id="box8" style="width:600px">
	<table width="500" border="0">
		<tr>
			<th width="274" scope="col"><span class="Estilo1"><img src="media/esact.png" width="32" height="32" />Activo</span> <span class="Estilo1"><img src="media/esiact.png" width="32" height="32" />Desactivado </span></th>
			<th width="216" colspan="3" scope="col">
				<div align="right">
					<input type="submit" name="button" id="button" value="Nuevo Deporte" onclick="opmenu('ver_listadederportes-1.php');" />
				</div>
			</th>
		</tr>
	</table>
</div>
<p>&nbsp;</p>
<script>
	Nifty('div#box7', 'big');
	Nifty('div#box8', 'big');
</script>