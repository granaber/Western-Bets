<div id="verLt"><div id="myForm3AS"></div></div>
<script>
var newId1 =1;
var mygrid2NL;
var mygrid3NL;
var carga3AS=true;
// Habilitacion del layout de DHTMLX para 4 Casillas en Ventana
dhtmlXLayoutObject.prototype.tplData["4C"] = '<layout><autosize hor="b;c;d" ver="a;d" rows="3" cols="2"/><table data="a,b;a,c;a,d"/><row><cell obj="a" wh="2,1" resize="hor" neighbors="a;b,c,d" rowspan="5"/><cell sep="ver" left="a" right="b,c,d" dblclick="a" rowspan="5"/><cell obj="b" wh="2,3" resize="ver" neighbors="b;c;d"/></row><row sep="yes"><cell sep="hor" top="b" bottom="c;d" dblclick="b"/></row><row><cell obj="c" wh="2,3" resize="ver" neighbors="b;c;d"/></row><row sep="yes"><cell sep="hor" top="b;c" bottom="d" dblclick="c"/></row><row><cell obj="d" wh="2,3" resize="ver" neighbors="b;c;d"/></row></layout>';dhtmlXLayoutObject.prototype._availAutoSize["4C_hor"] = new Array("a", "b;c;d");dhtmlXLayoutObject.prototype._availAutoSize["4C_ver"] = new Array("a;b", "a;c", "a;d");

// Funciones de la Barra Principal de la Ventana
// Donde se Crean nuevas loterias
function clicktoolBar(id){
 switch(id){
		case "Cerrar_":
				dhxWins3LTO.window("w1LTO").close();
				break;
		case "Nuevo_":
			  IDL=0;
			  dhxLayout.cells("b").setText('( Loteria NUEVO )');
				_utxprm=bna('filephp=Ani_Loteria-2.php|IDL=0',this);
				new Ajax.Request('animalitos/_.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
										var response = transport.responseText ;
										dhxLayout.cells("b").attachHTMLString(response);
										response.evalScripts();
										},
									onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
									 });
					mygrid2NL.clearAll();
					mygrid3NL.clearAll();

				break;

 }
 }

// Funcion al Dar Click al tree de las loterias creadas o una loteria Nueva
 function tonclick(id){
 	 vernivel=id.split('$');
 	 switch (vernivel[0]){
 		case '1':
		// Datos de Loteria
			$Nivel='G';
 			IDL=vernivel[1];dhxLayout.cells("b").setText('( Loteria '+IDL+' '+tree.getItemText(id)+' )');
			_utxprm=bna('filephp=Ani_Loteria-2.php|IDL='+IDL,this);
			new Ajax.Request('animalitos/_.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
									var response = transport.responseText ;
									dhxLayout.cells("b").attachHTMLString(response);response.evalScripts();
									},
								onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								 });
 		 // Sorteos
			_utxprm=bna('filephp=Ani_Loteria-4.php|IDL='+IDL,this);
			mygrid2NL.clearAll();
 		  mygrid2NL.loadXML("animalitos/L!p¡-.php?uid="+_utxprm);

		 // Animalitos
		 _utxprm=bna('filephp=Ani_Loteria-5.php|IDL='+IDL,this);
		 mygrid3NL.clearAll();
		 mygrid3NL.loadXML("animalitos/L!p¡-.php?uid="+_utxprm);

 		break;
 	 }
  }
// Funcionaes de la Barra de loterias Nuevas o existenate Layout A
	function clickBar1DUK(id){
		switch(id){
			case "grabar_":
					 _grabarLotte();
					 tree.deleteChildItems(0);
					 tree.loadXML("animalitos/Ani_Loteria-1.php");
						break;
			case "Eliminar_":
						break;

		}
	}
// Funciones del Asistente del Layout C donde se crean o modifican los sorteos de las loterias
	function clicktoolBarAS1(id){
		switch(id){
			case "Cerrar_":
				dhxWins3AS.window("w1AS").close();
			break;
			case "Aplicar_": // El proceso del asistente donde crea los sorteos indicando desde que hora y hasta con el lapso entre ellas
				desde=myForm3AS.getInput("HH").value;hasta=myForm3AS.getInput("HF").value;lapso=parseInt(myForm3AS.getInput("LP").value);
				adesde=desde.split(':');ndesde=adesde.size();
				ahasta=hasta.split(':');nhasta=ahasta.size();
				if ( !(ndesde>=2 && ndesde<=3) ){ alert('El Valor de la Hora Desde no es valido!'); myForm3AS.setItemValue("HH", ''); return false; }
				if ( !(nhasta>=2 && nhasta<=3) ){ alert('El Valor de la Hora Hasta no es valido!'); myForm3AS.setItemValue("HF", ''); return false; }
				Nh=new Array();
				HI=parseInt(adesde[0]);MI=parseInt(adesde[1]);
				HF=parseInt(ahasta[0]);MF=parseInt(ahasta[1]);
				i=0;
				Nh[i]=desde+':00';
				i++;
				for(;;){
					Nm=MI+lapso;
					if (Nm>=60){
						HI=HI+1;
						MI=Nm-60;
					}else{
						MI=Nm;
					}
				 	if (HI<10) iHI='0'+HI; else iHI=HI;
					if (MI<10) iMI='0'+MI; else iMI=MI;
					Nh[i]=iHI+':'+iMI+':00';
					if (HI>=HF && MI>=MF)
						break;
					i++;
				}

        LCloud=new Array();
        lCloud=0;
				for (i=0;i<=Nh.size()-1;i++){
					newId1=mygrid2NL.getRowsNum()+1;
					mygrid2NL.addRow(newId1,newId1+','+Nh[i]+','+_ConvetirPmAm(Nh[i])+',1');
          lineaOBJ={ln:newId1,Hora:Nh[i],Descripcion:_ConvetirPmAm(Nh[i]),Activo:1}
          LCloud[lCloud]=lineaOBJ;
          lCloud++
				}
        tIDL=$('IDL').lang;
        var response;
        _utxprm=bna('filephp=Ani_Loteria-6.php|op=3|IDL='+tIDL+'|Datos='+Object.toJSON(LCloud),this);
        new Ajax.Request('animalitos/_.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
                   response = transport.responseText.evalJSON(true) ;
                   },
                 onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
                  });
         if (!response){
           mygrid2NL.clearAll();
           alert('Houston: Tenemos un problema al grabar la informacion!');
         }
        dhxWins3AS.window("w1AS").close();
			break;

		}
	}

  //Funciones del Asistente del Layout d donde se crean los animalitos de las loterias
  function clicktoolBarAS2(id){
    switch(id){
      case "Cerrar_":
        dhxWins4AS.window("w2AS").close();
        break;
      case "Aplicar_": // Asistente de los animalitos se precrrean los animalitos estandar, incluyen las imagenes
        var AniStr=['Arana' ,'Carnero' ,'Toro' ,'Ciempies' ,'Alacran' ,'Leon' , 'Sapo' ,'Loro' ,'Raton' ,'Aguila' ,'Tigre' ,'Gato' ,'Caballo' ,'Mono' ,'Paloma' ,'Zorro' ,'Oso' ,'Pavo' ,'Burro' ,'Cabra' ,'Puerco' ,'Gallo' ,'Camello' ,'Cebra' ,'Iguana' ,'Gallina' ,'Vaca' ,'Perro' ,'Zamuro' ,'Elefante' ,'Caiman' ,'Lapa' ,'Ardilla' ,'Pescado' ,'Venado' ,'Jirafa' ,'Culebra' ,'Mariposa' ,'Conejo'];
        var FAniStr=['0.jpg' ,'1.png' ,'2.png' ,'3.png' ,'4.png' ,'5.png' ,'6.png' ,'7.png' ,'8.png' ,'9.png' ,'10.png' ,'11.png' ,'12.png' ,'13.png' ,'14.png' ,'15.png' ,'16.png' ,'17.png' ,'18.png' ,'19.png' ,'20.png' ,'21.png' ,'22.png' ,'23.png' ,'24.png' ,'25.png' ,'26.png' ,'27.png' ,'28.png' ,'29.png' ,'30.png' ,'31.png' ,'32.png' ,'33.png' ,'34.png' ,'35.png' ,'36.png' ,'37.png' ,'38.png' ];
        desde=parseInt(myForm3AS.getInput("NI").value);hasta=parseInt(myForm3AS.getInput("NF").value);

        if ( !(Number.isInteger(desde)) ){ alert('El Valor del numero no es valido!'); myForm3AS.setItemValue("NI", ''); return false; }
        if ( !(Number.isInteger(hasta)) ){ alert('El Valor del numero no es valido!'); myForm3AS.setItemValue("NF", ''); return false; }
        Nh=new Array();
        i=0;
        if (desde<10) Nh[i]='0'+desde; else Nh[i]=desde;
        i++;
        for(;;){
          desde++;
          if (desde<10) Nh[i]='0'+desde; else Nh[i]=desde;
          if (desde==hasta)
            break;
          i++;
        }
        LCloud=new Array();lCloud=0;
        for (i=0;i<=Nh.size()-1;i++){
          newId2=mygrid3NL.getRowsNum()+1;
          NuKm=parseInt(Nh[i]);
          Img="<img src='animalitos/imag/"+FAniStr[ NuKm ]+"' />";
          mygrid3NL.addRow(newId2,Nh[i]+','+AniStr[ NuKm ]+','+Img+',1');
          lineaOBJ={ln:Nh[i],Numero:Nh[i],Descripcion:AniStr[ parseInt(Nh[i]) ],Figura:FAniStr[ NuKm ],Hab:1}
          LCloud[lCloud]=lineaOBJ;
          lCloud++;
        }
       tIDL=$('IDL').lang;
        var response;
        _utxprm=bna('filephp=Ani_Loteria-6.php|op=7|IDL='+tIDL+'|Datos='+Object.toJSON(LCloud),this);
        new Ajax.Request('animalitos/_.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
                   response = transport.responseText.evalJSON(true) ;
                   },
                 onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
                  });
         if (!response){
           mygrid3NL.clearAll();
           alert('Houston: Tenemos un problema al grabar la informacion!');
         }
        dhxWins4AS.window("w2AS").close();
        break;
    }
  }
  // Convirte el hora Militar a hora AM&PM
	function _ConvetirPmAm(wH){
		iHora=wH.split(':');
		iHora[0]=parseInt(iHora[0]);
		if ( iHora[0]==12 ) {kH=iHora[0]; np='PM'; }else{
					if ( iHora[0]>12 ){
								kH=iHora[0]-12;
								if ( kH<10 ) kH='0'+kH
								np='PM';
					  	} else {
							 	if ( iHora[0]<10) kH='0'+iHora[0];
								else kH=iHora[0];
								 np='AM';
						 }
		}
		return ( kH+':'+iHora[1]+' '+np)
	}

 // Opciones del Layout de Sorteos de las Loterias
	function clickBar2DUK(id){
		switch(id){
			case "Asistente_":
      if (isset('IDL') ){
            if ( $('IDL').lang==0 ){
                alert('Debe Crear la nueva loteria para activar la opcion!')
                break;
            }
						////////////////////////////
						dhxWins3AS = new dhtmlXWindows();
						dhxWins3AS.setImagePath("codebase/imgs/");
						w1AS = dhxWins3AS.createWindow("w1AS",100, 100, 350, 200);
						w1AS.setText('Asistente de Horario de Sorteos');
						dhxWins3AS.window("w1AS").button('close').hide();
						dhxWins3AS.window("w1AS").button('minmax1').hide();
						dhxWins3AS.window("w1AS").button('minmax2').hide();
						dhxWins3AS.window("w1AS").button('park').hide();
						dhxWins3AS.window("w1AS").denyResize();
						dhxWins3AS.window("w1AS").centerOnScreen();
						barDUKAS = w1AS.attachToolbar();
						barDUKAS.addButton("Cerrar_", 1, "Cerrar",  "animalitos/icons/noun_1042920_cc.png", "animalitos/icons/noun_1042920_cc.png");
						barDUKAS.addButton("Aplicar_", 1, "Crear Sorteos",  "animalitos/icons/noun_993058_cc.png", "animalitos/icons/noun_993058_cc.png");
						barDUKAS.addSeparator("separator_", 2);
						barDUKAS.attachEvent("onClick", clicktoolBarAS1);
						$('verLt').innerHTML='<div id="myForm3AS"></div>';
						formData3AS = [
							{type: "fieldset", label: "Asistente", inputWidth: 320, list:[
															{type:"input", name: 'HH', label:'Hora Desde(HH:MM):', numberFormat: ["00:00:00"]},
															{type:"input", name:"HF", label:"Hora Hasta(HH:MM):"},
															{type:"input", name:"LP", label:"Lapso(MIN):",numberFormat: "00"}
															]}
											]
						myForm3AS = new dhtmlXForm("myForm3AS", formData3AS);
						w1AS.attachObject('myForm3AS');
						//////////////////////////////

          }else {alert('Debe Crear la nueva loteria para activar la opcion!')}
						break;
			case "Add_":
					  newId1=mygrid2NL.getRowsNum()+1;
 					  mygrid2NL.addRow(newId1,newId1+',,,');

						break;
			case "Eliminar_":
					selectedId = mygrid2NL.getSelectedRowId();
					Hora=mygrid2NL.cells(selectedId, 1).getValue()
					tIDL=$('IDL').lang;
					if (tIDL!=0){
						var response=false;
						_utxprm=bna('filephp=Ani_Loteria-6.php|op=2|IDL='+tIDL+'|Hora='+Hora,this);
						new Ajax.Request('animalitos/_.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
											 response = transport.responseText.evalJSON(true) ;
											 },
										 onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
											});
						if (response)	mygrid2NL.deleteSelectedRows();
					}else{
						alert('Houston: Tenemos un problema porque este registro es nuevo!');
					}
						break;

		}

	}
  // Funciona para almacenar la imagenes de los iconos de los animalitos
  function _GrabarIMG(_imgane,Numero){
    tIDL=$('IDL').lang;
    var response=false;
    _utxprm=bna('filephp=Ani_Loteria-6.php|op=8|IDL='+tIDL+'|Numero='+Numero+'|Figura='+_imgane,this);
    new Ajax.Request('animalitos/_.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
               response = transport.responseText.evalJSON(true) ;
               },
             onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
              });
    return  response
  }
  /// Funciones de la ventana de asistente de los iconos de los animalitos
	function clickBar3DUK(id){
		switch(id){
      case "Icono_":
      	  var selectedId = mygrid3NL.getSelectedRowId();
          if (selectedId!=null){
            dhxWins4AS = new dhtmlXWindows();
            dhxWins4AS.setImagePath("codebase/imgs/");
            w2AS = dhxWins4AS.createWindow("w2AS",300, 500, 350, 200);
            w2AS.setText('Iconos de Animalitos');
            dhxWins4AS.window("w2AS").button('close').hide();
            dhxWins4AS.window("w2AS").button('minmax1').hide();
            dhxWins4AS.window("w2AS").button('minmax2').hide();
            dhxWins4AS.window("w2AS").button('park').hide();
            dhxWins4AS.window("w2AS").denyResize();
            dhxWins4AS.window("w2AS").centerOnScreen();
            barDUK3AS = w2AS.attachToolbar();
            barDUK3AS.addButton("Cerrar_", 1, "Cerrar",  "animalitos/icons/noun_1042920_cc.png", "animalitos/icons/noun_1042920_cc.png");
                barDUK3AS.addSeparator("separator_", 2);
            barDUK3AS.attachEvent("onClick", function(id){
                  dhxWins4AS.window("w2AS").close();
            });

            barDUK3AS.attachEvent("onClick", clicktoolBarAS2);
            $('verLt').innerHTML='<div id="myForm3AS"></div>';
            formData3AS = [{
                  type: "fieldset",
                  label: "Logo",
                  list: [{
                      type: "upload",
                      name: "myFiles",
                      inputWidth: 330,
                      autoRemove:true,
                      url: "animalitos/dhtmlxform_item_upload_icons.php",
                      _swfLogs: "enabled",
                      autoStart: true,
                      swfPath: "../codebase/ext/uploader.swf",
                      swfUrl: "animalitos/dhtmlxform_item_upload_icons.php"
                  }]
                  }];
            myForm3AS = new dhtmlXForm("myForm3AS", formData3AS);
            myForm3AS.attachEvent("onUploadFile", function(realName, serverName) {

                if (   _GrabarIMG(realName,selectedId)  )
                 mygrid3NL.cells(selectedId, 2).setValue("<img src='animalitos/imag/"+realName+"' />")
                else
                 alert('Houston: Tenemos un problema al grabar la informacion de la imagen!');

                 dhxWins4AS.window("w2AS").close();
            })
            myForm3AS.attachEvent("onUploadFail", function(realName) {
               alert('Este tipo de archivos NO SON VALIDOS');
               dhxWins4AS.window("w2AS").close();
            })
            w2AS.attachObject('myForm3AS');
            //////////////////////////////
        }else
          alert('Debe seleccionar el Animalito a modificar!')
      break;
      case "Asistente_":
      if (isset('IDL') ){
            if ( $('IDL').lang==0 ){
                alert('Debe Crear la nueva loteria para activar la opcion!')
                break;
            }
						////////////////////////////
						dhxWins4AS = new dhtmlXWindows();
						dhxWins4AS.setImagePath("codebase/imgs/");
						w2AS = dhxWins4AS.createWindow("w2AS",100, 100, 350, 200);
						w2AS.setText('Asistente de Animalitos para Sorteos');
						dhxWins4AS.window("w2AS").button('close').hide();
						dhxWins4AS.window("w2AS").button('minmax1').hide();
						dhxWins4AS.window("w2AS").button('minmax2').hide();
						dhxWins4AS.window("w2AS").button('park').hide();
						dhxWins4AS.window("w2AS").denyResize();
						dhxWins4AS.window("w2AS").centerOnScreen();
						barDUK3AS = w2AS.attachToolbar();
						barDUK3AS.addButton("Cerrar_", 1, "Cerrar",  "animalitos/icons/noun_1042920_cc.png", "animalitos/icons/noun_1042920_cc.png");
						barDUK3AS.addButton("Aplicar_", 1, "Crear Animalitos",  "animalitos/icons/noun_993058_cc.png", "animalitos/icons/noun_993058_cc.png");
						barDUK3AS.addSeparator("separator_", 2);
						barDUK3AS.attachEvent("onClick", clicktoolBarAS2);
						$('verLt').innerHTML='<div id="myForm3AS"></div>';
						formData3AS = [
							{type: "fieldset", label: "Asistente", inputWidth: 320, list:[
															{type:"input", name: 'NI', label:'Numero Desde(N):'},
															{type:"input", name:"NF", label:"Numero Hasta(H):"}
															]}
											]
						myForm3AS = new dhtmlXForm("myForm3AS", formData3AS);

						w2AS.attachObject('myForm3AS');
						//////////////////////////////

          }else {alert('Debe Crear la nueva loteria para activar la opcion!')}
						break;
			case "Add_":
					  newId2=mygrid3NL.getRowsNum()+1;
 					  mygrid3NL.addRow(newId2,newId2+',,,1');

						break;
			case "Eliminar_":
						mygrid3NL.deleteSelectedRows();
						break;

		}

	}


	dhxWins3LTO = new dhtmlXWindows();
  dhxWins3LTO.setImagePath("codebase/imgs/");
	w1LTO = dhxWins3LTO.createWindow("w1LTO",100, 100, 850, 850);
	w1LTO.setText('Loterias de Animalitos');
//	w1LTO.attachObject('fromCarr');
	dhxWins3LTO.window("w1LTO").button('close').hide();
	dhxWins3LTO.window("w1LTO").button('minmax1').hide();
	dhxWins3LTO.window("w1LTO").button('minmax2').hide();
	dhxWins3LTO.window("w1LTO").button('park').hide();
	dhxWins3LTO.window("w1LTO").denyResize();
	dhxWins3LTO.window("w1LTO").centerOnScreen();

	barDUK = w1LTO.attachToolbar();
	barDUK.addButton("Cerrar_", 1, "Cerrar",  "animalitos/icons/noun_1042920_cc.png", "animalitos/icons/noun_1042920_cc.png");
	barDUK.addButton("Nuevo_", 1, "Nueva Loteria",  "animalitos/icons/noun_993058_cc.png", "animalitos/icons/noun_993058_cc.png");

	barDUK.addSeparator("separator_", 2);

	barDUK.attachEvent("onClick", clicktoolBar);

  var dhxLayout = w1LTO.attachLayout("4c");
	dhxLayout.cells("a").setText("Loterias");//dhxLayout.cells("a").setHeight(400);
	//dhxLayout.cells("a").fixSize(true,true);
	dhxLayout.cells("b").setText("Datos");dhxLayout.cells("b").setHeight(260);//dhxLayout.cells("b").setWidth(300);
	//dhxLayout.cells("b").fixSize(true,true);
	dhxLayout.cells("c").setText("Sorteo");
	dhxLayout.cells("d").setText("Animalitos");


	var tree = dhxLayout.cells("a").attachTree();
	tree.setImagePath("animalitos/icons/csh_vista/");
	tree.enableDragAndDrop(1,0);
	tree.setOnClickHandler(tonclick);
	tree.loadXML("animalitos/Ani_Loteria-1.php");

// Datos de las loterias
	myToolbar1 = dhxLayout.cells("b").attachToolbar();
	myToolbar1.addButton("grabar_", 1, "Grabar",  "animalitos/icons/noun_976547_cc.png", "animalitos/icons/noun_976547_cc.png");
	//myToolbar1.addButton("Eliminar_", 2, "Eliminar",  "animalitos/icons/noun_1071627_cc.png", "animalitos/icons/noun_1071627_cc.png");
//  myToolbar1.setSkin("dhx_blue");
	myToolbar1.attachEvent("onClick", clickBar1DUK);

// Datos del Sorteo
	myToolbar2 = dhxLayout.cells("c").attachToolbar();
	myToolbar2.addButton("Asistente_", 1, "Asistente",  "animalitos/icons/noun_689017_cc.png", "animalitos/icons/noun_689017_cc.png");
	myToolbar2.addButton("Add_", 2, "Adicionar Linea",  "animalitos/icons/noun_534845_cc.png", "animalitos/icons/noun_534845_cc.png");
	myToolbar2.addButton("Eliminar_", 3, "Eliminar Linea",  "animalitos/icons/noun_161524_cc.png", "animalitos/icons/noun_161524_cc.png");
	//myToolbar2.setSkin("dhx_blue");
	myToolbar2.attachEvent("onClick", clickBar2DUK);

	mygrid2NL = dhxLayout.cells("c").attachGrid();
  mygrid2NL.setImagePath("codebase/imgs/");
  mygrid2NL.setHeader("N,Hora Cierre,Descripcion,Hab");
  mygrid2NL.setInitWidths("30,100,170,40")
  mygrid2NL.setColAlign("right,right,center,right")
	mygrid2NL.setStyle("", "font-size:12px","", "");
  mygrid2NL.setColTypes("ro,ed,ed,ch");
  mygrid2NL.enableStableSorting(true);
  mygrid2NL.init();
	mygrid2NL.attachEvent("onEditCell", function(stage,rId,cInd,nValue,oValue){
   if (stage==2){
		 tIDL=$('IDL').lang;
		 Hora=mygrid2NL.cells(rId, 1).getValue()
		 descripcion=mygrid2NL.cells(rId, 2).getValue()
		 activo=mygrid2NL.cells(rId, 3).getValue()
		 var response=false;

		 _utxprm=bna('filephp=Ani_Loteria-6.php|op=0|IDL='+tIDL+'|Hora='+Hora+'|Descripcion='+descripcion+'|Activo='+activo,this);
		 new Ajax.Request('animalitos/_.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
		 						response = transport.responseText.evalJSON(true) ;
		 						},
		 					onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		 					 });


			if (response){
		 		return true;
			}else{
				alert('Houston: Tenemos un problema al grabar la informacion!');
				return false;
			}
	 }
	 if (stage==0 && cInd==3) {
      tIDL=$('IDL').lang;
			activo=mygrid2NL.cells(rId, 3).getValue()
			Hora=mygrid2NL.cells(rId, 1).getValue()
			var response=false;
			if (activo==0) activo=1; else activo=0;
			_utxprm=bna('filephp=Ani_Loteria-6.php|op=1|Activo='+activo+'|Hora='+Hora+'|IDL='+tIDL,this);
			new Ajax.Request('animalitos/_.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
								 response = transport.responseText.evalJSON(true) ;
								 },
							 onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
			 return true;

	 }

});

// Datos del Animalitos
	myToolbar3 = dhxLayout.cells("d").attachToolbar();
	myToolbar3.addButton("Asistente_", 1, "Asistente",  "animalitos/icons/noun_689017_cc.png", "animalitos/icons/noun_689017_cc.png");
	myToolbar3.addButton("Add_", 2, "Adicionar Linea",  "animalitos/icons/noun_534845_cc.png", "animalitos/icons/noun_534845_cc.png");
	myToolbar3.addButton("Eliminar_", 3, "Eliminar Linea",  "animalitos/icons/noun_161524_cc.png", "animalitos/icons/noun_161524_cc.png");
  myToolbar3.addButton("Icono_", 3, "Imagen",  "animalitos/icons/noun_974591_cc.png", "animalitos/icons/noun_974591_cc.png");

	//myToolbar2.setSkin("dhx_blue");
	myToolbar3.attachEvent("onClick", clickBar3DUK);

	mygrid3NL = dhxLayout.cells("d").attachGrid();
	mygrid3NL.setImagePath("codebase/imgs/");
	mygrid3NL.setHeader("Numero,Descripcion,Figura,Hab");
	mygrid3NL.setInitWidths("80,170,100,40")
	mygrid3NL.setColAlign("right,right,center,right")
	mygrid3NL.setStyle("", "font-size:12px","", "");
	mygrid3NL.setColTypes("ed,ed,ro,ch");
	mygrid3NL.enableStableSorting(true);
	mygrid3NL.init();

  mygrid3NL.attachEvent("onEditCell", function(stage,rId,cInd,nValue,oValue){
   if (stage==2){
		 tIDL=$('IDL').lang;
		 Numero=mygrid3NL.cells(rId, 0).getValue()
		 Descripcion=mygrid3NL.cells(rId, 1).getValue()
     Figura=mygrid3NL.cells(rId, 2).getValue()
		 Hab=mygrid3NL.cells(rId, 3).getValue()
		 var response=false;

		 _utxprm=bna('filephp=Ani_Loteria-6.php|op=4|IDL='+tIDL+'|Numero='+Numero+'|Descripcion='+Descripcion+'|Figura='+Figura+'|Hab='+Hab,this);
		 new Ajax.Request('animalitos/_.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
		 						response = transport.responseText.evalJSON(true) ;
		 						},
		 					onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
		 					 });


			if (response){
		 		return true;
			}else{
				alert('Houston: Tenemos un problema al grabar la informacion!');
				return false;
			}
	 }
	 if (stage==0 && cInd==3) {
      tIDL=$('IDL').lang;
			Hab=mygrid3NL.cells(rId, 3).getValue()
			Numero=mygrid3NL.cells(rId, 0).getValue()
			var response=false;
			if (Hab==0) activo=1; else activo=0;
			_utxprm=bna('filephp=Ani_Loteria-6.php|op=5|Activo='+activo+'|Numero='+Numero+'|IDL='+tIDL,this);
			new Ajax.Request('animalitos/_.php',{ parameters: { uid: _utxprm },method:'post',asynchronous:false,	onComplete: function(transport){
								 response = transport.responseText.evalJSON(true) ;
								 },
							 onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								});
			 return true;

	 }

});

</script>
