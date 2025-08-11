<?php
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();


?>

<div id="fromPremioJornada">

</div>
<div id="cco2"></div>
<script>
	var idRow = 0;

	function clicktoolBarPrem(id) {
		switch (id) {
			case "Cerrar_":
				dhxWinsPrem1.window("wPrem1").close();
				break;
		}
	}


	function doOnRowSelectedPrem(id) {
		idRow = id;
	}

	dhxWinsPrem1 = new dhtmlXWindows();
	dhxWinsPrem1.setImagePath("codebase/imgs/");
	wPrem1 = dhxWinsPrem1.createWindow("wPrem1", 500, 50, 335, 550);
	wPrem1.setText('Topes de Numero, <? echo $_REQUEST['sor']; ?> (Grupo)');
	wPrem1.attachObject('fromPremioJornada');
	dhxWinsPrem1.window("wPrem1").button('close').hide();
	dhxWinsPrem1.window("wPrem1").button('minmax1').hide();
	dhxWinsPrem1.window("wPrem1").button('minmax2').hide();
	dhxWinsPrem1.window("wPrem1").button('park').hide();
	dhxWinsPrem1.window('wPrem1').setModal(true);
	var barPrem = wPrem1.attachToolbar();
	barPrem.addButton("Cerrar_", 1, "Cerrar", "animalitos/icons/noun_1042920_cc.png", "animalitos/icons/noun_1042920_cc.png");
	barPrem.attachEvent("onClick", clicktoolBarPrem);

	mygridPrem = wPrem1.attachGrid();
	mygridPrem.setImagePath("codebase/imgs/");
	mygridPrem.setHeader("Numero,Animal,Maximo de Venta");
	mygridPrem.setInitWidths("95,70,100")
	mygridPrem.setColAlign("right,left,left")
	mygridPrem.setColTypes("ro,ro,ed");
	mygridPrem.setSkin("dhx_skyblue");
	mygridPrem.attachEvent("onRowSelect", doOnRowSelectedPrem);
	mygridPrem.loadXML("animalitos/Ani_Habilitar-9.php?id=<? echo $_REQUEST['id']; ?>&IDG=<? echo $_REQUEST['IDG']; ?>");

	mygridPrem.init();
	mygridPrem.attachEvent("onEditCell", function(stage, rId, cInd, nValue, oValue) {

		if (stage == 2) {

			_callBackGENDUK('Ani_Habilitar-3.php', '|op=5|num=' + rId + '|IDG=<? echo $_REQUEST['IDG']; ?>|IDS=<? echo $_REQUEST['id']; ?>|Tope=' + nValue, 'cocN1');
			return true;
		}
	});
</script>