// xPopup r1, Copyright 2002-2007 Michael Foster (Cross-Browser.com)
// Part of X, a Cross-Browser Javascript Library, Distributed under the terms of the GNU LGPL

function xPopup(sTmrType, uTimeout, sPos1, sPos2, sPos3, sStyle, sId, sUrl)
{
  if (document.getElementById && document.createElement &&
      document.body && document.body.appendChild)
  { // create popup element
    //var e = document.createElement('DIV');
    var e = document.createElement('IFRAME');
    this.ele = e;
    e.id = sId;
    e.style.position = 'absolute';
    e.className = sStyle;
    //e.innerHTML = sHtml;
    e.src = sUrl;
    document.body.appendChild(e);
    e.style.visibility = 'visible';
    this.tmr = xTimer.set(sTmrType, this, sTmrType, uTimeout);
    // init
	this.title='';
    this.open = false;
    this.margin = 10;
    this.pos1 = sPos1;
    this.pos2 = sPos2;
    this.pos3 = sPos3;
    this.slideTime = 500; // slide time in ms
	this.interval();
  } 
} // end xPopup
// methods
xPopup.prototype.show = function()
{
  this.interval();
};
xPopup.prototype.hide = function()
{
  this.timeout();
};
// timer event listeners
xPopup.prototype.timeout = function() // hide popup
{
  if (this.open) {
    var e = this.ele;
    var pos = xCardinalPosition(e, this.pos3, this.margin, true);
    xSlideTo(e, pos.x, pos.y, this.slideTime);
    setTimeout("xGetElementById('" + e.id + "').style.visibility='hidden'", this.slideTime);
    this.open = false;	
  }

};
xPopup.prototype.interval = function() // size, position and show popup
{
  if (!this.open) {
    var e = this.ele;
    var pos = xCardinalPosition(e, this.pos1, this.margin, true);
    xMoveTo(e, pos.x, pos.y);
    e.style.visibility = 'visible';
    pos = xCardinalPosition(e, this.pos2, this.margin, false);
    xSlideTo(e, pos.x, pos.y, this.slideTime);
    this.open = true;	

  } 

};
xPopup.prototype.acced = function(v,v1) 
{
  if (this.open) {     
  
         oXmlHttp  = new XMLHttpRequest();		
		 var element =  document.getElementById("tablemenu");
		 getuser=getCookie('rndusr');
         oXmlHttp.open('GET','logon.php?op=1&usu='+v+'&pwd='+v1+'&ck='+getuser,true); 
	     v3='';
		 oXmlHttp.onreadystatechange = function() {
			  var arrInfo = oXmlHttp.responseText.split("||");	
			 // alert (arrInfo);
                      if (!eval(arrInfo[0])) {
						   	  document.getElementById("con").style.display="";
                              document.getElementById("fch").style.display="none";
	                          document.getElementById("jnd").style.display="none";
	                          document.getElementById("usu").style.display="none";
	                          document.getElementById("est").style.display="none";
							  if (arrInfo[1]=='1') {
							    document.getElementById("con").innerHTML ='Usuario Bloqueado';
							  }
							  else{
							    document.getElementById("con").innerHTML ='El Usuario No Existe o Clave Errada';
							  }
							  //alert ('El Usuario No Existe');
					  } else {
						 //************************************************************************************////
						document.getElementById("con").style.display="";
					
						switch (arrInfo[1]){
							case '-2':						
						        document.getElementById("con").innerHTML ='Nivel:Administrador';oko=1;break;
							case '-1':
							    document.getElementById("con").innerHTML ='Nivel:Usuario';oko=0;break;
							case '-4':	 
							    document.getElementById("con").innerHTML ='Nivel:Informacion';oko=0;break;
						    case '-5':	 
							    document.getElementById("con").innerHTML ='Nivel:Sistema';oko=0;break;	
							default:					  		
						  		document.getElementById("con").innerHTML ='Concesionario:'+arrInfo[1];oko=0;break;
						}
						
						 document.getElementById("con").title=arrInfo[1];
						 document.getElementById("fch").style.display="";
						 document.getElementById("fch").innerHTML ='Fecha:'+arrInfo[4];
						 document.getElementById("fch").title=arrInfo[4];
						 document.getElementById("jnd").style.display="";
						 document.getElementById("jnd").innerHTML ='Jornada:'+arrInfo[5];
						 document.getElementById("jnd").title=arrInfo[5];
						 document.getElementById("usu").style.display="";
						 document.getElementById("usu").innerHTML ='Usuario:'+v;
						 document.getElementById("usu").title=arrInfo[7];
						 document.getElementById("est").style.display="";
						 document.getElementById("est").innerHTML ='Estacion:'+arrInfo[2];
						 document.getElementById("est").title=arrInfo[2];
						 //document.getElementById("btn").style.display="none";
						 //document.getElementById("btn2").style.display="";
						 //************************************************************************************////
					     setCookie('rndusr', arrInfo[6]);
						 document.getElementById("logo").lang=arrInfo[8];
						 
					     http_request = new XMLHttpRequest();
						 http_request2 = new XMLHttpRequest();    
						 
		                 var element =  document.getElementById("topmenu");
						 var element2 =  document.getElementById("menu1");
											 
						 
						 document.getElementById("p").bgColor="#000000";
						 document.getElementById("fd1").bgColor="#D3DCE6";
						 document.getElementById("fd2").bgColor="#FFFFFF";
						 
						 document.getElementById("topmenu2").style.display="none";
		                 document.getElementById("tablemenu2").style.display="none";
						 document.getElementById("tablemenu").style.display="";
						 document.getElementById("menu2").style.display="none";
						 document.getElementById("menu3").style.display="none";
						 document.getElementById("box_g").style.display="none"; 
						 document.getElementById("news").style.display="";

						 new Ajax.Request('topmenu.php?op='+oko+'&op2='+arrInfo[9],{
   		 					method:'get',	onSuccess: function(transport){
    						var response = transport.responseText;	
							element.innerHTML=response;
 		   					},
  		  					onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
							});       
												 
                        
						  var cmv2=arrInfo[9].split("|");
						 var cmv=cmv2[1].split("-");
						
	                     var iv=1;
						 for (i=0;i<=cmv.length;i++)
						 {
							 if (parseInt(cmv[i])!=0)
							 {
				
								 iv=parseInt(cmv[i]);break;
							 }
						 }
				         
						 switch(iv)
						 {
							 case 1:
							 	new Ajax.Request('menujugada.php?op=2&cng='+arrInfo[8],{
   		 						method:'get',	onSuccess: function(transport){
    							var response = transport.responseText;	
								element2.innerHTML=response;
 		   						},
  		  						onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								}); 
						
							 	break;
							 case 2:
							   new Ajax.Request('menujugada.php?op=2&cng='+arrInfo[8],{
   		 						method:'get',	onSuccess: function(transport){
    							var response = transport.responseText;	
								element2.innerHTML=response;
 		   						},
  		  						onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
								}); 
							 	break;
							 case 3:
							    makeRequestmn('topmenubb.php');
							 	break;								
								
						 }
				    	 
				
					  }//if
                }
				oXmlHttp.send(null);
				
				
				this.hide();
				mensajesactualiza(1);
		        //popcargar(); 
  }//open
};
xPopup.prototype.cargarconfig = function(v) // size, position and show popup
{
	

  
  if (this.open) {
      var arrInfo = v.split("|");
	//document.getElementById("b1").style.backgroundColor="#00CC00";
	//alert(document.this.getElementById("b1") );
	
	for (i=1;i<=arrInfo.length;i++)
	{
		document.getElementById(v[i]).style.display="none";
	}
	
	this.hide();

  } 

};