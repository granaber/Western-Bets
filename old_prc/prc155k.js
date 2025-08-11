var fecha;
var mygrid;
var lista_id;
var listacs_id
var mygrid1=0;
var mygrid2=0;
var dhxWins1,dhxWins2;
var dhtmlxCalendarLangModules = new Array();
var AudTik;
dhtmlxCalendarLangModules['es'] = {
	langname: 'es',
    dateformat: '%d/%c/%Y',
    monthesFNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    monthesSNames: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
    daysFNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
    daysSNames: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
    weekend: [0, 6],
    weekstart: 1,
    msgClose: "Cerrar",
    msgMinimize: "Minimiza",
    msgToday: "Hoy"
	}
function filterBy(){
			var tVal = $("serial").childNodes[0].value.toLowerCase();
			var aVal = $("letra").childNodes[0].value.toLowerCase();

			for( y=0; y< mygrid.getRowsNum();y++){
				var tStr = mygrid.cells2(y,0).getValue().toString().toLowerCase();
				var aStr = mygrid.cells2(y,1).getValue().toString().toLowerCase();
				if((tVal=="" || tStr.indexOf(tVal)==0) && (aVal=="" || aStr.indexOf(aVal)==0))
					mygrid.setRowHidden(mygrid.getRowId(y),false)
				else
					mygrid.setRowHidden(mygrid.getRowId(y),true)

			}
		}
function filterBy1(){
			var tVal = $("serial1").childNodes[0].value.toLowerCase();
			var aVal = $("letra1").childNodes[0].value.toLowerCase();

			for( y=0; y< mygrid1.getRowsNum();y++){
				var tStr = mygrid1.cells2(y,0).getValue().toString().toLowerCase();
				var aStr = mygrid1.cells2(y,1).getValue().toString().toLowerCase();
				if((tVal=="" || tStr.indexOf(tVal)==0) && (aVal=="" || aStr.indexOf(aVal)==0))
					mygrid1.setRowHidden(mygrid1.getRowId(y),false)
				else
					mygrid1.setRowHidden(mygrid1.getRowId(y),true)

			}
		}
function filterBy2(){
			var tVal = $("serial2").childNodes[0].value.toLowerCase();
			var aVal = $("letra2").childNodes[0].value.toLowerCase();

			for( y=0; y< mygrid2.getRowsNum();y++){
				var tStr = mygrid2.cells2(y,0).getValue().toString().toLowerCase();
				var aStr = mygrid2.cells2(y,1).getValue().toString().toLowerCase();

				if((tVal=="" || tStr.indexOf(tVal)==0) && (aVal=="" || aStr.indexOf(aVal)==0))
					mygrid2.setRowHidden(mygrid2.getRowId(y),false)
				else
					mygrid2.setRowHidden(mygrid2.getRowId(y),true)

			}
		}


	function trim(cadena)
	{

		for(i=0; i<cadena.length; )

		{

			if(cadena.charAt(i)==" ")

				cadena=cadena.substring(i+1, cadena.length);

			else

				break;

		}



		for(i=cadena.length-1; i>=0; i=cadena.length-1)

		{

			if(cadena.charAt(i)==" ")

				cadena=cadena.substring(0,i);

			else

				break;

		}



		return cadena;

	}



	//**



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



	function cerraventana()

	{

	 window.close()

	}

	//**************************************************************************/



	function tandas(campo, campo1) {

		var camp = campo.value;



		if (camp == "Si") {

			campo1.value = "1";

			campo1.disabled = false;

		}

		else {

			campo1.value = "0";

			campo1.disabled = true;

		}

		return;

	}






	function handleEnter (field, event) {

			var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;

			if (keyCode == 13) {

				//var i;

				//for (i = 0; i < field.form.elements.length; i++)

					//if (field == field.form.elements[i])

						//break;

				//i = (i + 1) % field.form.elements.length;

				//field.form.elements[i].focus();

				return false;

			}

			else

			return true;

		}



	function cargarcampos()

	{

			   Calendar.setup({

				   inputField     :    "fc",           // id of the input field

				   ifFormat       :    "%e/%m/%Y",    // format of the input field

				   align          :    "Tl",           // alignment (defaults to "Bl")

				   singleClick    :    true,

				   onUpdate       :    catcalc

				 });

	}



	function catcalc(cal) {

	  var date = cal.date;

	   var field = $("fc");

		mes=date.print("%m");

		if (parseInt(mes)<=9){

			mes2=mes.substring(1,2);

		}

		else{

			mes2=mes;

		}

			field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");

		}



	function cargarcampos2()

	{

			   Calendar.setup({

				   inputField     :    "fecha_2",           // id of the input field

				   ifFormat       :    "%e/%m/%Y",    // format of the input field

				   align          :    "Tl",           // alignment (defaults to "Bl")

				   singleClick    :    true,

				   onUpdate       :    catcalc2

				 });

	}



	function catcalc2(cal) {

	  var date = cal.date;

	   var field = $("fecha_2");



		mes=date.print("%m");

		if (parseInt(mes)<=9){

			mes2=mes.substring(1,2);

		}

		else{

			mes2=mes;

		}

			field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");

		}





	function cargarcampos6()

	{

			   Calendar.setup({

				   inputField     :    "fc",           // id of the input field

				   ifFormat       :    "%e/%m/%Y",    // format of the input field

				   align          :    "Tl",           // alignment (defaults to "Bl")

				   singleClick    :    true,

				   onUpdate       :    catcalc6

				 });

	}



	function catcalc6(cal) {

	  var date = cal.date;

	   var field = $("fc");



		  mes=date.print("%m");

		if (parseInt(mes)<=9){

			mes2=mes.substring(1,2);

		}

		else{

			mes2=mes;

		}

			field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");



		jsonvalores('fc');





		}



	var http_request = false;

	var http_request3 = false;



function makeRequest(url) {
	        $("menu1").innerHTML = '';  $("printer").innerHTML='';
			 new Ajax.Request(url,{ parameters: { idt: $("usu").title },
			 method:'get',
				onComplete: function(transport){
				var response = transport.responseText ;
					$("tablemenu").innerHTML = response;
					response.evalScripts();
			   },

			   onCreate: function(){
					$("tablemenu").innerHTML = '<img src="media/ajax-loader.gif" />';
			   },
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });

		}



	function makeRequestMENU(url) {

		 var element =  $("tablemenu2");

		  new Ajax.Request(url,{

			 method:'get',

				onSuccess: function(transport){

				var response = transport.responseText ;

					element.innerHTML = response;
					response.evalScripts();

			   },

				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

			  });

		}



	function makeRequestjug(url) {

			idc=$('con').title;
			var element =  $("tablemenu");
			verestatustabla(2);
			if (idc!=-4 && idc!=-5){
			new Ajax.Request(url+"&idc="+idc,{
			 method:'get',
				onComplete: function(transport){
				var response = transport.responseText ;
					element.innerHTML = response;
					response.evalScripts();
					  if (idc==-2 || idc==-1)
					   {
						$va=getCookie('cons');
						$vb=getCookie('nom');
						$('cons').value=($va!='*')?$va:'';
						$('nom').value=($vb!='*')?$vb:'';
						$('cons').focus();
						$('cons').select();
					   }
					   else{
						$('v1').focus();
						$('v1').select();
						$('valida').focus();
						$('valida').select();
					   }

			   },
			   onCreate: function(){
				element.innerHTML = '<img src="media/ajax-loader.gif" />';
			   },
			   onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			   });

			}else
			{
				alert ('Lo siento pero usted no tiene la autorizacion para Vender!');
			}
		}



	var  yq = false;

	function makeRequestJAVA(url) {



		 http_request = new XMLHttpRequest();



			var element =  $("tablemenu");

			/*http_request.onreadystatechange= alertContents;*/

			http_request.open('GET', url, true);

			http_request.onreadystatechange = function() {

					if(ParceJS(http_request.responseText) && yq==false) {

						 yq = true;

						 element.innerHTML = http_request.responseText;

					}//if(ParceJS(http_request.responseText))

					}

		   http_request.send(null);

		}

	function makeRequestSP(url) {
		var element =  $("tablemenu");
		 new Ajax.Request(url,{

								method:'get',	onComplete: function(transport){
									var response = transport.responseText ;
										 element.innerHTML = response;
										response.evalScripts();
								},onCreate: function(){
									$("tablemenu").innerHTML  = '<img src="media/ajax-loader.gif" />';
								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});


		}





	/*Funcion para div especificos*/

	 function makeResEsp2(url,obj,id) {

			var element =  $(obj);
			turl=url;

			new Ajax.Request( turl,{ method:'get',
    		onComplete: function(transport){
			 var response = transport.responseText;
			 element.innerHTML = response;
			 response.evalScripts();
			 },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });

		   /* Segunda Carga*/

		   var element2 =  $('parametrodeconfigu');

		   new Ajax.Request( 'jornada-1.php?opc='+id,{ method:'get',
    		onComplete: function(transport){
			 var response = transport.responseText;
			 element2.innerHTML = response;
			 response.evalScripts();
			 },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });
		}





	 function makeResEsp(url,obj) {

			var element =  $(obj);
			if (url=='jornada-1.php')
			{
			 $('busq').style.display="none";
			 valorc5=$("fc").value;
			 turl=url+'?opc=-1';
			}

			if (url=='jornada-1-1.php')
			{
			 $('busq').style.display="none";
			 valorc=$("fc").value;
			 turl=url+"?fc="+valorc;
			}

			if (url=='jornada-2.php')
			{
			valorc=$("cmbCarreras").value;
			valorc2=$("cmbTandas_3").value;
			valorc3=$("cmbTandas_1").value;
			valorc4=$("nj").title;
			turl=url+"?nc="+valorc+"&ntp4="+valorc2+"&ntdp="+valorc3+"&nj="+valorc4;
			}

			new Ajax.Request( turl,{ method:'get',
    		onComplete: function(transport){
			 var response = transport.responseText;
			 element.innerHTML = response;
							if (url=='jornada-1.php')
								 $("fecha_2").value=valorc5;
 		   },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });
}







	/* Cuadro de texto*/

	function calcular(g)

	{

	 k=0;

	 valor="celda"+g;



	 for (var i = 1; i < 14; i++)

	  {



		celda= $(valor+i);

		if (celda.style.backgroundColor=='rgb(102, 255, 51)')

		 {

		  k++;

		 }

	  }

		 switch(g)

		  {

		   case "1":

			document.form1.v1.value=k;

			break;

		   case "2":

			document.form1.v2.value=k;

			break;

		   case "3":

			document.form1.v3.value=k;

			break;

		   case "4":

			document.form1.v4.value=k;

			break;

		   case "5":

			document.form1.v5.value=k;

			break;

		   case "6":

			document.form1.v6.value=k;

			break;



		  }



		  document.form1.Total.value=(document.form1.v1.value*document.form1.v2.value*document.form1.v3.value*document.form1.v4.value*document.form1.v5.value*document.form1.v6.value);



	}









	/*****************************************/



	function pulsart(e,objs) {

	  tecla = document.all ? e.keyCode : e.which;

	 /* ;*/

	  if(tecla==13)

		{

		/*  alert (objs);*/

		  $(objs).focus();

		  $(objs).select();

		}

		else

		{

			 if (objs='nombre')

			 {

				idg=$('grupo').value;

				vidcn=$('c_idc').value;

				$('nomidcn').innerHTML=vidcn+idg;

				//$('nomidcn').value=

			 }

		}

	}









	function pulsartcl(e,objs,maximo) {

	  tecla = document.all ? e.keyCode : e.which;

	  oEvent= e || window.event;



	   var txtfield = oEvent.target || oEvent.srcElement;

	 /* ;*/



	  if(tecla==13)

		{

		if (parseInt(txtfield.value)>=1 && 	 parseInt(txtfield.value)<=maximo) {

		/*  alert (objs);*/

		  $(objs).focus();

		  $(objs).select();



		  v='t'+txtfield.id;

		  //alert(v);

		  switch(txtfield.value)

		  {

			  case '1':

			  $(v).innerHTML='Uno';break;

			  case '2':

			  $(v).innerHTML='Dos';break;

			  case '3':

			  $(v).innerHTML='Tres';break;

			  case '4':

			  $(v).innerHTML='Cuatro';break;

			  case '5':

			  $(v).innerHTML='Cinco';break;

			  case '6':

			  $(v).innerHTML='Seis';break;

			  case '7':

			  $(v).innerHTML='Siete';break;

			  case '8':

			  $(v).innerHTML='Ocho';break;

			  case '9':

			  $(v).innerHTML='Nueve';break;

			  case '10':

			  $(v).innerHTML='Diez';break;

			  case '11':

			  $(v).innerHTML='Once';break;

			  case '12':

			  $(v).innerHTML='Doce';break;

			  case '13':

			  $(v).innerHTML='Trece';break;

			  case '14':

			  $(v).innerHTML='Catorce';break;

			  default:

			  $(v).innerHTML='Partir';break;

		  }



		}else {

		txtfield.value='';

		}

	  }

	 // alert(tecla);

	  if(tecla==107)

		{

		ok=0;

		// alert(tecla);

		  for (i=1;i<=$('carr').title;i++)

		  {

			  if (parseInt($('v'+i).value)!=0 && $('v'+i).value!='')

			  {

				  ok=0;

			  }else {

				  ok=1;

				  break;

			  }

		  }

		  if (ok==0) {

		   $('idmonto').disabled='';

		   $('idmonto').focus();

		   $('idmonto').select();

		  }

		}

	}



	//************************* Valida la tecla presionada **************************************




	function permite(elEvento, permitidos) {

	  // Variables que definen los caracteres permitidos

	  var numeros = "0123456789";

	  var caracteres = " abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ+-";

      var caracteres2 = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-";

	  var numeros_caracteres = numeros + caracteres;

	  var teclas_especiales = [8, 37, 39, 46];

	  // 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha





	  // Seleccionar los caracteres a partir del parámetro de la función

	  switch(permitidos) {

		case 'num':

		  permitidos = numeros;

		  break;

		case 'car':

		  permitidos = caracteres;

		  break;

		case 'num_car':

		  permitidos = numeros_caracteres;

		  break;

		case 'num_car2':

		  permitidos = caracteres2;

		  break;

	   	case 'num_car3':

		  permitidos =  numeros + caracteres2;

		  break;

	  }



	  // Obtener la tecla pulsada

	  var evento = elEvento || window.event;

	  var codigoCaracter = document.all ? elEvento.keyCode : elEvento.which;

	  var caracter = String.fromCharCode(codigoCaracter);



	  // Comprobar si la tecla pulsada es alguna de las teclas especiales

	  // (teclas de borrado y flechas horizontales)

	  var tecla_especial = false;

	  for(var i in teclas_especiales) {

		if(codigoCaracter == teclas_especiales[i]) {

		  tecla_especial = true;

		  break;

		}

	  }

	// alert(permitidos.indexOf(caracter) != -1 || tecla_especial);

	  // Comprobar si la tecla pulsada se encuentra en los caracteres permitidos

	  // o si es una tecla especial

	  return permitidos.indexOf(caracter) != -1 || tecla_especial;

	}






	//********************************************************************************************





	function cambiar_grupo()

	{

				idg=$('grupo').value;

				vidcn=$('c_idc').value;

				$('nomidcn').innerHTML=vidcn+idg;

	}

	 function _grabcont(url) {




			/*

			***** captar los datos para ser organizados *-****

			*/

			tabl_x =  $("btngrb").alt;
			valorc=$("cmbCarreras").value;

			var listaconfig = new Array();
			retirados="";
			cantcba="";

			for (j=1;j<=tabl_x;j++)
			{

			 listaconfig[j]=$("t"+j).title+"*";

			 for (i=1;i<=valorc;i++)
			 {
			  if($("chek"+j+"-"+i).checked==true)
			  {
				listaconfig[j]+=i+"-";
			  }
			 }
				listaconfig[j]+=0;
			}



			for(i=1;i<=valorc;i++)
			{
				 cantcba+=$("ejem"+i).value+'|';
				 retirados+=$("reti"+i).value+'|';
			}



			var imploded=listaconfig.join('|');
			var element =  $("divresul");

			new Ajax.Request(url+"?config="+imploded+"&nc="+valorc+"&fc="+$("fecha_2").value+"&hp="+$("_hipod").value+"&nj="+$("nj").title+"&dp="+$("cmbTandas_1").value+"&ta="+$("cmbTandas_2").value+"&p4="+$("cmbTandas_3").value+"&ret="+retirados+"&fab="+cantcba+"&est="+$("testatus").value+"&macuare="+$('Macuare').value,{
   		 method:'get',
    		onComplete: function(transport){
    		var response = transport.responseText;
 			element.innerHTML = response

 		   },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });




		}





	function validar(oEvent)
		 {

			 oEvent= oEvent || window.event;
			 var txtfield = oEvent.target || oEvent.srcElement;

			 var element =  $("tablemenu");

			 var imae = $("img"+txtfield.id);
			 var btn=$("btnguardar");


		    new Ajax.Request('validaform.php?'+txtfield.id+'='+encodeURIComponent(txtfield.value),{
			 method:'get',asynchronous:false	,	onSuccess: function(transport){
		    var arrInfo = transport.responseText.evalJSON() ;
			alert(arrInfo.valid);
						   if (eval(arrInfo.valid)){
							  imae.style.display="none";
							  txtfield.valid=true;

							  if (btn.lang==txtfield.id) {btn.lang='';btn.disabled="";}

						  } else {

							  txtfield.valid=false;
							  imae.title=arrInfo.mesanje;
							  imae.style.display="";
							  btn.lang=txtfield.id;
							  btn.disabled="disabled";
						  }


		 		   },
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });

	 if (btn.lang!='') {  btn.disabled="disabled"; } else { btn.disabled=""; }
}





function grabar_datosJuego()
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

			// alert(element9);

			 var element =  $("tablemenu1");

			alert("agregarjuego-1-2.php?jn="+element1+"&fc="+element2+"&co="+element9+"&am="+element3+"&jt="+element4+"&je="+element5+"&nj="+element6+"&pr=1&cc="+element7+"&ce="+element8+"&cfn="+element10+"&fdc="+element11+"&frm="+element12+"&rps="+element13+"&proc="+element14+"&op1="+element15+"&op2="+element16+"&op3="+element17);
			 new Ajax.Request("agregarjuego-1-2.php?jn="+element1+"&fc="+element2+"&co="+element9+"&am="+element3+"&jt="+element4+"&je="+element5+"&nj="+element6+"&pr=1&cc="+element7+"&ce="+element8+"&cfn="+element10+"&fdc="+element11+"&frm="+element12+"&rps="+element13+"&proc="+element14+"&op1="+element15+"&op2="+element16+"&op3="+element17,{
			 method:'get',
				onSuccess: function(transport){
				var response = transport.responseText;
	            alert('Registro Almacenado!');
			   },

				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

			  });




				makeRequestSP('agregarjuego-1-1.php');



		 }



	function elimnar_datosJuego()

		 {

			 /*alert("Hola");*/

			 desci=confirm("Desea eliminar este Registro?");

			 if (desci==true){



			 element6 = $("numerJ").title;


			 var element =  $("tablemenu1");

			  new Ajax.Request('agregarjuego-1-2.php?nj='+element6+'&pr=2',{
			 method:'get',
				onSuccess: function(transport){
				var response = transport.responseText;
	            alert('Registro Almacenado!');
			   },

				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

			  });



				makeRequestSP('agregarjuego-1-1.php');



			 }

		 }








		function grabar_consecionario()
	 {

			 if ($("c_idc").value!='')
				 element1 = $("c_idc").value+$("grupo").value;
			 else
			 	element1 = '';
			 element2 = $("nombre").value;
			 element3 = $("direccion").value;
			 element4 = $("estado").value;
			 element5 = $("municipio").value;
			 element6 = $("telefono").value;
			 element7 = $("grupo").value;
			 element8 = $("estatus").value;
			 element9 = $("n_idr").title;
			 element10 = $("cel").value;
			 element11 = $("email").value;
			 element12 = $("resp").value;

			 var element =  $("tablamenu1");

			 new Ajax.Request('consecionario-1-2.php?idc='+element1+'&nm='+element2+'&dr='+element3+'&est='+element4+'&mup='+element5+'&tel='+element6+'&idg='+element7+'&es='+element8+'&idr='+element9+'&pr=1&cel='+ element10+'&mail='+element11+'&resp='+ element12+"&idt="+$("usu").title+"&tb="+$('tbl').value,{ method:'post',onSuccess: function(transport){
				    var response = transport.responseText.evalJSON(true) ;
					if (response[0]){
						dhxWins1.window("w1").close();
						nalert('ACTUALIZADO.',' LA INFORMACION FUE ALMACENDA CORRECTAMENTE!');
		   	    	    makeRequest('consecionario-1-1.php');
					}
					else{
						switch (response[1]){
								case 0:
									nalert('ERROR.','NO SE PUEDE ACTUALIZAR /nINTENTE DE NUEVO!');break;
								case 1:
									nalert('ERROR.','LA LETRA NO PUEDE ESTAR EN BLANCO!');break;
								case 2:
									nalert('ERROR.','EL NOMBRE NO PUEDE ESTAR EN BLANCO!');break;
								case 3:
									nalert('ERROR.','LA DIRECCION NO PUEDE ESTAR EN BLANCO!');break;
								case 4:
									nalert('ERROR.','EL ESTADO NO PUEDE ESTAR EN BLANCO!');break;
								case 5:
									nalert('ERROR.','EL MUNICIPIO NO PUEDE ESTAR EN BLANCO!');break;
								case 6:
									nalert('ERROR.','LA LETRA YA EXISTE');break;
						}
					}

				   },
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });


	}







	function elimnar_consecionario()
		 {
			 desci=confirm("Desea eliminar este Registro?");
			 if (desci==true){
			 element1 = $("n_idr").title;
			 new Ajax.Request('consecionario-1-2.php?idr='+element1+'&pr=2&idt='+$("usu").title,{
			 method:'get',
				onSuccess: function(transport){
				var response = transport.responseText.evalJSON(true) ;

				if (response)
				{
					nalert('ACTUALIZADO.','Registro Borrado con Exito!!');
				}else{
					nalert('ERROR.','Este Registro no puede ser borrado tiene Jugada!!');
				}
			   },
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });
				dhxWins1.window("w1").close();
				makeRequest('consecionario-1-1.php');
			 }
		 }


var novalido2=true;
	function validar2(oEvent)
			 {
			  oEvent= oEvent || window.event;
			  var txtfield = oEvent.target || oEvent.srcElement;
     		  var element =  $("tablemenu");
			  if (txtfield.id=='c_idc')
			  {
			  scr='validaform2.php?'+txtfield.id+'='+encodeURIComponent(txtfield.value)+'&nomidcn='+$('grupo').value;
			  }
			  else if (txtfield.id=='grupo')
			  {
			  scr='validaform2.php?'+txtfield.id+'='+encodeURIComponent(txtfield.value)+'&nomidcn='+$('c_idc').value;
			  }
			  else
			  {
			  scr='validaform2.php?'+txtfield.id+'='+encodeURIComponent(txtfield.value);
			  }
	var btn=$("btnguardar");
	 new Ajax.Request(scr,{
			 method:'get',asynchronous:false	,	onSuccess: function(transport){
				var arrInfo = transport.responseText.evalJSON() ;

							var imae = $("img"+txtfield.id);
							if (txtfield.id=='grupo')
							 {
							 var imae = $("imgc_idc");
							 }
							 /*var btn=$("btnguardar");
						  */

						   if (eval(arrInfo.valid)){
							  imae.style.display="none";
							  txtfield.valid=true;

							  if (btn.lang==txtfield.id) {btn.lang='';btn.disabled="";}

						  } else {

							  txtfield.valid=false;
							  imae.title=arrInfo.mesanje;
							  imae.style.display="";
							  btn.lang=txtfield.id;
							  btn.disabled="disabled";
						  }
				   },
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });

	 if (btn.lang!='') {  btn.disabled="disabled"; } else { btn.disabled=""; }
}







	function popcargar()

	{

	// alert ('Bienvenido al SPH Online.net ');

	  // for (i=0;i<=1000000;i++){}

	   v=$("btn2").title;

	   var arrInfo = v.split("|");

		for (i=0;i<=arrInfo.length;i++)

		{



			$(arrInfo[i]).style.display="none";



		}



	}



	var pop1=0;





	function popunnew()

	{





	  if (pop1==0){

	  pop1 = new xPopup(

				 'no',       // timer type

				 0,           // timeout in ms

				 's',             // from, on show

				 'ne',           // to, on show

				 'ne',             // to, on hide

				 'popupStyle',    // style class name

				 'popup1',        // id

				 'login.php');

	  }else{

		  top.pop1.show();

	  }



	}



	function logouto()

	{

		$("con").style.display="none";

		$("fch").style.display="none";

		$("jnd").style.display="none";

		vx=$("usu").title;

		$("usu").style.display="none";

		$("est").style.display="none";




		$("news").style.display="none";



		setCookie('rndusr', 0);

		$("menu1").innerHTML="";
		$("tablemenu").style.display="none";
		$("tablemenu").innerHTML="";

		$("topmenu").innerHTML="";



		$("p").bgColor="#000000";

		$("fd1").bgColor="#000000";

		$("fd2").bgColor="#000000";



		$("topmenu2").style.display="";

		$("tablemenu2").style.display="";

		$("menu2").style.display="";

		$("menu3").style.display="";
		$("box_g").style.display="";



		 new Ajax.Request("logon.php?op=0&usu="+$("usu").title,{
			 method:'get',	onSuccess: function(transport){
				var response = transport.responseText.evalJSON(true) ;
				cero=response;
			   },
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });

		 mensajesactualiza(2);



	}





	//************************************************************************************************************************************





	function ParceJS( ObjResponse )

	{



		 if ( "" == ObjResponse)

		   {

			  //alert("No se han enviado parametros a parcear");

			  return false;

		   }



		  //variable que almacena el texto del codigo javascript

		  var TextJs = "";

		  //almacena la cadena de texto a recorrer para encontrar el archivo incluido en lso js's

		  var TextSrc="";

		  //arreglo que almacena cada uno de los archivos incluidos llamados por src

		  var FileJsSrc = new Array();

		  var counter=0;

		  //guarda las porciones siguientes de codigo de HTML que se van generando por cada recorrido del parceador

		  var TextNextHtml;

		  var PosJSTagStart;

		  var PosJSTagEnd;

		  //guarda la posicion de la primera ocurrencia del parametro src

		  var SrcPosIni;

		  //guarda la posicion de ocurrencia de las comillas

		  var SrcPosComilla;

		  while (ObjResponse.indexOf("<script") > 0)

		 {

				/*encuentra la primera ocurrencia del tag <script*/

				PosJSTagStart = ObjResponse.indexOf("<script");

				/*corta el texto resultante desde la primera ocurrencia hasta el final del texto					   */

				TextNextHtml = ObjResponse.substring( PosJSTagStart,ObjResponse.length);

				/*encuentra la primera ocurrencia de finalizacion del tag >, donde cierra la palabra javascript*/

				PosJSTagEnd = TextNextHtml.indexOf(">");

				//captura el texto entre el tag <script>

				TextSrc = TextNextHtml.substring(0,PosJSTagEnd);

				//verficica si tiene le texto src de llamado a un archivo js

				//alert (TextSrc.indexOf("src") );

				if ( TextSrc.indexOf("src") > 0)

				{

					//posicion del src



					 SrcPosIni = TextSrc.indexOf( "src" );

					 //almacena el texto desde la primera aparicion del src hasta el final

					 TextSrc = TextSrc.substring(SrcPosIni, PosJSTagEnd);

					 //lee la posicion de la primer comilla

					 SrcPosComilla = TextSrc.indexOf( '"' );

					 //arma el texto, desde la primer comilla hasta el final,se le suma 1, para pasar la comilla inicial

					 TextSrc = TextSrc.substring(SrcPosComilla + 1,PosJSTagEnd);

					 //posicion de la comilla final

					 SrcPosComilla = TextSrc.indexOf('"');

					 //lee el archivo

					 SrcFileJs = TextSrc.substring(0, SrcPosComilla);

					 FileJsSrc[counter] = SrcFileJs;

					 counter++;



				}



				//TextNextHtml, nuevo porcion de texto HTML empezando desde el tag script

				TextNextHtml = TextNextHtml.substring(PosJSTagEnd + 1,ObjResponse.length);

				//encuentra el final del script

				objJSTagEndSc = TextNextHtml.indexOf("script>");



				/*recorre desde la primera ocurrencia del tag > hasta el final del script < /script>*/

				//se le resta 2 al objJSTagEndSc, para restarle el < /

				objJSText = TextNextHtml.substring(0, objJSTagEndSc - 2);



				ObjResponse = TextNextHtml;

				TextJs = TextJs + "\n" + objJSText;



		 }

			//alert("FinalJS\n\n"+objJs);



			// Agrego los scripts dentro del encabezado

			EvalScript = document.createElement("script");

			EvalScript.text = TextJs;

			document.getElementsByTagName('head')[0].appendChild(EvalScript);

			// Agrego los scripts incluidos dentro del encabezado

			for (i = 0; i <  FileJsSrc.length ;i++ )

			{

				EvalScript = document.createElement("script");

				EvalScript.src = FileJsSrc[i];

				document.getElementsByTagName('head')[0].appendChild(EvalScript);

			}

		return true;

	}







	///**************************************************************//////////////////////



	function cargarcampos3()

	{

			   Calendar.setup({

				   inputField     :    "fc",           // id of the input field

				   ifFormat       :    "%e/%m/%y",    // format of the input field

				   align          :    "Tl",           // alignment (defaults to "Bl")

				   singleClick    :    true,

				   onUpdate       :    catcalc3

				 });



	}

	function catcalc3(cal) {

	  var date = cal.date;



	  var field = $("fc");



		mes=date.print("%m");

		if (parseInt(mes)<=9){

			mes2=mes.substring(1,2);

		}

		else{

			mes2=mes;

		}

			field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");



		 oXmlHttp  = new XMLHttpRequest();

		 var element =  $("selej");



		 oXmlHttp.open('GET','verifijoranada.php?fecha='+field.value+'&tipo=1',true);



		 oXmlHttp.onreadystatechange = function()

			{

			 element.innerHTML = oXmlHttp.responseText;

			}

		oXmlHttp.send(null);



	}



	function cargarcampos5()

	{

			   Calendar.setup({

				   inputField     :    "fc",           // id of the input field

				   ifFormat       :    "%e/%m/%y",    // format of the input field

				   align          :    "Tl",           // alignment (defaults to "Bl")

				   singleClick    :    true,

				   onUpdate       :    catcalc5

				 });



	}



	function catcalc5(cal) {

	  var date = cal.date;

	  var field = $("fc");



		mes=date.print("%m");

		if (parseInt(mes)<=9){

			mes2=mes.substring(1,2);

		}

		else{

			mes2=mes;

		}

			field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");





		jsonvalores('fc');

		verifcarjj();



	}



	function cargarcampos7()

	{

			   Calendar.setup({

				   inputField     :    "fc",

				   ifFormat       :    "%e/%m/%y",

				   align          :    "Tl",

				   singleClick    :    true,

				   onUpdate       :    catcalc7

				 });



	}



	function catcalc7(cal) {

	  var date = cal.date;

	  var field = $("fc");



		mes=date.print("%m");

		if (parseInt(mes)<=9){

			mes2=mes.substring(1,2);

		}

		else{

			mes2=mes;

		}

		field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");



		jsonvalores2(field.value);





	}



	function datosganadores()
		 {

			 element1 = $("fc").value;
			 element2 = $("sjornada").value;
			 if (element2==''){
				 element2 =0;
			 }

		new Ajax.Request('verifijoranada.php?fecha='+element1+'&idcn='+element2+'&tipo=4',{
								method:'get',	onSuccess: function(transport){
								var response = transport.responseText ;
								$("lganadores").innerHTML=response;
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});



	}



	///************************* Graba Ganadores

	function grabardatosganadores()

		 {   sccc();

			 element1 = $("fc").value;

			 element2 = $("sjornada").value;

			 ///************************************************************

			 jugada='';

			 for(var x=1;x<=parseInt($('carr').title); x++)

			   {

				   jugada+='|';

				for (var y=1;y<=parseInt($('ejemp').title);y++)

				{

					celda= $('celda'+x+''+y);

					if (celda.title!='')

					{

						if (celda.style.backgroundColor=='rgb(102, 255, 51)')

						{

						   jugada+=y+'-';

						}

					}//if (celda.title!='')

				 }//**** For y

			   }//**** For x



			 oXmlHttp  = new XMLHttpRequest();



			oXmlHttp.open('GET','verifijoranada.php?fecha='+element1+'&idcn='+element2+'&tipo=2',true);





			oXmlHttp.onreadystatechange = function() {

						 element.innerHTML = oXmlHttp.responseText;

					}



				oXmlHttp.send(null);



				makeRequest('agregarjuego-1-1.php');





		 }





	function datosverjugada(serial,concesionario)
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
			new Ajax.Request('ver_jugada-1-1.php?cs='+cns+'&idcn='+jnd+'&idj='+jgd,{
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

	///******************************************Scroll ****************************************************

	function sccc()

	{

		var up = xGetElementById('upBtn');

		var dn = xGetElementById('dnBtn');

		var sc = xGetElementById('vScroller1');

		up.onmouseover = onScrollUpStart;

		up.onmouseout = onScrollStop;

		xMoveTo(up, 0, xPageY(sc));

		dn.onmouseover = onScrollDnStart;

		dn.onmouseout = onScrollStop;

		xMoveTo(dn, 0, xPageY(sc) + xHeight(sc) - xHeight(dn));



	}



	function sccc2()

	{



		esno=$('bserial').lang;

		var datos=esno.split("||");

		$('f'+datos[0]).style.backgroundColor=datos[1];

	}

	var scrollActive = false, scrollStop = true, scrollIncrement = 10, scrollInterval = 60;



	function onScrollDnStart()

	{

	  if (!scrollActive) {

		scrollStop = false;

		onScrollDn();

	  }

	}

	function onScrollDn()

	{

	  if (!scrollStop) {

		scrollActive = true;

		setTimeout('onScrollDn()', scrollInterval);

		var sc = xGetElementById('vScrollee1');

		var y = xTop(sc) - scrollIncrement;

		if (y >= -(xHeight(sc) - xHeight('vScroller1'))) {

		  xTop(sc, y);

		}

		else {

		  scrollStop = true;

		  scrollActive = false;

		}

	  }

	}

	function onScrollUpStart()

	{

	  if (!scrollActive) {

		scrollStop = false;

		onScrollUp();

	  }

	}

	function onScrollUp()

	{

	  if (!scrollStop) {

		scrollActive = true;

		setTimeout('onScrollUp()', scrollInterval);

		var sc = xGetElementById('vScrollee1');

		var y = xTop(sc) + scrollIncrement;

		if (y <= 0) {

		  xTop(sc, y);

		}

		else {

		  scrollStop = true;

		  scrollActive = false;

		}

	  }

	}

	function onScrollStop()

	{

	  scrollStop = true;

	  scrollActive = false;

	}





	  function xAddEventListener() {

		var up = xGetElementById('upBtn');

		var dn = xGetElementById('dnBtn');

		var sc = xGetElementById('vScroller1');



		up.onmouseover = onScrollUpStart;

		up.onmouseout = onScrollStop;

		xMoveTo(up, xPageX(sc) + xWidth(sc), xPageY(sc));



		dn.onmouseover = onScrollDnStart;

		dn.onmouseout = onScrollStop;

		xMoveTo(dn, xPageX(sc) + xWidth(sc), xPageY(sc) + xHeight(sc) - xHeight(dn));

	  }

	///****************************************************************************************************************************

	function grabar_usuario()
		 {


			 element1 = $("usuario").value;

			 element2 = $("nombre").value;

			 element3 = $("claveGenerada").innerHTML;

			 element4 = $("estacion").value;

			 element5 = $("tipo").value;

			 element6 = $("asoc").value;

			 element7 = $("estatus").value;

			 element8 = $("n_idu").title;

			 element9 = $("acceso").checked;



			 if (element9==true) {

				element9=0;

			 }else {

				element9=1;

			 }

			 /*configuracion de Jugada de SPH*/

			 valores='';



		/*	 for(i=1;i<=parseInt($("SPH").title);i++)
			 {

				 if ($("j"+i).checked==false)

				 {

				   valores+="op1"+$("j"+i).title+"|";

				 }

			 }



			 for(i=1;i<=parseInt($("DatosSPH").title)-1;i++)

			 {


				 if ($("o"+i).checked==false)

				 {

				   valores+=$("o"+i).title+"|";

				 }

			 }
	*/

	         // alert($("Deportesl").title);
			  for(i=1;i<=parseInt($("Deportesl").title);i++)

			 {

				 if ($("d"+i).checked==false)

				 {

				   valores+=$("d"+i).title+"|";

				 }

			 }



			 valoressm='';

			if ($("sph").checked==true)

			{

				valoressm+='1'+'-';

			}

			if ($("ganadores").checked==true)

			{

				valoressm+='2'+'-';

			}

			if ($("deportes").checked==true)

			{

				valoressm+='3';

			}

			 if (valores=='') { valores='|'; }


	        if ($('tipo').value==4){
				valor=$('GrupoK').value;
			}else{
					valor=0;
			}
			 if ($('vbanca').checked)
				valor2=$('IDB').value;
			else
				valor2=0;

			 new Ajax.Request('usuario-1-2.php?us='+element1+'&nm='+element2+'&clv='+element3+'&est='+element4+'&tp='+element5+'&as='+element6+'&es='+element7+'&idu='+element8+'&pr=1&ta='+element9+'&v='+valores+'&v2='+valoressm+'&agrupo='+valor+'&abanca='+valor2+"&idt="+$("usu").title+"&impremsg="+$("impremsg").checked,{					method:'get',asynchronous:false	,onComplete: function(transport){
								var response = transport.responseText.evalJSON(true);
								if (response[0]){
										dhxWins1.window("w1").close();dhxWins1.window("w2").close();
										nalert('ACTUALIZACION','INFORMACION GRABADA!');
										makeRequest('usuario-1-1.php');
								}else{
									switch (response[1]){
										case 1: nalert('ERROR','NO GENERO LA CLAVE PARA ESTE NUEVO USUARIO');break;
										case 2: nalert('ERROR','INTENTE DE NUEVO NO PUEDO GRABAR EL USUARIO');break;
										case 3: nalert('ERROR','ESTE USUARIO YA EXISTE!');break;
									}
								}

								},onCreate: function(){
									 $("tablemenu").innerHTML  = '<img src="media/ajax-loader.gif" />';
								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});







		 }


	function elimnar_usuario(){
			 desci=confirm("Desea eliminar este Registro?");
			 if (desci==true){
			  element1 = $("n_idu").title;

			 new Ajax.Request('usuario-1-2.php?idu='+element1+'&pr=2&idt='+$("usu").title,{method:'get',asynchronous:false	,onComplete: function(transport){
								var response = transport.responseText.evalJSON(true);
								dhxWins1.window("w1").close();dhxWins1.window("w2").close();
								if (response[0])
										nalert('ACTUALIZACION','USUARIO ELIMINADO');
								else
									    nalert('ERROR','NO PUEDO ELIMINAR EL USUARIO');

								makeRequestSP('usuario-1-1.php');

								},onCreate: function(){
									 $("tablemenu").innerHTML  = '<img src="media/ajax-loader.gif" />';
								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});


			 }

		 }



	function habilitar(){

			if ($("tipo").value==3){

				$("asoc").disabled= false;

			}else{

				$("asoc").value= "";

				$("asoc").disabled= true;

			}

		 }



	function validar3(oEvent)
			 {
			  oEvent= oEvent || window.event;
			 var txtfield = oEvent.target || oEvent.srcElement;
			  var element =  $("tablemenu");

			  var imae = $("img"+txtfield.id);
			  var btn=$("btnguardar");

				 new Ajax.Request('validaform3.php?'+txtfield.id+'='+encodeURIComponent(txtfield.value),{
			 method:'get',asynchronous:false	,	onSuccess: function(transport){
		    var arrInfo = transport.responseText.evalJSON() ;
				   if (eval(arrInfo.valid)){
							  imae.style.display="none";
							  txtfield.valid=true;

							  if (btn.lang==txtfield.id) {btn.lang='';btn.disabled="";}

						  } else {

							  txtfield.valid=false;
							  imae.title=arrInfo.mesanje;
							  imae.style.display="";
							  btn.lang=txtfield.id;
							  btn.disabled="disabled";
						  }


		 		   },
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });

	 if (btn.lang!='') {  btn.disabled="disabled"; } else { btn.disabled=""; }

}



	function clave(oEvent)
		 {

		 var clv = $("clave").value;
		 var rcl = $("rep").value;
	     oEvent= oEvent || window.event;
	 	 var txtfield = oEvent.target || oEvent.srcElement;
		 oXmlHttp  = new XMLHttpRequest();

			  var element =  $("tablemenu");
			  oXmlHttp.open('GET','validaform3.php?'+txtfield.id+'='+encodeURIComponent(txtfield.value),true);
			  oXmlHttp.onreadystatechange = function() {

							if (oXmlHttp.readyState == 4) {

							if (oXmlHttp.status == 200) {

							var arrInfo = oXmlHttp.responseText.split("||");

							var imae = $("imgrep");

							var btn=$("btnguardar");

						  /*  alert (txtfield.id);*/

						  if (clv != rcl){

							  txtfield.valid=false;

							  imae.title="La Clave es Incorrecta";

							  imae.style.display="";

							  btn.disabled="disabled";


						  } else if (!eval(arrInfo[0])) {

							  txtfield.valid=false;

							  imae.title=arrInfo[1];

							  imae.style.display="";

							  btn.disabled="disabled";

						  }else {

							  imae.style.display="none";

							  txtfield.valid=true;

							  btn.disabled="";

						  }

						}

					  }

					}



		   oXmlHttp.send(null);

		 }









	function datosdecierre()

		 {



			 element1 = $("fc").value;

			 element2 = $("sjornada").value;

			 if (element2==''){

				 element2 =0;

			 }

			 var element =  $("lganadores");





			 oXmlHttp  = new XMLHttpRequest();



			oXmlHttp.open('GET','cerrarjugada1.php?fecha='+element1+'&idcn='+element2+'&tipo=4',true);

			 yq = false;

			oXmlHttp.onreadystatechange = function() {

				   if(ParceJS(oXmlHttp.responseText) && yq==false) {

						 yq = true;

						 element.innerHTML = oXmlHttp.responseText;

					}

			}

				oXmlHttp.send(null);





	}





	//****************************************** Carga del Menu Segun la Configuracion

	function accesoconfig()

		 {

		   //oXmlHttp3 = new XMLHttpRequest();

		 }



	function cargarcampos4()

	{

			   Calendar.setup({

				   inputField     :    "fc2",           // id of the input field

				   ifFormat       :    "%e/%m/%Y",    // format of the input field

				   align          :    "Tl",           // alignment (defaults to "Bl")

				   singleClick    :    true,

				   onUpdate       :    catcalc4

				 });

	}



	function catcalc4(cal) {

	  var date = cal.date;

	   var field = $("fc2");

		mes=date.print("%m");

		if (parseInt(mes)<=9){

			mes2=mes.substring(1,2);

		}

		else{

			mes2=mes;

		}

			field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");

		}



	function cargarjug(jug){

		if ( $("pant").lang!='*'){

		 $("fila"+$("pant").lang).style.backgroundColor="";

		}

		 $("juego").innerHTML=$("jugada"+jug).innerHTML;

		 $("fila"+jug).style.backgroundColor="#FFFFFF";

		 $("sel").title=jug;

		 $("pant").lang=jug;

	}



	function grabar_grupo(){

			 element1 = $("nombre").value;
			 element2 = $("responsable").value;
			 element3 = $("telefono").value;
			 element4 = $("direccion").value;
			 element5 = $("estatus").value;
			 element6 = $("n_idg").title;
			 var element =  $("tablemenu");

			new Ajax.Request('grupo-1-2.php?nm='+element1+'&res='+element2+'&tlf='+element3+'&dr='+element4+'&es='+element5+'&idg='+element6+'&pr=1&participa='+$("Participacion").value+'&IDB='+$("IDB").value+"&porce_parlay=" +$('porce_Parlay').value+"&porce_derecho=" +$('porce_Derecho').value,{method:'post',asynchronous:false	,onComplete: function(transport){
								var response = transport.responseText.evalJSON(true);

								if (response[0]){
								 		dhxWins1.window("w1").close();
										nalert('ACTUALIZACION','INFORMACION ALMACENADA!');
										makeRequestSP('grupo-1-1.php');
								}else
									nalert('ERROR',response[1]);


								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});


		 }



	function elimnar_grupo()
		 {

			 desci=confirm("Desea eliminar este Registro?");
			 if (desci==true){
			  element1 = $("n_idg").title;
			new Ajax.Request('grupo-1-2.php?idg='+element1+'&pr=2',{method:'get',asynchronous:false	,onComplete: function(transport){
								var response = transport.responseText.evalJSON(true);

								if (response){
								 		dhxWins1.window("w1").close();
										nalert('ACTUALIZACION','EL GRUPO FUE ELIMINADO');
										makeRequestSP('grupo-1-1.php');
								}else
									nalert('ERROR','DISCULPE NO PUEDO ELIMINAR ESTE GRUPO!!');

								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});

			 }

		 }



		 function grabar_hipo()

		 {



		 var oXmlHttp=false;



			 /*alert("Hola");*/

			 element1 = $("nombre").value;

			 element2 = $("estatus").value;

			 element3 = $("n_idh").title;

			 element4 = $("sig").value;



			 oXmlHttp  = new XMLHttpRequest();


			  new Ajax.Request('hipodromo-1-2.php?nm='+element1+'&es='+element2+'&idh='+element3+'&sg='+element4+'&pr=1',{
			 method:'get',	onComplete: function(transport){
				var response = transport.responseText ;
					$("tablemenu").innerHTML = response;
			   },
			   onCreate: function(){

					$("tablemenu").innerHTML = '<img src="media/ajax-loader.gif" />';
			   },

				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

			  });



			makeRequestSP('hipodromo-1-1.php');

		 }



	function elimnar_hipo()

		 {

			 var oXmlHttp=false;

			 desci=confirm("Desea eliminar este Registro?");

			 if (desci==true){



			  element1 = $("n_idh").title;



			  oXmlHttp  = new XMLHttpRequest();

			  var element =  $("tablamenu1");



			 oXmlHttp.open('GET','hipodromo-1-2.php?idh='+element1+'&pr=2',true);





			 oXmlHttp.onreadystatechange = function() {

						 element.innerHTML = oXmlHttp.responseText;

					}



				oXmlHttp.send(null);



				makeRequestSP('hipodromo-1-1.php');



			 }

		 }



		 function validar4(oEvent)
		 {

			 oEvent= oEvent || window.event;


			 var txtfield = oEvent.target || oEvent.srcElement;
			 oXmlHttp  = new XMLHttpRequest();



			  var element =  $("tablemenu");


			  oXmlHttp.open('GET','validaform4.php?'+txtfield.id+'='+encodeURIComponent(txtfield.value),true);
						oXmlHttp.onreadystatechange = function() {
							if (oXmlHttp.readyState == 4) {
							if (oXmlHttp.status == 200) {
							var arrInfo = oXmlHttp.responseText.split("||");
							var imae = $("img"+txtfield.id);
							var btn=$("btnguardar");
						  /*  alert (txtfield.id);*/

						   if (!eval(arrInfo[0])) {

							  txtfield.valid=false;

							  imae.title=arrInfo[1];

							  imae.style.display="";

							  btn.disabled="disabled";

						  } else {

							  imae.style.display="none";

							  txtfield.valid=true;

							  btn.disabled="";

						  }

						}

					  }

					}



		   oXmlHttp.send(null);





		 }



	function makeRequestSC(url) {



			cns=$("con").title;

			 new Ajax.Request(url+'?cs='+cns,{
			 method:'get',
				onComplete: function(transport){
				var response = transport.responseText ;
					$("tablemenu").innerHTML = response;
					response.evalScripts();
			   },
			   onCreate: function(){

					$("tablemenu").innerHTML = '<img src="media/ajax-loader.gif" />';
			   },

				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

			  });







		}



	function cargarbusq(){

		//alert("Funciona!");

		if ($("bserial").disabled==true){


		$("bserial").disabled=false;

		$("bacept").disabled=false;

		}

		else{



		$("bserial").disabled=true;

		$("bacept").disabled=true;

		}

		$('bserial').focus();

		$('bserial').select();

	}



	function scc1(){

	   var up = xGetElementById('upBtn');

		var dn = xGetElementById('dnBtn');

		var sc = xGetElementById('vScroller1');



		up.onmouseover = onScrollUpStart;

		up.onmouseout = onScrollStop;

		xMoveTo(up, xPageX(sc) + xWidth(sc), xPageY(sc));



		dn.onmouseover = onScrollDnStart;

		dn.onmouseout = onScrollStop;

		xMoveTo(dn, xPageX(sc) + xWidth(sc), xPageY(sc) + xHeight(sc) - xHeight(dn));

	}



	function imprimirreeportes(url,tip)
	{
		var element =  $("printerver");
		cns=$("con").title;

		d1=$("fc").value;
		d2=$("fc2").value;

		abrir(url+'?cs='+cns+'&d1='+d1+'&d2='+d2,'Reporte de Ventas ',1,0,0,0,0,0,1,400,400,100,100,1);



	}







	function cambiartipo(valor)

	{

		if (valor == 1){

			$("tipo").innerHTML="Si / No";

		}else {

			$("tipo").innerHTML="Alta / Baja";

		}

	}





	//****************************************************

		function makeRequestmn() {





		 fecha=$("fch").title;



		  $("tablemenu").innerHTML="";



		 $("menu1").innerHTML="";



		  new Ajax.Request('topmenubb.php?fc='+fecha+'&op='+$('header2').lang,{

									method:'get',	onSuccess: function(transport){
									var response = transport.responseText;

									$("topmenubb").innerHTML =response;

									},

									onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

									})





		makeResultwin('resumencng.php?cns='+$("con").title,'tablemenu');



		}

	//***************************************************

		function makeRequestidx() {



		 http_request = new XMLHttpRequest();



		 var element =  $("menu1");



		 $("tablemenu").innerHTML="";

		 $("topmenubb").innerHTML="";



			 http_request.open('GET','menujugada.php?op=2&cng='+$("header2").lang, true);



			 http_request.onreadystatechange = function() {

			 element.innerHTML = http_request.responseText;

			   }



			http_request.send(null);



		}









		var anterior=0;

		function current(n)

		{



			 if (anterior==0)

			 {

				 $("1").className="";

				 anterior=n;

				 $(n).className="current";

			 }else{

				 $(anterior).className="";

				 $(n).className="current";

				 anterior=n;

			 }



		}



		function jsonvalores(oEvent)

		{



			txtfield=$(oEvent).value;



			new Ajax.Request("validaformgamejornadabb.php?"+oEvent+'='+txtfield,{

			 method:'get',

				onSuccess: function(transport){

				var response = transport.responseText.evalJSON(true) ;

				$('cant_p').value=response.cant;

				$('fc').lang=response.idj;



				if (response.cant!=0)

				{

					$('btncargar').disabled=false;

				}else{

					$('btncargar').disabled=true;

				}



			   },

				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

			  });



		}











	function cargarpartidos(Idj)
	{
	if (Idj==-1)
		desicion=parseInt($('cant_p').value)!=0;
	else
		desicion=true;


	var element =  $("coc");
	if (desicion){
		if (Idj==-1){
			element1=$("cant_p").value;
			element2=$("fc").lang;
			element3=$("Grupo").value;
			IDB=$('IDB').value;
			fc=$("fc").innerHTML;
		}else{
			for( y=0; y<=mygrid.getRowsNum();y++){
				if (mygrid.getRowId(y)==Idj){
					element1=mygrid.cells2(y,2).getValue();
					element2=mygrid.cells2(y,0).getValue()
					element3=mygrid.cells2(y,4).getValue();
					IDB=mygrid.cells2(y,5).getValue();
					fc=fecha;
					break;
				}

			}

		}

		 new Ajax.Request('jornadabb.php?cant='+element1+'&idj='+element2+'&dp='+element3+'&IDB='+IDB+'&fc='+fc,{
   		 method:'get',
    		onComplete: function(transport){
    		var response = transport.responseText ;
			element.innerHTML = response;
			response.evalScripts();
 		   },
		   onCreate: function(){
				element.innerHTML = '<img src="media/ajax-loader.gif" />';
 		   },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });
		 }else
		 	nalert('ERROR','INDIQUE LA CANTIDAD DE PARTIDOS')

	}




	function img(idc,eq1,eq2,i)

		{

			$("logl"+idc).innerHTML='<img id="imgl'+idc+'" src="images/logo/eq'+eq1+'.jpg"/>';

			$("logr"+idc).innerHTML='<img id="imgr'+idc+'" src="images/logo/eq'+eq2+'.jpg"/>';

			$("part"+i).lang='1';

		}



	function tick(url,idp)

		{

		$("imenud").style.display="none";

		$("imenud").style.setProperty('margin-left','250px',null);

		//alert($("imenud").style[0]);//.margin_left="250px";



		http_request4 = new XMLHttpRequest();

			element1= parseInt($("jornada").title);

			var element =  $("ticke");



			/*http_request.onreadystatechange= alertContents;*/

			http_request4.open('GET', url+'&idj='+element1, true);

			http_request4.onreadystatechange = function() {

				if (http_request4.readyState == 4) {

						if (http_request4.status == 200) {

						 element.innerHTML = http_request4.responseText;

							}

						}

					}

		   http_request4.send(null);



		$("imenud").style.display="";





		}





	function str_replace(cadena, cambia_esto, por_esto) {
      return cadena.split(cambia_esto).join(por_esto);
}






function guardarjorbb(liga,auto){
		if ( VerificarLogros(false) ){
			hrx='';
			pch='';
			gp='';
			equip='';
			np='';
			efec='';
			element1=$("n_idc").title;
			element2=$("fc").lang;
			cant=parseInt($("cant_p").lang);
			element5=cant;

			for (j=1;j<=cant;j++){
				hrx+=$("hora"+j).value+':'+$("min"+j).value+'|';
				pch+=$("pc1"+j).value+'|';
				gp+=$("GP1"+j).value+'|';
				efec+=$("efe1"+j).value+'|';
			}

			codigosDB='';
	        for (i=1;i<=cant;i++)
				codigosDB+=$("CodigoEq1_"+i).value+'|'+$("CodigoEq2_"+i).value+'|';

			for (i=1;i<=cant;i++)np+=$("np"+i).lang+'|';

			cant*=2;

			for (i=1;i<=cant;i++){
				if ($("equipo"+i).title=='2k'){
					equip+='$'+$("equipo"+i).innerHTML+'|';
				}else
					equip+=$("equipo"+i).value+'|';

				if (i>element5) {
					pch+=$("pc2"+i).value+'|';
					gp+=$("GP2"+i).value+'|';
					efec+=$("efe2"+i).value+'|';
					}
			}

			var elemd=new Array(element5);

			for (i=0;i<=element5-1;i++){
				listdecol=$('cv'+(i+1)).lang;
				arrdev=listdecol.split('|');
				elemd[i]='';
				sudgrupo=$(arrdev[1]).lang;
				subg='';
				for (j=1;j<=arrdev.length-1;j++){
				   if (sudgrupo==$(arrdev[j]).lang){
					subg+=$(arrdev[j]).value+'|';
				   }else{
					   elemd[i]+=sudgrupo+"["+subg+"*";
					   sudgrupo=$(arrdev[j]).lang;
					   subg='';
					   subg+=$(arrdev[j]).value+'|';
				   }
				}
				elemd[i]+=sudgrupo+"["+subg;
			}
			listado='';
			for (i=0;i<=elemd.length-1;i++){
			  listado=listado+elemd[i]+'/';
			}
				new Ajax.Request('jornadabb-1-2.php',{	  parameters: {op:1,idc:element1,lista:listado,fc:element2,eq:equip,hr:hrx,cant:element5,p:pch,gp:gp,e:efec,dp:$('Grupo').lang,np:np,IDB:$('IDB').lang,idt:$("usu").title,equiDB:codigosDB,liga:liga,auto:auto},

			 method:'post',

				onSuccess: function(transport){

					var response = transport.responseText.evalJSON(true);

					if (!response)
					 	nalert('ERROR','NO SE ACTUALIZO LA INFORMACION INTENTE DE NUEVO');

			   },
			onCreate:function(){mientrasProceso('Jornada Grabada','Grabando Jornada'); },
			onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

			  });
		}else 	nalert('ERROR','LO SIENTO HAY ERRORES EN LOS LOGROS!');

}


	function act_campo(n)

	{

		if (n==1)

		{

		if ($("check1").checked==true)

		{

			$("check2").checked="";

			$("tipo").disabled=false;

			$("grupo").disabled=true;

			$("grupo").value=0;

		}else

		{

			$("tipo").disabled=true;

			orden(0);

		}

		}

		if (n==2)

		{

		if ($("check2").checked==true)

		{

			$("check1").checked="";

			$("tipo").disabled=true;

			$("grupo").disabled=false;

			$("tipo").value=0;

		}else

		{

			$("grupo").disabled=true;

			orden(6);

		}

		}

	}



	function orden(n)

	{

		http_request3 = new XMLHttpRequest();

		element2=0;

			if (n==0)

			{

			element1=$("tipo").value=0;

			n=3;

			}else{

			element1= $("tipo").value;

			}

			if (n==6)

			{

			element3=$("grupo").value=0;

			n=5;

			}else{

			element3= $("grupo").value;

			}



			if (n==1 || n==2)

			{

				if($("tipo").value > 0){

					element2=n;

					element1=$("tipo").value;

					n=4;

				}else if ($("grupo").value > 0){

					element2=n;

					element1=$("grupo").value;

					n=5;

				}

			}

			if (n==3)

			{

				if (eval($("ord1").checked)==true){

					element2=1;

					element1=$("tipo").value;

					n=4;

				}

				if (eval($("ord2").checked)==true){

					element2=2;

					element1=$("tipo").value;

					n=4;

				}

			}

			if (n==5){

				if (eval($("ord1").checked)==true){

					element2=1;

					element1=$("grupo").value;

				}

				if (eval($("ord2").checked)==true){

					element2=2;

					element1=$("grupo").value;

				}

			}



			var element =  $("orden1");



			http_request3.open('GET','ordenusu.php?&opc='+n+'&bq='+element1+'&ord='+element2+'&bq2='+element3, true);

			http_request3.onreadystatechange = function() {

				if (http_request3.readyState == 4) {

						if (http_request3.status == 200) {

						 element.innerHTML = http_request3.responseText;

							}

						}

					}

		   http_request3.send(null);

	}



	function act_campo2()

	{

		if (eval($("check2").checked)==true)

		{

			$("grupo").disabled=false;

		}else

		{

			$("grupo").disabled=true;

			orden_conc(0);

		}

	}



	function orden_conc(n)

	{

		http_request3 = new XMLHttpRequest();

		element2=0;



		if (n==0){

			element1=$("grupo").value=0;

			n=3;

			}else{

			element1= $("grupo").value;

			}



		if (n==1 || n==2)

			{

				if($("grupo").value > 0){

					element2=n;

					element1=$("grupo").value;

					n=4;

				}

			}



		if (n==3)

			{

				if (eval($("ord1").checked)==true){

					element2=1;

					element1=$("grupo").value;

					n=4;

				}

				if (eval($("ord2").checked)==true){

					element2=2;

					element1=$("grupo").value;

					n=4;

				}

			}



		var element =  $("orden1");



			http_request3.open('GET','ordenconc.php?&opc='+n+'&bq='+element1+'&ord='+element2, true);

			http_request3.onreadystatechange = function() {

				if (http_request3.readyState == 4) {

						if (http_request3.status == 200) {

						 element.innerHTML = http_request3.responseText;

							}

						}

					}

		   http_request3.send(null);

	}





	//******************************** Imprimir reportes de Ventas ************************************//

	function imprimirre()

	{





		d1=$("fc").value;

		d2=$("fc2").value;

		idj=$("sel").title;

		org=$("org").value;

		clsi=$("clsi1").checked;

		if (clsi==true) {

		 gp=$("grupo").value;

		 clsi=1;

		}else{

		 gp=$("cons").value;

		 clsi=2;

		}

		//alert(clsi);

		if (idj!='') {
		 if ($('rt1').checked==true){
		 abrir('reportedeventas.php?gp='+gp+"&d1="+d1+"&d2="+d2+"&idj="+idj+"&org="+org+"&tc=1&clsi="+clsi,'Reporte de Ventas ',1,0,0,0,0,0,1,400,400,100,100,1);
		 }
		 if ($('rt2').checked==true){
		 abrir('reportedeventasresumido.php?gp='+gp+"&d1="+d1+"&d2="+d2+"&idj="+idj+"&org="+org+"&tc=1&clsi="+clsi,'Reporte de Ventas ',1,0,0,0,0,0,1,400,400,100,100,1);
		 }

		}else

		{

			alert ('No Selecciono niguna Jugada..!');

		}

	}



	//**************************************************************************************************//

	function _searjgd()

	{

		cot=$("cot").lang;
		bqd=$("bserial").value;

	 new Ajax.Request("ver_jugada-1-1.php?IDCN="+IDCN+"&idc="+idc+'&idj='+IDJugada+"&carr="+carr,{
			 method:'get',
				onComplete: function(transport){
				var response = transport.responseText.evalJSON(true) ;


				for (iii=1;iii<=response.length-1;iii++)
				{

						if (response[iii]!=0)
						{
						 $("la"+iii).innerHTML=response[iii];
						}
				}

			   },
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });



		for (i=1;i<=parseInt(cot);i++)
		{

			qui=$(i).lang;

			if (bqd==qui)

			{

				$('bserial').lang=bqd+'||'+$('f'+qui).style.backgroundColor;

				$('f'+qui).style.backgroundColor="#FFFF33";

				alert('Serial Encontrado!!');

				onScrollStop2();

				break;

			}



		}

		onScrollStop2();

		$('bserial').focus();

		$('bserial').select();

	}

	//  dn.onmouseover = onScrollDnStart;

	 //   dn.onmouseout = onScrollStop;



	var scrollActive2 = false, scrollStop2 = true, scrollIncrement2 =50, scrollInterval2 = 5;



	function onScrollDnStart2()

	{

	  if (!scrollActive2) {

		scrollStop2 = false;

		onScrollDn2();

	  }

	}

	function onScrollDn2()

	{

	  if (!scrollStop2) {

		scrollActive2 = true;

		setTimeout('onScrollDn2()', scrollInterval2);

		var sc = xGetElementById('vScrollee1');

		var y = xTop(sc) - scrollIncrement2;

		if (y >= -(xHeight(sc) - xHeight('vScroller1'))) {

		  xTop(sc, y);

		}

		else {

		  scrollStop = true;

		  scrollActive = false;

		}

	  }

	}

	function onScrollStop2()

	{

	  scrollStop2 = true;

	  scrollActive2 = false;

	}



function validar_con_ju(oEvent,tp)
{
  oEvent= oEvent || window.event;
  var txtfield = oEvent.target || oEvent.srcElement;

    new Ajax.Request('validaformgame.php?'+txtfield.id+'='+encodeURIComponent(txtfield.value),{
   		 method:'get',asynchronous:false,
    		onComplete: function(transport){
    		var arrInfo = transport.responseText.split("||");
			var imae = $("img"+txtfield.id);
							if (tp!=4) {
							var vld=$("valida");
							var eje=$("ejem");
							}//if (tp!=4)



						   if (  !eval(arrInfo[0]) ) {
							  txtfield.valid=false;
							  $(txtfield.id).focus();
							  //$(txtfield.id).select();

							  imae.title=arrInfo[1];
							  imae.style.display="";

							  if (tp!=4 && tp!=5 ) {
							    vld.disabled="disabled";
							    eje.disabled="disabled";
							     if (tp==2) {  $("carre_v").disabled="disabled";} if (tp==1) {  $("nom").disabled="disabled";}
							   }else {
								 for (iii=1;iii<=parseInt($("carr").title);iii++) {  $("v"+iii).disabled="disabled";	}
								 if (tp==4) {  $("nom").disabled="disabled";}
							   }//if (tp!=4)
						     } else { //Else *********** if (!eval(arrInfo[0]) || pasar)
							  imae.style.display="none";
							  txtfield.valid=true;
							  setCookie(txtfield.id,encodeURIComponent(txtfield.value));

							  if (tp!=4 && tp!=5 ) {
							    vld.disabled="";
							    eje.disabled="";
							   if (tp==2) {  $("carre_v").disabled="";} if (tp==1) {  $("nom").disabled="";}
							   }else{

								    if (tp==4) {  $("nom").disabled="";$("nom").select();$("nom").focus();}
									for (iii=1;iii<=parseInt($("carr").title);iii++)	{  $("v"+iii).disabled="";	}

							   } //if (tp!=4)
						   }	//  if (!eval(arrInfo[0]) || pasar) {


 		   },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });

}







	function guardarrelacion()

		{

			oXmlHttp  = new XMLHttpRequest();

			idcn=$("sjornada").value;

			v1=$("infc").lang;

			obs=$('observa').value ;

			$('observa').disabled="disabled";



			oXmlHttp.open('GET','relacion_g.php?idcn='+idcn+'&obs='+escape(obs)+'&tp=0',false);

			oXmlHttp.send(null);



			for (i=1;i<=parseInt(v1);i++)

			{

				element1=$("c"+i).lang;



				var stry=element1.split("||");



				/**********************/

				if (parseInt(stry[1])==1)

				{

					ne='';

					e='';



					for (ii=1;ii<=parseInt(stry[0]);ii++)

					{

						ne+=$("ne"+stry[2]+"-"+ii).value+"*";

						e+=$("e"+stry[2]+"-"+ii).value+"*";

						$("ne"+stry[2]+"-"+ii).disabled="disabled";

						$("e"+stry[2]+"-"+ii).disabled="disabled";

					}

					es=$("es"+stry[2]).value;

					ac=$("ac"+stry[2]).value;

					fac=$("fac"+stry[2]).value;

					dv=$("dv"+stry[2]).value;



					$("es"+stry[2]).disabled="disabled";

					$("ac"+stry[2]).disabled="disabled";

					$("fac"+stry[2]).disabled="disabled";

					$("dv"+stry[2]).disabled="disabled";



				 oXmlHttp.open('GET','relacion_g.php?idcn='+idcn+'&idjug='+stry[2]+'&ne='+ne+'&e='+e+'&es='+cartes(es)+'&ac='+cartes(ac)+'&fac='+cartes(fac)+'&dv='+cartes(dv)+'&tp=1',false);



				/* oXmlHttp.onreadystatechange = function() {



				  if (oXmlHttp.readyState == 4) {

							if (oXmlHttp.status == 200) {

							  // element.innerHTML = oXmlHttp.responseText;



							}

					   }

				   }*/



				   oXmlHttp.send(null);



				}



				/*********************/



				if (parseInt(stry[1])==2 || parseInt(stry[1])==3 )

				{

					ne='';

					e='';



					for (ii=1;ii<=parseInt(stry[0]);ii++)

					{

						if (parseInt(stry[1])==2)

						{

						ne+=$("ne"+stry[2]+"-"+ii+'-'+stry[3]).value+"*";

						}

						e+=$("e"+stry[2]+"-"+ii+'-'+stry[3]).value+"*";



						if (parseInt(stry[1])==2)

						{

						$("ne"+stry[2]+"-"+ii+'-'+stry[3]).disabled="disabled";

						}

						$("e"+stry[2]+"-"+ii+'-'+stry[3]).disabled="disabled";



					}



					if (parseInt(stry[1])==2)

					{

					dv=$("dv"+stry[2]+"-"+stry[3]).value;

					$("dv"+stry[2]+"-"+stry[3]).disabled="disabled";

					}

					oXmlHttp.open('GET','relacion_g.php?idcn='+idcn+'&idjug='+stry[2]+'&ne='+ne+'&e='+e+'&dv='+cartes(dv)+'&carr='+stry[3]+'&tp='+stry[1],false);        oXmlHttp.send(null);



					}

			}

		}





	var contenido_textarea='';



	function valida_longitud(num_caracteres_permitidos){

	   num_caracteres = $('observa').value.length;



	   if (num_caracteres > num_caracteres_permitidos){

		  $('observa').value = contenido_textarea;

	   }else{

		  contenido_textarea = $('observa').value;

	   }

	$('ccuenta').value=$('observa').value.length;

	}





	function makeRequestrelacion() {



		 http_request4 = new XMLHttpRequest();

		   jrnd=$("sjornada").value;

		   $("sjornada").disabled="disabled";

			var element =  $("relacionver");

			/*http_request.onreadystatechange= alertContents;*/



			http_request4.open('GET', 'relacion-1.php?idcn='+jrnd, true);

		//	alert(jrnd);



			http_request4.onreadystatechange = function() {

				 /*   if (http_request.readyState == 4) {

							if (http_request.status == 200) {	*/

						element.innerHTML = http_request4.responseText;

				   /*   }

					}*/

				}



		   http_request4.send(null);



		}

	var serialdedd=0;
	var valorini=0;

	var direccionconce=0;
	var impresion='';
	function formatclick(se,gp,imprimir,cambio,nuevo)
	{


		  Serialbb=getCookie('ticket_bb_sn');



		   if (serialdedd==0)


	                           serialdedd=1;
			/*{new Ajax.Request('contro_bb.php?tp=1',{
								method:'get',asynchronous:false,	onSuccess: function(transport){
								var response = transport.responseText.evalJSON(true) ;
								// setCookie('ticket_bb_sn',response);Serialbb= response;
								 serialdedd= response;
								 },
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});	 }*/

			  if (direccionconce==0){

			new Ajax.Request('contro_bb.php?tp=3&con='+$("con").title,{
								method:'get',asynchronous:false,	onSuccess: function(transport){
								var response = transport.responseText.evalJSON(true) ;
								direccionconce=response;
								 },
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
			 }

			 ff='';hh='';
			 if (imprimir)
				 new Ajax.Request('contro_bb.php?tp=2',{
								method:'get',asynchronous:false,	onSuccess: function(transport){
								var response = transport.responseText;
								 rpss=response.split("||") ;
								 ff=rpss[0];
								 hh=rpss[1];
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});

		ap=$("ap").value;
		lg=$("lgrunico").lang;
		//tti=$("c"+parseInt($("tl"+gp).title)).title ;
		tti=$('tti').lang;

		conces=$("con").title;
		direcc=direccionconce;

		a='<table width="200" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:9px"> <tr>    <th  scope="col" width="10"  align="left"  style=" font-size:9px" >Equipos</th>    <th width="10" scope="col"  style=" font-size:9px">Logro</th>  </tr>'  ;

	//Serialbb
		b= '<table  border="0" style="font-size:12px" align="left;color:#666666"> <tr>  <th colspan="3" scope="col"  ><p align="center">..::_Parlay en Linea_::.</p></th> </tr><tr><th colspan="3" scope="col" align="center"> k******^ TICKET VALIDO *^*^***k</th></tr> <tr>   <th colspan="3" scope="col" >Serial ticket:'+serialdedd+'</th> </tr>   <th colspan="3" scope="col" ><p align="left">Agencia:'+conces+'</p></th> </tr><tr>   <th colspan="3" scope="col" >Fecha:'+ff+' Hora:'+hh+'</th> </tr> <tr><tr>    <th  scope="col">N Partido</th> <th  scope="col" >Partido</th>    <th scope="col">Total</th>  </tr><tr><th colspan="3"   style=" font-size:10px" scope="col">#-----------------------------------#</th></tr>'  ;


		valorini=0;

		lista='';

		i=0;gp_x=0;

		tte=0;

		mpe=0;

		lequi='';

		liddd='';

	    if (true){
	     impresion='';
		 if (nuevo!=0){
			anuevo=nuevo.split('*');
			veces=0;
			}

		for (j=1;j<=parseInt($('totaldefilar').lang)-1;j++)
		{
			if (gp_x!=parseInt($("part_x"+j).lang))
			{
			   gp_x=parseInt($("part_x"+j).lang);
			   i=1;
			}else{
				i++;
			}

	           // alert($("part"+i+'_'+gp_x).lang);
			if ($("part"+i+'_'+gp_x).lang!=0 && $("rro"+i+'_'+gp_x).style.display!='none'){
	  			// verifparti($("ipd"+i+'_'+gp_x).lang,true);
				  tecc=$("part"+i+'_'+gp_x).title;
				  tecc2=$("part_2_"+i+'_'+gp_x).title;
				  valorccc=$("st_"+i+'_'+gp_x).lang;
				  teaimp=tecc.split('$');
				  teaimp2=tecc2.split('$');
				  valorcc2=valorccc.split('$');
				  //alert($("part"+i+'_'+gp_x).title)
				  if (teaimp.length==1)
					  toppp=0;
				  else
				  	  toppp=teaimp.length-2;

				  for (ii=0;ii<=toppp;ii++)
				  {

					/// Armar Nombres //

				  equi=teaimp[ii];

				  dequi=equi.split("||"); //

				  Divi1=dequi[1].split('@');//
				  Divi1=Divi1[1].split('#');//
				  if (nuevo!=0){

						 nlogro=anuevo[veces].split('|');// 65-9)-9, -110
						 nudes =nlogro[0].split(')');  // 65-9, -9
						 carr  =nudes[1] //
						 Divi1[0]=carr;
						 valorcc2[ii]=nlogro[1];
						 veces++;

				  }

				  equi=dequi[0]+'||'+dequi[2]+' '+Divi1[0]+Divi1[1];
				  ///////////////////



				  valocc=valorcc2[ii];

				  if (isNaN(valocc)==true){
					de=valocc;
					valorini=(lg*ap);
				  }else{
					  valocc1=Number(valocc);
					  // ********************  Calculo del Parlay ***********************************
					  if (valocc1<0)
					  {
						valorf=valocc1*-1;      // Factor  <0 100/Logro + 1 * Apuesta
						factor=(100/valorf)+1;
						ap=(factor*ap);
						valorini=ap;
						de=valocc;

					  }else{
						  factor=(valocc1/100)+1; // Factor  >0 Logro/100 + 1 * Apuesta
						  ap=(factor*ap);
						  valorini=ap;
						  de='+'+valocc;
					  }
					  //*********************************************************************************

				  }


				  dequi=equi.split("||");idddr=teaimp2[ii].split("%");				  // ***************************************

				  if (mpe==0) {mpe=parseInt(dequi[0]);idddc=parseInt(idddr[0]);}

				  lequi+=parseInt(dequi[0])+'|';liddd+=parseInt(idddr[0])+'|';



				  nvs_pl1=dequi[1].replace(String.fromCharCode(189),'.5');
				  nvs_pl=nvs_pl1.replace('&frac12;','.5');
				  // alert(nvs_pl);
				  // ***************************************

				  a+='<tr><th align="left"  style=" font-size:10px">' +dequi[1]+'</th><th align="right"  style=" font-size:10px"> '+de+' </th></tr>';
				  //$(dequi[0]).innerHTML+'-'+
				  //$("part_2_"+i+'_'+gp_x).innerHTML
				  b+='<tr><th align="left">'+$(dequi[0]).innerHTML+'-'+'</th><th align="left">'+nvs_pl+'</th><th align="right" >'+de+'</th></tr>';
				  //+$(dequi[0]).innerHTML+'-'
				  //$("part_2_"+i+'_'+gp_x).innerHTML
				  impresion+='<tr><th align="left">'+$(dequi[0]).innerHTML+'-'+'</th><th align="left">'+nvs_pl+'</th><th align="right" >'+de+'</th></tr>';

				  lista+=dequi[0]+'-'+teaimp2[ii]+'|'+de+'*';



				  tte++;
				 }
			 }

		}

	valorini=redond(valorini,2);

	a+='<tr><th colspan="2"   style="font-size:9px"  scope="col">----------------------------------------------------------</th></tr><tr><th  style=" font-size:10px" align="left">Apuesta</th><th  style=" font-size:10px"  align="right">'+$("ap").value+'</th> </tr><tr><th align="left"  style=" font-size:10px" >A Cobrar:</th> <th  style=" font-size:10px" align="right">'+valorini+'</th> </tr>  <tr><th align="left"  style=" font-size:10px">Ganacia:</th><th align="right"  style=" font-size:10px">'+redond((valorini-parseInt($("ap").value)),2)+'</th>  </tr>';

	a+='<tr><th colspan="3" scope="col" align="center" style="font-size:12px" > Toda apuesta realizada despues de iniciar un partido sera nula.</th></tr><tr></tr>';
	//a+='<tr><th colspan="3" scope="col" align="center" style="font-size:12px" > No se reconoceran ni se pagaran,errores de ningun tipo en los logros.</th></tr><tr></tr>';
	b1='';
	b1+='<tr>  <th colspan="3" scope="col"  ><p align="left">-------------------------------------</p></th> </tr><tr><th colspan="3" scope="col" align="left">Precio  :'+$("ap").value+' </th> </tr><tr><th colspan="3" scope="col" align="left">Premio  :'+valorini+'</th> </tr>  <tr>  <th colspan="3" scope="col" align="left"> Su Ganacia  :  '+redond((valorini-parseInt($("ap").value)),2)+' </th>  </tr><tr>  <th colspan="3" scope="col" align="left">-------------------------------------</th>  </tr>';

	/*b1+='<tr><th colspan="3" scope="col" align="center"> Este Ticket caduca a los 3 dias, No se </th></tr><tr></tr>';
	b1+='<tr><th colspan="3" scope="col" align="center"> aceptan devoluciones,Toda apuesta</th></tr><tr></tr>';
	b1+='<tr><th colspan="3" scope="col" align="center"> realizada despues de iniciar,un partido</th></tr><tr></tr>';
    b1+='<tr><th colspan="3" scope="col" align="center"> sera nula. Nos regimos por la hora oficial</th></tr><tr></tr>';
    b1+='<tr><th colspan="3" scope="col" align="center"> pautada por cada liga en sus sitios Web</th></tr><tr></tr>';
    b1+='<tr><th colspan="3" scope="col" align="center"> para el inicio del partido. Al participar</th></tr><tr></tr>';
    b1+='<tr><th colspan="3" scope="col" align="center"> en este tipo de apuesta me someto al</th></tr><tr></tr>';
    b1+='<tr><th colspan="3" scope="col" align="center"> presente reglamento.</th></tr><tr></tr>';*/



	//b1+='<tr><th colspan="3" scope="col" align="center"> errores de ningun tipo en los logros.</th></tr><tr></tr>';
		$("printer2").lang=lista;



		$("printer2").innerHTML=a+'</table>';



		$("printer").style.display="none";


	   b+=b1;
		$("printer").innerHTML=b+'<th>Segurida:</th> <th colspan="2">'+se+'</th> </tr><tr><th colspan="3" scope="col" align="center"> ****** VERIFIQUE SU JUGADA *****</th></tr></table>';

	   impresion+=b1;

	}else{
		$("printer").innerHTML=b+impresion+'<th>Segurida:</th> <th colspan="2">'+se+'</th> </tr><tr><th colspan="3" scope="col" align="center"> ****** VERIFIQUE SU JUGADA *****</th></tr></table>';

	}




	}





	function redond(num, ndec) {

	  var fact = Math.pow(10, ndec); // 10 elevado a ndec
	  /* Se desplaza el punto decimal ndec posiciones,
		se redondea el número y se vuelve a colocar
		el punto decimal en su sitio. */
	  return Math.round(num * fact) / fact;



	}



	function remm(valorQD){

		var unSTR=valorQD.replace(/%29/g,')');
		var unSTR=unSTR.replace(/%7C/g,'|');
		var unSTR=unSTR.replace(/%2A/g,'*');
		var unSTR=unSTR.replace(/%2B/g,'');

		return 	unSTR;

	}



	var tte=0;

	var mpe=0;

	var idddc=0;

	var lequi='';

	var liddd='';

	function impticketbb(modo){

				if (Number($("ap").value)!=0 )
					{
					terminal=$('est').title;
					IDusu=$('usu').title;
					if (isset('IDC'))
						idc=$('IDC').value;
					else
						idc=$('con').title;
					if (idc!=''){
					idj=$('idj_x').lang;
					estatus=true;

					tdj=$("printer2").lang;
					tdj=tdj.replace(/%/g,')');

	//?op=1&conce="+idc+"&idj="+idj+"&equic="+mpe+"&cantidad="+tte+"&idddc="+idddc+"&jgd="+tdj
					new Ajax.Request("frestricciones.php",{
								parameters: { op:1,conce:idc,idj:idj,equic:mpe,cantidad:tte,idddc:idddc,jgd:tdj},method:'post',asynchronous:false,	onSuccess: function(transport){
								var response = transport.responseText.evalJSON(true) ;
								if (response[0]==false)
								{
									if (tte==1){
									if(parseInt($("ap").value,10)<=response[1])
									{
										estatus=true;
									}else{
										estatus=false;
										alert('1:La apuesta que usted ha seleccionado, ha sobrepasado el monto permitido!');
									}

								}else
									estatus=true;


								}

								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});

					 if (tte > 1 && estatus==true) {
///						 ?op=2&conce="+idc+"&idj="+idj+"&equic="+lequi+"&cantidad="+tte+"&idddc="+liddd+"&ap="+$("ap").value+"&acobrar="+valorini
					new Ajax.Request("frestricciones.php" ,{parameters: {op:2,conce:idc,idj:idj,equic:lequi,cantidad:tte,idddc:liddd,ap:$("ap").value,acobrar:valorini},
								method:'get',asynchronous:false,	onSuccess: function(transport){
								var response = transport.responseText.evalJSON(true);
								  if (response[0]==false) {
									if(parseInt($("ap").value,10)<=response[1])
										estatus=true;
									else{
										estatus=false;
										alert('2:La apuesta que usted ha seleccionado, ha sobrepasado el monto permitido!');
									}
								  }else{
								  	if (response[1]=='A') {
										estatus=false;
										alert('3:La apuesta que usted ha seleccionado, ha sobrepasado el Monto del Premio Permitido!');
										}
								  }

								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});



				  }

	      /* if (estatus){
				new Ajax.Request("frestricciones.php?op=3&conce="+idc+"&idj="+idj+"&equic="+lequi+"&cantidad="+tte+"&idddc="+liddd+"&ap="+$("ap").value+"&acobrar="+valorini,{
								method:'get',asynchronous:false,	onSuccess: function(transport){
								var response = transport.responseText.evalJSON(true);
								  if (response[0]==false) {
									if(parseInt($("ap").value,10)<=response[1])
											estatus=true;
									else{
										estatus=false;
										alert('La apuesta que usted ha seleccionado, \n ha sobrepasado el monto permitido de su Grupo!');
									}
								  }else{
								  	if (response[1]=='A') {
										estatus=false;
										alert('La apuesta que usted ha seleccionado,\n ha sobrepasado el Monto del Premio Permitido de su Grupo!');
										}
								  }

								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});

			}*/
					if (estatus==true) {
					ent=true;
					switch(modo){
					 case 0: txtmsj="Desea Imprimir el ticket?"; break;
					 case 1: txtmsj="Desea Enviar el ticket?"; break;
					}
					do{

					desci=confirm(txtmsj);
					if (desci==true){
						 if (ent==true){
					//   alert("grabarjugadabb.php?op=1&serial="+Serialbb+"&jgd="+$("printer2").lang+"&ap="+$("ap").value+"&aco="+valorini+"&idj="+idj+"&usu="+IDusu+"&termi="+terminal+"&idc="+idc+'&grp=0');      Serialbb=getCookie('ticket_bb_sn');
					//?op=1&serial="+serialdedd+"&jgd="+tdj+"&ap="+$("ap").value+"&aco="+valorini+"&idj="+idj+"&usu="+IDusu+"&termi="+terminal+"&idc="+idc+'&grp=0'
						 tdj=$("printer2").lang;
						 tdj=tdj.replace(/%/g,')');
						 var erro=false;
						 new Ajax.Request("grabarjugadabbnek.php",{parameters: {op:1,serial:serialdedd,jgd:tdj,ap:$("ap").value,aco:valorini,idj:idj,usu:IDusu,termi: terminal,idc:idc,grp:0},
								method:'post',asynchronous:false,	onSuccess: function(transport){
								var response = transport.responseText.evalJSON(true) ;

								if (response[0])
								{

									serialdedd=response[2];
									vretur=remm(dbna(response[4]) )
									erro=true;
									switch(modo){
										case 0: formatclick(response[1],0,true,response[3],vretur );     break;
										case 1: formatclick_msg(response[1],0,true,response[3],vretur ); break;
									}
									_fnactCredito(idc)

								}else{
									switch (response[1]){
										case '0':
											nalert('JUGADA CERRADA','Disculpe pero hay partidos que ya estan Cerrado!')
											//\\
											cierrePartidos();
											//\\
											break;
										case '1':
											nalert('URGENTE','USTED SE ENCUENTRA SUSPENDIDO! COMUNIQUESE CON LA OFICINA!')
											break;
										case '2':
											nalert('ERROR','Existe un ERROR en el SERVIDOR! Realice el Ticket de Nuevo!')
											break;
										case '3':
											nalert('VENTA','DISCULPE ESTAMOS CERRADO PARA LA VENTA!')
											window.location.reload();
											break;
										case '4':
											nalert('TOPE MAXIMO','4:EL MONTO DE LA APUESTA QUE HA COLOCADO NO ESTA PERMITIDA \nCON LA CANTIDAD DE PARTIDOS SELECCIONADOS!')
											break;
										case '5':
											nalert('PARTIDOS MAXIMOS','5:USTED NO PUEDE HACER ESTE PARLAY POR LA CANTIDAD DE PARTIDOS!')
											break;
										case '6':
											nalert('HORA','HAY PROBLEMA CON LA HORA NO PUEDO HACER EL TICKET!!');
											window.location.reload();
											break;
										case '7':
											respuesta=response[2].split('-');
											nalert(respuesta[0],respuesta[1]);
											break;

									}

								}
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});


							 ent=false;



						 }



						  $('printer').style.display='';

						if (erro==true){
						 switch(modo){
						  case 0:
							  print();
							  Ext.example.msg('Terminado','Ticket Impreso....!');
							  break;
						  case 1:

						  	  SendMsgtk(serialdedd,idc);
							   Ext.example.msg('Terminado','Ticket Enviado....!');
						      break;
						  }
						}

						 desci=false;



						}



					}while (desci==true)



					if (ent==false){
	                  serialdedd=0;
					/*new Ajax.Request('contro_bb.php?tp=1',{
								method:'get',	onSuccess: function(transport){
								var response = transport.responseText.evalJSON(true) ;
								//setCookie('ticket_bb_sn',response);
								serialdedd=response;
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});*/
					new Ajax.Request('ticketbb.php',{
								method:'get',	onSuccess: function(transport){
								var response = transport.responseText;
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});

					inicialbb(); DesInactivo();

					}

					}else
								$("ap").value=0;
					}else
								nalert('ERROR','Debe Seleccionar la Letra a Realizar El Ticket!!');
					}else
								nalert('ERROR','No hay monto en la Apuesta!');






	}







	function inicialbb()
	{

	/*	activarrefress(2,0,0);*/

		//$("printer").innerHTML='';
		$("printer2").innerHTML='';
		$("ap").value='';
		$("btnprint").disabled="disabled";
		$("btnprint2").disabled="disabled";
		i=0;gp_x=0;

		for (j=1;j<=parseInt($('totaldefilar').lang)-1;j++)
		{
		  if (gp_x!=parseInt($("part_x"+j).lang))
			{
			   gp_x=parseInt($("part_x"+j).lang);
			   i=1;
			}else{
				i++;
			}
			if ($("part"+i+'_'+gp_x).lang!='0' && $("rro"+i+'_'+gp_x).style.display!='none'){

				  $("part"+i+'_'+gp_x).title='';$("part"+i+'_'+gp_x).lang='0';
				  $("part_2_"+i+'_'+gp_x).title='';
				  $("st_"+i+'_'+gp_x).lang='';


			}

		}

		camposmar=$('camposmarcados').lang;

		campomarcados=camposmar.split('|');

		for (j=0;j<=campomarcados.length-2;j++)

		{

			$(campomarcados[j]+'k').style.backgroundColor=bgroung;

			$(campomarcados[j]+'k').style.fontSize="11px";

			$(campomarcados[j]).checked=false;

		}

		bgroung='';

		$('camposmarcados').lang='';
		$("ap").focus();
		$("ap").select();



	}








	function desitem(f,p,c)



	{



		for(j=1;j<=c;j++)



		{



			$('equi'+f+''+j).style.display='none';



			if (j>p){



				if ($('equi'+(f+1)+''+j).style.display!='none'){



					$('equi'+(f+1)+''+j).selected="selected";



				}



			}



		}



	}




	function imprimirrelcc(rel)

	{

		 abrir('reporterelacion.php?idcn='+rel,'Relacion',1,0,0,0,0,0,1,400,400,100,100,1);



	}



	function cambiarperfil()
	{



			tp=$('tipo').value;

			switch(tp) {
			 case "1":
				cmp='Usuario';break;
			 case "2":
				cmp='Administrador';break;
			 case "3":
				cmp='Vendedor';break;
			 case "4":
				cmp='Info';break;
			 case "5":
				cmp='Sistema';break;
			}


			new Ajax.Request('perfilusuario.php?cmp='+cmp,{
							method:'get',onSuccess: function(transport){
								var arrInfo = transport.responseText.evalJSON(true) ;

								  if (arrInfo[0]==true) {
									 for(j=1;j<=parseInt($('DatosSPH').title)-1;j++)
									 {
										vali=$('o'+j).title;
										$('o'+j).checked=false;
										for(i=1;i<=(arrInfo.length-1);i++)
										{

										 if(vali==arrInfo[i]){ $('o'+j).checked=true; }
										}
									  }

									  for(j=1;j<=parseInt($('Deportesl').title)-1;j++)
										 {
										vali=$('d'+j).title;
										$('d'+j).checked=false;
										for(i=1;i<=(arrInfo.length-1);i++)
											{
											 if(vali==arrInfo[i]){ $('d'+j).checked=true; }
											}
										 }
									}

								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});







	}





	function cartes(tec)

	{

		a=tec;

		val='';

		for (ii=0;ii<=a.length-1;ii++)

		{

		val=val+a.charCodeAt(ii)+'*';

		}

		return val;

	}



	var bgroung='';


function valiDD(e,t,o,gp,IDB,oEvent,tablaID)
		{

	   /*  oEvent= oEvent || window.event;
	     var txtfield = oEvent.target || oEvent.srcElement;	*/

		$('tti').lang=$("c"+o).title;
		ccol=$("c"+o).lang;

		vrc=ccol.split('%');

		//$(vrc[0]+e).checked=false;



		//$(vrc[1]+e).checked=false;



			colunn=vrc[1].split('|');



			sercol=''







			for(tt=0;tt<=colunn.length-1;tt++)



			{



				if (colunn[tt].search('-')==-1)



				{



					sercol+=colunn[tt]+'|';



				}



			}



			if (vrc[0]==1){

				if ($("tl").title!=o)
				{

					 if ($("tl").title!='') {



							desactivar(parseInt($("tl").title));



							ccol=$("c"+o).lang;



							vrc=ccol.split('%')



							colunn=vrc[1].split('|');



							sercol=''



							for(tt=0;tt<=colunn.length-1;tt++)



							{



							if (colunn[tt].search('-')==-1)



								{



								sercol+=colunn[tt]+'|';



								}



							}



						}



						$("tl").title=o;







				}



				colunn=sercol.split('|');



				$("lgrunico").lang=$(colunn[t]+'_'+e+'b').title;



				$(colunn[1-t]+'_'+e).checked=false;



				$("st"+e).lang=colunn[t]+' '+$("lgrunico").lang;



				$("part"+e).title=$(colunn[t]+'_'+e+'a').lang;



				$(colunn[1-t]+'_'+e+'k').style.backgroundColor=$("part"+e).style.backgroundColor;



				$(colunn[1-t]+'_'+e+'k').style.fontSize="11px";







				$("part_2_"+e).title=o;







				if ($(colunn[t]+'_'+e).checked==false)



				{



					$("part"+e).lang='0';



					$(colunn[t]+'_'+e+'k').style.backgroundColor=$("part"+e).style.backgroundColor;



					$(colunn[t]+'_'+e+'k').style.fontSize="11px";







				}else



				{



					$("part"+e).lang='1';



					$(colunn[t]+'_'+e+'k').style.backgroundColor="#FFFF00";;



					$(colunn[t]+'_'+e+'k').style.fontSize="15px";







				}







				if (permitir(vrc[vrc.length-1],0)==true)



				{



					formatclick('0',0,false,0,0);



				}else{



					$(colunn[t]+'_'+e).checked=false;



					$("part"+e).lang='0';



					return false;



				}



			}







			if (vrc[0]>=2){
			    DesInactivo();
				Inactivo();
				$("tl"+gp).title=o;
				colunn=sercol.split('|');
				 if (t==0 && colunn.length==2)
					xt=false;
				else
					xt=($(colunn[1-t]+'_'+e).checked==true);

				if (xt){
					$(colunn[1-t]+'_'+e).checked=false;
					$("part"+e+'_'+gp).lang=parseInt($("part"+e+'_'+gp).lang)-1;
					$(colunn[1-t]+'_'+e+'k').style.backgroundColor=$("part"+e+'_'+gp).style.backgroundColor;
					$(colunn[1-t]+'_'+e+'k').style.fontSize="11px";
					bgroung=  $("part"+e+'_'+gp).style.backgroundColor;
				}else{
					$(colunn[t]+'_'+e+'k').style.backgroundColor=$("part"+e+'_'+gp).style.backgroundColor;
					$(colunn[t]+'_'+e+'k').style.fontSize="11px";
				}
				//$("part"+e).title=$(colunn[t]+e+'a').lang+' '+$('a2'+o+t+e).lang;
				//$("part_2_"+e).title=o+'%'+$('a2'+o+t+e).title;
				if ($(colunn[t]+'_'+e).checked==false){
					$("part"+e+'_'+gp).lang=parseInt($("part"+e+'_'+gp).lang)-1;
				}else{
					$("part"+e+'_'+gp).lang=parseInt($("part"+e+'_'+gp).lang)+1;
				}//alert(parseInt($("part"+e+''+gp).lang));
				if (permitir(vrc[vrc.length-1],e,gp,o)==true)	{
					if ($(colunn[t]+'_'+e).checked==true) {
						$(colunn[t]+'_'+e+'k').style.backgroundColor="#FFFF00";//"#0066FF";

					$(colunn[t]+'_'+e+'k').style.fontSize="15px";

					$('camposmarcados').lang=$('camposmarcados').lang+(colunn[t]+'_'+e)+'|';

					}

					updatelogro(o,e,vrc[1],gp,IDB,oEvent,tablaID);

					escrute(e,gp);

					formatclick('0',gp,false,0,0);

				}else{

					$(colunn[t]+'_'+e).checked=false;

					$("part"+e+'_'+gp).lang=parseInt($("part"+e+'_'+gp).lang)-1;

					return false;

				}







			}







		}



	function updatelogro(iddd,fila,cmp,gp,IDB,txtfield,tablaID)
	{

	var bloquearLogro=false;
	var idj=$('fortt'+gp).lang;
	var idg=$('fortt'+gp).title;

	if ($('forttD_'+idg).style.display!='none')//,asynchronous:false
		new Ajax.Request("procierre.php?op=11&idj="+idj+"&idg="+idg+'&IDB='+IDB+"&IDusu="+$("usu").title,{method:'post',	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true) ;
										bloquearLogro=response;
										if (!bloquearLogro){
											$('btnprint').disabled="disabled";	$("btnprint2").disabled="disabled";
											nalert('BLOQUEADO','Disculpe Este Deporte se Encuentra Bloqueados POR MODIFICACION');
											inicialbb();
											$('forttD_'+idg).style.display='none';
										}
								},

							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});

	if (!bloquearLogro){

		colunn=cmp.split('|');
		sercol='';
		for(tt=0;tt<=colunn.length-1;tt++)
			{
				if (colunn[tt].search('-')==-1)
				{

					sercol+=colunn[tt]+'|';
				}
			}
		cmpt=sercol.split('|');
		new Ajax.Request("procierre.php?op=3&idj="+idj+"&idp="+fila+"&iddd="+iddd +"&idg="+idg+'&IDB='+IDB+'&actualiza='+$(txtfield+'_'+fila+'_Act').lang+"&tablaID="+tablaID,{
								method:'get',asynchronous:false,onSuccess: function(transport){
								var response = transport.responseText.evalJSON(true) ;
								lognuevos=response;
								if (lognuevos[0]!=-2)
								{

									$(txtfield+'_'+fila+'_Act').lang=lognuevos[4];
									uno=lognuevos[1].split('%');
									$(cmpt[0]+'_'+fila+'dy').innerHTML=uno[0];
									$(cmpt[1]+'_'+fila+'dy').innerHTML=uno[1];
									uno=lognuevos[1].split('%');
									$(cmpt[0]+'_'+fila).title=uno[0];
									$(cmpt[1]+'_'+fila).title=uno[1];

									if (lognuevos[2]!=''){
									 uno=lognuevos[2].split('%');
									 $('a2_'+iddd+'_'+'0'+'_'+fila+'dy').innerHTML=uno[0];
									 $('a2_'+iddd+'_'+'1'+'_'+fila+'dy').innerHTML=uno[1];
									 uno=lognuevos[3].split('%');
									 $('a2_'+iddd+'_'+'0'+'_'+fila).lang=uno[0];
									 $('a2_'+iddd+'_'+'1'+'_'+fila).lang=uno[1];
									 uno=lognuevos[5].split('%');
									 $('a2_'+iddd+'_'+'0'+'_'+fila).title=uno[0];
									 $('a2_'+iddd+'_'+'1'+'_'+fila).title=uno[1];
									}
									//nalert('LOGROS','Logros Actualizados! Realice de nuevo el Ticket!');
									//inicialbb();

								}
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
	}
	}

















function isset(Object1) {return ($(Object1)!=null); }


function escrute(fila,gp)
	{
		$("part"+fila+'_'+gp).title='';
		$("part_2_"+fila+'_'+gp).title='';
		$("st_"+fila+'_'+gp).lang='';

		for (iii=1;iii<=parseInt($("nctd"+gp).lang);iii++)
		{
			coll=$("nc_"+iii+'_'+gp).lang;
			tcoll=coll.split('|');
			for (ii=0;ii<=tcoll.length-1;ii++)
			{

				if (tcoll[ii].search('-')==-1)
				{
				   if (isset(tcoll[ii]+'_'+fila))
				   {

					if ($(tcoll[ii]+'_'+fila).checked==true)
					{

					valores=$(tcoll[ii]+'_'+fila+'b').lang;
					vv=valores.split('|');
					valores=$('a2_'+vv[1]+'_'+vv[0]+'_'+fila).lang;
					vv2=valores.split('|');
					if (vv2.length==3)
					{
						ttcc=vv2[2]+vv2[vv[0]];addm=vv2[2]; addm1=vv2[vv[0]];
					}
					if (vv2.length==2)
					{
						ttcc=vv2[1]+vv2[0];addm=vv2[1]; addm1=vv2[0];
					}
					if (vv2.length==1)
					{
						ttcc=vv2[0];addm='0'; addm1=vv2[0];
					}
					$("part"+fila+'_'+gp).title+=$(tcoll[ii]+'_'+fila+'a').lang+' '+ttcc+'@'+addm+'#'+addm1+'#'+$(tcoll[ii]+'_'+fila+'a').lang+'$';
					$("part_2_"+fila+'_'+gp).title+=vv[1]+'%'+$('a2_'+vv[1]+'_'+vv[0]+'_'+fila).title+'$';
					$("st_"+fila+'_'+gp).lang+=$(tcoll[ii]+'_'+fila).title+'$';
					}
				  }
				}
			}
		}
	}











	function ecruteveri(fila,cp,gp){
		mp=true;
		ncb=cp.split('|');

		for (iii=0;iii<=ncb.length-2;iii++)	{
		 if (isset("nc_"+ncb[iii]+"_"+gp)){
			coll=$("nc_"+ncb[iii]+"_"+gp).lang;

			tcoll=coll.split('|');
			for (ii=0;ii<=tcoll.length-1;ii++){
				if (tcoll[ii].search('-')==-1){
					if (isset(tcoll[ii]+'_'+fila))
						if ( $(tcoll[ii]+'_'+fila).checked==true )
							mp=false;
				}
			 }

		  }
		}

		return mp;

	}


	function verresticc(o){
		valor='';
		new Ajax.Request("proce_ajax.php",{parameters: { op:8,Iddd:o},method:'post',asynchronous:false,	onComplete: function(transport){
										var response = transport.responseText.evalJSON(true) ;
											valor=response;
										},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

									});


		return valor;
	}





	function permitir(cuenta,fila,gp,o)

	{
	  ree=true;
		frm=cuenta.split('-');tlm=0;

		tdge=$('ldegrup').lang;

		to=tdge.split('|');
		for (f=1;f<=to.length-1;f++){

		for (i=1;i<=parseInt($("tl"+to[f]).lang)-1;i++)
			{
				if($("part"+i+'_'+to[f]).lang!='0' && $("rro"+i+'_'+to[f]).style.display!='none')

				{
				 tlm+=parseInt($("part"+i+'_'+to[f]).lang);
				}
			}

		}

		switch (frm[2])
		{


			case 'o': //<--- Formato de 6 Obligadas No combinacion
				if (tlm==frm[0])

				{

					$("btnprint").disabled="";$("btnprint2").disabled="";

				}else

				{
				  if (tlm < frm[0]) {
					$("btnprint").disabled="disabled";	$("btnprint2").disabled="disabled";
					}

				}


				if (tlm > frm[0])

					{

						ree=false;
					}

				break;



			case 'i'://<--- Formato individual

				if (tlm>=frm[0])
				{

					$("btnprint").disabled="";$("btnprint2").disabled="";
				}else

				{

					if (tlm < frm[0] ) {

					$("btnprint").disabled="disabled";	$("btnprint2").disabled="disabled";

					}

				}

				if (tlm > frm[1])
				{
					ree=false;

				}

				if (frm[3]!='' && ree==true)

				{
					 ree=ecruteveri(fila,frm[3],gp);
					 if (ree==false)	{
						$("btnprint").disabled="disabled";$("btnprint2").disabled="disabled";
					 	nalert('COMBINACION','ESTA COMBINACION NO ESTA PERMITIDA!');
					 }


				}


				break;



	}


		return ree;

	}







	function  desactivar(cl)
	{
	   ccol=$("c"+cl).lang;
	   vrc=ccol.split('%');
	   colunn=vrc[1].split('|');
	   sercol='';


			for(tt=0;tt<=colunn.length-1;tt++)
			{
				if (colunn[tt].search('-')==-1)
				{
					sercol+=colunn[tt]+'|';
				}
			}

			vrc=sercol.split('|');
			for (i=1;i<=parseInt($("tl").lang)-1;i++){

					$("part"+i).lang='0';
					$("st"+i).lang='';
					$(vrc[1]+'_'+i).checked=false;
					$(vrc[0]+'_'+i).checked=false;
					$(vrc[1]+'_'+i+'k').style.backgroundColor=$("part"+i).style.backgroundColor;
					$(vrc[1]+'_'+i+'k').style.fontSize="11px";
					$(vrc[0]+'_'+i+'k').style.backgroundColor=$("part"+i).style.backgroundColor;
					$(vrc[0]+'_'+i+'k').style.fontSize="11px";

			}
	}






	function focusobjbb(oEvent,nexto)
	{




	  oEvent= oEvent || window.event;
	  var txtfield = oEvent.target || oEvent.srcElement;
	  tecla = document.all ? oEvent.keyCode : oEvent.which;



	  if(tecla==13) {



		var nv=$('cv'+nexto).lang;
		tvr=nv.split('|');

		for (i=0;i<=tvr.length-1;i++)
		{

			if (tvr[i]==txtfield.id)
			{

				if (i+1<tvr.length)
				{
					amarcar=tvr[i+1];break;
				}else{
					amarcar=tvr[1];break;

				}
			}
		}



		 $(amarcar).focus();
		 $(amarcar).select();

	  }
	}







	function focusobjbb2(oEvent,nexto)



	{







	  oEvent= oEvent || window.event;



	  var txtfield = oEvent.target || oEvent.srcElement;











	  tecla = document.all ? oEvent.keyCode : oEvent.which;







	  if(tecla==13) {











		 $(nexto).focus();



		 $(nexto).select();







	  }



	}







	function focusobjbbg(oEvent,nexto,id)



	{



	  oEvent= oEvent || window.event;



	  var txtfield = oEvent.target || oEvent.srcElement;



	  tecla = document.all ? oEvent.keyCode : oEvent.which;







	  if(tecla==13) {



		if (id==1)



		{



			if (parseInt(txtfield.value)>=0 && parseInt(txtfield.value)<=23)



			{



				$(nexto).focus();



				$(nexto).select();



			}else{



				$(txtfield.id).focus();



				$(txtfield.id).select();



				alert('Error al colocar la Hora \n EL FORMATO UTILIZADO ES HORA MILITAR');



			}



		}



		if (id==2)



		{



			if (parseInt(txtfield.value)>=0 && parseInt(txtfield.value)<=59)



			{



				$(nexto).focus();



				$(nexto).select();



			}else{
				$(txtfield.id).focus();
				$(txtfield.id).select();
				alert('Error al colocar los Minutos \n EL FORMATO UTILIZADO ES HORA MILITAR');

			}
		}
	  }

	}


	function permitebb(elEvento, permitidos,eventodb,col,j) {



	  // Variables que definen los caracteres permitidos



	  var numeros = "0123456789+-.";
	  var caracteres = " abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ+-";
	  var numeros_caracteres = numeros + caracteres;
	  var teclas_especiales = [8, 37, 39, 46];

	  // 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha
	  // Seleccionar los caracteres a partir del parámetro de la función

	  switch(permitidos) {
		case 'num':
		  permitidos = numeros;
		  break;
		case 'car':
		  permitidos = caracteres;
		  break;
		case 'num_car':
		  permitidos = numeros_caracteres;
		  break;
	  }



	  // Obtener la tecla pulsada



	  var evento = elEvento || window.event;
	  var txtfield = elEvento.target || elEvento.srcElement;
	  var codigoCaracter = document.all ? elEvento.keyCode : elEvento.which;
	  var caracter = String.fromCharCode(codigoCaracter);



	  // Comprobar si la tecla pulsada es alguna de las teclas especiales



	  // (teclas de borrado y flechas horizontales)



	  var tecla_especial = false;
	  for(var i in teclas_especiales) {
		if(codigoCaracter == teclas_especiales[i]) {
		  tecla_especial = true;
		  break;
		}
	  }
	pasar=true;
	if (eventodb==1 && tecla_especial==false)
	{

		vercol=col.split('|');

		campos=vercol[1].split('-');
		camposv1=campos[1]+j;
		campos=vercol[3].split('-');
		camposv2=campos[1]+j;

		v1=$(camposv1).value;
		v2=$(camposv2).value;

		if (txtfield.id==camposv1)
		{
			if (permitidos.indexOf(caracter) != -1) {$(camposv2).value=$(camposv1).value+caracter; $(camposv2).value=-1*Number($(camposv2).value);}
		}
		if (txtfield.id==camposv2)
		{
			if (permitidos.indexOf(caracter) != -1) {$(camposv1).value=$(camposv2).value+caracter; $(camposv1).value=-1*Number($(camposv1).value);}
		}


	}
	if (eventodb==2 && tecla_especial==false)
	{
		vercol=col.split('|');

		campos=vercol[1].split('-');
		camposv1=campos[1]+j;
		campos=vercol[3].split('-');
		camposv2=campos[1]+j;

		if (txtfield.id==camposv1)
		{
			if (permitidos.indexOf(caracter) != -1) {$(camposv2).value=$(camposv1).value+caracter; }
		}
		if (txtfield.id==camposv2)
		{
			if (permitidos.indexOf(caracter) != -1) {$(camposv1).value=$(camposv2).value+caracter; }
		}
	}

	// alert(permitidos.indexOf(caracter) != -1 || tecla_especial);
	// Comprobar si la tecla pulsada se encuentra en los caracteres permitidos
	// o si es una tecla especial

	  return (permitidos.indexOf(caracter) != -1 || tecla_especial) && pasar;

	}


	function copiarvaloresjsonbb(oEvent)
	{
			oEvent= oEvent || window.event;
			var txtfield = oEvent.target || oEvent.srcElement;
			cmpo=$(txtfield.id).lang;
			id=$(txtfield.id).title;
			valorop=$(cmpo+id).value;

			cant=$("cant_p").lang;

			for (ii=1;ii<=cant;ii++)
			  $(cmpo+ii).value=	valorop;

	}



	function asignarfocus(cmpo,idd)

	{

		$(idd).lang=cmpo;

	}





function cargarcierre()
	{
		element2=document.getElementById("fc").lang;
		var element =  document.getElementById("coc");


				new Ajax.Request('cierrebb.php?idj='+element2,{

   		 					method:'get',	onSuccess: function(transport){
    						var response = transport.responseText;
							element.innerHTML=response;
							response.evalScripts();

 		   					},
  		  					onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
							});



	}


function cierrebb(oEvent,i,gp)
{

  		oEvent= oEvent || window.event;
  		var img = oEvent.target || oEvent.srcElement;
  		 IDusu=$('usu').title;
		 idj=$('n_idc').title;
		 acceso=false;

		 if (	$(img).lang=='0' ) {
		  var password=prompt('Introduzca su Clave para Abrir la Jugada!',' ');
		  if (password=='11oo'){ acceso=true; } else { alert ('Clave Errada'); }

		 }else{	acceso=true; }

		 if (acceso){
		 $(img).disable="disabled";
		 new Ajax.Request("procierre.php?op=1&idj="+idj+"&idp="+i+"&idu="+IDusu+'&dp='+gp,{
   		 					method:'get',asynchronous:false,	onSuccess: function(transport){
    						var response = transport.responseText.evalJSON(true) ;
							 $(img).disable="";
							  if (response==true)
							  {
								if ($(img).lang=='1')
								{

									$(img).src="media/lock.png";
									$(img).lang='0';
								}else{

									$(img).src="media/unlock.png";
									$(img).lang='1';
								}
							  }else{

								  alert(' No puedo abrir el partido, debido a que el escrute ya se realizo. ');



							  }

 		   					},

 		  					onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

							});

		 }
}
function cierreautoajax(op,idj)
{

	new Ajax.Request('procierre.php?op=7&idj='+idj+'&idu='+$('usu').title, {
		method: 'get', onSuccess:
		function (transport){
		 var response = transport.responseText.evalJSON(true);
		    $('horaser').innerHTML=response[0];
           if ((response.length-1)!=0){
		 	for (ii=1;ii<=(response.length-1);ii++)
		 	{

				$('img_'+response[ii]).src="media/lock.png";
				$('img_'+response[ii]).lang='0';
				ultiidp=response[ii];
			}
				 if (ultiidp != 0) {
				$('uno_'+ultiidp).style.textDecoration='blink';
				$('dos_'+ultiidp).style.textDecoration='blink';
				$('tres_'+ultiidp).style.textDecoration='blink';
				$('cuatro_'+ultiidp).style.textDecoration='blink';
					if (desb!=0){
						$('uno_'+desb).style.textDecoration='';
						$('dos_'+desb).style.textDecoration='';
						$('tres_'+desb).style.textDecoration='';
						$('cuatro_'+desb).style.textDecoration='';
					}else{ desb=ultiidp;}
			   }
		   }
		},

 		  					onFailure: function(){  $('horaser').innerHTML='NO HAY COMUNICACION'; }

	});

}
var inievvedec=false;
var timerID=0;
var ultiidp=0;
var desb=0;
function cierreauto(op,idj)
{


if (op==1){

	timerID = setInterval("cierreautoajax("+op+","+idj+")", 10000);

	inievvedec=true;
}
if (op==2){
	 if (inievvedec) { clearInterval(timerID); inievvedec=false;}
  }
}

function Activar_Ventas(idp,idj,IDB){
		new Ajax.Request("ticketbb-3.php?xidj="+idj+"&idp="+idp+"&tdl="+$('forttD_'+idp).lang+'&IDB='+IDB,{method:'post',	onComplete: function(transport){
					var response = transport.responseText;
					$('forttD_'+idp).innerHTML=response;
				   },onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }});
}

function activarcc(idp,idj,IDB)
	{

		activarrefress(2,0,0);
		activarrefress(1,idp,idj);


	    if 	($('forttD_'+idp).style.display=='none')
			new Ajax.Request("procierre.php?op=11&idj="+idj+"&idg="+idp+"&IDB="+IDB,{method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText.evalJSON(true) ;
										bloquearLogro=response;
										if (bloquearLogro){
											mientrasProceso('Actualizando','Logros..!')
											Activar_Ventas(idp,idj,IDB)
											$('forttD_'+idp).style.display=''
										}
								},

							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});



	}

	var evve=false;
	var cantidaddeerrores=0;

	function activarrefress(op,dp,idj)
	{

	   // idj=$('jornada').title;



		if (op==1){
		evve=new Ajax.PeriodicalUpdater('', 'procierre.php?op=2&idj='+idj+'&dp='+dp, {
			method: 'get', decay:1,frequency: 240, onSuccess:
			function (transport){
			   var response = transport.responseText;
			   pc=response.split('|');
	           cantidaddeerrores=0;
			   for (i=0;i<=pc.length-1;i++)
			   {

				  if ($($('rro_2_'+pc[i]).lang).style.display!="none")
				   {
					 alert('Se Cerraron unos partidos Verifique Por Favor!');
					 $($('rro_2_'+pc[i]).lang).style.display="none";
					 $("btnprint").disabled="disabled";$("btnprint2").disabled="disabled";
				   }
			   }
			},onFailure: function(){
			        if (cantidaddeerrores==2){
						nalert('ERROR!','No tengo respuesta Comuniquese con el Administrador!');
						evve.stop();
						window.location.reload();

					}else
			        	cantidaddeerrores++;
					 }});
		}

	  if (op==2){

		 if (evve!=false) { evve.stop(); }
	  }

	}





	function desbloqueo(IDusu)

	{

		if (IDusu!=parseInt($('usu').title))

		{

			 new Ajax.Request("usuario-1-2.php?pr=3&idu="+IDusu+"&idt="+$("usu").title,{

								method:'get',	onSuccess: function(transport){

								var response = transport.responseText.evalJSON(true) ;

								if (response==true)

								{

								 $('blk'+IDusu).style.display='none';

								}

								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});

		}else{

			alert('Disculpe: Pero el Usuario que quiere desbloquear es esta Sesion!!');

		}

	}


	function LogroVista(fileout){

		 var lista=new Array;k=0;
		 valormaxi=$('totalg').lang;

		 for (i=1;i<=valormaxi-1;i++){

			 if ($('chk0'+i).checked==true){
				 	lista[k]=$('chk0'+i).lang;k++
			 }

		 }

		 lista.toJSON();

		abrir(fileout+'?idj='+v+'&idg='+lista+'&usu='+$("con").title+'&IDB='+$('IDB').value,'Reporte de Logros ',1,0,0,0,0,0,1,400,400,100,100,1);
	}

	function imprimirlogro(valormaxi)

	{
		 var lista=new Array;k=0;
		 for (i=1;i<=valormaxi-1;i++){

			 if ($('chk0'+i).checked==true){
				 	lista[k]=$('chk0'+i).lang;k++
			 }

		 }

		 lista.toJSON();

		 v=$("fc").lang;
	     if (k!=0){
		 if ($('salida').value==1) {
			     $fileout='impresionlogros.php';
				  makeResultwin('vista.php','vista2k');

		 }else{
			    $fileout='impresionlogrosticket.php';
			 	abrir($fileout+'?idj='+v+'&idg='+lista+'&usu='+$("con").title+'&IDB='+$('IDB').value,'Reporte de Logros ',1,0,0,0,0,0,1,400,400,100,100,1);
		 	  }
		 }else{
			 alert('No ha seleccionado ningun Deporte..!');
		 }


	}

	  function camposImpLog(){

			   Calendar.setup({
				   inputField     :    "fc",           // id of the input field
				   ifFormat       :    "%e/%m/%Y",    // format of the input field
				   align          :    "Tl",           // alignment (defaults to "Bl")
				   singleClick    :    true,
				   onUpdate       :    camposImpLogMOD
				 });
	}



	function camposImpLogMOD(cal) {
	  var date = cal.date;
	  var field = $("fc");


		mes=date.print("%m");

		if (parseInt(mes)<=9){
			mes2=mes.substring(1,2);
		}else{
			mes2=mes;
		}
		field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");
		jsonvalores('fc');


		/////////////////////////////////////////////////////////////////
		 new Ajax.Request('logrosimprimirNK.php',{ parameters: { xfc:field.value },
			 method:'get',
				onComplete: function(transport){
				var response = transport.responseText ;
					$("verligrup").innerHTML = response;
					//response.evalScripts();
			   },

			   onCreate: function(){
					$("verligrup").innerHTML = '<img src="media/ajax-loader.gif" />';
			   },
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });
		/////////////////////////////////////////////////////////////////


		}

	function opcionVerTk(serial,op)
	{

			var element2 =  $("verticket");
		   	 if (op==1){
			   formatoticket(serial);
			 }else{
			 	if ($('chek'+serial).checked==true){
					formatoticket(serial);
				}else{
					$("printer2").innerHTML = 'DEBE VERIFICAR EL TICKET PARA MOSTRAR EL DETALLE!';
				}
			 }
	}


function ByView(serial,op)
	{

			var element2 =  $("verticket");
		   	 if (op==1){
			   formatoticket(serial);
			 }else{

					formatoticket(serial);

			 }
	}
	 var r_g;
	function formatoticket(se){




		  new Ajax.Request("fescrutes.php?serial="+se,{
								method:'get',asynchronous:false,
								onComplete: function(transport){
								var response = transport.responseText.evalJSON(true);
								r_g=response;
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});





		new Ajax.Request("procierre.php?op=4&serial="+se,{
								method:'get',asynchronous:false,
								onCreate: function(){
										$("printer2").innerHTML = '<div align="center" ><img src="media/ajax-loader.gif" /></div>';
								 },

							 onComplete: function(transport){

									var response2 = transport.responseText.evalJSON(true) ;
									//alert(r_g);
									arl=response2;
									//ap=$("ap").value;
									//lg=$("lgrunico").lang;
									//alert(arl);

									valoreex=arl[0].split('|');

									tti='Parlay';//$("c"+parseInt($("tl").title)).title ;

	 conces=arl[arl.length-1];
	 new Ajax.Request('contro_bb.php?tp=3&con='+conces,{
								method:'get',asynchronous:false,	onSuccess: function(transport){
								var response = transport.responseText.evalJSON(true) ;
								direcc=response;
								 },
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});



				a='<table width="235" border="0" style="font-size:10px; font-family:Arial, Helvetica, sans-serif"> <tr>   <th colspan="3" scope="col" >'+tti+' Ticket No:'+se+'</th> </tr><tr>    <th width="5" scope="col">Jgo.</th> <th  scope="col" width="78" >Equipos</th>    <th width="35" scope="col">Logro</th>  </tr>'  ;

				 b= '<table  border="0" style="font-size:18px" align="left" style="color:#666"> <tr>  <th colspan="3" scope="col"  ><p align="center" style="color:#666"> ..::Parlay En Linea::. </p></th> </tr><tr><th colspan="3" scope="col" align="center"> ^**^***^ TICKET NO VALIDO *^*^***^</th></tr> <tr>   <th colspan="3" scope="col" style="color:#666">No. Ticket:'+se+'*****COPIA*****</th> </tr> <tr>   <th colspan="3" scope="col" >Fecha:'+valoreex[1]+' Hora:'+valoreex[0]+'</th> </tr> <tr>   <th colspan="3" scope="col" ><p align="left">Agencia:'+conces+'</p></th> </tr><tr>   <th colspan="3" scope="col" >'+tti+'</th> </tr><tr>    <th  scope="col">Hora</th> <th  scope="col" >Partido</th>    <th scope="col">Total</th>  </tr><tr><th colspan="3" scope="col"><p align="left">--------------------------------------</p></th></tr>'  ;


								 for (i=1;i<=arl.length-2;i++) {
									  dequi=arl[i].split('|');
									  Tescrute='';

									  switch(r_g[i-1]) {
										 case 1:
										  Tescrute='-GANO'; break;
										 case 0:
										  Tescrute='-PERDIO'; break;
										 case 2:
										   Tescrute='-S/E'; break;
									  }
									  code=dequi[2].split('-');
					a+='<tr><th scope="col" > '+dequi[1]+'</th><th scope="col" width="78" class="alinl"  >' +dequi[2]+'</th><th scope="col" width="35" >   '+dequi[3]+Tescrute+'  </th></tr>';
				  b+='<tr><th scope="col">'+dequi[1]+'</th><th scope="col" align="left" >   '+dequi[2]+'</th><th scope="col"  align="right">  '+dequi[3]+Tescrute+'</th></tr>';
									 }


	a+='<tr><th colspan="3" scope="col"><p align="left">------------------------------------------------</p></th></tr><tr><th colspan="2" scope="col">Apuesta  .</th><th scope="col" ><p align="right">'+valoreex[2]+'</p></th> </tr><tr><th colspan="2" scope="col">A Cobrar:  </th> <th scope="col" ><p align="right">'+valoreex[3]+'</p></th> </tr>  <tr><th colspan="2" scope="col">Su Ganacia:</th><th scope="col"><p align="right">'+(parseInt(valoreex[3])-parseInt(valoreex[2]))+'</p></th>  </tr>';

	b+='<tr>  <th colspan="3" scope="col" align="left" >-------------------------------------</th> </tr><tr><th colspan="2" scope="col" align="left">Precio  : </th><th scope="col" align="right">'+valoreex[2]+'</th> </tr><tr><th colspan="2" scope="col" align="left">Premio  :</th> <th scope="col" align="right">'+valoreex[3]+'</th> </tr>  <tr>  <th colspan="2" scope="col" align="left">Su Ganacia  :</th> <th scope="col" align="right">'+(parseInt(valoreex[3])-parseInt(valoreex[2]))+'</th>  </tr>';


	b+='<tr><th colspan="3" scope="col" align="center"> CADUCA A LOS 7  DIAS </th></tr><tr></tr>';


		b+='<tr><th colspan="3" scope="col" align="center"> NO SE ACEPTA DEVOLUCIONES DESPUES</th></tr><tr></tr>';
	b+='<tr><th colspan="3" scope="col" align="center"> DE LOS '+$('cngfvendedor').lang+' MIN</th></tr><tr></tr>';

		$("printer2").innerHTML=a+'</table>';



		//$("printer").style.display="none";



		$("printer").innerHTML=b+'<th>SEGURIDAD:</th> <th colspan="2">'+valoreex[4]+'</th> </tr><tr><th colspan="3" scope="col" align="center">****** VERIFIQUE SU JUGADA *****</th></tr><tr>- </tr><tr>- </tr><tr>- </tr><tr>- </tr><tr>- </tr><tr>- </tr></table>'


								},



								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }



								});

	}




	function eliminarticketbb(se,img,admon)

	{

	 if (confirm('ESTA SEGURO DE ELIMINAR EL TICKET :'+se+'?')==true){
		 idc=$('con').title;

		new Ajax.Request("procierre.php?op=5&serial="+se+'&opadmon='+admon+'&idc='+idc,{

								method:'get',	onSuccess: function(transport){

									var response = transport.responseText.evalJSON(true) ;

									switch(response)

									{

										case 0:

										$(img).style.display="none";

										$(img.id+'v').style.display="none";

										$(img.id+'o').src="media/esiact.png";

										$("menu1").innerHTML='';

										break;

										case 1:

										nalert('ERROR','Este ticket no puede Ser Eliminado, porque el partido ya esta cerrado');

										break;

										case 2:

										nalert('ERROR','Usted ya elimino la cantidad de Ticket permitido por este Dia');

										break;

										case 3:

										nalert('ERROR','Usted ya no puede eliminar este tiquet porque sobrepaso el tiempo Establecido!');

										break;

									}

								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});

	 }



	}
function eliminarticketbbByAdmon(se,admon)
	{

	 if (confirm('ESTA SEGURO DE ELIMINAR EL TICKET :'+se+'?')==true){

		new Ajax.Request("procierre.php?op=5&serial="+se+'&opadmon='+admon,{

								method:'get',	onSuccess: function(transport){

									var response = transport.responseText.evalJSON(true) ;

									switch(response)

									{

										case 0:

										mygrid.setRowColor(se, '#FF3737')

										break;

										case 1:

										alert('Este ticket no puede Ser Eliminado, porque el partido ya esta cerrado');
										switch ($('TagSeleccionado').lang){
											case 'a1':	mygrid.setRowColor(se, '#FF3737'); break;
											case 'a2':	mygrid1.setRowColor(se, '#FF3737'); break;
											case 'a3':	mygrid2.setRowColor(se, '#FF3737'); break;
										}

										break;

										case 2:

										alert('Usted ya elimino la cantidad de Ticket permitido por este Dia');

										break;

									}

								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});

	 }



	}

	function reimprimirticketbb(se,op)
	{
	if (op==1){ pasa=true;
	}else{
	 	if ($('chek'+se).checked==true){
		 pasa=true;
		}else{
		 pasa=false;
		 $("printer2").innerHTML = 'DEBE VERIFICAR EL TICKET PARA SER REIMPRESO!';
		}
	}

	if (pasa){
	opcionVerTk(se,1);
	$('printer').style.display='';
	print();
	alert('Ticket No. '+se+' Impreso....!');
	//$('printer').style.display='none';
	}

	}






function makeRequestbb(url,obj) {
		 activarrefress(2,0,0);  cierreauto(2,0);
		 fecha=$("fch").title;
		 cns=$("con").title;
		 $("menu1").innerHTML="";
		 $("printer").innerHTML='';
		 var element =  $(obj);

			new Ajax.Request(url+'?fc='+fecha+'&idc='+cns,{parameters: { idt: $("usu").title },
								method:'get',	onComplete: function(transport){
									var response = transport.responseText ;
										element.innerHTML=response;
										response.evalScripts();
								},
								 onCreate: function(){
									element.innerHTML  = '<img src="media/ajax-loader.gif" />';

								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});

		}


	/****************************************************************************************************************/

	//****************************** Funciones de Configuracion para el Deportes ************************************/

	/****************************************************************************************************************/



	function opmenu(scr)

	{

		$('menu1').innerHTML='';

		new Ajax.Request(scr,{parameters: { idt: $("usu").title },

								method:'get',	onSuccess: function(transport){

									var response = transport.responseText ;



										$("submenucng").innerHTML=response;

										response.evalScripts();



								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});

	}



	function opmenu2(scr,obj)

	{

		$(obj).innerHTML='';

		new Ajax.Request(scr,{

								method:'get',	onSuccess: function(transport){

									var response = transport.responseText ;



										$(obj).innerHTML=response;

										response.evalScripts();



								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});

	}




	function grabar_cnf1(op,ldc,tb,otlc)

	{

		var lv=ldc.split('|');

		var valores= new Array();

		var okey=true;

		for (i=0;i<=lv.length-1;i++)

		{

		   var Slv=lv[i].split('.');

		   if (Slv[1]=='value'){

			valores[i]=Slv[0]+':'+escape($(Slv[0]).value);

			av=$(Slv[0]).value;

			if (av.blank()==true)	{ okey=false;	}

		   }
		   if (Slv[1]=='lang'){

			valores[i]=Slv[0]+':'+escape($(Slv[0]).lang);

			av=$(Slv[0]).lang;

			if (av.blank()==true)	{ okey=false;	}

		   }
		   if (Slv[1]=='checked'){

			if ($(Slv[0]).checked){ valordelcheck=1; }else{valordelcheck=0;}
			valores[i]=Slv[0]+':'+escape(valordelcheck);



		   }



		}

		if (otlc==false) {okey=true;}

		if (okey==true) {

		valores.toJSON();


    // alert ('cfngdeportes.php?op='+op+'&ldv='+valores+'&tb='+tb);
	new Ajax.Request('cfngdeportes.php?op='+op+'&ldv='+valores+'&tb='+tb+"&idt="+$("usu").title,{

								method:'get',	onSuccess: function(transport){

									var response = transport.responseText ;

									$("estado").innerHTML=response;
									if (response)
										logs(-4,'Escrutes Actulizados',1)





								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});

		}else{

			alert (' Lo Siento pero hay campos en Blanco Verifique NO SE PUEDE ALMACENAR ');

		}



	}
function logs(modulo,motivo,estatus){
	new Ajax.Request('logs.php',{  parameters: { idt:$("usu").title,Idm:modulo,asun:motivo,act:estatus },
								method:'post',	onSuccess: function(transport){
									var response = transport.responseText ;
								},
									onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});
}
function eliminar_cnf1(op,ldc,tb)
	{
		var lv=ldc.split('|');
		var valores= new Array();
		var okey=true;
		for (i=0;i<=lv.length-1;i++)
		{
			valores[i]=lv[i];
		}

	valores.toJSON();

	new Ajax.Request('cfngdeportes.php?op='+op+'&ldv='+valores+'&tb='+tb,{
								method:'get',	onSuccess: function(transport){
									var response = transport.responseText ;
									$("estado").innerHTML=response;

								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});



	}


	function verlista(veobj)

	{

		opmenu('ver_listadederportes-1.php?grupo='+veobj);

	}



	function verlista2(veobj)

	{

		opmenu('ver_gruposdejugada-1.php?grupo='+veobj);

	}



	function verlista3(veobj)


	{

		opmenu('cnfjuegosdd-1.php?grupo='+veobj);

	}



	function verlista4(veobj)

	{

		opmenu('listadeequipos-1.php?grupo='+veobj);

	}

	function verlista5(veobj)

	{

		opmenu('ver_listadeusuariodd-1.php?idr='+veobj);

	}
	function verlista6(veobj)

	{
	 makeResultwin('listerestricciones-1.php?idc='+veobj,'tablemenu')


	}

	function caet(obj,tb,ldv)

	{



	new Ajax.Request('cfngdeportes.php?op=3&tb='+tb+'&ldv='+ldv,{

								method:'get',	onSuccess: function(transport){

									var response = transport.responseText.evalJSON(true) ;



										if (response==1){

											$(obj).src='media/esact.png';

										}else{

											$(obj).src='media/esiact.png';

										}



								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});

	}



	function uploadFile(obj) {

	$('fromiut').submit();

	var a=$(obj).value;

	a1=a.split(String.fromCharCode(92));

	$('imgdp').src= 'media/'+a1[a1.length-1];

	$(obj).lang=a1[a1.length-1];

	}



	function uploadFile2(obj) {



	$('fromiut').submit();

	var a=$(obj).value;

	a1=a.split(String.fromCharCode(92));

	extension=a1[a1.length-1].split('.');



	if (extension[1]=='png' || extension[1]=='PNG') {

		$(obj).lang=a1[a1.length-1];

		$('imgver').src= 'images/logo/'+a1[a1.length-1];

	} else {

		$(obj).value='';

		alert('SOLAMENTE SE ACEPTAN LOGOS CON EXTENSION PNG!');

	}



	}

	function vista_jnc(obj,iddd)

	{

	new Ajax.Request('por_tipo_de_formato.php?op=1&fdg='+$(obj).value+'&iddd='+iddd,{

								method:'get',	onSuccess: function(transport){

									var response = transport.responseText ;

									$('cdsf').innerHTML=response;

								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});



	new Ajax.Request('por_tipo_de_formato.php?op=2&fdg='+$(obj).value+'&iddd='+iddd,{

								method:'get',	onSuccess: function(transport){

									var response = transport.responseText ;

									$('asf').innerHTML=response;

								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});



	}



	function combina_click()

	{

		tdc='';



		for (ii=1;ii<=parseInt($('tdc_c').lang)-1;ii++)

		{

			if ($('io'+ii).checked==true){

			 tdc=tdc+ii+'|';

			}

		}



		$('noCombinar').lang=tdc;

	}





	//**************************************************************************************************************/

	var ulclass;

	var selccio;

	function browsell(oEvent,op,nc)

	{

	 var img=oEvent;



	 if (op==1)

	   {

		for (i=1;i<=nc;i++)

		{

		if ($($(img).id+i).className!=null){

		 ulclass=$($(img).id+i).className;

		 $($(img).id+i).className="resal";

		 }

		}

	   }



	 if (op==2){

		 for (i=1;i<=nc;i++)

		{

		 if ($($(img).id+i).className!=null){

			$($(img).id+i).className=ulclass;

		 }

		}

		}

	}

	function browsell1(oEvent,op,nc)

	{

	 var img=oEvent;



	 if (op==1)

	   {

		for (i=1;i<=nc;i++)

		{

		if ($($(img).id+i).className!=null){

		 ulclass=$($(img).id+i).className;

		 $($(img).id+i).className="resal2";

		 }

		}

	   }



	 if (op==2){

		 for (i=1;i<=nc;i++)

		{

		 if ($($(img).id+i).className!=null){

			$($(img).id+i).className=ulclass;

		 }

		}

		}

	}



	function browsellH(oEvent,op,nc)

	{

	 var img=oEvent;



	 if (op==1)

	   {

		for (i=1;i<=nc;i++)

		{

		if ($($(img).id+i).className!=null){

		 ulclass=$($(img).id+i).className;

		 $($(img).id+i).className="resal2";

		 }

		}

	   }



	 if (op==2){

		 for (i=1;i<=nc;i++)

		{

		 if ($($(img).id+i).className!=null){

			$($(img).id+i).className=ulclass;

		 }

		}

		}

	}

	/*/**************************/

	function jsonvalores2(oEvent)

		{



			$("menu1").innerHTML='';



			 new Ajax.Request("ver_jugadabb-2.php?fc1="+oEvent+'&idc='+cns,{

			 method:'get',

				onComplete: function(transport){

				var response = transport.responseText ;

					$("tabl").innerHTML = response;

					response.evalScripts();

			   },

			   onCreate: function(){

					$("tabl").innerHTML = '<img src="media/ajax-loader.gif" />';

			   },

				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

			  });





		}





	function jsonvalores3(idc){

			 new Ajax.Request("jornadabb-1-2.php?op=2&idc="+idc+'&dp='+$('Grupo').value+'&IDB='+$('IDB').value+"&idt="+$("usu").title,{
			 method:'get',asynchronous:false,
				onComplete: function(transport){
				var response = transport.responseText.evalJSON(true) ;
					$("cant_p").value = response;
			   },

				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

			  });

		}





	function cargarcampos_e()

	{

			   Calendar.setup({

				   inputField     :    "fc",           // id of the input field

				   ifFormat       :    "%e/%m/%Y",    // format of the input field

				   align          :    "Tl",           // alignment (defaults to "Bl")

				   singleClick    :    true,

				   onUpdate       :    catcalc_e

				 });

	}



	function catcalc_e(cal) {

	  var date = cal.date;

	   var field = $("fc");



		  mes=date.print("%m");

		if (parseInt(mes)<=9){

			mes2=mes.substring(1,2);

		}

		else{

			mes2=mes;

		}

			field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");



		jsonvalores_esc('fc');





		}



	function jsonvalores_esc(obj)

		{



			 new Ajax.Request("escrute-2.php?fc="+$(obj).value,{

			 method:'get',

				onComplete: function(transport){

				var response = transport.responseText;

				$('box4').innerHTML = response;

				response.evalScripts();

			   },

				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

			  });

		}



	function opmenu_escrute(scr)

	{

		new Ajax.Request(scr,{

								method:'get',	onComplete: function(transport){

									var response = transport.responseText ;



										$("menu1").innerHTML=response;

										response.evalScripts();

										$("tablemenu").innerHTML='';



								},onCreate: function(){

									$("menu1").innerHTML  = '<img src="media/ajax-loader.gif" />';

								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});

	}

	function opmenu_escrute_resul(scr)

	{

		new Ajax.Request(scr,{

								method:'get',	onComplete: function(transport){

									var response = transport.responseText ;



										$("tablemenu").innerHTML=response;

										response.evalScripts();





								},onCreate: function(){

									$("tablemenu").innerHTML  = '<img src="media/ajax-loader.gif" />';

								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});

	}



function organizar(cng,ops)
	{
		nc=parseInt($('ctn').lang)-1;
		lcng='';
			for (j=1;j<=nc;j++)
			{
				lnea=$('ln'+j).lang;
				vlrs=lnea.split('|');
				lcng=lcng+vlrs[2]+'|';
				for (z=1;z<=parseInt(vlrs[0]);z++)
				{
					if (parseInt(vlrs[1])==1){
					  if (ops==true){
						lcng=lcng+'!-';
					  }else{
						 lcng=lcng+parseInt($('c'+vlrs[2]+''+z).value)+'-';
					  }
					}

					if (parseInt(vlrs[1])==2 || parseInt(vlrs[1])==4){
					   if (ops==true){
						   lcng=lcng+'!-';
					   }else{
						if ($('c'+vlrs[2]+''+z).checked==true){
						lcng=lcng+'1-';
						}else{
						lcng=lcng+'0-';
						}
					  }
					}
				 if (parseInt(vlrs[1])==3){
					  if (ops==true){
						lcng=lcng+'!-';
					  }else{
						 lcng=lcng+parseInt($('c'+vlrs[2]+''+z).value)+'-';
					  }
					}
				}
				lcng=lcng+'|';
		}
		$(cng).value=lcng;
	}


	function activarp()

	{

		$('Escrute').value='';



	}



	function makeRequesttk(url) {

			var element =  $("tablemenu");$("tablemenu").style.display="none";
			var element2 =  $("menu1");
			var fc =  $("fch").title;
			$("printer").innerHTML='';
			cns=$("con").title;


		  new Ajax.Request(url+'?fc='+fc+'&idc='+cns,{parameters: { idt: $("usu").title },
								method:'get',	onComplete: function(transport){
									var response = transport.responseText ;
										element.innerHTML = response;
										response.evalScripts();	$("tablemenu").style.display="";
								},
								 onCreate: function(){
									element.innerHTML  = '<img src="media/ajax-loader.gif" />';
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});





			new Ajax.Request('ticketbb-2.php?fc='+fc+'&op=1&idc='+cns,{parameters: { idt: $("usu").title },
								method:'get',	onComplete: function(transport){
									var response = transport.responseText ;
										element2.innerHTML = response;
										response.evalScripts();

								},

								 onCreate: function(){

									element2.innerHTML  = '<img src="media/ajax-loader.gif" />';

								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});



		  $("tablemenu").style.display="";






		   activarrefress(2);

		}





	function MM_effectHighlight(targetElement, duration, startColor, endColor, restoreColor, toggle)

	{

		Spry.Effect.DoHighlight(targetElement, {duration: duration, from: startColor, to: endColor, restoreColor: restoreColor, toggle: toggle});

	}

	function MM_effectGrowShrink(targetElement, duration, from, to, toggle, referHeight, growFromCenter)

	{

		Spry.Effect.DoGrow(targetElement, {duration: duration, from: from, to: to, toggle: toggle, referHeight: referHeight, growCenter: growFromCenter});

	}



	function MM_effectShake(targetElement)

	{

		Spry.Effect.DoShake(targetElement);

	}



	function cargarcampos_ddes1()

	{

			   Calendar.setup({

				   inputField     :    "fc1",

				   ifFormat       :    "%e/%m/%y",

				   align          :    "Tl",

				   singleClick    :    true,

				   onUpdate       :    catcalc_ddes1

				 });



	}



	function catcalc_ddes1(cal) {

	  var date = cal.date;

	  var field = $("fc1");



		mes=date.print("%m");

		if (parseInt(mes)<=9){

			mes2=mes.substring(1,2);

		}

		else{

			mes2=mes;

		}

		field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");







	}

	function cargarcampos_ddes2()

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

		}

		else{

			mes2=mes;

		}

		field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");

	}



	function imprimirredd(accesop)

	{

		d1=$("fc1").value;
		d2=$("fc2").value;
		clsi=$("uno").checked;
		if (clsi==true) {
		 gp=$("Concesionario").value;
		 clsi1=1;
		}

		clsi=$("dos").checked;
		if (clsi==true) {
		 gp=$("grupo").value;
		 clsi1=2;
		}

		clsi=$("tres").checked;
		if (clsi==true) {
		 gp=$("banca").value;
		 clsi1=3;
		}
	    if (accesop!=0) { gp=accesop; clsi1=2; }
		 abrir('reportedeventasresumidodd.php?d1='+d1+"&d2="+d2+"&clsi="+clsi1+"&gp="+gp,'Reporte de Ventas Resumido ',1,0,0,0,0,0,1,400,400,100,100,1);


	}



	function imprimirreddNK(accesop)

	{

		d1=$("fc1").value;
		d2=$("fc2").value;


		 abrir('reportedeventasresumidodNK.php?d1='+d1+"&d2="+d2+'&gp='+$('grupo').value,'Reporte de Ventas Resumido ',1,0,0,0,0,0,1,400,400,100,100,1);


	}
	function imprimirANULADO(accesop)

	{

		d1=$("fc1").value;
		d2=$("fc2").value;
		clsi=$("uno").checked;
		if (clsi==true) {
		 gp=$("Concesionario").value;
		 clsi1=1;
		}

		clsi=$("dos").checked;
		if (clsi==true) {
		 gp=$("grupo").value;
		 clsi1=2;
		}

		clsi=$("tres").checked;
		if (clsi==true) {
		 gp=$("banca").value;
		 clsi1=3;
		}
	    if (accesop!=0) { gp=accesop; clsi1=2; }

		 abrir('reporterANULADO.php?d1='+d1+"&d2="+d2+"&clsi="+clsi1+"&gp="+gp,'Reporte de Ventas Anulados',1,0,0,0,0,0,1,400,400,100,100,1);


	}
	function impri_gana_perdida(accesop)

	{

		d1=$("fc1").value;
		d2=$("fc2").value;
		clsi=$("uno").checked;
		if (clsi==true) {
		 gp=$("Concesionario").value;
		 clsi1=1;
		}

		clsi=$("dos").checked;
		if (clsi==true) {
		 gp=$("grupo").value;
		 clsi1=2;
		}

		clsi=$("tres").checked;
		if (clsi==true) {
		 gp=$("banca").value;
		 clsi1=3;
		}
	      if (accesop!=0) { gp=accesop; clsi1=2; }
		 abrir('reportedeventasganaciasyperdidas.php?d1='+d1+"&d2="+d2+"&clsi="+clsi1+"&gp="+gp,'Reporte de Ganacias y Perdidas Detallado ',1,0,0,0,0,0,1,400,400,100,100,1);


	}

	function impri_gana_perdidarsm(accesop)

	{

		d1=$("fc1").value;
		d2=$("fc2").value;
		clsi=$("uno").checked;
		if (clsi==true) {
		 gp=$("Concesionario").value;
		 clsi1=1;
		}

		clsi=$("dos").checked;
		if (clsi==true) {
		 gp=$("grupo").value;
		 clsi1=2;
		}

		clsi=$("tres").checked;
		if (clsi==true) {
		 gp=$("banca").value;
		 clsi1=3;
		}
	     if (accesop!=0) { gp=accesop; clsi1=2; }
		 abrir('reportedeventasganaciasyperdidasrsm.php?d1='+d1+"&d2="+d2+"&clsi="+clsi1+"&gp="+gp,'Reporte de Ganacias y Perdidas Resumido ',1,0,0,0,0,0,1,400,400,100,100,1);


	}

	function imprimirredt(accesop)
	{



		d1=$("fc1").value;
		d2=$("fc2").value;



		clsi=$("uno").checked;
		if (clsi==true) {
		 gp=$("Concesionario").value;
		 clsi1=1;
		}


		clsi=$("dos").checked;
		if (clsi==true) {
		 gp=$("grupo").value;
		 clsi1=2;
		}



		clsi=$("tres").checked;

		if (clsi==true) {

		 gp=$("banca").value;

		 clsi1=3;

		}

	       if (accesop!=0) { gp=accesop; clsi1=2; }

		 abrir('reportedeventasdetalladodd.php?d1='+d1+"&d2="+d2+"&clsi="+clsi1+"&gp="+gp,'Reporte de Ventas ',1,0,0,0,0,0,1,400,400,100,100,1);



	}





	function imprimirredtpv()

	{





		d1=$("fc1").value;

		d2=$("fc2").value;







		 gp=$('con').title;

		 clsi1=1;





		 abrir('reportedeventasdetalladoddpv.php?d1='+d1+"&d2="+d2+"&clsi="+clsi1+"&gp="+gp,'Reporte de Ventas Punto de Venta ',1,0,0,0,0,0,1,400,400,100,100,1);



	}

	function cargarcampos_v7()

	{

			   Calendar.setup({

				   inputField     :    "fc",

				   ifFormat       :    "%e/%m/%y",

				   align          :    "Tl",

				   singleClick    :    true,

				   onUpdate       :    catcalc_v7

				 });



	}

	function catcalc_v7(cal) {

	  var date = cal.date;

	  var field = $("fc");



		mes=date.print("%m");

		if (parseInt(mes)<=9){

			mes2=mes.substring(1,2);

		}

		else{

			mes2=mes;

		}

		field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");



		jsonvalores_v7(field.value);





	}

	function jsonvalores_v7(oEvent)
	{

		$("menu1").innerHTML='';
		if (isset('idt'))  {
		 source="ver_jugadabb-2admon.php?fc1="+oEvent+"&idt="+$('idt').lang;
		}else {
		 source="ver_jugadabb-2admon.php?fc1="+oEvent+"&idt=0";
		}

		 new Ajax.Request(source,{

   		 method:'get',

    		onComplete: function(transport){

    		var response = transport.responseText ;

				$("tabl").innerHTML = response;

				response.evalScripts();

 		   },

		   onCreate: function(){

				$("tabl").innerHTML = '<img src="media/ajax-loader.gif" />';

 		   },

  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

		  });





	if (isset('idt'))  {
		 source="conces_verdd.php?fc1="+oEvent+"&idt="+$('idt').lang;
		}else {
		 source="conces_verdd.php?fc1="+oEvent+"&idt=0";
		}

		 new Ajax.Request(source,{

   		 method:'get',

    		onComplete: function(transport){

    		var response = transport.responseText ;

				$("cns_1").innerHTML = response;

				},

  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

		  });



	}





	function jsonvalores_v8()

		{



			$("menu1").innerHTML='';

			if (parseInt($('bserial').value)!=0) {

				 tp=1;valor=parseInt($('bserial').value);$('bserial').value=0;

			}

			if (parseInt($('bmonto').value)!=0) {

				 tp=2;valor=parseInt($('bmonto').value);$('bmonto').value=0;

			}

			if (parseInt($('bmonto2').value)!=0) {

				 tp=3;valor=parseInt($('bmonto2').value);$('bmonto2').value=0;

			}



			switch (tp)

			{

				case 1: vlor="serial="; break;

				case 2: vlor="ap="; break;

				case 3: vlor="acobrar="; break;

			}

			if (isset('idt'))  {
		 	source="ver_jugadabb-2admon.php?idt="+$('idt').lang+"&"+vlor+valor;
			}else {
			 source="ver_jugadabb-2admon.php?idt=0&"+vlor+valor;
			}






			 new Ajax.Request("ver_jugadabb-2admon.php?"+vlor+valor,{

			 method:'get',

				onComplete: function(transport){

				var response = transport.responseText ;

					$("tabl").innerHTML = response;

					response.evalScripts();

			   },

			   onCreate: function(){

					$("tabl").innerHTML = '<img src="media/ajax-loader.gif" />';

			   },

				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

			  });









		}



	function jsonvalores_v9(oEvent)

		{

			$("menu1").innerHTML='';



			 new Ajax.Request("ver_jugadabb-2admon.php?fc2="+oEvent+"&IDC="+$('tidc').value,{

			 method:'get',

				onComplete: function(transport){

				var response = transport.responseText ;

					$("tabl").innerHTML = response;

					response.evalScripts();

			   },

			   onCreate: function(){

					$("tabl").innerHTML = '<img src="media/ajax-loader.gif" />';

			   },

				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

			  });

		}



	function cargarcampos_v10()

	{

			   Calendar.setup({

				   inputField     :    "fc",

				   ifFormat       :    "%e/%m/%y",

				   align          :    "Tl",

				   singleClick    :    true,

				   onUpdate       :    catcalc_v10

				 });



	}

	function catcalc_v10(cal) {

	  var date = cal.date;

	  var field = $("fc");



		mes=date.print("%m");

		if (parseInt(mes)<=9){

			mes2=mes.substring(1,2);

		}

		else{

			mes2=mes;

		}

		field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");



		jsonvalores_v10(field.value);





	}

	function jsonvalores_v10(oEvent)

		{



			$("menu1").innerHTML='';



			 new Ajax.Request("ver_jugadabb-2admonpv.php?fc1="+oEvent+"&idc="+$('con').title,{

			 method:'get',

				onComplete: function(transport){

				var response = transport.responseText ;

					$("tabl").innerHTML = response;

					response.evalScripts();

			   },

			   onCreate: function(){

					$("tabl").innerHTML = '<img src="media/ajax-loader.gif" />';

			   },

				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

			  });







		}



	function jsonvalores_v11()

		{



			$("menu1").innerHTML='';

			if (parseInt($('bserial').value)!=0) {

				 tp=1;valor=parseInt($('bserial').value);$('bserial').value=0;

			}



			 new Ajax.Request("ver_jugadabb-2admonpv.php?serial="+valor+"&idc="+$('con').title,{

			 method:'get',

				onComplete: function(transport){

				var response = transport.responseText ;

					$("tabl").innerHTML = response;

					response.evalScripts();

			   },

			   onCreate: function(){

					$("tabl").innerHTML = '<img src="media/ajax-loader.gif" />';

			   },

				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

			  });


	}

	function impresionverticketdd()

	{





		sql=$("inssql").lang;

		if ($('ti').checked==true) { tipo=1;}

		if ($('tp').checked==true) { tipo=2;}



		 abrir('imprimirticketseldd.php?sql='+sql+"&tipo="+tipo,'Reporte de Ticket ',1,0,0,0,0,0,1,400,400,100,100,1);



	}



	function imprimi_reporte(nrp)

	{





		d1=$("fc1").value;

		d2=$("fc2").value;



		gp=$('con').title;

		clsi1=1;



		abrir(nrp+'?d1='+d1+"&d2="+d2+"&clsi="+clsi1+"&gp="+gp,'Reporte de Ventas Punto de Venta ',0,0,0,0,0,1,1,400,400,100,100,1);



	}


	function makeResultwin(scr,obj)

	{
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

	}


	var emensa=false;
	var hora_de_msn='';


	function mensajesactualiza(op)
	{
		if (op==1){

		emensa=new Ajax.PeriodicalUpdater('', 'dowmensaje.php', {
			method: 'get', decay: 5, onSuccess:
			function (transport){
			   var response = transport.responseText.evalJSON(true);

		//	   if (hora_de_msn!=response[0]){

				$('retirados').innerHTML = response[1];
				$('macuare').innerHTML = response[2];
				$('ganadores').innerHTML = response[3];
				$('info').innerHTML = response[4];

			//   }
			}

			});


		}
		if (op==2){
			 if (emensa!=false) { emensa.stop();}
	  }

	}

	var veresta=false;
	function verestatustabla(op)
	{
		if (op==1){
		IDCN=$('jnd').title;
		idc=$('con').title;
		IDJugada=$('tj').title;
		carr=$('carrera').lang;
		veresta=new Ajax.PeriodicalUpdater('', "sumatablatotal.php?op=3&IDCN="+IDCN+"&idc="+idc+'&idj='+IDJugada+"&carr="+carr, {
			method: 'get', decay: 30, onSuccess:
			function (transport){
			   var response = transport.responseText.evalJSON(true);

			   if (response==false){
				$('esta2').style.display='none';
				$('esta1').style.display='';
				$('botonimp').style.display='none';
			   }
			}

			});
		}
		if (op==2){
			 if (veresta!=false) { veresta.stop(); }
	  }

	}

	function grabarrestricciones()

	{



		var valores= new Array();


		for (i=1;i<=parseInt($('tdr').lang);i++)
		{
		  valores[i]='';
		  valores[i]=$('IDC').lang+'|'+$('mmxj'+i).value+'|'+$('mmxj'+i).lang;
		 }





		valores.toJSON();



	new Ajax.Request('cfngdeportes.php?op=5&ldv='+valores,{

								method:'get',	onSuccess: function(transport){

									var response = transport.responseText ;

									$("estado").innerHTML=response;





								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});




	}

	function calculodeparlay()
	{
		ap=parseInt($('apuesta').value);
		valorini=0;
		for (f=1;f<=7;f++)
		{

					valocc1=parseInt($('prl'+f).value);
					  // ********************  Calculo del Parlay ***********************************
					  if (valocc1<0)
					  {
						valorf=valocc1*-1;      // Factor  <0 100/Logro + 1 * Apuesta
						factor=(100/valorf)+1;
						ap=(factor*ap);
						valorini=ap;

					  }
					  if (valocc1>0){
						  factor=(valocc1/100)+1; // Factor  >0 Logro/100 + 1 * Apuesta
						  ap=(factor*ap);
						  valorini=ap;
					  }

					  //*********************************************************************************
		}


	$('montacbra').innerHTML=redond(valorini,2);

	}

	function limpiarparlay()
	{
		$('apuesta').value='';

		for (f=1;f<=7;f++)
		{
		 $('prl'+f).value='';
		}


	$('montacbra').innerHTML='0';

	}

	function imprimirresultado(valormaxi)
	{
		 var lista=new Array;k=0;
		 for (i=1;i<=valormaxi-1;i++){

			 if ($('chk0'+i).checked==true){
				 	lista[k]=$('chk0'+i).lang;k++
			 }

		 }

		 lista.toJSON();

		 v=$("fc").lang;
		 if (k!=0){
			 if ($('salida').value==1)
			     $fileout='impresionresultados.php';
			 else
			 	$fileout='impresionresultadossticket.php';

			abrir($fileout+'?idj='+v+'&idg='+lista+'&usu='+$("con").title,'Reporte de Resultados ',1,0,0,0,0,1,1,400,400,100,100,1);
		 }else{
			 alert('No ha seleccionado ningun Deporte..!');
		 }



	}
var kp=0;
function NOAcceso(){

		  var f = function(v){
            return function(){
				 if (v>=1 && v<=3) kp=kp-5;
				 if (v>=4 && v<=9) kp=kp+5;
				 if (v>=10 && v<=13)  kp=kp-5;

                 dhxWins1.window("w1").setPosition(480+kp, 120);
           };
       };
       for(var i = 1; i < 13; i++){
           setTimeout(f(i), i*10);
       }
}

function accesoalsistema()
{
 	  var element =  $("tablemenu");
      getuser=getCookie('rndusr');
	  v3='';
	  idusuario=$('idusuario').value;
	  clave=$('idclave').value;

	  new Ajax.Request('logon.php?op=1&usu='+idusuario+'&pwd='+hex_md5(clave)+'&ck='+getuser,{
			method:'get',onCreate: function(){

								$("repuesta").innerHTML  = '<img src="media/ajax-loader.gif" />';

							},onSuccess: function(transport){
			var response = transport.responseText;
			var arrInfo = response.split("||");
 		             if (!eval(arrInfo[0])) {
						   	 $("repuesta").innerHTML ="";
                              /*$("fch").style.display="none";
	                          $("jnd").style.display="none";
	                          $("usu").style.display="none";
	                          $("est").style.display="none";*/
							 // NOAcceso();
							  $('idusuario').value="";  $('idclave').value="";
							  switch (arrInfo[1]){
								  	case '1':
										$("repuesta").innerHTML ='<strong style="color:#FF0000">Usuario Bloqueado</strong>';
										break;
									case '3':
										nalert('HORARIO','ESTA FUERA DEL HORARIO PARA LA VENTA!');
										break;
									default:
								      $("repuesta").innerHTML ='<strong style="color:#FF0000">El Usuario No Existe o Clave Errada</strong>';
							  }
							  $('idusuario').focus();
							  //alert ('El Usuario No Existe');
					  } else {
						 //************************************************************************************////

						if  (arrInfo[10]!=0){
						//dhxWins1.window("w1").close();

						$('tablemenu2').style.display="none";$('header2').style.display="";$('logo').style.display="none";
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
				         $("cngfvendedor").lang=arrInfo[11];
						 $("con").title=arrInfo[1];
						 $("con").style.display="";
						 $("fch").style.display="";
						 $("fch").innerHTML ='Fecha:'+arrInfo[4];
						 $("fch").title=arrInfo[4];
						 /*$("jnd").style.display="";*/
						 $("jnd").innerHTML ='Jornada:'+arrInfo[5];
						 $("jnd").title=arrInfo[5];
						 $("usu").style.display="";
						 $("usu").innerHTML ='Usuario:'+idusuario;
						 $("usu").title=arrInfo[7];	 $("usu").lang =idusuario;
						 $("est").style.display="";
						 $("est").innerHTML ='Estacion:'+arrInfo[2];
						 $("est").title=arrInfo[2];
					     setCookie('rndusr', arrInfo[6]);
						  document.cookie = "sessionhash="+arrInfo[7]+"; max-age=" + (60*60*24*4) ;
						 $("header2").lang=arrInfo[8];
						 var element =  $("topmenu");
						 var element2 =  $("menu1");


						 /*$("p").bgColor="#000000";
						 $("fd1").bgColor="#D3DCE6";
						 $("fd2").bgColor="#FFFFFF"; $("header").style.display="none";
						  $("vercons").style.display="";*/

		                $("header2").style.display="";
						  /*$("menu2").style.display="none";
						$("menu3").style.display="none";
						 $("news").style.display="";
						 */



						/* new Ajax.Request('topmenu.php?op='+oko+'&op2='+arrInfo[9],{
   		 					method:'get',	onSuccess: function(transport){
    						var response = transport.responseText;
							element.innerHTML=response;
 		   					},
  		  					onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
							});    */



                         $("tablemenu").style.display="";
						 initMenu($("header2").lang);

						new Ajax.Request('chatactivo.php',{
   		 					method:'get',	onSuccess: function(transport){
    						var response = transport.responseText;

							response.evalScripts();
 		   					},
  		  					onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
							});
					}else{
					 	makeResultwin2('newClave.php?usu='+idusuario,'repuesta')
					 }

					  }


		   },
  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });

}


function marcat(id)
	{
		for (i=1;i<=$('totalg').lang-1;i++)
		{
			if ($('chk'+id+i).checked==true) {
				$('chk'+id+i).checked=false;
			}else{
				$('chk'+id+i).checked=true;
			}
		}

	}


function captural(fc,idj)
{
	 new Ajax.Request('cpyjndbb.php?fc='+fc+'&gp='+$('Grupo').value+'&idj='+idj,{
   		 					method:'get',	onSuccess: function(transport){
    						var response = transport.responseText.evalJSON(true);
								if (response[0]){
									if (response[1]==1){ $('resultado').update('No Hay Logros Publicados'); } else
									{ $('resultado').update('Logros Actualizados'); }
								}else{
									 nalert('ERROR','Error: En Tabla No'+response[1]);
								}
								$('resultado').innerHTML;

 		   					},onCreate: function(){ mientrasProceso('Logros Copiados','Copiando...'); },
  		  					  onFailure: function(){ nalert('ERROR','No tengo respuesta Comuniquese con el Administrador!'); }
							});

}

function cargarcampos_publi()
{

	       Calendar.setup({
               inputField     :    "fc",           // id of the input field
               ifFormat       :    "%e/%m/%y",    // format of the input field
               align          :    "Tl",           // alignment (defaults to "Bl")
               singleClick    :    true,
			   onUpdate       :    catcalc_publi
             });

}



function catcalc_publi(cal) {
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

	makeResultwin('publicacc-2.php?fc='+field.value+'&IDB='+$('IDB').value ,'box6');

}

function publicardd(oEvent,idj,gp)
{

  		oEvent= oEvent || window.event;
  		var img = oEvent.target || oEvent.srcElement;

		 //alert("procierre.php?op=5&idj="+idj+"&grupo="+gp);
		 new Ajax.Request("procierre.php?op=6&idj="+idj+"&grupo="+gp+"&IDB="+$('IDB').value,{
   		 					method:'get',asynchronous:false,	onSuccess: function(transport){
    						var response = transport.responseText.evalJSON(true) ;
							  if (response==1)
							  {
							  	    $(img).src="media/ver2.png";
									logs(-3,'Publicacion de Logros '+gp,1)

								}else{
									$(img).src="media/lock.png";
									logs(-3,'Bloqueo de Logros '+gp,1)

								}

 		   					},

 		  					onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

							});

}

function btnstop()
{
 if ($('btn').lang==1){
 cierreauto(2,0);
 $('dbj').style.display="none";
 $('btn').lang=2; $('btn').value='Iniciar';
 }else{
 cierreauto(1,$('n_idc').title);
 $('dbj').style.display="";
 $('btn').lang=1;$('btn').value='Parar Cierre';
 }

}
function cierrePartidos(){
	gp_x=0;
	for (j=1;j<=parseInt($('totaldefilar').lang)-1;j++)
		{
			if (gp_x!=parseInt($("part_x"+j).lang))
			{
			   gp_x=parseInt($("part_x"+j).lang);
			   i=1;
			}else{
				i++;
			}

			if ($("part"+i+'_'+gp_x).lang!=0 && $("rro"+i+'_'+gp_x).style.display!='none') verifparti($("ipd"+i+'_'+gp_x).lang,true,false);
		}
}
function verifparti(idp,sincronizacion,mensaje)
{
	     valor=false;$("btnprint").disabled="disabled";	$("btnprint2").disabled="disabled";
		 new Ajax.Request('procierre.php?op=8&idp='+idp,{
   		 					method:'get',asynchronous:sincronizacion,	onSuccess: function(transport){
    						var response = transport.responseText.evalJSON(true);
                         	if (response){
								if (mensaje)
									alert('Se Cerraro unos partidos Verifique Por Favor!');
		         				$($('rro_2_'+idp).lang).style.display="none";
		         				$("btnprint").disabled="disabled";	$("btnprint2").disabled="disabled";
								valor=true;
								}else{
								$("btnprint").disabled="";	$("btnprint2").disabled="";
								}
							},
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
							});

		 return valor;

}

function makeResultwin2(scr,obj)
	{
		new Ajax.Request(scr,{

								method:'get',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText ;
										$(obj).innerHTML=response;
										response.evalScripts();
								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});

	}

function sverifacion(e,serial)
{
	oEvent= e || window.event;
	var txtfield = oEvent.target || oEvent.srcElement;

	if (txtfield.checked){
					se=prompt('Escriba el Serial Electronico para Verificar su Validez?');
					if (se!=''){
					verif=true;
					new Ajax.Request('procierre.php?op=9&serial='+serial+'&se='+se,{
								method:'get',asynchronous:false,onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
									if (response){
										$('se'+serial).innerHTML=se;$('mt'+serial).innerHTML=$('mt'+serial).lang;
										alert('CORRECTO: Ticket Verificado, Puede Pagarlo');
									}else{
										alert('Lo Siento pero el Serial ELECTRONICO No es VALIDO!');	verif=false;
									}

								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});
					 return verif;

					}else {return false;}

	}else{
	return false;
	}
}
function makeRequestHIPI(url) {

			 new Ajax.Request(url,{ parameters: { idt: $("usu").title },
			 method:'get',
				onComplete: function(transport){
				var response = transport.responseText ;
					$("tablemenu").innerHTML = response;
					response.evalScripts();
			   },

			   onCreate: function(){
					$("tablemenu").innerHTML = '<img src="media/ajax-loader.gif" />';
			   },
				onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });

		}

function datoscierresph()
{			 element1 = $("fc").value;
			 element2 = $("sjornada").value;
			 if (element2==''){
				 element2 =0;
				 }

		new Ajax.Request('cierresph2.php?fecha='+element1+'&idcn='+element2+'&tipo=4',{
								method:'get',	onSuccess: function(transport){
								var response = transport.responseText ;
								$("lganadores").innerHTML=response;
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
}

function cambiarest(oEvent,i)
		 {
			 oEvent= oEvent || window.event;
			 var txtfield = oEvent.target || oEvent.srcElement;
			 c="c"+i;
			 if (txtfield.lang=='1') {
			  txtfield.lang='0';
			  txtfield.src="media/unlock.png";
			}else{

			   txtfield.src="media/lock.png"
			   txtfield.lang='1';
			 }



			 grabarganadores(0);
	}



function grabar_ganadores(oEvent)
		 {
			oEvent= oEvent || window.event;
			 var txtfield = oEvent.target || oEvent.srcElement;

			txtfield.src="media/listo.png";
			grabarganadores(1);
		 }


function grabarganadores(op)
		 {

			  ganar='';
			  cierre='';
			  for (i=1; i<=$("ncarr").title; i++)
				{
					if (op==1){
					for (j=1; j<=4; j++)
					  {
							  ganar+=$("p"+i+j).value+'|';
					  }

					ganar+='*';
					}else{
					if ($("ch"+i).lang == '1')
					{
						cierre+='1'+'|';
					}else{
						cierre+='0'+'|';
					}
				  }
				}
				element1 = $("sjornada").value;
				carr =  $("ncarr").title;
				var elm =  $("ver");

				new Ajax.Request('ganadores-1-2.php?jn='+element1+'&gn='+ganar+'&cr='+cierre+'&carr='+carr+'&op='+op,{
								method:'get',asynchronous:false,	onSuccess: function(transport){
								var response = transport.responseText ;
								elm.innerHTML =response;
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
		 }
function createByxml(_file,_sql,_campos)
{
 new Ajax.Request('newxml.php',{ parameters: { file:_file,sql:_sql,campos:_campos },	method:'get',asynchronous:false,
				               onComplete: function(transport){
									var response = transport.responseText ;

								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
}
function createByxmlForverJugada(_file1,_file2,_file3,_idj)
{
 new Ajax.Request('xmlverjugada.php',{ parameters: { file1:_file1,file2:_file2,file3:_file3,idj:_idj },	method:'get',asynchronous:false,
				               onComplete: function(transport){
									var response = transport.responseText ;


								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
}
function grabarBycupoBygrupo(_IDG,_maximoCupo)
{
	 var respuesta=false;
	 new Ajax.Request('grupo-1-2.php',{ parameters: { IDG:_IDG,maximoCupo:_maximoCupo,pr:3 },	method:'get',asynchronous:false,
				               onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
			                        respuesta=response;
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
	return respuesta;
}
function cargarFechaForVer()
	{

			   Calendar.setup({
				   inputField     :    "fc",
				   ifFormat       :    "%e/%m/%y",
				   align          :    "Tl",
				   singleClick    :    true,
				   onUpdate       :    catcalc_FechaForVer
				 });
	}

	function catcalc_FechaForVer(cal) {
	  var date = cal.date;
	  var field = $("fc");
		mes=date.print("%m");
		if (parseInt(mes)<=9){
			mes2=mes.substring(1,2);
		}else{
			mes2=mes;
		}

		field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");
		jsonvalores_catcalc_FechaForVer(field.value);
	}

function jsonvalores_catcalc_FechaForVer(oEvent)
	{

		source="verfecha.php?fc="+oEvent+"&idt=0";
		$("menu1").innerHTML='';
		 new Ajax.Request(source,{
   		 method:'get',onComplete: function(transport){
    		var response = transport.responseText.evalJSON(true);
				$("fc").lang = response;
 		   },	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });
/*
	if (isset('idt'))  {
		 source="conces_verdd.php?fc1="+oEvent+"&idt="+$('idt').lang;
		}else {
		 source="conces_verdd.php?fc1="+oEvent+"&idt=0";
		}

		 new Ajax.Request(source,{

   		 method:'get',

    		onComplete: function(transport){

    		var response = transport.responseText ;

				$("cns_1").innerHTML = response;

				},

  		  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

		  });	*/
	}
function nalert(titulo,Mensaje){
 Ext.MessageBox.alert(titulo, Mensaje);
}
function grabarBycupoBygrupodd(_IDG,_celda,_maximoCupo)
{
	 var respuesta=false;
	 new Ajax.Request('grupodd-1-2.php',{ parameters: { IDG:_IDG,maximoCupo:_maximoCupo,celda:_celda },	method:'get',asynchronous:false,
				               onComplete: function(transport){
									var response = transport.responseText.evalJSON(true);
			                        respuesta=response;
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
	return respuesta;
}
function mientrasProceso(msgfinal,txtMsg){
        Ext.MessageBox.show({
           title: 'Espere un Momento',
           msg: txtMsg,
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
					//$('printer').style.display='none';
                }else{
                    var i = v/11;
                    Ext.MessageBox.updateProgress(i, Math.round(100*i)+'% completed');
                }
           };
       };
       for(var i = 1; i < 13; i++){
           setTimeout(f(i), i*200);
       }
    }
function CopyToLista(IDC)
	{
		source="procierre.php?op=12&IDC="+IDC;
		 new Ajax.Request(source,{
   		 method:'get',onComplete: function(transport){
    		var response = transport.responseText.evalJSON(true);

 		   },	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });
	}

function GenerarClave(){
	 clave='';
	 for (i=1;i<=5;i++){
		 var aleatorio = Math.floor(Math.random()*11);
		 clave=clave+aleatorio;
		}

	$('claveGenerada').innerHTML=clave;


}
function ClaveNueva(){

var newclave=$('nwclave').value;
if (newclave.length>=4 && newclave.length<=7){
if (newclave!=''){
	if (newclave==$('re_nwclave').value){
		 source='procierre.php';
		 new Ajax.Request(source,{ parameters: {op:13, usu:$('usuario').lang,pwdnew:newclave },
   		 method:'post',onComplete: function(transport){
    		var response = transport.responseText.evalJSON(true);

			if (response){
					dhxWins2.window("w1").close();
					nalert('CONFIRMACION','Clave Actualizada ...');

			}else{
				nalert('ERROR','INTENTE DE NUEVO ERROR ACTUALIZANDO LA CLAVE!');
				$('nwclave').value='';
				$('re_nwclave').value='';
				$('nwclave').focus();
			}

 		   },	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });


	}else{
		nalert('ERROR','LAS CLAVES NO SON IGUALES (VERIFIQUE)!');
		$('nwclave').value='';
		$('re_nwclave').value='';
		$('nwclave').focus();
	}
	}else{
		nalert('ERROR','LAS CLAVES NO PUEDE ESTAR EN BLANCO!');
		$('nwclave').value='';
		$('re_nwclave').value='';
		$('nwclave').focus();
	}
	}else{
		nalert('ERROR','LAS CLAVES DEBE CONTENER MAS DE 4 CARACTERES y HASTA 7!');
		$('nwclave').value='';
		$('re_nwclave').value='';
		$('nwclave').focus();
	}
}

function VerificarClave(){
var Resultado=false;
var clave=$('clave').value;
if (clave.length>=4 && clave.length<=7){
if (clave!=''){
		 source='procierre.php';
		 new Ajax.Request(source,{ parameters: {op:14, usu:$('usuario').lang,pwdnew:clave },
   		 method:'post',asynchronous:false,onComplete: function(transport){
    		var response = transport.responseText.evalJSON(true);
			if (response){
					dhxWins2.window("w1").close();
					Resultado=true;

			}else{
				nalert('ERROR','CLAVE ERRADA!');
				dhxWins2.window("w1").close();
				Resultado=false;
			}

 		   },	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });
	}else{
		nalert('ERROR','LAS CLAVES NO PUEDE ESTAR EN BLANCO!');
		$('clave').value='';
		$('clave').focus();
	}
	}else{
		nalert('ERROR','LAS CLAVES DEBE CONTENER MAS DE 4 CARACTERES y HASTA 7!');
		$('clave').value='';
		$('clave').focus();
	}
	return Resultado;
}

function initMenu(_Autorizados) {

		archivo='arch/'+$("usu").lang+'.xml';

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

	}

function execMenu(id, zoneId, casState){
     $('stCredito').style.display="none";

	zona=id.split('-');

	if (zona[0]=='Animalitos'){
				_callBackDUK('animalitos/venta_animalitos.php')
				return true;
			}

  a=zona[0].split('');

	if (a[0]=='s'){ //
		new Ajax.Request('animalitos/vermenu.php',{ parameters: { idmenu:id,idt:$("usu").title},method:'post',asynchronous:false,	onComplete: function(transport){
								var response = transport.responseText;
								 response.evalScripts();
								},
						onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
							});
							return true;
						}


	if (zona[0]=='m4' ){
		if (zona[0]=='m4')
				 window.location.reload();

	}else
		new Ajax.Request('vermenu.php',{ parameters: { idmenu:id,idt:$("usu").title},method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText;
									 response.evalScripts();
									},
							onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});


}
function grabar_banca(){

			 element1 = $("nombre").value;
			 element2 = $("responsable").value;
			 element5 = $("estatus").value;
			 element6 = $("n_idg").title;
			 var element =  $("tablemenu");

			new Ajax.Request('banca-1-2.php?nm='+element1+'&res='+element2+'&es='+element5+'&idg='+element6+'&pr=1',{method:'get',asynchronous:false	,onComplete: function(transport){
								var response = transport.responseText.evalJSON(true);

								if (response[0]){
								 		dhxWins1.window("w1").close();
										nalert('ACTUALIZACION','INFORMACION ALMACENADA!');
										makeRequestSP('banca-1-1.php');
								}else
									nalert('ERROR',response[1]);

								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});


		 }



	function eliminar_banca()
		 {

			 desci=confirm("Desea eliminar este Registro?");
			 if (desci==true){
			  element1 = $("n_idg").title;
			new Ajax.Request('banca-1-2.php?idg='+element1+'&pr=2',{method:'get',asynchronous:false	,onComplete: function(transport){
								var response = transport.responseText.evalJSON(true);

								if (response){
								 		dhxWins1.window("w1").close();
										nalert('ACTUALIZACION','LA BANCA FUE ELIMINADO');
										makeRequestSP('banca-1-1.php');
								}else
									nalert('ERROR','DISCULPE NO PUEDO ELIMINAR ESTA BANCA!!');

								},

								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});

			 }

		 }

function ImportarLogros()
		 {
			 desci=confirm("Desea Importar estos Logros?");
			 if (desci==true){


			new Ajax.Request('jornadabb-1-2.php?hasta='+$('fromcambio').lang+'&desde='+$('desde').value+'&op=3&idt='+$("usu").title,{method:'get',asynchronous:false	,onComplete: function(transport){
								var response = transport.responseText.evalJSON(true);

								if (response){
									nalert('ACTUALIZACION','Importacion Realizada');
									dhxWins1.window("w1").close();
								}else
									nalert('ERROR','DISCULPE NO PUEDO REALIZAR LA OPERACION');

								},
								onCreate:function(){mientrasProceso('Jornada Grabada','Grabando Jornada'); },
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});

			 }

		 }


function cargarcampos_publiResul()
{

	       Calendar.setup({
               inputField     :    "fc",           // id of the input field
               ifFormat       :    "%e/%m/%y",    // format of the input field
               align          :    "Tl",           // alignment (defaults to "Bl")
               singleClick    :    true,
			   onUpdate       :    catcalc_resul
             });

}



function catcalc_resul(cal) {
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

	makeResultwin('publicarResultados-2.php?fc='+field.value,'box6');
}

function publicarResultados(oEvent,idj,gp)
{

  		oEvent= oEvent || window.event;
  		var img = oEvent.target || oEvent.srcElement;

		 //alert("procierre.php?op=5&idj="+idj+"&grupo="+gp);
		 new Ajax.Request("procierre.php?op=20&idj="+idj+"&grupo="+gp,{
   		 					method:'get',asynchronous:false,	onSuccess: function(transport){
    						var response = transport.responseText.evalJSON(true) ;
							  if (response==1)
							  {
							  	    $(img).src="media/ver2.png";

								}else{
									$(img).src="media/lock.png";

								}

 		   					},

 		  					onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

							});

}
function grabarEscrute(opcion){
	 idj=$('IDJ').value;
	 gp=$('Grupo').value;

	 new Ajax.Request("procierre.php?op=21&idj="+idj+"&grupo="+gp,{
   		 					method:'get',asynchronous:false,	onSuccess: function(transport){
    						var response = transport.responseText.evalJSON(true) ;
							  if (response)
							  {
							     switch (opcion){
								   case 1:
								   organizar('Escrute',false);
								   break;
								   case 2:
								   organizar('Escrute',true);
								   break;
								   case 3:
								   activarp();
								   break;
								 }


								   grabar_cnf1(2,'Ides.value|IDP.value|Grupo.value|Fecha.value|Hora.value|Escrute.value|IDJ.value|juegocompleto.checked','_tbescrute',false);
								   opmenu_escrute('escrute-1.php?idj='+idj+'&idg='+gp);
								}else
									nalert('INFORMACION','La Publicacion de los Resultado esta Activada');

 		   					},

 		  					onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

							});

}
function pulsoENTER(e,objs) {
	  tecla = document.all ? e.keyCode : e.which;
	  oEvent= e || window.event;

	   var txtfield = oEvent.target || oEvent.srcElement;

	  if(tecla==13)
	  {
	  	$(objs).focus();
	  }

	}

function OpcionVerificarPublica(se)
{
		  var r_g;
		  new Ajax.Request("fescrutes.php?serial="+se,{
								method:'get',asynchronous:false,
								onComplete: function(transport){
								var response = transport.responseText.evalJSON(true);
								r_g=response;
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
		   if (r_g[0]!='NE'){

		  new Ajax.Request("procierre.php?op=4&serial="+se,{
								method:'get',asynchronous:false,
								onCreate: function(){
										$("resultados").innerHTML = '<div align="center" ><img src="media/ajax-loader.gif" /></div>';
								 },
							 onComplete: function(transport){
										var response2 = transport.responseText.evalJSON(true) ;
										if (response2[0])
										{
									    arl=response2;
 									    valoreex=arl[0].split('|');
									    tti='Parlay';//$("c"+parseInt($("tl").title)).title ;

									   conces=arl[arl.length-1];

	 new Ajax.Request('contro_bb.php?tp=3&con='+conces,{
								method:'get',asynchronous:false,	onSuccess: function(transport){
								var response = transport.responseText.evalJSON(true) ;
								direcc=response;
								 },
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});


				 a='<table width="235" border="0" style="font-size:10px; font-family:Arial, Helvetica, sans-serif"> <tr>   <th colspan="3" scope="col" >'+tti+' Ticket No:'+se+'</th> </tr><tr>   <th colspan="3" scope="col" >Fecha:'+valoreex[1]+' Hora:'+valoreex[0]+'</th> </tr><tr>   <th colspan="3" scope="col" >Punto de Venta:'+conces+' '+direcc+'</th> </tr><tr>    <th width="5" scope="col">Jgo.</th> <th  scope="col" width="78" >Equipos</th>    <th width="35" scope="col">Logro</th>  </tr>'  ;



					 for (i=1;i<=arl.length-2;i++)
					 {
						  dequi=arl[i].split('|');
 		                  Tescrute='';
						  switch(r_g[i-1])
  					      {
							 case 1:
 						  		Tescrute='-GANO'; break;
 		                     case 0:
				 			    Tescrute='-PERDIO'; break;
							 case 2:
		 					    Tescrute='-S/E'; break;
					        }

					a+='<tr><th scope="col" >'+(i)+' '+dequi[1]+'</th><th scope="col" width="78" class="alinl"  >   ' +dequi[2]+'</th><th scope="col" width="35" >   '+dequi[3]+Tescrute+'  </th></tr>';



	                   }


	a+='<tr><th colspan="3" scope="col"><p align="left">-------------------------------------------------------------------</p></th></tr><tr><th colspan="2" scope="col">Apuesta  .</th><th scope="col" ><p align="right">'+valoreex[2]+'</p></th> </tr><tr><th colspan="2" scope="col">A Cobrar:  </th> <th scope="col" ><p align="right">'+valoreex[3]+'</p></th> </tr>  <tr><th colspan="2" scope="col">Su Ganacia:</th><th scope="col"><p align="right">'+(parseInt(valoreex[3])-parseInt(valoreex[2]))+'</p></th>  </tr>';

		$("resultados").innerHTML=a+'</table>';
										}else{
											$("resultados").innerHTML="<blink>ESTE TICKET NO EXISTE</blink>";
										}

								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
		  }else{
			  $("resultados").innerHTML="<blink>ESTE TICKET NO EXISTE</blink>";
		  }


	}

function publicarResultados(oEvent,idj,gp)
{

  		oEvent= oEvent || window.event;
  		var img = oEvent.target || oEvent.srcElement;

		 //alert("procierre.php?op=5&idj="+idj+"&grupo="+gp);
		 new Ajax.Request("procierre.php?op=20&idj="+idj+"&grupo="+gp,{
   		 					method:'get',asynchronous:false,	onSuccess: function(transport){
    						var response = transport.responseText.evalJSON(true) ;
							  if (response==1)
							  {
							  	    $(img).src="media/ver2.png";

								}else{
									$(img).src="media/lock.png";

								}

 		   					},

 		  					onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

							});

}
function grabarEscrute(opcion){
	 idj=$('IDJ').value;
	 gp=$('Grupo').value;

	 new Ajax.Request("procierre.php?op=21&idj="+idj+"&grupo="+gp,{
   		 					method:'get',asynchronous:false,	onSuccess: function(transport){
    						var response = transport.responseText.evalJSON(true) ;
							  if (response)
							  {
							     switch (opcion){
								   case 1:
								   organizar('Escrute',false);
								   break;
								   case 2:
								   organizar('Escrute',true);
								   break;
								   case 3:
								   activarp();
								   break;
								 }


								   grabar_cnf1(2,'Ides.value|IDP.value|Grupo.value|Fecha.value|Hora.value|Escrute.value|IDJ.value|juegocompleto.checked','_tbescrute',false);
								   opmenu_escrute('escrute-1.php?idj='+idj+'&idg='+gp);
								}else
									nalert('INFORMACION','La Publicacion de los Resultado esta Activada');

 		   					},

 		  					onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

							});

}
function CkeckEstadistica(){

  mientrasProceso('Analizando','Procesando');
  new Ajax.Request("verEstadistica.php",{ parameters: { grupo:$('deporte').value,IDJ:$('fc').lang},
								method:'post',asynchronous:false,
								onComplete: function(transport){
								var response = transport.responseText.evalJSON(true);
								if (response)
									makeResultwin('verestadiscaxml-2.php?grupo='+$('deporte').value,'resul_estadistica');

								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
}
function Enlinea(){
	  new Ajax.Request("verEstadistica.php",{ parameters: { grupo:$('deporte').value,IDJ:$('fc').lang},
								method:'post',asynchronous:false,
								onComplete: function(transport){
								var response = transport.responseText.evalJSON(true);
								if (response){
									 mygrid.clearAll();
									 mygrid1.clearAll();
									 mygrid2.clearAll();
									 mygrid3.clearAll();

									 mygrid.loadXML("Total.xml");
									 mygrid1.loadXML("Parlay.xml");
									 mygrid2.loadXML("Derecho.xml");
									 mygrid3.loadXML("Premio.xml");
									 makeResultwin('grafico_1.php','boxx4');
								}


								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
}

var timerID1=0;
function AutoRefress(op){
if (op==1)
	timerID1 = setInterval("Enlinea()", 300000);
if (op==2)
	clearInterval(timerID1);
}
function createByXMLLogs()
{
 new Ajax.Request('xmlAuditoria_Acceso-2.php', {method:'get',asynchronous:false,
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


function createByxmlTreeDeportes()
{
 new Ajax.Request('xmlcreatertree-3.php', {method:'get',asynchronous:false,
				               onComplete: function(transport){
									var response = transport.responseText ;
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
}
var funcionInac;
function Inactivo(){
	funcionInac = setTimeout("inicialbb()", 60000);
}
function DesInactivo(){
    clearInterval(funcionInac);
}

function colocarTexto(i){
		$('Equi_'+i).innerHTML=$("equipo"+i).options[($("equipo"+i).value-1)].text;
}



	function imprimirreddxDerecho(){

		d1=$("fc1").value;
		d2=$("fc2").value;
		clsi=$("uno").checked;
		if (clsi==true) {
		 gp=$("Concesionario").value;
		 clsi1=1;
		}



		clsi=$("dos").checked;
		if (clsi==true) {
		 gp=$("grupo").value;
		 clsi1=2;
		}



		clsi=$("tres").checked;
		if (clsi==true) {
		 gp=$("banca").value;
		 clsi1=3;
		}

		 abrir('reportedeventasderecho.php?d1='+d1+"&d2="+d2+"&clsi="+clsi1+"&gp="+gp,'Reporte de Ventas Resumido ',1,0,0,0,0,0,1,400,400,100,100,1);
}


function verEquipos(idEqui,Grupo,Liga){
	 makeResultwin('jornadabb-1-8.php?Dequipo='+$('equipo'+idEqui).innerHTML+'&Grupo='+Grupo+'&Liga='+Liga+'&iEd='+idEqui,'tablemenu1');
}
function Devolver(idEqui,Grupo,Liga){
if (confirm('Dese regresar el cambio del equipo?'))
	new Ajax.Request('jornadabb-1-9.php?op=1&EDevolver='+$('equipoDev'+idEqui).innerHTML+'&Grupo='+Grupo+'&Liga='+Liga+'&Aequipo='+$('equipo'+idEqui).innerHTML+'&seleccion='+$('equipo'+idEqui).lang,{
   		 					method:'get',asynchronous:false,	onSuccess: function(transport){
    						var response = transport.responseText.evalJSON(true) ;
							   if (response){
								    $('equipo'+idEqui).lang=0;
									$('equipo'+idEqui).innerHTML=$('equipoDev'+idEqui).lang;
									$('equipoDev'+idEqui).style.display="none";
									$('ButonAct'+idEqui).style.display="";
									$('equipo'+idEqui).style.backgroundColor="#C00";
									}else
										alert('Disculpe no puedo devolver los cambios!');


 		   					},
 		  						onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
							});


}

var valoreslista;
function mas_menos(op,id){

	switch (op){

		case 1:
			$('linea_'+id).style.display="none";
			$('imgLmenos_'+id).style.display="none";
			$('imgLmas_'+id).style.display="";
			for (i=0;i<=valoreslista.length-2;i++) $("tpg_"+valoreslista[i]+"_"+id).style.display="none";
			break;
		case 2:
			$('linea_'+id).style.display="";
			$('imgLmenos_'+id).style.display="";
			$('imgLmas_'+id).style.display="none";
			for (i=0;i<=valoreslista.length-2;i++) $("tpg_"+valoreslista[i]+"_"+id).style.display="";
			break;
	}

}

function VerificarLogros(op){
           var  grabar=true;
			hrx='';
			pch='';
			gp='';
			equip='';
			np='';
			efec='';
			element1=$("n_idc").title;
			element2=$("fc").lang;
			cant=parseInt($("cant_p").lang);
			element5=cant;
			for (j=1;j<=cant;j++) for (i=0;i<=valoreslista.length-4;i++){ $("ERR_"+valoreslista[i]+"_"+j).innerHTML='';	}
			for (j=1;j<=cant;j++){
				hrx+=$("hora"+j).value+':'+$("min"+j).value+'|';
				pch+=$("pc1"+j).value+'|';
				gp+=$("GP1"+j).value+'|';
				efec+=$("efe1"+j).value+'|';

			}

			codigosDB='';
	        for (i=1;i<=cant;i++)
				codigosDB+=$("CodigoEq1_"+i).value+'|'+$("CodigoEq2_"+i).value+'|';

			for (i=1;i<=cant;i++)np+=$("np"+i).lang+'|';

			cant*=2;

			for (i=1;i<=cant;i++){
				if ($("equipo"+i).title=='2k')
					equip+='$'+$("equipo"+i).innerHTML+'|';
				else
					equip+=$("equipo"+i).value+'|';

				if (i>element5) {
					pch+=$("pc2"+i).value+'|';
					gp+=$("GP2"+i).value+'|';
					efec+=$("efe2"+i).value+'|';
					}
			}

			var elemd=new Array(element5);

			for (i=0;i<=element5-1;i++){
				listdecol=$('cv'+(i+1)).lang;
				arrdev=listdecol.split('|');
				elemd[i]='';
				sudgrupo=$(arrdev[1]).lang;
				subg='';
				for (j=1;j<=arrdev.length-1;j++){
				   if (sudgrupo==$(arrdev[j]).lang){
					subg+=$(arrdev[j]).value+'|';
				   }else{
					   elemd[i]+=sudgrupo+"["+subg+"*";
					   sudgrupo=$(arrdev[j]).lang;
					   subg='';
					   subg+=$(arrdev[j]).value+'|';
				   }
				}
				elemd[i]+=sudgrupo+"["+subg;

			}
			listado='';
			for (i=0;i<=elemd.length-1;i++){
			  listado=listado+elemd[i]+'/';
			}
				new Ajax.Request('jornadabb-1-10.php',{	  parameters: {idc:element1,lista:listado,fc:element2,eq:equip,hr:hrx,cant:element5,p:pch,gp:gp,e:efec,dp:$('Grupo').lang,np:np,IDB:$('IDB').lang,idt:$("usu").title,equiDB:codigosDB},

			 method:'post',asynchronous:false,

				onSuccess: function(transport){

					var response = transport.responseText.evalJSON(true);



					if  ((response.length)!=0){
				        grabar=false;
						for (i=0; i<=response.length-1; i++){
							codigo=response[i].split('|');

							valorLinea=parseInt(codigo[2])+1;
							switch(codigo[0]){

									case 'E':
										$("linea_"+valorLinea).style.backgroundColor="#C00";
									 	break;
									case '1':
									     ErrorSobra(codigo[1],valorLinea,codigo[3],"#C00")
										 $("ERR_"+codigo[3]+"_"+valorLinea).innerHTML="Logros Errados";
									 	break;
									case '2':
									     ErrorSobra(codigo[1],valorLinea,codigo[3],"#C00")
										 $("ERR_"+codigo[3]+"_"+valorLinea).innerHTML="Logros con Signo(+)";
									 	 break;
									case '6':
									     ErrorSobra(codigo[1],valorLinea,codigo[3],"#FF0")
										 $("ERR_"+codigo[3]+"_"+valorLinea).innerHTML="Carreraje y Signo Iguales";
										 if (!op) if (confirm('Desea grabar los Logros con este Error?')) { grabar=true; }
									 	 break;
									case '3':
									     ErrorSobra(codigo[1],valorLinea,codigo[3],"#C00")
										 $("ERR_"+codigo[3]+"_"+valorLinea).innerHTML="Logros/Carreraje Diferentes";
									 	 break;
									case '4':
										ErrorSobra(codigo[1],valorLinea,codigo[3],"#C00")
										if (codigo[4] == 1)
										 $("ERR_"+codigo[3]+"_"+valorLinea).innerHTML="Fuera de Rango de Logros";
										else
   									     $("ERR_"+codigo[3]+"_"+valorLinea).innerHTML="Fuera de Rango de Carreraje/Puntos";
									 	break;
							}
						}
						if (op)	alert('Hay errores en los logros por favor verique!');

					}
			   },
			onCreate:function(){mientrasProceso('Chequeando  Logros','Jornada Validada'); },
			onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

			  });



	return  grabar;

		}

function ErrorSobra(Logros,Linea,Columna,Adver){
 									   var valores=Logros.split('&');
									    var verLogros=$("tpg_"+Columna+"_"+Linea).lang;
										var iverLogros=verLogros.split('|');

										for (u=0;u<=iverLogros.length-1; u++){
										    var verGuion=iverLogros[u].split('-');
											if ( verGuion.length == 2)  campo=verGuion[1];  else campo=verGuion[0];

											if (valores[0]== $(campo+Linea ).value || valores[1]== $(campo+Linea ).value)
												$(campo+Linea).style.backgroundColor=Adver;//#C00
										}
}


function createXMLOdds(Grupo)
{
 new Ajax.Request('chkOddsTree.php', {parameters: {Grupo:Grupo}, method:'get',asynchronous:false,
				               onComplete: function(transport){
									var response = transport.responseText ;
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
}
var Camposl=new Array;

function chkOddOpt(op){

	for (u=1;u<=Camposl.length-1; u++){
	$('tx'+Camposl[u]).style.display="none";	$('cp'+Camposl[u]).style.display="none";	}

	 $('tx'+Camposl[op]).style.display="";	$('cp'+Camposl[op]).style.display="";

}
 function is_numeric(input){
    return typeof(input)=='number';
  }
var Grupo=0;
function GrabarchkOdds(){

	$('from1').request({
					  method: 'post',
 					  onComplete: function(transport){
						 var response = transport.responseText.evalJSON(true) ;
						  if (response){
						  	nalert('INFORMACION','INFORMACION ALMACENADA' )
							$('config').innerHTML=''
							mygrid1.clearAndLoad("chkOdds-4.php?Grupo="+Grupo);

						  }else
						  	nalert('ERROR','Disculpe: pero la informacion no se almaceno!')
			   			},
			  			onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  			 });

}
function EliminarchkOdds(){


	new Ajax.Request('chkOdds-3.php', {parameters: {newi:$('new').value}, method:'get',asynchronous:false,
				               onComplete: function(transport){
									 var response = transport.responseText.evalJSON(true) ;
									  if (response){
										nalert('INFORMACION','INFORMACION ELIMINADA' )
										$('config').innerHTML=''
										mygrid1.clearAndLoad("chkOdds-4.php?Grupo="+Grupo);

									  }else
										nalert('ERROR','Disculpe: pero la informacion no se Elimino!')
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});




}
///////////////////////////////////////////NUEVAS CARACTERISTICAS///////////////////////////////////////////////////
function cargarFechaForVer1()
	{

			   Calendar.setup({
				   inputField     :    "fc1",
				   ifFormat       :    "%e/%m/%y",
				   align          :    "Tl",
				   singleClick    :    true,
				   onUpdate       :    catcalc_FechaForVer1
				 });
	}

	function catcalc_FechaForVer1(cal) {
	  var date = cal.date;
	  var field = $("fc1");
		mes=date.print("%m");
		if (parseInt(mes)<=9){
			mes2=mes.substring(1,2);
		}else{
			mes2=mes;
		}

		field.value = date.print("%d")+"/"+mes2+"/"+date.print("%Y");
		jsonvalores_catcalc_FechaForVer1(field.value);
	}

function jsonvalores_catcalc_FechaForVer1(oEvent)
	{

		source="verfecha.php?fc="+oEvent+"&idt=0";
		$("menu1").innerHTML='';
		 new Ajax.Request(source,{
   		 method:'get',onComplete: function(transport){
    		var response = transport.responseText.evalJSON(true);
				$("fc1").lang = response;
 		   },	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		  });
	}


function checkAduiVentas(){
  mientrasProceso('Analizando','Procesando');
  new Ajax.Request("Auditoriadeventas.php",{ parameters: { grupo:$('deporte').value,IDJ:$('fc').lang},
								method:'post',asynchronous:false,
								onComplete: function(transport){
								var response = transport.responseText.evalJSON(true);
								if (response)
									makeResultwin('Auditoriadeventas-2.php?grupo='+$('deporte').value,'resul_Venta');

								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
////// Credito /////////
 function SeleMonto(i){
	  switch(i){
		case 1: $('Monto_TOtal').disabled="disabled";  break;
		case 2: $('Monto_TOtal').disabled="";  $('Monto_TOtal').select(); $('Monto_TOtal').focus();  break;
	  }
  }
  function iSumaValores(){

	if ($('iEfectivo').value=='') valor1=0; else valor1=parseFloat($('iEfectivo').value);
	if ($('iCheque').value=='') valor2=0; else valor2=parseFloat($('iCheque').value);
	if ($('iTransfer').value=='') valor3=0; else valor3=parseFloat($('iTransfer').value);

	$("iPago").innerHTML =  valor1+valor2+valor3;
  }
  function iHabilitaCrd(obj){

  }

/////////////////////////
function _fnactCredito(IDC){
		new Ajax.Request("crd-1-11.php",{
								parameters: { idc:IDC},method:'post',asynchronous:false,	onSuccess: function(transport){
								var response = transport.responseText.evalJSON(true) ;
									if (response[0]!='NO'){
										$('crd').innerHTML="CREDITO:"+response[0];
										$('bln').innerHTML="BALANCE:"+response[1];
										$('pnd').innerHTML="PENDIENTE:"+response[2];
										$('dip').innerHTML="DISPONIBLE:"+response[3];
									}
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});

	}
