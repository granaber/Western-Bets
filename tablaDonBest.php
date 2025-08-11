<div id='tpg_1'  style='height:400px; width:800px '></div>
<script>
function doOnCellEdit(stage,rowId,cellInd,newvalue){


   if (stage==2){
	   var  response;
	
	new Ajax.Request("tablaDonBest-2.php",{ parameters: { Campo:cellInd,valor:newvalue,id:rowId },
			 method:'post',
				onComplete: function(transport){
				response = transport.responseText.evalJSON() ;
				  if (!response)
				  	alert('No se pudo actulizar su requerimiento');
			   },
			  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });
   }
	return true;
	} 
			dimCol='80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80';
			mygridVar = new dhtmlXGridObject("tpg_1");
			mygridVar.setImagePath("codebase/imgs/");
			mygridVar.setHeader("ID,Base Macho,Base Hembra, 20 Macho ,20 Hembra , 30 Macho ,20 Hembra, 40 Macho ,40 Hembra,Alta,Baja,Apretando 1/2 punto(M),Apretando 1/2 punto(H),Apretando 1 punto(M),Apretando 1 punto(H),Apretando 1.5 punto(M),Apretando 1.5 punto(H),MoneyLine(M),MoneyLine(H),Logro5In(M),Logro5In(H)");
			mygridVar.setInitWidths(dimCol)
			mygridVar.setColAlign("right,right,right,right,right,right,right,right,right,right,right,right,right,right,right,right,right,right,right,right,right")
			mygridVar.setColTypes("ro,ro,ro,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed");	
			mygridVar.setSkin("dhx_skyblue");
			mygridVar.init();	
			//mygridVar.splitAt(3);
			mygridVar.loadXML("tablaDonBest-1.php");
			mygridVar.attachEvent("onEditCell",doOnCellEdit); 

</script>