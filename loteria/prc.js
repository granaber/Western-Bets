// JavaScript Document
var dhxWins1=0;
var dhxWins2=0;
var dhxWins3=0;
var dhxWins10=0;
var mygrid=0;
var nticket=0;
var mygridv=0;
var filaventas=0;
var mygridAdicc=0;
var layout1=0;
var dhxLayout=0;
var menu;
var iduser=0;
var mygridchg=0;
var serialSeleccion=0;
var selectRowId=0;
var idgeneral=0;
var z=0;
var mCal;
var bar;
var fecha;
var ejecutor;
var mygrid2;
var dhxWins4;
var opciCal;
var barWin;
var mygridchgWin;
var SeleccionIDLot;
var SeleccionIDAdd;
var	mygridchg;
var mygridchg2;
var SeleccionIDLotD;
var serialElectronico=0;
var timerID;
var vIDJ;
var cal1,cal2,mCal,mDCal,newStyleSheet;
var dateFrom;
var dateTo;
var valorS;
function makeResultwin(scr,obj)	
	{	
		new Ajax.Request(scr,{method:'post',	onComplete: function(transport){
									var response = transport.responseText ;	
										$(obj).innerHTML=response;
										response.evalScripts();	
								},onCreate: function(){    		
									$(obj).innerHTML  = '<img src="media/ajax-loader.gif" />';
								},
	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
	
								});	
}
function makeResultwinNow(scr,obj)	
	{	
		new Ajax.Request(scr,{method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText ;	
										$(obj).innerHTML=response;
										response.evalScripts();	
								},onCreate: function(){    		
									$(obj).innerHTML  = '<img src="media/ajax-loader.gif" />';
								},
	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
	
								});	
}
function createByxml_Loteria(_file,_sql,_campos) 
{
 new Ajax.Request('xmlcreater_loteria.php',{ parameters: { file:_file,sql:_sql,campos:_campos },	method:'get',asynchronous:false,	
				               onComplete: function(transport){
									var response = transport.responseText ;	
								},	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
								});	
}
function createByxml_Loteria_Premiacion(_file,_sql,_campos) 
{
 new Ajax.Request('xmlcreater_premiacion.php',{ parameters: { file:_file,sql:_sql,campos:_campos,idj:$('IDJ').lang,fecha:fecha },	method:'get',asynchronous:false,	
				               onComplete: function(transport){
									var response = transport.responseText ;	
								},	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
								});	
}


function createByxml(_file,_sql,_campos) 
{
 new Ajax.Request('xmlcreater.php',{ parameters: { file:_file,sql:_sql,campos:_campos },	method:'get',asynchronous:false,	
				               onComplete: function(transport){
									var response = transport.responseText ;	
								},	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
								});	
}

function createByxmlTree(_file,_sql1,_sql2,_Clave,_campos,_prin,_Ide) 
{
 new Ajax.Request('xmlcreatertree.php',{ parameters: { file:_file,sql1:_sql1,sql2:_sql2,campos:_campos,principal:_prin,Indice:_Ide,Clave:_Clave },	method:'get',asynchronous:false,	
				               onComplete: function(transport){
									var response = transport.responseText ;	
								},	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }	
								});	
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

/******************************** Open Windows New ******************************/
function abrir(direccion,nombreventana, pantallacompleta, herramientas, direcciones, estado, barramenu, barrascroll, cambiatamano, ancho, alto, izquierda, arriba, sustituir){
		var opciones = "fullscreen=" + pantallacompleta +
					 ",toolbar=" + herramientas +
					 ",location=" + direcciones +
					 ",status=" + estado +
					 ",menubar=" + barramenu +
					 ",scrollbars=" + barrascroll +
					 ",resizable=" + cambiatamano +
					 ",width=" + ancho +
					 ",height=" + alto +
					 ",left=" + izquierda +
					 ",top=" + arriba;

var ventana = window.open(direccion,nombreventana,opciones,sustituir);
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
function refrecargrid(file,sql,lista){
	 createByxml(file,sql,lista);
	
	 mygrid.clearAll();
	 mygrid.loadXML(file);
}

function refrecargridPHP(file){
	 mygrid.clearAll();
	 mygrid.loadXML(file);
}
function uploadFile2(obj) {
	$('fromiut').submit();
	var a=$(obj).value; 
	a1=a.split(String.fromCharCode(92));
	extension=a1[a1.length-1].split('.');
 //   alert(obj);alert(a1);
	if (extension[1]=='png' || extension[1]=='PNG' || extension[1]=='GIF' || extension[1]=='gif') {
		$(obj).lang=a1[a1.length-1];
		$('imgver').src= 'images/logo/'+a1[a1.length-1];
	} else {
		$(obj).value=''; 
		alert('SOLAMENTE SE ACEPTAN LOGOS CON EXTENSION PNG O GIF!');
	}
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
//////////// Isset //////////////
function isset(Object1) { 
	 return ($(Object1)!=null);
  }
  
  
function horaactual(obj1,obj2)
{	
	
	new Ajax.Request('proc_php.php?op=1', {
		method: 'get', onComplete: 		
		function (transport){	   
		 var response = transport.responseText.evalJSON(true);	
		    $(obj1).value=response[0];   $(obj2).value=response[1];        
		},
 		  	onFailure: function(){  $(obj1).value='NO HAY COMUNICACION';  $(obj2).value='NO HAY COMUNICACION';}
			
	});
	
	
}

function horaestablecer(obj1,obj2)
{
	tiempo=1000;
	timerID = setInterval("horaactual('"+obj1+"','"+obj2+"')", tiempo);
}  
function stop_func(){	clearInterval(timerID); }
function handleEnter (newFocus, oevent) {
			var keyCode = oevent.keyCode ? oevent.keyCode : oevent.which ? oevent.which : oevent.charCode;
			if (keyCode == 13){
			    $(newFocus).focus();
				return true;
			}
	
		}  
		
function CambioTriple_a_Terminal()
{

	$('CambioTriple_a_Terminal').disabled="disabled";
	MaximaLinea=mygridv.getRowsNum()-1;
	for (iy=0;iy<=MaximaLinea;iy++){
	 numero=mygridv.cells2(iy, 1).getValue();
	 if (numero.length==3){
		 numeros=numero.split("");
		 if (mygridv.cells2(iy, 6).getValue()==0)
		    IdAdd=1;
		 else
		 	IdAdd=mygridv.cells2(iy, 6).getValue();
			
		 MakeTicket_Idd(numeros[1]+numeros[2],mygridv.cells2(iy, 5).getValue(),mygridv.cells2(iy, 3).getValue(),IdAdd)
		
	 }
	}
	$('CambioTriple_a_Terminal').disabled="";
}

//////////////////////////////////////////////////////////////////
function CambioTriple_a_Punta()
{	   
    $('CambioTriple_a_Punta').disabled="disabled";
	MaximaLinea=mygridv.getRowsNum()-1;
	for (iy=0;iy<=MaximaLinea;iy++){
	 numero=mygridv.cells2(iy, 1).getValue();
	 if (numero.length==3){
		 numeros=numero.split("");
		 if (mygridv.cells2(iy, 6).getValue()==0)
		    IdAdd=1;
		 else
		 	IdAdd=mygridv.cells2(iy, 6).getValue();
			
		 MakeTicket_Idd(numeros[0]+numeros[1],mygridv.cells2(iy, 5).getValue(),mygridv.cells2(iy, 3).getValue(),IdAdd)
		
	 }
	}
	  $('CambioTriple_a_Punta').disabled="";
}
//////////////////////////////////////////////////////////////////
function CambioTripletazo_a_Terminalazo()
{	   
    $('CambioTripletazo_a_Terminalazo').disabled="disabled";
	MaximaLinea=mygridv.getRowsNum()-1;
	for (iy=0;iy<=MaximaLinea;iy++){
	 numero=mygridv.cells2(iy, 1).getValue();
	 if (numero.length==3 && mygridv.cells2(iy, 6).getValue()!=0 ){
		 numeros=numero.split("");
		 IdAdd=mygridv.cells2(iy, 6).getValue();
		 MakeTicket_Idd(numeros[1]+numeros[2],mygridv.cells2(iy, 5).getValue(),mygridv.cells2(iy, 3).getValue(),IdAdd)
	 }
	}
	  $('CambioTripletazo_a_Terminalazo').disabled="";
}
///////////// ** Procedimiento para la Ventas ** ////////////////

function MakeTicket(numero){
for (ii=0;ii<=mygrid.getRowsNum()-1;ii++)
	   { 

		if (mygrid.cellByIndex(ii, 1).getValue()	== 1)
			{  
			  if ($('Cng').lang==2){ monto=$('MontoA').value/1000; }else{monto=$('MontoA').value;}
		       
			   if ( mygrid.cellByIndex(ii,6).getValue() == 1){
				existe=getNum(numero,mygrid.cellByIndex(ii, 4).getValue(),0);

				if (existe==-1){
				  
					mygridv.addRow(filaventas,'0,'+numero+','+mygrid.cellByIndex(ii, 5).getValue()+','+monto+',,'+mygrid.cellByIndex(ii, 4).getValue()+',0');
				    
					filaventas++;
				   
				}else{
					if (parseFloat(monto)<0) {
						if ( ( parseFloat(monto)*-1 ) <= parseFloat(mygridv.cellByIndex(existe, 3).getValue()) ){
							mygridv.cellByIndex(existe, 3).setValue(parseFloat(mygridv.cellByIndex(existe, 3).getValue())+parseFloat(monto));
						    if (parseFloat(mygridv.cellByIndex(existe, 3).getValue())==0) 
		 				      mygridv.deleteRow(existe);
						   }
					  }else
						mygridv.cellByIndex(existe, 3).setValue(parseFloat(mygridv.cellByIndex(existe, 3).getValue())+parseFloat(monto));	
				}
				
			   }else{ // <-- En caso de una Adicional Se Establece otro procedimiento
			        marcados=0;
				  	for (iy=0;iy<=mygridAdicc.getRowsNum()-1;iy++)  ///<-- Grid de Adicional
	   				{  
					if (mygridAdicc.cells(iy, 1).getValue()	== 1)  {
						marcados++; 
						existe=getNum(numero,mygrid.cellByIndex(ii, 4).getValue(),mygridAdicc.cells(iy, 2).getValue());
       
					if (existe==-1){
				  
						mygridv.addRow(filaventas,'0,'+numero+','+mygrid.cellByIndex(ii, 5).getValue()+','+monto+','+mygridAdicc.cells(iy, 0).getValue()+','+mygrid.cellByIndex(ii, 4).getValue()+','+mygridAdicc.cells(iy, 2).getValue());
				    
						filaventas++;
				   
					}else{
						if (parseFloat(monto)<0) {
							if ( ( parseFloat(monto)*-1 ) <= parseFloat(mygridv.cellByIndex(existe, 3).getValue()) ){
								mygridv.cellByIndex(existe, 3).setValue(parseFloat(mygridv.cellByIndex(existe, 3).getValue())+parseFloat(monto));
						  	  if (parseFloat(mygridv.cellByIndex(existe, 3).getValue())==0) 
		 				     	 mygridv.deleteRow(existe);
						   	}
					  	}else
							mygridv.cellByIndex(existe, 3).setValue(parseFloat(mygridv.cellByIndex(existe, 3).getValue())+parseFloat(monto));	
					}//if (existe==-1)
					} // if (mygridAdicc.cells(iy, 1).getValue()	== 1)
					}// Fin de for Adicional
					//  *************************************************************
					if (marcados==0){ 
					alert('Disculpe pero Falta Informacion!\nHa Seleccionado una Loteria con Adicional\nPero no lo ha Marcado'); 	$('Numero').focus();}
			   }
			}		
     	} 		
}
function Add_Venta(_tipo){

	switch(_tipo){	
	case 1:
	case 2:
	    Svalor=$('Numero').value;	
		desicion=(!isNaN(parseInt($('Numero').value)) && ( Svalor.length>=2 && Svalor.length<=3  ));
		break;
	case 3:
		desde=$('desde').value;	hasta=$('hasta').value;	
	    desicion=(!isNaN(parseInt($('desde').value)) && !isNaN(parseInt($('hasta').value)) && ( desde.length>=2 && desde.length<=3  )  && ( hasta.length>=2 && hasta.length<=3  ));
	 case 4:
	    Svalor=$('Numero').value;	
		desicion=(!isNaN(parseInt($('Numero').value)) && ( Svalor.length>=2 && Svalor.length<=3  ));
		break;
		
	}

if (parseFloat($('MontoA').value)!=0 && !isNaN(parseFloat($('MontoA').value )) && desicion  ){
	switch(_tipo){	
 	case 1: //<-Opcion Normal 
	    MakeTicket($('Numero').value);	$('Numero').focus(); 
		break;
	case 2: //<-Opcion Permuta
	    cantidad=(Svalor.length);
		numeros=Svalor.split("");
		permuta=new Array;
		var i=0;
		if (cantidad==3){
		permuta[i]=numeros[0]+numeros[1]+numeros[2]; i++; 
		permuta[i]=numeros[0]+numeros[2]+numeros[1]; i++;
		permuta[i]=numeros[2]+numeros[0]+numeros[1]; i++;
		permuta[i]=numeros[2]+numeros[1]+numeros[0]; i++;
		permuta[i]=numeros[1]+numeros[2]+numeros[0]; i++;
		permuta[i]=numeros[1]+numeros[0]+numeros[2]; i++;
		
		}else{
		permuta[i]=numeros[0]+numeros[1]; i++; 
		permuta[i]=numeros[1]+numeros[0]; i++;	
		
		}
		
		for (i=0;i<=permuta.length-1;i++){
			for (x=i+1;x<=length-1;x++){
				 if (permuta[i]==permuta[x]) permuta.splice(x,1); 
				}	
		}
		  
		for (x=0;x<=permuta.length-1;x++)	   
		MakeTicket(permuta[x]);
		
		$('Numero').focus();
 
		break;	
		
	   case 3:
	
		var i=0;
		if (desde>=hasta){temp= desde; desde=hasta; hasta=temp;}
		
		for (x=desde;x<=hasta;x++){
				MakeTicket(x);
				}	
	   case 4:// <== Opcion Series
	    cantidad=(Svalor.length);
		numeros=Svalor.split("");
		series=new Array;
		series[0]='ne';
		for (i=0;i<=9;i++){
			if (numeros[0]==0)
				series[i]=i+numeros[1]+numeros[2];
			if (numeros[2]==0)
				series[i]=numeros[0]+numeros[1]+i;
			
		}	
		if (series[0]!='ne'){
			for (x=0;x<=9;x++)
					MakeTicket(series[x]);
		}else{
			alert('Lo siento pero debe Agregar un cero(0) al final o al comienzo del Numero para hacer la Serie!');	
		}
	    break;
	}
	sumarticket();
	$('Numero').value='';$('desde').value='';$('hasta').value='';
	$('MontoA').value='';
	$('Numero').focus();
	
}else{
	alert('Disculpe pero Falta Informacion (NUMERO o MONTO!)');	
	$('Numero').focus();
	$('Numero').select();
}
}

function factorial (n)
{ if (n == 0)
   return 1;
  else
   return n * factorial(n-1);
}

function getNum(NumeroSearch,lotery,Adicional){
	ixf=-1; 

	for (ix=0;ix<=mygridv.getRowsNum()-1;ix++)
	  { 
	     if (Adicional==0){ 
		   if (mygridv.cells2(ix, 1).getValue()	== NumeroSearch && mygridv.cells2(ix, 5).getValue()	== lotery  )
			{  
			   ixf=ix;
			   break;
			}
		  }else{
			 if (mygridv.cells2(ix, 1).getValue()	== NumeroSearch && mygridv.cells2(ix, 5).getValue()	== lotery  && mygridv.cells2(ix, 6).getValue() == Adicional )
			 	{  
			  	 ixf=ix;
			  	 break;
				}
		 }
     }
  
	 return ixf;	
}
function sumarticket(){
	suma=0;	
	for (ix=0;ix<=mygridv.getRowsNum()-1;ix++)
	 suma=suma+parseFloat(mygridv.cells2(ix, 3).getValue());
	$('Total_Ticket').value=redond(parseFloat(suma),2);	
}
function redond(num, ndec) {
	  var fact = Math.pow(10, ndec); 
	  return Math.round(num * fact) / fact;
}  
function grabarjugada(_idc)
{
		dhxWins1.window("w1").progressOn();
		//_jugada=new Array();
		_jugada='';
		_onlyLotery='';
		for(var i=0; i<=mygridv.getRowsNum()-1 ;i++)
		{
			_jugada	=_jugada+mygridv.cells2(i, 1).getValue()+'|'+mygridv.cells2(i, 5).getValue()+'|'+mygridv.cells2(i, 6).getValue()+'|'+mygridv.cells2(i, 3).getValue()+',';
		}
		for(var i=0; i<=mygrid.getRowsNum()-1 ;i++)
		{
			_onlyLotery=_onlyLotery+mygrid.cells2(i, 4).getValue()+',';
		}
	   /// _Debo Chequear si las Loteria esta Cerradas y los Topes de Los Numeros /// 
	   var hayerror=false;
	   var arraydeerror=new Array();
	   var TopesdeNumeros=new Array();
	   	new Ajax.Request('operaLotery.php',{ parameters: { op:2,IDLots:_onlyLotery,Jugada:_jugada},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);	
									for (ii=0;ii<=response.length-1;ii++){
										if (response[ii]==0)
										{
											hayerror=true;
											arraydeerror=response;
											break;
										}
									}
		},
 		  	onFailure: function(){ alert('NO TENGO COMUNICACION CON EL SERVIDOR'); }
			
		});
		/// Chequeo si paso el primer chequeo
		//if (!hayerror){
			new Ajax.Request('operaLotery.php',{ parameters: { op:4,Jugada:_jugada,IDCtt:_idc,IDJ:$('IDJ').lang},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);	
	
										for (ii=0;ii<=response.length-1;ii++){
											disgr=response[ii].split('|');
										
											if (!(disgr[0]=='true'))
											{
											hayerror=true;
											TopesdeNumeros=response;
											break;
											}
										}
									
		},
 		  	onFailure: function(){ alert('NO TENGO COMUNICACION CON EL SERVIDOR'); }
			
		});	
		//}
	   
	   //////////////////////////////////////////////////////////////////////////
	   
	   if  (!hayerror){
	
		new Ajax.Request('grabarjugada.php',{ parameters: {Jugada:_jugada, serial: 1,idj:$('IDJ').lang,monto:$('Total_Ticket').value,IDCtt:_idc,IDLots:_onlyLotery}, 
			method: 'post',asynchronous:false, onComplete: 		
			function (transport){	   
			 var response = transport.responseText.evalJSON(true);
	
           	 if  (response[0])  {
		   	 Imprimir_Ticket(response[1],response[2],response[3],response[4],true,'printer',$('Total_Ticket').value,response[5]  ,true,0,$('Agencia').innerHTML,false,0);
		  		dhxWins1.window("w1").progressOff();
				inicializar_form();
			  }else{
				hayerror=true;
				arraydeerror=response[2].split(',');
				TopesdeNumeros=response[1].split(',');
							  }
			},
 		  	onFailure: function(){ alert('NO TENGO COMUNICACION CON EL SERVIDOR'); }
			
			});
	     //  alert(arraydeerror)
			 if  (hayerror)		
			 	VerOBservaciones(arraydeerror,_jugada,TopesdeNumeros);
			 
			 $('Numero').focus();
	   }else
		   VerOBservaciones(arraydeerror,_jugada,TopesdeNumeros);
		   
	   
	
	
}
function Imprimir_Ticket(_Fecha,se,_Lista_Jugada,_Hora,_imprimir,_obj,_MontoTotal,_serial,_piePg,_AwsActivo,_AgenciaTXT,_FormatoPremio,_sumapremio)
{
 var aleatorio = Math.floor(Math.random()*11);
 var listadecodigo=listadecodigoAleatorio(aleatorio);
 var listadecodigoImp=listadecodigo.split(',');
 
 a=''; 
 a=a+'<table width="320" border="0" cellspacing="0" cellpadding="0"> <tr>    <td colspan="3" align="center">Venta de Loterias</td> </tr>';
 anexo='';
 switch (_AwsActivo)
 {
	 case 1:
	 	a=a+'<tr><td colspan="3">ANULADO**ANULADO**ANULADO**ANULADO</td></tr>';anexo='ANULADO';
		break;
	 case 2:
	 	a=a+'<tr><td colspan="3">COPIA**COPIA**COPIA**COPIA</td></tr>';anexo='***COPIA***';
		break;
		
 }
 a=a+'<tr><td width="103">Agencia:</td><td colspan="2">'+_AgenciaTXT+'</td></tr>';
 a=a+'<tr><td>Fecha:</td><td colspan="2">'+_Fecha+'</td><td>&nbsp;</td></tr>';
 a=a+'<tr><td>Hora:</td><td colspan="2">'+_Hora+'</td><td>&nbsp;</td></tr>';
 a=a+'<tr><td colspan="3">Serial:'+_serial+' '+anexo+'</td></tr>';
 primeraLoteria=0;totallineas=0;
 Verlista=_Lista_Jugada.split('*');

 	for (i=0;i<=Verlista.length-2;i++){
	Verlista2	= Verlista[i].split('|');
	 if (primeraLoteria!=Verlista2[0]){  
	 	primeraLoteria=Verlista2[0];
	 	 a=a+'<tr> <td colspan="3" align="center">== Sorteo:'+Verlista2[0]+' ==</td> </tr>';
	 }
		//alert(_FormatoPremio); alert(Verlista2[4]); 
	    if (_FormatoPremio)
		 a=a+'<tr> <td align="right">'+Verlista2[3]+'</td><td width="20">x'+Verlista2[2]+'</td><td align="left">-'+Verlista2[1]+' (P) '+Verlista2[4]+'</td></tr>';
		else
		  if ( (Verlista2.length-1)==4 )
			if (Verlista2[4]=='0')
		 		a=a+'<tr> <td align="right">'+Verlista2[3]+'</td><td width="20">x'+Verlista2[2]+'</td><td align="left">-'+Verlista2[1]+'</td></tr>';	
		 	else
				 a=a+'<tr> <td align="right">'+Verlista2[3]+'</td><td width="20">x'+Verlista2[2]+'</td><td align="left">-'+Verlista2[1]+' (P) '+Verlista2[4]+'</td></tr>';
		  else
		  	 a=a+'<tr> <td align="right">'+Verlista2[3]+'</td><td width="20">x'+Verlista2[2]+'</td><td align="left">-'+Verlista2[1]+'</td></tr>';	

	
		 totallineas++;
 	}
 a=a+'<tr><td colspan="3" align="center">-----------------------------</td></tr>';	
 a=a+'<tr><td colspan="3" align="left">Total Bsf.:'+_MontoTotal+'</td></tr>';
 a=a+'<tr><td colspan="3" align="center">-----------------------------</td></tr>';
 switch (_AwsActivo)
 {
	 case 1:
	 	a=a+'<tr><td colspan="3">ANULADO**ANULADO**ANULADO**ANULADO</td></tr>';
		break;
	 case 2:
	 	a=a+'<tr><td colspan="3">COPIA**COPIA**COPIA**COPIA</td></tr>';
		break;
		
 } 
if (_FormatoPremio)
 a=a+'<tr><td colspan="3" align="left">Total Premio Bsf.'+_sumapremio+'</td></tr>';
if (_piePg){ 
 a=a+'<tr><td colspan="3" align="center">'+se+'-L'+totallineas+'</td></tr>';
 a=a+'<tr><td colspan="3" align="center">'+listadecodigoImp[0]+listadecodigoImp[2]+' '+listadecodigoImp[9]+' '+listadecodigoImp[3]+listadecodigoImp[1]+'</td></tr>';
 a=a+'<tr><td colspan="3" align="center">'+listadecodigoImp[4]+listadecodigoImp[6]+' '+listadecodigoImp[10]+' '+listadecodigoImp[7]+listadecodigoImp[5]+'</td></tr>';
 for (i=0;i<=3;i++)  a=a+'<tr><td colspan="3" align="center">'+listadecodigoImp[11]+listadecodigoImp[8]+' '+listadecodigoImp[11]+'</td></tr>';

 for (i=0;i<=5;i++) a=a+'<tr><td colspan="3" align="center">*</td></tr>';
}
a=a+'</table>';
$(_obj).innerHTML=a;
if (_imprimir) print();
//alert('Ticket Impreso');
//$('printer').innerHTML='';

}

function listadecodigoAleatorio(codigo)
{
	switch (codigo)
	{
		case 0: valores='//,\\,***,***,//,\\,xx,xn,BUENA SUERTE,Verifique su Jugada,GRACIAS POR SU COMPRA,=='; break;
		case 1: valores='||,||,x**,*x*,||,||,^^,^+,Verifique su Jugada,BUENA SUERTE,GRACIAS,++'; break;
		case 2: valores='\\,//,xxx,xxx*,\\,//,^^,^^,BUENA SUERTE,Verifique su Ticket,Verifique su Ticket,--'; break;
		case 3: valores='//,\\,xxx,xxx,//,\\,==,==,GRACIAS POR SU COMPRA,Verifique su Ticket,BUENA SUERTE,**'; break;
		case 4: valores='**,**,///,\\\,//,\\,--,--,GRACIAS POR SU COMPRA,Verifique su Jugada,BUENA SUERTE,xx'; break;
		case 5: valores='//,\\,*z*,**z,//,\\,--,--,BUENA SUERTE,GRACIAS POR SU COMPRA,Verifique su Ticket,++'; break;
		case 6: valores='//,\\,xzx,*z*,//,\\,>>,<<,BUENA SUERTE,Verifique su Jugada,GRACIAS POR SU COMPRA,**'; break;
		case 7: valores='//,\\,***,***,||,||,xx,xn,BUENA SUERTE,Verifique su Jugada,GRACIAS POR SU COMPRA,++'; break;
		case 8: valores='<<,>>,*x*,xxx,//,\\,xx,xn,BUENA SUERTE,Verifique su Ticket,GRACIAS POR SU COMPRA,||'; break;
		case 9: valores='//,\\,*x*,**x,//,\\,xx,xn,BUENA SUERTE,Verifique su Jugada,GRACIAS POR SU COMPRA,++'; break;
		case 10: valores='//,\\,=x=,==x,\\,//,>>,<<,BUENA SUERTE,Verifique su Ticket,GRACIAS POR SU COMPRA,..'; break;
		case 11: valores='||,||,^**,*^*,//,\\,xx,xn,GRACIAS POR SU COMPRA,BUENA SUERTE,Verifique su Jugada,||'; break;		
		
	}
	return valores;
}
function Eliminar_Linea()
{
	for(var i=0; i<=mygridv.getRowsNum()-1;i++){
		   if ( mygridv.cells2(i,0).getValue() == 1)
			   mygridv.deleteRow(mygridv.getRowId(i));
		 
	}
	sumarticket()
}
function LimiarTicket()
{
    mygridv.clearAll();
	$('Total_Ticket').value=redond(0,2);
	inicializar_form();
}
//////////////////////////////////////////
function filterBy(){
			var tVal = $("title_flt").childNodes[0].value.toLowerCase();

			
			for(var i=0; i< mygridv.getRowsNum();i++){
				var tStr = mygridv.cells2(i,0).getValue().toString().toLowerCase();
				if((tVal=="" || tStr.indexOf(tVal)==0))
					mygridv.setRowHidden(mygridv.getRowId(i),false)
				else
					mygridv.setRowHidden(mygridv.getRowId(i),true)
			}
		}
		
/////////////////////////  Formato para Loteria Adicional 		
function cargar_formato(_formato)	{   /// <---- Para la Venta
	    mygridAdicc.clearAll();
		new Ajax.Request('proc_php.php?op=3&formato='+_formato, {
		method: 'get', onComplete: 		
		function (transport){	   
		 var response = transport.responseText.evalJSON(true);	

		   for (ii=0;ii<=response.length-1;ii++)
		   mygridAdicc.addRow(ii,response[ii]+',0,'+(ii+1));
		   
		
		   
		},
 		  	onFailure: function(){  $(obj1).value='NO HAY COMUNICACION';  $(obj2).value='NO HAY COMUNICACION';}
			
	});
	
	
}

function cargar_formato_Premacion(_formato)	{  //<-- Para la Premiacion!!

		new Ajax.Request('proc_php.php?op=3&formato='+_formato, {
		method: 'get', onComplete: 		
		function (transport){	   
		 var response = transport.responseText.evalJSON(true);	
		 
		
		   z = new dhtmlXCombo("Adicional", "alfa3", 80);		 

		   for (ii=0;ii<=response.length-1;ii++)
		   z.addOption([[ii+1, response[ii]]]);
		
		   
		},
 		  	onFailure: function(){  $(obj1).value='NO HAY COMUNICACION';  $(obj2).value='NO HAY COMUNICACION';}
			
	});
	
	
}
//////////////////////////////////////////////////////
function inicializar_form(){
	mygridv.clearAll();$('Total_Ticket').value=0;
	for(var i=0; i<=mygrid.getRowsNum()-1;i++)
		   mygrid.cells2(i,1).setValue(0);		   
	
	mygridAdicc.clearAll();layout1.cells("a").collapse();
	 $('secuencia').style.display='none';$('sprytextfield1').style.display=''; 
	 $('Txtliterial').innerHTML='Numero';
  	 $('Txtliterial').lang='1';
	 $('Txtliterial').style.textDecoration='';
}

function permutar()
{
 if ($('Txtliterial').lang=='1') {
 	 $('Txtliterial').innerHTML='Permuta';
  	 $('Txtliterial').lang='2';
	 $('Txtliterial').style.textDecoration='blink';
  }else{
	 $('Txtliterial').innerHTML='Numero';
  	 $('Txtliterial').lang='1';
	 $('Txtliterial').style.textDecoration='';  $('sprytextfield1').style.display=''; $('secuencia').style.display='none';
  }
  	$('Numero').focus();
  
}
function secuencia()
{
 if ($('Txtliterial').lang=='1') {
 	 $('Txtliterial').innerHTML='Secuencia';
  	 $('Txtliterial').lang='3';
	 $('Txtliterial').style.textDecoration='blink';
	 $('sprytextfield1').style.display='none'; $('secuencia').style.display='';
	 	$('desde').focus();
  }else{
	 $('Txtliterial').innerHTML='Numero';
  	 $('Txtliterial').lang='1';
	 $('Txtliterial').style.textDecoration='';
	  $('sprytextfield1').style.display=''; $('secuencia').style.display='none';
	  	$('Numero').focus();
  }
  
  
}
function Mseries()
{
 if ($('Txtliterial').lang=='1') {
 	 $('Txtliterial').innerHTML='Series';
  	 $('Txtliterial').lang='4';
	 $('Txtliterial').style.textDecoration='blink';
	 $('Numero').focus();
  }else{
	 $('Txtliterial').innerHTML='Numero';
  	 $('Txtliterial').lang='1';
	 $('Txtliterial').style.textDecoration='';
	 $('Numero').focus();
  }
  
  
}
function VerLoteria(Idlot)
{
	var respuesta=0;
new Ajax.Request('requestByid.php',{ parameters: { op:1,IDLot:Idlot},method:'get',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									respuesta	= response;
								},
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
	
								});	

return respuesta;
}

function VerAdicional(Idlot,IdAdd)
{
var respuesta=0;
new Ajax.Request('requestByid.php',{ parameters: { op:2,IDLot:Idlot,IdAdd:IdAdd},method:'get',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									respuesta	= response;
								},
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
	
								});	

return respuesta;
}
function MakeTicket_Idd(numero,Idlot,Monto,IdAdd){
 
		
			  if ($('Cng').lang==2){ monto=Monto/1000; }else{monto=Monto;}
		       
			   if ( IdAdd == 1){
				existe=getNum(numero,Idlot,0);

				if (existe==-1){
				
				    txtLoteria=VerLoteria(Idlot);
					mygridv.addRow(filaventas,'0,'+numero+','+txtLoteria+','+monto+',,'+Idlot+',0');
					filaventas++;
				   
				}else{
					if (parseFloat(monto)<0) {
						if ( ( parseFloat(monto)*-1 ) <= parseFloat(mygridv.cells2(existe, 3).getValue()) ){
							mygridv.cells2(existe, 3).setValue(parseFloat(mygridv.cells2(existe, 3).getValue())+parseFloat(monto));
						    if (parseFloat(mygridv.cells(existe, 3).getValue())==0) 
		 				      mygridv.deleteRow(existe);
						   }
					  }else
						mygridv.cells2(existe, 3).setValue(parseFloat(mygridv.cells2(existe, 3).getValue())+parseFloat(monto));	
				}
				
			   }else{ // <-- En caso de una Adicional Se Establece otro procedimiento
			      
						existe=getNum(numero,Idlot,IdAdd);
     
					if (existe==-1){
				         txtLoteria=VerAdicional(Idlot,IdAdd);
						mygridv.addRow(filaventas,'0,'+numero+','+txtLoteria[1]+','+monto+','+txtLoteria[0]+','+Idlot+','+IdAdd);
				    
						filaventas++;
				   
					}else{
						if (parseFloat(monto)<0) {
							if ( ( parseFloat(monto)*-1 ) <= parseFloat(mygridv.cells2(existe, 3).getValue()) ){
								mygridv.cells2(existe, 3).setValue(parseFloat(mygridv.cells2(existe, 3).getValue())+parseFloat(monto));
						  	  if (parseFloat(mygridv.cells(existe, 3).getValue())==0) 
		 				     	 mygridv.deleteRow(existe);
						   	}
					  	}else
							mygridv.cells2(existe, 3).setValue(parseFloat(mygridv.cells2(existe, 3).getValue())+parseFloat(monto));	
					}//if (existe==-1)
					
				
					//  *************************************************************
					
			   }
					
     	 		
}

////////////////// * ////////////////// * ////////////////// 

function clicktoolBartheChange(id){

	switch(id){
		case "Cerrar_":
					dhxWins3.window("w1").close();
					$('showprint').innerHTML='<div id="printerver" style="width: 100%; height: 100%; overflow: auto;display: none; font-family: Tahoma; font-size: 11px;">    <div id="printerver_2" style="margin: 3px 5px 3px 5px;"></div></div>';
					break;	
				
          }
	
}
function ChangeLotery()
{
	dhxWins3 = new dhtmlXWindows();	
	dhxWins3.setImagePath("codebase/imgs/");	
	w1 = dhxWins3.createWindow("w1",10, 80, 480, 400);
	w1.setText("Cambio de Loterias");
	dhxWins3.window("w1").setModal(true);
	dhxWins3.window("w1").centerOnScreen();
	dhxWins3.window("w1").denyResize();
	dhxWins3.window("w1").denyMove();
	//dhxWins1.setSkin("web");  
	
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.attachEvent("onClick", clicktoolBartheChange);
	
	dhxLayout = new dhtmlXLayoutObject(w1, "3W");	
	dhxLayout.cells("a").setText("Loterias Activas (TICKET)");dhxLayout.cells("a").setWidth(230);
	dhxLayout.cells("b").setText("Cambiar Por Loterias Activas");dhxLayout.cells("b").setWidth(150);
	dhxLayout.cells("c").setText("Adicionales");dhxLayout.cells("c").setWidth(100);dhxLayout.cells("c").collapse();
	
	mygridchg = dhxLayout.cells("a").attachGrid();
	mygridchg.setImagePath("codebase/imgs/");
	mygridchg.setHeader("Loteria,Adicionales,ID,IDAdd");
	mygridchg.setInitWidths("130,100")
	mygridchg.setColAlign("left,left")
	mygridchg.setColTypes("ro,ro,ro,ro");
	mygridchg.setSkin("dhx_skyblue");	
	mygridchg.attachEvent("onRowSelect",doSelectCHA);
	//mygridchg.setColumnColor("white,white");
	//mygridchg.enableMultiselect(true);
	mygridchg.init();
	Loterias=new Array(); Adicionales=new Array(); TextoAdicional=new Array();
	j=0;
	for (k=0;k<mygridv.getRowsNum();k++){
		 if ( !existeIDLOT( Loterias,mygridv.cells2(k, 5).getValue(),Adicionales,mygridv.cells2(k, 6).getValue() ) ){
		 	Loterias[j]=mygridv.cells2(k, 5).getValue();Adicionales[j]=mygridv.cells2(k,6).getValue();TextoAdicional[j]=mygridv.cells2(k,4).getValue();
			j++;
		 }
	}
	
	for (k=0;k<=Loterias.length-1;k++){
		mygridchg.addRow(k, ValorInLoteria(Loterias[k],2)+','+TextoAdicional[k]+','+Loterias[k]+','+Adicionales[k]);
	}
	
	mygridchg2 = dhxLayout.cells("b").attachGrid();
	mygridchg2.setImagePath("codebase/imgs/");
	mygridchg2.setHeader("Loteria,ID,IDAdd");
	mygridchg2.setInitWidths("300")
	mygridchg2.setColAlign("left")
	mygridchg2.setColTypes("ro,ro,ro");
	mygridchg2.setSkin("dhx_skyblue");
	mygridchg2.attachEvent("onRowSelect",doSelectAtoB);
	//mygridchg2.enableMultiselect(true);
	mygridchg2.init();
	
	for (k=0;k<=mygrid.getRowsNum()-1;k++){
		mygridchg2.addRow(k, mygrid.cellByIndex(k, 2).getValue()+','+mygrid.cellByIndex(k, 4).getValue()+','+mygrid.cellByIndex(k, 6).getValue());
	}	
	
	mygridchg3 = dhxLayout.cells("c").attachGrid();
	mygridchg3.setImagePath("codebase/imgs/");
	mygridchg3.setHeader("Signo,Sel,ID");
	mygridchg3.setInitWidths("100")
	mygridchg3.setColAlign("left")
	mygridchg3.setColTypes("ro,ro");
	mygridchg3.setSkin("dhx_skyblue");
	mygridchg3.attachEvent("onRowSelect",doSelectAtoB_Add);
	//mygridchg2.enableMultiselect(true);
	mygridchg3.init();

}

///////////////////////// Copiar a Otra Loteria ////////////////////////////////////
function CopyLotery()
{
	dhxWins3 = new dhtmlXWindows();	
	dhxWins3.setImagePath("codebase/imgs/");	
	w1 = dhxWins3.createWindow("w1",10, 80, 480, 400);
	w1.setText("Copiar a Loterias");
	dhxWins3.window("w1").setModal(true);
	dhxWins3.window("w1").centerOnScreen();
	dhxWins3.window("w1").denyResize();
	dhxWins3.window("w1").denyMove();
	//dhxWins1.setSkin("web");  
	
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.attachEvent("onClick", clicktoolBartheChange);
	
	dhxLayout = new dhtmlXLayoutObject(w1, "3W");	
	dhxLayout.cells("a").setText("Loterias Activas (TICKET)");dhxLayout.cells("a").setWidth(230);
	dhxLayout.cells("b").setText("Copiar Por Loterias Activas");dhxLayout.cells("b").setWidth(150);
	dhxLayout.cells("c").setText("Adicionales");dhxLayout.cells("c").setWidth(100);dhxLayout.cells("c").collapse();
	
	mygridchg = dhxLayout.cells("a").attachGrid();
	mygridchg.setImagePath("codebase/imgs/");
	mygridchg.setHeader("Loteria,Adicionales,ID,IDAdd");
	mygridchg.setInitWidths("130,100")
	mygridchg.setColAlign("left,left")
	mygridchg.setColTypes("ro,ro,ro,ro");
	mygridchg.setSkin("dhx_skyblue");	
	mygridchg.attachEvent("onRowSelect",doSelectCHA);
	//mygridchg.setColumnColor("white,white");
	//mygridchg.enableMultiselect(true);
	mygridchg.init();
	Loterias=new Array(); Adicionales=new Array(); TextoAdicional=new Array();
	j=0;
	for (k=0;k<mygridv.getRowsNum();k++){
		 if ( !existeIDLOT( Loterias,mygridv.cells2(k, 5).getValue(),Adicionales,mygridv.cells2(k, 6).getValue() ) ){
		 	Loterias[j]=mygridv.cells2(k, 5).getValue();Adicionales[j]=mygridv.cells2(k,6).getValue();TextoAdicional[j]=mygridv.cells2(k,4).getValue();
			j++;
		 }
	}
	
	for (k=0;k<=Loterias.length-1;k++){
		mygridchg.addRow(k, ValorInLoteria(Loterias[k],2)+','+TextoAdicional[k]+','+Loterias[k]+','+Adicionales[k]);
	}
	
	mygridchg2 = dhxLayout.cells("b").attachGrid();
	mygridchg2.setImagePath("codebase/imgs/");
	mygridchg2.setHeader("Loteria,ID,IDAdd");
	mygridchg2.setInitWidths("300")
	mygridchg2.setColAlign("left")
	mygridchg2.setColTypes("ro,ro,ro");
	mygridchg2.setSkin("dhx_skyblue");
	mygridchg2.attachEvent("onRowSelect",doSelectAtoB2);
	//mygridchg2.enableMultiselect(true);
	mygridchg2.init();
	
	for (k=0;k<=mygrid.getRowsNum()-1;k++){
		mygridchg2.addRow(k, mygrid.cellByIndex(k, 2).getValue()+','+mygrid.cellByIndex(k, 4).getValue()+','+mygrid.cellByIndex(k, 6).getValue());
	}	
	
	mygridchg3 = dhxLayout.cells("c").attachGrid();
	mygridchg3.setImagePath("codebase/imgs/");
	mygridchg3.setHeader("Signo,Sel,ID");
	mygridchg3.setInitWidths("100")
	mygridchg3.setColAlign("left")
	mygridchg3.setColTypes("ro,ro");
	mygridchg3.setSkin("dhx_skyblue");
	mygridchg3.attachEvent("onRowSelect",doSelectAtoB_Cyp);
	//mygridchg2.enableMultiselect(true);
	mygridchg3.init();

}

////////////////////////////////////////////////////////////////////////////////////




function doSelectCHA(rowId,cellIndex)
{
	SeleccionIDLot=mygridchg.cellByIndex(rowId, 2).getValue();
	SeleccionIDAdd=mygridchg.cellByIndex(rowId, 3).getValue();
}
function doSelectAtoB(rowId,cellIndex)
{
	if (mygridchg2.cellByIndex(rowId, 2).getValue() != 1){
			dhxLayout.cells("c").expand();
			SeleccionIDLotD=mygridchg2.cellByIndex(rowId, 1).getValue();
			cargar_formato_2(mygridchg2.cellByIndex(rowId, 2).getValue());
	}else{
		Ejecutar(SeleccionIDLot,SeleccionIDAdd,mygridchg2.cellByIndex(rowId, 1).getValue() ,0)	
	}
}
function cargar_formato_2(_formato)	{   /// <---- Para la Venta
	    mygridchg3.clearAll();
		new Ajax.Request('proc_php.php?op=3&formato='+_formato, {
		method: 'get', onComplete: 		
		function (transport){	   
		 var response = transport.responseText.evalJSON(true);	

		   for (ii=0;ii<=response.length-1;ii++)
		   mygridchg3.addRow(ii,response[ii]+','+(ii+1));
		   
		},
 		  	onFailure: function(){ alert('NO HAY COMUNICACION'); }
			
	});
}
function doSelectAtoB_Add(rowId,cellIndex)
{
	Ejecutar(SeleccionIDLot,SeleccionIDAdd,SeleccionIDLotD ,mygridchg3.cellByIndex(rowId, 1).getValue() )	
}
function Ejecutar(Origen,AdicionalO,Destido,AdicionalD)
{	
	Texto_Orig1='';Texto_Orig2='';
	Texto_Dest1='';Texto_Dest2='';
	
	Texto_Orig1=mygridchg.cellByIndex(mygridchg.getSelectedRowId(), 0).getValue();
	
	
	if (AdicionalO!=0)
	Texto_Orig2=mygridchg.cellByIndex(mygridchg.getSelectedRowId(), 1).getValue();
	
	Texto_Dest1=mygridchg2.cellByIndex(mygridchg2.getSelectedRowId(), 0).getValue();
	
	if (AdicionalD!=0)
	Texto_Dest2=mygridchg3.cellByIndex(mygridchg3.getSelectedRowId(), 0).getValue();
	
	repuestaPrompt=confirm("Desea Cambiar ("+Texto_Orig1+" "+Texto_Orig2+") ==> ("+Texto_Dest1+ " " +Texto_Dest2+')?');
	var ListadeCambios=new Array();
	var k=0;
	if (repuestaPrompt){
		for (i=0;i<=mygridv.getRowsNum()-1;i++){
			if (mygridv.cellByIndex(i,5).getValue()==Origen && mygridv.cellByIndex(i,6).getValue()==AdicionalO){
				    ListadeCambios[k]=i;k++;
					mygridv.cellByIndex(i,5).setValue(Destido);mygridv.cellByIndex(i,2).setValue( ValorInLoteria(Destido,5) );
					if (AdicionalD!=0){ mygridv.cellByIndex(i,6).setValue(AdicionalD); mygridv.cellByIndex(i,4).setValue(Texto_Dest2); }
					else{
						if ( mygridv.cellByIndex(i,6).getValue()!=0 ){
							mygridv.cellByIndex(i,6).setValue(0); mygridv.cellByIndex(i,4).setValue('');
						}
					}
			}
			
		}
		dhxWins3.window("w1").close();
		compresionTicket(ListadeCambios);
	}
	
	
}
function doSelectAtoB2(rowId,cellIndex)
{
	if (mygridchg2.cellByIndex(rowId, 2).getValue() != 1){
			dhxLayout.cells("c").expand();
			SeleccionIDLotD=mygridchg2.cellByIndex(rowId, 1).getValue();
			cargar_formato_2(mygridchg2.cellByIndex(rowId, 2).getValue());
	}else{
		EjecutarCyp(SeleccionIDLot,SeleccionIDAdd,mygridchg2.cellByIndex(rowId, 1).getValue() ,0)	
	}
}

function doSelectAtoB_Cyp(rowId,cellIndex)
{
	EjecutarCyp(SeleccionIDLot,SeleccionIDAdd,SeleccionIDLotD ,mygridchg3.cellByIndex(rowId, 1).getValue() )	
}
function EjecutarCyp(Origen,AdicionalO,Destido,AdicionalD)
{	
	Texto_Orig1='';Texto_Orig2='';
	Texto_Dest1='';Texto_Dest2='';
	
	Texto_Orig1=mygridchg.cellByIndex(mygridchg.getSelectedRowId(), 0).getValue();
	
	
	if (AdicionalO!=0)
	Texto_Orig2=mygridchg.cellByIndex(mygridchg.getSelectedRowId(), 1).getValue();
	
	Texto_Dest1=mygridchg2.cellByIndex(mygridchg2.getSelectedRowId(), 0).getValue();
	
	if (AdicionalD!=0)
	Texto_Dest2=mygridchg3.cellByIndex(mygridchg3.getSelectedRowId(), 0).getValue();
	
	repuestaPrompt=confirm("Desea Copiar los numeros de la Loteria ("+Texto_Orig1+" "+Texto_Orig2+") a  ("+Texto_Dest1+ " " +Texto_Dest2+')?');
	var ListadeCambios=new Array();
	var k=0;
	if (repuestaPrompt){
		for (i=0;i<=mygridv.getRowsNum()-1;i++){
			if (mygridv.cellByIndex(i,5).getValue()==Origen && mygridv.cellByIndex(i,6).getValue()==AdicionalO){
				    ListadeCambios[k]=i;k++;
					MakeTicket_Idd(mygridv.cellByIndex(i,1).getValue(),Destido, mygridv.cellByIndex(i,3).getValue() ,AdicionalD)
			}
			
		}
		dhxWins3.window("w1").close();
		compresionTicket(ListadeCambios);
	}
	
	
}


function ValorInLoteria(IDLotA,campos)
{
	devolValor=0;
	for (l=0;l<=mygrid.getRowsNum()-1;l++){
		if (mygrid.cellByIndex(l, 4).getValue()==IDLotA){
			devolValor=mygrid.cellByIndex(l, campos).getValue();
			break;
		}		
	}
	return devolValor;
}
function existeIDLOT(ALoteria,IDLotA,AAdicionales,IDAdd)
{
	existe=false;
	for (i=0;i<=ALoteria.length-1;i++){
		if (ALoteria[i]==IDLotA && AAdicionales[i]==IDAdd ) { existe=true; break; }
	}
	
	return existe;

}

function compresionTicket(ListadeCambios)
{

			for (a=0;a<=ListadeCambios.length-1;a++){
				indice=ListadeCambios[a];
				Numero=mygridv.cellByIndex(indice,1).getValue(); 
				IDLot= mygridv.cellByIndex(indice,5).getValue()
				IDAdd= mygridv.cellByIndex(indice,6).getValue()
				
				for (b=0;b<=mygridv.getRowsNum()-1;b++){
					if (indice!=b){
					 if ( Numero==mygridv.cellByIndex(b,1).getValue() &&  mygridv.cellByIndex(b,5).getValue()==IDLot && mygridv.cellByIndex(b,6).getValue()==IDAdd 	){
						valoractual=parseFloat(mygridv.cellByIndex(indice,3).getValue())+parseFloat(mygridv.cellByIndex(b,3).getValue());
						mygridv.cellByIndex(indice,3).setValue(valoractual);
						mygridv.cellByIndex(b,1).setValue('-1');	
					 }
					}
				}
			}
	
			
			
			for (a=0;a<=mygridv.getRowsNum()-1;a++){
				if (   mygridv.cellByIndex(a,1).getValue() == '-1'){
					mygridv.selectRow( a );mygridv.deleteSelectedRows();
				}
				
			}
	
}

function AmarTicket(_serial)
{
			new Ajax.Request('vertickets-1.php',{ parameters: { op:1,serial:_serial},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									if (response[5]) opcion=0; else opcion=1;
									Imprimir_Ticket(response[4],'NO HABILITADO',response[2],response[0],false,'printerver_2',response[1],response[3],false,opcion,$('Agencia').innerHTML,false,0);
									
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
}


function AmarTicketPREMIADO(_serial)
{
new Ajax.Request('vertickets-1.php',{ parameters: { op:3,serial:_serial},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									if (response[5]) opcion=0; else opcion=1;
									Imprimir_Ticket(response[4],'NO HABILITADO',response[2],response[0],false,'printerver_2',response[1],response[3],false,opcion,response[8],true,response[7]);
									
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
}

function EliminarTicket(_serial){
	if (confirm("Desea ELIMINAR el ticket No."+_serial+"?")){
		new Ajax.Request('vertickets-1.php',{ parameters: {op:2, serial:_serial,idjActual:$('IDJ').lang},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									if (response) {
											alert('El Ticket Anulado!');
											mygridchg.clearAll();
	 										mygridchg.loadXML("vertickets.php?Fecha="+fecha);
										}
									else
										alert('El Ticket no se pudo Anular');
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	}
		
}

function ReImprimirTicket(_serial)
{
	new Ajax.Request('vertickets-1.php',{ parameters: { op:1,serial:_serial},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									if (response[5])
									  Imprimir_Ticket(response[4],response[6],response[2],response[0],true,'printer',response[1],response[3],true,2,$('Agencia').innerHTML,false,0);					
									else
									  alert('Lo Siento pero este ticket esta anulado!!');
									
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
}

function doSelectVerticket(rowId){ 
		serialSelect=mygridchg.cellById(rowId, 0).getValue()
		AmarTicket(serialSelect);
		//alert($('printerver').innerHTML)
		dhxLayout.cells("b").attachObject("printerver");
		serialSeleccion=serialSelect;
		//$('printerver').innerHTML='';
	    } 
		
function BuscarTicket(){
	dhxWins4 = new dhtmlXWindows();	
	dhxWins4.setImagePath("codebase/imgs/");
	w4 = dhxWins4.createWindow("w4",10, 80, 300, 200);
	w4.setText("Buscar Tickets");
	dhxWins4.window("w4").setModal(true);
	dhxWins4.window("w4").centerOnScreen();
	dhxWins4.window("w4").denyResize();
	dhxWins4.window("w4").denyMove();
	dhxWins4.window("w4").button("close").hide();
	dhxWins4.window("w4").attachObject("Busqueda");
	
	bar = w4.attachToolbar();
	bar.addButton("Cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.attachEvent("onClick", clicktoolBar_BuscarTicket);
	
}
function BusquedaSerial(){
	mygridchg.clearAll();
	mygridchg.loadXML("vertickets.php?Serial="+$('BSerial').value);
	clicktoolBar_BuscarTicket("Cerrar_");
}
function clicktoolBar_BuscarTicket(id){
	switch(id){
		case "Cerrar_":
					dhxWins4.window("w4").close();
					$('FrmBsq').innerHTML='<div id="Busqueda"><br /><br /><span> Indique el Serial: </span><span id="sprytextfield5"><input id="BSerial" type="text"  size="8"/>  <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>&nbsp;&nbsp;&nbsp;<input name="" type="button" value="Buscar" onclick="BusquedaSerial();"/></div>';
					break;	
	}
}
function clicktoolBartheChangeVT(id){
  
	switch(id){
		case "Cerrar_":
					dhxWins3.window("w2").close();
					$('showprint').innerHTML='<div id="printerver" style="width: 100%; height: 100%; overflow: auto;display: none; font-family: Tahoma; font-size: 11px;">    <div id="printerver_2" style="margin: 3px 5px 3px 5px;"></div></div>';
					break;	
		case "Eliminar_":
					EliminarTicket(serialSeleccion);					
					break;				
		case "Imprimir_":
					ReImprimirTicket(serialSeleccion);
					break;
		case "Calendario_":
					opciCal=1;	
					calendarioToolBar(670,150);
					break;		
		case "Buscar_":
					BuscarTicket();
					break;				
					
          }
}
function VerTicket()
{
	dhxWins3 = new dhtmlXWindows();	
	dhxWins3.setImagePath("codebase/imgs/");	
	w2 = dhxWins3.createWindow("w2",10, 80, 680, 400);
	w2.setText("Visor de Tickets");
	dhxWins3.window("w2").setModal(true);
	dhxWins3.window("w2").centerOnScreen();
	dhxWins3.window("w2").denyResize();
	dhxWins3.window("w2").denyMove();
	dhxWins3.window("w2").button("close").hide();
	//dhxWins1.setSkin("web");  
	fecha=$('Fecha').lang;
	bar = w2.attachToolbar();
	bar.addButton("Eliminar_", 1, "Eliminar Ticket", "images/sample_close.gif", "images/sample_close.gif"); 
	bar.addButton("Imprimir_", 2, "Imprimir Copia", "images/dhtmlxwebmenu_icon.gif", "images/dhtmlxwebmenu_icon.gif"); 
	bar.addButton("Buscar_", 3, "Buscar Ticket", "images/dhtmlxfolders_icon.gif", "images/dhtmlxfolders_icon.gif"); 
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.addSeparator('', 5);
	bar.addText('TextoFecha', 6, 'Fecha:'+fecha);
	bar.addButton("Calendario_", 7, "", "images/dhtmlxcalendar_icon.gif", "images/dhtmlxcalendar_icon.gif"); 
	bar.attachEvent("onClick", clicktoolBartheChangeVT);
	
	dhxLayout = new dhtmlXLayoutObject(w2, "2U");	
	dhxLayout.cells("a").setText("Tickets Realizados");dhxLayout.cells("a").setWidth(285);
	dhxLayout.cells("b").setText("Ver Tickets");
	
	setCookie('IDC',$('stAgencia').lang);
	mygridchg = dhxLayout.cells("a").attachGrid();
	mygridchg.setImagePath("codebase/imgs/");
	mygridchg.setHeader("Serial,Fecha,Hora,Monto");
	mygridchg.setInitWidths("70,65,80,50")
	mygridchg.setColAlign("right,left,left,right")
	mygridchg.setColTypes("ro,ro,ro,ro");
    mygridchg.setSkin("dhx_skyblue");
	mygridchg.attachEvent("onRowSelect",doSelectVerticket); 
	mygridchg.init();
	mygridchg.loadXML("vertickets.php?Fecha="+fecha);
	//for (k=0;k<mygridv.getRowsNum();k++){
    //		mygridchg.addRow(k,mygridv.cells2(k, 0).getValue()+',0'+mygridv.cells2(k, 0).getValue()+','+txtLoteria[1]+','+monto+','+txtLoteria[0]+','+Idlot+','+IdAdd);
    //	}

}

function clickChangeUser(tipodeusuario,Asociado)
{

	switch (parseInt(tipodeusuario) ){
		case 1:
				makeResultwin('usuarios-3.php?SQL=Select * From _tagencias&id=Asociado&idS=IDC&idD=Descripcion&Seleccion='+Asociado,'lblAsociado'); break;
		case 2:
				makeResultwin('usuarios-3.php?SQL=Select * From _tintermediario&id=Asociado&idS=IDI&idD=Descripcion&Seleccion='+Asociado,'lblAsociado'); break;		
		case 3:
				makeResultwin('usuarios-3.php?SQL=Select * From _tzona&id=Asociado&idS=IDZ&idD=Descripcion&Seleccion='+Asociado,'lblAsociado'); break;	
		case 4:
				makeResultwin('usuarios-3.php?SQL=Select * From _tbanca&id=Asociado&idS=IDB&idD=Descripcion&Seleccion='+Asociado,'lblAsociado'); break;		
		case 5:
		case 6:
				$('lblAsociado').innerHTML='<input id="Asociado" type="text"  value="0" style="display:none"/>';break;	
		
	}
}
///////////////// Funcion MUestra los Ticket's Premiados  ////////////////////////
function BuscarTicketPREMIO(){
	dhxWins5 = new dhtmlXWindows();	
	dhxWins5.setImagePath("codebase/imgs/");
	w5 = dhxWins5.createWindow("w5",10, 80, 300, 200);
	w5.setText("Buscar Tickets PREMIADO");
	dhxWins5.window("w5").setModal(true);
	dhxWins5.window("w5").centerOnScreen();
	dhxWins5.window("w5").denyResize();
	dhxWins5.window("w5").denyMove();
	dhxWins5.window("w5").button("close").hide();
	dhxWins5.window("w5").attachObject("BusquedaPremio");
	
	bar = w5.attachToolbar();
	bar.addButton("Cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.attachEvent("onClick", BuscarTicketPREMIO_Bar);
	bar.setSkin("dhx_black");  
	
}
function BusquedaSerialPREMIO(){
	mygridchgWin.clearAll();
	mygridchgWin.loadXML("verticketsPremiado.php?Serial="+$('BSerialP').value);
	BuscarTicketPREMIO_Bar("Cerrar_");
}
function BuscarTicketPREMIO_Bar(id){
	switch(id){
		case "Cerrar_":					
					$('frmPremio').innerHTML='<div id="BusquedaPremio"><br /><br /><span> Indique el Serial: </span><input id="BSerialP" type="text"  size="8"/>&nbsp;&nbsp;&nbsp;<input name="" type="button" value="Buscar"  onclick="BusquedaSerialPREMIO();"/></div>';
					
					dhxWins5.window("w5").close();
					break;	
	}
}
function clicktoolBarPREMIO(id){
  
	switch(id){
		case "Cerrar_":
					dhxWins4.window("wpremiados").close();
					$('showprint').innerHTML='<div id="printerver" style="width: 100%; height: 100%; overflow: auto;display: none; font-family: Tahoma; font-size: 11px;">    <div id="printerver_2" style="margin: 3px 5px 3px 5px;"></div></div>';
					break;	
		case "Buscar_":
					BuscarTicketPREMIO();
					break;		
		case "Calendario_":
					opciCal=2;
					calendarioToolBar(670,150);
					break;		
		case "Pagar_":
					PagarPremio();
					break;					
				
          }
}
function PagarPremio(){
 if (serialSelect!=0){	
 new Ajax.Request('vertickets-1.php',{ parameters: { op:4,serial:serialSelect},method:'post',asynchronous:false,	onComplete: function(transport){
	var response = transport.responseText.evalJSON(true);
	  if (	response[0] ){		
	  	serialElectronico=response[1]
		dhxWins5 = new dhtmlXWindows();	
		dhxWins5.setImagePath("codebase/imgs/");
		w5 = dhxWins5.createWindow("w5",10, 80, 430, 130);
		w5.setText("Pagar Premio SERIAL NO."+serialSelect);
		dhxWins5.window("w5").setModal(true);
		dhxWins5.window("w5").centerOnScreen();
		dhxWins5.window("w5").denyResize();
		dhxWins5.window("w5").denyMove();
		dhxWins5.window("w5").button("close").hide();
		dhxWins5.window("w5").attachObject("PagoPremioCodigo");
		bar = w5.attachToolbar();
		bar.addButton("Cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif"); 
		bar.attachEvent("onClick", PagarPremio_Bar);
		bar.setSkin("dhx_black");
	  }else {
		alert (response[1]);  
	  }
	},	
		onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
	});
	
 }else{
	alert('No ha seleccionado ningun Ticket para Confirmar el Pago!'); 
 }
	
}
function comparar(){
	
	okey=true;
	 new Ajax.Request('vertickets-1.php',{ parameters: { op:6,seTK:serialElectronico,seIntro:$('UNO').value+'-'+$('DOS').value+'-'+$('TRES').value+'-'+$('CUATRO').value},method:'post',asynchronous:false,	onComplete: function(transport){
	var response = transport.responseText.evalJSON(true);
	
	if (!response){
		alert('Lo siento pero este Serial Electronico No Corresponde al del Ticket!');	
		PagarPremio_Bar("Cerrar_");
	}else
		CancelarPremio()
		
	},	
		onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
	});
	
	
	

}
function CancelarPremio()
{
new Ajax.Request('vertickets-1.php',{ parameters: { op:5,serial:serialSelect,IDCtrr:$('stAgencia').lang,IDusu:$('UsuarioB').lang},method:'post',asynchronous:false,	onComplete: function(transport){
		var response = transport.responseText.evalJSON(true);
		if (response)
			alert('Ticket Valido Puede Cancelarlo');
		else
			alert('El ticket no se Puede Registrar NO PUEDE PAGARLO: Comuniquese con el Administrador');	
		
	},	
		onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
	});
	PagarPremio_Bar("Cerrar_");
}
function PagarPremio_Bar(id){
  
	switch(id){
		case "Cerrar_":
					dhxWins5.window("w5").close();
					$('frmPagoPremio').innerHTML='<div id="PagoPremioCodigo"><br />	<span> Indique Codigo: </span> <input id="UNO" type="text"  size="5"/>-<input id="DOS" type="text"  size="5"/>-<input id="TRES" type="text"  size="5"/>-<input id="CUATRO" type="text"  size="5"/><input name="" type="button" value="Validar"  onclick="comparar();"/></div>';
					break;	
          }
}
function VerTicketPremiados()
{
	serialSelect=0;
	
	dhxWins4 = new dhtmlXWindows();	
	dhxWins4.setImagePath("codebase/imgs/");	
	wpremiados = dhxWins4.createWindow("wpremiados",10, 80, 680, 400);
	wpremiados.setText("Visor de Tickets PREMIADOS");
	dhxWins4.window("wpremiados").setModal(true);
	dhxWins4.window("wpremiados").centerOnScreen();
	dhxWins4.window("wpremiados").denyResize();
	dhxWins4.window("wpremiados").denyMove();
	//dhxWins4.setSkin("dhx_black");  
	
	fecha=$('Fecha').lang;
	barWin = wpremiados.attachToolbar();
	barWin.addButton("Pagar_", 1, "Pagar Ticket", "images/dhtmlxwebmenu_icon.gif", "images/dhtmlxwebmenu_icon.gif"); 
	barWin.addButton("Buscar_", 2, "Buscar Ticket", "images/dhtmlxfolders_icon.gif", "images/dhtmlxfolders_icon.gif"); 
	barWin.addButton("Cerrar_", 3, "Cerrar", "images/close.gif", "images/close.gif"); 
	barWin.addSeparator('', 5);
	barWin.addText('TextoFecha', 6, 'Fecha:'+fecha);
	barWin.addButton("Calendario_", 7, "", "images/dhtmlxcalendar_icon.gif", "images/dhtmlxcalendar_icon.gif"); 
	barWin.attachEvent("onClick", clicktoolBarPREMIO);
	barWin.setSkin("dhx_black");  
	
	dhxLayoutWin = new dhtmlXLayoutObject(wpremiados, "2U");	
	dhxLayoutWin.cells("a").setText("Tickets Realizados");
	dhxLayoutWin.cells("a").setWidth(410);
	dhxLayoutWin.cells("b").setText("Ver Tickets");
	//dhxLayoutWin.setSkin("dhx_black");  
	
	
	mygridchgWin = dhxLayoutWin.cells("a").attachGrid();
	mygridchgWin.setImagePath("codebase/imgs/");
	mygridchgWin.setHeader("Serial,Fecha,Hora,Monto,Premio");
	mygridchgWin.setInitWidths("70,65,80,90,100")
	mygridchgWin.setColAlign("right,left,left,right,right")
	mygridchgWin.setColTypes("ro,ro,ro,ro,ro");
    mygridchgWin.setSkin("dhx_black");
	mygridchgWin.attachEvent("onRowSelect",doSelectVerticketPremiados); 
	mygridchgWin.init();
	mygridchgWin.loadXML("verticketsPremiado.php?Fecha="+fecha+"&IDCkk="+$('stAgencia').lang);
	//for (k=0;k<mygridv.getRowsNum();k++){
    //		mygridchg.addRow(k,mygridv.cells2(k, 0).getValue()+',0'+mygridv.cells2(k, 0).getValue()+','+txtLoteria[1]+','+monto+','+txtLoteria[0]+','+Idlot+','+IdAdd);
    //	}

}
function doSelectVerticketPremiados(rowId){ 
		serialSelect=mygridchgWin.cellById(rowId, 0).getValue()
		AmarTicketPREMIADO(serialSelect);
		dhxLayoutWin.cells("b").attachObject("printerver");
		serialSeleccion=serialSelect;
	    }
function MoveWindowsDigalequeNO()
{
	 var pos = dhxWins1.window("w1").getPosition();
     vi=90000;
	 yp=pos[1];
	
	 for (interac=1;interac<=4;interac++){
		 x=pos[0]-30;
		 dhxWins1.window("w1").setPosition(x, yp);delay(vi); 
		 x=x+30;
		 dhxWins1.window("w1").setPosition(x, yp);delay(vi); 
		 x=x+30;
		 dhxWins1.window("w1").setPosition(x, yp);delay(vi); 
		 x=x+30;
		 dhxWins1.window("w1").setPosition(x, yp);delay(vi); 
		 x=x+30;
		 dhxWins1.window("w1").setPosition(x, yp);delay(vi);  
		 x=x-30;
		 dhxWins1.window("w1").setPosition(x, yp);delay(vi);  
		 x=x-30;
		 dhxWins1.window("w1").setPosition(x, yp);delay(vi); 
		 x=x-30;
		 dhxWins1.window("w1").setPosition(x, yp);delay(vi); 
	 }
	 	
}
function delay(timeInMilliS){
	var d = new Date();
	var begin = d.getTime();
	while ((d.getTime() - begin ) > timeInMilliS){
		// nothing...
		}
}
//// Opciones del Menu
function accesoalsistema()
{
    iduser=$('idusuario').value;
	setCookie('-okwilh',$('idclave').value);
new Ajax.Request('tiocpqok91_rtaka.php',{method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
								
									setCookie('-okwilh',response);
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
	new Ajax.Request('logon.php',{ parameters: { iduser:$('idusuario').value,IDJ:$('IDJ').lang},method:'post',	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
										// alert(response[1])
										// $('repuesta').innerHTML  = response;
										
										setCookie('-okwilh','');
										if (response[0]){
										 if (response[1]==1){
											dhxWins1.window("w1").close(); 
											iduser=response[3];
											FrmtheCode(response[2])
										 }else{	
										 	if (response[1]==2){
												$('stUsuario').style.display="";
												$('UsuarioB').innerHTML =response[2];
												$('UsuarioB').lang =response[3];
												$('stAgencia').style.display="";$('stAgencia').lang=response[7];
												$('txtAgencia').innerHTML =response[4]+':';
												$('Agencia').innerHTML =response[6];
												$('Agencia').lang =response[5];
										    	dhxWins1.window("w1").close(); 
												initMenu(response[4])
											}else{
												$('stUsuario').style.display="";
												$('UsuarioB').innerHTML =response[2];
												$('UsuarioB').lang =response[4];$('stAgencia').lang='-2';
												$('stTipodeUsuario').style.display="";
												$('TUsuario').innerHTML =response[3];
												dhxWins1.window("w1").close(); 
												if (response[4]==1)
													initMenu(response[3])
												else
													initMenu(response[3])
											}
										 }
										}else{
											MoveWindowsDigalequeNO();
											//alert();	
											$('repuesta').innerHTML  = response[1];
											$('idusuario').value='';
											$('idclave').value=''
											$('idusuario').focus();										
										}
										
										
										
								},onCreate: function(){    		
									$('repuesta').innerHTML  = '<img src="media/ajax-loader.gif" />';
								},
	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
	
								});	
	
}
function execMenu(id, zoneId, casState){
   

	if (id=='m4')
				 window.location.reload();
	else
		new Ajax.Request('vermenu.php',{ parameters: { idmenu:id},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText;
									 response.evalScripts();	
									},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
		
}


function initMenu(_Autorizados) {
	
		archivo='arch/'+$("UsuarioB").innerHTML+'.xml';
	
		new Ajax.Request('xmlcreaterMenu.php',{ parameters: { file:archivo,Autorizados:_Autorizados},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText;								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
		menu = new dhtmlXMenuObject("contextArea","modern_blue");
		menu.setImagePath("codebase/imgs/");
		menu.setIconsPath("images/");
		menu.setOpenMode("win");
		menu.loadXML(archivo+"?e="+new Date().getTime());
		menu.attachEvent("onClick","execMenu");
		var webBar = new dhtmlXToolbarObject("toolbarObj");
		webBar.setIconsPath("images/");
	    webBar.loadXML("toolsbar.xml?etc="+new Date().getTime());

	}
	
function FrmtheCode(_Se) {
	var dhxWins2 = new dhtmlXWindows();	
	dhxWins2.setImagePath("codebase/imgs/");	
	w2 = dhxWins2.createWindow("w2",10, 80, 500, 160);
	w2.setText("Registro al Sistema WM Lotery");
	dhxWins2.window("w2").setModal(true);
	dhxWins2.window("w2").centerOnScreen();
	dhxWins2.window("w2").denyResize();
	dhxWins2.window("w2").denyMove();
	w2.attachObject('Registro');
	$('Codigo').innerHTML  = _Se;
	}	


function FrmClaveEspecial() {

	new Ajax.Request('sendmail.php',{method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									 
					 
	if (response[0]){	
	    if (response[1])
			ClavaAsiBLI(' (Verifique su Correo) ');
		else
			ClavaAsiBLI('');
		   
		dhxWins2 = new dhtmlXWindows();	
		dhxWins2.setImagePath("codebase/imgs/");	
		w2 = dhxWins2.createWindow("w2",10, 80, 350, 180);
		w2.setText("Clave BLI");
		dhxWins2.window("w2").setModal(true);
		dhxWins2.window("w2").centerOnScreen();
		dhxWins2.window("w2").denyResize();
		dhxWins2.window("w2").denyMove();
		w2.attachObject('ClaveBLI');
	}else
		alert('Los siento pero no puedo generar la clave BLI');	
	
									 
									 
									 },	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
	}

function EliminarRegiINst(){
   
	new Ajax.Request('proc_php.php',{parameters: { op:4,ikUsu:$('txUsu').value,ikClave:$('txClave').value},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									 dhxWins2.window("w2").close();
									 if (response){
									  if (confirm("Desea Eliminar este Registro?") )  
									  {
										 makeResultwin("chaceStatus.php?SqlStatus=Delete from _registros_de_acceso  where IDusu="+mygrid.cellById(fila, 0).getValue(),"gridbox");
										 mygrid.clearAll();
										 mygrid.loadXML("generador-1.php");
										 alert('Registro Eliminado!');	
									   }
									 }else
									 	alert ('Clave o Usuario Errada!');
									 
									 },	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	dhxWins2.window("w2").close();
	dhxWins2=0;
		
}
function vericarRegistro()
{
	listacodigo='';
	for (i=1;i<=4;i++){
		listacodigo=listacodigo+$('c'+i).value+'|';
	}

		new Ajax.Request('verificarRegistro.php',{ parameters: { idusert:iduser,codigo:listacodigo},method:'get',	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									if (response){
										$('rechazado').style.display="none";
										$('aceptar').style.display="";	
										alert('Por Favor vuelva a Recargar La Pagina para Iniciar el Sistema!');
										dhxWins2.window("w2").close(); 
									}else{
										$('aceptar').style.display="none";
										$('rechazado').style.display="";	
										
									}
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
}

function gen_generador(id,op)
{
new Ajax.Request('generador-2.php',{ parameters: { IDusu:id,opcion:op},method:'post',	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									if (response){
										refrecargridPHP("generador-1.php")
									}else{
										alert('Lo Siento no puedo realizar la Operacion!!');
									}
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
}
function clicktoolBartheChangePREMI(id){
  
	switch(id){
		case "Cerrar_":
		
		            ///  Terminal No.1     
		            terminal1='';
					if ($('CT1').checked) terminal1='C'
					if ($('DT1').checked) terminal1=terminal1+'D'
					if ($('UT1').checked) terminal1=terminal1+'U'
					
					///  Terminal No.2     
		            terminal2='';
					if ($('CT2').checked) terminal2='C'
					if ($('DT2').checked) terminal2=terminal2+'D'
					if ($('UT2').checked) terminal2=terminal2+'U'
					
					///  Terminal No.3     
		            terminal3='';
					if ($('CT3').checked) terminal3='C'
					if ($('DT3').checked) terminal3=terminal3+'D'
					if ($('UT3').checked) terminal3=terminal3+'U'
					
					///  Triple
		            triple='';
					if ($('CTR4').checked) triple='C'
					if ($('DTR4').checked) triple=triple+'D'
					if ($('UTR4').checked) triple=triple+'U'
					
					/// Inicilizacion de la Formula
					$('CT1').checked=false
					$('DT1').checked=false
					$('UT1').checked=false
					$('CT2').checked=false
					$('DT2').checked=false
					$('UT2').checked=false
					$('UT3').checked=false
					$('CT3').checked=false
					$('DT3').checked=false
					$('CTR4').checked=false
					$('DTR4').checked=false
					$('UTR4').checked=false
					////////////////////////////////
			
					id=mygrid.cellById(selectRowId, 3).getValue()
					
					grabacion('FormulaPago',terminal1+'|'+terminal2+'|'+terminal3+'|'+triple,selectRowId,idgeneral);  // <-- Grabacion de la Formula de Premiacion
				
					dhxWins2.window("w2").close();
					$('frmPremiacion').innerHTML='<div id="premiacion" style="display:none" ></div>';
					
					break;			
          }
}

function grabacion(_campo,_data,_idLoteria,_IdRelacionado)
{
	var respuesta=false;
	new Ajax.Request('cupos-3.php',{ parameters: { op:1,idLoteria:_idLoteria,IdRelacionado:_IdRelacionado,campo:_campo,data:_data},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									if (!response)
										alert('No pude actulizar el Sistema!!')
										
									respuesta=	response;
									
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	return respuesta;
}
function consulta(_campo,_idLoteria,_IdRelacionado)
{
var retorno=0;	
new Ajax.Request('cupos-3.php',{ parameters: {op:2,idLoteria:_idLoteria,IdRelacionado:_IdRelacionado,campo:_campo},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText;
									
										retorno =response;									
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	

return retorno;

}
function Marcar(_Seleccion)
{	
  valor=_Seleccion.split('|');
	
  for (j=0;j<=2;j++){	
	mostrar=valor[j].split('');
	for (i=0;i<=mostrar.length-1;i++)
		$(mostrar[i]+'T'+(j+1)).checked=true; 
   }
  
   triple=valor[3].split('');
   
   for (i=0;i<=triple.length-1;i++)
	 $(triple[i]+'TR4').checked=true; 
	
}
function Premiaciondeloteria()
{

	dhxWins2 = new dhtmlXWindows();	
	dhxWins2.setImagePath("codebase/imgs/");	
	var isWin = dhxWins2.isWindow("w2");
	w2 = dhxWins2.createWindow("w2",10, 80, 410, 200);
	w2.setText("Premiacion");
	dhxWins2.window("w2").setModal(true);
	dhxWins2.window("w2").centerOnScreen();
	
	dhxWins2.window("w2").button('close').hide();
	dhxWins2.window("w2").button('minmax1').hide();
	dhxWins2.window("w2").button('minmax2').hide();
	dhxWins2.window("w2").button('park').hide();
	
	dhxWins2.window("w2").denyResize();
	dhxWins2.window("w2").denyMove();
	w2.attachObject('premiacion');
	bar = w2.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.attachEvent("onClick", clicktoolBartheChangePREMI);
	valor=consulta('FormulaPago',selectRowId,idgeneral);
	//alert(valor)
	////
	 makeResultwinNow('fromPremacion.php','premiacion');	
	if (!(valor==false))
			Marcar(valor);
	
}


function combiacion(valor1,valor2,valor3,cantidad)
{
	    marcados=0;
		 
		if ($(valor1).checked) marcados++;
		if ($(valor2).checked) marcados++;
		if ($(valor3).checked) marcados++;
		
		if (marcados<=cantidad) estado=true; else  estado=false;
		
		return estado;
	
}

//////////////////////////////////////////////////////

function MostrarPREMIO(_Seleccion)
{	
  valor=_Seleccion.split('|');
	
  for (j=0;j<=2;j++){	
		$('Terminal'+(j+1)).value=valor[j]; 
   }
  
   $('Triple').value=valor[3]; 
	
}

function PREMIOdeloteria()
{

	dhxWins2 = new dhtmlXWindows();	
	dhxWins2.setImagePath("codebase/imgs/");	
	var isWin = dhxWins2.isWindow("w3");
	w3 = dhxWins2.createWindow("w3",10, 80, 290, 200);
	w3.setText("Premiacion");
	dhxWins2.window("w3").setModal(true);
	dhxWins2.window("w3").centerOnScreen();
	dhxWins2.window("w3").button('close').hide();
	dhxWins2.window("w3").button('minmax1').hide();
	dhxWins2.window("w3").button('minmax2').hide();
	dhxWins2.window("w3").button('park').hide();
	dhxWins2.window("w3").denyResize();
	dhxWins2.window("w3").denyMove();
	
	w3.attachObject('premio');
	bar = w3.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.attachEvent("onClick", clicktoolBartheChangePREMIO);
	valor=consulta('Premio',selectRowId,idgeneral);
    makeResultwinNow('fromPremio.php','premio');
	if (!(valor==false))
			MostrarPREMIO(valor);
	
}

function clicktoolBartheChangePREMIO(id){
  
	switch(id){
		case "Cerrar_":
					
					
					Total=$('Terminal1').value+'|'+$('Terminal2').value+'|'+$('Terminal3').value+'|'+$('Triple').value;
					
					/// Inicilizacion de la Formula
					$('Terminal1').value='';
					$('Terminal2').value='';
					$('Terminal3').value='';
					$('Triple').value='';
					////////////////////////////////
			
					id=mygrid.cellById(selectRowId, 3).getValue()
					
					grabacion('Premio',Total,selectRowId,idgeneral);  // <-- Grabacion de la Formula de Premiacion
				
					dhxWins2.window("w3").close();
	
					$('frmPremio').innerHTML='<div id="premio" style="display:none" ></div>';
					
					break;			
          }
}
function grabacion_Premiacion(_fecha)
{
	Svalor=$('NumeroGanador').value;	
	desicion=(!isNaN(parseInt(Svalor)) && ( Svalor.length>=2 && Svalor.length<=3  ));
	
	if (desicion){
		
	if (z==0) 
		Adicional=0;	
	else
		Adicional=z.getSelectedValue();


	new Ajax.Request('grabar_premio.php',{ parameters: { op:1,Fecha:_fecha,IDLot:$('LoterySelec').lang,NumeroP:$('NumeroGanador').value,Adicional:Adicional},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
							
									if (response)
										{
											new Ajax.Request('grabar_premio.php',{ parameters: { op:3,Fecha:_fecha,IDLot:$(			'LoterySelec').lang,NumeroP:$('NumeroGanador').value,Adicional:Adicional},method:'post',asynchronous:false,	onComplete: function(transport){
											var response = transport.responseText.evalJSON(true);
											
												$("lista").innerHTML = 'Procesado Total de Premios:'+response[0]+'<br>Monto total de Premios Bsf.:'+response[1]; 
											
																	
											},	
											onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
											});	
											
										}else
										alert('No pude actualizar el Sistema!!')
										
																	
								},
							 onCreate: function(){ 
								$("lista").innerHTML = '<img src="images/ajax-loader.gif" />'; },
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	}else{
		alert('El Numero Ganador no es Valido Verifique Por Favor!');	
		$('NumeroGanador').value='';
		$('NumeroGanador').focus();
	 	
	}
}

function consultar_Premiacion(_fecha)
{
	if ($('LoterySelec').lang!='0'){
	new Ajax.Request('grabar_premio.php',{ parameters: { op:2,IDJ:$('IDJ').lang,Fecha:_fecha,IDLot:$('LoterySelec').lang},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									
															
									if (response[0])
									{
										$('NumeroGanador').value=response[1]
										if (response[2]!=0)
											z.selectOption(response[2]-1); 
										
									}else{
										$('NumeroGanador').value='';
										
									}
										
										
																	
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
}
}

/////////////// opcion Fecha en ToolBar /////////////////////

function calendarioToolBar(x,y)
{
	dhxWins2 = new dhtmlXWindows();
    dhxWins2.setImagePath("codebase/imgs/");	
	var wToolBar = dhxWins2.createWindow("wToolBar",10, 80, 190, 210);
	wToolBar.clearIcon();
	dhxWins2.window("wToolBar").button('close').hide();
	dhxWins2.window("wToolBar").button('minmax1').hide();
	dhxWins2.window("wToolBar").button('minmax2').hide();
	dhxWins2.window("wToolBar").button('park').hide();
	dhxWins2.window("wToolBar").setPosition(x, y);
    wToolBar.setText("");
	wToolBar.attachObject('obj');
	
	mCal = new dhtmlxCalendarObject('Calen1');
	mCal.attachEvent("onClick", mSelectDateToolBar);
	mCal.setSkin("dhx_black");
    mCal.draw();
    
}
function mSelectDateToolBar(date)
{
	$('vista').innerHTML='<div id="obj"><div id="Calen1"/></div></div>';
	fecha=mCal.getFormatedDate("%d/%m/%Y", date);
	serialSelect=0;
	switch(opciCal){
		case 1:
			bar.setItemText('TextoFecha', 'Fecha: '+fecha);
			mygridchg.clearAll();
			mygridchg.loadXML("vertickets.php?Fecha="+fecha);		
			break;
		case 2:
			barWin.setItemText('TextoFecha', 'Fecha: '+fecha);
			mygridchgWin.clearAll();
			mygridchgWin.loadXML("verticketsPremiado.php?Fecha="+fecha+"&IDCkk="+$('stAgencia').lang);	
			break;
			
	}
	dhxWins2.window("wToolBar").close();
}

function checkLoteria(_idLot)
{
	estatus=false;
	new Ajax.Request('operaLotery.php',{ parameters: { op:1,IDJ:$('IDJ').lang,IDLot:_idLot},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
			
								if (	response[0]   ){
									estatus=true;									
								}else{
									estatus=false;
									switch(response[1]){
										case '1':
												alert('Esta Loteria Fue desactivada');
												break;
										case '2':
												alert('Esta Loteria Esta Cerrada');
												break;
										case '3':
												alert('Esta Loteria NO EXISTE: Comuniquese con el Administrador!');
												break;
									}
									
								}
										
																	
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
	return estatus;
}

function checkLoteriaByPremio(_idLot)
{
	estatus=false;

	new Ajax.Request('operaLotery.php',{ parameters: { op:3,Fecha:fecha,IDLot:_idLot},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
			
								if (	!response[0]   ){
									if (response[1]=='2')  
										estatus=true;		
									else
										{
										switch(response[1]){
											case '1':
												alert('Esta Loteria Fue desactivada');
												break;
											case '2':
												alert('Esta Loteria Esta Cerrada');
												break;
											case '3':
												alert('Esta Loteria NO EXISTE: Comuniquese con el Administrador!');
												break;
											}											
										}
								}else{
									estatus=false;	
									alert('Esta Loteria Todavia esta Abierta NO SE PUEDE PREMIAR!');
								}
										
																	
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
	return estatus;
}
//////////////////////////////////////////////////////////
////// Ventana de Aviso para Numeros con Tope y  ////////
////// Loetias Cerradas 						////////

function  VerOBservaciones(arraydeerror,_jugada,TopesdeNumeros)
{

	dhxWins3 = new dhtmlXWindows();	
	dhxWins3.setImagePath("codebase/imgs/");	

	w3 = dhxWins3.createWindow("w3",10, 80, 400, 300);
	w3.setText("== Observaciones ==  NO SE PUDO IMPRIMIR EL TICKET");
	dhxWins3.window("w3").setModal(true);
	dhxWins3.window("w3").centerOnScreen();
	dhxWins3.window("w3").denyResize();
	dhxWins3.window("w3").denyMove();
	//w3.attachObject('premio');
	bar = w3.attachToolbar();
	bar.addButton("Cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.addButton("Aceptar_", 2, "Aceptar Cambio de Cupos", "images/dhtmlxajax_icon.gif", "images/dhtmlxajax_icon.gif"); 
	bar.attachEvent("onClick", clickdeObservaciones);
	
	
	mygrid2 = w3.attachGrid();
	mygrid2.setImagePath("codebase/imgs/");
	mygrid2.setHeader("Motivo,Observaciones,ID,OP");
	mygrid2.setInitWidths("100,350")
	mygrid2.setColAlign("left,left")
	mygrid2.setColTypes("ro,ro,ro,ro");
	mygrid2.setSkin("dhx_skyblue");
	mygrid2.init();
	filaa=0;
	//// 1 = Cierre de Loterias
	for (ii=0;ii<=arraydeerror.length-1;ii++){
		if (arraydeerror[ii]==0)		
			{
			mygrid2.addRow(filaa,'Loteria Cerrada:,'+mygrid.cellByIndex(ii, 2).getValue()+','+mygrid.cellByIndex(ii, 4).getValue()+',1');
			filaa++;
			}
	}
	Anumero=_jugada.split(',');
	for (ii=0;ii<=TopesdeNumeros.length-1;ii++){
	
		numeros=Anumero[ii].split('|');
		fallas=TopesdeNumeros[ii].split('|');
		if (fallas[0]=='false'){		
			mygrid2.addRow(filaa,'Cupo Disponible:,Numero('+numeros[0]+') '+mygridv.cellByIndex(ii, 2).getValue()+' Cupo Dispoble:'+fallas[1]+','+ii+'|'+fallas[1]+',2');
			filaa++;
		}
	
	}

}
function Cierre_Loteria(){
		///////// Cerramos Loteria Activa ///////// 
					for (ii=0;ii<=mygrid2.getRowsNum()-1;ii++){
				    	if ( mygrid2.cellByIndex(ii, 3).getValue()==1 )	
								mygrid.deleteRow( mygrid2.cellByIndex(ii, 2).getValue() );
							//	mygrid2.addRow(ii,'Loteria Cerrada:,'+mygrid.cells(ii, 2).getValue()+','+mygrid.cells(ii, 4).getValue()+',1');
						}
				     for (yy=0;yy<=mygridv.getRowsNum()-1;yy++){
						for (ii=0;ii<=mygrid2.getRowsNum()-1;ii++){ 
							if ( mygrid2.cellByIndex(ii, 3).getValue()==1 )	{
							// alert(mygrid2.cellByIndex(ii, 2).getValue());
							// alert(mygridv.cellByIndex(yy, 5).getValue());
							 if ( mygrid2.cellByIndex(ii, 2).getValue()==mygridv.cellByIndex(yy, 5).getValue() )
							   
								mygridv.selectRow( yy );mygridv.deleteSelectedRows();
							}
						}
					 }
					 
					 
}

function clickdeObservaciones(id){
  
	switch(id){
		case "Cerrar_":
					Cierre_Loteria();					 
					 ///////////////////////////////////////	
					dhxWins3.window("w3").close();					
					break;			
			case "Aceptar_":
			  

					 for (yy=0;yy<=mygridv.getRowsNum()-1;yy++){
						for (ii=0;ii<=mygrid2.getRowsNum()-1;ii++){ 
							if ( mygrid2.cellByIndex(ii, 3).getValue()==2 )	{
								
							  fallas=mygrid2.cellByIndex(ii, 2).getValue();
							  vfallas=fallas.split('|');
							  
							
							 if ( parseInt(vfallas[0])==yy )
							    if (parseInt(vfallas[1])==0)
									{mygridv.cellByIndex(yy, 0).setValue(1);//mygridv.selectRowById( yy );//mygridv.deleteRow(yy); 
									
									break; }
								else
									{mygridv.cellByIndex(yy, 3).setValue(parseInt(vfallas[1])); break; }
							}
						}
					 }
					Eliminar_Linea();
					Cierre_Loteria();
					dhxWins3.window("w3").close();
					
					
					
					break;					
          }
		  
		   sumarticket();
}

/////////////////////// Cierre de Caja Punto de Venta /////////////////////
function CierreDeCaja(IDJ)
{
	vIDJ=IDJ;
	dhxWins2 = new dhtmlXWindows();	
	dhxWins2.setImagePath("codebase/imgs/");	
	var isWin = dhxWins2.isWindow("w3");
	w3 = dhxWins2.createWindow("w3",10, 80, 550, 500);
	w3.setText("Cierre de Caja (Punto de Venta)");
	dhxWins2.window("w3").setModal(true);
	dhxWins2.window("w3").centerOnScreen();
	dhxWins2.window("w3").denyResize();
	dhxWins2.window("w3").denyMove();
	
	bar = w3.attachToolbar();
	bar.addButton("Cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.addButton("Cierre_", 2, "Cierre de Caja", "images/select_all.gif", "images/select_all.gif"); 
	bar.attachEvent("onClick", bar_CierreDeCaja);
	
	dhxLayout = w3.attachLayout("3L");
	dhxLayout.cells("a").setText("Lista de Gastos");dhxLayout.cells("a").setWidth(200);
	dhxLayout.cells("b").setText("Informacion de Gastos");dhxLayout.cells("b").setWidth(250);
	dhxLayout.cells("c").setText("Cuadre de Caja(Desglose)");dhxLayout.cells("b").setHeight(190);
	//dhxLayout.cells("b").attachURL("cuadrecaja-1.php?diferencia=0");
	dhxLayout.cells("b").attachObject("RegistroGasto");
    
	mygridGastos = dhxLayout.cells("a").attachGrid();
	mygridGastos.setImagePath("codebase/imgs/");
	mygridGastos.setHeader("Id,Hora,Descripcion,Monto");
	mygridGastos.setInitWidths("30,60,105,80")
	mygridGastos.setColAlign("left,left,left,right")
	mygridGastos.setColTypes("ro,ro,ro,ro");
	mygridGastos.setSkin("dhx_skyblue");	
	mygridGastos.enableMultiselect(true);
    //mygridGastos.attachEvent("onCheckbox",doOnCheckLoteriasAdici);
	mygridGastos.init();
	mygridGastos.loadXML("gastos-2.php?IDJ="+IDJ+"&IDCtrr="+$('stAgencia').lang);

	mygridCuadre = dhxLayout.cells("c").attachGrid();
	mygridCuadre.setImagePath("codebase/imgs/");
	mygridCuadre.setHeader("Cant,Denominacion,Total,IDDE");
	mygridCuadre.setInitWidths("65,110,65")
	mygridCuadre.setColAlign("right,center,right,right")
	mygridCuadre.setColTypes("ed,ro,ro,ro");
	mygridCuadre.setSkin("dhx_skyblue");	
	mygridCuadre.enableMultiselect(true);
    mygridCuadre.attachEvent("onEditCell",editcell);
	mygridCuadre.init();

	mygridCuadre.loadXML("cuadrecaja-2.php?IDCierre=0");
	fromCuadre(IDJ);

}
function editcell(stage,rowId,cellIndex,newValue,oldValue){
      if ((stage==2)&&(newValue!=oldValue)){

		 if (!isNaN(parseFloat(newValue)) ){
			if ( parseFloat(newValue)>=0 ){
		 	valor=parseFloat(newValue)*parseFloat(mygridCuadre.cells(rowId, 3).getValue());
         	mygridCuadre.cells(rowId, 2).setValue(valor);
			}else{
					mygridCuadre.cells(rowId, 2).setValue('0');
					mygridCuadre.cells(rowId, 0).setValue('0');
			}
		  }else{
		  	mygridCuadre.cells(rowId, 2).setValue('0');
			mygridCuadre.cells(rowId, 0).setValue('0');
		  }
		 suma=0;
 		 for (i=0;i<=mygridCuadre.getRowsNum()-1;i++)	
			 if (mygridCuadre.cellByIndex(i, 2).getValue()!='')
							 suma=suma+parseFloat(mygridCuadre.cellByIndex(i, 2).getValue());
		 
		 $('Cuadre').value=suma;
		  $('Diferencia').value=parseFloat($('Dif').lang)-suma;
         return true;
      }
      return true;
   }
function sumatotalCuadre(){
  suma=0;
  for (i=0;i<=mygridCuadre.getRowsNum()-1;i++){
  	suma+=parseFloat(mygridCuadre.cells(i, 2).getValue());
  }
  $('Diferencia').value=suma;
}
function bar_CierreDeCaja(id){
	switch(id){
		case "Cerrar_":
					$('FromRegistroGasto').innerHTML='<div id="RegistroGasto"></div>';
					dhxWins2.window("w3").close();
					break;
					
		case "Cierre_":
					CierredeCagaFINAL();
					break;
					
	          }
}

function fromCuadre(IDJ){
		new Ajax.Request('cuadrecaja-1.php',{ parameters: {IDJ:IDJ,IDCtrr:$('stAgencia').lang},method:'post',onComplete: function(transport){
									var response = transport.responseText;
									$('RegistroGasto').innerHTML=response;
									response.evalScripts();	
									$('Descripcion').focus();
										
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
}

function CierredeCagaFINAL(){
	if (confirm('Esta Seguro de Realizar El CIERRE?')){
	  valores='';	
	 for (i=0;i<=mygridCuadre.getRowsNum()-1;i++)
  			valores=valores+mygridCuadre.cellByIndex(i, 3).getValue()+'-'+mygridCuadre.cellByIndex(i, 0).getValue()+',';
  		
	new Ajax.Request('cuadrecaja-3.php',{ parameters: {PremiosPagados:$('PremioP').value,TotalGastos:$('TotalG').value,TotalVenta:$('TotalV').value,IDJ:vIDJ,IDCtrr:$('stAgencia').lang,IDAp:$('IDAp').lang,valores:valores},method:'post',onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									if (!response[0])
										alert('No se puede realizar el Cierre: Intente de Nuevo!');	
									else{
													///// DEBO REALIZAR LA IMPRESION DEL CIEERRE!!!	
												new Ajax.Request('ticketcuadre.php',{ parameters: {IDCierre:response[1]},method:'post',onComplete: function(transport){																																									                                			 var response = transport.responseText;																	
											 //////////
											 $('printer').innerHTML=response;
											 print();
											 //////////
												},	
												onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
												});	
										
										  		dhxWins2.window("w3").close();	
										  		stop_func();
										  		dhxWins1.window("w1").close();
										 		
									     }
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	}
}
///////////////////////////////////////////////////////////////////////////
/////////////////////// Reporte de Gastos             /////////////////////
function GastosPuntodeVenta()
{
	dhxWins2 = new dhtmlXWindows();	
	dhxWins2.setImagePath("codebase/imgs/");	
	var isWin = dhxWins2.isWindow("w3");
	w3 = dhxWins2.createWindow("w3",10, 80, 600, 260);
	w3.setText("Gastos de Caja (Punto de Venta)");
	dhxWins2.window("w3").setModal(true);
	dhxWins2.window("w3").centerOnScreen();
	dhxWins2.window("w3").denyResize();
	dhxWins2.window("w3").denyMove();
	
	bar = w3.attachToolbar();
	bar.addButton("Cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.attachEvent("onClick", bar_GastosdeCaja);
	
	dhxLayout = w3.attachLayout("2U");
	dhxLayout.cells("a").setText("Registro de Gastos");
	dhxLayout.cells("b").setText("Lista de Gastos");dhxLayout.cells("b").setHeight(100);
	dhxLayout.cells("a").attachObject("RegistroGasto");
    
	mygridGastos = dhxLayout.cells("b").attachGrid();
	mygridGastos.setImagePath("codebase/imgs/");
	mygridGastos.setHeader("Id,Hora,Descripcion,Monto");
	mygridGastos.setInitWidths("30,65,110,80")
	mygridGastos.setColAlign("left,left,left,right")
	mygridGastos.setColTypes("ro,ro,ro,ro");
	mygridGastos.setSkin("dhx_skyblue");	
	mygridGastos.enableMultiselect(true);
    mygridGastos.attachEvent("onRowSelect",doSelectGastos);
	mygridGastos.init();
	mygridGastos.loadXML("gastos-2.php?IDJ="+$('IDJ').lang+"&IDCtrr="+$('stAgencia').lang);
	fromGastos();

}
function bar_GastosdeCaja(id){
	switch(id){
		case "Cerrar_":
					$('FromRegistroGasto').innerHTML='<div id="RegistroGasto"></div>';
					dhxWins2.window("w3").close();
	          }
}
function fromGastos(){
		new Ajax.Request('gastos.php',{ parameters: { op:1,IDGas:1},method:'post',onComplete: function(transport){
									var response = transport.responseText;
									$('RegistroGasto').innerHTML=response;
									response.evalScripts();	
									$('Descripcion').focus();
										
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
}
function RegistraGasto(){
			new Ajax.Request('gastos-1.php',{ parameters: { op:1,IDGas:$('IDGas').lang,IDJ:$('IDJ').lang,IDCtrr:$('stAgencia').lang,Descripcion:$('Descripcion').value,Monto:$('Monto').value},method:'post',onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									if (!response[0])
										alert(response[1]);
									else{
										mygridGastos.clearAll();
										mygridGastos.loadXML("gastos-2.php?IDJ="+$('IDJ').lang+"&IDCtrr="+$('stAgencia').lang);										fromGastos();										
									}
										
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
			
			
			
	
}
function EliminarGasto(){
			new Ajax.Request('gastos-1.php',{ parameters: { op:2,IDGas:$('IDGas').lang},method:'post',onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									if (!response)
										alert('El Registo no Fue Almacenado: Intente de Nuevo');
									else{
										mygridGastos.clearAll();
										mygridGastos.loadXML("gastos-2.php?IDJ="+$('IDJ').lang+"&IDCtrr="+$('stAgencia').lang)
										alert('El Registo fue Eliminado');
										fromGastos();
										}
										
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
}
function doSelectGastos(rowId,cellIndex)
{
	new Ajax.Request('gastos.php',{ parameters: { op:2,IDGas:mygridGastos.cells(rowId, 0).getValue()},method:'post',onComplete: function(transport){
									var response = transport.responseText;
									$('RegistroGasto').innerHTML=response;
									response.evalScripts();	
									$('Descripcion').focus();
										
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
}

/////// Calendario de los Reportes y Otras Opciones Adicionales////////////////
function setFrom() {
    dateFrom = new Date(cal1.date);
    mCal.setSensitive(dateFrom, dateTo);
    return true;
}
function selectDate1(date) {
    $('calInput1').value = cal1.getFormatedDate("%d/%m/%Y", date);
    $('calendar1').style.display = 'none';
    dateFrom = new Date(date);
    mCal.setSensitive(dateFrom, dateTo);
    return true;
}
function selectDate2(date) {
    $('calInput2').value = cal2.getFormatedDate("%d/%m/%Y", date);
    $('calendar2').style.display = 'none';
    dateTo = new Date(date);
    mCal.setSensitive(dateFrom, dateTo);
    return true;
}
function showCalendar(k) {
    $('calendar' + k).style.display = 'block';
}
function showTipo(valor){
	new Ajax.Request('reportes_ventasgeneral_1.php',{ parameters: { idTipo:valor },method:'post',onComplete: function(transport){
									var response = transport.responseText;
								    $('respuesta').innerHTML=response;
										
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
}
function vertipo(){
		
		valor=0;
		tipo=$('banca').checked;
		if (tipo) valor=1;//<- banca
		if (valor==0){
			tipo=$('Zona').checked;
			if (tipo) valor=2; //<- Zona
			if (valor==0){
				tipo=$('Intermediario').checked;
				if (tipo) valor=3;  //<- Intermediario
				if (valor==0){
					 valor=4;  // <- Agencia
				}
			}		
		}
		
		return 	valor;	
	
}

///////////////////////////////////////////////
//////////// Opciones de Impresion   /////////


//////////    Reporte de Ventas   ///////////
function Reporte_Pv1() {
			
			TipoSeleccionado=vertipo();
			ValorSeleccion=$('seleccion').value;
			Desde_Fecha=$('calInput1').value;
			Hasta_Fecha=$('calInput2').value;
			
			abrir('reportes_ventasgeneral_2?desdef='+Desde_Fecha+"&hastaf="+Hasta_Fecha+"&tipo="+TipoSeleccionado+"&seleccion="+ValorSeleccion,'Reporte de Ventas ',1,0,0,0,0,0,1,400,400,100,100,1);
			
			
}
//////////////////////////////////////////
function ckeck_Juegos(){
	var habilitado=false;
	for (ii=0;ii<=mygrid.getRowsNum()-1;ii++)
	{
		if (mygrid.cellByIndex(ii, 1).getValue()	== 1)
			{
				var habilitado=true;
				break;
			}		
	}
	return habilitado;
}

//////////////////////////////////////////
///////   Filtrado de Loterias //////////

function bar_Filtrado(id){
	switch(id){
		case "Cerrar_":
					dhxWins2.window("w3").close(); break;
		case "Asignar_":		
					for(var i=0; i<=mygrid.getRowsNum()-1;i++)
					   mygrid.cells2(i,1).setValue(0);
					   
					for(var i=0; i<=mygridFil.getRowsNum()-1;i++){
						valor=mygridFil.cells2(i,0).getValue();	
						if ( valor==1 ) { 
							marcadoHora= mygridFil.cells2(i,1).getValue(); 
							for(var x=0; x<=mygrid.getRowsNum()-1;x++)
								if ( marcadoHora==mygrid.cells2(x,3).getValue() ) {
								   mygrid.cells2(x,1).setValue(1);	rowId=x; state=true;
								   if (checkLoteria( mygrid.cells2(rowId, 4).getValue() ) ){
										if ( ckeck_Juegos() ) 
												$('idAceptar').disabled="";
											else	
												$('idAceptar').disabled="disabled";
												
											if (mygrid.cells2(rowId, 6).getValue()!=1 && state){
												cargar_formato(mygrid.cells2(rowId, 6).getValue());	
												layout1.cells("a").expand();
											}else{
												 if (mygrid.cells2(rowId, 6).getValue()!=1){
												  mygridAdicc.clearAll();  
												  layout1.cells("a").collapse();}
											}											
									}else
										  mygrid.deleteRow(rowId);
								}
						}
					}					
					dhxWins2.window("w3").close(); $('Numero').focus(); break;			
	          }
}
function Filtrado()
{
	dhxWins2 = new dhtmlXWindows();	
	dhxWins2.setImagePath("codebase/imgs/");	
	var isWin = dhxWins2.isWindow("w3");
	w3 = dhxWins2.createWindow("w3",10, 80, 250, 260);
	w3.setText("Filtrado");
	dhxWins2.window("w3").setModal(true);
	dhxWins2.window("w3").centerOnScreen();
	dhxWins2.window("w3").denyResize();
	dhxWins2.window("w3").denyMove();
	
	bar = w3.attachToolbar();
	bar.addButton("Cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.addButton("Asignar_", 2, "Asignar", "images/redo_dis.gif", "images/redo_dis.gif"); 
	bar.attachEvent("onClick", bar_Filtrado);
	bar.setSkin("dhx_black");  
	mygridFil = w3.attachGrid();
	mygridFil.setImagePath("codebase/imgs/");
	mygridFil.setHeader("Seleccion,Hora de Sorteo(s)");
	mygridFil.setInitWidths("60,150")
	mygridFil.setColAlign("left,left")
	mygridFil.setColTypes("ch,ro");
	mygridFil.setSkin("dhx_black");
	mygridFil.enableMultiselect(true);
	mygridFil.init();
	mygridFil.loadXML("filtrado.php");

}

/////////////////////////////////////////////
////// Copiar Ticket de Otros Dias /////////


function CopiarTKchg(){
	    $('frmCpySerial').innerHTML='<div id="CpySerial"><br />	<span> Indique Serial: </span>		<input name="" type="text"  id="iuSerial"/></div>';
		
		
		dhxWins2 = new dhtmlXWindows();	
		dhxWins2.setImagePath("codebase/imgs/");	
		var w3 = dhxWins2.isWindow("w3");
		w3 = dhxWins2.createWindow("w3",10, 80, 350, 180);
		w3.setText("Indique Serial de Ticket a Copiar");
		dhxWins2.window("w3").setModal(true);
		dhxWins2.window("w3").centerOnScreen();
		dhxWins2.window("w3").denyResize();
		dhxWins2.window("w3").denyMove();
		w3.attachObject('CpySerial');
		
		bar = w3.attachToolbar();
		bar.addButton("Cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif"); 
		bar.addButton("Aceptar_", 2, "Aceptar", "images/select_all.gif", "images/select_all.gif");
		bar.attachEvent("onClick", bar_CopiarTKchg);
	
}

function bar_CopiarTKchg(id){
	switch(id){
		case "Cerrar_":
					dhxWins2.window("w3").close();
					break;
		case "Aceptar_":
		 			serial=$('iuSerial').value;
					dhxWins2.window("w3").close();
					BuscaTIKCopiar(serial);
					break;			
	          }
			  
}

function BuscaTIKCopiar(Serial){
	var monto=0;
		new Ajax.Request('proc_php.php',{ parameters: { serial:Serial,op:5 },method:'post',onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									if (response[0]){
								     for( i=1; i<=response.length-1 ;i++){
										serpara=response[i].split('|');
										//$row1['numero'].'|'.$row1['IDLot'].'|'.$row2['NombrePantalla'].'|'.$row1['Monto'].'|'.$row1['Adicional'].'|'.$adicional;
										 monto=parseFloat(monto)+parseFloat(serpara[3]);	
										// alert(monto)
										 //alert(serpara[3])
										 MakeTicket_Idd(serpara[0],serpara[1],serpara[3],serpara[4]);
										 //parseFloat(serpara[3]);
									}
									//alert(monto);
									$('Total_Ticket').value=redond(parseFloat($('Total_Ticket').value),2)+redond(parseFloat(monto),2);	
									}else
									 alert('Este ticket no existe');
								},	
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	
	
	
}
function ClavaAsiBLI(msg){

$('FromClaveBLI').innerHTML='<div id="ClaveBLI"><table  border="0" cellpadding="0" cellspacing="0">  <tr>    <td colspan="3"><div align="center"><span  style="color:#036">Clave BLI'+msg+'</span></div></td>    </tr>  <tr>    <td>Usuario :</td>    <td colspan="2"><input   name="" type="text"  id="txUsu"  /></td>  </tr>  <tr>    <td >Clave :</td>    <td colspan="2"><input name="" type="password"  id="txClave"/></td>    </tr>  <tr>    <td>&nbsp;</td>    <td>&nbsp;</td>    <td>&nbsp;</td>  </tr>  <tr>    <td>&nbsp;</td>    <td >&nbsp;</td>    <td  align="right"><label>      <input type="submit" name="button" id="btnRegistro" value="Registrar"  onclick="EliminarRegiINst()"/>    </label></td>  </tr></table></div>';
	
}


///////////Procedmientos para BLOQUEO////////////////

function iVerAdd(){
	dats=$('iloteria').value;
	vfor=dats.split('|');
	if (vfor[1]!=1)
		new Ajax.Request('bloque1-2.php',{ parameters: { Formato:vfor[1] },method:'post',onComplete: function(transport){
										var response = transport.responseText;
										$('iAdd').innerHTML=response;
									},	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
									});	
	else
		$('iAdd').innerHTML='';
	
}
function mSelectDate(date) {
     $('fc1').value = cal1.getFormatedDate('%d/%c/%Y', date);
	    return true;
}
function Select1(){
	if ($('radio1').checked)
		$('fc1').disabled="";	
	else
		$('fc1').disabled="disabled";	
	
}
function Select2(){
	if ($('radio3').checked)
		$('iMonto').disabled="";	
	else
		$('iMonto').disabled="disabled";		
	
}
function SelecTree(){
	new Ajax.Request('ListaRelacion.php',{ method:'post',onComplete: function(transport){
										var response = transport.responseText;
											response.evalScripts();	
									},	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
									});	
	
}
function GrabarBlq(){
	
	//// Seleccion Uno
	if ($('radio1').checked){
		fecha=	$('fc1').value;
		selec1=1;
	}else{
		fecha=	'0';
		selec1=2;		
	}
	//// Seleccion Dos
	if ($('radio3').checked){
		monto=	$('iMonto').value;
		selec2=1;
	}else{
		monto=	'0';
		selec2=2;		
	}
	///Seleccion Loteria
	if ($('iloteria').value=='0'){
		Loteria=0;
		Add=0;
	}else{
		Loteria=$('iloteria').value;
		Add=$('iAddcional').value;
		
	}
	
		new Ajax.Request('bloque1-3.php',{ parameters: { idBlq:$('idBlq').value,fecha:fecha,selec1:selec1,monto:monto,selec2:selec2,Numero:$('iNumero').value,Aplicar:$('iAplicar').value,loteria:Loteria,Adicional:Add,idAplicar:$('iAplicar').lang},method:'post',onComplete: function(transport){
										var response = transport.responseText.evalJSON(true);
										
										if (response){
												$('iRelacion').innerHTML='';
												alert('Informacion Almacenada OK!');	
												mygrid.clearAll();
											    mygrid.loadXML("bloque2.php");			
										}else
												alert('La Informacion no se Almaceno Verifique los Datos!');	
																																																																																 
									},	
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
									});	
	
}