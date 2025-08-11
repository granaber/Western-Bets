<?php

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$Dequipo = $_REQUEST["Dequipo"];
$Grupo = $_REQUEST["Grupo"];
$Liga = $_REQUEST["Liga"];
$iEd = $_REQUEST['iEd'];

?>
<div id='fromcambio' style=" background:#BAC6D8;width: 100%; height: 100%; ">


	<table width="873" border="0">

		<tr>
			<td></td>
			<td>Equipo</td>
			<td><input id="dequipo" name="" type="text" value="<? echo $Dequipo ?>" /></td>
		</tr>
		<tr>
			<td width="10">&nbsp;</td>
			<td width="107">Asociado a (Existente) </td>
			<td width="569"> <?
								echo '<select name="select2" size="1" id="equipoS"  >';
								echo "<option  value='0'></option>";
								$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb where  ( _equiposbb.Grupo=" . $Grupo . " or _equiposbb.Grupo1=" . $Grupo . " or _equiposbb.Grupo2=" . $Grupo . " ) order by Descripcion,IDE");
								while ($row = mysqli_fetch_array($result))
									echo "<option  value=" . $row["IDE"] . ">" . $row["Descripcion"] . "</option>";
								echo '</select></div></td>'; ?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Logo:</td>
			<td>
				<div id="vaultDiv"></div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="2">&nbsp;</td>
		</tr>
	</table>
</div>

<script>
	var Liga = <? echo $Liga; ?>;
	var Grupo = <? echo $Grupo; ?>;
	var Dequipo = '<? echo $Dequipo; ?>';
	var iEd = <? echo $iEd; ?>;

	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				dhxWins2.window("w2").close();
				break;
			case "Copiar_":
				new Ajax.Request('jornadabb-1-9.php?op=0&Dequipo=' + Dequipo + '&Grupo=' + Grupo + '&Liga=' + Liga + '&Asociado=' + $('equipoS').value + '&RDequipo=' + $('dequipo').value, {
					method: 'get',
					asynchronous: false,
					onSuccess: function(transport) {
						var response = transport.responseText.evalJSON(true);
						if (response[0]) {
							if (response[1] != -2) {

								var Idex = $('equipoS').selectedIndex;

								if (response[1] == -1) {
									$('equipo' + iEd).innerHTML = $('equipoS').options[Idex].text;
									$('equipo' + iEd).lang = "1";
								} else
									$('equipo' + iEd).innerHTML = response[1];


								$('equipoDev' + iEd).style.display = "";
								$('ButonAct' + iEd).style.display = "none";
								$('equipo' + iEd).style.backgroundColor = "#F90";

							} else
								alert('Este equipo ya esta asignado a otro equipo, por favor revise ( No se realizo ningun ajuste )');

						} else
							alert(' No se realizo ningun ajuste ');
					},
					onFailure: function() {
						alert('No tengo respuesta Comuniquese con el Administrador!');
					}
				});

				dhxWins2.window("w2").close();
				break;
		}
	}

	function doOnRowSelected(id) {
		idRow = id;
	}

	dhxWins2 = new dhtmlXWindows();
	dhxWins2.setImagePath("codebase/imgs/");
	w2 = dhxWins2.createWindow("w2", 150, 200, 650, 370);
	w2.setText('Asociacion de Equipos');
	w2.attachObject('fromcambio');
	dhxWins2.window("w2").button('close').hide();
	dhxWins2.window("w2").button('minmax1').hide();
	dhxWins2.window("w2").button('minmax2').hide();
	dhxWins2.window("w2").button('park').hide();
	dhxWins2.window('w2').setModal(true);
	var bar = w2.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
	bar.addButton("Copiar_", 1, "Grabar Configuracion", "images/copy.gif", "images/copy.gif");
	bar.attachEvent("onClick", clicktoolBar);

	vault = new dhtmlXVaultObject();
	vault.setImagePath("codebase/imgs/");
	vault.setFilesLimit(1);
	vault.strings.btnAdd = "Cargar";
	vault.strings.btnUpload = "Subir";
	vault.strings.btnClean = "Borrar";
	vault.setServerHandlers("UploadHandler.php", "GetInfoHandler.php", "GetIdHandler.php");
	//vault.onFileUploaded = function(file) { alert("id:" + file.id + ",name:" + file.name + ",uploaded:" + file.uploaded + ",error:" + file.error); }; 
	//?Liga="+Liga+"&Grupo="+Grupo+"&IDE="+$('equipoS').value
	vault.onAddFile = function(fileName) {
		var ext = this.getFileExtension(fileName);
		if (ext == "png" || ext == "PNG")
			return true;
		else
			alert('SOLO SE ACEPTA ARCHIVOS CON TIPO png');
	}

	vault.create("vaultDiv");
</script>