<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$fc = date("d/n/Y");
$IDC = $_REQUEST['IDC'];
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

if ($debo < 0) :
	$debo = $debo * -1;
?>

	<div id='fromConcesionario3' align="center" style="background: #FFF; color:#000;width:600px" />
	<form id="from1" name="from1" method="POST" action="crd-1-10.php">
		<table width="815" border="0">
			<tr>
				<td width="144">Letra:</td>
				<td width="661"><? echo $IDC; ?></td>
			</tr>
			<tr>
				<td>Fecha de Deposito:</td>
				<td> <input name="fc" type="text" id="fc" size="10" value="<?php echo $fc; ?>" /></td>
			</tr>
			<tr>
				<td>Deposito:</td>
				<td><label>
						<input name="radio" type="radio" id="radio1" value="radio1" onClick="SeleMonto(1)" checked>
					</label>
					Monto Total Bsf.<? echo number_format($debo, 2, ',', '.'); ?><br>
					<input name="radio" type="radio" id="radio2" value="radio2" onClick="SeleMonto(2)">
					Otro Monto:
					<label>
						<input name="Monto_TOtal" type="text" disabled id="Monto_TOtal" value="<? echo number_format($debo, 2, ',', '.'); ?>" onkeypress="return permiteNew(event,'num',this.id);">
					</label>
				</td>
			</tr>
			<tr>
				<td>Depositado en:</td>
				<td><label>
						<input type="checkbox" name="checkboxE" id="checkboxE" onclick="if($(this.id).checked){ $('iEfectivo').disabled='';  $('iEfectivo').focus(); }else{ $('iEfectivo').disabled='disabled'; $('iEfectivo').value=0; iSumaValores() }">
					</label>
					Efectivo Bsf.
					<input type="text" name="iEfectivo" id="iEfectivo" size="10" maxlength="10" onkeypress="return permiteNew(event,'num',this.id);" onkeyup="iSumaValores()" disabled="disabled">
					<br>
					<input type="checkbox" name="checkboxC" id="checkboxC" onclick="if($(this.id).checked){ $('strCheque').disabled=''; $('iCheque').disabled='';  $('strCheque').focus(); }else{ $('iCheque').disabled='disabled';  $('strCheque').disabled='disabled'; $('iCheque').value=0; $('strCheque').value=''; iSumaValores()}">
					Cheque Bsf.
					<strong>No Cheque:</strong>
					<input type="text" name="strCheque" id="strCheque" size="15" maxlength="15" disabled="disabled">
					por Bsf.:
					<input type="text" name="iCheque" id="iCheque" size="10" maxlength="10" onkeypress="return permiteNew(event,'num',this.id);" onkeyup="iSumaValores()" disabled="disabled">
					<br>
					<input type="checkbox" name="checkboxT" id="checkboxT" onclick="if($(this.id).checked){$('strRecibo').disabled=''; $('strBanco').disabled=''; $('iTransfer').disabled=''; $('strRecibo').focus(); }else{ $('strRecibo').disabled='disabled';  $('strBanco').disabled='disabled'; $('iTransfer').disabled='disabled'; $('strRecibo').value=''; $('strBanco').value=''; $('iTransfer').value=0;iSumaValores()}">
					Transferencia/Deposito <strong>Recibo No.</strong>
					<input type="text" name="strRecibo" id="strRecibo" size="15" maxlength="15" disabled="disabled">
					Banco:
					<input type="text" name="strBanco" id="strBanco" disabled="disabled">
					por Bsf:
					<input type="text" name="iTransfer" id="iTransfer" size="10" maxlength="10" onkeypress="return permiteNew(event,'num',this.id);" onkeyup="iSumaValores()" disabled="disabled">
				</td>
			</tr>
			<tr>
				<td>Total Depositado Bsf.</td>
				<td><span id="iPago" style="font-size:18px">0,00</span></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</form>
	</div>



	<script>
		function mSelectDate(date) {
			$('fc').value = cal1.getFormatedDate('%d/%c/%Y', date);
			return true;
		}


		function clicktoolBar1(id) {
			switch (id) {
				case "Cerrar_":
					dhxWins13.window("w13").close();
					break;
				case "Recbibo_":
					grabar = true;
					if ($('radio1').checked) {
						montototal = <? echo $debo; ?>;
						montosuma = parseFloat($("iPago").innerHTML);
						if (montosuma != montototal) {
							alert('1:El monto en forma de pago no concuerda con el monto total a cancelar');
							grabar = false;
						}
					} else {
						montototal2 = parseFloat($("Monto_TOtal").value);
						montosuma = parseFloat($("iPago").innerHTML);
						if (montosuma != montototal2) {
							alert('2:El monto en forma de pago no concuerda con el monto total a cancelar');
							grabar = false;
						}
					}

					if (grabar) {

						$('from1').request({
							method: 'post',
							parameters: {
								IDC: '<? echo $IDC; ?>',
								pago: $("iPago").innerHTML,
								deudaT: <? echo $debo; ?>
							},
							onComplete: function(transport) {
								var response = transport.responseText.evalJSON(true);

								if (response[0]) {
									nalert('INFORMACION', 'INFORMACION ALMACENADA')

									dhxWinsEME = new dhtmlXWindows();
									dhxWinsEME.setImagePath("../../codebase/imgs/");
									w1k1 = dhxWinsEME.createWindow("w1k1", 20, 30, 320, 240);
									dhxWinsEME.window('w1k1').centerOnScreen();
									w1k1.setText("Recibo de Deposito");
									w1k1.button("close").disable();
									w1k1.attachHTMLString(response[1]);

									dhxWins13.window("w13").close();
								} else
									nalert('ERROR', 'LA INFORMACION NO FUE REGISTRADA, Comuniquese con el Administrador!')

							},
							onFailure: function() {
								alert('No tengo respuesta Comuniquese con el Administrador!');
							}
						});

					}

					//					dhxWins12.window("w12").close();

					break;
				case "Modificar_":
					if (idRow != 0) {
						dhxWins1.window("w1").close();
					} else
						nalert('ERROR', 'DEBE SELECCIONAR PRIMERO EL CONCESIONARIO A MODIFICAR!!');
					break;

					//"ImprimirReporte2('reportedeventashipodromo-2.php');"
			}
		}


		dhxWins13 = new dhtmlXWindows();
		dhxWins13.setImagePath("codebase/imgs/");
		w13 = dhxWins13.createWindow("w13", 600, 355, 780, 500);
		w13.setText('Deposito');
		w13.attachObject('fromConcesionario3');
		dhxWins13.window("w13").button('close').hide();
		dhxWins13.window("w13").button('minmax1').hide();
		dhxWins13.window("w13").button('minmax2').hide();
		dhxWins13.window("w13").button('park').hide();
		dhxWins13.window("w13").denyResize();
		dhxWins13.window("w13").denyMove();
		dhxWins13.window('w13').setModal(true);
		var bar1 = w13.attachToolbar();
		bar1.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
		bar1.addButton("Recbibo_", 1, "Procesar Pago", "images/mensaje.gif", "images/mensaje.gif");
		/*bar.addButton("Modificar_", 1, "Modificar Concesionario", "images/page_setup.gif", "images/page_setup.gif");*/
		bar1.attachEvent("onClick", clicktoolBar1);


		cal1 = new dhtmlxCalendarObject('fc');
		cal1.setOnClickHandler(mSelectDate);
	</script>
<? else : ?>
	<script>
		alert('Este cliente no tiene Premios a Cobrar');
	</script>
<? endif; ?>