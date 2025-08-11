<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
?>

<div id="obj">
	<table width="460" border="0">
		<tr>
			<td width="177">&nbsp;</td>
			<td width="273">&nbsp;</td>
		</tr>
		<tr>
			<td><span style="color:#000; font-size:12px">Introduzca la Clave de Modificar:</span></td>
			<td><input id="clave" name="input" type="password"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>

</div>
<script>
	function clicktoolBar(id) {
		switch (id) {
			case "continuar_":

				source = 'procierre.php';
				new Ajax.Request(source, {
					parameters: {
						op: 31,
						clave: $('clave').value,
						nivel: 1
					},
					method: 'post',
					asynchronous: false,
					onComplete: function(transport) {
						var response = transport.responseText.evalJSON(true);
						if (response) {
							dhxWins2.window("w1").close();
							guardarjorbb();

						} else {
							nalert('ERROR', 'CLAVE ERRADA!');
						}
					},
					onFailure: function() {
						alert('No tengo respuesta Comuniquese con el Administrador!');
					}
				});
				break;
			case "cerrar_":
				dhxWins2.window("w1").close();
				break;
		}
	}


	dhxWins2 = new dhtmlXWindows();
	dhxWins2.setImagePath("codebase/imgs/");
	var w1 = dhxWins2.createWindow("w1", 50, 120, 350, 150);
	w1.setText("Autorizacion a Modificar");
	w1.attachObject('obj');
	w1.centerOnScreen();
	dhxWins2.window("w1").button('close').hide();
	dhxWins2.window("w1").button('minmax1').hide();
	dhxWins2.window("w1").button('minmax2').hide();
	dhxWins2.window("w1").button('park').hide();
	dhxWins2.window("w1").denyResize();
	dhxWins2.window("w1").denyMove();
	dhxWins2.window("w1").setModal(true);

	var bar = w1.attachToolbar();
	bar.addButton("continuar_", 1, "Continuar", "media/down.ico", "media/down.ico");
	bar.addButton("cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif");
	bar.attachEvent("onClick", clicktoolBar);
	$('clave').value = '';
	$('clave').focus();
</script>