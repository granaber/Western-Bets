<div id="obj">

</div>
<div id="gridbox">

</div>
<samp id="idseleccionado" ></samp>
<script>
function clicktoolBar(id){

switch(id){
	case "incluir_":
					 makeResultwin("intermediario-1.php?op=1","gridbox");
					break;
	case "modificar_":
	                 makeResultwin("intermediario-1.php?op=2&IDI="+$('idseleccionado').lang,"gridbox");
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
	makeResultwin("chaceStatus.php?SqlStatus=Update _tintermediario set Estatus="+estado+" where IDI="+rowId,"gridbox");
	} 
  	var dhxWins1 = new dhtmlXWindows();
	
    dhxWins1.setImagePath("codebase/imgs/");	
	var w1 = dhxWins1.createWindow("w1",10, 80, 610, 200);
	w1.setText("Configuracion de Intermediario");
	w1.attachObject('obj');
	//dhxWins1.setSkin("web");  
	

    var bar = w1.attachToolbar();
	bar.addButton("incluir_", 0, "Incluir", "images/dhtmlxeditor_icon.gif", "images/dhtmlxeditor_icon.gif");
	bar.addSeparator("separator_", 1); 
    bar.addButton("modificar_", 2, "Modificar", "images/sample_close.gif", "images/sample_close.gif"); 
	bar.addSeparator("separator_", 3); 
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.attachEvent("onClick", clicktoolBar);
	
	createByxml('grid_Inter.xml','SELECT * FROM _tintermediario Order by IDI','IDI|Descripcion|Responsable|Telefono|Estatus');
	mygrid = w1.attachGrid();
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("ID,Descripcion,Responsable,Telefono,Status");
	mygrid.setInitWidths("50,200,150,100,100")
	mygrid.setColAlign("right,left,left,left,center")
	mygrid.setColTypes("ro,ro,ro,ro,ch");
	//mygrid.setColSorting("int,str,str,int,str,str");
	mygrid.setColumnColor("white,white,white,white,white");
    mygrid.setSkin("light");
	mygrid.attachEvent("onRowSelect",doOnRowSelected); 
	 mygrid.attachEvent("onCheckbox",doOnCheck);
	/*mygrid.attachEvent("onEditCell",doOnCellEdit); 
	 mygrid.attachEvent("onEnter",doOnEnter); 
	 mygrid.attachEvent("onCheckbox",doOnCheck);*/
	//////////////////////
	mygrid.init();
	mygrid.loadXML("grid_Inter.xml");
</script>