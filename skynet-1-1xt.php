<div id="fromJornada12"></div>

<script>
 var Narre='<? echo $_REQUEST['selec']; ?>';
 var arre=Narre.split(',');
 function clicktoolBar(id){
	 
	switch(id){	
		case "Cerrar_":
		            nuearr=new Array();
					x=0;
		            for (i=0;i<=arre.length-1;i++) 
					 if  (arre[i]!=-1){ nuearr[x]=arre[i]; x++;}
					 
		            $('selcas').innerHTML=nuearr.splice(',');
					dhxWins12.window("w12").close();
					break;	
	  }
 }
  var n=arre.length;
  function doOnCheck(rowId,cellInd,state){
	estado=false;  
	if (state){
	  liga=rowId;
	  var s = rowId;
	  if (s!=-1) { estado=true;saltar=false;
	  for (i=0;i<=n-1;i++) if (arre[i]==-1){ arre[i]=rowId; saltar=true; break; } 
	  if (!saltar){ arre[n]=rowId; n++; }
	  }
   }else{
	  estado=true;liga=0; 
	  
	  for (i=0;i<=n-1;i++) if (arre[i]==rowId){arre[i]=-1; break;} 
	  }
	return estado;
  }  
  
 function doOnRowSelected(id){ 
		idRow=id;
	    } 
		
		
new Ajax.Request( "skynet-1-1xmlXT.php",{ parameters: {vlr:arre.join(',')},method:'get', asynchronous:false,
    		onComplete: function(transport){
			 var response = transport.responseText;	
			 },	
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });				 
	 
	dhxWins12 = new dhtmlXWindows();
    dhxWins12.setImagePath("codebase/imgs/");	
	w12 = dhxWins12.createWindow("w12",400, 280, 200, 300);
	w12.setText('Lista de Casinos(Activos)');
	w12.attachObject('fromJornada12');
	dhxWins12.window("w12").button('close').hide();
	dhxWins12.window("w12").button('minmax1').hide();
	dhxWins12.window("w12").button('minmax2').hide();
	dhxWins12.window("w12").button('park').hide();
	dhxWins12.window('w12').setModal(true);
    var bar12 = w12.attachToolbar();
	bar12.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif"); 
	
	bar12.attachEvent("onClick", clicktoolBar);
	
	mygrid12 = w12.attachGrid();
	mygrid12.setImagePath("codebase/imgs/");
	mygrid12.setHeader(",Casinos,");
	mygrid12.setInitWidths("25,400,0")
	mygrid12.setColAlign("right,left,left")
	mygrid12.setColTypes("ch,ro,ro");
	mygrid12.enableCollSpan(true);
    mygrid12.setSkin("dhx_skyblue");
	mygrid12.attachEvent("onRowSelect",doOnRowSelected); 
	mygrid12.attachEvent("onCheckbox",doOnCheck);
	
	mygrid12.loadXML("liscas.xml?e="+new Date().getTime());mygrid12.init();
</script>  
