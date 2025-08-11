<?

$grupo=$_REQUEST['grupo'];
?>

<br>
<br>
<div id="box5" style="background:#033; float:left">
<br />
<div align="center"><span  style="color:#FC0; font-size:16px">** Estadistica **</span></div>
<br />


<div id="a_tabbar" style="width:925px; height:435px;"/></div>
<div  id="gridboxTP_tp" ><div  id="gridboxTT"  height="390px"    style=" width:900px;background-color:#FC0 "></div></div>
<div  id="gridboxTPG_tp" ><div  id="gridboxTP"  height="390px" style="background-color:#FC0 "></div></div>
<div  id="gridboxTG_tp" ><div  id="gridboxTD" height="390px" style="background-color:#FC0 "></div></div>
<div  id="gridboxTE_tp" ><div  id="gridboxTOr" height="390px" style="background-color:#FC0 "></div></div>



</div>

<br />
<br />
<div id="boxx4" style="background: #333; float:left">
<?

include ("grafico_1.php");

?>
</div>
<script>

var grupo=<? echo $grupo; ?>;
    function doOnRowSelected(id){ 
		if (id<0) id=id*-1;
	    ByView(id,2);
		$('idseleccionado').lang=id;
		$('BtnImprimir').disabled='';
		$('BtnEliminar').disabled='';
	    } 
	function my_func(idn,ido){
                $('TagSeleccionado').lang=idn;
                    return true;
                
            };	
   
	function doOnCellEdit(stage,rowId,cellInd,newvalue){ 
		
		 if (stage==2){
		
		  return grabarBycupoBygrupo(rowId,newvalue);
			
		 }
		} 
	
	
	
   Nifty('div#box5','big');

	
//// **************************   TABS de los GRID ***************************
	

// Llamar para crear XML   
  mientrasProceso('Analizando','Procesando')
//  makeResultwin2('procierre.php?op=30&IDJ='+$('fc').lang+'&accesogp='+accesogp+'&grupo='+grupo,'newreq');
	
// El primer GRID con tickets Perdedores
 // makeResultwin2('procierre.php?op=30&IDJ='+$('fc').lang,'newreq');
 
 	tabbar=new dhtmlXTabBar("a_tabbar","top");
	
	tabbar.attachEvent('onSelect ', my_func);
    tabbar.setImagePath("codebase/imgs/");
    tabbar.setSkinColors("#FCFBFC","#F4F3EE","#FCFBFC");
    tabbar.addTab("a1","Totales","150px");
    tabbar.addTab("a2","Parlay","150px");
    tabbar.addTab("a3","Derecho","150px");
	tabbar.addTab("a4","Premios","150px");
	//tabbar.setStyle("modern");
    tabbar.setTabActive("a1");
	tabbar.setContent("a1","gridboxTP_tp");
	tabbar.setContent("a2","gridboxTPG_tp");
	tabbar.setContent("a3","gridboxTG_tp");	
	tabbar.setContent("a4","gridboxTE_tp");
 
 
  	var listaconfig = new Array();	
	new Ajax.Request('Esta_columna.php?grupo='+grupo,{
			 method:'get',asynchronous:false	,	onSuccess: function(transport){
		    var arrInfo = transport.responseText.evalJSON() ;
			listaconfig=arrInfo
						  
		 		   },
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });	
	 //alert(listaconfig);
	var dimen="20,*,*";
	var type="int,str,int"; 
	var sumas=",#rspan";//{#stat_count}
	var typecol="ro,ro,ro";
	for (i=0;i<=listaconfig.length-3;i++) { dimen=dimen+",*";type=type+",int"; sumas=sumas+ ",#cspan";typecol=typecol+ ",ro" }
	//alert(dimen)
	mygrid = new dhtmlXGridObject('gridboxTT');
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader(listaconfig+',Total');
	mygrid.setInitWidths(dimen+',*')
	typecol=typecol+',ro';
	sumas=sumas+ ",{#stat_total}";
	type=type+",int";
	mygrid.setColSorting(type)
	mygrid.setColTypes(typecol);
	//mygrid.setColAlign("right,right,right,left,left,left,left,left")
	
	mygrid.setSkin("dhx_skyblue");
	mygrid.init();mygrid.attachFooter(sumas);mygrid.setSizes();
	//mygrid.setColumnHidden(2, true);
	//mygrid.attachFooter("{#stat_count},{#stat_total},{#stat_total},#cspan,{#stat_total},#cspan,#cspan,#cspan,#cspan");
    mygrid.loadXML("Total.xml");//
mygrid.enableStableSorting(true);

	mygrid.sortRows(listaconfig.length,"int","des");
	
	
	mygrid1 = new dhtmlXGridObject('gridboxTP');
	mygrid1.setImagePath("codebase/imgs/");
	mygrid1.setHeader(listaconfig+',Total');
	mygrid1.setInitWidths(dimen+',*')
	mygrid1.setColSorting(type)
	mygrid1.setColTypes(typecol);
	//mygrid.setColAlign("right,right,right,left,left,left,left,left")
	mygrid1.setSkin("dhx_skyblue");
	mygrid1.init();mygrid1.attachFooter(sumas);

	//mygrid.setColumnHidden(2, true);
	//mygrid.attachFooter("{#stat_count},{#stat_total},{#stat_total},#cspan,{#stat_total},#cspan,#cspan,#cspan,#cspan");
    mygrid1.loadXML("Parlay.xml");
	
	mygrid2 = new dhtmlXGridObject('gridboxTD');
	mygrid2.setImagePath("codebase/imgs/");
	mygrid2.setHeader(listaconfig+',Total');
	mygrid2.setInitWidths(dimen+',*')
	mygrid2.setColSorting(type)
	mygrid2.setColTypes(typecol);
	//mygrid.setColAlign("right,right,right,left,left,left,left,left")
	mygrid2.setSkin("dhx_skyblue");
	mygrid2.init();mygrid2.attachFooter(sumas);
	//mygrid.setColumnHidden(2, true);
	//mygrid.attachFooter("{#stat_count},{#stat_total},{#stat_total},#cspan,{#stat_total},#cspan,#cspan,#cspan,#cspan");
    mygrid2.loadXML("Derecho.xml");
	
	mygrid3 = new dhtmlXGridObject('gridboxTOr');
	mygrid3.setImagePath("codebase/imgs/");
	mygrid3.setHeader(listaconfig+',Total');
	mygrid3.setInitWidths(dimen+',*')
	mygrid3.setColSorting(type)
	mygrid3.setColTypes(typecol);
	//mygrid.setColAlign("right,right,right,left,left,left,left,left")
	mygrid3.setSkin("dhx_skyblue");
	mygrid3.init();mygrid3.attachFooter(sumas);
	//mygrid.setColumnHidden(2, true);
	//mygrid.attachFooter("{#stat_count},{#stat_total},{#stat_total},#cspan,{#stat_total},#cspan,#cspan,#cspan,#cspan");
    mygrid3.loadXML("Premio.xml");

</script>