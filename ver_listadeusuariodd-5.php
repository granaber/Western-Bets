<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
global $cantidadParlay;

$IDC = $_REQUEST['IDC'];

$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbrestriccionesxparlay where IDC='" . $IDC . "'");

if (mysqli_num_rows($resultj) == 0) :
	for ($i = 2; $i <= $cantidadParlay; $i++)
		$result = mysqli_query($GLOBALS['link'], "Insert _tbrestriccionesxparlay values('$IDC',$i,0)");
endif;



?>
<div id="fromRestriciones" style=" height:1000px; background:#4B79A7">

</div>
<div id="gridbox"></div>
<script>
	var IDC = '<? echo $IDC ?>';

	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				dhxWins1.window("w1").close();
				break;
			case "Copiar_":
				CopyToLista(IDC);
				nalert('COPIANDO...', 'Lista Copiada');
				dhxWins1.window("w1").close();
				break;


		}
	}

	function doOnRowSelected(id) {
		idseleccionado = id;
	}

	function doOnCellEdit(stage, rowId, cellInd, newvalue) {

		if (stage == 2)
			makeResultwin("chaceStatus.php?SqlStatus=Update _tbrestriccionesxparlay set MontodeVenta=" + newvalue + " where Cantidad=" + rowId + " and IDC='" + IDC + "'", "gridbox");
		return true;
	}

	var dhxWins1 = new dhtmlXWindows();
	dhxWins1.setImagePath("codebase/imgs/");
	var w1 = dhxWins1.createWindow("w1", 600, 850, 250, 300);
	w1.setText("Lista de Restricciones Parlay");
	w1.attachObject('fromRestriciones');
	dhxWins1.window('w1').setModal(true);

	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif");
	bar.addButton("Copiar_", 2, "Copiar", "media/tray.ico", "media/tray.ico");
	bar.attachEvent("onClick", clicktoolBar);

	mygrid = w1.attachGrid();
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("Cantidad Parlay,Monto Maximo de Venta");
	mygrid.setInitWidths("120,80")
	mygrid.setColAlign("right,left")
	mygrid.setColTypes("ro,ed");
	mygrid.setColSorting("int,int");
	mygrid.setSkin("dhx_skyblue");
	mygrid.setColumnColor("white,white")
	mygrid.attachEvent("onRowSelect", doOnRowSelected);
	mygrid.attachEvent("onEditCell", doOnCellEdit);
	mygrid.init();
	mygrid.loadXML("ver_listadeusuariodd-5-1.php?IDC=" + IDC);
</script>