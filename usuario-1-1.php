<?
session_start();
//if ($_SESSION['ejecutado']!==md5('O9plm1m91lk')):  echo 'ACCESO NEGADO/ACCESS DENIED/Zugriff verweigert'; exit; else: $_SESSION['ejecutado']=0;  endif;
?>

<?php

/*$fc=$_REQUEST['fc'];*/

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


$idt = $_REQUEST['idt'];
$accesogp = accesolimitado($idt);

?>
<div id='fromUsuarios' align="center" style="background: #FFF; color:#000;width:500px">
	<div id="a_tabbar" align="center" style="width:550px; height:470px;" />
	<?
	if ($accesogp == 0) :
		$result_g = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo where IDG!=0 order by IDG ");
		echo "<div id='otros'  style='height:430px; '>";
		echo "</div>";
	else :
		$result_g = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo where IDG in (" . $accesogp . ") order by IDG ");

	endif;
	$lista = '';
	$ltexto = '';
	while ($row_g = mysqli_fetch_array($result_g)) {
		$lista .= $row_g['IDG'] . ',';
		$ltexto .= $row_g['Descrip'] . ',';
		echo "<div id='tpg_" . $row_g['IDG'] . "'  style='height:430px; '>";
		echo "</div>";
	}


	$vc = $_REQUEST['idt'];

	?>
</div>
</div>

<div id='gridbox'></div>
<script>
	var idRow = 0;
	var lista = '<? echo $lista; ?>';
	var ltexto = '<? echo $ltexto; ?>';
	var accesogp = '<? echo $accesogp; ?>';
	var idt = <? echo $vc; ?>;
	var idta = <? echo $idt; ?>;
	valoreslista = lista.split(',');
	valoresltexto = ltexto.split(',');

	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				dhxWins1.window("w1").close();
				break;
			case "Agregar_":
				dhxWins1.window("w1").close();
				makeResultwin('usuario.php?fc=0&idt=<? echo $idt; ?>', 'tablemenu');
				break;
			case "Modificar_":
				if (idRow != 0) {
					dhxWins1.window("w1").close();
					makeResultwin('usuario.php?fc=' + idRow + '&idt=<? echo $vc; ?>', 'tablemenu');
				} else
					nalert('ERROR', 'DEBE SELECCIONAR PRIMERO EL USUARIO A MODIFICAR!!');
				break;

				//"ImprimirReporte2('reportedeventashipodromo-2.php');"
		}
	}

	function doOnCheck(rowId, cellInd, state) {
		if (state)
			estado = 1;
		else
			estado = 0;

		if (rowId != idta) {
			new Ajax.Request("chaceStus.php", {
				parameters: {
					opk: 1,
					estado: estado,
					IDusu: rowId
				},
				method: 'post',
				onComplete: function(transport) {
					var response = transport.responseText.evalJSON();
					if (!response)
						alert('No se pudo actulizar su requerimiento');
				},
				onFailure: function() {
					alert('No tengo respuesta Comuniquese con el Administrador!');
				}
			});
		} else {
			alert('Este Usuario (Usted mismo) no puede bloquearse! Opcion sin Efecto');
			return 0;
		}
	}

	function doOnRowSelected(id) {
		idRow = id;
	}

	dhxWins1 = new dhtmlXWindows();
	dhxWins1.setImagePath("codebase/imgs/");
	w1 = dhxWins1.createWindow("w1", 350, 250, 570, 530);
	w1.setText('Usuarios');
	w1.attachObject('fromUsuarios');
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	dhxWins1.window("w1").denyResize();
	dhxWins1.window("w1").denyMove();
	dhxWins1.window('w1').setModal(true);
	dhxWins1.window('w1').centerOnScreen();
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
	bar.addButton("Agregar_", 1, "Agregar Usuario", "media/user.png", "media/user.png");
	bar.addButton("Modificar_", 1, "Modificar Usuario", "images/page_setup.gif", "images/page_setup.gif");
	bar.attachEvent("onClick", clicktoolBar);


	tabbar = new dhtmlXTabBar("a_tabbar", "top");
	tabbar.setStyle("dhx_skyblue");
	tabbar.setImagePath("codebase/imgs/");
	tabbar.enableAutoReSize(true);
	if (accesogp == 0) {
		tabbar.addTab("a_0", "OTROS USUARIOS", "150px");
		tabbar.setContent("a_0", "otros");
	}
	for (i = 0; i <= valoreslista.length - 2; i++) {
		tabbar.addTab("a_" + valoreslista[i], valoresltexto[i], "150px");
		tabbar.setContent("a_" + valoreslista[i], "tpg_" + valoreslista[i]);
	}

	tabbar.enableScroll(true);
	if (accesogp == 0)
		tabbar.setTabActive("a_0");
	else
		tabbar.setTabActive("a_" + valoreslista[0]);
	if (accesogp == 0) {
		mygrid = new dhtmlXGridObject("otros");
		mygrid.setImagePath("codebase/imgs/");
		mygrid.setHeader("Usuario,Nombre Completo,Tipo de Usuario,Estatus");
		mygrid.setInitWidths("100,110,110,80")
		mygrid.setColAlign("right,left,left,left")
		mygrid.setColTypes("ro,ro,ro,ch");
		mygrid.setSkin("dhx_skyblue");
		mygrid.attachEvent("onRowSelect", doOnRowSelected);
		mygrid.attachEvent("onCheckbox", doOnCheck);
		mygrid.init();
		mygrid.loadXML("usuario-1-3.php?IDG=0&frma=1")
	}
	for (i = 0; i <= valoreslista.length - 2; i++) {
		mygrid = new dhtmlXGridObject("tpg_" + valoreslista[i]);
		mygrid.setImagePath("codebase/imgs/");
		mygrid.setHeader("Usuario,Nombre Completo,Asociado a:,Estatus");
		mygrid.setInitWidths("100,110,110,80")
		mygrid.setColAlign("right,left,left,left")
		mygrid.setColTypes("ro,ro,ro,ch");
		mygrid.setSkin("dhx_skyblue");
		mygrid.attachEvent("onRowSelect", doOnRowSelected);
		mygrid.attachEvent("onCheckbox", doOnCheck);
		mygrid.init();
		mygrid.loadXML("usuario-1-3.php?IDG=" + valoreslista[i] + "&frma=2")

	}
</script>