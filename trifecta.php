

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
	font-family: "Times New Roman", Times, serif;
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
.Estilo16 {font-family: Arial, Helvetica, sans-serif; font-size: 18; }
.Estilo17 {font-size: 18}
.Estilo19 {font-family: Arial, Helvetica, sans-serif; font-size: 16px; }
.Estilo20 {font-size: 16px}
-->
      </style>
      <script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<form id="form1" name="form1" method="post" action="">
<div align="left">
        <table width="590" border="1" bordercolor="#808080">
          <tr bgcolor="#669999">
            <th colspan="19" scope="col"><div align="left"><span class="Estilo2">TRIFECTA </span></div></th>
          </tr>
          <tr bgcolor="#669999">
            <th colspan="17" scope="col"><div align="left"><span class="Estilo10">N.Ticket: 0000000000 </span></div></th>
            <th scope="col"><div align="center"><span class="Estilo12">X</span></div></th>
            <th bordercolor="#333333" scope="col"><div align="center"><span class="Estilo10">FUNCIONES</span></div></th>
          </tr>
          <tr>
            <th width="144" bgcolor="#669999" scope="col"><span class="Estilo19">Carrera:</span>
            <input name="carrera" type="text" id="carrera" /></th>
            <th width="17" scope="col" bgcolor="#669999"><span class="Estilo16">1.-</span></th>
            <th width="6" bgcolor="#FFFFFF" scope="col"><span class="Estilo17"></span></th>
            <th width="20" align="center"  bgcolor="#26354A" id="celda11"><span class="Estilo20 Estilo1"><strong>1</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda12" scope="col"><span class="Estilo20 Estilo1"><strong>2</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda13" scope="col"><span class="Estilo20 Estilo1"><strong>3</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda14" scope="col"><span class="Estilo20 Estilo1"><strong>4</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda15" scope="col"><span class="Estilo20 Estilo1"><strong>5</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda16" scope="col"><span class="Estilo20 Estilo1"><strong>6</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda17" scope="col"><span class="Estilo20 Estilo1"><strong>7</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda18" scope="col"><span class="Estilo20 Estilo1"><strong>8</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda19" scope="col"><span class="Estilo20 Estilo1"><strong>9</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda110" scope="col"><span class="Estilo20 Estilo1"><strong>10</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda111" scope="col"><span class="Estilo20 Estilo1"><strong>11</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda112" scope="col"><span class="Estilo20 Estilo1"><strong>12</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda113" scope="col"><span class="Estilo20 Estilo1"><strong>13</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda114" scope="col"><span class="Estilo20 Estilo1"><strong>14</strong></span></th>
            <th width="30" bgcolor="#FFFFFF" scope="col"> <input name="v1" type="text" id="v1" size="3" /></th>
            <th width="103" bgcolor="#669999" scope="col"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="100" height="22">
              <param name="movie" value="button1.swf" />
              <param name="quality" value="high" />
              <embed src="button1.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100" height="22"></embed>
            </object></th>
          </tr>
          <tr>
            <th width="144" bgcolor="#669999" scope="col"><label><span class="Estilo19">Puesto:
                </span>
              <input name="val" type="text" id="val" />
            </label></th>
            <th width="17" height="49" bgcolor="#669999" scope="col"><span class="Estilo16">2.-</span></th>
            <th width="6" bgcolor="#FFFFFF" scope="col"><span class="Estilo17"></span></th>
            <th width="20" align="center" bgcolor="#26354A" id="celda21"><span class="Estilo20 Estilo1"><strong>1</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda22" scope="col"><span class="Estilo20 Estilo1"><strong>2</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda23" scope="col"><span class="Estilo20 Estilo1"><strong>3</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda24" scope="col"><span class="Estilo20 Estilo1"><strong>4</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda25" scope="col"><span class="Estilo20 Estilo1"><strong>5</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda26" scope="col"><span class="Estilo20 Estilo1"><strong>6</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda27" scope="col"><span class="Estilo20 Estilo1"><strong>7</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda28" scope="col"><span class="Estilo20 Estilo1"><strong>8</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda29" scope="col"><span class="Estilo20 Estilo1"><strong>9</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda210" scope="col"><span class="Estilo20 Estilo1"><strong>10</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda211" scope="col"><span class="Estilo20 Estilo1"><strong>11</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda212" scope="col"><span class="Estilo20 Estilo1"><strong>12</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda213" scope="col"><span class="Estilo20 Estilo1"><strong>13</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda214" scope="col"><span class="Estilo20 Estilo1"><strong>14</strong></span></th>
            <th width="30" bgcolor="#FFFFFF" scope="col"><input name="v2" type="text" id="v2" size="3" /></th>
            <th width="103" bgcolor="#669999" scope="col"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="100" height="22">
              <param name="movie" value="button2.swf" />
              <param name="quality" value="high" />
              <embed src="button2.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100" height="22"></embed>
            </object></th>
          </tr>
          <tr>
            <th width="144" bgcolor="#669999" scope="col"><label><span class="Estilo19">Ejemplar:</span>
                <input name="ejem" type="text" id="ejem" />
            </label></th>
            <th width="17" bgcolor="#669999" scope="col"><span class="Estilo16">3.-</span></th>
            <th width="6" bgcolor="#FFFFFF" scope="col"><span class="Estilo17"></span></th>
            <th width="20" align="center" bgcolor="#26354A" id="celda31"><span class="Estilo20 Estilo1"><strong>1</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda32" scope="col"><span class="Estilo20 Estilo1"><strong>2</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda33" scope="col"><span class="Estilo20 Estilo1"><strong>3</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda34" scope="col"><span class="Estilo20 Estilo1"><strong>4</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda35" scope="col"><span class="Estilo20 Estilo1"><strong>5</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda36" scope="col"><span class="Estilo20 Estilo1"><strong>6</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda37" scope="col"><span class="Estilo20 Estilo1"><strong>7</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda38" scope="col"><span class="Estilo20 Estilo1"><strong>8</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda39" scope="col"><span class="Estilo20 Estilo1"><strong>9</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda310" scope="col"><span class="Estilo20 Estilo1"><strong>10</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda311" scope="col"><span class="Estilo20 Estilo1"><strong>11</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda312" scope="col"><span class="Estilo20 Estilo1"><strong>12</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda313" scope="col"><span class="Estilo20 Estilo1"><strong>13</strong></span></th>
            <th width="20" align="center" bordercolor="#000000" bgcolor="#26354A" id="celda314" scope="col"><span class="Estilo20 Estilo1"><strong>14</strong></span></th>
            <th width="30" bgcolor="#FFFFFF" scope="col"><input name="v3" type="text" id="v3" size="3" /></th>
            <th width="103" bgcolor="#669999" scope="col"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="100" height="22">
              <param name="movie" value="button3.swf" />
              <param name="quality" value="high" />
              <embed src="button3.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100" height="22"></embed>
            </object></th>
          </tr>
          
          
          <tr>
            <th bgcolor="#669999" scope="row"><label></label></th>
            <th colspan="17" bgcolor="#669999" scope="row"><label> </label>
                <div align="right"><span class="Estilo4">Total Bs.F. </span>
                  <input type="text" name="Total" id="Total" />
            </div></th>
            <td bgcolor="#669999">&nbsp;</td>
          </tr>
  </table> 
 </div> 
</form> 