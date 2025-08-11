<br />
<div align="center"><span style="color:#FC0; font-size:16px">** Auditoria de Resultado **</span></div>
<br />


<div id="a_tabbar" style="width:925px; height:435px;" />
</div>
<?
if (isset($_REQUEST['xfc'])) :
	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();

	$fc = $_REQUEST['xfc'];
	$IDB = $_REQUEST['IDB'];
endif;
$listaIDD = array();
$IDJ = 0;
$result2 = mysqli_query($GLOBALS['link'], "SELECT _gruposdd.Descripcion, _gruposdd.Grupo,_jornadabb.IDJ FROM _jornadabb,_gruposdd where _jornadabb.Grupo=_gruposdd.Grupo and Fecha='$fc' and _jornadabb.IDB=$IDB");

while ($row = mysqli_fetch_array($result2)) {
	$listaIDD[] = $row['Grupo'];
	$IDJ = $row['IDJ'];
	echo ' <div  id="Tb_' . $row['Grupo'] . '" lang="' . $row['Descripcion'] . '" ><div  id="Grid_' . $row['Grupo'] . '"  height="390px"    style=" width:900px;background-color:#FC0 "></div></div>';
}
?>
<? if (count($listaIDD) != 0) : ?>
	<script>
		var IDB = <? echo $IDB; ?>;
		var IDJ = <? echo $IDJ; ?>;
		var codeGrupo = '<? echo implode(',', $listaIDD); ?>';
		var Encabezados;

		var IDDDjs = new Array();


		valorescodeGrupo = codeGrupo.split(',');


		function my_func(idn, ido) {

			dk = idn.split('-');
			idselect = dk[1];
			return true;
		};

		function doOnRowSelected(rowId, cellIndex) {
			var style = mygridA[idselect].cells(rowId, cellIndex).cell.style.cssText;
			if (style != '') {
				idx = cellIndex - 4;
				IDP = (mygridA[idselect].getRowIndex(rowId)) + 1;
				IDPr = rowId;
				textoCol = mygridA[idselect].getColumnLabel(cellIndex);
				makeResultwin2("xmlAuditoria_Resul-5.php?Grupo=" + valorescodeGrupo[idselect] + "&IDPr=" + IDPr + "&IDJ=<? echo $IDJ; ?>&IDP=" + IDP + "&TCol=" + textoCol + '&IDDD=' + IDDDjs[idselect][idx], 'fromChangeOdds'); //
			}
			return true;
		}

		var mygridA = new Array();
		tabbar = new dhtmlXTabBar("a_tabbar", "top");

		tabbar.attachEvent('onSelect', my_func);
		tabbar.setImagePath("codebase/imgs/");
		tabbar.setSkinColors("#FCFBFC", "#F4F3EE", "#FCFBFC");
		for (i = 0; i <= valorescodeGrupo.length - 1; i++) {
			tabbar.addTab("a-" + i, $('Tb_' + valorescodeGrupo[i]).lang, "150px");
			tabbar.setContent("a-" + i, 'Tb_' + valorescodeGrupo[i]);
			new Ajax.Request('proce_ajax.php', {
				parameters: {
					op: 7,
					Grupo: valorescodeGrupo[i]
				},
				method: 'get',
				asynchronous: false,
				onComplete: function(transport) {
					var response = transport.responseText.evalJSON(true);
					Encabezados = response;
				},
				onFailure: function() {
					alert('No tengo respuesta Comuniquese con el Administrador!');
				}
			});

			mygridA[i] = new dhtmlXGridObject('Grid_' + valorescodeGrupo[i]);
			mygridA[i].setImagePath("codebase/imgs/");
			mygridA[i].setHeader("ID,Hora,Equipo1,Equipo2," + Encabezados[0]);
			mygridA[i].setInitWidths("50,50,100,100," + Encabezados[1]);
			mygridA[i].setColAlign("right,left,left,left," + Encabezados[2]);
			mygridA[i].setSkin("light");
			mygridA[i].attachEvent("onRowSelect", doOnRowSelected);
			mygridA[i].init();
			mygridA[i].clearAll();
			mygridA[i].loadXML("xmlAuditoria_Resul-3.php?Grupo=" + valorescodeGrupo[i] + "&IDB=" + IDB + "&IDJ=" + IDJ);
			IDDDjs[i] = Encabezados[4];

		}
		tabbar.setTabActive("a-0");
	</script>
<? endif; ?>