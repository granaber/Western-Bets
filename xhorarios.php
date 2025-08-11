<div id="obj">

</div>
<div id="gridbox">

</div>
<samp id="idseleccionado" ></samp>
<script>
function clicktoolBar(id){
	switch(id){
		case "Cerrar_":
					 dhxWins1.window("w1").close();
					break;				
	}	
}
 function doOnRowSelected(id){ 
	    
		$('idseleccionado').lang=id;
		
	    } 
   function doOnCellEdit(stage,rowId,cellInd,newvalue){
  
	if (cellInd==2)
	  campo='HoradeVenta';
	else
	    campo='HoradeCierre';
	makeResultwin("chaceStatus.php?SqlStatus=Update _thorariodeventas set "+campo+"='"+newvalue+"' where Dia="+rowId,"gridbox");
	return true;
	} 
  	var dhxWins1 = new dhtmlXWindows();
	
    dhxWins1.setImagePath("codebase/imgs/");	
	var w1 = dhxWins1.createWindow("w1",10, 80, 540, 210);
	w1.setText("Configuracion de Horarios");
	w1.attachObject('obj');
	dhxWins1.window("w1").setModal(true);
	w1.centerOnScreen();
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 1, "Cerrar","images/close.gif", "images/close.gif"); 
	bar.attachEvent("onClick", clicktoolBar);

    
	
	createByxml('arch/grid_horarios.xml','SELECT * FROM _thorariodeventas Order by Dia','Dia|DiaTexto|HoradeVenta|HoradeCierre');
	mygrid = w1.attachGrid();
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("ID,Dia,Hora de Apertura,Hora de Cierre");
	mygrid.setInitWidths("50,200,150,100")
	mygrid.setColAlign("right,left,left,center")
	mygrid.setColTypes("ro,ro,ed,ed");
	//mygrid.setColSorting("int,str,str,int,str,str");
	mygrid.setColumnColor("white,white,white,white");
    	mygrid.setSkin("dhx_skyblue");
	mygrid.attachEvent("onRowSelect",doOnRowSelected); 
	mygrid.attachEvent("onEditCell",doOnCellEdit); 
	
	/*mygrid.attachEvent("onEditCell",doOnCellEdit); 
	 mygrid.attachEvent("onEnter",doOnEnter); 
	 mygrid.attachEvent("onCheckbox",doOnCheck);*/
	//////////////////////
	mygrid.init();
	mygrid.loadXML("arch/grid_horarios.xml");
</script>