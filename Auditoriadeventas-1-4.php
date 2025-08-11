<br />
<div align="center"><span style="color:#FC0; font-size:16px">Auditoria de Ventas</span></div>
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

<script>
	var IDB = <? echo $IDB; ?>;
	var IDJ = <? echo $IDJ; ?>;
	var codeGrupo = '<? echo implode(',', $listaIDD); ?>';
	var Encabezados;
	var idselect = 0;
	var IDDDjs = new Array();

	function verAudi(selecttion1) {

		new Ajax.Request('Auditoriadeventas-5.php', {
			parameters: {
				IDJ: IDJ,
				param: selecttion1
			},
			method: 'post',
			asynchronous: false,
			onCreate: function() {
				$("printer3").innerHTML = '<div align="center" ><img src="media/ajax-loader.gif" /></div>';
			},
			onComplete: function(transport) {
				var response2 = transport.responseText.evalJSON(true);

				arl = response2[1];
				AudTik = response2[0].join('(');
				tti = 'Auditoria Parlay';
				a = '<table width="235" border="0" style="font-size:10px; font-family:Arial, Helvetica, sans-serif"> <tr>   <th colspan="3" scope="col" >' + tti + '</th> </tr><tr>    <th width="5" scope="col">Jgo.</th> <th  scope="col" width="78" >Equipos Auditar</th>    <th width="35" scope="col"></th>  </tr>';

				for (i = 0; i <= arl.length - 1; i++) {
					dequi = arl[i].split('|');
					a += '<tr><th scope="col" >' + (i + 1) + ' ' + dequi[1] + '</th><th scope="col" width="78" class="alinl"  >   ' + dequi[2] + '</th><th scope="col" width="35" >' + dequi[3] + '   </th></tr>';
				}


				a += '<tr><th colspan="3" scope="col"><p align="left">-------------------------------------------------------------------</p></th></tr>';
				$("printer3").innerHTML = a + '</table>';


			},
			onFailure: function() {
				alert('No tengo respuesta Comuniquese con el Administrador!');
			}
		});



	}


	valorescodeGrupo = codeGrupo.split(',');


	function my_func(idn, ido) {

		dk = idn.split('-');
		idselect = dk[1];
		return true;
	};
	var seleccion = new Array();
	var i;

	function doOnCheck(rowId, cellInd, state) {
		if (state)
			estado = 1;
		else
			estado = 0;
		//  alert(rowId)
		/* alert(mygridA[idselect].cells(rowId,(cellInd+1)).getValue())
	  
	  switch (cellInd){
		case 2:
			seleccion[idselect][rowId]=mygridA[idselect].cells(rowId,3).getValue();
			break;
		case 4:
			seleccion[idselect][rowId][cellInd]=mygridA[idselect].cells2(rowId,5).getValue();
			break;
		default:
	  }*/


		var selecttion = new Array();
		m = 0;
		for (i = 0; i <= valorescodeGrupo.length - 1; i++) {

			for (j = 0; j <= mygridA[i].getRowsNum() - 1; j++) {

				// alert(mygridA[i].cells2(j,2).getValue()	)
				if (mygridA[i].cells2(j, 2).getValue() == 1) {
					selecttion[m] = 'e-1-' + mygridA[i].cells2(j, 0).getValue();
					m++;
				}
				if (mygridA[i].cells2(j, 4).getValue() == 1) {
					selecttion[m] = 'e-2-' + mygridA[i].cells2(j, 0).getValue();
					m++;
				}

				// alert(selecttion);
				columnas = IDDDjs[i].length;
				for (x = 6; x <= columnas + 5; x++)
					if (mygridA[i].cells2(j, x).getValue() == 1) {
						selecttion[m] = 'j-' + IDDDjs[i][(x - 6)] + '-' + mygridA[i].cells2(j, 0).getValue();
						m++;
					}
			}
		}
		//  alert(selecttion);
		selecttion1 = selecttion.join('|');
		verAudi(selecttion1);

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
				op: 6,
				Grupo: valorescodeGrupo[i]
			},
			method: 'post',
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
		mygridA[i].setHeader("ID,Hora,,Equipo1,,Equipo2," + Encabezados[0]);
		mygridA[i].setInitWidths("50,50,20,100,20,100," + Encabezados[1]);
		mygridA[i].setColAlign("right,left,left,left,left,left," + Encabezados[2]);
		mygridA[i].setColTypes("ro,ro,ch,ro,ch,ro," + Encabezados[3]);
		mygridA[i].setSkin("light");
		mygridA[i].attachEvent("onCheckbox", doOnCheck);
		mygridA[i].init();
		mygridA[i].clearAll();
		mygridA[i].loadXML("Auditoriadeventas-3.php?Grupo=" + valorescodeGrupo[i] + "&IDB=" + IDB + "&IDJ=" + IDJ);
		IDDDjs[i] = Encabezados[4];

	}
	tabbar.setTabActive("a-0");
</script>