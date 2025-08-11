

<script language="javascript">

function calcular(g)
{
 k=0;
 valor="celda"+g;

 for (var i = 1; i < 14; i++)
  {
    
	celda= document.getElementById(valor+i);
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
function pulsar(e,i) {
  tecla = document.all ? e.keyCode : e.which;

  if(tecla==13) {
   	  if(i==2) {
	   if (document.form1.ejem.value!='') {
	   switch(document.form1.valida.value)
          {
           case "1":
		    celda= document.getElementById('celda1'+document.form1.ejem.value);
			break;
		   case "2":
		    celda= document.getElementById('celda2'+document.form1.ejem.value);
			break;
		   case "3":
		    celda= document.getElementById('celda3'+document.form1.ejem.value);
			break;
		   case "4":
		    celda= document.getElementById('celda4'+document.form1.ejem.value);
			break;
		   case "5":
		    celda= document.getElementById('celda5'+document.form1.ejem.value);
			break;
		   case "6":
		    celda= document.getElementById('celda6'+document.form1.ejem.value);
			break;	
	      }
		   
          if (celda.style.backgroundColor=='rgb(102, 255, 51)') 
		  {
		  celda.style.backgroundColor="#26354A";
		  }
		  else
		  {
		  celda.style.backgroundColor="#66ff33";
		  }
		  
	      calcular(document.form1.valida.value);
		  document.form1.ejem.value='';
		  document.form1.ejem.focus();
	      document.form1.ejem.select();
		 
		  }
		  else
		  {
		
		   document.form1.valida.value=parseInt(document.form1.valida.value)+1;
		   if (document.form1.valida.value=='7')
		     {
			  document.form1.valida.value="";
			  document.form1.valida.focus();
	          document.form1.valida.select();
			 }
			 else
			 {
		      document.form1.valida.focus();
	          document.form1.valida.select();
			 }
			 
		  }
	  }
  }
  
   if(i==1) {
	  document.form1.ejem.focus();
	  document.form1.ejem.select();
		  }
}

</script>
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>
      <link href="../mm_training.css" rel="stylesheet" type="text/css" />
      <style type="text/css">
<!--
.Estilo2 {
	font-size: 36px;
	font-weight: bold;
}
.Estilo4 {font-size: 18px}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo17 {font-family: Arial, Helvetica, sans-serif; font-size: 16px; color: #FFFFFF; font-weight: bold; }
.Estilo19 {font-family: "Times New Roman", Times, serif; font-size: 16px; color: #000000; font-weight: bold; }
-->
      </style>
      <script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<form id="form1" name="form1" method="post" action="">
<div align="left">
        <table width="700" border="1" bgcolor="#99CC66">
          <tr bgcolor="#9BB867">
            <th colspan="19" scope="col"><span class="Estilo2">MACUARE </span></th>
          </tr>
          <tr bgcolor="#9BB867">
            <th colspan="17" scope="col"><div align="left"><span class="Estilo17">N.Ticket: 0000000000</span></div></th>
            <th scope="col"><div align="center"><span class="Estilo19">X</span></div></th>
            <th scope="col"><div align="center"><span class="Estilo17">FUNCIONES</span></div></th>
          </tr>
          <tr>
            <th width="147" rowspan="6" bgcolor="#9BB867" scope="col"><p class="Estilo4">Puesto:</p>
                <label>
                <input type="text" name="valida" id="valida" onkeyup = "pulsar(event,1)" />
                </label>
                <p class="Estilo4">
                  <label></label>
            </p>            </th>
            <th width="51" align="center" valign="middle" bgcolor="#9BB867" scope="col"> 1.-</th>
            <th width="7" align="center" valign="middle" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th width="14" align="center" valign="middle"  bgcolor="#26354A" id="celda11"><span class="Estilo1"> 1</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda12" scope="col"><span class="Estilo1">2 </span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda13" scope="col"><span class="Estilo1">3</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda14" scope="col"><span class="Estilo1">4</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda15" scope="col"><span class="Estilo1">5</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda16" scope="col"><span class="Estilo1">6</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda17" scope="col"><span class="Estilo1">7</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda18" scope="col"><span class="Estilo1">8</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda19" scope="col"><span class="Estilo1">9</span></th>
            <th width="22" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda110" scope="col"><span class="Estilo1">10</span></th>
            <th width="20" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda111" scope="col"><span class="Estilo1">11</span></th>
            <th width="21" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda112" scope="col"><span class="Estilo1">12</span></th>
            <th width="27" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda113" scope="col"><span class="Estilo1">13</span></th>
            <th width="22" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda114" scope="col"><span class="Estilo1">14</span></th>
            <th width="35" align="center" valign="middle" bgcolor="#FFFFFF" scope="col"> <input name="v1" type="text" id="v1" size="3" /></th>
            <th width="136" rowspan="4" align="center" bgcolor="#9BB867" scope="col"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="100" height="22">
              <param name="movie" value="button1.swf" />
              <param name="quality" value="high" />
              <embed src="button1.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100" height="22"></embed>
            </object></th>
          </tr>
          <tr>
            <th width="51" align="center" bgcolor="#9BB867" scope="col">2.-</th>
            <th width="7" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th width="14" bgcolor="#26354A" id="celda21"><span class="Estilo1">1</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda22" scope="col"><span class="Estilo1">2</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda23" scope="col"><span class="Estilo1">3</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda24" scope="col"><span class="Estilo1">4</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda25" scope="col"><span class="Estilo1">5</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda26" scope="col"><span class="Estilo1">6</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda27" scope="col"><span class="Estilo1">7</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda28" scope="col"><span class="Estilo1">8</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda29" scope="col"><span class="Estilo1">9</span></th>
            <th width="22" bordercolor="#000000" bgcolor="#26354A" id="celda210" scope="col"><span class="Estilo1">10</span></th>
            <th width="20" bordercolor="#000000" bgcolor="#26354A" id="celda211" scope="col"><span class="Estilo1">11</span></th>
            <th width="21" bordercolor="#000000" bgcolor="#26354A" id="celda212" scope="col"><span class="Estilo1">12</span></th>
            <th width="27" bordercolor="#000000" bgcolor="#26354A" id="celda213" scope="col"><span class="Estilo1">13</span></th>
            <th width="22" bordercolor="#000000" bgcolor="#26354A" id="celda214" scope="col"><span class="Estilo1">14</span></th>
            <th width="35" bgcolor="#FFFFFF" scope="col"><input name="v2" type="text" id="v2" size="3" /></th>
          </tr>
          <tr>
            <th width="51" align="center" bgcolor="#9BB867" scope="col">3.-</th>
            <th width="7" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th width="14" bgcolor="#26354A" id="celda31"><span class="Estilo1">1</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda32" scope="col"><span class="Estilo1">2</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda33" scope="col"><span class="Estilo1">3</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda34" scope="col"><span class="Estilo1">4</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda35" scope="col"><span class="Estilo1">5</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda36" scope="col"><span class="Estilo1">6</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda37" scope="col"><span class="Estilo1">7</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda38" scope="col"><span class="Estilo1">8</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda39" scope="col"><span class="Estilo1">9</span></th>
            <th width="22" bordercolor="#000000" bgcolor="#26354A" id="celda310" scope="col"><span class="Estilo1">10</span></th>
            <th width="20" bordercolor="#000000" bgcolor="#26354A" id="celda311" scope="col"><span class="Estilo1">11</span></th>
            <th width="21" bordercolor="#000000" bgcolor="#26354A" id="celda312" scope="col"><span class="Estilo1">12</span></th>
            <th width="27" bordercolor="#000000" bgcolor="#26354A" id="celda313" scope="col"><span class="Estilo1">13</span></th>
            <th width="22" bordercolor="#000000" bgcolor="#26354A" id="celda314" scope="col"><span class="Estilo1">14</span></th>
            <th width="35" bgcolor="#FFFFFF" scope="col"><input name="v3" type="text" id="v3" size="3" /></th>
          </tr>
          <tr>
            <th width="51" align="center" valign="middle" bgcolor="#9BB867" scope="col">4.-</th>
            <th width="7" align="center" valign="middle" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th width="14" align="center" valign="middle" bgcolor="#26354A" id="celda41"><span class="Estilo1">1</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda42" scope="col"><span class="Estilo1">2</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda43" scope="col"><span class="Estilo1">3</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda44" scope="col"><span class="Estilo1">4</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda45" scope="col"><span class="Estilo1">5</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda46" scope="col"><span class="Estilo1">6</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda47" scope="col"><span class="Estilo1">7</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda48" scope="col"><span class="Estilo1">8</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda49" scope="col"><span class="Estilo1">9</span></th>
            <th width="22" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda410" scope="col"><span class="Estilo1">10</span></th>
            <th width="20" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda411" scope="col"><span class="Estilo1">11</span></th>
            <th width="21" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda412" scope="col"><span class="Estilo1">12</span></th>
            <th width="27" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda413" scope="col"><span class="Estilo1">13</span></th>
            <th width="22" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda414" scope="col"><span class="Estilo1">14</span></th>
            <th width="35" align="center" valign="middle" bgcolor="#FFFFFF" scope="col"><input name="v4" type="text" id="v4" size="3" /></th>
          </tr>
          <tr>
            <th width="51" align="center" bgcolor="#9BB867" scope="col">5.-</th>
            <th width="7" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th width="14" bgcolor="#26354A" id="celda51"><span class="Estilo1">1</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda52" scope="col"><span class="Estilo1">2</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda53" scope="col"><span class="Estilo1">3</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda54" scope="col"><span class="Estilo1">4</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda55" scope="col"><span class="Estilo1">5</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda56" scope="col"><span class="Estilo1">6</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda57" scope="col"><span class="Estilo1">7</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda58" scope="col"><span class="Estilo1">8</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda59" scope="col"><span class="Estilo1">9</span></th>
            <th width="22" bordercolor="#000000" bgcolor="#26354A" id="celda510" scope="col"><span class="Estilo1">10</span></th>
            <th width="20" bordercolor="#000000" bgcolor="#26354A" id="celda511" scope="col"><span class="Estilo1">11</span></th>
            <th width="21" bordercolor="#000000" bgcolor="#26354A" id="celda512" scope="col"><span class="Estilo1">12</span></th>
            <th width="27" bordercolor="#000000" bgcolor="#26354A" id="celda513" scope="col"><span class="Estilo1">13</span></th>
            <th width="22" bordercolor="#000000" bgcolor="#26354A" id="celda514" scope="col"><span class="Estilo1">14</span></th>
            <th width="35" bgcolor="#FFFFFF" scope="col"><input name="v5" type="text" id="v5" size="3" /></th>
            <th width="136" rowspan="4" align="center" bgcolor="#9BB867" scope="col"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="100" height="22">
              <param name="movie" value="button2.swf" />
              <param name="quality" value="high" />
              <embed src="button2.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100" height="22"></embed>
            </object></th>
          </tr>
          <tr>
            <th width="51" align="center"  bgcolor="#9BB867" scope="col">6.-</th>
            <th width="7" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th width="14" bgcolor="#26354A" id="celda61"><span class="Estilo1">1</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda62" scope="col"><span class="Estilo1">2</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda63" scope="col"><span class="Estilo1">3</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda64" scope="col"><span class="Estilo1">4</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda65" scope="col"><span class="Estilo1">5</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda66" scope="col"><span class="Estilo1">6</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda67" scope="col"><span class="Estilo1">7</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda68" scope="col"><span class="Estilo1">8</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda69" scope="col"><span class="Estilo1">9</span></th>
            <th width="22" bordercolor="#000000" bgcolor="#26354A" id="celda610" scope="col"><span class="Estilo1">10</span></th>
            <th width="20" bordercolor="#000000" bgcolor="#26354A" id="celda611" scope="col"><span class="Estilo1">11</span></th>
            <th width="21" bordercolor="#000000" bgcolor="#26354A" id="celda612" scope="col"><span class="Estilo1">12</span></th>
            <th width="27" bordercolor="#000000" bgcolor="#26354A" id="celda613" scope="col"><span class="Estilo1">13</span></th>
            <th width="22" bordercolor="#000000" bgcolor="#26354A" id="celda614" scope="col"><span class="Estilo1">14</span></th>
            <th width="35" bgcolor="#FFFFFF" scope="col"><input name="v6" type="text" id="v6" size="3" /></th>
          </tr>
          <tr>
            <th width="147" rowspan="6" bgcolor="#9BB867" scope="col"><p class="Estilo4">Ejemplar:</p>
              <label>
              <input type="text" name="ejem" id="ejem" onkeyup = "pulsar(event,2)">
            </label></th>
            <th align="left" valign="middle"  bgcolor="#9BB867" scope="col"><div align="center">7.-</div></th>
            <th width="7" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th width="14" align="center" valign="middle" bgcolor="#26354A" id="celda61"><span class="Estilo1">1</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda62" scope="col"><span class="Estilo1">2</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda63" scope="col"><span class="Estilo1">3</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda64" scope="col"><span class="Estilo1">4</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda65" scope="col"><span class="Estilo1">5</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda66" scope="col"><span class="Estilo1">6</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda67" scope="col"><span class="Estilo1">7</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda68" scope="col"><span class="Estilo1">8</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda69" scope="col"><span class="Estilo1">9</span></th>
            <th width="22" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda610" scope="col"><span class="Estilo1">10</span></th>
            <th width="20" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda611" scope="col"><span class="Estilo1">11</span></th>
            <th width="21" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda612" scope="col"><span class="Estilo1">12</span></th>
            <th width="27" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda613" scope="col"><span class="Estilo1">13</span></th>
            <th width="22" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda614" scope="col"><span class="Estilo1">14</span></th>
            <th width="35" align="center" valign="middle" bgcolor="#FFFFFF" scope="col"><input name="v62" type="text" id="v62" size="3" /></th>
          </tr>
          <tr>
            <th align="left" valign="middle"  bgcolor="#9BB867" scope="col"><div align="center">8.-</div></th>
            <th width="7" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th width="14" align="center" valign="middle" bgcolor="#26354A" id="celda61"><span class="Estilo1">1</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda62" scope="col"><span class="Estilo1">2</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda63" scope="col"><span class="Estilo1">3</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda64" scope="col"><span class="Estilo1">4</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda65" scope="col"><span class="Estilo1">5</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda66" scope="col"><span class="Estilo1">6</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda67" scope="col"><span class="Estilo1">7</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda68" scope="col"><span class="Estilo1">8</span></th>
            <th width="15" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda69" scope="col"><span class="Estilo1">9</span></th>
            <th width="22" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda610" scope="col"><span class="Estilo1">10</span></th>
            <th width="20" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda611" scope="col"><span class="Estilo1">11</span></th>
            <th width="21" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda612" scope="col"><span class="Estilo1">12</span></th>
            <th width="27" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda613" scope="col"><span class="Estilo1">13</span></th>
            <th width="22" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda614" scope="col"><span class="Estilo1">14</span></th>
            <th width="35" align="center" valign="middle" bgcolor="#FFFFFF" scope="col"><input name="v63" type="text" id="v63" size="3" /></th>
          </tr>
          <tr>
            <th align="left"  bgcolor="#9BB867" scope="col"><div align="center">9.-</div></th>
            <th width="7" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th width="14" bgcolor="#26354A" id="celda61"><span class="Estilo1">1</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda62" scope="col"><span class="Estilo1">2</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda63" scope="col"><span class="Estilo1">3</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda64" scope="col"><span class="Estilo1">4</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda65" scope="col"><span class="Estilo1">5</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda66" scope="col"><span class="Estilo1">6</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda67" scope="col"><span class="Estilo1">7</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda68" scope="col"><span class="Estilo1">8</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda69" scope="col"><span class="Estilo1">9</span></th>
            <th width="22" bordercolor="#000000" bgcolor="#26354A" id="celda610" scope="col"><span class="Estilo1">10</span></th>
            <th width="20" bordercolor="#000000" bgcolor="#26354A" id="celda611" scope="col"><span class="Estilo1">11</span></th>
            <th width="21" bordercolor="#000000" bgcolor="#26354A" id="celda612" scope="col"><span class="Estilo1">12</span></th>
            <th width="27" bordercolor="#000000" bgcolor="#26354A" id="celda613" scope="col"><span class="Estilo1">13</span></th>
            <th width="22" bordercolor="#000000" bgcolor="#26354A" id="celda614" scope="col"><span class="Estilo1">14</span></th>
            <th width="35" bgcolor="#FFFFFF" scope="col"><input name="v64" type="text" id="v64" size="3" /></th>
            <th width="136" rowspan="4" align="center" bgcolor="#9BB867" scope="col"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="100" height="22" align="middle">
              <param name="movie" value="button3.swf" />
              <param name="quality" value="high" />
              <embed src="button3.swf" width="100" height="22" align="middle" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
            </object></th>
          </tr>
          <tr>
            <th align="left"  bgcolor="#9BB867" scope="col"><div align="center">10.-</div></th>
            <th width="7" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th width="14" bgcolor="#26354A" id="celda61"><span class="Estilo1">1</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda62" scope="col"><span class="Estilo1">2</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda63" scope="col"><span class="Estilo1">3</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda64" scope="col"><span class="Estilo1">4</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda65" scope="col"><span class="Estilo1">5</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda66" scope="col"><span class="Estilo1">6</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda67" scope="col"><span class="Estilo1">7</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda68" scope="col"><span class="Estilo1">8</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda69" scope="col"><span class="Estilo1">9</span></th>
            <th width="22" bordercolor="#000000" bgcolor="#26354A" id="celda610" scope="col"><span class="Estilo1">10</span></th>
            <th width="20" bordercolor="#000000" bgcolor="#26354A" id="celda611" scope="col"><span class="Estilo1">11</span></th>
            <th width="21" bordercolor="#000000" bgcolor="#26354A" id="celda612" scope="col"><span class="Estilo1">12</span></th>
            <th width="27" bordercolor="#000000" bgcolor="#26354A" id="celda613" scope="col"><span class="Estilo1">13</span></th>
            <th width="22" bordercolor="#000000" bgcolor="#26354A" id="celda614" scope="col"><span class="Estilo1">14</span></th>
            <th width="35" bgcolor="#FFFFFF" scope="col"><input name="v65" type="text" id="v65" size="3" /></th>
          </tr>
          <tr>
            <th align="left"  bgcolor="#9BB867" scope="col"><div align="center">11.-</div></th>
            <th width="7" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th width="14" bgcolor="#26354A" id="celda61"><span class="Estilo1">1</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda62" scope="col"><span class="Estilo1">2</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda63" scope="col"><span class="Estilo1">3</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda64" scope="col"><span class="Estilo1">4</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda65" scope="col"><span class="Estilo1">5</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda66" scope="col"><span class="Estilo1">6</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda67" scope="col"><span class="Estilo1">7</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda68" scope="col"><span class="Estilo1">8</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda69" scope="col"><span class="Estilo1">9</span></th>
            <th width="22" bordercolor="#000000" bgcolor="#26354A" id="celda610" scope="col"><span class="Estilo1">10</span></th>
            <th width="20" bordercolor="#000000" bgcolor="#26354A" id="celda611" scope="col"><span class="Estilo1">11</span></th>
            <th width="21" bordercolor="#000000" bgcolor="#26354A" id="celda612" scope="col"><span class="Estilo1">12</span></th>
            <th width="27" bordercolor="#000000" bgcolor="#26354A" id="celda613" scope="col"><span class="Estilo1">13</span></th>
            <th width="22" bordercolor="#000000" bgcolor="#26354A" id="celda614" scope="col"><span class="Estilo1">14</span></th>
            <th width="35" bgcolor="#FFFFFF" scope="col"><input name="v652" type="text" id="v652" size="3" /></th>
          </tr>
          <tr>
            <th align="left"  bgcolor="#9BB867" scope="col"><div align="center">12.-</div></th>
            <th width="7" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th width="14" bgcolor="#26354A" id="celda61"><span class="Estilo1">1</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda62" scope="col"><span class="Estilo1">2</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda63" scope="col"><span class="Estilo1">3</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda64" scope="col"><span class="Estilo1">4</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda65" scope="col"><span class="Estilo1">5</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda66" scope="col"><span class="Estilo1">6</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda67" scope="col"><span class="Estilo1">7</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda68" scope="col"><span class="Estilo1">8</span></th>
            <th width="15" bordercolor="#000000" bgcolor="#26354A" id="celda69" scope="col"><span class="Estilo1">9</span></th>
            <th width="22" bordercolor="#000000" bgcolor="#26354A" id="celda610" scope="col"><span class="Estilo1">10</span></th>
            <th width="20" bordercolor="#000000" bgcolor="#26354A" id="celda611" scope="col"><span class="Estilo1">11</span></th>
            <th width="21" bordercolor="#000000" bgcolor="#26354A" id="celda612" scope="col"><span class="Estilo1">12</span></th>
            <th width="27" bordercolor="#000000" bgcolor="#26354A" id="celda613" scope="col"><span class="Estilo1">13</span></th>
            <th width="22" bordercolor="#000000" bgcolor="#26354A" id="celda614" scope="col"><span class="Estilo1">14</span></th>
            <th width="35" bgcolor="#FFFFFF" scope="col"><input name="v653" type="text" id="v653" size="3" /></th>
          </tr>
          <tr bgcolor="#9BB867">
            <th scope="row"><label></label></th>
            <th colspan="17" scope="row"><label> </label>
                <div align="right"><span class="Estilo4">Total Bs.F.</span>
                  <input type="text" name="Total" id="Total" />
            </div></th>
            <td>&nbsp;</td>
          </tr>
  </table> 
  </div>
</form> 
