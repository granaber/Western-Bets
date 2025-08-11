<style type="text/css">
	.Estilo2 {
		color: #FFFFFF
	}
</style>
<?php
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();
$ListaA = array();
$ListaB = array();
$resultj = mysqli_query($link, "SELECT * FROM _Loterias  Where Activa=1");
while ($row = mysqli_fetch_array($resultj)) {
	$ListaA[] = $row['IDL'];
	$ListaB[] = $row['Nombre'];
}
foreach ($ListaA as $i => $delta) {
	echo "<div id='lote" . $ListaA[$i] . "'  style='height:430px; '>";
	echo "</div>";
}
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
	var fc = '<? echo FecharealAnimalitos($minutosh, "d/n/Y"); ?>';
	var L1 = '<? echo implode(',', $ListaA); ?>';
	var L2 = '<? echo implode(',', $ListaB); ?>';

	var Rl1 = L1.split(',');
	var Rl2 = L2.split(',');
	var xId = Rl1[0];

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
		fc = mCal.getFormatedDate("%d/%c/%Y", date);
		setCookie('FechaCookie', fecha);
		bar.setItemText('TextoFecha', 'Fecha: ' + fc);
		dhxWins2.window("w2").close();
		mygrid.clearAll();
		mygrid.loadXML("animalitos/Ani_Jornada-1.php?Fee=" + fc);
	}

	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				dhxWins1.window("w1").close();
				break;
			case "Agregar_":
				_callBackGENDUK('Ani_Jornada-2.php', '|op=1|fc=' + fc, "coc");
				break;
			case "All_":
				_callBackGENDUK('Ani_Jornada-3.php', '|op=4|fc=' + fc + '|IDL=' + xId, "coc");
				mygrid[xId].clearAll();
				mygrid[xId].loadXML("animalitos/Ani_Jornada-1.php?Fee=" + fc + '&IDL=' + xId);
				break;
			case "Modificar_":
				if (idRow != 0) {
					_callBackGENDUK('Ani_Jornada-2.php', '|op=2|ID=' + idRow + '|fc=' + fc, "coc");
				} else
					nalert('ERROR', 'DEBE SELECCIONAR PRIMERO LA JORNADA A MODIFICAR!!');
				break;
			case "Calendario_":
				calendario();
				break;
			case "Premios_":
				if (idRow != 0) {
					_callBackGENDUK('Ani_Jornada-4.php', '|Hj=' + mygrid[xId].cells(idRow, 1).getValue() + '|ID=' + idRow, "coc");
				} else
					nalert('ERROR', 'DEBE SELECCIONAR PRIMERO LA JORNADA!!');
				break;
		}
	}

	function doOnCheck(rowId, cellInd, state) {
		if (state)
			estado = 1;
		else
			estado = 0;
		_callBackGENDUK('Ani_Jornada-3.php', '|op=3|ID=' + rowId + '|fc=' + fc + '|Activo=' + estado);
	}

	function doOnRowSelected(id) {
		idRow = id;
	}

	function clicktoolTAB(id, lastId) {
		var inew = id.split("_");

		xId = inew[1];

		return true;

	}
	dhxWins1 = new dhtmlXWindows();
	dhxWins1.setImagePath("codebase/imgs/");
	w1 = dhxWins1.createWindow("w1", 350, 255, 555, 450);
	w1.setText('Lista de Jornada ANIMALITOS');
	w1.attachObject('fromJornada');
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	dhxWins1.window('w1').setModal(true);
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 1, "Cerrar", "animalitos/icons/noun_1042920_cc.png", "animalitos/icons/noun_1042920_cc.png");
	//	bar.addButton("Agregar_", 2, "Agregar ", "animalitos/icons/noun_991643_cc.png", "animalitos/icons/noun_991643_cc.png");
	bar.addButton("Modificar_", 3, "Modificar ", "animalitos/icons/noun_561917_cc.png", "animalitos/icons/noun_561917_cc.png");
	bar.addButton("Premios_", 4, "Premios", "animalitos/icons/noun_987636_cc.png", "animalitos/icons/noun_987636_cc.png");
	bar.addButton("All_", 5, "Activar Todos", "animalitos/icons/noun_713987_cc.png", "animalitos/icons/noun_713987_cc.png");
	bar.addSeparator('', 6);
	bar.addText('TextoFecha', 7, 'Fecha:' + fc);
	bar.addButton("Calendario_", 8, "", "animalitos/icons/noun_932012_cc.png", "animalitos/icons/noun_932012_cc.png");
	bar.addSeparator('', 9);
	bar.attachEvent("onClick", clicktoolBar);

	tabbarVer = w1.attachTabbar();
	tabbarVer.setImagePath("codebase/imgs/");
	tabbarVer.enableAutoReSize(true);
	tabbarVer.enableScroll(true);
	tabbarVer.setSkinColors("#FCFBFC", "#F4F3EE", "#FCFBFC");
	for (i = 0; i <= Rl1.size() - 1; i++) {
		tabbarVer.addTab("a_" + Rl1[i], Rl2[i]);
		tabbarVer.setContent("a_" + Rl1[i], "lote" + Rl1[i]);
	}
	tabbarVer.setTabActive("a_" + Rl1[0]);
	tabbarVer.attachEvent("onSelect", clicktoolTAB);
	mygrid = new Array();
	for (i = 0; i <= Rl1.size() - 1; i++) {
		x = Rl1[i];
		mygrid[x] = new dhtmlXGridObject("lote" + Rl1[i]);
		mygrid[x].setImagePath("codebase/imgs/");
		mygrid[x].setHeader("No. Jornada,Sorteo,Animalitos,Activa");
		mygrid[x].setInitWidths("70,200,80,100")
		mygrid[x].setColAlign("right,left,left,center")
		mygrid[x].setColTypes("ro,ro,ro,ch");
		mygrid[x].setColumnColor("white,white,white,white");
		mygrid[x].setSkin("dhx_skyblue");
		mygrid[x].attachEvent("onRowSelect", doOnRowSelected);
		mygrid[x].attachEvent("onCheckbox", doOnCheck);
		mygrid[x].loadXML("animalitos/Ani_Jornada-1.php?Fee=" + fc + '&IDL=' + Rl1[i]);
		mygrid[x].init();
	}
</script>