<?

if (isset($_REQUEST['xfc'])) :
	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();

	$fc = $_REQUEST['xfc'];
	$IDB = $_REQUEST['IDB'];
endif;

$IDJ = 0;
$result2 = mysqli_query($GLOBALS['link'], "SELECT _jornadabb.IDJ FROM _jornadabb  where  Fecha='$fc'");
if (mysqli_num_rows($result2) != 0) :
	$row = mysqli_fetch_array($result2);
	$IDJ = $row['IDJ'];
endif;
?>


<div id="Box5xAudi" style="background:#C1C9D9">
	<div style="float:left">
		<br />
		<div align="center"><span style="color:#000; font-size:16px">** Ver Jugada AUDITORIA **</span></div>
		<br />
		<div id="a_tabbarVJ" style="width:705px; height:435px;"></div>

		<div id="gridboxTP_tpVJ">
			<div id="gridboxTPVJ" height="390px" style="background-color:#FC0 "></div>
			<div id="pagingAreaVJ"></div>
		</div>
		<div id="gridboxTPG_tpVJ">
			<div id="gridboxTPGVJ" height="390px" style="background-color:#FC0 "></div>
			<div id="pagingArea1VJ"></div>
		</div>
		<div id="gridboxTG_tpVJ">
			<div id="gridboxTGVJ" height="390px" style="background-color:#FC0 "></div>
			<div id="pagingArea2VJ"></div>
		</div>
		<div id="gridboxTE_tpVJ">
			<div id="gridboxTEVJ" height="390px" style="background-color:#FC0 "></div>
			<div id="pagingArea3VJ"></div>
		</div>

	</div>


	<samp id="idseleccionado"></samp><samp id="TagSeleccionado" lang="a1"></samp><br />
	<br />
	<br />
	<br />

	<div id="verticket">
		<?php


		include('ticketbb-2.php'); ?>
	</div>
</div>
<samp id='newreq'></samp>
<script>
	var idseleccionado = 0;
	var accesogp = 0;
	var grupo = 0;
	var IDJ = <? echo $IDJ; ?>;

	function doOnRowSelected(id) {
		if (id < 0) id = id * -1;
		ByView(id, 2);
		$('idseleccionado').lang = id;
		$('BtnImprimir').disabled = '';
		$('BtnEliminar').disabled = '';
	}

	function my_func(idn, ido) {
		$('TagSeleccionado').lang = idn;
		return true;

	};

	function doOnCellEdit(stage, rowId, cellInd, newvalue) {

		if (stage == 2) {

			return grabarBycupoBygrupo(rowId, newvalue);

		}
	}


	function clicktoolBar(id) {

		switch (id) {
			case "Cerrar_":
				dhxWins1.window("w1").close();
				if (dhxWins2 != 0) {
					var isWin = dhxWins2.isWindow("w2");
					if (isWin) dhxWins2.window("w2").close();
					var isWin = dhxWins2.isWindow("w3");
					if (isWin) dhxWins2.window("w3").close();
				}
				break;
		}
	}


	dhxWins1 = new dhtmlXWindows();
	dhxWins1.setImagePath("codebase/imgs/");
	w1 = dhxWins1.createWindow("w1", 195, 190, 980, 560);
	w1.setText("Ver Jugada AUDITORIA");
	w1.attachObject('Box5xAudi');
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	dhxWins1.window('w1').setModal(true);
	//dhxWins1.window("w1").centerOnScreen();
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
	bar.attachEvent("onClick", clicktoolBar);

	//// **************************   TABS de los GRID ***************************

	tabbar = new dhtmlXTabBar("a_tabbarVJ", "top");

	tabbar.attachEvent('onSelect ', my_func);
	tabbar.setImagePath("codebase/imgs/");
	tabbar.setSkinColors("#FCFBFC", "#F4F3EE", "#FCFBFC");
	tabbar.addTab("a1VJ", "Ticket Perdedores", "150px");
	tabbar.addTab("a2VJ", "Ticket Posibles a Ganar", "150px");
	tabbar.addTab("a3VJ", "Ticket Ganadores (premios)", "150px");
	tabbar.addTab("a4VJ", "Ticket Eliminados", "150px");
	//tabbar.setStyle("modern");
	tabbar.setTabActive("a1VJ");
	tabbar.setContent("a1VJ", "gridboxTP_tpVJ");
	tabbar.setContent("a2VJ", "gridboxTPG_tpVJ");
	tabbar.setContent("a3VJ", "gridboxTG_tpVJ");
	tabbar.setContent("a4VJ", "gridboxTE_tpVJ");

	dimCol = "60,130,100,40,100,100,180,0";
	// Llamar para crear XML   
	mientrasProceso('Escrutando', 'Procesando')
	makeResultwin2('procierre.php?op=30&IDJ=' + $('fc').lang + '&accesogp=' + accesogp + '&grupo=' + grupo, 'newreq');

	// El primer GRID con tickets Perdedores
	// makeResultwin2('procierre.php?op=30&IDJ='+$('fc').lang,'newreq');

	mygrid = new dhtmlXGridObject('gridboxTPVJ');
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("Serial,Letra,Hora,Filtro,Apuesta,Cobra,Serial Electronico,esc");
	mygrid.setInitWidths(dimCol)
	mygrid.setColAlign("right,left,right,right,center,left,center,center")
	mygrid.setColTypes("ro,ed,ro,cp,ro,ro,ro,ro");
	mygrid.attachHeader("#connector_text_filter,#connector_select_filter")
	mygrid.setColSorting("int,str,str,date,int,int,str,str")
	mygrid.attachEvent("onRowSelect", doOnRowSelected);
	mygrid.setSkin("dhx_skyblue");
	mygrid.enablePaging(true, 50, 10, "pagingAreaVJ", true);
	mygrid.setPagingSkin("bricks");
	mygrid.init();
	mygrid.attachFooter("Total de Ticket (P):{#stat_count},#cspan,#cspan,#cspan,Venta Bsf.: {#stat_total}");
	mygrid.setSizes();
	mygrid.loadXML("Auditoriadeventas-7.php?IDJ=" + IDJ + "&tipo=1&activo=1&accesogp=" + accesogp + '&grupo=' + grupo + '&parametro=' + AudTik);


	// El primer GRID con tickets Posibles GANADORES
	mygrid1 = new dhtmlXGridObject('gridboxTPGVJ');
	mygrid1.setImagePath("codebase/imgs/");
	mygrid1.setHeader("Serial,Letra,Hora,Filtro,Apuesta,Cobra,Serial Electronico");
	mygrid1.setInitWidths(dimCol)
	mygrid1.setColAlign("right,left,left,right,center,left,center,center")
	mygrid1.setColTypes("ed,ed,ro,cp,ro,ro,ro,ro");
	mygrid1.attachHeader("#connector_text_filter,#connector_select_filter")
	mygrid1.setColSorting("connector,connector")
	mygrid1.setColSorting("int,str,str,date,int,int,str,str")
	mygrid1.attachEvent("onRowSelect", doOnRowSelected);
	mygrid1.setSkin("dhx_skyblue");
	mygrid1.enablePaging(true, 50, 10, "pagingArea1VJ", true);
	mygrid1.setPagingSkin("bricks");

	mygrid1.init();
	mygrid1.attachFooter("Total de Ticket (SE):{#stat_count},#cspan,#cspan,#cspan,Venta Bsf.: {#stat_total},Premio Bsf.: {#stat_total}");
	mygrid1.loadXML("Auditoriadeventas-7.php?IDJ=" + IDJ + "&tipo=2&activo=1&accesogp=" + accesogp + '&grupo=' + grupo + '&parametro=' + AudTik);


	// El primer GRID con tickets GANADORES
	mygrid2 = new dhtmlXGridObject('gridboxTGVJ');
	mygrid2.setImagePath("codebase/imgs/");
	mygrid2.setHeader("Serial,Letra,Hora,Filtro,Apuesta,Cobra,Serial Electronico");
	mygrid2.setInitWidths(dimCol)
	mygrid2.setColAlign("right,left,left,right,center,left,center,center")
	mygrid2.setColTypes("ro,ro,ro,cp,ro,ro,ro,ro");
	mygrid2.attachHeader("#connector_text_filter,#connector_select_filter")
	mygrid2.setColSorting("int,str,str,date,int,int,str,str")
	mygrid2.attachEvent("onRowSelect", doOnRowSelected);
	mygrid2.setSkin("dhx_skyblue");
	mygrid2.enablePaging(true, 50, 10, "pagingArea2VJ", true);
	mygrid2.setPagingSkin("bricks");
	mygrid2.init();
	mygrid2.attachFooter("Total de Ticket (G):{#stat_count},#cspan,#cspan,#cspan,Venta Bsf.: {#stat_total},Premio Bsf.: {#stat_total}");
	mygrid2.loadXML("Auditoriadeventas-7.php?IDJ=" + IDJ + "&tipo=3&activo=1&accesogp=" + accesogp + '&grupo=' + grupo + '&parametro=' + AudTik);



	// El primer GRID con tickets GANADORES
	mygrid3 = new dhtmlXGridObject('gridboxTEVJ');
	mygrid3.setImagePath("codebase/imgs/");
	mygrid3.setHeader("Serial,Letra,Hora,Filtro,Apuesta,Cobra,Serial Electronico");
	mygrid3.setInitWidths(dimCol)
	mygrid3.setColAlign("right,left,left,right,center,left,center,center")
	mygrid3.setColTypes("ro,ro,ro,cp,ro,ro,ro,ro");
	mygrid3.attachHeader("#connector_text_filter,#connector_select_filter")
	mygrid3.setColSorting("int,str,str,date,int,int,str,str")
	mygrid3.attachEvent("onRowSelect", doOnRowSelected);
	mygrid3.setSkin("dhx_skyblue");
	mygrid3.enablePaging(true, 50, 10, "pagingArea3VJ", true);
	mygrid3.setPagingSkin("bricks");
	mygrid3.init();
	mygrid3.attachFooter("Total de Ticket (E):{#stat_count},#cspan,#cspan,#cspan,Eliminados Bsf.: {#stat_total},#cspan,#cspan,#cspan,#cspan");
	mygrid3.loadXML("Auditoriadeventas-7.php?IDJ=" + IDJ + "&tipo=3&activo=2&accesogp=" + accesogp + '&grupo=' + grupo + '&IDJ1=' + $('fc1').lang);
</script>