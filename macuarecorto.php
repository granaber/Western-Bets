

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
.Estilo10 {font-family: Arial, Helvetica, sans-serif; font-size: 16px; color: #FFFFFF; font-weight: bold; }
.Estilo12 {font-family: "Times New Roman", Times, serif; font-size: 16px; color: #FFFFFF; font-weight: bold; }
-->
      </style>
      <script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<form id="form1" name="form1" method="post" action="">
<div align="left">
        <table width="590" border="1" bgcolor="#996666">
          <tr bgcolor="#93726D">
            <th colspan="19" scope="col"><div align="left"><span class="Estilo2">MACUARE CORTO </span></div></th>
          </tr>
          <tr bgcolor="#CCCCFF">
            <th colspan="17" bgcolor="#93726D" scope="col"><div align="left"><span class="Estilo10">N.Ticket: 0000000000</span></div></th>
            <th bgcolor="#93726D" scope="col"><div align="center"><span class="Estilo12">X</span></div></th>
            <th bgcolor="#93726D" scope="col"><div align="center"><span class="Estilo10">FUNCIONES</span></div></th>
          </tr>
          <tr>
            <th width="144" rowspan="6" bgcolor="#93726D" scope="col"><p class="Estilo4">Puesto:</p>
                <label>
                <input type="text" name="valida" id="valida" onkeyup = "pulsar(event,1)" />
                </label>
                <p class="Estilo4">Ejemplar:</p>
              <label>
                <input type="text" name="ejem" id="ejem" onkeyup = "pulsar(event,2)"  />
            </label></th>
            <th width="17" scope="col" bgcolor="#93726D">1.-</th>
            <th width="6" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th id="celda11"  bgcolor="#26354A" width="12"><span class="Estilo1">1</span></th>
            <th id="celda12" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">2</span></th>
            <th id="celda13" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">3</span></th>
            <th id="celda14" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">4</span></th>
            <th id="celda15" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">5</span></th>
            <th id="celda16" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">6</span></th>
            <th id="celda17" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">7</span></th>
            <th id="celda18" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">8</span></th>
            <th id="celda19" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">9</span></th>
            <th id="celda110" width="19" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">10</span></th>
            <th id="celda111" width="17" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">11</span></th>
            <th id="celda112" width="18" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">12</span></th>
            <th id="celda113" width="23" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">13</span></th>
            <th id="celda114" width="19" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">14</span></th>
            <th width="30" bgcolor="#FFFFFF" scope="col"> <input name="v1" type="text" id="v1" size="3" /></th>
            <th width="103" bgcolor="#93726D" scope="col"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="100" height="22">
              <param name="movie" value="button1.swf" />
              <param name="quality" value="high" />
              <embed src="button1.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100" height="22"></embed>
            </object></th>
          </tr>
          <tr>
            <th width="17" scope="col" bgcolor="#93726D">2.-</th>
            <th width="6" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th id="celda21" bgcolor="#26354A" width="12"><span class="Estilo1">1</span></th>
            <th id="celda22" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">2</span></th>
            <th id="celda23" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">3</span></th>
            <th id="celda24" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">4</span></th>
            <th id="celda25" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">5</span></th>
            <th id="celda26" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">6</span></th>
            <th id="celda27" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">7</span></th>
            <th id="celda28" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">8</span></th>
            <th id="celda29" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">9</span></th>
            <th id="celda210" width="19" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">10</span></th>
            <th id="celda211" width="17" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">11</span></th>
            <th id="celda212" width="18" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">12</span></th>
            <th id="celda213" width="23" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">13</span></th>
            <th id="celda214" width="19" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">14</span></th>
            <th width="30" bgcolor="#FFFFFF" scope="col"><input name="v2" type="text" id="v2" size="3" /></th>
            <th width="103" bgcolor="#93726D" scope="col">&nbsp;</th>
          </tr>
          <tr>
            <th width="17" scope="col" bgcolor="#93726D">3.-</th>
            <th width="6" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th id="celda31" bgcolor="#26354A" width="12"><span class="Estilo1">1</span></th>
            <th id="celda32" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">2</span></th>
            <th id="celda33" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">3</span></th>
            <th id="celda34" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">4</span></th>
            <th id="celda35" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">5</span></th>
            <th id="celda36" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">6</span></th>
            <th id="celda37" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">7</span></th>
            <th id="celda38" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">8</span></th>
            <th id="celda39" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">9</span></th>
            <th id="celda310" width="19" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">10</span></th>
            <th id="celda311" width="17" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">11</span></th>
            <th id="celda312" width="18" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">12</span></th>
            <th id="celda313" width="23" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">13</span></th>
            <th id="celda314" width="19" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">14</span></th>
            <th width="30" bgcolor="#FFFFFF" scope="col"><input name="v3" type="text" id="v3" size="3" /></th>
            <th width="103" bgcolor="#93726D" scope="col"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="100" height="22">
              <param name="movie" value="button2.swf" />
              <param name="quality" value="high" />
              <embed src="button2.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100" height="22"></embed>
            </object></th>
          </tr>
          <tr>
            <th width="17" scope="col" bgcolor="#93726D">4.-</th>
            <th width="6" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th id="celda41" bgcolor="#26354A" width="12"><span class="Estilo1">1</span></th>
            <th id="celda42" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">2</span></th>
            <th id="celda43" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">3</span></th>
            <th id="celda44" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">4</span></th>
            <th id="celda45" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">5</span></th>
            <th id="celda46" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">6</span></th>
            <th id="celda47" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">7</span></th>
            <th id="celda48" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">8</span></th>
            <th id="celda49" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">9</span></th>
            <th id="celda410" width="19" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">10</span></th>
            <th id="celda411" width="17" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">11</span></th>
            <th id="celda412" width="18" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">12</span></th>
            <th id="celda413" width="23" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">13</span></th>
            <th id="celda414" width="19" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">14</span></th>
            <th width="30" bgcolor="#FFFFFF" scope="col"><input name="v4" type="text" id="v4" size="3" /></th>
            <th width="103" bgcolor="#93726D" scope="col">&nbsp;</th>
          </tr>
          <tr>
            <th width="17" scope="col" bgcolor="#93726D">5.-</th>
            <th width="6" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th id="celda51" bgcolor="#26354A" width="12"><span class="Estilo1">1</span></th>
            <th id="celda52" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">2</span></th>
            <th id="celda53" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">3</span></th>
            <th id="celda54" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">4</span></th>
            <th id="celda55" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">5</span></th>
            <th id="celda56" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">6</span></th>
            <th id="celda57" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">7</span></th>
            <th id="celda58" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">8</span></th>
            <th id="celda59" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">9</span></th>
            <th id="celda510" width="19" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">10</span></th>
            <th id="celda511" width="17" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">11</span></th>
            <th id="celda512" width="18" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">12</span></th>
            <th id="celda513" width="23" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">13</span></th>
            <th id="celda514" width="19" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">14</span></th>
            <th width="30" bgcolor="#FFFFFF" scope="col"><input name="v5" type="text" id="v5" size="3" /></th>
            <th width="103" bgcolor="#93726D" scope="col"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="100" height="22">
              <param name="movie" value="button3.swf" />
              <param name="quality" value="high" />
              <embed src="button3.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100" height="22"></embed>
            </object></th>
          </tr>
          <tr>
            <th width="17"  bgcolor="#93726D" scope="col">6.-</th>
            <th width="6" bgcolor="#FFFFFF" scope="col">&nbsp;</th>
            <th id="celda61" bgcolor="#26354A" width="12"><span class="Estilo1">1</span></th>
            <th id="celda62" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">2</span></th>
            <th id="celda63" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">3</span></th>
            <th id="celda64" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">4</span></th>
            <th id="celda65" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">5</span></th>
            <th id="celda66" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">6</span></th>
            <th id="celda67" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">7</span></th>
            <th id="celda68" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">8</span></th>
            <th id="celda69" width="13" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">9</span></th>
            <th id="celda610" width="19" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">10</span></th>
            <th id="celda611" width="17" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">11</span></th>
            <th id="celda612" width="18" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">12</span></th>
            <th id="celda613" width="23" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">13</span></th>
            <th id="celda614" width="19" scope="col" bgcolor="#26354A" bordercolor="#000000"><span class="Estilo1">14</span></th>
            <th width="30" bgcolor="#FFFFFF" scope="col"><input name="v6" type="text" id="v6" size="3" /></th>
            <th width="103" bgcolor="#93726D" scope="col">&nbsp;</th>
          </tr>
          <tr bgcolor="#93726D">
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