// JavaScript Document
function SendMsgtk(serial,idc){
//  do{
    var phone = prompt("Introduzca el Numero Telefonico a enviar el Ticket");
	hay=false;
	if (phone!=null){
		if (phone.length==10){
		var res = phone.substr(0, 3);
		var listCell=new Array("412", "414", "416", "424", "426");
		for (i=0;i<=listCell.length-1;i++){
			if (listCell[i]==res){
				hay=true;
				break;
			}
		}
		if (hay){
		new Ajax.Request('whatsend.php',{parameters: {phsnd:phone, tk:$("printer").innerHTML,idc:idc,serial:serial},method:'get',asynchronous:false,
						onSuccess: function(transport){
								var response = transport.responseText.evalJSON(true) ;
								// setCookie('ticket_bb_sn',response);Serialbb= response;
								// console.log(response)
								 if (response)
									  alert('No pude enviar el Mensaje, Comuniquese con el administrador!');
									  hay=false;
								 },
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});
		}else
			alert('Este Numero Telefonico no es valido, Debe ser 412,414,424 o 426');
	}else
		alert('Este Numero Telefonico no es valido!, faltan o sobram digitos en el numero telefonico');
	}else
		alert('Este Numero Telefonico no es valido!, no introdujo el numero de telefono');

  //}while(!hay)

}
function ReSendMsgtk(serial){
	new Ajax.Request('phonesendPRX.php',{parameters: {op:1,serial:serial,phsnd:$('tele-'+serial).value},method:'get',asynchronous:false,
						onSuccess: function(transport){
								var response = transport.responseText.evalJSON(true) ;
								// setCookie('ticket_bb_sn',response);Serialbb= response;
								if (response!=-1)
									alert('Mensaje Enviado!')
								else
									alert('Este ticket no fue enviado por mensaje de texto')
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});


}
function ReSendMsgtkANI(serial,telefono){
	new Ajax.Request('phonesendPRX.php',{parameters: {op:1,serial:serial,phsnd:telefono},method:'get',asynchronous:false,
						onSuccess: function(transport){
								var response = transport.responseText.evalJSON(true) ;
								// setCookie('ticket_bb_sn',response);Serialbb= response;
								if (response!=-1)
									alert('Mensaje Enviado!')
								else
									alert('Este ticket no fue enviado por mensaje de texto')
								},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }

								});


}
function formatclick_msg(se,gp,imprimir,cambio,nuevo){

/*  html2canvas([document.getElementById(divID)], {
    onrendered: function (canvas) {
      var img = canvas.toDataURL('images'); //o por 'image/jpeg'
      //display 64bit imag
      window.open(img);
    }

    var a = document.createElement('a');
       // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
       a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
       a.download = 'somefilename.jpg';
       a.click();
  }

  html2canvas(document.querySelector("#printer2")).then(canvas => {
    var img = canvas.toDataURL('images'); //o por 'image/jpeg'
    //display 64bit imag
    img.download="prueba.jpg"
    window.open(img);
});*/



		  Serialbb=getCookie('ticket_bb_sn');
		  if (serialdedd==0) serialdedd=1;
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

						console.info('formatclick_msg');


		ap=$("ap").value;
		lg=$("lgrunico").lang;
		//tti=$("c"+parseInt($("tl"+gp).title)).title ;
		tti=$('tti').lang;

		conces=$("con").title;
		direcc=direccionconce;

		a='<table width="200" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:9px"> <tr>    <th  scope="col" width="10"  align="left"  style=" font-size:9px" >Equipos</th>    <th width="10" scope="col"  style=" font-size:9px">Logro</th>  </tr>'  ;

	//Serialbb
		var b= '*::PARLAYENLINEA::*%%Punto de VENTA: '+$("con").title+'%%Fecha:'+ff+' Hora:'+hh+'%%Serial del Ticket:'+serialdedd+'%%SU JUGADA ES:%%=====================%%'  ;


		valorini=0;

		lista='';

		i=0;gp_x=0;

		tte=0;

		mpe=0;

		lequi='';

		liddd='';
      nl=1
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
				  tecc=$("part"+i+'_'+gp_x).title;  //   43||Cleveland -9Ptos NBA@-9#Ptos NBA#43||Cleveland $42||Charlotte 203.5Ba NBA@203.5#Ba NBA#42||Charlotte $
				  tecc2=$("part_2_"+i+'_'+gp_x).title;  // 9%-9$10%203.5$
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
				  Divi1=Divi1[1].split('#');//// -9#Ptos NBA#43   -9  Ptos NBA  43
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
						  factor=(valocc1/100)+1; /// Factor  >0 Logro/100 + 1 * Apuesta
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
          // $(dequi[0]).innerHTML+'-'
				  b+=nl+'= '+nvs_pl+' '+de+'%%';
          nl++;
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
	var bn1='=====================%%Total de Apuesta(s):'+(nl-1)+'%%Monto de Ticket :'+$("ap").value+'%%A Cobra (si es ganador):'+valorini;


	//b1+='<tr><th colspan="3" scope="col" align="center"> errores de ningun tipo en los logros.</th></tr><tr></tr>';
		$("printer2").lang=lista;


		$("printer2").innerHTML=a+'</table>';

		$("printer").style.display="none";

	   b=b+bn1;

		$("printer").innerHTML=b;
	   impresion+=bn1;


	}else{
		$("printer").innerHTML=b+impresion+'<th>Segurida:</th> <th colspan="2">'+se+'</th> </tr><tr><th colspan="3" scope="col" align="center"> ****** VERIFIQUE SU JUGADA *****</th></tr></table>';

	}




	}
