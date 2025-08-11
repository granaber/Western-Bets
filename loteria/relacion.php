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

function doOnCheck(rowId,cellInd,state){
	if (state)
	  estado=1;
	else
	  estado=0;
	makeResultwin("chaceStatus.php?SqlStatus=Update _tloteria set Estatus="+estado+" where IDLot="+rowId,"gridbox");
	} 
	
function myDragHandler(idFrom,idTo){
	        desde=idFrom.split('-');
			hasta=idTo.split('-');
			//**// Tipo,ID,relacion,IDrelacion //**//
		    /* alert(idFrom);alert(idTo);
			alert("cambio_relacion.php?Tipo="+desde[0]+"&ID="+desde[1]+"&relacion="+hasta[0]+"&IDrelacion="+hasta[1]);*/
			makeResultwin("cambio_relacion.php?Tipo="+desde[0]+"&ID="+desde[1]+"&relacion="+hasta[0]+"&IDrelacion="+hasta[1],"gridbox");
    
            return true;
            }	

    var dhxWins1 = new dhtmlXWindows();
	
    dhxWins1.setImagePath("codebase/imgs/");	
	var w1 = dhxWins1.createWindow("w1",10, 80, 640, 550);
	w1.setText("Relacion");
	w1.attachObject('obj');
	//dhxWins1.setSkin("web");  
	

    var bar = w1.attachToolbar();
	bar.addSeparator("separator_", 3); 
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.attachEvent("onClick", clicktoolBar);
	
	var dhxLayout = new dhtmlXLayoutObject(w1, "4T");
	dhxLayout.cells("a").setText("Entes Relacionados");dhxLayout.cells("a").setHeight(250);
	dhxLayout.cells("b").setText("Zonas");
	dhxLayout.cells("c").setText("Intermediario"); 
	dhxLayout.cells("d").setText("Agencias");

	
	createByxmlTreePrincipal();
	var tree = dhxLayout.cells("a").attachTree();
	tree.setImagePath("codebase/imgs/csh_vista/");
	tree.openItem("Sistema");
	tree.enableDragAndDrop(1,0);
	tree.setDragHandler(myDragHandler);
	/*tree.setImageArrays("plus","","","","plus.gif");
	tree.setImageArrays("minus","","","","minus.gif");
	tree.setStdImages("banca.ico","banca.ico","banca.ico");*/	
	tree.loadXML("gridRelaCION.xml");
	
	createByxmlTree('gridRelaCION_1.xml','SELECT * FROM _tzona', 'SELECT * FROM _trelacionbanca where Tipo=2 and ID_Relacionado=','IDZ','Descripcion|IDZ',"Zonas",'2');
	var tree1 = dhxLayout.cells("b").attachTree();
	tree1.setImagePath("codebase/imgs/csh_vista/");
	tree1.openItem("Zonas");
	tree1.enableDragAndDrop(1,0);
	tree1.setStdImages("zona.gif","zona.gif","zona.gif");	
	tree1.loadXML("gridRelaCION_1.xml");
	
	createByxmlTree('gridRelaCION_2.xml','SELECT * FROM _tintermediario','SELECT * FROM _trelacionbanca where Tipo=3 and ID_Relacionado=','IDI','Descripcion|IDI',"Intermediario",'3');
	var tree2 = dhxLayout.cells("c").attachTree();
	tree2.setImagePath("codebase/imgs/csh_vista/");
	tree2.openItem("Intermediario");
	tree2.enableDragAndDrop(1,0);
	tree2.setStdImages("intermediario.ico","intermediario.ico","intermediario.ico");	
	tree2.loadXML("gridRelaCION_2.xml");
	
	createByxmlTree('gridRelaCION_3.xml','SELECT * FROM _tagencias','SELECT * FROM _trelacionbanca where Tipo=4 and ID_Relacionado=','IDC','Descripcion|IDC',"Agencia",'4');
	var tree3 = dhxLayout.cells("d").attachTree();
	tree3.setImagePath("codebase/imgs/csh_vista/");
	tree3.openItem("Agencia");
	tree3.enableDragAndDrop(1,0);
	tree3.setStdImages("agencia.gif","agencia.gif","agencia.gif");	
	tree3.loadXML("gridRelaCION_3.xml");
    
    
</script>