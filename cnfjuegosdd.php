<style type="text/css">
	<!--
	.Estilo1 {
		color: #FFFFFF
	}
	-->
</style>
<div id="box9" style="width:730px">
	<div id='tpg2' class='tabPanelGroup'>
		<div class='tabGroup'>

			<a href='#tpg21' class='tabDefault'> Configuracion de Juegos </a><span class='linkDelim'>&nbsp;|&nbsp;</span>

		</div>

		<div id='tpg21' class='tabPanel'>

			<table width="729" border="0" cellspacing="0">
				<tr bgcolor="#66CCFF">
					<th bgcolor="#66CCFF" width="5"></th>
					<th width="42" bgcolor="#66CCFF">Id.</th>
					<th width="200" bgcolor="#66CCFF">Descripcion</th>
					<th width="225" bgcolor="#66CCFF">Asociado al Formato</th>
					<th width="245" bgcolor="#66CCFF">Pertene al Deporte:</th>
				</tr>
				<?php
				require('prc_php.php');
				$GLOBALS['link'] = Connection::getInstance();

				$resultj = mysqli_query($GLOBALS['link'], "SELECT _tbjuegodd.*,_gruposdd.imagen,_gruposdd.descripcion as Desjuego,_formatosbb.descripcion as Desform FROM _tbjuegodd,_gruposdd,_formatosbb where _tbjuegodd.Grupo=_gruposdd.Grupo and _tbjuegodd.Formato=_formatosbb.Formato Order by IDDD");
				$i = 1;
				while ($Row = mysqli_fetch_array($resultj)) {
					if ($i == 1) :
						$bgh = "nom1";
						$i = 2;
					else :
						$bgh = "nom2";
						$i = 1;
					endif;
					if ($Row['Estatus'] == 1) :
						$tde = "media/esact.png";
					else :
						$tde = "media/esiact.png";
					endif;
					$tb = "'_tbjuegodd'";
					$grpu = "'IDDD:" . $Row['IDDD'] . "'";

					echo '<tr  id="la' . $Row['IDDD'] . '" class="' . $bgh . '"  ondblclick="verlista3(' . $Row['IDDD'] . ');"  onMouseOver="browsell(this,1,5);"   onMouseOut="browsell(this,2,5);" >';

					echo '<th  id="la' . $Row['IDDD'] . '1" class="' . $bgh . '"  ><div  align="right"  > <img src="' . $tde . '" height="16" width="16" onclick="caet(this,' . $tb . ',' . $grpu . ');"/></div></th>';

					echo '<th id="la' . $Row['IDDD'] . '2" class="' . $bgh . '"  ><div align="center" >' . $Row['IDDD'] . '</div></th>';
					echo '<th id="la' . $Row['IDDD'] . '3"class="' . $bgh . '"  ><div align="left" >' . $Row['Descripcion'] . '</div></th>';
					echo '<th id="la' . $Row['IDDD'] . '4"class="' . $bgh . '"  ><div align="left" >' . $Row['Desform'] . '</div></th>';
					echo '<th id="la' . $Row['IDDD'] . '5"class="' . $bgh . '"  ><div  align="left" >';

					echo '<img  src="media/' . $Row['imagen'] . '"  height="32" width="32"  onmouseover="Pop(this,-50,-25,200,200,10,null);" onmouseout="Revert(this,10,null);"/>' . $Row['Desjuego'] . '</div></th></tr>';
				}
				?>
			</table>
		</div>
	</div>
</div>
<p>&nbsp;</p>
<div id="box8">
	<table width="707" border="0">
		<tr>
			<th width="298" scope="col"><span class="Estilo1"><img src="media/esact.png" width="32" height="32" />Activo</span> <span class="Estilo1"><img src="media/esiact.png" width="32" height="32" />Desactivado </span></th>
			<th width="399">
				<div align="right">
					<input type="submit" name="button" id="button" value="Nuevo Juego" onclick="opmenu('cnfjuegosdd-1.php');" />
				</div>
			</th>
		</tr>
	</table>
</div>
<p>&nbsp;</p>
<script>
	new xTabPanelGroup('tpg2', 705, 500, 30, 'tabPanel', 'tabGroup', 'tabDefault', 'tabSelected');
	Nifty('div#box9', 'big');
	Nifty('div#box8', 'big');
</script>