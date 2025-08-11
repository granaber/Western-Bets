<?php

/*$fc=$_REQUEST['fc'];*/


require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

if (isset($_REQUEST['idt'])) :
	$idt = $_REQUEST['idt'];
	$accesogp = accesolimitado($idt);
else :
	$accesogp = 0;
endif;
$tp = "";
$idg = "";

?>
<div id='fromConcesionario' align="center" style="background: #FFF; color:#000;width:600px">

	<div id="a_tabbar" align="center" style="width:750px; height:580px;" />
	<?
	if ($accesogp == 0) :

		$result_g = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo  order by IDG ");
		while ($row_g = mysqli_fetch_array($result_g)) {
			$lista .= $row_g['IDG'] . ',';
			$ltexto .= $row_g['Descrip'] . ',';
			echo "<div id='tpg_" . $row_g['IDG'] . "'  style='height:550px; '>";
			echo "</div>";
		}



	else :
		$result_g = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo where IDG=" . $accesogp . " order by IDG ");

		$lista = '';
		$ltexto = '';
		while ($row_g = mysqli_fetch_array($result_g)) {
			$lista .= $row_g['IDG'] . ',';
			$ltexto .= $row_g['Descrip'] . ',';
			echo "<div id='tpg_" . $row_g['IDG'] . "'  style='height:550px; '>";
			//	include('ordenconc.php'); 
			echo "</div>";
		}
	endif;
	?>
</div>
</div>
<script>
	var idRow = 0;
	var lista = '<? echo $lista; ?>';
	var ltexto = '<? echo $ltexto; ?>';

	var listab = '<? echo $listaB; ?>';
	var ltextob = '<? echo $ltextoB; ?>';

	valoreslista = lista.split(',');
	valoresltexto = ltexto.split(',');
	valoreslistaB = listab.split(',');
	valoresltextoB = ltextob.split(',');

	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				dhxWins1.window("w1").close();
				break;
			case "Ver_":
				//dhxWins1.window("w1").close();
				if (idRow != 0)
					makeResultwin('crd-1-5.php?IDC=' + idRow, 'tablemenu');
				break;
			case "Modificar_":
				if (idRow != 0) {
					dhxWins1.window("w1").close();
					makeResultwin('consecionario.php?fc=' + idRow + '&idt=<? echo $idt ?>', 'tablemenu');
				} else
					nalert('ERROR', 'DEBE SELECCIONAR PRIMERO EL CONCESIONARIO A MODIFICAR!!');
				break;

				//"ImprimirReporte2('reportedeventashipodromo-2.php');"
		}
	}
	/*   function doOnCheck(rowId,cellInd,state){
		  
		//mygrid.checkAll(false);////<----- Chequear
		if (cellInd==2){
			if (state)
			  estado=1;
			else
			  estado=0;
			  new Ajax.Request('install-1-4.php?op=1&idr='+rowId+'&ins='+estado,{method:'get',asynchronous:false	,onComplete: function(transport){
										var response = transport.responseText.evalJSON(true);
										if (!response)
											alert('DISCULPE NO PUEDO ACTUALIZAR');		
										},	
										onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
										});		
		   }
		  }*/

	function doOnCellEdit(stage, rowId, cellInd, newvalue) {
		var response = true
		if (cellInd == 2 && stage == 2)
			new Ajax.Request('crd-1-4.php?op=1&IDC=' + rowId + '&credito=' + newvalue, {
				method: 'get',
				asynchronous: false,
				onComplete: function(transport) {
					response = transport.responseText.evalJSON(true);
					if (!response)
						alert('DISCULPE NO PUEDO ACTUALIZAR');
				},
				onFailure: function() {
					alert('No tengo respuesta Comuniquese con el Administrador!');
				}
			});


		return true;
	}


	function doOnRowSelected(id) {
		idRow = id;
	}

	dhxWins1 = new dhtmlXWindows();
	dhxWins1.setImagePath("codebase/imgs/");
	w1 = dhxWins1.createWindow("w1", 300, 255, 770, 650);
	w1.setText('Modulo de Credito');
	w1.attachObject('fromConcesionario');
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	dhxWins1.window("w1").denyResize();
	dhxWins1.window("w1").denyMove();
	dhxWins1.window('w1').setModal(true);
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
	bar.addButton("Ver_", 1, "Ver Movimientos", "media/users.png", "media/users.png");
	/*bar.addButton("Modificar_", 1, "Modificar Concesionario", "images/page_setup.gif", "images/page_setup.gif");
	 */
	bar.attachEvent("onClick", clicktoolBar);


	tabbar1 = new dhtmlXTabBar("a_tabbar", "top");
	tabbar1.setStyle("winbiscarf");
	tabbar1.setImagePath("codebase/imgs/");
	tabbar1.enableAutoReSize(true);
	for (i = 0; i <= valoreslista.length - 2; i++) {
		tabbar1.addTab("a_" + valoreslista[i], valoresltexto[i], "150px");
		tabbar1.setContent("a_" + valoreslista[i], "tpg_" + valoreslista[i]);
	}

	tabbar1.enableScroll(true);
	tabbar1.setTabActive("a_" + valoreslista[0]);

	for (i = 0; i <= valoreslista.length - 2; i++) {
		mygrid = new dhtmlXGridObject("tpg_" + valoreslista[i]);
		mygrid.setImagePath("codebase/imgs/");
		mygrid.setHeader("Letra,Nombre Asignado,Credito,Saldo,Debe,Ultima Transaccion");
		mygrid.setInitWidths("100,110,110,110,110,110")
		mygrid.setColAlign("right,left,left,left,left")
		mygrid.setColTypes("ro,ro,ed,ro,ro,ro");
		mygrid.setColSorting("str,str,str,str,str,str")
		mygrid.setSkin("dhx_skyblue");
		mygrid.attachEvent("onRowSelect", doOnRowSelected);
		mygrid.attachEvent("onEditCell", doOnCellEdit);
		mygrid.init(); //	mygrid.attachEvent("onCheckbox",doOnCheck); 
		mygrid.loadXML("crd-1-3.php?IDG=" + valoreslista[i])

	}
</script>