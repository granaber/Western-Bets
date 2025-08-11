<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$nc = $_REQUEST['nc'];
$IDCN = $_REQUEST['IDCN'];
$result1 = mysqli_query($GLOBALS['link'], "SELECT * FROM  _tconfighi  where IDCN=$IDCN");
$row1 = mysqli_fetch_array($result1);
$CantiEje = explode('|', $row1['_Fab']);
$Retirado = explode('|', $row1['_Ret']);
$fc = $row1['_Fecha'];

$EjeRetirados = explode('-', $Retirado[$nc - 1]);
$nivel = 0;
$cod = '0';

?>
<div id='fromCarrPlus'>
	<div style="background:#036; color:#FFF">Carrera:<? echo $nc; ?> de Fecha:<? echo $fc; ?></div>

	<div style="background:#036; color:#FFF">Aplicar a:<select id="selApp" onchange="frmChgCondiciones(<? echo $IDCN; ?>,<? echo $nc; ?>,true)">
			<option value="0" selected="selected">Todos</option>
			<option value="1">Grupo</option>
			<option value="2">Punto de Venta</option>
		</select></div>
	<div id='SelAppn2' style="background:#036; color:#FFF">Seleccion:</div>
	<div id='SeelAppn3'>
		<?
		include 'condiciones-6.php';
		?>
	</div>
</div>
<script>
	var CantiEje = <? echo $CantiEje[$nc - 1]; ?>;
	var IDCN = <? echo $IDCN; ?>;
	var Carr = <? echo $nc; ?>;

	function doOnCellEdit(stage, rowId, cellInd, newvalue) {
		if (stage == 2)
			makeResultwin("chaceStatus.php?SqlStatus=Update _creditos set Saldo=" + newvalue + " where IDC='" + rowId + "'", "gridbox");
		return true;
	}

	function grabarCondiciones() {
		DiviFijo = '';
		Premio = '';
		Cupo = '';
		for (i = 1; i <= CantiEje; i++) {
			if (isset('DF' + i))
				DiviFijo = DiviFijo + $('DF' + i).value + '|';
			else
				DiviFijo = DiviFijo + '*|';

			if (isset('P' + i))
				Premio = Premio + $('P' + i).value + '|';
			else
				Premio = Premio + '*|';

			if (isset('C' + i))
				Cupo = Cupo + $('C' + i).value + '|';
			else
				Cupo = Cupo + '*|';
		}
		nivel = $('selApp').value
		if (nivel == 0) cod = 0;
		else cod = $('selApp2').value;

		new Ajax.Request('condiciones-4.php', {
			parameters: {
				DiviFijo: DiviFijo,
				Premio: Premio,
				Cupo: Cupo,
				IDCN: IDCN,
				Carr: Carr,
				nivel: nivel,
				cod: cod
			},
			method: 'post',
			onComplete: function(transport) {
				var response = transport.responseText.evalJSON(true);
				if (response) {
					mygrid.clearAll();
					mygrid.loadXML("condiciones-7-1.php?IDCN=<? echo $IDCN; ?>&carr=<? echo $nc; ?>");
					alert('Informacion Almacenada con Exito!');
				} else
					alert('Informacion NO SE ACTUALIZO');
			},
			onFailure: function() {
				alert('No tengo respuesta Comuniquese con el Administrador!');
			}
		});


	}

	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				dhxWins.window("w1").close();
				dhxWins2.window("w2").close();
				break;
			case "Grabar_":
				grabarCondiciones();
				break;

		}
	}

	dhxWins = new dhtmlXWindows();
	dhxWins.setImagePath("codebase/imgs/");
	w1 = dhxWins.createWindow("w1", 270, 150, 280, 600);
	w1.setText('Condiciones de Carreras No.<? echo $nc; ?>');
	w1.attachObject('fromCarrPlus');
	dhxWins.window("w1").button('close').hide();
	dhxWins.window("w1").button('minmax1').hide();
	dhxWins.window("w1").button('minmax2').hide();
	dhxWins.window("w1").button('park').hide();
	dhxWins.window("w1").denyResize();

	dhxWins.window('w1').setModal(true);
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "media/icon_bar/close.gif", "media/icon_bar/close.gif");
	bar.addButton("Grabar_", 5, "Grabar", "media/icon_bar/page_setup.gif", "media/icon_bar/page_setup.gif");
	bar.attachEvent("onClick", clicktoolBar);

	$('<? echo $primero; ?>').focus();
</script>