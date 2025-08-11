// JavaScript Document


function copiarCaracterLogros(elEvento,obccpy,dividir,eventodb,col,j) {	
	  // Variables que definen los caracteres permitidos	
	  var numeros = "0123456789+-.";
	  var caracteres = " abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ+-";
	  var numeros_caracteres = numeros + caracteres;
	  var teclas_especiales = [8, 37, 39, 46];	
	  // 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha
	  // Seleccionar los caracteres a partir del parámetro de la función	
	 
		  permitidos = numeros;
		 
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
	if (dividir==0) 
	if (tecla_especial==false)
			if (permitidos.indexOf(caracter) != -1) {$(obccpy).value=$(txtfield).value+caracter; }
	

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
	
	