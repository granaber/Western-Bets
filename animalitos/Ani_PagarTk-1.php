<style type="text/css">
<!--
.Estilo2d1 {color: #000000}
.Estilo3d1 {
	color: #FFFF66;
	font-size:15px;
}
.Estilo5d1 {
	color: #FFFFFF;
	font-size:15px;
}
.Estilo4d1 { color:#FFFFFF; font-size:14px}
-->
</style>





<div id="FromPagar"  style=" height:1000px; background:#069" align="center" >


 <table   width="440" border="0" cellspacing="0" >

        <tr   >
          <th    ></th>
          <th width="80"   ><div align="right" class="Estilo3d1" >Serial:</div></th>
          <th colspan="2"   ><input type="text" id="Serial"  size="20"  onkeypress=' return permitebbDUK(event,"num");'   onkeyup=" pressSpecialNMDUK(event,'se') "/></th>
          <th width="68"   ><div align="right"></div></th>
        </tr>

        <tr   >
          <th    ></th>
          <th   ><div align="right" class="Estilo3d1" >Electronico:</div></th>
          <th width="144"   ><input type="text" id="se"  size="40" onkeyup=" pressSpecialNMDUK(event,'Serial')  /></th>
          <th width="137"   ></th>
        </tr>




      </table>
      <br><br><br>

			<div id="verticket" >
			        <div><samp id="nDatos" lang="-"></samp>
			 <table  height="420" border="0" cellpadding="0" cellspacing="0"  >
			  <tr>
			    <td  rowspan="2"><div align="right" style="margin-top:0px; margin-left:0px">
			      <div class="shadowcontainerx2">         <div class="innerdivx2"><div align="center" style="font-size:14px;color:#000"><strong>Ticket Virtual </strong></div>
			          <table height="320" border="0" cellpadding="0" cellspacing="0">

			            <tr>
			              <td  align="left"><samp id="printer3" ></samp></td>
			            </tr>
			          </table>
			        </div>
			      </div>
			    </div></td>
			  </tr>
			  <tr> </tr>
			</table>
			</div>
			</div>
</div>


<script>

 function clicktoolBar(id){
	switch(id){
		case "Cerrar_":
					dhxWins1.window("w1").close();
					break;
		case "Pagar_":
		 if ($('Serial').value!=''){
			_utxprm=bna('filephp=Ani_PagarTk-2.php|serial='+$('Serial').value+'|se='+$('se').value+'|usu='+$('usu').title,this);
		  new Ajax.Request('animalitos/L!p¡-.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
		  //new Ajax.Request('animalitos/grabar_animalitos.php',{ parameters: {Jugada:Object.toJSON(TicketCloud),IDC:$('con').title,usu:$('usu').title},method:'post',asynchronous:false,	onComplete: function(transport){
		              var response = transport.responseText.evalJSON(true)  ;

		              if (response[0]){
		               $('printer3').innerHTML=response[1];
									 dhxWins1.window("w1").setDimension(400, 850);
								 }
		              else{
		                alert(response[1])
										dhxWins1.window("w1").close();
									}


		              },
		            onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		             });

			}
					 break;
					}
  }
  dhxWins1 = new dhtmlXWindows();
  dhxWins1.setImagePath("codebase/imgs/");
	w1 = dhxWins1.createWindow("w1",450, 40, 400, 150);
	w1.setText('Pagar Ticket' );
	w1.attachObject('FromPagar');
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	dhxWins1.window("w1").denyResize();
	dhxWins1.window("w1").denyMove();
	dhxWins1.window('w1').setModal(true)
  var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "animalitos/icons/noun_1042920_cc.png", "animalitos/icons/noun_1042920_cc.png");
	bar.addButton("Pagar_", 1, "Pagar", "animalitos/icons/noun_903924_cc.png", "animalitos/icons/noun_903924_cc.png");
	bar.attachEvent("onClick", clicktoolBar);
  $('Serial').focus();
</script>
