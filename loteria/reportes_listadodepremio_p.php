<div id="vista">
	<div id="obj2">
		<div id="Calen1"/></div>
	</div>
</div>
<div id="gridbox">

</div>
<samp id="idseleccionado" ></samp>

<script>

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
	w2.attachObject('obj2');	
	mCal = new dhtmlxCalendarObject('Calen1');
	mCal.attachEvent("onClick", mSelectDate);
	mCal.setSkin("dhx_black");
    mCal.draw();
}

function mSelectDate(date)
{
	$('vista').innerHTML='<div id="obj2"><div id="Calen1"/></div></div>';
	fecha=mCal.getFormatedDate("%d/%m/%Y", date);
    setCookie('FechaCookie',fecha);
	bar.setItemText('TextoFecha', 'Fecha: '+fecha);
	dhxWins2.window("w2").close();
	mygrid.clearAll();
	mygrid.loadXML("verticketsAdmon.php?Fecha="+fecha);
	mygrid2.clearAll();	
	mygrid2.loadXML("verticketsPremiadoAdmon.php?Fecha="+fecha);
}
function clicktoolBar(id){
switch(id){
	case "Cerrar_":
					$('showprint').innerHTML='<div id="printerver" style="width: 100%; height: 100%; overflow: auto;display: none; font-family: Tahoma; font-size: 11px;">    <div id="printerver_2" style="margin: 3px 5px 3px 5px;"></div></div>';
					dhxWins1.window("w1").close();
					break;		
	case "Calendario_":
					calendario();
					break;	
	case "Eliminar_":
					EliminarTicketAdmin(serialSeleccion);					
					break;	
	
}
	
}

function EliminarTicketAdmin(_serial){
	if (confirm("Desea ELIMINAR el ticket No."+_serial+"?")){
		new Ajax.Request('vertickets-1.php',{ parameters: {op:2, serial:_serial,idjActual:$('IDJ').lang},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									if (response) {
											alert('El Ticket Anulado!');
											mygrid.clearAll();
											mygrid.loadXML("verticketsAdmon.php?Fecha="+fecha);

										}
									else
										alert('El Ticket no se pudo Anular');
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	}
		
}
function doSelectVerticketAdmin(rowId){ 
		serialSelect=mygrid.cellById(rowId, 0).getValue()
		if (serialSelect<0) serialSelect=serialSelect*-1;
		AmarTicket(serialSelect);
		dhxLayout.cells("b").attachObject("printerver");
		serialSeleccion=serialSelect;		
	    } 
function doSelectVerticketPremiadosAdmin(rowId){ 
		serialSelect=mygrid2.cellById(rowId, 0).getValue()
		if (serialSelect<0) serialSelect=serialSelect*-1;
		AmarTicketPREMIADO(serialSelect);
		dhxLayout.cells("b").attachObject("printerver");
		serialSeleccion=serialSelect;
	    }		
	
	fecha="<? echo date('d/n/Y'); ?>";   setCookie('FechaCookie',fecha);
  	var dhxWins1 = new dhtmlXWindows();
	
    dhxWins1.setImagePath("codebase/imgs/");	
	var w1 = dhxWins1.createWindow("w1",10, 80, 800, 600);
	w1.setText("Listado de Premio");

	
    var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 5, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.addButton("Eliminar_", 1, "Eliminar Ticket", "images/sample_close.gif", "images/sample_close.gif"); 
	bar.addSeparator('', 2);
	bar.addText('TextoFecha', 3, 'Fecha:'+fecha);
	bar.addButton("Calendario_", 4, "", "images/dhtmlxcalendar_icon.gif", "images/dhtmlxcalendar_icon.gif");
	bar.addSeparator('', 6);

	bar.attachEvent("onClick", clicktoolBar);
	
	dhxLayout = new dhtmlXLayoutObject(w1, "2U");
	dhxLayout.cells("a").setText("Lista de Premios");dhxLayout.cells("a").setWidth(500);
	dhxLayout.cells("a").fixSize(true,true);
	dhxLayout.cells("b").setText("Detalle del Ticket");
	dhxLayout.hideToolbar();
	
	var dhxTabbar = dhxLayout.cells("a").attachTabbar();
    dhxTabbar.setSkin("default");
    dhxTabbar.setImagePath("codebase/imgs/");
	dhxTabbar.addTab("a1","Ticket Impresos","180px");
	dhxTabbar.addTab("a2","Ticket Premiados","180px");
	dhxTabbar.setTabActive("a1");
	
	
	mygrid = dhxTabbar.cells("a1").attachGrid();
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("Serial,Agencia,Fecha,Hora,Monto");
	mygrid.setInitWidths("70,100,80,90,100")
	mygrid.setColAlign("right,left,left,right,right")
	mygrid.setColTypes("dyn,ro,ro,ro,ro,ro");
	mygrid.attachHeader("#connector_text_filter,#connector_select_filter");
	mygrid.setColSorting("conector,conector");
			
	//mygrid.setColSorting("int,str,str,str,int");
	//mygrid.setColumnColor("white,white,white,white,white");
   mygrid.setSkin("light");
	/*mygrid.attachEvent("onRowSelect",doOnRowSelected); 
	mygrid.attachEvent("onCheckbox",doOnCheck);
	mygrid.attachEvent("onEditCell",doOnCellEdit); 
	 mygrid.attachEvent("onEnter",doOnEnter); 
	 mygrid.attachEvent("onCheckbox",doOnCheck);*/
	//////////////////////
	//dhtmlxOptionsConnector filterConnector = new dhtmlxOptionsConnector("Country", "ISO", connector.Request.Adapter);
	mygrid.attachEvent("onRowSelect",doSelectVerticketAdmin);
	//
	mygrid.loadXML("verticketsAdmon.php?Fecha="+fecha);
	mygrid.init();
	/*  var dp = new dataProcessor("verticketsAdmon.php");
      dp.init(mygrid);*/

	mygrid2 = dhxTabbar.cells("a2").attachGrid();
	mygrid2.setImagePath("codebase/imgs/");
	mygrid2.setHeader("Serial,Agencia,Fecha,Hora,Monto,Premio");
	mygrid2.setInitWidths("70,100,80,76,80,80")
	mygrid2.setColAlign("right,left,left,right,right,right")
	mygrid2.setColTypes("dyn,ro,ro,ro,ro,ro");
	mygrid2.attachHeader("#connector_text_filter,#connector_select_filter");
	mygrid2.setColSorting("conector,conector");
    mygrid2.setSkin("light");
	mygrid2.attachEvent("onRowSelect",doSelectVerticketPremiadosAdmin); 
	mygrid2.init();	
	mygrid2.loadXML("verticketsPremiadoAdmon.php?Fecha="+fecha);
	
	

</script>