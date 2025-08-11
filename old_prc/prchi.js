// JavaScript Document para Hipismo Internacional.
//// Declaracion de Variables Globales
var dhxWins1=0;
var totalventas=0;
var timerID =0;
function makeResultwinHI(scr,obj)
	
	{
		stop_func();
		new Ajax.Request(scr,{
	
								method:'get',	onComplete: function(transport){
									var response = transport.responseText ;	
										$(obj).innerHTML=response;
										response.evalScripts();	
								},onCreate: function(){    		
									$(obj).innerHTML  = '<img src="media/ajax-loader.gif" />';
								},
	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
	
								});
		EstableTime();
	
	}

function focusset(elEvento,objsgn){
	  var evento = elEvento || window.event;
	
	  var codigoCaracter = document.all ? elEvento.keyCode : elEvento.which;
	 // alert(codigoCaracter);
	  if (codigoCaracter==13){
		$(	objsgn ).focus();
		$(	objsgn ).select();
	  }
	
}
	
		function makeRequesthip() {
	
		
	
		 var element =  $("menu1");
	
							 
	
		 $("tablemenu").innerHTML="";
	
		
			new Ajax.Request('menuhi.php?op=2&opciones='+$("logo").lang,{
	
									method:'get',	onSuccess: function(transport){
									var response = transport.responseText;	
	              
									 element.innerHTML = response;
									 response.evalScripts();	
	
									},
	
									onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
	
									})
	
	
	
	
		}
		
		
		function grabar_datosJuegohi()	
		 {   
	
			 /*alert("Hola");*/	
			 element1 = $("juego_nombre").value;	
			 element2 = $("factor").value;	
			 element3 = $("juego_apuesta_minima").value;	
			 element4 = $("juego_tandas").value;	
			 element5 = $("juego_estatus").value;	
			 element6 = $("numerJ").title;
			 element7 = $("cantidadcarrera").value;	
			 element8 = $("cantidadejemp").value;	
			 element9 = $("color").value;	
			 element9=element9.substr(1);	 
	
			 element10= element7+$("juego_conf").value;
			 element11= $("fdc").value;	
			 element12= $("frm").value;	
			 element13= $("relpos").value;
			 
	 		 element14= $("porcent").value;
			 if ($("op1").checked) {		 element15= 1;	 }else{element15= 0;}
			 if ($("op2").checked) {		 element16= 1;	 }else{element16= 0;}
			 if ($("op3").checked) {		 element17= 1;	 }else{element17= 0;}
			 element18= $("op4").value;
	
	
			 var element =  $("tablemenu");
		
				
 new Ajax.Request("agregarjuego-1-2hi.php?jn="+element1+"&fc="+element2+"&co="+element9+"&am="+element3+"&jt="+element4+"&je="+element5+"&nj="+element6+"&pr=1&cc="+element7+"&ce="+element8+"&cfn="+element10+"&fdc="+element11+"&frm="+element12+"&rps="+element13+"&proc="+element14+"&op1="+element15+"&op2="+element16+"&op3="+element17+'&op4='+element18,{		 
			 method:'get',
				onSuccess: function(transport){
				var response = transport.responseText;	 					 

	            alert('Registro Almacenado!');
			   },
	
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
	
			  }); 
	
	
				
	
				makeRequestSP('agregarjuego-1-1hi.php');
	
		  
	
		 }
	
		 
	
	function elimnar_datosJuegohi()
	
		 {   
	
			 /*alert("Hola");*/
	
			 desci=confirm("Desea eliminar este Registro?");
	
			 if (desci==true){
	
		
	
			 element6 = $("numerJ").title;
	
			 
			 var element =  $("tablemenu1");
	
			  new Ajax.Request('agregarjuego-1-2hi.php?nj='+element6+'&pr=2',{		 
			 method:'get',
				onSuccess: function(transport){
				var response = transport.responseText;	 
	            alert('Registro Eliminado!');
			   },
	
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
	
			  }); 
	
				
	
				makeRequestSP('agregarjuego-1-1hi.php');
	
				
	
			 }
	
		 }
		 
		 
		 
 function makeResEsphi(url,obj) {
	
			var element =  $(obj);	
			if (url=='jornada-1hi.php')	
			{	
			 $('busq').style.display="none";	
			 valorc5=$("fc").value;	
			 turl=url+'?opc=-1&fc='+valorc5;
			}
	
			if (url=='jornada-1-1hi.php')	
			{	
			 $('busq').style.display="none";	
			 valorc=$("fc").value;	
			 turl=url+"?fc="+valorc;	
			}	
			
	
			if (url=='jornada-2hi.php')	
			{
				
	
			valorc=$("cmbCarreras").value;	
			valorc2=$("cmbTandas_1").value;	
			valorc3=$("cmbTandas_2").value;	
			valorc4=$("cmbTandas_3").value;	
			valorc5=$("nj").title;		
	
			turl=url+"?nc="+valorc+"&tp4="+valorc2+"&tp3="+valorc3+"&dd="+valorc4+"&nj="+valorc5;			
	
			}		
	
			new Ajax.Request(turl,{		 
			 method:'get',
				onSuccess: function(transport){
				var response = transport.responseText;	 
	            element.innerHTML = response;	response.evalScripts();	
	
				if (url=='jornada-1.php')	{	 $("fecha_2").value=valorc5;	}	
			   },	
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
			  }); 
		}
		
		
 function _grabconthi(url,listadoO) {	
	
	
	
			tabl_x = parseInt( $("btngrb").alt );	tabl_x2= parseInt( $("btngrb").lang );
			valorc=$("cmbCarreras").value;
	
			var listaconfig = new Array();	
			retirados="";	
			cantcba="";
			favoritos="";
			hora="";
	
			
			for (j=1;j<=tabl_x;j++)	
			{		 
	
			 listaconfig[j]=$("t"+j).title+"*";		
			 for (i=1;i<=valorc;i++){	
			   if($("chek"+j+"-"+i).checked==true)   {	listaconfig[j]+=i+"-";	 } 
			   }	
				listaconfig[j]+=0;	
			}
			tabl_x++;
			tabl_x2+=tabl_x;
		
			sigue=tabl_x;
			var AListadoO=listadoO.split(',');
	        g=0;

			for (j=tabl_x;j<=tabl_x2;j++)	
			{		 
			
		
	         for (subcol=0;subcol<=AListadoO[g];subcol++)
			  {
				listaconfig[sigue]=$("t"+j+'_'+(subcol+1)).title+"*";	 
			 	for (i=1;i<=valorc;i++){	
					
			   		if($("chek"+j+"-"+i+"-"+(subcol+1)).checked==true)   {
						carreras=$("t"+j+'_'+(subcol+1)).lang;
						//alert(carreras);
						for (y=i;y<=(i+parseInt(carreras))-1;y++)
							listaconfig[sigue]+=y+"-";	
						} 
					
					}
				listaconfig[sigue]+=0;
				
				sigue++;	
			  	
				
			  }
			  g++;
		
			}
			
	
			for(i=1;i<=valorc;i++)	
			{	
				 cantcba+=$("ejem"+i).value+'|';	
				 retirados+=$("reti"+i).value+'|';	
				 favoritos+=$("favor"+i).value+'|';	
				 hora+=$("hora"+i).value+'|';	
			}
			
	
			var imploded=listaconfig.join('|');		
		   // alert(imploded);
			var element =  $("divresul");
			 
			
	         mientrasProceso('Grabacion Completada!') /// Procediento para dar la espera
			new Ajax.Request(url+"?config="+imploded+"&nc="+valorc+"&fc="+$("fecha_2").value+"&hp="+$("_hipod").value+"&nj="+$("nj").title+"&dp="+$("cmbTandas_1").value+"&ta="+$("cmbTandas_2").value+"&p4="+$("cmbTandas_3").value+"&ret="+retirados+"&fab="+cantcba+"&est="+$("testatus").value+"&favor="+favoritos+"&hora="+hora,{		 
			 method:'get',
				onSuccess: function(transport){
				var response = transport.responseText;	 
				//alert(response);
	            element.innerHTML = response;	response.evalScripts();		
			   },	
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
			  }); 
	
		}
		
		
function pulsarhi(e,i,t_tx,ty) {
  tecla = document.all ? e.keyCode : e.which;
  if(tecla==13) {
   	  if(i==2) {		
	    if ($('ejem').value!='' && $('ejem').value<=parseInt($('ejemp').title)) {
 
		  if ($('ejem').value!=0){
		   celda= $('celda'+$('valida').value+''+$('ejem').value);
		   // alert (celda.style.backgroundColor);
		   if (celda.title!=''){
           if (celda.style.backgroundColor=='rgb(0, 102, 255)') 
		    {
		     celda.style.backgroundColor="#26354A";
		    }
		    else
		    {
		    celda.style.backgroundColor="#0066FF";
		    } // if (celda.style.backgroundColor=='rgb(102, 255, 51)')rgb(102, 255, 51)
		   }//if (celda.title!='#999999')
		  }else  
		   {
			   
			 for (u=1;u<=parseInt($('ejemp').title);u++)
			 {
				 celda= $('celda'+$('valida').value+''+u);
				 //if (celda.style.backgroundColor=='#999999')
				 if (celda.title!=''){
				 if (celda.style.backgroundColor=='rgb(0, 102, 255)') 
		  		 {
				  celda.style.backgroundColor="#26354A";
				 }
		  		else
		  		 {
		  		  celda.style.backgroundColor="#0066FF";
		    	 }
				 }//if (celda.title!='#999999')
			 }// for
			 
		 } //  if ($('ejem').value!=0)
		 

	      calcular($('valida').value,ty);
		  $('ejem').value='';
		  $('ejem').focus();
	      $('ejem').select();
		 
		  }
		  else
		  {
		    if  ($('ejem').value=='')
			{
		   $("valida").value=parseInt($('valida').value)+1;
		   //alert (parseInt($("valida").value)<=parseInt($('carr').title));
		   if (parseInt($("valida").value)>parseInt($('carr').title))
		     {
			  $('valida').value="";
			  $('valida').focus();
	          $('valida').select();
			 }
			 else
			 {
		      $('valida').focus();
	          $('valida').select();
			 }//if ($("valida").value=='7')
			} 
			else {
			  	 $('ejem').value='';
		 		 $('ejem').focus();
	      		 $('ejem').select();
			}
		  }
	  }
 
  
   if(i==1) {

	  if ($('valida').value=='' ) 
	  {
	   
	   if (verificars()==true  ) 
	   {
	     $('valida').focus();
	     $('valida').select();
	   }else{
 	  	 $('ejem').disabled="disabled"; 
 		 $('valida').disabled="disabled"; 
		 $('idmonto').disabled=""; 
         $('idmonto').focus();
         $('idmonto').select();
	  } //if (verificars())
	  
	  }
	  else {
	   	 $('ejem').focus();
	     $('ejem').select();   
	 } //  if ($('valida').value=='' ) 
   } //if(i==1)
   
    var noy;
    if(i==3) {
		//$('idmonto').value=$('Total').value;
		valorCNC=parseInt($('idmonto').value)%parseInt($('Total').value);
		if (valorCNC!=0){ alert('El Monto debe ser proporcional al valor del Boleto!'); }
		//// Verifico si Tope Maximo de apuesta es valido
		valor=tomedeapuestamax();
		if ( valor!=0 ){  alert('La Apuesta Maxima es hasta '+valor+' veces Maximo\nEl valor maximo de este Boleto es de: Bsf.'+ ($('Total').value*valor) ); valorCNC=1; }
		
		
		////
		if (valorCNC==0 && $('idmonto').value!="" && parseInt($('idmonto').value)!=0 && parseInt($('idmonto').value)>=parseInt($('apm').lang)){ 
		 var yag=false;
		 noy=0;
         var v=false;
		idc=$('con').title;
		$("c").value='0';
		
		do{
		 $('idmonto').disabled="disabled"; 
		 if (idc==-2 || idc==-1)
		 {
		  desci=confirm("Desea Grabar el Boleto?");
		 }else{
		  desci=confirm("Desea Imprimir el ticket?");
		 }
		
	 	 if (desci==true){
			  //**** Aqui Instrucciones para impresion de Ticket
			  //tecla = event.keyCode ;
			if (yag==false)
			  {			   
	     	   v3=x_grabargamehi(t_tx);
			   yag=true; 
			  }
			 //   
			
			 idc=$('con').title;
			  idc=0;
			  if (idc==-2 || idc==-1)
			  {   
				  desci=false;
			  }else
			  {
				 
			  if (v3==true) 
			   { 
			  	   print(); 
			   }else{
				   desci=false;
			   }	
			   
			  }
		 } 
	
		}while (desci==true);
		//alert(noy);

	
		
		if (v3==true){	
		  Serial=$('numet').title;
		  IDJugada=$('tj').title;
	      setCookie('ticket_j'+	IDJugada,	Serial);
	     }
		 
		 $("printer").style.display="none";
		
		if (yag==true ){
		 in_tgame(t_tx,true); //Inicializar el formulario del Juego		 
		} else
		{
		 $('idmonto').disabled="";
	 	 $('idmonto').focus();
         $('idmonto').select();
		}
		
		if (v3==1500){
			alert('ATENCION:  !No tengo Comunicacion con El Servidor el ticket! \n NO SE ALMACENO');
			$("tablemenu").innerHTML='';
		}
			
		} else
		{
		 $('idmonto').disabled="";
		 $('idmonto').focus();
         $('idmonto').select();
		}//$('idmonto').value!=""
	 }//if(i==3)
     
   
   
  }
 
 if(tecla==27) {  
   if(i==3) {
		  $('ejem').disabled=""; 
 		  $('valida').disabled="";	
		  $('idmonto').disabled="disabled"; 
		  $('valida').focus();
	      $('valida').select();
	 }//if(i==3)
	if (i=1) 
	{
		 idc=$('con').title;
		 if (idc==-2 || idc==-1)
		 {
			in_tgame(t_tx,false);
		   	$('cons').value="";
			$('nom').value="";
			$('valida').disabled="disabled";
			$('ejem').disabled="disabled";
		    $('cons').focus();
	        $('cons').select();
		 }
		 
	}
 }
 
}

function tomedeapuestamax(){
	IDJugada=$('tj').title;	
	idc=$('con').title;
	Valor_R=$('Total').value;			
	Valor_J=$('idmonto').value;
	
	var respuesta=0;
		new Ajax.Request("ApuestaMaxima.php?IDC="+idc+"&valorj="+Valor_J+"&valorr="+Valor_R+"&idj="+IDJugada,{method:'get',asynchronous:false,onSuccess: function(transport){
      						var response = transport.responseText.evalJSON(true) ;//
								respuesta=response;
    						},
						    onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!') }
  							});
		
	return respuesta;	
}

var v3;
function x_grabargamehi(t_tx)
{  
	      jugada='';
		  if (t_tx==5){			  
		    tde=$('ne').lang;
	  	    jugada='';
			for (i=1;i<=tde;i++)
			{   	    		
				if (isset('ap'+i) )
				{
					
					if (parseInt($('ap'+i).value)!=0){jugada+='|'+i+'*'; jugada+=$('ap'+i).value+'-'+$('logros'+i).innerHTML;	}
				}
			}			  
		  
		  }else{
			  if (t_tx==4){	  
			  num=1;
			  }else {
			  num=parseInt($('ejemp').title);
			  }
		  for(var x=1;x<=parseInt($('carr').title); x++)
           {
			   jugada+='|';
		    for (var y=1;y<=num;y++)
		    {   
			   if (t_tx==4)
			   {
				    jugada+=$('v'+x).value;
			   }else {
				celda= $('celda'+x+''+y);
				
				if (celda.title!='')
				{ 
			        if (celda.style.backgroundColor=='rgb(0, 102, 255)') 
					{
					   jugada+=y+'-';
					}
				}//if (celda.title!='')
			   }// if (t_tx==3)
             }//**** For y
		   }//**** For x 
		  }		  
		  // 
		  
		   Serial=$('numet').title;
		
		   fecha=$('fch').title;
		   IDJugada=$('tj').title;	
		   Valor_R=0;
		   if (t_tx!=4)
		   {
		    Valor_R=$('Total').value;			
		   }
		   Valor_J=0;
		   if (t_tx!=5)
		   {
		   Valor_J=$('idmonto').value;
		   }
		   terminal=$('est').title;
		   IDusu=$('usu').title; 
		   IDCN=$('TIDCN').lang;
		   idc=$('con').title;
		   multi=0;
		   if (t_tx!=5)
		   {
		   multi=$('multi').title;
		   }
		   
		   carr=0;
		   
		   if (t_tx==2)
		   {
			  vec=$('carre_v').value.split("||");
	 		  e_c=vec[0];
	 		  crv=vec[1];
			  carr=crv;  
		   }
		   if (t_tx==5){  
		   	carr=$('carrera').lang;
			nom=idc;
			org=4;
		   }else{		
		 /*  if (idc==-2 || idc==-1)
		   {
			idc=$('cons').value;
			nom=$('nom').value;
			//org=$('org').value;
			if ($('org1').checked==true) {org=1;}
			if ($('org2').checked==true) {org=2;}
			if ($('org3').checked==true) {org=3;}	
		   }else
		   {nom=idc;*/
			nom='FBI2';
			org=4;
		  /* }*/
		   }

		   
		   $("printer").innerHTML = '';		   
		   $("printer").style.display=''; 
		  	   
		   var element2 =  $("tablemenu");
		   
         $('c').value='1500';
		 if (IDCN=='Cerrada'){
			 alert('Disculpe pero la jornada esta cerrada!');
		 }else{
			 
			 var estatus=true;
		
			/*  new Ajax.Request('frestriccionessphhi.php?monto='+Valor_J+'&idcn='+IDCN+'&jugada='+jugada+'&idc='+idc+'&op=2&idj='+IDJugada,{
						method:'get',asynchronous:false,
  						  onSuccess: function(transport){
      						var response = transport.responseText.evalJSON(true) ;
							if (response[0])
							{
								if (parseInt(Valor_J)>response[1])
								{
									 estatus=false;
									 alert('La apuesta que usted ha seleccionado, ha sobrepasado el monto permitido \nMonto Restante de esta Combinacion:'+response[1]);
								}
							}
							 
    						},
						    onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!') }
  							});*/
	
		if (estatus==true)
		{
	// $("tablemenu").innerHTML ="grabarjugada.php?tipo=2&Serial="+Serial+"&IDCN="+IDCN+"&fecha="+fecha+"&IDJugada="+IDJugada+"&Valor_R="+Valor_R+"&Valor_J="+Valor_J+"&terminal="+terminal+"&IDusu="+IDusu+"&jugada="+jugada+"&idc="+idc+"&multi="+multi+"&carr="+carr+"&fmr="+t_tx+"&nom="+nom+"&org="+org;
	
		new Ajax.Request("grabarjugadahi.php?tipo=2&Serial="+Serial+"&IDCN="+IDCN+"&fecha="+fecha+"&IDJugada="+IDJugada+"&Valor_R="+Valor_R+"&Valor_J="+Valor_J+"&terminal="+terminal+"&IDusu="+IDusu+"&jugada="+jugada+"&idc="+idc+"&multi="+multi+"&carr="+carr+"&fmr="+t_tx+"&nom="+nom+"&org="+org+"&inicarr="+$('inicioCarr').lang,{
   		 method:'get',asynchronous:false,
    		onSuccess: function(transport){
    		var response = transport.responseText.evalJSON(true) ;//
		  //   alert (response);
		 
   		   if (response.eva==true)
		   {  
		     
		        $('c').value=response.confir;
				if (response.confir==true){			  	  
			     $("printer").innerHTML = response.tk;
	
				}else{			
				  alert('Este ticket no se Almaceno.. VERIFIQUE!!');
				}	
				
	          			   
		   }else {
			   switch(t_tx)
			   {
				case 5:
				  alert('Lo Siento Esta Carrera Esta Cerrada'); 
				  $('esta2').style.display='none';
				  $('esta1').style.display='';
				  $('botonimp').style.display='none';				  
				  break;
				default:
			     $('c').value=response.eva;
				  if (carr==0) {
					  var element4 =  $("tablemenu");
					  new Ajax.Request('jugadacerrada.php',{
						method:'get',
  						  onSuccess: function(transport){
      						var response = transport.responseText;
							element4.innerHTML = response;
							 
    						},
						    onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!') }
  							});
				   				   
				  } // if (carr==0) 
				  else {
					   focoobjhi('valida',IDJugada,IDCN,response.as);
					       var v3=false;
				  }// if (carr==0)
			   	  break;	
			   }
			  
		   }
		   
		   
 		   },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });
		 }
		 }
       
	    return eval($('c').value);
	  
}

function focoobjhi(obs,tipojug,idcn,ept,compartir)
{    
 	   stop_func();
       vec=$('carre_v').value.split("||");
	   e_c=vec[0];
	   crv=vec[1];
	   if (crv!=undefined){
		new Ajax.Request("jugadat2-1hi.php?tp="+tipojug+"&cr="+e_c+"&idcn="+idcn+"&ept="+ept+"&crv="+crv+"&compartir="+compartir,{method:'get',asynchronous:false,onSuccess: function(transport){
      						var response = transport.responseText;
							var arrInfo = response.split("||");	
							 if (eval(arrInfo[0])){	
							  
			       				if (ept==1) {
								  $('ejemp').title=arrInfo[1];
				     			  inib_tgame(1,arrInfo[1],arrInfo[2],1,arrInfo[3]);
								}else
				     			  inib_tgame(1,arrInfo[1],arrInfo[2],2,arrInfo[3]);
		   	       
				   				$(obs).focus();
	       	      			    $(obs).select();
								EstableTime();
		 				      }else{
							   alert('Esta carrera o tanda esta cerrada');
							   inib_tgame(0,'','',0,0);
		  					  }
							   $('valida').value=1;	
    						},
						    onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!') }
  							});
	

	   }else{
		    alert('Esta carrera o tanda esta cerrada');
		  inib_tgame(0,'','',0);
	   }
}

function cambiodejornadahi(tj,tandas,activo1,idcn)
{
	//idcn=$('jndv').value;
	$('TIDCN').lang=idcn;	
	new Ajax.Request('jugadat2-2hi.php?tidcn='+idcn+'&tj='+tj+'&activo1='+activo1,{	
									method:'get',asynchronous:false,	onSuccess: function(transport){
									var response = transport.responseText;		
									 $('inclcarr').innerHTML = response;	
									},	
									onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
									});
									
									focoobjhi('valida',tj,idcn,tandas);
									
	
	
	
}

function cambiodejornadahiGPS(idcn)
{
	//idcn=$('jndv').value;
	$('TIDCN').lang=idcn;	
	new Ajax.Request('jugadat4-1hit.php?IDCNt='+idcn,{	
									method:'get',asynchronous:false,	onSuccess: function(transport){
									var response = transport.responseText;		
									 $('inclcarr').innerHTML = response;	
									 response.evalScripts();		
									},	
									onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
									});
   new Ajax.Request('jugadat4-2hi.php?tidcn='+idcn,{	
									method:'get',asynchronous:false,	onSuccess: function(transport){
									var response = transport.responseText;		
									 $('b_carr').innerHTML = response;	
									 response.evalScripts();		
									},	
									onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
									});
									
	
	
	
}

function makeResEsp2hi(url,obj,id) {			
	var element =  $(obj);
	turl=url;	
	new Ajax.Request(turl,{			method:'get',	onSuccess: function(transport){
									var response = transport.responseText;		
									  element.innerHTML =  response;	
									},	
									onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
									});

	makeResultwin('jornada-1hi.php?opc='+id,'parametrodeconfigu');
}

function accesogps(e,op,opcion)
{
  tecla = document.all ? e.keyCode : e.which;
  i=$('eje').value;
  if(tecla==13 ){
  if (i=='') { x_grabargameganahi(); }	  
  if (isset('g'+i)){
  if(tecla==13 && opcion==1) {	
	if (op) {
		$('g'+i).style.display='';
		$('p'+i).style.display='';	
		$('s'+i).style.display='';	
		$('g'+i).focus();
	}else{
		$('g'+i).style.display='none';
		$('p'+i).style.display='none';	
		$('s'+i).style.display='none';	
		$('eje').focus();
	}
  }else{
  if(tecla==13 && opcion==2) {	  
   if (!op){
		$('g'+i).style.display='none';
		$('p'+i).style.display='none';
		$('s'+i).style.display='none';
		
	 	 if ($('g'+i).value!='') {		
		     if (parseInt($('g'+i).value)<0){
		      if ((parseInt($('g'+i).value)*-1)<=parseInt($('gt'+i).lang)){
					$('gt'+i).innerHTML=parseInt($('gt'+i).lang)+parseInt($('g'+i).value);
					$('gt'+i).lang=parseInt($('gt'+i).lang)+parseInt($('g'+i).value);	
			  }
			 }else{
				 	$('gt'+i).innerHTML=parseInt($('gt'+i).lang)+parseInt($('g'+i).value);
					$('gt'+i).lang=parseInt($('gt'+i).lang)+parseInt($('g'+i).value);	
				 
			 }
		  }
			
	  	 if ($('p'+i).value!='') {	
		   if (parseInt($('p'+i).value)<0){
		      if ((parseInt($('p'+i).value)*-1)<=parseInt($('pt'+i).lang)){		 
				$('pt'+i).innerHTML=parseInt($('pt'+i).lang)+parseInt($('p'+i).value);
				$('pt'+i).lang=parseInt($('pt'+i).lang)+parseInt($('p'+i).value);			
			  }
         }else{
				 $('pt'+i).innerHTML=parseInt($('pt'+i).lang)+parseInt($('p'+i).value);
				$('pt'+i).lang=parseInt($('pt'+i).lang)+parseInt($('p'+i).value);		
				 
			 }   
          }
			  
	  	 if ($('s'+i).value!='') {	
		    if (parseInt($('s'+i).value)<0){
		      if ((parseInt($('s'+i).value)*-1)<=parseInt($('st'+i).lang)){		 
			 	$('st'+i).innerHTML=parseInt($('st'+i).lang)+parseInt($('s'+i).value);
				$('st'+i).lang=parseInt($('st'+i).lang)+parseInt($('s'+i).value);	
			   }
            }else{
			    $('st'+i).innerHTML=parseInt($('st'+i).lang)+parseInt($('s'+i).value);
				$('st'+i).lang=parseInt($('st'+i).lang)+parseInt($('s'+i).value);	
			 }   
		   }
			 
			 
		$('g'+i).value='';$('p'+i).value='';$('s'+i).value='';
		sumargp();
		$('eje').value='';
	 	$('eje').focus();	
	  } 
    }
  
  }
  
  }else{ $('eje').value='';  }
  }
}  

function sumargp()
{
	var total=0;
	for (i=1;i<=parseInt($('totaleje').lang);i++)
	{
		  if (isset('gt'+i)){
			total+=parseInt($('gt'+i).lang)+parseInt($('pt'+i).lang)+parseInt($('st'+i).lang);
		  }
	}
	$('totalg').value=total;
	
}

function cargarCamposHI()
{
	       Calendar.setup({
               inputField     :    "fc", 
               ifFormat       :    "%e/%m/%y",
               align          :    "Tl",
               singleClick    :    true,
			   onUpdate       :    catcalcHI
             });

		   

}

function catcalcHI(cal) {
  var date = cal.date;
  var field = document.getElementById("fc");  

    mes=date.print("%m");
    if (parseInt(mes)<=9){
		mes2=mes.substring(1,2);
	}
	else{
		mes2=mes;
	}
	
	field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");	
	jsonvaloresHI(field.value);	 	 

}

function jsonvaloresHI(oEvent)
	{	
		 new Ajax.Request("cfngdeportes-1hi.php?fc1="+oEvent+"&hip="+$('_hipod').value,{
   		 method:'get',
    		onComplete: function(transport){
    		var response = transport.responseText ;
				$("respejem").innerHTML = response;  
				response.evalScripts();	
 		   },
		   onCreate: function(){   	
				$("respejem").innerHTML = '<img src="media/ajax-loader.gif" />';
 		   },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });		

	}


function grabar_hipohi()	
		 {  
		 
	
			 element1 = $("nombre").value;	
			 element2 = $("estatus").value;	
			 element3 = $("n_idh").title;		
			 element4 = $("sig").value;
			 

	
			  new Ajax.Request('hipodromo-1-2hi.php?nm='+element1+'&es='+element2+'&idh='+element3+'&sg='+element4+'&pr=1',{
			 method:'get',	onComplete: function(transport){
				var response = transport.responseText ;
					$("tablemenu").innerHTML = response;  
			   },
			   onCreate: function(){    	
	
					$("tablemenu").innerHTML = '<img src="media/ajax-loader.gif" />';  
			   },
	
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
	
			  });
	
			
	
			makeResultwin('hipodromo-1-1hi.php',"tablemenu");
	
		 }
		 
function elimnar_hipohi()	
		 {   

			 desci=confirm("Desea eliminar este Registro?");	
			 if (desci==true){			 
	
			  element1 = $("n_idh").title;
	
			  new Ajax.Request('hipodromo-1-2hi.php?idh='+element1+'&pr=2',{
			 method:'get',	asynchronous:false,onComplete: function(transport){
				var response = transport.responseText ;
					$("tablamenu1").innerHTML = response;  
			   },
			   onCreate: function(){    	
	
					$("tablamenu1").innerHTML = '<img src="media/ajax-loader.gif" />';  
			   },
	
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
			  });
	
			  makeResultwin('hipodromo-1-1hi.php',"tablemenu");
	
	
			 }
	
		 }
		 
function grabarejemplareshi(nc,idcn)
	{	
	  ldv='';
	  for (i=1;i<=nc;i++)
	  {
		ldv+=i+'*';   
		for (j=1;j<=parseInt($('ne'+i).lang);j++)
		{
			ldv+=$('eje'+i+j).value+'|';  
		}
		ldv+='*';
	  }

		 new Ajax.Request("cfngdeportes-2hi.php?IDCN="+idcn+'&LNE='+ldv,{
   		 method:'get',
    		onComplete: function(transport){
    		var response = transport.responseText ;
				$("resultado").innerHTML = response;
 		   },
		   onCreate: function(){ 
				$("resultado").innerHTML = '<img src="media/ajax-loader.gif" />'; 
 		   },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });	


	}
	

function x_grabargameganahi()
{  
	      jugada='';  $hayjugada=false;   	  
		  for(var x=1;x<=parseInt($('totaleje').lang); x++)
           {
			 if (isset('gt'+x)){
				jugada+=parseInt($('gt'+x).lang)+'-'+parseInt($('pt'+x).lang)+'-'+parseInt($('st'+x).lang)+'|';
				 if (parseInt($('gt'+x).lang)!=0 || parseInt($('pt'+x).lang)!=0 || parseInt($('st'+x).lang)!=0) 
				   $hayjugada=true; 
			 }else{
				 jugada+='0-0-0|';
			 }
		   }//**** For x 	
		   if ($hayjugada){
		   Serial=$('numet').title;		
		   fecha=$('fch').title;
		   IDJugada=0;	
		   Valor_R=0;
		   Valor_J=$('totalg').value;
		   terminal=$('est').title;
		   IDusu=$('usu').title; 
		   IDCN=$('TIDCN').lang;
		   idc=$('con').title;
		   multi=0;		   
		   carr=parseInt($('carr').value);
		   nom='';
		   org=4;
		   
		   
		   $("printer").innerHTML = '';		   
		   $("printer").style.display=''; 
		  	   

		   
         //$('c').value='1500';
		 if (IDCN=='Cerrada'){
			 alert('Disculpe pero la jornada esta cerrada!');
		 }else{
			 
		var estatus=true;		
			
		if (estatus==true)
		{
	
		new Ajax.Request("grabarjugadahi_gana.php?tipo=2&Serial="+Serial+"&IDCN="+IDCN+"&fecha="+fecha+"&IDJugada="+IDJugada+"&Valor_R="+Valor_R+"&Valor_J="+Valor_J+"&terminal="+terminal+"&IDusu="+IDusu+"&jugada="+jugada+"&idc="+idc+"&multi="+multi+"&carr="+carr+"&fmr=0&nom="+nom+"&org="+org,{	  method:'get',asynchronous:false,
    	  onSuccess: function(transport){
    	  var response = transport.responseText.evalJSON(true);

	
		 
   		   if (response[0])
		   {  		
		   		$("printer").innerHTML =ticketimpri(Serial,fecha,response[2],jugada,response[1],response[3],response[4],carr,1,'');
			   
				 print();				
	          	 alert('Ticket Impreso');		   
		   }else {
			   switch(response[1])
			   {
				case '3':
				  alert('Lo Siento pero esta Sobrepasando la Apuesta Maxima'); 
				  $('btn').disabled="disabled";				  
				  break;   
				case '2':
				  alert('Lo Siento Esta Carrera Esta Cerrada'); 
				  $('btn').disabled="disabled";				  
				  break;
			   case '1':
			     alert('Este Ticket No se Almaceno VERIFIQUE!!!!') ;
				 }
  						
			}
		   
		   
 		   },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });
		 }
		 }
       
	  in_tgamehi_gana(IDCN);
		   }else{
			   alert('No hay Jugada que Realizar VERIFIQUE !');
			   $('eje').focus();
			   $('eje').select();
		   }
	  
}

	function isset(Object1) { 
	
			 return ($(Object1)!=null);
	  }
	
function ticketimpri(Serial,fecha,hora,jugada,se,direcc,Hipodromo,carr,op,premio,dividendo)
{
 a ='<table  border="0">   <tr>    <td colspan="4" ><p align="center">PAGAVEN</p></td>  </tr> <tr>    <td colspan="4" ><p align="center">Hipismo Internacional</p></td>  </tr>  <tr>    <td colspan="4" ><p align="center">Ganadores,Place y Show</p></td>  </tr>  <tr>    <td >Ticket No.</td>    <td colspan="3">'+Serial+'</td>  </tr>  <tr>    <td>Conces.:</td>    <td colspan="3">'+$('con').title+'-'+direcc+'</td>  </tr>  <tr>    <td colspan="4">Fecha:'+fecha+' &nbsp;Hora:'+hora+'</td>     </tr>  <tr>    <td colspan="4" >';
 
 switch(op){
	 
	 case 1: 
 			a+='Orginal</td>  </tr> <tr>    <td colspan="4" >Hipodromo:'+Hipodromo+'</td>  </tr>  <tr>    <td colspan="4" >Carrera No.:'+carr+'</td>  </tr> <tr>    <td >Ejemplar</td>    <td  >Ganador</td>    <td  >Place</td>    <td  >Show</td>  </tr>';
		    break;
	 case 2: 
 			a+='PAGO</td>  </tr> <tr>    <td colspan="4" >Hipodromo:'+Hipodromo+'</td>  </tr>  <tr>    <td colspan="4" >Carrera No.:'+carr+'</td>  </tr> <tr>    <td >Ejemplar</td>    <td  >Ganador</td>    <td  >Place</td>    <td  >Show</td>  </tr>';
		    break;		
	 case 3: 
 			a+='COPIA NO VALIDO</td>  </tr> <tr>    <td colspan="4" >Hipodromo:'+Hipodromo+'</td>  </tr>  <tr>    <td colspan="4" >Carrera No.:'+carr+'</td>  </tr> <tr>    <td >Ejemplar</td>    <td  >Ganador</td>    <td  >Place</td>    <td  >Show</td>  </tr>';
		    break;			
			
 }


	
 total=0;	
 lista=jugada.split('|'); 
 for (i=1;i<=lista.length-1;i++)
 {
	 apuesta=lista[i-1].split('-');
	 if (apuesta[0]!=0 || apuesta[1]!=0 || apuesta[2]!=0){
		 if (isset('ejemplar'+i))
			 a+=' <tr>   <td >'+i+'-'+$('ejemplar'+i).lang+'</td>    <td>'+apuesta[0]+'</td><td>'+apuesta[1]+'</td>    <td >'+apuesta[2]+'</td>  </tr>';
		else
			a+=' <tr>   <td >'+i+'-</td>    <td>'+apuesta[0]+'</td><td>'+apuesta[1]+'</td>    <td >'+apuesta[2]+'</td>  </tr>';
		
		total+=(parseInt(apuesta[0])+parseInt(apuesta[1])+parseInt(apuesta[2]));
	 }
 } 
 
switch(op){
		case 1:
		a+='<tr><td colspan="4">---------------------------------------</td>  </tr>  <tr>    <td colspan="2">Total Bs.F:</td>    <td colspan="2"><samp  align="right">'+$('totalg').value+'</p></td>  </tr>  <tr>    <td colspan="2">&nbsp;</td>    <td colspan="2">&nbsp;</td>  </tr>  <tr><td colspan="4"><samp align="center">********VERIFIQUE SU JUGADA********</p></td>  </tr>  <tr>    <td colspan="4" ><samp align="center">CADUCA A LOS 7 DIAS</p></td></tr><tr><td colspan="4">S.E.'+se+'</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr></table>';
			break;
		case 2:
			a+='<tr><td colspan="4">---------------------------------------</td>  </tr>  <tr>    <td colspan="2">Total Bs.F:</td>    <td colspan="2"><samp  align="right">'+total+'</p></td>  </tr><tr>    <td colspan="2">Dividendo:</td>    <td colspan="2"><samp  align="right">'+dividendo+'</p></td>  </tr>  <tr>    <td colspan="2">Premio Bs.F:</td>    <td colspan="2"><samp  align="right">'+premio+'</p></td>  </tr>  <tr>    <td colspan="2">&nbsp;</td>    <td colspan="2">&nbsp;</td>  </tr>  <tr><td colspan="4"><samp align="center">********VERIFIQUE SU JUGADA********</p></td>  </tr>  <tr>    <td colspan="4" ><samp align="center">CADUCA A LOS 7 DIAS</p></td></tr><tr><td colspan="4">S.E.'+se+'</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr></table>';
			break;
			
			case 3:
		a+='<tr><td colspan="4">---------------------------------------</td>  </tr>  <tr>    <td colspan="2">Total Bs.F:</td>    <td colspan="2"><samp  align="right">'+total+'</p></td>  </tr>  <tr>    <td colspan="2">&nbsp;</td>    <td colspan="2">&nbsp;</td>  </tr>  <tr><td colspan="4"><samp align="center">********NO VALIDO********</p></td>  </tr>  <tr>    <td colspan="4" ><samp align="center">CADUCA A LOS 7 DIAS</p></td></tr><tr><td colspan="4">COPIA-COPIA-COPIA-COPIA</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr><tr><td colspan="4">-</td>  </tr></table>';
			break;	
	
}

 	

return a;
}

function in_tgamehi_gana(IDCN)
{
      	$('eje').value=0;$('totalg').value=0;$("printer").innerHTML ='';
		makeResultwin('jugadat4-1hit.php?IDCNt='+IDCN+'&primercarr='+$('carr').value,'inclcarr');
		new Ajax.Request("ticket.php?tipo=1",{
   		 	method:'get',asynchronous:false,	onSuccess: function(transport){
    		var response = transport.responseText.evalJSON(true) ;
			$('numet').title = response;
			$('numet').innerHTML = $('numet').title;
			setCookie('numerticke',	response);							   
 		   },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });
		$('eje').focus();
		$('eje').select();
		
	
}

////////////////////  Acceso al Menu ////////////////////////////

function accesoalsistema()
{
               
		 var element =  $("tablemenu");
		 getuser=getCookie('rndusr');
		 v3='';
		 new Ajax.Request('logon.php?op=1&usu='+$('idusuario').value+'&pwd='+$('idclave').value+'&ck='+getuser,{
			 method:'get',onComplete: function(transport){
				var arrInfo = transport.responseText.split("||");	
	           
					   if (!eval(arrInfo[0])) {
						   	  $("con").style.display="";
                              $("fch").style.display="none";
	                          $("jnd").style.display="none";
	                          $("usu").style.display="none";
	                          $("est").style.display="none";
							  if (arrInfo[1]=='1') {
							    $("repuesta").innerHTML ='Usuario Bloqueado';
							  }
							  else{
                                if (arrInfo[1]=='2'){
									alert('USTED NO PERTENECE A ESTE SERVIDOR, Comuniquese con el Administrador!');
							    }else{
							    $("repuesta").innerHTML ='El Usuario No Existe o Clave Errada';
								}
							  }
					  } else {
						
						$("con").style.display="";
						switch (arrInfo[1]){
							case '-2':
						        $("con").innerHTML ='Nivel:Administrador';oko=1;break;
							case '-1':
							    $("con").innerHTML ='Nivel:Usuario';oko=0;break;
							case '-4':	 
							    $("con").innerHTML ='Nivel:Informacion';oko=0;break;
						    case '-5':	
							    $("con").innerHTML ='Nivel:Sistema';oko=0;break;	
							default:
						  		$("con").innerHTML ='Concesionario:'+arrInfo[1];oko=0;break;
						       }
						 $("con").title=arrInfo[1];
						 $("fch").style.display="";
						 $("fch").innerHTML ='Fecha:'+arrInfo[4];
						 $("fch").title=arrInfo[4];
						 $("jnd").style.display="";
						 $("jnd").innerHTML ='Jornada:'+arrInfo[5];
						 $("jnd").title=arrInfo[5];
						 $("usu").style.display="";
						 $("usu").innerHTML ='Usuario:'+v;
						 $("usu").title=arrInfo[7];
						 $("est").style.display="";
						 $("est").innerHTML ='Estacion:'+arrInfo[2];
						 $("est").title=arrInfo[2];						 
						 /*$("box16").style.display="none";*/
						 $("repuesta").style.display="none";
						  document.cookie = "sessionhash="+arrInfo[7]+"; max-age=" + (60*60*24*4) ;
					     setCookie('rndusr', arrInfo[6]);
						 $("logo").lang=arrInfo[8];
						 
		                 var element =  $("topmenu");
						 var element2 =  $("menu1");
						 
						// $("p").bgColor="#000000";
					//	 $("fd1").bgColor="#D3DCE6";
						// $("fd2").bgColor="#FFFFFF";
						 

						 /*$("topmenu2").style.display="none";
		                 $("tablemenu2").style.display="none";
						 $("tablemenu").style.display="";
						 $("menu2").style.display="none";
						 $("menu3").style.display="none";
						 $("box_g").style.display="none"; 
						 $("news").style.display=""; 	 */					 
						
						
					
						 element.innerHTML=''; 
						 $("body_princ").style.display="none";
						 $("body_program").style.display="";
						 var cmv2=arrInfo[9].split("|");
						 var cmv=cmv2[1].split("-");
                
	                     var iv=1;
                        //  makeRequesthip();  
						   
			
						  new Ajax.Request('chatactivo.php',{
   		 					method:'get',	onSuccess: function(transport){
    						var response = transport.responseText;	
			
							response.evalScripts();	
 		   					},
  		  					onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
							});
						  initMenu($("logo").lang); 
					  }//if
                
			   }, onCreate: function(){ 
					$("repuesta").innerHTML = '<img src="media/ajax-loader.gif" />';
			   },
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
		 
	
	function datosverjugadahi(serial,concesionario)
	{
	
	 if (serial==0){
		cns=$("con").title;
		jgd=$("jgd").value;
		jnd=$("jnd1").value;
	 }else
	 {
		
		 cns=-1;
		 jgd=$('bserial').value;
		 jnd=-1;
		
		
	 }
	 
	 
	
	
		for (i=0;i<=arraticket.length-1;i++)
		{	a=arraticket.pop(); }	
	
		if (cns==-2) 
		{		 
	
			cns=$("tcns").value;
	
			if (cns==0)
			{
				cns=-2;
			}
		}
			yq=false;
			new Ajax.Request('ver_jugada-1-1hi.php?cs='+cns+'&idcn='+jnd+'&idj='+jgd,{
			 method:'get',
				onComplete: function(transport){
				var response = transport.responseText ;
					$("lista").innerHTML = response;  
					response.evalScripts();	
			   },
			   onCreate: function(){    		
					$("lista").innerHTML = '<img src="media/ajax-loader.gif" />';  
			   },
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });
	
	}
function toolbar()
{
	var webBar = new dhtmlXToolbarObject("toolbarObj");
	webBar.setIconsPath("images/");
	webBar.loadXML("toolsbar.xml?etc="+new Date().getTime(),function(){});

}


function GrabarForDiviendo(_IDCN,_idhipo){
	
	_cantidadTcarr=$('Thipo'+_idhipo).lang;
	arrayDividendos=new Array();
	arrayTandas=new Array();
	for (u=1;u<=_cantidadTcarr;u++){
		listado=$('lista_'+u+'_'+_idhipo).lang.split('|');
		
		 
		arrayDividendos[u-1]='';
		for (o=0;o<=listado.length-2;o++){
			arrayDividendos[u-1]+=$(listado[o]).value+'|';
			if (isset(listado[o]+'t') )
		       if (typeof($(listado[o]+'t').innerHTML)!='undefined')
			   {
				mascara=listado[o].split('-');
				mascara2=mascara[1].split('_');
				arrayTandas[u-1]+=$(listado[o]+'t').innerHTML+'-'+mascara2[0]+'|';
			   }
			
		}
	}

	arrayDividendos.toJSON();
	arrayTandas.toJSON();

	new Ajax.Request('dividendosHI-1.php?IDCN='+_IDCN+'&Dividendo='+arrayDividendos+'&Tandas='+arrayTandas,{
			 method:'get',onComplete: function(transport){
				var response = transport.responseText ;
		

					alert("Informacion Grabada!!");
			   },
			  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });
	
}
//////////////////////////////  Funciones de Impresion de Reportes  / ////////////////////////////////////////
function ImprimirReporte(file)
	
	{
	
		d1=$("fc1").value;
		d2=$("fc2").value;
		hipo=$("Hipodromo").value;
		gp=$("Concesionario").value;
		
	
		 abrir(file+'?desde='+d1+"&hasta="+d2+"&hipodromo="+hipo+"&letra="+gp,' ',1,0,0,0,0,0,1,400,400,100,100,1);
	
	
	}
	
function ImprimirReporte2(file)
	
	{
	
		d1=$("fc1").value;
		d2=$("fc2").value;
		gp=$("Concesionario").value;
		
	
		 abrir(file+'?desde='+d1+"&hasta="+d2+"&letra="+gp,' ',1,0,0,0,0,1,1,400,400,100,100,1);
	
	
	}	
	
function ImprimirReporte3(file)
	
	{
	
		d1=$("fc1").value;
		d2=$("fc2").value;
		gp=$("Grupo").value;
		hipo=$("Hipodromo").value;
	
		 abrir(file+'?desde='+d1+"&hasta="+d2+"&grupo="+gp+"&hipodromo="+hipo,' ',1,0,0,0,0,0,1,400,400,100,100,1);
	
	
	}	
	
function ImprimirReporte4(file)
	
	{
	
		d1=$("fc1").value;
		d2=$("fc2").value;
		gp=$("Grupo").value;
	
		 abrir(file+'?desde='+d1+"&hasta="+d2+"&grupo="+gp,' ',1,0,0,0,0,1,1,400,400,100,100,1);
	
	
	}		
////////////////////////////////////////


function VerMonitor(){
		 abrir('television.php',' ',1,0,0,0,0,0,1,400,400,100,100,1);
	}	
/////////////////////////////////////	
function grabar_grupo(){  
	
			 element1 = $("nombre").value;	
			 element2 = $("responsable").value;	
			 element3 = $("telefono").value;	
			 element4 = $("direccion").value;	
			 element5 = $("estatus").value;	
			 element6 = $("n_idg").title;	
			 

			 
			  new Ajax.Request('grupo-1-2.php?nm='+element1+'&res='+element2+'&tlf='+element3+'&dr='+element4+'&es='+element5+'&idg='+element6+'&pr=1',{
			 method:'get',	onComplete: function(transport){
				var response = transport.responseText ;
					$("tablemenu2").innerHTML = response;  
			   },
			   onCreate: function(){    	
	
					$("tablemenu2").innerHTML = '<img src="media/ajax-loader.gif" />';  
			   },
	
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
	
			  });
	
			makeResultwin('grupo-1-1.php','tablemenu2');
	
		 }
	
		 
	
function elimnar_grupo() { 
	    desci=confirm("Desea eliminar este Registro?");
		 if (desci==true){
		    element1 = $("n_idg").title;
			new Ajax.Request('grupo-1-2.php?idg='+element1+'&pr=2',{
			 method:'get',	onComplete: function(transport){
				var response = transport.responseText ;
					$("tablemenu2").innerHTML = response;  
			   },
			   onCreate: function(){    	
	
					$("tablemenu2").innerHTML = '<img src="media/ajax-loader.gif" />';  
			   },
	
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
	
			  });
						makeResultwin('grupo-1-1.php','tablemenu2');
			 }
 }
 
 	 
	
function grabar_consecionario(){   
	
		
			 element1 = $("c_idc").value;	
			 element2 = $("nombre").value;	
			 element3 = $("direccion").value;	
			 element4 = $("estado").value;	
			 element5 = $("municipio").value;	
			 element6 = '';	
			 element7 = $("grupo").value;	
			 element8 = $("estatus").value;	
			 element9 = $("n_idr").title;	
			 element10 ='';
			 element11 = '';
			 element12 = '';	
	
	
			 new Ajax.Request('consecionario-1-2.php?idc='+element1+'&nm='+element2+'&dr='+element3+'&est='+element4+'&mup='+element5+'&tel='+element6+'&idg='+element7+'&es='+element8+'&idr='+element9+'&pr=1&cel='+ element10+'&mail='+element11+'&resp='+ element12,{
			 method:'get',	onComplete: function(transport){
				var response = transport.responseText ;
					$("tablemenu2").innerHTML = response;  
			   },
			   onCreate: function(){    	
	
					$("tablemenu2").innerHTML = '<img src="media/ajax-loader.gif" />';  
			   },
	
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
	
			  });
			 
			makeResultwin('consecionario-1-1.php','tablemenu2');
	
 }
	
function elimnar_consecionario(){  
			 desci=confirm("Desea eliminar este Registro?");
	
			 if (desci==true){		
	
			 element1 = $("n_idr").title;	
	
			 new Ajax.Request('consecionario-1-2.php?idr='+element1+'&pr=2',{
			 method:'get',
				onSuccess: function(transport){
				var response = transport.responseText.evalJSON(true) ;	
				if (response==true){
					alert('Registro Borrado con Exito!!');
				}else{
					alert('Este Registro no puede ser borrado tiene Jugada!!');
				} },
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });
	
			 
	
			makeResultwin('consecionario-1-1.php','tablemenu2');
	
	
	
			 }
	
		 }
var arraticket = new Array();
function eliminartickethi()
{  
    listael='';
	for (i=0;i<=arraticket.length-1;i++)
	{  
	  if (arraticket[i]!='') {		  
		listael=listael+arraticket[i]+"|";	
	  }
	}	
	 mientrasProceso('Ticket(s) Actualizado(s)!') /// Procediento para dar la espera
	new Ajax.Request("ver_jugada-1-2hi.php?tk="+listael+"&idc="+$("con").title,{	
								method:'get',onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									
									if (response[0]){
									
									for (i=0;i<=arraticket.length-1;i++)
									{  
						
	 								 if (arraticket[i]!='') {		  
									 listael=listael+arraticket[i]+"|";	
									 a='f'+arraticket[i];
		 							 c='im'+arraticket[i];
									 if ($(a).title=='1'){
		 								 $(a).title='0';
										 $(a).style.backgroundColor="#FFCC33";
		 								 $(c).src='media/estrellaout.gif'
									 }else{
										 $(a).title='1'; 
										 $(a).style.backgroundColor="#E2E7EF";		  
		 							 }				 
										arraticket[i]=''; 		 
	  								 }
									}
									for (i=0;i<=arraticket.length-1;i++){	a=arraticket.pop(); }	
									}else{ alert('Lo Siento usted no puede eliminar tickets');}
								},
	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
	
								});
	
	 
	
}
function datoscierresphhi()	
		 { 
	
			 element1 = $("fc").value;	
			
			 
		new Ajax.Request('cierreBHI.php?fecha='+element1,{	
								method:'get',	onSuccess: function(transport){	
								var response = transport.responseText ;		
								$("lganadores").innerHTML=response;	
								},	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
								});
	
	
	
	}
function MakeRespK1(url,obj) {	
    
	var element =  $(obj);
	turl=url;	
	new Ajax.Request(turl,{			method:'get',	onSuccess: function(transport){
									var response = transport.responseText;		
									  element.innerHTML =  response;	
									  response.evalScripts();	
									},	
									onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
									});

}	
function cargarcampos_ddesHI1()
	{	
			   Calendar.setup({	
				   inputField     :    "fc1",
				   ifFormat       :    "%e/%m/%y",   
				   align          :    "Tl",
				   singleClick    :    true,
				   onUpdate       :    catcalc_ddes1HI
				 });
	}
function catcalc_ddes1HI(cal) {
	  var date = cal.date;
	  var field = $("fc1");
	  mes=date.print("%m");
		if (parseInt(mes)<=9){
			mes2=mes.substring(1,2);
		}else{
			mes2=mes;
		}
		field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");
		 
		MakeRespK1('hipodromo-1-3hi.php?desde='+$('fc1').value+'&hasta='+$('fc2').value,'Hipodro');
	}
	
	function cargarcampos_ddesHI2()
	{
			   Calendar.setup({
				   inputField     :    "fc2",
				   ifFormat       :    "%e/%m/%y", 
				   align          :    "Tl",     
				   singleClick    :    true,
				   onUpdate       :    catcalc_ddes2
				 });
	}
	
function catcalc_ddes2(cal) {
	  var date = cal.date;
	  var field = $("fc2"); 
		mes=date.print("%m");
		if (parseInt(mes)<=9){
			mes2=mes.substring(1,2);
		}else{
			mes2=mes;
		}
		field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");
		MakeRespK1('hipodromo-1-3hi.php?desde='+$('fc1').value+'&hasta='+$('fc2').value,'Hipodro');
	}	
	
	
	
function uploadFile2(obj,id,idch) {
	mientrasCopio();
	$('fromiut_'+id+'_'+idch).submit();
	var a=$(obj).value; 
	a1=a.split(String.fromCharCode(92));
	extension=a1[a1.length-1].split('.');
 //   alert(a1);
 //alert(extension);
	if (extension[1]=='pdf' || extension[1]=='PDF' ) {
		$(obj).lang=a1[a1.length-1];
		//$('imgver').src= 'images/logo/'+a1[a1.length-1];
	} else {
		$(obj).value=''; 
		alert('SOLAMENTE SE ACEPTAN ARCHIVOS CON EXTENSION PDF!');
	}
	
}
function mientrasCopio(){
        Ext.MessageBox.show({
           title: 'Espere un Momento',
           msg: 'Cargando Archivo...',
           progressText: 'Inicializando...',
           width:300,
           progress:true,
           closable:false
       });
		
       var f = function(v){
            return function(){
                if(v == 12){
                    Ext.MessageBox.hide();
                    Ext.example.msg('Terminado', 'El Archivo ha sido Cargado!');
                }else{
                    var i = v/11;
                    Ext.MessageBox.updateProgress(i, Math.round(100*i)+'% completed');
                }
           };
       };
       for(var i = 1; i < 13; i++){
           setTimeout(f(i), i*500);
       }
    }	
function mientrasProceso(msgfinal){
        Ext.MessageBox.show({
           title: 'Espere un Momento',
           msg: 'Actualizando ..',
           progressText: 'Inicializando...',
           width:300,
           progress:true,
           closable:false
       });
		
       var f = function(v){
            return function(){
                if(v == 12){
                    Ext.MessageBox.hide();
                    Ext.example.msg('Terminado',msgfinal );
                }else{
                    var i = v/11;
                    Ext.MessageBox.updateProgress(i, Math.round(100*i)+'% completed');
                }
           };
       };
       for(var i = 1; i < 13; i++){
           setTimeout(f(i), i*500);
       }
    }		
function cambiofile(fecha){
	 mientrasCopio();
	namearch='';
	valores=$('lvr').lang;
	valores1=valores.split(',');
	for (i=0;i<=valores1.length-2;i++)
		namearch=namearch+$(valores1[i]).lang+',';

	//alert(namearch);alert($('lvr').lang);
	
	MakeRespK1('cambioarchivos.php?ldv='+$('lvr').lang+'&arch='+namearch+'&fch='+fecha,'Hipodro');
	
	
}
function cargarbusqhi(){
		if ($("bserial").disabled==true){
			$("bserial").disabled=false;
			$("bacept").disabled=false;
		}else{	
			$("bserial").disabled=true;
			$("bacept").disabled=true;
			}
		$('bserial').focus();
		$('bserial').select();
	}
	
function createByxmlTreePrincipal() 
{
 new Ajax.Request('xmlcreatertree-2.php', {method:'get',asynchronous:false,	
				               onComplete: function(transport){
									var response = transport.responseText ;	
								},	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
								});	
}	
	
/////////////////////////////////////// Funcion ////////////////////////
/// Permite Incluir,Modificar Registro de Cualquier Tabla /////////////
/// op=Opcion , ldc=Lista de Campos, tb=Nombre de tablas, otlc= verifica campos en Blanco en TRUE

function gem_general(op,ldc,tb,otlc)
	{
		var lv=ldc.split('|');
		var valores= new Array();
		var okey=true;
		for (i=0;i<=lv.length-1;i++)
		{
		   var Slv=lv[i].split('.');
		   if (Slv[1]=='value'){
			valores[i]=Slv[0]+'!'+escape($(Slv[0]).value);
			av=$(Slv[0]).value;
			if (av.blank()==true)	{ okey=false;	}
		   } 
		   if (Slv[1]=='lang'){
			valores[i]=Slv[0]+'!'+escape($(Slv[0]).lang);
			av=$(Slv[0]).lang;
			if (av.blank()==true)	{ okey=false;	}
		   }
		   if (Slv[1]=='checked'){
			if ($(Slv[0]).checked){ valordelcheck=1; }else{valordelcheck=0;}
			valores[i]=Slv[0]+'!'+escape(valordelcheck);
		   }
		}
		if (otlc==false) {okey=true;}
		if (okey==true) {
		valores.toJSON();
   
	new Ajax.Request('gem_general.php?op='+op+'&ldv='+valores+'&tb='+tb,{
								method:'post',	onSuccess: function(transport){
									var response = transport.responseText ;	
									$("estado").innerHTML=response;
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
		}else{
			alert (' Lo Siento pero hay campos en Blanco Verifique NO SE PUEDE ALMACENAR ');
		}
	
	}
/////////////////////////////////////////////////////////////////////

function GrabarCuposGPS(_IDC){
	JugadaMaximas=$('JMG').value+'|'+$('JMP').value+'|'+$('JMS').value;
	DividendosMaximos=$('DMG').value+'|'+$('DMP').value+'|'+$('DMS').value;
	
	MakeRespK1('cupos-3.php?op=1&JM='+JugadaMaximas+'&DM='+DividendosMaximos+'&IDC='+_IDC,'Hipodro');
	
}

function grabacion(_campo,_data,_idJugada,_IDC)
{
	var respuesta=false;
	new Ajax.Request('cupos-3.php',{ parameters: { op:2,idJugada:_idJugada,IdRelacionado:_IDC,campo:_campo,data:_data},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									if (!response)
										alert('No pude actualizar el Sistema!!')
										
									respuesta=	response;
									
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	return respuesta;
}

function initMenu(_Autorizados) {
	
		new Ajax.Request('xmlcreaterMenu.php',{ parameters: { file:'menu.xml',Autorizados:_Autorizados},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText;								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
		menu = new dhtmlXMenuObject("contextArea","modern_blue");
		menu.setImagePath("codebase/imgs/");
		menu.setIconsPath("images/");
		menu.setOpenMode("win");
		menu.loadXML("menu.xml?e="+new Date().getTime());
		menu.attachEvent("onClick","execMenu");

	}
	
function execMenu(id, zoneId, casState){
    stop_func();
	zona=id.split('-');
	if (zona[0]=='m1' || zona[0]=='m4' || zona[0]=='m5' || zona[0]=='m6'){
		if (zona[0]=='m1')
	 	switch (zona[1]){
			case '0':
				makeRequest('jugadat4hit.php?tj=0');
				break;
			default:
				makeRequest('jugadat2hi.php?tj='+zona[1]);
				break;	
				}
		if (zona[0]=='m4'){
			 	 cierreventanas();
				 MakeRespK1("resultados.php",'tablemenu'); 
		}
		if (zona[0]=='m5')
				 window.location.reload();
		if (zona[0]=='m6')
				 abrir('television.php',' ',1,0,0,0,0,0,1,400,400,100,100,1);		 
	}else
		new Ajax.Request('vermenu.php',{ parameters: { idmenu:id},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText;
									 response.evalScripts();	
									},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
		
}
function verticketGPSPremiado(serial,premio,dividendo){
		new Ajax.Request('pagaticketpremiado-3.php',{ parameters: { serial:serial},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									   //alert(ticketimpri(serial,response[0],response[1],response[2],response[3],response[4],response[5],response[6]));
									$('verticket').innerHTML=ticketimpri(serial,response[0],response[1],response[2],response[3],response[4],response[5],response[6],2,premio,dividendo);
									$('vertik').value=serial;	
									if (response[7]){
										$("printer").innerHTML =$('verticket').innerHTML;
										$('btnpagar').disabled="";
									}else{
										$("printer").innerHTML ='';
										$('btnpagar').disabled="disabled"; 
										$('verticket').innerHTML='<BLINK> ******* TICKET PAGADO ******* <BLINK><br>'+$('verticket').innerHTML;
									}
									},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
}
function verticketEXOPremiado(serial,premio,dividendo){
		new Ajax.Request('grabarjugadahi.php',{ parameters: { Serial:serial,tipo:1,premio:premio,dividendo:dividendo},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
				     
									$('verticket').innerHTML=response.tk;
									$('vertik').value=serial;
									
									if (response.eva){
										$("printer").innerHTML =$('verticket').innerHTML;
										$('btnpagar').disabled="";
									}else{
										$("printer").innerHTML ='';
										$('btnpagar').disabled="disabled"; 
										$('verticket').innerHTML='<BLINK> ******* TICKET PAGADO ******* <BLINK><br>'+$('verticket').innerHTML;
									}
									},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
}
function pagapremio(_serial){
	
			new Ajax.Request('pagaticketpremiado-1.php',{ parameters: { serial:_serial},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									
									if (response[0]){
											if (response[1]==-1)
												alert('El Ticket No se Existe! Verique el Serial');	
											else{
												
												switch (response[2]){
													case 0:
															verticketGPSPremiado(_serial,response[1],response[3]);
															break;
													case 1:
															verticketEXOPremiado(_serial,response[1],response[3]);
															break;
												}
											}
										
									}else{
										alert('El Ticket No esta premiado Verifique por Favor!!');	
									}
									
									
									},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
}

function pagarticket(serial){
	
		new Ajax.Request('pagaticketpremiado-2.php',{ parameters: { serial:serial,Idusu:$('usu').title},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									   if (response)
									   	{	print();
											alert('Ticket Premiado Impreso y Pagado..');
										}else{
											alert('No puedo pagar este Ticket (Ya fue Pagado) Verifique por favor');
										}
									},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
}
  
function EstableTime(){

	inic=parseInt($('inicioCarr').lang);
  	if (inic==0){
	valor=$('carre_v').value;
	valor2=valor.split('||');
	inic=valor2[1];
	}
	if (inic==-1) inic=$('carr').value;

	if (!isNaN(inic))
	new Ajax.Request('proce_ajax.php',{ parameters: {op:2,IDCN:$('TIDCN').lang,carr:inic},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									  horaestablecer(response);
									},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	

}
function horarestan(horacierre)
{	
	new Ajax.Request('proce_ajax.php?op=1&horacierre='+horacierre, {
		method: 'get', onComplete: 		
		function (transport){	   
		 var response = transport.responseText.evalJSON(true);	
		    $('minrestan').innerHTML=response+' min';         
		},
 		  	onFailure: function(){  $('minrestan').value='ERR'; }
			
	});
	
	
}

function horaestablecer(horacierre)
{
	tiempo=60000;
	horarestan(horacierre)
	timerID = setInterval("horarestan('"+horacierre+"')", tiempo);
	

}  
function stop_func(){	if (timerID!=0){ if (isset('minrestan')) $('minrestan').innerHTML='0 min';  clearInterval(timerID);} timerID=0; }


function RImprimirTicket(_serial){
	if (_serial!='*') {
		mientrasProceso('Imprimiendo Ticket!');
			new Ajax.Request('proce_ajax.php',{ parameters: {op:4, serial:_serial},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									
								
											if (response[1]==-1)
												alert('El Ticket Esta Anulado! Verique el Serial');	
											else{
										
												switch (response[2]){
													case 0:
															RIMPRIMIRGPS(_serial);
															break;
													case 1:
															RIMPRIMIREXO(_serial);
															break;
												}
												
											}
										
									
									
									
									},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	}
	
}

function RIMPRIMIRGPS(serial){
		new Ajax.Request('proce_ajax.php',{ parameters: { op:3,serial:serial},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									   //alert(ticketimpri(serial,response[0],response[1],response[2],response[3],response[4],response[5],response[6]));
									 if (response[0]) { 
										$('printer').innerHTML=ticketimpri(serial,response[1],response[2],response[3],response[4],response[5],response[6],response[7],3,0,0);
										print(); }
									else
										alert('La Carrera en la cual pertence este ticket esta cerrada!');
									
									
									},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
}
function RIMPRIMIREXO(serial){
		new Ajax.Request('grabarjugadahi.php',{ parameters: { Serial:serial,tipo:3,premio:0,dividendo:0},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
				                     if (response.eva==true){
										$('printer').innerHTML=response.tk;   print(); 
									 }else 		
								   		alert('La Jornada en la cual pertence este ticket esta cerrada!');
									
									},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
}