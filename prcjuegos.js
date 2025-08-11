// JavaScript Document

  var l1 = new Array();
  var l2 = new Array();
  var l3 = new Array();
  var l4 = new Array();

function arrainput(nc)
{
		for (var a = 1; a <=l1.length; a++)
		r=l1.pop();
		
 		for (var b = 1; b <=l2.length; b++)
 		r=l2.pop();
		
		for (var c = 1; c <=l3.length; c++)
 		r=l3.pop();
		
		for (var d = 1; d <=l4.length; d++)
  		r=l4.pop(); 
		//alert ('apass');
		if (1<=nc) { 
			w=1;
		    for (var y=1;y<=parseInt($('ejemp').title);y++)
		    {   
				celda= $('celda1'+y);
			
				if (celda.title!='')
				{ 
			        if (celda.style.backgroundColor=='rgb(0, 102, 255)') 
					{
					  l1[w]=y;
					  w++;
					}
				}//if (celda.title!='')
             }//**** For y
		 }
		 
		 if (2<=nc) { 
			w=1;
		    for (var y=1;y<=parseInt($('ejemp').title);y++)
		    {
				celda= $('celda2'+y);
				if (celda.title!='')
				{ 
			        if (celda.style.backgroundColor=='rgb(0, 102, 255)') 
					{
					  l2[w]=y;
					  w++;
					}
				}//if (celda.title!='')
             }//**** For y
		 }
		 
		 if (3<=nc) {
		   	w=1;
		    for (var y=1;y<=parseInt($('ejemp').title);y++)
		    {
				celda= $('celda3'+y);
				if (celda.title!='')
				{ 
			        if (celda.style.backgroundColor=='rgb(0, 102, 255)') 
					{
					  l3[w]=y;
					  w++;
					}
				}//if (celda.title!='')
             }//**** For y
		 }
		 
		 if (4<=nc) {
			w=1;
		    for (var y=1;y<=parseInt($('ejemp').title);y++)
		    {
				celda= $('celda4'+y);
				if (celda.title!='')
				{ 
			        if (celda.style.backgroundColor=='rgb(0, 102, 255)') 
					{
					  l4[w]=y;
					  w++;
					}
				}//if (celda.title!='')
             }//**** For y
		 }
		 
		 
}


function calcular(g,t)
{
 k=0;
 valor="celda"+g;
 /*alert(valor);*/
 for (var i = 1; i <=parseInt($('ejemp').title); i++)
  {    
	celda= $(valor+i);
	
	 if (celda.style.backgroundColor=='rgb(0, 102, 255)') 
	 { 
	  k++;
	 }
  }		
 $('v'+g).value=k;    
	

 switch (t) {
	 case 1: 
        valorm=1;	
 		for(var l=1;l<=parseInt($('carr').title); l++)
		{
		 valorm=valorm*$('v'+l).value;
		}
  		break;
    case 2:
        arrainput(parseInt($('carr').title));
		valorm=0;	
		//alert (l1[1]);
		 switch (parseInt($('carr').title)) {
		 case 4:
		    valorm=0;
			for (var a = 1; a<=l1.length-1; a++)
			{
 			for (var b = 1; b<=l2.length-1; b++)
 			{
			for (var c = 1; c<=l3.length-1; c++)
 			{
			for (var d = 1; d<=l4.length-1; d++)
  			{   
		      if (l1[a]!=l2[b] && l1[a]!=l3[c] && l1[a]!=l4[d]) {
				 if (l2[b]!=l3[c] && l2[b]!=l4[d]) {
					 if (l3[c]!=l4[d]) {
						 valorm++;
					 }// if (l3[c]<>l4[d])
			 	}//if (l2[b]<>l3[c] && l2[b]<>l4[d])
		  	}//if (l1[a]<>l2[b] && l1[a]<>l3[c] && l1[a]<>l4[d])		  
			}//d
			}//c
			}//b
			}//a
			//alert (valorm);
			break;
		 case 3:
		 	for (var a = 1; a<=l1.length-1; a++)
			{
 			for (var b = 1; b<=l2.length-1; b++)
 			{
			for (var c = 1; c<=l3.length-1; c++)
 			{
    	      if (l1[a]!=l2[b] && l1[a]!=l3[c] ) {
				 if (l2[b]!=l3[c] ) {
					 valorm++;
			 	}//if (l2[b]<>l3[c] && l2[b]<>l4[d])
		  	}//if (l1[a]<>l2[b] && l1[a]<>l3[c] && l1[a]<>l4[d])		  
			}//c
			}//b
			}//a
			break;

		 case 2:
		 	for (var a = 1; a<=l1.length-1; a++)
			{
 			for (var b = 1; b<=l2.length-1; b++)
 			{
    	      if (l1[a]!=l2[b] ) {
					 valorm++;
		  	  }//if (l1[a]<>l2[b] )		  
			}//b
			}//a
			break;
		 
												  }//switch (parseInt($('carr').title) {
		
		break; 
		
 }		
mg=Math.ceil(parseInt(valorm*$('multi').title));
 
 $('Total').value=mg;
 $('idmonto').value=mg;
}



function pulsar(e,i,t_tx,ty) {
  tecla = document.all ? e.keyCode : e.which;

  if(tecla==13) {
   	  if(i==2) {		
	    if ($('ejem').value!='' && $('ejem').value<=parseInt($('ejemp').title)) {
 
		  if ($('ejem').value!=0){
		   celda= $('celda'+$('valida').value+''+$('ejem').value);
		 //  alert (celda.style.backgroundColor);
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
		
		if ($('idmonto').value!="" && parseInt($('idmonto').value)!=0 && parseInt($('idmonto').value)>=parseInt($('apm').lang)){ 
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
	     	   v=x_grabargame(t_tx);
			   yag=true; 
			  }
			 //  
			 idc=$('con').title;
			  if (idc==-2 || idc==-1)
			  {   
				  desci=false;
			  }else
			  {
				  
			  if (v==true) 
			   { 
			  	   print(); 
			   }else{
				   desci=false;
			   }	
			   
			  }
		 } 
	
		}while (desci==true);
		//alert(noy);

	
		
		if (v==true){	
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
		
		if (v==1500){
			alert('ATENCION:  !DEBO CERRARLE EL JUEGO SE TERMINO LA COMUNICACION ! \n ****el ticket NO SE ALMACENO****');
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


function celdasicons(v,ty)
{
		 for (u=1;u<=parseInt($('ejemp').title);u++)
			 {
				 celda= $('celda'+v+''+u);
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
				  calcular(v,ty);
				 }//if (celda.title!='#999999')
				 
			 }// for
		  $('valida').value='';
		  $('valida').focus();
	      $('valida').select();
}


function verificars() {
 hayceros=false;

 
 for (var u=1;u<=parseInt($('carr').title);u++)
 { 
  
	 if ($('v'+u).value==0)
	 {    

		 hayceros=true;
	 }
 }
 
 if (parseInt($('Total').value)==0) { hayceros=true; }
  
 return hayceros;
}




function in_tgame(t_tx,yag)
{
      
		 
		  
		  
		  
		  if (t_tx==5)
		  {
			 $('Total').value=''; $('totalver').innerHTML='';
			 
			 tde=$('ne').lang;
	
			for (i=1;i<=tde;i++)
			{   	    		
				if (isset('ap'+i) )	{ $('ap'+i).value=0; }
			}
			 
		  }else{
			  
			  $('idmonto').value=""; 
		      $('idmonto').disabled="disabled"; 
		  if (t_tx==4)
		  {	 
		     num=1;
		  }else		  
		  {    
		      $('Total').value='';    
			  $('ejem').disabled=""; 
		      $('ejem').value=""; 
 		      $('valida').disabled="";	
		      $('valida').value="";
			  num=parseInt($('ejemp').title);
		  }
		 
		  for(var x=1;x<=parseInt($('carr').title); x++)
           {
		    for (var y=1;y<=num;y++)
		    {
			   if (t_tx==4)
			   {
				 $('v'+x).value='';
				 $('tv'+x).innerHTML='';
			   }else {
                 celda= $('celda'+x+''+y);
				 if (celda.title!='')
				 { 
			      celda.style.backgroundColor="#26354A";
				 }
			   }
            }
			 if (t_tx!=4)
			   {$('v'+x).value='';}
		   } 
		   
		   if (t_tx!=4)
			{
              $('valida').focus();
	          $('valida').select();
			}else
			{
				$('v1').focus();
  				$('v1').select();
			}
		 }
			
			if (yag==true)
			{
		 	new Ajax.Request("ticket.php?tipo=1",{
   		 	method:'get',asynchronous:false,	onSuccess: function(transport){
    		var response = transport.responseText.evalJSON(true) ;
			$('numet').title = response;
			$('numet').innerHTML = $('numet').title;
			setCookie('numerticke',	response);
							   
 		   },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });
		
		   }   
		  

		//alert ('a ver si fui yo');
}

/*****************************************/
var v;
function x_grabargame(t_tx)
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
		   IDCN=$('jnd').title;
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
		   if (idc==-2 || idc==-1)
		   {
			idc=$('cons').value;
			nom=$('nom').value;
			//org=$('org').value;
			if ($('org1').checked==true) {org=1;}
			if ($('org2').checked==true) {org=2;}
			if ($('org3').checked==true) {org=3;}	
		   }else
		   {
			nom=idc;
			org=4;
		   }
		   }

		   
		   $("printer").innerHTML = '';		   
		   $("printer").style.display=''; 
		  	   
		   var element2 =  $("tablemenu");
		   
         $('c').value='1500';
		 if (IDCN=='Cerrada'){
			 alert('Disculpe pero la jornada esta cerrada!');
		 }else{
			 
			 var estatus=true;

			  new Ajax.Request('frestriccionessph.php?monto='+Valor_J+'&idcn='+IDCN+'&jugada='+jugada+'&idc='+idc+'&op=2&idj='+IDJugada,{
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
							}else {
								estatus=false;	
								if (response[1]==-1)
										 alert('USTED NO TIENE CONFIGURADO LOS LIMITES \n**DEBE COMUNICARSE CON EL ADMINISTRADOR**');
								else
										alert('ESTA JUGADA LLEGO AL LIMITE DEL CUPO ASIGNADO A USTED!');
							}
							 
    						},
						    onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!') }
  							});
			  
			  if (estatus){
				  
				new Ajax.Request('frestriccionessph.php?monto='+Valor_J+'&idcn='+IDCN+'&jugada='+jugada+'&idc='+idc+'&op=4&idj='+IDJugada,{
						method:'get',asynchronous:false,
  						  onSuccess: function(transport){
      						var response = transport.responseText.evalJSON(true) ;
							if (response[0])
							{
								if (parseInt(Valor_J)>response[1])
								{
									 estatus=false;
									 alert('La apuesta que usted ha seleccionado, ha sobrepasado el monto permitido por Grupo \nMonto Restante de esta Combinacion:'+response[1]);
								}
							}else {
								estatus=false;	
								if (response[1]==-1)
										alert('USTED NO TIENE CONFIGURADO LOS LIMITES POR GRUPO \n**DEBE COMUNICARSE CON EL ADMINISTRADOR**');
								else
										alert('ESTA JUGADA LLEGO AL LIMITE DEL CUPO ASIGNADO AL GRUPO QUE USTED PERTENECE!');
							}
							 
    						},
						    onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!') }
  							});  
			  }
	
		if (estatus==true)
		{
	// $("tablemenu").innerHTML ="grabarjugada.php?tipo=2&Serial="+Serial+"&IDCN="+IDCN+"&fecha="+fecha+"&IDJugada="+IDJugada+"&Valor_R="+Valor_R+"&Valor_J="+Valor_J+"&terminal="+terminal+"&IDusu="+IDusu+"&jugada="+jugada+"&idc="+idc+"&multi="+multi+"&carr="+carr+"&fmr="+t_tx+"&nom="+nom+"&org="+org;
	
		new Ajax.Request("grabarjugada.php?tipo=2&Serial="+Serial+"&IDCN="+IDCN+"&fecha="+fecha+"&IDJugada="+IDJugada+"&Valor_R="+Valor_R+"&Valor_J="+Valor_J+"&terminal="+terminal+"&IDusu="+IDusu+"&jugada="+jugada+"&idc="+idc+"&multi="+multi+"&carr="+carr+"&fmr="+t_tx+"&nom="+nom+"&org="+org,{
   		 method:'get',asynchronous:false,
    		onSuccess: function(transport){
				 
    		var response = transport.responseText.evalJSON(true) ;
		  // 
		  
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
					   focoobj('valida',IDJugada,IDCN,response.as);
					       var v=false;
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

// Crear Un Cookie
function getCookie(name){
  var cname = name + "=";               
  var dc = document.cookie;        
 
  if (dc.length > 0) {              
    begin = dc.indexOf(cname);   
	   
    if (begin != -1) {           
      begin += cname.length;       
      end = dc.indexOf(";", begin);
	  
      if (end == -1) end = dc.length;
        return unescape(dc.substring(begin, end));
    } 
  }
  return "*";
}

// ver el contenido de un cookie
function setCookie(name, value) {

var exdate=new Date();
exdate.setDate(exdate.getDate());

  document.cookie = name + "=" + escape(value)+"; max-age=" + (60*60*24*4) ;
}

// Eliminar Cookie
function delCookie (name) {
  if (getCookie(name)) {
    document.cookie = name + "='*'" ;
  }
}


function _reimpresionticket(IDJugada)
{

        http_request = false;
		  // alert (IDJugada);
		   Serial=getCookie('ticket_j'+IDJugada);
		 

		 //   alert (Serial);
	       if (Serial!='*') {
		
		   $("printer").style.display=""; 
		 //  $("printer").title="";
		   var element =  $("printer");
	
		  

		
		
		//*************************************************************************************
		
		new Ajax.Request("grabarjugada.php?tipo=1&Serial="+Serial,{
   		 method:'get',asynchronous:false,
    		onSuccess: function(transport){
    		var response = transport.responseText.evalJSON(true) ;
	
   		   if (response.eva==true)
		   {   
		   
		       element.innerHTML  = response.tk;
			   $("printer").title="true"; 
	          			   
		   }else {
			     $("printer").title="false"; 
				 $("printer").style.display="none"; 
				 alert('La Jornada en la cual pertence este ticket esta cerrada!'); 
		   }
		   
		   
 		   },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });
		//*************************************************************************************
		
			
		// alert ($("printer").title);
		 if ($("printer").title=="true") 
		 {
  	   	do{
	     		desci=confirm("Desea Imprimir el ticket?");
	 	 		if (desci==true){
			 		 print();
			  		}//if (desci==true)
			  	}while (desci==true)
		 }
	 }// if (serial!='null')
	 
	$("printer").style.display="none"; 
	
}

var http_request2 = false;
	
function ticketassig()
	{
	   nticket=getCookie('numerticke');	
	   
	   if (nticket=='*' || nticket==''){
		   
		  new Ajax.Request("ticket.php?tipo=1",{
   		 method:'get',	onSuccess: function(transport){
    		var response = transport.responseText.evalJSON(true) ;
			
			$('numet').title = response;
			$('numet').innerHTML = $('numet').title;
			
			setCookie('numerticke',	$('numet').title);
							   
 		   },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });
	
	  
	   }else
	   {   
	     new Ajax.Request("ticket.php?tipo=2",{
   		 method:'get',	onSuccess: function(transport){
            $('numet').title = nticket;
			$('numet').innerHTML = nticket;
		   }
			  });
		}
	 
}

function focoobj(obs,tipojug,idcn,ept)
{
       vec=$('carre_v').value.split("||");
	   e_c=vec[0];
	   crv=vec[1];
	   http_request = new XMLHttpRequest();	

	   http_request.open('GET', "jugadat2-1.php?tp="+tipojug+"&cr="+e_c+"&idcn="+idcn+"&ept="+ept+"&crv="+crv, true);
	   //alert('SI');
	    
	   http_request.onreadystatechange = function() {	

	  	  if (http_request.readyState == 4) {
		   if (http_request.status == 200) {
			 
		 	var arrInfo = http_request.responseText.split("||");	
			
          	if (eval(arrInfo[0])){	
			
			       if (ept==1) {
					  $('ejemp').title=arrInfo[1];
				      inib_tgame(1,arrInfo[1],arrInfo[2],1);
					}else{
				      inib_tgame(1,arrInfo[1],arrInfo[2],2);
					}	
		   	       
				   $(obs).focus();
	       	       $(obs).select();
		 	 }else{
				  alert('Esta carrera o tanda esta cerrada');
				  inib_tgame(0,'','',0);
		  	}
		  }
		  }
			
		  }
          http_request.send(null);
}



function inib_tgame(hb,cb,rt,est)
{
	
	if (hb==0) {
          $('ejem').disabled="disabled"; 
		  $('ejem').value=""; 
 		  $('valida').disabled="disabled";	
		  $('valida').value="";		 
		  $('idmonto').value=""; 
		  $('idmonto').disabled="disabled"; 
		  $('Total').value='';	
		  
		  for(var x=1;x<=parseInt($('carr').title); x++)
           {
		    for (var y=1;y<=14;y++)
		    {				
                 celda= $('celda'+x+''+y);
			     celda.style.backgroundColor="#999999";
				 celda.title='';
            }
			$('v'+x).value='';
		   }
		   
	}else{
		   
	      $('ejem').disabled=""; 
		  $('ejem').value=""; 
 		  $('valida').disabled="";	
		  $('valida').value="";		 
		  $('idmonto').value=""; 
		  $('idmonto').disabled="disabled"; 
		  $('Total').value='';	
		  
		  for(var x=1;x<=parseInt($('carr').title); x++)
           {
		    for (var y=1;y<=14;y++)
		    {
				
                 celda= $('celda'+x+''+y);
			     celda.style.backgroundColor="#999999";
				 celda.title='';
				
            }
			$('v'+x).value='';
		   }
		  if (est==1) {
		  var art = rt.split("-");	
		  for(var x=1;x<=parseInt($('carr').title); x++)
           {
		    for (var y=1;y<=parseInt($('ejemp').title);y++)
		    {
							
                 celda= $('celda'+x+''+y);				 
			     celda.style.backgroundColor="#26354A";
				 celda.title=y;
				  for (var i=0;i<=art.length;i++)
		         {
					  if (y==art[i]) {
					  celda.style.backgroundColor="#FF0000";
					  celda.title='';
					  }
				 }
				 			 
             } 
	
		   }
		}
	    if (est==2) {
			
		  var art = cb.split("-");	
		  for(var x=1;x<=parseInt($('carr').title); x++)
           {
		    for (var y=1;y<=art[x-1];y++)
		    {
							
                 celda= $('celda'+x+''+y);	
				 celda.style.backgroundColor="#26354A";
				 celda.title=y;
				 			 
             } 
	
		   }
			 
	    }	  
	}
	
}


var arraticket = new Array();

function eliminarticket()
{  
    listael='';
	for (i=0;i<=arraticket.length-1;i++)
	{  
	  if (arraticket[i]!='') {	
		listael=listael+arraticket[i]+"|";
	  }
	}	
	

	new Ajax.Request("ver_jugada-1-2.php?tk="+listael+"&idc="+$("con").title,{	
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


function incluirlista(oEvent)
{
	oEvent= oEvent || window.event;		  
	var txtfield = oEvent.target || oEvent.srcElement;
	
	c='im'+txtfield.title;
	a='f'+txtfield.title;
	if (txtfield.checked==true)
	{	
		$(c).src='media/accept.png';
	}else
	{
		$(c).src='media/estrella.png';
	}
	ex=true;
	if (arraticket.length!=0)
	{
		 
		for (t=0;t<=arraticket.length-1;t++)
		{    

			if (arraticket[t]==encodeURIComponent(txtfield.title)) {
			 ex=false;			 
			 arraticket.splice(t,1);
	
			}
		}
		
		if (ex==true) {
			if (txtfield.checked==true ){
			 arraticket[arraticket.length]=encodeURIComponent(txtfield.title);
	
			}else{
				if ($(a).title=='0') 
				{
					arraticket[arraticket.length]=encodeURIComponent(txtfield.title);
					
				}
				
			}
			
		}
	}else {

      	arraticket[0]=encodeURIComponent(txtfield.title);
	}	
}




function _reimpresiondl(Serial)
{
	// alert ('hola1');
if (Serial!='*') {
	var no;
	new Ajax.Request("grabarjugada.php?tipo=1&Serial="+Serial,{
   		 					method:'get',asynchronous:false	,onComplete: function(transport){
    						var response = transport.responseText.evalJSON(true) ;
	                        //  alert(response);
   		 					  if (response.eva==true)
		   						{  		     
			    					 $("printer").innerHTML = response.tk;	no=true;
								} else {
								   no=false;		
								   alert('La Jornada en la cual pertence este ticket esta cerrada!');
			   					}									 
								
							},
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); 							}
							});	   
	   if (no){		   
	 	do{
	     desci=confirm("Desea Imprimir el ticket?");
		 
	 	 if (desci==true){
			  print();
			  }//if (desci==true)
			  
		}while (desci==true);
		
	   }//if (no)
	   
	 }// if (serial!='null')
	$("printer").style.display="none"; 
}

function cambiarcelda(oEvent,ty,tx)
{
	oEvent= oEvent || window.event;		  
	var celda = oEvent.target || oEvent.srcElement;
	
	 if (celda.title!=''){
           if (celda.style.backgroundColor=='rgb(0, 102, 255)') 
		    {
		     celda.style.backgroundColor="#26354A";
		    }
		    else
		    {
		    celda.style.backgroundColor="#0066FF";
		    } // if (celda.style.backgroundColor=='rgb(102, 255, 51)')
		   }//if (celda.title!='#999999')
		  calcular(tx,ty);
		  $('valida').value='';
		  $('valida').focus();
	      $('valida').select();
}
var evento=false;
function activarmonitor(idcn)
{
	if ($('button').lang=='1')
	{    
	if ($('monto').value!=0){
	     $('button').value='Detener';$('button').lang='0';$('monto').disabled="disabled"; $('img').style.display='';
		 activarre_sph(1,$('monto').value,idcn);
	}else{
		alert('El Monto a Buscar debe ser Diferente de Cero!');
	}
	}else{
		activarre_sph(2,0,0);$('button').value='Buscar';$('button').lang='1';$('monto').disabled="";  $('img').style.display='none';
	}
}



function activarre_sph(op,monto,idcn)
{   
	if (op==1){
	evento=new Ajax.PeriodicalUpdater('', 'frestriccionessph.php?monto='+monto+'&idcn='+idcn+'&op=1', {
		method: 'get', decay: 2, onSuccess: 	
		function (transport){ 
		  var response = transport.responseText.evalJSON(true) ;	

		  if (response[0])
		  {
		 	jugadarepetida=response[2].split('|');
			$('blq').lang=response[2];
			for (i=1;i<=jugadarepetida.length-1;i++)
			{
				$('v'+i).innerHTML=jugadarepetida[i];
				$('tv'+i).innerHTML=enletras(jugadarepetida[i]);
			}
			$('montoacum').value=response[1];
			tdt='';
			for (i=3;i<=response.length-1;i++)
			{
				tdt+=response[i]+'|';				
			}
			new Ajax.Request('listaserialesm.php?seriales='+tdt,{ method:'get',
    		onComplete: function(transport){
    		var response = transport.responseText;	
				$("ver").innerHTML = response;  
				 response.evalScripts();
 		   },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });	 

			
		  }
		}
		});
	}
  if (op==2){
	 if (evento!=false) { evento.stop(); }
  }
}


function enletras(valor)
{ 
  switch(parseInt(valor))
	  {
		  case 1:
		  r='Uno';break;
		  case 2:
		  r='Dos';break;
		  case 3:
		  r='Tres';break;
		  case 4:
		  r='Cuatro';break;
		  case 5:
		  r='Cinco';break;
		  case 6:
		  r='Seis';break;
		  case 7:
		  r='Siete';break;
		  case 8:
		  r='Ocho';break;
		  case 9:
		  r='Nueve';break;
		  case 10:
		  r='Diez';break;
		  case 11:
		  r='Once';break;
		  case 12:
		  r='Doce';break;
		  case 13:
		  r='Trece';break;
		  case 14:
		  r='Catorce';break;
	  }
	  return r
}

function abrirmonitor()

{	

     abrir('monitort4.php?tj=4&jnd='+$('jnd').title,'Monitor de Macuare',1,0,0,0,0,0,1,400,510,100,100,1);

	
}	

function blqjugada(idcn,idj)
{
	jugada=$('blq').lang;
	new Ajax.Request('frestriccionessph.php?op=3&jugada='+jugada+'&idcn='+idcn+'&idj='+idj,{ method:'get',
    		onComplete: function(transport){
    		var response = transport.responseText.evalJSON(true) ;	
				if (response)
				{
					$('blq').src="media/lock.png";
					activarre_sph(2,0,0);$('button').value='Buscar';$('button').lang='1';$('monto').disabled="";  $('img').style.display='none';
				}else{
					$('blq').src="media/unlock.png";
				}
 		   },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });	 

}


function cargarcampos_v13()
{
	       Calendar.setup({
               inputField     :    "fc", 
               ifFormat       :    "%e/%m/%y",
               align          :    "Tl",
               singleClick    :    true,
			   onUpdate       :    catcalc_v13
             });

		   

}

function catcalc_v13(cal) {
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
	jsonvalores_v13(field.value);	 	 

}

function jsonvalores_v13(oEvent)
	{	

	

		 new Ajax.Request("cfngdeportes-1.php?fc1="+oEvent,{
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

function grabarejemplares(nc,idcn)
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


		 new Ajax.Request("cfngdeportes-2.php?IDCN="+idcn+'&LNE='+ldv,{
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
	
	
function grabartablas(nc,idcn)
	{	
	  ldv='';ldc='';
	  for (i=1;i<=nc;i++)
	  {
		ldv+=i+'*';   
		for (j=1;j<=parseInt($('ne'+i).lang);j++)
		{
			if (isset('eje'+i+j)) {
				ldv+=parseInt($('eje'+i+j).value)+'|'; 
			}else {
				ldv+='0|'; 
			}
		}
		ldc+=$('estatus'+i).lang+'|';
		ldv+='*';
	  }
		 new Ajax.Request("configuraciontablas-2.php?op=1&IDCN="+idcn+'&LNE='+ldv+'&LNC='+ldc,{
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
	
function click_mensaje_tabla(idun,idcn)
{
   
	if ($('esta1'+idun).style.display=='none')
	{
		$('esta2'+idun).style.display='none';
		$('esta1'+idun).style.display=''
		$('estatus'+idun).lang='0';
		estatus=0;
	}else{
		$('esta2'+idun).style.display='';
		$('esta1'+idun).style.display='none';
		$('estatus'+idun).lang='1';
		estatus=1;
	}

	 new Ajax.Request("configuraciontablas-2.php?op=2&IDCN="+idcn+'&carr='+idun+'&estatus='+estatus,{
   		 method:'get',
    		onComplete: function(transport){
    		var response = transport.responseText.evalJSON(true) ;	
			 if (response==true)
			 {
				  $("resultado").innerHTML = 'Actualizado';
			 }else{
				   $("resultado").innerHTML = 'Error al realizar la actulizacion!';
			 }
			 				
 		   },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });	

}

function cargarcampos_v14()
{
	       Calendar.setup({
               inputField     :    "fc", 
               ifFormat       :    "%e/%m/%y",
               align          :    "Tl",
               singleClick    :    true,
			   onUpdate       :    catcalc_v14
             });

		   

}

function catcalc_v14(cal) {
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
	jsonvalores_v14(field.value);	 	 

}

function jsonvalores_v14(oEvent)
	{	

	

		 new Ajax.Request("configuraciontablas-1.php?fc1="+oEvent,{
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

function sumadelticket()
{
	tde=$('ne').lang;
	total=0;
	for (i=1;i<=tde;i++)
	{
		if (isset('ap'+i))
		{
			total+=parseInt($('ap'+i).value);
		}
	}
	$('Total').value=total;
	$('totalver').innerHTML=total;
}


function imprimirtabla()
{
		 IDCN=$('jnd').title;
		 idc=$('con').title;
         IDJugada=$('tj').title;	
		 carr=$('carrera').lang;
		 new Ajax.Request("sumatablatotal.php?op=3&IDCN="+IDCN+"&idc="+idc+'&idj='+IDJugada+"&carr="+carr,{
   		 method:'get',asynchronous:false,
    		onComplete: function(transport){
    		var response = transport.responseText.evalJSON(true) ;	
			
		   if (response==false){			   
			$('esta2').style.display='none';
			$('esta1').style.display='';
			$('botonimp').style.display='none';
		   }
		   
 		   },	
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });
	
	yag=false;  
	tde=$('ne').lang;
	total=0;
	procesar=false;
	cierre=true;
	for (i=1;i<=tde;i++)
	{
		if (isset('ap'+i))
		{
			if(parseInt($('ap'+i).value)!=0) {procesar=true; break;}
		}
	}
	if ($('esta2').style.display=='none') { cierre=false; }
	
	if (procesar && cierre){
	do{
		desci=confirm("Desea Imprimir el ticket?");			
	 	if (desci==true){
			 yag=true;
	     	 v=x_grabargame(5);
			 if (v==true){	 print(); alert('Ticket Impreso');	} else { v=true; }
			 desci=false;	
			 
		 } 
	
		}while (desci==true);
	
		
		if (v==true){	
		  Serial=$('numet').title;
		  IDJugada=$('tj').title;
	      setCookie('ticket_j'+	IDJugada,	Serial);
	     }
		 
		 $("printer").style.display="none";
		
		if (yag==true){
		 in_tgame(5,true);	
		 subtotaldetablas();
		 conteodetablas();
		 if (v==1500){
			alert('ATENCION:  !No tengo Comunicacion con El Servidor el ticket! \n NO SE ALMACENO');
			$("tablemenu").innerHTML='';
		 }
		}
	}else{
		if (procesar==false) {alert('Lo Siento no hay apuestas realizadas en el Ticket!');}
		if (cierre==false) {alert('Lo Siento la Carrera se encuentra Cerrada!');}
	}
	 }
	 
function subtotaldetablas()
	{	

		 IDCN=$('jnd').title;
		 idc=$('con').title;
         IDJugada=$('tj').title;	
		 carr=$('carrera').lang;
		 new Ajax.Request("sumatablatotal.php?op=1&IDCN="+IDCN+"&idc="+idc+'&idj='+IDJugada+"&carr="+carr,{
   		 method:'get',
    		onComplete: function(transport){
    		var response = transport.responseText.evalJSON(true) ;	
			$("totalgeneral").innerHTML = response;  
 		   },	
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });	

	}
	
function conteodetablas()
	{	

		 IDCN=$('jnd').title;
		 idc=$('con').title;
         IDJugada=$('tj').title;	
		 carr=$('carrera').lang;
		 
		 new Ajax.Request("sumatablatotal.php?op=2&IDCN="+IDCN+"&idc="+idc+'&idj='+IDJugada+"&carr="+carr,{
   		 method:'get',
    		onComplete: function(transport){
    		var response = transport.responseText.evalJSON(true) ;	

			
			for (iii=1;iii<=response.length-1;iii++)
			{
				
					if (isset("la"+iii))
					{
					 $("la"+iii).innerHTML=response[iii];
					}
			}
			
 		   },	
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });	

	}	
	
function permitetablas(elEvento, permitidos,fila)
{

 cuantosquedan=parseInt($('la'+fila).innerHTML);
 anexoretorno=true;valoresteclas=true;
 if ($('la'+fila).innerHTML=='')
 {
	alert('Lo Siento No tiene Configurado la Cantidad de Tablas a Vender!');
	anexoretorno=false;
 }else{
 	if (cuantosquedan<=0)
	 {
		 alert('Lo Siento no tiene tablas para vender');
		 anexoretorno=false;
	 }else{
	 	valoresteclas=permite(elEvento, permitidos);
	 }
 }
	
 return (anexoretorno && valoresteclas);

}	
/////////////////////////////////////////////////////////////////////////////////////
var funcionNew1;
function refresDBest(){	
	funcionNew1 = setInterval("refresDBest2()", 60000);
}
var mygridVar=new Array();
var validos=new Array();
function refresDBest2(){
	 new Ajax.Request('sh.php',{
   		 method:'get',
    		onComplete: function(transport){
    		  var response = transport.responseText.evalJSON(true) ;	
			   if ( response ){
				for (l=0;l<= validos.length-1;l++){  
					mygridVar[l].clearAll();
					mygridVar[l].loadXML("skynetDB-1.php?liga="+validos[l]);
				}
				
			   }
 		   },	
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });	

	
}
///////////////////////////////////////////////////////////////////////////////