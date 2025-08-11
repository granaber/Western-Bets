<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$IDCN = $_REQUEST['IDCN'];
$nc = $_REQUEST['nc'];


?>
<div id="fromCarrPlus2s" style="color:#000">
	<div id="gridboxTPG" height="390px"></div>
</div>
<script>
	function doOnRowSelected(id) {



		new Ajax.Request('condiciones-7-2.php', {
			parameters: {
				row: id
			},
			method: 'post',
			onComplete: function(transport) {
				var response = transport.responseText.evalJSON(true);
				for (i = 1; i <= $('ntdc').lang; i++) {
					if (isset('DF' + i)) {
						$('DF' + i).value = 0;
						$('P' + i).value = 0;
						$('C' + i).value = 0;
					}

				}

				$('selApp').value = response[0];
				new Ajax.Request('condiciones-5.php', {
					method: 'post',
					asynchronous: false,
					parameters: {
						app: $('selApp').value,
						IDCN: <? echo $IDCN; ?>,
						nc: <? echo $nc; ?>
					},
					onComplete: function(transport) {
						var response = transport.responseText;
						$('SelAppn2').innerHTML = response;

					},
					onFailure: function() {
						alert('No tengo respuesta Comuniquese con el Administrador!');
					}
				});

				$('selApp2').value = response[1];
				$('DF' + response[2]).value = response[3];
				$('P' + response[2]).value = response[4];
				$('C' + response[2]).value = response[5];

			},
			onFailure: function() {
				alert('No tengo respuesta Comuniquese con el Administrador!');
			}
		});
	}

	dhxWins2 = new dhtmlXWindows();
	dhxWins2.setImagePath("codebase/imgs/");
	w2 = dhxWins2.createWindow("w2", 570, 150, 480, 600);
	w2.setText('Lista de Condiciones de la Carrera No.<? echo $_REQUEST['nc']; ?>');
	w2.attachObject('fromCarrPlus2s');
	dhxWins2.window("w2").button('close').hide();
	dhxWins2.window("w2").button('minmax1').hide();
	dhxWins2.window("w2").button('minmax2').hide();
	dhxWins2.window("w2").button('park').hide();
	dhxWins2.window("w2").denyResize();

	dhxWins2.window('w2').setModal(true);
	dimCol = "50,110,55,60,60,60";
	// Llamar para crear XML   
	//mientrasProceso('Escrutando','Procesando')
	// makeResultwin2('procierre.php?op=30&IDJ='+$('fc').lang+'&accesogp='+accesogp+'&grupo='+grupo,'newreq');

	// El primer GRID con tickets Perdedores
	// makeResultwin2('procierre.php?op=30&IDJ='+$('fc').lang,'newreq');

	mygrid = new dhtmlXGridObject('gridboxTPG');
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("Aplica,Seleccion,Ejemplar,Div.Fijo,Premio,Cupo(%)");
	mygrid.setInitWidths(dimCol)
	mygrid.setColAlign("left,left,right,right,left,left")
	mygrid.setColTypes("ro,ro,ro,ro,ro,ro");
	//

	mygrid.attachEvent("onRowSelect", doOnRowSelected);
	mygrid.setSkin("dhx_skyblue");
	mygrid.init();
	//mygrid.attachFooter("Total de Ticket (P):{#stat_count},#cspan,#cspan,#cspan,Venta Bsf.: {#stat_total}");
	mygrid.setSizes();
	mygrid.loadXML("condiciones-7-1.php?IDCN=<? echo $IDCN; ?>&carr=<? echo $_REQUEST['nc']; ?>");
</script>