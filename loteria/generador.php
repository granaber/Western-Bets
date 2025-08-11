<div id="obj">

</div>
<div id="gridbox">

</div>
<samp id="idseleccionado" ></samp>
<script>
function clicktoolBar(id){
	fila=parseInt($('idseleccionado').lang);


switch(id){
	case "eliminar_":
	           /* if (
				if (mygrid.cellById(fila, 4).getValue()==1){
					
				}else{
					alert('Lo siento pero no puedo eliminar este Registro !');	
				}*/
				FrmClaveEspecial();
					break;
	case "generar_":	
	             if (mygrid.cellById(fila, 3).getValue()==''){
					  gen_generador(fila,2)
				}else{
					
					  	alert('Lo siento pero no puedo Generar El Codigo de este Registro !');	
				}
					break;
	case "Cerrar_":
					dhxWins1.window("w1").close();
					break;				
	
}
	
}
 function doOnRowSelected(rowId){ 
	    
		$('idseleccionado').lang=rowId;
		
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
	var w1 = dhxWins1.createWindow("w1",10, 80, 460, 600);
	w1.setText("Configuracion Instalador");
	w1.attachObject('obj');
	//dhxWins1.setSkin("web");  
	

    var bar = w1.attachToolbar();
	bar.addButton("eliminar_", 0, "Eliminar", "images/sample_close.gif", "images/sample_close.gif");
	bar.addSeparator("separator_", 1); 
    bar.addButton("generar_", 2, "Generar", "images/leaf_new.gif", "images/leaf_new.gif"); 
	bar.addSeparator("separator_", 3); 
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.attachEvent("onClick", clicktoolBar);
	
	
	

	mygrid = w1.attachGrid();
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("ID,Usuario,Serial de Confirmacion, Serial de Instalacion,Bloqueado");
	mygrid.setInitWidths("70,100,130,130")
	mygrid.setColAlign("right,left,left,left")
	mygrid.setColTypes("ro,ro,ro,ro,ch");
    mygrid.setSkin("dhx_skyblue");
	mygrid.attachEvent("onRowSelect",doOnRowSelected); 
	mygrid.init();
	mygrid.loadXML("generador-1.php");
	/*var dp = new dataProcessor("usuarios-2.php");
	dp.init(mygrid);
*/
</script>