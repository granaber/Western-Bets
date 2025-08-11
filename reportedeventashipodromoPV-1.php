<style type="text/css">
	<!--
	.Estilo2d1 {
		color: #000000
	}

	.Estilo3d1 {
		color: #FFFF66;
		font-size: 10px;
	}

	.Estilo5d1 {
		color: #FFFFFF;
		font-size: 10px;
	}

	.Estilo4d1 {
		color: #FFFFFF;
		font-size: 14px
	}
	-->
</style>





<div id="fromReporte" style=" height:1000px;width:500px; background:  #4B79A7">
	<?php

	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();

	?>

	<table width="440" border="0" cellspacing="0">
		<tr>
			<th width="1"></th>
			<th colspan="4">
				<div align="center" class="Estilo4d1">Reporte de Ventas/Premio por Hipodromo</div>
				<div align="right"></div>
			</th>
		</tr>
		<tr>
			<th></th>
			<th width="80">&nbsp;</th>
			<th colspan="2">&nbsp;</th>
			<th width="68">
				<div align="right"></div>
			</th>
		</tr>

		<tr>
			<th></th>
			<th class="Estilo3d1">
				<div align="right">Desde:</div>
			</th>
			<th width="144"><input name="fc" type="text" id="fc1" size="10" value="<?php echo date("d/n/Y"); ?>" /></th>
			<th width="137">
				<div align="right" class="Estilo3d1">Hasta:</div>
			</th>
			<th><input name="fc" type="text" id="fc2" size="10" value="<?php echo date("d/n/Y"); ?>" /></th>
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
		$('fc1').value = cal1.getFormatedDate('%d/%c/%Y', date);
		MakeRespK1('hipodromo-1-3hi.php?desde=' + $('fc1').value + '&hasta=' + $('fc2').value, 'Hipodro');
		return true;
	}

	function mSelectDate2(date) {
		$('fc2').value = cal2.getFormatedDate('%d/%c/%Y', date);
		MakeRespK1('hipodromo-1-3hi.php?desde=' + $('fc1').value + '&hasta=' + $('fc2').value, 'Hipodro');
		return true;
	}

	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				dhxWins1.window("w1").close();
				break;
			case "ImprimiR_":
				abrir('reportedeventashipodromoPV-2.php?desde=' + $("fc1").value + "&hasta=" + $("fc2").value + "&IDC=" + $('con').title, ' ', 1, 0, 0, 0, 0, 0, 1, 400, 400, 100, 100, 1);
				break;
			case "Imprimit_":
				abrir('reportedeventasporconcesionarioPV-3.php?desde=' + $("fc1").value + "&hasta=" + $("fc2").value + "&IDC=" + $('con').title + '&hipodromo=' + $('Hipodromo').value, ' ', 1, 0, 0, 0, 0, 0, 1, 400, 500, 100, 100, 1);
				break;

				//"ImprimirReporte2('reportedeventashipodromo-2.php');"
		}
	}
	dhxWins1 = new dhtmlXWindows();
	dhxWins1.setImagePath("codebase/imgs/");
	w1 = dhxWins1.createWindow("w1", 350, 270, 500, 150);
	w1.setText('Reporte de Ventas/Premio por Hipodromo de ' + $('con').title);
	w1.attachObject('fromReporte');
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	dhxWins1.window("w1").denyResize();
	dhxWins1.window("w1").denyMove();
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
	bar.addButton("ImprimiR_", 1, "Imprimir Reporte", "images/print.gif", "images/print.gif");
	//bar.addButton("Imprimit_", 2, "Imprimir Ticket", "images/print_dis.gif", "images/print_dis.gif"); 
	bar.attachEvent("onClick", clicktoolBar);

	cal1 = new dhtmlxCalendarObject('fc1');
	cal1.setOnClickHandler(mSelectDate);

	cal2 = new dhtmlxCalendarObject('fc2');
	cal2.setOnClickHandler(mSelectDate2);
</script>