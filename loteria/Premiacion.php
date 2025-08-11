
<div id="vista">
<div id="obj">
<div id="Calen1"/></div>
</div></div>
<div id="gridbox" style="display:none">
<table border="0">
  <tr bgcolor="#069">
    <td colspan="3" background="#069"><span id="LoterySelec"  lang="0" style="background:#069; color:#FFF"></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Numero Ganador:</td>
    <td><span id="sprytextfield1">
      <input type="text" id="NumeroGanador" size="8" maxlength="4"  >
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Adicionales:</td>
    <td>  <div id="Adicional" style="width:80px; height:30px;"></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="submit" name="button" id="button" value="Premiacion" onClick="grabacion_Premiacion($('selecFecha').lang)"></td>
    <td>&nbsp;</td>
    <td><label>
      <input type="submit" name="button2" id="button2" value="Borrar">
    </label></td>
  </tr>
</table>
</div>
<samp id="idseleccionado" ></samp>
<samp id="selecFecha" lang="<? echo date('d/n/Y'); ?>"></samp>
<div id="obj_ver"><div id="lista"></div></div>
<div id='nada'></div>
 
<script>
function clicktoolBar(id){

	switch(id){
	
		case "Cerrar_":
					dhxWins1.window("w1").close();
					break;	
		case "Calendario_":
					calendario();
					break;				
					
		
	}
	
}

function calendario()
{
	dhxWins2 = new dhtmlXWindows();
	
    dhxWins2.setImagePath("codebase/imgs/");	
	var w2 = dhxWins2.createWindow("w2",10, 80, 190, 210);
	w2.clearIcon();
	dhxWins2.window("w2").button('close').hide();
	dhxWins2.window("w2").button('minmax1').hide();
	dhxWins2.window("w2").button('minmax2').hide();
	dhxWins2.window("w2").button('park').hide();
    w2.setText("");
	w2.attachObject('obj');
	
	mCal = new dhtmlxCalendarObject('Calen1');
	mCal.attachEvent("onClick", mSelectDate);
	mCal.setSkin("dhx_black");
    mCal.draw();
    
}
function mSelectDate(date)
{
	$('vista').innerHTML='<div id="obj"><div id="Calen1"/></div></div>';
	fecha=mCal.getFormatedDate("%d/%m/%Y", date);
    $('selecFecha').lang=fecha;
	bar.setItemText('TextoFecha', 'Fecha: '+fecha);
	dhxWins2.window("w2").close();
	SelectTabb(dhxTabbar.getActiveTab());
	consultar_Premiacion(fecha);
	 $('NumeroGanador').focus();
}
function doOnCheckLoterias(rowId,cellInd,state){
	if (checkLoteriaByPremio(mygrid.cells2(rowId-1, 2).getValue()) ){
		dhxLayout.cells("b").attachObject("gridbox");
		$("lista").innerHTML = ''; 
		$('LoterySelec').innerHTML="LOTERIA :"+mygrid.cells2(rowId-1, 1).getValue();	
		$('LoterySelec').lang=mygrid.cells2(rowId-1, 2).getValue();	
	
		formato=mygrid.cells2(rowId-1, 4).getValue();
	
		if (formato!=1)
		  cargar_formato_Premacion(formato);
		else{
			if (z!=0)
		    z.clearAll();
			z=0;
		    $('Adicional').innerHTML='';
		  }
	 	 consultar_Premiacion(fecha);
	 	 $('NumeroGanador').focus();
		}
	
	
}

function SelectTabb(pos){

	id=pos.split("");
	
	createByxml_Loteria_Premiacion('gridLoteriaPremiacion.xml',respuesta[id[1]],'DATA!imagen|NombrePantalla|IDLot|NombreTicket|Formato');
	mygrid = dhxTabbar.cells(pos).attachGrid();
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("Loteria,Loteria,ID,NombreTicket,Formato");
	mygrid.setInitWidths("70,450")
	mygrid.setColAlign("right,left")
	mygrid.setColTypes("ro,ro,ro,ro,ro,ro");
	//mygrid.setColumnColor("white,white,white,white");
    mygrid.setSkin("dhx_skyblue");	
	mygrid.enableMultiselect(true);
	mygrid.attachEvent("onRowSelect",doOnCheckLoterias); 
	mygrid.init();
	mygrid.loadXML("gridLoteriaPremiacion.xml");
	
	return true;
}
	fecha="<? echo date('d/n/Y'); ?>";
	window.dhx_globalImgPath = "codebase/imgs/";
    var dhxWins1 = new dhtmlXWindows();
	
    dhxWins1.setImagePath("codebase/imgs/");	
	var w1 = dhxWins1.createWindow("w1",10, 80, 780, 480);
	w1.setText("Premiacion");
	//w1.attachObject('obj');
	//dhxWins1.setSkin("web");  
	
    bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.addSeparator('', 2);
	bar.addText('TextoFecha', 3, 'Fecha:'+fecha);
	bar.addButton("Calendario_", 4, "", "images/dhtmlxcalendar_icon.gif", "images/dhtmlxcalendar_icon.gif"); 
	bar.attachEvent("onClick", clicktoolBar);
	//bar.disableItem(3);
	
	
		
	
/*	var dhxCalendarData = {
       				 parent: 'Calen1',
        			isAutoDraw: false
    				};
    mCal = new dhtmlxCalendarObject(dhxCalendarData);*/
	
	
	dhxLayout = new dhtmlXLayoutObject(w1, "3U");
	dhxLayout.cells("a").setText("Loterias Activas");dhxLayout.cells("a").setHeight(320);dhxLayout.cells("a").setWidth(500);dhxLayout.cells("a").fixSize(true,true);
	dhxLayout.cells("b").setText("Premacion");
	dhxLayout.cells("c").setText("Procesos");dhxLayout.cells("c").attachObject("obj_ver");
	 dhxLayout.hideToolbar();
	
	// Grid de Loterias //
	/**/

  var respuesta;
  var dhxTabbar = dhxLayout.cells("a").attachTabbar();
  dhxTabbar.setSkin("default");
  dhxTabbar.setImagePath("codebase/imgs/");
  new Ajax.Request('operaLotery.php',{ parameters: { op:5 },method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);	
									for (ii=0;ii<=response.length-1;ii++){
									 dhxTabbar.addTab("a"+ii,"<img src='images/logo/"+response[ii]+"'  width='59' height='20'  />","80px");
									}
									respuesta=response;
								},
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
  
  
 
createByxml_Loteria_Premiacion('gridLoteriaPremiacion.xml',respuesta[0],'DATA!imagen|NombrePantalla|IDLot|NombreTicket|Formato');
	mygrid = dhxTabbar.cells("a0").attachGrid();
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("Loteria,Loteria,ID,NombreTicket,Formato");
	mygrid.setInitWidths("70,450")
	mygrid.setColAlign("right,left")
	mygrid.setColTypes("ro,ro,ro,ro,ro,ro");
	//mygrid.setColumnColor("white,white,white,white");
    mygrid.setSkin("dhx_skyblue");	
	mygrid.enableMultiselect(true);
	mygrid.attachEvent("onRowSelect",doOnCheckLoterias); 
	mygrid.init();
	mygrid.loadXML("gridLoteriaPremiacion.xml");
	
	dhxTabbar.setTabActive("a0"); dhxTabbar.attachEvent("onSelect",SelectTabb);
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {useCharacterMasking:true});

</script>
