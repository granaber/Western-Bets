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
					if (dhxWins2!=0){
					var isWin = dhxWins2.isWindow("w2");
					if (isWin)	dhxWins2.window("w2").close();					
					var isWin = dhxWins2.isWindow("w3");
					if (isWin)	dhxWins2.window("w3").close();
					}
					break;		
	}	
}
function doOnRowSelected(id){ 
		$('idseleccionado').lang=id;
} 

function doOnCheckPremiacion(rowId,cellInd,state){
	selectRowId=rowId;

	if (cellInd==3)
		PREMIOdeloteria()
	if (cellInd==4)
		Premiaciondeloteria()
	
	} 
function doOnCellEdit(stage,rowId,cellInd,newvalue){ 
        	
		selectRowId=rowId;
		campos= new Array();
		campos[0]='JugadaMaxima';
		campos[1]='DividendoMaximos';
		 if (stage==2 &&  (cellInd==2 || cellInd==3) )
		  return  grabacion(campos[cellInd-2],newvalue,selectRowId,idgeneral)
		 else
		  return true
		 
	} 
	
function tonclick(id){
     vernivel=id.split('-');
	 idgeneral=id;
	if (id[0]!=1)
	 Grid_Cupos();
	else{
	  mygrid.clearAll();
	  $('porcentaje').innerHTML='';
	}
 }	
 
function Grid_Cupos(){
	mygrid = dhxLayout.cells("c").attachGrid();
	mygrid.setImagePath("codebase/imgs/"); 
	mygrid.setHeader("ID,Tipo de Juego, Jugada Maxima,Dividendos Maximos"); 
	mygrid.setInitWidths("50,150,200,200");
	mygrid.setColAlign("right,left,left,left");
	mygrid.setColTypes("ro,ro,ed,ed"); 
	mygrid.setColSorting("int,str,int,int")
	mygrid.setSkin("light");
	mygrid.attachEvent("onCheckbox",doOnCheckPremiacion);
	mygrid.attachEvent("onEditCell",doOnCellEdit); 
	mygrid.init();	
	mygrid.loadXML("cupos-2.php?IdRelacionado="+idgeneral);
	verPorcentajes();
}
function verPorcentajes()
{
	new Ajax.Request('fromPorcentajes.php',{ parameters: { ID:idgeneral},method:'post',onComplete: function(transport){
									var response = transport.responseText;
									$('porcentaje').innerHTML=response;
									response.evalScripts();	
									$('PorcentajeTerminal').focus();
										
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
}

	dhxWins1 = new dhtmlXWindows();
    dhxWins1.setImagePath("codebase/imgs/");	
	w1 = dhxWins1.createWindow("w1",100, 270, 830, 560);
	w1.setText("Cupos/Limites");
	//w1.attachObject('obj');
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
	
	var dhxLayout = new dhtmlXLayoutObject(w1, "3U");
	dhxLayout.cells("a").setText("Entes Relacionados");dhxLayout.cells("a").setHeight(230);dhxLayout.cells("a").setWidth(300);
	dhxLayout.cells("b").setText("Informacion");	dhxLayout.cells("b").attachObject("porcentaje");
	dhxLayout.cells("c").setText("Cupos/Limites");
	
	createByxmlTreePrincipal();
	var tree = dhxLayout.cells("a").attachTree();
	tree.setImagePath("codebase/imgs/csh_vista/");
//	tree.openItem("Sistema");
	tree.enableDragAndDrop(1,0);
	tree.setOnClickHandler(tonclick);
	tree.loadXML("gridRelaCION.xml");
	
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {useCharacterMasking:true});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {useCharacterMasking:true});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {useCharacterMasking:true});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer", {useCharacterMasking:true});
</script>