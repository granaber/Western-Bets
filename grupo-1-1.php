<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$accesogp = 0;
$accesoBanca = 0;
if (isset($_REQUEST['idt'])) :
	$idt = $_REQUEST['idt'];
	$accesogp = accesolimitado($idt);
	$accesoBanca = accesolimitadobanca($idt);

endif;
?>

<div id='fromGrupos' align="center" style="background: #FFF; color:#000;width:450px">
	<div id="a_tabbar" align="center" style="width:550px; height:450px;" />
	<?
	$sql = $accesoBanca == 0 ? "SELECT * FROM _tbanca order by IDB " : "SELECT * FROM _tbanca where IDB in (" . $accesoBanca . ") order by IDB ";
	$result_g = mysqli_query($GLOBALS['link'], $sql);
	$lista = '';
	$ltexto = '';
	while ($row_g = mysqli_fetch_array($result_g)) {
		$lista .= $row_g['IDB'] . ',';
		$ltexto .= $row_g['NombreB'] . ',';
		echo "<div id='tpg_" . $row_g['IDB'] . "'  style='height:430px; '>";
		echo "</div>";
	}
	?>
</div>
</div>
<div id='gridbox'></div>
<script>
	var idRow = 0;
	var lista = '<? echo $lista; ?>';
	var ltexto = '<? echo $ltexto; ?>';

	valoreslista = lista.split(',');
	valoresltexto = ltexto.split(',');

	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				dhxWins1.window("w1").close();
				break;
			case "Agregar_":
				dhxWins1.window("w1").close();
				yq = true;
				makeRequest('grupo.php?fc=0&accesoBanca=<?= $accesoBanca ?>');
				break;
			case "Modificar_":
				if (idRow != 0) {
					dhxWins1.window("w1").close();
					makeResultwin('grupo.php?fc=' + idRow + "&accesoBanca=<?= $accesoBanca ?>", 'tablemenu');
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
	}

	function doOnRowSelected(id) {
		idRow = id;
	}

	dhxWins1 = new dhtmlXWindows();
	dhxWins1.setImagePath("codebase/imgs/");
	w1 = dhxWins1.createWindow("w1", 350, 100, 570, 450);
	w1.setText('Grupos');
	w1.attachObject('fromGrupos');
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	dhxWins1.window("w1").denyResize();
	dhxWins1.window("w1").denyMove();
	dhxWins1.window('w1').setModal(true);
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
	bar.addButton("Agregar_", 1, "Agregar Grupos", "media/user.png", "media/user.png");
	bar.addButton("Modificar_", 1, "Modificar Grupos", "images/page_setup.gif", "images/page_setup.gif");
	bar.attachEvent("onClick", clicktoolBar);


	tabbar = new dhtmlXTabBar("a_tabbar", "top");
	tabbar.setStyle("dark_blue");
	tabbar.setImagePath("codebase/imgs/");
	tabbar.enableAutoReSize(true);

	for (i = 0; i <= valoreslista.length - 2; i++) {
		tabbar.addTab("a_" + valoreslista[i], valoresltexto[i], "150px");
		tabbar.setContent("a_" + valoreslista[i], "tpg_" + valoreslista[i]);
	}

	tabbar.enableScroll(true);
	tabbar.setTabActive("a_" + valoreslista[0]);


	for (i = 0; i <= valoreslista.length - 2; i++) {
		mygrid = new dhtmlXGridObject("tpg_" + valoreslista[i]);
		mygrid.setImagePath("codebase/imgs/");
		mygrid.setHeader("ID Grupo,Nombre del Grupo,Responsable,Estatus");
		mygrid.setInitWidths("40,110,110,80")
		mygrid.setColAlign("right,left,left,left")
		mygrid.setColTypes("ro,ro,ro,ch");
		mygrid.setSkin("dhx_skyblue");
		mygrid.attachEvent("onRowSelect", doOnRowSelected);
		mygrid.attachEvent("onCheckbox", doOnCheck);
		mygrid.init();
		mygrid.loadXML("grupo-1-3.php?IDB=" + valoreslista[i])

	}
</script>