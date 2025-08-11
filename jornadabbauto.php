<?
$grupo=$_REQUEST['grupo'];
$idj=$_REQUEST['idj'];
$idb=$_REQUEST['idb'];
?>
<div id="fromauto"></div><div id="gridbox1"></div>
<script>

 function clicktoolBar(id){
	switch(id){	
		case "Cerrar_":
		            var lis=new Array();
					j=0;
					var cn=mygridauto.getRowsNum();
				
					for(i=0;i<=cn-1;i++)
						if (mygridauto.cells2(i,0).getValue()==1) { lis[j]=	mygridauto.cells2(i,3).getValue(); j++; }
					
					makeResultwin("chaceStatus.php?SqlStatus=Update _agendaNT set IDDDs='"+lis.join(',')+"' where Grupo=<? echo $grupo; ?> and idj=<? echo $idj; ?> and idb=<? echo $idb; ?>","gridbox1");
					dhxWinsauto.window("wauto").close();
					break;	
		
					
					//"ImprimirReporte2('reportedeventashipodromo-2.php');"
	}	
  }
  function doOnCheck(rowId,cellInd,state){
	if (state)
	  estado=1;
	else
	  estado=0;
	//makeResultwin("chaceStatus.php?SqlStatus=Update _tusu set Estatus="+estado+" where IDusu="+rowId,"gridbox");
  }  
  
 function doOnRowSelected(id){ 
		idRow=id;
	    }  
	dhxWinsauto = new dhtmlXWindows();
    dhxWinsauto.setImagePath("codebase/imgs/");	
	wauto = dhxWinsauto.createWindow("wauto",250, 255, 320, 420);
	wauto.setText('Seleccion de logros automaticos');
	wauto.attachObject('fromauto');
	dhxWinsauto.window("wauto").button('close').hide();
	dhxWinsauto.window("wauto").button('park').hide();
	dhxWinsauto.window('wauto').setModal(true);
	

    var barauto = wauto.attachToolbar();
	barauto.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
	barauto.attachEvent("onClick", clicktoolBar);
					
	barauto=new dhtmlXTabBar("tabbar","top");	
	barauto.setStyle("dhx_skyblue");
    barauto.setImagePath("codebase/imgs/");
	barauto.enableAutoReSize(true);
	
	mygridauto = wauto.attachGrid();
	mygridauto.setImagePath("codebase/imgs/");
	mygridauto.setHeader("Auto,Apuesta,Ubicacion,d1");
	mygridauto.setInitWidths("55,150,150")
	mygridauto.setColAlign("right,left,left")
	mygridauto.setColTypes("ch,ro,ro,ro");
	
	mygridauto.setColumnColor("white,white,white");
    mygridauto.setSkin("dhx_skyblue");
	mygridauto.attachEvent("onRowSelect",doOnRowSelected); 
	mygridauto.attachEvent("onCheckbox",doOnCheck);
	
	mygridauto.loadXML("jornadabbauto-1.php?Grupo=<? echo $grupo; ?>&idj=<? echo $idj; ?>&idb=<? echo $idb; ?>");
	mygridauto.init();
</script>