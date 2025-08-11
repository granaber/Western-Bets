
<div id="obj">

</div>
<div id="iRelacion">

</div>

<div id="dhtmlxCalendar"></div>
<script>
function clicktoolBar(id){
	switch(id){	
		case "Cerrar_":
					dhxWins1.window("w1").close();
					if (dhxWins2!=0){
					var isWin = dhxWins2.isWindow("w2");
					if (isWin)	dhxWins2.window("w2").close();					
					var isWin = dhxWins2.isWindow("w3");
					if (isWin)	dhxWins2.window("w3").close();
					}
					break;		
		case "Agregar_":
				 new Ajax.Request('bloque1-1.php',{  parameters: { IDBlq:0},	method:'get',asynchronous:false,	
				               onComplete: function(transport){
									var response = transport.responseText ;	
									$('iRelacion').innerHTML=response;
									response.evalScripts();	
								},	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
								});	
					break;			
		case "Eliminar_":
		    if ( $('idBlq').value!=0)
			  if (confirm('Desea Eliminar este Registro!'))
				 new Ajax.Request('bloque1-3.php',{  parameters: { idBlq:($('idBlq').value*-1)},	method:'get',asynchronous:false,	
				               onComplete: function(transport){
										var response = transport.responseText.evalJSON(true);
										
										if (response){
												$('iRelacion').innerHTML='';
												alert('Registro Eliminado!');	
												mygrid.clearAll();
											    mygrid.loadXML("bloque2.php");			
										}else
												alert('Este Registro no se pudo eliminar!');	
								},	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
								});	
					break;			
	}	
}
function doSelectVerticketAdmin(id){
	

 new Ajax.Request('bloque1-1.php',{  parameters: { IDBlq:id},	method:'get',asynchronous:false,	
				               onComplete: function(transport){
									var response = transport.responseText ;	
									$('iRelacion').innerHTML=response;
									response.evalScripts();	
								},	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
								});	
}

    var dhxWins1 = new dhtmlXWindows();
    dhxWins1.setImagePath("codebase/imgs/");	
	var w1 = dhxWins1.createWindow("w1",10, 80, 860, 560);
	w1.setText("Bloqueo");
	w1.attachObject('obj');
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	dhxWins1.window("w1").denyResize();
	dhxWins1.window("w1").denyMove();
	
    var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.addButton("Agregar_", 2, "Agregar", "images/dhtmlxajax_icon.gif", "images/dhtmlxajax_icon.gif"); 
	bar.addButton("Eliminar_", 4, "Eliminar", "images/cut.gif", "images/cut.gif"); 
	bar.attachEvent("onClick", clicktoolBar);
	
	var dhxLayout = new dhtmlXLayoutObject(w1, "3U");
	dhxLayout.cells("a").setText("Fecha");dhxLayout.cells("a").setHeight(230);dhxLayout.cells("a").setWidth(180);
	dhxLayout.cells("b").setText("Relacion");	
	dhxLayout.cells("c").setText("Bloqueo");
	dhxLayout.cells("b").attachObject("iRelacion");
	
	dhxLayout.cells("a").attachObject("dhtmlxCalendar");
	
	mCal = new dhtmlxCalendarObject('dhtmlxCalendar', false, {
        isYearEditable: true
    });
    mCal.setYearsRange(2000, 2500);
	mCal.setSkin("dhx_black");
    mCal.draw();
	
	mygrid = dhxLayout.cells("c").attachGrid();
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("ID,Fecha,Aplica A,Numero,Loteria,Adicional,Monto,Bloqueado");
	mygrid.setInitWidths("10,80,150,90,150,150,80,80")
	mygrid.setColAlign("right,left,left,left,left,left,left,left")
	mygrid.setColTypes("dyn,ro,ro,ro,ro,ro,ro,ro");
	mygrid.attachHeader(",#connector_text_filter,#connector_select_filter,#connector_text_filter");
    mygrid.setSkin("light");
    mygrid.attachEvent("onRowSelect",doSelectVerticketAdmin);
	mygrid.loadXML("bloque2.php");
	mygrid.init();
	
</script>