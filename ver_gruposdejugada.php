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
			<th bgcolor="#FFFFFF">No. Formato</th>
			<th bgcolor="#FFFFFF">Descripcion</th>
			<th bgcolor="#FFFFFF">Pertenece al Deporte de:</th>
		</tr>
		<?php
		require('prc_php.php');
		$GLOBALS['link'] = Connection::getInstance();

		$resultj = mysqli_query($GLOBALS['link'], "SELECT _formatosbb.*,_gruposdd.imagen FROM _formatosbb,_gruposdd where _formatosbb.grupo=_gruposdd.grupo Order by Formato");
		$i = 1;
		while ($Row = mysqli_fetch_array($resultj)) {
			if ($i == 1) :
				$bgh = "nom1";
				$i = 2;
			else :
				$bgh = "nom2";
				$i = 1;
			endif;
			if ($Row['Grupo'] != 0) :
				$tde = "media/esact.png";
			else :
				$tde = "media/esiact.png";
			endif;
			echo '<tr  id="la' . $Row['Formato'] . '" class="' . $bgh . '"  ondblclick="verlista2(' . $Row['Formato'] . ');"  onMouseOver="browsell(this,1,4);"   onMouseOut="browsell(this,2,4);" >';

			echo '<th  id="la' . $Row['Formato'] . '1" class="' . $bgh . '"  ><div  align="right"  > <img src="' . $tde . '" height="16" width="16" /></div></th>';

			echo '<th id="la' . $Row['Formato'] . '2" class="' . $bgh . '"  ><div align="center" >' . $Row['Formato'] . '</div></th>';
			echo '<th id="la' . $Row['Formato'] . '3"class="' . $bgh . '"  ><div align="center" >' . $Row['Descripcion'] . '</div></th>';
			echo '<th id="la' . $Row['Formato'] . '4"class="' . $bgh . '"  ><div  align="center" >';
			if ($Row['Grupo'] != 0) :
				echo '<img  src="media/' . $Row['imagen'] . '"  height="32" width="32"  onmouseover="Pop(this,-50,-25,200,200,10,null);" onmouseout="Revert(this,10,null);"/></div></th></tr>';
			else :
				echo '</div></th></tr>';
			endif;
		}
		?>
	</table>
</div>
<p>&nbsp;</p>
<div id="box8">
	<table width="500" border="0">
		<tr>
			<th width="274" scope="col"></th>
			<th width="216" colspan="3" scope="col">
				<div align="right">
					<input type="submit" name="button" id="button" value="Nuevo Grupo" onclick="opmenu('ver_gruposdejugada-1.php');" />
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