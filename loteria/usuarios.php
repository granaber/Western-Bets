<div id="obj">

</div>
<div id="gridbox">

</div>
<samp id="idseleccionado" ></samp>
<script>
function clicktoolBar(id){

switch(id){
	case "incluir_":
					 makeResultwin("usuarios-1.php?op=1","gridbox");
					break;
	case "modificar_":
	                 makeResultwin("usuarios-1.php?op=2&IDusu="+$('idseleccionado').lang,"gridbox");
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
	makeResultwin("chaceStatus.php?SqlStatus=Update _tbanca set Estatus="+estado+" where IDB="+rowId,"gridbox");
	} 
  	var dhxWins1 = new dhtmlXWindows();
    dhxWins1.setImagePath("codebase/imgs/");	
	var w1 = dhxWins1.createWindow("w1",10, 80, 300, 600);
	w1.setText("Configuracion de Bancas");
	w1.attachObject('obj');
	//dhxWins1.setSkin("web");  
	

    var bar = w1.attachToolbar();
	bar.addButton("incluir_", 0, "Incluir", "images/dhtmlxeditor_icon.gif", "images/dhtmlxeditor_icon.gif");
	bar.addSeparator("separator_", 1); 
    bar.addButton("modificar_", 2, "Modificar", "images/sample_close.gif", "images/sample_close.gif"); 
	bar.addSeparator("separator_", 3); 
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.attachEvent("onClick", clicktoolBar);
	
	
	

	mygrid = w1.attachGrid();
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("ID,Usuario,Estatus");
	mygrid.setInitWidths("70,100,130")
	mygrid.setColAlign("right,left,left")
	mygrid.setColTypes("ro,ro,ch");
    mygrid.setSkin("dhx_skyblue");
	mygrid.attachEvent("onRowSelect",doOnRowSelected); 
	mygrid.init();
	mygrid.loadXML("usuarios-2.php");
	/*var dp = new dataProcessor("usuarios-2.php");
	dp.init(mygrid);
*/
</script>