

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
.Estilo10 {font-family: Arial, Helvetica, sans-serif; font-size: 16px; color: #000000; }
.Estilo12 {font-family: "Times New Roman", Times, serif; font-size: 16px; color: #000000; }
.Estilo13 {font-family: "Times New Roman", Times, serif}
.Estilo24 {font-family: "Times New Roman", Times, serif; font-size: 24; }
.Estilo25 {font-size: 24}
.Estilo30 {font-size: 16px}
.Estilo31 {font-size: 16px; color: #FFFFFF; }
.Estilo35 {font-family: Arial, Helvetica, sans-serif; font-size: 16px; }
-->
      </style>
      <script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<form id="form1" name="form1" method="post" action="">
<div align="left">
        <table width="590" border="1" bgcolor="#99CCFF">
          <tr bgcolor="#99CCFF">
            <th colspan="19" scope="col"><div align="left"><span class="Estilo2">POOL DE CUATRO  </span></div></th>
          </tr>
          <tr bgcolor="#99CCFF">
            <th colspan="17" scope="col"><div align="left"><span class="Estilo10">N.Ticket: 0000000000</span></div></th>
            <th scope="col"><div align="center"><span class="Estilo12">X</span></div></th>
            <th scope="col"><div align="center"><span class="Estilo10">FUNCIONES</span></div></th>
          </tr>
          <tr>
            <th width="144" bgcolor="#99CCFF" scope="col">
              <span class="Estilo35">Tanda:</span>
              <span class="Estilo35">
              <input type="text" name="textfield" />
              </span></th>
            <th width="17" scope="col" bgcolor="#99CCFF"><span class="Estilo24">1.-</span></th>
            <th width="6" bgcolor="#FFFFFF" scope="col"><span class="Estilo25"></span></th>
            <th width="12" align="center" valign="middle"  bgcolor="#26354A" id="celda11"><div align="center"><span class="Estilo1 Estilo13 Estilo30">1</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda12" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">2</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda13" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">3</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda14" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">4</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda15" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">5</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda16" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">6</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda17" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">7</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda18" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">8</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda19" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">9</span></div></th>
            <th width="19" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda110" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">10</span></div></th>
            <th width="17" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda111" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">11</span></div></th>
            <th width="18" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda112" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">12</span></div></th>
            <th width="23" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda113" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">13</span></div></th>
            <th width="19" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda114" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">14</span></div></th>
            <th width="30" bgcolor="#FFFFFF" scope="col"> <input name="v1" type="text" id="v1" size="3" /></th>
            <th width="103" bgcolor="#99CCFF" scope="col"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="100" height="22">
              <param name="movie" value="button1.swf" />
              <param name="quality" value="high" />
              <embed src="button1.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100" height="22"></embed>
            </object></th>
          </tr>
          <tr>
            <th width="144" bgcolor="#99CCFF" scope="col"><span class="Estilo35">Valida:</span>
              <span class="Estilo35">
              <input type="text" name="textfield2" />
            </span></th>
            <th width="17" height="43" bgcolor="#99CCFF" scope="col"><span class="Estilo24">2.-</span></th>
            <th width="6" bgcolor="#FFFFFF" scope="col"><span class="Estilo25"></span></th>
            <th width="12" align="center" valign="middle" bgcolor="#26354A" id="celda21"><div align="center"><span class="Estilo1 Estilo13 Estilo30">1</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda22" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">2</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda23" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">3</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda24" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">4</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda25" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">5</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda26" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">6</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda27" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">7</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda28" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">8</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda29" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">9</span></div></th>
            <th width="19" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda210" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">10</span></div></th>
            <th width="17" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda211" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">11</span></div></th>
            <th width="18" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda212" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">12</span></div></th>
            <th width="23" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda213" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">13</span></div></th>
            <th width="19" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda214" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">14</span></div></th>
            <th width="30" bgcolor="#FFFFFF" scope="col"><input name="v2" type="text" id="v2" size="3" /></th>
            <th width="103" bgcolor="#99CCFF" scope="col"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="100" height="22">
              <param name="movie" value="button2.swf" />
              <param name="quality" value="high" />
              <embed src="button2.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100" height="22"></embed>
            </object></th>
          </tr>
          <tr>
            <th width="144" bgcolor="#99CCFF" scope="col"><span class="Estilo35">Ejemplar:
            <input type="text" name="textfield3" />
            </span></th>
            <th width="17" height="44" bgcolor="#99CCFF" scope="col"><span class="Estilo24">3.-</span></th>
            <th width="6" bgcolor="#FFFFFF" scope="col"><span class="Estilo25"></span></th>
            <th width="12" align="center" valign="middle" bgcolor="#26354A" id="celda31"><div align="center"><span class="Estilo1 Estilo13 Estilo30">1</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda32" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">2</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda33" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">3</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda34" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">4</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda35" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">5</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda36" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">6</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda37" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">7</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda38" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">8</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda39" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">9</span></div></th>
            <th width="19" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda310" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">10</span></div></th>
            <th width="17" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda311" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">11</span></div></th>
            <th width="18" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda312" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">12</span></div></th>
            <th width="23" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda313" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">13</span></div></th>
            <th width="19" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda314" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">14</span></div></th>
            <th width="30" bgcolor="#FFFFFF" scope="col"><input name="v3" type="text" id="v3" size="3" /></th>
            <th width="103" bgcolor="#99CCFF" scope="col"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="100" height="22">
              <param name="movie" value="button3.swf" />
              <param name="quality" value="high" />
              <embed src="button3.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100" height="22"></embed>
            </object></th>
          </tr>
          <tr>
            <th width="144" bgcolor="#99CCFF" scope="col">&nbsp;</th>
            <th width="17" bgcolor="#99CCFF" scope="col"><span class="Estilo24">4.-</span></th>
            <th width="6" bgcolor="#FFFFFF" scope="col"><span class="Estilo25"></span></th>
            <th width="12" height="5" align="center" valign="middle" bgcolor="#26354A" id="celda41"><div align="center"><span class="Estilo1 Estilo13 Estilo30">1</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda42" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">2</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda43" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">3</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda44" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">4</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda45" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">5</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda46" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">6</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda47" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">7</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda48" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">8</span></div></th>
            <th width="13" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda49" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">9</span></div></th>
            <th width="19" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda410" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">10</span></div></th>
            <th width="17" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda411" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">11</span></div></th>
            <th width="18" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda412" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">12</span></div></th>
            <th width="23" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda413" scope="col"><div align="center"><span class="Estilo1 Estilo13 Estilo30">13</span></div></th>
            <th width="19" align="center" valign="middle" bordercolor="#000000" bgcolor="#26354A" id="celda414" scope="col"><div align="center"><span class="Estilo31">14</span></div></th>
            <th width="30" bgcolor="#FFFFFF" scope="col"><input name="v4" type="text" id="v4" size="3" /></th>
            <th width="103" bgcolor="#99CCFF" scope="col">&nbsp;</th>
          </tr>
          
          <tr>
            <th bgcolor="#99CCFF" scope="row"><label></label></th>
            <th colspan="17" bgcolor="#99CCFF" scope="row"><label> </label>
                <div align="right"><span class="Estilo4">Total Bs.F.</span>
                  <input type="text" name="Total" id="Total" />
            </div></th>
            <td bgcolor="#99CCFF">&nbsp;</td>
          </tr>
  </table> 
  </div>
</form> 