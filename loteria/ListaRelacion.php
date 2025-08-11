<div id='obj2'>
</div>
<script>

function clicktoolBar(id){

switch(id){

	case "Cerrar_":
					dhxWins1.window("w1").close();
					break;	
					
	case "Seleccion_":
					$('iAplicar').value=valorS;	$('iAplicar').lang=ivalorS;
					dhxWins1.window("w1").close();
					break;					
	
}
	
}


function tonclick(id) {
    valorS=tree.getItemText(id);
	ivalorS=id;
}


   var dhxWins1 = new dhtmlXWindows();
	
    dhxWins1.setImagePath("codebase/imgs/");	
	var w1 = dhxWins1.createWindow("w1",100, 150, 540, 450);
	w1.setText("Aplicar A");
	dhxWins1.window('w1').setModal(true);
//	w1.attachObject('obj2');
	//dhxWins1.setSkin("web");  
	

    var bar = w1.attachToolbar();
	bar.addSeparator("separator_", 3); 
	bar.addButton("Cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.addButton("Seleccion_", 4, "Seleccionar", "images/select_all.gif", "images/select_all.gif"); 
	bar.attachEvent("onClick", clicktoolBar);
	
	
	
	createByxmlTreePrincipal();
	var tree = w1.attachTree();
	tree.setImagePath("codebase/imgs/csh_vista/");
	tree.openItem("Sistema");
	tree.setOnClickHandler(tonclick);
	/*tree.setImageArrays("plus","","","","plus.gif");
	tree.setImageArrays("minus","","","","minus.gif");
	tree.setStdImages("banca.ico","banca.ico","banca.ico");*/	
	tree.loadXML("gridRelaCION.xml");

</script>