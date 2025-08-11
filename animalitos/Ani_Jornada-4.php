<?php
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();


?>

<div id="fromPremioJornada">

</div>
<div id="cco2"></div>
<script>
	var idRow = 0;
	var fc = '<? echo $_REQUEST['fc']; ?>';


	function clicktoolBarPrem(id) {
		switch (id) {
			case "Cerrar_":
				dhxWinsPrem1.window("wPrem1").close();
				break;
			case "Agregar_":
				_callBackGENDUK('Ani_Jornada-6.php', '|op=1|ID=<? echo $_REQUEST['ID']; ?>', "cco2");
				break;
			case "Eliminar_":
				if (idRow != 0) {
					_callBackGENDUK('Ani_Jornada-3.php', '|op=7|ID=<? echo $_REQUEST['ID']; ?>|l=' + idRow, "cco2");
				} else
					nalert('ERROR', 'DEBE SELECCIONAR PRIMERO LA JORNADA A MODIFICAR!!');
				mygridPrem.clearAll();
				mygridPrem.loadXML("animalitos/Ani_Jornada-5.php?ID=<? echo $_REQUEST['ID']; ?>");

				break;
			case "Modificar_":
				if (idRow != 0) {
					_callBackGENDUK('Ani_Jornada-6.php', '|op=2|ID=<? echo $_REQUEST['ID']; ?>|l=' + idRow, "cco2");
				} else
					nalert('ERROR', 'DEBE SELECCIONAR PRIMERO LA JORNADA A MODIFICAR!!');
				break;
		}
	}


	function doOnRowSelectedPrem(id) {
		idRow = id;
	}

	dhxWinsPrem1 = new dhtmlXWindows();
	dhxWinsPrem1.setImagePath("codebase/imgs/");
	wPrem1 = dhxWinsPrem1.createWindow("wPrem1", 300, 155, 335, 550);
	wPrem1.setText('Premio de <? echo $_REQUEST['Hj']; ?>');
	wPrem1.attachObject('fromPremioJornada');
	dhxWinsPrem1.window("wPrem1").button('close').hide();
	dhxWinsPrem1.window("wPrem1").button('minmax1').hide();
	dhxWinsPrem1.window("wPrem1").button('minmax2').hide();
	dhxWinsPrem1.window("wPrem1").button('park').hide();
	dhxWinsPrem1.window('wPrem1').setModal(true);
	var barPrem = wPrem1.attachToolbar();
	barPrem.addButton("Cerrar_", 1, "Cerrar", "animalitos/icons/noun_1042920_cc.png", "animalitos/icons/noun_1042920_cc.png");
	barPrem.addButton("Agregar_", 2, "Agregar ", "animalitos/icons/noun_991643_cc.png", "animalitos/icons/noun_991643_cc.png");
	barPrem.addButton("Modificar_", 3, "Modificar ", "animalitos/icons/noun_561917_cc.png", "animalitos/icons/noun_561917_cc.png");
	barPrem.addButton("Eliminar_", 4, "Eliminar", "animalitos/icons/noun_997234_cc.png", "animalitos/icons/noun_997234_cc.png");
	barPrem.attachEvent("onClick", clicktoolBarPrem);

	mygridPrem = wPrem1.attachGrid();
	mygridPrem.setImagePath("codebase/imgs/");
	mygridPrem.setHeader("Animal,Premio,Modo");
	mygridPrem.setInitWidths("95,70,100")
	mygridPrem.setColAlign("right,left,left")
	mygridPrem.setColTypes("ro,ro,ro");
	mygridPrem.setSkin("dhx_skyblue");
	mygridPrem.attachEvent("onRowSelect", doOnRowSelectedPrem);
	mygridPrem.loadXML("animalitos/Ani_Jornada-5.php?ID=<? echo $_REQUEST['ID']; ?>");

	mygridPrem.init();
</script>