<div id="obj">

</div>
<div id="gridbox">

</div>
<samp id="idseleccionado" ></samp>
<script>
function clicktoolBar(id){

switch(id){
	case "incluir_":
					 makeResultwin("listaloteria-1.php?op=1","gridbox");
					break;
	case "modificar_":
	                 makeResultwin("listaloteria-1.php?op=2&Formato="+$('idseleccionado').lang,"gridbox");
					break;
	case "Cerrar_":
					dhxWins1.window("w1").close();
					break;				
	
}
	
}
 function doOnRowSelected(id){ 
	    
		$('idseleccionado').lang=id;
		
	    } 
 
  	var dhxWins1 = new dhtmlXWindows();
	
    dhxWins1.setImagePath("codebase/imgs/");	
	var w1 = dhxWins1.createWindow("w1",10, 80, 610, 200);
	w1.setText("Configuracion de Formatos de Loteria");
	w1.attachObject('obj');
	//dhxWins1.setSkin("web");  
	

    var bar = w1.attachToolbar();
	bar.addButton("incluir_", 0, "Incluir", "images/dhtmlxeditor_icon.gif", "images/dhtmlxeditor_icon.gif");
	bar.addSeparator("separator_", 1); 
    bar.addButton("modificar_", 2, "Modificar", "images/sample_close.gif", "images/sample_close.gif"); 
	bar.addSeparator("separator_", 3); 
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.attachEvent("onClick", clicktoolBar);
	
	createByxml('grid_Floteria.xml','SELECT * FROM _tloteria_formato Order by Formato','Formato|Descripcion|Lista');
	mygrid = w1.attachGrid();
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("ID,Descripcion,Lista");
	mygrid.setInitWidths("50,200,350")
	mygrid.setColAlign("right,left,left")
	mygrid.setColTypes("ro,ro,ro");
	//mygrid.setColSorting("int,str,str,int,str,str");
	mygrid.setColumnColor("white,white,white");
    mygrid.setSkin("light");
	mygrid.attachEvent("onRowSelect",doOnRowSelected); 
	/*mygrid.attachEvent("onEditCell",doOnCellEdit); 
	 mygrid.attachEvent("onEnter",doOnEnter); 
	 mygrid.attachEvent("onCheckbox",doOnCheck);*/
	//////////////////////
	mygrid.init();
	mygrid.loadXML("grid_Floteria.xml");
</script>