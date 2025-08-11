<div id="obj">

</div>
<div id="gridbox">

</div>
<div id='frmPremiacion'>
	<div id="premiacion" style="display:none"  >
	</div>
</div>
<div id='frmPremio'>
	<div id="premio" style="display:none"  >
	</div>
</div>
<samp id="idseleccionado" ></samp>
<div id="title_flt_box" style="display:none"><input type="100%"  size="18"style="border:1px solid gray;" onClick="(arguments[0]||window.event).cancelBubble=true;" onKeyUp="filterBy()"></div>

<div id="FromPorcentaje">
	<span id="porcentaje"></span>
</div>

<script>

function clicktoolBar(id){
	switch(id){	
		case "Cerrar_":
					dhxWins1.window("w1").close();
					break;		
	}	
}
 
 function tonclickDeportes(id){
	 uid=id.split('-');
	 if (uid[0]!='k')
	 	GridApuesta(uid);
 }	

function GridApuesta(id){
	
	mygrid = dhxLayout.cells("b").attachGrid();
	mygrid.setImagePath("codebase/imgs/"); 
	mygrid.setHeader("ID,Fecha,Hora ,Motivo,Estado"); 
	mygrid.setInitWidths("25,75,75,170,55");
	mygrid.setColAlign("right,left,left,left,left");
	mygrid.setColTypes("ro,ro,ro,ro,ro"); 
	mygrid.attachHeader(",#connector_select_filter,#connector_select_filter,#connector_select_filter")
	mygrid.setColSorting(",connector,connector,connector")
	mygrid.setColSorting("int,date,date,str,str")
	mygrid.setSkin("light");
	mygrid.init();	
	mygrid.clearAll();
	mygrid.loadXML("xmlAuditoria_Acceso-3.php?IDusu="+id[1]+"&IDM="+id[0]);

}


	dhxWins1 = new dhtmlXWindows();
    dhxWins1.setImagePath("codebase/imgs/");	
	w1 = dhxWins1.createWindow("w1",100, 270, 830, 560);
	w1.setText("Auditoria");
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	dhxWins1.window("w1").denyResize();
	dhxWins1.window("w1").denyMove();
	dhxWins1.window("w1").centerOnScreen();
    var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.attachEvent("onClick", clicktoolBar);
    dhxLayout = new dhtmlXLayoutObject(w1, "2U");
	dhxLayout.cells("a").setText("Usuarios/Bitacora");
	dhxLayout.cells("b").setText("Detalles");	
	
	
	
	createByXMLLogs();
	
	var tree1 = dhxLayout.cells("a").attachTree();
	tree1.setImagePath("media/");
	tree1.enableDragAndDrop(1,0);
	tree1.setOnClickHandler(tonclickDeportes);
	tree1.loadXML("arch/gridRelaCIONAudi.xml");
</script>