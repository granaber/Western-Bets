<style type="text/css">
	.Estilo2 {
		color: #FFFFFF
	}
</style>
<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$fc = $_REQUEST["fc"];

$Abanca = 0;
$idt = $_REQUEST['idt'];
$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu where IDusu=$idt");
$rowj = mysqli_fetch_array($resultj);
$Abanca = $rowj['ABanca'];
?>
<div id="vista">
	<div id="obj2">
		<div id="Calen1" />
	</div>
</div>
</div>
<div id="fromJornada"></div>
<div id="coc"></div>
<script>
	var idRow = 0;
	var abanca = <? echo $Abanca; ?>;

	function calendario() {
		dhxWins2 = new dhtmlXWindows();
		dhxWins2.setImagePath("codebase/imgs/");
		var w2 = dhxWins2.createWindow("w2", 450, 300, 190, 210);
		w2.clearIcon();
		dhxWins2.window("w2").button('close').hide();
		dhxWins2.window("w2").button('minmax1').hide();
		dhxWins2.window("w2").button('minmax2').hide();
		dhxWins2.window("w2").button('park').hide();
		w2.setText("");
		w2.attachObject('obj2');
		mCal = new dhtmlxCalendarObject('Calen1');
		mCal.attachEvent("onClick", mSelectDate);
		mCal.setSkin("dhx_black");
		mCal.loadUserLanguage('es');
		mCal.draw();
	}

	function mSelectDate(date) {
		$('vista').innerHTML = '<div id="obj2"><div id="Calen1"/></div></div>';
		fecha = mCal.getFormatedDate("%d/%c/%Y", date);
		setCookie('FechaCookie', fecha);
		bar.setItemText('TextoFecha', 'Fecha: ' + fecha);
		dhxWins2.window("w2").close();
		mygrid.clearAll();
		mygrid.loadXML('jornadabb-1-3.php?fc=' + fecha + '&Abanca=' + abanca);

	}

	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				dhxWins1.window("w1").close();
				break;
			case "Agregar_":
				dhxWins1.window("w1").close();
				makeResultwin('jornadabb-1-4.php?fc=' + fecha + '&idt=<? echo $idt; ?>', 'tablemenu');
				break;
			case "Modificar_":
				if (idRow != 0) {

					cargarpartidos(idRow);
					dhxWins1.window("w1").close();
				} else
					nalert('ERROR', 'DEBE SELECCIONAR PRIMERO LA JORNADA A MODIFICAR!!');
				break;
			case "Calendario_":
				calendario();
				break;


				//"ImprimirReporte2('reportedeventashipodromo-2.php');"
		}
	}

	function doOnCheck(rowId, cellInd, state) {
		if (state)
			estado = 1;
		else
			estado = 0;
		makeResultwin("chaceStatus.php?SqlStatus=Update _tusu set Estatus=" + estado + " where IDusu=" + rowId, "gridbox");
	}

	function doOnRowSelected(id) {
		idRow = id;
	}

	dhxWins1 = new dhtmlXWindows();
	dhxWins1.setImagePath("codebase/imgs/");
	w1 = dhxWins1.createWindow("w1", 350, 255, 410, 250);
	w1.setText('Lista de Jornada ');
	w1.attachObject('fromJornada');
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	dhxWins1.window('w1').setModal(true);
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
	bar.addButton("Agregar_", 1, "Agregar ", "images/copy.gif", "images/copy.gif");
	bar.addButton("Modificar_", 2, "Modificar ", "images/leaf_pro_new.gif", "images/leaf_pro_new.gif");
	bar.addSeparator('', 3);
	bar.addText('TextoFecha', 4, 'Fecha:<? echo  $fc; ?>');
	bar.addButton("Calendario_", 5, "", "images/dhtmlxcalendar_icon.gif", "images/dhtmlxcalendar_icon.gif");
	bar.addSeparator('', 6);
	bar.attachEvent("onClick", clicktoolBar);

	mygrid = w1.attachGrid();
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("No. Jornada,Deporte,Cantidad de Partidos,Banca,id1,id2,aut");
	mygrid.setInitWidths("55,150,80,100")
	mygrid.setColAlign("right,left,left,center")
	mygrid.setColTypes("ro,ro,ro,ro,ro,ro,ro");

	mygrid.setColumnColor("white,white,white,white");
	mygrid.setSkin("dhx_skyblue");
	mygrid.attachEvent("onRowSelect", doOnRowSelected);
	mygrid.attachEvent("onCheckbox", doOnCheck);

	mygrid.loadXML("jornadabb-1-3.php?fc=<? echo $_REQUEST["fc"]; ?>&Abanca=" + abanca);
	mygrid.init();
</script>