<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$Grupo = $_REQUEST['Grupo'];
$IDC = $_REQUEST['IDC'];
$IDG = $_REQUEST['IDG'];
$IDDD = $_REQUEST['IDDD'];

$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbreglas_3 Where IDDD=$IDDD and  IDC='$IDC' and IDG=$IDG and Grupo=$Grupo ");
if (mysqli_num_rows($result) != 0) :
	$row = mysqli_fetch_array($result);
	$Minimas = $row['Minimas'];
	$Maximas = $row['Maximas'];
else :
	$Minimas = 0;
	$Maximas = 0;
endif;

$result = mysqli_query($GLOBALS['link'], "SELECT _tbjuegodd.*,_formatosbb.Descripcion AS Desc1 FROM _tbjuegodd,_formatosbb WHERE _tbjuegodd.`Formato`=_formatosbb.`Formato` and IDDD=$IDDD ");
$row = mysqli_fetch_array($result);

$NombredeJugada = $row['Descripcion'];
$NombredeGrupo = $row['Desc1'];


?>
<div id="FromMM">
	<table width="325" border="0">
		<tr>
			<td colspan="3" align="center" style="background:#4B79A7; color:#FFF">
				<div align="center" style="font-size:16px">Jugada:<? echo $NombredeJugada . '-' . $NombredeGrupo; ?></div>
			</td>
		</tr>
		<tr>
			<td colspan="2">Minimas de Combinaciones Permitidas:</td>
			<td width="96"><label>
					<input type="text" name="textfield" id="Minimas" size="5" value="<? echo $Minimas; ?>" />
				</label></td>
		</tr>
		<tr>
			<td width="99">&nbsp;</td>
			<td width="80">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">Maxima de Combinaciones Permitidas:</td>
			<td> <input type="text" name="textfield" id="Maximas" size="5" value="<? echo $Maximas; ?>" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3">
				<div>
					<div id='gridboxDRC' style="background-color:#FC0 "></div>
				</div>
			</td>
		</tr>
	</table>
</div>
<script>
	function clicktoolBarK(id) {

		switch (id) {
			case "Cerrar_":
				dhxWinsMM.window("w2").close();
				break;
			case "Grabar_":
				new Ajax.Request('procierre.php', {
					parameters: {
						op: 34,
						Grupo: <? echo $Grupo; ?>,
						IDC: '<? echo $IDC; ?>',
						IDG: <? echo $IDG; ?>,
						Minimas: $('Minimas').value,
						Maximas: $('Maximas').value,
						IDDD: <? echo $IDDD; ?>
					},
					method: 'post',
					asynchronous: false,
					onComplete: function(transport) {
						var response = transport.responseText.evalJSON(true);
						if (response) {
							nalert('Grabacion', ' Asignacion de Reglas con Exito! ');
							dhxWinsMM.window("w2").close();
						} else
							nalert('Error', ' No se Puede Almacenar la Informacion ');

					},
					onFailure: function() {
						alert('No tengo respuesta Comuniquese con el Administrador!');
					}
				});
				break;
		}
	}


	dhxWinsMM = new dhtmlXWindows();
	dhxWinsMM.setImagePath("codebase/imgs/");
	w2 = dhxWinsMM.createWindow("w2", 100, 270, 330, 300);
	w2.setText("Minimas / Maximas ");
	w2.attachObject('FromMM');
	dhxWinsMM.window("w2").button('close').hide();
	dhxWinsMM.window("w2").button('minmax1').hide();
	dhxWinsMM.window("w2").button('minmax2').hide();
	dhxWinsMM.window("w2").button('park').hide();
	dhxWinsMM.window("w2").denyResize();
	dhxWinsMM.window("w2").denyMove();
	dhxWinsMM.window("w2").centerOnScreen();
	dhxWinsMM.window('w2').setModal(true);
	var bar1 = w2.attachToolbar();
	bar1.addButton("Cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif");
	bar1.addButton("Grabar_", 2, "Grabar", "media/edit_icon.gif", "media/edit_icon.gif");
	bar1.attachEvent("onClick", clicktoolBarK);
</script>