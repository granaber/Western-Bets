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
var IDC=-1,IDG=-1;
var Grupo=0;
var Encabezados;
var mygrid,mygrid1;
var deport=0;
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
	}	
}
function Asignacion_Reglas(){
	var noCombina='';
	for (f=0;f<=mygrid.getRowsNum()-1;f++){
		noCombina=noCombina+mygrid.cellByIndex(f,0).getValue()+'*'; 
		for (c=0;c<=Encabezados[4].length-1;c++){
			if (mygrid.cellByIndex(f,(c+3)).getValue()==1)
				noCombina=noCombina+(c+1)+'|';
	  }
	  noCombina=noCombina+'-';
	}
	
	var RestricpoDerecho='';
	
	for (f=0;f<=mygrid1.getRowsNum()-1;f++){
		RestricpoDerecho=RestricpoDerecho+mygrid1.getRowId(f)+'*'+mygrid1.cellByIndex(f,1).getValue()+'|'+mygrid1.cellByIndex(f,2).getValue(); 
	    RestricpoDerecho=RestricpoDerecho+'-';
	}

	
	 new Ajax.Request('procierre.php', {  parameters: { op:32,noCombinar:noCombina,IDC:IDC,IDG:IDG,porDerecho:RestricpoDerecho }, method:'get',asynchronous:false,	
				               onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);	
									if (response)
										nalert('Grabacion',' Asignacion de Reglas con Exito! ');
									else
										nalert('Error',' No se Puede Almacenar la Informacion ');
										
								},	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
								});	
}
function Asignacion(id){
 switch(id){
	 case 'Jugadas_':
			clickNuevaRegla();
			break;
	 case 'Jugadas2_':
			clickNuevaReglaJugadas();
			break;		
 	 case 'Asignar_':
	 		if (IDC!=-1 && IDG!=-1){
				Asignacion_Reglas();					
			}else
				nalert('Error','Debe Indicar a que Elemento (Banca,Grupo,Punto de Venta) va Asignar el Reglamento');
	}

}

	
function tonclick(id){
   
     vernivel=id.split('-');
	 switch (vernivel[0]){
		case '1': 
		  IDC=0;IDG=vernivel[1];dhxLayout.cells("d").setText(' Combinaciones a Bloqueas Para: ( Grupo '+IDG+' '+tree.getItemText(id)+')');
		  break;
		case 'Banca':
		  IDC=0; IDG=0; dhxLayout.cells("d").setText(' Combinaciones a Bloqueas Para la : (BANCA GENERAL)') ;break;
		default:
		  IDC=vernivel[0];IDG=0;dhxLayout.cells("d").setText(' Combinaciones a Bloqueas Para: ( Concesionario '+tree.getItemText(id)+')');
		
	 }
	 if (deport!=0)  GridApuesta(deport);
 }	
 
 function tonclickDeportes(id){
	 deport=id;
	 GridApuesta(id);
 }	
function doOnRowSelected(id,col,status){ 
		col=col-3;
	
		// Cambio Coordenadas;
		idchg=Encabezados[4][col];
		colcng=Encabezados[5][id];
	
		mygrid.cellById(idchg, colcng+3).setValue(status);
		
} 

 var IdSelecJx=0;
 var Texto1Jx='';
 var Texto2Jx='';  
 function doSelectRow(id){ 
        IdSelecJx=id;
		Texto1Jx=mygrid.cellById(id,1).getValue();
		Texto2Jx=mygrid.cellById(id,2).getValue();
	    }  
function GridApuesta(id){
	
	 new Ajax.Request('proce_ajax.php', {  parameters: { op:5,Grupo:id}, method:'get',asynchronous:false,	
				               onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);	
									Encabezados=response;
								},	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
								});	
	mygrid = dhxLayout.cells("d").attachGrid();
	mygrid.setImagePath("codebase/imgs/"); 
	mygrid.setHeader("ID,Jugada,Posicion, "+Encabezados[0]); 
	mygrid.setInitWidths("50,150,150,"+Encabezados[1]);
	mygrid.setColAlign("right,left,left,"+Encabezados[2]);
	mygrid.setColTypes("ro,ro,ro,"+Encabezados[3]); 
	mygrid.setSkin("light");
	mygrid.attachEvent("onCheckbox",doOnRowSelected); 
	mygrid.attachEvent("onRowSelect",doSelectRow); 
	mygrid.init();	
	mygrid.clearAll();
	mygrid.loadXML("reglamentoI-4.php?Grupo="+id+"&IDC="+IDC+"&IDG="+IDG);
	
	
	
	mygrid1 =  dhxLayout.cells("c").attachGrid();
	mygrid1.setImagePath("codebase/imgs/");
	mygrid1.setHeader("Jugada,Monto,Bloqueo");
	mygrid1.setInitWidths("110,80,80")
	mygrid1.setColAlign("left,right,left")
	mygrid1.setColTypes("ro,ed,ch");
	mygrid1.setSkin("dhx_skyblue");
	mygrid1.init();	
	mygrid1.loadXML("reglamentoI-2.php?Grupo="+id+"&IDC="+IDC+"&IDG="+IDG);
	mygrid1.setSizes();
	

}
function clickNuevaRegla(){
	if (deport!=0 && (IDC!=-1 || IDG!=-1) )
		 makeResultwin2("reglamentoI-3.php?Grupo="+deport+"&IDC="+IDC+"&IDG="+IDG,'porcentaje');
	else
		nalert('Error','Debe Indicar a que Elemento (Banca,Grupo,Punto de Venta) va Asignar el Reglamento');
		
	
}

function clickNuevaReglaJugadas(){
	if (deport!=0 && (IDC!=-1 || IDG!=-1))
		 makeResultwin2("reglamentoI-5.php?Grupo="+deport+"&IDC="+IDC+"&IDG="+IDG+'&IDDD='+IdSelecJx,'porcentaje');
	else
		nalert('Error','Debe Indicar a que Elemento (Banca,Grupo,Punto de Venta) va Asignar el Reglamento y Ademas la Apuesta que va asignar el tope');
		
	
}
	dhxWins1 = new dhtmlXWindows();
    dhxWins1.setImagePath("codebase/imgs/");	
	w1 = dhxWins1.createWindow("w1",100, 270, 830, 560);
	w1.setText("Reglamentos");
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	//dhxWins1.window("w1").denyResize();
	//dhxWins1.window("w1").denyMove();
	dhxWins1.window('w1').setModal(true);
	dhxWins1.window("w1").centerOnScreen();
    var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.attachEvent("onClick", clicktoolBar);
    dhxLayout = new dhtmlXLayoutObject(w1, "4U");
	dhxLayout.cells("a").setText("Puntos de Ventas/Grupos");
	dhxLayout.cells("b").setText("Deportes");	
	dhxLayout.cells("c").setText("Restricciones por Derecho"); 
	dhxLayout.cells("d").setText("Combinaciones a Bloquear"); 
	var barGri = dhxLayout.cells("d").attachToolbar();
	barGri.addButton("Asignar_", 1, "Asignar Reglamento", "media/abierto.png", "media/abierto.png"); 
	barGri.addButton("Jugadas_", 2, "Jugadas Minimas/Maximas del DEPORTE", "media/add.png", "media/add.png"); 
	barGri.addButton("Jugadas2_", 3, "Jugadas Minimas/Maximas de la Jugadas", "media/bandera.pnp.png", "media/bandera.pnp.png"); 
	barGri.attachEvent("onClick", Asignacion);
	
	
	
	createByxmlTreePrincipal();
	var tree = dhxLayout.cells("a").attachTree();
	tree.setImagePath("codebase/imgs/csh_vista/");
	tree.enableDragAndDrop(1,0);
	tree.setOnClickHandler(tonclick);
	tree.loadXML("arch/gridRelaCION.xml");
	createByxmlTreeDeportes();
	var tree1 = dhxLayout.cells("b").attachTree();
	tree1.setImagePath("media/");
	tree1.enableDragAndDrop(1,0);
	tree1.setOnClickHandler(tonclickDeportes);
	tree1.loadXML("arch/gridRelaCIONDeport.xml");
</script>