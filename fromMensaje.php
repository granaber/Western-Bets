<?
require('prc_php.php');

$GLOBALS['link'] = Connection::getInstance();
$result1 = mysqli_query($GLOBALS['link'], "SELECT * FROM  _tbmensaje  ");
$row1 = mysqli_fetch_array($result1);
$fc = Fechareal($GLOBALS['minutosh'], "d/n/Y");;
?>

<div id="TblMensaje" style="background:#829BB0">
	<span style="color:#000">Ultima Actualizacion:<? echo $row1['fechaModi']; ?></span><br /><br />

	<div style="vertical-align: text-top"><span style="color:#000; vertical-align: top"> Texto :</span><textarea id="msg" name="" cols="120" rows="20" style="background:#FFF; color:#000"><? echo $row1['mensaje']; ?></textarea></div>
</div>
<div id='gridbox'></div>
<script>
	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				dhxWins.window("w1").close();
				break;
			case "Grabar_":
				makeResultwin("chaceStatus.php?SqlStatus=Update _tbmensaje  set fechaModi='<? echo $fc; ?>',mensaje='" + $('msg').value + "'", "gridbox");
				break;

		}
	}

	dhxWins = new dhtmlXWindows();
	dhxWins.setImagePath("codebase/imgs/");
	w1 = dhxWins.createWindow("w1", 270, 150, 600, 215);
	w1.setText('Mensaje de Cintillo');
	w1.attachObject('TblMensaje');
	dhxWins.window("w1").button('close').hide();
	dhxWins.window("w1").button('minmax1').hide();
	dhxWins.window("w1").button('minmax2').hide();
	dhxWins.window("w1").button('park').hide();
	dhxWins.window("w1").denyResize();

	dhxWins.window('w1').setModal(true);
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
	bar.addButton("Grabar_", 5, "Grabar", "images/page_setup.gif", "images/page_setup.gif");
	bar.attachEvent("onClick", clicktoolBar);

	$('<? echo $primero; ?>').focus();
</script>