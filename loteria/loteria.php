<div id="obj">

</div>
<div id="gridbox">

</div>
<samp id="idseleccionado" ></samp>
<script>
function clicktoolBar(id){

switch(id){
	case "incluir_":
					 makeResultwin("loteria-1.php?op=1","gridbox");
					break;
	case "modificar_":
	                 makeResultwin("loteria-1.php?op=2&IDlot="+$('idseleccionado').lang,"gridbox");
					break;
	case "Cerrar_":
					dhxWins1.window("w1").close();
					break;				
	
}
	
}
 function doOnRowSelected(id){ 
	    
		$('idseleccionado').lang=id;
		
	    } 
   function doOnCheck(rowId,cellInd,state){
  
	if (state)
	  estado=1;
	else
	  estado=0;
	makeResultwin("chaceStatus.php?SqlStatus=Update _tloteria set Estatus="+estado+" where IDLot="+rowId,"gridbox");
	} 
  	var dhxWins1 = new dhtmlXWindows();
	
    dhxWins1.setImagePath("codebase/imgs/");	
	var w1 = dhxWins1.createWindow("w1",10, 80, 670, 400);
	w1.setText("Loterias");
	w1.attachObject('obj');
	//dhxWins1.setSkin("web");  
	

    var bar = w1.attachToolbar();
	bar.addButton("incluir_", 0, "Incluir", "images/dhtmlxeditor_icon.gif", "images/dhtmlxeditor_icon.gif");
	bar.addSeparator("separator_", 1); 
    bar.addButton("modificar_", 2, "Modificar", "images/sample_close.gif", "images/sample_close.gif"); 
	bar.addSeparator("separator_", 3); 
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.attachEvent("onClick", clicktoolBar);
	
	createByxml('grid.xml','SELECT * FROM _tloteria Order by IDLot','IDLot|NombrePantalla|NombreTicket|CodigoAcceso|Estatus|DATA!imagen');
	mygrid = w1.attachGrid();
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("ID,Loteria,Texto Ticket,Asignacion de Tecla,Status,Logo");
	mygrid.setInitWidths("50,200,150,100,50,100")
	mygrid.setColAlign("right,left,left,center,center,center")
	mygrid.setColTypes("ro,ro,ro,ro,ch,ro");
	//mygrid.setColSorting("int,str,str,int,str,str");
	mygrid.setColumnColor("white,white,white,white,white,white");
    mygrid.setSkin("light");
	mygrid.attachEvent("onRowSelect",doOnRowSelected); 
	 mygrid.attachEvent("onCheckbox",doOnCheck);
	/*mygrid.attachEvent("onEditCell",doOnCellEdit); 
	 mygrid.attachEvent("onEnter",doOnEnter); 
	 mygrid.attachEvent("onCheckbox",doOnCheck);*/
	//////////////////////
	mygrid.init();
	mygrid.loadXML("grid.xml");

    
	
	
    
    
</script>