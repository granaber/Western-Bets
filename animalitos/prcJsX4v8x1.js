///// Prefijo DUK para sistema de Animalitos
//// Variables Globales

var mygridANI;
var mygrid2;
var mygrid3;
var barDUK;
var Numeros=new Array();
var ArrSort=new Array();
var TicketCloud=new Array();
var sumaSor=new Array();
var lCloud=0;
var TOPE=38;
var xCampACT='';
var ModoIng=0;
var minv=0;
var maxv=0;
var toplt=0;
var funcionInac;
var SerialMonitor=0;
var iFile;
var lCloudSorteos=new Array();
var lCloudNumeros=new Array();
var Rl1=new Array();
var Rl2=new Array();
var iIDL;
////  Instrucciones JS para sistema de Animalitos
function _iLkDUK(){

    _utxprm=bna('filephp=venta_animalitos-1.php|op=2',this);

    new Ajax.Request('animalitos/L!p¡-.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
                  var response = transport.responseText.evalJSON(true) ;

        					lCloudSorteos=response[0];
                  lCloudNumeros=response[1];

                  },
              onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
                });

}
function _callBackDUK(url) {

_utxprm=bna('filephp='+url+'|IDC='+$('con').title+'|idt='+$('usu').title,this);

  new Ajax.Request('L!p¡-.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
                var response = transport.responseText;
                $("tablemenuANI").innerHTML = response;
      					response.evalScripts();
                },
            onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
              });
      }


function _callBackGENDUK(url,parm,reps){
  _utxprm=bna('filephp='+url+parm+'|usu='+$('usu').title,this);
  new Ajax.Request('animalitos/L!p¡-.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
              var response = transport.responseText;
              $(reps).innerHTML = response;
              response.evalScripts();
              },
            onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
             });

}

function pressSpecialNMDUK(elEvento,newFocus){

  // Obtener la tecla pulsada
  var evento = elEvento || window.event;
  var txtfield = elEvento.target || elEvento.srcElement;
  var codigoCaracter = document.all ? elEvento.keyCode : elEvento.which;
  var caracter = String.fromCharCode(codigoCaracter);
  var teclas_especiales = [8, 37, 39, 46];
  if (codigoCaracter==13){
            $(newFocus).focus();
            $(newFocus).select();
  }
}

function pressSpecialDUK(elEvento,newFocus,exec){

  // Obtener la tecla pulsada
  var evento = elEvento || window.event;
  var txtfield = elEvento.target || elEvento.srcElement;
  var codigoCaracter = document.all ? elEvento.keyCode : elEvento.which;
  var caracter = String.fromCharCode(codigoCaracter);
  var teclas_especiales = [8, 37, 39, 46];
  if (codigoCaracter==13){
     if (exec==0){
      if (_MarckNumDUK('ImpNumero')){
         if (mygrid3.getRowsNum()==0 ||  $('ImpNumero').value!='' ){
            $(newFocus).focus()
            $(newFocus).select()
            xCampACT=newFocus;

         }else{
           $('ImpNumero').disable="disabled";
           $('ImpMonto').disable="disabled";
           barDUK.disableItem("Imprimir_");
           _grabarJugadaDUK(1);
         }

      }else{
        $('ImpNumero').focus()
        xCampACT='ImpNumero'
      }
    } else
        VirtualTKDUK();

  }
}
function permitebbDUK(elEvento, permitidos,eventodb,col,j) {
                // Variables que definen los caracteres permitidos
                var numeros = "0123456789*";
                var caracteres = " abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ+-";
                var numeros_caracteres = numeros + caracteres;
                var teclas_especiales = [8, 37, 39, 46];

                // 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha
                // Seleccionar los caracteres a partir del parámetro de la función

                switch(permitidos) {
                case 'real':
                  permitidos = numeros+'.';
                  break;  
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
                var noquiero="^'%¨´.";
                if (noquiero.indexOf(caracter) != -1 ) tecla_especial = false;
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
                if (txtbarDUKld.id==camposv2)
                {
                  if (permitidos.indexOf(caracter) != -1) {$(camposv1).value=$(camposv2).value+caracter; }
                }
              }
              // alert(permitidos.indexOf(caracter))
              // alert(permitidos.indexOf(caracter) != -1 || tecla_especial);
              // Comprobar si la tecla pulsada se encuentra en los caracteres permitidos
              // o si es una tecla especial

                return (permitidos.indexOf(caracter) != -1 || tecla_especial) && pasar;

}
function _contarGuarismosDUK(Lectura){
  var res = Lectura.split("");
  CountGuarimos=0;
  cLeng=res.length;
  P_I=cLeng%2;
  if (P_I!=0){
    CountGuarimos++;
    res.shift();
    cLeng=res.length;
  }
  AntiGuarimos=cLeng/2;
  CountGuarimos+=AntiGuarimos;
  return CountGuarimos;
}

function _InterpreteNumDUK(Lectura){
var res = Lectura.split("");
/// Interpretacion del Introduzca
cLeng=res.length;

P_I=cLeng%2;
var Guarismos=new Array();
var Cdos=0;

if (P_I!=0){
  Guarismos[Cdos] = res[0];
  Cdos++;
  res.shift();
  cLeng=res.length;
}

  hayserie=false;
  for (gr=0;gr<=cLeng-1;gr++){
    if ((gr%2)==0){
      Guarismos[Cdos]=res[gr];
   }else{
      Guarismos[Cdos]=Guarismos[Cdos]+res[gr];
      if (!(res[gr]=='*')){
        if (Guarismos[Cdos].indexOf("*")==-1 ){
          if (!(Number(Guarismos[Cdos])>=0 && Number(Guarismos[Cdos])<=TOPE)){
            alert('Estos numeros no son validos!')
            $('ImpNumero').value='';
            Guarismos[0]=-1;
            break;
          }
        }else
          hayserie=true;
      }else
        hayserie=true;
      Cdos++;
   }
  }

  if (!hayserie && ModoIng!=0 ){
    alert('Estos numeros no son validos para el modo de Combinatoria!')
    $('ImpNumero').value='';
    Guarismos[0]=-1;
    return Guarismos;
  }
  switch (ModoIng) {
    case 1:
      if (_contarGuarismosDUK(Lectura)!=2){
        alert('Usted selecciono una combinatoria de 2 y no estan seleccionados!')
        $('ImpNumero').focus()
        xCampACT='ImpNumero'
        Guarismos[0]=-1;
      }
      break;
    case 2:
      if (_contarGuarismosDUK(Lectura)!=3){
        alert('Usted selecciono una combinatoria de 3 y no estan seleccionados!')
        $('ImpNumero').focus()
        xCampACT='ImpNumero'
        Guarismos[0]=-1;
      }
      break;
  }

  var Rept=Guarismos.uniq();

  if (Rept.size()!=Guarismos.size()){
    alert('Los valores colocados en Numeros deben ser diferentes!')
    $('ImpNumero').focus()
    xCampACT='ImpNumero'
    Guarismos[0]=-1;
  }

  if (hayserie){
    var series=new Array();n=0;
    for (i=0;i<=Guarismos.size()-1;i++){
      hay=Guarismos[i].indexOf("*");
      if (hay!=-1){
        separar=Guarismos[i].split("");
        if (separar[0]=='*'){
          if (separar[1]<=8) t=3; else t=2;
          if (separar[0]==0) i=1; else i=0;
          for (s=i;s<=t;s++){ series[n]=s+separar[1];  n++; }
          }else{
            if (separar[0]<=3){
                if (separar[0]<=2) t=9; else t=8;
                for (s=0;s<=t;s++){ if ( (separar[0]+s)!='00' ){ series[n]=separar[0]+s; n++; } }
            }
          }
      }else{
          series[n]=Guarismos[i]; n++;}
    }

    ellos=new Array();d=0;
    for (i=0;i<=series.size();i++){
      if ( (Number(series[i])>=0 && Number(series[i])<=Number(TOPE)) ){ ellos[d]=series[i]; d++; }
    }

    Guarismos=ellos;
  }


return Guarismos;


}

function _MarckNumDUK(IDSel){


    Numeros=_InterpreteNumDUK($(IDSel).value);
    if (Numeros[0]!=-1){
        for (i=0;i<=Numeros.length-1;i++){
          mygridANI.cells(Numeros[i],0).setValue(1);
        }
        return true;
    }else {
      return false;
    }

}
function Sorteos(){

  x=0;
  for (i=0;i<=mygrid2.getRowsNum()-1;i++){
      	if (mygrid2.cells2(i, 0).getValue()==1){
          ArrSort[x]=mygrid2.getRowId(i);
          x++;
        }
  }

    return ArrSort;

}
function VirtualTKDUK(){
  lCloud=TicketCloud.length;
  Numeros=_InterpreteNumDUK($('ImpNumero').value);
  if (Numeros.length==0){
    alert('Necesita los numero(s) a jugar')
    $('ImpNumero').focus()
    xCampACT='ImpNumero'
    return false;
  }

  ArrSort=Sorteos()
  if (ArrSort.length==0){
    alert('Necesita los Sorteo(s) a jugar')
    $('ImpNumero').focus()
    xCampACT='ImpNumero'
    return false;
  }

  if (   $('ImpMonto').value==0 ||  $('ImpMonto').value==''  ){
    alert('Necesita el valor de la apuesta')
    $('ImpMonto').focus()
    xCampACT='ImpMonto'
    return false;
  }
  if (minv!=0 ){
     if (lCloud==0){
      if ( !(parseFloat($('ImpMonto').value)>=minv) ){
        alert('El valor de la Apuesta debe ser mayor a '+minv)
        $('ImpMonto').focus()
        xCampACT='ImpMonto'
        return false;
      }
    }
  }
  if (maxv!=0 ){
      if (  !(parseFloat($('ImpMonto').value)<=maxv)) {
        alert('El valor de la Apuesta debe ser  menor a '+maxv)
        $('ImpMonto').focus()
        xCampACT='ImpMonto'
        return false;
      }
  }
  Erro=0;
  lCloud=TicketCloud.length;
  for (x=0;x<=ArrSort.length-1;x++){
     switch (ModoIng) {
       case 0:
         for (y=0;y<=Numeros.length-1;y++){
           var vIndex=-1;
           TicketCloud.filter(function(element, index, array) {
                if (TicketCloud[index].numero==Numeros[y] && TicketCloud[index].sorteo==ArrSort[x])
                vIndex=index;
            })
           if (vIndex==-1){
            if ( (parseFloat($('ImpMonto').value)>=minv) ){
             lineaOBJ={numero:Numeros[y],sorteo:ArrSort[x],monto:parseFloat($('ImpMonto').value),modo:ModoIng}
             TicketCloud[lCloud]=lineaOBJ;
             lCloud++
            }else { Erro=2;}
           }else{

             if (maxv!=0 ){
                 SumaTem=  TicketCloud[vIndex].monto+parseFloat($('ImpMonto').value);
                 if (  !(parseFloat(SumaTem)<=maxv)) {
                   Erro=1;
                 }else{
                   TicketCloud[vIndex].monto+=parseFloat($('ImpMonto').value);
                 }
               }else{
                 TicketCloud[vIndex].monto+=parseFloat($('ImpMonto').value);
             }



           }
         }
         break;
        case 1:
             lineaOBJ={numero1:Numeros[0],numero2:Numeros[1],sorteo:ArrSort[x],monto:$('ImpMonto').value,modo:ModoIng}
             TicketCloud[lCloud]=lineaOBJ;
             lCloud++
           break;
       case 2:
            lineaOBJ={numero1:Numeros[0],numero2:Numeros[1],numero3:Numeros[2],sorteo:ArrSort[x],monto:$('ImpMonto').value,modo:ModoIng}
            TicketCloud[lCloud]=lineaOBJ;
            lCloud++
          break;
     }
    }

    if (Erro==1){
        alert('Hay numero de no se acepto porque superaron el limite de apuesta por numero ('+maxv+')')
    }
    if (Erro==2){
        alert('Hay numero de no se acepto porque el monto minimo no se cumplio ('+minv+')')
    }

  TicketCloud.sort(function(a, b){
      return a.sorteo-b.sorteo
  })


_restarTicketDUK()

ArrSort=new Array();
mygridANI.uncheckAll();
//mygrid2.uncheckAll();
$('ImpMonto').value='';
$('ImpNumero').value='';
$('ImpNumero').focus()
xCampACT='ImpNumero'
barDUK.setItemState('Combi1_', false);
barDUK.setItemState('Combi2_', false);
ModoIng=0
}

function _restarTicketDUK(){
  var l=1;
  var Total=0;
  mygrid3.clearAll();
  NewSorteo=0;

  for (x=0;x<=TicketCloud.length-1;x++){
    if (NewSorteo!=TicketCloud[x].sorteo){

      for (key in Rl1) {
          if ( lCloudSorteos[TicketCloud[x].sorteo][1] == Rl1[key] )
             fIDL=key;

      }
        mIDL=lCloudSorteos[TicketCloud[x].sorteo][1];

        mygrid3.addRow('0-'+TicketCloud[x].sorteo,',*'+ lCloudSorteos[TicketCloud[x].sorteo][0]+',-'+Rl2[fIDL]+'*,0');
        NewSorteo=TicketCloud[x].sorteo;
    }
    switch (TicketCloud[x].modo) {
      case 0:
        mygrid3.addRow(l,l+','+ lCloudNumeros[TicketCloud[x].numero][mIDL]+'('+TicketCloud[x].numero+')'+','+TicketCloud[x].monto+','+NewSorteo);
        break;
      case 1:
      //  mygrid3.addRow(l,l+','+ mygridANI.cells(TicketCloud[x].numero1, 3).getValue()+'('+TicketCloud[x].numero1+')-'+mygridANI.cells(TicketCloud[x].numero2, 3).getValue()+'('+TicketCloud[x].numero2+'),'+TicketCloud[x].monto+','+NewSorteo);
        break;
      case 2:
      //  mygrid3.addRow(l,l+','+ mygridANI.cells(TicketCloud[x].numero1, 3).getValue()+'('+TicketCloud[x].numero1+')-'+mygridANI.cells(TicketCloud[x].numero2, 3).getValue()+'('+TicketCloud[x].numero2+')-'+mygridANI.cells(TicketCloud[x].numero3, 3).getValue()+'('+TicketCloud[x].numero3+'),'+TicketCloud[x].monto+','+NewSorteo);
        break;
    }


    Total=Total+Number(TicketCloud[x].monto);
    l++;

  }
 $('nrsumt').innerHTML=Total;

}

function remm(valorQD){

  var unSTR=valorQD.replace(/%29/g,')');
  var unSTR=unSTR.replace(/%7C/g,'|');
  var unSTR=unSTR.replace(/%2A/g,'*');
  var unSTR=unSTR.replace(/%2B/g,'');
  var unSTR=unSTR.replace(/%3C/g,'<');
  var unSTR=unSTR.replace(/%3D/g,'=');
  var unSTR=unSTR.replace(/%3A/g,':');
  var unSTR=unSTR.replace(/%22/g,'"');
  var unSTR=unSTR.replace(/%3B/g,';');
  var unSTR=unSTR.replace(/%2C/g,',');
  var unSTR=unSTR.replace(/%3E/g,'>');
  var unSTR=unSTR.replace(/%2F/g,'/');
  var unSTR=unSTR.replace('/+/g','');
  return 	unSTR;

}
function _grabarJugadaDUK(op){


    if (op==1){
      desci=confirm("Desea Imprimir el ticket?");
      Numero='-1'
    }else{
      Numero=prompt('Por favor indique el numero telefonico (414,416,424,426)!');
      if (Numero==null)
        desci=false
      else{
        if (!(Numero.length>9)){ alert('El numero telefonico es errado!');desci=false;}else desci=true;
      }	
    }
    if (desci==true){
      
    _utxprm=bna('filephp=grabar_animalitosN2.php|Jugada='+Object.toJSON(TicketCloud)+'|vf='+Numero+'|IDC='+$('con').title+'|usu='+$('usu').title,this);

    new Ajax.Request('animalitos/L!p¡-.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
    //new Ajax.Request('animalitos/grabar_animalitos.php',{ parameters: {Jugada:Object.toJSON(TicketCloud),IDC:$('con').title,usu:$('usu').title},method:'post',asynchronous:false,	onComplete: function(transport){
                var response = transport.responseText.evalJSON(true) ;

								if (response[0]){
									//vretur=remm(dbna(response[1]) )
                  //_formatclickDUK();
                  if (Numero=='-1'){
                    $("printer").innerHTML=remm(response[1]);
                    $('printer').style.display='';
                    print();
                  }else{
                    clave=response[1];
                    if (clave!=='0')
											nalert('VER FACIL','La Clave del Telefono '+Numero+' es:('+clave+') ');
										else
											nalert('VER FACIL',' Ticket Enviado a VERFACIL ');	
                  }
                  TicketCloud=new Array();
                  ArrSort=new Array();
                  lCloud=0;
                  $('nrsumt').innerHTML='0';
                  mygrid3.clearAll();

                  if (response[2].size()!=0) _PublicErrorDUK(response[2],response[3]);
                  else if (response[3].size()!=0) _PublicErrorDUK(response[2],response[3]);

								}else{
											respuesta=response[2].split('-');
											nalert(respuesta[0],respuesta[1]);
                      if (response[1]=='1') mygrid2.clearAll();
								      }
                },
              onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
               });
  }
    barDUK.enableItem("Imprimir_");
    $('ImpNumero').disable="";
    $('ImpMonto').disable="";
}
function _PublicErrorDUK(lista1,lista2){
  dhxWins3Err = new dhtmlXWindows();
  dhxWins3Err.setImagePath("codebase/imgs/");
	w1err = dhxWins3Err.createWindow("w1err",10, 80, 400, 300);
	w1err.setText('Observaciones en la impresion del ticket!');
	dhxWins3Err.window("w1err").button('close').hide();
	dhxWins3Err.window("w1err").button('minmax1').hide();
	dhxWins3Err.window("w1err").button('minmax2').hide();
	dhxWins3Err.window("w1err").button('park').hide();
	dhxWins3Err.window("w1err").denyResize();
	dhxWins3Err.window("w1err").centerOnScreen();
  barerr = w1err.attachToolbar();
	barerr.addButton("Cerrar_", 1, "Cerrar", "animalitos/icons/noun_1042920_cc.png", "animalitos/icons/noun_1042920_cc.png");
	barerr.attachEvent("onClick", function(id){
    switch(id){
      case "Cerrar_":
            dhxWins3Err.window("w1err").close();
            break;
          }
  });

  mygrid2Err = w1err.attachGrid();
	mygrid2Err.setImagePath("codebase/imgs/");
	mygrid2Err.setHeader("Motivo,Observaciones");
	mygrid2Err.setInitWidths("100,1000")
	mygrid2Err.setColAlign("left,left")
	mygrid2Err.setColTypes("ro,ro");
	mygrid2Err.setSkin("dhx_skyblue");
	mygrid2Err.init();
  filaa=0;
  i=0;
  solo_sorteos=new Array();
  for (x=0;x<=lista1.size()-1;x++){
    ubi=solo_sorteos.indexOf(lista1[x].sorteo);
    if (ubi==-1){ solo_sorteos[i]=lista1[x].sorteo; i++;}
  }
    for (x=0;x<=solo_sorteos.size()-1;x++){//lCloudSorteos
      //mygrid2Err.addRow(filaa,'Sorteo Cerrado:,No se imprimio el '+mygrid2.cells(solo_sorteos[x], 1).getValue());
      tex1=lCloudSorteos[solo_sorteos[x]][0];
      for (key in Rl1) {
          if ( lCloudSorteos[solo_sorteos[x]][1] == Rl1[key] )
             fIDL=key;
      }
      tex2=Rl2[fIDL];
      mygrid2Err.addRow(filaa,'Sorteo Cerrado:,No se imprimio el '+tex1+' de '+tex2);
			filaa++;
  }
  mygrid2.clearAll();
  _utxprm=bna('filephp=sorteos.php|usu='+$('usu').title+'|IDL='+iIDL,this);
  mygrid2.loadXML("animalitos/L!p¡-.php?uid="+_utxprm);

  for (x=0;x<=lista2.size()-1;x++)
  {


      mygrid2Err.addRow(filaa,'Limite de Venta:,'+lista2[x][1]);
      filaa++;

  }

}
function _formatclickDUK(dticket){
  txtmsj="Desea Imprimir el ticket?";
  $("printer").innerHTML=dticket;
  $('printer').style.display='';
  desci=confirm(txtmsj);
  if (desci){
      print();
      alert('Impresion','Ticket Impreso....');
    }
  TicketCloud=new Array();
  ArrSort=new Array();
  lCloud=0;
  $('nrsumt').innerHTML='0';
  mygrid3.clearAll();

}
function _chek_sorteoDUK(sorteoCheck,obj){
  _utxprm=bna('filephp=sorteo-1.php|iSord='+sorteoCheck+'|usu='+$('usu').title,this);
  new Ajax.Request('animalitos/L!p¡-.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
  //new Ajax.Request('animalitos/sorteo-1.php',{ parameters: {iSord:sorteoCheck,usu:$('usu').title},method:'post',asynchronous:false,	onComplete: function(transport){
              var response = transport.responseText.evalJSON(true) ;
                if (response.size()!=0){
                    if (response[0]==false){
                      clearLayout('C')
                      alert('Disculpe no hay sorteos habilitados');
                    }else{
                      deleteRowLayout('C',sorteoCheck)
                      alert('Disculpe este sorteo ya no esta habilitado');
                    }
                }else{
                  console.log(obj,response)
                  obj.classList.add('active')
                }
              },
            onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
             });

}
function ByViewDUK(serial,TU)
	{

      _utxprm=bna('filephp=vertk.php|serial='+serial+'|TU='+TU,this);
      new Ajax.Request('animalitos/L!p¡-.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
      //new Ajax.Request('animalitos/grabar_animalitos.php',{ parameters: {Jugada:Object.toJSON(TicketCloud),IDC:$('con').title,usu:$('usu').title},method:'post',asynchronous:false,	onComplete: function(transport){
                  var response = transport.responseText ;
                   $('printer3').innerHTML=response;

                  },onCreate: function(){
  									$('printer3').innerHTML  = '<img src="media/ajax-loader.gif" />';
  								},
                onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
                 });
	}
function Anular_ticket(serial){
  if (confirm('Esta SEGURO DE ANULAR EL TICKET '+serial+'?')){
  _utxprm=bna('filephp=Anultk.php|serial='+serial+'|usu='+$('usu').title,this);
  new Ajax.Request('animalitos/L!p¡-.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
  //new Ajax.Request('animalitos/grabar_animalitos.php',{ parameters: {Jugada:Object.toJSON(TicketCloud),IDC:$('con').title,usu:$('usu').title},method:'post',asynchronous:false,	onComplete: function(transport){
              var response = transport.responseText.evalJSON(true) ;

              if ( response[0] ){
                  mygridV1.deleteSelectedRows();
                  nalert('ANUALDO','Ticket Anulado!');
              }else{
                respuesta=response[2].split('-');
                nalert(respuesta[0],respuesta[1]);
              }

              },
            onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
             });
      }

}

function ReimprimirTK(serial,TU){
  _utxprm=bna('filephp=ImprTK.php|serial='+serial+'|TU='+TU,this);
  new Ajax.Request('animalitos/L!p¡-.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
  //new Ajax.Request('animalitos/grabar_animalitos.php',{ parameters: {Jugada:Object.toJSON(TicketCloud),IDC:$('con').title,usu:$('usu').title},method:'post',asynchronous:false,	onComplete: function(transport){
              var response = transport.responseText.evalJSON(true)  ;

              if (response[0])
                _formatclickDUK(response[1]);
              else
                alert(response[1])



              },
            onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
             });



}
function _valida1(IDC,ipIDL){
  _utxprm=bna('filephp=venta_animalitos-1.php|op=1|IDC='+IDC+'|IDL='+ipIDL,this);
  new Ajax.Request('animalitos/L!p¡-.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
  //new Ajax.Request('animalitos/grabar_animalitos.php',{ parameters: {Jugada:Object.toJSON(TicketCloud),IDC:$('con').title,usu:$('usu').title},method:'post',asynchronous:false,	onComplete: function(transport){
              var response = transport.responseText.evalJSON(true)  ;
              if (response[0]){
                minv=response[1];
                maxv=response[2];
                toplt=response[3];
                TOPE=response[4];
              }else{
                alert(response[2]);
                dhxWins3.window("w1").close();
              }
              },
            onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
             });
}
function refresMonitor(){
	funcionInac = window.setInterval("inicialbbDUK()", 6000);
}

function inicialbbDUK(){

  _utxprm=bna('filephp=Ani_Monitor-1-2.php|IDJ='+idjDUK+'|IDS='+idsDUK,this);
  new Ajax.Request('animalitos/_.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
  //new Ajax.Request('animalitos/grabar_animalitos.php',{ parameters: {Jugada:Object.toJSON(TicketCloud),IDC:$('con').title,usu:$('usu').title},method:'post',asynchronous:false,	onComplete: function(transport){
              var response = transport.responseText.evalJSON(true)  ;

              xMov=response[idsDUK];

              for (key in xMov) {
                  numero=key;
                  monto=xMov[key].monto;
                  tk=xMov[key].tk;
                  pr=xMov[key].porce;
                  if (numero=='Total'){
                    fila=mygridMM[nivel].getRowsNum();
                    c=2;c2=6;
                  }else{
                    fila=Math.round(numero/2);
                    if ((numero%2)==0) c=7; else c=2;
                    c2=c+1;c3=c+2;
                  }
                  valor = mygridMM[nivel].cells2(fila-1,c).getValue();
                  v1=valor.gsub(/\*+/,'');
                  //add=''
                  //console.info(v1)
                  //console.info(valor)
                  if (v1!=monto && numero!='Total' ) add='*'; else add='';
                  mygridMM[nivel].cells2(fila-1,c).setValue(add+monto+add);
                  mygridMM[nivel].cells2(fila-1,c2).setValue(tk);
                  if (numero!='Total') mygridMM[nivel].cells2(fila-1,c3).setValue(pr);

              }


              },
            onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
             });
}
function openClas(url,lop,nombreventana, pantallacompleta, herramientas, direcciones, estado, barramenu, barrascroll, cambiatamano, ancho, alto, izquierda, arriba, sustituir){
  	_utxprm=bna('filephp='+url+'|'+lop+'|usu='+$('usu').title,this);
		url= "animalitos/L!p¡-.php?uid="+_utxprm;
		opciones = "fullscreen=" + pantallacompleta +
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
		var ventana = window.open(url,nombreventana,opciones,sustituir);

}
function _grabarLotte(){
 var response;
   if ($('activo').checked) iActivo=1; else iActivo=0;
   iCode='';
   iCode=$('Code').value;

  _utxprm=bna('filephp=Ani_Loteria-3.php|IDL='+$('IDL').lang+'|Nombre='+$('Nombre').value+'|Activa='+iActivo+'|logo='+iFile+'|AutoSorteo='+$('AutoSorteo').value+'|Code='+iCode,this);
  new Ajax.Request('animalitos/_.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
               response = transport.responseText.evalJSON(true) ;
                if (response)
                  alert('Informacion Grabada')
                else {
                  alert('Houston: Tenemos un problema al grabar la informacion!')
                }
              },
            onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
             });

  return response;

}
function isset(Object1) {return ($(Object1)!=null); }
