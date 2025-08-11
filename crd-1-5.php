<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

if (isset($_REQUEST['punto'])) :
	$idt = $_REQUEST['idt'];
	$resultCONFI = mysqli_query($GLOBALS['link'], "Select * from _tusu  where IDusu=$idt");
	$rowgrupo = mysqli_fetch_array($resultCONFI);
	$IDC = $rowgrupo['Asociado'];

else :
	$IDC = $_REQUEST['IDC'];
endif;

cRdCredito($IDC);
cRdCreditoAnt($IDC);
$resultCONFI = mysqli_query($GLOBALS['link'], "Select * from _tconsecionario  where IDC='$IDC'");
$rowgrupo = mysqli_fetch_array($resultCONFI);

$credito = 0;
$saldo   = 0;
$fechapago = '';
$debo    = $credito - $saldo;
$creditohoy = 0;
$resultCONFI2 = mysqli_query($GLOBALS['link'], "Select * from _tbcrdcredito  where IDC='$IDC'");
if (mysqli_num_rows($resultCONFI2) != 0) :
	$rowgrupo2 = mysqli_fetch_array($resultCONFI2);
	$credito = $rowgrupo2['credito'];
	$saldo   = $rowgrupo2['saldo'];
	$fechapago = '';
	$debo    = $credito - $saldo;
	$creditohoy = $rowgrupo2['CreditoDiario'];
endif;
?>


<div id='fromConcesionario2' align="center" style="background: #FFF; color:#000;width:600px" />

<table width="200" border="0">
	<tr>
		<td height="100">

			<table width="787" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="249" height="27"><span style="color:#006; font-size:15px">Letra:</span>:<span style="color:#000;font-size:14px"><? echo $IDC . '-' . $rowgrupo['Nombre']; ?></span></td>

					<td width="269"><span style="color:#006; font-size:15px">Grupo:</span>:<span style="color:#000;font-size:14px"><? echo $rowgrupo['IDG']; ?></span></td>
					<td width="269">&nbsp;</td>
				</tr>
				<tr>
					<td height="29"><span style="color:#006; font-size:15px">Telf:</span><? echo $Telefono; ?></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr bgcolor="#999999">
					<td height="23"><span style="color:#006; font-size:15px">Credito</span>:<span style="color:#FFF;font-size:14px"><? echo number_format($credito, 2, ',', '.'); ?></span></td>
					<td><span style="color:#006; font-size:15px">Ultima Fecha de Pago:</span><span style="color:#FFF;font-size:14px"><? echo $fechapago; ?></span></td>
					<td>&nbsp;</td>
				</tr>
				<tr bgcolor="#999999">
					<td height="19"><span style="color:#006; font-size:15px">Saldo :</span><span style="color:#FFF;font-size:14px"><? echo number_format($saldo, 2, ',', '.'); ?></span></td>
					<td><span style="color:#006; font-size:15px">Credito Disponible:</span><span style="color:#FFF;font-size:14px"><? echo number_format($creditohoy, 2, ',', '.'); ?></span></td>
					<td>&nbsp;</td>
				</tr>
				<tr bgcolor="#999999">
					<td height="28"><span style="color:#006; font-size:15px">Debe :</span><span style="color:#FFF;font-size:14px"><? echo number_format($debo, 2, ',', '.'); ?></span></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>





		</td>
	</tr>
	<tr valign="top">
		<td>
			<div id="a_tabbar2" align="center" style="width:643px; height:300px;" />
			</div>
		</td>
	</tr>
</table>


</div>
<div id="tablemenuN1"></div>
<script>
	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				dhxWins12.window("w12").close();
				break;
			case "Pago_":
				makeResultwin('crd-1-7.php?IDC=<? echo $IDC; ?>', 'tablemenuN1');

				break;
			case "Deposito_":
				makeResultwin('crd-1-9.php?IDC=<? echo $IDC; ?>', 'tablemenuN1');

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

	dhxWins12 = new dhtmlXWindows();
	dhxWins12.setImagePath("codebase/imgs/");
	<? if (isset($_REQUEST['punto'])) : ?>
		w12 = dhxWins12.createWindow("w12", 400, 150, 670, 500);
	<? else : ?>
		w12 = dhxWins12.createWindow("w12", 400, 455, 670, 500);
	<? endif; ?>

	w12.setText('Movimientos');
	w12.attachObject('fromConcesionario2');
	dhxWins12.window("w12").button('close').hide();
	dhxWins12.window("w12").button('minmax1').hide();
	dhxWins12.window("w12").button('minmax2').hide();
	dhxWins12.window("w12").button('park').hide();
	dhxWins12.window("w12").denyResize();
	dhxWins12.window("w12").denyMove();
	dhxWins12.window('w12').setModal(true);
	var bar = w12.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
	<? if (!isset($_REQUEST['punto'])) : ?>
		bar.addButton("Pago_", 1, "Agregar Pago", "media/add.png", "media/add.png");
		bar.addButton("Deposito_", 1, "Deposito", "images/page_setup.gif", "images/page_setup.gif");
	<? endif; ?>
	bar.attachEvent("onClick", clicktoolBar);


	mygrid2 = new dhtmlXGridObject("a_tabbar2");
	mygrid2.setImagePath("codebase/imgs/");
	mygrid2.setHeader("Trans ,Fecha,Descripcion,Tipo,Monto,Saldo");
	mygrid2.setInitWidths("1,110,110,50,110,110")
	mygrid2.setColAlign("right,left,left,right,right,right")
	mygrid2.setColTypes("ro,ro,ed,ro,ro,ro");
	mygrid2.setColSorting("int")
	mygrid2.setSkin("dhx_skyblue")
	mygrid2.init();
	//	mygrid.attachEvent("onCheckbox",doOnCheck);
	mygrid2.loadXML("crd-1-6.php?IDC=<? echo $IDC; ?>")

	new Ajax.Request('crd-1-6-1.php?IDC=<? echo $IDC; ?>', {
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
</script>