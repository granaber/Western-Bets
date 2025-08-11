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
	<span id="config"></span>
</div>

<script>
var IDC=-1,IDG=-1;
var Encabezados;
var mygrid;
var deport=0;
function clicktoolBar(id,sel){
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
		 case "btnDeporte_":	break;		
		 default:		
					createXMLOdds(id);
					var tree = dhxLayout.cells("a").attachTree();
					tree.setImagePath("media/");
					tree.enableDragAndDrop(1,0);
					tree.setOnClickHandler(tonclick);
					tree.loadXML("arch/chkOdds.xml");		
					Grupo=id;
					$('config').innerHTML='';
					mygrid1.clearAndLoad("chkOdds-4.php?Grupo="+Grupo);
						
					
	}	
}


function tonclick(id){
   
     vernivel=id
	 GridApuesta(id);
 }	

function GridApuesta(id){
	
	 new Ajax.Request('chkOdds-1.php', {  parameters: { Grupo:id,inew:0}, method:'get',asynchronous:false,	
				               onComplete: function(transport){
									var response = transport.responseText;
									$('config').innerHTML=response;
									response.evalScripts();	
									
									
									
								},	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
								});	
	

}
function createXMLOdds_Bar(){
	
	 new Ajax.Request('chkOddsTree-1.php', {  method:'get',asynchronous:false,	
				               onComplete: function(transport){
									var response = transport.responseText;
								},	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
								});	
	

}

 function doSelectRow(id){ 
        IdSelecJx=id;
		
		new Ajax.Request('chkOdds-1.php', {  parameters: { Grupo:0,inew:IdSelecJx}, method:'get',asynchronous:false,	
				               onComplete: function(transport){
									var response = transport.responseText;
									$('config').innerHTML=response;
									response.evalScripts();	
									
									
									
								},	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
								});	
	
	    } 

    Grupo=2;
	dhxWins1 = new dhtmlXWindows();
    dhxWins1.setImagePath("codebase/imgs/");	
	w1 = dhxWins1.createWindow("w1",100, 270, 830, 560);
	w1.setText("Chequeo de Logros");
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	//dhxWins1.window("w1").denyResize();
	//dhxWins1.window("w1").denyMove();
	
	createXMLOdds_Bar()
	
	dhxWins1.window('w1').setModal(true);
	dhxWins1.window("w1").centerOnScreen();
    var bar = w1.attachToolbar();
	bar.loadXML("arch/chkOdds-1.xml?etc=" + new Date().getTime());
	bar.attachEvent("onClick", clicktoolBar);
    dhxLayout = new dhtmlXLayoutObject(w1, "3U");
	dhxLayout.cells("a").setText("Jugadas");
	dhxLayout.cells("b").setText("Configuracion");	dhxLayout.cells("b").attachObject("config"); dhxLayout.cells("b").setWidth(500);
	dhxLayout.cells("c").setText("Listas de Configuraciones"); 
	
	createXMLOdds(Grupo);
	var tree = dhxLayout.cells("a").attachTree();
	tree.setImagePath("media/");
	tree.enableDragAndDrop(1,0);
	tree.setOnClickHandler(tonclick);
	tree.loadXML("arch/chkOdds.xml");
	
	mygrid1 =  dhxLayout.cells("c").attachGrid();
	mygrid1.setImagePath("codebase/imgs/");
	mygrid1.setHeader("Id,Jugada,Opcion,Rango de Logro, Rango de Carrera,Jugada a Comparar,Logro EVE");
	mygrid1.setInitWidths("30,150,50,100,100,150,80")
	mygrid1.setColAlign("left,left,left,left,left,left,left")
	mygrid1.setColTypes("ro,ro,ro,ro,ro,ro,ro");
	mygrid1.setSkin("dhx_skyblue");
	mygrid1.attachEvent("onRowSelect",doSelectRow); 
	mygrid1.init();	
	mygrid1.loadXML("chkOdds-4.php?Grupo="+Grupo);
	mygrid1.setSizes();
</script>