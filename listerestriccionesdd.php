
<div id="box5" style="background:#033">
<br />
<div align="center"><span  style="color:#FC0; font-size:16px">** Restriccion por Grupo DEPORTES **</span></div>
<br />

<div  id="gridbox" width="520px" height="150px" style="float:left "></div>
<div   style="background: #4B79A7;float: none;  height:150px ">
<img src="media/estrella.png" width="16" height="16" /><span style="color:#FFF; font-size:12px">
<strong>PARA MODIFICAR EL CUPO MAXIMO</strong><br /><br />

<span style="color:#FC0">- Dar un click al CUPO a MODIFCAR.</span><br />
<span style="color:#FC0">- F2 para Editar y Modicar.</span><br />
<span style="color:#FC0">- ENTER Para Aceptar el Monto.</span><br />
<span style="color:#FC0">- ESC   Para Cancelar el Cambio.</span><br />
</div>

</div>



<script>
var idseleccionado=0
    function doOnRowSelected(id){ 
	    idseleccionado=id;
	
	    } 
	function doOnCellEdit(stage,rowId,cellInd,newvalue){ 
		
		 if (stage==2){
		
		  return grabarBycupoBygrupodd(rowId,cellInd,newvalue);
			
		 }
		  
		  
		  
		} 
//	function doOnEnter(rowId,cellInd){ 
//		alert('Aqui');
//	
//		} 

  
	
createByxml('grid.xml','select _tgrupo.*,_trestricionesbb.MxD,_trestricionesbb.MxP from _tgrupo,_trestricionesbb where  _tgrupo.IDG=_trestricionesbb.IDG Order by _tgrupo.IDG','IDG|Descrip|Responsable|MxD|MxP');
	mygrid = new dhtmlXGridObject('gridbox');
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("No Grupo,Nombre del Grupo,Responsable,Cupo Derecho,Cupo Parlay");
	mygrid.setInitWidths("50,150,200,60,60")
	mygrid.setColAlign("right,left,left,right,right")
	mygrid.setColTypes("ro,ro,ro,ed,ed");
    /*mygrid.getCombo(5).put(2,2);*/
	mygrid.setColSorting("int,str,str,int,int");
	mygrid.setSkin("modern");
	mygrid.setColumnColor("white,white,white,#d5f1ff,#d5f1ff")
	/////////////////////////////////
	 mygrid.attachEvent("onRowSelect",doOnRowSelected); 
	 mygrid.attachEvent("onEditCell",doOnCellEdit); 
	/* mygrid.attachEvent("onEnter",doOnEnter); 
	 mygrid.attachEvent("onCheckbox",doOnCheck);*/
	//////////////////////
	mygrid.init();
	mygrid.loadXML("grid.xml");
	
	  Nifty('div#box4','big');   Nifty('div#box6','big');Nifty('div#box5','big');
	
	
	

</script>
