<style type="text/css">
	<!--
	.Estilo2d1 {
		color: #000000
	}

	.Estilo3d1 {
		color: #FFFF66;
		font-size: 15px;
	}

	.Estilo5d1 {
		color: #FFFFFF;
		font-size: 15px;
	}

	.Estilo4d1 {
		color: #FFFFFF;
		font-size: 14px
	}
	-->
</style>





<div id="fromReporte" style=" height:1000px; background:#069">
	<?php

	require_once('prc_phpDUK.php');


	if ($_REQUEST['iGrupo'] == 0) :
		$add = '';
	else :
		$add = ' and IDG in (' . $_REQUEST['iGrupo'] . ')';
	endif;
	$iIDC = array();
	$link = ConnectionAnimalitos::getInstance();
	$result = mysqli_query($link, "SELECT * FROM _Concesionario_Ani order by IDC");
	while ($row = mysqli_fetch_array($result)) $iIDC[] = "'" . $row['IDC'] . "'";


	global $serverD;
	global $userD;
	global $clvD;
	global $dbD;


	$conexion = mysqli_connect($serverD, $userD, $clvD, $dbD);


	$lnIDC = array();
	$lIDG = array();
	$result = mysqli_query($link, "SELECT * FROM _tconsecionario where IDC in (" . implode(',', $iIDC) . ") " . $add . " order by IDC");
	while ($row = mysqli_fetch_array($result)) {
		$lnIDC[] = "<option value=" . $row["IDC"] . ">" . $row["IDC"] . "-" . $row['Nombre'] . "</option>";
		$lIDG[$row['IDG']] = $row['IDG'];
	}

	$lnIDG = array();
	$result = mysqli_query($link, "SELECT * FROM _tgrupo where IDG in (" . implode(',', $lIDG) . ")  order by IDG");
	//	echo ("SELECT * FROM tgrupo where IDG in (".implode(',',$lIDG).")  order by IDG");
	while ($row = mysqli_fetch_array($result))
		$lnIDG[] = "<option value=" . $row["IDG"] . ">" . $row["IDG"] . "-" . $row['Descrip'] . "</option>";




	?>

	<table width="475" border="0" cellspacing="0">
		<tr>
			<th width="0"></th>
			<th colspan="4">
				<div align="center" class="Estilo4d1">Reporte de Ventas Resumido</div>
				<div align="right"></div>
			</th>
		</tr>
		<tr>
			<th></th>
			<th width="134">&nbsp;</th>
			<th colspan="2">&nbsp;</th>
			<th width="107">
				<div align="right"></div>
			</th>
		</tr>

		<tr>
			<th></th>
			<th class="Estilo3d1">
				<div align="right">Desde:</div>
			</th>
			<th width="72"><input name="fc" type="text" id="fc1_ani" size="10" value="<?php echo date("d/n/Y"); ?>" />
			</th>
			<th width="152">
				<div align="right" class="Estilo3d1">Hasta:</div>
			</th>
			<th><input name="fc" type="text" id="fc2_ani" size="10" value="<?php echo date("d/n/Y"); ?>" /></th>
		</tr>

		<tr>
			<th></th>
			<th>
				<div align="right" class="Estilo3d1">Clasificar Por:</div>
			</th>
			<th colspan="3">
				<label>
					<input name="radio" type="radio" id="uno_ani" onclick="$('tu_ani').style.display='';$('tdc_ani').style.display='';$('td_ani').style.display='none';$('tdg_ani').style.display='none';" value="radio" checked="checked" />
				</label>
				<span class="Estilo5d1">Concesionario</span>
				<label>
					<input type="radio" name="radio" id="dos_ani" value="radio" onclick="$('tu_ani').style.display='none';$('tdc_ani').style.display='none';$('td_ani').style.display='';$('tdg_ani').style.display='';" />
				</label>
				<span class="Estilo5d1">Grupo</span>
			</th>
		</tr>
		<tr>
			<th colspan="2" class="Estilo3d1">
				<div id="tu_ani" align="right">Punto de Venta:</div>
				<div id="td_ani" align="right" style="display:none">Grupo</div>
			</th>
			<th colspan="2">
				<span id="spryselect1">
					<label>
						<div id="tdc_ani" align="left">
							<select id="Concesionario_ani">
								<option value="0">Todos</option>
								<?php
								for ($i = 0; $i <= count($lnIDC) - 1; $i++) {
									echo $lnIDC[$i];
								}
								?>
							</select>
						</div>
						<div id="tdg_ani" align="left" style="display:none">
							<select size="1" id="grupo_ani">
								<option selected="selected" value="0">Todos</option>
								<?php
								for ($i = 0; $i <= count($lnIDG) - 1; $i++) {
									echo $lnIDG[$i];
								}
								?>
							</select>
						</div>

					</label>
					<span class="selectRequiredMsg">Seleccione un elemento.</span></span>

			</th>
		</tr>
		<tr>
			<th></th>
			<th>&nbsp;</th>
			<th colspan="2">&nbsp;</th>
			<th>&nbsp;</th>
		</tr>

	</table>

</div>


<script>
	function mSelectDate(date) {
		$('fc1_ani').value = cal1.getFormatedDate('%d/%c/%Y', date);
		// MakeRespK1('hipodromo-1-5hi.php?desde='+$('fc1_ani').value+'&hasta='+$('fc2_ani').value,'Hipodro');
		return true;
	}

	function mSelectDate2(date) {
		$('fc2_ani').value = cal2.getFormatedDate('%d/%c/%Y', date);
		//	 MakeRespK1('hipodromo-1-5hi.php?desde='+$('fc1_ani').value+'&hasta='+$('fc2_ani').value,'Hipodro');
		return true;
	}

	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				dhxWins1.window("w1").close();
				break;
			case "ImprimiR_":


				clsi = $("uno_ani").checked;
				if (clsi) {
					gp = $("Concesionario_ani").value;
					clsi1 = 1;
				} else {
					gp = $("grupo_ani").value;
					clsi1 = 2;
				}



				openClas('Ani_Reporte_RES-2.php', 'd1=' + $("fc1_ani").value + "|d2=" + $("fc2_ani").value + "|op=" +
					clsi1 + "|gp=" + gp + "|iGrupo=<? echo $_REQUEST['iGrupo']; ?>", 'Reporte de Tickets Pagados', 1, 0,
					0, 0, 0, 0, 1, 400, 400, 100, 100, 1);
				break;
		}
	}
	dhxWins1 = new dhtmlXWindows();
	dhxWins1.setImagePath("codebase/imgs/");
	w1 = dhxWins1.createWindow("w1", 450, 250, 500, 250);
	w1.setText('Reporte de Venta Resumido');
	w1.attachObject('fromReporte');
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	dhxWins1.window("w1").denyResize();
	dhxWins1.window("w1").denyMove();
	dhxWins1.window('w1').setModal(true)
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "animalitos/icons/noun_1042920_cc.png", "animalitos/icons/noun_1042920_cc.png");
	bar.addButton("ImprimiR_", 1, "Imprimir Reporte", "animalitos/icons/noun_926248_cc.png",
		"animalitos/icons/noun_926248_cc.png");
	bar.attachEvent("onClick", clicktoolBar);

	cal1 = new dhtmlxCalendarObject('fc1_ani');
	cal1.setOnClickHandler(mSelectDate);

	cal2 = new dhtmlxCalendarObject('fc2_ani');
	cal2.setOnClickHandler(mSelectDate2);
</script>