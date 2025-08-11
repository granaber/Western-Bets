<style type="text/css">
	<!--
	.Estilo1 {
		color: #FFFFFF
	}
	-->
</style>
<div id="box5" style="background:#033">
	<br />
	<div align="center"><span style="color:#FC0; font-size:16px">** Restriccion por Grupo **</span></div>
	<br />

	<div id="gridbox" width="450px" height="150px" style="background-color:#FC0;float:left "></div>
	<div style="background: #4B79A7;float: none;  height:150px ">
		<img src="media/estrella.png" width="16" height="16" /><span style="color:#FFF; font-size:12px">
			<strong>PARA MODIFICAR EL CUPO MAXIMO</strong><br /><br />

			<span style="color:#FC0">- Dar un click al CUPO a MODIFCAR.</span><br />
			<span style="color:#FC0">- F2 para Editar y Modicar.</span><br />
			<span style="color:#FC0">- ENTER Para Aceptar el Monto.</span><br />
			<span style="color:#FC0">- ESC Para Cancelar el Cambio.</span><br />
	</div>

</div>
<br />
<div id="box4" style="float: none">
	<br />
	<div align="center"><span style="color:#FC0; font-size:16px">** Restriccion por Punto de Venta **</span></div>
	<br />
	<div id='tpg2' class='tabPanelGroup'>

		<div class='tabGroup'>
			<?
			require('prc_php.php');
			$GLOBALS['link'] = Connection::getInstance();

			$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo order by IDG");
			while ($Row = mysqli_fetch_array($resultj)) {
				echo " <a href='#tpg2" . $Row['IDG'] . "' class='tabDefault' >Grupo No." . $Row['IDG'] . "</a><span class='linkDelim'>&nbsp;|&nbsp;</span>";
			}
			?>
		</div>
		<?
		$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo order by IDG");
		while ($Row = mysqli_fetch_array($resultj)) {
			echo "<div id='tpg2" . $Row['IDG'] . "' class='tabPanel'><table width='500' border='0' cellspacing='0'>";

			echo " <tr  bgcolor='#FFFFFF'>";
			echo "<th scope='col'></th>";
			echo "<th scope='col'>Letra</th>";
			echo "<th scope='col'>Nombre</th>";
			echo "<th scope='col'>Macure</th>";
			echo "<th scope='col'>Tablas</th>";
			echo '</tr>';
			$i = 1;
			$resultj2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario where  IDG=" . $Row['IDG'] . " order by IDC");
			while ($Row2 = mysqli_fetch_array($resultj2)) {
				if ($i == 1) :
					$bgh = "nom1";
					$i = 2;
				else :
					$bgh = "nom2";
					$i = 1;
				endif;
				$rrr = "'" . $Row2['IDC'] . "'";
				echo '<tr  id="la' . $Row2['IDRow'] . '-" class="' . $bgh . '"  onMouseOver="browsell1(this,1,5);"   onMouseOut="browsell1(this,2,5);"  onclick="verlista6(' . $rrr . ');" >';

				if ($Row2['Estatus'] == 1) :
					echo '<th id="la' . $Row2['IDRow'] . '-1" class="' . $bgh . '"><div  align="right"  > <img id="bt' . $Row2['IDRow'] . 'o" src="media/esact.png" height="16" width="16"/></div></th>';
				else :
					echo '<th id="la' . $Row2['IDRow'] . '-1"  class="' . $bgh . '"><div  align="right"><img src="media/esiact.png" height="16" width="16" /></div></th>';
				endif;
				echo '<th id="la' . $Row2['IDRow'] . '-2"  class="' . $bgh . '"><div align="center" class="EstiloCC">' . $Row2['IDC'] . '</div></th>';
				echo '<th  id="la' . $Row2['IDRow'] . '-3"  class="' . $bgh . '"><div align="left" class="EstiloCC">' . $Row2['Nombre'] . '</div></th>';

				$resultj32 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbrestricionessph where  IDC='" . $Row2['IDC'] . "' Order by IDJ");
				if (mysqli_num_rows($resultj32) != 0) :
					$u = 4;
					while ($Row3 = mysqli_fetch_array($resultj32)) {
						echo '<th id="la' . $Row2['IDRow'] . '-' . $u . '"  class="' . $bgh . '"><div align="center" class="EstiloCC">' . $Row3['mmxj'] . '</div></th>';
						$u++;
					}
					if ($u == 5) :
						echo '<th id="la' . $Row2['IDRow'] . '-' . $u . '"  class="' . $bgh . '"><div align="center" class="EstiloCC">0</div></th>';
					endif;
				else :
					echo '<th id="la' . $Row2['IDRow'] . '-4"  class="' . $bgh . '"><div align="center" class="EstiloCC"></div></th>';
					echo '<th id="la' . $Row2['IDRow'] . '-5"  class="' . $bgh . '"><div align="center" class="EstiloCC"></div></th>';
				endif;

				echo '</tr >';
			}
			echo "</table> </div>";
		}
		?>
	</div>
</div>

<div id="box6">
	<table width="500" border="0">
		<tr>
			<th width="500" colspan="3" scope="col"><span class="Estilo1"><img src="media/esact.png" width="32" height="32" />Activo</span> <span class="Estilo1"><img src="media/esiact.png" width="32" height="32" />Desactivado</span></th>
		</tr>
	</table>
</div>

<script>
	var idseleccionado = 0

	function doOnRowSelected(id) {
		idseleccionado = id;

	}

	function doOnCellEdit(stage, rowId, cellInd, newvalue) {

		if (stage == 2) {

			return grabarBycupoBygrupo(rowId, newvalue);

		}



	}
	//	function doOnEnter(rowId,cellInd){ 
	//		alert('Aqui');
	//	
	//		} 



	Nifty('div#box4', 'big');
	Nifty('div#box6', 'big');
	Nifty('div#box5', 'big');
	new xTabPanelGroup('tpg2', 505, 350, 40, 'tabPanel', 'tabGroup', 'tabDefault', 'tabSelected');


	createByxml('grid.xml', 'select _tgrupo.*,_tbrestriccionbygrupo.MaximoCupo from _tgrupo,_tbrestriccionbygrupo where  _tgrupo.IDG=_tbrestriccionbygrupo.IDG Order by _tgrupo.IDG', 'IDG|Descrip|Responsable|MaximoCupo');
	mygrid = new dhtmlXGridObject('gridbox');
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("No Grupo,Nombre del Grupo,Responsable,Cupo Maximo");
	mygrid.setInitWidths("50,150,200,50")
	mygrid.setColAlign("right,left,left,right")
	mygrid.setColTypes("ro,ro,ro,ed");
	/*mygrid.getCombo(5).put(2,2);*/
	mygrid.setColSorting("int,str,str,int");
	//mygrid.setSkin("ligth");
	mygrid.setColumnColor("white,white,white,#d5f1ff")
	/////////////////////////////////
	mygrid.attachEvent("onRowSelect", doOnRowSelected);
	mygrid.attachEvent("onEditCell", doOnCellEdit);
	/* mygrid.attachEvent("onEnter",doOnEnter); 
	 mygrid.attachEvent("onCheckbox",doOnCheck);*/
	//////////////////////
	mygrid.init();
	mygrid.loadXML("grid.xml");
</script>