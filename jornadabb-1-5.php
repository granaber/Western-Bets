<?php

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$idj = $_REQUEST["idj"];
$dp = $_REQUEST["dp"];
$IDB = $_REQUEST["IDB"];
$fc = $_REQUEST["fc"];

$hasta = $idj . '-' . $IDB . '-' . $dp;

?>
<div id='fromcambio' style=" background:#BAC6D8;width: 100%; height: 100%; " lang='<? echo $hasta; ?>'>

	<?
	//echo ("SELECT _jornadabb.*,_tbanca.NombreB,_gruposdd.Descripcion FROM _jornadabb,_tbanca,_gruposdd where _gruposdd.Grupo=_jornadabb.Grupo and _jornadabb.IDB=_tbanca.IDB and _jornadabb.Grupo=".$dp." and _jornadabb.IDB<>$IDB and _jornadabb.fecha='$fc'");	
	?>
	<table width="324" border="0">

		<tr>
			<td></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="11">&nbsp;</td>
			<td width="92">Copiar </td>
			<td width="261"><select name="select2" id="desde">
					<?

					$result = mysqli_query($GLOBALS['link'], "SELECT _jornadabb.*,_tbanca.NombreB,_gruposdd.Descripcion FROM _jornadabb,_tbanca,_gruposdd where _gruposdd.Grupo=_jornadabb.Grupo and _jornadabb.IDB=_tbanca.IDB and _jornadabb.Grupo=" . $dp . " and _jornadabb.IDB<>$IDB and _jornadabb.fecha='$fc'");
					while ($row_g = mysqli_fetch_array($result)) {

						echo '<option value="' . $row_g['IDJ'] . '-' . $row_g['IDB'] . '-' . $row_g['Grupo'] . '">' . $row_g['NombreB'] . '-' . $row_g['Descripcion'] . '</option>';
					}
					?>
				</select></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="2">* Solamente se Copiara los logros de la otra(s) banca configuradas en el mismo Sistema. En Caso de quere exportar logros de otro proveedor este se procede por otra opcion del menu de Administracion!</td>
		</tr>
	</table>
</div>

<script>
	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				dhxWins2.window("w2").close();
				break;
			case "Copiar_":

				ImportarLogros();
				dhxWins2.window("w2").close();
				break;
		}
	}

	function doOnRowSelected(id) {
		idRow = id;
	}

	dhxWins2 = new dhtmlXWindows();
	dhxWins2.setImagePath("codebase/imgs/");
	w2 = dhxWins2.createWindow("w2", 350, 300, 250, 200);
	w2.setText('Importar Configuracion');
	w2.attachObject('fromcambio');
	dhxWins2.window("w2").button('close').hide();
	dhxWins2.window("w2").button('minmax1').hide();
	dhxWins2.window("w2").button('minmax2').hide();
	dhxWins2.window("w2").button('park').hide();
	dhxWins2.window('w2').setModal(true);
	var bar = w2.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
	bar.addButton("Copiar_", 1, "Copiar Configuracion", "images/copy.gif", "images/copy.gif");
	bar.attachEvent("onClick", clicktoolBar);
</script>